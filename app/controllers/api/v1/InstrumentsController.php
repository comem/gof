<?php
namespace api\v1;

use \Jsend;
use \Input;
use \BaseController;
use \Instrument;

class InstrumentsController extends BaseController {

    /**
     * Allows to display every instruments from the database.
     * @return Response Jsend::success with all instruments.
     */
    public function index() {

        return Jsend::success(Instrument::all()->toArray());
    }

    /**
     * Allows to save a new genre.
     * @var name_de (string) name - the intstrument name (get)
     * 
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if a resource was not found.
     * @return Response Jsend::success if a new instrument was created.
     */
    public function store() {

        $name_de = Input::get('name_de');
        
        $instrument = static::saveInstrument($name_de);
        
         if (!is_a($instrument, 'Instrument')) {
                    return Jsend::fail($instrument);
                    }

        
        return Jsend::success(array('name_de' => $instrument->name_de));
    }

    /**
     * Allows to display a specific instrument from the database.
     * @param  int -  the id from the instrument
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if the required resource was not found.
     * @return Response Jsend::success if the required instrument was found.
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
     * Allows to display a specific instrument from the database.
     * @param  int -  the id from the instrument to modify
     * 
     * @var string - the new instrument name
     * 
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if the required resource was not found.
     * @return Response Jsend::success if the instrument was modified.
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
            return Jsend::fail($validationInst);
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
     * @param  int -  the id from the instrument to delete 
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if the required resource was not found.
     * @return Response Jsend::success if the instrument was deleted.
     */
    public function destroy($id) {
        //auth
        if (ctype_digit($id)) {
            $id = (int) $id;
        }
        $validationInst = Instrument::validate(array(
                    'id' => $id
        ));


        if ($validationInst !== true) {
            return Jsend::fail($validationInst);
        }

        $instrument = Instrument::find($id);
        if (!isset($instrument)) {
            return Jsend::error('resource not found');
        }


        $instrument->delete();

        return Jsend::success();
    }

    
    /**
     * Allows to save a new instrument
     * @param string - the instrument name
     * @return Instrument - the created instrument
     */
    public static function saveInstrument($name_de){
       
        if (Instrument::existBuisnessId($name_de) == true) {

            return Jsend::error("instrument: " .$name_de."  already exists in the database");
        }

        $validationInstrum = Instrument::validate(array('name_de' => $name_de));

        if ($validationInstrum !== true) {
            return Jsend::fail($validationInstrum);
        }

        $newinstrument = new Instrument();
        $newinstrument->name_de = $name_de;
        $newinstrument->save();
        
        return $newinstrument;
    }
    
    
}
