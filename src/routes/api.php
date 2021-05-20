<?php

use App\Http\Controllers\Api\v1\ArticleApiController;
use App\Http\Controllers\Api\v1\CategoryApiController;
use App\Http\Controllers\Api\v1\CommentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\v1\UserApiController;
use App\Http\Controllers\Auth\VerificationController;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use function App\Helpers\uploadImage;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::resource('user', UserApiController::class)->only([
    'create', 'destroy', "update", "edit"
])->middleware('auth:api');

Route::resource('users', UserApiController::class)->only([
    'index'
]);

Route::get('/get-user/{user}', [UserApiController::class, "show"]);


Route::post('register', [AuthController::class, "register"]);
Route::post('login', [AuthController::class, "login"]);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, "logout"]);
    Route::get('/get-user', [AuthController::class, "getUser"]);
    Route::post('/user/upload-avatar/{user}', [UserApiController::class, "uploadAvatar"]);
    Route::post('/upload-image', function (Request $request){
        if($request->file('image')){
            $image = uploadImage('public/images/upload/', $request->file('image'));
            return response(['status'=>201,'path'=> '/storage/images/upload/' . $image], 201);
        }
    });
});

Route::get('/get-count-users', function (){
    return response(['status'=>200, 'total'=>User::all()->count()], 200);
});
Route::get('/get-count-category', function (){
    return response(['status'=>200, 'total'=>Category::all()->count()], 200);
});

Route::resource('category', CategoryApiController::class);

Route::resource('article', ArticleApiController::class)->only([
    'create', 'destroy', "update", "edit", "store"
])->middleware('auth:api');

Route::get('/articles/search', [ArticleApiController::class, 'search']);

Route::resource('article', ArticleApiController::class)->only([
    'index', 'show'
]);


Route::resource('comment', CommentController::class)->only([
    'create', 'destroy', 'edit'
])->middleware('auth:api');

Route::resource('comment', CommentController::class)->only([
    'show', 'index'
]);


Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

//Подтверждение почты
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth:api','signed'])->name('verification.verify');
