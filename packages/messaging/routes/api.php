<?php

use DraftScripts\Messaging\Http\Controllers\MessagingController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    // Dashboard Routes...
    Route::get('/initialize', [MessagingController::class, 'initialize']);
    Route::get('/message', [MessagingController::class, 'getMessages']);
    Route::post('/message', [MessagingController::class, 'store']);
});

// Catch-all Route...
Route::get('/{view?}', fn () => view('messaging::app'))->where('view', '(.*)')->name('messaging');
