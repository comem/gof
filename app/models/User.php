<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

/**
 * User model (ACL)
 * 
 * Corresponds to the "users" class of the class diagram.
 *
 * @category  Model
 * @version   1.0
 * @author    gof
 */
class User extends MyEloquent implements UserInterface, RemindableInterface {

    protected $table = 'users';
    public $timestamps = true;

    use SoftDeletingTrait,
        UserTrait,
        RemindableTrait;

    protected $dates = ['deleted_at'];
    protected $hidden = array('password');

    /**
     * Allows to define the relationship between User and Group.
     * @return Group the group of the user.
     */
    public function group() {
        return $this->belongsTo('Group');
    }

    /**
     * Allows to verify if a group has access to a resource.
     * @return boolean true if the group has access, false otherwise.
     */
    public function hasResource($resourceName) {

        if ($this->group->hasResource($resourceName)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Allows to verify if a group has the correct role to access to a resource.
     * @return boolean true if the user has access, false otherwise.
     */
    public function hasRoleForResource($roleName, $resourceName) {
        if ($this->group->hasRoleForResource($roleName, $resourceName)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Allows to define the relationship between User and Language.
     * @return Language the language of the user.
     */
    public function language() {
        return $this->belongsTo('Language');
    }

    /**
     * Allows to validate attributes for a User.
     * @param array data array with every attributes that has to be validate. 
     * @return boolean|array true if the input data are valid, array with errors otherwise.
     */
    public static function validate($data = array()) {
        return parent::validator($data, array(
                    'email' => 'string|between:1,255|sometimes|required',
                    'first_name' => 'string|between:1,255|sometimes|required',
                    'last_name' => 'string|between:1,255|sometimes|required',
                    'password' => 'string|between:1,255|sometimes|required',
                    'last_login' => 'datetime|sometimes',
                    'created_at' => 'date|sometimes|required',
                    'updated_at' => 'date|sometimes|required',
                    'deleted_at' => 'date|sometimes',
        ));
    }

}
