<?php
require_once '../../includes/app.php';
$title = 'تغيير كلمة المرور';
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">

        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4">

            <?php require_once '../../includes/alerts.php'; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">تغيير كلمة المرور</h1>
                    <p class="text-muted mb-0">يمكنك تغيير كلمة مرور حسابك من هنا</p>
                </div>

                <a href="<?= clsPath::profile(); ?>" class="btn btn-outline-secondary">
                    <i class="fa fa-arrow-right me-1"></i>
                    الرجوع
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <form action="<?= clsPath::changePasswordAction(); ?>" method="POST">

                        <div class="row g-3">

                            <div class="col-md-12">
                                <label class="form-label text-warning">كلمة المرور الحالية</label>
                                <input type="password" name="current_password" class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">كلمة المرور الجديدة</label>
                                <input type="password" name="new_password" class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">تأكيد كلمة المرور الجديدة</label>
                                <input type="password" name="confirm_password" class="form-control">
                            </div>

                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save me-1"></i>
                                تحديث كلمة المرور
                            </button>

                            <a href="<?= clsPath::profile(); ?>" class="btn btn-light border">
                                إلغاء
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>

    </div>

<?php require_once '../../includes/footer.php'; ?>