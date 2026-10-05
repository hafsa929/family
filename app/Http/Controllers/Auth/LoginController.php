<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function login(Request $request)
    {
        // التحقق من البيانات
        $credentials = $request->validate([
            'phone' => ['required'],
            'password' => ['required'],
        ]);


        // محاولة تسجيل الدخول
        if (Auth::attempt([
            'phone' => $credentials['phone'],
            'password' => $credentials['password'],
        ], $request->boolean('remember'))) {

            // حماية الجلسة
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }


        // إذا كانت البيانات خاطئة
        return back()
            ->withInput($request->only('phone'))
            ->with('error', 'رقم الهاتف أو كلمة المرور غير صحيحة.');
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}