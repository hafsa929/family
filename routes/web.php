<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');



Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/virtual-reality', [ContributionController::class, 'index']);
Route::get('/contributions/existing-months',[ContributionController::class, 'existingMonths']);
Route::get('/tables', [UserController::class, 'index'])->name('tables');
Route::put('/users/{id}', [UserController::class, 'update']);
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{id}/statement', [UserController::class, 'statement'])
    ->name('users.statement'); //طباعه كشف

Route::get('/contributions', [ContributionController::class, 'index']);
Route::post('/contributions/generate-month', [ContributionController::class, 'generateMonth']);
Route::post('/contributions/pay/{id}', [ContributionController::class, 'pay']);
Route::get('/missing-months', [ContributionController::class, 'missingMonths']);

Route::get('/billing', [FinanceController::class, 'index'])->name('billing');

Route::post('/expenses/store', [FinanceController::class, 'store'])->name('expenses.store');