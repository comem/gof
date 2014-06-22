<?php

class TicketcategoriesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * @return Response
	 */
	public function index()
	{
		// Vérification des droits d'accès (ACL)
			//A réaliser

        // Retourne toutes les catégories de ticket
        return  Jsend::success(Ticketcategorie::all()->toArray());
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		/** 
		* En dur dans la base de donnée (1D)
		* Correspond au CREATE des fonctions CRUD
		*/
	}


	/**
	 * Display the specified resource.
	 * @param  int  $id correspondant à l'id technique de la cathégorie de ticket à voir
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

        //Validation des types
        $validationTicketCategorie = Ticketcategorie::validate(array('id' => $id));
        if ($validationTicketCategorie !== true) {
            return Jsend::fail($validationTicketCategorie);
        }

        // Validation de l'existance de la plateforme
        if (Ticketcategorie::existTechId($id) !== true) {
            return Jsend::fail($id);
        }

        // Récupération de la plateforme
        $ticketcategorie = Ticketategorie::find($id);

        // Retourne la plateforme encapsulée en JSEND si tout est OK
        return Jsend::success($ticketcategorie->toArray());
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		/** 
		* Priorité 1C
		* Correspond au UPDATE des fonctions CRUD
		*/
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		/** 
		* Priorité 1C
		* Correspond au DELETE des fonctions CRUD
		*/
	}


}
