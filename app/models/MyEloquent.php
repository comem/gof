<?php

class MyEloquent extends Eloquent
{
    /**
     * Valide les données et retourne un tableau associatif des messages
     * d'erreurs indicés par les attributs erronés
     *
     * Retourne true si aucune erreur.
     *
     * @param array $data tableau associatif des valeurs à valider
     * @param array $rules tableau associatif des règles de validation
     * @return boolean|array
     */
    protected static function validator($data, $rules = array()) {
        $validator = Validator::make($data, $rules);
        if (!$validator->fails()) {
            return true;
        }
        $messages = $validator->messages();
        $errors = array();
        foreach ($rules as $key => $value) {
            if ($messages->has($key)) {
                $errors[$key] = implode(' ', $messages->get($key));
            }
        }
        return  $errors;
    }

}