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

$totalStudents = $classroom->studentsCount();
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">

        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4 classrooms">

            <?php require_once '../../includes/alerts.php'; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">تعديل الفصل</h1>
                    <p class="text-muted mb-0">تعديل بيانات الفصل الحالية</p>
                </div>

                <div class="d-flex gap-2">
                    <a href="<?= clsPath::classrooms(); ?>view.php?id=<?= $classroom->id; ?>"
                       class="btn btn-outline-primary">
                        <i class="fa fa-eye me-1"></i>
                        عرض
                    </a>

                    <a href="<?= clsPath::classrooms(); ?>index.php"
                       class="btn btn-outline-secondary">
                        <i class="fa fa-arrow-right me-1"></i>
                        الرجوع
                    </a>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">

                    <div class="d-flex align-items-center flex-wrap gap-3">

                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                             style="width:75px;height:75px;">
                            <i class="fa fa-school text-primary fs-2"></i>
                        </div>

                        <div>
                            <h4 class="mb-1">
                                <?= clsHelper::e($classroom->class_name); ?>
                            </h4>

                            <p class="text-muted mb-2">
                                رمز الفصل:
                                <?= clsHelper::e($classroom->class_code ?: '-'); ?>
                            </p>

                            <div class="d-flex gap-2 flex-wrap">
                            <span class="badge bg-primary px-3">
                                <?= clsHelper::e($classroom->level_name ?: '-'); ?>
                            </span>

                                <span class="badge bg-success px-3">
                                <?= clsHelper::e($totalStudents); ?> طالب
                            </span>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <form action="<?= clsPath::classrooms(); ?>update.php" method="POST">

                <input type="hidden" name="id" value="<?= clsHelper::e($classroom->id); ?>">

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">

                        <h5 class="mb-4">
                            <i class="fa fa-id-card text-primary me-1"></i>
                            بيانات الفصل
                        </h5>

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-chalkboard text-primary me-1"></i>
                                    اسم الفصل
                                </label>
                                <input type="text"
                                       name="class_name"
                                       class="form-control"
                                       value="<?= clsHelper::old('class_name', $classroom->class_name); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-fingerprint text-primary me-1"></i>
                                    رمز الفصل
                                </label>
                                <input type="text"
                                       name="class_code"
                                       class="form-control"
                                       value="<?= clsHelper::old('class_code', $classroom->class_code); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-brands fa-gitter text-primary me-1"></i>
                                    المرحلة / المستوى
                                </label>
                                <input type="text"
                                       name="level_name"
                                       class="form-control"
                                       value="<?= clsHelper::old('level_name', $classroom->level_name); ?>">
                            </div>

                        </div>

                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">

                    <a href="<?= clsPath::classrooms(); ?>view.php?id=<?= $classroom->id; ?>"
                       class="btn btn-outline-secondary">
                        <i class="fa fa-eye me-1"></i>
                        عرض الفصل
                    </a>

                    <a href="<?= clsPath::classrooms(); ?>index.php"
                       class="btn btn-light border">
                        إلغاء
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save me-1"></i>
                        حفظ التعديلات
                    </button>

                </div>

            </form>

        </div>

    </div>

<?php require_once '../../includes/footer.php'; ?>