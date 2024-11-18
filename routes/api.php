<?php

use App\Http\Controllers\Api\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\PostController;
use App\Http\Middleware\BeforeResponseInterceptor;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware(Authenticate::using('sanctum'));


Route::get('/', function (Request $request) {
    return response()->json([
        'success' => true,
        'request url' => $request->url(),
        'message' => 'This api under construction',
    ]);
});

Route::prefix('auth')->group(function () {
    //login routes
    Route::post('login', [AuthenticatedSessionController::class, 'login']);
    Route::post('register', [AuthenticatedSessionController::class, 'register']);
    //get current user
    Route::get('current-user', [AuthenticatedSessionController::class, 'currentUser'])->middleware(['auth:sanctum',BeforeResponseInterceptor::class]);
    //logout
    Route::post('logout', [AuthenticatedSessionController::class, 'logout'])->middleware('auth:sanctum');
});

Route::get('app', [HomeController::class, 'initApp'])->middleware(BeforeResponseInterceptor::class);
Route::get('category', [CategoryController::class, 'index'])->middleware(BeforeResponseInterceptor::class);
Route::get('posts', [PostController::class, 'posts'])->middleware(BeforeResponseInterceptor::class);
Route::get('post/{slug}', [PostController::class, 'show'])->middleware(BeforeResponseInterceptor::class);
Route::post('comment', [CommentController::class, 'store']);
Route::post('comment', [CommentController::class, 'destroy']);

// upload-image-by-cropper js
Route::post('upload-image', [HomeController::class, 'uploadImage']);
Route::post('upload-docs-file', [HomeController::class, 'uploadDocsFile']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('get-users', [HomeController::class, 'getAllUsers'])->middleware(BeforeResponseInterceptor::class);
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
