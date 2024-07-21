<?php

use App\Http\Controllers\HomeController;
use App\Imports\TargetSetup;
use App\Livewire\ApiTokenManager;
use App\Livewire\BrowserSession;
use App\Livewire\ContactManagement;
use App\Livewire\GenerateRoute;
use App\Livewire\JobBatching;
use App\Livewire\PostManagement;
use App\Livewire\UserDashboard;
use Illuminate\Support\Facades\Http;
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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', UserDashboard::class)->name('dashboard');
    Route::view('profile', 'profile')->name('profile');
    Route::get('browser-session', BrowserSession::class)->name('browser-session');
    Route::get('tokens', ApiTokenManager::class)->name('api.tokens');
    Route::get('blog', PostManagement::class)->name('blog');
    Route::get('contacts', ContactManagement::class)->name('contacts');

    Route::post('upload-base64', [HomeController::class, 'uploadBase64'])->name('upload.base64');
    Route::get('generate-route', GenerateRoute::class)->name('generate.route');
    Route::get('job-batching', JobBatching::class)->name('job-batching');
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

Route::get('sms', function () {
    try {
        $url = "https://gpcmp.grameenphone.com/ecmapigw/webresources/ecmapigw.v2";

        $data = [
            "username" => "NIPROJPADMN",
            "password" => "JERP_(2024@Bd", //"Ekram@111",
            "apicode" => "1",
            "msisdn" => "01716724245",
            "countrycode" => "880",
            "cli" => "NIPRO JMI",
            "messagetype" => "1",
            "message" => "Test my MSG from API",
            "messageid" => "0"
        ];

        $response = Http::post($url, $data);

        dd($response->json());
    } catch (\Throwable $th) {
        dd($th);
    }
});
