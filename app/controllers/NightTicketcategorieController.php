<?php

class NightTicketcategorieController extends \BaseController {

    /**
     * Display a listing of the resource.
     * @return Jsend::success Toutes les catégories de tickets
     */
    public function index() {
        // Retourne toutes les publication
        return Jsend::success(NightTicketcategorie::all()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     * @var ticketCat_id a récupérer comme contenu en get. Correspond à l'id de la catégorie de ticket.
     * @var night_id a récupérer comme contenu en get. Correspond à l'id de l'événement.
     * @var amount a récupérer comme contenu en get. Correspond au prix du ticket.
     * @var quantitySold a récupérer comme contenu en get. Correspond au nombre de ticket vendu.
     * @var comment a récupérer comme contenu en get. Correspond à un commentaire sur ce ticket. 
     * @return Jsend::fail Un message d'erreur si les données entrées ne correspondent pas aux données demandées.
     * @return Jsend::error Un message d'erreur si la catégorie de ticket n'existe pas.
     * @return Jsend::error Un message d'erreur si l'événement n'existe pas.
     * @return Jsend::error Un message d'erreur si le ticket existe déjà.
     * @return Jsend::success Sinon, un message de validation d'enregistrement contenant l'id hybride du ticket.
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
        if (!TicketCategorie::existTechId($ticketCat_id)) {
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
     * Display the specified resource.
     * @param  int $ticketCat_id correspondant à l'id technique de la catégorie de ticket.
     * @var night_id a récupérer dans le header. Correspond à l'id de l'événement.
     * @return Jsend::fail Un message d'erreur si les données entrées ne correspondent pas aux données demandées.
     * @return Jsend::error Un message d'erreur si l'id hybride est déjà en mémoire.
     * @return Jsend::success Sinon, un message de validation d'enregistrement contenant le ticket correspondant à l'id hybride.
     */

    public function show($ticketCat_id) {

        // Récupération par le header
        $night_id = Request::header('night_id');

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
     * Update the specified resource in storage.
     * @param  int $ticketCat_id correspondant à l'id technique de la catégorie de ticket (formant l'id hybride de la publication).
     * @var night_id a récupérer comme contenu en get. Correspond à l'id de l'événement.
     * @var amount a récupérer comme contenu en get. Correspond au prix du ticket.
     * @var quantitySold a récupérer comme contenu en get. Correspond au nombre de ticket vendu.
     * @var comment a récupérer comme contenu en get. Correspond à un commentaire sur ce ticket. 
     * @return Jsend::fail Un message d'erreur si les données entrées ne correspondent pas aux données demandées.
     * @return Jsend::error Un message d'erreur si l'événement lié à la modification n'existe pas.
     * @return Jsend::error Un message d'erreur si la catégorie de ticket liée à la modification n'existe pas.
     * @return Jsend::error Un message d'erreur si le ticket à modifier n'existe pas.
     * @return Jsend::success Sinon, un message de validation de modification contenant le ticket correspondante à l'id hybride.
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
        if (TicketCategorie::existTechId($ticketCat_id) !== true) {
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
     * Remove the specified resource from storage.
     * @param  int $ticketCat_id correspondant à l'id technique de la catégorie de ticket.
     * @var night_id a récupérer comme contenu en get. Correspond à l'id de l'événement.
     * @return Jsend::fail Un message d'erreur si les données entrées ne correspondent pas aux données demandées.
     * @return Jsend::error Un message d'erreur si le ticket n'est pas existant.
     * @return Jsend::success Sinon, un message de validation de supression du ticket.
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
