<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Job extends MyEloquent {

	protected $table = 'jobs';
	public $timestamps = false;

	use SoftDeletingTrait;

	protected $dates = ['deleted_at'];

	public function members()
	{
		return $this->belongsToMany('Member');
	}

	public function events()
	{
		return $this->belongsToMany('Night');
	}

	public function staffs()
	{
		return $this->hasMany('NightMember');
	}

}