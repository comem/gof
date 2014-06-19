<?php

class GroupResource extends MyEloquent {

	protected $table = 'group_resource';
	public $timestamps = false;
        
               public static function validate($data = array())
    {
        return parent::validator($data, array(

            
            'group_name' => 'string|between:1,255|sometimes|required',
            'resource_model' => 'string|between:1,25|sometimes|required',
            'resource_function'  => 'string|between:1,255|sometimes|required'
            

        ));
    }

}