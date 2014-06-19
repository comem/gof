<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Member extends MyEloquent {

	protected $table = 'members';
	public $timestamps = true;

	use SoftDeletingTrait;

	protected $dates = ['deleted_at'];
	protected $hidden = array('softDeletes');

	public function functions()
	{
		return $this->belongsToMany('Job');
	}

	public function events()
	{
		return $this->belongsToMany('Night');
	}

	public function adresse()
	{
		return $this->belongsTo('Adresse');
	}

}