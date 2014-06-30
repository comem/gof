<?php

namespace api\v1;

use \Jsend;
use \Ticketcategorie;
use \BaseController;

/**
 * REST controller with index and show methods implemented
 *
 * @category  Application services
 * @version   1.0
 * @author    gof
 */
class TicketcategoriesController extends BaseController {

    /**
     * Display a listing of the resource.
     * @return Jsend::success Toutes les catégories de tickets
     */
    public function index() {

// Retourne toutes les catégories de ticket

        return Jsend::success(Ticketcategorie::all()->toArray());
    }

    /**
     * @ignore
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
     * @param  int  $id correspondant à l'id technique de la cathégorie de ticket à voir
     * @return Jsend::fail Un message d'erreur si les données entrées ne correspondent pas aux données demandées.
     * @return Jsend::fail Un message d'erreur si l'id technique est déjà en mémoire.
     * @return Jsend::success Sinon, un message de validation d'enregistrement contenant la catégorie de ticket correspondant à l'id technique.
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
        $validationTicketCategorie = Ticketcategorie::validate(array('id' => $id));
        if ($validationTicketCategorie !== true) {
            return Jsend::fail($validationTicketCategorie);
        }

// Validation de l'existance de la plateforme
        if (Ticketcategorie::existTechId($id) !== true) {
            return Jsend::fail($id);
        }

// Récupération de la plateforme
        $ticketcategorie = Ticketategorie::find($id);

// Retourne la plateforme encapsulée en JSEND si tout est OK
        return Jsend::success($ticketcategorie->toArray());
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
        /**
         * Priorité 1C
         * Correspond au DELETE des fonctions CRUD
         */
    }

}
