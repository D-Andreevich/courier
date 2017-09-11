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

Route::get('/', 'HomeController@index');

Route::get('order/add', 'OrderController@add')->name('add_order');

Route::prefix('cabinet')->group(function () {
	Route::get('/client', 'CabinetClientController@index')->name('client');
	Route::get('/courier', 'CabinetCourierController@index')->name('courier');
});

Route::match(['get', 'post'], '/save', ['uses' => 'OrderController@create', 'as' => 'create_order']);

Auth::routes();

Route::post('/accepted_order', 'AcceptedOrderController@store');

Route::post('/change_status', 'OrderController@changeStatus');

