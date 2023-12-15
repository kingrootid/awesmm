<?php

use App\Http\Controllers\Admin\AjaxController as AdminAjaxController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DataController as AdminDataController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CronsJobController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\NonLoginController;
use App\Http\Controllers\TripayCallbackController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DashboardController::class, 'landing']);


Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::get('api-docs', [DashboardController::class, 'apiDocs']);
    Route::get('tickets', [DashboardController::class, 'tickets']);
    Route::get('user/settings', [DashboardController::class, 'userSetting']);
    Route::get('tickets/reply/{id}', [DashboardController::class, 'ticketsReply']);
    Route::get('monitoring_services', [DashboardController::class, 'monitoring']);


    Route::group(['prefix' => 'logs', 'as' => 'logs.'], function () {
        Route::get('mutasi', [DashboardController::class, 'mutasi']);
        Route::get('login', [DashboardController::class, 'login']);
        Route::get('services', [DashboardController::class, 'history']);
    });

    Route::group(['prefix' => 'deposit'], function () {
        Route::get('new', [DashboardController::class, 'depositNew']);
        Route::get('history', [DashboardController::class, 'depositHistory']);
        Route::get('invoice/{id}', [DashboardController::class, 'depositInvoice']);
    });
    Route::group(['prefix' => 'orders'], function () {
        Route::get('social-single', [DashboardController::class, 'singleOrder']);
        Route::get('history', [DashboardController::class, 'historyOrder']);
        Route::get('request', [DashboardController::class, 'requestOrder']);
    });


    // ajax 
    Route::group(['prefix' => 'ajax'], function () {
        Route::post('showCategory', [AjaxController::class, 'showCategory']);
        Route::post('favorite-services', [AjaxController::class, 'FavoriteServices']);
        Route::post('getServices', [AjaxController::class, 'getServices']);
        Route::post('favgetServices', [AjaxController::class, 'favGetServices']);
        Route::post('priceSosmed', [AjaxController::class, 'priceSosmed']);
        Route::post('TotalPriceSosmed', [AjaxController::class, 'TotalPriceSosmed']);
        Route::post('orderSosmed', [AjaxController::class, 'orderSosmed']);
        Route::post('deposit', [AjaxController::class, 'doDeposit']);
        Route::post('generate-api-key', [AjaxController::class, 'generateApiKey']);
        Route::post('tickets', [AjaxController::class, 'tickets']);
        Route::post('user-settings', [AjaxController::class, 'userSetting']);
        Route::get('detail-social/{id}', [AjaxController::class, 'detailOrderSocial']);
        Route::post('change-order', [AjaxController::class, 'changeOrders']);
    });
    // Data 
    Route::group(['prefix' => 'data'], function () {
        Route::get('order-history', [DataController::class, 'orderHistory']);
        Route::get('deposit-history', [DataController::class, 'depositHistory']);
        Route::get('tickets', [DataController::class, 'tickets']);
        Route::get('monitoring', [DataController::class, 'monitoring']);
        Route::get('mutasi', [DataController::class, 'mutasi']);
        Route::get('login', [DataController::class, 'login']);
        Route::get('request-history', [DataController::class, 'OrderRequest']);
    });
});

// Non Login
Route::group(['prefix' => 'data'], function () {
    Route::get('price/social', [DataController::class, 'priceSocial']);
});

Route::group(['prefix' => 'admin'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::get('login', [AuthController::class, 'admin_login'])->name('adminLogin');
        Route::post('login', [AdminAjaxController::class, 'adminAuthenticate']);
    });
    Route::middleware('adminauth')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'dashboard']);
        Route::get('/dashboard', [AdminDashboardController::class, 'dashboard']);
        Route::get('news', [AdminDashboardController::class, 'news']);
        Route::get('balance_provider', [AdminDashboardController::class, 'balance_provider']);
        Route::get('method', [AdminDashboardController::class, 'method']);
        Route::get('history_deposits', [AdminDashboardController::class, 'history_deposits']);
        Route::get('category', [AdminDashboardController::class, 'category']);
        Route::get('provider', [AdminDashboardController::class, 'provider']);
        Route::get('services', [AdminDashboardController::class, 'services']);
        Route::get('category_images', [AdminDashboardController::class, 'category_images']);
        Route::get('order_social', [AdminDashboardController::class, 'history_social']);
        Route::get('web-config', [AdminDashboardController::class, 'settings']);
        Route::get('users', [AdminDashboardController::class, 'users']);
        Route::get('role', [AdminDashboardController::class, 'role']);
        Route::get('tickets', [AdminDashboardController::class, 'tickets']);
        Route::get('faq', [AdminDashboardController::class, 'faq']);
        Route::get('report-order', [AdminDashboardController::class, 'report_order']);
        Route::get('contact-us', [AdminDashboardController::class, 'contact_us']);
        Route::get('service-premium', [AdminDashboardController::class, 'service_premium']);
        Route::get('service-hide', [AdminDashboardController::class, 'serviceHide']);
        Route::get('service-recommended', [AdminDashboardController::class, 'serviceRecommend']);
        Route::get('tickets/reply/{id}', [AdminDashboardController::class, 'tickets_reply']);
        Route::get('pages', [AdminDashboardController::class, 'pages']);
        Route::get('pages/edit/{id}', [AdminDashboardController::class, 'editPages']);
        Route::get('order-request', [AdminDashboardController::class, 'history_request']);
        Route::group(['prefix' => 'data'], function () {
            Route::get('news', [AdminDataController::class, 'news']);
            Route::get('news/{id}', [AdminDataController::class, 'getNews']);
            Route::get('history_deposits', [AdminDataController::class, 'deposits']);
            Route::get('method', [AdminDataController::class, 'method']);
            Route::get('method/{id}', [AdminDataController::class, 'getMethod']);
            Route::get('category', [AdminDataController::class, 'category']);
            Route::get('category/{id}', [AdminDataController::class, 'getCategory']);
            Route::get('provider', [AdminDataController::class, 'provider']);
            Route::get('provider/{id}', [AdminDataController::class, 'getProvider']);
            Route::get('services', [AdminDataController::class, 'services']);
            Route::get('services/{id}', [AdminDataController::class, 'getServices']);
            Route::get('history_sosmed', [AdminDataController::class, 'history_sosmed']);
            Route::get('users', [AdminDataController::class, 'users']);
            Route::get('users/{id}', [AdminDataController::class, 'getUsers']);
            Route::get('role', [AdminDataController::class, 'role']);
            Route::get('role/{id}', [AdminDataController::class, 'findrole']);
            Route::get('tickets', [AdminDataController::class, 'tickets']);
            Route::get('pages', [AdminDataController::class, 'pages']);
            Route::get('request-history', [AdminDataController::class, 'OrderRequest']);
            Route::get('request-history/{id}', [AdminDataController::class, 'getOrderRequest']);
        });
        Route::group(['prefix' => 'ajax', 'as' => 'ajax.'], function () {
            Route::post('news', [AdminAjaxController::class, 'news']);
            Route::post('deposit', [AdminAjaxController::class, 'deposit']);
            Route::post('method', [AdminAjaxController::class, 'method']);
            Route::post('category', [AdminAjaxController::class, 'category']);
            Route::post('provider', [AdminAjaxController::class, 'provider']);
            Route::post('services', [AdminAjaxController::class, 'services']);
            Route::post('edit-social', [AdminAjaxController::class, 'editSocial']);
            Route::get('detail-social/{id}', [AdminAjaxController::class, 'detailOrderSocial']);
            Route::post('user', [AdminAjaxController::class, 'user']);
            Route::post('role', [AdminAjaxController::class, 'role']);
            Route::post('setting-update', [AdminAjaxController::class, 'setting_update']);
            Route::post('pages', [AdminAjaxController::class, 'pages']);
            Route::post('uploadImage', [AdminAjaxController::class, 'uploadImage'])->name('upload');
            Route::post('tickets', [AdminAjaxController::class, 'tickets']);
            Route::get('getSaldoProvider', [AdminAjaxController::class, 'getSaldoProvider']);
            Route::post('order-request', [AdminAjaxController::class, 'OrderRequest']);
        });
    });
});
Route::get('daftar-harga', [DashboardController::class, 'priceList']);
Route::get('pages/{name}', [DashboardController::class, 'pages']);
Route::group(['prefix' => 'auth'], function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'authenticate']);
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'store']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::post('forgot', [AuthController::class, 'reset']);
    Route::get('forgot', [AuthController::class, 'reset_password']);
    Route::get('verify/{code}', [AuthController::class, 'activation']);
    Route::get('/provider/{provider}', [\App\Http\Controllers\SocialiteController::class, 'redirectToProvider']);
    Route::get('/provider/{provider}/callback', [\App\Http\Controllers\SocialiteController::class, 'handleProvideCallback']);
});
Route::post('/callback/tripay', [TripayCallbackController::class, 'handle']);
Route::group(['prefix' => 'cron', 'as' => 'cron.'], function () {
    Route::get('sosmed/{name}', [CronsJobController::class, 'getServicesSosmed']);
    Route::get('sosmed/new/{name}', [CronsJobController::class, 'getServicesSosmedST']);
    Route::get('sosmed/indo-old/{name}', [CronsJobController::class, 'getServicesSosmedOld']);
    Route::get('sosmed/luar/{name}', [CronsJobController::class, 'getServicesSosmedLuar']);
    Route::get('sosmed/buzzer/{name}', [CronsJobController::class, 'getServicesSosmedBuzzer']);
    Route::get('sosmed/undrctrl/{name}', [CronsJobController::class, 'getServicesSosmedUndrCtrl']);
    Route::get('sosmed', [CronsJobController::class, 'cron_sosmed']);
    Route::get('paymentChannel', [CronsJobController::class, 'getPaymentChannel']);
    Route::get('setnewRole', [CronsJobController::class, 'setnewRole']);
});
