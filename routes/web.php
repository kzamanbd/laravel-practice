<?php

use App\Http\Livewire\BrowserSessionManager;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogViewerController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Livewire\RoleList;
use App\Http\Livewire\UserList;
use App\Http\Livewire\ContactList;
use App\Models\Contact;
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
    return "Site Optimized";
});
Route::get('storage', function () {
    Artisan::call('storage:link');
    return "Storage Link Created";
});


Route::view('/', 'welcome');
Route::view('/map', 'google-map');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::get('contacts-list', ContactList::class)->name('contacts.list');
    Route::view('api-tokens', 'api.index')->name('api.tokens');

    //user
    Route::get('user-list', UserList::class)->name('user.list');
    Route::get('user/{id}/view', [UserController::class, 'show'])->name('user.show');
    //role
    Route::get('role-list', RoleList::class)->name('role.list');
    Route::get('role/{id}/view', [RoleController::class, 'show'])->name('role.show');
    //generate permission
    Route::get('generate-permission', [PermissionController::class, 'generateAllPermissions'])->name('generate.permission');

    //current user
    Route::view('profile', 'user-profile')->name('current-user.show');
    Route::get('send-notification', [HomeController::class, 'sendAccountVerificationMail'])->name('send.notification');
    // browser session
    Route::get('browser-session', BrowserSessionManager::class)->name('browser-session');

    Route::get('log-viewer', [LogViewerController::class, 'getLogFile'])->name('log-viewer');
    Route::get('log-viewer/{file}', [LogViewerController::class, 'getLogDetail']);
    Route::get('log-viewer/download/{file}', [LogViewerController::class, 'downloadLogs']);
    Route::get('log-viewer/clear/{file}', [LogViewerController::class, 'clearLogs']);
    Route::get('log-viewer/delete/{file}', [LogViewerController::class, 'deleteLogs']);
    Route::post('log-viewer/bulk-action', [LogViewerController::class, 'bulkAction']);
});


require __DIR__ . '/auth.php';

Route::get('test', function () {
    return Contact::query()->paginate(25);
});
