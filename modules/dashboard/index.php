<?php
require_once '../../includes/app.php';
$title = 'لوحة التحكم';

$userObj = new clsUser($conn);
$classroomObj = new clsClassroom($conn);
$studentObj = new clsStudent($conn);
$attendanceObj = new clsAttendance($conn);
$reportObj = new clsReport($conn);

$today = date('Y-m-d');

/*
|--------------------------------------------------------------------------
| إحصائيات عامة
|--------------------------------------------------------------------------
*/
$totalUsers = $userObj->countAll();
$totalClassrooms = $classroomObj->countAll();
$totalStudents = $studentObj->countAll();

/*
|--------------------------------------------------------------------------
| إحصائيات حضور اليوم
|--------------------------------------------------------------------------
*/
$totalTodayAttendance = $attendanceObj->countAllByDate($today);
$totalPresent = $attendanceObj->countByStatus($today, 'present');
$totalAbsent = $attendanceObj->countByStatus($today, 'absent');
$totalLate = $attendanceObj->countByStatus($today, 'late');
$totalExcused = $attendanceObj->countByStatus($today, 'excused');

/*
|--------------------------------------------------------------------------
| أحدث سجلات حضور اليوم
|--------------------------------------------------------------------------
*/
$todayRows = $reportObj->getDailyReport($today);

/* نأخذ أول 8 سجلات فقط */
$latestAttendance = array_slice($todayRows, 0, 8);
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">

        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4">

            <?php require_once '../../includes/alerts.php'; ?>

            <!-- عنوان الصفحة -->
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                <div>
                    <h1 class="mb-1">مرحبًا <?= clsHelper::e($_SESSION['full_name']); ?></h1>
                    <p class="text-muted mb-0">
                        هذه نظرة عامة على نظام <strong>Hodoor</strong> ليوم <?= clsHelper::e($today); ?>
                    </p>
                </div>

                <div class="d-flex gap-2 flex-wrap">
                    <a href="<?= clsPath::attendance(); ?>index.php" class="btn btn-primary">
                        <i class="fa fa-check me-1"></i>
                        تسجيل الحضور
                    </a>

                    <a href="<?= clsPath::reports(); ?>daily_report.php" class="btn btn-outline-secondary">
                        <i class="fa fa-chart-bar me-1"></i>
                        التقارير
                    </a>
                </div>
            </div>

            <!-- الإحصائيات العامة -->
            <div class="row g-3 mb-4">

                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card dashboard-card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="small text-muted mb-2">إجمالي المستخدمين</div>
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="mb-0"><?= $totalUsers; ?></h3>
                                <div class="dashboard-icon bg-primary-subtle text-primary">
                                    <i class="fa fa-user-cog"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card dashboard-card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="small text-muted mb-2">إجمالي الفصول</div>
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="mb-0"><?= $totalClassrooms; ?></h3>
                                <div class="dashboard-icon bg-success-subtle text-success">
                                    <i class="fa fa-school"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card dashboard-card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="small text-muted mb-2">إجمالي الطلاب</div>
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="mb-0"><?= $totalStudents; ?></h3>
                                <div class="dashboard-icon bg-warning-subtle text-warning">
                                    <i class="fa fa-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- إحصائيات حضور اليوم -->
            <div class="mb-3">
                <h4 class="mb-1">ملخص حضور اليوم</h4>
                <p class="text-muted mb-0">إحصائيات الحضور الخاصة بتاريخ <?= clsHelper::e($today); ?></p>
            </div>

            <div class="row g-3 mb-4">

                <div class="col-12 col-sm-6 col-lg-4 col-xl-2">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="small text-muted mb-2">الإجمالي</div>
                            <h4 class="mb-0"><?= $totalTodayAttendance; ?></h4>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 col-xl-2">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="small text-muted mb-2">حاضر</div>
                            <h4 class="mb-0 text-success"><?= $totalPresent; ?></h4>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 col-xl-2">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="small text-muted mb-2">غائب</div>
                            <h4 class="mb-0 text-danger"><?= $totalAbsent; ?></h4>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 col-xl-2">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="small text-muted mb-2">متأخر</div>
                            <h4 class="mb-0 text-warning"><?= $totalLate; ?></h4>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 col-xl-2">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="small text-muted mb-2">مستأذن</div>
                            <h4 class="mb-0 text-info"><?= $totalExcused; ?></h4>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row g-4">

                <!-- أحدث سجلات الحضور -->
                <div class="col-12 col-xl-8">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">أحدث سجلات الحضور اليوم</h5>
                            </div>

                            <a href="<?= clsPath::attendance(); ?>daily.php?attendance_date=<?= urlencode($today); ?>"
                               class="btn btn-sm btn-outline-secondary">
                                عرض الكل
                            </a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>الفصل</th>
                                        <th>اسم الطالب</th>
                                        <th>رقم الطالب</th>
                                        <th>الحالة</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($latestAttendance)): ?>
                                        <?php foreach ($latestAttendance as $index => $row): ?>
                                            <tr>
                                                <td><?= $index + 1; ?></td>
                                                <td><?= clsHelper::e($row['class_name']); ?></td>
                                                <td><?= clsHelper::e($row['student_name']); ?></td>
                                                <td><?= clsHelper::e($row['student_number']); ?></td>
                                                <td>
                                                    <?php if ($row['status'] === 'present'): ?>
                                                        <span class="badge bg-success">حاضر</span>
                                                    <?php elseif ($row['status'] === 'absent'): ?>
                                                        <span class="badge bg-danger">غائب</span>
                                                    <?php elseif ($row['status'] === 'late'): ?>
                                                        <span class="badge bg-warning text-dark">متأخر</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-info text-dark">مستأذن</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                لا توجد سجلات حضور لليوم حتى الآن
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- اختصارات سريعة -->
                <div class="col-12 col-xl-4">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-0">
                            <h5 class="mb-0">اختصارات سريعة</h5>
                        </div>

                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="<?= clsPath::users(); ?>index.php" class="btn btn-light border text-start">
                                    <i class="fa fa-user-cog me-2"></i>
                                    إدارة المستخدمين
                                </a>

                                <a href="<?= clsPath::classrooms(); ?>index.php"
                                   class="btn btn-light border text-start">
                                    <i class="fa fa-school me-2"></i>
                                    إدارة الفصول
                                </a>

                                <a href="<?= clsPath::students(); ?>index.php" class="btn btn-light border text-start">
                                    <i class="fa fa-users me-2"></i>
                                    إدارة الطلاب
                                </a>

                                <a href="<?= clsPath::attendance(); ?>index.php"
                                   class="btn btn-light border text-start">
                                    <i class="fa fa-check me-2"></i>
                                    بدء الحضور
                                </a>

                                <a href="<?= clsPath::reports(); ?>daily_report.php"
                                   class="btn btn-light border text-start">
                                    <i class="fa fa-chart-column me-2"></i>
                                    التقارير اليومية
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-0">
                            <h5 class="mb-0">معلومات سريعة</h5>
                        </div>

                        <div class="card-body">
                            <ul class="list-unstyled mb-0 dashboard-info-list">
                                <li class="mb-2">
                                    <strong>اسم المستخدم:</strong>
                                    <?= clsHelper::e($_SESSION['username']); ?>
                                </li>
                                <li class="mb-2">
                                    <strong>البريد:</strong>
                                    <?= clsHelper::e($_SESSION['email']); ?>
                                </li>
                                <li class="mb-0">
                                    <strong>التاريخ اليوم:</strong>
                                    <?= clsHelper::e($today); ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

<?php require_once '../../includes/footer.php'; ?>