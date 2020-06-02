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
        $api->post('login', 'App\\Api\\V1\\Controllers\\LoginController@login');
        $api->post('logout', 'App\\Api\\V1\\Controllers\\LogoutController@logout');
        $api->get('me', 'App\\Api\\V1\\Controllers\\UserController@me');
    });
});

Route::post('register', 'AuthSellerController@register');
Route::post('login', 'AuthSellerController@login');
Route::get('product/{id}', 'ProductController@product')->middleware('jwt.auth');
