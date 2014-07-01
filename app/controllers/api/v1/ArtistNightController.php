<?php

namespace api\v1;

use \Jsend;
use \Input;
use \Request;
use \Artist;
use \Night;
use \ArtistNight;
use \BaseController;

/**
 * REST controller with index, store, show, update and destroy methods implemented.
 * 
 * Corresponds to the "performers" class of the class diagram.
 *
 * @category  Application services
 * @version   1.0
 * @author    gof
 */
class ArtistNightController extends BaseController {

    /**
     * Display a listing of the resource.
     * @return Response Jsend::success all performers
     */
    public function index() {
        return Jsend::success(ArtistNight::all()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     * @var artist_id (int) id from artist (get) (hybride from performer).
     * @var night_id (int) id from night (get) (hybride from performer).
     * @var order (int). the order from passage (get)(hybride from performer).
     * @var $is_support (boolen) from perfomers (get)
     * @var $artist_hour_arrival (date) hour from arrival (get)
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if a resource was not found.
     * @return Response Jsend::success if a new artistnight was created.
     */
    public function store() {

        $artist_id = Input::get('artist_id');
        $night_id = Input::get('night_id');
        $order = Input::get('order');
        $is_support = Input::get('is_support');
        $artist_hour_arrival = Input::get('artist_hour_arrival');

        $artistNight = static::saveArtistNight($artist_id, $night_id, $order, $is_support, $artist_hour_arrival);


        // Retour de l'id du message nouvellement créé (encapsulé en JSEND)
        return Jsend::success($artistNight->toArray());
    }

    /**
     * @ignore
     * Allows to save a new Artist Night 
     * @param string artist_id - id from the artist
     * @param string night_id - id from night
     * @param string order - a order from night
     * @param array is_support - (artistNight perfomers)
     * @param array artist_hour_of_arrival - from (artistNight perfomers)
     * @return Artist - a created artistNight
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if a resource was not found.
     * @return Response Jsend::success a new ArtistNight.
     */
    public static function saveArtistNight($artist_id, $night_id, $order, $is_support, $artist_hour_arrival) {
        if (ctype_digit($artist_id)) {
            $artist_id = (int) $artist_id;
        }

        if (ctype_digit($night_id)) {
            $nightId = (int) $nightId;
        }

        $validationArtistNight = ArtistNight::validate(array(
                    'artist_id' => $artist_id,
                    'night_id' => $night_id,
                    'order' => $order,
                    'is_support' => $is_support,
                    'artist_hour_arrival' => $artist_hour_arrival,
        ));

        if ($validationArtistNight !== true) {
            return Jsend::fail($validationArtistNight);
        }

        if (!Artist::existTechId($artist_id)) {
            return Jsend::error('artist not found');
        }

        if (!Night::existTechId($night_id)) {
            return Jsend::error('night not found');
        }

        if (ArtistNight::existTechId($artist_id, $night_id, $order)) {
            return Jsend::error('artistnight already exists');
        }

        $artistNight = new ArtistNight();
        $artistNight->artist_id = $artist_id;
        $artistNight->night_id = $night_id;
        $artistNight->order = $order;
        $artistNight->is_support = $is_support;
        $artistNight->artist_hour_arrival = $artist_hour_arrival;
        $artistNight->save();





        return $artistNight;
    }

    /**
     * Display the specified resource.
     * @var string Night-id - id from the night (header)
     * @var string Artist-id - id from the artist (header)
     * @param string $order - a order from night (get)
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if a resource was not found.
     * @return Response Jsend::success if a new artist was created.
     */
    public function show($order) {

        // Récupération par le header
        $night_id = Request::header('Night-id');
        $artist_id = Request::header('Artist-id');

        //Cast de platform_id et de event_id car l'url les envoit en String
        if (ctype_digit($artist_id)) {
            $artist_id = (int) $artist_id;
        }
        if (ctype_digit($night_id)) {
            $night_id = (int) $night_id;
        }
        if (ctype_digit($order)) {
            $order = (int) $order;
        }

        // Validation des types
        $validationArtistNight = ArtistNight::validate(array(
                    'artist_id' => $artist_id,
                    'night_id' => $night_id,
                    'order' => $order,
        ));
        if ($validationArtistNight !== true) {
            return Jsend::fail($validationArtistNight, 400);
        }

        // Validation de l'existance de l'artistnight
        if (!ArtistNight::existTechId($artist_id, $night_id, $order)) {
            return Jsend::error('artistnight not found', 404);
        }

        // Récupération de l'artistnight
        $artistNight = ArtistNight::where('artist_id', '=', $artist_id)->where('night_id', '=', $night_id)->where('order', '=', $order)->first();

        // Retourne la publication encapsulée en JSEND si tout est OK
        return Jsend::success($artistNight->toArray());
        //
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param string $artist_id (int) - id from the artist
     * @param string $night_id (int) - id from night
     * @param string $order(int) - a order from night
     * @var $is_support (boolen) from perfomers 
     * @var $artist_hour_arrival (date) hour from arrival 
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if a resource was not found.
     * @return Response Jsend::success if a new artist was created.
     */
    public function update($order) {

        $night_id = Input::get('night_id');
        $artist_id = Input::get('artist_id');
        $is_support = Input::get('is_support');
        $artist_hour_arrival = Input::get('artist_hour_arrival');

        //Cast de platform_id et de night_id car l'url les envoit en String
        if (ctype_digit($artist_id)) {
            $artist_id = (int) $artist_id;
        }
        if (ctype_digit($night_id)) {
            $night_id = (int) $night_id;
        }
        if (ctype_digit($order)) {
            $order = (int) $order;
        }
        if (ctype_digit($is_support)) {
            $is_support = (int) $is_support;
        }

        // Validation des types
        $validationArtistNight = ArtistNight::validate(array(
                    'artist_id' => $artist_id,
                    'night_id' => $night_id,
                    'order' => $order,
                    'is_support' => $is_support,
                    'artist_hour_arrival' => $artist_hour_arrival,
        ));
        if ($validationArtistNight !== true) {
            return Jsend::fail($validationArtistNight);
        }

        // Validation de l'existance de l'événement
        if (Night::existTechId($night_id) !== true) {
            return Jsend::error('night not found');
        }

        // Validation de l'existance de l'artiste
        if (Artist::existTechId($artist_id) !== true) {
            return Jsend::error('artist not found');
        }

        // Validation de l'existance de l'interprète (performer)
        if (ArtistNight::existTechId($artist_id, $night_id, $order) !== true) {
            return Jsend::error('performer not found');
        }

        //Modification de l'interprète (performer)
        //Query Builder pour l'update 
        DB::table('artist_night')
                ->where('night_id', '=', $night_id)
                ->where('artist_id', '=', $artist_id)
                ->where('order', '=', $order)
                ->update(array(
                    'is_support' => $is_support,
                    'artist_hour_arrival' => $artist_hour_arrival)
        );

        // Récupération du performer pour retourner l'objet modifié
        $performer = ArtistNight::where('night_id', '=', $night_id)
                ->where('artist_id', '=', $artist_id)
                ->where('order', '=', $order)
                ->first();
        return Jsend::success($performer->toArray());
    }

    /**
     * Remove the specified resource from storage.
     * @param string $artist_id (int) - id from the artist
     * @param string $night_id (int) - id from night
     * @param string $order(int) - a order from night
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if a resource was not found.
     * @return Response Jsend::success if a new artist was created.
     */
    public function destroy($order) {

        $artist_id = Input::get('artist_id');
        $night_id = Input::get('night_id');

        //Cast de order_id, artist_id et de night_id car l'url les envoit en String
        if (ctype_digit($artist_id)) {
            $artist_id = (int) $artist_id;
        }
        if (ctype_digit($night_id)) {
            $night_id = (int) $night_id;
        }
        if (ctype_digit($order)) {
            $order = (int) $order;
        }

        // Validation des types
        $validationArtistNight = ArtistNight::validate(array(
                    'artist_id' => $artist_id,
                    'night_id' => $night_id,
                    'order' => $order,
        ));
        if ($validationArtistNight !== true) {
            return Jsend::fail($validationArtistNight);
        }

        // Validation de l'existance de l'interprète (performer)
        if (ArtistNight::existTechId($artist_id, $night_id, $order) !== true) {
            return Jsend::error('performer not found');
        }

        //Supression de l'interprète/performer (table pivot avec id hybrid "order").
        // Réalisé grace au niveau en-dessous de Eloquent -> Query Builder
        DB::table('artist_night')
                ->where('night_id', '=', $night_id)
                ->where('artist_id', '=', $artist_id)
                ->where('order', '=', $order)
                ->delete();

        return Jsend::success('Performer deleted');
    }

}
