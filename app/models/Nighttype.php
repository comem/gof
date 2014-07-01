<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

/**
 * Nighttype model
 * 
 * Corresponds to the "event_types" class of the class diagram.
 *
 * @category  Model
 * @version   1.0
 * @author    gof
 */
class Nighttype extends Eloquent {

    protected $table = 'nighttypes';
    public $timestamps = false;

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    public function nights() {
        return $this->hasMany('Night');
    }

    /**
     * Allows to validate attributes for a Nighttype.
     * @param array data array with every attributes that has to be validate. 
     * @return boolean|array true if the input data are valid, array with errors otherwise.
     */
    public static function validate($data = array()) {
        return parent::validator($data, array(
                    'id' => 'unsigned|sometimes|required',
                    'name_de' => 'string|between:1,255|sometimes|required|unique:nighttypes',
        ));
    }

}
