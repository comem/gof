<?php

class MyEloquent extends Eloquent
{
    /**
     * 
     * Allows to validate data and returns an associative array with error messages for each attributes that fails the validation.
     *
     * Returns true if no errors.
     *
     * @param array data associative array with data to validate
     * @param array $rules associative array with validation rules
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