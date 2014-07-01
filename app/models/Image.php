<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

/**
 * Image model
 * 
 * Corresponds to the "images" class of the class diagram.
 *
 * @category  Model
 * @version   1.0
 * @author    gof
 */
class Image extends MyEloquent {

    protected $table = 'images';
    public $timestamps = true;

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    /**
     * Allows to define the relationship between Image and Night.
     * @return Night the nights of the image.
     */
    public function nights() {
        return $this->hasMany('Night');
    }

    /**
     * Allows to define the relationship between Image and Artist.
     * @return Artist the artist of the image.
     */
    public function artist() {
        return $this->belongsTo('Artist');
    }

    /**
     * Allows to validate attributes for an Image.
     * @param array data array with every attributes that has to be validate. 
     * @return boolean true if the input data are valid, false otherwise.
     */
    public static function validate($data = array()) {
        return parent::validator($data, array(
                    'id' => 'integer:unsigned|sometimes|required',
                    'alt_de' => 'string|between:1,255|sometimes',
                    'caption_de' => 'string|between:1,255|sometimes',
                    'source' => 'string|between:1,255|sometimes',
                    'created_at' => 'date|sometimes|required',
                    'updated_at' => 'date|sometimes|required',
                    'deleted_at' => 'date|sometimes',
                    'artist_id' => 'integer:unsigned|sometimes',
                    'uploaded_img' => 'mimes:jpeg,bmp,png|sometimes|required',
        ));
    }

    /**
     * Allows to verify if an Image exists in the database with his technical id.
     * @param int the technical id corresponding to the primary key of the Image.
     * @return boolean true if the Image exists in the database, false otherwise.
     */
    public static function existTechId($imageId) {
        $e = Image::find($imageId);
        return $e != null;
    }

}
