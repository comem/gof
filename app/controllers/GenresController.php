<?php

class GenresController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return Jsend::success(Genre::all()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $genreName = Input::get('name_de');
        $validationGenre = Genre::validate(array('name_de' => $genreName));
        if ($validationGenre !== true) {
            return Jsend::fail($validationGenre);
        }

        if (Genre::existBusinessId($genreName)) {
            return Jsend::error("genre already exists");
        }
        $genre = new Genre();
        $genre->name_de = $genreName;
        $genre->save();
        return Jsend::success(array('id' => $genre->id));
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
        $validationGenre = Genre::validate(array('id' => $id));
        if ($validationGenre !== true) {
            return Jsend::fail($validationGenre);
        }
        if (!Genre::existTechId($id)) {
            return Jsend::error('genre not found');
        }

        return Jsend::success(Genre::find($id)->toArray());
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
