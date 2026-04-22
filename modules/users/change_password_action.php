<?php

require_once '../../includes/app.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    clsHelper::redirect(clsPath::changePassword());
}

$current_password = clsHelper::post('current_password');
$new_password = clsHelper::post('new_password');
$confirm_password = clsHelper::post('confirm_password');

$errors = [];

if (!clsValidator::required($current_password)) {
    $errors[] = 'كلمة المرور الحالية مطلوبة';
}

if (!clsValidator::required($new_password)) {
    $errors[] = 'كلمة المرور الجديدة مطلوبة';
} elseif (!clsValidator::password($new_password)) {
    $errors[] = 'كلمة المرور الجديدة يجب أن تكون 6 أحرف على الأقل';
}

if (!clsValidator::required($confirm_password)) {
    $errors[] = 'تأكيد كلمة المرور الجديدة مطلوب';
} elseif (!clsValidator::match($new_password, $confirm_password)) {
    $errors[] = 'كلمتا المرور الجديدتان غير متطابقتين';
}

if (!empty($errors)) {
    clsHelper::setMessage('error', implode('<br>', $errors));
    clsHelper::redirect(clsPath::changePassword());
}

$user = new clsUser($conn);

if (!$user->loadById($_SESSION['user_id'])) {
    clsHelper::setMessage('error', 'المستخدم غير موجود');
    clsHelper::redirect(clsPath::login());
}

if (!$user->checkPassword($current_password)) {
    clsHelper::setMessage('error', 'كلمة المرور الحالية غير صحيحة');
    clsHelper::redirect(clsPath::changePassword());
}

if ($user->updatePassword($new_password)) {
    clsHelper::setMessage('success', 'تم تغيير كلمة المرور بنجاح');
    clsHelper::redirect(clsPath::profile());
}

clsHelper::setMessage('error', 'حدث خطأ أثناء تحديث كلمة المرور');
clsHelper::redirect(clsPath::changePassword());