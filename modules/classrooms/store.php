<?php

require_once '../../includes/app.php';

clsHelper::requireRole(['admin', 'supervisor']);

// منع الوصول المباشر
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    clsHelper::redirect(clsPath::classrooms() . 'create.php');
}

// قراءة المدخلات
$class_name = clsHelper::post('class_name');
$class_code = clsHelper::post('class_code');
$level_name = clsHelper::post('level_name');

// حفظ القيم القديمة عند الخطأ
clsHelper::sessionSet('old', 'class_name', $class_name);
clsHelper::sessionSet('old', 'class_code', $class_code);
clsHelper::sessionSet('old', 'level_name', $level_name);

$errors = [];

/*
|--------------------------------------------------------------------------
| التحقق من المدخلات
|--------------------------------------------------------------------------
*/
if (!clsValidator::required($class_name)) {
    $errors[] = 'اسم الفصل مطلوب';
} elseif (!clsValidator::minLength($class_name, 2)) {
    $errors[] = 'اسم الفصل يجب أن يكون حرفين على الأقل';
}

if (!clsValidator::required($class_code)) {
    $errors[] = 'رمز الفصل مطلوب';
} elseif (!clsValidator::minLength($class_code, 2)) {
    $errors[] = 'رمز الفصل يجب أن يكون حرفين على الأقل';
}

if (!clsValidator::required($level_name)) {
    $errors[] = 'المرحلة / المستوى مطلوب';
} elseif (!clsValidator::minLength($level_name, 2)) {
    $errors[] = 'المرحلة / المستوى يجب أن تكون حرفين على الأقل';
}

if (!empty($errors)) {
    clsHelper::setMessage('error', implode('<br>', $errors));
    clsHelper::redirect(clsPath::classrooms() . 'create.php');
}

$classroom = new clsClassroom($conn);

/*
|--------------------------------------------------------------------------
| التحقق من تكرار رمز الفصل
|--------------------------------------------------------------------------
*/
if ($classroom->classCodeExists($class_code)) {
    $errors[] = 'رمز الفصل مستخدم مسبقًا';
}

if (!empty($errors)) {
    clsHelper::setMessage('error', implode('<br>', $errors));
    clsHelper::redirect(clsPath::classrooms() . 'create.php');
}

/*
|--------------------------------------------------------------------------
| تجهيز بيانات الكائن
|--------------------------------------------------------------------------
*/
$classroom->class_name = $class_name;
$classroom->class_code = $class_code;
$classroom->level_name = $level_name;

/*
|--------------------------------------------------------------------------
| حفظ البيانات
|--------------------------------------------------------------------------
*/
if ($classroom->insert()) {

    clsHelper::sessionRemove('old', 'class_name');
    clsHelper::sessionRemove('old', 'class_code');
    clsHelper::sessionRemove('old', 'level_name');

    clsHelper::setMessage('success', 'تم إضافة الفصل بنجاح');
    clsHelper::redirect(clsPath::classrooms() . 'index.php');
}

clsHelper::setMessage('error', 'حدث خطأ أثناء إضافة الفصل');
clsHelper::redirect(clsPath::classrooms() . 'create.php');