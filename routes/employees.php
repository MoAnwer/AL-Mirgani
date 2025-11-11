<?php

use App\Http\Controllers\Employees\EmployeeController;

Route::name('employees.')->controller(EmployeeController::class)->prefix('employees')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('create', 'create')->name('create');
    Route::get('{employee}/edit', 'edit')->name('edit');
    Route::put('{employee}/update', 'update')->name('update');
    Route::get('{employee}/show', 'show')->name('show');
    Route::post('store', 'store')->name('store');
    Route::get('{employee}/delete', 'delete')->name('delete');
    Route::delete('{employee}/destroy', 'destroy')->name('destroy');
});
