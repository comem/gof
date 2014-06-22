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
        return $this->belongsToMany('Ticketcategorie');
    }

    public function printingtypes() {
        return $this->belongsToMany('Printingtype');
    }

    public function gifts() {
        return $this->belongsToMany('Gift');
    }

    public function artists() {
        return $this->belongsToMany('Artist');
    }    

    /**
     * Cette méthode vérifie l'existant due l'événement selon son identifiant métier.
     * @param Un identifiant méditer correspondant à un attribut unique.
     * @return True si le lien existe.
     *         False si le lien n'existe pas.
     */
    public static function existBuisnessId($nightStartDateHour){
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
    public static function existTechId($nightId){
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
    public function validate($data = array()) {
        return parent::validator($data, array(
                    'id' => 'unsigned|sometimes|required',
                    'start_date_hour' => 'date|sometimes|required|unique:nights',
                    'ending_date_hour' => 'date|sometimes|required',
                    'opening_doors' => 'date|sometimes',
                    'title_de' => 'string|between:1,255|sometimes|requiered',
                    'nb_meal' => 'unsigned|sometimes|required',
                    'nb_vegans_meal' => 'unsigned|sometimes|required',
                    'meal_notes' => 'string|between:1,10000|sometimes',
                    'nb_places' => 'unsigned|sometimes|required',
                    'followed_by_private' => 'sometimes|required',
                    'contact_src' => 'string|between:1,255|sometimes',
                    'notes' => 'string|between:1,10000|sometimes',
                    'published_at' => 'date|sometimes',
                    'created_at' => 'date|sometimes|requiered',
                    'updated_at' => 'date|sometimes|requiered',
                    'nighttype_id' => 'unsigned|sometimes|required',
                    'image_id' => 'unsigned|sometimes|required',
        ));
    }

}
