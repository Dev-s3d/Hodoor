<?php
require_once '../../includes/app.php';
clsHelper::requireRole(['admin', 'supervisor']);

$title = 'تعديل الطالب';

$id = clsHelper::get('id');

$student = new clsStudent($conn);

if (!$id || !$student->loadById($id)) {
    clsHelper::setMessage('error', 'الطالب غير موجود');
    clsHelper::redirect(clsPath::students() . 'index.php');
}

$classroomObj = new clsClassroom($conn);
$classrooms = $classroomObj->getAll();

$genderLabel = $student->gender === 'female' ? 'أنثى' : 'ذكر';
$genderBadge = $student->gender === 'female' ? 'bg-danger' : 'bg-primary';

$statusLabel = (int)$student->status === 1 ? 'مفعل' : 'غير مفعل';
$statusBadge = (int)$student->status === 1 ? 'bg-success' : 'bg-secondary';
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">

        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4 students">

            <?php require_once '../../includes/alerts.php'; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">تعديل الطالب</h1>
                    <p class="text-muted mb-0">تعديل بيانات الطالب الحالية</p>
                </div>

                <div class="d-flex gap-2">
                    <a href="<?= clsPath::students(); ?>view.php?id=<?= $student->id; ?>"
                       class="btn btn-outline-primary">
                        <i class="fa fa-eye me-1"></i>
                        عرض
                    </a>

                    <a href="<?= clsPath::students(); ?>index.php"
                       class="btn btn-outline-secondary">
                        <i class="fa fa-arrow-right me-1"></i>
                        الرجوع
                    </a>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">

                    <div class="d-flex align-items-center flex-wrap gap-3">

                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                             style="width:75px;height:75px;">
                            <i class="fa fa-user-graduate text-primary fs-2"></i>
                        </div>

                        <div>
                            <h4 class="mb-1">
                                <?= clsHelper::e($student->student_name); ?>
                            </h4>

                            <p class="text-muted mb-2">
                                رقم الطالب:
                                <?= clsHelper::e($student->student_number ?: '-'); ?>
                            </p>

                            <div class="d-flex gap-2 flex-wrap">
                            <span class="badge <?= $genderBadge; ?> px-3">
                                <?= $genderLabel; ?>
                            </span>

                                <span class="badge <?= $statusBadge; ?> px-3">
                                <?= $statusLabel; ?>
                            </span>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <form action="<?= clsPath::students(); ?>update.php" method="POST">

                <input type="hidden" name="id" value="<?= clsHelper::e($student->id); ?>">

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
                                       value="<?= clsHelper::old('student_name', $student->student_name); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-fingerprint text-primary me-1"></i>
                                    رقم الطالب
                                </label>
                                <input type="text"
                                       name="student_number"
                                       class="form-control"
                                       value="<?= clsHelper::old('student_number', $student->student_number); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-chalkboard text-primary me-1"></i>
                                    الفصل
                                </label>

                                <?php $oldClassroomId = clsHelper::old('classroom_id', $student->classroom_id); ?>

                                <select name="classroom_id" class="form-select">
                                    <option value="">اختر الفصل</option>
                                    <?php foreach ($classrooms as $classroom): ?>
                                        <option value="<?= $classroom['id']; ?>"
                                                <?= $oldClassroomId == $classroom['id'] ? 'selected' : ''; ?>>
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

                                <?php $oldGender = clsHelper::old('gender', $student->gender); ?>

                                <select name="gender" class="form-select">
                                    <option value="male" <?= $oldGender === 'male' ? 'selected' : ''; ?>>
                                        ذكر
                                    </option>
                                    <option value="female" <?= $oldGender === 'female' ? 'selected' : ''; ?>>
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
                                       value="<?= clsHelper::old('birth_date', $student->birth_date); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-user-check text-primary me-1"></i>
                                    الحالة
                                </label>

                                <?php $oldStatus = clsHelper::old('status', (string)$student->status); ?>

                                <select name="status" class="form-select">
                                    <option value="1" <?= $oldStatus == '1' ? 'selected' : ''; ?>>
                                        مفعل
                                    </option>
                                    <option value="0" <?= $oldStatus == '0' ? 'selected' : ''; ?>>
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
                                       value="<?= clsHelper::old('phone', $student->phone); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-user-tie text-primary me-1"></i>
                                    اسم ولي الأمر
                                </label>
                                <input type="text"
                                       name="parent_name"
                                       class="form-control"
                                       value="<?= clsHelper::old('parent_name', $student->parent_name); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-phone text-primary me-1"></i>
                                    هاتف ولي الأمر
                                </label>
                                <input type="text"
                                       name="parent_phone"
                                       class="form-control"
                                       value="<?= clsHelper::old('parent_phone', $student->parent_phone); ?>">
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
                                          rows="3"><?= clsHelper::old('address', $student->address); ?></textarea>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">

                    <a href="<?= clsPath::students(); ?>view.php?id=<?= $student->id; ?>"
                       class="btn btn-outline-secondary">
                        <i class="fa fa-eye me-1"></i>
                        عرض الطالب
                    </a>

                    <a href="<?= clsPath::students(); ?>index.php"
                       class="btn btn-light border">
                        إلغاء
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save me-1"></i>
                        حفظ التعديلات
                    </button>

                </div>

            </form>

        </div>
    </div>

<?php require_once '../../includes/footer.php'; ?>