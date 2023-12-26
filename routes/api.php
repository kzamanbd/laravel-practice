<?php

use App\Http\Controllers\API\Auth\AuthenticatedSessionController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\PostController;
use Illuminate\Http\Request;
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
        'success' => true,
        'request url' => request()->url(),
        'message' => 'This api under construction',
    ]);
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

Route::get('init-app', [HomeController::class, 'initApp']);
//get category
Route::get('category', [CategoryController::class, 'index']);
//get post
Route::get('posts', [PostController::class, 'posts']);
Route::get('post/{slug}', [PostController::class, 'show']);

// comment route
Route::post('comment', [CommentController::class, 'store']);
Route::post('comment', [CommentController::class, 'destroy']);

// upload-image-by-cropper js
Route::post('upload-image', [HomeController::class, 'uploadImage']);
Route::post('upload-docs-file', [HomeController::class, 'uploadDocsFile']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('get-users', [HomeController::class, 'getAllUsers']);
    Route::get('get-user-detail/{id}', [HomeController::class, 'user']);
});

Route::any('basic-auth', function (Request $request) {
    return [
        $request->getUser(),
        // get the basic auth password
        $request->getPassword(),
        // get header auth
        $request->header('api-key'),
    ];
});
Route::get('test-database-transactions', [HomeController::class, 'testDatabaseTransactions']);
Route::post('upload-base64', [HomeController::class, 'uploadBase64'])->name('upload.base64');
