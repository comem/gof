<?php

class NightsController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return Jsend::success(Night::all()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $start_date_hour = Input::get('start_date_hour');
        $ending_date_hour = Input::get('ending_date_hour');
        $opening_doors = Input::get('opening_doors');
        $title_de = Input::get('title_de');
        $nb_meal = Input::get('nb_meal');
        $nb_vegans_meal = Input::get('nb_vegans_meal');
        $meal_notes = Input::get('meal_notes');
        $nb_places = Input::get('nb_places');
        $followed_by_private = Input::get('followed_by_private');
        $contract_src = Input::get('contract_src');
        $notes = Input::get('notes');
        $nighttype_id = Input::get('nighttype_id');
        $image_id = Input::get('image_id');
        $ticket_categorie = Input::get('ticket_categorie');




        if (Night::existBuisnessId($start_date_hour) == true) {

            return Jsend::error("event already exist in the database");
        }
        
        // Validation des types
        $validationNight = Night::validate(array(
            'start_date_hour' => $start_date_hour,
            'ending_date_hour' => $ending_date_hour,
            'opening_doors' => $opening_doors,
            'title_de' => $title_de,
            'nb_meal' => $nb_meal,
            'nb_vegans_meal' => $nb_vegans_meal,
            'meal_notes' => $meal_notes,
            'nb_places' => $nb_places,
            'followed_by_private' => $followed_by_private,
            'contract_src' => $contract_src,
            'notes' => $notes,
            'nighttype_id' => $nighttype_id,
            'image_id' => $image_id
        ));
        if ($validationNight !== true) {
            return Jsend::fail($validationNight);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
