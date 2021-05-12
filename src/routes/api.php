<?php

use App\Http\Controllers\Api\v1\ArticleApiController;
use App\Http\Controllers\Api\v1\CategoryApiController;
use App\Http\Controllers\Api\v1\CommentController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, "register"]);
Route::post('login', [AuthController::class, "login"]);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, "logout"]);
    Route::get('/get-user', [AuthController::class, "getUser"]);
});


Route::resource('category', CategoryApiController::class);


Route::resource('article', ArticleApiController::class)->only([
    'create', 'destroy', "update", "edit", "store"
])->middleware('auth:api');

Route::resource('article', ArticleApiController::class)->only([
    'index', 'show'
]);


Route::resource('comment', CommentController::class)->only([
    'create', 'destroy'
])->middleware('auth:api');

Route::resource('comment', CommentController::class)->only([
    'show'
]);

