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

Route::prefix('admin')->namespace('Admin')->group(function() {

    Route::get('login', 'LoginController@showLoginForm')->name('admin.login.get');
    Route::post('login', 'LoginController@login')->name('admin.login.post');
    Route::get('logout', 'LoginController@logout')->name('admin.logout.get');

    Route::group(['middleware' => 'admin.auth'], function() {
        // ajax
        Route::any('ajax' , 'AjaxController@index')->name('admin.ajax.index');

        // 首页
        Route::get('/', 'IndexController@getMain')->name('admin.index.main');
        Route::get('index', 'IndexController@getIndex')->name('admin.index.index');

        Route::resource('article', 'ArticleController');
        Route::resource('manager', 'ManagerController');
        Route::resource('menu', 'MenuController');
        Route::resource('single', 'SinglePageController');

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

        // roles
        Route::prefix('roles')->group(function() {
            Route::get('/', 'RolesController@getIndex')->name('admin.roles.index');
            Route::match(['get', 'post'],'/create', 'RolesController@doCreate')->name('admin.roles.create');
            Route::match(['get', 'post'],'/update', 'RolesController@doUpdate')->name('admin.roles.update');
            Route::get('/delete', 'RolesController@getDelete')->name('admin.roles.delete');
        });

        // access
        Route::prefix('role-access')->group(function() {
            Route::get('/', 'RoleAccessController@getIndex')->name('admin.roleaccess.index');
            Route::match(['get', 'post'],'/create', 'RoleAccessController@doCreate')->name('admin.roleaccess.create');
            Route::match(['get', 'post'],'/update', 'RoleAccessController@doUpdate')->name('admin.roleaccess.update');
            Route::get('/delete', 'RoleAccessController@getDelete')->name('admin.roleaccess.delete');
        });

        // database
        Route::prefix('database')->group(function() {
            Route::get('/', 'DatabaseController@getIndex')->name('admin.database.index');
            Route::get('/fields', 'DatabaseController@getFields')->name('admin.database.fields');
            Route::get('/repair', 'DatabaseController@getRepair')->name('admin.database.repair');
            Route::get('/optimize', 'DatabaseController@getOptimize')->name('admin.database.optimize');
        });

        // setting
        Route::prefix('setting')->group(function() {
            Route::get('/', 'SettingController@getIndex')->name('admin.setting.index');
            Route::post('/create', 'SettingController@postCreate')->name('admin.setting.create');
            Route::post('/update', 'SettingController@postUpdate')->name('admin.setting.update');
            Route::get('/delete', 'SettingController@getDelete')->name('admin.setting.delete');
        });

        // user
        Route::prefix('user')->group(function() {
            Route::get('/', 'UserController@getIndex')->name('admin.user.index');
            Route::get('/delete', 'UserController@getDelete')->name('admin.user.delete');
        });

        // category
        Route::prefix('category')->group(function() {
            Route::get('/', 'CategoryController@getIndex')->name('admin.category.index');
            Route::post('/create', 'CategoryController@postCreate')->name('admin.category.create');
            Route::post('/update', 'CategoryController@postUpdate')->name('admin.category.update');
            Route::get('/delete', 'CategoryController@getDelete')->name('admin.category.delete');
        });

    });
});

Route::prefix('/')->namespace('Home')->group(function() {

    Route::get('{any}', function () {
        return view('home.index.index');
    })->where('any', '.*');

});
