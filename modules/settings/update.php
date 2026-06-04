<?php

require_once '../../includes/app.php';

clsHelper::requireRole(['admin']);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    clsHelper::redirect(clsPath::settings() . 'index.php');
}

$form_type = clsHelper::post('form_type');

$setting = new clsSetting($conn);

if ($form_type === 'school_info') {

    $school_name = clsHelper::post('school_name');
    $school_phone = clsHelper::post('school_phone');
    $school_email = clsHelper::post('school_email');
    $school_address = clsHelper::post('school_address');

    if (!clsValidator::required($school_name)) {
        clsHelper::setMessage('error', 'اسم المدرسة مطلوب');
        clsHelper::redirect(clsPath::settings() . 'school_info.php');
    }

    if (!empty($school_email) && !clsValidator::email($school_email)) {
        clsHelper::setMessage('error', 'البريد الإلكتروني غير صحيح');
        clsHelper::redirect(clsPath::settings() . 'school_info.php');
    }

    $setting->set('school_name', $school_name);
    $setting->set('school_phone', $school_phone);
    $setting->set('school_email', $school_email);
    $setting->set('school_address', $school_address);

    clsHelper::setMessage('success', 'تم تحديث معلومات المدرسة بنجاح');

    clsLog::add(
        $conn,
        'تعديل الإعدادات',
        'تم تعديل معلومات المدرسة'
    );

    clsHelper::redirect(clsPath::settings() . 'school_info.php');
}

if ($form_type === 'general') {

    $system_name = clsHelper::post('system_name');
    $academic_year = clsHelper::post('academic_year');
    $default_lang = clsHelper::post('default_lang');

    if (!clsValidator::required($system_name)) {
        clsHelper::setMessage('error', 'اسم النظام مطلوب');
        clsHelper::redirect(clsPath::settings() . 'general.php');
    }

    if (!clsValidator::required($academic_year)) {
        clsHelper::setMessage('error', 'السنة الدراسية مطلوبة');
        clsHelper::redirect(clsPath::settings() . 'general.php');
    }

    if (!clsValidator::in($default_lang, ['ar', 'en'])) {
        clsHelper::setMessage('error', 'اللغة المحددة غير صحيحة');
        clsHelper::redirect(clsPath::settings() . 'general.php');
    }

    $setting->set('system_name', $system_name);
    $setting->set('academic_year', $academic_year);
    $setting->set('default_lang', $default_lang);

    clsHelper::setMessage('success', 'تم تحديث الإعدادات العامة بنجاح');

    clsLog::add(
        $conn,
        'تعديل الإعدادات',
        'تم تعديل الإعدادات العامة'
    );

    clsHelper::redirect(clsPath::settings() . 'general.php');
}

if ($form_type === 'attendance_status') {

    $enable_present = isset($_POST['enable_present']) ? '1' : '0';
    $enable_absent = isset($_POST['enable_absent']) ? '1' : '0';
    $enable_late = isset($_POST['enable_late']) ? '1' : '0';
    $enable_excused = isset($_POST['enable_excused']) ? '1' : '0';

    $setting->set('enable_present', $enable_present);
    $setting->set('enable_absent', $enable_absent);
    $setting->set('enable_late', $enable_late);
    $setting->set('enable_excused', $enable_excused);

    clsHelper::setMessage('success', 'تم تحديث إعدادات الحضور بنجاح');

    clsLog::add(
        $conn,
        'تعديل الإعدادات',
        'تم تعديل إعدادات الحضور'
    );

    clsHelper::redirect(clsPath::settings() . 'attendance_status.php');
}

clsHelper::setMessage('error', 'نوع الإعداد غير صحيح');
clsHelper::redirect(clsPath::settings() . 'index.php');