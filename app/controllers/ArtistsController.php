<?php

class ArtistsController extends \BaseController {

    /**
     * 
     * @return type
     */
    public function index() {
        return Jsend::success(Artist::with('genres')->get());
    }

    /**
     * 
     * @return type
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
            if (ctype_digit($genre['id'])) {
                $genre['id'] = (int) $genre['id'];
            }

            $validationGenre = Genre::validate(array(
                        'id' => $genre['id'],
                        'name_de' => $genre['name_de']));
            if ($validationGenre !== true) {
                return Jsend::fail($validationGenre);
            }

            if (!Genre::existTechId($genre['id'])) {
                if (!Genre::existTechId($genre['id'])) {
                    return Jsend::error('genre not found');
                }
            }

            $artist = new Artist();
            $artist->name = $artistName;
            $artist->short_description_de = $artistSD;
            $artist->complete_description_de = $artistCD;
            $artist->save();

            foreach ($genres as $genre) {
                $artist->genres()->attach($genre['id']);
            }
            return Jsend::success($artist->toArray());
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

        return Jsend::success($artist->with('genres')->find($id));
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
     * @param  $id The id of the specified resource
     * @return Jsend::error An error message if the ressource doesn't exist or exist but you are trying to rewrite it
     * @return Jsend::success A validation message
     */
    public function destroy($id) {
         if (ctype_digit($id)) {
            $id = (int) $id;
        }
        $artist = Artist::find($id);
        if (!isset($artist)) {
            return Jsend::error('resource not found');
        }
        $artist->delete();
        return Jsend::success('Artist deleted');
    }

}
