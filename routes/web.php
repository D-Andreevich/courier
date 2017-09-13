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

Route::get('order/add', 'OrderController@add')->name('add_order')->middleware('auth');

Route::get('/qrcodes', 'QrCodeController@index')->name('qrcodes')->middleware('auth');

Route::prefix('cabinet')->group(function () {
	Route::get('/client', 'CabinetClientController@index')->name('client')->middleware('auth');
	Route::get('/courier', 'CabinetCourierController@index')->name('courier')->middleware('auth');
});

Route::match(['get', 'post'], '/save', ['uses' => 'OrderController@create', 'as' => 'create_order'])->middleware('auth');

Auth::routes();

Route::post('/accepted_order', 'AcceptedOrderController@store')->middleware('auth');

Route::post('/change_status', 'OrderController@changeStatus')->middleware('auth');

Route::get('MarkAllSeen', 'OrderController@allSeen')->middleware('auth');

