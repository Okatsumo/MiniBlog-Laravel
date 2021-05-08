<?php


use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\v1\AdminController;
use App\Http\Controllers\Api\v1\ArticleApiController;
use App\Http\Controllers\Api\v1\CategoryApiController;
use App\Http\Controllers\Api\v1\CommentController;
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



Route::resource('article', ArticleApiController::class);
Route::resource('category', CategoryApiController::class);

Route::resource('comment', CommentController::class)->only([
    'create', 'destroy'
])->middleware('jwt');;

Route::resource('comment', CommentController::class)->only([
    'show'
]);


Route::group(['prefix'=>'auth'], function (){
    Route::put('register', [AuthApiController::class, 'register']);
    Route::put('login', [AuthApiController::class, 'login']);
    Route::put('refreshToken', [AuthApiController::class, 'getRefreshToken']);
});

Route::group(['prefix'=>'admin', 'middleware'=>'jwt'], function (){
    Route::post('test', [AdminController::class, 'test']);
});
