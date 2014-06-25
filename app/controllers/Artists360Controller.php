<?php

class Artists360Controller extends \BaseController {

    /**
     * 
     * @return type
     */
    public function index() {
        return Jsend::success(Artist::with('musicians')->with('links')->with('genres')->with('images')->join('artist_musician', 'artists.id', '=', 'artist_musician.artist_id' )->join('instruments', 'instruments.id', '=', 'artist_musician.instrument_id')->get());     
    }
   

    

}
