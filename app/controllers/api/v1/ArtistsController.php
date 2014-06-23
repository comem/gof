<?php

namespace api\v1;

use \Jsend;
use \Input;
use \Genre;
use \Artist;
use \ArtistGenre;
use \BaseController;


class ArtistsController extends BaseController {

    /**
     * Permet d'afficher tous les artists
     * @return jsend
     */
    public function index() {
        return Jsend::success(Artist::with('genres')->get());
    }

    /**
     * Permet d'enregistrer un nouvel artist
     * @param (string) name - Le nom de l'artist
     * @param (string) short_description_de - Une courte description de l'artist
     * @param (string) complete_description_de - Une description complete de l'artist
     * @param (array) genre - Les genres de l'artist
     * 
     * @return jsend
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
                if (!ArtistGenre::existTechId($artist->id, $genre['id'])) {
                    $artist->genres()->attach($genre['id']);
                    return Jsend::success($artist->toArray(), 201);
                }
                return Jsend::error('description already exists');
            }
        }
    }

    /**
     * Permet d'afficher un artist
     *
     * @param  int  $id - l'id de l'artist à afficher
     * @return jsend
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
     * Permet de modifier un artist
     * @param  int  $id - l'id de l'artist à modifier
     * @param (string) name - Le nom de l'artist
     * @param (string) short_description_de - Une courte description de l'artist
     * @param (string) complete_description_de - Une description complete de l'artist
     * 
     * @return jsend
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
     * Pas implémentée pour l'instant
     */
    public function destroy($id) {
        
    }

}
