<?php

use App\Models\Category;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Подтверждение почты
Route::get('/email/verify/{id}/{hash}', function () {
    return view('auth.confirmEmail');
});

Route::get('/reset-password/{token}', function ($token) {
    return view('index');
})->middleware('guest')->name('password.reset');

//Роут перенаправляющий всё на vue
Route::get('/', function () {
    return view(
        'index',
        [
            'categories'=> Category::all(),
        ]
    );
});

Broadcast::routes(
    [
        'middleware' => 'auth:api', ]
);

Route::get('{any}', function () {
    return view(
        'index',
        [
            'categories'=> Category::all(),
        ]
    );
})->where('any', '.*');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
