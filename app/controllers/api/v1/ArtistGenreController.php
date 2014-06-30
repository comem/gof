<?php

namespace api\v1;

use \Jsend;
use \BaseController;
use \Input;
use \Artist;
use \Genre;
use \ArtistGenre;



class ArtistGenreController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return Jsend::success(ArtistGenre::all()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($artist_id, $genre_id) {
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
