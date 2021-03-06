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
use \Artist;
use \WordPublish;
use \Response;
use \SimpleXMLElement;
use \ArrayToXml;

/**
 * REST controller with index, store, show, update and destroy methods implemented.
 * 
 * Corresponds to the "events" class of the class diagram.
 *
 * @category  Application services
 * @version   1.0
 * @author    gof
 */
class NightsController extends BaseController {
    //Cette classe correspond Ã  la table "events" du diagrame de class.

    /**
     * Display a listing of the resource.
     *
     * @return Response Jsend::success All the events
     */
    public function index() {
        return Jsend::success(Night::with('ticketcategories')->
                                with('platforms')->with('artists')->with('image')->with('printingtypes')->with('nighttype')->get()->toArray());
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
     * @var (array)  "ticket_categorie": {
      "ticket1": {
      "ticket_categorie_id": "1",
      "amount": "30",
      "quantitySold": "30",
      "comment": "test"
      }
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
     * # @var (array) "platforms": {
      "platform1": {
      "platform_id":"1",
      "external_id":"external_id",
      "external_infos":"external_infos",
      "url":"url"
      }
      }

     * 
     * @return Response Jsend::fail An error message if the parameters aren't correct
     * @return Response Jsend::error An error message if the ressource doesn't exist or exist but you are trying to rewrite it
     * @return Response Jsend::success A validation message with the id of the new Event created
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
      "ticket_categories": {
      "ticket1": {
      "ticket_categorie_id": "1",
      "amount": "30",
      "quantitySold": "30",
      "comment": "test"
      }
      },
      "artists": {
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
        $ticket_categorie = Input::get('ticket_categories');
        $artist = Input::get('artists');
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
        // Et on retourne l'id du lien nouvellement crÃ©Ã© (encapsulÃ© en JSEND)
        return Jsend::success($night->toArray(), 201);
    }

    /**
     * Display the specified resource.
     * @param  $night_id The id of the demanded ressources
     * @return Response Jsend::fail An error message if the parameters aren't correct
     * @return Response Jsend::error An error message if the ressource doesn't exist or exist but you are trying to rewrite it
     * @return Response Jsend::success A validation message with the event searched
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




        // Retourne le message encapsulÃ© en JSEND si tout est OK
        return Jsend::success(Night::with('ticketcategories')->with('platforms')->with('artists')->with('image')->with('printingtypes')->with('nighttype')->find($night_id));
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
     * @return Response Jsend::fail An error message if the parameters aren't correct
     * @return Response Jsend::error An error message if the ressource doesn't exist
     * @return Response Jsend::success A validation message with the new Event
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
            if (!Night::comparison_date($start_date_hour, $opening_doors)) {
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
     * @return Response Jsend::error An error message if the ressource doesn't exist or exist but you are trying to rewrite it
     * @return Response Jsend::success A validation message
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

    /**
     * Allows to search a night with attribute title_de
     * @var string : data of search. exemple : musician/search?string=test
     * @return json of object received
     */
    public static function search() {

        $string = Input::get('string');

        $results = Night::Where('title_de', 'like', "$string%")->get();

        return ($results->toArray());
    }

    /**
     * @ignore
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
     * @return Response Jsend::fail An error message if the parameters aren't correct
     * @return Reponse Jsend::error An error message if the ressource doesn't exist or exist but you are trying to rewrite it
     * @return Response Jsend::success A validation message with the id of the new Event created
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

            $validationNightTicketCat = Ticketcategorie::validate(array(
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
            //return Jsend::error($validationNight);
        }





        if (!Night::comparison_date($start_date_hour, $ending_date_hour)) {
            return Jsend::error(array('id' => "The start date is after the ending date"
                        , 'date_1' => $start_date_hour
                        , 'date_2' => $ending_date_hour));
        }



        if ($opening_doors != null) {
            
            if (!Night::comparison_date($opening_doors, $start_date_hour)) {
                return Jsend::fail("The opening door is after the start date");
            }
        }

        $all_night = Night::all();

        foreach ($all_night as $night) {
            $start_night = $night->start_date_hour;
            $end_night = $night->ending_date_hour;


            if (Night::comparison_date($start_night, $start_date_hour) && Night::comparison_date($start_date_hour, $end_night)) {
                
                return Jsend::fail("The opening door is after the start date");
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
    }

    /**
     * @ignore
     * Allows to search an event by date.
     * @param datetime date the date of the night.
     * @return Night the night conerned.
     */
    public static function searchdate($date) {


        $event = Night::Where('start_date_hour', '=', "$date")->get();


        return $event;
    }

    /**
     * Allows to export a night with filetype .docx.
     * @var date (datetime) the date of the night to export.
     * @return Response the .docx file generated.
     */
    public static function exportWord() {
        
        

        $datepublish = Input::get('date');
        
      
        

        $event = NightsController::searchdate($datepublish);
        
         

        $id = $event[0]['id'];

        $event360 = Night::with('ticketcategories', 'artists', 'image', 'nighttype')->find($id);
        
         

        $event360->artists->load('genres');

        $fileCreated = WordPublish::export($event360);

        return Response::download($fileCreated);
    }

    /**
     * Allows to export a Night to publish.
     */
    public static function exportFacebook() {
        $app = Platform::where('name', '=', 'facebook')->firstOrFail();
        $facebook = new Facebook(array(
            'appId' => $app->client_id,
            'secret' => $app->client_secret,
        ));

        $fbUser = $facebook->getUser();
    }
    
    /**
     * Allows to export an event with filetype .xml
     * exemple : api/v1/nights/toxml?date=1998-01-02%2001:01:01
     * @var date : date to night showed
     * @return Response the .xml file generated.
     */

    public static function convertXml() {
        
          
        
       // $pathsave = ('C:\night.xml'); // choose your path 

        $datepublish = Input::get('date');

        $event = NightsController::searchdate($datepublish);

        $id = $event[0]['id'];
        
        $title = $event[0]['title_de'];
        
        $date = substr($event[0]['start_date_hour'], 0, 10);
        
        $array = Night::with('ticketcategories')->with('platforms')->with('artists')->with('image')->with('printingtypes')->with('nighttype')->find($id)->toArray();
       
        // initializing or creating array
        $night = array($array);

// creating object of SimpleXMLElement
        $xml_night_info = new SimpleXMLElement("<?xml version=\"1.0\"?><event></event>");

// function call to convert array to xml
        ArrayToXml::array_to_xml($night, $xml_night_info);

        
//saving generated xml file
        $xml_night_info->asXML('public/export/'. $date .'-'.$title.'.xml');
        
        
                
       $fileCreated = 'public/export/'. $date .'-'.$title.'.xml';
        
        
     return Response::download($fileCreated);
        
        
       

// function defination to convert array to xml
    }

}
