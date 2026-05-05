<?php
require_once '../../includes/app.php';
clsHelper::requireRole(['admin', 'supervisor', 'teacher']);
$title = 'التقرير اليومي';

$attendance_date = clsHelper::get('attendance_date', date('Y-m-d'));
$classroom_id = clsHelper::get('classroom_id');

$classroomObj = new clsClassroom($conn);
$classrooms = $classroomObj->getAll();

$attendanceObj = new clsAttendance($conn);
$settingObj = new clsSetting($conn);

$records = [];

if (!empty($classroom_id) && clsValidator::integer($classroom_id) && clsValidator::date($attendance_date)) {
    $records = $attendanceObj->getAllByDateAndClassroom($attendance_date, $classroom_id);
}

$totalAll = $attendanceObj->countAllByDate($attendance_date, $classroom_id ?: null);
$totalPresent = $attendanceObj->countByStatus($attendance_date, 'present', $classroom_id ?: null);
$totalAbsent = $attendanceObj->countByStatus($attendance_date, 'absent', $classroom_id ?: null);
$totalLate = $attendanceObj->countByStatus($attendance_date, 'late', $classroom_id ?: null);
$totalExcused = $attendanceObj->countByStatus($attendance_date, 'excused', $classroom_id ?: null);
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">
        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4">
            <?php require_once '../../includes/alerts.php'; ?>

            <div class="mb-4">
                <h1 class="mb-1">التقرير اليومي</h1>
                <p class="text-muted mb-0">عرض حضور الطلاب حسب التاريخ والفصل</p>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <form method="GET">
                        <div class="row g-3">

                            <div class="col-md-4">
                                <label class="form-label">التاريخ</label>
                                <input type="date" name="attendance_date" class="form-control"
                                       value="<?= clsHelper::e($attendance_date); ?>">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">الفصل</label>
                                <select name="classroom_id" class="form-select">
                                    <option value="">اختر الفصل</option>
                                    <?php foreach ($classrooms as $classroom): ?>
                                        <option value="<?= $classroom['id']; ?>" <?= $classroom_id == $classroom['id'] ? 'selected' : ''; ?>>
                                            <?= clsHelper::e($classroom['class_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-4 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search me-1"></i>
                                    عرض
                                </button>

                                <a href="<?= clsPath::attendance(); ?>index.php" class="btn btn-light border">
                                    رجوع
                                </a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <div class="row g-3 mb-4">

                <div class="col-6 col-lg-2">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-muted">الإجمالي</h6>
                            <h4 class="mb-0"><?= $totalAll; ?></h4>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-2">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-muted"><?= clsHelper::e($settingObj->getAttendanceStatusLabel('present')); ?></h6>
                            <h4 class="mb-0"><?= $totalPresent; ?></h4>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-2">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-muted"><?= clsHelper::e($settingObj->getAttendanceStatusLabel('absent')); ?></h6>
                            <h4 class="mb-0"><?= $totalAbsent; ?></h4>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-2">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-muted"><?= clsHelper::e($settingObj->getAttendanceStatusLabel('late')); ?></h6>
                            <h4 class="mb-0"><?= $totalLate; ?></h4>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-2">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-muted"><?= clsHelper::e($settingObj->getAttendanceStatusLabel('excused')); ?></h6>
                            <h4 class="mb-0"><?= $totalExcused; ?></h4>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>اسم الطالب</th>
                                <th>رقم الطالب</th>
                                <th>الحالة</th>
                                <th>ملاحظات</th>
                                <th>العمليات</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php if (!empty($records)): ?>
                                <?php foreach ($records as $index => $record): ?>
                                    <tr>
                                        <td><?= $index + 1; ?></td>
                                        <td><?= clsHelper::e($record['student_name']); ?></td>
                                        <td><?= clsHelper::e($record['student_number']); ?></td>
                                        <td>
                                            <span class="badge <?= $settingObj->getAttendanceStatusBadgeClass($record['status']); ?>">
                                                <?= clsHelper::e($settingObj->getAttendanceStatusLabel($record['status'])); ?>
                                            </span>
                                        </td>
                                        <td><?= clsHelper::e($record['notes'] ?: '-'); ?></td>
                                        <td>
                                            <a href="<?= clsPath::attendance(); ?>edit.php?id=<?= $record['id']; ?>"
                                               class="btn btn-sm btn-outline-primary">
                                                تعديل
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">لا توجد بيانات حضور حسب الفلتر المحدد</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>

<?php require_once '../../includes/footer.php'; ?>