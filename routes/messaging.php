<?php

use App\Http\Controllers\MessagingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('messaging/initialize', [MessagingController::class, 'initialize']);
    Route::get('messaging/message', [MessagingController::class, 'getMessages']);
    Route::post('messaging/message', [MessagingController::class, 'store']);
    Route::post('messaging/group', [MessagingController::class, 'createGroup']);
    Route::get('messaging/{view?}', fn() => view('messaging'))->where('view', '(.*)')->name('messaging');
});
