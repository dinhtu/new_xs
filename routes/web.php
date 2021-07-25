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
Route::post('check-email', 'RegisterController@checkEmail')->name('checkEmail');
Route::get('forgot_password/reset/{token}', 'ForgotPasswordController@reset')->name('forgot_password.reset');
Route::post('forgot_password/changePassword', 'ForgotPasswordController@changePassword')->name('forgot_password.changePassword');
// Route::get('/', function () {
//     return view('user/index');
// });
// Auth::routes();

Route::group([
    'prefix' => 'producer',
    'namespace' => 'Producer',
    // 'middleware' => ['assign.guard:user', 'producer']
], function () {
    //route producer
    Route::resource('dashboard', DashboardController::class, ['as' => 'producer']);
    Route::resource('profile', ProfileController::class, ['as' => 'producer']);
    Route::resource('accountInfo', AccountInfoController::class, ['as' => 'producer']);
    Route::resource('code', CodeController::class, ['as' => 'producer']);
    Route::resource('systemInfo', SystemInfoController::class, ['as' => 'producer']);
    Route::resource('readHistory', ReadHistoryController::class, ['as' => 'producer']);
    Route::resource('traceAbility', TraceAbilityController::class, ['as' => 'producer']);
    Route::resource('pastTraceAbility', PastTraceAbilityController::class, ['as' => 'producer']);
    Route::resource('qrCode', QrCodeController::class, ['as' => 'producer']);
    Route::resource('info', InfoController::class, ['as' => 'producer']);
});

Route::group([
    'prefix' => 'wholeSalers',
    'namespace' => 'WholeSalers',
    // 'middleware' => ['assign.guard:user', 'wholeSalers']
], function () {
    //route WholeSaleers
    Route::resource('dashboard', DashboardController::class, ['as' => 'wholeSalers']);
    Route::resource('profile', ProfileController::class, ['as' => 'wholeSalers']);
    Route::resource('accountInfo', AccountInfoController::class, ['as' => 'wholeSalers']);
    Route::resource('systemInfo', SystemInfoController::class, ['as' => 'wholeSalers']);
    Route::resource('readHistory', ReadHistoryController::class, ['as' => 'wholeSalers']);
    Route::resource('traceAbility', TraceAbilityController::class, ['as' => 'wholeSalers']);
    Route::resource('pastTraceAbility', PastTraceAbilityController::class, ['as' => 'wholeSalers']);
    Route::resource('info', InfoController::class, ['as' => 'wholeSalers']);
    Route::resource('qrCode', QrCodeController::class, ['as' => 'wholeSalers']);
});

Route::group([
    'prefix' => 'restaurant',
    'namespace' => 'Restaurant',
    // 'middleware' => ['assign.guard:user', 'restaurant']
], function () {
    //route Restaurant
    Route::resource('dashboard', DashboardController::class, ['as' => 'restaurant']);
    Route::resource('profile', ProfileController::class, ['as' => 'restaurant']);
    Route::resource('accountInfo', AccountInfoController::class, ['as' => 'restaurant']);
    Route::resource('readHistory', ReadHistoryController::class, ['as' => 'restaurant']);
    Route::resource('traceAbility', TraceAbilityController::class, ['as' => 'restaurant']);
    Route::resource('pastTraceAbility', PastTraceAbilityController::class, ['as' => 'restaurant']);
    Route::resource('info', InfoController::class, ['as' => 'restaurant']);
    Route::resource('qrCode', QrCodeController::class, ['as' => 'restaurant']);
});

Route::group([
    'prefix' => 'users',
    'namespace' => 'Users',
    // 'middleware' => ['assign.guard:user', 'producer']
], function () {
    //route producer
    // Route::resource('dashboard', Producer\DashboardController::class, [
    //     'as' => 'users'
    // ]);
    Route::resource('profile', ProfileController::class, ['as' => 'users']);
    Route::resource('accountInfo', AccountInfoController::class, ['as' => 'users']);
    Route::resource('traceAbility', TraceAbilityController::class, ['as' => 'users']);
});

// 一般情報照会
// Route::get('traceAbility/{uuid}', [TraceAbility\TraceAbilityController::class, 'index'], []);
// Route::get('traceAbility/{uuid}/edit', [TraceAbility\TraceAbilityController::class, 'edit'], []);
