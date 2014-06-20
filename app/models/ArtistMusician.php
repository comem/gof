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
    public static function existTechId($instru_id,$artist_id,$musician_id) {
       
        $e = ArtistMusician::where('instrument_id', '=', $instrument_id)
            ->where('artist_id', '=', $artist_id)
            ->where('musician_id', '=', $musician_id)
            ->first();
        return $e != null;       // Si null, n’existe pas
    }

}