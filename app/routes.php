<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

// Page d'accueil
Route::get('/', function () {
    return Redirect::to(URL::action('AuthController@getIndex'));
});



Route::group(
       array(
    'prefix' => 'api/v1',
    'namespace' => 'api\v1',
    'before' => array(/* 'auth', 'acl_rest' */),
        ), function() {
    Route::get('artists/search', 'ArtistsController@search');
    Route::get('musicians/search', 'MusiciansController@search');
    Route::get('genres/search', 'GenresController@search');
    Route::get('instruments/search', 'InstrumentsController@search');
    Route::resource('artists', 'ArtistsController');
    Route::resource('nightplatform', 'NightPlatformController');

    Route::resource('musicians', 'MusiciansController');
    Route::resource('artistnight', 'ArtistNight');
    Route::resource('nightticketcategorie', 'NightTicketcategorieController');
    Route::resource('images', 'ImagesController');
    Route::resource('instruments', 'InstrumentsController');
    Route::resource('genres', 'GenresController');
    Route::resource('links', 'LinksController');
    Route::resource('platforms', 'PlatformsController');

    Route::resource('nights', 'NightsController');

    Route::resource('artistmusician', 'ArtistMusicianController');
    Route::resource('nights', 'NightsController');
}
);

// Routage pour le controller de la gestion des authentifications
Route::controller('/auth', 'AuthController');
