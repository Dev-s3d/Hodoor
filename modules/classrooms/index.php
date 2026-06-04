<?php
require_once '../../includes/app.php';

clsHelper::requireRole(['admin', 'supervisor']);

$title = 'الفصول';

$classroomObj = new clsClassroom($conn);

$search = trim($_GET['search'] ?? '');

$totalClasses = $classroomObj->countAll();
$classrooms = $classroomObj->getAll($search);

$totalStudents = 0;

foreach ($classrooms as $classroom) {
    $totalStudents += $classroomObj->countStudentsInClass($classroom['id']);
}

$avgStudents = count($classrooms)
        ? round($totalStudents / count($classrooms))
        : 0;
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

<div class="main-content w-100">

    <?php require_once '../../includes/navbar.php'; ?>

    <div class="content p-4">

        <?php require_once '../../includes/alerts.php'; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mb-1">الفصول</h1>
                <p class="text-muted mb-0">
                    عرض جميع الفصول الدراسية داخل النظام
                </p>
            </div>

            <a href="<?= clsPath::classrooms(); ?>create.php"
               class="btn btn-primary">
                <i class="fa fa-plus me-1"></i>
                إضافة فصل
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">

                <form method="GET">

                    <div class="row g-3">

                        <div class="col-md-10">
                            <input type="text"
                                   name="search"
                                   class="form-control"
                                   placeholder="اسم الفصل أو الرمز أو المرحلة"
                                   value="<?= clsHelper::e($search); ?>">
                        </div>

                        <div class="col-md-2 d-flex gap-2">

                            <button class="btn btn-primary w-100">
                                <i class="fa fa-search"></i>
                            </button>

                            <a href="<?= clsPath::classrooms(); ?>index.php"
                               class="btn btn-outline-secondary">
                                <i class="fa fa-rotate-right"></i>
                            </a>

                        </div>

                    </div>

                </form>

            </div>
        </div>

        <div class="row g-3 mb-4">

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">إجمالي الفصول</h6>

                        <div class="d-flex justify-content-between">
                            <h3><?= $totalClasses; ?></h3>
                            <i class="fa fa-school text-primary font-size-30"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">إجمالي الطلاب</h6>

                        <div class="d-flex justify-content-between">
                            <h3><?= $totalStudents; ?></h3>
                            <i class="fa fa-users text-success font-size-30"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">متوسط الطلاب</h6>

                        <div class="d-flex justify-content-between">
                            <h3><?= $avgStudents; ?></h3>
                            <i class="fa fa-chart-column text-warning font-size-30"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row g-5">

            <?php if (!empty($classrooms)): ?>

                <?php foreach ($classrooms as $index => $classroom): ?>

                    <?php
                    $studentsCount =
                            $classroomObj->countStudentsInClass($classroom['id']);
                    ?>

                    <div class="col-md-6 col-xl-4">

                        <div class="classroom-card-modern position-relative overflow-hidden h-100">

                            <div class="classroom-top">

                                <div class="d-flex justify-content-between align-items-start">

                                    <div>

                                        <div class="classroom-level mb-2">
                                            <?= clsHelper::e($classroom['level_name']); ?>
                                        </div>

                                        <h4 class="classroom-title mb-1">
                                            <?= clsHelper::e($classroom['class_name']); ?>
                                        </h4>

                                        <div class="classroom-code">
                                            <?= clsHelper::e($classroom['class_code']); ?>
                                        </div>

                                    </div>

                                    <div class="classroom-number">
                                        <?= $index + 1; ?>
                                    </div>

                                </div>

                            </div>

                            <div class="classroom-body">

                                <div class="row g-3 mb-4">

                                    <div class="col-6">

                                        <div class="classroom-box">

                                            <div class="classroom-box-icon bg-primary-subtle text-primary">
                                                <i class="fa fa-users"></i>
                                            </div>

                                            <div>

                                                <small>عدد الطلاب</small>

                                                <div class="mt-1">
                                                    <span class="badge bg-primary px-3 py-2">
                                                        <?= $studentsCount; ?> طالب
                                                    </span>
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-6">

                                        <div class="classroom-box">

                                            <div class="classroom-box-icon bg-success-subtle text-success">
                                                <i class="fa fa-calendar"></i>
                                            </div>

                                            <div>

                                                <small>الإنشاء</small>

                                                <h6 class="mb-0">
                                                    <?= clsHelper::dateOnly($classroom['created_at']); ?>
                                                </h6>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="d-grid gap-2">

                                    <a href="<?= clsPath::attendance(); ?>take.php?classroom_id=<?= $classroom['id']; ?>&attendance_date=<?= date('Y-m-d'); ?>"
                                       class="btn btn-primary classroom-btn-main">

                                        <i class="fa fa-check-circle me-1"></i>
                                        بدء التحضير

                                    </a>

                                    <a href="<?= clsPath::students(); ?>index.php?classroom_id=<?= $classroom['id']; ?>"
                                       class="btn btn-outline-secondary w-100">

                                        <i class="fa fa-users me-1"></i>
                                        الطلاب

                                    </a>

                                    <div class="d-flex gap-2">

                                        <a href="<?= clsPath::classrooms(); ?>view.php?id=<?= $classroom['id']; ?>"
                                           class="btn btn-light w-100"
                                           title="عرض">

                                            <i class="fa fa-eye"></i>

                                        </a>

                                        <a href="<?= clsPath::classrooms(); ?>edit.php?id=<?= $classroom['id']; ?>"
                                           class="btn btn-light w-100"
                                           title="تعديل">

                                            <i class="fa fa-edit"></i>

                                        </a>

                                        <a href="<?= clsPath::classrooms(); ?>delete.php?id=<?= $classroom['id']; ?>"
                                           class="btn btn-outline-danger"
                                           title="حذف">

                                            <i class="fa fa-trash"></i>

                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="col-12">

                    <div class="empty-classrooms text-center py-5">

                        <div class="mb-3">
                            <i class="fa fa-school fa-4x text-secondary opacity-50"></i>
                        </div>

                        <h4 class="mb-2">
                            لا توجد فصول حالياً
                        </h4>

                        <p class="text-muted">
                            قم بإضافة فصل جديد للبدء في إدارة الطلاب والحضور
                        </p>

                        <a href="<?= clsPath::classrooms(); ?>create.php"
                           class="btn btn-primary mt-2">

                            <i class="fa fa-plus me-1"></i>
                            إضافة فصل

                        </a>

                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<?php require_once '../../includes/footer.php'; ?>
```
