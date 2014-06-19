<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Equipment extends MyEloquent {

	protected $table = 'equipments';
	public $timestamps = false;

	use SoftDeletingTrait;

	protected $dates = ['deleted_at'];

	public function events()
	{
		return $this->belongsToMany('Night');
	}

}