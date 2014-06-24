<?php

namespace api\v1;

use \Jsend;
use \Input;
use \DB;
use \Genre;
use \Artist;
use \Musician;
use \ArtistMusician;
use \Instrument;
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
     * @var (string) name - Le nom de l'artist
     * @var (string) short_description_de - Une courte description de l'artist
     * @var (string) complete_description_de - Une description complete de l'artist
     * @var (array) genre - Les genres de l'artist
     * 
     * @return Jsend::fail Un message d'erreur si les données entrées ne correspondent pas aux données demandées.
     * @return Jsend::error Un message d'erreur si le genre n'existe pas.
     * @return Jsend::success Sinon, un message de validation d'enregistrement contenant l'artist créé.
     */
    public function store() {
        $artistName = Input::get('name');
        $artistSD = Input::get('short_description_de');
        $artistCD = Input::get('complete_description_de');
        $genres = Input::get('genres');
        $musicianInstruments = Input::get('musicianInstruments');
        $musicians = Input::get('musicians');



        DB::beginTransaction();

        $validationArtist = Artist::validate(array(
                    'name' => $artistName,
                    'short_description_de' => $artistSD,
                    'complete_description_de' => $artistCD,
        ));


        if ($validationArtist !== true) {
            return Jsend::fail($validationArtist, 400);
        }

        $artist = new Artist();
        $artist->name = $artistName;
        $artist->short_description_de = $artistSD;
        $artist->complete_description_de = $artistCD;
        $artist->save();


        foreach ($genres as $genre) {
            if (ctype_digit($genre['id'])) {
                $genre['id'] = (int) $genre['id'];
            }

            $validationGenre = Genre::validate(array(
                        'id' => $genre['id'],
            ));
            if ($validationGenre !== true) {

                return Jsend::fail($validationGenre, 400);
            }

            if (!Genre::existTechId($genre['id'])) {
                if (!Genre::existTechId($genre['id'])) {

                    return Jsend::error('genre not found', 404);
                }
            }
            $artist->genres()->attach($genre['id']);
        }


        if (isset($musicianInstruments)) {
            foreach ($musicianInstruments as $musicianInstrument) {
                if (ctype_digit($musicianInstrument['musician_id'])) {
                    $musicianInstrument['musician_id'] = (int) $musicianInstrument['musician_id'];
                }
                if (ctype_digit($musicianInstrument['instrument_id'])) {
                    $musicianInstrument['instrument_id'] = (int) $musicianInstrument['instrument_id'];
                }

                $musician_id = $musicianInstrument['musician_id'];
                $instrument_id = $musicianInstrument['instrument_id'];
                $validationMusician = Musician::validate(array('id' => $musician_id));
                if ($validationMusician !== true) {
                    return Jsend::fail($validationMusician, 400);
                }

                if (!Musician::existTechId($musician_id)) {
                    return Jsend::error('musician id :' . $musician_id . ' not found');
                }

                $validationInstrument = Instrument::validate(array('id' => $instrument_id));
                if ($validationMusician !== true) {
                    return Jsend::fail($validationInstrument, 400);
                }

                if (!Instrument::existTechId($instrument_id)) {
                    return Jsend::error('instrument id :' . $instrument_id . ' not found', 404);
                }
                $artistMusician = new ArtistMusician();
                $artistMusician->musician_id = $musician_id;
                $artistMusician->artist_id = $artist->id;
                $artistMusician->instrument_id = $instrument_id;
                $artistMusician->save();
            }
        }

        if (isset($musicians)) {

            foreach ($musicians as $musician) {
                $first_name = $musician['first_name'];
                $last_name = $musician['last_name'];
                $stagename = $musician['stagename'];
                $musicianInstrument_id = $musician['instrument_id'];
                $validationInstrument = Instrument::validate(array('id' => $musicianInstrument_id));
                $validationMusician = Musician::validate(array(
                            'first_name' => $first_name,
                            'last_name' => $last_name,
                            'stagename' => $stagename
                ));

                if ($validationMusician !== true) {
                    return Jsend::fail($validationMusician, 400);
                }

                if ($validationInstrument !== true) {
                    return Jsend::fail($validationInstrument, 400);
                }

                if (Instrument::existTechId($musicianInstrument_id) !== true) {
                    return Jsend::error("instrument dosen't exists in the database", 404);
                }

                $musicianToSave = new Musician();
                $musicianToSave->first_name = $first_name;
                $musicianToSave->last_name = $last_name;
                $musicianToSave->stagename = $stagename;
                $musicianToSave->save();
                $artistMusician = new ArtistMusician();
                $artistMusician->musician_id = $musicianToSave->id;
                $artistMusician->artist_id = $artist->id;
                $artistMusician->instrument_id = $musicianInstrument_id;
                $artistMusician->save();
            }
        }
        DB::commit();
        return Jsend::success($artist->toArray());
    }

    /**
     * Permet d'afficher un artist
     *
     * @param  int  $id - l'id de l'artist à afficher
     * @return Jsend::fail Un message d'erreur si les données entrées ne correspondent pas aux données demandées.
     * @return Jsend::success Sinon, un artist avec genre correspondant l'enregistrement demandé.
     */
    public function show($id) {

        if (ctype_digit($id)) {
            $id = (int) $id;
        }
        $validationArtist = Artist::validate(array('id' => $id));
        if ($validationArtist !== true) {
            return Jsend::fail($validationArtist, 400);
        }

        $artist = Artist::find($id);

        if (!isset($artist)) {
            return Jsend::error('resource not found', 404);
        }

        return Jsend::success($artist->with('genres')->find($id), 200);
    }

    /**
     * Permet de modifier un artist
     * @param int $id - l'id de l'artist a modifier
     * @var (string) name - Le nom de l'artist
     * @var (string) short_description_de - Une courte description de l'artist
     * @var (string) complete_description_de - Une description complete de l'artist
     * 
     * @return Jsend::fail Un message d'erreur si les données entrées ne correspondent pas aux données demandées.
     * @return Jsend::error Un message d'erreur si l'artist à modifier n'existe pas.
     * @return Jsend::success Sinon, un message de validation de modification de l'artist concerné.
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
