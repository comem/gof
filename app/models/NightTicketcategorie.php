<?php

class NightTicketcategorie extends MyEloquent {

	protected $table = 'night_ticketcategorie';
	public $timestamps = false;

	public static function validate($data = array())
    {
        return parent::validator($data, array(
            'ticketcategorie_id' => 'unsigned|sometimes|required',
            'night_id' => 'unsigned|sometimes|required',
            'amount' => 'unsigned|sometimes|required',
            'quantity_sold' => 'unsigned|sometimes',
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