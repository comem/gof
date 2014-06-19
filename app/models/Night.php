<?php

class Night extends MyEloquent {

    protected $table = 'nights';
    public $timestamps = true;

    public function event_types() {
        return $this->belongsTo('NightType');
    }

    public function images() {
        return $this->belongsTo('Image');
    }

    public function jobs() {
        return $this->belongsToMany('Job');
    }

    public function plateforms() {
        return $this->belongsToMany('Plateform');
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

    public function validate($data = array()) {
        return parent::validator($data, array(
                    'id' => 'unsigned|sometimes|required',
                    'start_date_hour' => 'unique:nights|date|sometimes|required',
                    'ending_date_hour' => 'date|sometimes|required',
                    'opening_doors' => 'date|sometimes',
                    'title_de' => 'string|sometimes|required',
                    'nb_meal' => 'unsigned|sometimes|required',
                    'nb_vegans_meal' => 'unsigned|sometimes|required',
                    'meal_notes' => '',
                    'nb_places' => '',
                    'nb_places' => '',
                    'followed_by_private' => '',
                    'contact_src' => '',
                    'notes' => '',
                    'published_at' => '',
                    'nighttype_id' => '',
                    'image_id' => '',
                    'created_at' => '',
                    'updated_at' => '',
        ));
    }

}
