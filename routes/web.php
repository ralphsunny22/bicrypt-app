<?php

use App\Http\Controllers\Admin\Ext\InstallController;
use App\Http\Controllers\Admin\ExtensionController;
use App\Http\Controllers\Admin\ManageExchangesController;
use App\Http\Controllers\Admin\PopupsController;
use App\Http\Controllers\Admin\Providers\ProviderInstallController;
use App\Http\Controllers\Admin\UpdateController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CronController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\RssfeedController;
use App\Http\Controllers\WatchlistController;
use Illuminate\Support\Facades\Route;

Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('cron', 'CronController@index')->name('cron');
Route::get('cron/practice', 'CronController@practiceCron')->name('practice.cron');
Route::get('cron/schedule', 'CronController@scheduledOrdersCron')->name('schedule.cron');
Route::get('cron/crypto/price', 'CronController@store')->name('crypt.price');
getRoute(1, 'cron');
getRoute(3, 'cron');
getRoute(4, 'cron');
getRoute(6, 'cron');
Route::get('cron/provider/currencies', 'CronController@currencies')->name('provider.currencies');
Route::get('cron/provider/currenciesToTable', 'CronController@currenciesToTable')->name('provider.currenciesToTable');
Route::get('cron/provider/marketsToTable', 'CronController@marketsToTable')->name('provider.marketsToTable');
Route::get('cron/provider/pairsToTable', 'CronController@pairsToTable')->name('provider.pairsToTable');
Route::get('cron/provider/check/deposit', 'CronController@fetch_deposits')->name('provider.checkdeposit');
Route::get('cron/provider/fetch/order', 'CronController@fetch_order')->name('provider.fetchorder');
Route::get('cron/provider/marketsClean', 'CronController@marketsClean')->name('provider.marketsClean');
Route::get('cron/check_update', 'CronController@check_update')->name('cron.check_update');

Route::get('/generate-qrcode', [QrCodeController::class, 'index']);

Route::namespace('Gateway')->prefix('ipn')->name('ipn.')->group(function () {
    Route::post('paypal', 'paypal\ProcessController@ipn')->name('paypal');
    Route::get('paypal_sdk', 'paypal_sdk\ProcessController@ipn')->name('paypal_sdk');
    Route::post('perfect_money', 'perfect_money\ProcessController@ipn')->name('perfect_money');
    Route::post('stripe', 'stripe\ProcessController@ipn')->name('stripe');
    Route::post('stripe_js', 'stripe_js\ProcessController@ipn')->name('stripe_js');
    Route::post('stripe_v3', 'stripe_v3\ProcessController@ipn')->name('stripe_v3');
    Route::post('skrill', 'skrill\ProcessController@ipn')->name('skrill');
    Route::post('paytm', 'paytm\ProcessController@ipn')->name('paytm');
    Route::post('payeer', 'payeer\ProcessController@ipn')->name('payeer');
    Route::post('paystack', 'paystack\ProcessController@ipn')->name('paystack');
    Route::post('voguepay', 'voguepay\ProcessController@ipn')->name('voguepay');
    Route::get('flutterwave/{trx}/{type}', 'flutterwave\ProcessController@ipn')->name('flutterwave');
    Route::post('razorpay', 'razorpay\ProcessController@ipn')->name('razorpay');
    Route::post('instamojo', 'instamojo\ProcessController@ipn')->name('instamojo');
    Route::get('blockchain', 'blockchain\ProcessController@ipn')->name('blockchain');
    Route::get('blockio', 'blockio\ProcessController@ipn')->name('blockio');
    Route::post('coinpayments', 'coinpayments\ProcessController@ipn')->name('coinpayments');
    Route::post('coinpayments_fiat', 'coinpayments_fiat\ProcessController@ipn')->name('coinpayments_fiat');
    Route::post('coingate', 'coingate\ProcessController@ipn')->name('coingate');
    Route::post('coinbase_commerce', 'coinbase_commerce\ProcessController@ipn')->name('coinbase_commerce');
    Route::get('mollie', 'mollie\ProcessController@ipn')->name('mollie');
    Route::post('cashmaal', 'cashmaal\ProcessController@ipn')->name('cashmaal');
});

// User Support Ticket
Route::prefix('ticket')->group(function () {
    Route::get('/', 'TicketController@supportTicket')->name('ticket');
    Route::get('/new', 'TicketController@openSupportTicket')->name('ticket.open');
    Route::post('/create', 'TicketController@storeSupportTicket')->name('ticket.store');
    Route::get('/view/{ticket}', 'TicketController@viewTicket')->name('ticket.view');
    Route::post('/reply/{ticket}', 'TicketController@replyTicket')->name('ticket.reply');
    Route::get('/download/{ticket}', 'TicketController@ticketDownload')->name('ticket.download');
});

Route::post('install', [UpdateController::class, 'download_update'])->name('install');

//Route::any('api/{any}', 'ViewController@app')->where('any','^(?!api).*$');

/*
|--------------------------------------------------------------------------
| Start Frontend Area
|--------------------------------------------------------------------------
*/

// Root route
$plat = arrayToObject(getPlatforms());
if (!isset($plat->system->maintenance) || $plat->system->maintenance != 1) {
    if (!isset($plat->frontend->frontend_status) || $plat->frontend->frontend_status != 1) {
        Route::get('/', function () {
            return redirect(route('user.home'));
        })->name('home');
    } else {
        Route::get('/', [HomeController::class, 'home'])->name('home');
    }
} else {
    Route::get('/', [HomeController::class, 'maintenance'])->name('home');
}
Route::get('/trading/{title}', [HomeController::class, 'page'])->name('page');
Route::get('about', [HomeController::class, 'about'])->name('frontend.pages.about');
Route::get('banned', [HomeController::class, 'banned'])->name('banned');
Route::post('/subscribe', 'SiteController@subscribe')->name('subscribe');
Route::get('/contact', 'SiteController@contact')->name('contact');
Route::post('/contact', 'SiteController@contactSubmit')->name('contact.send');
Route::get('placeholder-image/{size}', 'SiteController@placeholderImage')->name('placeholderImage');
//Route::get('/{slug}', 'SiteController@pages')->name('pages');

/*
|--------------------------------------------------------------------------
| Start User Area
|--------------------------------------------------------------------------
*/

Route::get('lang/{locale}', 'LanguageController@swap');

require_once __DIR__ . '/jetstream.php';
require_once __DIR__ . '/fortify.php';

Route::get('trade/{symbol}/{currency}', 'HomeController@trade')->name('trade');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => ['verified', 'checkStatus'], 'role:user', 'prefix' => 'user', 'as' => 'user.'], function () {

        Route::post('dashboard', 'UserController@updateProfile')->name('profile.update');

        // Router
        Route::get('/', 'UserController@index')->name('home');

        // Binary
        Route::group(['prefix' => 'binary', 'as' => 'binary.'], function () {
            // Trade
            Route::get('crypto/rate', 'TradeController@btcRate')->name('crypto.rate');
            Route::group(['middleware' => 'checkKYC', 'prefix' => 'trade', 'as' => 'trade.'], function () {
                Route::post('store', 'TradeController@store')->name('store');
                Route::post('result', 'TradeController@tradeResult')->name('result');
                Route::post('schedule', 'TradeController@schedule')->name('schedule');
            });

            // Practice
            Route::post('/add/practice/balance', 'UserController@addPracticeBalance')->name('add.practice.balance');
            Route::group(['prefix' => 'practice', 'as' => 'practice.'], function () {
                Route::get('crypto/rate', 'PracticeController@btcRate')->name('crypto.rate');
                Route::post('exchange', 'PracticeController@exchange')->name('exchange');
                Route::post('store', 'PracticeController@store')->name('store');
                Route::post('result', 'PracticeController@tradeResult')->name('result');
                Route::post('schedule', 'PracticeController@schedule')->name('schedule');
            });
        });
        // Fetch
        Route::group(['prefix' => 'fetch', 'as' => 'fetch.'], function () {
            Route::post('/data', 'UserController@data');
            Route::post('/support', 'TicketController@fetch_tickets');
            Route::post('/support/ticket/{id}', 'TicketController@fetch_ticket_messages');
            Route::post('/trade/orders', 'ExchangeController@trading_orders');
            Route::post('/trade/orders/{symbol}/{currency}', 'ExchangeController@trading_market_orders');

            Route::post('dashboard/binary', 'UserController@binary_dashboard')->name('binary.dashboard');
            Route::group(['prefix' => 'binary', 'as' => 'binary.'], function () {
                // Trade
                Route::group(['prefix' => 'trade', 'as' => 'trade.'], function () {
                    Route::post('{symbol}/{currency}', 'BinaryController@trade')->name('now');
                    Route::post('wallet', 'BinaryController@fetch_wallet')->name('wallet');
                    Route::post('contracts', 'BinaryController@binary_trade_log')->name('contract.log');
                    Route::post('orders', 'BinaryController@binary_trade_orders')->name('orders');
                    Route::post('wining/contracts', 'TradeController@winingTradeContract')->name('wining.contract.log');
                    Route::post('losing/contracts', 'TradeController@losingTradeContract')->name('losing.contract.log');
                    Route::post('draw/contracts', 'TradeController@drawTradeContract')->name('draw.contract.log');
                });

                // Practice
                Route::group(['prefix' => 'practice', 'as' => 'practice.'], function () {
                    Route::post('{symbol}/{currency}', 'BinaryController@practice')->name('now');
                    Route::post('contracts', 'BinaryController@binary_practice_log')->name('contract.log');
                    Route::post('orders', 'BinaryController@binary_practice_orders')->name('orders');
                });
                Route::post('/contract/view/{type}/{id}', 'BinaryController@preview')->name('contract.preview');
            });

            Route::post('/wallets', 'WalletController@fetch_wallets')->name('wallets');
            Route::post('/wallet/{type}/{symbol}/{address}', 'WalletController@fetch_wallet')->name('wallet');
            Route::post('/wallet', 'WalletController@fetch_wallet_balance')->name('wallet.balance');

            Route::post('/withdraw/history', 'UserController@fetch_withdraw_history')->name('withdraw.history');
            Route::post('/deposit/history', 'UserController@fetch_deposit_history')->name('deposit.history');
            Route::post('/transaction/history', 'UserController@fetch_transaction_history')->name('transaction.history');

            Route::post('news', [RssfeedController::class, 'fetch_news'])->name('news');
        });

        // Trade
        Route::group(['middleware' => 'checkKYC', 'prefix' => 'trade', 'as' => 'trade.'], function () {
            Route::post('/{symbol}/{currency}', 'ExchangeController@trading')->name('now');
            Route::post('store', 'ExchangeController@store')->name('store')->middleware('vue');
            Route::post('cancel', 'ExchangeController@cancel')->name('cancel')->middleware('vue');
        });

        // Wallet
        Route::group(['prefix' => 'wallet', 'as' => 'wallet.'], function () {
            Route::post('/create', 'WalletController@create')->name('create');
            Route::post('/j/create', 'WalletController@create_json')->name('create.json');
            Route::post('/fetch', 'WalletController@fetchWallet')->name('fetch');
            Route::post('/regenerate', 'WalletController@regenerate')->name('regenerate');
            Route::post('/deposit', 'WalletController@deposit')->name('deposit');
            Route::post('/withdraw', 'WalletController@withdraw')->middleware('vue')->name('withdraw');
            Route::post('/transfer/trading', 'WalletController@transfer_from_trading')->name('transfer.trading');
            Route::post('/transfer/funding', 'WalletController@transfer_from_funding')->name('transfer.funding');
            Route::post('/connect', 'WalletController@connect')->name('connect');
            Route::post('/disconnect', 'WalletController@disconnect')->name('disconnect');
        });


        //Watchlist
        Route::post('watchlists', [WatchlistController::class, 'index'])->name('watchlists');
        Route::post('watchlist/data', [WatchlistController::class, 'favs']);
        Route::post('watchlist/store', [WatchlistController::class, 'store'])->name('watchlist.store');
        Route::post('watchlist/delete', [WatchlistController::class, 'delete'])->name('watchlist.delete');

        //KYC
        Route::get('/kyc', 'User\KycController@index')->name('kyc');
        Route::get('/kyc/application', 'User\KycController@application')->name('kyc.application');
        Route::get('/kyc/application/view', 'User\KycController@view')->name('kyc.application.view');
        Route::post('/kyc/submit', 'User\KycController@submit')->name('kyc.submit');

        getRoute(1, 'user');
        getRoute(2, 'user');
        getRoute(3, 'user');
        getRoute(4, 'user');
        getRoute(5, 'user');
        getRoute(6, 'user');
        getRoute(8, 'user');
        getRoute(9, 'user');
        getRoute(10, 'user');
        getRoute(11, 'user');
        getRoute(12, 'user');

        // Deposit
        Route::any('deposit/wallet', 'Gateway\PaymentController@deposit')->middleware('checkKYC')->name('deposit');
        Route::post('deposit/insert', 'Gateway\PaymentController@depositInsert')->name('deposit.insert');
        Route::get('deposit/preview', 'Gateway\PaymentController@depositPreview')->name('deposit.preview');
        Route::get('deposit/confirm', 'Gateway\PaymentController@depositConfirm')->name('deposit.confirm');
        Route::get('deposit/manual', 'Gateway\PaymentController@manualDepositConfirm')->name('deposit.manual.confirm');
        Route::post('deposit/manual', 'Gateway\PaymentController@manualDepositUpdate')->name('deposit.manual.update');
        Route::get('deposit/history', 'UserController@depositHistory')->name('deposit.history');

        // Withdraw
        Route::get('/withdraw/wallet/{symbol}', 'UserController@withdrawMoney')->middleware('checkKYC')->name('withdraw');
        Route::post('/withdraw', 'UserController@withdrawStore')->name('withdraw.money');
        Route::get('/withdraw/preview', 'UserController@withdrawPreview')->name('withdraw.preview');
        Route::post('/withdraw/preview', 'UserController@withdrawSubmit')->name('withdraw.submit');
        Route::get('/withdraw/history', 'UserController@withdrawLog')->name('withdraw.history');

        // User Support Ticket
        Route::prefix('support')->group(function () {
            Route::prefix('ticket')->group(function () {
                Route::get('/', 'TicketController@supportTicket')->name('ticket');
                Route::get('/new', 'TicketController@openSupportTicket')->name('ticket.open');
                Route::post('/create', 'TicketController@storeSupportTicket')->name('ticket.store');
                Route::get('/view/{ticket}', 'TicketController@viewTicket')->name('ticket.view');
                Route::post('/reply/{ticket}', 'TicketController@replyTicket')->name('ticket.reply');
                Route::get('/download/{ticket}', 'TicketController@ticketDownload')->name('ticket.download');
            });
        });

        // Popups
        Route::name('popups.')->prefix('popups')->group(function () {
            Route::post('/disable', [PopupsController::class, 'disable_popup'])->name('disable');
        });
    });

    // Admin
    Route::group(['middleware' => 'role:admin,demo', 'prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {
        Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
        Route::get('market', [MarketController::class, 'index'])->name('market');
        Route::resource('tokens', 'TokensController');
        Route::get('api-tokens', 'AdminController@api')->name('api.index');
        Route::get('/clear', 'AdminController@clean')->name('clean')->middleware('demo');
        Route::match(array('GET', 'POST'), 'update', [UpdateController::class, 'index'])->name('update')->middleware('demo');
        Route::get('/update/check', [UpdateController::class, 'check_new_version'])->name('update.check');
        Route::match(array('GET', 'POST'), 'lic/activate', [UpdateController::class, 'lic_activate'])->name('lic.activate')->middleware('demo');
        Route::match(array('GET', 'POST'), 'lic/deactivate', [UpdateController::class, 'lic_deactivate'])->name('lic.deactivate')->middleware('demo');


        Route::get('cron', [CronController::class, 'view'])->name('cron');

        // Notifications
        Route::get('notification/read/{id}', 'AdminController@notificationRead')->name('notification.read');
        Route::get('notification', 'AdminController@notifications')->name('notifications');
        Route::get('notification/clean', 'AdminController@notifications_clean')->name('notifications.clean');

        // Users Manager
        Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
            Route::get('/', 'ManageUsersController@allUsers')->name('all');
            Route::post('remove', 'ManageUsersController@remove')->name('remove')->middleware('demo');

            // Login History
            Route::get('login/history/{id}', 'ManageUsersController@userLoginHistory')->name('login.history.single');
            Route::get('send-email', 'ManageUsersController@showEmailAllForm')->name('email.all');
            Route::post('send-email', 'ManageUsersController@sendEmailAll')->name('email.send')->middleware('demo');
            Route::get('referral/log/{id}', 'ManageUsersController@referralLog')->name('referral.log');
            Route::get('commission/log/{id}', 'ManageUsersController@commissionLog')->name('commission.log');
        });

        // User Manager
        Route::group(['prefix' => 'user', 'as' => 'users.'], function () {
            Route::get('detail/{id}', 'ManageUsersController@detail')->name('detail');
            Route::post('update/{id}', 'ManageUsersController@update')->name('update')->middleware('demo');
            Route::post('add-sub-balance/{id}', 'ManageUsersController@addSubBalance')->name('addSubBalance')->middleware('demo');

            Route::post('/wallet/frozen/create', 'ManageUsersController@frozen_wallet_create')->name('wallet.frozen.create');
            Route::get('/wallet/frozen/remove/{id}', 'ManageUsersController@frozen_wallet_remove')->name('wallet.frozen.remove');
            Route::post('/wallet/frozen/activate', 'ManageUsersController@frozen_wallet_activate')->name('wallet.frozen.activate');
            Route::post('/wallet/frozen/deactivate', 'ManageUsersController@frozen_wallet_deactivate')->name('wallet.frozen.deactivate');
            Route::post('add-sub-balance-frozen/{id}', 'ManageUsersController@addSubBalanceFrozen')->name('addSubBalanceFrozen')->middleware('demo');

            Route::get('send-email/{id}', 'ManageUsersController@showEmailSingleForm')->name('email.single');
            Route::post('send-email/{id}', 'ManageUsersController@sendEmailSingle')->middleware('demo');
            Route::get('transactions/{id}', 'ManageUsersController@transactions')->name('transactions');
            Route::get('deposits/{id}', 'ManageUsersController@deposits')->name('deposits');
            Route::get('deposits/via/{method}/{type?}/{userId}', 'ManageUsersController@depViaMethod')->name('deposits.method');
            Route::get('withdrawals/{id}', 'ManageUsersController@withdrawals')->name('withdrawals');
            Route::get('withdrawals/via/{method}/{type?}/{userId}', 'ManageUsersController@withdrawalsViaMethod')->name('withdrawals.method');
            Route::get('practice/trade/{id}', 'ManageUsersController@practiceLog')->name('practice.log');
            Route::get('trade/traded/{id}', 'ManageUsersController@traded')->name('traded');
            Route::get('trade/wining/{id}', 'ManageUsersController@wining')->name('wining');
            Route::get('trade/losing/{id}', 'ManageUsersController@losing')->name('losing');
            Route::get('trade/draw/{id}', 'ManageUsersController@draw')->name('draw');
        });

        Route::post('/wallet/create', '\App\Http\Controllers\WalletController@admincreateWallet')->name('wallet.create');
        Route::post('/wallet/regenerate', '\App\Http\Controllers\WalletController@adminregenerateWallet')->name('wallet.regenerate');


        Route::group(['prefix' => 'binary', 'as' => 'binary.'], function () {
            Route::get('trade/log', 'TradeLogController@index')->name('trade.log.list');
            Route::get('practice/trade/log', 'PracticeTradeController@index')->name('practice.log.list');
        });

        // Exchange Logs
        Route::get('trade/log', [ManageExchangesController::class, 'log'])->name('exchange.log.list');

        // Providers
        Route::group(['prefix' => 'provider', 'as' => 'provider.'], function () {
            Route::get('/', 'ManageThirdpartyController@index')->name('index');

            Route::get('edit/{id}', 'ManageThirdpartyController@edit')->name('edit')->middleware('demo');
            Route::get('balances/{id}', 'ManageThirdpartyController@balances')->name('balances')->middleware('demo');
            Route::post('update', 'ManageThirdpartyController@update')->name('update')->middleware('demo');
            Route::post('activate', 'ManageThirdpartyController@activate')->name('activate')->middleware('demo');
            Route::post('deactivate', 'ManageThirdpartyController@deactivate')->name('deactivate')->middleware('demo');
            Route::match(array('GET', 'POST'), 'install/{id}', [ProviderInstallController::class, 'index'])->name('install');
            Route::get('activater/{id}', [ProviderInstallController::class, 'activater'])->name('activater');
            Route::post('verify', [ProviderInstallController::class, 'activate_licenser'])->name('verify');
            Route::post('updater/{id}', [ProviderInstallController::class, 'update'])->name('updater')->middleware('demo');

            Route::get('/{provider}/currencies', 'ManageThirdpartyController@currencies')->name('currencies.index');
            Route::get('/{provider}/markets', 'ManageThirdpartyController@markets')->name('markets.index');
            Route::post('/markets/activate', 'ManageThirdpartyController@market_activate')->name('market.activate')->middleware('demo');
            Route::post('/markets/deactivate', 'ManageThirdpartyController@market_deactivate')->name('market.deactivate')->middleware('demo');
            Route::get('/refresh', 'ManageThirdpartyController@refresh')->name('refresh')->middleware('demo');
        });

        // Deposit Gateway
        Route::name('payment.')->prefix('payment')->group(function () {
            // Automatic Gateway
            Route::get('provider', 'GatewayController@index')->name('provider.index');
            Route::get('provider/edit/{alias}', 'GatewayController@edit')->name('provider.edit');
            Route::post('provider/update/{code}', 'GatewayController@update')->name('provider.update')->middleware('demo');
            Route::post('provider/remove/{code}', 'GatewayController@remove')->name('provider.remove')->middleware('demo');
            Route::post('provider/activate', 'GatewayController@activate')->name('provider.activate')->middleware('demo');
            Route::post('provider/deactivate', 'GatewayController@deactivate')->name('provider.deactivate')->middleware('demo');

            // Manual Methods
            Route::get('manual', 'ManualGatewayController@index')->name('manual.index');
            Route::get('manual/new', 'ManualGatewayController@create')->name('manual.create');
            Route::post('manual/new', 'ManualGatewayController@store')->name('manual.store')->middleware('demo');
            Route::get('manual/edit/{alias}', 'ManualGatewayController@edit')->name('manual.edit');
            Route::post('manual/update/{id}', 'ManualGatewayController@update')->name('manual.update')->middleware('demo');
            Route::post('manual/activate', 'ManualGatewayController@activate')->name('manual.activate')->middleware('demo');
            Route::post('manual/deactivate', 'ManualGatewayController@deactivate')->name('manual.deactivate')->middleware('demo');
        });


        // Deposit System
        Route::name('deposit.')->prefix('deposit')->group(function () {
            Route::get('/', 'DepositController@deposit')->name('list');
            Route::get('pending', 'DepositController@pending')->name('pending');
            Route::get('rejected', 'DepositController@rejected')->name('rejected');
            Route::get('approved', 'DepositController@approved')->name('approved');
            Route::get('successful', 'DepositController@successful')->name('successful');
            Route::get('details/{id}', 'DepositController@details')->name('details');

            Route::post('reject', 'DepositController@reject')->name('reject')->middleware('demo');
            Route::post('approve', 'DepositController@approve')->name('approve')->middleware('demo');
            Route::get('via/{method}/{type?}', 'DepositController@depViaMethod')->name('method');
            Route::get('/{scope}/search', 'DepositController@search')->name('search');
            Route::get('date-search/{scope}', 'DepositController@dateSearch')->name('dateSearch');
        });

        // Withdraw
        Route::name('withdraw.')->prefix('withdraw')->group(function () {
            Route::get('pending', 'WithdrawalController@pending')->name('pending');
            Route::get('approved', 'WithdrawalController@approved')->name('approved');
            Route::get('rejected', 'WithdrawalController@rejected')->name('rejected');
            Route::get('log', 'WithdrawalController@log')->name('log');
            Route::get('via/{method_id}/{type?}', 'WithdrawalController@logViaMethod')->name('method');
            Route::get('{scope}/search', 'WithdrawalController@search')->name('search');
            Route::get('date-search/{scope}', 'WithdrawalController@dateSearch')->name('dateSearch');
            Route::get('details/{id}', 'WithdrawalController@details')->name('details');
            Route::post('approve', 'WithdrawalController@approve')->name('approve')->middleware('demo');
            Route::post('reject', 'WithdrawalController@reject')->name('reject')->middleware('demo');

            // Withdraw Method
            Route::get('', 'WithdrawMethodController@methods')->name('method.index');
            Route::get('create', 'WithdrawMethodController@create')->name('method.create');
            Route::post('create', 'WithdrawMethodController@store')->name('method.store')->middleware('demo');
            Route::get('edit/{id}', 'WithdrawMethodController@edit')->name('method.edit');
            Route::post('edit/{id}', 'WithdrawMethodController@update')->name('method.update')->middleware('demo');
            Route::post('activate', 'WithdrawMethodController@activate')->name('method.activate')->middleware('demo');
            Route::post('deactivate', 'WithdrawMethodController@deactivate')->name('method.deactivate')->middleware('demo');
        });

        // Report
        Route::group(['prefix' => 'report', 'as' => 'report.'], function () {
            Route::get('/transaction', 'ReportController@transaction')->name('transaction');
            Route::get('/transaction/search', 'ReportController@transactionSearch')->name('transaction.search');

            Route::get('/wallet', 'ReportController@wallet')->name('wallet');
            Route::post('/wallet/cancel', 'ReportController@wallet_trx_cancel')->name('wallet.cancel');
            Route::get('/wallet/search', 'ReportController@wallet_search')->name('wallet.search');

            Route::get('/wallet/deposit', 'ReportController@wallet_deposit')->name('wallet.deposit');
            Route::get('/wallet/deposit/search', 'ReportController@wallet_deposit_search')->name('wallet.deposit.search');

            Route::get('/wallet/withdraw', 'ReportController@wallet_withdraw')->name('wallet.withdraw');
            Route::get('/wallet/withdraw/search', 'ReportController@wallet_withdraw_search')->name('wallet.withdraw.search');

            Route::get('/wallet/transfer/trading', 'ReportController@wallet_transfer_trading')->name('wallet.transfer.trading');
            Route::get('/wallet/transfer/trading/search', 'ReportController@wallet_transfer_trading_search')->name('wallet.transfer.trading.search');

            Route::get('/wallet/transfer/funding', 'ReportController@wallet_transfer_funding')->name('wallet.transfer.funding');
            Route::get('/wallet/transfer/funding/search', 'ReportController@wallet_transfer_funding_search')->name('wallet.transfer.funding.search');
            Route::post('/wallet/transfer/funding/approve', 'ReportController@wallet_transfer_funding_approve')->name('wallet.transfer.funding.approve');
            Route::post('/wallet/transfer/funding/reject', 'ReportController@wallet_transfer_funding_reject')->name('wallet.transfer.funding.reject');

            Route::get('/commission', 'ReportController@commission')->name('commission');
            Route::get('/commission/search', 'ReportController@commissionSearch')->name('commission.search');

            Route::get('/login/history', 'ReportController@loginHistory')->name('login.history');
            Route::get('/login/ipHistory/{ip}', 'ReportController@loginIpHistory')->name('login.ipHistory');
        });

        // Admin Support
        Route::get('tickets', 'SupportTicketController@tickets')->name('ticket');
        Route::get('tickets/pending', 'SupportTicketController@pendingTicket')->name('ticket.pending');
        Route::get('tickets/closed', 'SupportTicketController@closedTicket')->name('ticket.closed');
        Route::get('tickets/answered', 'SupportTicketController@answeredTicket')->name('ticket.answered');
        Route::get('tickets/view/{id}', 'SupportTicketController@ticketReply')->name('ticket.view');
        Route::post('ticket/reply/{id}', 'SupportTicketController@ticketReplySend')->name('ticket.reply')->middleware('demo');
        Route::get('ticket/download/{ticket}', 'SupportTicketController@ticketDownload')->name('ticket.download');
        Route::post('ticket/delete', 'SupportTicketController@ticketDelete')->name('ticket.delete')->middleware('demo');

        // General Setting
        Route::get('settings', 'GeneralSettingController@index')->name('setting.index');
        Route::post('settings', 'GeneralSettingController@update')->name('setting.update')->middleware('demo');

        // Currencies Setting
        Route::get('currencies', 'GeneralSettingController@currencies')->name('currency.index');
        Route::post('currencies', 'GeneralSettingController@currency_update')->name('currency.update')->middleware('demo');
        Route::post('activate', 'GeneralSettingController@currency_activate')->name('currency.activate')->middleware('demo');

        // Platform Setting
        Route::get('platform', 'PlatformController@index')->name('platform');
        Route::post('platform', 'PlatformController@update')->name('platform.update')->middleware('demo');

        // Logo-Icon
        Route::get('setting/logo-icon', 'GeneralSettingController@logoIcon')->name('setting.logo_icon');
        Route::post('setting/logo-icon', 'GeneralSettingController@logoIconUpdate')->name('setting.logo_icon_update')->middleware('demo');

        // Extensions
        Route::group(['prefix' => 'extensions', 'as' => 'extensions.'], function () {
            Route::get('/', [ExtensionController::class, 'index'])->name('index');
            Route::match(array('GET', 'POST'), 'install/{id}', [InstallController::class, 'index'])->middleware('demo')->name('install');
            Route::get('activater/{id}', [InstallController::class, 'activater'])->name('activater');
            Route::post('verify', [InstallController::class, 'activate_licenser'])->middleware('demo')->name('verify');
            Route::post('update/{id}', [ExtensionController::class, 'update'])->name('update')->middleware('demo');
            Route::post('activate', [ExtensionController::class, 'activate'])->name('activate')->middleware('demo');
            Route::post('deactivate', [ExtensionController::class, 'deactivate'])->name('deactivate')->middleware('demo');
        });

        getRoute(1, 'admin');
        getRoute(2, 'admin');
        getRoute(3, 'admin');
        getRoute(4, 'admin');
        getRoute(5, 'admin');
        getRoute(6, 'admin');
        getRoute(8, 'admin');
        getRoute(10, 'admin');
        getRoute(11, 'admin');

        // SEO
        Route::get('seo-manager', [HomeController::class, 'seoEdit'])->name('seo');
        Route::post('frontend-content/{key}', [HomeController::class, 'frontendContent'])->name('seo.content')->middleware('demo');

        // Frontend
        Route::name('template.')->prefix('template')->group(function () {
            Route::get('index', 'AdminController@frontend')->name('index');
            Route::post('save', 'AdminController@frontend_save')->middleware('demo')->name('save');
            Route::post('frontendset', 'AdminController@frontend_set')->middleware('demo')->name('set');
        });

        // KYC
        Route::get('/kyc-list/{status?}', 'KycController@index')->name('kycs');
        Route::group(['prefix' => 'kyc', 'as' => 'kyc.'], function () {
            Route::get('/view/{id}/{type}', 'KycController@show')->name('view');
            Route::post('/view', 'KycController@ajax_show')->name('ajax_show');
            Route::post('/update', 'KycController@update')->name('update')->middleware('demo');
            Route::post('/delete', 'KycController@delete')->name('delete')->middleware('demo');
            Route::get('/search', 'KycController@search')->name('search');
        });

        // Sidebar Manager
        Route::group(['prefix' => 'sidebar', 'as' => 'sidebar.'], function () {
            Route::get('admin', 'AdminController@sidebar_admin')->name('admin');
            Route::get('user', 'AdminController@sidebar_user')->name('user');

            Route::get('edit/{type}/{id}', 'AdminController@sidebar_edit')->name('edit')->middleware('demo');
            Route::post('update/{type}/{id}', 'AdminController@sidebar_update')->name('update')->middleware('demo');
            Route::post('{type}/activate', 'AdminController@sidebar_activate')->name('activate')->middleware('demo');
            Route::post('{type}/deactivate', 'AdminController@sidebar_deactivate')->name('deactivate')->middleware('demo');

            Route::get('edit/{type}/{id}/submenu/{submenu_id}', 'AdminController@sidebar_submenu_edit')->name('submenu.edit')->middleware('demo');
            Route::post('update/{type}/{id}/submenu/{submenu_id}', 'AdminController@sidebar_submenu_update')->name('submenu.update')->middleware('demo');
            Route::post('submenu/{type}/activate/{id}', 'AdminController@sidebar_submenu_activate')->name('submenu.activate')->middleware('demo');
            Route::post('submenu/{type}/deactivate/{id}', 'AdminController@sidebar_submenu_deactivate')->name('submenu.deactivate')->middleware('demo');
        });

        // Cleaners
        Route::get('/settings/database', 'DatabaseController@index')->name('settings.database')->middleware('demo');
        Route::post('/database/binary/practice/logs/clean', 'DatabaseController@clean_binary_practice_logs')->name('database.binary.practice.logs.clean')->middleware('demo');
        Route::post('/database/binary/trade/logs/clean', 'DatabaseController@clean_binary_trade_logs')->name('database.binary.trade.logs.clean')->middleware('demo');
        Route::post('/database/trade/logs/clean', 'DatabaseController@clean_trade_logs')->name('database.trade.logs.clean')->middleware('demo');
        Route::post('/database/forex/investments/logs/clean', 'DatabaseController@clean_forex_investments_logs')->name('database.forex.investments.logs.clean')->middleware('demo');
        Route::post('/database/bot/investments/logs/clean', 'DatabaseController@clean_bot_investments_logs')->name('database.bot.investments.logs.clean')->middleware('demo');
        Route::post('/database/staking/logs/clean', 'DatabaseController@clean_staking_logs')->name('database.staking.logs.clean')->middleware('demo');
        Route::post('/database/ico/logs/clean', 'DatabaseController@clean_ico_logs')->name('database.ico.logs.clean')->middleware('demo');
        Route::post('/database/wallets/clean', 'DatabaseController@clean_wallets')->name('database.wallets.clean')->middleware('demo');
        Route::post('/database/refresh/permissions', 'DatabaseController@refresh_permissions')->name('database.refresh.permissions')->middleware('demo');

        Route::get('/alerts/remove/install', 'AdminController@remove_install_file')->name('alerts.remove_install_file')->middleware('demo');

        // Popups
        Route::name('popups.')->prefix('popups')->group(function () {
            Route::get('', [PopupsController::class, 'index'])->name('index');
            Route::get('/create', [PopupsController::class, 'create'])->name('create');
            Route::get('/edit/{id}', [PopupsController::class, 'edit'])->name('edit');
            Route::post('/store', [PopupsController::class, 'store'])->name('store');
            Route::post('/update/{id}', [PopupsController::class, 'update'])->name('update');
            Route::post('/remove', [PopupsController::class, 'remove'])->name('remove');
        });

        // Locale
        Route::resource('locale', 'LocaleController')->middleware('demo');

        Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
        Route::resource('permissions', 'PermissionsController');

        // Roles
        Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
        Route::resource('roles', 'RolesController');

        //Route::resource('permissions', 'PermissionsController')->middleware('demo');
        Route::post('roles/assign', 'RolesController@assign')->name('roles.assign')->middleware('demo');
        Route::resource('roles', 'RolesController')->middleware('demo');


        //Notification Setting
        Route::post('/users/email/send', 'UsersController@send_email')->name('users.email')->middleware('demo');
        Route::name('settings.mail.')->controller('NotificationController')->prefix('/settings/email')->group(function () {
            //Template Setting
            Route::get('/', 'global')->name('index');
            Route::post('update', 'globalUpdate')->name('update')->middleware('demo');
            Route::get('templates', 'templates')->name('templates');
            Route::get('template/edit/{id}', 'templateEdit')->name('template.edit');
            Route::post('template/update/{id}', 'templateUpdate')->name('template.update')->middleware('demo');

            //Email Setting
            Route::get('settings', 'emailSetting')->middleware('demo')->name('email');
            Route::post('settings', 'emailSettingUpdate')->middleware('demo');
            Route::post('test', 'emailTest')->name('test')->middleware('demo');

            //SMS Setting
            Route::get('sms/settings', 'smsSetting')->middleware('demo')->name('sms');
            Route::post('sms/settings', 'smsSettingUpdate')->middleware('demo');
            Route::post('sms/test', 'smsTest')->name('sms.test')->middleware('demo');

            //Push Notification Setting
            Route::get('push-notification/settings', 'pushNotificationSetting')->middleware('demo')->name('push');
            Route::post('push-notification/settings', 'pushNotificationSettingUpdate')->middleware('demo');
        });
    });
});