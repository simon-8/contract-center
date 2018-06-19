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

    Route::get('login', 'LoginController@showLoginForm')->name('login.get');
    Route::post('login', 'LoginController@login')->name('login.post');
    Route::get('logout', 'LoginController@logout')->name('logout.get');

    Route::group(['middleware' => 'admin.auth'], function() {
        // ajax
        Route::any('ajax' , 'AjaxController@index')->name('ajax.index');

        // 首页
        Route::get('/', 'IndexController@getMain')->name('index.main');
        Route::get('index', 'IndexController@getIndex')->name('index.index');

        Route::resource('ad', 'AdController');
        Route::resource('ad-place', 'AdPlaceController');
        Route::resource('article', 'ArticleController');
        Route::resource('category', 'CategoryController');
        Route::resource('manager', 'ManagerController');
        Route::resource('menu', 'MenuController');
        Route::resource('roles', 'RolesController');
        Route::resource('role-access', 'RoleAccessController');
        Route::resource('single', 'SinglePageController');
        Route::resource('setting', 'SettingController');

        // database
        Route::prefix('database')->group(function() {
            Route::get('/', 'DatabaseController@getIndex')->name('database.index');
            Route::get('/fields', 'DatabaseController@getFields')->name('database.fields');
            Route::get('/repair', 'DatabaseController@getRepair')->name('database.repair');
            Route::get('/optimize', 'DatabaseController@getOptimize')->name('database.optimize');
        });
    });
});

Route::prefix('/')->namespace('Home')->group(function() {

    Route::get('{any}', function () {
        return view('home.index.index');
    })->where('any', '.*');

});
