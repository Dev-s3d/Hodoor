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
    $_SESSION['old_login'] = $login;
    clsHelper::redirect(clsPath::login());
}

$user = new clsUser($conn);

if (!$user->login($login, $password)) {
    clsHelper::setMessage('error', 'بيانات الدخول غير صحيحة أو الحساب غير مفعل');
    $_SESSION['old_login'] = $login;
    clsHelper::redirect(clsPath::login());
}

$user->createSession();

if ($remember) {
    setcookie('remember_user', $user->username, time() + (86400 * 30), '/');
}

clsHelper::setMessage('success', 'مرحبًا بك في نظام Hodoor');
clsHelper::redirect(clsPath::dashboardIndex());


