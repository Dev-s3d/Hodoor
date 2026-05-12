<?php
require_once '../../includes/app.php';
clsHelper::requireRole(['admin', 'supervisor']);
$title = 'إضافة طالب جديد';

$classroomObj = new clsClassroom($conn);
$classrooms = $classroomObj->getAll();
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">
        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4">
            <?php require_once '../../includes/alerts.php'; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">إضافة طالب جديد</h1>
                    <p class="text-muted mb-0">أدخل بيانات الطالب لإضافته إلى النظام</p>
                </div>

                <a href="<?= clsPath::students(); ?>index.php" class="btn btn-outline-secondary">
                    <i class="fa fa-arrow-right me-1"></i>
                    الرجوع
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <form action="<?= clsPath::students(); ?>store.php" method="POST">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-address-card fs-5 text-primary"></i>
                                    اسم الطالب
                                </label>
                                <input type="text" name="student_name" class="form-control"
                                       value="<?= clsHelper::old('student_name'); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-fingerprint fs-5 text-primary"></i>
                                    رقم الطالب
                                </label>
                                <input type="text" name="student_number" class="form-control"
                                       value="<?= clsHelper::old('student_number'); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-chalkboard fs-5 text-primary"></i>
                                    الفصل
                                </label>
                                <select name="classroom_id" class="form-select">
                                    <option value="">اختر الفصل</option>
                                    <?php foreach ($classrooms as $classroom): ?>
                                        <option value="<?= $classroom['id']; ?>" <?= clsHelper::old('classroom_id') == $classroom['id'] ? 'selected' : ''; ?>>
                                            <?= clsHelper::e($classroom['class_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-person-half-dress fs-5 text-primary"></i>
                                    الجنس
                                </label>
                                <select name="gender" class="form-select">
                                    <option value="male" <?= clsHelper::old('gender', 'male') === 'male' ? 'selected' : ''; ?>>
                                        ذكر
                                    </option>
                                    <option value="female" <?= clsHelper::old('gender') === 'female' ? 'selected' : ''; ?>>
                                        أنثى
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-cake-candles fs-5 text-primary"></i>
                                    تاريخ الميلاد
                                </label>
                                <input type="date" name="birth_date" class="form-control"
                                       value="<?= clsHelper::old('birth_date'); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-mobile-screen-button fs-5 text-primary"></i>
                                    هاتف الطالب
                                </label>
                                <input type="text" name="phone" class="form-control"
                                       value="<?= clsHelper::old('phone'); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-person-breastfeeding fs-5 text-primary"></i>
                                    اسم ولي الأمر
                                </label>
                                <input type="text" name="parent_name" class="form-control"
                                       value="<?= clsHelper::old('parent_name'); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-mobile-screen-button fs-5 text-primary"></i>
                                    هاتف ولي الأمر
                                </label>
                                <input type="text" name="parent_phone" class="form-control"
                                       value="<?= clsHelper::old('parent_phone'); ?>">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">
                                    <i class="fa-solid fa-location-dot fs-5 text-primary"></i>
                                    العنوان
                                </label>
                                <textarea name="address" class="form-control"
                                          rows="3"><?= clsHelper::old('address'); ?></textarea>
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
                                حفظ الطالب
                            </button>

                            <a href="<?= clsPath::students(); ?>index.php" class="btn btn-light border">
                                إلغاء
                            </a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

<?php require_once '../../includes/footer.php'; ?>