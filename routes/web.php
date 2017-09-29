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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::prefix('order')->group(function () {
	Route::get('/add', 'OrderController@add')->name('add_order')->middleware('auth');
	Route::post('/accept', 'OrderController@accept')->middleware('auth');
	Route::post('/remove', 'OrderController@remove')->middleware('auth');
	Route::post('/deny', 'OrderController@deny')->middleware('auth');
	Route::any('/taken/{id}/{token}', 'OrderController@taken')->name('taken_order')->middleware('auth');
	Route::any('/delivered/{token}', 'OrderController@delivered');
});

Route::prefix('cabinet')->group(function () {
	Route::get('/client', 'CabinetClientController@index')->name('client')->middleware('auth');
	Route::get('/courier', 'CabinetCourierController@index')->name('courier')->middleware('auth');
});

Route::get('/qrcodes', 'QrCodeController@index')->name('qrcodes')->middleware('auth');


Route::match(['get', 'post'], '/save', ['uses' => 'OrderController@create', 'as' => 'create_order'])->middleware('auth');

Route::get('/profile', 'UserController@profile')->name('profile')->middleware('auth');

Route::post('/profile', 'UserController@updateAvatar')->middleware('auth');

Route::get('MarkAllSeen', 'OrderController@allSeen')->middleware('auth');

Route::post('/user/rating', 'UserController@updateRating');


