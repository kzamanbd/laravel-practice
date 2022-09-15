<?php

use App\Http\Livewire\BrowserSessionManager;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PHPSpreadsheetController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Livewire\UserList;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::controller(PHPSpreadsheetController::class)->group(function () {
        Route::get('upload-excel', 'index')->name('upload-excel');
        Route::post('upload-excel', 'preview')->name('submit-excel');
        Route::post('upload-confirm', 'store')->name('upload-confirm');
        Route::get('export-excel', 'show')->name('export-excel');
        Route::get('download-excel', 'export')->name('download-excel');
    });

    //role
    Route::resource('role', RoleController::class);
    //user
    Route::get('user-list', UserList::class)->name('user-list');
    Route::get('user/{id}', [UserController::class, 'show'])->name('user.show');
    //generate permission
    Route::get('generate-permission', [PermissionController::class, 'generateAllPermissions'])->name('generate.permission');

    //current user
    Route::get('profile', [HomeController::class, 'profile'])->name('current-user.show');
    Route::get('send-notification',  [HomeController::class, 'sendAccountVerificationMail'])->name('send.notification');
    // browser session
    Route::get('browser-session',  BrowserSessionManager::class)->name('browser-session');
});


require __DIR__ . '/auth.php';

Route::get('clear', function () {
    Artisan::call('optimize:clear');
    return "Site Optimized";
});
Route::get('storage', function () {
    Artisan::call('storage:link');
    return "Storage Link Created";
});
