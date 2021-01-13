<?php

use Illuminate\Http\Request;

// Events
Route::get('events', 'EventController@getEvents');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user-events', 'EventController@getEvents');
    Route::post('user-events/delete', 'EventController@deleteEvent');

    // Admin routes
    Route::group(['middleware' => ['role:admin|superadmin']], function () {
        // Orders
        Route::get('orders', 'OrderController@getOrders');
        Route::post('orders', 'OrderController@storeOrder');
        Route::post('orders/delete', 'OrderController@deleteOrder');
    });

    // Logout
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
