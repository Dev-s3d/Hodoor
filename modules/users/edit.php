<?php
require_once '../../includes/app.php';
$title = 'تعديل المستخدم';

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

            <?php require_once '../../includes/alerts.php'; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">تعديل المستخدم</h1>
                    <p class="text-muted mb-0">يمكنك تعديل بيانات المستخدم الحالية</p>
                </div>

                <a href="<?= clsPath::users(); ?>index.php" class="btn btn-outline-secondary">
                    <i class="fa fa-arrow-right me-1"></i>
                    الرجوع
                </a>
            </div>
            
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <form action="<?= clsPath::users(); ?>update.php" method="POST">

                        <!-- نرسل id مخفي حتى نعرف أي مستخدم سنحدث -->
                        <input type="hidden" name="id" value="<?= clsHelper::e($user->id); ?>">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">الاسم الكامل</label>
                                <input type="text" name="full_name" class="form-control"
                                       value="<?= clsHelper::old('full_name', $user->full_name); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">اسم المستخدم</label>
                                <input type="text" name="username" class="form-control"
                                       value="<?= clsHelper::old('username', $user->username); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">البريد الإلكتروني</label>
                                <input type="email" name="email" class="form-control"
                                       value="<?= clsHelper::old('email', $user->email); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">الدور</label>
                                <?php $oldRole = clsHelper::old('role', $user->role); ?>
                                <select name="role" class="form-select">
                                    <option value="">اختر الدور</option>
                                    <option value="admin" <?= $oldRole === 'admin' ? 'selected' : ''; ?>>مدير</option>
                                    <option value="teacher" <?= $oldRole === 'teacher' ? 'selected' : ''; ?>>معلم
                                    </option>
                                    <option value="supervisor" <?= $oldRole === 'supervisor' ? 'selected' : ''; ?>>
                                        مشرف
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">الحالة</label>
                                <?php $oldStatus = clsHelper::old('status', (string)$user->status); ?>
                                <select name="status" class="form-select">
                                    <option value="1" <?= $oldStatus == '1' ? 'selected' : ''; ?>>مفعل</option>
                                    <option value="0" <?= $oldStatus == '0' ? 'selected' : ''; ?>>غير مفعل</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">كلمة المرور الجديدة</label>
                                <input type="password" name="password" class="form-control"
                                       placeholder="اتركها فارغة إذا لا تريد التغيير">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">تأكيد كلمة المرور الجديدة</label>
                                <input type="password" name="confirm_password" class="form-control"
                                       placeholder="أعد إدخال كلمة المرور الجديدة">
                            </div>

                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save me-1"></i>
                                حفظ التعديلات
                            </button>

                            <a href="<?= clsPath::users(); ?>index.php" class="btn btn-light border">
                                إلغاء
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>

    </div>

<?php require_once '../../includes/footer.php'; ?>