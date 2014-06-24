<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Nighttype extends Eloquent {

	protected $table = 'nighttypes';
	public $timestamps = false;

	use SoftDeletingTrait;

	protected $dates = ['deleted_at'];

	public function events()
	{
		return $this->hasMany('Night');
	}
        
        /**
     * Cette méthode valide les types des attributs selon une liste de critères par attribut.
     * @param array $data Chaîne de caractère possèdant chaque attribut et leurs critères de validation. 
     * @return True si les données sont valides ou pas. 
     *         False si les données ne sont pas valides.
     */
	public static function validate($data = array())
    {
        return parent::validator($data, array(
            'id' => 'unsigned|sometimes|required',
            'name_de' => 'string|between:1,255|sometimes|required|unique:nighttypes',
        ));
    }

}