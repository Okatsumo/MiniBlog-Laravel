<?php

use App\Models\Category;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;

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


//Роут перенаправляющий всё на vue
Route::get('/', function () {
    return view('index',
        [
            'categories'=>Category::all()
        ]);
})->name('login');


Broadcast::routes([
    'middleware' => 'auth:api']
);


Route::get('{any}', function () {
    return view('index',
    [
        'categories'=>Category::all()
    ]);
})->where('any', '.*');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

