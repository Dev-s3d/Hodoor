<?php
require_once '../../includes/app.php';
clsHelper::requireRole(['admin']);

$title = 'الإعدادات العامة';

$setting = new clsSetting($conn);

$academic_year = $setting->get('academic_year', '2026');
$system_name = $setting->get('system_name', 'Hodoor');
$default_lang = $setting->get('default_lang', 'ar');
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">

        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4">

            <?php require_once '../../includes/alerts.php'; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">الإعدادات العامة</h1>
                    <p class="text-muted mb-0">تعديل الإعدادات العامة للنظام</p>
                </div>

                <a href="<?= clsPath::settings(); ?>index.php" class="btn btn-outline-secondary">
                    الرجوع
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <form action="<?= clsPath::settings(); ?>update.php" method="POST">

                        <input type="hidden" name="form_type" value="general">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">اسم النظام</label>
                                <input type="text" name="system_name" class="form-control"
                                       value="<?= clsHelper::e($system_name); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">السنة الدراسية</label>
                                <input type="text" name="academic_year" class="form-control"
                                       value="<?= clsHelper::e($academic_year); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">اللغة الافتراضية</label>
                                <select name="default_lang" class="form-select" disabled>
                                    <option value="ar" <?= $default_lang === 'ar' ? 'selected' : ''; ?>>
                                        العربية
                                    </option>
                                    <option value="en" <?= $default_lang === 'en' ? 'selected' : ''; ?>>English</option>
                                </select>
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