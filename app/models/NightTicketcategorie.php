<?php

class NightTicketcategorie extends MyEloquent {

	protected $table = 'night_ticketcategorie';
	public $timestamps = false;

	public static function validate($data = array())
    {
        return parent::validator($data, array(
            'ticketcategorie_id' => 'integer:unsigned|sometimes|required',
            'night_id' => 'integer:unsigned|sometimes|required',
            'amount' => 'integer:unsigned|sometimes|required',
            'quantity_sold' => 'integer:unsigned|sometimes',
            'comment' => 'string|between:1,255|sometimes',
        ));
    }
    
    public static function existTechId($ticketCatId, $nightId) {
        $e = NightTicketcategorie::where('ticketcategorie_id', '=', $ticketCatId)
                ->where('night_id', '=', $nightId)
                ->first();
        return $e != null;
    }

}