<?php

use App\Http\Controllers\Installment\InstallmentController;
use App\Http\Middleware\{EnsureTotalFeesIsCompleted, EnsureInstallmentIsPaid};

Route::name('installments.')->controller(InstallmentController::class)->prefix('installments')->group(function () {
    Route::get('{student}/create', 'create')->name('create')->middleware(EnsureTotalFeesIsCompleted::class);
    Route::post('{student}/store', 'store')->name('store');
    Route::get('{installment}/edit', 'edit')->name('edit')->middleware(EnsureInstallmentIsPaid::class);
    Route::put('{installment}/update', 'update')->name('update');
    Route::get('{installment}/delete', 'delete')->name('delete');
    Route::delete('{installment}/destroy', 'destroy')->name('destroy');
});
