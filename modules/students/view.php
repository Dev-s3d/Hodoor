<?php
require_once '../../includes/app.php';
clsHelper::requireRole(['admin', 'supervisor']);

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

$genderLabel = $student->gender === 'female' ? 'أنثى' : 'ذكر';
$genderBadge = $student->gender === 'female' ? 'bg-danger' : 'bg-primary';

$statusLabel = (int)$student->status === 1 ? 'مفعل' : 'غير مفعل';
$statusBadge = (int)$student->status === 1 ? 'bg-success' : 'bg-secondary';
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">

        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4 students">

            <?php require_once '../../includes/alerts.php'; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">عرض الطالب</h1>
                    <p class="text-muted mb-0">الملف التفصيلي لبيانات الطالب</p>
                </div>

                <div class="d-flex gap-2">
                    <a href="<?= clsPath::students(); ?>edit.php?id=<?= $student->id; ?>"
                       class="btn btn-primary">
                        <i class="fa fa-pen me-1"></i>
                        تعديل
                    </a>

                    <a href="<?= clsPath::students(); ?>index.php"
                       class="btn btn-outline-secondary">
                        <i class="fa fa-arrow-right me-1"></i>
                        الرجوع
                    </a>
                </div>
            </div>

            <div class="row g-4">

                <div class="col-lg-4">

                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body text-center">

                            <div class="mb-3">
                                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center"
                                     style="width: 90px; height: 90px;">
                                    <i class="fa fa-user-graduate text-primary" style="font-size: 42px;"></i>
                                </div>
                            </div>

                            <h4 class="mb-1">
                                <?= clsHelper::e($student->student_name); ?>
                            </h4>

                            <p class="text-muted mb-3">
                                رقم الطالب:
                                <?= clsHelper::e($student->student_number ?: '-'); ?>
                            </p>

                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                            <span class="badge <?= $genderBadge; ?> px-3">
                                <?= $genderLabel; ?>
                            </span>

                                <span class="badge <?= $statusBadge; ?> px-3">
                                <?= $statusLabel; ?>
                            </span>
                            </div>

                        </div>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-body">

                            <h5 class="mb-3">
                                <i class="fa fa-school text-primary me-1"></i>
                                معلومات دراسية
                            </h5>

                            <div class="mb-3">
                                <small class="text-muted d-block">الفصل</small>
                                <div class="fw-semibold">
                                    <?= clsHelper::e($className); ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block">تاريخ الميلاد</small>
                                <div class="fw-semibold">
                                    <?= clsHelper::e($student->birth_date ?: '-'); ?>
                                </div>
                            </div>

                            <div>
                                <small class="text-muted d-block">تاريخ الإنشاء</small>
                                <div class="fw-semibold">
                                    <?= clsHelper::e(clsHelper::dateOnly($student->created_at)); ?>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="col-lg-8">

                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">

                            <h5 class="mb-4">
                                <i class="fa fa-id-card text-primary me-1"></i>
                                البيانات الأساسية
                            </h5>

                            <div class="row g-4">

                                <div class="col-md-6">
                                    <small class="text-muted d-block mb-1">
                                        <i class="fa fa-user me-1"></i>
                                        اسم الطالب
                                    </small>
                                    <div class="fw-semibold">
                                        <?= clsHelper::e($student->student_name); ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <small class="text-muted d-block mb-1">
                                        <i class="fa fa-fingerprint me-1"></i>
                                        رقم الطالب
                                    </small>
                                    <div class="fw-semibold">
                                        <?= clsHelper::e($student->student_number ?: '-'); ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <small class="text-muted d-block mb-1">
                                        <i class="fa fa-venus-mars me-1"></i>
                                        الجنس
                                    </small>
                                    <span class="badge <?= $genderBadge; ?> px-3">
                                    <?= $genderLabel; ?>
                                </span>
                                </div>

                                <div class="col-md-6">
                                    <small class="text-muted d-block mb-1">
                                        <i class="fa fa-toggle-on me-1"></i>
                                        الحالة
                                    </small>
                                    <span class="badge <?= $statusBadge; ?> px-3">
                                    <?= $statusLabel; ?>
                                </span>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">

                            <h5 class="mb-4">
                                <i class="fa fa-phone text-primary me-1"></i>
                                بيانات التواصل وولي الأمر
                            </h5>

                            <div class="row g-4">

                                <div class="col-md-6">
                                    <small class="text-muted d-block mb-1">
                                        <i class="fa fa-mobile-screen-button me-1"></i>
                                        هاتف الطالب
                                    </small>
                                    <div class="fw-semibold">
                                        <?= clsHelper::e($student->phone ?: '-'); ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <small class="text-muted d-block mb-1">
                                        <i class="fa fa-user-tie me-1"></i>
                                        اسم ولي الأمر
                                    </small>
                                    <div class="fw-semibold">
                                        <?= clsHelper::e($student->parent_name ?: '-'); ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <small class="text-muted d-block mb-1">
                                        <i class="fa fa-phone me-1"></i>
                                        هاتف ولي الأمر
                                    </small>
                                    <div class="fw-semibold">
                                        <?= clsHelper::e($student->parent_phone ?: '-'); ?>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <small class="text-muted d-block mb-1">
                                        <i class="fa fa-location-dot me-1"></i>
                                        العنوان
                                    </small>
                                    <div class="fw-semibold">
                                        <?= nl2br(clsHelper::e($student->address ?: '-')); ?>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= clsPath::students(); ?>edit.php?id=<?= $student->id; ?>"
                           class="btn btn-outline-primary">
                            <i class="fa fa-edit me-1"></i>
                            تعديل بيانات الطالب
                        </a>

                        <a href="<?= clsPath::students(); ?>delete.php?id=<?= $student->id; ?>"
                           class="btn btn-outline-danger">
                            <i class="fa fa-trash me-1"></i>
                            حذف الطالب
                        </a>
                    </div>

                </div>

            </div>

        </div>
    </div>

<?php require_once '../../includes/footer.php'; ?>