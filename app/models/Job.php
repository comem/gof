<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

/**
 * Not implemented yet.
 *
 * @category  Model
 * @version   0.0
 * @author    gof
 */
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