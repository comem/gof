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
Route::get('/', function (){
    return Redirect::to(URL::action('AuthController@getIndex'));
});

Route::group(array('before' => 'auth'), function()
{
    // Permet d'implÃ©menter post avec une architecture REST
    Route::resource('artist_event', 'Artist_eventsController');
    Route::resource('artist_genre', 'Artist_genresController');
    Route::resource('artist_musician', 'Artist_musiciansController');
    Route::resource('artists', 'ArtistsController');
    Route::resource('event_platform', 'Event_platformsController');
    Route::resource('event_ticketcategorie', 'Event_ticketcategoriesController');
    Route::resource('events', 'EventsController');
    Route::resource('eventtypes', 'EventtypesController');
    Route::resource('genres', 'GenresController');
    Route::resource('images', 'ImagesController');
    Route::resource('instruments', 'InstrumentsController');
    Route::resource('links', 'LinksController');
    Route::resource('musicians', 'MusiciansController');
    Route::resource('platforms', 'PlatformsController');
    Route::resource('ticketcategories', 'TicketCategoriesController');
    Route::resource('index', 'IndexController');
});

// Routage pour le controller de la gestion des authentifications
Route::controller('/auth', 'AuthController');