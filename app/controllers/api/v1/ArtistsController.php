<?php

namespace api\v1;

use \Jsend;
use \Input;
use \DB;
use \Genre;
use \Artist;
use \Image;
use \BaseController;


/**
 * REST controller with index, store, show and update methods implemented.
 * 
 * Corresponds to the "artists" class of the class diagram.
 *
 * @category  Application services
 * @version   1.0
 * @author    gof
 */
class ArtistsController extends BaseController {

    /**
     * Allows to display every artists from the database with musicians and their instruments, genres, nights, images, and links.
     * @return Response Jsend::success with all artists.
     */
    public function index() {
        $artists = Artist::with('musicians', 'genres', 'nights', 'images', 'links')->get();
        foreach ($artists as $artist) {
            $artist->musicians->load('instruments');
        }
        return Jsend::success($artists, 200);
    }

    /**
     * Allows to save a new artist with genres, unexisting links, existing musicians, unexisting musicians, existing night and existing images
     * @var name (string) - the artist name (get)
     * @var short_description (string) - a short description (get)
     * @var complete_description (string) - a complete description (get)
     * @var genres (array) [{"id": "(int)"}] - the artist genres (get)
     * @var links (array) [{"url": "(string)","name_de": "(string)","title_de": "(string)"}] - the existing musicians (get)
     * @var musicianInstruments (array) [{"musician_id": "(int)","instrument_id": "(int)"}] - the existing musicians (get)
     * @var musicians (array) [{"first_name": "(string)","last_name": "(string)","stagename": "(string)","instruments": [{"id": "(int)"},{"id": "(int)"}] - the new musicians (get)
     * @var night (array) {"id": "(int)","order": "(int)","isSupport": "(tinyint)","artist_hour_arrival": "(datetime)"} - the artist will play at this night (get)
     * @var images (array) [{"id": "(int)"}] - the existing images (get)
     * 
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if a resource was not found.
     * @return Response Jsend::success if a new artist was created.
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
     * Allows to display a specific artist from the database with musicians and their instruments, genres, nights, images, and links.
     * @param  int -  the id from the artist (url)
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if the required resource was not found.
     * @return Response Jsend::success if the required artist was found.
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

        $artistToDisplay = Artist::with('musicians', 'genres', 'nights', 'images', 'links')->find($id);
   
            $artistToDisplay->musicians->load('instruments');

        return Jsend::success($artistToDisplay, 200);
    }

    /**
     * Allows to modify an artist
     * @param int the id from the artist (url)
     * @var name (string) the name from the artist (get)
     * @var short_description_de (string) a short description from the artist (get)
     * @var complete_description_de (string) a complete description from the artist (get)
     * 
     * @return Response Jsend::fail if the input data are not correct.
     * @return Response Jsend::error if the resource to modify was not found.
     * @return Response Jsend::success if the artist was modified.
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
     * @ignore
     * Not implemented yet.
     */
    public function destroy($id) {
        
    }

    /**
     * @ignore
     * Allows to save a new artist 
     * @param string artistName - the name from the artist
     * @param string artistSD - a short description from the artist
     * @param string artistCD - a complete description from the artist
     * @param array genres - the genres from the artists
     * @return Artist - a created artist
     */
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

    /**
     * @ignore
     * Allows to save an Illustration.
     * @param int $artistId
     * @param int $imageId
     * @return Image - the image that illustrate the artist
     */
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

    /**
     * Allow to search a Artist with  name attribute
     * @var string : data of search. exemple : artist/search?string=test
     * @return json of object received
     */
    public static function search() {

        $string = Input::get('string');

        $results = Artist::Where('name', 'like', "$string%")->get();

        return ($results->toArray());
    }

}
