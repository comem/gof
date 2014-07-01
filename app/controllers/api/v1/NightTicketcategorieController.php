<?php

namespace api\v1;

use \Jsend;
use \Input;
use \Request;
use \Night;
use \Ticketcategorie;
use \NightTicketcategorie;
use \BaseController;

/**
 * REST controller with index, store, show, update and destroy methods implemented.
 * 
 * Corresponds to the "tickets" class of the class diagram.
 *
 * @category  Application services
 * @version   1.0
 * @author    gof
 */
class NightTicketcategorieController extends BaseController {

    /**
     * Allows to display every nightticketcategory from the database.
     * @return Response Jsend::success with all nightticketcategory.
     */
    public function index() {
        // Retourne toutes les publication
        return Jsend::success(NightTicketcategorie::all()->toArray());
    }
    /**
     * Allows to save a new nightticketcategory.
     * @var night_id (int) - the id from the night (get)
     * @var ticketcategorie_id (int) - the id from the ticketcategorie (get)
     * @var amount (int) - the amount of the nightticketcategorie (get)
     * @var quantity_sold (int) - the quantitiy sold from the nightticketcategorie (get)
     * @var comment_de (string) - the comment from the nightticketcategorie (get)
     * 
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if a resource was not found.
     * @return Response Jsend::success if a new artist was created.
     */
    public function store() {

        $night_id = Input::get('night_id');
        $ticketCat_id = Input::get('ticketcategorie_id');
        $amount = Input::get('amount');
        $quantitySold = Input::get('quantity_sold');
        $comment_de = Input::get('comment_de');

        //Cast de ticketCat_id et de event_id car l'url les envoit en String
        if (ctype_digit($ticketCat_id)) {
            $ticketCat_id = (int)$ticketCat_id;
        }
        if (ctype_digit($night_id)) {
            $night_id = (int)$night_id;
        }
        if (ctype_digit($amount)) {
            $amount = (int)$amounr;
        }
        if (ctype_digit($quantitySold)) {
            $quantitySold = (int)$quantitySold;
        }

        // Validation des types
        $validationNightTicketCat = NightTicketcategorie::validate(array(
            'night_id' => $night_id,
            'ticketcategorie_id' => $ticketCat_id,
            'amount' => $amount,
            'quantity_sold' => $quantitySold,
            'comment_de' => $comment_de,
        ));
        if ($validationNightTicketCat !== true) {
            return Jsend::fail($validationNightTicketCat);
        }
        
        // Validation de l'existance de la catégorie de ticket
        if (!Ticketcategorie::existTechId($ticketCat_id)) {
            return Jsend::error('ticket category not found');
        }
        
        // Validation de l'existance de l'événement
        if (!Night::existTechId($night_id)) {
            return Jsend::error('night not found');
        }
        
        // // Validation de l'inexistance du ticket
        if (NightTicketcategorie::existTechId($ticketCat_id, $night_id)) {
            return Jsend::error('nightticketcategorie already exists');
        }

        // Tout est ok, sauvegarde du ticket avec les ids de l'événement et de la catégorie de ticket.
        $nightTicketCat = new NightTicketcategorie();
        $nightTicketCat->night_id = $night_id;
        $nightTicketCat->ticketcategorie_id = $ticketCat_id;
        $nightTicketCat->amount = $amount;
        $nightTicketCat->quantity_sold = $quantitySold;
        $nightTicketCat->comment_de = $comment_de;
        $nightTicketCat->save();
     
        // Retour l'id du ticket nouvellement créé (encapsulé en JSEND)
        return Jsend::success(array(
            'night_id' => $nightTicketCat->night_id,
            'ticketcategorie_id' => $nightTicketCat->ticketcategorie_id
        ));
    }

    /**
     * Allows to display a specific nightticketcategory from the database.
     * @param  int -  the id from the ticketcategorie (url)
     * @var  Night-id (int) - the id from the night (header)
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if the required resource was not found.
     * @return Response Jsend::success if the required platform was found.
     */
    public function show($ticketCat_id) {

        // Récupération par le header
        $night_id = Request::header('Night-id');

        //Cast de ticketCat_id et de event_id car l'url les envoit en String
        if (ctype_digit($ticketCat_id)) {
            $ticketCat_id = (int)$ticketCat_id;
        }
        if (ctype_digit($night_id)) {
            $night_id = (int)$night_id;
        }
 
        // Validation des types
        $validationNightTicketCat = NightTicketcategorie::validate(array(
            'night_id' => $night_id,
            'ticketcategorie_id' => $ticketCat_id,
        ));
        if ($validationNightTicketCat !== true) {
            return Jsend::fail($validationNightTicketCat);
        }

        // Validation de l'existance du ticket
        if (NightTicketcategorie::existTechId($ticketCat_id, $night_id) !== true) {
            return Jsend::error('ticket not found');
        }

        // Récupération du ticket
        $ticket = NightTicketcategorie::where('ticketcategorie_id', '=', $ticketCat_id)->where('night_id', '=', $night_id)->first();
        
        // Retourne le ticket encapsulée en JSEND si tout est OK
        return Jsend::success($ticket->toArray());
        
    }

    /**
     * Allows to modify a nightticketcategorie.
     * @param int the id from the ticketcategorie (url)
     * @var night_id (int) - the id from the night (get)
     * @var ticketcategorie_id (int) - the id from the ticketcategorie (get)
     * @var amount (int) - the amount of the nightticketcategorie (get)
     * @var quantity_sold (int) - the quantitiy sold from the nightticketcategorie (get)
     * @var comment_de (string) - the comment from the nightticketcategorie (get)
     * 
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if a resource was not found.
     * @return Response Jsend::success if a publication was modified.
     */
    public function update($ticketCat_id) {
        
        $night_id = Input::get('night_id');
        $ticketCat_id = Input::get('ticketcategorie_id');
        $amount = Input::get('amount');
        $quantitySold = Input::get('quantity_sold');
        $comment_de = Input::get('comment_de');

        //Cast de ticketCat_id et de event_id car l'url les envoit en String
        if (ctype_digit($ticketCat_id)) {
            $ticketCat_id = (int)$ticketCat_id;
        }
        if (ctype_digit($night_id)) {
            $night_id = (int)$night_id;
        }
        if (ctype_digit($amount)) {
            $amount = (int)$amounr;
        }
        if (ctype_digit($quantitySold)) {
            $quantitySold = (int)$quantitySold;
        }

        // Validation des types
        $validationNightTicketCat = NightTicketcategorie::validate(array(
            'night_id' => $night_id,
            'ticketcategorie_id' => $ticketCat_id,
            'amount' => $amount,
            'quantity_sold' => $quantitySold,
            'comment_de' => $comment_de,
        ));
        if ($validationNightTicketCat !== true) {
            return Jsend::fail($validationNightTicketCat);
        }

        // Validation de l'existance de l'événement
        if (Night::existTechId($night_id) !== true) {
            return Jsend::error('night not found');
        }

        // Validation de l'existance de la catégorie de ticket
        if (Ticketcategorie::existTechId($ticketCat_id) !== true) {
            return Jsend::error('ticket category not found');
        }

        // Validation de l'existance du ticket
        if (NightTicketcategorie::existTechId($ticketCat_id, $night_id) !== true) {
            return Jsend::error('ticket not found');
        }

        //Modification du ticket (table pivot).
        Night::find($night_id)->ticketcategories()->updateExistingPivot($ticketCat_id, array(
            'amount' => $amount,
            'quantity_sold' => $quantitySold,
            'comment_de' => $comment_de
        ));

        // Récupération du ticket pour retourner l'objet modifié
        $ticket = NightTicketcategorie::where('ticketcategorie_id', '=', $ticketCat_id)->where('night_id', '=', $night_id)->first();    
        return Jsend::success($ticket->toArray());
    }

    /**
     * Allows to remove a specific nightticketcategory from the database.
     * @param  int -  the id from the ticketcategorie (url)
     * @var  night_id (int) - the id from the night (get)
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if the required resource was not found.
     * @return Response Jsend::success if the nightticketcategorie was deleted.
     */
    public function destroy($ticketCat_id) {
        
        $night_id = Input::get('night_id');

        //Cast de platform_id et de event_id car l'url les envoit en String
        if (ctype_digit($ticketCat_id)) {
            $ticketCat_id = (int)$ticketCat_id;
        }
        if (ctype_digit($night_id)) {
            $night_id = (int)$night_id;
        }

        // Validation des types
        $validationNightTicketCat = NightTicketcategorie::validate(array(
            'night_id' => $night_id,
            'ticketcategorie_id' => $ticketCat_id,
        ));
        if ($validationNightTicketCat !== true) {
            return Jsend::fail($validationNightTicketCat);
        }

        // Validation de l'existance du ticket
        if (NightTicketcategorie::existTechId($ticketCat_id, $night_id) !== true) {
            return Jsend::error('ticket not found');
        }

        // Supression du ticket (table pivot).
        Night::find($night_id)->ticketcategories()->detach($ticketCat_id);
        return Jsend::success('Ticket deleted');
    }

}
