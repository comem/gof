<?php

class NightPlatformController extends \BaseController {

	//Cette classe correspond à la table "publications" du diagrame de class.

	/**
	 * Display a listing of the resource.
	 * @return Tous les événements
	 */
	public function index()
	{
        // Retourne toutes les publication
        return  Jsend::success(NightPlatform::all()->toArray());
	}


	/**
	 * Store a newly created resource in storage.
	 * @var platform_id a récupérer comme contenu en get. Correspond à l'id de la plateforme.
     * @var night_id a récupérer comme contenu en get. Correspond à l'id de l'événement.
     * @var external_id a récupérer comme contenu en get. Correspond à l'id externe de la plateforme.
     * @var external_infos a récupérer comme contenu en get. Correspond aux autres infos externes de la plateforme.
     * @var url a récupérer comme contenu en get. Correspond à l'url de la plateforme.  
     * @return Un message d'erreur si les données entrées ne correspondent pas aux données demandées.
     * @return Un message d'erreur si l'événement n'existe pas.
     * @return Un message d'erreur si la plateforme n'existe pas.
     * @return Un message d'erreur si la publication existe déjà.
     * @return Sinon, un message de validation d'enregistrement contenant l'id du lien créé.
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
        $performers = Night::find($night_id)->artists;
        foreach ($performers as $performer) {
            $p = $performer->pivot->is_support;
            printf($p);
        }
        dd($p);
        //return Jsend::success($performers);

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
