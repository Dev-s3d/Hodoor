<?php
require_once '../../includes/app.php';
clsHelper::requireRole(['admin', 'supervisor']);
$title = 'تقرير الفصل';

$classroom_id = clsHelper::get('classroom_id');
$date_from = clsHelper::get('date_from');
$date_to = clsHelper::get('date_to');

$classroomObj = new clsClassroom($conn);
$classrooms = $classroomObj->getAll();

$report = new clsReport($conn);
$settingObj = new clsSetting($conn);

$rows = [];

if (!empty($classroom_id) && clsValidator::integer($classroom_id)) {
    $rows = $report->getClassroomReport($classroom_id, $date_from ?: null, $date_to ?: null);
}
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">
        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4">
            <?php require_once '../../includes/alerts.php'; ?>

            <div class="mb-4">
                <h1 class="mb-1">تقرير الفصل</h1>
                <p class="text-muted mb-0">عرض الحضور حسب الفصل</p>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <form method="GET">
                        <div class="row g-3">

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

                            <div class="col-md-3">
                                <label class="form-label">من تاريخ</label>
                                <input type="date" name="date_from" class="form-control"
                                       value="<?= clsHelper::e($date_from); ?>">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">إلى تاريخ</label>
                                <input type="date" name="date_to" class="form-control"
                                       value="<?= clsHelper::e($date_to); ?>">
                            </div>

                            <div class="col-md-2 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-primary">عرض</button>

                                <?php if (!empty($classroom_id)): ?>
                                    <a href="print_report.php?type=classroom&classroom_id=<?= urlencode($classroom_id); ?>&date_from=<?= urlencode($date_from); ?>&date_to=<?= urlencode($date_to); ?>"
                                       target="_blank"
                                       class="btn btn-outline-secondary">
                                        طباعة
                                        <i class="fa fa-print"></i>
                                    </a>

                                    <a href="export_report.php?type=classroom&classroom_id=<?= urlencode($classroom_id); ?>&date_from=<?= urlencode($date_from); ?>&date_to=<?= urlencode($date_to); ?>"
                                       class="btn btn-success">
                                        تصدير Excel
                                        <i class="fa fa-file-excel"></i>
                                    </a>
                                <?php endif; ?>
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
                            </tr>
                            </thead>

                            <tbody>
                            <?php if (!empty($rows)): ?>
                                <?php foreach ($rows as $index => $row): ?>
                                    <tr>
                                        <td><?= $index + 1; ?></td>
                                        <td><?= clsHelper::e($row['attendance_date']); ?></td>
                                        <td><?= clsHelper::e($row['class_name']); ?></td>
                                        <td><?= clsHelper::e($row['student_name']); ?></td>
                                        <td><?= clsHelper::e($row['student_number']); ?></td>
                                        <td>
                                            <span class="badge <?= $settingObj->getAttendanceStatusBadgeClass($row['status']); ?>">
                                                <?= clsHelper::e($settingObj->getAttendanceStatusLabel($row['status'])); ?>
                                            </span>
                                        </td>
                                        <td><?= clsHelper::e($row['notes'] ?: '-'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4">لا توجد بيانات</td>
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