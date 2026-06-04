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

/*
|--------------------------------------------------------------------------
| حفظ القيم القديمة عند الخطأ
|--------------------------------------------------------------------------
*/
clsHelper::sessionSet('old', 'classroom_id', $classroom_id);
clsHelper::sessionSet('old', 'student_name', $student_name);
clsHelper::sessionSet('old', 'student_number', $student_number);
clsHelper::sessionSet('old', 'gender', $gender);
clsHelper::sessionSet('old', 'birth_date', $birth_date);
clsHelper::sessionSet('old', 'phone', $phone);
clsHelper::sessionSet('old', 'parent_name', $parent_name);
clsHelper::sessionSet('old', 'parent_phone', $parent_phone);
clsHelper::sessionSet('old', 'address', $address);
clsHelper::sessionSet('old', 'status', $status);

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

    clsHelper::sessionRemove('old', 'classroom_id');
    clsHelper::sessionRemove('old', 'student_name');
    clsHelper::sessionRemove('old', 'student_number');
    clsHelper::sessionRemove('old', 'gender');
    clsHelper::sessionRemove('old', 'birth_date');
    clsHelper::sessionRemove('old', 'phone');
    clsHelper::sessionRemove('old', 'parent_name');
    clsHelper::sessionRemove('old', 'parent_phone');
    clsHelper::sessionRemove('old', 'address');
    clsHelper::sessionRemove('old', 'status');

    clsHelper::setMessage('success', 'تم إضافة الطالب بنجاح');
    clsLog::add(
        $conn,
        'إضافة طالب',
        'تمت إضافة الطالب: ' . $student->student_name
    );
    clsHelper::redirect(clsPath::students() . 'index.php');
}

clsHelper::setMessage('error', 'حدث خطأ أثناء إضافة الطالب');
clsHelper::redirect(clsPath::students() . 'create.php');