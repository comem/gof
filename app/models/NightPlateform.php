<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class NightPlatform extends MyEloquent {

	protected $table = 'night_platform';
	public $timestamps = true;

	use SoftDeletingTrait;

	protected $dates = ['deleted_at'];

    /**
     * Cette méthode valide les types des attributs selon une liste de critères par attribut.
     * @param array $data Chaîne de caractère possèdant chaque attribut et leurs critères de validation. 
     * @return True si les données sont valides ou pas. 
     *         False si les données ne sont pas valides.
     */
	public static function validate($data = array())
    {
        return parent::validator($data, array(
            'platform_id' => 'unsigned|sometimes|required',
            'event_id' => 'unsigned|sometimes|required',
            'external_id' => 'string|between:1,255|sometimes|required',
            'external_infos' => 'string|between:1,10000|sometimes',
            'url' => 'string|between:1,255|sometimes|required',
            'created_at' => 'date|sometimes|required',
            'deleted_at' => 'date|sometimes|required',
        ));
    }

    /**
     * Cette méthode vérifie l'existant de la publication selon son identifiant hybride.
     * @param int $event_id Un id technique formant la clé primaire hybride.
     * @param int $platform_id Un id technique formant la clé primaire hybride.
     * @return True si la plateforme existe.
     *         False si la plateforme n'existe pas.
     */
    public static function existTechId($night_id, $platform_id) {
        $e = NightPlatform::where('night_id', '=', $night_id)->where('platform_id', '=', $platform_id)->first();
        return $e != null;
    }

}