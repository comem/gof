<?php

class ArtistGenre extends MyEloquent {

	protected $table = 'artist_genre';
	public $timestamps = false;

	public static function validate($data = array())
    {
        return parent::validator($data, array(
            'artist_id' => 'integer:unsigned|sometimes|required',
            'genre_id' => 'integer:unsigned|sometimes|required',
        ));
    }
    
    public static function existTechId($artist_id, $genre_id) {
        $e = ArtistGenre::where('artist_id', '=', $artist_id)->where('genre_id', '=', $genre_id)->first();
        return $e != null;
    }

}