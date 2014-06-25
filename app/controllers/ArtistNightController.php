<?php

class ArtistNightController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return Jsend::success(ArtistNight::all()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {



        $artistId = Input::get('artist_id');
        $nightId = Input::get('night_id');
        $order = Input::get('order');
        $isSupport = Input::get('is_support');
        $artistHourArrival = Input::get('artist_hour_arrival');

        if (ctype_digit($artistId)) {
            $artistId = (int) $artistId;
        }

        if (ctype_digit($nightId)) {
            $nightId = (int) $nightId;
        }

        $validationArtistNight = ArtistNight::validate(array(
                    'artist_id' => $artistId,
                    'night_id' => $nightId,
                    'order' => $order,
                    'is_support' => $isSupport,
                    'artist_hour_arrival' => $artistHourArrival,
        ));

        if ($validationArtistNight !== true) {
            return Jsend::fail($validationArtistNight);
        }

        if (!Artist::existTechId($nightId)) {
            return Jsend::error('artist not found');
        }

        if (!Night::existTechId($nightId)) {
            return Jsend::error('night not found');
        }

        if (ArtistNight::existTechId($artistId, $nightId, $order)) {
            return Jsend::error('artistnight already exists');
        }

        $artistNight = new ArtistNight();
        $artistNight->artist_id = $artistId;
        $artistNight->night_id = $nightId;
        $artistNight->order = $order;
        $artistNight->is_support = $isSupport;
        $artistNight->artist_hour_arrival = $artistHourArrival;
        $artistNight->save();


        // Et on retourne l'id du message nouvellement créé (encapsulé en JSEND)
        return Jsend::success($artistNight->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {

        // Récupération par le header
        $night_id = Request::header('night_id');
        $order = Request::header('order');

        //Cast de platform_id et de event_id car l'url les envoit en String
        if (ctype_digit($id)) {
            $id = (int) $id;
        }
        if (ctype_digit($night_id)) {
            $night_id = (int) $night_id;
        }
        if (ctype_digit($order)) {
            $order = (int) $order;
        }

        // Validation des types
        $validationArtistNight = ArtistNight::validate(array(
                    'artist_id' => $id,
                    'night_id' => $night_id,
                    'order' => $order,
        ));
        if ($validationArtistNight !== true) {
            return Jsend::fail($validationArtistNight, 400);
        }

        // Validation de l'existance de l'artistnight
        if (!ArtistNight::existTechId($id, $night_id, $order)) {
            return Jsend::error('artistnight not found', 404);
        }

        // Récupération de l'artistnight
        $artistNight = ArtistNight::where('artist_id', '=', $id)->where('night_id', '=', $night_id)->where('order', '=', $order)->first();

        // Retourne la publication encapsulée en JSEND si tout est OK
        return Jsend::success($artistNight->toArray());
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {

        $nightId = Input::get('night_id');
        $order = Input::get('order');
        $isSupport = Input::get('is_support');
        $artistHourArrival = Input::get('artist_hour_arrival');

        //Cast de platform_id et de night_id car l'url les envoit en String
        if (ctype_digit($id)) {
            $id = (int) $id;
        }

        if (ctype_digit($nightId)) {
            $nightId = (int) $nightId;
        }
        if (ctype_digit($order)) {
            $order = (int) $order;
        }


        // Validation des types
        $validationArtistNight = ArtistNight::validate(array(
                    'artist_id' => $id,
                    'night_id' => $nightId,
                    'order' => $order,
                    'is_support' => $isSupport,
                    'artist_hour_arrival' => $artistHourArrival,
        ));

        if ($validationArtistNight !== true) {
            return Jsend::fail($validationArtistNight);
        }

//        // Validation de l'existance de l'événement
//        if (Night::existTechId($night_id) !== true) {
//            return Jsend::error('night not found');
//        }
//
//        // Validation de l'existance de la plateforme
//        if (Platform::existTechId($platform_id) !== true) {
//            return Jsend::error('platform not found');
//        }
//
//        // Validation de l'existance de la publication
//        if (NightPlatform::existTechId($night_id, $platform_id) !== true) {
//            return Jsend::error('publication not found');
//        }
//
//        Night::find($night_id)->platforms()->updateExistingPivot($platform_id, array(
//            'external_id' => $external_id,
//            'external_infos' => $external_infos,
//            'url' => $url
//        ));
//
//        // Récupération de la publication 
//        $publication = NightPlatform::where('platform_id', '=', $platform_id)->where('night_id', '=', $night_id)->first();
//
//        return Jsend::success($publication->toArray());
//        //

        //Query Builder pour l'update (a voir si ça fonctionne)
        DB::table('artist_night')
            ->where('night_id', '=', $night_id)
            ->where('artist_id', '=', $artist_id)
            ->where('order', '=', $order)
            ->update(array(
                'is_support' => $isSupport,
                'artist_hour_arrival' => $artistHourArrival
            );


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
