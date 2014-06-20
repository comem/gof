<?php

class NightsPlatformController extends \BaseController {

	//Cette classe correspond à la table "publications" du diagrame de class.

	/**
	 * Display a listing of the resource.
	 * @return Response
	 */
	public function index()
	{
        // Retourne toutes les publication
        return  Jsend::success(NightPlatform::all()->toArray());
	}


	/**
	 * Store a newly created resource in storage.
	 * @return Response
	 */
	public function store()
	{

        $platform_id = Input::get('platform_id');
        $event_id = Input::get('event_id');
        $external_id = Input::get('external_id');
        $external_infos = Input::get('external_infos');
        $url = Input::get('url');

        //Cast de platform_id et de event_id car l'url les envoit en String
        if (ctype_digit($platform_id)) {
            $platform_id = (int)$platform_id;
        }
        if (ctype_digit($event_id)) {
            $event_id = (int)$event_id;
        }

        // Validation des types
        $validationNightPlatform = Link::validate(array(
            'platform_id' => $platform_id,
            'event_id' => $event_id,
            'external_id' => $external_id,
            'external_infos' => $external_infos,
            'url' => $url,
        ));
        if ($validationNightPlatform !== true) {
            return Jsend::fail($validationNightPlatform);
        }

        // Validation de l'existance de l'artiste
        if (Artist::existTechId($artist_id) !== true) {
            return Jsend::error('artist already exists in the database');
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
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
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
