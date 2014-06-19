<?php

class PlatformsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Vérification des droits d'accès (ACL)
			//A réaliser

        // Retourne toutes les plateformes
        return  Jsend::success(Platform::all()->toArray());
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
        $validationPlatform = Platform::validate(array('id' => $id));
        if ($validationPlatform !== true) {
            return Jsend::fail($validationPlatform);
        }

        // Vérification de l'existence de la plateforme
        $platform = Platform::find($id);
        if (!isset($platform)) {
            return Jsend::error('platform not found');
        }

        // Retourne la plateforme encapsulée en JSEND si tout est OK
        return Jsend::success($platform->toArray());
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
