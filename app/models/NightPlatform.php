<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

/**
 * NightPlatform model
 * 
 * Corresponds to the "publications" class of the class diagram.
 *
 * @category  Model
 * @version   1.0
 * @author    gof
 */
class NightPlatform extends MyEloquent {

	protected $table = 'night_platform';
    // protected $primaryKey = array('night_id', 'platform_id');
    // public $incrementing = false;
	public $timestamps = true;

    /**
     * Allows to validate attributes for a NightPlatform.
     * @param array data array with every attributes that has to be validate. 
     * @return boolean|array true if the input data are valid, array with errors otherwise.
     */
    public static function validate($data = array())
    {
        return parent::validator($data, array(
            'platform_id' => 'integer:unsigned|sometimes|required',
            'night_id' => 'integer:unsigned|sometimes|required',
            'external_id' => 'string|between:1,255|sometimes|required',
            'external_infos' => 'string|between:1,10000|sometimes',
            'url' => 'string|between:1,255|sometimes|required',
            'created_at' => 'date|sometimes|required',
            'updated_at' => 'date|sometimes|required',
        ));
    }

    /**
     * Allows to verify if a NightPlatform exists in the database with his technical id.
     * @param int the technical id of night corresponding to the composite primary key of the NightPlatform.
     * @param int the technical id of platform corresponding to the composite primary key of the NightPlatform.
     * @return boolean true if the Night exists in the database, false otherwise.
     */
    public static function existTechId($night_id, $platform_id) {
        $e = NightPlatform::where('night_id', '=', $night_id)->where('platform_id', '=', $platform_id)->first();
        return $e != null;
    }

}