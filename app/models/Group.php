<?php

/**
 * Group model (ACL)
 * 
 * Corresponds to the "groups" class of the class diagram.
 *
 * @category  Model
 * @version   1.0
 * @author    gof
 */
class Group extends MyEloquent {

    protected $table = 'groups';
    public $timestamps = true;

    /**
     * Allows to define the relationship between Group and Resource.
     * @return Resource the resources of the group.
     */
    public function resources() {
        return $this->belongsToMany('Resource');
    }

    /**
     * Allows to define the relationship between Group and User.
     * @return User the users of the group.
     */
    public function users() {
        return $this->hasMany('User');
    }

    /**
     * Allows to verify if a group has access to a resource.
     * @return boolean true if the group has access, false otherwise.
     */
    public function hasResource($resourceName) {
        foreach ($this->resources as $resource) {
            if ($resource->model == $resourceName) {
                return true;
            }
        }
        return false;
    }

    /**
     * Allows to verify if a group has the correct role to access to a resource.
     * @return boolean true if the group has access, false otherwise.
     */
    public function hasRoleForResource($roleName, $resourceName) {
        foreach ($this->resources as $resource) {
            if ($resource->model == $resourceName && $resource->function == $roleName) {
                return true;
            }
        }
        return false;
    }

    /**
     * Allows to validate attributes for a Group.
     * @param array data array with every attributes that has to be validate. 
     * @return boolean|array true if the input data are valid, array with errors otherwise.
     */
    public static function validate($data = array()) {
        return parent::validator($data, array(
                    'name' => 'unique:groups|string|between:1,255|sometimes|required',
                    'created_at' => 'date|sometimes|required',
                    'updated_at' => 'date|sometimes|required',
        ));
    }

}
