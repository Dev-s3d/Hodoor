<?php
require_once '../../includes/app.php';
$title = 'تسجيل الحضور';

$classroom_id = clsHelper::get('classroom_id');
$attendance_date = clsHelper::get('attendance_date', date('Y-m-d'));

if (empty($classroom_id) || !clsValidator::integer($classroom_id)) {
    clsHelper::setMessage('error', 'يجب اختيار الفصل');
    clsHelper::redirect(clsPath::attendance() . 'index.php');
}

if (!clsValidator::date($attendance_date)) {
    clsHelper::setMessage('error', 'التاريخ غير صحيح');
    clsHelper::redirect(clsPath::attendance() . 'index.php');
}

$classroom = new clsClassroom($conn);
if (!$classroom->loadById($classroom_id)) {
    clsHelper::setMessage('error', 'الفصل غير موجود');
    clsHelper::redirect(clsPath::attendance() . 'index.php');
}

$studentObj = new clsStudent($conn);
$students = $studentObj->getAllByClassroomId($classroom_id);

$attendanceObj = new clsAttendance($conn);
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">
        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4">
            <?php require_once '../../includes/alerts.php'; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">تسجيل الحضور</h1>
                    <p class="text-muted mb-0">
                        الفصل: <?= clsHelper::e($classroom->class_name); ?> |
                        التاريخ: <?= clsHelper::e($attendance_date); ?>
                    </p>
                </div>

                <a href="<?= clsPath::attendance(); ?>index.php" class="btn btn-outline-secondary">
                    <i class="fa fa-arrow-right me-1"></i>
                    الرجوع
                </a>
            </div>

            <?php if (!empty($students)): ?>
                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <form action="<?= clsPath::attendance(); ?>save.php" method="POST">
                            <input type="hidden" name="classroom_id" value="<?= clsHelper::e($classroom_id); ?>">
                            <input type="hidden" name="attendance_date" value="<?= clsHelper::e($attendance_date); ?>">

                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>اسم الطالب</th>
                                        <th>رقم الطالب</th>
                                        <th>الحالة</th>
                                        <th>ملاحظات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($students as $index => $student): ?>
                                        <?php
                                        $existing = $attendanceObj->getStudentAttendanceOnDate($student['id'], $attendance_date);
                                        $currentStatus = $existing['status'] ?? 'present';
                                        $currentNotes = $existing['notes'] ?? '';
                                        ?>
                                        <tr>
                                            <td><?= $index + 1; ?></td>
                                            <td>
                                                <?= clsHelper::e($student['student_name']); ?>
                                                <input type="hidden" name="student_ids[]"
                                                       value="<?= $student['id']; ?>">
                                            </td>
                                            <td><?= clsHelper::e($student['student_number']); ?></td>
                                            <td style="min-width: 180px;">
                                                <select name="statuses[<?= $student['id']; ?>]" class="form-select">
                                                    <option value="present" <?= $currentStatus === 'present' ? 'selected' : ''; ?>>
                                                        حاضر
                                                    </option>
                                                    <option value="absent" <?= $currentStatus === 'absent' ? 'selected' : ''; ?>>
                                                        غائب
                                                    </option>
                                                    <option value="late" <?= $currentStatus === 'late' ? 'selected' : ''; ?>>
                                                        متأخر
                                                    </option>
                                                    <option value="excused" <?= $currentStatus === 'excused' ? 'selected' : ''; ?>>
                                                        مستأذن
                                                    </option>
                                                </select>
                                            </td>
                                            <td>
                                                <input
                                                        type="text"
                                                        name="notes[<?= $student['id']; ?>]"
                                                        class="form-control"
                                                        value="<?= clsHelper::e($currentNotes); ?>"
                                                        placeholder="ملاحظات">
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3 d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save me-1"></i>
                                    حفظ الحضور
                                </button>

                                <a href="<?= clsPath::attendance(); ?>daily.php?attendance_date=<?= $attendance_date; ?>&classroom_id=<?= $classroom_id; ?>"
                                   class="btn btn-outline-secondary">
                                    عرض التقرير
                                </a>
                            </div>
                        </form>

                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info">لا يوجد طلاب في هذا الفصل حاليًا</div>
            <?php endif; ?>

        </div>
    </div>

<?php require_once '../../includes/footer.php'; ?>