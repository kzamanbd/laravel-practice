<?php

use App\Http\Controllers\BrowserSessionManager;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PHPSpreadsheetController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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
Route::view('/product', 'product');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('upload-excel', [PHPSpreadsheetController::class, 'index'])->name('upload-excel');
    Route::post('upload-excel', [PHPSpreadsheetController::class, 'preview'])->name('submit-excel');
    Route::post('upload-confirm', [PHPSpreadsheetController::class, 'store'])->name('upload-confirm');
    Route::get('export-excel', [PHPSpreadsheetController::class, 'show'])->name('export-excel');
    Route::post('export-excel', [PHPSpreadsheetController::class, 'export'])->name('download-excel');
    //role
    Route::resource('role', RoleController::class);
    //current user
    Route::get('current-user', 'HomeController@profile')->name('current-user.show');
    Route::get('current-user/edit', 'HomeController@edit')->name('current-user.edit');
    Route::post('current-user/update', 'HomeController@update')->name('current-user.update');
    //user
    Route::resource('user', UserController::class);
    //generate permission
    Route::get('generate-permission', 'PermissionController@generateAllPermissions')->name('generate.permission');
    Route::get('send-notification', [HomeController::class, 'sendAccountVerificationMail'])->name('send.notification');

    // browser session
    Route::get('browser-session', [BrowserSessionManager::class, 'getSessionsProperty'])->name('browser-session');
    Route::post('logout-other-browser', [BrowserSessionManager::class, 'logoutOtherBrowserSessions'])->name('logout-other-browser');
    Route::get('logout-single-browser/{device_id}', [BrowserSessionManager::class, 'logoutSingleSessionDevice'])->name('logout-single-browser');
});

require __DIR__ . '/auth.php';

