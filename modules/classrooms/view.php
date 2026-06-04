<?php
require_once '../../includes/app.php';

clsHelper::requireRole(['admin', 'supervisor']);

$title = 'عرض الفصل';

$id = clsHelper::get('id');

$classroom = new clsClassroom($conn);

if (!$id || !$classroom->loadById($id)) {
    clsHelper::setMessage('error', 'الفصل غير موجود');
    clsHelper::redirect(clsPath::classrooms() . 'index.php');
}

$students = $classroom->getStudents();
$totalStudents = $classroom->studentsCount();
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
                    <p class="text-muted mb-0">
                        الملف الكامل للفصل الدراسي
                    </p>
                </div>

                <div class="d-flex gap-2">

                    <a href="<?= clsPath::classrooms(); ?>edit.php?id=<?= $classroom->id; ?>"
                       class="btn btn-primary">

                        <i class="fa fa-edit me-1"></i>
                        تعديل

                    </a>

                    <a href="<?= clsPath::classrooms(); ?>index.php"
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
                                     style="width:90px;height:90px;">

                                    <i class="fa fa-school text-primary"
                                       style="font-size:42px;"></i>

                                </div>

                            </div>

                            <h3 class="mb-2">
                                <?= clsHelper::e($classroom->class_name); ?>
                            </h3>

                            <p class="text-muted mb-3">
                                <?= clsHelper::e($classroom->class_code ?: '-'); ?>
                            </p>

                            <span class="badge bg-primary px-3 py-2">
                            <?= $totalStudents; ?> طالب
                        </span>

                        </div>

                    </div>

                    <div class="card shadow-sm border-0">

                        <div class="card-body">

                            <h5 class="mb-3">
                                <i class="fa fa-chart-simple text-primary me-1"></i>
                                إحصائيات الفصل
                            </h5>

                            <div class="d-flex justify-content-between mb-3">

                                <span>عدد الطلاب</span>

                                <strong>
                                    <?= $totalStudents; ?>
                                </strong>

                            </div>

                            <div class="d-flex justify-content-between mb-3">

                                <span>المرحلة</span>

                                <strong>
                                    <?= clsHelper::e($classroom->level_name ?: '-'); ?>
                                </strong>

                            </div>

                            <div class="d-flex justify-content-between">

                                <span>تاريخ الإنشاء</span>

                                <strong>
                                    <?= clsHelper::dateOnly($classroom->created_at); ?>
                                </strong>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-lg-8">

                    <div class="card shadow-sm border-0 mb-4">

                        <div class="card-body">

                            <h5 class="mb-4">

                                <i class="fa fa-info-circle text-primary me-1"></i>
                                معلومات الفصل

                            </h5>

                            <div class="row g-4">

                                <div class="col-md-6">

                                    <small class="text-muted d-block mb-1">
                                        اسم الفصل
                                    </small>

                                    <div class="fw-semibold">
                                        <?= clsHelper::e($classroom->class_name); ?>
                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <small class="text-muted d-block mb-1">
                                        رمز الفصل
                                    </small>

                                    <div class="fw-semibold">
                                        <?= clsHelper::e($classroom->class_code ?: '-'); ?>
                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <small class="text-muted d-block mb-1">
                                        المرحلة / المستوى
                                    </small>

                                    <div class="fw-semibold">
                                        <?= clsHelper::e($classroom->level_name ?: '-'); ?>
                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <small class="text-muted d-block mb-1">
                                        تاريخ الإنشاء
                                    </small>

                                    <div class="fw-semibold">
                                        <?= clsHelper::dateOnly($classroom->created_at); ?>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="card shadow-sm border-0">

                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center mb-4">

                                <h5 class="mb-0">

                                    <i class="fa fa-users text-primary me-1"></i>
                                    طلاب الفصل

                                </h5>

                                <span class="badge bg-primary">
                                <?= $totalStudents; ?>
                            </span>

                            </div>

                            <?php if (!empty($students)): ?>

                                <div class="table-responsive">

                                    <table class="table table-hover align-middle">

                                        <thead class="table-light">

                                        <tr>

                                            <th>#</th>
                                            <th>اسم الطالب</th>
                                            <th>رقم الطالب</th>
                                            <th>الجنس</th>
                                            <th>الحالة</th>
                                            <th>عرض</th>

                                        </tr>

                                        </thead>

                                        <tbody>

                                        <?php foreach ($students as $index => $student): ?>

                                            <tr>

                                                <td>
                                                    <?= $index + 1; ?>
                                                </td>

                                                <td>
                                                    <?= clsHelper::e($student['student_name']); ?>
                                                </td>

                                                <td>
                                                    <?= clsHelper::e($student['student_number']); ?>
                                                </td>

                                                <td>
                                                    <?= clsHelper::genderBadge($student['gender']); ?>
                                                </td>

                                                <td>
                                                    <?= clsHelper::statusBadge($student['status']); ?>
                                                </td>

                                                <td>

                                                    <a href="<?= clsPath::students(); ?>view.php?id=<?= $student['id']; ?>"
                                                       class="btn btn-sm btn-outline-primary"
                                                       title="عرض الطالب">

                                                        <i class="fa fa-eye"></i>

                                                    </a>

                                                </td>

                                            </tr>

                                        <?php endforeach; ?>

                                        </tbody>

                                    </table>

                                </div>

                            <?php else: ?>

                                <div class="text-center py-5">

                                    <i class="fa fa-users fa-3x text-muted mb-3"></i>

                                    <h5 class="text-muted">
                                        لا يوجد طلاب داخل هذا الفصل
                                    </h5>

                                </div>

                            <?php endif; ?>

                        </div>

                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">

                        <a href="<?= clsPath::attendance(); ?>take.php?classroom_id=<?= $classroom->id; ?>&attendance_date=<?= date('Y-m-d'); ?>"
                           class="btn btn-success">

                            <i class="fa fa-check-circle me-1"></i>
                            بدء التحضير

                        </a>

                        <a href="<?= clsPath::classrooms(); ?>edit.php?id=<?= $classroom->id; ?>"
                           class="btn btn-outline-primary">

                            <i class="fa fa-edit me-1"></i>
                            تعديل الفصل

                        </a>

                        <a href="<?= clsPath::classrooms(); ?>delete.php?id=<?= $classroom->id; ?>"
                           class="btn btn-outline-danger">

                            <i class="fa fa-trash me-1"></i>
                            حذف الفصل

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

<?php require_once '../../includes/footer.php'; ?>