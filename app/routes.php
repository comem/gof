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

Route::get('/', function()
{
	return View::make('hello');
});
Route::group(array('before' => 'auth'), function()
{
    // Permet d'implÃ©menter post avec une architecture REST
    Route::resource('artist_event', 'Artist_event');
    Route::resource('artist_genre', 'Artist_genre');
    Route::resource('artist_musician', 'Artist_musician');
    Route::resource('artists', 'Artists');
    Route::resource('event_platform', 'Event_platform');
    Route::resource('event_ticketcategorie', 'Event_ticketcategorie');
    Route::resource('events', 'Events');
    Route::resource('eventtypes', 'Eventtypes');
    Route::resource('genres', 'Genres');
    Route::resource('images', 'Images');
    Route::resource('instruments', 'Instruments');
    Route::resource('links', 'Links');
    Route::resource('musicians', 'Musicians');
    Route::resource('platforms', 'Platforms');
    Route::resource('ticketcategories', 'TicketCategories');
});

// Routage pour le controller de la gestion des authentifications
Route::controller('/auth', 'Auth');

