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
        $api->get('products', 'App\\Api\\V1\\Controllers\\ProductController@index');
        $api->get('lives', 'App\\Api\\V1\\Controllers\\LiveController@index');
    });
});
