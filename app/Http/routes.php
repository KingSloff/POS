<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes...
Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function()
{
    Route::get('login', [
        'as' => 'login',
        'uses' => 'AuthController@getLogin'
    ]);

    Route::post('login', [
        'as' => 'login',
        'uses' => 'AuthController@postLogin'
    ]);

    Route::get('logout', [
        'as' => 'logout',
        'uses' => 'AuthController@getLogout'
    ]);
});

Route::group(['middleware' => 'auth'], function()
{
    Route::resource('product', 'ProductController');

    Route::resource('product.stock', 'StockController',[
        'except' => ['index', 'show']
    ]);
});
