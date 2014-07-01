<?php

namespace api\v1;

use \BaseController;
use \Input;
use \Jsend;
use \Artist;
use \Musician;
use \ArtistMusician;
use \DB;
use \Instrument;

/**
 * REST controller with store and destroy methods implemented.
 * 
 * Corresponds to the "lineups" class of the class diagram.
 *
 * @category  Application services
 * @version   1.0
 * @author    gof
 */
class ArtistMusicianController extends BaseController {

    /**
     * @ignore
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        //
    }

    /**
     * Store a newly created resource in storage.
     * Registers a new association between a musician , an instrument and an artist
     * @var instrument_id(int): id instrument
     * @var artist_id(int): id artist
     * @var musician_id(int): id musician 
     * @return Response Jsend::fail An error message if the input data does not match the requested data.
     * @return Response Jsend::error An error message if  artist or insrtument or musician does not exist.
     * @return Response Jsend::success an association between an artist, a musician, and an instrument has been registred 
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
     * @ignore
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {

        //
    }

    /**
     * @ignore
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        
    }

    /**
     * Delete an association between an artist, a musician, and an instrument
     * @param int artist_id - the id from the artist (url)
     * @var instrument_id (int): the id from the instrument (get)
     * @var musician_id (int): the id from the musician (get) 
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if the resource to modify was not found.
     * @return Response Jsend::success if the artist was deleted.
     */

    public function destroy($artist_id) {



        $instrument_id = Input::get('instrument_id');
        $musician_id = Input::get('musician_id');

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

        if (!ArtistMusician::existTechId($instrument_id, $artist_id, $musician_id)) {
            return Jsend::error("association doesn't exist");
        }


        DB::table('artist_musician')
                ->where('instrument_id', '=', $instrument_id)
                ->where('artist_id', '=', $artist_id)
                ->where('musician_id', '=', $musician_id)
                ->delete();



        return Jsend::success('Association deleted');
    }

    /**
     * @ignore
     * Store a newly created resource in storage.
     * Registers a new association between a musician , an instrument and an artist
     * @var instrument_id(int): id instrument
     * @var artist_id(int): id artist
     * @var musician_id(int): id musician 
     * @return Response Jsend::fail An error message if the input data does not match the requested data.
     * @return Response Jsend::error An error message if  artist or insrtument or musician does not exist.
     * @return ArtistMusician an ArtistMusician saved 
     */
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

        if (ArtistMusician::existTechId($instrument_id, $artist_id, $musician_id)) {
            return Jsend::error('association alredy exist');
        }


        $artistMusician = new ArtistMusician();
        $artistMusician->musician_id = $musician_id;
        $artistMusician->artist_id = $artist_id;
        $artistMusician->instrument_id = $instrument_id;
        $artistMusician->save();

        return $artistMusician;
    }

}
