<?php

/**
 * Not implemented yet.
 *
 * @category  Model
 * @version   0.0
 * @author    gof
 */
class NightMember extends MyEloquent {

	protected $table = 'night_member';
	public $timestamps = false;

	public function job()
	{
		return $this->belongsTo('Job');
	}

}