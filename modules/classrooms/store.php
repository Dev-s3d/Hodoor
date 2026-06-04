<?php

require_once '../../includes/app.php';

clsHelper::requireRole(['admin', 'supervisor']);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    clsHelper::redirect(clsPath::classrooms() . 'create.php');
}

$class_name = clsHelper::post('class_name');
$class_code = clsHelper::post('class_code');
$level_name = clsHelper::post('level_name');

$oldFields = [
    'class_name' => $class_name,
    'class_code' => $class_code,
    'level_name' => $level_name,
];

foreach ($oldFields as $key => $value) {
    clsHelper::sessionSet('old', $key, $value);
}

$errors = [];

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

if ($classroom->classCodeExists($class_code)) {
    clsHelper::setMessage('error', 'رمز الفصل مستخدم مسبقًا');
    clsHelper::redirect(clsPath::classrooms() . 'create.php');
}

$classroom->class_name = $class_name;
$classroom->class_code = $class_code;
$classroom->level_name = $level_name;

if ($classroom->insert()) {

    foreach (array_keys($oldFields) as $key) {
        clsHelper::sessionRemove('old', $key);
    }

    clsHelper::setMessage('success', 'تم إضافة الفصل بنجاح');

    clsLog::add(
        $conn,
        'إضافة فصل',
        'تمت إضافة الفصل: ' . $classroom->class_name . ' - الرمز: ' . $classroom->class_code
    );

    clsHelper::redirect(clsPath::classrooms() . 'view.php?id=' . urlencode($classroom->id));
}

clsHelper::setMessage('error', 'حدث خطأ أثناء إضافة الفصل');
clsHelper::redirect(clsPath::classrooms() . 'create.php');