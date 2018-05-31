<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/')->namespace('Api')->group(function() {
    Route::get('banner', 'IndexController@getBanner');
    Route::get('category', 'IndexController@getCategory');
    Route::get('tag', 'IndexController@getTag');
    Route::get('menus', 'IndexController@getMenus');

    Route::get('article/tag/{tagid}', 'ArticleController@listByTag')->where('tagid', '\d+');
    Route::resource('article', 'ArticleController');
    Route::resource('single', 'SingleController');

});

//Route::prefix('/weapp')->namespace('Wechat')->group(function() {
//    Route::get('/user', 'MiniProgramController@getUser');
//});