<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Platform extends MyEloquent {

	protected $table = 'platforms';
	public $timestamps = false;

	use SoftDeletingTrait;

	protected $dates = ['deleted_at'];
	protected $hidden = array('softDeletes');

    /**
     * Cette méthode permet de lier la plateforme à un event.
     * @return L'event à qui correspond la plateforme.
     */
	public function nights()
	{
		return $this->belongsToMany('Night');
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
            'id' => 'integer:unsigned|sometimes|required',
            'name' => 'string|between:1,255|sometimes|requiered|unique:platforms',
            'client_id' => 'string|between:1,255|sometimes',
            'client_secret' => 'string|between:1,255|sometimes',
            'api_infos' => 'string|between:1,10000|sometimes',
            'deleted_at' => 'date|sometimes',
        ));
    }

    /**
     * Cette méthode vérifie l'existant de la plateforme selon son identifiant technique.
     * @param Un identifiant technique correspondant à la clé primaire de la plateforme. 
     * @return True si la plateforme existe.
     *         False si la plateforme n'existe pas.
     */
    public static function existTechId($platformId) {
        $e = Platform::find($platformId);
        return $e != null;
    }

    /**
     * Cette méthode vérifie l'existant de la plateforme selon son identifiant métier.
     * @param Un identifiant méditer correspondant à un attribut unique.
     * @return True si la plateforme existe.
     *         False si la plateforme n'existe pas.
     */
    public static function existBusinessId($platformName) {
        $e = Platform::where('name','=',$platformName)->first();
        return $e != null;
    }

}