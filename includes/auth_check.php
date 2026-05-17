<?php

require_once dirname(__DIR__) . '/config/bootstrap.php';

/*
|--------------------------------------------------------------------------
| التحقق من تسجيل الدخول
|--------------------------------------------------------------------------
*/

if (empty(clsHelper::auth('user_id'))) {

    clsHelper::setMessage(
        'error',
        'يرجى تسجيل الدخول أولاً'
    );

    clsHelper::redirect(
        clsPath::login()
    );
}