<?php

/**
 * ArtistNight model
 * 
 * Corresponds to the "performers" class of the class diagram.
 *
 * @category  Model
 * @version   1.0
 * @author    gof
 */
class ArtistNight extends MyEloquent {

    protected $table = 'artist_night';
    public $timestamps = false;

    /**
     * Allows to validate attributes for an ArtistNight.
     * @param array data array with every attributes that has to be validate. 
     * @return boolean|array true if the input data are valid, array with errors otherwise.
     */
    public static function validate($data = array()) {
        return parent::validator($data, array(
                    'artist_id' => 'integer:unsigned|sometimes|required',
                    'night_id' => 'integer:unsigned|sometimes|required',
                    'order' => 'integer:unsigned|sometimes|required',
                    'is_support' => 'boolean|sometimes|required',
                    'artist_hour_arrival' => 'date|sometimes|required'
        ));
    }

    /**
     * Allows to verify if an ArtistNight exists in the database with his technical id.
     * @param int the technical id of artist corresponding to the composite primary key of the ArtistNight.
     * @param int the technical id of night corresponding to the composite primary key of the ArtistNight.
     * @param int the technical id of order corresponding to the composite primary key of the ArtistNight.
     * @return boolean true if the Artist exists in the database, false otherwise.
     */
    public static function existTechId($artistId, $nightId, $order) {
        $e = ArtistNight::where('artist_id', '=', $artistId)
                ->where('night_id', '=', $nightId)
                ->where('order', '=', $order)
                ->first();
        return $e != null;
    }

}
