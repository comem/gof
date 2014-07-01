<?php

class Link extends MyEloquent {

    protected $table = 'links';
    public $timestamps = false;

    /**
     * Allows to define the relationship between Link and Artist.
     * @return Artist the artist who own the link.
     */
    public function artist() {
        return $this->belongsTo('Artist');
    }

    /**
     * Allows to validate attributes for a Link.
     * @param array data array with every attributes that has to be validate. 
     * @return boolean true if the input data are valid, false otherwise.
     */
    public static function validate($data = array()) {
        return parent::validator($data, array(
                    'id' => 'integer:unsigned|sometimes|required',
                    'url' => 'string|between:1,255|sometimes|required|unique:links',
                    'name_de' => 'string|between:1,255|sometimes|required',
                    'title_de' => 'string|between:1,255|sometimes',
                    'artist_id' => 'integer:unsigned|sometimes|required',
        ));
    }

    /**
     * Allows to verify if a Link exists in the database with his technical id.
     * @param int the technical id corresponding to the primary key of the Link.
     * @return boolean true if the Link exists in the database, false otherwise.
     */
    public static function existTechId($linkId) {
        $e = Link::find($linkId);
        return $e != null;
    }

    /**
     * Allows to verify if a Link exists in the database with his business id.
     * @param string the business id corresponding to the url of the Link.
     * @return boolean true if the Link exists in the database, false otherwise.
     */
    public static function existBusinessId($linkUrl) {
        $e = Link::where('url', '=', $linkUrl)->first();
        return $e != null;
    }

}
