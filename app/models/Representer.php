<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

/**
 * Not implemented yet.
 *
 * @category  Model
 * @version   0.0
 * @author    gof
 */
class Representer extends MyEloquent {

    protected $table = 'representers';
    public $timestamps = true;

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    public function nights() {
        return $this->hasMany('Night');
    }


}
