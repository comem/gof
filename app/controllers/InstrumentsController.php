<?php

class InstrumentsController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response retourn tout les instruments de la table
     */
    public function index() {
        // Auth


        return Jsend::success(Instrument::all()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response Message de succes
     */
    public function store() {
        // Auth



        $instrument = Input::get('name_de');


        if (Instrument::existBuisnessId($instrument) == true) {

            return Jsend::error("Cette instrument est déjà enregistré");
        }

        $validationInstrum = Instrument::validate(array('instrument' => $instrument));

        if ($validationInstrum !== true) {
            return Jsend::error("Les données ne sont pas valide");
        }



        $newinstrument = new Instrument();
        $newinstrument->name_de = $instrument;
        $newinstrument->save();
        return Jsend::success(array('name_de' => $newinstrument->name_de));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id id de l'instrument
     * @return Response l'instrument correspondant à l'id
     */
    public function show($id) {
        // Auth
        if (ctype_digit($id)) {
            $id = (int) $id;
        }

        if (Instrument::existTechId($id) !== true) {
            return Jsend::error("L'instrument n'existe pas");
        }


//        $validationInst = Instrument::validate(array('id' => $id));
//
//        if ($validationInst !== true) {
//            return Jsend::fail($validationInst);
//        }

        // Vérification de l'existence de l'instrument
        $instrument = Instrument::find($id);
        
        if (!isset($instrument)) {
            return Jsend::error('resource not found');
        }
        // Retourne le message encapsulé en JSEND si tout est OK
        return Jsend::success($instrument->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //Auth
        // Validation des données et retour des messages en JSEND

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
        // Vérification de l'existence du message

        $instrument = Instrument::find($id);
        if (!isset($instrument)) {
            return Jsend::error('resource not found');
        }
        // Tout est OK, on mets à jour notre message
        $instrument->message = $inst;
        $instrument->save();
        return Jsend::success();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
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
        // Tout est OK, on mets à jour notre message

        $instrument->delete();

        return Jsend::success();
    }

}
