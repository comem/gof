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
        $instrumentArtist = Input::get('instrument');
        
     


        $validationMusician = Musician::validate(array('first_name' => $first_name,
                    'last_name' => $last_name,
                    'stagename' => $stagename));

        if ($validationMusician !== true) {
            return Jsend::fail($validationMusician);
        }
   
        foreach ($instruments as $instru) {

            $validationInstru = Instrument::validate(array('id' => (int) $instru['id'], 'name_de' => $instru['name_de']));
            if ($validationInstru !== true) {
                return Jsend::fail($validationInstru);
            }

            if (!Instrument::existTechId((int) $instru['id'])) {
                return Jsend::error($instru['id'] . ' not found');
            }
        }
        
        foreach ($artists as $artist) {

            $validationArt = Artist::validate(array('id' => (int) $artist['id']));
            if ($validationArt !== true) {
                return Jsend::fail($validationArt);
            }

            if (!Artist::existTechId((int) $artist['id'])) {
                return Jsend::error($artist['id'] . ' not found');
            }
        }


        $musician = new Musician();
        $musician->first_name = $first_name;
        $musician->last_name = $last_name;
        $musician->stagename = $stagename;
        $musician->save();
        
        dd($instruments);

        foreach ($artists as $artist) {
            foreach ($instruments as $instru) {
                if (!ArtistMusician::existTechId($instru->id, $artist->id,$musician->id)) {
                    $artistMusician = new ArtistMusician();
                    $artistMusician->artist_id = $artist->id;
                    $artistMusician->musician_id = $musician->id;
                    $artistMusician->instrument_id = $instru->id;
                    $artistMusician->save();
                } else {
                    return Jsend::error('$artistMusician already exists');
                }
            }
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
