<?php

use App\Http\Controllers\Payments\InstallmentPaymentsController;
use App\Http\Middleware\EnsureInstallmentIsPaid;

    Route::name('installments.payments.')->prefix('payments/installments')->controller(InstallmentPaymentsController::class)->group(function() {
        Route::get('/{installment}', 'paymentsList')->name('list');
        Route::get('{installment}/create', 'create')->name('create')->middleware(EnsureInstallmentIsPaid::class);
        Route::post('{installment}/store', 'store')->name('store');
        Route::get('{payment}/edit', 'edit')->name('edit');
        Route::put('{payment}/update', 'update')->name('update');
        Route::get('{payment}/delete', 'delete')->name('delete');
        Route::delete('{payment}/destroy', 'destroy')->name('destroy');
    });