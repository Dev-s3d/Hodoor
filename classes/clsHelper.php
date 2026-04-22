<?php

class clsHelper
{
    /*
    |--------------------------------------------------------------------------
    | Password
    |--------------------------------------------------------------------------
    */

    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function verifyPassword($password, $hashedPassword)
    {
        return password_verify($password, $hashedPassword);
    }

    /*
    |--------------------------------------------------------------------------
    | Clean / Escape
    |--------------------------------------------------------------------------
    */

    public static function clean($value)
    {
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }

    public static function e($value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    /*
    |--------------------------------------------------------------------------
    | GET / POST
    |--------------------------------------------------------------------------
    */

    public static function post($key, $default = null)
    {
        return isset($_POST[$key]) ? self::clean($_POST[$key]) : $default;
    }

    public static function get($key, $default = null)
    {
        return isset($_GET[$key]) ? self::clean($_GET[$key]) : $default;
    }

    /*
    |--------------------------------------------------------------------------
    | Old Input (for forms)
    |--------------------------------------------------------------------------
    */

    public static function old($key, $default = '')
    {
        if (isset($_SESSION['old'][$key])) {
            return self::e($_SESSION['old'][$key]);
        }

        return self::e($default);
    }

    /*
    |--------------------------------------------------------------------------
    | Redirect
    |--------------------------------------------------------------------------
    */

    public static function redirect($path)
    {
        header("Location: $path");
        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | Flash Messages
    |--------------------------------------------------------------------------
    */

    public static function setMessage($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function getMessage($key)
    {
        if (isset($_SESSION[$key])) {
            $value = $_SESSION[$key];
            unset($_SESSION[$key]);
            return $value;
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Date Helpers
    |--------------------------------------------------------------------------
    */

    public static function now()
    {
        return date('Y-m-d H:i:s');
    }

    public static function today()
    {
        return date('Y-m-d');
    }

    /*
    |--------------------------------------------------------------------------
    | Random String
    |--------------------------------------------------------------------------
    */

    public static function random($length = 10)
    {
        return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
    }

    /*
    |--------------------------------------------------------------------------
    | Debug
    |--------------------------------------------------------------------------
    */

    public static function dd($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        die();
    }

    /*
    |--------------------------------------------------------------------------
    | datetime
    |--------------------------------------------------------------------------
    */

    public static function dateOnly($datetime)
    {
        // إذا القيمة فارغة
        if (empty($datetime)) {
            return '';
        }

        // تحويل النص إلى timestamp ثم إخراج التاريخ فقط
        return date('Y-m-d', strtotime($datetime));
    }
}