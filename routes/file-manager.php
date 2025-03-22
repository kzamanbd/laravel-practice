<?php

use App\Http\Controllers\FileManagerController;
use Illuminate\Support\Facades\Route;

Route::prefix('files')->group(function () {
    Route::get('/', [FileManagerController::class, 'index'])->name('files');
    Route::post('content', [FileManagerController::class, 'content'])->name('files.content');
})->middleware(['auth']);
