<?php

namespace api\v1;

use \Jsend;
use \Input;
use \BaseController;
use \Musician;
use \DB;

/**
 * REST controller with index, store and show methods implemented
 *
 * @category  Application services
 * @version   1.0
 * @author    gof
 */
class MusiciansController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return Jsend::success(Musician::with('instruments', 'artists')->get());
    }

    /**
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
     */
    public function store() {
        $first_name = Input::get('first_name');
        $last_name = Input::get('last_name');
        $stagename = Input::get('stagename');
        $artistsInstruments = Input::get('artistsInstruments');


        DB::beginTransaction();



        if (!isset($artistsInstruments)) {
            return Jsend::fail("Artist and Instrument required");
        }

        $musician = MusiciansController::saveMusician($first_name, $last_name, $stagename);

        if (!is_a($musician, 'Musician')) {
            return Jsend::error($musician);
        }



        foreach ($artistsInstruments as $aI) {

            $artist_id = $aI['artist_id'];


            foreach ($aI['instruments'] as $instru) {

                $instrument_id = $instru['instrument_id'];


                $artistMusician = ArtistMusicianController::saveArtistMusician($artist_id, $instrument_id, $musician->id);

                if (!is_a($artistMusician, 'ArtistMusician')) {
                    return Jsend::fail($artistMusician);
                }
            }
        }
        DB::commit();
        return Jsend::success(array('first_name' => $first_name,
                    'last_name' => $last_name,
                    'stagename' => $stagename,
                    'association' => 'artist and instrument'));
    }

    /**
     * Affiche le musician correspondant à l'id passée en paramètre
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
        return Jsend::success(Musician::with('instruments', 'artists')->find($musician_id));
    }

    /**
     * @ignore
     * Not implemented yet.
     */
    public function update($id) {
        //
    }

    /**
     * @ignore
     * Not implemented yet.
     */
    public function destroy($id) {
        //
    }

    /**
     * @ignore
     * @param type $first_name
     * @param type $last_name
     * @param type $stagename
     * @return \Musician
     */
    public static function saveMusician($first_name, $last_name, $stagename) {

        $validationMusician = Musician::validate(array('first_name' => $first_name,
                    'last_name' => $last_name,
                    'stagename' => $stagename));

        if ($validationMusician !== true) {
            return Jsend::fail($validationMusician);
        }


        $musician = new Musician();
        $musician->first_name = $first_name;
        $musician->last_name = $last_name;
        $musician->stagename = $stagename;
        $musician->save();

        return $musician;
    }

    /**
     * Allow to search a musician with attribute
     * @var string : data of search. exemple : musician/search?string=test
     * @return json of object received
     */
    public static function search() {

        $string = Input::get('string');


        $results = Musician::Where('first_name', 'like', "$string%")
                        ->orWhere('last_name', 'like', "$string%")
                        ->orWhere('stagename', 'like', "$string%")->get();

        return ($results->toArray());
    }

}
