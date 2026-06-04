<?php

require_once '../../includes/app.php';
clsHelper::requireRole(['admin', 'supervisor', 'teacher']);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    clsHelper::redirect(clsPath::attendance() . 'index.php');
}

$classroom_id = clsHelper::post('classroom_id');
$attendance_date = clsHelper::post('attendance_date');
$student_ids = $_POST['student_ids'] ?? [];
$statuses = $_POST['statuses'] ?? [];
$notes = $_POST['notes'] ?? [];

$settingObj = new clsSetting($conn);
$activeStatuses = $settingObj->getActiveAttendanceStatuses();
$allowedStatuses = array_keys($activeStatuses);

$classroomObj = new clsClassroom($conn);
if (!$classroomObj->loadById($classroom_id)) {
    clsHelper::setMessage('error', 'الفصل غير موجود');
    clsHelper::redirect(clsPath::attendance() . 'index.php');
}

$errors = [];

if (!clsValidator::required($classroom_id) || !clsValidator::integer($classroom_id)) {
    $errors[] = 'الفصل غير صحيح';
}

if (!clsValidator::required($attendance_date) || !clsValidator::date($attendance_date)) {
    $errors[] = 'التاريخ غير صحيح';
}

if (empty($student_ids) || !is_array($student_ids)) {
    $errors[] = 'لا يوجد طلاب للحفظ';
}

if (empty($allowedStatuses)) {
    $errors[] = 'لا توجد حالات حضور مفعلة';
}

if (!empty($errors)) {
    clsHelper::setMessage('error', implode('<br>', $errors));
    clsHelper::redirect(clsPath::attendance() . 'index.php');
}

$attendance = new clsAttendance($conn);

foreach ($student_ids as $student_id) {
    $student_id = (int)$student_id;

    $status = $statuses[$student_id] ?? ($allowedStatuses[0] ?? 'present');
    $note = $notes[$student_id] ?? '';

    if (!in_array($status, $allowedStatuses)) {
        $status = $allowedStatuses[0];
    }

    $attendance->id = null;
    $attendance->student_id = $student_id;
    $attendance->classroom_id = (int)$classroom_id;
    $attendance->attendance_date = $attendance_date;
    $attendance->status = $status;
    $attendance->notes = $note;
    $attendance->recorded_by = clsHelper::auth('user_id');

    $attendance->saveOrUpdate();
}

clsHelper::setMessage('success', 'تم حفظ الحضور بنجاح');
clsLog::add(
    $conn,
    'تحضير جديد',
    'تم تسجيل حضور الفصل: ' . $classroomObj->class_name . ' - التاريخ: ' . $attendance_date . ' - عدد الطلاب: ' . count($student_ids)
);
clsHelper::redirect(
    clsPath::attendance() . 'daily.php?attendance_date=' . urlencode($attendance_date) . '&classroom_id=' . urlencode($classroom_id)
);