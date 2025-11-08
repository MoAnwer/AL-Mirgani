<?php

use App\Http\Controllers\Earning\EarningController;

Route::name('earnings.')->prefix('earnings')->controller(EarningController::class)->group(function() {
    Route::get('', 'index')->name('index');
    Route::get('create', 'create')->name('create');
    Route::post('store', 'store')->name('store');
});