<?php

use Illuminate\Support\Facades\Route;

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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::group([
        'middleware' => 'guest'
    ], function () {
        Route::post('check', 'API\Auth\AuthController@check');
        Route::post('register', 'API\Auth\AuthController@register');
        Route::post('login', 'API\Auth\AuthController@login');
        Route::post('confirm', 'API\Auth\AuthController@confirm');
    });
    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::get('user', 'API\Auth\AuthController@user');
        Route::get('logout', 'API\Auth\AuthController@logout');
        Route::put('update', 'API\Auth\AuthController@update');
    });
});

Route::resource('categories', 'API\Categories\CategoryController', [
    'show', 'index'
]);
Route::resource('addresses', 'API\Address\AddressController')
    ->middleware('auth:api');

Route::get('addresses/{address}/shipping', 'API\Address\AddressShippingController@action')
    ->middleware(['auth:api']);

Route::resource('products', 'API\Products\ProductController', [
    'index', 'show'
]);
Route::resource('regions', 'API\Regions\RegionController')
    ->middleware('auth:api');

Route::resource('orders', 'API\Orders\OrderController')
    ->middleware('auth:api');

Route::resource('cart', 'API\Cart\CartController', [
    'parameters ' => [
        'cart' => 'productVariation'
    ]
])->middleware(['auth:api']);

Route::resource('payment-methods','API\PaymentMethods\PaymentMethodController')->middleware(['auth:api']);