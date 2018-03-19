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

Route::prefix('admin')->namespace('Admin')->group(function() {
    // ajax
    Route::any('ajax' , 'AjaxController@getIndex')->name('admin.ajax.index');

    // 首页
    Route::get('/', 'IndexController@getMain')->name('admin.index.main');
    Route::get('index', 'IndexController@getIndex')->name('admin.index.index');

    // 用户
    //Route::prefix('user')->group(function() {
    //    $namePrefix = 'admin.user.';
    //    Route::get('/', 'UserController@getIndex')->name('admin.user.index');
    //    Route::get('/create', 'UserController@getCreate')->name('admin.user.create');
    //    Route::get('/delete', 'UserController@getDelete')->name('admin.user.delete');
    //});

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

    // manager
    Route::prefix('manager')->group(function() {
        Route::get('/', 'ManagerController@getIndex')->name('admin.manager.index');
        Route::match(['get', 'post'],'/create', 'ManagerController@doCreate')->name('admin.manager.create');
        Route::match(['get', 'post'],'/update', 'ManagerController@doUpdate')->name('admin.manager.update');
        Route::get('/delete', 'ManagerController@getDelete')->name('admin.manager.delete');
    });

    // database
    Route::prefix('database')->group(function() {
        Route::get('/', 'DatabaseController@getIndex')->name('admin.database.index');
        Route::get('/fields', 'DatabaseController@getFields')->name('admin.database.fields');
        Route::get('/repair', 'DatabaseController@getRepair')->name('admin.database.repair');
        Route::get('/optimize', 'DatabaseController@getOptimize')->name('admin.database.optimize');
    });

    // activity
    Route::prefix('activity')->group(function() {
        Route::get('/', 'ActivityController@getIndex')->name('admin.activity.index');
        Route::match(['get', 'post'],'/create', 'ActivityController@doCreate')->name('admin.activity.create');
        Route::match(['get', 'post'],'/update', 'ActivityController@doUpdate')->name('admin.activity.update');
        Route::get('/delete', 'ActivityController@getDelete')->name('admin.activity.delete');
    });

    // gift
    Route::prefix('gift')->group(function() {
        Route::get('/', 'GiftController@getIndex')->name('admin.gift.index');
        Route::match(['get', 'post'],'/create', 'GiftController@doCreate')->name('admin.gift.create');
        Route::match(['get', 'post'],'/update', 'GiftController@doUpdate')->name('admin.gift.update');
        Route::get('/delete', 'GiftController@getDelete')->name('admin.gift.delete');
    });

    // setting
    Route::prefix('setting')->group(function() {
        Route::get('/', 'SettingController@getIndex')->name('admin.setting.index');
        Route::post('/create', 'SettingController@postCreate')->name('admin.setting.create');
        Route::post('/update', 'SettingController@postUpdate')->name('admin.setting.update');
        Route::get('/delete', 'SettingController@getDelete')->name('admin.setting.delete');
    });
});
