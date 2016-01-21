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

Route::get('/', function () {
    return view('welcome');
});
Route::get('home', function () {
    return view('welcome');
});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::get('getFacebookAuthUrl', 'FacebookAuthController@getAuthUrl');
Route::get('login', 'FacebookAuthController@authenticate');

Route::group(['middleware' => 'auth'], function () {
    Route::get('executeGetRequest', 'FacebookRequestController@executeGetRequest');
    Route::get('rdf', 'RdfController@test');
    Route::get('createAuthUrl', 'GoogleAuthController@createAuthUrl');
    Route::get('oauth2callback', 'GoogleAuthController@oauth2callback');
    Route::get('buildGraph', 'GraphController@makeGraph');
});