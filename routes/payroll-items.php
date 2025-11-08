<?php

use App\Http\Controllers\PayrollItemController;


Route::name('payroll_items.')->prefix('payroll-items')->controller(PayrollItemController::class)->group(function()  {
    Route::get('create', 'create')->name('create');
    Route::post('', 'store')->name('store');
    Route::get('', 'index')->name('index');
    Route::get('{payroll_item}/edit', 'edit')->name('edit');
    Route::put('{payroll_item}', 'update')->name('update');
});