<?php

namespace api\v1;

use \Jsend;
use \Input;
use \DB;
use \Genre;
use \Artist;
use \Musician;
use \ArtistMusicianController;
use \ArtistMusician;
use \Exception;
use \Instrument;
use \BaseController;
use \MusiciansController;

class ArtistsController extends BaseController {

    /**
     * Permet d'afficher tous les artists
     * @return jsend
     */
    public function index() {
        return Jsend::success(Artist::with('genres')->get(), 200);
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

            $artist = static::saveArtist($artistName, $artistSD, $artistCD, $genres);


            if (isset($musicianInstruments)) {
                foreach ($musicianInstruments as $musicianInstrument) {
                    ArtistMusicianController::saveArtistMusician($musicianInstrument['musician_id'], $artist->id, $musicianInstrument['instrument_id']);
                }
            }

            if (isset($musicians)) {

                foreach ($musicians as $musician) {
                    $musicianToSave = MusiciansController::saveMusician($musician);
                    $musicianInstrument_id = $musician['instrument_id'];
                    $validationInstrument = Instrument::validate(array('id' => $musicianInstrument_id));
                    if ($validationInstrument !== true) {
                        return Jsend::fail($validationInstrument, 400);
                    }

                    if (Instrument::existTechId($musicianInstrument_id) !== true) {
                        return Jsend::error("instrument dosen't exists in the database", 404);
                    }

                    ArtistMusicianController::saveArtistMusician($musicianToSave->id, $artist->id, $musicianInstrument_id);
                }
            }
            DB::commit();
        
        return Jsend::success($artist->toArray(), 201);
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
            return Jsend::fail($validationArtist, 400);
        }

        $artist = Artist::find($id);
        if (!isset($artist)) {
            return Jsend::error('resource not found', 404);
        }

        $artist->name = $artistName;
        $artist->short_description_de = $artistSD;
        $artist->complete_description_de = $artistCD;
        $artist->save();

        return Jsend::success($artist->toArray(), 200);
    }

    /**
     * Pas implémentée pour l'instant
     */
    public function destroy($id) {
        
    }

    public static function saveArtist($artistName, $artistSD, $artistCD, $genres) {
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

        return $artist;
    }

}
