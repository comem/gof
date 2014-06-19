<?php

class InstrumentsController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        // Auth
       
       return Jsend::success(Instrument::all()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        // Auth
        $instrument = Input::get('name_de');
        $validationInstrum = Message::validate(array('instrument' => $instrument));

        if ($validationInstrum !== true) {
            return Jsend::fail($validationInstrum);
        }
        // Tout est ok, on sauve le message avec l'id du user connecté
        $newinstrument = new Instrument();
        $newinstrument->name_de = $instrument['name_de'];
        $newinstrument->save();


        // Et on retourne l'id du message nouvellement créé (encapsulé en JSEND)
        return Jsend::success(array('name_de' => $newinstrument->name_de));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        // Auth
        
        
        $validationInst = Instrument::validate(array('id' => $id));
             dd($validationInst);
        if ($validationInst !== true) {
            return Jsend::fail($validationInst);
        }
    
        // Vérification de l'existence du message
        $instrument = Instrument::find($id);
        // Ou si l'on veut que les informations de l'utilisateur soit avec :
        // $message = Message::with('user')->find($id);
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
