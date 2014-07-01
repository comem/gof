<?php

namespace api\v1;

use \Jsend;
use \Input;
use \BaseController;
use \Musician;
use \DB;

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
      <<<<<<< HEAD
     * Store a musician and an association beetween this musicians, an instrument and an artist
     * @var (string) first_name : first name of the musician
     * @var (string) last_name : last name of the musician
     * @var (string) satgename : pseudo of the musicians
     * @var (array)  "artistsInstruments": [
      {
      "artist_id": "1",
      "instruments": [
      {
      "instrument_id": "4"
      },
      {
      "instrument_id": "7"
      }
      ]
      },
      {
      "artist_id": "2",
      "instruments": [
      {
      "instrument_id": "3"
      },
      {
      "instrument_id": "7"
      }
      ]
      }
      ]
     * @return Jsend::fail An error message if the parameters aren't correct
     * @return Jsend::error An error message if the ressource doesn't exist or exist but you are trying to rewrite it
     * @return Jsend::success A validation message with the id of the news musicians
     * 
     * 
     * JSEND DE TEST:
     * {
      "first_name": "Grey",
      "last_name": "Jorge",
      "stagename": "Apple",
      "artistsInstruments": [
      {
      "artist_id": "1",
      "instruments": [
      {
      "instrument_id": "4"
      },
      {
      "instrument_id": "7"
      }
      ]
      },
      {
      "artist_id": "2",
      "instruments": [
      {
      "instrument_id": "3"
      },
      {
      "instrument_id": "7"
      }
      ]
      }
      ]
      }
      =======
     * Allow to record a Musician with assoication betweem an instrument and a artist
     * @var first_name (string) first name from artist (get)
     * @var last_name (string) last name from artist (get)
     * @var stagename (string) stagename from artist (get)
     * @var artistsInstruments : array of id from musician and instrument ( association ) 
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if a resource was not found.
     * @return Response Jsend::success if a new musician was created.
      >>>>>>> Comments
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
