<?php

use App\Facades\Math;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogViewerController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\BrowserSessionManager;
use App\Http\Livewire\ContactList;
use App\Http\Livewire\RoleList;
use App\Http\Livewire\UserList;
use Illuminate\Support\Facades\Artisan;
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

Route::get('clear', function () {
    Artisan::call('optimize:clear');

    return 'Site Optimized';
});
Route::get('storage', function () {
    Artisan::call('storage:link');

    return 'Storage Link Created';
});

require __DIR__ . '/auth.php';

Route::view('/', 'welcome');
Route::view('/map', 'google-map');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('api-tokens', 'api.index')->name('api.tokens');
    Route::view('profile', 'user-profile')->name('current-user.show');
    Route::get('contacts', ContactList::class)->name('contacts.list');
    Route::get('users', UserList::class)->name('user.list');
    Route::get('user/{id}/view', [UserController::class, 'show'])->name('user.show');
    Route::get('roles', RoleList::class)->name('role.list');
    Route::get('role/{id}/view', [RoleController::class, 'show'])->name('role.show');
    Route::get('generate-permission', [PermissionController::class, 'generateAllPermissions'])->name('generate.permission');
    Route::get('send-notification', [HomeController::class, 'sendAccountVerificationMail'])->name('send.notification');
    Route::get('browser-session', BrowserSessionManager::class)->name('browser-session');
    Route::get('log-viewer', [LogViewerController::class, 'getLogFile'])->name('log-viewer');
    Route::get('log-viewer/{file}', [LogViewerController::class, 'getLogDetail']);
});

Route::get('/facade', function () {
    return Math::addition(10, 2);
});
