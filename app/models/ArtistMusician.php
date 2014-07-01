<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

/**
 * ArtistMusician model
 * 
 * Corresponds to the "lineups" class of the class diagram.
 *
 * @category  Model
 * @version   1.0
 * @author    gof
 */
class ArtistMusician extends MyEloquent {

    protected $table = 'artist_musician';
    public $timestamps = false;

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    /**
     * Allows to define the relationship between ArtistMusician and Instrument.
     * @return Instrument the instrument of the artistmusician.
     */
    public function instrument() {
        return $this->belongsTo('Instrument');
    }

    /**
     * Allows to validate attributes for an ArtistMusician.
     * @param array data array with every attributes that has to be validate. 
     * @return boolean true if the input data are valid, false otherwise.
     */
    public static function validate($data = array()) {
        return parent::validator($data, array(
                    'musician_id' => 'integer:unsigned|sometimes|required',
                    'artist_id' => 'integer:unsigned|sometimes|required',
                    'instrument_id' => 'integer:unsigned|sometimes|required',
        ));
    }

    /**
     * Allows to verify if an ArtistGenre exists in the database with his technical id.
     * @param int the technical id corresponding to the composite primary key of the ArtistMusician.
     * @param int the technical id corresponding to the composite primary key of the ArtistMusician.
     * @param int the technical id corresponding to the composite primary key of the ArtistMusician.
     * @return boolean true if the Artist exists in the database, false otherwise.
     */
    public static function existTechId($instrument_id, $artist_id, $musician_id) {

        $e = ArtistMusician::where('instrument_id', '=', $instrument_id)
                ->where('artist_id', '=', $artist_id)
                ->where('musician_id', '=', $musician_id)
                ->first();
        return $e != null;       // Si null, n’exi passte
    }

}
