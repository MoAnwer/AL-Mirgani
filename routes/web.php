<?php

use App\Http\Controllers\Auth\{LoginController, LogoutController};
use App\Http\Controllers\{Dashboard\DashboardController, Student\StudentController};
use App\Http\Controllers\Earning\EarningController;
use App\Http\Controllers\Expense\ExpenseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Installment\InstallmentController;
use App\Http\Controllers\Payments\InstallmentPaymentsController;
use App\Http\Controllers\Receipts\ReceiptController;
use App\Http\Controllers\Student\StudentHealthyHistoryController;
use App\Http\Controllers\Teacher\TeacherController;
use App\Http\Middleware\EnsureInstallmentIsPaid;

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
    Route::get('students/{student}/installments', [StudentController::class, 'installments'])->name('students.installments');
    Route::resource('students', StudentController::class);

    Route::name('installments.')->controller(InstallmentController::class)->prefix('installments')->group(function() {
        Route::get('{id}/create', 'create')->name('create');
        Route::post('{student}/store', 'store')->name('store');
        Route::get('{installment}/edit', 'edit')->name('edit');
        Route::put('{installment}/update', 'update')->name('update');
        Route::get('{installment}/delete', 'delete')->name('delete');
        Route::delete('{installment}/destroy', 'destroy')->name('destroy');
    });

    Route::name('installments.payments.')->prefix('payments/installments')->controller(InstallmentPaymentsController::class)->group(function() {
        Route::get('/{installment}', 'paymentsList')->name('list');
        Route::get('{installment}/create', 'create')->name('create')->middleware(EnsureInstallmentIsPaid::class);
        Route::post('{installment}/store', 'store')->name('store');
        Route::get('{payment}/edit', 'edit')->name('edit');
        Route::put('{payment}/update', 'update')->name('update');
        Route::get('{payment}/delete', 'delete')->name('delete');
        Route::delete('{payment}/destroy', 'destroy')->name('destroy');
    });

    Route::name('receipts.')->prefix('receipts')->controller(ReceiptController::class)->group(function() {
        Route::get('payments/{payment}', 'receipt');
        Route::get('{payment}/receipt/create');
    });

    Route::name('teachers.')->controller(TeacherController::class)->prefix('teachers')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
    });


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