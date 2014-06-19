<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Image extends MyEloquent {

	protected $table = 'images';
	public $timestamps = true;

	use SoftDeletingTrait;

	protected $dates = ['deleted_at'];

	public function events()
	{
		return $this->hasMany('Night');
	}

	public static function validate($data = array())
    {
        return parent::validator($data, array(
            'id' => 'unsigned|sometimes|required',
            'alt_de' => 'string|between:1,255|sometimes',
            'caption_de' => 'string|between:1,255|sometimes',
            'source' => 'string|between:1,255|sometimes|required',
            'created_at' => 'date|sometimes|required',
            'updated_at' => 'date|sometimes|required',
            'deleted_at' => 'date|sometimes',
            'artist_id' => 'unsigned|sometimes|required',
        ));
    }

}