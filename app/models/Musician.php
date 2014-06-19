<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Musician extends MyEloquent {

	protected $table = 'musicians';
	public $timestamps = true;

	use SoftDeletingTrait;

	protected $dates = ['deleted_at'];

	public function artists()
	{
		return $this->belongsToMany('Artist');
	}

	public static function validate($data = array())
    {
        return parent::validator($data, array(
            'id'      => 'unsigned|sometimes|required',
            'first_name' => 'string|between:1,255|sometimes|required',
            'last_name' => 'string|between:1,255|sometimes',
            'stagename' => 'string|between:1,255|sometimes',
            'created_at' => 'date|sometimes|required',
            'updated_at' => 'date|sometimes|required',
            'deleted_at' => 'date|sometimes',
        ));
    }

}