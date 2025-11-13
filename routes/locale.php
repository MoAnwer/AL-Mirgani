<?php

use App\Http\Controllers\LocaleController;

Route::post('/lang', [LocaleController::class, 'setLocale'])->name('locale');