<?php

require_once '../../includes/app.php';
clsHelper::requireRole(['admin', 'supervisor']);
$title = 'تعديل الفصل';

$id = clsHelper::get('id');

$classroom = new clsClassroom($conn);

if (!$id || !$classroom->loadById($id)) {
    clsHelper::setMessage('error', 'الفصل غير موجود');
    clsHelper::redirect(clsPath::classrooms() . 'index.php');
}

clsHelper::showSessions();
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">

        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4">

            <?php require_once '../../includes/alerts.php'; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">تعديل الفصل</h1>
                    <p class="text-muted mb-0">يمكنك تعديل بيانات الفصل الحالية</p>
                </div>

                <a href="<?= clsPath::classrooms(); ?>index.php" class="btn btn-outline-secondary">
                    <i class="fa fa-arrow-right me-1"></i>
                    الرجوع
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <form action="<?= clsPath::classrooms(); ?>update.php" method="POST">

                        <!-- نرسل id حتى نعرف أي فصل سنحدث -->
                        <input type="hidden" name="id" value="<?= clsHelper::e($classroom->id); ?>">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-chalkboard fs-5 text-primary"></i>
                                    اسم الفصل
                                </label>
                                <input
                                        type="text"
                                        name="class_name"
                                        class="form-control"
                                        value="<?= clsHelper::old('class_name', $classroom->class_name); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-fingerprint fs-5 text-primary"></i>
                                    رمز الفصل
                                </label>
                                <input
                                        type="text"
                                        name="class_code"
                                        class="form-control"
                                        value="<?= clsHelper::old('class_code', $classroom->class_code); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-brands fa-gitter fs-5 text-primary"></i>
                                    المرحلة / المستوى
                                </label>
                                <input
                                        type="text"
                                        name="level_name"
                                        class="form-control"
                                        value="<?= clsHelper::old('level_name', $classroom->level_name); ?>">
                            </div>

                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save me-1"></i>
                                حفظ التعديلات
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