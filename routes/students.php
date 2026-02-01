<?php

use App\Http\Controllers\Reports\StudentAccountController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\StudentHealthyHistoryController;

Route::get('students/count-report', [StudentController::class, 'studentsCount'])->name('students.count-report');
Route::get('students/delete/{student}', [StudentController::class, 'delete'])->name('students.delete');
Route::get('students/{student}/installments', [StudentController::class, 'installments'])->name('students.installments');
Route::get('students/{student}/registration-fees', [StudentController::class, 'registrationFeesPage'])->name('students.registrationFees');
Route::get('students/{student}/registration-fees/create', [StudentController::class, 'createRegistrationFeesPage'])->name('students.registrationFees.create');
Route::post('students/{student}/registration-fees/store', [StudentController::class, 'storeRegistrationFees'])->name('students.registrationFees.store');
Route::get('accounts/{student}', [StudentAccountController::class, 'showAccountStatement'])->name('students.accounts');
Route::resource('students', StudentController::class);

Route::name('student-healthy-history.')->prefix('student-healthy-history')->group(function() {
    Route::get('show/{student}', [StudentHealthyHistoryController::class, 'show'])->name('show');
    Route::put('update/{student}', [StudentHealthyHistoryController::class, 'update'])->name('update');
});
