<?php

require_once '../../includes/app.php';

// منع الوصول المباشر
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    clsHelper::redirect(clsPath::profile());
}

$id = clsHelper::post('id');
$full_name = clsHelper::post('full_name');
$username = clsHelper::post('username');
$email = clsHelper::post('email');

// حفظ القيم القديمة
$_SESSION['old_full_name'] = $full_name;
$_SESSION['old_username'] = $username;
$_SESSION['old_email'] = $email;

$errors = [];

/*
|--------------------------------------------------------------------------
| حماية أساسية
|--------------------------------------------------------------------------
| لا نسمح للمستخدم بتعديل أي id غير id الخاص به
*/
if (!clsValidator::required($id) || !clsValidator::integer($id)) {
    $errors[] = 'بيانات المستخدم غير صحيحة';
} elseif ((int)$id !== (int)$_SESSION['user_id']) {
    $errors[] = 'غير مصرح لك بتعديل هذا المستخدم';
}

/*
|--------------------------------------------------------------------------
| التحقق من المدخلات
|--------------------------------------------------------------------------
*/
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

if (!empty($errors)) {
    clsHelper::setMessage('error', implode('<br>', $errors));
    clsHelper::redirect(clsPath::profile());
}

$user = new clsUser($conn);

if (!$user->loadById($_SESSION['user_id'])) {
    clsHelper::setMessage('error', 'المستخدم غير موجود');
    clsHelper::redirect(clsPath::login());
}

/*
|--------------------------------------------------------------------------
| التحقق من عدم تكرار username و email
|--------------------------------------------------------------------------
*/
if ($user->usernameExistsExceptCurrent($username, $user->id)) {
    $errors[] = 'اسم المستخدم مستخدم من قبل مستخدم آخر';
}

if ($user->emailExistsExceptCurrent($email, $user->id)) {
    $errors[] = 'البريد الإلكتروني مستخدم من قبل مستخدم آخر';
}

if (!empty($errors)) {
    clsHelper::setMessage('error', implode('<br>', $errors));
    clsHelper::redirect(clsPath::profile());
}

/*
|--------------------------------------------------------------------------
| تحديث البيانات المسموحة فقط
|--------------------------------------------------------------------------
| لا نسمح هنا بتعديل role أو status من الملف الشخصي
*/
$user->full_name = $full_name;
$user->username = $username;
$user->email = $email;

if ($user->update()) {
    /*
    | تحديث بيانات الجلسة بعد نجاح التعديل
    */
    $_SESSION['full_name'] = $user->full_name;
    $_SESSION['username'] = $user->username;
    $_SESSION['email'] = $user->email;

    unset(
        $_SESSION['old_full_name'],
        $_SESSION['old_username'],
        $_SESSION['old_email']
    );

    clsHelper::setMessage('success', 'تم تحديث الملف الشخصي بنجاح');
    clsHelper::redirect(clsPath::profile());
}

clsHelper::setMessage('error', 'حدث خطأ أثناء تحديث الملف الشخصي');
clsHelper::redirect(clsPath::profile());