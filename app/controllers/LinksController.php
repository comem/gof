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
		// Vérification des droits d'accès (ACL)
			//A réaliser
        $url = Input::get('url');
        $name_de = Input::get('name_de');
        $title_de = Input::get('title_de');
        $artist_id = Input::get('artist_id');

        if (ctype_digit($artist_id)) {
            $artist_id = (int)$artist_id;
        }
        $validationLink = Link::validate(array(
            'url' => $url,
            'name_de' => $name_de,
            'title_de' => $title_de,
            'artist_id' => $artist_id,
        ));
        // Test avec l'unicité sur l'url???

        // Tout est ok, on sauve le lien avec l'id de l'artiste
        $link = new Link();
        $link->url = $url;
        $link->name_de = $name_de;
        $link->title_de = $title_de;
        $link->artist_id = $artist_id;
        $link->save();
        return Jsend::success();

        // Et on retourne l'id du lien nouvellement créé (encapsulé en JSEND)
        return Jsend::success(array('link' => $link->id));	// Pourquoi ne rend pas l'id nouvellement créé?
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

        // Vérification de l'existence du lien
        $link = Link::find($id);
        if (!isset($link)) {
            return Jsend::error('link not found');
        }

        // Retourne le lien encapsulé en JSEND si tout est OK
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
        $artist_id = Input::get('artist_id');

        if (ctype_digit($artist_id)) {
            $artist_id = (int)$artist_id;
        }

        $validationLink = Link::validate(array(
            'url' => $url,
            'name_de' => $name_de,
            'title_de' => $title_de,
            'artist_id' => $artist_id,
            'id' => $id
        ));

        if ($validationLink !== true) {
            return Jsend::fail($validationLink);
        }

        //Vérification du contenu ???

        // Vérification de l'existence du lien
        $link = Link::find($id);
        if (!isset($link)) {
            return Jsend::error('link not found');
        }
        // Vérification de l'existence de l'artist
        $artist = Artist::find($artist_id);
        if (!isset($artist)) {
            return Jsend::error('artist not found');
        }
        // Tout est OK, on mets à jour notre lien
        $link->url = $url;
        $link->name_de = $name_de;
        $link->title_de = $title_de;
        $link->artist_id = $artist_id;
        $link->save();
        return Jsend::success();
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
