<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Contribution;
use App\Models\Transaction;
use Illuminate\Support\Facades\Hash;
use Mpdf\Mpdf;

class UserController extends Controller
{
  
public function index()
{
    // جلب الأعضاء فقط واستبعاد حساب المدير
    $users = User::where('is_admin', false)
        ->orderBy('id', 'asc')
        ->get();

    $contributions = Contribution::with('user')
        ->where('month', date('Y-m'))
        ->get();

    return view('tables', compact('users', 'contributions'));
}


public function store(Request $request)
{
    $request->validate([
    'name' => 'required|string|max:255',
    'phone' => 'required|digits:10',
    'status' => 'required',
    'account_number' => 'nullable|string|max:50',
    'bank_name' => 'nullable|string|max:255',
    'iban' => 'nullable|string|max:50',
]);

    // إضافة العضو
    $user = User::create([
    'name' => $request->name,
    'phone' => $request->phone,
    'status' => $request->status,
    'account_number' => $request->account_number,
    'bank_name' => $request->bank_name,
    'iban' => $request->iban,
    'is_admin' => false,
]);

    // جلب جميع الأشهر الموجودة مع قيمة الاشتراك
    $months = Contribution::select('month', 'expected_amount')
        ->distinct()
        ->get();

    // إنشاء اشتراك للعضو الجديد في جميع الأشهر الموجودة
    foreach ($months as $month) {

        Contribution::create([
            'user_id' => $user->id,
            'month' => $month->month,
            'expected_amount' => $month->expected_amount,
            'paid_amount' => 0,
            'status' => 'unpaid',
        ]);

    }

    return redirect()->back()->with('success', 'تم إضافة العضو بنجاح');
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|digits:10',
        'status' => 'required',
        'account_number' => 'nullable|string|max:50',
        'bank_name' => 'nullable|string|max:255',
        'iban' => 'nullable|string|max:50',
    ]);

    $user = User::where('is_admin', false)->findOrFail($id);

    $user->update([
        'name' => $request->name,
        'phone' => $request->phone,
        'status' => $request->status,
        'account_number' => $request->account_number,
        'bank_name' => $request->bank_name,
        'iban' => $request->iban,
    ]);

    return redirect()->back()->with('success', 'تم تعديل بيانات العضو بنجاح');
}
public function statement($id)
{
    $user = User::where('is_admin', false)->findOrFail($id);

    $contributions = Contribution::where('user_id', $id)
        ->orderBy('month')
        ->get();
    $transactions = Transaction::where('user_id', $id)
    ->latest()
    ->get();

    return view('users.statement', compact(
        'user',
        'contributions',
        'transactions'
    ));
}

public function statementPdf($id)
{
    
    $user = User::where('is_admin', false)->findOrFail($id);

    $contributions = Contribution::where('user_id', $id)
        ->orderBy('month')
        ->get();

    $transactions = Transaction::where('user_id', $id)
        ->latest()
        ->get();

    $html = view('users.statement', compact(
        'user',
        'contributions',
        'transactions'
    ))->render();

    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'directionality' => 'rtl',
        'default_font' => 'dejavusans'
    ]);

    $mpdf->WriteHTML($html);

    return response(
        $mpdf->Output(
            'كشف-' . $user->name . '.pdf',
            'S'
        )
    )->header('Content-Type', 'application/pdf');
}
}
