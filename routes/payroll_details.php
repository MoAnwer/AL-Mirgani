<?php
use App\Http\Controllers\PayrollDetailController;
use App\Http\Middleware\EmployeeIsExists;

Route::middleware(EmployeeIsExists::class)->prefix('payroll/{payroll}/details')->name('payroll.details.')->group(function () {
    Route::get('/create', [PayrollDetailController::class, 'create'])->name('create');
    Route::post('/', [PayrollDetailController::class, 'store'])->name('store');
    
    Route::get('/{detail}/edit', [PayrollDetailController::class, 'edit'])->name('edit');
    Route::put('/{detail}', [PayrollDetailController::class, 'update'])->name('update');
});