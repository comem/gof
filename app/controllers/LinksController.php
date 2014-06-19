<?php

class LinksController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		/** 
		* Priorité 1C
		* Correspond au READ all des fonctions CRUD
		*/

		// Vérification des droits d'accès (ACL)
			// A réaliser

        // Retour de tous les messages
        //return  Jsend::success(Link::all()->toArray());
        dd("test");
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
        $validationLink = Link::validate(array('id' => $id));
        if ($validationLink !== true) {
            return Jsend::fail($validationLink);
        }

        // Vérification de l'existence du message
        $link = Link::find($id);
        if (!isset($link)) {
            return Jsend::error('link not found');
        }

        // Retourne le message encapsulé en JSEND si tout est OK
        return Jsend::success($link->toArray());
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
