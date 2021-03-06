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

    Route::get('profile', ['as' => 'profile', 'uẽses' => 'Admin\AuthController@profile']);

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

    Route::get('tool/addMoney', ['as' => 'tool.addMoney', 'uses' => 'Admin\Tool\AddMoneyController@index','middleware' => ['permission:administrator']]);

    Route::get('tool/addMoney/create', ['as' => 'tool.addMoney.create', 'uses' => 'Admin\Tool\AddMoneyController@create','middleware' => ['permission:administrator']]);

    Route::post('tool/addMoney/create',['as'=>'tool.addMoney.store','uses'=>'Admin\Tool\AddMoneyController@store','middleware' => ['permission:administrator']]);

    Route::get('tool/topGame', ['as' => 'tool.topGame', 'uses' => 'Admin\Tool\TopGameController@index']);

    Route::get('tool/userInfo', ['as' => 'tool.userInfo', 'uses' => 'Admin\Tool\UserInfoController@index']);

//    Route::resource('tool/createAdmin', ['uses' => 'Admin\Tool\CreateAdminController','middleware' => ['permission:administrator']]);

    Route::get('tool/createAdmin', ['as' => 'createAdmin.index', 'uses' => 'Admin\Tool\CreateAdminController@index','middleware' => ['permission:administrator']]);

    Route::get('tool/createAdmin/create', ['as' => 'createAdmin.create', 'uses' => 'Admin\Tool\CreateAdminController@create', 'middleware' => ['permission:administrator']]);

    Route::post('tool/createAdmin/create',['as'=>'createAdmin.store','uses'=>'Admin\Tool\CreateAdminController@store','middleware' => ['permission:administrator']]);

    Route::get('tool/createAdmin/{id}/edit',['as'=>'createAdmin.edit','uses'=>'Admin\Tool\CreateAdminController@edit','middleware' => ['permission:administrator']]);
    Route::patch('tool/createAdmin/{id}',['as'=>'createAdmin.update','uses'=>'Admin\Tool\CreateAdminController@update','middleware' => ['permission:administrator']]);
    Route::delete('tool/createAdmin/{id}',['as'=>'createAdmin.destroy','uses'=>'Admin\Tool\CreateAdminController@destroy','middleware' => ['permission:administrator']]);

    Route::get('tool/serverMessage', ['as' => 'tool.serverMessage', 'uses' => 'Admin\Tool\ServerMessageController@index']);

    Route::get('tool/serverMessage/create', ['as' => 'tool.serverMessage.create', 'uses' => 'Admin\Tool\ServerMessageController@create']);

    Route::post('tool/serverMessage/create',['as'=>'tool.serverMessage.store','uses'=>'Admin\Tool\ServerMessageController@store']);

    Route::get('tool/sendEmail/create', ['as' => 'tool.sendEmail.create', 'uses' => 'Admin\Tool\SendEmailController@create']);

    Route::post('tool/sendEmail/create', ['as' => 'tool.sendEmail.store', 'uses' => 'Admin\Tool\SendEmailController@store']);

    Route::get('tool/giftCode', ['as' => 'tool.giftCode', 'uses' => 'Admin\Tool\GiftCodeController@index']);
    Route::get('tool/payment', ['as' => 'tool.payment', 'uses' => 'Admin\Tool\PaymentController@index']);
    Route::get('tool/payment/{id}/edit', ['as' => 'tool.payment.edit', 'uses' => 'Admin\Tool\PaymentController@edit', 'middleware' => ['permission:administrator']]);
    Route::patch('tool/payment/{id}', ['as' => 'cp.update', 'uses' => 'Admin\Tool\PaymentController@update']);

    Route::get('revenue/rechargeTransaction', ['as' => 'revenue.rechargeTransaction', 'uses' => 'Admin\Revenue\RechargeTransactionController@index']);

    Route::get('revenue/rechargeTransaction/xlsx', ['as' => 'rechargeTransaction.excel', 'uses' => 'Admin\Revenue\RechargeTransactionController@downloadExcel']);

    Route::get('revenue/revenueDay', ['as' => 'revenue.revenueDay', 'uses' => 'Admin\Revenue\RevenueDayController@index']);

    Route::get('revenue/revenueDay/statistic/{fromDate}/{toDate}/{partner}', ['as' => 'revenue.revenueDay.statistic', 'uses' => 'Admin\Revenue\RevenueDayController@statistic']);

    Route::get('revenue/revenueUserCharge', ['as' => 'revenue.revenueUserCharge', 'uses' => 'Admin\Revenue\RevenueUserChargeController@index']);

    Route::get('revenue/userOnline', ['as' => 'revenue.userOnline', 'uses' => 'Admin\Revenue\UserOnlineController@index']);

    Route::get('revenue/ccu', ['as' => 'revenue.ccu', 'uses' => 'Admin\Revenue\CCUController@index']);

    Route::get('revenue/ccu/statistic/{gameId}/{partner}', ['as' => 'revenue.ccu.statistic', 'uses' => 'Admin\Revenue\CCUController@statistic']);

    Route::get('revenue/wasteMoney', ['as' => 'revenue.wasteMoney', 'uses' => 'Admin\Revenue\WasteMoneyController@index']);

    Route::get('revenue/wasteMoney/xlsx', ['as' => 'wasteMoney.excel', 'uses' => 'Admin\Revenue\WasteMoneyController@downloadExcel'] );

    Route::get('revenue/exchangeRequest', ['as' => 'revenue.exchangeRequest', 'uses' => 'Admin\Revenue\ExchangeRequestController@index']);

    Route::patch('revenue/exchangeRequest/{id}', ['as' => 'exchangeRequest.update', 'uses' => 'Admin\Revenue\ExchangeRequestController@update']);

    Route::post('revenue/exchangeRequest/delete', ['as' => 'exchangeRequest.delete', 'uses' => 'Admin\Revenue\ExchangeRequestController@delete']);

    Route::get('revenue/exchangeRequest/getMatchLog/{id}', ['as' => 'exchangeRequest.getMatchLog', 'uses' => 'Admin\Revenue\ExchangeRequestController@getMatchLog']);

    Route::get('revenue/rechargeTransaction/getMoneyLog/{id}', ['as' => 'rechargeTransaction.getMoneyLog', 'uses' => 'Admin\Revenue\RechargeTransactionController@getMoneyLog']);

    Route::get('revenue/exchangeRequest/getMoneyExchange/{id}', ['as' => 'exchangeRequest.getMoneyExchange', 'uses' => 'Admin\Revenue\ExchangeRequestController@getMoneyExchange']);

    Route::get('revenue/exchangeRequest/getMoneyTransfer/{id}', ['as' => 'exchangeRequest.getMoneyTransfer', 'uses' => 'Admin\Revenue\ExchangeRequestController@getMoneyTransfer']);

    Route::get('revenue/exchangeRequest/getMoneyReceived/{id}', ['as' => 'exchangeRequest.getMoneyReceived', 'uses' => 'Admin\Revenue\ExchangeRequestController@getMoneyReceived']);

    Route::get('revenue/exchangeRequest/xlsx', ['as' => 'exchangeRequest.excel', 'uses' => 'Admin\Revenue\ExchangeRequestController@downloadExcel']);

    Route::get('revenue/cashOut', ['as' => 'revenue.cashOut', 'uses' => 'Admin\Revenue\CashOutController@index']);

    Route::get('revenue/topCashOut', ['as' => 'revenue.topCashOut', 'uses' => 'Admin\Revenue\TopCashOutController@index']);
    Route::get('revenue/topCharging', ['as' => 'revenue.topCharging', 'uses' => 'Admin\Revenue\TopChargingController@index']);

    Route::get('revenue/payCashOut', ['as' => 'revenue.payCashOut', 'uses' => 'Admin\Revenue\PayCashOutController@index']);

    Route::get('revenue/vip', ['as' => 'revenue.vip', 'uses' => 'Admin\Revenue\VipController@index']);

    Route::get('revenue/vip/xlsx', ['as' => 'vip.excel', 'uses' => 'Admin\Revenue\VipController@downloadExcel']);
    Route::get('revenue/logPayment/xlsx', ['as' => 'logPayment.excel', 'uses' => 'Admin\Revenue\LogPaymentController@downloadExcel']);
    Route::get('revenue/historyMoney/xlsx', ['as' => 'historyMoney.excel', 'uses' => 'Admin\Revenue\MoneyHistoryController@downloadExcel']);

    Route::get('revenue/detailSmsHistory', ['as' => 'revenue.detailSmsHistory', 'uses' => 'Admin\Revenue\SmsHistoryRevenueController@index']);

    Route::get('revenue/moRevenue', ['as' => 'revenue.moRevenue', 'uses' => 'Admin\Revenue\MoRevenueController@index']);

    Route::get('revenue/smsRevenue', ['as' => 'revenue.smsRevenue', 'uses' => 'Admin\Revenue\SmsRevenueController@index']);

    Route::get('revenue/logPayment', ['as' => 'revenue.logPayment', 'uses' => 'Admin\Revenue\LogPaymentController@index']);

    Route::get('revenue/historyMoney', ['as' => 'revenue.historyMoney', 'uses' => 'Admin\Revenue\MoneyHistoryController@index']);

    Route::get('revenue/ccu', ['as' => 'revenue.ccu', 'uses' => 'Admin\Revenue\CCUController@index']);

    Route::get('revenue/revenueUserActive', ['as' => 'revenue.revenueUserActive', 'uses' => 'Admin\Revenue\RevenueUserActiveController@index']);

    Route::get('revenue/revenueUserPurchase', ['as' => 'revenue.revenueUserPurchase', 'uses' => 'Admin\Revenue\RevenueUserPurchaseController@index']);

    Route::get('tool/roles',['as'=>'tool.roles','uses'=>'Admin\Tool\CreateRoleController@index','middleware' => ['permission:administrator']]);
    Route::get('tool/roles/create',['as'=>'tool.roles.create','uses'=>'Admin\Tool\CreateRoleController@create','middleware' => ['permission:administrator']]);
    Route::post('tool/roles/create',['as'=>'tool.roles.store','uses'=>'Admin\Tool\CreateRoleController@store','middleware' => ['permission:administrator']]);
    Route::get('tool/roles/{id}/edit',['as'=>'tool.roles.edit','uses'=>'Admin\Tool\CreateRoleController@edit','middleware' => ['permission:administrator']]);
    Route::patch('tool/roles/{id}',['as'=>'tool.roles.update','uses'=>'Admin\Tool\CreateRoleController@update','middleware' => ['permission:administrator']]);
    Route::delete('tool/roles/{id}',['as'=>'tool.roles.destroy','uses'=>'Admin\Tool\CreateRoleController@destroy','middleware' => ['permission:administrator']]);

    Route::get('tool/emailUpdate', ['as' => 'tool.emailUpdate', 'uses' => 'Admin\Tool\EmailUpdateController@email']);

    Route::post('tool/emailUpdate', ['as' => 'tool.emailUpdate.store', 'uses' => 'Admin\Tool\EmailUpdateController@store']);

    Route::get('tool/phoneUpdate', ['as' => 'tool.phoneUpdate', 'uses' => 'Admin\Tool\PhoneUpdateController@phone']);

    Route::post('tool/phoneUpdate', ['as' => 'tool.phoneUpdate.store', 'uses' => 'Admin\Tool\PhoneUpdateController@store']);

    Route::resource('tool/crashTableAlarm','Admin\Tool\CrashTableAlarmController');

    Route::get('system/ipLock', ['as' => 'system.ipLock', 'uses' => 'Admin\System\LockIpController@index','middleware' => ['permission:administrator']]);

    Route::post('system/ipLock', ['as' => 'system.ipLock.store', 'uses' => 'Admin\System\LockIpController@store','middleware' => ['permission:administrator']]);

    Route::get('system/taixiu/create', ['as' => 'system.taixiu.create', 'uses' => 'Admin\System\TaiXiuController@create', 'middleware' => ['permission:administrator|admin']]);

    Route::post('system/taixiu/create',['as'=>'system.taixiu.store','uses'=>'Admin\System\TaiXiuController@store','middleware' => ['permission:administrator|admin']]);



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
    Route::get('game/poker', ['as' => 'game.poker', 'uses' => 'Admin\Game\PokerLogController@log']);

    Route::get('moneyGame/cardProvider', ['as' => 'moneyGame.cardProvider', 'uses' => 'Admin\MoneyGame\CardProviderController@index']);

    //giftcode
//    Route::resource('moneyGame/giftCode','Admin\MoneyGame\GiftCodeController');
    Route::get('moneyGame/giftCode',['as'=>'giftCode.index','uses'=>'Admin\MoneyGame\GiftCodeController@index','middleware' => ['permission:administrator|admin']]);
    Route::get('moneyGame/giftCode/create',['as'=>'giftCode.create','uses'=>'Admin\MoneyGame\GiftCodeController@create','middleware' => ['permission:administrator|admin']]);
    Route::post('moneyGame/giftCode/create',['as'=>'giftCode.store','uses'=>'Admin\MoneyGame\GiftCodeController@store','middleware' => ['permission:administrator|admin']]);
    Route::get('moneyGame/giftCode/{id}/edit',['as'=>'giftCode.edit','uses'=>'Admin\MoneyGame\GiftCodeController@edit','middleware' => ['permission:administrator|admin']]);
    Route::patch('moneyGame/giftCode/{id}',['as'=>'giftCode.update','uses'=>'Admin\MoneyGame\GiftCodeController@update','middleware' => ['permission:administrator|admin']]);
    Route::delete('moneyGame/giftCode/{id}',['as'=>'giftCode.destroy','uses'=>'Admin\MoneyGame\GiftCodeController@destroy','middleware' => ['permission:administrator|admin']]);
    Route::get('moneyGame/giftCode/multi',['as'=>'giftCode.multi','uses'=>'Admin\MoneyGame\GiftCodeController@multi','middleware' => ['permission:administrator|admin']]);
    Route::post('moneyGame/giftCode/multi',['as'=>'giftCode.multiStore','uses'=>'Admin\MoneyGame\GiftCodeController@multiStore','middleware' => ['permission:administrator|admin']]);

    //giftevent
    Route::resource('moneyGame/eventGift','Admin\MoneyGame\GiftEventController');

    //purchase money
//    Route::resource('moneyGame/purchaseMoney','Admin\MoneyGame\PurchaseMoneyController');

    Route::get('moneyGame/purchaseMoney',['as'=>'purchaseMoney.index','uses'=>'Admin\MoneyGame\PurchaseMoneyController@index','middleware' => ['permission:administrator|admin']]);
    Route::get('moneyGame/purchaseMoney/create',['as'=>'purchaseMoney.create','uses'=>'Admin\MoneyGame\PurchaseMoneyController@create','middleware' => ['permission:administrator|admin']]);
    Route::post('moneyGame/purchaseMoney/create',['as'=>'purchaseMoney.store','uses'=>'Admin\MoneyGame\PurchaseMoneyController@store','middleware' => ['permission:administrator|admin']]);
    Route::get('moneyGame/purchaseMoney/{id}/edit',['as'=>'purchaseMoney.edit','uses'=>'Admin\MoneyGame\PurchaseMoneyController@edit','middleware' => ['permission:administrator|admin']]);
    Route::patch('moneyGame/purchaseMoney/{id}',['as'=>'purchaseMoney.update','uses'=>'Admin\MoneyGame\PurchaseMoneyController@update','middleware' => ['permission:administrator|admin']]);
    Route::delete('moneyGame/purchaseMoney/{id}',['as'=>'purchaseMoney.destroy','uses'=>'Admin\MoneyGame\PurchaseMoneyController@destroy','middleware' => ['permission:administrator|admin']]);

    //purchase money error
    Route::resource('moneyGame/errorPurchaseMoney','Admin\MoneyGame\PurchaseMoneyErrorController');
    Route::post('moneyGame/errorPurchaseMoney/purchaseMoney','Admin\MoneyGame\PurchaseMoneyErrorController@purchaseMoney');

    //add money
//    Route::resource('moneyGame/addMoney', ['uses' => 'Admin\MoneyGame\AddMoneyController','middleware' => ['permission:administrator']]);

    Route::get('moneyGame/addMoney',['as'=>'addMoney.index','uses'=>'Admin\MoneyGame\AddMoneyController@index','middleware' => ['permission:administrator|admin']]);
    Route::get('moneyGame/addMoney/create',['as'=>'addMoney.create','uses'=>'Admin\MoneyGame\AddMoneyController@create','middleware' => ['permission:administrator|admin']]);
    Route::post('moneyGame/addMoney/create',['as'=>'addMoney.store','uses'=>'Admin\MoneyGame\AddMoneyController@store','middleware' => ['permission:administrator|admin']]);


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
    // Route::patch('others/tip/{id}', ['as' => 'tool.tip.update', 'uses' => 'Admin\Tool\QuickTipController@update']);
    // Route::patch('others/tip/{id}', ['as' => 'tip.update', 'uses' => 'Admin\Tool\QuickTipController@update']);

    Route::resource('others/tip','Admin\Others\QuickTipController');


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

    //mail content
    Route::resource('others/mail','Admin\Others\MailController');

    //Check username exists via userid
    Route::get('checkUser', [
        'uses' => 'Admin\CheckUserController@checkUser',
        'as' => 'checkUser',
    ]);
    Route::get('gate/chargingAgent', ['as' => 'gate.chargingAgent', 'uses' => 'Admin\Gateway\ChargingAgentController@index']);
    Route::get('gate/chargingAgentLog', ['as' => 'gate.chargingAgentLog', 'uses' => 'Admin\Gateway\ChargingAgentlogController@index']);
    Route::get('gate/chargingError', ['as' => 'gate.chargingError', 'uses' => 'Admin\Gateway\ChargingErrorController@index']);
    Route::get('gate/chargingHistory', ['as' => 'gate.chargingHistory', 'uses' => 'Admin\Gateway\ChargingHistoryController@index']);
    Route::get('gate/chargingGWLog', ['as' => 'gate.chargingGWLog', 'uses' => 'Admin\Gateway\ChargingGWlogController@index']);
    Route::get('gate/smsThang', ['as' => 'gate.smsThang', 'uses' => 'Admin\Gateway\SmsThangController@index']);

//    Route::get('gate/chargingError','Admin\Gateway\ChargingErrorController');
//    Route::get('gate/chargingHistory','Admin\Gateway\ChargingHistoryController');
//    Route::get('gate/chargingAgent','Admin\Gateway\ChargingAgentController');
//    Route::get('gate/chargingGWLog','Admin\Gateway\ChargingGWlogController');

    //gateway
});
