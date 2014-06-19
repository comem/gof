<?php

class ArtistNight extends MyEloquent {

	protected $table = 'artist_night';
	public $timestamps = false;



            public static function validate($data = array())
    {
        return parent::validator($data, array(
            'artist_id'      => 'unsigned|sometimes|required',
            'night_id'      => 'unsigned|sometimes|required',
            'order_id'      => 'unsigned|sometimes|required',
            'is_support' => 'sometimes|required',
            'artist_hour_of_arrival' => 'date|sometimes|required'
        ));
    }
    
}