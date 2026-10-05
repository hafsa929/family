<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;


/*
|--------------------------------------------------------------------------
| تسجيل الدخول
|--------------------------------------------------------------------------
*/

// صفحة تسجيل الدخول
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');

// تنفيذ تسجيل الدخول
Route::post('/login', [LoginController::class, 'login'])
    ->name('login.authenticate');


/*
|--------------------------------------------------------------------------
| الصفحات المحمية
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | تسجيل الخروج
    |--------------------------------------------------------------------------
    */

   Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');


    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');


    /*
    |--------------------------------------------------------------------------
    | Users
    |--------------------------------------------------------------------------
    */

    Route::get('/tables', [UserController::class, 'index'])
        ->name('tables');

    Route::post('/users', [UserController::class, 'store'])
        ->name('users.store');

    Route::put('/users/{id}', [UserController::class, 'update']);

    // كشف حساب المستخدم
    Route::get('/users/{id}/statement', [UserController::class, 'statement'])
        ->name('users.statement');

    // كشف الحساب PDF
    Route::get('/users/{id}/statement/pdf', [UserController::class, 'statementPdf'])
        ->name('users.statementPdf');


    /*
    |--------------------------------------------------------------------------
    | Contributions
    |--------------------------------------------------------------------------
    */

    Route::get('/virtual-reality', [ContributionController::class, 'index']);

    Route::get('/contributions', [ContributionController::class, 'index']);

    Route::get('/contributions/existing-months', [ContributionController::class, 'existingMonths']);

    Route::get('/missing-months', [ContributionController::class, 'missingMonths']);

    // إنشاء شهر جديد
    Route::post('/contributions/generate-month', [ContributionController::class, 'generateMonth']);

    // دفع مساهمة
    Route::post('/contributions/pay/{id}', [ContributionController::class, 'pay'])
        ->name('contributions.pay');

    // تعديل الدفع
    Route::put('/contributions/update-payment/{id}', [ContributionController::class, 'updatePayment'])
        ->name('contributions.updatePayment');


    /*
    |--------------------------------------------------------------------------
    | طباعة المساهمات
    |--------------------------------------------------------------------------
    */

    Route::get('/contributions/print/month/{month}', 
        [ContributionController::class, 'printMonth']
    );

    Route::get('/contributions/print/year/{year}', 
        [ContributionController::class, 'printYear']
    );


    /*
    |--------------------------------------------------------------------------
    | PDF المساهمات
    |--------------------------------------------------------------------------
    */

    Route::get('/contributions/pdf/month/{month}', 
        [ContributionController::class, 'pdfMonth']
    );

    Route::get('/contributions/pdf/year/{year}', 
        [ContributionController::class, 'pdfYear']
    )->name('contributions.pdf.year');


    /*
    |--------------------------------------------------------------------------
    | Finance / Billing
    |--------------------------------------------------------------------------
    */

    Route::get('/billing', [FinanceController::class, 'index'])
        ->name('billing');

    // إضافة مصروف
    Route::post('/expenses/store', [FinanceController::class, 'store'])
        ->name('expenses.store');

});