<?php
require_once '../../includes/app.php';
$title = 'عرض الفصل';

$id = clsHelper::get('id');

$classroom = new clsClassroom($conn);

if (!$id || !$classroom->loadById($id)) {
    clsHelper::setMessage('error', 'الفصل غير موجود');
    clsHelper::redirect(clsPath::classrooms() . 'index.php');
}
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">

        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4">

            <?php require_once '../../includes/alerts.php'; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">عرض الفصل</h1>
                    <p class="text-muted mb-0">تفاصيل الفصل المحدد</p>
                </div>

                <div class="d-flex gap-2">
                    <a href="<?= clsPath::classrooms(); ?>edit.php?id=<?= $classroom->id; ?>" class="btn btn-primary">
                        <i class="fa fa-pen me-1"></i>
                        تعديل
                    </a>

                    <a href="<?= clsPath::classrooms(); ?>index.php" class="btn btn-outline-secondary">
                        <i class="fa fa-arrow-right me-1"></i>
                        الرجوع
                    </a>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <div class="row g-4">

                        <div class="col-md-6">
                            <label class="form-label text-muted">اسم الفصل</label>
                            <div class="fw-semibold"><?= clsHelper::e($classroom->class_name); ?></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">رمز الفصل</label>
                            <div class="fw-semibold"><?= clsHelper::e($classroom->class_code); ?></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">المرحلة / المستوى</label>
                            <div class="fw-semibold"><?= clsHelper::e($classroom->level_name); ?></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">تاريخ الإنشاء</label>
                            <div class="fw-semibold"><?= clsHelper::e($classroom->created_at); ?></div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>

<?php require_once '../../includes/footer.php'; ?>