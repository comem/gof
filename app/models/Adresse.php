<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Adresse extends MyEloquent {

	protected $table = 'adresses';
	public $timestamps = false;

	use SoftDeletingTrait;

	protected $dates = ['deleted_at']; // soft delete

	public function members()
	{
		return $this->hasMany('Member');
	}

}