<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Plateform extends MyEloquent {

	protected $table = 'plateforms';
	public $timestamps = false;

	use SoftDeletingTrait;

	protected $dates = ['deleted_at'];
	protected $hidden = array('softDeletes');

	public function events()
	{
		return $this->belongsToMany('Night');
	}

	public static function validate($data = array())
    {
        return parent::validator($data, array(
            'id' => 'unsigned|sometimes|required',
            'name' => 'string|between:1,255|sometimes|requiered|unique:plateforms',
            'client_id' => 'string|between:1,255|sometimes',
            'client_secret' => 'string|between:1,255|sometimes',
            'api_infos' => 'string|between:1,10000|sometimes',
            'deleted_at' => 'date|sometimes',
        ));
    }

}