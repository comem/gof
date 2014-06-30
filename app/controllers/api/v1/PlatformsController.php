<?php

namespace api\v1;

use \Jsend;
use \Platform;
use \BaseController;

class PlatformsController extends BaseController {

    /**
     * Display a listing of the resource.
     * @return Jsend::success Toutes les plateformes
     */
    public function index() {
        // Retourne toutes les plateformes
        return Jsend::success(Platform::all()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     * En dur dans la base de donnée (1D)
     * @return Rien (fonction non réalisée pour le moment)
     */
    public function store() {
        /**
         * En dur dans la base de donnée (1D)
         * Correspond au CREATE des fonctions CRUD
         */
    }

    /**
     * Display the specified resource.
     * @param  int  $id correspondant à l'id technique de la plateforme à voir
     * @return Jsend::fail Un message d'erreur si les données entrées ne correspondent pas aux données demandées.
     * @return Jsend::fail Un message d'erreur si l'id technique est déjà en mémoire.
     * @return Jsend::success Sinon, un message de validation d'enregistrement contenant la plateforme correspondant à l'id technique.
     */
    public function show($id) {
        // Vérification des droits d'accès (ACL)
        //A réaliser
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
     * Remove the specified resource from storage.
     * Priorité 1C
     * @param  int  $id
     * @return Rien (fonction non réalisée pour le moment)
     */
    public function destroy($id) {
        /**
         * Priorité 1C
         * Correspond au DELETE des fonctions CRUD
         */
    }

}
