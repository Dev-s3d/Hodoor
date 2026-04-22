<?php

/*
|--------------------------------------------------------------------------
| رسائل النظام
|--------------------------------------------------------------------------
| هذا الملف يعرض الرسائل المحفوظة في Session مرة واحدة فقط
| الأنواع المدعومة حاليًا:
| - success
| - error
| - warning
| - info
*/

$success = clsHelper::getMessage('success');
$error = clsHelper::getMessage('error');
$warning = clsHelper::getMessage('warning');
$info = clsHelper::getMessage('info');

if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i>
        <?= $success; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-circle-xmark me-2"></i>
        <?= $error; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if ($warning): ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-triangle-exclamation me-2"></i>
        <?= $warning; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if ($info): ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-circle-info me-2"></i>
        <?= $info; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>