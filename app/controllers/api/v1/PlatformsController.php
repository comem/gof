<?php

namespace api\v1;

use \Jsend;
use \Platform;
use \BaseController;

/**
 * REST controller with index and show methods implemented.
 * 
 * Corresponds to the "platforms" class of the class diagram.
 *
 * @category  Application services
 * @version   1.0
 * @author    gof
 */
class PlatformsController extends BaseController {

    /**
     * Allows to display every platforms from the database.
     * @return Response Jsend::success with all platforms.
     */
    public function index() {
        // Retourne toutes les plateformes
        return Jsend::success(Platform::all()->toArray());
    }

    /**
     * @ignore
     * Not implemented yet.
     */
    public function store() {
        /*
         * En dur dans la base de donnée (1D)
         * Correspond au CREATE des fonctions CRUD
         */
    }

    /**
     * Allows to display a specific platform from the database.
     * @param  int -  the id from the platform (url)
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if the required resource was not found.
     * @return Response Jsend::success if the required platform was found.
     */
    public function show($id) {
        // Les ids venant de l'url sont des "String", alors que celui-ci est un "int"
        // Par contre la conversion se fait que pour des chaines Ok.
        if (ctype_digit($id)) {
            $id = (int) $id;
        }

        //Validation des types
        $validationPlatform = Platform::validate(array('id' => $id));
        if ($validationPlatform !== true) {
            return Jsend::fail($validationPlatform);
        }

        // Validation de l'existance de la plateforme
        if (Platform::existTechId($id) !== true) {
            return Jsend::fail($id);
        }

        // Récupération de la plateforme
        $platform = Platform::find($id);

        // Retourne la plateforme encapsulée en JSEND si tout est OK
        return Jsend::success($platform->toArray());
    }

    /**
     * @ignore
     * Update the specified resource in storage.
     * Priorité 1C
     * @param  int  $id
     * @return Rien (fonction non réalisée pour le moment)
     */
    public function update($id) {
        /**
         * Priorité 1C
         * Correspond au UPDATE des fonctions CRUD
         */
    }

    /**
     * @ignore
     * Remove the specified resource from storage.
     * Priorité 1C
     * @param  int  $id
     * @return Rien (fonction non réalisée pour le moment)
     */
    public function destroy($id) {
        /*
         * Priorité 1C
         * Correspond au DELETE des fonctions CRUD
         */
    }

}
