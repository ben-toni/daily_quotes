<?php

Auth::routes(['register' => false, 'reset' => false, 'confirm' => false, 'verify' => false ]);

Route::get('/', 'HomeController')->name('home');

Route::get('status/subscribers/{subscriber}/{status}', 'SubscriberController@updateStatus')->name('change-status-mail')->middleware('signed');
Route::post('/subscribers', 'SubscriberController@store');
Route::get('/mail/subscribers/{subscriber}', 'SubscriberController@sendMail');
Route::get('/active/subscribers/{subscriber}', 'SubscriberController@updateActiveStatus');


Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::post('index/quotes', 'QuoteController@indexData');
    Route::resource('/quotes', 'QuoteController')->except(['show', 'create']);

    Route::get('index/users', 'UserController@indexData');
    Route::resource('/users', 'UserController')->only(['index']);

    Route::post('index/subscribers', 'SubscriberController@indexData');
    Route::resource('/subscribers', 'SubscriberController')->only(['index', 'update']);
});
