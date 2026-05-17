<?php

require_once '../../config/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    clsHelper::redirect(clsPath::login());
}

$login = clsHelper::post('login');
$password = clsHelper::post('password');
$remember = isset($_POST['remember']);

if (empty($login) || empty($password)) {
    clsHelper::setMessage('error', 'جميع الحقول مطلوبة');
    clsHelper::sessionSet('old', 'login', $login);
    clsHelper::redirect(clsPath::login());
}

$user = new clsUser($conn);

if (!$user->login($login, $password)) {
    clsHelper::setMessage('error', 'بيانات الدخول غير صحيحة');
    clsHelper::sessionSet('old', 'login', $login);
    clsHelper::redirect(clsPath::login());
}

if (!$user->isActive()) {
    clsHelper::setMessage('warning', 'الحساب غير مفعل');
    clsHelper::sessionSet('old', 'login', $login);
    clsHelper::redirect(clsPath::login());
}

$user->createSession();

clsHelper::sessionRemove('old', 'login');

if ($remember) {
    setcookie('remember_user', $user->username, time() + (86400 * 30), '/');
} else {
    setcookie('remember_user', '', time() - 3600, '/');
    unset($_COOKIE['remember_user']);
}

if (clsHelper::isTeacher()) {
    clsHelper::redirect(clsPath::attendance() . 'index.php');
}

clsHelper::setMessage('success', 'مرحبًا بك في نظام Hodoor');
clsHelper::redirect(clsPath::dashboardIndex());