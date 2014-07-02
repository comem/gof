<?php

/**
 * Resource model (ACL)
 * 
 * Corresponds to the "resources" class of the class diagram.
 *
 * @category  Model
 * @version   1.0
 * @author    gof
 */
class Resource extends MyEloquent {

    protected $table = 'resources';
    public $timestamps = true;

    /**
     * Allows to define the relationship Resource and Group.
     * @return Group the groups of the resource.
     */
    public function groups() {
        return $this->belongsToMany('Group');
    }

    /**
     * Allows to validate attributes for a Resource.
     * @param array data array with every attributes that has to be validate. 
     * @return boolean|array true if the input data are valid, array with errors otherwise.
     */
    public static function validate($data = array()) {
        return parent::validator($data, array(
                    'model' => 'string|between:1,200|sometimes|required',
                    'function' => 'string|between:1,200|sometimes|required',
                    'created_at' => 'date|sometimes|required',
                    'updated_at' => 'date|sometimes|required',
        ));
    }

}
