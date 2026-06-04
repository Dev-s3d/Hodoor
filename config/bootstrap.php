<?php

// تشغيل الجلسة
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__) . '/vendor/autoload.php';

define('BASE_PATH', dirname(__DIR__));

// تحميل الإعدادات
require_once BASE_PATH . '/config/config.php';
require_once BASE_PATH . '/config/constants.php';
require_once BASE_PATH . '/config/database.php';

// تحميل الكلاسات
require_once BASE_PATH . '/classes/clsDatabase.php';
require_once BASE_PATH . '/classes/clsHelper.php';
require_once BASE_PATH . '/classes/clsValidator.php';
require_once BASE_PATH . '/classes/clsUser.php';
require_once BASE_PATH . '/classes/clsStudent.php';
require_once BASE_PATH . '/classes/clsClassroom.php';
require_once BASE_PATH . '/classes/clsAttendance.php';
require_once BASE_PATH . '/classes/clsReport.php';
require_once BASE_PATH . '/classes/clsSetting.php';
require_once BASE_PATH . '/classes/clsPath.php';
require_once BASE_PATH . '/classes/clsLog.php';

// إنشاء اتصال قاعدة البيانات (اختياري)
$db = new clsDatabase();
$conn = $db->connect();