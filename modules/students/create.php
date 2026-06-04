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

        <div class="content p-4 students">

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

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">

                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                             style="width:75px;height:75px;">
                            <i class="fa fa-user-plus text-primary fs-2"></i>
                        </div>

                        <div>
                            <h4 class="mb-1">طالب جديد</h4>
                            <p class="text-muted mb-0">
                                قم بتعبئة البيانات الأساسية وبيانات ولي الأمر
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <form action="<?= clsPath::students(); ?>store.php" method="POST">

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">

                        <h5 class="mb-4">
                            <i class="fa fa-id-card text-primary me-1"></i>
                            البيانات الأساسية
                        </h5>

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-address-card text-primary me-1"></i>
                                    اسم الطالب
                                </label>
                                <input type="text"
                                       name="student_name"
                                       class="form-control"
                                       value="<?= clsHelper::old('student_name'); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-fingerprint text-primary me-1"></i>
                                    رقم الطالب
                                </label>
                                <input type="text"
                                       name="student_number"
                                       class="form-control"
                                       value="<?= clsHelper::old('student_number'); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-chalkboard text-primary me-1"></i>
                                    الفصل
                                </label>
                                <select name="classroom_id" class="form-select">
                                    <option value="">اختر الفصل</option>
                                    <?php foreach ($classrooms as $classroom): ?>
                                        <option value="<?= $classroom['id']; ?>"
                                                <?= clsHelper::old('classroom_id') == $classroom['id'] ? 'selected' : ''; ?>>
                                            <?= clsHelper::e($classroom['class_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-person-half-dress text-primary me-1"></i>
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
                                    <i class="fa-solid fa-cake-candles text-primary me-1"></i>
                                    تاريخ الميلاد
                                </label>
                                <input type="date"
                                       name="birth_date"
                                       class="form-control"
                                       value="<?= clsHelper::old('birth_date'); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-user-check text-primary me-1"></i>
                                    الحالة
                                </label>
                                <select name="status" class="form-select">
                                    <option value="1" <?= clsHelper::old('status', '1') == '1' ? 'selected' : ''; ?>>
                                        مفعل
                                    </option>
                                    <option value="0" <?= clsHelper::old('status') === '0' ? 'selected' : ''; ?>>
                                        غير مفعل
                                    </option>
                                </select>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">

                        <h5 class="mb-4">
                            <i class="fa fa-phone text-primary me-1"></i>
                            بيانات التواصل وولي الأمر
                        </h5>

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-mobile-screen-button text-primary me-1"></i>
                                    هاتف الطالب
                                </label>
                                <input type="text"
                                       name="phone"
                                       class="form-control"
                                       value="<?= clsHelper::old('phone'); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-user-tie text-primary me-1"></i>
                                    اسم ولي الأمر
                                </label>
                                <input type="text"
                                       name="parent_name"
                                       class="form-control"
                                       value="<?= clsHelper::old('parent_name'); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-phone text-primary me-1"></i>
                                    هاتف ولي الأمر
                                </label>
                                <input type="text"
                                       name="parent_phone"
                                       class="form-control"
                                       value="<?= clsHelper::old('parent_phone'); ?>">
                            </div>

                        </div>

                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">

                        <h5 class="mb-4">
                            <i class="fa fa-location-dot text-primary me-1"></i>
                            بيانات إضافية
                        </h5>

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">
                                    <i class="fa-solid fa-location-dot text-primary me-1"></i>
                                    العنوان
                                </label>
                                <textarea name="address"
                                          class="form-control"
                                          rows="3"><?= clsHelper::old('address'); ?></textarea>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="<?= clsPath::students(); ?>index.php" class="btn btn-light border">
                        إلغاء
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save me-1"></i>
                        حفظ الطالب
                    </button>
                </div>

            </form>

        </div>
    </div>

<?php require_once '../../includes/footer.php'; ?>