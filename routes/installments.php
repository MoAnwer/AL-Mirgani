<?php

use App\Http\Controllers\Installment\InstallmentController;

Route::name('installments.')->controller(InstallmentController::class)->prefix('installments')->group(function() {
    Route::get('{id}/create', 'create')->name('create');
    Route::post('{student}/store', 'store')->name('store');
    Route::get('{installment}/edit', 'edit')->name('edit');
    Route::put('{installment}/update', 'update')->name('update');
    Route::get('{installment}/delete', 'delete')->name('delete');
    Route::delete('{installment}/destroy', 'destroy')->name('destroy');
});
