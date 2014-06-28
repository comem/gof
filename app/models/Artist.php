<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Artist extends MyEloquent {

    protected $table = 'artists';
    public $timestamps = true;

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    public function genres() {
        return $this->belongsToMany('Genre');
    }

    public function musicians() {
        return $this->belongsToMany('Musician')->withPivot('instrument_id');
    }

    public function links() {
        return $this->hasMany('Link');
    }

    public function nights() {
        return $this->belongsToMany('Night');
    }

    public function images() {
        return $this->hasMany('Image');
    }

    public function instruments() {
        return $this->belongsToMany('Instrument', 'artist_musician')->withPivot('musician_id');
    }

    public static function validate($data = array()) {
        return parent::validator($data, array(
                    'id' => 'integer:unsigned|sometimes|required',
                    'name' => 'string|between:1,255|sometimes|required',
                    'short_description_de' => 'string|between:1,255|sometimes',
                    'complete_description_de' => 'string|between:1,255|sometimes',
                    'created_at' => 'date|sometimes|required',
                    'updated_at' => 'date|sometimes|required',
                    'deleted_at' => 'date|sometimes',
        ));
    }

    public static function existTechId($artistId) {
        $e = Artist::find($artistId);
        return $e != null;
    }

}
