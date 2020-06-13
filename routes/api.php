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
        $api->post('login/seller/2fa', 'App\\Api\\V1\\Controllers\\Auth\\LoginSellerController@Confirm');
        $api->post('register/customer', 'App\\Api\\V1\\Controllers\\Auth\\LoginCustomerController@register');
        $api->post('login/customer', 'App\\Api\\V1\\Controllers\\Auth\\LoginCustomerController@login');
        $api->post('login/customer/newDevice', 'App\\Api\\V1\\Controllers\\Auth\\LoginCustomerController@newDevice');
        $api->get('me', 'App\\Api\\V1\\Controllers\\UserController@me');
    });

    //Authorizationed Zone
    $api->group(['middleware' => 'jwt.auth'], function(Router $api) {
        /**
         * Product
         */
        $api->get('products', 'App\\Api\\V1\\Controllers\\ProductController@index');
        $api->get('product/{id}', 'App\\Api\\V1\\Controllers\\ProductController@show');
        $api->post('product/like', 'App\\Api\\V1\\Controllers\\ProductController@like');
        /**
         * Live
         */
        $api->get('lives', 'App\\Api\\V1\\Controllers\\LiveController@index');
        $api->post('live/create', 'App\\Api\\V1\\Controllers\\LiveController@create')->middleware('checklivecreator');
        $api->get('live/{id}', 'App\\Api\\V1\\Controllers\\LiveController@view');
        $api->get('live/start/{id}', 'App\\Api\\V1\\Controllers\\LiveController@start');
        $api->get('live/publish/{id}', 'App\\Api\\V1\\Controllers\\LiveController@publish');
        $api->get('live/stop/{id}', 'App\\Api\\V1\\Controllers\\LiveController@stop');
        $api->get('live/state/{id}', 'App\\Api\\V1\\Controllers\\LiveController@state');
        $api->get('live/view/{id}', 'App\\Api\\V1\\Controllers\\LiveController@view');
        /**
         * Store
         */
        $api->get('stores','App\\Api\\V1\\Controllers\\StoreController@index');
        $api->get('store/{id}','App\\Api\\V1\\Controllers\\StoreController@show');
        /**
         * Search
         */
        $api->post('search','App\\Api\\V1\\Controllers\\SearchController@index');
        $api->get('search/logs','App\\Api\\V1\\Controllers\\SearchController@logs');
    });
});
