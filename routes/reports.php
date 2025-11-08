<?php

use App\Http\Controllers\Accounts\AccountController;
use App\Http\Controllers\Reports\ArrearsReportController;
use App\Http\Controllers\Reports\EarningStatementReportController;
use App\Http\Controllers\Reports\EmployeeCountReportController;
use App\Http\Controllers\Reports\GeneralExpenseReportController;
use App\Http\Controllers\Reports\RevenueAnalysisController;

Route::view('/reports', 'reports.reports')->name('reports');
Route::get('accounts', [AccountController::class, 'showDailyAccount'])->name('accounts');
Route::get('student-arrears-report', [ArrearsReportController::class, 'generateArrearsReport'])->name('arrears.all');
Route::get('revenues', [RevenueAnalysisController::class, 'revenueBySchool'])->name('revenues');
Route::get('general-expenses-report', [GeneralExpenseReportController::class, 'generateGeneralExpenseSummary'])->name('reports.general-expense-report');
Route::get('employee-count-report', [EmployeeCountReportController::class, 'generateEmployeeCountReport'])->name('reports.employee-count-report');
Route::get('incomeReport', [EarningStatementReportController::class, 'generateIncomeStatement'])->name('incomeReport');
