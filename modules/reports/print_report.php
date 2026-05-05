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
$rows = [];
$pageTitle = 'تقرير';

switch ($type) {
    case 'daily':
        $pageTitle = 'تقرير يومي';
        $rows = $report->getDailyReport($attendance_date ?: date('Y-m-d'), $classroom_id ?: null);
        break;

    case 'weekly':
        $pageTitle = 'تقرير أسبوعي';
        $rows = $report->getWeeklyReport($date_from, $date_to, $classroom_id ?: null);
        break;

    case 'monthly':
        $pageTitle = 'تقرير شهري';
        $rows = $report->getMonthlyReport($year ?: date('Y'), $month ?: date('m'), $classroom_id ?: null);
        break;

    default:
        $pageTitle = 'تقرير';
        $rows = [];
        break;
}
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title><?= clsHelper::e($pageTitle); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: rtl;
            margin: 20px;
        }

        h2 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: right;
        }

        th {
            background: #f2f2f2;
        }
    </style>
</head>
<body onload="window.print()">
<h2><?= clsHelper::e($pageTitle); ?></h2>

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
            <tr>
                <td><?= $index + 1; ?></td>
                <td><?= clsHelper::e($row['attendance_date']); ?></td>
                <td><?= clsHelper::e($row['class_name']); ?></td>
                <td><?= clsHelper::e($row['student_name']); ?></td>
                <td><?= clsHelper::e($row['student_number']); ?></td>
                <td><?= clsHelper::e($row['status']); ?></td>
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
</body>
</html>