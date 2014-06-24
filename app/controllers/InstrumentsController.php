<?php

class InstrumentsController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response : retourne tout les instruments de la table
     */
    public function index() {

        return Jsend::success(Instrument::all()->toArray());
    }

    /**
     * @var name_de(string): name de l'instrument , id metier 
     * @return Jsend::fail Un message d'erreur si les données entrées ne correspondent pas aux données demandées.
     * @return Jsend::error Un message d'erreur si l'instrument existe déjà dans la base de données.
     * @return Jsend::success Sinon, un message de validation d'enregistrement contenant les informations des données enregistrée.
     */
    public function store() {
        // Auth

        $name_de = Input::get('name_de');


        if (Instrument::existBuisnessId($name_de) == true) {

            return Jsend::error("instrument already exists in the database");
        }

        $validationInstrum = Instrument::validate(array('name_de' => $name_de));

        if ($validationInstrum !== true) {
            return Jsend::fail($validationInstrum);
        }

        $newinstrument = new Instrument();
        $newinstrument->name_de = $name_de;
        $newinstrument->save();
        return Jsend::success(array('name_de' => $newinstrument->name_de));
    }

    /**
     * Display the specified resource.
     *
     * @var $id : identifiant technique de l'instrument 
     * @return Jsend::fail Un message d'erreur si les données entrées ne correspondent pas aux données demandées.
     * @return Jsend::error Un message d'erreur si l'instrument n'existe pas dans la base de données.
     * @return Jsend::success Sinon, un message de validation  contenant les informations des données demandée.
     */
    public function show($instrument_id) {
        // Auth
        if (ctype_digit($instrument_id)) {
            $instrument_id = (int) $instrument_id;
        }

        if (Instrument::existTechId($instrument_id) !== true) {
            return Jsend::error("instrument dosen't exists in the database");
        }

        $instrument = Instrument::find($instrument_id);

        if (!isset($instrument)) {
            return Jsend::error('resource not found');
        }
        // Retourne le message encapsulé en JSEND si tout est OK
        return Jsend::success($instrument->toArray());
    }

    /**
     * @var $id : identifiant technique de l'instrument 
     * @return Jsend::fail Un message d'erreur si les données entrées ne correspondent pas aux données demandées.
     * @return Jsend::error Un message d'erreur si l'instrument n'existe pas dans la base de données.
     * @return Jsend::success Sinon, un message de validation d'enregistrement contenant les informations à jour.
     */
    public function update($id) {
    

        if (ctype_digit($id)) {
            $id = (int) $id;
        }

        $inst = Input::get('name_de');

        $validationInst = Instrument::validate(array(
                    'name_de' => $inst,
                    'id' => $id
        ));
        
        if ($validationInst !== true) {
            return Jsend::fail($validationMsg);
        }

        $instrument = Instrument::find($id);
        if (!isset($instrument)) {
            return Jsend::error('resource not found');
        }
        // Tout est OK, on mets à jour notre message
        $instrument->message = $inst;
        $instrument->save();
        return Jsend::success($instrument->toArray());
    }

    /**
     * Remove the specified resource from storage.
     * @var $id : identifiant technique de l'instrument à supprimer
     * @return Jsend::fail Un message d'erreur si les données entrées ne correspondent pas aux données demandées.
     * @return Jsend::error Un message d'erreur si l'instrument n'existe pas dans la base de données.
     * @return Jsend::success Sinon, un message de validation de suppression.
     */
    public function destroy($id) {
        //auth
        if (ctype_digit($id)) {
            $id = (int) $id;
        }
        $validationInst = Instrument::validate(array(
                    'name_de' => $inst,
                    'id' => $id
        ));


        if ($validationInst !== true) {
            return Jsend::fail($validationMsg);
        }

        $instrument = Instrument::find($id);
        if (!isset($instrument)) {
            return Jsend::error('resource not found');
        }


        $instrument->delete();

        return Jsend::success();
    }

}
