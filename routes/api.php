<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\V1\CommentController;
use App\Http\Controllers\Api\V1\CategoryController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->name('api.vi.')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::prefix('v1')->name('api.vi.')->group(function () {
    Route::apiResource('/posts',PostController::class);
    Route::get('posts/{slug}/view-increment',[PostController::class,'viewIncrement'])->name('posts.view-increment');
    // Route::post('posts/{slug}',[PostController::class,'update'])->name('posts.update');
    Route::get('posts/category/{category}',[PostController::class,'getPostsByCategory'])->name('posts.byCategory');
    Route::get('/aside/posts/most-popular',[PostController::class,'mostPopularPosts'])->name('posts.most-popular');
    Route::get('/aside/posts/most-active',[PostController::class,'mostActivePosts'])->name('posts.most-active');
    Route::apiresource('/categories',CategoryController::class)->only('index');
    Route::apiResource('/posts/{post}/comment',CommentController::class)->only('store');
    Route::get('my-posts',[UserController::class,'myPosts'])->name('user.my-posts');
    // Route::get('posts/slug/{slug}',[PostController::class,'showBySlug'])->name('posts.slug');
});
