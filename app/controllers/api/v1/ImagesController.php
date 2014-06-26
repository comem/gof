<?php

class ImagesController extends \BaseController {

    /**
     * Display a listing of the resource.
     * @return Jsend::success every images
     */
    public function index() {
        // Retourne toutes les images
        return Jsend::success(Image::all()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @var alt_de corresponds to the title of the image. (header)
     * @var caption_de corresponds to the description of the image. (header)
     * @var artist_id corresponds to the id of the artist. (header)
     * @var uploadedImage image to upload (multipart/form-data)
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::success if a new image was created.
     */
    public function store() {

        $alt_de = Input::header('alt_de');
        $caption_de = Input::header('caption_de');
        $artist_id = Input::header('artist_id');
        $uploadedImage = Input::file('uploadedImage');
        //Cast de artist_id car l'url l'envoit en String
        if (ctype_digit($artist_id)) {
            $artist_id = (int) $artist_id;
        }

        // Validation des types
        $validationImage = Image::validate(array(
                    'alt_de' => $alt_de,
                    'caption_de' => $caption_de,
                    'artist_id' => $artist_id,
                    'uploaded_img' => $uploadedImage,
        ));
        if ($validationImage !== true) {
            return Jsend::fail($validationImage);
        }


        $explodedMime = explode('/', $uploadedImage->getMimeType());
        $uploadFolder = 'public/upload/';
        $extension = '.' . $explodedMime[1];
        $imageName = date('Y-m-d-H-i-s'). '-' . $alt_de . $extension;
        $source = $uploadFolder . $imageName;

        $uploadedImage->move($uploadFolder, date('Y-m-d-H-i-s'). '-' . $alt_de . $extension);

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
     * @param  int  $id the id form the image
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if the required resource was not found.
     * @return Response Jsend::success if the required image was found.
     */
    public function show($id) {
        // Les ids venant de l'url sont des "String", alors que celui-ci est un "int"
        // Par contre la conversion se fait que pour des chaines Ok.
        if (ctype_digit($id)) {
            $id = (int) $id;
        }

        // Validation des types
        $validationImage = Image::validate(array('id' => $id));
        if ($validationImage !== true) {
            return Jsend::fail($validationImage);
        }

        // Validation de l'existance de lu lien
        if (Image::existTechId($id) !== true) {
            return Jsend::fail($id);
        }

        // Récupération du lien 
        $image = Image::find($id);

        // Retourne le lien encapsulé en JSEND si tout est OK
        return Jsend::success($image->toArray());
    }

    /**
     * Update the specified resource in storage.
     * Priorité 1B
     * @param  int  $id
     * @return Rien (fonction non réalisée pour le moment)
     */
    public function update($id) {
        /**
         * Priorité 1B
         * Correspond au UPDATE des fonctions CRUD
         */
    }

    /**
     * Remove the specified resource from storage.
     * Ne se fait pas dans l'application (seulement soft delet)
     * @param  int  $id
     * @return Rien (fonction non réalisée pour le moment)
     */
    public function destroy($id) {
        /**
         * Ne se fait pas dans l'application (seulement soft delet)
         * Correspond au DELETE des fonctions CRUD
         */
    }

}
