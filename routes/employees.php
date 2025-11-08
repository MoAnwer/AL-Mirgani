<?php

use App\Http\Controllers\Employees\EmployeeController;

Route::name('employees.')->controller(EmployeeController::class)->prefix('employees')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('create', 'create')->name('create');
    Route::get('{employee}/show', 'show')->name('show');
    Route::post('store', 'store')->name('store');
});
