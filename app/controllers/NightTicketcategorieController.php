<?php

class NightTicketcategorieController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return Jsend::success(NightTicketcategorie::all()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $nightId = Input::get('night_id');
        $ticketCatId = Input::get('ticketcategorie_id');
        $amount = Input::get('amount');
        $quantitySold = Input::get('quantity_sold');
        $comment = Input::get('comment_de');


        $validationNightTicketCat = TicketCategorie::validate(array(
            'night_id' => $nightId,
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
        
        if (!Night::existTechId($nightId)) {
            return Jsend::error('night not found');
        }
        
        if (NightTicketcategorie::existTechId($ticketCatId, $nightId)) {
            return Jsend::error('nightticketcategorie already exists');
        }

        $nightTicketCat = new NightTicketcategorie();
        $nightTicketCat->night_id = $nightId;
        $nightTicketCat->ticketcategorie_id = $ticketCatId;
        $nightTicketCat->amount = $amount;
        $nightTicketCat->quantity_sold = $quantitySold;
        $nightTicketCat->comment_de = $comment;
        $nightTicketCat->save();
     
        // Et on retourne l'id du message nouvellement créé (encapsulé en JSEND)
        return Jsend::success(array('night_id' => $nightTicketCat->night_id, 'ticketcategorie_id' => $nightTicketCat->ticketcategorie_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id1) {
        
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
