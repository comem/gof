<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

/**
 * Platform model
 * 
 * Corresponds to the "platforms" class of the class diagram.
 *
 * @category  Model
 * @version   1.0
 * @author    gof
 */
class Platform extends MyEloquent {

    protected $table = 'platforms';
    public $timestamps = false;

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
    protected $hidden = array('softDeletes');

    /**
     * Allows to define the relationship between Platform and Night.
     * @return Night the nights of the platform.
     */
    public function nights() {
        return $this->belongsToMany('Night');
    }

    /**
     * Allows to validate attributes for a Platform.
     * @param array data array with every attributes that has to be validate. 
     * @return boolean|array true if the input data are valid, array with errors otherwise.
     */
    public static function validate($data = array()) {
        return parent::validator($data, array(
                    'id' => 'unsigned|sometimes|required',
                    'name' => 'string|between:1,255|sometimes|required|unique:platforms',
                    'client_id' => 'string|between:1,255|sometimes',
                    'client_secret' => 'string|between:1,255|sometimes',
                    'api_infos' => 'string|between:1,10000|sometimes',
                    'deleted_at' => 'date|sometimes',
        ));
    }

    /**
     * Allows to verify if a Platform exists in the database with his technical id.
     * @param int the technical id corresponding to the primary key of the Plaform.
     * @return boolean true if the Platform exists in the database, false otherwise.
     */
    public static function existTechId($platformId) {
        $e = Platform::find($platformId);
        return $e != null;
    }
    
    /**
     * Allows to verify if a Platform exists in the database with his business id.
     * @param string the business id corresponding to the url of the Platform.
     * @return boolean true if the Platform exists in the database, false otherwise.
     */
    public static function existBusinessId($platformName) {
        $e = Platform::where('name', '=', $platformName)->first();
        return $e != null;
    }

}
