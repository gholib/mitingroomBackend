<?php

Route::get('auth/verify_email/{email}/{verify_token}', 'Auth\AuthController@verifyUserEmail');
Route::group(['middleware' => 'cors'], function () {
    Route::post('login', 'Auth\AuthController@login');
    Route::post('register', 'Auth\AuthController@register');
    Route::get('/images/{path}', 'MediaController@getImage');

    Route::post('auth/forgot_password', 'Auth\AuthController@forgotUserPassword');
    Route::post('auth/reset_password', 'Auth\AuthController@resetUserPassword');
});

Route::group(['middleware' => ['auth.jwt', 'cors', 'verified']], function () {
    Route::post('logout', 'Auth\AuthController@logout');
    Route::post('user/edit-account-data', 'Auth\AuthController@updateAccountData');
    Route::get('user/verify-link', 'Auth\AuthController@sendVerifyLink');

    Route::namespace('Room')->group(function () {
        Route::group(['prefix' => 'room'], function () {
            Route::post('/', 'RoomController@store')->middleware('admin');
            Route::get('/', 'RoomController@getAll');
            Route::post('/{room_id}', 'RoomController@update')->middleware('admin')->where(['room_id' => '[0-9]+']);
            Route::delete('/{room_id}', 'RoomController@destroy')->middleware('admin')->where(['room_id' => '[0-9]+']);
            Route::patch('/delete_selected', 'RoomController@destroySelected')->middleware('admin');
        });
    });

    Route::namespace('Reservation')->group(function () {
        Route::group(['prefix' => 'reservation'], function () {
            Route::post('/sort', 'ReservationController@sortBy');
            Route::post('/', 'ReservationController@store');
            Route::get('/{roomId}', 'ReservationController@getAll')->where(['roomId' => '[0-9]+']);
            Route::post('/{reservation_id}', 'ReservationController@update')->where(['reservation_id' => '[0-9]+']);
            Route::delete('/{reservation_id}', 'ReservationController@destroy')->where(['reservation_id' => '[0-9]+']);
        });
    });
});