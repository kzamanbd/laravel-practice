<?php

use App\Http\Controllers\BrowserSessionManager;
use App\Http\Controllers\FirebaseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PHPSpreadsheetController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
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
require __DIR__ . '/auth.php';

Route::get('clear', function () {
    Artisan::call('optimize:clear');
    return "Site Optimized";
});
Route::get('storage', function () {
    Artisan::call('storage:link');
    return "Storage Link Created";
});

Route::view('/', 'welcome');
Route::middleware(['auth'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::controller(PHPSpreadsheetController::class)->group(function () {
        Route::get('upload-excel', 'index')->name('upload-excel');
        Route::post('upload-excel', 'preview')->name('submit-excel');
        Route::post('upload-confirm', 'store')->name('upload-confirm');
        Route::get('export-excel', 'show')->name('export-excel');
        Route::post('export-excel', 'export')->name('download-excel');
    });

    //role
    Route::resource('role', RoleController::class);
    //user
    Route::resource('user', UserController::class);
    //generate permission
    Route::get('generate-permission', [PermissionController::class, 'generateAllPermissions'])->name('generate.permission');

    Route::controller(HomeController::class)->group(function(){
        //current user
        Route::get('profile', 'profile')->name('current-user.show');
        Route::get('send-notification',  'sendAccountVerificationMail')->name('send.notification');
    });
    Route::controller(BrowserSessionManager::class)->group(function(){
        // browser session
        Route::get('browser-session',  'getSessionsProperty')->name('browser-session');
        Route::post('logout-other-browser',  'logoutOtherBrowserSessions')->name('logout-other-browser');
        Route::get('logout-single-browser/{device_id}',  'logoutSingleSessionDevice')->name('logout-single-browser');
    });

});

Route::get('firebase', [FirebaseController::class, 'firebase'])->name('firebase');

