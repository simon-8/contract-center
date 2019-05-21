<?php

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

Route::prefix(config('admin.basePath'))->namespace('Admin')->name('admin.')->group(function() {
    Route::match(['get', 'post'], 'login', 'LoginController@index')->name('login');
    Route::get('logout', 'LoginController@logout')->name('logout');
    Route::any('ajax' , 'AjaxController@index')->name('ajax.index');

    //Route::group(['middleware' => 'auth:admin'], function() {
        // 首页
        Route::get('/', 'IndexController@index')->name('index.index');
        Route::get('main', 'IndexController@main')->name('index.main');

    Route::resource('menu', 'MenuController');
    Route::resource('user', 'UserController');
        // database
        Route::prefix('database')->group(function() {
            Route::get('/', 'DatabaseController@getIndex')->name('database.index');
            Route::get('/fields', 'DatabaseController@getFields')->name('database.fields');
            Route::get('/repair', 'DatabaseController@getRepair')->name('database.repair');
            Route::get('/optimize', 'DatabaseController@getOptimize')->name('database.optimize');
        });

    //});
});
