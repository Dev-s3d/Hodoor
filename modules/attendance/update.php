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
    clsHelper::redirect(clsPath::attendance() . 'edit.php?id=' . $id);
}

$attendance = new clsAttendance($conn);

if (!$attendance->loadById($id)) {
    clsHelper::setMessage('error', 'سجل الحضور غير موجود');
    clsHelper::redirect(clsPath::attendance() . 'history.php');
}

$attendance->attendance_date = $attendance_date;
$attendance->status = $status;
$attendance->notes = $notes;
$attendance->recorded_by = $_SESSION['user_id'];

if ($attendance->update()) {
    clsHelper::setMessage('success', 'تم تحديث سجل الحضور بنجاح');
    clsHelper::redirect(clsPath::attendance() . 'history.php');
}

clsHelper::setMessage('error', 'حدث خطأ أثناء تحديث سجل الحضور');
clsHelper::redirect(clsPath::attendance() . 'edit.php?id=' . $id);