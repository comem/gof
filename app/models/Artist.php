<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

/**
 * Artist model
 *
 * Corresponds to the "artists" class of the class diagram.
 * 
 * @category  Model
 * @version   1.0
 * @author    gof
 */
class Artist extends MyEloquent {

    protected $table = 'artists';
    public $timestamps = true;
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];

    /**
     * Allows to define the relationship between Artist and Genre.
     * @return Genre the genres of the artist.
     */
    public function genres() {
        return $this->belongsToMany('Genre');
    }

    /**
     * Allows to define the relationship between Artist and Musician.
     * @return Musician the musicians of the artist.
     */
    public function musicians() {
        return $this->belongsToMany('Musician')->withPivot('instrument_id');
    }

    /**
     * Allows to define the relationship between Artist and Link.
     * @return Link the links of the artist.
     */
    public function links() {
        return $this->hasMany('Link');
    }

    /**
     * Allows to define the relationship between Artist and Night.
     * @return Night the nights of the artist.
     */
    public function nights() {
        return $this->belongsToMany('Night');
    }

    /**
     * Allows to define the relationship between Artist and Image.
     * @return Image the images of the artist.
     */
    public function images() {
        return $this->hasMany('Image');
    }

    /**
     * Allows to define the relationship between Artist and Instrument.
     * @return Instrument the instruments of the artist.
     */
    public function instruments() {
        return $this->belongsToMany('Instrument', 'artist_musician')->withPivot('musician_id');
    }

    /**
     * Allows to validate attributes for an Artist.
     * @param array data array with every attributes that has to be validate. 
     * @return boolean true if the input data are valid, false otherwise.
     */
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

    /**
     * Allows to verify if an Artist exists in the database with his technical id.
     * @param int the technical id corresponding to the primary key of the Artist.
     * @return boolean true if the Artist exists in the database, false otherwise.
     */
    public static function existTechId($artistId) {
        $e = Artist::find($artistId);
        return $e != null;
    }

}
