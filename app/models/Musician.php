<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

/**
 * Musician model
 * 
 * Corresponds to the "musicians" class of the class diagram.
 *
 * @category  Model
 * @version   1.0
 * @author    gof
 */
class Musician extends MyEloquent {

    protected $table = 'musicians';
    public $timestamps = true;

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    /**
     * Allows to define the relationship between Musician and Artists.
     * @return Artist the artists of the musician.
     */
    public function artists() {
        return $this->belongsToMany('Artist')->withPivot('instrument_id');
    }

    /**
     * Allows to validate attributes for a Musician.
     * @param array data array with every attributes that has to be validate. 
     * @return boolean|array true if the input data are valid, array with errors otherwise.
     */
    public static function validate($data = array()) {
        return parent::validator($data, array(
                    'id' => 'integer:unsigned|sometimes|required',
                    'first_name' => 'string|between:1,255|sometimes|required',
                    'last_name' => 'string|between:1,255|sometimes',
                    'stagename' => 'string|between:1,255|sometimes',
                    'created_at' => 'date|sometimes|required',
                    'updated_at' => 'date|sometimes|required',
                    'deleted_at' => 'date|sometimes',
        ));
    }

    /**
     * Allows to verify if a Musician exists in the database with his technical id.
     * @param int the technical id corresponding to the primary key of the Musician.
     * @return boolean true if the Musician exists in the database, false otherwise.
     */
    public static function existTechId($tech_id) {
        $e = Musician::where('id', '=', $tech_id)
                ->first();
        return $e != null;       // Si null, n’existe pas 
    }

    /**
     * Allows to define the relationship between Musician and Instrument.
     * @return Instrument the intruments of the musician.
     */
    public function instruments() {

        $instru = $this->belongsToMany('Instrument', 'artist_musician');

        return ($instru);
    }

}
