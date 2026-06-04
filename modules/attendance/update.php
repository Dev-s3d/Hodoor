<?php

require_once '../../includes/app.php';

clsHelper::requireRole(['admin', 'supervisor', 'teacher']);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    clsHelper::redirect(clsPath::attendance() . 'history.php');
}

$id = clsHelper::post('id');
$attendance_date = clsHelper::post('attendance_date');
$status = clsHelper::post('status');
$notes = clsHelper::post('notes');

$errors = [];

if (!clsValidator::required($id) || !clsValidator::integer($id)) {
    $errors[] = 'رقم السجل غير صحيح';
}

if (!clsValidator::required($attendance_date) || !clsValidator::date($attendance_date)) {
    $errors[] = 'التاريخ غير صحيح';
}

$settingObj = new clsSetting($conn);

if (!$settingObj->isAttendanceStatusActive($status)) {
    $errors[] = 'حالة الحضور المحددة غير مفعلة من الإعدادات';
}

if (!empty($errors)) {
    clsHelper::setMessage('error', implode('<br>', $errors));
    clsHelper::redirect(clsPath::attendance() . 'edit.php?id=' . urlencode($id));
}

$attendance = new clsAttendance($conn);

if (!$attendance->loadById($id)) {
    clsHelper::setMessage('error', 'سجل الحضور غير موجود');
    clsHelper::redirect(clsPath::attendance() . 'history.php');
}

$oldStatus = $attendance->status;
$oldDate = $attendance->attendance_date;

$studentObj = new clsStudent($conn);

if (!$studentObj->loadById($attendance->student_id)) {
    clsHelper::setMessage('error', 'الطالب غير موجود');
    clsHelper::redirect(clsPath::attendance() . 'index.php');
}

$classroomObj = new clsClassroom($conn);
$className = '-';

if (!empty($attendance->classroom_id) && $classroomObj->loadById($attendance->classroom_id)) {
    $className = $classroomObj->class_name;
}

$attendance->attendance_date = $attendance_date;
$attendance->status = $status;
$attendance->notes = $notes;
$attendance->recorded_by = clsHelper::auth('user_id');

if ($attendance->update()) {
    clsHelper::setMessage('success', 'تم تحديث سجل الحضور بنجاح');

    clsLog::add(
        $conn,
        'تعديل حضور',
        'تم تعديل حضور الطالب: '
        . $studentObj->student_name
        . ' - الفصل: '
        . $className
        . ' - من: '
        . clsHelper::attendanceStatus($oldStatus)
        . ' بتاريخ '
        . $oldDate
        . ' إلى: '
        . clsHelper::attendanceStatus($status)
        . ' بتاريخ '
        . $attendance_date
    );

    clsHelper::redirect(clsPath::attendance() . 'history.php');
}

clsHelper::setMessage('error', 'حدث خطأ أثناء تحديث سجل الحضور');
clsHelper::redirect(clsPath::attendance() . 'edit.php?id=' . urlencode($id));