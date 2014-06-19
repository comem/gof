<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Gift extends MyEloquent {

	protected $table = 'gifts';
	public $timestamps = false;

	use SoftDeletingTrait;

	protected $dates = ['deleted_at'];

	public function events()
	{
		return $this->belongsToMany('');
	}

}