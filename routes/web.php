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
	
	Route::prefix('client')->group(function () {
		Route::get('/active', 'CabinetClientController@active')->name('client_active')->middleware('auth');
		Route::get('/complete', 'CabinetClientController@complete')->name('client_complete')->middleware('auth');
	});
	
	Route::prefix('courier')->group(function () {
		Route::get('/active', 'CabinetCourierController@active')->name('courier_active')->middleware('auth');
		Route::get('/complete', 'CabinetCourierController@complete')->name('courier_complete')->middleware('auth');
	});
	
});

Route::match(['get', 'post'], '/save', ['uses' => 'OrderController@create', 'as' => 'create_order'])->middleware('auth');

Route::get('/profile', 'UserController@profile')->name('profile')->middleware('auth');

Route::post('/profile', 'UserController@updateAvatar')->middleware('auth');

Route::get('MarkAllSeen', 'OrderController@allSeen')->middleware('auth');

Route::post('/user/rating', 'UserController@updateRating');

/*
 * socialite authentication with Facebook, Google
 */
Route::get('login/facebook', 'Auth\SocialAuthController@redirectToProvider_facebook')->name('login_facebook');
Route::get('login/facebook/callback', 'Auth\SocialAuthController@handleProviderCallback_facebook');
Route::post('login/facebook/callback', 'Auth\SocialAuthController@saveAuthSocial')->name('auth_social');

Route::get('login/google', 'Auth\SocialAuthController@redirectToProvider_google')->name('login_google');
Route::get('login/google/callback', 'Auth\SocialAuthController@handleProviderCallback_google');
Route::post('login/google/callback', 'Auth\SocialAuthController@saveAuthSocial')->name('auth_social');