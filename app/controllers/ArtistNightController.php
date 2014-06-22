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
        return Jsend::success(array('artist_id' => $artistNight->artist_id, 'night_id' => $artistNight->night_id, 'order' => $artistNight->order));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
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
