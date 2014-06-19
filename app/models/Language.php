<?php

class Language extends MyEloquent {

    protected $table = 'languages';
    public $timestamps = false;

    public function users() {
        return $this->hasMany('User');
    }

    public static function validate($data = array()) {
        return parent::validator($data, array(
            
                 
                    'locale' => 'unique|string|between:1,255|sometimes|required',
                    'name_de' => 'string|between:1,255|sometimes|required'
        ));
    }

}
