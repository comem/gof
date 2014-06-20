<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TicketCategorie extends MyEloquent {

	protected $table = 'ticketcategories';
	public $timestamps = false;

	use SoftDeletingTrait;

	protected $dates = ['deleted_at'];

	public function events()
	{
		return $this->belongsToMany('Night');
	}

	public static function validate($data = array())
    {
        return parent::validator($data, array(
            'id' => 'unsigned|sometimes|required',
            'name_de' => 'string|between:1,255|sometimes|requiered|unique:ticketcategories',
            'deleted_at' => 'date|sometimes',
        ));
    }

    public static function existTechId($ticketcategorieId) {
        $e = TicketCategorie::find($ticketcategorieId);
        return $e != null;
    }

}