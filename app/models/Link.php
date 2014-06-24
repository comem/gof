<?php

class Link extends MyEloquent {

	protected $table = 'links';
	public $timestamps = false;

    /**
     * Cette méthode permet de lier le lien à un artiste
     * @return L'artiste à qui appartient ce lien.
     */
	public function artist()
	{
		return $this->belongsTo('Artist');
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
            'url' => 'string|between:1,255|sometimes|required|unique:links',
            'name_de' => 'string|between:1,255|sometimes|required',
            'title_de' => 'string|between:1,255|sometimes',
            'artist_id' => 'integer:unsigned|sometimes|required',
        ));
    }

    /**
     * Cette méthode vérifie l'existant du lien selon son identifiant technique.
     * @param Un identifiant technique correspondant à la clé primaire de lien. 
     * @return True si le lien existe.
     *         False si le lien n'existe pas.
     */
    public static function existTechId($linkId) {
        $e = Link::find($linkId);
        return $e != null;
    }

    /**
     * Cette méthode vérifie l'existant du lien selon son identifiant métier.
     * @param Un identifiant méditer correspondant à un attribut unique.
     * @return True si le lien existe.
     *         False si le lien n'existe pas.
     */
    public static function existBusinessId($linkUrl) {
        $e = Link::where('url','=',$linkUrl)->first();
        return $e != null;
    }

}