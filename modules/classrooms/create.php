<?php
require_once '../../includes/app.php';
clsHelper::requireRole(['admin', 'supervisor']);
$title = 'إضافة فصل جديد';
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">

        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4">

            <?php require_once '../../includes/alerts.php'; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">إضافة فصل جديد</h1>
                    <p class="text-muted mb-0">أدخل بيانات الفصل لإضافته إلى النظام</p>
                </div>

                <a href="<?= clsPath::classrooms(); ?>index.php" class="btn btn-outline-secondary">
                    <i class="fa fa-arrow-right me-1"></i>
                    الرجوع
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <form action="<?= clsPath::classrooms(); ?>store.php" method="POST">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">اسم الفصل</label>
                                <input
                                        type="text"
                                        name="class_name"
                                        class="form-control"
                                        value="<?= clsHelper::old('class_name'); ?>"
                                        placeholder="مثال: الصف الأول أ">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">رمز الفصل</label>
                                <input
                                        type="text"
                                        name="class_code"
                                        class="form-control"
                                        value="<?= clsHelper::old('class_code'); ?>"
                                        placeholder="مثال: A-101">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">المرحلة / المستوى</label>
                                <input
                                        type="text"
                                        name="level_name"
                                        class="form-control"
                                        value="<?= clsHelper::old('level_name'); ?>"
                                        placeholder="مثال: ابتدائي">
                            </div>

                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save me-1"></i>
                                حفظ الفصل
                            </button>

                            <a href="<?= clsPath::classrooms(); ?>index.php" class="btn btn-light border">
                                إلغاء
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>

    </div>

<?php require_once '../../includes/footer.php'; ?>