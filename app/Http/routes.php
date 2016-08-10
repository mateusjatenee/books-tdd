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

Route::group(['prefix' => 'api', 'middleware' => 'api', 'namespace' => 'Api'], function () {
    Route::resource('books', 'BooksController');

    Route::group(['prefix' => 'auth', 'namespace' => 'Auth', 'as' => 'api.auth'], function () {
        Route::post('login', 'AuthController@login')->name('.login');
        Route::post('register', 'AuthController@register')->name('.register');
    });

});
