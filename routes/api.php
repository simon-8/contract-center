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
    Route::apiResource('online-config', 'OnlineConfigController');

    Route::prefix('contract')->group(function () {
        Route::get('status', 'ContractController@getStatus');
        Route::get('status-count', 'ContractController@getStatusCount');
        Route::get('{contract}', 'ContractController@show')->where('contract', '\d+');
        Route::post('confirm/{contract}', 'ContractController@confirm');
        //Route::post('sign', 'ContractController@sign');
        Route::get('sign-company-info/{contract}', 'ContractController@signCompanyInfo');
        Route::get('my-count', 'ContractController@myCount');
    });

    Route::apiResource('contract', 'ContractController')
        ->middleware('auth:api')
        ->except('getStatus', 'getStatusCount', 'show');

    Route::get('contract-category/company', 'ContractCategoryController@company');
    Route::apiResource('contract-category', 'ContractCategoryController');
    Route::apiResource('contract-tpl', 'ContractTplController');
    //Route::apiResource('contract-template', 'ContractTemplateController');
    Route::apiResource('contract-file', 'ContractFileController');
    Route::apiResource('single-page', 'SinglePageController');

    //Route::apiResource('company/staff', 'CompanyStaffController');

    Route::prefix('order')->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::post('', 'OrderController@store');
            Route::post('repay/{orderid}', 'OrderController@reStore');
            Route::post('cancel/{orderid}', 'OrderController@cancel');
        });
        Route::any('notify/{channel}', 'OrderController@notify')->name('order.notify');
        Route::any('refund/{channel}', 'OrderController@refund')->name('order.refund');
    });

    Route::prefix('order-lawyer-confirm')->group(function() {
        Route::any('notify/{channel}', 'OrderLawyerConfirmController@notify')->name('orderLawyerConfirm.notify');
        Route::any('refund/{channel}', 'OrderLawyerConfirmController@refund')->name('orderLawyerConfirm.refund');
        Route::get('show-by-user', 'OrderLawyerConfirmController@showByUser')->middleware('auth:api');
    });
    Route::resource('order-lawyer-confirm', 'OrderLawyerConfirmController')
        ->middleware('auth:api')
        ->except('notify', 'refund');
/*    Route::prefix('order-lawyer-confirm')->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::get('', 'OrderLawyerConfirmController@show');
            Route::post('', 'OrderLawyerConfirmController@store');
            //Route::post('repay/{orderid}', 'OrderLawyerConfirmController@reStore');
            //Route::post('cancel/{orderid}', 'OrderLawyerConfirmController@cancel');
            //Route::get('query-express-fee', 'OrderLawyerConfirmController@queryExpressFee');
        });
        //Route::any('notify/{channel}', 'OrderLawyerConfirmController@notify')->name('orderLawyerConfirm.notify');
        //Route::any('refund/{channel}', 'OrderLawyerConfirmController@refund')->name('orderLawyerConfirm.refund');
    });*/

    Route::prefix('user')->group(function () {
        Route::group(['middleware' => 'auth:api'], function() {
            Route::post('send-code', 'UserController@sendCode');
            Route::post('bind-mobile', 'UserController@bindMobile');
            Route::get('info', 'UserController@info');

            Route::post('sign/confirm', 'SignController@confirm');
            Route::post('sign/send-verify-code', 'SignController@sendVerifyCode');
            Route::post('sign/verify-code', 'SignController@verifyCode');
            Route::apiResource('sign', 'SignController');

            Route::get('test', 'UserController@test');

            // 站内信
            Route::prefix('message')->group(function() {
                Route::get('', 'MessageController@index');
                Route::get('{message}', 'MessageController@show');
                Route::get('count/unread', 'MessageController@unreadCount');
                Route::put('{message}/read', 'MessageController@updateRead');
            });
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
        Route::prefix('company')->group(function() {
            //Route::get('', 'CompanyController@index');
            Route::post('', 'CompanyController@store');
            Route::put('', 'CompanyController@update');
            Route::delete('', 'CompanyController@destroy');
            Route::get('my', 'CompanyController@my');
            Route::get('my-join', 'CompanyController@myJoin');
            Route::get('search', 'CompanyController@search');
            Route::post('topay/{id}', 'CompanyController@toPay');
            Route::post('pay-amount-verify/{id}', 'CompanyController@payAmountVerify');
            Route::get('bank', 'CompanyController@bank');
            Route::get('sub-bank', 'CompanyController@subBank');
            Route::get('area', 'CompanyController@area');

            Route::post('send-code', 'UserController@sendCode');
            //Route::post('bind-mobile', 'UserController@bindMobile');
        });

        Route::prefix('company/staff')->group(function() {
            Route::get('', 'CompanyStaffController@index');
            Route::post('apply', 'CompanyStaffController@apply');
            Route::post('cancel', 'CompanyStaffController@cancel');
            Route::post('user-cancel', 'CompanyStaffController@userCancel');
            Route::post('confirm', 'CompanyStaffController@confirm');
            Route::post('refuse', 'CompanyStaffController@refuse');
            Route::get('status', 'CompanyStaffController@getStatus');
        });
        //Route::apiResource('user-real-name', 'UserRealNameController');
    });

    Route::post('company-order/notify/{pid}', 'CompanyOrderController@notify')->name('companyOrder.notify');

    //Route::get('test', function() {
    //    (new \App\Services\RealNameService())->teleComAuth([
    //        'mobile' => 17788561708,
    //        'name' => '刘文静',
    //        'idno' => '340811199110035318'
    //    ]);
    //});
    //Route::get('test/{id}', function($id) {
    //    $contract = \App\Models\Contract::find($id);
    //    $sections = json_decode($contract->content->tpl, true);
    //    $fill = json_decode($contract->content->fill, true);
    //    return view('api.contract.show', compact('contract', 'sections', 'fill'));
    //});

});
