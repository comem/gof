<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Image extends MyEloquent {

    protected $table = 'images';
    public $timestamps = true;

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    /**
     * Cette méthode permet de lier l'image à un événement (soirée).
     * @return La soirée à ui est liée à cette image.
     */
    public function nights() {
        return $this->hasMany('Night');
    }

    public function artist() {
        return $this->belongsTo('Artist');
    }

    /**
     * Cette méthode valide les types des attributs selon une liste de critères par attribut.
     * @param array $data Chaîne de caractère possèdant chaque attribut et leurs critères de validation. 
     * @return True si les données sont valides ou pas. 
     *         False si les données ne sont pas valides.
     */
    public static function validate($data = array()) {
        return parent::validator($data, array(
                    'id' => 'integer:unsigned|sometimes|required',
                    'alt_de' => 'string|between:1,255|sometimes',
                    'caption_de' => 'string|between:1,255|sometimes',
                    'source' => 'string|between:1,255|sometimes|required',
                    'created_at' => 'date|sometimes|required',
                    'updated_at' => 'date|sometimes|required',
                    'deleted_at' => 'date|sometimes',
                    'artist_id' => 'integer:unsigned|sometimes',
        ));
    }

    /**
     * Cette méthode vérifie l'existant de l'image selon son identifiant technique.
     * @param Un identifiant technique correspondant à la clé primaire de l'image.
     * @return True si l'mage existe.
     *         False si l'image n'existe pas.
     */
    public static function existTechId($imageId) {
        $e = Image::find($imageId);
        return $e != null;
    }

}
