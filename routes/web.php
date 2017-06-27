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

    Route::get('profile', ['as' => 'profile', 'uses' => 'Admin\AuthController@profile']);

    Route::get('password.change', ['as' => 'password.change', 'uses' => 'Admin\AuthController@changePassword']);

    Route::post('password.postCredentials', ['as' => 'password.postCredentials', 'uses' => 'Admin\AuthController@postCredentials']);

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

    Route::resource('tool/createAdmin', 'Admin\Tool\CreateAdminController');

//    Route::get('tool/createAdmin', ['as' => 'tool.createAdmin', 'uses' => 'Admin\Tool\CreateAdminController@index']);
//
//    Route::get('tool/createAdmin/create', ['as' => 'tool.createAdmin.create', 'uses' => 'Admin\Tool\CreateAdminController@create', 'middleware' => ['permission:administrator']]);
//
//    Route::post('tool/createAdmin/create',['as'=>'tool.createAdmin.store','uses'=>'Admin\Tool\CreateAdminController@store','middleware' => ['permission:administrator']]);

    Route::get('tool/serverMessage', ['as' => 'tool.serverMessage', 'uses' => 'Admin\Tool\ServerMessageController@index']);

    Route::get('tool/serverMessage/create', ['as' => 'tool.serverMessage.create', 'uses' => 'Admin\Tool\ServerMessageController@create']);

    Route::post('tool/serverMessage/create',['as'=>'tool.serverMessage.store','uses'=>'Admin\Tool\ServerMessageController@store']);

    Route::get('tool/sendEmail/create', ['as' => 'tool.sendEmail.create', 'uses' => 'Admin\Tool\SendEmailController@create']);

    Route::post('tool/sendEmail/create', ['as' => 'tool.sendEmail.store', 'uses' => 'Admin\Tool\SendEmailController@store']);

    Route::get('tool/giftCode', ['as' => 'tool.giftCode', 'uses' => 'Admin\Tool\GiftCodeController@index']);

    Route::get('revenue/rechargeTransaction', ['as' => 'revenue.rechargeTransaction', 'uses' => 'Admin\Revenue\RechargeTransactionController@index']);

    Route::get('revenue/rechargeTransaction/xlsx', ['as' => 'rechargeTransaction.excel', 'uses' => 'Admin\Revenue\RechargeTransactionController@downloadExcel']);

    Route::get('revenue/revenueDay', ['as' => 'revenue.revenueDay', 'uses' => 'Admin\Revenue\RevenueDayController@index']);

    Route::get('revenue/revenueDay/statistic/{fromDate}/{toDate}', ['as' => 'revenue.revenueDay.statistic', 'uses' => 'Admin\Revenue\RevenueDayController@statistic']);

    Route::get('revenue/revenueUserCharge', ['as' => 'revenue.revenueUserCharge', 'uses' => 'Admin\Revenue\RevenueUserChargeController@index']);

    Route::get('revenue/userOnline', ['as' => 'revenue.userOnline', 'uses' => 'Admin\Revenue\UserOnlineController@index']);

    Route::get('revenue/ccu', ['as' => 'revenue.ccu', 'uses' => 'Admin\Revenue\CCUController@index']);

    Route::get('revenue/ccu/statistic/{fromDate}', ['as' => 'revenue.ccu.statistic', 'uses' => 'Admin\Revenue\CCUController@statistic']);

    Route::get('revenue/wasteMoney', ['as' => 'revenue.wasteMoney', 'uses' => 'Admin\Revenue\WasteMoneyController@index']);

    Route::get('revenue/wasteMoney/xlsx', ['as' => 'wasteMoney.excel', 'uses' => 'Admin\Revenue\WasteMoneyController@downloadExcel'] );

    Route::get('revenue/exchangeRequest', ['as' => 'revenue.exchangeRequest', 'uses' => 'Admin\Revenue\ExchangeRequestController@index']);

    Route::patch('revenue/exchangeRequest/{id}', ['as' => 'exchangeRequest.update', 'uses' => 'Admin\Revenue\ExchangeRequestController@update']);

    Route::post('revenue/exchangeRequest/delete', ['as' => 'exchangeRequest.delete', 'uses' => 'Admin\Revenue\ExchangeRequestController@delete']);

    Route::get('revenue/exchangeRequest/getMatchLog/{id}', ['as' => 'exchangeRequest.getMatchLog', 'uses' => 'Admin\Revenue\ExchangeRequestController@getMatchLog']);

    Route::get('revenue/exchangeRequest/xlsx', ['as' => 'exchangeRequest.excel', 'uses' => 'Admin\Revenue\ExchangeRequestController@downloadExcel']);

    Route::get('revenue/cashOut', ['as' => 'revenue.cashOut', 'uses' => 'Admin\Revenue\CashOutController@index']);

    Route::get('revenue/topCashOut', ['as' => 'revenue.topCashOut', 'uses' => 'Admin\Revenue\TopCashOutController@index']);

    Route::get('revenue/payCashOut', ['as' => 'revenue.payCashOut', 'uses' => 'Admin\Revenue\PayCashOutController@index']);

    Route::get('revenue/detailSmsHistory', ['as' => 'revenue.detailSmsHistory', 'uses' => 'Admin\Revenue\SmsHistoryRevenueController@index']);

    Route::get('revenue/moRevenue', ['as' => 'revenue.moRevenue', 'uses' => 'Admin\Revenue\MoRevenueController@index']);

    Route::get('revenue/smsRevenue', ['as' => 'revenue.smsRevenue', 'uses' => 'Admin\Revenue\SmsRevenueController@index']);

    Route::get('revenue/logPayment', ['as' => 'revenue.logPayment', 'uses' => 'Admin\Revenue\LogPaymentController@index']);

    Route::get('revenue/historyMoney', ['as' => 'revenue.historyMoney', 'uses' => 'Admin\Revenue\MoneyHistoryController@index']);

    Route::get('revenue/ccu', ['as' => 'revenue.ccu', 'uses' => 'Admin\Revenue\CCUController@index']);

    Route::get('revenue/revenueUserActive', ['as' => 'revenue.revenueUserActive', 'uses' => 'Admin\Revenue\RevenueUserActiveController@index']);

    Route::get('revenue/revenueUserPurchase', ['as' => 'revenue.revenueUserPurchase', 'uses' => 'Admin\Revenue\RevenueUserPurchaseController@index']);

    Route::get('tool/roles',['as'=>'tool.roles','uses'=>'Admin\Tool\CreateRoleController@index']);
    Route::get('tool/roles/create',['as'=>'tool.roles.create','uses'=>'Admin\Tool\CreateRoleController@create']);
    Route::post('tool/roles/create',['as'=>'tool.roles.store','uses'=>'Admin\Tool\CreateRoleController@store']);
    Route::get('tool/roles/{id}/edit',['as'=>'tool.roles.edit','uses'=>'Admin\Tool\CreateRoleController@edit']);
    Route::patch('tool/roles/{id}',['as'=>'tool.roles.update','uses'=>'Admin\Tool\CreateRoleController@update']);
    Route::delete('tool/roles/{id}',['as'=>'tool.roles.destroy','uses'=>'Admin\Tool\CreateRoleController@destroy']);

    Route::get('tool/emailUpdate', ['as' => 'tool.emailUpdate', 'uses' => 'Admin\Tool\EmailUpdateController@email']);

    Route::post('tool/emailUpdate', ['as' => 'tool.emailUpdate.store', 'uses' => 'Admin\Tool\EmailUpdateController@store']);

    Route::get('tool/phoneUpdate', ['as' => 'tool.phoneUpdate', 'uses' => 'Admin\Tool\PhoneUpdateController@phone']);

    Route::post('tool/phoneUpdate', ['as' => 'tool.phoneUpdate.store', 'uses' => 'Admin\Tool\PhoneUpdateController@store']);

    Route::resource('tool/crashTableAlarm','Admin\Tool\CrashTableAlarmController');

    Route::get('system/ipLock', ['as' => 'system.ipLock', 'uses' => 'Admin\System\LockIpController@index']);

    Route::post('system/ipLock', ['as' => 'system.ipLock.store', 'uses' => 'Admin\System\LockIpController@store']);

    Route::get('system/taixiu/create', ['as' => 'system.taixiu.create', 'uses' => 'Admin\System\TaiXiuController@create', 'middleware' => ['permission:administrator']]);

    Route::post('system/taixiu/create',['as'=>'system.taixiu.store','uses'=>'Admin\System\TaiXiuController@store','middleware' => ['permission:administrator']]);



    //users management
    Route::get('users/userReg', ['as' => 'users.userReg', 'uses' => 'Admin\Users\UserRegisterController@index']);

    Route::post('users/userReg/lockUser', ['as'=>'users.userReg.lockUser', 'uses'=>'Admin\Users\UserRegisterController@lockUser']);

    Route::post('users/userReg/unlockUser', ['as'=>'users.userReg.unlockUser', 'uses'=>'Admin\Users\UserRegisterController@unlockUser']);

    Route::post('users/userReg/resetUser', ['as'=>'users.userReg.resetUser', 'uses'=>'Admin\Users\UserRegisterController@resetUser']);

    Route::get('users/userReg/xlsx', ['as' => 'userReg.excel', 'uses' => 'Admin\Users\UserRegisterController@downloadExcel']);

    Route::get('users/userInfo', ['as' => 'users.userInfo', 'uses' => 'Admin\Users\UserInfoController@index']);

    Route::get('users/userRateActive', ['as' => 'users.userRateActive', 'uses' => 'Admin\Users\UserRateActiveController@index']);

    Route::get('users/otp', ['as' => 'users.otp', 'uses' => 'Admin\Users\OtpController@index']);

    Route::get('users/autoOtp', ['as' => 'users.autoOtp', 'uses' => 'Admin\Users\OtpAutoController@index']);

    Route::get('users/logUserLogin', ['as' => 'users.logUserLogin', 'uses' => 'Admin\Users\LogUserLoginController@index']);

    Route::get('users/logUserLogin/xlsx', ['as' => 'logUserLogin.excel', 'uses' => 'Admin\Users\LogUserLoginController@downloadExcel']);

    Route::get('users/topMoney', ['as' => 'users.topMoney', 'uses' => 'Admin\Users\TopMoneyController@index']);

    Route::get('users/topGame', ['as' => 'users.topGame', 'uses' => 'Admin\Users\TopGameController@index']);

    Route::get('users/userLock', ['as' => 'users.userLock', 'uses' => 'Admin\Users\UserLockController@index']);

    //notification
    Route::resource('game/emergencyNotification','Admin\Game\NotificationController');

    //game mangement
//    Route::get('game/manageGame', ['as' => 'game.manageGame', 'uses' => 'Admin\Game\GameController@index']);
    Route::resource('game/manageGame','Admin\Game\GameController');

    Route::get('game/matchLog', ['as' => 'game.matchLog', 'uses' => 'Admin\Game\MatchLogController@index']);

    //room
    Route::resource('game/room','Admin\Game\RoomController');

    //lucky wheel
    Route::get('game/logLuckyWheel', ['as' => 'game.logLuckyWheel', 'uses' => 'Admin\Game\LuckyWheelController@log']);
    Route::get('game/itemLuckyWheel', ['as' => 'game.itemLuckyWheel', 'uses' => 'Admin\Game\LuckyWheelController@item']);
    Route::get('game/chanceLuckyWheel', ['as' => 'game.chanceLuckyWheel', 'uses' => 'Admin\Game\LuckyWheelController@chance']);

    //mini poker
    Route::get('game/miniPoker', ['as' => 'game.miniPoker', 'uses' => 'Admin\Game\MiniPokerLogController@log']);
    Route::get('game/rateMiniPoker', ['as' => 'game.rateMiniPoker', 'uses' => 'Admin\Game\MiniPokerLogController@rate']);

    //Xoc dia
    Route::get('game/xocDia', ['as' => 'game.xocDia', 'uses' => 'Admin\Game\XocdiaController@index']);
    //tai xiu
    Route::get('game/taiXiu', ['as' => 'game.taiXiu', 'uses' => 'Admin\Game\TaiXiuController@index']);
    //lieng
    Route::get('game/lieng', ['as' => 'game.lieng', 'uses' => 'Admin\Game\LiengController@index']);
    //xito
    Route::get('game/xito', ['as' => 'game.xito', 'uses' => 'Admin\Game\XiToController@index']);
    //TLMN
    Route::get('game/tlmn', ['as' => 'game.tlmn', 'uses' => 'Admin\Game\TLMNController@index']);
    //TLMN solo
    Route::get('game/tlmnsolo', ['as' => 'game.tlmnsolo', 'uses' => 'Admin\Game\TLMNSoloController@index']);
    //Mau Binh
    Route::get('game/maubinh', ['as' => 'game.maubinh', 'uses' => 'Admin\Game\MauBinhController@index']);
    //Phom
    Route::get('game/phom', ['as' => 'game.phom', 'uses' => 'Admin\Game\PhomController@index']);
    //Bacay
    Route::get('game/bacay', ['as' => 'game.bacay', 'uses' => 'Admin\Game\BaCayController@index']);

    Route::get('moneyGame/cardProvider', ['as' => 'moneyGame.cardProvider', 'uses' => 'Admin\MoneyGame\CardProviderController@index']);

    //giftcode
    Route::resource('moneyGame/giftCode','Admin\MoneyGame\GiftCodeController');

    //giftevent
    Route::resource('moneyGame/eventGift','Admin\MoneyGame\GiftEventController');

    //purchase money
    Route::resource('moneyGame/purchaseMoney','Admin\MoneyGame\PurchaseMoneyController');

    //purchase money error
    Route::resource('moneyGame/errorPurchaseMoney','Admin\MoneyGame\PurchaseMoneyErrorController');
    Route::post('moneyGame/errorPurchaseMoney/purchaseMoney','Admin\MoneyGame\PurchaseMoneyErrorController@purchaseMoney');

    //add money
    Route::resource('moneyGame/addMoney','Admin\MoneyGame\AddMoneyController');

    //income
    Route::get('moneyGame/income', ['as' => 'income.index', 'uses' => 'Admin\MoneyGame\IncomeMoneyController@index']);

    Route::get('moneyGame/income/xlsx',['as' => 'income.excel', 'uses' => 'Admin\MoneyGame\IncomeMoneyController@downloadExcel']);

    //circulation
    Route::resource('moneyGame/circulation','Admin\MoneyGame\CirculationMoneyController');

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

    //Check username exists via userid
    Route::get('checkUser', [
        'uses' => 'Admin\CheckUserController@checkUser',
        'as' => 'checkUser',
    ]);
});
