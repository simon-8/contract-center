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

    Route::get('/{aid}', 'IndexController@getIndex')->where('aid','\d+');

    Route::prefix('/activity')->group(function() {
        Route::get('/', 'ActivityController@getIndex');
        Route::post('/dolottery', 'ActivityController@postLottery');
        //Route::get('/{id}', 'ActivityController@getOne')->where('id','\d+');
    });

    //Route::prefix('/gift')->group(function() {
    //    Route::get('/', 'GiftController@getIndex');
    //});

    Route::prefix('/user')->group(function() {
        //Route::get('/', 'UserController@getOne');
        Route::post('/checkin/{aid}', 'UserController@postCheckIn')->where('aid','\d+');
        Route::get('/lottery/{aid}/{openid?}', 'UserController@getLotteryHistory');
    });

});

Route::prefix('/weapp')->namespace('Wechat')->group(function() {
    Route::get('/user', 'MiniProgramController@getUser');
});