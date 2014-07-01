<?php

/**
 * NightTicketcategorie model
 * 
 * Corresponds to the "tickets" class of the class diagram.
 *
 * @category  Model
 * @version   1.0
 * @author    gof
 */
class NightTicketcategorie extends MyEloquent {

    protected $table = 'night_ticketcategorie';
    public $timestamps = false;

    /**
     * Allows to validate attributes for a NightTicketcategorie.
     * @param array data array with every attributes that has to be validate. 
     * @return boolean|array true if the input data are valid, array with errors otherwise.
     */
    public static function validate($data = array()) {
        return parent::validator($data, array(
                    'ticketcategorie_id' => 'integer:unsigned|sometimes|required',
                    'night_id' => 'integer:unsigned|sometimes|required',
                    'amount' => 'integer:unsigned|sometimes|required',
                    'quantity_sold' => 'integer:unsigned|sometimes',
                    'comment_de' => 'string|between:1,255|sometimes',
        ));
    }

    /**
     * Allows to verify if a NightTicketcategorie exists in the database with his technical id.
     * @param int the technical id of ticketcategorie corresponding to the composite primary key of the NightTicketcategorie.
     * @param int the technical id of night corresponding to the composite primary key of the NightTicketcategorie.
     * @return boolean true if the Night exists in the database, false otherwise.
     */
    public static function existTechId($ticketCat_id, $night_id) {
        $e = NightTicketcategorie::where('ticketcategorie_id', '=', $ticketCat_id)
                ->where('night_id', '=', $night_id)
                ->first();
        return $e != null;
    }

}
