<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Livewire\ApiTokenManager;
use App\Livewire\BrowserSession;
use App\Livewire\ContactList;
use App\Livewire\RoleList;
use App\Livewire\UserList;
use Illuminate\Support\Facades\Route;

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
Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');
Route::view('profile', 'profile')->middleware(['auth'])->name('profile');


Route::get('browser-session', BrowserSession::class)->name('browser-session');
Route::get('api-tokens', ApiTokenManager::class)->name('api.tokens');
Route::get('contacts', ContactList::class)->name('contacts');
Route::get('users', UserList::class)->name('user.list');
Route::get('user/{id}/view', [UserController::class, 'show'])->name('user.show');
Route::get('roles', RoleList::class)->name('role.list');
Route::get('role/{id}/view', [RoleController::class, 'show'])->name('role.show');

require __DIR__ . '/auth.php';
