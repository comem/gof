<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Nighttype extends MyEloquent {

    protected $table = 'nighttypes';
    public $timestamps = false;

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    public function events() {
        return $this->hasMany('Night');
    }

    public static function validate($data = array()) {
        return parent::validator($data, array(
                    'id' => 'unsigned|sometimes|required',
                    'name_de' => 'string|between:1,255|sometimes|required|unique:nighttypes',
                    'deleted_at' => 'date|sometimes',
        ));
    }

    public static function existTechId($id) {
        $e = Nighttype::find($id);
        return $e != null;
    }

}
