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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('/')->namespace('Api')->group(function() {
    Route::get('/article', 'IndexController@getArticle');
    Route::get('/article/{id}', 'IndexController@getArticleContent');
    Route::get('/single/{id}', 'IndexController@getSinglePage');
    Route::get('/banner', 'IndexController@getBanner');
    Route::get('/category', 'IndexController@getCategory');
});

//Route::prefix('/weapp')->namespace('Wechat')->group(function() {
//    Route::get('/user', 'MiniProgramController@getUser');
//});