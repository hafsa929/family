<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Contribution;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
    

        return view('dashboard', [
            
            // 👥 عدد الأعضاء
            'membersCount' => User::count(),

            //  رصيد الصندوق (تبرعات - مصاريف)
            'fundBalance' => 
                (Transaction::where('type', 'deposit')->sum('amount') - Expense::sum('amount')),

            //  معاملات اليوم
            'transactionsToday' => Transaction::whereDate('created_at', today())->count(),

            //  إجمالي المعاملات
            'totalTransactions' => Transaction::count(),
        


        ]);
    }
}