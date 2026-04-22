<?php
require_once '../../includes/app.php';
$title = 'تعديل سجل الحضور';

$id = clsHelper::get('id');

$attendance = new clsAttendance($conn);
if (!$id || !$attendance->loadById($id)) {
    clsHelper::setMessage('error', 'سجل الحضور غير موجود');
    clsHelper::redirect(clsPath::attendance() . 'history.php');
}

$student = new clsStudent($conn);
$studentName = '-';
$studentNumber = '-';
if ($student->loadById($attendance->student_id)) {
    $studentName = $student->student_name;
    $studentNumber = $student->student_number;
}

$classroom = new clsClassroom($conn);
$classroomName = '-';
if ($classroom->loadById($attendance->classroom_id)) {
    $classroomName = $classroom->class_name;
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
                    <h1 class="mb-1">تعديل سجل الحضور</h1>
                    <p class="text-muted mb-0">يمكنك تعديل حالة الحضور والملاحظات</p>
                </div>

                <a href="<?= clsPath::attendance(); ?>history.php" class="btn btn-outline-secondary">
                    <i class="fa fa-arrow-right me-1"></i>
                    الرجوع
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <form action="<?= clsPath::attendance(); ?>update.php" method="POST">
                        <input type="hidden" name="id" value="<?= clsHelper::e($attendance->id); ?>">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">اسم الطالب</label>
                                <input type="text" class="form-control" value="<?= clsHelper::e($studentName); ?>"
                                       disabled>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">رقم الطالب</label>
                                <input type="text" class="form-control" value="<?= clsHelper::e($studentNumber); ?>"
                                       disabled>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">الفصل</label>
                                <input type="text" class="form-control" value="<?= clsHelper::e($classroomName); ?>"
                                       disabled>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">التاريخ</label>
                                <input type="date" name="attendance_date" class="form-control"
                                       value="<?= clsHelper::e($attendance->attendance_date); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">الحالة</label>
                                <select name="status" class="form-select">
                                    <option value="present" <?= $attendance->status === 'present' ? 'selected' : ''; ?>>
                                        حاضر
                                    </option>
                                    <option value="absent" <?= $attendance->status === 'absent' ? 'selected' : ''; ?>>
                                        غائب
                                    </option>
                                    <option value="late" <?= $attendance->status === 'late' ? 'selected' : ''; ?>>
                                        متأخر
                                    </option>
                                    <option value="excused" <?= $attendance->status === 'excused' ? 'selected' : ''; ?>>
                                        مستأذن
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">ملاحظات</label>
                                <textarea name="notes" class="form-control"
                                          rows="3"><?= clsHelper::e($attendance->notes); ?></textarea>
                            </div>

                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save me-1"></i>
                                حفظ التعديلات
                            </button>

                            <a href="<?= clsPath::attendance(); ?>history.php" class="btn btn-light border">
                                إلغاء
                            </a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

<?php require_once '../../includes/footer.php'; ?>