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
     * Permet d'enregistré une nouvelle association entre un musician , un instrument et un artist
     * @var instrument_id(int), id de l'instrument
     * @var artist_id(int), id de l'artist
     * @var musician_id(int), id du musician 
     * 
     * @return Response JSON 
     */
    public function store() {

        $instrument_id = Input::get('instrument_id');
        $artist_id = Input::get('artist_id');
        $musician_id = Input::get('musician_id');


        if (ctype_digit($artist_id)) {
            $artist_id = (int) $artist_id;
        }

        if (ctype_digit($instrument_id)) {
            $instrument_id = (int) $instrument_id;
        }

        if (ctype_digit($musician_id)) {
            $musician_id = (int) $musician_id;
        }
        
           

        $validationInstru = Instrument::validate(array('id' => $instrument_id));
        
        if ($validationInstru !== true) {
            return Jsend::fail($validationInstru);
        }
        
     

        if (!Instrument::existTechId($instrument_id)) {
            return Jsend::error('instrument id : ' . $instrument_id . ' not found');
        }

        $validationArt = Artist::validate(array('id' => $artist_id));
        if ($validationArt !== true) {
            return Jsend::fail($validationArt);
        }

        if (!Artist::existTechId ($artist_id)) {
            return Jsend::error('artist id :' . $artist_id . '  not found');
        }

        $validationMusician = Musician::validate(array('id' => $musician_id));
        if ($validationMusician !== true) {
            return Jsend::fail($validationMusician);
        }

        if (!Musician::existTechId($musician_id)) {
            return Jsend::error('musician id :' . $musician_id . ' not found');
        }


        $validationArtMus = ArtistMusician::validate(array('musician_id' => $musician_id,
                    'artist_id' => $artist_id,
                    'instrument_id' => $instrument_id));

        if ($validationArtMus !== true) {
            return Jsend::fail($validationArtMus);
        }

        if (ArtistMusician::existTechId($instrument_id, $artist_id, $musician_id)) {
            return Jsend::error('assoicate ArtistMusician already exist');
        }

        $artistMusician = new ArtistMusician();
        $artistMusician->musician_id = (int) $musician_id;
        $artistMusician->artist_id = (int) $artist_id;
        $artistMusician->instrument_id = (int) $instrument_id;
        $artistMusician->save();


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
