<?php
require_once '../../includes/app.php';
clsHelper::requireRole(['admin', 'supervisor']);
$title = 'التقرير اليومي';

$attendance_date = clsHelper::get('attendance_date', date('Y-m-d'));
$classroom_id = clsHelper::get('classroom_id');

$classroomObj = new clsClassroom($conn);
$classrooms = $classroomObj->getAll();

$report = new clsReport($conn);
$settingObj = new clsSetting($conn);

$rows = $report->getDailyReport($attendance_date, $classroom_id ?: null);
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">
        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4">
            <?php require_once '../../includes/alerts.php'; ?>

            <div class="mb-4">
                <h1 class="mb-1">التقرير اليومي</h1>
                <p class="text-muted mb-0">عرض تقرير يومي للحضور حسب التاريخ والفصل</p>
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
                                    <option value="">كل الفصول</option>
                                    <?php foreach ($classrooms as $classroom): ?>
                                        <option value="<?= $classroom['id']; ?>" <?= $classroom_id == $classroom['id'] ? 'selected' : ''; ?>>
                                            <?= clsHelper::e($classroom['class_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-4 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-primary">عرض</button>

                                <a href="<?= clsPath::reports(); ?>print_report.php?type=daily&attendance_date=<?= urlencode($attendance_date); ?>&classroom_id=<?= urlencode($classroom_id); ?>"
                                   class="btn btn-outline-secondary" target="_blank">
                                    طباعة
                                    <i class="fa fa-print"></i>
                                </a>

                                <a href="<?= clsPath::reports(); ?>export_report.php?type=daily&attendance_date=<?= urlencode($attendance_date); ?>&classroom_id=<?= urlencode($classroom_id); ?>"
                                   class="btn btn-outline-success">
                                    تصدير Excel
                                    <i class="fa fa-file-excel"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive text-center">
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
                                <th>بواسطة</th>
                                <th>تاريخ التحضير</th>
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
                                        <?php
                                        $recordedBy = new clsUser($conn);
                                        $recordedBy->loadById($row['recorded_by']);
                                        ?>
                                        <td><?= clsHelper::e($recordedBy->full_name); ?></td>
                                        <td><?= clsHelper::e($row['created_at']); ?></td>
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