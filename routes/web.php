<?php

use App\Http\Controllers\ChatRoomController;
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

require_once __DIR__ . './auth.php';
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::get('upload-excel', [PHPSpreadsheetController::class, 'index'])
    ->middleware(['auth:sanctum', 'verified'])
    ->name('upload-excel');

Route::post('upload-excel', [PHPSpreadsheetController::class, 'preview'])
    ->middleware(['auth:sanctum', 'verified'])
    ->name('submit-excel');

Route::post('upload-confirm', [PHPSpreadsheetController::class, 'store'])
    ->middleware(['auth:sanctum', 'verified'])
    ->name('upload-confirm');

Route::get('export-excel', [PHPSpreadsheetController::class, 'show'])
    ->middleware(['auth:sanctum', 'verified'])
    ->name('export-excel');

Route::post('export-excel', [PHPSpreadsheetController::class, 'export'])
    ->middleware(['auth:sanctum', 'verified'])
    ->name('download-excel');

//role
Route::resource('role', RoleController::class);
//current user
Route::get('current-user', 'HomeController@profile')->name('current-user.show');
Route::get('current-user/edit', 'HomeController@edit')->name('current-user.edit');
Route::post('current-user/update', 'HomeController@update')->name('current-user.update');
//user
Route::resource('user', UserController::class)
    ->middleware(['auth:sanctum', 'verified']);
//generate permission
Route::get('generate-permission', 'PermissionController@generateAllPermissions')
    ->name('generate.permission');

Route::get('send-notification', [HomeController::class, 'sendAccountVerificationMail'])
    ->name('send.notification')
    ->middleware(['auth:sanctum', 'verified']);

// chat

Route::get('chat', [ChatRoomController::class, 'index'])
    ->name('chat')
    ->middleware(['auth:sanctum', 'verified']);

Route::get('chat/rooms', [ChatRoomController::class, 'rooms'])
    ->name('chat.rooms')
    ->middleware(['auth:sanctum', 'verified']);

Route::get('chat/{roomId}/messages', [ChatRoomController::class, 'messages'])
    ->name('chat.messages')
    ->middleware(['auth:sanctum', 'verified']);

Route::post('chat/{roomId}/messages', [ChatRoomController::class, 'newMessages'])
    ->name('new.messages')
    ->middleware(['auth:sanctum', 'verified']);
