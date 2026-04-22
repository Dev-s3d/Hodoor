<?php
require_once '../../includes/app.php';
$title = 'الطلاب';

$studentObj = new clsStudent($conn);
$totalStudents = $studentObj->countAll();
$students = $studentObj->getAll();
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">
        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4">
            <?php require_once '../../includes/alerts.php'; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">الطلاب</h1>
                    <p class="text-muted mb-0">عرض جميع الطلاب داخل النظام</p>
                </div>

                <a href="<?= clsPath::students(); ?>create.php" class="btn btn-primary">
                    <i class="fa fa-plus me-1"></i>
                    إضافة طالب
                </a>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-muted">إجمالي الطلاب</h6>
                            <h3 class="mb-0"><?= $totalStudents; ?></h3>
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
                                <th>اسم الطالب</th>
                                <th>رقم الطالب</th>
                                <th>الفصل</th>
                                <th>الجنس</th>
                                <th>الحالة</th>
                                <th>العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($students)): ?>
                                <?php foreach ($students as $student): ?>
                                    <tr>
                                        <td><?= clsHelper::e($student['id']); ?></td>
                                        <td><?= clsHelper::e($student['student_name']); ?></td>
                                        <td><?= clsHelper::e($student['student_number']); ?></td>
                                        <td><?= clsHelper::e($student['class_name'] ?? '-'); ?></td>
                                        <td><?= $student['gender'] === 'female' ? 'أنثى' : 'ذكر'; ?></td>
                                        <td>
                                            <?php if ((int)$student['status'] === 1): ?>
                                                <span class="badge bg-success">مفعل</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">غير مفعل</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="d-flex gap-1 flex-wrap">
                                            <a href="<?= clsPath::students(); ?>view.php?id=<?= $student['id']; ?>"
                                               class="btn btn-sm btn-outline-info">عرض</a>
                                            <a href="<?= clsPath::students(); ?>edit.php?id=<?= $student['id']; ?>"
                                               class="btn btn-sm btn-outline-primary">تعديل</a>
                                            <a href="<?= clsPath::students(); ?>delete.php?id=<?= $student['id']; ?>"
                                               class="btn btn-sm btn-outline-danger">حذف</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4">لا يوجد طلاب حاليًا</td>
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