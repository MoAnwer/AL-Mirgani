<?php

use App\Http\Controllers\Auth\{LoginController, LogoutController};
use App\Http\Controllers\{Dashboard\DashboardController, Student\StudentController};
use App\Http\Controllers\Earning\EarningController;
use App\Http\Controllers\Expense\ExpenseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Student\StudentHealthyHistoryController;

Route::get('/', HomeController::class);

Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'home'])->name('dashboard');

Route::name('auth.')->group(function() {

    Route::name('login.')->middleware('guest')->group(function() {
        Route::get('login', [LoginController::class, 'login'])->name('form');
        Route::post('loginAction', [LoginController::class, 'loginAction'])->name('action');
    });
    
    Route::post('logout', LogoutController::class)->name('logout');
});

Route::middleware('auth')->group(function() {
    Route::get('students/delete/{student}', [StudentController::class, 'delete'])->name('students.delete');
    Route::resource('students', StudentController::class);


    Route::name('expenses.')->prefix('expenses')->group(function() {
        Route::get('', [ExpenseController::class, 'index'])->name('index');
        Route::get('create', [ExpenseController::class, 'create'])->name('create');
        Route::post('store', [ExpenseController::class, 'store'])->name('store');
        Route::get('show/{expense}', [ExpenseController::class, 'show'])->name('show');
        Route::get('edit/{expense}', [ExpenseController::class, 'edit'])->name('edit');
        Route::put('update/{expense}', [ExpenseController::class, 'update'])->name('update');
        Route::get('delete/{expense}', [ExpenseController::class, 'delete'])->name('delete');
        Route::delete('destroy/{expense}', [ExpenseController::class, 'destroy'])->name('destroy');
    });

    Route::name('student-healthy-history.')->prefix('student-healthy-history')->group(function() {
        Route::get('show/{student}', [StudentHealthyHistoryController::class, 'show'])->name('show');
        Route::put('update/{student}', [StudentHealthyHistoryController::class, 'update'])->name('update');
    });

    Route::name('earnings.')->prefix('earnings')->controller(EarningController::class)->group(function() {
        Route::get('', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
    });
});