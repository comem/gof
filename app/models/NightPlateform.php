<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class NightPlatform extends MyEloquent {

	protected $table = 'night_platform';
	public $timestamps = true;

	use SoftDeletingTrait;

	protected $dates = ['deleted_at'];

	public static function validate($data = array())
    {
        return parent::validator($data, array(
            'platform_id' => 'unsigned|sometimes|required',
            'event_id' => 'unsigned|sometimes|required',
            'external_id' => 'string|between:1,255|sometimes|required',
            'external_infos' => 'string|between:1,10000|sometimes',
            'url' => 'string|between:1,255|sometimes|required',
            'created_at' => 'date|sometimes|required',
            'deleted_at' => 'date|sometimes|required',
        ));
    }

}