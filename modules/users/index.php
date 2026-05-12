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

$users = $userObj->getAllUsers()
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
                                        <td class="d-flex gap-1 flex-wrap justify-content-center">
                                            <a href="<?= clsPath::users(); ?>view.php?id=<?= $user['id']; ?>"
                                               class="btn btn-sm btn-secondary">عرض</a>
                                            <a href="<?= clsPath::users(); ?>edit.php?id=<?= $user['id']; ?>"
                                               class="btn btn-sm btn-primary">تعديل</a>
                                            <a href="<?= clsPath::users(); ?>delete.php?id=<?= $user['id']; ?>"
                                               class="btn btn-sm btn-danger">حذف</a>
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