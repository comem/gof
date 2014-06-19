<?php

class TicketCategoriesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Vérification des droits d'accès (ACL)
			//A réaliser

        // Retourne toutes les catégories de ticket
        return  Jsend::success(TicketCategorie::all()->toArray());
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// Vérification des droits d'accès (ACL)
			//A réaliser

        // Les ids venant de l'url sont des "String", alors que celui-ci est un "int"
		// Par contre la conversion se fait que pour des chaines Ok.
        if (ctype_digit($id)) {
            $id = (int)$id;
        }

        //Validation des attributs 
        $validationTicketCategorie = TicketCategorie::validate(array('id' => $id));
        if ($validationTicketCategorie !== true) {
            return Jsend::fail($validationTicketCategorie);
        }

        // Vérification de l'existence de la plateforme
        $ticketcategory = TicketCategorie::find($id);
        if (!isset($ticketcategory)) {
            return Jsend::error('ticket category not found');
        }

        // Retourne la plateforme encapsulée en JSEND si tout est OK
        return Jsend::success($ticketcategory->toArray());
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
