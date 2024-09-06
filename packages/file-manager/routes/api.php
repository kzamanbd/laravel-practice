<?php

use DraftScripts\FileManager\Http\Controllers\FileManagerController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::get('data', [FileManagerController::class, 'index']);
});

// Catch-all Route...
Route::get('/{view?}', fn() => view('file-manager::app'))->where('view', '(.*)')->name('files');
