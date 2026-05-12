<?php
require_once '../../includes/app.php';
clsHelper::requireRole(['admin', 'supervisor']);
$title = 'الفصول';

$classroomObj = new clsClassroom($conn);
$totalClasses = $classroomObj->countAll();
$classrooms = $classroomObj->getAll();
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
                    <p class="text-muted mb-0">عرض جميع الفصول الدراسية داخل النظام</p>
                </div>

                <a href="<?= clsPath::classrooms(); ?>create.php" class="btn btn-primary">
                    <i class="fa fa-plus me-1"></i>
                    إضافة فصل
                </a>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-lg-4 flip-in-hor-bottom">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-muted">إجمالي الفصول</h6>
                            <div class="d-flex justify-content-between">
                                <h3 class="mb-0"><?= $totalClasses; ?></h3>
                                <i class="fa-solid fa-chalkboard-user fs-5 text-success font-size-30"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <?php if (!empty($classrooms)): ?>
                    <?php $counter = 0; ?>
                    <?php foreach ($classrooms as $classroom): ?>
                        <?php $counter++; ?>
                        <div class="col-md-6 col-xl-3 flip-in-hor-bottom">
                            <div class="classroom-card card border-0 shadow-sm h-100">

                                <div class="card-body p-4">

                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h5 class="fw-bold mb-1">
                                                <?= clsHelper::e($classroom['class_name']); ?>
                                            </h5>

                                            <span class="badge bg-primary-subtle text-primary">
                                            <?= clsHelper::e($classroom['level_name']); ?>
                                        </span>
                                        </div>

                                        <div class="classroom-icon">
                                            <?= $counter; ?>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="text-muted small">رمز الفصل</div>
                                        <div class="fw-semibold">
                                            <?= clsHelper::e($classroom['class_code']); ?>
                                        </div>
                                    </div>

                                    <div class="row g-2 mb-4">
                                        <div class="col-6">
                                            <div class="classroom-stat">
                                                <div class="text-muted small">الطلاب</div>
                                                <strong>
                                                    <?= $classroomObj->countStudentsInClass($classroom['id']); ?>
                                                </strong>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="classroom-stat">
                                                <div class="text-muted small">تاريخ الإنشاء</div>
                                                <strong><?= clsHelper::dateOnly($classroom['created_at']); ?></strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2 flex-wrap">
                                        <a href="<?= clsPath::classrooms(); ?>view.php?id=<?= $classroom['id']; ?>"
                                           class="btn btn-sm btn-secondary">
                                            عرض
                                        </a>

                                        <a href="<?= clsPath::classrooms(); ?>edit.php?id=<?= $classroom['id']; ?>"
                                           class="btn btn-sm btn-light">
                                            تعديل
                                        </a>

                                        <a href="<?= clsPath::attendance(); ?>take.php?classroom_id=<?= $classroom['id']; ?>&attendance_date=<?= date('Y-m-d'); ?>"
                                           class="btn btn-sm btn-primary">
                                            تحضير
                                        </a>

                                        <a href="<?= clsPath::classrooms(); ?>delete.php?id=<?= $classroom['id']; ?>"
                                           class="btn btn-sm btn-outline-danger">
                                            حذف
                                        </a>
                                    </div>

                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4">لا توجد فصول حاليًا</td>
                    </tr>
                <?php endif; ?>

            </div>

        </div>
    </div>
    </div>

    </div>

<?php require_once '../../includes/footer.php'; ?>