<?php

use  App\Http\Controllers\School\SchoolController;

Route::name('schools.')->prefix('schools')->controller(SchoolController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('edit/{school}', 'edit')->name('edit');
    Route::put('update/{school}',  'update')->name('update');
});