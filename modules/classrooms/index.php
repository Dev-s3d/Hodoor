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
                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-muted">إجمالي الفصول</h6>
                            <h3 class="mb-0"><?= $totalClasses; ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>اسم الفصل</th>
                                <th>رمز الفصل</th>
                                <th>المرحلة / المستوى</th>
                                <th>تاريخ الإنشاء</th>
                                <th>العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($classrooms)): ?>
                                <?php foreach ($classrooms as $classroom): ?>
                                    <tr>
                                        <td><?= clsHelper::e($classroom['id']); ?></td>
                                        <td><?= clsHelper::e($classroom['class_name']); ?></td>
                                        <td><?= clsHelper::e($classroom['class_code']); ?></td>
                                        <td><?= clsHelper::e($classroom['level_name']); ?></td>
                                        <td><?= clsHelper::dateOnly($classroom['created_at']); ?></td>
                                        <td class="d-flex gap-1 flex-wrap">
                                            <a href="<?= clsPath::classrooms(); ?>view.php?id=<?= $classroom['id']; ?>"
                                               class="btn btn-sm btn-outline-info">
                                                عرض
                                            </a>

                                            <a href="<?= clsPath::classrooms(); ?>edit.php?id=<?= $classroom['id']; ?>"
                                               class="btn btn-sm btn-outline-primary">
                                                تعديل
                                            </a>

                                            <a href="<?= clsPath::classrooms(); ?>delete.php?id=<?= $classroom['id']; ?>"
                                               class="btn btn-sm btn-outline-danger">
                                                حذف
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">لا توجد فصول حاليًا</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>

    </div>

<?php require_once '../../includes/footer.php'; ?>