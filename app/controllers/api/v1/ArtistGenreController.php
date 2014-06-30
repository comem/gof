<?php

namespace api\v1;

use \Jsend;
use \BaseController;
use \Input;
use \Artist;
use \Genre;
use \ArtistGenre;
use \DB;


/**
 * REST controller with index, store and destroy methods implemented
 *
 * @category  Application services
 * @version   1.0
 * @author    gof
 */
class ArtistGenreController extends BaseController {

    /**
     * Display a listing of the resource.
     * @return Jsend::success Toutes les catégories de tickets
     */
    public function index() {
        return Jsend::success(ArtistGenre::all()->toArray());
    }

    /**
     * Store a newly created resource in storage.
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
     * @return Jsend::success A validation message with the id of the news art
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
     */
    public function store() {
        $artist_id = Input::get('artist_id');
        $genre_id = Input::get('genre_id');


        if (ctype_digit($artist_id)) {
            $artist_id = (int) $artist_id;
        }
        if (ctype_digit($genre_id)) {
            $genre_id = (int) $genre_id;
        }

        $validationArtist = Artist::validate(array('id' => $artist_id));
        $validationGenre = Genre::validate(array('id' => $genre_id));

        if ($validationArtist !== true) {
            return Jsend::fail($validationArtist);
        }
        if ($validationGenre !== true) {
            return Jsend::fail($validationGenre);
        }

        if (!Artist::existTechId($artist_id)) {
            return Jsend::error('artist not found');
        }

        if (!Genre::existTechId($genre_id)) {
            return Jsend::error('genre not found');
        }


        if (!ArtistGenre::existTechId($artist_id, $genre_id)) {
            $artistGenre = new ArtistGenre();
            $artistGenre->artist_id = $artist_id;
            $artistGenre->genre_id = $artist_id;
            $artistGenre->save();
        } else {
            return Jsend::error('description already exists');
        }

        return Jsend::success(array("id_artist" => $artist_id, "id_genre" => $genre_id));
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($artist_id) {


        $genre_id = Input::get('genre_id');

        if (ctype_digit($artist_id)) {
            $artist_id = (int) $artist_id;
        }
        if (ctype_digit($genre_id)) {
            $genre_id = (int) $genre_id;
        }


        // Validation Artist
        $validationArt = Artist::validate(array('id' => $artist_id));
        if ($validationArt !== true) {
            return Jsend::fail($validationArt);
        }


        if (!Artist::existTechId($artist_id)) {
            return Jsend::error('artist_id :', $artist_id . ' not found');
        }

        // Validation Genre
        $validationGenre = Genre::validate(array('id' => $genre_id));
        if ($validationGenre !== true) {
            return Jsend::fail($validationGenre, 400);
        }


        if (!Genre::existTechId($genre_id)) {
            return Jsend::error('genre id :' . $genre_id . ' not found', 404);
        }
       

        if (!ArtistGenre::existTechId($artist_id, $genre_id)) {
            return Jsend::error("association doesn't exist");
        }


        DB::table('artist_genre')
                ->where('artist_id', '=', $artist_id)
                ->where('genre_id', '=', $genre_id)
                ->delete();



        return Jsend::success('Association deleted');
    }

}
