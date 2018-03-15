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
        // 首页
        Route::get('/', 'IndexController@getMain')->name('admin.index.main');
        Route::get('index', 'IndexController@getIndex')->name('admin.index.index');

        // 用户
        Route::prefix('user')->group(function() {
            Route::get('/', 'UserController@getIndex')->name('admin.user.index');
            Route::get('/create', 'UserController@getCreate')->name('admin.user.create');
            Route::get('/delete', 'UserController@getDelete')->name('admin.user.delete');
        });

        // 菜单
        Route::prefix('menu')->group(function() {
            Route::get('/', 'MenuController@getIndex')->name('admin.menu.index');
            Route::post('/create', 'MenuController@postCreate')->name('admin.menu.create');
            Route::post('/update', 'MenuController@postUpdate')->name('admin.menu.update');
            Route::get('/delete', 'MenuController@getDelete')->name('admin.menu.delete');
        });

        // ad place
        Route::prefix('ad')->group(function() {
            Route::get('/', 'AdController@getIndex')->name('admin.ad.index');
            Route::post('/create', 'AdController@postCreate')->name('admin.ad.create');
            Route::post('/update', 'AdController@postUpdate')->name('admin.ad.update');
            Route::get('/delete', 'AdController@getDelete')->name('admin.ad.delete');

            // ad
            Route::get('/items/{pid}', 'AdController@itemIndex')->name('admin.ad.item.index')->where('pid','\d+');
            Route::post('/item/create', 'AdController@itemCreate')->name('admin.ad.item.create');
            Route::post('/item/update', 'AdController@itemUpdate')->name('admin.ad.item.update');
            Route::get('/item/delete', 'AdController@itemDelete')->name('admin.ad.item.delete');
        });
        Route::any('ajax' , 'AjaxController@getIndex')->name('admin.ajax.index');
    });
});