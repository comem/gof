<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

/**
 * Not implemented yet.
 *
 * @category  Model
 * @version   0.0
 * @author    gof
 */
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