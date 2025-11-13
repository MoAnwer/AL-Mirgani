<?php

use App\Http\Controllers\Settings\SettingController;

Route::name('settings.')->prefix('settings')->group(function () {
    Route::get('', [SettingController::class, 'settingsPage'])->name('.page');
});