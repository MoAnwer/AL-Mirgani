<?php
use App\Http\Controllers\Payrolls\PayrollDetailController;
use App\Http\Middleware\EmployeeIsExists;

Route::get('payroll-details/{detail}/delete', [PayrollDetailController::class, 'delete'])->name('payroll.details.delete');
Route::delete('payroll-details/{detail}/destroy', [PayrollDetailController::class, 'destroy'])->name('payroll.details.destroy');

Route::middleware(EmployeeIsExists::class)->prefix('payroll/{payroll}/details')->name('payroll.details.')->group(function () {
    Route::get('/create', [PayrollDetailController::class, 'create'])->name('create');
    Route::post('/', [PayrollDetailController::class, 'store'])->name('store');
    Route::get('/{detail}/edit', [PayrollDetailController::class, 'edit'])->name('edit');
    Route::put('/{detail}', [PayrollDetailController::class, 'update'])->name('update');
});
