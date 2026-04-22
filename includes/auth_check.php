<?php

require_once dirname(__DIR__) . '/config/bootstrap.php';

// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    clsHelper::setMessage('error', 'يجب تسجيل الدخول أولًا');
    clsHelper::redirect(clsPath::login());
}