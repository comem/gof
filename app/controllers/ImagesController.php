<?php

class ImagesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * @return Response
	 */
	public function index()
	{
		// Retourne toutes les images
        return  Jsend::success(Image::all()->toArray());
	}


	/**
	 * Store a newly created resource in storage.
	 * @return Response
	 */
	public function store()
	{

        $alt_de = Input::get('alt_de');
        $caption_de = Input::get('caption_de');
        $source = Input::get('source');
        $artist_id = Input::get('artist_id');

        //Cast de artist_id car l'url l'envoit en String
        if (ctype_digit($artist_id)) {
            $artist_id = (int)$artist_id;
        }

        // Validation des types
        $validationImage = Image::validate(array(
            'alt_de' => $alt_de,
            'caption_de' => $caption_de,
            'source' => $source,
            'artist_id' => $artist_id,
        ));
        if ($validationImage !== true) {
            return Jsend::fail($validationImage);
        }

        // Sauvegarde de l'image avec l'artiste (Aucune validation car l'id d'artist n'est pas obligatoire.)
        $image = new Image();
        $image->alt_de = $alt_de;
        $image->caption_de = $caption_de;
        $image->source = $source;
        $image->artist_id = $artist_id;
        $image->save();

        // Et on retourne l'id du lien nouvellement créé (encapsulé en JSEND)
        return Jsend::success(array('id' => $image->id));
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		/** 
		* Priorité 1B
		* Correspond au UPDATE des fonctions CRUD
		*/
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		/** 
		* Ne se fait pas dans l'application (seulement soft delet)
		* Correspond au DELETE des fonctions CRUD
		*/
	}


}
