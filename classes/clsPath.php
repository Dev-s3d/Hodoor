<?php

class clsPath
{
    private static $domain = "http://localhost/Hodoor/";

    public static function root()
    {
        return self::$domain;
    }

    public static function home()
    {
        return self::root() . "index.php";
    }

    public static function assets()
    {
        return self::root() . "assets/";
    }

    public static function css()
    {
        return self::assets() . "css/";
    }

    public static function js()
    {
        return self::assets() . "js/";
    }

    public static function images()
    {
        return self::assets() . "images/";
    }

    public static function uploads()
    {
        return self::assets() . "uploads/";
    }

    public static function vendors()
    {
        return self::assets() . "vendors/";
    }

    public static function bootstrapCss()
    {
        return self::vendors() . "bootstrap/css/bootstrap.rtl.min.css";
    }

    public static function bootstrapJs()
    {
        return self::vendors() . "bootstrap/js/bootstrap.bundle.min.js";
    }

    public static function fontawesome()
    {
        return self::vendors() . "fontawesome/css/all.min.css";
    }

    public static function classes()
    {
        return self::root() . "classes/";
    }

    public static function config()
    {
        return self::root() . "config/";
    }

    public static function database()
    {
        return self::root() . "database/";
    }

    public static function docs()
    {
        return self::root() . "docs/";
    }

    public static function includes()
    {
        return self::root() . "includes/";
    }

    public static function modules()
    {
        return self::root() . "modules/";
    }

    public static function auth()
    {
        return self::modules() . "auth/";
    }

    public static function dashboard()
    {
        return self::modules() . "dashboard/";
    }

    public static function users()
    {
        return self::modules() . "users/";
    }

    public static function classrooms()
    {
        return self::modules() . "classrooms/";
    }

    public static function students()
    {
        return self::modules() . "students/";
    }

    public static function attendance()
    {
        return self::modules() . "attendance/";
    }

    public static function reports()
    {
        return self::modules() . "reports/";
    }

    public static function settings()
    {
        return self::modules() . "settings/";
    }

    public static function login()
    {
        return self::auth() . "login.php";
    }

    public static function loginAction()
    {
        return self::auth() . "login_action.php";
    }

    public static function logout()
    {
        return self::auth() . "logout.php";
    }

    public static function dashboardIndex()
    {
        return self::dashboard() . "index.php";
    }

    public static function routes()
    {
        return self::root() . "routes/";
    }

    public static function storage()
    {
        return self::root() . "storage/";
    }

    public static function templates()
    {
        return self::root() . "templates/";
    }

    public static function profile()
    {
        return self::users() . "profile.php";
    }

    public static function editProfile()
    {
        return self::users() . "edit_profile.php";
    }

    public static function changePassword()
    {
        return self::users() . "change_password.php";
    }

    public static function changePasswordAction()
    {
        return self::users() . "change_password_action.php";
    }

    public static function profileUpdate()
    {
        return self::users() . "profile_update.php";
    }
}