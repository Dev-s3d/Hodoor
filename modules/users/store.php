<?php

require_once '../../includes/app.php';
clsHelper::requireRole(['admin']);
// منع الوصول المباشر
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    clsHelper::redirect(clsPath::users() . 'create.php');
}

// قراءة المدخلات
$full_name = clsHelper::post('full_name');
$username = clsHelper::post('username');
$email = clsHelper::post('email');
$role = clsHelper::post('role');
$password = clsHelper::post('password');
$confirm_password = clsHelper::post('confirm_password');
$status = clsHelper::post('status', '1');

// حفظ القيم القديمة عند الخطأ
$_SESSION['old']['userAddNewFullName'] = $full_name;
$_SESSION['old']['userAddNewUsername'] = $username;
$_SESSION['old']['userAddNewEmail'] = $email;
$_SESSION['old']['userAddNewRole'] = $role;
$_SESSION['old']['userAddNewStatus'] = $status;

$errors = [];

// تحقق المدخلات
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

if (!clsValidator::required($password)) {
    $errors[] = 'كلمة المرور مطلوبة';
} elseif (!clsValidator::password($password)) {
    $errors[] = 'كلمة المرور يجب أن تكون 6 أحرف على الأقل';
}

if (!clsValidator::required($confirm_password)) {
    $errors[] = 'تأكيد كلمة المرور مطلوب';
} elseif (!clsValidator::match($password, $confirm_password)) {
    $errors[] = 'كلمتا المرور غير متطابقتين';
}

if (!clsValidator::in($status, ['0', '1', 0, 1])) {
    $errors[] = 'الحالة المحددة غير صحيحة';
}

if (!empty($errors)) {
    clsHelper::setMessage('error', implode('<br>', $errors));
    clsHelper::redirect(clsPath::users() . 'create.php');
}

$user = new clsUser($conn);

// تحقق التكرار
if ($user->usernameExists($username)) {
    $errors[] = 'اسم المستخدم مستخدم مسبقًا';
}

if ($user->emailExists($email)) {
    $errors[] = 'البريد الإلكتروني مستخدم مسبقًا';
}

if (!empty($errors)) {
    clsHelper::setMessage('error', implode('<br>', $errors));
    clsHelper::redirect(clsPath::users() . 'create.php');
}

// تجهيز الكائن
$user->full_name = $full_name;
$user->username = $username;
$user->email = $email;
$user->password = clsHelper::hashPassword($password);
$user->role = $role;
$user->status = (int)$status;

// حفظ
if ($user->insert()) {
    unset(
        $_SESSION['old_full_name'],
        $_SESSION['old_username'],
        $_SESSION['old_email'],
        $_SESSION['old_role'],
        $_SESSION['old_status']
    );

    clsHelper::setMessage('success', 'تم إضافة المستخدم بنجاح');
    clsHelper::redirect(clsPath::users() . 'index.php');
}

clsHelper::setMessage('error', 'حدث خطأ أثناء إضافة المستخدم');
clsHelper::redirect(clsPath::users() . 'create.php');