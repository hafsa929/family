<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Contribution;
use App\Models\Transaction;
use Mpdf\Mpdf;

class ContributionController extends Controller
{
public function index(Request $request)
{
    $query = Contribution::with('user');

    // =========================
    // البحث
    // =========================
    if ($request->search) {

        $search = trim($request->search);

        $statusMap = [
            'تم الدفع'   => 'paid',
            'جزئي'       => 'partial',
            'غير مدفوع'  => 'unpaid',
        ];

        if (isset($statusMap[$search])) {
            $search = $statusMap[$search];
        }

        $query->where(function ($q) use ($search) {

            $q->whereHas('user', function ($qq) use ($search) {

                $qq->where('name', 'like', '%' . $search . '%');

            })->orWhere('status', 'like', '%' . $search . '%');

        });
    }


    // =========================
    // فلترة الشهر
    // =========================
    if ($request->month) {

        $query->where('month', $request->month);

    }


    // =========================
    // فلترة الفترة
    // =========================
    if ($request->from_month && $request->to_month) {

        $query->whereBetween(
            'month',
            [
                $request->from_month,
                $request->to_month
            ]
        );

    }


    // =========================
    // فلترة السنة
    // =========================
    if ($request->year) {

        $query->where(
            'month',
            'like',
            $request->year . '%'
        );

    }


    // =========================
    // جلب البيانات
    // =========================
    $contributions = $query
        ->orderBy('month', 'asc')
        ->orderBy(
            User::select('id')
                ->whereColumn(
                    'users.id',
                    'contributions.user_id'
                )
        )
        ->get();


    // =========================
    // حساب المجاميع
    // =========================

    $totalExpected = $contributions->sum('expected_amount');

    $totalPaid = $contributions->sum('paid_amount');

    $totalRemaining = $totalExpected - $totalPaid;


    // =========================
    // تحديد عنوان المجموع
    // =========================

    $totalTitle = 'المجموع الكلي';

    if ($request->month) {

        $totalTitle = 'مجموع الشهر';

    } elseif ($request->from_month && $request->to_month) {

        $totalTitle = 'مجموع الفترة';

    } elseif ($request->year) {

        $totalTitle = 'مجموع السنة';

    }


    // =========================
    // طلب AJAX
    // =========================

    if ($request->ajax()) {

        return view(
            'virtual-reality',
            compact(
                'contributions',
                'totalExpected',
                'totalPaid',
                'totalRemaining',
                'totalTitle'
            )
        )->render();
    }


    // =========================
    // الصفحة العادية
    // =========================

    $users = User::where('status', 'active')->get();

    return view(
        'virtual-reality',
        compact(
            'users',
            'contributions',
            'totalExpected',
            'totalPaid',
            'totalRemaining',
            'totalTitle'
        )
    );
}
public function generateMonth(Request $request)
{
    $from = Carbon::parse($request->from_month);
    $to = $request->to_month
        ? Carbon::parse($request->to_month)
        : $from;

    $amount = $request->amount;

    $users = User::all();

    while ($from->lte($to)) {

        $month = $from->format('Y-m');

        foreach ($users as $user) {

            $exists = Contribution::where('user_id', $user->id)
                ->where('month', $month)
                ->first();

            // لو موجود يحدث القيمة فقط
            if ($exists) {

                $exists->expected_amount = $amount;
                $exists->save();

            } else {

                Contribution::create([
                    'user_id' => $user->id,
                    'month' => $month,
                    'expected_amount' => $amount,
                    'paid_amount' => 0,
                    'status' => 'unpaid',
                ]);
            }
        }

        $from->addMonth();
    }

    return back()->with('success', 'تم إنشاء / تحديث الاشتراكات بنجاح');
}

public function existingMonths()
{
    $months = Contribution::select('month', 'expected_amount')
        ->distinct()
        ->get();

    return response()->json($months);
}

public function pay(Request $request, $id)
{
    $firstContribution = Contribution::findOrFail($id);

    $request->validate([
        'amount' => 'required|numeric|min:0.01',
        'payment_method' => 'nullable|string',
    ]);

    $amount = (float) $request->amount;
    $userId = $firstContribution->user_id;
    $paymentMethod = $request->payment_method;

    /*
    |--------------------------------------------------------------------------
    | جلب الأشهر غير المسددة فقط
    |--------------------------------------------------------------------------
    */
    $contributions = Contribution::where('user_id', $userId)
        ->whereIn('status', ['unpaid', 'partial'])
        ->orderBy('month', 'asc')
        ->get();

    /*
    |--------------------------------------------------------------------------
    | حساب إجمالي المبلغ المتبقي
    |--------------------------------------------------------------------------
    */
    $totalRemaining = $contributions->sum(function ($contribution) {
        return max(
            0,
            (float) $contribution->expected_amount -
            (float) $contribution->paid_amount
        );
    });

    /*
    |--------------------------------------------------------------------------
    | التأكد أن المبلغ لا يتجاوز المطلوب
    |--------------------------------------------------------------------------
    */
    if ($amount > $totalRemaining) {
        return back()->with(
            'error',
            'المبلغ المدفوع أكبر من إجمالي المبلغ المتبقي على العضو. المتبقي هو '
            . number_format($totalRemaining, 2)
            . ' د.ل'
        );
    }

    $remainingAmount = $amount;

    $coveredMonths = [];

    /*
    |--------------------------------------------------------------------------
    | توزيع المبلغ من أقدم شهر إلى أحدث شهر
    |--------------------------------------------------------------------------
    */
    foreach ($contributions as $contribution) {

        if ($remainingAmount <= 0) {
            break;
        }

        $expected = (float) $contribution->expected_amount;
        $paid = (float) $contribution->paid_amount;

        $remaining = max(0, $expected - $paid);

        if ($remaining <= 0) {
            continue;
        }

        // المبلغ الذي سيذهب لهذا الشهر
        $paidNow = min($remainingAmount, $remaining);

        $contribution->paid_amount = $paid + $paidNow;

        /*
        |--------------------------------------------------------------------------
        | تحديث حالة الشهر
        |--------------------------------------------------------------------------
        */
        if ($contribution->paid_amount >= $expected) {
            $contribution->paid_amount = $expected;
            $contribution->status = 'paid';
        } else {
            $contribution->status = 'partial';
        }

        $contribution->save();

        /*
        |--------------------------------------------------------------------------
        | خصم المبلغ الذي تم توزيعه
        |--------------------------------------------------------------------------
        */
        $remainingAmount -= $paidNow;

        /*
        |--------------------------------------------------------------------------
        | تسجيل الشهر الذي تمت تغطيته
        |--------------------------------------------------------------------------
        */
        $coveredMonths[] = [
            'month' => $contribution->month,
            'amount' => $paidNow,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | المبلغ الذي تم دفعه فعليًا
    |--------------------------------------------------------------------------
    */
    $actualPaidAmount = $amount - $remainingAmount;

    /*
    |--------------------------------------------------------------------------
    | إنشاء Transaction واحدة فقط للدفعة كاملة
    |--------------------------------------------------------------------------
    */
    if ($actualPaidAmount > 0 && count($coveredMonths) > 0) {

        $monthsFormatted = collect($coveredMonths)
            ->map(function ($item) {
                return Carbon::parse($item['month'])->format('m');
            })
            ->implode(' - ');

        $year = Carbon::parse($coveredMonths[0]['month'])
            ->format('Y');

        Transaction::create([
            'user_id' => $userId,
            'type' => 'deposit',
            'amount' => $actualPaidAmount,
            'payment_method' => $paymentMethod,
            'reference_type' => 'bulk_payment',

            // معرف أول مساهمة فقط كمرجع للدفعة
            'reference_id' => $firstContribution->id,

            'description' =>
                'تم دفع مبلغ تراكمي (' .
                number_format($actualPaidAmount, 2) .
                ') وتم تقسيمه على الأشهر (' .
                $monthsFormatted .
                ') من سنة ' .
                $year,
        ]);
    }

    return back()->with(
        'success',
        'تم توزيع الدفع بنجاح بمبلغ ' .
        number_format($actualPaidAmount, 2) .
        ' د.ل'
    );
}
public function missingMonths()
{
    $start = Carbon::now()->startOfYear();
    $end = Carbon::now()->addYear();

    $existing = Contribution::select('month')
        ->distinct()
        ->pluck('month')
        ->toArray();

    $months = [];

    while ($start->lte($end)) {

        $m = $start->format('Y-m');

        if (!in_array($m, $existing)) {
            $months[] = $m;
        }

        $start->addMonth();
    }

    return response()->json($months);
}

public function printMonth($month)
{
    $contributions = Contribution::with('user')
        ->where('month',$month)
        ->get();

    return view('reports.contribution-month',compact('contributions','month'));
}

public function printYear($year)
{
    $contributions = Contribution::with('user')
        ->where('month','like',$year.'%')
        ->get();

    return view('reports.contribution-year',compact('contributions','year'));
}

public function pdfMonth($month)
{
    $contributions = Contribution::where('month', $month)
        ->with('user')
        ->get();

    $html = view('contributions.print', compact('contributions', 'month'))->render();

    $mpdf = new Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'directionality' => 'rtl',
        'default_font' => 'dejavusans'
    ]);

    $mpdf->WriteHTML($html);

    return response($mpdf->Output("اشتراكات-$month.pdf", 'S'))
        ->header('Content-Type', 'application/pdf');
}

public function pdfYear($year)
{
    $contributions = Contribution::where('month', 'like', $year.'%')
        ->with('user')
        ->get();

    $html = view('contributions.print-year', compact('contributions', 'year'))->render();

    $mpdf = new Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'directionality' => 'rtl',
        'default_font' => 'dejavusans'
    ]);

    $mpdf->WriteHTML($html);

    return response($mpdf->Output("اشتراكات-$year.pdf", 'S'))
        ->header('Content-Type', 'application/pdf');
}
public function updatePayment(Request $request, $id)
{
    $contribution = Contribution::findOrFail($id);

    $request->validate([
        'paid_amount' => 'required|numeric|min:0',
    ]);

    $paidAmount = $request->paid_amount;

    // لا يسمح بأن يكون المدفوع أكبر من المطلوب
    if ($paidAmount > $contribution->expected_amount) {
        return back()->with('error', 'المبلغ المدفوع لا يمكن أن يكون أكبر من المبلغ المطلوب');
    }

    // تحديث المبلغ
    $contribution->paid_amount = $paidAmount;

    // تحديد الحالة تلقائياً
    if ($paidAmount == 0) {

        $contribution->status = 'unpaid';

    } elseif ($paidAmount < $contribution->expected_amount) {

        $contribution->status = 'partial';

    } else {

        $contribution->status = 'paid';
    }

    $contribution->save();

    return back()->with('success', 'تم تعديل الدفع بنجاح');
}

}
