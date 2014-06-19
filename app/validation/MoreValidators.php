<?php
use Illuminate\Validation\Validator;

class MoreValidators extends Validator {

    public function validateString($attribute, $value, $parameters)
    {
        return is_string($value);
    }

    public function validateUnsigned($attribute, $value, $parameters)
    {
        return is_int($value) && $value >= 0;
    }

}