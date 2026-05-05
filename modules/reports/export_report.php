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

switch ($type) {
    case 'daily':
        $rows = $report->getDailyReport($attendance_date ?: date('Y-m-d'), $classroom_id ?: null);
        $filename = 'daily_report.csv';
        break;

    case 'weekly':
        $rows = $report->getWeeklyReport($date_from, $date_to, $classroom_id ?: null);
        $filename = 'weekly_report.csv';
        break;

    case 'monthly':
        $rows = $report->getMonthlyReport($year ?: date('Y'), $month ?: date('m'), $classroom_id ?: null);
        $filename = 'monthly_report.csv';
        break;

    case 'classroom':
        $rows = $report->getClassroomReport($classroom_id, $date_from ?: null, $date_to ?: null);
        $filename = 'classroom_report.csv';
        break;

    case 'student':
        $rows = $report->getStudentReport($student_id, $date_from ?: null, $date_to ?: null);
        $filename = 'student_report.csv';
        break;

    case 'absences':
        $rows = $report->getAbsencesReport($date_from ?: null, $date_to ?: null, $classroom_id ?: null);
        $filename = 'absences_report.csv';
        break;

    case 'late':
        $rows = $report->getLateReport($date_from ?: null, $date_to ?: null, $classroom_id ?: null);
        $filename = 'late_report.csv';
        break;

    default:
        $rows = [];
        $filename = 'report.csv';
        break;
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);

$output = fopen('php://output', 'w');

fputcsv($output, ['#', 'التاريخ', 'الفصل', 'اسم الطالب', 'رقم الطالب', 'الحالة', 'ملاحظات']);

if (!empty($rows)) {
    foreach ($rows as $index => $row) {
        fputcsv($output, [
            $index + 1,
            $row['attendance_date'] ?? '',
            $row['class_name'] ?? '',
            $row['student_name'] ?? '',
            $row['student_number'] ?? '',
            $row['status'] ?? '',
            $row['notes'] ?? ''
        ]);
    }
}

fclose($output);
exit;