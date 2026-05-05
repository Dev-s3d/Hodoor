<?php
require_once '../../includes/app.php';
clsHelper::requireRole(['admin']);

$title = 'الإعدادات';
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">

        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4">

            <?php require_once '../../includes/alerts.php'; ?>

            <div class="mb-4">
                <h1 class="mb-1">الإعدادات</h1>
                <p class="text-muted mb-0">إدارة إعدادات نظام Hodoor</p>
            </div>

            <div class="row g-4">

                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <h5 class="mb-2">
                                <i class="fa fa-school me-2"></i>
                                معلومات المدرسة
                            </h5>
                            <p class="text-muted">تعديل اسم المدرسة وبيانات التواصل.</p>

                            <a href="<?= clsPath::settings(); ?>school_info.php" class="btn btn-primary">
                                إدارة
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <h5 class="mb-2">
                                <i class="fa fa-sliders me-2"></i>
                                الإعدادات العامة
                            </h5>
                            <p class="text-muted">تعديل السنة الدراسية وبعض الإعدادات العامة.</p>

                            <a href="<?= clsPath::settings(); ?>general.php" class="btn btn-primary">
                                إدارة
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <h5 class="mb-2">
                                <i class="fa fa-check-circle me-2"></i>
                                إعدادات الحضور
                            </h5>
                            <p class="text-muted">إدارة حالات الحضور المستخدمة في النظام.</p>

                            <a href="<?= clsPath::settings(); ?>attendance_status.php" class="btn btn-primary">
                                إدارة
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

<?php require_once '../../includes/footer.php'; ?>