<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Genre extends MyEloquent {

	protected $table = 'genres';
	public $timestamps = false;

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
            'name_de' => 'string|between:1,255|sometimes|required|unique:genres',
            'deleted_at' => 'datetime|sometimes',
        ));
    }

}