<?php
require_once '../../includes/app.php';
clsHelper::requireRole(['admin']);
$title = 'إضافة مستخدم جديد';
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">

        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4">
            <?php require_once '../../includes/alerts.php'; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">إضافة مستخدم جديد</h1>
                    <p class="text-muted mb-0">أدخل بيانات المستخدم لإضافته إلى النظام</p>
                </div>

                <a href="<?= clsPath::users(); ?>index.php" class="btn btn-outline-secondary">
                    <i class="fa fa-arrow-right me-1"></i>
                    الرجوع
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <form action="<?= clsPath::users(); ?>store.php" method="POST">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-regular fa-address-card fs-5 text-primary"></i>
                                    الاسم الكامل
                                </label>
                                <input type="text" name="full_name" class="form-control"
                                       value="<?= clsHelper::old('full_name'); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-id-card-clip fs-5 text-primary"></i>
                                    اسم المستخدم
                                </label>
                                <input type="text" name="username" class="form-control"
                                       value="<?= clsHelper::old('username'); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-at fs-5 text-primary"></i>
                                    البريد الإلكتروني
                                </label>
                                <input type="email" name="email" class="form-control"
                                       value="<?= clsHelper::old('email'); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-lock-open fs-5 text-primary"></i>
                                    الدور
                                </label>
                                <select name="role" class="form-select">
                                    <option value="">اختر الدور</option>
                                    <option value="admin" <?= clsHelper::old('role') === 'admin' ? 'selected' : ''; ?>>
                                        مدير
                                    </option>
                                    <option value="supervisor" <?= clsHelper::old('role') === 'supervisor' ? 'selected' : ''; ?>>
                                        مشرف
                                    </option>
                                    <option value="teacher" <?= clsHelper::old('role') === 'teacher' ? 'selected' : ''; ?>>
                                        معلم
                                    </option>

                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-key fs-5 text-primary"></i>
                                    كلمة المرور
                                </label>
                                <input type="password" name="password" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-key fs-5 text-primary"></i>
                                    تأكيد كلمة المرور
                                </label>
                                <input type="password" name="confirm_password" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-user-check fs-5 text-primary"></i>
                                    الحالة
                                </label>
                                <select name="status" class="form-select">
                                    <option value="1" <?= clsHelper::old('status', '1') == '1' ? 'selected' : ''; ?>>
                                        مفعل
                                    </option>
                                    <option value="0" <?= clsHelper::old('status') === '0' ? 'selected' : ''; ?>>غير
                                        مفعل
                                    </option>
                                </select>
                            </div>

                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save me-1"></i>
                                حفظ المستخدم
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