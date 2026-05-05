<?php

require_once '../../includes/app.php';
clsHelper::requireRole(['admin', 'supervisor']);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    clsHelper::redirect(clsPath::students() . 'create.php');
}

$classroom_id = clsHelper::post('classroom_id');
$student_name = clsHelper::post('student_name');
$student_number = clsHelper::post('student_number');
$gender = clsHelper::post('gender', 'male');
$birth_date = clsHelper::post('birth_date');
$phone = clsHelper::post('phone');
$parent_name = clsHelper::post('parent_name');
$parent_phone = clsHelper::post('parent_phone');
$address = clsHelper::post('address');
$status = clsHelper::post('status', '1');

$_SESSION['old_classroom_id'] = $classroom_id;
$_SESSION['old_student_name'] = $student_name;
$_SESSION['old_student_number'] = $student_number;
$_SESSION['old_gender'] = $gender;
$_SESSION['old_birth_date'] = $birth_date;
$_SESSION['old_phone'] = $phone;
$_SESSION['old_parent_name'] = $parent_name;
$_SESSION['old_parent_phone'] = $parent_phone;
$_SESSION['old_address'] = $address;
$_SESSION['old_status'] = $status;

$errors = [];

if (!clsValidator::required($classroom_id) || !clsValidator::integer($classroom_id)) {
    $errors[] = 'الفصل مطلوب';
}

if (!clsValidator::required($student_name)) {
    $errors[] = 'اسم الطالب مطلوب';
} elseif (!clsValidator::minLength($student_name, 3)) {
    $errors[] = 'اسم الطالب يجب أن يكون 3 أحرف على الأقل';
}

if (!clsValidator::required($student_number)) {
    $errors[] = 'رقم الطالب مطلوب';
}

if (!clsValidator::in($gender, ['male', 'female'])) {
    $errors[] = 'قيمة الجنس غير صحيحة';
}

if (!empty($birth_date) && !clsValidator::date($birth_date)) {
    $errors[] = 'تاريخ الميلاد غير صحيح';
}

if (!clsValidator::in($status, ['0', '1', 0, 1])) {
    $errors[] = 'الحالة المحددة غير صحيحة';
}

if (!empty($errors)) {
    clsHelper::setMessage('error', implode('<br>', $errors));
    clsHelper::redirect(clsPath::students() . 'create.php');
}

$student = new clsStudent($conn);

if ($student->studentNumberExists($student_number)) {
    $errors[] = 'رقم الطالب مستخدم مسبقًا';
}

if (!empty($errors)) {
    clsHelper::setMessage('error', implode('<br>', $errors));
    clsHelper::redirect(clsPath::students() . 'create.php');
}

$student->classroom_id = (int)$classroom_id;
$student->student_name = $student_name;
$student->student_number = $student_number;
$student->gender = $gender;
$student->birth_date = !empty($birth_date) ? $birth_date : null;
$student->phone = $phone;
$student->parent_name = $parent_name;
$student->parent_phone = $parent_phone;
$student->address = $address;
$student->status = (int)$status;

if ($student->insert()) {
    unset(
        $_SESSION['old_classroom_id'],
        $_SESSION['old_student_name'],
        $_SESSION['old_student_number'],
        $_SESSION['old_gender'],
        $_SESSION['old_birth_date'],
        $_SESSION['old_phone'],
        $_SESSION['old_parent_name'],
        $_SESSION['old_parent_phone'],
        $_SESSION['old_address'],
        $_SESSION['old_status']
    );

    clsHelper::setMessage('success', 'تم إضافة الطالب بنجاح');
    clsHelper::redirect(clsPath::students() . 'index.php');
}

clsHelper::setMessage('error', 'حدث خطأ أثناء إضافة الطالب');
clsHelper::redirect(clsPath::students() . 'create.php');