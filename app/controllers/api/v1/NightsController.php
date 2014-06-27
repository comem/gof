<?php

namespace api\v1;

use \BaseController;
use \Night;
use \Input;
use \Jsend;
use \DB;
use \Image;
use \NightTicketcategorie;
use \Ticketcategorie;

class NightsController extends BaseController {
    //Cette classe correspond à la table "events" du diagrame de class.

    /**
     * Display a listing of the resource.
     *
     * @return Jsend::success All the events
     */
    public function index() {
        return Jsend::success(Night::with('ticketcategories')->with('platforms')->with('artists')->with('image')->with('printingtypes')->get());
    }

    /**
     * Save an Event
     * @var (date) start_date_hour - Date of the beginning event
     * @var (date) ending_date_hour - Date of the ending event
     * @var (date) opening_doors - OPTIONNAL - Date of the opening doors
     * @var (string) title_de - The title of the event
     * @var (int) nb_meal - The number of meal
     * @var (int) nb_vegans_meal - The number of vegans meal
     * @var (string) meal_notes - OPTIONNAL - The notes of the meal
     * @var (int) nb_places - OPTIONNAL - The number of places in the event
     * @var (boolean) followed_by_private - OPTIONNAL - If the event is organized by a private organisator
     * @var (string) contract_src - OPTIONNAL - The source of the contract (The directory for example)
     * @var (string) notes - OPTIONNAL - A note about the evenement
     * @var (int) nighttype_id - The id of the event type
     * @var (int) image_id - The id of the illustration image
     * @var (array) "platforms": {
    "platform1": {
      "platform_id":"1",
      "external_id":"external_id",
      "external_infos":"external_infos",
      "url":"url"
    }
  }
     * @var (array) {
   "artist": {
    "artist1": {
      "id": "",
      "artistName": "Capitain",
      "artistSD": "ShortDescription",
      "artistCD": "BigDescription",
      "is_support":"0",
      "artist_hour_arrival":"2014-01-03 01:01:01",
      "genres": {
        "genre1": {
          "id": "1"
        }
      }
    },
    "artist2": {
      "id":"1",
      "artistName":"",
      "artistSD":"",
      "artistCD":"",
      "is_support":"0",
      "artist_hour_arrival":"2014-01-03 01:01:01",
      "genres":""
    }
  }
  
     * 
     * @return Jsend::fail An error message if the parameters aren't correct
     * @return Jsend::error An error message if the ressource doesn't exist or exist but you are trying to rewrite it
     * @return Jsend::success A validation message with the id of the new Event created
     * 
     * JSON DE TEST:
     * {
  "start_date_hour": "2019-01-02 01:03:01",
  "ending_date_hour": "2020-01-03 01:01:01",
  "opening_doors": "",
  "title_de": "MODIF OK",
  "nb_meal": "30",
  "nb_vegans_meal": "30",
  "meal_note": "",
  "nb_places": "130",
  "followed_by_private": "FALSE",
  "contract_src": "",
  "notes": "notes",
  "nighttype_id": "1",
  "image_id": "1",
  "ticket_categorie": {
    "ticket1": {
      "ticket_categorie_id": "1",
      "amount": "30",
      "quantitySold": "30",
      "comment": "test"
    }
  },
  "artist": {
    "artist1": {
      "id": "",
      "artistName": "Capitain",
      "artistSD": "ShortDescription",
      "artistCD": "BigDescription",
      "is_support":"0",
      "artist_hour_arrival":"2014-01-03 01:01:01",
      "genres": {
        "genre1": {
          "id": "1"
        }
      }
    },
    "artist2": {
      "id":"1",
      "artistName":"",
      "artistSD":"",
      "artistCD":"",
      "is_support":"0",
      "artist_hour_arrival":"2014-01-03 01:01:01",
      "genres":""
    }
  },
  "platforms": {
    "platform1": {
      "platform_id":"1",
      "external_id":"external_id",
      "external_infos":"external_infos",
      "url":"url"
    }
  }
}
     */
    public function store() {
        $start_date_hour = Input::get('start_date_hour');
        $ending_date_hour = Input::get('ending_date_hour');
        $opening_doors = Input::get('opening_doors');
        $title_de = Input::get('title_de');
        $nb_meal = Input::get('nb_meal');
        $nb_vegans_meal = Input::get('nb_vegans_meal');
        $meal_notes = Input::get('meal_notes');
        $nb_places = Input::get('nb_places');
        $followed_by_private = Input::get('followed_by_private');
        $contract_src = Input::get('contract_src');
        $notes = Input::get('notes');
        $nighttype_id = Input::get('nighttype_id');
        $image_id = Input::get('image_id');
        $ticket_categorie = Input::get('ticket_categorie');
        $artist = Input::get('artist');
        $platforms = Input::get('platforms');

        DB::beginTransaction();
        $night = static::saveNight($start_date_hour, $ending_date_hour, $opening_doors, $title_de, $nb_meal, $nb_vegans_meal, $meal_notes, $nb_places, $followed_by_private, $contract_src, $notes, $nighttype_id, $image_id, $ticket_categorie);
        if (!is_a($night, 'Night')) {
            return $night;
        }
        
        if (isset($artist)) {
            $compteur = 1;
            foreach ($artist as $a) {
                if ($a['id'] == '') {
                    
                    $artist_saved = ArtistsController::saveArtist($a['artistName'], $a['artistSD'], $a['artistCD'], $a['genres']);
                    
                    if (!is_a($artist_saved, 'Artist')) {
                        return $artist_saved;
                    }
                    
                    $artistNight = ArtistNightController::saveArtistNight($artist_saved->id, $night->id, $compteur, $a['is_support'], $a['artist_hour_arrival']);
                
                   
                    } else {
                        
                    $artistNight = ArtistNightController::saveArtistNight($a['id'], $night->id, $compteur, $a['is_support'], $a['artist_hour_arrival']);
                }
                 

                if (!is_a($artistNight, 'ArtistNight')) {
                    return $artistNight;
                }
                  


                $compteur++;
            }
        }
        
        if (isset($platforms)) {
            foreach ($platforms as $p) {
                $nightPlatform = NightPlatformController::saveNightPlatform($p['platform_id'], $night->id, $p['external_id'], $p['external_infos'], $p['url']);
                if (!is_a($nightPlatform, 'NightPlatform')) {
                    return $nightPlatform;
                }
            }
        }
        

        DB::commit();
        // Et on retourne l'id du lien nouvellement créé (encapsulé en JSEND)
        return Jsend::success($night->toArray(), 201);
    }

    /**
     * Display the specified resource.
     * @param  $night_id The id of the demanded ressources
     * @return Jsend::fail An error message if the parameters aren't correct
     * @return Jsend::error An error message if the ressource doesn't exist or exist but you are trying to rewrite it
     * @return Jsend::success A validation message with the event searched
     */

    /**
     * Save an Event
     * @param (date) start_date_hour - Date of the beginning event
     * @param (date) ending_date_hour - Date of the ending event
     * @param (date) opening_doors - OPTIONNAL - Date of the opening doors
     * @param (string) title_de - The title of the event
     * @param (int) nb_meal - The number of meal
     * @param (int) nb_vegans_meal - The number of vegans meal
     * @param (string) meal_notes - OPTIONNAL - The notes of the meal
     * @param (int) nb_places - OPTIONNAL - The number of places in the event
     * @param (boolean) followed_by_private - OPTIONNAL - If the event is organized by a private organisator
     * @param (string) contract_src - OPTIONNAL - The source of the contract (The directory for example)
     * @param (string) notes - OPTIONNAL - A note about the evenement
     * @param (int) nighttype_id - The id of the event type
     * @param (int) image_id - The id of the illustration image
     * @param (array) "ticket_categorie": [{"ticket1": {"ticket_categorie_id":(int),"amount":(int},"quantitySold":(int},"comment":(string)},
     * "ticket2": {"ticket_categorie_id":(int),"amount":(int},"quantitySold":(int},"comment":(string)}}] - The category ticket concerned by the event
     * 
     * @return Jsend::fail An error message if the parameters aren't correct
     * @return Jsend::error An error message if the ressource doesn't exist or exist but you are trying to rewrite it
     * @return Jsend::success A validation message with the id of the new Event created
     */
    public static function saveNight($start_date_hour, $ending_date_hour, $opening_doors, $title_de, $nb_meal, $nb_vegans_meal, $meal_notes, $nb_places, $followed_by_private, $contract_src, $notes, $nighttype_id, $image_id, $ticket_categorie) {
        if (Night::existBuisnessId($start_date_hour) == true) {

            return Jsend::error("event already exist in the database");
        }

        if ($image_id != null) {
            if (Image::existTechId($image_id) == false) {
                return Jsend::error("Image doesn't exist in the database");
            }
        }

        foreach ($ticket_categorie as $tc) {
            $ticketCatId = $tc['ticket_categorie_id'];
            $amount = $tc['amount'];
            $quantitySold = $tc['quantitySold'];
            $comment = $tc['comment'];

            $validationNightTicketCat = \Ticketcategorie::validate(array(
                        'night_id' => '1',
                        'ticketcategorie_id' => $ticketCatId,
                        'amount' => $amount,
                        'quantity_sold' => $quantitySold,
                        'comment' => $comment,
            ));

            if ($validationNightTicketCat !== true) {
                return Jsend::fail($validationNightTicketCat);
            }

            if (!Ticketcategorie::existTechId($ticketCatId)) {
                return Jsend::error('ticketcategorie not found');
            }
        }

        // Validation des types
        $validationNight = Night::validate(array(
                    'start_date_hour' => $start_date_hour,
                    'ending_date_hour' => $ending_date_hour,
                    'opening_doors' => $opening_doors,
                    'title_de' => $title_de,
                    'nb_meal' => $nb_meal,
                    'nb_vegans_meal' => $nb_vegans_meal,
                    'meal_notes' => $meal_notes,
                    'nb_places' => $nb_places,
                    'followed_by_private' => $followed_by_private,
                    'contract_src' => $contract_src,
                    'notes' => $notes,
                    'nighttype_id' => $nighttype_id,
                    'image_id' => $image_id
        ));
        if ($validationNight !== true) {
            return Jsend::fail($validationNight);
        }



        if (!Night::comparison_date($start_date_hour, $ending_date_hour)) {
            return Jsend::fail(array('id' => "The start date is after the ending date"
                        , 'date_1' => $start_date_hour
                        , 'date_2' => $ending_date_hour));
        }



        if ($opening_doors != null) {
            if (Night::comparison_date($start_date_hour, $opening_doors)) {
                return Jsend::fail("The opening door is after the start date");
            }
        }

        $all_night = Night::all();

        foreach ($all_night as $night) {
            $start_night = $night->start_date_hour;
            $end_night = $night->ending_date_hour;


            if (Night::comparison_date($start_night, $start_date_hour) && Night::comparison_date($start_date_hour, $end_night)) {
                return Jsend::fail("The actual event overlaps an existing one");
            }
            if (Night::comparison_date($start_night, $ending_date_hour) && Night::comparison_date($ending_date_hour, $end_night)) {
                return Jsend::fail("The actual event overlaps an existing one");
            }
        }

        $night = new Night();
        $night->start_date_hour = $start_date_hour;
        $night->ending_date_hour = $ending_date_hour;
        if ($opening_doors != '') {
            $night->opening_doors = $opening_doors;
        }
        $night->title_de = $title_de;
        $night->nb_meal = $nb_meal;
        $night->nb_vegans_meal = $nb_vegans_meal;
        $night->meal_notes = $meal_notes;
        $night->nb_places = $nb_places;
        $night->followed_by_private = $followed_by_private;
        $night->contact_src = $contract_src;
        $night->notes = $notes;
        $night->nighttype_id = $nighttype_id;
        if ($image_id != '') {
            $night->image_id = $image_id;
        }

        $night->save();
        $nightId = $night->id;
        foreach ($ticket_categorie as $tc) {
            $ticketCatId = $tc['ticket_categorie_id'];
            $amount = $tc['amount'];
            $quantitySold = $tc['quantitySold'];
            $comment = $tc['comment'];
            $nightTicketCat = new NightTicketcategorie();
            $nightTicketCat->night_id = $nightId;
            $nightTicketCat->ticketcategorie_id = $ticketCatId;
            $nightTicketCat->amount = $amount;
            $nightTicketCat->quantity_sold = $quantitySold;
            $nightTicketCat->comment_de = $comment;
            $nightTicketCat->save();
        }

        return $night;


        // Et on retourne l'id du lien nouvellement créé (encapsulé en JSEND)
        return Jsend::success(array('id' => $night->id));
    }

    /**
     * Display the specified resource.
     * @param  $night_id The id of the demanded ressources
     * @return Jsend::fail An error message if the parameters aren't correct
     * @return Jsend::error An error message if the ressource doesn't exist or exist but you are trying to rewrite it
     * @return Jsend::success A validation message with the event searched
     */
    public function show($night_id) {
        // Auth
        if (ctype_digit($night_id)) {
            $night_id = (int) $night_id;
        }

        if (Night::existTechId($night_id) !== true) {
            return Jsend::error("night doesn't exists in the database");
        }

        $night = Night::find($night_id);

        if (!isset($night)) {
            return Jsend::error('Night id : ' . $night_id . 'resource not found');
        }

        


        // Retourne le message encapsulé en JSEND si tout est OK
        return Jsend::success(Night::with('ticketcategories')->with('platforms')->with('artists')->with('image')->find($night_id));
    }

    /**
     * Update an event
     * @param  $night_id The id of the demanded ressources
     * @var (date) start_date_hour - Date of the beginning event
     * @var (date) ending_date_hour - Date of the ending event
     * @var (date) opening_doors - OPTIONNAL - Date of the opening doors
     * @var (string) title_de - The title of the event
     * @var (int) nb_meal - The number of meal
     * @var (int) nb_vegans_meal - The number of vegans meal
     * @var (string) meal_notes - OPTIONNAL - The notes of the meal
     * @var (int) nb_places - OPTIONNAL - The number of places in the event
     * @var (boolean) followed_by_private - OPTIONNAL - If the event is organized by a private organisator
     * @var (string) contract_src - OPTIONNAL - The source of the contract (The directory for example)
     * @var (string) notes - OPTIONNAL - A note about the evenement
     * @var (int) nighttype_id - The id of the event type
     * @var (int) image_id - The id of the illustration image

     * 
     * @return Jsend::fail An error message if the parameters aren't correct
     * @return Jsend::error An error message if the ressource doesn't exist
     * @return Jsend::success A validation message with the new Event
     */
    public function update($id) {
        if (ctype_digit($id)) {
            $id = (int) $id;
        }
        $start_date_hour = Input::get('start_date_hour');
        $ending_date_hour = Input::get('ending_date_hour');
        $opening_doors = Input::get('opening_doors');
        $title_de = Input::get('title_de');
        $nb_meal = Input::get('nb_meal');
        $nb_vegans_meal = Input::get('nb_vegans_meal');
        $meal_notes = Input::get('meal_notes');
        $nb_places = Input::get('nb_places');
        $followed_by_private = Input::get('followed_by_private');
        $contract_src = Input::get('contract_src');
        $notes = Input::get('notes');
        $nighttype_id = Input::get('nighttype_id');
        $image_id = Input::get('image_id');
        // Validation des types


        $validationNight = Night::validate(array(
                    'start_date_hour' => $start_date_hour,
                    'ending_date_hour' => $ending_date_hour,
                    'opening_doors' => $opening_doors,
                    'title_de' => $title_de,
                    'nb_meal' => $nb_meal,
                    'nb_vegans_meal' => $nb_vegans_meal,
                    'meal_notes' => $meal_notes,
                    'nb_places' => $nb_places,
                    'followed_by_private' => $followed_by_private,
                    'contract_src' => $contract_src,
                    'notes' => $notes,
                    'nighttype_id' => $nighttype_id,
                    'image_id' => $image_id
        ));
        if ($validationNight !== true) {
            return Jsend::fail($validationNight);
        }

        $night = Night::find($id);
        if (!isset($night)) {
            return Jsend::error('resource not found');
        }
        if (!Night::comparison_date($start_date_hour, $ending_date_hour)) {
            return Jsend::fail(array('id' => "The start date is after the ending date"
                        , 'date_1' => $start_date_hour
                        , 'date_2' => $ending_date_hour));
        }



        if ($opening_doors != null) {
            if (Night::comparison_date($start_date_hour, $opening_doors)) {
                return Jsend::fail("The opening door is after the start date");
            }
        }
        $all_night = Night::all();

        foreach ($all_night as $night) {
            $start_night = $night->start_date_hour;
            $end_night = $night->ending_date_hour;
            if ($night->id != $id) {
                if (Night::comparison_date($start_night, $start_date_hour) && Night::comparison_date($start_date_hour, $end_night)) {
                    return Jsend::fail("The actual event overlaps an existing one");
                }
                if (Night::comparison_date($start_night, $ending_date_hour) && Night::comparison_date($ending_date_hour, $end_night)) {
                    return Jsend::fail("The actual event overlaps an existing one");
                }
            }
        }
        $night->start_date_hour = $start_date_hour;
        $night->ending_date_hour = $ending_date_hour;
        if ($opening_doors != '') {
            $night->opening_doors = $opening_doors;
        }
        $night->title_de = $title_de;
        $night->nb_meal = $nb_meal;
        $night->nb_vegans_meal = $nb_vegans_meal;
        $night->meal_notes = $meal_notes;
        $night->nb_places = $nb_places;
        $night->followed_by_private = $followed_by_private;
        $night->contact_src = $contract_src;
        $night->notes = $notes;
        $night->nighttype_id = $nighttype_id;
        if ($image_id != '') {
            $night->image_id = $image_id;
        }

        $night->save();
        return Jsend::success($night->toArray());
    }

    /**
     * Remove the specified ressrouces
     * @param  $night_id The id of the demanded ressources
     * @return Jsend::error An error message if the ressource doesn't exist or exist but you are trying to rewrite it
     * @return Jsend::success A validation message
     */
    public function destroy($id) {
        if (ctype_digit($id)) {
            $id = (int) $id;
        }
        $night = Night::find($id);
        if (!isset($night)) {
            return Jsend::error('resource not found');
        }

        $night->platforms()->detach();
        $night->ticketcategories()->detach();
        $night->artists()->detach();
        $night->delete();


        return Jsend::success('Night deleted');
    }

}
