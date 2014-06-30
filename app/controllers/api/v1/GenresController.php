<?php

namespace api\v1;

use \BaseController;
use \Jsend;
use \Genre;
use \Input;


class GenresController extends BaseController {

    /**
     * Allows to display every genres from the database.
     * @return Response Jsend::success with all genres.
     */
    public function index() {
        return Jsend::success(Genre::all()->toArray());
    }

    /**
     * Allows to save a new genre.
     * @var name_de (string) name - the genre name (get)
     * 
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if a resource was not found.
     * @return Response Jsend::success if a new genre was created.
     */
    public function store() {
        $genreName = Input::get('name_de');
        $validationGenre = Genre::validate(array('name_de' => $genreName));
        if (Genre::existBusinessId($genreName)) {
            return Jsend::error("genre already exists");
        }

        if ($validationGenre !== true) {
            return Jsend::fail($validationGenre);
        }


        $genre = new Genre();
        $genre->name_de = $genreName;
        $genre->save();
        return Jsend::success($genre->toArray());
    }

    /**
     * Allows to display a specific genre from the database.
     * @param  int -  the id from the genre
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if the required resource was not found.
     * @return Response Jsend::success if the required genre was found.
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
     * Not implemented yet.
     */
    public function update($id) {
        //
    }

    /**
     * Not implemented yet.
     */
    public function destroy($id) {
        //
    }
    
      public static function search() {

        $string = Input::get('string');


        $results = Genre::Where('name_de', 'like', "$string%")->get();
        
        return ($results->toArray());

      
    }

}
