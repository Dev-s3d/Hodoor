<?php
require_once '../../includes/app.php';
clsHelper::requireRole(['admin']);

$title = 'معلومات المدرسة';

$setting = new clsSetting($conn);

$school_name = $setting->get('school_name', 'Hodoor School');
$school_phone = $setting->get('school_phone', '');
$school_email = $setting->get('school_email', '');
$school_address = $setting->get('school_address', '');
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">

        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4">

            <?php require_once '../../includes/alerts.php'; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">معلومات المدرسة</h1>
                    <p class="text-muted mb-0">تعديل بيانات المدرسة الأساسية</p>
                </div>

                <a href="<?= clsPath::settings(); ?>index.php" class="btn btn-outline-secondary">
                    الرجوع
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <form action="<?= clsPath::settings(); ?>update.php" method="POST">

                        <input type="hidden" name="form_type" value="school_info">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">اسم المدرسة</label>
                                <input type="text" name="school_name" class="form-control"
                                       value="<?= clsHelper::e($school_name); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">رقم التواصل</label>
                                <input type="text" name="school_phone" class="form-control"
                                       value="<?= clsHelper::e($school_phone); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">البريد الإلكتروني</label>
                                <input type="email" name="school_email" class="form-control"
                                       value="<?= clsHelper::e($school_email); ?>">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">العنوان</label>
                                <textarea name="school_address" class="form-control"
                                          rows="3"><?= clsHelper::e($school_address); ?></textarea>
                            </div>

                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                حفظ التعديلات
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>

    </div>

<?php require_once '../../includes/footer.php'; ?>