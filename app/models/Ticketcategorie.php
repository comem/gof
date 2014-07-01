<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

/**
 * Ticketcategorie model
 * 
 * Corresponds to the "ticket_categories" class of the class diagram.
 *
 * @category  Model
 * @version   1.0
 * @author    gof
 */
class Ticketcategorie extends MyEloquent {

    protected $table = 'ticketcategories';
    public $timestamps = false;

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    /**
     * Allows to define the relationship between Ticketcategorie and Night.
     * @return Night the nights of the ticketcategorie.
     */
    public function nights() {
        return $this->belongsToMany('Night');
    }

    /**
     * Allows to validate attributes for a Ticketcategorie.
     * @param array data array with every attributes that has to be validate. 
     * @return boolean|array true if the input data are valid, array with errors otherwise.
     */
    public static function validate($data = array()) {
        return parent::validator($data, array(
                    'id' => 'integer:unsigned|sometimes|required',
                    'name_de' => 'string|between:1,255|sometimes|requiered|unique:ticketcategories',
                    'deleted_at' => 'date|sometimes',
        ));
    }

    /**
     * Allows to verify if a Ticketcategorie exists in the database with his technical id.
     * @param int the technical id corresponding to the primary key of the Ticketcategorie.
     * @return boolean true if the Ticketcategorie exists in the database, false otherwise.
     */
    public static function existTechId($ticketcategorieId) {
        $e = TicketCategorie::find($ticketcategorieId);
        return $e != null;
    }

}
