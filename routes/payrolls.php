<?php

use App\Http\Controllers\Payrolls\PayrollController;
use App\Http\Controllers\Reports\PayrollSummaryReportController;

Route::name('payroll.')
    ->prefix('payrolls')
    ->controller(PayrollController::class)
    ->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{payroll}', 'show')->name('show');
        Route::get('/{payroll}/edit', 'edit')->name('edit');
        Route::get('/{payroll}/delete', 'delete')->name('delete');
        Route::delete('/{payroll}/destroy', 'destroy')->name('destroy');
        Route::put('/{payroll}/update', 'update')->name('update');
        Route::get('/{payroll}/print', 'payrollInvoice')->name('invoice.print');
    });


Route::get('/payroll-summary-report', [PayrollSummaryReportController::class, 'generateSummaryReport'])->name('payroll.summary.report');
