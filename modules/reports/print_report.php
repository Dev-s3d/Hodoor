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
    <link rel="icon" type="image/x-icon" href="<?= clsPath::assets(); ?>/images/favicon.png">
    <style>
        * {
            font-family: 'Tajawal', Arial, sans-serif;
            box-sizing: border-box;
        }

        body {
            background: #fff;
            color: #1f2937;
            margin: 0;
            padding: 18px;
            font-size: 13px;
        }

        @page {
            size: A4;
            margin: 10px;
        }

        @media print {
            body {
                padding: 0;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .no-print {
                display: none !important;
            }

            .report-page {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
            }
        }

        .report-page {
            max-width: 1100px;
            margin: 0 auto;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 22px;
        }

        .report-header {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            border-bottom: 3px solid #3852b4;
            padding-bottom: 16px;
            margin-bottom: 18px;
        }

        .school-brand {
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .school-logo {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            background: #eef3ff;
            color: #3852b4;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            flex-shrink: 0;
        }

        .school-name {
            font-size: 22px;
            font-weight: 800;
            margin: 0 0 6px;
            color: #111827;
        }

        .school-meta {
            margin: 0;
            color: #6b7280;
            line-height: 1.8;
        }

        .school-contact {
            text-align: left;
            direction: ltr;
            color: #374151;
            font-size: 13px;
            line-height: 1.8;
        }

        .school-contact div {
            margin-bottom: 3px;
        }

        .report-title-box {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .report-title {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
            color: #111827;
        }

        .report-title i {
            color: #3852b4;
            font-size: 13px;
            margin-left: 6px;
        }

        .report-info {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .report-badge {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 50px;
            padding: 6px 12px;
            font-size: 12px;
            color: #374151;
        }

        .summary-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 18px;
        }

        .summary-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 12px;
        }

        .summary-card span {
            display: block;
            color: #6b7280;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .summary-card strong {
            font-size: 18px;
            color: #111827;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 12px;
            font-size: 12.5px;
        }

        thead th {
            background: #3852b4 !important;
            color: #fff !important;
            border: 1px solid #3852b4;
            padding: 10px 8px;
            text-align: center;
            font-weight: 700;
        }

        tbody td {
            border: 1px solid #e5e7eb;
            padding: 9px 8px;
            text-align: center;
            vertical-align: middle;
        }

        tbody tr:nth-child(even) td {
            background: #f9fafb;
        }

        .status-pill {
            display: inline-block;
            min-width: 70px;
            padding: 5px 10px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 12px;
        }

        .status-present {
            background: #dcfce7;
            color: #166534;
        }

        .status-absent {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-late {
            background: #fef3c7;
            color: #92400e;
        }

        .status-excused {
            background: #e0f2fe;
            color: #075985;
        }

        .status-default {
            background: #f3f4f6;
            color: #374151;
        }

        .report-footer {
            margin-top: 20px;
            padding-top: 12px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            color: #6b7280;
            font-size: 12px;
        }

        @media print {
            .report-header {
                page-break-inside: avoid;
            }

            .report-title-box {
                page-break-inside: avoid;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            thead {
                display: table-header-group;
            }
        }
    </style>
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