<?php

class MusiciansController extends \BaseController {

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
     *
     * @return Response un message de succès avec les informations sauvée
     */
    public function store() {
        $first_name = Input::get('first_name');
        $last_name = Input::get('last_name');
        $stagename = Input::get('stagename');
        $artistsInstruments = Input::get('artistsInstruments');




        $validationMusician = Musician::validate(array('first_name' => $first_name,
                    'last_name' => $last_name,
                    'stagename' => $stagename));

        if ($validationMusician !== true) {
            return Jsend::fail($validationMusician);
        }

        foreach ($artistsInstruments as $aI) {

            $validationInstru = Instrument::validate(array('id' => (int) $aI['instrument_id']));
            if ($validationInstru !== true) {
                return Jsend::fail($validationInstru);
            }

            if (!Instrument::existTechId((int) $aI['instrument_id'])) {
                return Jsend::error($aI['instrument_id'] . ' not found');
            }

            $validationArt = Artist::validate(array('id' => (int) $aI['artist_id']));
            if ($validationArt !== true) {
                return Jsend::fail($validationArt);
            }

            if (!Artist::existTechId((int) $aI['artist_id'])) {
                return Jsend::error($aI['artist_id'] . ' not found');
            }
        }



        $musician = new Musician();
        $musician->first_name = $first_name;
        $musician->last_name = $last_name;
        $musician->stagename = $stagename;
        $musician->save();


        foreach ($artistsInstruments as $aI) {
           
            
             $validationArtMus = ArtistMusician::validate(array('musician_id' => $musician->id,
                'artist_id' => (int) $aI['artist_id'],
                'instrument_id' => (int) $aI['instrument_id']));
             
               if ($validationArtMus!== true) {
                return Jsend::fail($validationArtMus);
            }
            
             if (ArtistMusician::existTechId((int) $aI['instrument_id'],(int) $aI['artist_id'],$musician->id))
                
                {
                return Jsend::error('assoicate ArtistMusician already exist');
            }
            
             
            $artistMusician = new ArtistMusician();
            $artistMusician->musician_id = $musician->id;
            $artistMusician->artist_id = (int) $aI['artist_id'];
            $artistMusician->instrument_id = (int) $aI['instrument_id'];
            $artistMusician->save();
        }


        return Jsend::success(array('first_name' => $first_name,
                    'last_name' => $last_name,
                    'stagename' => $stagename));
    }

    /**
     * Affiche le musician correspondant à l'id passée en paramètre
     *
     * @param  int  $id correspond à l'identifiant du musician
     * @return Response retourne le musician correspondant à l'id
     */
    public function show($id) {
        // Auth
        if (ctype_digit($id)) {
            $id = (int) $id;
        }

        if (Musician::existTechId($id) !== true) {
            return Jsend::error("musician doesn't exists in the database");
        }

        $musician = Musician::find($id);

        if (!isset($musician)) {
            return Jsend::error('resource not found');
        }
        // Retourne le message encapsulé en JSEND si tout est OK
        return Jsend::success($musician->toArray());
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
