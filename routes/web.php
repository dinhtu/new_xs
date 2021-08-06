<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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
Route::resource('/', HomeController::class);
Route::resource('login', LoginController::class);
Route::resource('register', RegisterController::class);
Route::resource('forgot_password', ForgotPasswordController::class);
Route::get('logout', "LoginController@logout");

Route::group([
    'prefix' => 'producer',
    'namespace' => 'Producer',
    'middleware' => ['dinhtu']
], function () {
    //route producer
    Route::resource('dashboard', DashboardController::class, ['as' => 'producer']);
    Route::resource('result', ResultController::class, ['as' => 'producer']);
});
