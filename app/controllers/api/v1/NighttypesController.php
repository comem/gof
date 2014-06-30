<?php

namespace api\v1;

use \Jsend;
use \Nighttype;


/**
 * REST controller with index and show methods implemented
 *
 * @category  Application services
 * @version   1.0
 * @author    gof
 */
class NighttypesController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
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
