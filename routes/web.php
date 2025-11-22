<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Users\UserController;

Route::get('/', HomeController::class);

require __DIR__ . '/locale.php';
require __DIR__.'/auth.php';

Route::middleware('auth')->group(function() {
    require __DIR__.'/dashboard.php';
    Route::resource('users', UserController::class);
    Route::get('users/{user}/delete', [UserController::class, 'delete'])->name('users.delete');
    require __DIR__  . '/schools.php';
    require __DIR__  . '/students.php';
    require __DIR__  . '/installments.php';
    require __DIR__  . '/payments.php';
    require __DIR__  . '/receipts.php';
    require __DIR__  . '/employees.php';
    require __DIR__  . '/expenses.php';
    require __DIR__  . '/earning.php';
    require __DIR__  . '/reports.php';
    require __DIR__  . '/payroll_details.php';
    require __DIR__  . '/payrolls.php';
    require __DIR__  . '/payroll-items.php';
    require __DIR__  . '/settings.php';
    require __DIR__ . '/notifications.php';
});