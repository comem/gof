<?php


use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class User extends MyEloquent {

	protected $table = 'users';
	public $timestamps = true;

	use SoftDeletingTrait, UserTrait, RemindableTrait;

	protected $dates = ['deleted_at'];
	protected $hidden = array('password');

	public function group()
	{
		return $this->belongsTo('Group');
	}

	public function language()
	{
		return $this->belongsTo('Language');
	}
        
         public static function validate($data = array())
    {
        return parent::validator($data, array(
            
            'email' => 'unique|string|between:1,255|sometimes|required',
            'first_name' => 'string|between:1,255|sometimes|required',
            'last_name' => 'string|between:1,255|sometimes|required',
            'password' => 'string|between:1,255|sometimes|required',
            'last_loing' => 'datetime|sometimes',
           
        ));
    }

}