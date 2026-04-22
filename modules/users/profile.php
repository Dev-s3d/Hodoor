<?php
require_once '../../includes/app.php';
$title = 'الملف الشخصي';

$user = new clsUser($conn);

if (!$user->loadById($_SESSION['user_id'])) {
    clsHelper::setMessage('error', 'تعذر تحميل بيانات المستخدم');
    clsHelper::redirect(clsPath::dashboardIndex());
}
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">

        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4">

            <?php require_once '../../includes/alerts.php'; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">الملف الشخصي</h1>
                    <p class="text-muted mb-0">عرض وتعديل بيانات المستخدم الحالي</p>
                </div>

                <a href="<?= clsPath::changePassword(); ?>" class="btn btn-outline-primary">
                    <i class="fa fa-key me-1"></i>
                    تغيير كلمة المرور
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <form action="<?= clsPath::profileUpdate(); ?>" method="POST">

                        <input type="hidden" name="id" value="<?= clsHelper::e($user->id); ?>">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">الاسم الكامل</label>
                                <input
                                        type="text"
                                        name="full_name"
                                        class="form-control"
                                        value="<?= clsHelper::old('full_name', $user->full_name); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">اسم المستخدم</label>
                                <input
                                        type="text"
                                        name="username"
                                        class="form-control"
                                        value="<?= clsHelper::old('username', $user->username); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">البريد الإلكتروني</label>
                                <input
                                        type="email"
                                        name="email"
                                        class="form-control"
                                        value="<?= clsHelper::old('email', $user->email); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">الدور</label>
                                <input
                                        type="text"
                                        class="form-control"
                                        value="<?= clsHelper::e($user->role); ?>"
                                        disabled>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">الحالة</label>
                                <input
                                        type="text"
                                        class="form-control"
                                        value="<?= (int)$user->status === 1 ? 'مفعل' : 'غير مفعل'; ?>"
                                        disabled>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">تاريخ الإنشاء</label>
                                <input
                                        type="text"
                                        class="form-control"
                                        value="<?= clsHelper::e($user->created_at); ?>"
                                        disabled>
                            </div>

                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save me-1"></i>
                                حفظ التعديلات
                            </button>

                            <a href="<?= clsPath::dashboardIndex(); ?>" class="btn btn-light border">
                                رجوع
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>

    </div>

<?php require_once '../../includes/footer.php'; ?>