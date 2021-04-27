<?php


use App\Http\Controllers\Api\Auth\LoginApiController;
use App\Http\Controllers\Api\v1\AdminController;
use App\Http\Controllers\Api\v1\ArticleApiController;
use App\Http\Controllers\Api\v1\CategoryApiController;
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


Route::group(['prefix'=>'auth'], function (){
    Route::put('login', [LoginApiController::class, 'login']);
    Route::put('refreshToken', [LoginApiController::class, 'getRefreshToken']);
});

Route::group(['prefix'=>'admin', 'middleware'=>'jwt'], function (){
    Route::post('test', [AdminController::class, 'test']);
});
