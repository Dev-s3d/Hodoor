<?php
require_once '../../includes/app.php';
clsHelper::requireRole(['admin', 'supervisor']);

$title = 'الطلاب';

$studentObj = new clsStudent($conn);

$woman = $studentObj->countByGender("female");
$man = $studentObj->countByGender();

$active = $studentObj->countByStatus("active");
$notActive = $studentObj->countByStatus("notActive");


$limit = 10;

$page = isset($_GET['page']) && is_numeric($_GET['page'])
        ? (int)$_GET['page']
        : 1;

if ($page < 1) {
    $page = 1;
}

$totalStudents = $studentObj->countAll();

$totalPages = ceil($totalStudents / $limit);

if ($totalPages < 1) {
    $totalPages = 1;
}

if ($page > $totalPages) {
    $page = $totalPages;
}

$offset = ($page - 1) * $limit;

$students = $studentObj->getPaginated($limit, $offset);
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
                    <p class="text-muted mb-0">عرض الطلاب مع تقسيم الصفحات</p>
                </div>

                <a href="<?= clsPath::students(); ?>create.php" class="btn btn-primary">
                    <i class="fa fa-plus me-1"></i>
                    إضافة طالب
                </a>
            </div>

            <div class="row g-3 mb-4">

                <div class="col-md-6 col-lg-2 flip-in-hor-bottom">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-muted">إجمالي الطلاب</h6>
                            <div class="d-flex justify-content-between">
                                <h3 class="mb-0 d-inline-block"><?= $totalStudents; ?></h3>
                                <i class="fa-solid fa-user-graduate fs-5 text-success font-size-30"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-2 flip-in-hor-bottom">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-muted">أنثى</h6>
                            <div class="d-flex justify-content-between">
                                <h3 class="mb-0 d-inline-block"><?= $woman; ?></h3>
                                <i class="fa-solid fa-person-dress fs-5 text-danger font-size-30"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-2 flip-in-hor-bottom">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-muted">ذكر</h6>
                            <div class="d-flex justify-content-between">
                                <h3 class="mb-0 d-inline-block"><?= $man; ?></h3>
                                <i class="fa-solid fa-person fs-5 text-primary font-size-30"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-2 flip-in-hor-bottom">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-muted">المفعلين</h6>
                            <div class="d-flex justify-content-between">
                                <h3 class="mb-0 d-inline-block"><?= $active; ?></h3>
                                <i class="fa-solid fa-check fs-5 text-success font-size-30"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-2 flip-in-hor-bottom">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-muted">الغير مفعلين</h6>
                            <div class="d-flex justify-content-between">
                                <h3 class="mb-0 d-inline-block"><?= $notActive; ?></h3>
                                <i class="fa-solid fa-xmark fs-5 text-danger font-size-30"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="text-muted">
                            الصفحة <?= $page; ?> من <?= $totalPages; ?>
                        </div>

                        <div class="text-muted">
                            عرض <?= count($students); ?> من أصل <?= $totalStudents; ?> طالب
                        </div>
                    </div>

                    <div class="table-responsive text-center">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>اسم الطالب</th>
                                <th>رقم الطالب</th>
                                <th>الفصل</th>
                                <th>الجنس</th>
                                <th>جوال الطالب</th>
                                <th>اسم ولي الامر</th>
                                <th>جوال ولي الامر</th>
                                <th>الحالة</th>
                                <th>العمليات</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php if (!empty($students)): ?>
                                <?php foreach ($students as $index => $student): ?>
                                    <tr>
                                        <td><?= $offset + $index + 1; ?></td>

                                        <td><?= clsHelper::e($student['student_name']); ?></td>

                                        <td><?= clsHelper::e($student['student_number']); ?></td>

                                        <td><?= clsHelper::e($student['class_name'] ?? '-'); ?></td>

                                        <td>
                                            <?= $student['gender'] === 'female' ? 'أنثى' : 'ذكر'; ?>
                                        </td>
                                        <td><?= clsHelper::e($student['phone']); ?></td>
                                        <td><?= clsHelper::e($student['parent_name']); ?></td>
                                        <td><?= clsHelper::e($student['parent_phone']); ?></td>

                                        <td>
                                            <?php if ((int)$student['status'] === 1): ?>
                                                <span class="badge bg-success">مفعل</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">غير مفعل</span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="d-flex gap-1 flex-wrap justify-content-center">
                                            <a href="<?= clsPath::students(); ?>view.php?id=<?= $student['id']; ?>"
                                               class="btn btn-sm btn-secondary">
                                                عرض
                                            </a>

                                            <a href="<?= clsPath::students(); ?>edit.php?id=<?= $student['id']; ?>"
                                               class="btn btn-sm btn-primary">
                                                تعديل
                                            </a>

                                            <a href="<?= clsPath::students(); ?>delete.php?id=<?= $student['id']; ?>"
                                               class="btn btn-sm btn-danger">
                                                حذف
                                            </a>
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

                    <?php if ($totalPages > 1): ?>
                        <nav class="mt-4">
                            <ul class="pagination justify-content-center">

                                <li class="page-item <?= $page <= 1 ? 'disabled' : ''; ?>">
                                    <a class="page-link"
                                       href="<?= clsPath::students(); ?>index.php?page=<?= $page - 1; ?>">
                                        السابق
                                    </a>
                                </li>

                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?= $page == $i ? 'active' : ''; ?>">
                                        <a class="page-link"
                                           href="<?= clsPath::students(); ?>index.php?page=<?= $i; ?>">
                                            <?= $i; ?>
                                            
                                        </a>
                                    </li>
                                <?php endfor; ?>

                                <li class="page-item <?= $page >= $totalPages ? 'disabled' : ''; ?>">
                                    <a class="page-link"
                                       href="<?= clsPath::students(); ?>index.php?page=<?= $page + 1; ?>">
                                        التالي
                                    </a>
                                </li>

                            </ul>
                        </nav>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>

<?php require_once '../../includes/footer.php'; ?>