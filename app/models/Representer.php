<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Image extends MyEloquent {

    protected $table = 'representers';
    public $timestamps = true;

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    /**
     * Cette méthode permet de lier l'image à un événement (soirée).
     * @return La soirée à ui est liée à cette image.
     */
    public function nights() {
        return $this->hasMany('Night');
    }

   
}
