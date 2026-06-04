<?php
require_once '../../includes/app.php';
clsHelper::requireRole(['admin', 'supervisor']);

$title = 'الطلاب';

$studentObj = new clsStudent($conn);

$search = $_GET['search'] ?? '';
$gender = $_GET['gender'] ?? '';
$status = $_GET['status'] ?? '';

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

$totalStudents = $studentObj->countFiltered($search, $gender, $status);

$totalPages = ceil($totalStudents / $limit);

if ($totalPages < 1) {
    $totalPages = 1;
}

if ($page > $totalPages) {
    $page = $totalPages;
}

$offset = ($page - 1) * $limit;

$students = $studentObj->getPaginated($limit, $offset, $search, $gender, $status);

$queryString = http_build_query([
        'search' => $search,
        'gender' => $gender,
        'status' => $status
]);
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">
        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4 students">

            <?php require_once '../../includes/alerts.php'; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">الطلاب</h1>
                    <p class="text-muted mb-0">عرض الطلاب مع البحث والفلترة وتقسيم الصفحات</p>
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
                                <h3 class="mb-0 d-inline-block"><?= clsHelper::e($totalStudents); ?></h3>
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
                                <h3 class="mb-0 d-inline-block"><?= clsHelper::e($woman); ?></h3>
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
                                <h3 class="mb-0 d-inline-block"><?= clsHelper::e($man); ?></h3>
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
                                <h3 class="mb-0 d-inline-block"><?= clsHelper::e($active); ?></h3>
                                <i class="fa-solid fa-check fs-5 text-success font-size-30"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-2 flip-in-hor-bottom">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-muted">غير المفعلين</h6>
                            <div class="d-flex justify-content-between">
                                <h3 class="mb-0 d-inline-block"><?= clsHelper::e($notActive); ?></h3>
                                <i class="fa-solid fa-xmark fs-5 text-danger font-size-30"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">

                    <form method="GET" class="row g-3 align-items-end">

                        <div class="col-md-4">
                            <label class="form-label">بحث</label>
                            <input type="text"
                                   name="search"
                                   class="form-control"
                                   placeholder="اسم الطالب، رقم الطالب، رقم الجوال"
                                   value="<?= clsHelper::e($search); ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">الجنس</label>
                            <select name="gender" class="form-select">
                                <option value="">كل الطلاب</option>
                                <option value="male" <?= $gender === 'male' ? 'selected' : ''; ?>>ذكر</option>
                                <option value="female" <?= $gender === 'female' ? 'selected' : ''; ?>>أنثى</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">الحالة</label>
                            <select name="status" class="form-select">
                                <option value="">كل الحالات</option>
                                <option value="1" <?= $status === '1' ? 'selected' : ''; ?>>مفعل</option>
                                <option value="0" <?= $status === '0' ? 'selected' : ''; ?>>غير مفعل</option>
                            </select>
                        </div>

                        <div class="col-md-2 d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100" title="بحث">
                                <i class="fa fa-search"></i>
                            </button>

                            <a href="<?= clsPath::students(); ?>index.php"
                               class="btn btn-outline-secondary"
                               title="إعادة تعيين">
                                <i class="fa fa-rotate-right"></i>
                            </a>
                        </div>

                    </form>

                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="text-muted">
                            الصفحة <?= clsHelper::e($page); ?> من <?= clsHelper::e($totalPages); ?>
                        </div>

                        <div class="text-muted">
                            عرض <?= clsHelper::e(count($students)); ?> من أصل <?= clsHelper::e($totalStudents); ?> طالب
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
                                <th>اسم ولي الأمر</th>
                                <th>جوال ولي الأمر</th>
                                <th>الحالة</th>
                                <th>العمليات</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php if (!empty($students)): ?>
                                <?php foreach ($students as $index => $student): ?>
                                    <tr>
                                        <td><?= clsHelper::e($offset + $index + 1); ?></td>

                                        <td><?= clsHelper::e($student['student_name']); ?></td>

                                        <td><?= clsHelper::e($student['student_number']); ?></td>

                                        <td><?= clsHelper::e($student['class_name'] ?? '-'); ?></td>

                                        <td>
                                            <?php if ($student['gender'] === 'female'): ?>
                                                <span class="badge bg-danger font-weight-500 px-3">أنثى</span>
                                            <?php else: ?>
                                                <span class="badge bg-primary font-weight-500 px-3">ذكر</span>
                                            <?php endif; ?>
                                        </td>

                                        <td><?= clsHelper::e($student['phone']); ?></td>

                                        <td><?= clsHelper::e($student['parent_name']); ?></td>

                                        <td><?= clsHelper::e($student['parent_phone']); ?></td>

                                        <td>
                                            <?php if ((int)$student['status'] === 1): ?>
                                                <span class="badge bg-success font-weight-500 px-3">مفعل</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary font-weight-500 px-3">غير مفعل</span>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <div class="d-flex gap-1 flex-wrap justify-content-center">

                                                <a href="<?= clsPath::students(); ?>view.php?id=<?= $student['id']; ?>"
                                                   class="btn btn-sm btn-outline-secondary"
                                                   title="عرض">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                <a href="<?= clsPath::students(); ?>edit.php?id=<?= $student['id']; ?>"
                                                   class="btn btn-sm btn-outline-primary"
                                                   title="تعديل">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <a href="<?= clsPath::students(); ?>delete.php?id=<?= $student['id']; ?>"
                                                   class="btn btn-sm btn-outline-danger"
                                                   title="حذف">
                                                    <i class="fa fa-trash"></i>
                                                </a>

                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        لا يوجد طلاب مطابقون لنتائج البحث
                                    </td>
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
                                       href="<?= clsPath::students(); ?>index.php?page=<?= $page - 1; ?>&<?= $queryString; ?>">
                                        السابق
                                    </a>
                                </li>

                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?= $page == $i ? 'active' : ''; ?>">
                                        <a class="page-link"
                                           href="<?= clsPath::students(); ?>index.php?page=<?= $i; ?>&<?= $queryString; ?>">
                                            <?= clsHelper::e($i); ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>

                                <li class="page-item <?= $page >= $totalPages ? 'disabled' : ''; ?>">
                                    <a class="page-link"
                                       href="<?= clsPath::students(); ?>index.php?page=<?= $page + 1; ?>&<?= $queryString; ?>">
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