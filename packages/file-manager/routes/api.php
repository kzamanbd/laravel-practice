<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    // Dashboard Routes...
});

// Catch-all Route...
Route::get('/{view?}', fn() => view('file-manager::app'))->where('view', '(.*)')->name('files');
