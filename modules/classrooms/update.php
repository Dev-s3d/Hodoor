<?php

require_once '../../includes/app.php';

clsHelper::requireRole(['admin', 'supervisor']);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    clsHelper::redirect(clsPath::classrooms() . 'index.php');
}

$id = clsHelper::post('id');
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
    clsHelper::redirect(clsPath::classrooms() . 'edit.php?id=' . urlencode($id));
}

$classroom = new clsClassroom($conn);

if (!$classroom->loadById($id)) {
    clsHelper::setMessage('error', 'الفصل غير موجود');
    clsHelper::redirect(clsPath::classrooms() . 'index.php');
}

$oldClassName = $classroom->class_name;
$oldClassCode = $classroom->class_code;

if ($classroom->classCodeExistsExceptCurrent($class_code, $id)) {
    clsHelper::setMessage('error', 'رمز الفصل مستخدم من قبل فصل آخر');
    clsHelper::redirect(clsPath::classrooms() . 'edit.php?id=' . urlencode($id));
}

$classroom->class_name = $class_name;
$classroom->class_code = $class_code;
$classroom->level_name = $level_name;

if ($classroom->update()) {

    foreach (array_keys($oldFields) as $key) {
        clsHelper::sessionRemove('old', $key);
    }

    clsHelper::setMessage('success', 'تم تحديث الفصل بنجاح');

    clsLog::add(
        $conn,
        'تعديل فصل',
        'تم تعديل الفصل: ' . $oldClassName . ' (' . $oldClassCode . ') إلى: ' . $classroom->class_name . ' (' . $classroom->class_code . ')'
    );

    clsHelper::redirect(clsPath::classrooms() . 'view.php?id=' . urlencode($classroom->id));
}

clsHelper::setMessage('error', 'حدث خطأ أثناء تحديث الفصل');
clsHelper::redirect(clsPath::classrooms() . 'edit.php?id=' . urlencode($id));