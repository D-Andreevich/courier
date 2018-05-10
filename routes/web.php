<?php
Route::get('/', 'Home\HomeView')->name('home');

Auth::routes();

/*
 * order auth
 */
Route::middleware('auth')->prefix('order')->group(function () {
	Route::get('/add', 'Order\OrderViewForm')->name('add_order');
	Route::post('/accept', 'Order\OrderAccept');
	Route::post('/save', 'Order\OrderCreate')->name('create_order');
	Route::post('/remove', 'Order\OrderRemove');
	Route::post('/deny', 'Order\OrderDeny');
	Route::post('/restore', 'Order\OrderRestore');
	Route::any('/taken/{id}/{token}', 'Order\OrderTaken')->name('taken_order');
	Route::any('/delivered/{token}', 'Order\OrderDelivered');
	Route::any('/confirm/{token}', 'Order\OrderConfirmed');
    Route::get('/markAllSeen', 'Order\OrderAllSeen');

});
/*
 * order no auth
 */
Route::prefix('order')->group(function () {
    Route::post('/get', 'Order\OrderGet');
    Route::get('/{id}/tracking/{token}', 'TrackingController@trackingMap');
});
/*
 * cabinet
 */
Route::middleware('auth')->prefix('cabinet')->group(function () {
	Route::prefix('client')->group(function () {
		Route::get('/active', 'Cabinet\CabinetClientActive')->name('client_active');
		Route::get('/complete', 'Cabinet\CabinetClientComplete')->name('client_complete');
	});
	
	Route::prefix('courier')->group(function () {
		Route::get('/active', 'Cabinet\CabinetCourierActive')->name('courier_active');
		Route::get('/complete', 'Cabinet\CabinetCourierComplete')->name('courier_complete');
	});
});
/*
 * profile
 */
Route::prefix('profile')->group(function () {
    Route::get('/', 'User\UserViewProfile')->name('profile')->middleware('auth');
    Route::post('/', 'User\UserUpdateAvatar')->middleware('auth');
    Route::post('/notification', 'Notification\NotificationGet')->name('noty');
    Route::post('/rating', 'User\UserUpdateRating');
});

/*
 * socialite authentication with Facebook, Google
 */
Route::prefix('login')->group(function () {

    Route::get('/facebook', 'Auth\SocialAuthController@redirectToProvider_facebook')->name('login_facebook');
    Route::get('/facebook/callback', 'Auth\SocialAuthController@handleProviderCallback_facebook');
    Route::post('/facebook/callback', 'Auth\SocialAuthController@saveAuthSocial')->name('auth_social');

    Route::get('/google', 'Auth\SocialAuthController@redirectToProvider_google')->name('login_google');
    Route::get('/google/callback', 'Auth\SocialAuthController@handleProviderCallback_google');
    Route::post('/google/callback', 'Auth\SocialAuthController@saveAuthSocial')->name('auth_social');
});

//Route::get('/tracking', 'TrackingController@trackingMap');
Route::get('/getPosition', 'TrackingController@getPosition');
Route::any('/savepos', 'TrackingController@positionGoToDB');


//Route::get('socket', 'SocketController@index');
Route::get('/chat', 'ChatController@getIndex');
Route::post('/chat/message', 'ChatController@setMessage');

Route::post('sendmessage', 'SocketController@sendMessage');
Route::get('writemessage', 'SocketController@writemessage');