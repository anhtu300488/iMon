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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => ['auth']], function() {

    Route::get('home', ['as' => 'home', 'uses' => 'Admin\HomeController@index']);

    Route::get('basic/logPayment', ['as' => 'basic.logPayment', 'uses' => 'Admin\Basic\LogPaymentController@index'] );

    Route::get('basic/purchaseMoneyLog', ['as' => 'basic.purchaseMoneyLog', 'uses' => 'Admin\Basic\PurchaseMoneyLogController@index']);

    Route::get('basic/topUser', ['as' => 'basic.topUser', 'uses' => 'Admin\Basic\TopUserController@index']);

    Route::get('basic/userReg', ['as' => 'basic.userReg', 'uses' => 'Admin\Basic\UserRegisterController@index']);

    Route::get('basic/exchangeAssetRequest', ['as' => 'basic.exchangeAssetRequest', 'uses' => 'Admin\Basic\ExchangeAssetRequestController@index']);

    Route::get('basic/history', ['as' => 'basic.history', 'uses' => 'Admin\Basic\HistoryController@index']);

    Route::get('basic/kenHistory', ['as' => 'basic.kenHistory', 'uses' => 'Admin\Basic\KenHistoryController@index']);

    Route::get('basic/xunHistory', ['as' => 'basic.xuHistory', 'uses' => 'Admin\Basic\XuHistoryController@index']);

    Route::get('tool/addMoney', ['as' => 'tool.addMoney', 'uses' => 'Admin\Tool\AddMoneyController@index']);

    Route::get('tool/addMoney/create', ['as' => 'tool.addMoney.create', 'uses' => 'Admin\Tool\AddMoneyController@create']);

    Route::post('tool/addMoney/create',['as'=>'tool.addMoney.store','uses'=>'Admin\Tool\AddMoneyController@store']);

    Route::get('tool/topGame', ['as' => 'tool.topGame', 'uses' => 'Admin\Tool\TopGameController@index']);

    Route::get('tool/userInfo', ['as' => 'tool.userInfo', 'uses' => 'Admin\Tool\UserInfoController@index']);

    Route::get('tool/createAdmin', ['as' => 'tool.createAdmin', 'uses' => 'Admin\Tool\CreateAdminController@index']);

    Route::get('tool/createAdmin/create', ['as' => 'tool.createAdmin.create', 'uses' => 'Admin\Tool\CreateAdminController@create', 'middleware' => ['permission:administrator']]);

    Route::post('tool/createAdmin/create',['as'=>'tool.createAdmin.store','uses'=>'Admin\Tool\CreateAdminController@store','middleware' => ['permission:administrator']]);

    Route::get('tool/serverMessage', ['as' => 'tool.serverMessage', 'uses' => 'Admin\Tool\ServerMessageController@index']);

    Route::get('tool/serverMessage/create', ['as' => 'tool.serverMessage.create', 'uses' => 'Admin\Tool\ServerMessageController@create']);

    Route::post('tool/serverMessage/create',['as'=>'tool.serverMessage.store','uses'=>'Admin\Tool\ServerMessageController@store']);

    Route::get('tool/sendEmail/create', ['as' => 'tool.sendEmail.create', 'uses' => 'Admin\Tool\SendEmailController@create']);

    Route::post('tool/sendEmail/create', ['as' => 'tool.sendEmail.store', 'uses' => 'Admin\Tool\SendEmailController@store']);

    Route::get('tool/giftCode', ['as' => 'tool.giftCode', 'uses' => 'Admin\Tool\GiftCodeController@index']);

    Route::get('revenue/rechargeTransaction', ['as' => 'revenue.rechargeTransaction', 'uses' => 'Admin\Revenue\RechargeTransactionController@index']);

    Route::get('revenue/revenueDay', ['as' => 'revenue.revenueDay', 'uses' => 'Admin\Revenue\RevenueDayController@index']);

    Route::get('revenue/userOnline', ['as' => 'revenue.userOnline', 'uses' => 'Admin\Revenue\UserOnlineController@index']);

    Route::get('revenue/ccu', ['as' => 'revenue.ccu', 'uses' => 'Admin\Revenue\CCUController@index']);

    Route::get('revenue/exchangeRequest', ['as' => 'revenue.exchangeRequest', 'uses' => 'Admin\Revenue\ExchangeRequestController@index']);

    Route::get('revenue/detailSmsHistory', ['as' => 'revenue.detailSmsHistory', 'uses' => 'Admin\Revenue\SmsHistoryRevenueController@index']);

    Route::get('revenue/moRevenue', ['as' => 'revenue.moRevenue', 'uses' => 'Admin\Revenue\MoRevenueController@index']);

    Route::get('revenue/smsRevenue', ['as' => 'revenue.smsRevenue', 'uses' => 'Admin\Revenue\SmsRevenueController@index']);

    Route::get('revenue/logPayment', ['as' => 'revenue.logPayment', 'uses' => 'Admin\Revenue\LogPaymentController@index']);

    Route::get('revenue/historyMoney', ['as' => 'revenue.historyMoney', 'uses' => 'Admin\Revenue\MoneyHistoryController@index']);

    Route::get('tool/roles',['as'=>'tool.roles','uses'=>'Admin\Tool\CreateRoleController@index']);
    Route::get('tool/roles/create',['as'=>'tool.roles.create','uses'=>'Admin\Tool\CreateRoleController@create']);
    Route::post('tool/roles/create',['as'=>'tool.roles.store','uses'=>'Admin\Tool\CreateRoleController@store']);
    Route::get('tool/roles/{id}/edit',['as'=>'tool.roles.edit','uses'=>'Admin\Tool\CreateRoleController@edit']);
    Route::patch('tool/roles/{id}',['as'=>'tool.roles.update','uses'=>'Admin\Tool\CreateRoleController@update']);
    Route::delete('tool/roles/{id}',['as'=>'tool.roles.destroy','uses'=>'Admin\Tool\CreateRoleController@destroy']);

    Route::get('tool/lockUser', ['as' => 'tool.lockUser', 'uses' => 'Admin\Tool\LockUserController@lock']);

    Route::post('tool/lockUser', ['as' => 'tool.lockUser.store', 'uses' => 'Admin\Tool\LockUserController@store']);

    Route::get('tool/unlockUser', ['as' => 'tool.unlockUser', 'uses' => 'Admin\Tool\UnlockUserController@unlock']);

    Route::post('tool/unlockUser', ['as' => 'tool.unlockUser.store', 'uses' => 'Admin\Tool\UnlockUserController@store']);

    Route::get('tool/emailUpdate', ['as' => 'tool.emailUpdate', 'uses' => 'Admin\Tool\EmailUpdateController@email']);

    Route::post('tool/emailUpdate', ['as' => 'tool.emailUpdate.store', 'uses' => 'Admin\Tool\EmailUpdateController@store']);

    Route::get('tool/phoneUpdate', ['as' => 'tool.phoneUpdate', 'uses' => 'Admin\Tool\PhoneUpdateController@phone']);

    Route::post('tool/phoneUpdate', ['as' => 'tool.phoneUpdate.store', 'uses' => 'Admin\Tool\PhoneUpdateController@store']);

    Route::get('system/ipLock', ['as' => 'system.ipLock', 'uses' => 'Admin\System\LockIpController@index']);

    Route::post('system/ipLock', ['as' => 'system.ipLock.store', 'uses' => 'Admin\System\LockIpController@store']);

    //users management
    Route::get('users/userReg', ['as' => 'users.userReg', 'uses' => 'Admin\Users\UserRegisterController@index']);

    Route::get('users/userInfo', ['as' => 'users.userInfo', 'uses' => 'Admin\Users\UserInfoController@index']);

    Route::get('users/otp', ['as' => 'users.otp', 'uses' => 'Admin\Users\OtpController@index']);

    Route::get('users/autoOtp', ['as' => 'users.autoOtp', 'uses' => 'Admin\Users\OtpAutoController@index']);

    Route::get('users/logUserLogin', ['as' => 'users.logUserLogin', 'uses' => 'Admin\Users\LogUserLoginController@index']);

    //notification
    Route::resource('game/emergencyNotification','Admin\Game\NotificationController');

    //game mangement
    Route::get('game/manageGame', ['as' => 'game.manageGame', 'uses' => 'Admin\Game\GameController@index']);

    Route::get('game/matchLog', ['as' => 'game.matchLog', 'uses' => 'Admin\Game\MatchLogController@index']);

    //room
    Route::resource('game/room','Admin\Game\RoomController');

    //lucky wheel
    Route::get('game/logLuckyWheel', ['as' => 'game.logLuckyWheel', 'uses' => 'Admin\Game\LuckyWheelController@log']);
    Route::get('game/itemLuckyWheel', ['as' => 'game.itemLuckyWheel', 'uses' => 'Admin\Game\LuckyWheelController@item']);
    Route::get('game/chanceLuckyWheel', ['as' => 'game.chanceLuckyWheel', 'uses' => 'Admin\Game\LuckyWheelController@chance']);

    //mini poker

    Route::get('moneyGame/cardProvider', ['as' => 'moneyGame.cardProvider', 'uses' => 'Admin\MoneyGame\CardProviderController@index']);

    //giftcode
    Route::resource('moneyGame/giftCode','Admin\MoneyGame\GiftCodeController');

    //giftevent
    Route::resource('moneyGame/eventGift','Admin\MoneyGame\GiftEventController');

    //purchase money
    Route::resource('moneyGame/purchaseMoney','Admin\MoneyGame\PurchaseMoneyController');

    //add money
    Route::resource('moneyGame/addMoney','Admin\MoneyGame\AddMoneyController');

    //link download
    Route::resource('others/linkDownload','Admin\Others\LinkDownloadController');

    //log web
    Route::resource('others/logWeb','Admin\Others\LogWebController');

    //message user
    Route::resource('others/messageUser','Admin\Others\MessageController');

    //notification
    Route::resource('others/notification','Admin\Others\NotificationController');

    //notify
    Route::resource('others/notify','Admin\Others\NotifyController');

    //OS
    Route::resource('others/clientType','Admin\Others\ClientTypeController');

    //partner
    Route::resource('others/partner','Admin\Others\PartnerController');

    //telco
    Route::resource('others/provider','Admin\Others\ProviderController');

    //test case
    Route::resource('others/testCase','Admin\Others\TestCaseController');

    //web content
    Route::resource('others/webContent','Admin\Others\WebContentController');
});
