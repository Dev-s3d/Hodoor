<?php
require_once '../../includes/app.php';
$title = 'عرض الطالب';

$id = clsHelper::get('id');

$student = new clsStudent($conn);
if (!$id || !$student->loadById($id)) {
    clsHelper::setMessage('error', 'الطالب غير موجود');
    clsHelper::redirect(clsPath::students() . 'index.php');
}

$classroom = new clsClassroom($conn);
$className = '-';
if (!empty($student->classroom_id) && $classroom->loadById($student->classroom_id)) {
    $className = $classroom->class_name;
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
                    <h1 class="mb-1">عرض الطالب</h1>
                    <p class="text-muted mb-0">تفاصيل الطالب المحدد</p>
                </div>

                <div class="d-flex gap-2">
                    <a href="<?= clsPath::students(); ?>edit.php?id=<?= $student->id; ?>" class="btn btn-primary">
                        <i class="fa fa-pen me-1"></i>
                        تعديل
                    </a>

                    <a href="<?= clsPath::students(); ?>index.php" class="btn btn-outline-secondary">
                        <i class="fa fa-arrow-right me-1"></i>
                        الرجوع
                    </a>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="row g-4">

                        <div class="col-md-6">
                            <label class="form-label text-muted">اسم الطالب</label>
                            <div class="fw-semibold"><?= clsHelper::e($student->student_name); ?></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">رقم الطالب</label>
                            <div class="fw-semibold"><?= clsHelper::e($student->student_number); ?></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">الفصل</label>
                            <div class="fw-semibold"><?= clsHelper::e($className); ?></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">الجنس</label>
                            <div class="fw-semibold"><?= $student->gender === 'female' ? 'أنثى' : 'ذكر'; ?></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">تاريخ الميلاد</label>
                            <div class="fw-semibold"><?= clsHelper::e($student->birth_date ?: '-'); ?></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">هاتف الطالب</label>
                            <div class="fw-semibold"><?= clsHelper::e($student->phone ?: '-'); ?></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">اسم ولي الأمر</label>
                            <div class="fw-semibold"><?= clsHelper::e($student->parent_name ?: '-'); ?></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">هاتف ولي الأمر</label>
                            <div class="fw-semibold"><?= clsHelper::e($student->parent_phone ?: '-'); ?></div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label text-muted">العنوان</label>
                            <div class="fw-semibold"><?= nl2br(clsHelper::e($student->address ?: '-')); ?></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">الحالة</label>
                            <div class="fw-semibold">
                                <?php if ((int)$student->status === 1): ?>
                                    <span class="badge bg-success">مفعل</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">غير مفعل</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">تاريخ الإنشاء</label>
                            <div class="fw-semibold"><?= clsHelper::e($student->created_at); ?></div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

<?php require_once '../../includes/footer.php'; ?>