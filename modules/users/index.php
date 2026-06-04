<?php
require_once '../../includes/app.php';
clsHelper::requireRole(['admin']);
$title = 'المستخدمين';

$userObj = new clsUser($conn);

$totalUsers = $userObj->countAll();
$totalAdmins = $userObj->countByRole('admin');
$totalTeachers = $userObj->countByRole('teacher');
$totalSupervisors = $userObj->countByRole('supervisor');

$active = $userObj->countByStatus();
$notActive = $userObj->countByStatus("notActive");

$search = $_GET['search'] ?? '';
$role = $_GET['role'] ?? '';
$status = $_GET['status'] ?? '';

$users = $userObj->getAllUsers($search, $role, $status);
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">

        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4 users">

            <?php require_once '../../includes/alerts.php'; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">المستخدمين</h1>
                    <p class="text-muted mb-0">عرض جميع مستخدمي النظام وإحصائياتهم</p>
                </div>

                <a href="<?= clsPath::users(); ?>create.php" class="btn btn-primary">
                    <i class="fa fa-plus me-1"></i>
                    إضافة مستخدم
                </a>
            </div>

            <div class="row g-3 mb-4">

                <div class="col-md-6 col-lg-2 flip-in-hor-bottom">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-muted">إجمالي المستخدمين</h6>
                            <div class="d-flex justify-content-between">
                                <h3 class="mb-0 d-inline-block"><?= $totalUsers; ?></h3>
                                <i class="fa-solid fa-users fs-5 text-success font-size-30"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-2 flip-in-hor-bottom">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-muted">المدراء</h6>
                            <div class="d-flex justify-content-between">
                                <h3 class="mb-0 d-inline-block"><?= $totalAdmins; ?></h3>
                                <i class="fa-solid fa-user-tie fs-5 text-danger font-size-30"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-2 flip-in-hor-bottom">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-muted">المعلمون</h6>
                            <div class="d-flex justify-content-between">
                                <h3 class="mb-0 d-inline-block"><?= $totalTeachers; ?></h3>
                                <i class="fa-solid fa-person-chalkboard fs-5 text-primary font-size-30"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-2 flip-in-hor-bottom">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-muted">المشرفون</h6>
                            <div class="d-flex justify-content-between">
                                <h3 class="mb-0 d-inline-block"><?= $totalSupervisors; ?></h3>
                                <i class="fa-solid fa-user-group fs-5 text-warning font-size-30"></i>
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
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">

                    <form method="GET" class="row g-3 align-items-end">

                        <div class="col-md-4">
                            <label class="form-label">بحث</label>
                            <input type="text"
                                   name="search"
                                   class="form-control"
                                   placeholder="الاسم، اسم المستخدم، البريد"
                                   value="<?= clsHelper::e($search); ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">الدور</label>
                            <select name="role" class="form-select">
                                <option value="">كل الأدوار</option>
                                <option value="admin" <?= $role === 'admin' ? 'selected' : ''; ?>>مدير</option>
                                <option value="supervisor" <?= $role === 'supervisor' ? 'selected' : ''; ?>>مشرف
                                </option>
                                <option value="teacher" <?= $role === 'teacher' ? 'selected' : ''; ?>>معلم</option>
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

                            <a href="<?= clsPath::users(); ?>index.php"
                               class="btn btn-outline-secondary"
                               title="إعادة تعيين">
                                <i class="fa fa-rotate-right"></i>
                            </a>
                        </div>

                    </form>

                </div>
            </div>
            <div class="card shadow-sm border-0 ">
                <div class="card-body">
                    <div class="table-responsive text-center">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>الاسم الكامل</th>
                                <th>اسم المستخدم</th>
                                <th>البريد الإلكتروني</th>
                                <th>الدور</th>
                                <th>الحالة</th>
                                <th>تاريخ الإنشاء</th>
                                <th>العمليات</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php if (!empty($users)): ?>
                                <?php $counter = 1; ?>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= clsHelper::e($counter); ?></td>
                                        <td><?= clsHelper::e($user['full_name']); ?></td>
                                        <td><?= clsHelper::e($user['username']); ?></td>

                                        <?php if (!empty($user['email'])): ?>
                                            <td><?= clsHelper::e($user['email']); ?></td>
                                        <?php else: ?>
                                            <td>لايوجد</td>
                                        <?php endif; ?>

                                        <td>
                                            <?php if ($user['role'] === 'admin'): ?>
                                                <span class="badge bg-danger font-weight-500 px-3">مدير</span>
                                            <?php elseif ($user['role'] === 'teacher'): ?>
                                                <span class="badge bg-primary font-weight-500 px-3">معلم</span>
                                            <?php elseif ($user['role'] === 'supervisor'): ?>
                                                <span class="badge bg-warning text-dark font-weight-500 px-3">مشرف</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary font-weight-500 px-3"><?= clsHelper::e($user['role']); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ((int)$user['status'] === 1): ?>
                                                <span class="badge bg-success font-weight-500 px-3">مفعل</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary font-weight-500 px-3">غير مفعل</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= clsHelper::e(clsHelper::dateOnly($user['created_at'])); ?></td>
                                        <td>
                                            <div class="d-flex gap-1 flex-wrap justify-content-center">
                                                <a href="<?= clsPath::users(); ?>view.php?id=<?= $user['id']; ?>"
                                                   class="btn btn-sm btn-outline-secondary"
                                                   title="عرض">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                <a href="<?= clsPath::users(); ?>edit.php?id=<?= $user['id']; ?>"
                                                   class="btn btn-sm btn-outline-primary"
                                                   title="تعديل">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <?php if ((int)$user['id'] !== (int)clsHelper::auth('user_id')): ?>
                                                    <a href="<?= clsPath::users(); ?>delete.php?id=<?= $user['id']; ?>"
                                                       class="btn btn-sm btn-outline-danger"
                                                       title="حذف">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $counter++; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4">لا يوجد مستخدمون حاليًا</td>
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