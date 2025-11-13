<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

Route::name('auth.')->group(function() {

    Route::name('login.')->middleware('guest')->group(function() {
        Route::get('login', [LoginController::class, 'login'])->name('form');
        Route::post('loginAction', [LoginController::class, 'loginAction'])->name('action');
    });

    Route::name('forgot_password.')->prefix('forgot-password')->middleware('guest')->group(function() {
        Route::get('', [ForgotPasswordController::class, 'forgotPasswordPage'])->name('page');
    });
    
    Route::post('logout', LogoutController::class)->name('logout');
});