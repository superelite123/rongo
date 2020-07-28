<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Dingo\Api\Routing\Router;
$api = app(Router::class);

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
$api->version('v1', function (Router $api) {
    $api->group(['prefix' => 'auth'], function(Router $api) {
        $api->post('login/seller', 'App\\Api\\V1\\Controllers\\Auth\\LoginSellerController@login');
        $api->post('login/seller/2fa', 'App\\Api\\V1\\Controllers\\Auth\\LoginSellerController@confirm');
        $api->post('register/customer', 'App\\Api\\V1\\Controllers\\Auth\\LoginCustomerController@register');
        $api->post('login/customer', 'App\\Api\\V1\\Controllers\\Auth\\LoginCustomerController@login');
        $api->post('login/customer/newDevice', 'App\\Api\\V1\\Controllers\\Auth\\LoginCustomerController@newDevice');
    });

    //Authorizationed Zone
    $api->group(['middleware' => 'jwt.auth'], function(Router $api) {
        /**
         * Product
         */
        $api->get('products', 'App\\Api\\V1\\Controllers\\ProductController@index');
        $api->get('product/getAdminList/{type}', 'App\\Api\\V1\\Controllers\\ProductController@getAdminList');
        $api->get('product/{id}', 'App\\Api\\V1\\Controllers\\ProductController@show');
        $api->get('product/edit/{id}', 'App\\Api\\V1\\Controllers\\ProductController@edit');
        $api->post('product/like', 'App\\Api\\V1\\Controllers\\ProductController@addLikeProduct');
        $api->post('product/stage', 'App\\Api\\V1\\Controllers\\ProductController@stageProduct');
        $api->post('product/store', 'App\\Api\\V1\\Controllers\\ProductController@store');
        $api->post('product/click', 'App\\Api\\V1\\Controllers\\ProductClickController@store');
        $api->post('product/delete', 'App\\Api\\V1\\Controllers\\ProductController@delete');
        $api->get('products/ranking', 'App\\Api\\V1\\Controllers\\ProductController@rankings');
        /**
         * Store
         */
        $api->get('stores','App\\Api\\V1\\Controllers\\StoreController@index');
        $api->get('store/{id}','App\\Api\\V1\\Controllers\\StoreController@show');
        $api->get('store/follows/{type}', 'App\\Api\\V1\\Controllers\\StoreController@follows');
        $api->get('store/products/{type}', 'App\\Api\\V1\\Controllers\\StoreController@products');
        $api->get('store/liveStream/{type}', 'App\\Api\\V1\\Controllers\\StoreController@liveStreams');
        /**
         * Search
         */
        $api->post('search','App\\Api\\V1\\Controllers\\SearchController@index');
        $api->get('search/logs','App\\Api\\V1\\Controllers\\SearchController@logs');
    });
    /**
     * Live
     */
    $api->group( ['prefix' => 'live','middleware' => 'jwt.auth'], function(Router $api){
        $api->get('/', 'App\\Api\\V1\\Controllers\\LiveController@index');
        $api->post('create', 'App\\Api\\V1\\Controllers\\LiveController@create');
        $api->post('quit', 'App\\Api\\V1\\Controllers\\LiveController@quit');
        $api->get('view/{id}', 'App\\Api\\V1\\Controllers\\LiveController@view');
        $api->get('start/{id}', 'App\\Api\\V1\\Controllers\\LiveController@start');
        $api->get('publish/{id}', 'App\\Api\\V1\\Controllers\\LiveController@publish');
        $api->get('stop/{id}', 'App\\Api\\V1\\Controllers\\LiveController@stop');
        $api->get('state/{id}', 'App\\Api\\V1\\Controllers\\LiveController@state');
        $api->get('initial_products', 'App\\Api\\V1\\Controllers\\LiveController@initialProducts');
        $api->get('products/{id}', 'App\\Api\\V1\\Controllers\\LiveController@products');
        $api->post('register', 'App\\Api\\V1\\Controllers\\LiveController@register');
        $api->post('register/confirm', 'App\\Api\\V1\\Controllers\\LiveController@registerConfirm');
        $api->post('add_product', 'App\\Api\\V1\\Controllers\\LiveController@addProduct');

    });
    /**
     * User Detail
     */
    $api->group(['middleware' => 'jwt.auth','prefix' => 'me'], function(Router $api) {
        $api->get('/','App\\Api\\V1\\Controllers\\UserController@show');
        $api->get('likeProducts','App\\Api\\V1\\Controllers\\ProductLikeController@index');
        $api->get('show','App\\Api\\V1\\Controllers\\UserController@show');
        $api->get('watched_lives','App\\Api\\V1\\Controllers\\LiveController@watchedLives');
        $api->post('store','App\\Api\\V1\\Controllers\\UserController@store');
        $api->post('uploadPhoto','App\\Api\\V1\\Controllers\\UserController@uploadPhoto');
        $api->post('updateEmail','App\\Api\\V1\\Controllers\\UserController@updateEmail');
        $api->post('addAle','App\\Api\\V1\\Controllers\\UserController@addAle');
        $api->get('getInviteCode','App\\Api\\V1\\Controllers\\UserController@getInviteCode');
        $api->post('deleteUser', 'App\\Api\\V1\\Controllers\\UserController@deleteUser');
        $api->get('getStore','App\\Api\\V1\\Controllers\\UserStoreController@index');
        $api->post('saveStore','App\\Api\\V1\\Controllers\\UserStoreController@store');
        $api->post('changePassword','App\\Api\\V1\\Controllers\\UserController@changePassword');
        $api->post('changeEmail','App\\Api\\V1\\Controllers\\UserController@changeEmail');
        $api->post('registerAccount', 'App\\Api\\V1\\Controllers\\UserController@registerAccountInfo');
        $api->post('changeDevice', 'App\\Api\\V1\\Controllers\\UserController@changeUserDeivce');
    });
    $api->get('confirmEmailChange', 'App\\Api\\V1\\Controllers\\UserController@confirmEmailChange')->middleware('jwt.auth');
    /**
     * Address
     */
    $api->group(['middleware' => 'jwt.auth','prefix' => 'address'], function(Router $api) {
        $api->get('show/{id}','App\\Api\\V1\\Controllers\\AddressController@show');
        $api->get('store','App\\Api\\V1\\Controllers\\AddressController@store');
        $api->get('dAddresses','App\\Api\\V1\\Controllers\\DAddressController@index');
        $api->post('dAddress','App\\Api\\V1\\Controllers\\DAddressController@store');
    });
    $api->group(['middleware' => 'jwt.auth','prefix' => 'storeFollow'], function(Router $api) {
        $api->get('/{type}','App\\Api\\V1\\Controllers\\StoreFollowController@index');
        $api->post('follow','App\\Api\\V1\\Controllers\\StoreFollowController@follow');
    });
    /**
     * Payment
     */
    $api->group(['middleware' => 'jwt.auth','prefix' => 'payment'], function(Router $api) {
        $api->get('card/','App\\Api\\V1\\Controllers\\Payment\\CardController@index');
        $api->post('execute/','App\\Api\\V1\\Controllers\\Payment\\OrderController@execute');
        $api->get('cards','App\\Api\\V1\\Controllers\\Payment\\CardController@index');
        $api->post('add_card','App\\Api\\V1\\Controllers\\Payment\\CardController@store');
        $api->get('transactions', 'App\\Api\\V1\\Controllers\\Payment\\OrderController@getTransactions');

    });
    $api->group(['middleware' => 'jwt.auth','prefix' => 'sell_history'], function(Router $api) {
        $api->get('/', 'App\\Api\\V1\\Controllers\\SellHistoryController@index');
        $api->post('/getDetail', 'App\\Api\\V1\\Controllers\\SellHistoryController@getDetail');
    });
    /**
     * Notification
     */
    $api->group(['middleware' => 'jwt.auth','prefix' => 'notification'], function(Router $api) {
        $api->get('/','App\\Api\\V1\\Controllers\\NotificationController@index');
    });
    /**
     * News
     */
    $api->group(['middleware' => 'jwt.auth','prefix' => 'news'], function(Router $api) {
        $api->get('/','App\\Api\\V1\\Controllers\\NewsController@index');
    });

    /**
     * User Setting
     */
    $api->group(['middleware' => 'jwt.auth','prefix' => 'user_setting'], function(Router $api) {
        $api->get('notifications','App\\Api\\V1\\Controllers\\UserSettingController@notifications');
        $api->post('notification/set','App\\Api\\V1\\Controllers\\UserSettingController@setNotification');
    });
});
