<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Printingtype extends MyEloquent {

	protected $table = 'printingtypes';
	public $timestamps = false;

	use SoftDeletingTrait;

	protected $dates = ['deleted_at'];

	public function events()
	{
		return $this->belongsToMany('Night');
	}

}