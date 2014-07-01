<?php

/**
 * ArtistGenre model
 *
 * Corresponds to the "descriptions" class of the class diagram.
 * 
 * @category  Model
 * @version   1.0
 * @author    gof
 */
class ArtistGenre extends MyEloquent {

    protected $table = 'artist_genre';
    public $timestamps = false;

    /**
     * Allows to validate attributes for an ArtistGenre.
     * @param array data array with every attributes that has to be validate. 
     * @return boolean|array true if the input data are valid, array with errors otherwise.
     */
    public static function validate($data = array()) {
        return parent::validator($data, array(
                    'artist_id' => 'integer:unsigned|sometimes|required',
                    'genre_id' => 'integer:unsigned|sometimes|required',
        ));
    }

    /**
     * Allows to verify if an ArtistGenre exists in the database with his technical id.
     * @param int the technical id of artist corresponding to the composite primary key of the ArtistGenre.
     * @param int the technical id of genre corresponding to the composite primary key of the ArtistGenre.
     * @return boolean true if the Artist exists in the database, false otherwise.
     */
    public static function existTechId($artist_id, $genre_id) {
        $e = ArtistGenre::where('artist_id', '=', $artist_id)->where('genre_id', '=', $genre_id)->first();
        return $e != null;
    }

}
