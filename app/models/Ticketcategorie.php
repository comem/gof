<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TicketCategorie extends MyEloquent {

	protected $table = 'ticketcategories';
	public $timestamps = false;

	use SoftDeletingTrait;

	protected $dates = ['deleted_at'];

	/**
     * Cette méthode permet de lier la catégorie de ticket à un event'
     * @return L'event à qui correspond la catégorie de ticket.
     */
	public function events()
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
            'id' => 'unsigned|sometimes|required',
            'name_de' => 'string|between:1,255|sometimes|requiered|unique:ticketcategories',
            'deleted_at' => 'date|sometimes',
        ));
    }

    /**
     * Cette méthode vérifie l'existant de la catégorie de ticket selon son identifiant technique.
     * @param Un identifiant technique correspondant à la clé primaire de la catégorie. 
     * @return True si la catégorie existe.
     *         False si la catégorie n'existe pas.
     */
    public static function existTechId($ticketcategorieId) {
        $e = TicketCategorie::find($ticketcategorieId);
        return $e != null;
    }

}