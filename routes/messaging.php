<?php

use App\Http\Controllers\MessagingController;
use Illuminate\Support\Facades\Route;

Route::prefix('messaging')->group(function () {
    Route::get('/{uuid?}', [MessagingController::class, 'initialize'])->name('messaging');
    Route::post('message', [MessagingController::class, 'store'])->name('message.store');
    Route::post('group', [MessagingController::class, 'createGroup']);
})->middleware(['auth']);
