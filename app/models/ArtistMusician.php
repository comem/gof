<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

/**
 * this class combines the instrument, the artist and musician
 */
class ArtistMusician extends MyEloquent {

    protected $table = 'artist_musician';
    public $timestamps = false;

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    /**
     * instruments linked
     * @return type
     */
    public function instrument() {
        return $this->belongsTo('Instrument');
    }
 /**
  * This methode validate the type of attribute content in the table
  */
    public static function validate($data = array()) {
        return parent::validator($data, array(
                    'musician_id' => 'integer:unsigned|sometimes|required',
                    'artist_id' => 'integer:unsigned|sometimes|required',
                    'instrument_id' => 'integer:unsigned|sometimes|required',
        ));
    }

    public static function existTechId($instrument_id, $artist_id, $musician_id) {

        $e = ArtistMusician::where('instrument_id', '=', $instrument_id)
                ->where('artist_id', '=', $artist_id)
                ->where('musician_id', '=', $musician_id)
                ->first();
        return $e != null;       // Si null, n’exi passte
    }

}
