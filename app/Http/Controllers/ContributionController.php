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

    // بحث
if ($request->search) {

    $search = trim($request->search);

    // 🔁 تحويل الكلمات العربية إلى قيم قاعدة البيانات
    $statusMap = [
        'تم الدفع' => 'paid',
        'جزئي' => 'partial',
        'غير مدفوع' => 'unpaid',
    ];

    // إذا كتب حالة بالعربي نحولها
    if (isset($statusMap[$search])) {
        $search = $statusMap[$search];
    }

    $query->where(function ($q) use ($search) {

        $q->whereHas('user', function ($qq) use ($search) {
            $qq->where('name', 'like', '%' . $search . '%');
        })
        ->orWhere('status', 'like', '%' . $search . '%');

    });
}
// فلترة
if ($request->month) {
    $query->where('month', $request->month);
}

if ($request->from_month && $request->to_month) {
    $query->whereBetween('month', [$request->from_month, $request->to_month]);
}

if ($request->year) {
    $query->where('month', 'like', $request->year . '%');
}

   $contributions = $query
    ->orderBy('month', 'asc')
    ->orderBy(User::select('id')
        ->whereColumn('users.id', 'contributions.user_id'))
    ->get();

    //  لو الطلب AJAX
    if ($request->ajax()) {
        return view('virtual-reality', compact('contributions'))->render();
    }

    $users = User::where('status', 'active')->get();
    return view('virtual-reality', compact('users', 'contributions'));
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

public function pay(Request $request , $id)
{
    $firstContribution = Contribution::findOrFail($id);

    $amount = $request->amount;
    $originalAmount = $amount;
    $paymentMethod = $request->payment_method;
    $userId = $firstContribution->user_id;

    $coveredMonths = [];

    $contributions = Contribution::where('user_id', $userId)
        ->where('status', '!=', 'paid')
        ->orderBy('month')
        ->get();

    foreach ($contributions as $contribution) {

        if ($amount <= 0) break;

        $remaining = $contribution->expected_amount - $contribution->paid_amount;

        if ($remaining <= 0) continue;

        $paidNow = min($amount, $remaining);

        $contribution->paid_amount += $paidNow;
        $amount -= $paidNow;

        $coveredMonths[] = $contribution->month;

        $contribution->status =
            $contribution->paid_amount >= $contribution->expected_amount
            ? 'paid'
            : 'partial';

        $contribution->save();
    }

    
    if (count($coveredMonths) > 0) {

    // استخراج الأشهر بشكل مختصر 01 - 02 - 03
    $monthsFormatted = collect($coveredMonths)
        ->map(function ($m) {
            return \Carbon\Carbon::parse($m)->format('m');
        })
        ->implode(' - ');

    // السنة من أول شهر
    $year = \Carbon\Carbon::parse($coveredMonths[0])->format('Y');

    Transaction::create([
        'user_id' => $userId,
        'type' => 'deposit',
        'amount' => $originalAmount,
        'payment_method' => $paymentMethod,
        'reference_type' => 'bulk_payment',
        'reference_id' => $firstContribution->id,
        'description' =>
            'تم دفع مبلغ تراكمي (' . $originalAmount . ') '
            . 'وتم تقسيمه على الأشهر (' . $monthsFormatted . ') من ' . $year,
    ]);

    }

    return back()->with('success', 'تم توزيع الدفع بنجاح');
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
}
