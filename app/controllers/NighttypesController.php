<?php

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
     * Store a newly created resource in storage.
     *
     * @return Response
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
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
