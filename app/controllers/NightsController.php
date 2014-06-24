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

        if ($image_id != null) {
            if (existTechId($image_id) == false) {
                return Jsend::error("Image doesn't exist in the database");
            }
        }

        foreach ($ticket_categorie as $tc) {
            $ticketCatId = $tc['ticket_categorie_id'];
            $amount = $tc['amount'];
            $quantitySold = $tc['quantitySold'];
            $comment = $tc['comment'];

            $validationNightTicketCat = TicketCategorie::validate(array(
                        'night_id' => '1',
                        'ticketcategorie_id' => $ticketCatId,
                        'amount' => $amount,
                        'quantity_sold' => $quantitySold,
                        'comment' => $comment,
            ));

            if ($validationNightTicketCat !== true) {
                return Jsend::fail($validationNightTicketCat);
            }

            if (!TicketCategorie::existTechId($ticketCatId)) {
                return Jsend::error('ticketcategorie not found');
            }
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



        if (!Night::comparison_date($start_date_hour, $ending_date_hour)) {
            return Jsend::fail(array('id' => "The start date is after the ending date"
                        , 'date_1' => $start_date_hour
                        , 'date_2' => $ending_date_hour));
        }



        if ($opening_doors != null) {
            if (Night::comparison_date($start_date_hour, $opening_doors)) {
                return Jsend::fail("The opening door is after the start date");
            }
        }

        $all_night = Night::all();

        foreach ($all_night as $night) {
            $start_night = $night->start_date_hour;
            $end_night = $night->ending_date_hour;


            if (Night::comparison_date($start_night, $start_date_hour) && Night::comparison_date($start_date_hour, $end_night)) {
                return Jsend::fail("The actual event overlaps an existing one");
            }
            if (Night::comparison_date($start_night, $ending_date_hour) && Night::comparison_date($ending_date_hour, $end_night)) {
                return Jsend::fail("The actual event overlaps an existing one");
            }
        }

        $night = new Night();
        $night->start_date_hour = $start_date_hour;
        $night->ending_date_hour = $ending_date_hour;
        if ($opening_doors != '') {
            $night->opening_doors = $opening_doors;
        }
        $night->title_de = $title_de;
        $night->nb_meal = $nb_meal;
        $night->nb_vegans_meal = $nb_vegans_meal;
        $night->meal_notes = $meal_notes;
        $night->nb_places = $nb_places;
        $night->followed_by_private = $followed_by_private;
        $night->contact_src = $contract_src;
        $night->notes = $notes;
        $night->nighttype_id = $nighttype_id;
        if ($image_id != '') {
            $night->image_id = $image_id;
        }

        $night->save();
        $nightId = $night->id;
        foreach ($ticket_categorie as $tc) {
            $nightTicketCat = new NightTicketcategorie();
            $nightTicketCat->night_id = $nightId;
            $nightTicketCat->ticketcategorie_id = $ticketCatId;
            $nightTicketCat->amount = $amount;
            $nightTicketCat->quantity_sold = $quantitySold;
            $nightTicketCat->comment_de = $comment;
            $nightTicketCat->save();
        }
        // Et on retourne l'id du lien nouvellement créé (encapsulé en JSEND)
        return Jsend::success(array('id' => $night->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($night_id) {
        // Auth
        if (ctype_digit($night_id)) {
            $night_id = (int) $night_id;
        }

        if (Night::existTechId($night_id) !== true) {
            return Jsend::error("night doesn't exists in the database");
        }

        $night = Night::find($night_id);

        if (!isset($night)) {
            return Jsend::error('Night id : ' . $night_id . 'resource not found');
        }
        // Retourne le message encapsulé en JSEND si tout est OK
        return Jsend::success($night->toArray());
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
