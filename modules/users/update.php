<?php

require_once '../../includes/app.php';

clsHelper::requireRole(['admin']);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    clsHelper::redirect(clsPath::users() . 'index.php');
}

$id = clsHelper::post('id');
$full_name = clsHelper::post('full_name');
$username = clsHelper::post('username');
$email = clsHelper::post('email');
$role = clsHelper::post('role');
$status = clsHelper::post('status', '1');
$password = clsHelper::post('password');
$confirm_password = clsHelper::post('confirm_password');

$oldFields = [
    'userEditFullName' => $full_name,
    'userEditUsername' => $username,
    'userEditEmail' => $email,
    'userEditRole' => $role,
    'userEditStatus' => $status,
];

foreach ($oldFields as $key => $value) {
    clsHelper::sessionSet('old', $key, $value);
}

$errors = [];

if (!clsValidator::required($id) || !clsValidator::integer($id)) {
    $errors[] = 'رقم المستخدم غير صحيح';
}

if (!clsValidator::required($full_name)) {
    $errors[] = 'الاسم الكامل مطلوب';
} elseif (!clsValidator::minLength($full_name, 3)) {
    $errors[] = 'الاسم الكامل يجب أن يكون 3 أحرف على الأقل';
}

if (!clsValidator::required($username)) {
    $errors[] = 'اسم المستخدم مطلوب';
} elseif (!clsValidator::minLength($username, 3)) {
    $errors[] = 'اسم المستخدم يجب أن يكون 3 أحرف على الأقل';
}

if (!clsValidator::required($email)) {
    $errors[] = 'البريد الإلكتروني مطلوب';
} elseif (!clsValidator::email($email)) {
    $errors[] = 'صيغة البريد الإلكتروني غير صحيحة';
}

if (!clsValidator::required($role)) {
    $errors[] = 'الدور مطلوب';
} elseif (!clsValidator::in($role, ['admin', 'teacher', 'supervisor'])) {
    $errors[] = 'الدور المحدد غير صحيح';
}

if (!clsValidator::in($status, ['0', '1', 0, 1])) {
    $errors[] = 'الحالة المحددة غير صحيحة';
}

if (!empty($password) || !empty($confirm_password)) {
    if (!clsValidator::password($password)) {
        $errors[] = 'كلمة المرور الجديدة يجب أن تكون 6 أحرف على الأقل';
    }

    if (!clsValidator::match($password, $confirm_password)) {
        $errors[] = 'كلمتا المرور الجديدتان غير متطابقتين';
    }
}

if (!empty($errors)) {
    clsHelper::setMessage('error', implode('<br>', $errors));
    clsHelper::redirect(clsPath::users() . 'edit.php' . urlencode($id));
}

$user = new clsUser($conn);

if (!$user->loadById($id)) {
    clsHelper::setMessage('error', 'المستخدم غير موجود');
    clsHelper::redirect(clsPath::users() . 'index.php');
}

$oldFullName = $user->full_name;
$oldUsername = $user->username;

if ($user->usernameExistsExceptCurrent($username, $id)) {
    $errors[] = 'اسم المستخدم مستخدم من قبل مستخدم آخر';
}

if ($user->emailExistsExceptCurrent($email, $id)) {
    $errors[] = 'البريد الإلكتروني مستخدم من قبل مستخدم آخر';
}

if (!empty($errors)) {
    clsHelper::setMessage('error', implode('<br>', $errors));
    clsHelper::redirect(clsPath::users() . 'edit.php' . urlencode($id));
}

$user->full_name = $full_name;
$user->username = $username;
$user->email = $email;
$user->role = $role;
$user->status = (int)$status;

if (!$user->update()) {
    clsHelper::setMessage('error', 'حدث خطأ أثناء تحديث بيانات المستخدم');
    clsHelper::redirect(clsPath::users() . 'edit.php' . urlencode($id));
}

$passwordChanged = false;

if (!empty($password)) {
    if (!$user->updatePassword($password)) {
        clsHelper::setMessage('error', 'تم تحديث البيانات لكن حدث خطأ أثناء تحديث كلمة المرور');
        clsHelper::redirect(clsPath::users() . 'edit.php' . urlencode($id));
    }

    $passwordChanged = true;
}

foreach (array_keys($oldFields) as $key) {
    clsHelper::sessionRemove('old', $key);
}

clsHelper::setMessage('success', 'تم تحديث المستخدم بنجاح');

$description = 'تم تعديل بيانات المستخدم: '
    . $oldFullName
    . ' (' . $oldUsername . ')'
    . ' إلى: '
    . $user->full_name
    . ' (' . $user->username . ')';

if ($passwordChanged) {
    $description .= ' مع تغيير كلمة المرور';
}

clsLog::add(
    $conn,
    'تعديل مستخدم',
    $description
);

clsHelper::redirect(clsPath::users() . 'index.php');