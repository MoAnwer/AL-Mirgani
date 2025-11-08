<?php

use App\Http\Controllers\Expense\ExpenseController;

Route::name('expenses.')->controller(ExpenseController::class)->prefix('expenses')->group(function () {
    Route::get('',  'index')->name('index');
    Route::get('/new',  'create')->name('new');
    Route::post('store',  'store')->name('store');
    Route::get('show/{expense}',  'show')->name('show');
    Route::get('edit/{expense}',  'edit')->name('edit');
    Route::put('update/{expense}',  'update')->name('update');
    Route::get('delete/{expense}',  'delete')->name('delete');
    Route::delete('destroy/{expense}',  'destroy')->name('destroy');
});
