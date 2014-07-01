<?php

class Night extends MyEloquent {

    protected $table = 'nights';
    public $timestamps = true;

    public function nighttype() {
        return $this->belongsTo('Nighttype');
    }

    public function image() {
        return $this->belongsTo('Image');
    }

    public function representer() {
        return $this->belongsTo('Representer');
    }

    public function jobs() {
        return $this->belongsToMany('Job');
    }

    public function platforms() {
        return $this->belongsToMany('Platform');
    }

    public function members() {
        return $this->belongsToMany('Member');
    }

    public function equipments() {
        return $this->belongsToMany('Equipment');
    }

    public function ticketcategories() {
        return $this->belongsToMany('Ticketcategorie')->withPivot('amount', 'quantity_sold', 'comment_de');
    }

    public function printingtypes() {
        return $this->belongsToMany('Printingtype');
    }

    public function gifts() {
        return $this->belongsToMany('Gift');
    }

    public function artists() {
        return $this->belongsToMany('Artist')->withPivot('order', 'artist_hour_arrival');
    }

    /**
     * Cette méthode permet de lier l'événement à un interprète (performer = table pivot)
     * @return L'interprète lié à cet événement.
     */
    public function artistNights() {
        return $this->hasMany('ArtistNight');
    }

    public function nightPlatforms() {
        return $this->hasMany('NightPlatform');
    }

    public function nightTicketcategorie() {
        return $this->hasMany('NightTicketcategorie');
    }

    public function nights() {
        return $this->hasMany('Night');
    }

    public static function comparison_date($start_date_hour, $end_date_hour) {
        if (strtotime($start_date_hour) < strtotime($end_date_hour)) {
            return true;
        }
        return false;
    }

    /**
     * Cette méthode vérifie l'existant due l'événement selon son identifiant métier.
     * @param Un identifiant méditer correspondant à un attribut unique.
     * @return True si le lien existe.
     *         False si le lien n'existe pas.
     */
    public static function existBuisnessId($nightStartDateHour) {
        $e = Night::where('start_date_hour', '=', $nightStartDateHour)
                ->first();
        return $e != null;       // Si null, n’existe pas 
    }

    /**
     * Cette méthode vérifie l'existant de l'événement selon son identifiant technique.
     * @param Un identifiant technique correspondant à la clé primaire de cet événement. 
     * @return True si le lien existe.
     *         False si le lien n'existe pas.
     */
    public static function existTechId($nightId) {
        $e = Night::where('id', '=', $nightId)
                ->first();
        return $e != null;       // Si null, n’existe pas 
    }

    /**
     * Cette méthode valide les types des attributs selon une liste de critères par attribut.
     * @param array $data Chaîne de caractère possèdant chaque attribut et leurs critères de validation. 
     * @return True si les données sont valides ou pas. 
     *         False si les données ne sont pas valides.
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
