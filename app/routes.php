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

<<<<<<< HEAD

=======
//array('auth', 'acl_rest')
>>>>>>> master
Route::group(array('before' => array('auth')), function()
{
// Permet d'implÃ©menter post avec une architecture REST
// Permet d'implÃ©menter post avec une architecture REST

    Route::resource('artistnight', 'ArtistNightController');
    Route::resource('artistgenre', 'ArtistGenreController');
    Route::resource('artistmusician', 'ArtistMusicianController');
    Route::resource('artists', 'ArtistsController');
    Route::resource('nightplatform', 'NightPlatformController');
    Route::resource('nightticketcategorie', 'NightTicketcategorieController');
    Route::resource('nights', 'NightsController');
    Route::resource('nighttypes', 'NighttypesController');
    Route::resource('genres', 'GenresController');
    Route::resource('images', 'ImagesController');
    Route::resource('instruments', 'InstrumentsController');
    Route::resource('links', 'LinksController');
    Route::resource('musicians', 'MusiciansController');
    Route::resource('platforms', 'PlatformsController');
    Route::resource('ticketcategories', 'TicketcategoriesController');
    Route::resource('index', 'IndexController');
});


Route::group(
    array (
        'prefix'    => 'api/v1',
        'namespace' => 'api\v1',
        'before'    => array(/*'auth', 'acl_rest'*/),
    ), function() {
        Route::resource('artists', 'ArtistsController');
        Route::resource('nightplatform', 'NightPlatformController');
    }
);

// Routage pour le controller de la gestion des authentifications
Route::controller('/auth', 'AuthController');
