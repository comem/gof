<?php

/**
 * Night model
 * 
 * Corresponds to the "events" class of the class diagram.
 *
 * @category  Model
 * @version   1.0
 * @author    gof
 */
class Night extends MyEloquent {

    protected $table = 'nights';
    public $timestamps = true;

    /**
     * Allows to define the relationship between Night and Nighttype.
     * @return Nighttype the nighttype of the night.
     */
    public function nighttype() {
        return $this->belongsTo('Nighttype');
    }

    /**
     * Allows to define the relationship between Night and Image.
     * @return Image the image of the night.
     */
    public function image() {
        return $this->belongsTo('Image');
    }

    /**
     * Allows to define the relationship between Night and Representer.
     * @return Representer the representer of the night.
     */
    public function representer() {
        return $this->belongsTo('Representer');
    }

    /**
     * Allows to define the relationship between Night and Job.
     * @return Job the jobs of the night.
     */
    public function jobs() {
        return $this->belongsToMany('Job');
    }

    /**
     * Allows to define the relationship between Night and Platform.
     * @return Platform the platforms of the night.
     */
    public function platforms() {
        return $this->belongsToMany('Platform');
    }

    /**
     * Allows to define the relationship between Night and Member.
     * @return Artist the members of the night.
     */
    public function members() {
        return $this->belongsToMany('Member');
    }

    /**
     * Allows to define the relationship between Night and Equipment.
     * @return Equipment the equipments of the night.
     */
    public function equipments() {
        return $this->belongsToMany('Equipment');
    }

    /**
     * Allows to define the relationship between Night and Ticketcategorie.
     * @return Ticketcategorie the ticketcategories of the night.
     */
    public function ticketcategories() {
        return $this->belongsToMany('Ticketcategorie')->withPivot('amount', 'quantity_sold', 'comment_de');
    }

    /**
     * Allows to define the relationship between Night and Printingtype.
     * @return Printingtype the printingtypes of the night.
     */
    public function printingtypes() {
        return $this->belongsToMany('Printingtype');
    }

    /**
     * Allows to define the relationship between Night and Gift.
     * @return Gift the gifts of the night.
     */
    public function gifts() {
        return $this->belongsToMany('Gift');
    }

    /**
     * Allows to define the relationship between Night and Artist.
     * @return Artist the artists of the night.
     */
    public function artists() {
        return $this->belongsToMany('Artist')->withPivot('order', 'artist_hour_arrival');
    }

    /**
     * Allows to define the relationship between Night and ArtistNight.
     * @return ArtistNight the artistnights of the night.
     */
    public function artistNights() {
        return $this->hasMany('ArtistNight');
    }

    /**
     * Allows to define the relationship between Night and NightPlatform.
     * @return NightPlatform the nightplatforms of the night.
     */
    public function nightPlatforms() {
        return $this->hasMany('NightPlatform');
    }

    /**
     * Allows to define the relationship between Night and NightTicketcategorie.
     * @return Ticketcategorie the ticketcategories of the night.
     */
    public function nightTicketcategorie() {
        return $this->hasMany('NightTicketcategorie');
    }

    public static function comparison_date($start_date_hour, $end_date_hour) {
        if (strtotime($start_date_hour) < strtotime($end_date_hour)) {
            return true;
        }
        return false;
    }

    /**
     * Allows to verify if a Night exists in the database with his business id.
     * @param string the business id corresponding to the url of the Night.
     * @return boolean true if the Night exists in the database, false otherwise.
     */
    public static function existBuisnessId($nightStartDateHour) {
        $e = Night::where('start_date_hour', '=', $nightStartDateHour)
                ->first();
        return $e != null;       // Si null, n’existe pas 
    }

    /**
     * Allows to verify if a Night exists in the database with his technical id.
     * @param int the technical id corresponding to the primary key of the Night.
     * @return boolean true if the Night exists in the database, false otherwise.
     */
    public static function existTechId($nightId) {
        $e = Night::where('id', '=', $nightId)
                ->first();
        return $e != null;       // Si null, n’existe pas 
    }

    /**
     * Allows to validate attributes for a Night.
     * @param array data array with every attributes that has to be validate. 
     * @return boolean|array true if the input data are valid, array with errors otherwise.
     */
    public static function validate($data = array()) {
        return parent::validator($data, array(
                    'id' => 'integer:unsigned|sometimes|required',
                    'start_date_hour' => 'date|sometimes|required',
                    'ending_date_hour' => 'date|sometimes|required',
                    'opening_doors' => 'date|sometimes',
                    'title_de' => 'string|between:1,255|sometimes|required',
                    'nb_meal' => 'integer:unsigned|sometimes|required',
                    'nb_vegans_meal' => 'integer:unsigned|sometimes|required',
                    'meal_notes' => 'string|between:1,10000|sometimes',
                    'nb_places' => 'integer:unsigned|sometimes|required',
                    'followed_by_private' => 'sometimes|required',
                    'contact_src' => 'string|between:1,255|sometimes',
                    'notes' => 'string|between:1,10000|sometimes',
                    'published_at' => 'date|sometimes',
                    'created_at' => 'date|sometimes|required',
                    'updated_at' => 'date|sometimes|required',
                    'nighttype_id' => 'integer:unsigned|sometimes|required',
                    'image_id' => 'integer:unsigned|sometimes',
        ));
    }

}
