<?php

class NightMember extends MyEloquent {

	protected $table = 'night_member';
	public $timestamps = false;

	public function job()
	{
		return $this->belongsTo('Job');
	}

}