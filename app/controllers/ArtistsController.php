<?php

class ArtistsController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return Jsend::success(Artist::all()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $artistName = Input::get('name');
        $artistSD = Input::get('short_description_de');
        $artistCD = Input::get('complete_description_de');
        $genres = Input::get('genre');

        $validationArtist = Artist::validate(array(
                    'name' => $artistName,
                    'short_description_de' => $artistSD,
                    'complete_description_de' => $artistCD,
        ));
        if ($validationArtist !== true) {
            return Jsend::fail($validationArtist);
        }
        foreach ($genres as $genre) {

            $validationGenre = Genre::validate(array('id' => (int) $genre['id'], 'name_de' => $genre['name_de']));
            if ($validationGenre !== true) {
                return Jsend::fail($validationGenre);
            }

            if (!Genre::existTechId($genre['id'])) {
                if (!Genre::existTechId((int) $genre['id'])) {

                    return Jsend::error($genre['name_de'] . ' not found');
                }
            }

            $artist = new Artist();
            $artist->name = $artistName;
            $artist->short_description_de = $artistSD;
            $artist->complete_description_de = $artistCD;
            $artist->save();
            foreach ($genres as $genre) {
                if (!ArtistGenre::existTechId($artist->id, $genre['id'])) {
                    $description = new ArtistGenre();
                    $description->artist_id = $artist->id;
                    $description->genre_id = $genre['id'];
                    $description->save();
                    return Jsend::success(array("id" => $artist->id));
                }
                return Jsend::error('description already exists');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {

        if (ctype_digit($id)) {
            $id = (int) $id;
        }
        $validationArtist = Artist::validate(array('id' => $id));
        if ($validationArtist !== true) {
            return Jsend::fail($validationArtist);
        }

        $artist = Artist::find($id);

        if (!isset($artist)) {
            return Jsend::error('resource not found');
        }

        return Jsend::success($artist->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {

        if (ctype_digit($id)) {
            $id = (int) $id;
        }

        $artistName = Input::get('name');
        $artistSD = Input::get('short_description_de');
        $artistCD = Input::get('complete_description_de');
        $validationArtist = Artist::validate(array(
                    'name' => $artistName,
                    'short_description_de' => $artistSD,
                    'complete_description_de' => $artistCD,
        ));
        if ($validationArtist !== true) {
            return Jsend::fail($validationArtist);
        }

        $artist = Artist::find($id);
        if (!isset($artist)) {
            return Jsend::error('resource not found');
        }

        $artist->name = $artistName;
        $artist->short_description_de = $artistSD;
        $artist->complete_description_de = $artistCD;
        $artist->save();

        return Jsend::success($artist->toArray());
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
