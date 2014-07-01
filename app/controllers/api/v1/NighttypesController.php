<?php

namespace api\v1;

use \Jsend;
use \Nighttype;
use \Input;

/**
 * REST controller with index and show methods implemented.
 * 
 * Corresponds to the "event_types" class of the class diagram.
 *
 * @category  Application services
 * @version   1.0
 * @author    gof
 */
class NighttypesController extends \BaseController {

    /**
     * Allows to display every nighttypes from the database.
     * @return Response Jsend::success with all nighttypes.
     */
    public function index() {
        return Jsend::success(Nighttype::all()->toArray());
    }

    /**
     * @ignore
     * Not implemented yet.
     */
    public function store() {
        //
    }

    /**
     * Allows to display a specific nighttype from the database.
     * @param  int -  the id from the nighttype
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if the required resource was not found.
     * @return Response Jsend::success if the required genre was found.
     */
    public function show($id) {
        if (ctype_digit($id)) {
            $id = (int) $id;
        }
        $validationNighttype = Nighttype::validate(array('id' => $id));
        if ($validationNighttype !== true) {
            return Jsend::fail($validationNighttype);
        }
        if (!Nighttype::existTechId($id)) {
            return Jsend::error('nighttype not found');
        }
        return Jsend::success(Nighttype::find($id)->toArray());
    }

    /**
     * Allow to search a nighttype with attribute name_de
     * @var string : data of search. exemple : musician/search?string=test
     * @return json of object received
     */
    public static function search() {

        $string = Input::get('string');

        $results = Nighttype::Where('name_de', 'like', "$string%")->get();

        return ($results->toArray());
    }

    /**
     * @ignore
     * Not implemented yet.
     * 
     */
    public function update($id) {
        //
    }

    /**
     * @ignore
     * Not implemented yet.
     */
    public function destroy($id) {
        //
    }

}
