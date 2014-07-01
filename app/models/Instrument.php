<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

/**
 * Instrument model
 * 
 * Corresponds to the "instruments" class of the class diagram.
 *
 * @category  Model
 * @version   1.0
 * @author    gof
 */
class Instrument extends MyEloquent {

    protected $table = 'instruments';
    public $timestamps = false;

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    /**
     * Allows to define the relationship between Instrument and ArtistMusician
     * @return ArtistMusician the artistmusicians of the instrument.
     */
    public function artist_musicians() {
        return $this->hasMany('ArtistMusician');
    }

    /**
     * Allows to define the relationship between Instrument and Artist.
     * @return Artist the artists of the instrument.
     */
    public function artists() {
        return $this->belongsToMany('Artist', 'artist_musician');
    }

    /**
     * Allows to validate attributes for an Instrument.
     * @param array data array with every attributes that has to be validate. 
     * @return boolean|array true if the input data are valid, array with errors otherwise.
     */
    public static function validate($data = array()) {
        return parent::validator($data, array(
                    'id' => 'integer:unsigned|sometimes|required',
                    'name_de' => 'string|between:1,255|sometimes|required',
                    'created_at' => 'date|sometimes|required',
                    'updated_at' => 'date|sometimes|required',
                    'deleted_at' => 'date|sometimes',
        ));
    }

    /**
     * Allows to verify if a Genre exists in the database with his business id.
     * @param string the business id corresponding to the name_de of the Instrument.
     * @return boolean true if the Instrument exists in the database, false otherwise.
     */
    public static function existBuisnessId($name_de) {
        $e = Instrument::where('name_de', '=', $name_de)
                ->first();
        return $e != null;       // Si null, n’existe pas 
    }

    /**
     * Allows to verify if an Instrument exists in the database with his technical id.
     * @param int the technical id corresponding to the primary key of the Instrument.
     * @return boolean true if the Instrument exists in the database, false otherwise.
     */
    public static function existTechId($instrument_id) {
        $e = Instrument::where('id', '=', $instrument_id)
                ->first();
        return $e != null;       // Si null, n’existe pas 
    }
}
