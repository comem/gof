<?php

/**
 * GroupResource model (ACL)
 *
 * @category  Model
 * @version   1.0
 * @author    gof
 */
class GroupResource extends MyEloquent {

    protected $table = 'group_resource';
    public $timestamps = false;

    /**
     * Allows to validate attributes for a GroupResource.
     * @param array data array with every attributes that has to be validate. 
     * @return boolean|array true if the input data are valid, array with errors otherwise.
     */
    public static function validate($data = array()) {
        return parent::validator($data, array(
                    'group_name' => 'string|between:1,255|sometimes|required',
                    'resource_model' => 'string|between:1,25|sometimes|required',
                    'resource_function' => 'string|between:1,255|sometimes|required'
        ));
    }

}
