<?php

require_once '../../includes/app.php';

clsHelper::requireRole(['admin', 'supervisor']);

$type = clsHelper::get('type', 'daily');
$attendance_date = clsHelper::get('attendance_date');
$date_from = clsHelper::get('date_from');
$date_to = clsHelper::get('date_to');
$year = clsHelper::get('year');
$month = clsHelper::get('month');
$classroom_id = clsHelper::get('classroom_id');
$student_id = clsHelper::get('student_id');

$report = new clsReport($conn);
$setting = new clsSetting($conn);

$rows = [];
$pageTitle = 'تقرير';

switch ($type) {
    case 'daily':
        $pageTitle = 'تقرير الحضور اليومي';
        $rows = $report->getDailyReport($attendance_date ?: date('Y-m-d'), $classroom_id ?: null);
        break;

    case 'weekly':
        $pageTitle = 'تقرير الحضور الأسبوعي';
        $rows = $report->getWeeklyReport($date_from, $date_to, $classroom_id ?: null);
        break;

    case 'monthly':
        $pageTitle = 'تقرير الحضور الشهري';
        $rows = $report->getMonthlyReport($year ?: date('Y'), $month ?: date('m'), $classroom_id ?: null);
        break;

    case 'classroom':
        $pageTitle = 'تقرير الفصل';
        $rows = $report->getClassroomReport($classroom_id, $date_from ?: null, $date_to ?: null);
        break;

    case 'student':
        $pageTitle = 'تقرير الطالب';
        $rows = $report->getStudentReport($student_id, $date_from ?: null, $date_to ?: null);
        break;

    case 'absences':
        $pageTitle = 'تقرير الغياب';
        $rows = $report->getAbsencesReport($date_from ?: null, $date_to ?: null, $classroom_id ?: null);
        break;

    case 'late':
        $pageTitle = 'تقرير التأخير';
        $rows = $report->getLateReport($date_from ?: null, $date_to ?: null, $classroom_id ?: null);
        break;
}

$schoolName = $setting->get('school_name', 'Hodoor School');
$schoolAddress = $setting->get('school_address', '-');
$schoolPhone = $setting->get('school_phone', '-');
$schoolEmail = $setting->get('school_email', '-');

$printDate = date('Y-m-d');
$printTime = date('H:i');

?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title><?= clsHelper::e($pageTitle); ?></title>
    <link rel="stylesheet" href="<?= clsPath::css(); ?>allFileCss.css">
    <link rel="stylesheet" href="<?= clsPath::bootstrapCss(); ?>">
    <link rel="stylesheet" href="<?= clsPath::fontawesome(); ?>">
    <link rel="stylesheet" href="<?= clsPath::css(); ?>reports.css">
    <link rel="icon" type="image/x-icon" href="<?= clsPath::assets(); ?>/images/favicon.png">
</head>

<body onload="window.print()">

<div class="report-page">

    <div class="report-header">

        <div class="school-brand">
            <div class="school-logo">
                <i class="fa-solid fa-school"></i>
            </div>

            <div>
                <h1 class="school-name">
                    <?= clsHelper::e($schoolName); ?>
                </h1>

                <p class="school-meta">
                    <?= clsHelper::e($schoolAddress); ?>
                </p>
            </div>
        </div>

        <div class="school-contact">
            <div>
                <i class="fa-solid fa-phone"></i>
                <?= clsHelper::e($schoolPhone); ?>
            </div>

            <div>
                <i class="fa-solid fa-envelope"></i>
                <?= clsHelper::e($schoolEmail); ?>
            </div>
        </div>

    </div>

    <div class="report-title-box">

        <h2 class="report-title">
            <i class="fa-solid fa-circle"></i>
            <?= clsHelper::e($pageTitle); ?>
        </h2>

        <div class="report-info">
            <span class="report-badge">
                تاريخ الطباعة: <?= clsHelper::e($printDate); ?>
            </span>

            <span class="report-badge">
                الوقت: <?= clsHelper::e($printTime); ?>
            </span>

            <span class="report-badge">
                عدد السجلات: <?= count($rows); ?>
            </span>
        </div>

    </div>

    <div class="summary-row">
        <div class="summary-card">
            <span>إجمالي السجلات</span>
            <strong><?= count($rows); ?></strong>
        </div>

        <div class="summary-card">
            <span>نوع التقرير</span>
            <strong><?= clsHelper::e($pageTitle); ?></strong>
        </div>

        <div class="summary-card">
            <span>تاريخ التقرير</span>
            <strong><?= clsHelper::e($attendance_date ?: '-'); ?></strong>
        </div>

        <div class="summary-card">
            <span>السنة / الشهر</span>
            <strong><?= clsHelper::e(($year ?: date('Y')) . ' / ' . ($month ?: date('m'))); ?></strong>
        </div>
    </div>

    <table>
        <thead>
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
                <?php
                $statusClass = 'status-default';

                if ($row['status'] === 'present') {
                    $statusClass = 'status-present';
                } elseif ($row['status'] === 'absent') {
                    $statusClass = 'status-absent';
                } elseif ($row['status'] === 'late') {
                    $statusClass = 'status-late';
                } elseif ($row['status'] === 'excused') {
                    $statusClass = 'status-excused';
                }
                ?>

                <tr>
                    <td><?= $index + 1; ?></td>
                    <td><?= clsHelper::e($row['attendance_date']); ?></td>
                    <td><?= clsHelper::e($row['class_name']); ?></td>
                    <td><?= clsHelper::e($row['student_name']); ?></td>
                    <td><?= clsHelper::e($row['student_number']); ?></td>
                    <td>
                        <span class="status-pill <?= $statusClass; ?>">
                            <?= clsHelper::e(clsHelper::attendanceStatus($row['status'])); ?>
                        </span>
                    </td>
                    <td><?= clsHelper::e($row['notes'] ?: '-'); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">لا توجد بيانات</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <div class="report-footer">
        <span>تم إنشاء التقرير بواسطة نظام Hodoor</span>
        <span><?= clsHelper::e($schoolName); ?></span>
    </div>

</div>

</body>
</html>