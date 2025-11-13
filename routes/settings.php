<?php

use App\Http\Controllers\SecurityQuestion\SecurityQuestionController;
use App\Http\Controllers\Settings\SettingController;

Route::name('settings.')->prefix('settings')->group(function () {
    Route::get('', [SettingController::class, 'settingsPage'])->name('page');
    Route::get('/create/security-question', [SecurityQuestionController::class, 'create'])->name('create_security_question');
    Route::post('/store/security-question', [SecurityQuestionController::class, 'store'])->name('store_security_question');
    Route::get('/security-question/edit/{securityQuestion}', [SecurityQuestionController::class, 'edit'])->name('edit_security_question');
    Route::put('/security-question/update/{securityQuestion}', [SecurityQuestionController::class, 'update'])->name('update_security_question');
    Route::delete('/security-question/delete/{securityQuestion}', [SecurityQuestionController::class, 'destroy'])->name('delete_security_question');
});