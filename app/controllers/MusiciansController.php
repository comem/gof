<?php

class MusiciansController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return l'ensemble pérstitant des musiciens
     */
    public function index() {

       return Jsend::success(Musician::all()->toArray());
    }

    /**
     * 
     * 
     * Store a newly created resource in storage.
     * Permet d'enregistré un musician et une association entre ce musician , un instrument et un artist
     * @var first_name : attribut de la table musician
     * @var last_name : attribut de la table musician
     * @var satgename : attribut de la table musician
     * @var artistsInstruments : tableau avec les valeurs des id des artists et instruments correponsant à l'artiste
     * @return Jsend::fail Un message d'erreur si les données entrées ne correspondent pas aux données demandées.
     * @return Jsend::error Un message d'erreur si l'artiste n'existe pas.
     * @return Jsend::error Un message d'erreur si l'instrument n'existe pas.
     * @return Jsend::error Un message d'erreur si l'association entre un musician un groupe et un instrument existe déjà.
     * @return Jsend::success Sinon, un message de validation d'enregistrement contenant les informations des données enregistrée.
     *
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

        if ($artistsInstruments !== null) {
            foreach ($artistsInstruments as $aI) {
                
                $instrument_id = $aI['instrument_id'];
                $artist_id = $aI['artist_id'];

                if (ctype_digit( $instrument_id)) {
                     $instrument_id = (int) $instrument_id;
                }

                if (ctype_digit( $artist_id )) {
                     $artist_id  = (int) $artist_id ;
                }
             

                $validationInstru = Instrument::validate(array('id' => $instrument_id));
                if ($validationInstru !== true) {
                    return Jsend::fail($validationInstru);
                }

                if (!Instrument::existTechId($instrument_id)) {
                    return Jsend::error($instrument_id . ' not found');
                }

                $validationArt = Artist::validate(array('id' =>  $artist_id ));
                if ($validationArt !== true) {
                    return Jsend::fail($validationArt);
                }

                if (!Artist::existTechId( $artist_id )) {
                    return Jsend::error( $artist_id  . ' not found');
                }
                  
            }
        }





        $musician = new Musician();
        $musician->first_name = $first_name;
        $musician->last_name = $last_name;
        $musician->stagename = $stagename;
        $musician->save();

        if ($artistsInstruments !== null){
        
        foreach ($artistsInstruments as $aI) {

               $instrument_id = $aI['instrument_id'];
                $artist_id = $aI['artist_id'];

                if (ctype_digit( $instrument_id)) {
                     $instrument_id = (int)  $instrument_id;
                }

                if (ctype_digit( $artist_id )) {
                     $artist_id =  (int) $artist_id ;
                }



            $validationArtMus = ArtistMusician::validate(array('musician_id' => $musician->id,
                        'artist_id' => $artist_id,
                        'instrument_id' =>  $instrument_id));

            if ($validationArtMus !== true) {
                return Jsend::fail($validationArtMus);
            }

            if (ArtistMusician::existTechId( $instrument_id, $artist_id, $musician->id)) {
                return Jsend::error('assoicate ArtistMusician already exist');
            }


            $artistMusician = new ArtistMusician();
            $artistMusician->musician_id = $musician->id;
            $artistMusician->artist_id = $artist_id;
            $artistMusician->instrument_id =  $instrument_id;
            $artistMusician->save();
            
            return Jsend::success(array('first_name' => $first_name,
                    'last_name' => $last_name,
                    'stagename' => $stagename,
                    'association' => 'artist and instrument'));
            
             
        }
        
        }

        return Jsend::success(array('first_name' => $first_name,
                    'last_name' => $last_name,
                    'stagename' => $stagename,
                    'association' => 'none'));
                    
    }

    /**
     * Affiche le musician correspondant à l'id passée en paramètre
     *
     * @param  int  $id correspond à l'identifiant du musician
     * @return Response retourne le musician correspondant à l'id
     */
    public function show($musician_id) {
        // Auth
        if (ctype_digit($musician_id)) {
            $musician_id = (int) $musician_id;
        }

        if (Musician::existTechId($musician_id) !== true) {
            return Jsend::error("musician doesn't exists in the database");
        }

        $musician = Musician::find($musician_id);

        if (!isset($musician)) {
            return Jsend::error('muscian id : ' . $musician_id . 'resource not found');
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
