<?php

class clsValidator
{
    /*
    |--------------------------------------------------------------------------
    | Required
    |--------------------------------------------------------------------------
    */

    public static function required($value)
    {
        return !empty(trim($value));
    }

    /*
    |--------------------------------------------------------------------------
    | Length
    |--------------------------------------------------------------------------
    */

    public static function minLength($value, $length)
    {
        return strlen($value) >= $length;
    }

    public static function maxLength($value, $length)
    {
        return strlen($value) <= $length;
    }

    /*
    |--------------------------------------------------------------------------
    | Email
    |--------------------------------------------------------------------------
    */

    public static function email($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    /*
    |--------------------------------------------------------------------------
    | Numbers
    |--------------------------------------------------------------------------
    */

    public static function number($value)
    {
        return is_numeric($value);
    }

    public static function integer($value)
    {
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

    /*
    |--------------------------------------------------------------------------
    | Match (password confirm)
    |--------------------------------------------------------------------------
    */

    public static function match($value1, $value2)
    {
        return $value1 === $value2;
    }

    /*
    |--------------------------------------------------------------------------
    | In Array
    |--------------------------------------------------------------------------
    */

    public static function in($value, $array)
    {
        return in_array($value, $array);
    }

    /*
    |--------------------------------------------------------------------------
    | Date
    |--------------------------------------------------------------------------
    */

    public static function date($value)
    {
        return strtotime($value) !== false;
    }

    /*
    |--------------------------------------------------------------------------
    | Password Strength (basic)
    |--------------------------------------------------------------------------
    */

    public static function password($value)
    {
        return strlen($value) >= 6;
    }

    /*
    |--------------------------------------------------------------------------
    | File Validation
    |--------------------------------------------------------------------------
    */

    public static function fileRequired($file)
    {
        return isset($file) && $file['error'] === 0;
    }

    public static function fileType($file, $allowedTypes = [])
    {
        return in_array($file['type'], $allowedTypes);
    }

    public static function fileSize($file, $maxSize)
    {
        return $file['size'] <= $maxSize;
    }
}