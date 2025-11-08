<?php

use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\StudentHealthyHistoryController;

Route::get('students/count-report', [StudentController::class, 'studentsCount'])->name('students.count-report');
Route::get('students/delete/{student}', [StudentController::class, 'delete'])->name('students.delete');
Route::get('students/{student}/installments', [StudentController::class, 'installments'])->name('students.installments');
Route::get('accounts/{student}', [StudentAccountController::class, 'showAccountStatement'])->name('students.accounts');
Route::resource('students', StudentController::class);

Route::name('student-healthy-history.')->prefix('student-healthy-history')->group(function() {
    Route::get('show/{student}', [StudentHealthyHistoryController::class, 'show'])->name('show');
    Route::put('update/{student}', [StudentHealthyHistoryController::class, 'update'])->name('update');
});
