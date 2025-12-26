<?php
namespace App\Utils;

class Validator {
    public static function string($v, $min = 2) {
        return strlen(trim($v)) >= $min;
    }

    public static function email($v) {
        return filter_var($v, FILTER_VALIDATE_EMAIL);
    }
}
