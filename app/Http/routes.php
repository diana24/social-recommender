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
    Route::get('/', function () {
        return view('index');
    });
    Route::get('home', function () {
        return view('index');
    });
    Route::get('profile', function () {
        return view('profile');
    });
    Route::get('executeGetRequest', 'FacebookRequestController@executeGetRequest');
    Route::get('rdf', 'RdfController@getAutoRec');
    Route::get('createAuthUrl', 'GoogleAuthController@createAuthUrl');
    Route::get('oauth2callback', 'GoogleAuthController@oauth2callback');
    Route::get('buildGraph', 'GraphController@makeGraph');

    Route::get('getLiteraryGenres', 'DataController@getAllLiteraryGenres');
    Route::get('getMovieGenres', 'DataController@getAllMovieGenres');
    Route::get('getCountries', 'DataController@getAllCountries');
    Route::get('getEventTypes', 'DataController@getAllEventTypes');
    Route::get('getPlaceTypes', 'DataController@getAllPlaceTypes');
    Route::get('getEduInstitutionTypes', 'DataController@getAllEducationalInstitutionTypes');
    Route::get('getLanguages', 'DataController@getAllLanguages');
    Route::get('getCities', 'DataController@getAllCities');
    Route::get('getIllustrators', 'DataController@getIllustrators');
    Route::get('getAuthors', 'DataController@getAuthors');
    Route::get('getDirectors', 'DataController@getDirectors');
    Route::get('getActors', 'DataController@getActors');
    Route::get('getMusicalArtists', 'DataController@getMusicalArtists');
    Route::get('getPlaces', 'DataController@getPlaces');
    Route::get('getPrincipals', 'DataController@getPrincipals');
    Route::get('getRectors', 'DataController@getRectors');

    Route::get('search/books', 'BookRdfController@searchBooks');
    Route::get('search/films', 'FilmRdfController@searchFilms');
    Route::get('search/events', 'EventRdfController@searchEvents');
    Route::get('search/places', 'PlaceRdfController@searchPlaces');
    Route::get('search/edu', 'EducationalInstitutionController@searchEdu');

    Route::get('recommendations/books', 'BookRdfController@recommendBooks');
    Route::get('recommendations/films', 'FilmRdfController@recommendFilms');

    Route::get('graph', 'GraphController@displayData');
    Route::get('users/me/connected-accounts', 'UserController@getConnectedAccounts');
    Route::get('users/me', 'UserController@show');
    Route::resource('lists', 'ListController@index');
    Route::get('saved_items', 'SavedItemsController@index');
    Route::get('save_item', 'SavedItemsController@store');
    Route::get('addToList', 'ListController@addToList');

    Route::get('search/books/show', function () {
        return view('searchBooks');
    });
    Route::get('search/films/show', function () {
        return view('searchFilms');
    });
    Route::get('search/events/show', function () {
        return view('searchEvents');
    });
    Route::get('search/places/show', function () {
        return view('searchPlaces');
    });
    Route::get('search/people/show', function () {
        return view('searchPeople');
    });
});