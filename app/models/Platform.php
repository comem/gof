<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Platform extends MyEloquent {

	protected $table = 'platforms';
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
            'name' => 'string|between:1,255|sometimes|requiered|unique:platforms',
            'client_id' => 'string|between:1,255|sometimes',
            'client_secret' => 'string|between:1,255|sometimes',
            'api_infos' => 'string|between:1,10000|sometimes',
            'deleted_at' => 'date|sometimes',
        ));
    }

    public static function existTechId($platformId) {
        $e = Platform::find($platformId);
        return $e != null;
    }

    public static function existBusinessId($platformName) {
        $e = Platform::where('name','=',$platformName)->first();
        return $e != null;
    }

}