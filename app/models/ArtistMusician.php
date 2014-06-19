<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ArtistMusician extends MyEloquent {

	protected $table = 'artist_musician';
	public $timestamps = false;

	use SoftDeletingTrait;

	protected $dates = ['deleted_at'];

	public function instrument()
	{
		return $this->belongsTo('Instrument');
	}
        
        
              public static function validate($data = array())
    {
        return parent::validator($data, array(
            'musician_id'      => 'unsigned|sometimes|required',
            'artist_id'      => 'unsigned|sometimes|required',
            'instrument_id'      => 'unsigned|sometimes|required',
           
        ));
    }

}