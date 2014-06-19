<?php

class InstrumentsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Auth
            
            return  Jsend::success(Instrument::all()->toArray());
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Auth
        $instrument = Input::get('name_de');   
        $validationInstrum = Message::validate(array('instrument' => $instrument));
         
        if ($validationInstrum !== true) {
            return Jsend::fail($validationInstrum);
        }
        // Tout est ok, on sauve le message avec l'id du user connecté
        $newinstrument = new Instrument();
        $newinstrument->name_de = $instrument['name_de'];
        $newinstrument->save();
        
    
        // Et on retourne l'id du message nouvellement créé (encapsulé en JSEND)
        return Jsend::success(array('name_de' => $newinstrument->name_de));
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
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
