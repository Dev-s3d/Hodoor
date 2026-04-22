<?php
require_once '../../includes/app.php';
$title = 'سجل الحضور';

$attendance_date = clsHelper::get('attendance_date');
$classroom_id = clsHelper::get('classroom_id');
$status = clsHelper::get('status');

$classroomObj = new clsClassroom($conn);
$classrooms = $classroomObj->getAll();

$attendanceObj = new clsAttendance($conn);

$filters = [
        'attendance_date' => $attendance_date,
        'classroom_id' => $classroom_id,
        'status' => $status
];

$records = $attendanceObj->getHistory($filters);
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">
        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4">
            <?php require_once '../../includes/alerts.php'; ?>

            <div class="mb-4">
                <h1 class="mb-1">سجل الحضور</h1>
                <p class="text-muted mb-0">عرض جميع سجلات الحضور مع إمكانية الفلترة</p>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <form method="GET">
                        <div class="row g-3">

                            <div class="col-md-3">
                                <label class="form-label">التاريخ</label>
                                <input type="date" name="attendance_date" class="form-control"
                                       value="<?= clsHelper::e($attendance_date); ?>">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">الفصل</label>
                                <select name="classroom_id" class="form-select">
                                    <option value="">كل الفصول</option>
                                    <?php foreach ($classrooms as $classroom): ?>
                                        <option value="<?= $classroom['id']; ?>" <?= $classroom_id == $classroom['id'] ? 'selected' : ''; ?>>
                                            <?= clsHelper::e($classroom['class_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">الحالة</label>
                                <select name="status" class="form-select">
                                    <option value="">كل الحالات</option>
                                    <option value="present" <?= $status === 'present' ? 'selected' : ''; ?>>حاضر
                                    </option>
                                    <option value="absent" <?= $status === 'absent' ? 'selected' : ''; ?>>غائب</option>
                                    <option value="late" <?= $status === 'late' ? 'selected' : ''; ?>>متأخر</option>
                                    <option value="excused" <?= $status === 'excused' ? 'selected' : ''; ?>>مستأذن
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-3 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search me-1"></i>
                                    فلترة
                                </button>

                                <a href="<?= clsPath::attendance(); ?>history.php" class="btn btn-light border">
                                    إعادة ضبط
                                </a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>التاريخ</th>
                                <th>الفصل</th>
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
                                        <td><?= clsHelper::e($record['attendance_date']); ?></td>
                                        <td><?= clsHelper::e($record['class_name']); ?></td>
                                        <td><?= clsHelper::e($record['student_name']); ?></td>
                                        <td><?= clsHelper::e($record['student_number']); ?></td>
                                        <td>
                                            <?php if ($record['status'] === 'present'): ?>
                                                <span class="badge bg-success">حاضر</span>
                                            <?php elseif ($record['status'] === 'absent'): ?>
                                                <span class="badge bg-danger">غائب</span>
                                            <?php elseif ($record['status'] === 'late'): ?>
                                                <span class="badge bg-warning text-dark">متأخر</span>
                                            <?php else: ?>
                                                <span class="badge bg-info text-dark">مستأذن</span>
                                            <?php endif; ?>
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
                                    <td colspan="8" class="text-center py-4">لا توجد سجلات حضور حسب الفلاتر المحددة</td>
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