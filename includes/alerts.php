<?php

$success = clsHelper::getMessage('success');
$error = clsHelper::getMessage('error');
$warning = clsHelper::getMessage('warning');
$info = clsHelper::getMessage('info');

?>

<?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i>

        <?= clsHelper::e($success); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-circle-xmark me-2"></i>

        <?= strip_tags($error, '<br>'); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($warning): ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-triangle-exclamation me-2"></i>

        <?= clsHelper::e($warning); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($info): ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-circle-info me-2"></i>

        <?= clsHelper::e($info); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>