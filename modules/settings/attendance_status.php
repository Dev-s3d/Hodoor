<?php
require_once '../../includes/app.php';
clsHelper::requireRole(['admin']);

$title = 'إعدادات الحضور';

$setting = new clsSetting($conn);

$enable_present = $setting->get('enable_present', '1');
$enable_absent = $setting->get('enable_absent', '1');
$enable_late = $setting->get('enable_late', '1');
$enable_excused = $setting->get('enable_excused', '1');
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">

        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4">

            <?php require_once '../../includes/alerts.php'; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">إعدادات الحضور</h1>
                    <p class="text-muted mb-0">تفعيل أو تعطيل حالات الحضور</p>
                </div>

                <a href="<?= clsPath::settings(); ?>index.php" class="btn btn-outline-secondary">
                    الرجوع
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <form action="<?= clsPath::settings(); ?>update.php" method="POST">

                        <input type="hidden" name="form_type" value="attendance_status">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="enable_present"
                                           value="1" <?= $enable_present == '1' ? 'checked' : ''; ?>>
                                    <label class="form-check-label">تفعيل حالة حاضر</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="enable_absent"
                                           value="1" <?= $enable_absent == '1' ? 'checked' : ''; ?>>
                                    <label class="form-check-label">تفعيل حالة غائب</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="enable_late"
                                           value="1" <?= $enable_late == '1' ? 'checked' : ''; ?>>
                                    <label class="form-check-label">تفعيل حالة متأخر</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="enable_excused"
                                           value="1" <?= $enable_excused == '1' ? 'checked' : ''; ?>>
                                    <label class="form-check-label">تفعيل حالة مستأذن</label>
                                </div>
                            </div>

                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                حفظ الإعدادات
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>

    </div>

<?php require_once '../../includes/footer.php'; ?>