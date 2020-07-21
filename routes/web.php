<?php

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

Route::prefix('admin')->middleware([])->group(function () {
	// Show login form when visit admin
	Route::get('login', 'Auth\Admin\LoginController@showLoginForm');
    Route::get('logout', 'Auth\Admin\LoginController@logout')->name('admin.logout');
	Route::post('login', 'Auth\Admin\LoginController@login')->name('admin.login');

	Route::middleware(['auth:admin'])->group(function(){
        //banner
        Route::resource('banner', 'Admin\BannerController');
        Route::post('banner/toggleactive', 'Admin\BannerController@toggleActive')->name('admin.banner.toggleactive');
        Route::post('banner/delete-multiple', 'Admin\BannerController@deleteMultiple')->name('admin.banner.delete-multiple');
    });
});

Auth::routes();
