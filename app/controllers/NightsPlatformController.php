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
        $night_id = Input::get('night_id');
        $external_id = Input::get('external_id');
        $external_infos = Input::get('external_infos');
        $url = Input::get('url');

        //Cast de platform_id et de event_id car l'url les envoit en String
        if (ctype_digit($platform_id)) {
            $platform_id = (int)$platform_id;
        }
        if (ctype_digit($night_id)) {
            $night_id = (int)$night_id;
        }

        // Validation des types
        $validationNightPlatform = NightPlatform::validate(array(
            'platform_id' => $platform_id,
            'night_id' => $night_id,
            'external_id' => $external_id,
            'external_infos' => $external_infos,
            'url' => $url,
        ));
        if ($validationNightPlatform !== true) {
            return Jsend::fail($validationNightPlatform);
        }

        // Validation de l'existance de l'événement
        if (Night::existTechId($night_id) !== true) {
            return Jsend::error('night not found');
        }

        // Contrainte C4
        // Lorsqu'un événement est crée, il doit y avoir au moin un arrist qui est le principal 
        // de cet événement. C'est-à-dire min 1 is_support à false
        // $nightC4 = Night::find($night_id);
        // $performers = $nightC4->artists();
        // dd($performers);

        // C5

        // Validation de l'existance de la plateforme
        if (Night::existTechId($platform_id) !== true) {
            return Jsend::error('platform not found');
        }

        // Validation de l'inexistance de la xpublication
        if (NightPlatform::existTechId($night_id, $platform_id) == true) {
            return Jsend::error('publication already exists in the database');
        }

        // Tout est ok, on sauve la publication avec les ids de l'événement et de la plateforme
        $nightplatform = new NightPlatform();
        $nightplatform->platform_id = $platform_id;
        $nightplatform->night_id = $night_id;
        $nightplatform->external_id = $external_id;
        $nightplatform->external_infos = $external_infos;
        $nightplatform->url = $url;
        $nightplatform->save();

        // Et on retourne l'id du lien nouvellement créé (encapsulé en JSEND)
        return Jsend::success(array('id' => $nightplatform->id));
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
