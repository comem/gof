<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

/**
 * Genre model
 * 
 * Corresponds to the "genres" class of the class diagram.
 *
 * @category  Model
 * @version   1.0
 * @author    gof
 */
class Genre extends MyEloquent {

    protected $table = 'genres';
    public $timestamps = false;

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    /**
     * Allows to define the relationship between Genre and Artist.
     * @return Artist the artists of the genre.
     */
    public function artists() {
        return $this->belongsToMany('Artist');
    }

    /**
     * Allows to validate attributes for a Genre.
     * @param array data array with every attributes that has to be validate. 
     * @return boolean|array true if the input data are valid, array with errors otherwise.
     */
    public static function validate($data = array()) {
        return parent::validator($data, array(
                    'id' => 'integer:unsigned|sometimes|required',
                    'name_de' => 'string|between:1,255|sometimes|required',
                    'deleted_at' => 'datetime|sometimes',
        ));
    }

    /**
     * Allows to verify if a Genre exists in the database with his business id.
     * @param string the business id corresponding to the name_de of the Genre.
     * @return boolean true if the Genre exists in the database, false otherwise.
     */
    public static function existBusinessId($id) {
        $e = Genre::where('name_de', '=', $id)->first();
        return $e != null;
    }

    /**
     * Allows to verify if a Genre exists in the database with his technical id.
     * @param int the technical id corresponding to the primary key of the Genre.
     * @return boolean true if the Genre exists in the database, false otherwise.
     */
    public static function existTechId($id) {
        $e = Genre::find($id);
        return $e != null;
    }

}
