<?php
require_once '../../includes/app.php';
clsHelper::requireRole(['admin']);
$title = 'عرض المستخدم';


$id = clsHelper::get('id');
$user = new clsUser($conn);
if (!$id || !$user->loadById($id)) {
    clsHelper::setMessage('error', 'المستخدم غير موجود');
    clsHelper::redirect(clsPath::users() . 'index.php');
}
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">

        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">عرض المستخدم</h1>
                    <p class="text-muted mb-0">تفاصيل المستخدم المحدد</p>
                </div>

                <div class="d-flex gap-2">
                    <a href="<?= clsPath::users(); ?>edit.php?id=<?= $user->id; ?>" class="btn btn-primary">
                        <i class="fa fa-pen me-1"></i>
                        تعديل
                    </a>

                    <a href="<?= clsPath::users(); ?>index.php" class="btn btn-outline-secondary">
                        <i class="fa fa-arrow-right me-1"></i>
                        الرجوع
                    </a>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <div class="row g-4">

                        <div class="col-md-6">
                            <label class="form-label text-muted">
                                <i class="fa-regular fa-address-card fs-5 text-primary"></i>
                                الاسم الكامل
                            </label>
                            <div class="fw-semibold"><?= clsHelper::e($user->full_name); ?></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">
                                <i class="fa-solid fa-id-card-clip fs-5 text-primary"></i>
                                اسم المستخدم
                            </label>
                            <div class="fw-semibold"><?= clsHelper::e($user->username); ?></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">
                                <i class="fa-solid fa-at fs-5 text-primary"></i>
                                البريد الإلكتروني
                            </label>
                            <?php if ($user->email): ?>
                                <div class="fw-semibold"><?= clsHelper::e($user->email); ?></div>
                            <?php else: ?>
                                <div class="fw-semibold">لايوجد</div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">
                                <i class="fa-solid fa-lock-open fs-5 text-primary"></i>
                                الدور
                            </label>
                            <div class="fw-semibold">
                                <?php if ($user->role === 'admin'): ?>
                                    <span class="badge bg-danger font-weight-500 px-3">مدير</span>
                                <?php elseif ($user->role === 'teacher'): ?>
                                    <span class="badge bg-primary font-weight-500 px-3">معلم</span>
                                <?php elseif ($user->role === 'supervisor'): ?>
                                    <span class="badge bg-warning text-dark font-weight-500 px-3">مشرف</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary font-weight-500 px-3"><?= clsHelper::e($user->role); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">
                                <i class="fa-solid fa-user-check fs-5 text-primary"></i>
                                الحالة
                            </label>
                            <div class="fw-semibold">
                                <?php if ((int)$user->status === 1): ?>
                                    <span class="badge bg-success font-weight-500 px-3">مفعل</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary font-weight-500 px-3">غير مفعل</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">
                                <i class="fa-solid fa-calendar-days f2-5 text-primary"></i>
                                تاريخ الإنشاء
                            </label>
                            <div class="fw-semibold"><?= clsHelper::e($user->created_at); ?></div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>

<?php require_once '../../includes/footer.php'; ?>