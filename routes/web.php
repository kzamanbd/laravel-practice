<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Imports\TargetSetup;
use App\Livewire\ApiTokenManager;
use App\Livewire\BrowserSession;
use App\Livewire\ContactManagement;
use App\Livewire\GenerateRoute;
use App\Livewire\PostManagement;
use App\Livewire\RoleManagement;
use App\Livewire\UserDashboard;
use App\Livewire\UserManagement;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');

Route::get('dashboard', UserDashboard::class)->middleware(['auth', 'verified'])->name('dashboard');
// auth route group
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('profile', 'profile')->name('profile');
    Route::get('browser-session', BrowserSession::class)->name('browser-session');
    Route::get('api-tokens', ApiTokenManager::class)->name('api.tokens');
    Route::get('contacts', ContactManagement::class)->name('contacts');
    Route::get('users', UserManagement::class)->name('user.list');
    Route::get('user/{id}/view', [UserController::class, 'show'])->name('user.show');
    Route::get('roles', RoleManagement::class)->name('role.list');
    Route::get('role/{id}/view', [RoleController::class, 'show'])->name('role.show');
    Route::get('posts', PostManagement::class)->name('posts');

    Route::post('upload-base64', [HomeController::class, 'uploadBase64'])->name('upload.base64');
    Route::get('generate-route', GenerateRoute::class)->name('generate.route');
});

require __DIR__ . '/auth.php';

Route::get('test', function () {
    $path = public_path('docs/TargetSetup.xlsx');
    // get all sheets
    $response = [];
    $sheets = Excel::toCollection(new TargetSetup, $path);
    foreach ($sheets as $sheet) {
        $response[] = $sheet;
    }
    return $response;
});

