<?php

namespace api\v1;

use \Jsend;
use \Input;
use \DB;
use \Genre;
use \Artist;
use \Image;
use \ArtistMusicianController;
use \BaseController;
use \LinksController;
use \ArtistNightController;

//use \MusiciansController;

class ArtistsController extends BaseController {

    /**
     * Permet d'afficher tous les artists
     * @return jsend
     */
    public function index() {
        return Jsend::success(Artist::with('genres')->get(), 200);
    }

    /**
     * Allows to save a new artist
     * @var (string) name - the artist name
     * @var (string) short_description_de - A short description
     * @var (string) complete_description_de - A complete description
     * @var (array) "genres": [{"id": "(int)"}] - the artist genres
     * @var (array) "links": [{"url": "(string)","name_de": "(string)","title_de": "(string)"}] - the existing musicians
     * @var (array) "musicianInstruments": [{"musician_id": "(int)","instrument_id": "(int)"}] - the existing musicians
     * @var (array) "musicians": [{"first_name": "(string)","last_name": "(string)","stagename": "(string)","instruments": [{"id": "(int)"},{"id": "(int)"}] - the new musicians
     * @var (array) "night" :{"id": "(int)","order": "(int)","isSupport": "(tinyint)","artist_hour_arrival": "(datetime)"}
     * 
     * @return Jsend::fail Un message d'erreur si les données entrées ne correspondent pas aux données demandées.
     * @return Jsend::error Un message d'erreur si une ressource n'existe pas.
     * @return Jsend::success Un message de validation avec l'artist créé s'il a été enregistré.
     */
    public function store() {
        $artistName = Input::get('name');
        $artistSD = Input::get('short_description_de');
        $artistCD = Input::get('complete_description_de');
        $genres = Input::get('genres');
        $links = Input::get('links');
        $musicianInstruments = Input::get('musicianInstruments');
        $musicians = Input::get('musicians');
        $night = Input::get('night');
        $images = Input::get('images');



        DB::beginTransaction();



        $artist = static::saveArtist($artistName, $artistSD, $artistCD, $genres);

        if (!is_a($artist, 'Artist')) {
            return $artist;
        }

        if (isset($links)) {
            foreach ($links as $link) {
                $linkSaved = LinksController::saveLink($link['url'], $link['name_de'], $link['title_de'], $artist->id);
                if (!is_a($linkSaved, 'Link')) {
                    return $linkSaved;
                }
            }
        }

        if (isset($musicianInstruments)) {
            foreach ($musicianInstruments as $musicianInstrument) {
                $artistMusician = ArtistMusicianController::saveArtistMusician($artist->id, $musicianInstrument['instrument_id'], $musicianInstrument['musician_id']);
                if (!is_a($artistMusician, 'ArtistMusician')) {
                    return Jsend::error($artistMusician);
                }
            }
        }

        if (isset($musicians)) {
            foreach ($musicians as $musician) {
                $musicianToSave = MusiciansController::saveMusician($musician['first_name'], $musician['last_name'], $musician['stagename']);
                if (!is_a($musicianToSave, 'Musician')) {
                    return $musicianToSave;
                }

                foreach ($musician['instruments'] as $instrument) {
                    $artistMusician = ArtistMusicianController::saveArtistMusician($artist->id, $instrument['id'], $musicianToSave->id);
                    if (!is_a($artistMusician, 'ArtistMusician')) {
                        return Jsend::error($artistMusician);
                    }
                }
            }
        }

        if (isset($night)) {

            $performerToSave = ArtistNightController::saveArtistNight($artist->id, $night['id'], $night['order'], $night['isSupport'], $night['artist_hour_arrival']);
            if (!is_a($performerToSave, 'ArtistNight')) {
                return $performerToSave;
            }
        }

        if (isset($images)) {
            foreach ($images as $image) {
                $imageSaved = static::saveIllustration($artist->id, $image['id']);
                if (!is_a($imageSaved, 'Image')) {
                    return $imageSaved;
                }
            }
        }
        DB::commit();

        return Jsend::success($artist->toArray(), 201);
    }

    /**
     * Permet d'afficher un artist
     *
     * @param  int  $id - l'id de l'artist à afficher
     * @return Jsend::fail Un message d'erreur si les données entrées ne correspondent pas aux données demandées.
     * @return Jsend::success Sinon, un artist avec genre correspondant l'enregistrement demandé.
     */
    public function show($id) {

        if (ctype_digit($id)) {
            $id = (int) $id;
        }
        $validationArtist = Artist::validate(array('id' => $id));
        if ($validationArtist !== true) {
            return Jsend::fail($validationArtist, 400);
        }

        $artist = Artist::find($id);

        if (!isset($artist)) {
            return Jsend::error('resource not found', 404);
        }

        return Jsend::success($artist->with('genres')->find($id), 200);
    }

    /**
     * Permet de modifier un artist
     * @param int $id - l'id de l'artist a modifier
     * @var (string) name - Le nom de l'artist
     * @var (string) short_description_de - Une courte description de l'artist
     * @var (string) complete_description_de - Une description complete de l'artist
     * 
     * @return Jsend::fail Un message d'erreur si les données entrées ne correspondent pas aux données demandées.
     * @return Jsend::error Un message d'erreur si l'artist à modifier n'existe pas.
     * @return Jsend::success Sinon, un message de validation de modification de l'artist concerné.
     */
    public function update($id) {

        if (ctype_digit($id)) {
            $id = (int) $id;
        }

        $artistName = Input::get('name');
        $artistSD = Input::get('short_description_de');
        $artistCD = Input::get('complete_description_de');
        $validationArtist = Artist::validate(array(
                    'name' => $artistName,
                    'short_description_de' => $artistSD,
                    'complete_description_de' => $artistCD,
        ));
        if ($validationArtist !== true) {
            return Jsend::fail($validationArtist, 400);
        }

        $artist = Artist::find($id);
        if (!isset($artist)) {
            return Jsend::error('resource not found', 404);
        }

        $artist->name = $artistName;
        $artist->short_description_de = $artistSD;
        $artist->complete_description_de = $artistCD;
        $artist->save();

        return Jsend::success($artist->toArray(), 200);
    }

    /**
     * Pas implémentée pour l'instant
     */
    public function destroy($id) {
        
    }

    public static function saveArtist($artistName, $artistSD, $artistCD, $genres) {
        $validationArtist = Artist::validate(array(
                    'name' => $artistName,
                    'short_description_de' => $artistSD,
                    'complete_description_de' => $artistCD,
        ));


        if ($validationArtist !== true) {
            return Jsend::fail($validationArtist, 400);
        }

        $artist = new Artist();
        $artist->name = $artistName;
        $artist->short_description_de = $artistSD;
        $artist->complete_description_de = $artistCD;
        $artist->save();

        if (!isset($genres)) {
            return Jsend::fail('genre is required');
        }
        foreach ($genres as $genre) {
            if (ctype_digit($genre['id'])) {
                $genre['id'] = (int) $genre['id'];
            }

            $validationGenre = Genre::validate(array(
                        'id' => $genre['id'],
            ));
            if ($validationGenre !== true) {

                return Jsend::fail($validationGenre, 400);
            }

            if (!Genre::existTechId($genre['id'])) {
                if (!Genre::existTechId($genre['id'])) {

                    return Jsend::error('genre not found', 404);
                }
            }
            $artist->genres()->attach($genre['id']);
        }

        return $artist;
    }

    public static function saveIllustration($artistId, $imageId) {


        if (!Image::existTechId($imageId)) {
            return Jsend::error('image not found', 404);
        }

        $image = Image::find($imageId);
        if ($image->artist_id !== null) {
            return Jsend::fail('this image belongs already to an artist', 400);
        }


        $image->artist_id = $artistId;
        $image->save();
        return $image;
    }

}
