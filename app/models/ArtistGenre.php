<?php

class ArtistGenre extends MyEloquent {

	protected $table = 'artist_genre';
	public $timestamps = false;

	public static function validate($data = array())
    {
        return parent::validator($data, array(
            'artist_id' => 'unsigned|sometimes|required',
            'genre_id' => 'unsigned|sometimes|required',
        ));
    }

}