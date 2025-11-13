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
        Route::get('/check-account', [ForgotPasswordController::class, 'checkUserNamePage'])->name('check_username');
        Route::post('/verify-account', [ForgotPasswordController::class, 'verifyAccount'])->name('verifyAccount');
        Route::get('/security-question-form', [ForgotPasswordController::class, 'forgotPasswordPage'])->name('page');
        Route::post('/verify-answer', [ForgotPasswordController::class, 'verifyAnswer'])->name('verifyAnswer');
        Route::get('/reset-password', [ForgotPasswordController::class, 'resetPasswordPage'])->name('reset_password_page');
        Route::post('/reset-password', [ForgotPasswordController::class, 'resetPasswordAction'])->name('reset_password_action');
    });
    
    Route::post('logout', LogoutController::class)->name('logout');
});