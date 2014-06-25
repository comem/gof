<?php

namespace api\v1;

use \Jsend;
use \Input;
use \Request;
use \Artist;
use \Night;
use \ArtistNight;
use \BaseController;

class ArtistNightController extends BaseController {

    /**
     * Display a listing of the resource.
     * @return Jsend::success Tous les performers
     */
    public function index() {
        return Jsend::success(ArtistNight::all()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     * @var order a récupérer comme contenu en get. Correspond à un attribut d'ordre (formant l'id hybride du performer).
     * @var night_id a récupérer comme contenu en get. Correspond à l'id de l'événement (formant l'id hybride du performer).
     * @var $artist_id a récupérer comme contenu en get. Correspond à l'id de l'artiste (formant l'id hybride du performer).
     * @var $is_ussport a récupérer comme contenu en get. Correspond à l'importnace de l'artiste sur l'événement.
     * @var $artist_hour_arrival a récupérer comme contenu en get. Correspond à l'heure d'arrivée. 
     * @return Jsend::fail Un message d'erreur si les données entrées ne correspondent pas aux données demandées.
     * @return Jsend::error Un message d'erreur si l'artiste n'existe pas.
     * @return Jsend::error Un message d'erreur si l'événement n'existe pas.
     * @return Jsend::error Un message d'erreur si le performer existe déjà.
     * @return Jsend::success Sinon, un message de validation d'enregistrement contenant le performer créé.
     */
    public function store() {

        $artist_id = Input::get('artist_id');
        $night_id = Input::get('night_id');
        $order = Input::get('order');
        $is_support = Input::get('is_support');
        $artist_hour_arrival = Input::get('artist_hour_arrival');

        if (ctype_digit($artist_id)) {
            $artist_id = (int) $artist_id;
        }

        if (ctype_digit($night_id)) {
            $night_id = (int) $night_id;
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

        if (!Artist::existTechId($night_id)) {
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


        // Retour de l'id du message nouvellement créé (encapsulé en JSEND)
        return Jsend::success($artistNight->toArray());
    }

    /**
     * Display the specified resource.
     * @param  int $order correspondant à un attribut d'ordre de performer (formant l'id hybride du performer).
     * @var night_id a récupérer comme contenu en get. Correspond à l'id de l'événement (formant l'id hybride du performer).
     * @var $artist_id a récupérer comme contenu en get. Correspond à l'id de l'artiste (formant l'id hybride du performer).
     * @return Jsend::fail Un message d'erreur si les données entrées ne correspondent pas aux données demandées.
     * @return Jsend::error Un message d'erreur si l'id hybride est déjà en mémoire.
     * @return Jsend::success Sinon, un message de validation d'enregistrement contenant le performer correspondant à l'id hybride.
     */
    public function show($order) {

        // Récupération par le header
        $night_id = Request::header('night_id');
        $artist_id = Request::header('artist_id');

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
     * @param  int $order correspondant à un attribut d'ordre de performer (formant l'id hybride du performer).
     * @var night_id a récupérer comme contenu en get. Correspond à l'id de l'événement (formant l'id hybride du performer).
     * @var $artist_id a récupérer comme contenu en get. Correspond à l'id de l'artiste (formant l'id hybride du performer).
     * @var $is_ussport a récupérer comme contenu en get. Correspond à l'importnace de l'artiste sur l'événement.
     * @var $artist_hour_arrival a récupérer comme contenu en get. Correspond à l'heure d'arrivée. 
     * @return Jsend::fail Un message d'erreur si les données entrées ne correspondent pas aux données demandées.
     * @return Jsend::error Un message d'erreur si l'événement lié à la modification n'existe pas.
     * @return Jsend::error Un message d'erreur si l'artiste lié à la modification n'existe pas.
     * @return Jsend::error Un message d'erreur si le performer n'existe pas.
     * @return Jsend::success Sinon, un message de validation de modification contenant le performer correspondant à l'id hybride.
     */
    public function update($order) {

        $night_id = Input::get('night_id');
        $artist_id = Input::get('artist_id');
        $is_support = Input::get('is_support');
        $artist_hour_arrival = Input::get('artist_hour_arrival');

        //Cast de platform_id et de night_id car l'url les envoit en String
        if (ctype_digit($artist_id)) {
            $artist_id = (int)$artist_id;
        }
        if (ctype_digit($night_id)) {
            $night_id = (int)$night_id;
        }
        if (ctype_digit($order)) {
            $order = (int)$order;
        }
        if (ctype_digit($is_support)) {
            $is_support = (int)$is_support;
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
     * @param int $order correspondant à une partie de l'id hybrdide de l'interprète (performer).
     * @var artist_id a récupérer comme contenu en get. Correspond à l'id de l'artist.
     * @var night_id a récupérer comme contenu en get. Correspond à l'id de l'événement.
     * @return Jsend::fail Un message d'erreur si les données entrées ne correspondent pas aux données demandées.
     * @return Jsend::error Un message d'erreur si l'interprète (performer) n'est pas existant.
     * @return Jsend::success Sinon, un message de validation de supression de l'interprète (performer).
     */
    public function destroy($order)
    {

        $artist_id = Input::get('artist_id');
        $night_id = Input::get('night_id');

        //Cast de order_id, artist_id et de night_id car l'url les envoit en String
        if (ctype_digit($artist_id)) {
            $artist_id = (int)$artist_id;
        }
        if (ctype_digit($night_id)) {
            $night_id = (int)$night_id;
        }
        if (ctype_digit($order)) {
            $order = (int)$order;
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
