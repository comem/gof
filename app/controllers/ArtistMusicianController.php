<?php

class ArtistMusicianController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        //
    }

    /**
     * Store a newly created resource in storage.
     * Permet d'enregistrer une nouvelle association entre un musician , un instrument et un artist
     * @var instrument_id(int): id de l'instrument
     * @var artist_id(int): id de l'artist
     * @var musician_id(int): id du musician 
     * @return Jsend::fail Un message d'erreur si les données entrées ne correspondent pas aux données demandées.
     * @return Jsend::error Un message d'erreur si l'artiste n'existe pas.
     * @return Jsend::error Un message d'erreur si l'instrument n'existe pas.
     * @return Jsend::error Un message d'erreur si le musician n'existe pas.
     * @return Jsend::success Sinon, un message de validation d'enregistrement contenant les informations des données enregistrée.
     * 
     */
    public function store() {

        $instrument_id = Input::get('instrument_id');
        $artist_id = Input::get('artist_id');
        $musician_id = Input::get('musician_id');

        $artistMusician = ArtistMusicianController::saveArtistMusician($artist_id, $instrument_id, $musician_id);

        if (!is_a($artistMusician, 'ArtistMusician')) {
            return Jsend::error($artistMusician);
        }

        return Jsend::success(array('musician id' => $musician_id,
                    'artsit id' => $artist_id,
                    'instrument id' => $instrument_id));
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

        // mettre les parametre get. il va le trouver dans la requete.
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

    public static function saveArtistMusician($artist_id, $instrument_id, $musician_id) {

        if (ctype_digit($musician_id)) {
            $musician_id = (int) $musician_id;
        }
        if (ctype_digit($instrument_id)) {
            $instrument_id = (int) $instrument_id;
        }

        if (ctype_digit($artist_id)) {
            $artist_id = (int) $artist_id;
        }
        // Validation Artist
        $validationArt = Artist::validate(array('id' => $artist_id));
        if ($validationArt !== true) {
            return Jsend::fail($validationArt);
        }

        if (!Artist::existTechId($artist_id)) {
            return Jsend::error($artist_id . ' not found');
        }
        // Validation Musician
        $validationMusician = Musician::validate(array('id' => $musician_id));
        if ($validationMusician !== true) {
            return Jsend::fail($validationMusician, 400);
        }

        if (!Musician::existTechId($musician_id)) {
            return Jsend::error('musician id :' . $musician_id . ' not found', 404);
        }
        // Validation instrument

        $validationInstrument = Instrument::validate(array('id' => $instrument_id));
        if ($validationMusician !== true) {
            return Jsend::fail($validationInstrument, 400);
        }

        if (!Instrument::existTechId($instrument_id)) {
            return Jsend::error('instrument id :' . $instrument_id . ' not found', 404);
        }


        $artistMusician = new ArtistMusician();
        $artistMusician->musician_id = $musician_id;
        $artistMusician->artist_id = $artist_id;
        $artistMusician->instrument_id = $instrument_id;
        $artistMusician->save();
        
        return $artistMusician;
    }

}
