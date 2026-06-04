<?php
require_once '../../includes/app.php';

clsHelper::requireRole(['admin', 'supervisor']);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    clsHelper::redirect(clsPath::students() . 'index.php');
}

$id = clsHelper::post('id');
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

$oldFields = [
    'classroom_id' => $classroom_id,
    'student_name' => $student_name,
    'student_number' => $student_number,
    'gender' => $gender,
    'birth_date' => $birth_date,
    'phone' => $phone,
    'parent_name' => $parent_name,
    'parent_phone' => $parent_phone,
    'address' => $address,
    'status' => $status,
];

foreach ($oldFields as $key => $value) {
    clsHelper::sessionSet('old', $key, $value);
}

$errors = [];

if (!clsValidator::required($id) || !clsValidator::integer($id)) {
    $errors[] = 'رقم الطالب غير صحيح';
}

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
    clsHelper::redirect(clsPath::students() . 'edit.php?id=' . urlencode($id));
}

$student = new clsStudent($conn);

if (!$student->loadById($id)) {
    clsHelper::setMessage('error', 'الطالب غير موجود');
    clsHelper::redirect(clsPath::students() . 'index.php');
}

$oldStudentName = $student->student_name;

if ($student->studentNumberExistsExceptCurrent($student_number, $id)) {
    clsHelper::setMessage('error', 'رقم الطالب مستخدم من قبل طالب آخر');
    clsHelper::redirect(clsPath::students() . 'edit.php?id=' . urlencode($id));
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

if ($student->update()) {

    foreach (array_keys($oldFields) as $key) {
        clsHelper::sessionRemove('old', $key);
    }

    clsHelper::setMessage('success', 'تم تحديث الطالب بنجاح');

    clsLog::add(
        $conn,
        'تعديل طالب',
        'تم تعديل بيانات الطالب: ' . $oldStudentName . ' إلى: ' . $student->student_name
    );
    
    clsHelper::redirect(clsPath::students() . 'view.php?id=' . urlencode($student->id));
}

clsHelper::setMessage('error', 'حدث خطأ أثناء تحديث الطالب');
clsHelper::redirect(clsPath::students() . 'edit.php?id=' . urlencode($id));