<?php

require_once '../../../includes/app.php';

// منع الوصول المباشر
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    clsHelper::redirect(clsPath::editProfile());
}

$id = clsHelper::post('id');
$full_name = clsHelper::post('full_name');
$username = clsHelper::post('username');
$email = clsHelper::post('email');

// حفظ القيم القديمة عند حدوث خطأ
clsHelper::sessionSet('old', 'full_name', $full_name);
clsHelper::sessionSet('old', 'username', $username);
clsHelper::sessionSet('old', 'email', $email);

$errors = [];

/*
|--------------------------------------------------------------------------
| حماية أساسية
|--------------------------------------------------------------------------
| لا نسمح للمستخدم بتعديل أي id غير id الخاص به
*/
if (!clsValidator::required($id) || !clsValidator::integer($id)) {
    $errors[] = 'بيانات المستخدم غير صحيحة';
} elseif ((int)$id !== (int)clsHelper::auth('user_id')) {
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
    clsHelper::redirect(clsPath::editProfile());
}

$user = new clsUser($conn);

if (!$user->loadById(clsHelper::auth('user_id'))) {
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
    clsHelper::redirect(clsPath::editProfile());
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
    |--------------------------------------------------------------------------
    | تحديث بيانات الجلسة بعد نجاح التعديل
    |--------------------------------------------------------------------------
    */
    clsHelper::sessionSet('auth', 'full_name', $user->full_name);
    clsHelper::sessionSet('auth', 'username', $user->username);
    clsHelper::sessionSet('auth', 'email', $user->email);

    /*
    |--------------------------------------------------------------------------
    | حذف القيم القديمة بعد النجاح
    |--------------------------------------------------------------------------
    */
    clsHelper::sessionRemove('old', 'full_name');
    clsHelper::sessionRemove('old', 'username');
    clsHelper::sessionRemove('old', 'email');

    clsHelper::setMessage('success', 'تم تحديث الملف الشخصي بنجاح');
    clsLog::add(
        $conn,
        'تحديث الملف الشخصي',
        'تمت عملية تحديث الملف الشخصي بنجاح , ' . $user->full_name
    );
    clsHelper::redirect(clsPath::editProfile());
}

clsHelper::setMessage('error', 'حدث خطأ أثناء تحديث الملف الشخصي');
clsHelper::redirect(clsPath::editProfile());