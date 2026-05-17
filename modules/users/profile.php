<?php
require_once '../../includes/app.php';
$title = 'الملف الشخصي';

$user = new clsUser($conn);

if (!$user->loadById(clsHelper::auth('user_id'))) {
    clsHelper::setMessage('error', 'تعذر تحميل بيانات المستخدم');
    clsHelper::redirect(clsPath::dashboardIndex());
}
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">

        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">الملف الشخصي</h1>
                    <p class="text-muted mb-0">عرض بيانات المستخدم الحالي</p>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">رقم المعرف</label>
                            <input
                                    type="text"
                                    name="id"
                                    class="form-control"
                                    value="<?= (int)$user->id; ?>"
                                    disabled>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">الاسم الكامل</label>
                            <input
                                    type="text"
                                    name="full_name"
                                    class="form-control"
                                    value="<?= clsHelper::e($user->full_name); ?>"
                                    disabled>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">اسم المستخدم</label>
                            <input
                                    type="text"
                                    name="username"
                                    class="form-control"
                                    value="<?= clsHelper::e($user->username); ?>"
                                    disabled>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input
                                    type="email"
                                    name="email"
                                    class="form-control text-start"
                                    value="<?= clsHelper::e($user->email); ?>"
                                    disabled
                            >
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
                        <a href="<?= clsPath::dashboardIndex(); ?>" class="btn btn-light border">
                            رجوع
                        </a>
                    </div>


                </div>
            </div>

        </div>

    </div>

<?php require_once '../../includes/footer.php'; ?>