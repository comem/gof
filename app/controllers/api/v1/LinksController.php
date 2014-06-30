<?php

namespace api\v1;

use \Input;
use \Link;
use \BaseController;
use \Jsend;
use \Artist;

class LinksController extends BaseController {

    /**
     * Not implemented yet.
     */
    public function index() {
        /*
         * Priorité 1C
         * Correspond au READ all des fonctions CRUD
         */
    }

    /**
     * Allows to save a new link.
     * @var url (string) - the url (get)
     * @var name_de (string) - the name of the resource (get)
     * @var title_de (string) - the title of the resource (get)
     * @var artist_id (int) - the id from the artist (get)
     * 
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if a resource was not found.
     * @return Response Jsend::success if a new artist was created.
     */
    public function store() {
        $url = Input::get('url');
        $name_de = Input::get('name_de');
        $title_de = Input::get('title_de');
        $artist_id = Input::get('artist_id');

        //Cast de artist_id car l'url l'envoit en String
        if (ctype_digit($artist_id)) {
            $artist_id = (int) $artist_id;
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
     * Allows to display a specific link.
     * @param  int -  the id from the link (url)
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if a resource was not found.
     * @return Response Jsend::success if a new artist was created.
     */
    public function show($id) {
        // Les ids venant de l'url sont des "String", alors que celui-ci est un "int"
        // Par contre la conversion se fait que pour des chaines Ok.
        if (ctype_digit($id)) {
            $id = (int) $id;
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
     * Allows to modify a link.
     * @param int the id from the link (url)
     * @var url (string) - the url (get)
     * @var name_de (string) - the name of the resource (get)
     * @var title_de (string) - the title of the resource (get)
     * 
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if the resource to modify was not found.
     * @return Response Jsend::success if the artist was modified.
     */
    public function update($id) {
        // Les ids venant de l'url sont des "String", alors que celui-ci est un "int"
        // Par contre la conversion se fait que pour des chaines Ok.
        if (ctype_digit($id)) {
            $id = (int) $id;
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

        // Tout est OK, mise-à-jour du notre lien
        $link->url = $url;
        $link->name_de = $name_de;
        $link->title_de = $title_de;
        $link->save();
        return Jsend::success($link->toArray());
    }

    /** 
     * Not implemented yet.
     */
    public function destroy($id) {
        /*
         * Priorité 1C
         * Correspond au DELETE des fonctions CRUD
         */
    }

    
    public static function saveLink($url, $name_de, $title_de, $artist_id) {
        //Cast de artist_id car l'url l'envoit en String
        if (ctype_digit($artist_id)) {
            $artist_id = (int) $artist_id;
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
        return $link;
    }

}
