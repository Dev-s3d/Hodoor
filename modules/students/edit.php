<?php
require_once '../../includes/app.php';
$title = 'تعديل الطالب';

$id = clsHelper::get('id');

$student = new clsStudent($conn);
if (!$id || !$student->loadById($id)) {
    clsHelper::setMessage('error', 'الطالب غير موجود');
    clsHelper::redirect(clsPath::students() . 'index.php');
}

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
                    <h1 class="mb-1">تعديل الطالب</h1>
                    <p class="text-muted mb-0">يمكنك تعديل بيانات الطالب الحالية</p>
                </div>

                <a href="<?= clsPath::students(); ?>index.php" class="btn btn-outline-secondary">
                    <i class="fa fa-arrow-right me-1"></i>
                    الرجوع
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <form action="<?= clsPath::students(); ?>update.php" method="POST">
                        <input type="hidden" name="id" value="<?= clsHelper::e($student->id); ?>">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">اسم الطالب</label>
                                <input type="text" name="student_name" class="form-control"
                                       value="<?= clsHelper::old('student_name', $student->student_name); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">رقم الطالب</label>
                                <input type="text" name="student_number" class="form-control"
                                       value="<?= clsHelper::old('student_number', $student->student_number); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">الفصل</label>
                                <?php $oldClassroomId = clsHelper::old('classroom_id', $student->classroom_id); ?>
                                <select name="classroom_id" class="form-select">
                                    <option value="">اختر الفصل</option>
                                    <?php foreach ($classrooms as $classroom): ?>
                                        <option value="<?= $classroom['id']; ?>" <?= $oldClassroomId == $classroom['id'] ? 'selected' : ''; ?>>
                                            <?= clsHelper::e($classroom['class_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">الجنس</label>
                                <?php $oldGender = clsHelper::old('gender', $student->gender); ?>
                                <select name="gender" class="form-select">
                                    <option value="male" <?= $oldGender === 'male' ? 'selected' : ''; ?>>ذكر</option>
                                    <option value="female" <?= $oldGender === 'female' ? 'selected' : ''; ?>>أنثى
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">تاريخ الميلاد</label>
                                <input type="date" name="birth_date" class="form-control"
                                       value="<?= clsHelper::old('birth_date', $student->birth_date); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">هاتف الطالب</label>
                                <input type="text" name="phone" class="form-control"
                                       value="<?= clsHelper::old('phone', $student->phone); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">اسم ولي الأمر</label>
                                <input type="text" name="parent_name" class="form-control"
                                       value="<?= clsHelper::old('parent_name', $student->parent_name); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">هاتف ولي الأمر</label>
                                <input type="text" name="parent_phone" class="form-control"
                                       value="<?= clsHelper::old('parent_phone', $student->parent_phone); ?>">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">العنوان</label>
                                <textarea name="address" class="form-control"
                                          rows="3"><?= clsHelper::old('address', $student->address); ?></textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">الحالة</label>
                                <?php $oldStatus = clsHelper::old('status', (string)$student->status); ?>
                                <select name="status" class="form-select">
                                    <option value="1" <?= $oldStatus == '1' ? 'selected' : ''; ?>>مفعل</option>
                                    <option value="0" <?= $oldStatus == '0' ? 'selected' : ''; ?>>غير مفعل</option>
                                </select>
                            </div>

                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save me-1"></i>
                                حفظ التعديلات
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