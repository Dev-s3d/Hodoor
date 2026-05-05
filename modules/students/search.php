<?php
require_once '../../includes/app.php';
clsHelper::requireRole(['admin', 'supervisor']);
$title = 'اسم الصفحة';
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">

        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4">

            <h1><?= $title; ?></h1>

            <p>هذه الصفحة قيد التطوير</p>

        </div>

    </div>

<?php require_once '../../includes/footer.php'; ?>