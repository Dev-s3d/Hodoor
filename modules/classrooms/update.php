<?php

require_once '../../includes/app.php';
clsHelper::requireRole(['admin', 'supervisor']);

// منع الوصول المباشر
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    clsHelper::redirect(clsPath::classrooms() . 'index.php');
}

// قراءة المدخلات
$id = clsHelper::post('id');
$class_name = clsHelper::post('class_name');
$class_code = clsHelper::post('class_code');
$level_name = clsHelper::post('level_name');

// حفظ القيم القديمة عند الخطأ
$_SESSION['old_class_name'] = $class_name;
$_SESSION['old_class_code'] = $class_code;
$_SESSION['old_level_name'] = $level_name;

$errors = [];

/*
|--------------------------------------------------------------------------
| التحقق من المدخلات
|--------------------------------------------------------------------------
*/
if (!clsValidator::required($id) || !clsValidator::integer($id)) {
    $errors[] = 'رقم الفصل غير صحيح';
}

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
    clsHelper::redirect(clsPath::classrooms() . 'edit.php?id=' . $id);
}

$classroom = new clsClassroom($conn);

if (!$classroom->loadById($id)) {
    clsHelper::setMessage('error', 'الفصل غير موجود');
    clsHelper::redirect(clsPath::classrooms() . 'index.php');
}

/*
|--------------------------------------------------------------------------
| التحقق من عدم تكرار رمز الفصل
|--------------------------------------------------------------------------
*/
if ($classroom->classCodeExistsExceptCurrent($class_code, $id)) {
    $errors[] = 'رمز الفصل مستخدم من قبل فصل آخر';
}

if (!empty($errors)) {
    clsHelper::setMessage('error', implode('<br>', $errors));
    clsHelper::redirect(clsPath::classrooms() . 'edit.php?id=' . $id);
}

/*
|--------------------------------------------------------------------------
| تحديث بيانات الكائن
|--------------------------------------------------------------------------
*/
$classroom->class_name = $class_name;
$classroom->class_code = $class_code;
$classroom->level_name = $level_name;

/*
|--------------------------------------------------------------------------
| حفظ التعديلات
|--------------------------------------------------------------------------
*/
if ($classroom->update()) {
    unset(
        $_SESSION['old_class_name'],
        $_SESSION['old_class_code'],
        $_SESSION['old_level_name']
    );

    clsHelper::setMessage('success', 'تم تحديث الفصل بنجاح');
    clsHelper::redirect(clsPath::classrooms() . 'index.php');
}

clsHelper::setMessage('error', 'حدث خطأ أثناء تحديث الفصل');
clsHelper::redirect(clsPath::classrooms() . 'edit.php?id=' . $id);