<?php

use App\Http\Controllers\Auth\{LoginController, LogoutController};
use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


Route::get('/', HomeController::class);

Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'home'])->name('dashboard');

Route::name('auth.')->group(function() {

    Route::name('login.')->middleware('guest')->group(function() {
        Route::get('login', [LoginController::class, 'login'])->name('form');
        Route::post('loginAction', [LoginController::class, 'loginAction'])->name('action');
    });
    
    Route::post('logout', LogoutController::class);
});