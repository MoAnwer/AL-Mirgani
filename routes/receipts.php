<?php

use App\Http\Controllers\Receipts\ReceiptController;

    Route::name('receipts.')->prefix('receipts')->controller(ReceiptController::class)->group(function() {
        Route::get('show/{receipt}', [ReceiptController::class, 'show'])->name('show');
        Route::post('{payment}', [ReceiptController::class, 'store'])->name('store');
    });