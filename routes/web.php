<?php

use App\Livewire\Blogging;
use App\Livewire\JobBatching;
use App\Livewire\UserDashboard;
use App\Livewire\BrowserSession;
use App\Livewire\DatabaseBackup;
use App\Livewire\ApiTokenManager;
use App\Livewire\ContactManagement;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\LoggerMiddleware;
use App\Livewire\OpenAi\OpenAIManager;

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

Route::view('/', 'welcome')->middleware(LoggerMiddleware::class);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', UserDashboard::class)->name('dashboard');
    Route::get('profile', fn() => view('profile'))->name('profile');
    Route::get('browser-session', BrowserSession::class)->name('browser.session');
    Route::get('tokens', ApiTokenManager::class)->name('api.tokens');
    Route::get('blogging', Blogging::class)->name('blog');
    Route::get('contacts', ContactManagement::class)->name('contacts');
    Route::get('job-batching', JobBatching::class)->name('job.batching');
    Route::get('database-backup', DatabaseBackup::class)->name('database.backup');
    Route::get('open-ai', OpenAIManager::class)->name('open-ai');
    Route::post('upload-base64', [HomeController::class, 'uploadBase64'])->name('upload.base64');
});

Route::view('payhere', 'payhere')->name('payhere');
Route::view('payhere-success', 'payhere-success')->name('payhere.success');
Route::view('payhere-cancel', 'payhere-cancel')->name('payhere.cancel');
Route::view('payhere-notify', 'payhere-notify')->name('payhere.notify');
