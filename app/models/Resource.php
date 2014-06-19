<?php

class Resource extends MyEloquent {

	protected $table = 'resources';
	public $timestamps = true;

	public function groups()
	{
		return $this->belongsToMany('Group');
	}

        
           public static function validate($data = array())
    {
        return parent::validator($data, array(
  
            
            'model' => 'string|between:1,200|sometimes|required',
            'function' => 'string|between:1,200|sometimes|required',
            'created_at' => 'date|sometimes|required',
            'updated_at' => 'date|sometimes|required',
            
        ));
    }
}