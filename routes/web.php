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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*
|--------------------------------------------------------------------------
| Transactions
|--------------------------------------------------------------------------
*/
Route::get('/transactions', 'TransactionsController@index')->name('Transactions');

Route::get('/vue-demo', 'HomeController@vue_demo')->name('Vue.js Demo');

/*
|--------------------------------------------------------------------------
| API / Endpoints
|--------------------------------------------------------------------------
*/
Route::prefix('api')->group(function () {
    Route::prefix('transactions')->group(function () {
        Route::get('user_categories', 'TransactionsAPIController@user_categories');
        Route::post('all', 'TransactionsAPIController@get_all_transactions');
        Route::get('recent/{type?}', 'TransactionsAPIController@get_recent_transactions');
        Route::post('save', 'TransactionsAPIController@save');
    });
});
