<?php

namespace api\v1;

use \Jsend;
use \Input;
use \Request;
use \Night;
use \Platform;
use \NightPlatform;
use \BaseController;

/**
 * REST controller with index, store, show, update and destroy methods implemented.
 * 
 * Corresponds to the "publications" class of the class diagram.
 *
 * @category  Services applicatifs
 * @version   1.0
 * @author    gof
 */
class NightPlatformController extends BaseController {
    //Cette classe correspond à la table "publications" du diagrame de class.

    /**
     * Allows to display every publications from the database
     * @return Response Jsend::success with all publications.
     */
    public function index() {
        // Retourne toutes les publication
        return Jsend::success(NightPlatform::all()->toArray());
    }

    /**
     * 
     * Allows to save a new publication.
     * @var platform_id (int) - the id from the platform (get)
     * @var night_id (int) - the id from the night (get)
     * @var external_id (string) - the external id for the platform (get)
     * @var external_infos (text) - the external infos for the platform (get)
     * @var url (string) - the url from the platform (get)
     * 
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if a resource was not found.
     * @return Response Jsend::success if a new artist was created.
     */
    public function store() {

        $platform_id = Input::get('platform_id');
        $night_id = Input::get('night_id');
        $external_id = Input::get('external_id');
        $external_infos = Input::get('external_infos');
        $url = Input::get('url');


        $nightPlatform = static::saveNightPlatform($platform_id, $night_id, $external_id, $external_infos, $url);
        if (!is_a($nightPlatform, 'NightPlatform')) {
            return $nightPlatform;
        }

        // Et on retourne l'id de la publication nouvellement créée (encapsulé en JSEND)
        return Jsend::success(array(
                    'platform_id' => $nightplatform->platform_id,
                    'night_id' => $nightplatform->night_id,
        ));
    }

    /**
     * @ignore
     * Allows to save a new publication.
     * @param int $platform_id - the id from the platform
     * @param int $night_id - the id from the night
     * @param string $external_id - the external id for the platform
     * @param text $external_infos - the external infos for the platform
     * @param string $url - the url from the platform (get)
     * @return NightPlatform - the created publication
     */
    public static function saveNightPlatform($platform_id, $night_id, $external_id, $external_infos, $url) {
        //Cast de platform_id et de event_id car l'url les envoit en String
        if (ctype_digit($platform_id)) {
            $platform_id = (int) $platform_id;
        }
        if (ctype_digit($night_id)) {
            $night_id = (int) $night_id;
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
        if ($constraintValid == false) {
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
        return $nightplatform;
    }

    /**
     * Allows to display a specific publication.
     * @param  int the id from the link (url)
     * @var night_id (int) - the id from the night (header)
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if a resource was not found.
     * @return Response Jsend::success if a new artist was created.
     */
    public function show($platform_id) {
        // Récupération par le header
        $night_id = Request::header('night_id');

        //Cast de platform_id et de event_id car l'url les envoit en String
        if (ctype_digit($platform_id)) {
            $platform_id = (int) $platform_id;
        }
        if (ctype_digit($night_id)) {
            $night_id = (int) $night_id;
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
     * 
     * Allows to modify a publication.
     * @param int the id from the platform (url)
     * @var night_id (int) - the id from the night (get)
     * @var external_id (string) - the external id for the platform (get)
     * @var external_infos (text) - the external infos for the platform (get)
     * @var url (string) - the url from the platform (get)
     * 
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if a resource was not found.
     * @return Response Jsend::success if a publication was modified.
     * 
     * 
     * 
     */
    public function update($platform_id) {

        $night_id = Input::get('night_id');
        $external_id = Input::get('external_id');
        $external_infos = Input::get('external_infos');
        $url = Input::get('url');

        //Cast de platform_id et de night_id car l'url les envoit en String
        if (ctype_digit($platform_id)) {
            $platform_id = (int) $platform_id;
        }
        if (ctype_digit($night_id)) {
            $night_id = (int) $night_id;
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
     * 
     * Allows to delete a publication.
     * @param int the id from the platform (url)
     * @var night_id (int) - the id from the night (get)S
     * 
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if a resource was not found.
     * @return Response Jsend::success if a publication was deleted.
     * 
     * 
     * 
     */
    public function destroy($platform_id) {
        $night_id = Input::get('night_id');

        //Cast de platform_id et de event_id car l'url les envoit en String
        if (ctype_digit($platform_id)) {
            $platform_id = (int) $platform_id;
        }
        if (ctype_digit($night_id)) {
            $night_id = (int) $night_id;
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
