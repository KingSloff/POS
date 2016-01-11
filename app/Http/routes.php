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

/*DB::listen(function($event){
    dump($event->sql);
    dump($event->bindings);
});*/

/**
 * All checkout related routes
 */
Route::group(['middleware' => ['auth']], function() {
    Route::get('/', [
        'as' => 'checkout.index',
        'uses' => 'CheckoutController@index'
    ]);

    Route::post('/', [
        'as' => 'checkout.store',
        'uses' => 'CheckoutController@store'
    ]);

    Route::put('/{cartItem}', [
        'as' => 'checkout.update',
        'uses' => 'CheckoutController@update'
    ]);

    Route::delete('/{cartItem}', [
        'as' => 'checkout.destroy',
        'uses' => 'CheckoutController@destroy'
    ]);

    Route::post('/checkout/{cart}', [
        'as' => 'checkout.checkout',
        'uses' => 'CheckoutController@checkout'
    ]);

    /**
     * All Reports related routes
     */
    Route::get('/reports', [
        'as' => 'report.index',
        'uses' => 'ReportController@index'
    ]);

    Route::get('/reports/stats', [
        'as' => 'report.stats',
        'uses' => 'ReportController@stats'
    ]);

    Route::get('/reports/debtors', [
        'as' => 'report.debtors',
        'uses' => 'ReportController@debtors'
    ]);

    Route::get('/reports/debtors/send-email', [
        'as' => 'report.debtors.send-email',
        'uses' => 'ReportController@sendDebtorEmail'
    ]);

    Route::get('/reports/trial-balance', [
        'as' => 'report.trial-balance',
        'uses' => 'ReportController@trialBalance'
    ]);

    Route::post('/reports/trial-balance/bank', [
        'as' => 'report.trial-balance.bank',
        'uses' => 'ReportController@bank'
    ]);

    Route::post('/reports/trial-balance/withdraw', [
        'as' => 'report.trial-balance.withdraw',
        'uses' => 'ReportController@withdraw'
    ]);

    Route::get('/reports/lists', [
        'as' => 'report.lists',
        'uses' => 'ReportController@lists'
    ]);
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

Route::group(['middleware' => ['auth']], function()
{
    Route::resource('product', 'ProductController');

    Route::post('/product/{product}/writeOff', [
        'as' => 'product.write-off',
        'uses' => 'ProductController@writeOff'
    ]);

    Route::resource('product.stock', 'StockController',[
        'except' => ['index', 'show']
    ]);

    Route::resource('product.order', 'OrderController',[
        'except' => ['index', 'show']
    ]);

    Route::post('/product/{product}/order/{order}/complete', [
        'as' => 'product.order.complete',
        'uses' => 'OrderController@complete'
    ]);

    Route::resource('user', 'UserController');

    Route::post('/user/{user}/pay', [
        'as' => 'user.pay',
        'uses' => 'UserController@pay'
    ]);

    Route::post('/user/{user}/loan', [
        'as' => 'user.loan',
        'uses' => 'UserController@loan'
    ]);
});
