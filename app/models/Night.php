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
