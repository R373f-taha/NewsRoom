<?php

use App\Http\Controllers\Api\V1\ArticleController;
use App\Http\Controllers\Api\V1\ArticlePublishController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\DashboardController;
use App\Http\Controllers\Api\V1\TagController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V2\ArticleController as V2ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('V1/')->group(function(){

Route::get('articles',[ArticleController::class,'all'])->middleware(['auth:sanctum', 'throttle:60,1']);
Route::get('published/articles',[ArticleController::class,'indexV1'])->middleware(['auth:sanctum', 'throttle:60,1']);
Route::get('articles/{article}',[ArticleController::class ,'show'])->middleware(['auth:sanctum','throttle:60,2']);
Route::post('articles',[ArticleController::class,'store'])->middleware(['auth:sanctum','is_writer' ,'throttle:60,1']);
Route::post('/users/login', [AuthController::class, 'login'])->middleware(['throttle:5,10']);
Route::post('users/register',[AuthController::class,'register'])->middleware('throttle:10,1');
Route::post('/users/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum', 'throttle:60,1']);
Route::get('/dashboard/stats', [DashboardController::class, 'stats'])->middleware(['auth:sanctum','is_admin', 'throttle:60,1']);
Route::put('/articles/{article}/publish', [ArticlePublishController::class, 'publish'])->middleware(['auth:sanctum','is_writer', 'throttle:60,1']);
Route::get('/top/{limit}/tags',[TagController::class,'topTags'])->middleware(['auth:sanctum', 'throttle:60,1']);

});


Route::prefix('V2/')->group(function(){

Route::get('published/articles',[V2ArticleController::class,'indexV2'])->middleware(['auth:sanctum', 'throttle:60,1']);

});
