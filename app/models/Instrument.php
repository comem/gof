<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Instrument extends MyEloquent {

	protected $table = 'instruments';
	public $timestamps = false;

	use SoftDeletingTrait;

	protected $dates = ['deleted_at'];

	public function artist_musicians()
	{
		return $this->hasMany('ArtistMusician');
	}

	public static function validate($data = array())
    {
           
        return parent::validator($data, array(
            'id' => 'unsigned|sometimes|required',
            'name_de' => 'string|between:1,255|sometimes|required|unique:instruments',
            'created_at' => 'date|sometimes|required',
            'updated_at' => 'date|sometimes|required',
            'deleted_at' => 'date|sometimes',
        ));
    }
    
    /**
     * 
     * @param type $buisness_id identifiant metier de la table instrument
     * @return type retourne true or false si l'artiste existe ou non
     */
    
     public static function existBuisnessId($buisness_id){
        $e = Instrument::where('name_de', '=', $buisness_id)
            ->first();
        return $e != null;       // Si null, n’existe pas 
    }
    
     public static function existTechId($tech_id){
        $e = Instrument::where('id', '=', $tech_id)
            ->first();
        return $e != null;       // Si null, n’existe pas 
    }
}