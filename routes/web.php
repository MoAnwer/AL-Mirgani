<?php

use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Users\UserController;

require __DIR__ . '/locale.php';

Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

Route::get('/', HomeController::class);

Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'home'])->name('dashboard');

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function() {
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
});