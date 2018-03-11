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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function() {
    Route::namespace('Admin')->group(function() {
        Route::get('/', 'IndexController@getMain')->name('admin.main');
        Route::get('index', 'IndexController@getIndex')->name('admin.index');

        Route::prefix('user')->group(function() {
            Route::get('/', 'UserController@getIndex')->name('admin.user.index');
            Route::get('/create', 'UserController@getCreate')->name('admin.user.create');
            Route::get('/delete', 'UserController@getDelete')->name('admin.user.delete');
        });

        Route::prefix('menu')->group(function() {
            Route::get('/', 'MenuController@getIndex')->name('admin.menu.index');
            Route::post('/create', 'MenuController@postCreate')->name('admin.menu.create');
            Route::post('/update', 'MenuController@postUpdate')->name('admin.menu.update');
            Route::get('/delete', 'MenuController@getDelete')->name('admin.menu.delete');
        });

    });
});