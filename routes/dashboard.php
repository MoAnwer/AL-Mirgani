<?php

use App\Http\Controllers\Dashboard\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'home'])->name('dashboard');
