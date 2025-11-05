<?php

use App\Http\Controllers\Auth\{LoginController, LogoutController};
use App\Http\Controllers\{Reports\ArrearsReportController, Dashboard\DashboardController, PayrollDetailController, PayrollItemController, PayrollProcessorController, Student\StudentController};
use App\Http\Controllers\Accounts\AccountController;
use App\Http\Controllers\Earning\EarningController;
use App\Http\Controllers\Employees\EmployeeController;
use App\Http\Controllers\Employees\EmployeePayrollController;
use App\Http\Controllers\Expense\ExpenseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Installment\InstallmentController;
use App\Http\Controllers\Payments\InstallmentPaymentsController;
use App\Http\Controllers\Receipts\ReceiptController;
use App\Http\Controllers\Reports\EarningStatementReportController;
use App\Http\Controllers\Reports\GeneralExpenseReportController;
use App\Http\Controllers\Reports\PayrollSummaryReportController ;
use App\Http\Controllers\Reports\StudentAccountController;
use App\Http\Controllers\Student\StudentHealthyHistoryController;
use App\Http\Middleware\EnsureInstallmentIsPaid;
use App\Http\Controllers\Reports\RevenueAnalysisController;
use App\Http\Controllers\Users\UserController;

Route::get('/', HomeController::class);

Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'home'])->name('dashboard');

Route::name('auth.')->group(function() {

    Route::name('login.')->middleware('guest')->group(function() {
        Route::get('login', [LoginController::class, 'login'])->name('form');
        Route::post('loginAction', [LoginController::class, 'loginAction'])->name('action');
    });
    
    Route::post('logout', LogoutController::class)->name('logout');
});

Route::middleware('auth')->group(function() {


    Route::resource('users', UserController::class);

    Route::get('students/count-report', [StudentController::class, 'studentsCount'])->name('students.count-report');
    Route::get('students/delete/{student}', [StudentController::class, 'delete'])->name('students.delete');
    Route::get('students/{student}/installments', [StudentController::class, 'installments'])->name('students.installments');
    Route::get('accounts/{student}', [StudentAccountController::class, 'showAccountStatement'])->name('students.accounts');
    Route::resource('students', StudentController::class);

    Route::name('installments.')->controller(InstallmentController::class)->prefix('installments')->group(function() {
        Route::get('{id}/create', 'create')->name('create');
        Route::post('{student}/store', 'store')->name('store');
        Route::get('{installment}/edit', 'edit')->name('edit');
        Route::put('{installment}/update', 'update')->name('update');
        Route::get('{installment}/delete', 'delete')->name('delete');
        Route::delete('{installment}/destroy', 'destroy')->name('destroy');
    });

    Route::name('installments.payments.')->prefix('payments/installments')->controller(InstallmentPaymentsController::class)->group(function() {
        Route::get('/{installment}', 'paymentsList')->name('list');
        Route::get('{installment}/create', 'create')->name('create')->middleware(EnsureInstallmentIsPaid::class);
        Route::post('{installment}/store', 'store')->name('store');
        Route::get('{payment}/edit', 'edit')->name('edit');
        Route::put('{payment}/update', 'update')->name('update');
        Route::get('{payment}/delete', 'delete')->name('delete');
        Route::delete('{payment}/destroy', 'destroy')->name('destroy');
    });

    Route::name('receipts.')->prefix('receipts')->controller(ReceiptController::class)->group(function() {
        Route::get('show/{receipt}', [ReceiptController::class, 'show'])->name('show');
        Route::post('{payment}', [ReceiptController::class, 'store'])->name('store');
    });

    Route::name('employees.')->controller(EmployeeController::class)->prefix('employees')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::get('{employee}/show', 'show')->name('show');
        Route::post('store', 'store')->name('store');
    });

    Route::name('expenses.')->prefix('expenses')->group(function() {
        Route::get('', [ExpenseController::class, 'index'])->name('index');
        Route::get('/new', [ExpenseController::class, 'create'])->name('new');
        Route::post('store', [ExpenseController::class, 'store'])->name('store');
        Route::get('show/{expense}', [ExpenseController::class, 'show'])->name('show');
        Route::get('edit/{expense}', [ExpenseController::class, 'edit'])->name('edit');
        Route::put('update/{expense}', [ExpenseController::class, 'update'])->name('update');
        Route::get('delete/{expense}', [ExpenseController::class, 'delete'])->name('delete');
        Route::delete('destroy/{expense}', [ExpenseController::class, 'destroy'])->name('destroy');
    });

    Route::name('student-healthy-history.')->prefix('student-healthy-history')->group(function() {
        Route::get('show/{student}', [StudentHealthyHistoryController::class, 'show'])->name('show');
        Route::put('update/{student}', [StudentHealthyHistoryController::class, 'update'])->name('update');
    });

    Route::name('earnings.')->prefix('earnings')->controller(EarningController::class)->group(function() {
        Route::get('', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
    });

    Route::get('accounts', [AccountController::class, 'showDailyAccount'])->name('accounts');
    Route::get('/reports/arrears', [ArrearsReportController::class, 'generateArrearsReport'])->name('arrears.all');
    Route::get('revenues', [RevenueAnalysisController::class, 'revenueBySchool'])->name('revenues');

    Route::view('/reports', 'reports.reports')->name('reports');
    Route::get('general-expenses-report', [GeneralExpenseReportController::class, 'generateGeneralExpenseSummary'])->name('reports.general-expense-report');
    Route::get('incomeReport', [EarningStatementReportController::class, 'generateIncomeStatement'])->name('incomeReport');

    Route::prefix('payroll/{payroll}/details')->name('payroll.details.')->group(function () {
        Route::get('/create', [PayrollDetailController::class, 'create'])->name('create');
        Route::post('/', [PayrollDetailController::class, 'store'])->name('store');
        
        Route::get('/{detail}/edit', [PayrollDetailController::class, 'edit'])->name('edit');
        Route::put('/{detail}', [PayrollDetailController::class, 'update'])->name('update');
    });

    Route::get('/payrolls', [EmployeePayrollController::class, 'index'])->name('payroll.index');
    Route::get('/payrolls/create', [EmployeePayrollController::class, 'create'])->name('payroll.create');
    Route::post('/payrolls/store', [PayrollProcessorController::class, 'processAndStore'])->name('payroll.store');
    Route::get('/payrolls/{payroll}', [EmployeePayrollController::class, 'show'])->name('payroll.show');
    Route::get('/payrolls/{payroll}/edit', [EmployeePayrollController::class, 'edit'])->name('payroll.edit');
    Route::put('/payrolls/{payroll}/update', [EmployeePayrollController::class, 'update'])->name('payroll.update');
    Route::get('/payrolls/{payroll}/print', [EmployeePayrollController::class, 'payrollInvoice'])->name('payroll.invoice.print');
    Route::get('/payroll-summary-report', [PayrollSummaryReportController::class, 'generateSummaryReport'])->name('payroll.summary.report');



    Route::get('/payroll-items/create', [PayrollItemController::class, 'create'])->name('payroll_items.create');
    Route::post('/payroll-items', [PayrollItemController::class, 'store'])->name('payroll_items.store');
    Route::get('/payroll-items', [PayrollItemController::class, 'index'])->name('payroll_items.index');
    Route::get('/payroll-items/{payroll_item}/edit', [PayrollItemController::class, 'edit'])->name('payroll_items.edit');
    Route::put('/payroll-items/{payroll_item}', [PayrollItemController::class, 'update'])->name('payroll_items.update');
});