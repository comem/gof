<?php

namespace api\v1;

use \Jsend;
use \Input;
use \Night;
use \Platform;
use \NightPlatform;
use \BaseController;

class NightPlatformController extends BaseController {

	//Cette classe correspond à la table "publications" du diagrame de class.

	/**
	 * Display a listing of the resource.
	 * @return Jsend::success Toutes les publications.
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
     * @var external_id a récupérer comme contenu en get. Correspond à l'id externe de la publication.
     * @var external_infos a récupérer comme contenu en get. Correspond aux autres infos externes de la publication.
     * @var url a récupérer comme contenu en get. Correspond à l'url de la publication.  
     * @return Jsend::fail Un message d'erreur si les données entrées ne correspondent pas aux données demandées.
     * @return Jsend::error Un message d'erreur si l'événement n'existe pas.
     * @return Jsend::error Un message d'erreur s'il n'y a pas d'artiste nommé comme principal pour l'événement.
     * @return Jsend::error Un message d'erreur si l'événement de comprend pas d'image qui le symbolise.
     * @return Jsend::error Un message d'erreur si la plateforme n'existe pas.
     * @return Jsend::error Un message d'erreur si la publication existe déjà.
     * @return Jsend::success Sinon, un message de validation d'enregistrement contenant l'id hybride de la publication.
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
        // Si un événement est publié, il doit y avoir au moin un artiste qui est nommé comme principal 
        // pour cet événement. C'est-à-dire min 1 "is_support" à 0.
        $performers = Night::find($night_id)->artistNights;
        $constraintValid = false;
        foreach ($performers as $performer) {
            $is_support = $performer->is_support;
            if ($is_support == false) {
                $constraintValid = true;
            }
        }
        if ($constraintValid == false){
            return Jsend::error('There are no principal artist for this event. It is necessary to appoint a principal artist for each event.');   
        }

        // Contrainte C5
        // Si un événement est publié, il doit être symbolisé par une image.
        if (Night::find($night_id)->image_id == null) {
            return Jsend::error('The event has no image that symbolizes.');
        }

        // Validation de l'existance de la plateforme
        if (Platform::existTechId($platform_id) !== true) {
            return Jsend::error('platform not found');
        }

        // Validation de l'inexistance de la publication
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

        // Et on retourne l'id de la publication nouvellement créée (encapsulé en JSEND)
        return Jsend::success(array(
            'platform_id' => $nightplatform->platform_id,
            'night_id' => $nightplatform->night_id,
        ));
	}


	/**
	 * Display the specified resource.
	 * @param  int  $platform_id correspondant à l'id technique de la plateforme.
     * @var night_id a récupérer comme contenu en get dans le header. Correspond à l'id de l'événement.
     * @return Jsend::fail Un message d'erreur si les données entrées ne correspondent pas aux données demandées.
     * @return Jsend::fail Un message d'erreur si l'id hybride est déjà en mémoire.
     * @return Jsend::success Sinon, un message de validation d'enregistrement contenant la publication correspondant à l'id hybride.
	 */
	public function show($platform_id)
	{
        // Récupération par le header
        $night_id = Request::header('night_id');

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
        ));
        if ($validationNightPlatform !== true) {
            return Jsend::fail($validationNightPlatform);
        }

        // Validation de l'existance de la publication
        if (NightPlatform::existTechId($night_id, $platform_id) !== true) {
            return Jsend::error('publication not found');
        }

        // Récupération de la publication 
        $publication = NightPlatform::where('platform_id', '=', $platform_id)->where('night_id', '=', $night_id)->first();
        
        // Retourne la publication encapsulée en JSEND si tout est OK
        return Jsend::success($publication->toArray());
	}


	/**
	 * Update the specified resource in storage.
	 * @param  int  $id correspondant à l'id technique de la plateforme (formant l'id hybride de la publication).
     * @var night_id a récupérer comme contenu en get. Correspond à l'id technique de l'événement (formant l'id hybride de la publication).
     * @var external_id a récupérer comme contenu en get. Correspond l'id externe de la publication.
     * @var external_indos a récupérer comme contenu en get. Correspond aux informations externes de la publication.
     * @var url a récupérer comme contenu en get. Correspond à l'url de la publication.
     * @return Jsend::fail Un message d'erreur si les données entrées ne correspondent pas aux données demandées.
     * @return Jsend::error Un message d'erreur si l'événement lié à la modification n'existe pas.
     * @return Jsend::error Un message d'erreur si la plateforme liée à la modification n'existe pas.
     * @return Jsend::error Un message d'erreur si la publication à modifier n'existe pas.
     * @return Jsend::success Sinon, un message de validation de modification contenant la publication correspondante à l'id hybride.
	 */
	public function update($platform_id)
	{

        $night_id = Input::get('night_id');
        $external_id = Input::get('external_id');
        $external_infos = Input::get('external_infos');
        $url = Input::get('url');

        //Cast de platform_id et de night_id car l'url les envoit en String
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

        // Validation de l'existance de la plateforme
        if (Platform::existTechId($platform_id) !== true) {
            return Jsend::error('platform not found');
        }

        // Validation de l'existance de la publication
        if (NightPlatform::existTechId($night_id, $platform_id) !== true) {
            return Jsend::error('publication not found');
        }

        //Modification de la publication (table pivot).
        Night::find($night_id)->platforms()->updateExistingPivot($platform_id, array(
            'external_id' => $external_id,
            'external_infos' => $external_infos,
            'url' => $url
        ));

        // Récupération de la publication pour retourner l'objet modifié
        $publication = NightPlatform::where('platform_id', '=', $platform_id)->where('night_id', '=', $night_id)->first();    
        return Jsend::success($publication->toArray());
	}


	/**
	 * Remove the specified resource from storage.
	 * @param  int  $platform_id correspondant à l'id technique de la plateforme.
     * @var night_id a récupérer comme contenu en get dans le header. Correspond à l'id de l'événement.
     * @return Jsend::fail Un message d'erreur si les données entrées ne correspondent pas aux données demandées.
     * @return Jsend::error Un message d'erreur si la publication n'est pas existante
     * @return Jsend::success Sinon, un message de validation de supression de la publication.
	 */
	public function destroy($platform_id)
	{
        $night_id = Input::get('night_id');

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
        ));
        if ($validationNightPlatform !== true) {
            return Jsend::fail($validationNightPlatform);
        }

        // Validation de l'existance de la publication
        if (NightPlatform::existTechId($night_id, $platform_id) !== true) {
            return Jsend::error('publication not found');
        }

        // Supression de la publication (table pivot).
        Night::find($night_id)->platforms()->detach($platform_id);
        return Jsend::success('Publication deleted');
	}


}
