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

Route::prefix('/')->namespace('Api')->name('api.')->group(function () {
    Route::prefix('mini-program')->group(function () {
        Route::any('login', 'MiniProgramController@login');
        Route::any('debug-login/{userid}', 'MiniProgramController@debugLogin');
        //Route::get('unlimit-qrcode', 'MiniProgramController@getUnlimitQrCode');
        //Route::get('config', 'MiniProgramController@config');
        //Route::post('decrypt-data', 'MiniProgramController@decryptData')->middleware('auth:api');
    });

    Route::apiResource('banner', 'BannerController');

    Route::prefix('contract')->group(function () {
        Route::get('status', 'ContractController@getStatus');
        Route::get('status-count', 'ContractController@getStatusCount');
        Route::post('confirm/{contract}', 'ContractController@confirm');
        Route::post('sign', 'ContractController@sign');
    });

    Route::apiResource('contract', 'ContractController')
        ->middleware('auth:api')
        ->except('getStatus', 'getStatusCount');

    Route::apiResource('contract-template', 'ContractTemplateController');
    Route::apiResource('contract-file', 'ContractFileController');

    Route::prefix('order')->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::post('', 'OrderController@store');
            Route::post('repay/{orderid}', 'OrderController@reStore');
            Route::post('cancel/{orderid}', 'OrderController@cancel');
        });
        Route::any('notify/{channel}', 'OrderController@notify')->name('order.notify');
        Route::any('refund/{channel}', 'OrderController@refund')->name('order.refund');
    });

    Route::prefix('user')->group(function () {
        Route::group(['middleware' => 'auth:api'], function() {
            Route::post('send-code', 'UserController@sendCode');
            Route::post('bind-mobile', 'UserController@bindMobile');
            Route::get('info', 'UserController@info');

            Route::apiResource('sign', 'SignController');
        });
    });
    Route::middleware('auth:api')->group(function () {
        Route::apiResource('user-address', 'UserAddressController');

        Route::prefix('user-real-name')->group(function () {
            Route::get('', 'UserRealNameController@show');
            Route::post('', 'UserRealNameController@store');
            Route::put('', 'UserRealNameController@update');
            Route::delete('', 'UserRealNameController@destroy');
            Route::post('confirm', 'UserRealNameController@confirm');
            Route::get('cancel', 'UserRealNameController@cancel');
        });
        //Route::apiResource('user-real-name', 'UserRealNameController');
    });

    Route::get('test', function(\App\Services\EsignService $service) {
        $user = \App\Models\User::find(1);
        $contract = \App\Models\Contract::find(4);
        $sign = $contract->sign()->where('userid', $user->id)->first();
        $signImageData = base64_encode(Storage::disk('uploads')->get($sign->thumb));
        //$signImageData = substr($signImageData, strpos($signImageData, ',') + 1);
        $data = [
            'accountid' => $user->esignUser->accountid,
            'signFile' => [
                'srcPdfFile' => base_path('public/uploads/pdf/source/4.pdf'),
                'dstPdfFile' => base_path('public/uploads/pdf/output/4.pdf'),
                //'fileName' => '',
                //'ownerPassword' => '',
            ],
            'signPos' => [
                //'posPage' => '',

                // 甲
                //'posX' => '80',
                //'posY' => '10',
                //'key' => '甲方签章',
                //'width' => '100',
                // 乙
                'posX' => '80',
                'posY' => '10',
                'key' => '乙方签章',
                'width' => '100',

                //'cacellingSign' => '',
                //'isQrcodeSign' => '',
                //'addSignTime' => '',
            ],
            'signType' => 'Key',
            'sealData' => $signImageData,
            'stream' => true,
        ];
        info(__METHOD__, $data);
        $serviceid = $service->userSign($data);
        info(__METHOD__, ['serviceid' => $serviceid]);
        return $serviceid;
        //$contract = \App\Models\Contract::find(4);
        //$contractService = $contractService->makePdf($contract);
        //$contract = \App\Models\Contract::find(4);
        //$content = $contract->content->getAttribute('content');
        //unset($contract->content);
        //$contract->content = $content;
        //
        ////return PDF::loadView('api.contract.show', compact('contract'))->setPaper('a4')->setOption('margin-bottom', 0)->download('1.pdf');
        //$pdf = PDF::loadView('api.contract.show', compact('contract'));
        //return $pdf->download('1.pdf');
        //return view('api.contract.show', compact('contract'));
    });
});