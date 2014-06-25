<?php

class ArtistNight extends MyEloquent {

    protected $table = 'artist_night';
    public $timestamps = false;

    public static function validate($data = array()) {
        return parent::validator($data, array(
                    'artist_id' => 'integer:unsigned|sometimes|required',
                    'night_id' => 'integer:unsigned|sometimes|required',
                    'order' => 'integer:unsigned|sometimes|required',
                    'is_support' => 'boolean|sometimes|required',
                    'artist_hour_arrival' => 'date|sometimes|required'
        ));
    }

    public static function existTechId($artistId, $nightId, $order) {
        $e = ArtistNight::where('artist_id', '=', $artistId)
                ->where('night_id', '=', $nightId)
                ->where('order', '=', $order)
                ->first();
        return $e != null;
    }

}
