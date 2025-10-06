<?php

namespace App\Helpers;

class Validator
{
    public static function validateNombre(string $nombre): bool
    {
        if (trim($nombre) === '') {
            return false;
        }
        return preg_match('/^[\p{L} ]+$/u', $nombre);
    }

    public static function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}