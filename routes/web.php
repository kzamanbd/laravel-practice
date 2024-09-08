<?php

use App\Livewire\Blogging;
use App\Livewire\JobBatching;
use App\Imports\CollectionData;
use App\Livewire\UserDashboard;
use App\Livewire\BrowserSession;
use App\Livewire\DatabaseBackup;
use App\Livewire\ApiTokenManager;
use App\Livewire\ContactManagement;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', UserDashboard::class)->name('dashboard');
    Route::get('profile', fn() => view('profile'))->name('profile');
    Route::get('browser-session', BrowserSession::class)->name('browser.session');
    Route::get('tokens', ApiTokenManager::class)->name('api.tokens');
    Route::get('blogging', Blogging::class)->name('blog');
    Route::get('contacts', ContactManagement::class)->name('contacts');
    Route::get('job-batching', JobBatching::class)->name('job.batching');
    Route::get('database-backup', DatabaseBackup::class)->name('database.backup');
    Route::post('upload-base64', [HomeController::class, 'uploadBase64'])->name('upload.base64');
});

require __DIR__ . '/auth.php';

Route::get('excel-data', function () {
    $path = public_path('docs/TargetSetup.xlsx');
    // get all sheets
    $response = [];
    $sheets = Excel::toCollection(new CollectionData, $path);

    foreach ($sheets as $sheet) {
        $response[] = $sheet;
    }

    return $response;
});
