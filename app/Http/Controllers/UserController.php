<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Contribution;
use App\Models\Transaction;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
     public function index()
{
    
    $users = User::orderBy('id', 'asc')->get();


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
    ]);

    User::create([
        'name' => $request->name,
        'phone' => $request->phone,
        'status' => $request->status,
    ]);

    return redirect()->back()->with('success', 'تم إضافة العضو بنجاح');
}
    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);
    $user->status = $request->status;
    $user->save();

    return redirect()->back();
}

public function statement($id)
{
    $user = User::findOrFail($id);

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

}
