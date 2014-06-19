<?php

class Group extends MyEloquent {

	protected $table = 'groups';
	public $timestamps = true;

	public function resources()
	{
		return $this->belongsToMany('Resource');
	}

	public function users()
	{
		return $this->hasMany('User');
	}

	public function group()
	{
		return $this->belongsTo('Group');
	}
        
           public static function validate($data = array())
    {
        return parent::validator($data, array(

            
            'name' => 'unique|string|between:1,255|sometimes|required',

        ));
    }

}