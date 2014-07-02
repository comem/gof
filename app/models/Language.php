<?php

/**
 * Language model
 * 
 * Corresponds to the "languages" class of the class diagram (ACL).
 *
 * @category  Model
 * @version   1.0
 * @author    gof
 */
class Language extends MyEloquent {

    protected $table = 'languages';
    public $timestamps = false;

    /**
     * Allows to define the relationship between Language and User.
     * @return User the users of the language.
     */
    public function users() {
        return $this->hasMany('User');
    }

    /**
     * Allows to validate attributes for a User.
     * @param array data array with every attributes that has to be validate. 
     * @return boolean|array true if the input data are valid, array with errors otherwise.
     */
    public static function validate($data = array()) {
        return parent::validator($data, array(
                    'locale' => 'unique:languages|string|between:1,255|sometimes|required',
                    'name_de' => 'string|between:1,255|sometimes|required'
        ));
    }

}
