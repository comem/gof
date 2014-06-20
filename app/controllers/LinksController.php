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

        // Retourne tous les liens
       
	}


	/**
	 * Store a newly created resource in storage.
	 * @return Response
	 */
	public function store()
	{
		// Vérification des droits d'accès (ACL)
			//A réaliser
        $url = Input::get('url');
        $name_de = Input::get('name_de');
        $title_de = Input::get('title_de');
        $artist_id = Input::get('artist_id');

        //Cast de artist_id car l'url l'envoit en String
        if (ctype_digit($artist_id)) {
            $artist_id = (int)$artist_id;
        }

        // Validation des types
        $validationLink = Link::validate(array(
            'url' => $url,
            'name_de' => $name_de,
            'title_de' => $title_de,
            'artist_id' => $artist_id,
        ));
        if ($validationLink !== true) {
            return Jsend::fail($validationLink);
        }

        // Validation de l'existance de l'artiste
        if (Artist::existTechId($artist_id) !== true) {
            return Jsend::error('artist not found');
        }

        // Validation de l'inexistance du lien
        if (Link::existBusinessId($url) == true) {
            return Jsend::error('link already exists in the database');
        }

        // Tout est ok, on sauve le lien avec l'id de l'artiste
        $link = new Link();
        $link->url = $url;
        $link->name_de = $name_de;
        $link->title_de = $title_de;
        $link->artist_id = $artist_id;
        $link->save();

        // Et on retourne l'id du lien nouvellement créé (encapsulé en JSEND)
        return Jsend::success(array('id' => $link->id));	
	}


	/**
	 * Display the specified resource.
	 * @param  int  $id correspondant à l'id technique du lien à voir.
	 * @return Response
	 */
	public function show($id)
	{
        // Les ids venant de l'url sont des "String", alors que celui-ci est un "int"
		// Par contre la conversion se fait que pour des chaines Ok.
        if (ctype_digit($id)) {
            $id = (int)$id;
        }

        // Validation des types
        $validationLink = Link::validate(array('id' => $id));
        if ($validationLink !== true) {
            return Jsend::fail($validationLink);
        }

        // Validation de l'existance de lu lien
        if (Link::existTechId($id) !== true) {
            return Jsend::fail($id);
        }

        // Récupération du lien 
        $link = Link::find($id);

        // Retourne le lien encapsulé en JSEND si tout est OK
        return Jsend::success($link->toArray());
	}


	/**
	 * Update the specified resource in storage.
	 * @param  int  $id correspondant à l'id technique du lien à modifier
	 * @return Response
	 */
	public function update($id)
	{
		// Vérification des droits d'accès (ACL)
			//A réaliser

        // Les ids venant de l'url sont des "String", alors que celui-ci est un "int"
		// Par contre la conversion se fait que pour des chaines Ok.
        if (ctype_digit($id)) {
            $id = (int)$id;
        }

        // Validation des données et retour des liens en JSEND
        $url = Input::get('url');
        $name_de = Input::get('name_de');
        $title_de = Input::get('title_de');

        // Validation des types du lien
        $validationLink = Link::validate(array(
            'url' => $url,
            'name_de' => $name_de,
            'title_de' => $title_de
        ));
        if ($validationLink !== true) {
            return Jsend::fail($validationLink);
        }

        // Validation de l'existance du lien à modifier
        if (Link::existTechId($id) !== true) {
            return Jsend::error('link not found');
        }

        // Récupération du lien existant
        $link = Link::find($id);

        // Validation de l'inexistance du lien uploadé
        if (Link::existBusinessId($url) == true) {
            return Jsend::error('link already exists in the database');
        }

        // Tout est OK, on mets à jour notre lien
        $link->url = $url;
        $link->name_de = $name_de;
        $link->title_de = $title_de;
        $link->save();
        return Jsend::success($link->toArray());
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
