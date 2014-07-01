<?php

namespace api\v1;

use \Jsend;
use \BaseController;
use \Input;
use \Artist;
use \Genre;
use \ArtistGenre;
use \DB;


/**
 * REST controller with index, store and destroy methods implemented.
 * 
 * Corresponds to the "description" class of the class diagram.
 *
 * @category  Application services
 * @version   1.0
 * @author    gof
 */
class ArtistGenreController extends BaseController {

    /**
     * Allows to display every artistgenre from the database.
     * @return Response Jsend::success with all artistgenre.
     */
    public function index() {
        return Jsend::success(ArtistGenre::all()->toArray());
    }

    /**
     * Allows to save a new artistgenre.
     * @var artist_id (int) - the artist name (get)
     * @var short_description (int) - a short description (get)
     * 
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if a resource was not found.
     * @return Response Jsend::success if a new artist was created.
     */
    public function store() {
        $artist_id = Input::get('artist_id');
        $genre_id = Input::get('genre_id');


        if (ctype_digit($artist_id)) {
            $artist_id = (int) $artist_id;
        }
        if (ctype_digit($genre_id)) {
            $genre_id = (int) $genre_id;
        }

        $validationArtist = Artist::validate(array('id' => $artist_id));
        $validationGenre = Genre::validate(array('id' => $genre_id));

        if ($validationArtist !== true) {
            return Jsend::fail($validationArtist);
        }
        if ($validationGenre !== true) {
            return Jsend::fail($validationGenre);
        }

        if (!Artist::existTechId($artist_id)) {
            return Jsend::error('artist not found');
        }

        if (!Genre::existTechId($genre_id)) {
            return Jsend::error('genre not found');
        }


        if (!ArtistGenre::existTechId($artist_id, $genre_id)) {
            $artistGenre = new ArtistGenre();
            $artistGenre->artist_id = $artist_id;
            $artistGenre->genre_id = $artist_id;
            $artistGenre->save();
        } else {
            return Jsend::error('description already exists');
        }

        return Jsend::success(array("id_artist" => $artist_id, "id_genre" => $genre_id));
    }

    /**
     * @ignore
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * @ignore
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */

    public function update($id) {

        
    }

    /**
     * Removes the specified resource from storage.
     * @param  int -  the id from the artist (url)
     * @var genre_id (int) - the id from the genre (get) 
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if the required resource was not found.
     * @return Response Jsend::success if the artistgenre was deleted.
     */
    public function destroy($artist_id) {


        $genre_id = Input::get('genre_id');

        if (ctype_digit($artist_id)) {
            $artist_id = (int) $artist_id;
        }
        if (ctype_digit($genre_id)) {
            $genre_id = (int) $genre_id;
        }


        // Validation Artist
        $validationArt = Artist::validate(array('id' => $artist_id));
        if ($validationArt !== true) {
            return Jsend::fail($validationArt);
        }


        if (!Artist::existTechId($artist_id)) {
            return Jsend::error('artist_id :', $artist_id . ' not found');
        }

        // Validation Genre
        $validationGenre = Genre::validate(array('id' => $genre_id));
        if ($validationGenre !== true) {
            return Jsend::fail($validationGenre, 400);
        }


        if (!Genre::existTechId($genre_id)) {
            return Jsend::error('genre id :' . $genre_id . ' not found', 404);
        }
       

        if (!ArtistGenre::existTechId($artist_id, $genre_id)) {
            return Jsend::error("association doesn't exist");
        }


        DB::table('artist_genre')
                ->where('artist_id', '=', $artist_id)
                ->where('genre_id', '=', $genre_id)
                ->delete();



        return Jsend::success('Association deleted');
    }

}
