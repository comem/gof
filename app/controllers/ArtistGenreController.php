<?php

class ArtistGenreController extends \BaseController {

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
        $validationGenre = Genre::validate(array('genre_id' => $genre_id));

        if ($validationArtist !== true) {
            return Jsend::fail($validationArtist);
        } 
        if ($validationGenre !== true) {
            return Jsend::fail($validationGenre);
        }
        
        if (!Artist::exist($artist_id)) {
            return Jsend::error('resource not found');
        }
        
        if (!Genre::existTechId($genre_id)) {
            return Jsend::error('resource not found');
        }
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
    public function update($id) {
        //
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
