<?php

use App\Http\Controllers\API\ChatController;
use Illuminate\Http\Request;
use App\Http\Controllers\API\Auth\AuthenticatedSessionController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\NotifierController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function () {
    return response()->json([
        'request url' => request()->url(),
        'success' => true,
        'message' => 'api under construction'
    ]);
});

Route::post('form-submitted', function (Request $request) {
    return $request->all();
});


Route::prefix('auth')->group(function () {
    //get current user
    Route::get('current-user', [AuthenticatedSessionController::class, 'currentUser']);
    //login routes
    Route::post('login', [AuthenticatedSessionController::class, 'login']);
    Route::post('register', [AuthenticatedSessionController::class, 'register']);
    //logout
    Route::post('logout', [AuthenticatedSessionController::class, 'logout']);

});

Route::get('init-app', [HomeController::class, 'index']);
//get category
Route::get('category', [CategoryController::class, 'index']);
//get post
Route::get('posts', [PostController::class, 'index']);
Route::get('post', [PostController::class, 'show']);

// comment route
Route::post('comment', [CommentController::class, 'store']);
Route::post('comment', [CommentController::class, 'destroy']);

// chat
Route::post('get-message', [ChatController::class, 'getMessage']);
// upload-image-by-cropper js
Route::post('upload-image-by-croperjs', [HomeController::class, 'uploadImageByCroperjs']);
Route::post('upload-docs-file', [HomeController::class, 'uploadDocsFile']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('get-users', [HomeController::class, 'getAllUsers']);
    Route::get('get-user-detail/{id}', [HomeController::class, 'user']);
});


Route::get('get-notification', [NotifierController::class, 'getNotification']);
Route::post('store-notification', [NotifierController::class, 'store']);
Route::post('sync-offline-message', [NotifierController::class, 'syncOfflineMessage']);

Route::get('update-sender-number', [NotifierController::class, 'updateSenderNumber']);
