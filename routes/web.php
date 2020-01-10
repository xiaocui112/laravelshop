<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('layouts.app');
})->middleware('verified');

Auth::routes(['verify' => true]);
// auth 中间件代表需要登录，verified中间件代表需要经过邮箱验证
Route::group(['middleware' => ['auth', 'verified']], function () {
    //获取地址详情
    Route::get('user_addresses', 'UserAddressesController@index')->name('user_addresses.index');
    //新建地址
    Route::get('user_addresses/create', 'UserAddressesController@create')->name('user_addresses.create');
});
