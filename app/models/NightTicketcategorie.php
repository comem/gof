<?php

class NightTicketcategorie extends MyEloquent {

	protected $table = 'night_ticketcategorie';
	public $timestamps = false;

    /**
     * Cette méthode valide les types des attributs selon une liste de critères par attribut.
     * @param array $data Chaîne de caractère possèdant chaque attribut et leurs critères de validation. 
     * @return True si les données sont valides ou pas. 
     *         False si les données ne sont pas valides.
     */
	public static function validate($data = array())
    {
        return parent::validator($data, array(
            'ticketcategorie_id' => 'integer:unsigned|sometimes|required',
            'night_id' => 'integer:unsigned|sometimes|required',
            'amount' => 'integer:unsigned|sometimes|required',
            'quantity_sold' => 'integer:unsigned|sometimes',
            'comment_de' => 'string|between:1,255|sometimes',
        ));
    }
    
    /**
     * Cette méthode vérifie l'existant du ticket selon son identifiant hybride.
     * @param int $night_id Un id technique formant la clé primaire hybride.
     * @param int $ticketCat_id Un id technique formant la clé primaire hybride.
     * @return True si la plateforme existe.
     *         False si la plateforme n'existe pas.
     */
    public static function existTechId($ticketCat_id, $night_id) {
        $e = NightTicketcategorie::where('ticketcategorie_id', '=', $ticketCat_id)
                ->where('night_id', '=', $night_id)
                ->first();
        return $e != null;
    }

}