<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Instrument extends MyEloquent {

	protected $table = 'instruments';
	public $timestamps = false;

	use SoftDeletingTrait;

	protected $dates = ['deleted_at'];

	public function artist_musicians()
	{
		return $this->hasMany('ArtistMusician');
	}

	public static function validate($data = array())
    {
           
        return parent::validator($data, array(
            'id' => 'unsigned|sometimes|required',
            'name_de' => 'string|between:1,255|sometimes|required|unique:instruments',
            'deleted_at' => 'date|sometimes',
        ));
    }

}