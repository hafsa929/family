<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Transaction;
use App\Models\User;


class FinanceController extends Controller
{
    public function index()
    {
        // إجمالي الإيرادات
        $totalRevenues = Transaction::where('type', 'deposit')->sum('amount');
        // إجمالي المصروفات
        $totalExpenses = Transaction::where('type', 'withdraw')->sum('amount');
        // الرصيد الحالي
        $balance = $totalRevenues - $totalExpenses;

        // آخر المصروفات
        $expenses = Expense::latest()->take(5)->get();

        // آخر الإيرادات
        $revenues = Transaction::with('user')
            ->where('type', 'deposit')
            ->latest()
            ->take(5)
            ->get();

        // آخر العمليات
        $transactions = Transaction::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        $users = User::all();

        return view('billing', [
    'totalRevenues' => $totalRevenues,
    'totalExpenses' => $totalExpenses,
    'balance' => $balance,
    'transactions' => $transactions,
    'expenses' => $expenses,
    'revenues' => $revenues,
    'users' =>$users,

]);
    }


public function store(Request $request)
{
    $expense = Expense::create([
        'amount' => $request->amount,
        'reason' => $request->reason,
        'beneficiary' => $request->beneficiary,
        'created_by' => auth()->id(),
        'date' => now(),
    ]);

    Transaction::create([
        'user_id' => auth()->id(),
        'type' => 'withdraw',
        'amount' => $request->amount,
        'reference_type' => 'expense',
        'reference_id' => $expense->id,
        'description' =>('خصم بقيمة'.$request->amount),
    ]);

    return redirect()->route('billing')
        ->with('success', 'تم إضافة المصروف بنجاح');
}
}