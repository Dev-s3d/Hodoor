<?php

require_once '../../config/bootstrap.php';

// تفريغ الجلسة
$_SESSION = [];

// تدمير الجلسة
session_destroy();

// حذف كوكي "تذكرني"
//if (isset($_COOKIE['remember_user'])) {
//    setcookie('remember_user', '', time() - 3600, '/');
//    unset($_COOKIE['remember_user']);
//}

// إنشاء Session جديدة (حماية إضافية)
session_start();
session_regenerate_id(true);

// رسالة خروج (اختياري)
clsHelper::setMessage('success', 'تم تسجيل الخروج بنجاح');

// إعادة التوجيه
clsHelper::redirect(clsPath::login());

