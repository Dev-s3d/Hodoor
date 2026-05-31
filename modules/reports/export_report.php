<?php

require_once '../../includes/app.php';

clsHelper::requireRole(['admin', 'supervisor']);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
$pageTitle = 'تقرير الحضور';
$filename = 'attendance_report_' . date('Y-m-d') . '.xlsx';

switch ($type) {
    case 'daily':
        $pageTitle = 'تقرير الحضور اليومي';
        $rows = $report->getDailyReport($attendance_date ?: date('Y-m-d'), $classroom_id ?: null);
        $filename = 'daily_report_' . date('Y-m-d') . '.xlsx';
        break;

    case 'weekly':
        $pageTitle = 'تقرير الحضور الأسبوعي';
        $rows = $report->getWeeklyReport($date_from, $date_to, $classroom_id ?: null);
        $filename = 'weekly_report_' . date('Y-m-d') . '.xlsx';
        break;

    case 'monthly':
        $pageTitle = 'تقرير الحضور الشهري';
        $rows = $report->getMonthlyReport($year ?: date('Y'), $month ?: date('m'), $classroom_id ?: null);
        $filename = 'monthly_report_' . date('Y-m-d') . '.xlsx';
        break;

    case 'classroom':
        $pageTitle = 'تقرير الفصل';
        $rows = $report->getClassroomReport($classroom_id, $date_from ?: null, $date_to ?: null);
        $filename = 'classroom_report_' . date('Y-m-d') . '.xlsx';
        break;

    case 'student':
        $pageTitle = 'تقرير الطالب';
        $rows = $report->getStudentReport($student_id, $date_from ?: null, $date_to ?: null);
        $filename = 'student_report_' . date('Y-m-d') . '.xlsx';
        break;

    case 'absences':
        $pageTitle = 'تقرير الغياب';
        $rows = $report->getAbsencesReport($date_from ?: null, $date_to ?: null, $classroom_id ?: null);
        $filename = 'absences_report_' . date('Y-m-d') . '.xlsx';
        break;

    case 'late':
        $pageTitle = 'تقرير التأخير';
        $rows = $report->getLateReport($date_from ?: null, $date_to ?: null, $classroom_id ?: null);
        $filename = 'late_report_' . date('Y-m-d') . '.xlsx';
        break;

    default:
        $pageTitle = 'تقرير الحضور';
        $rows = [];
        $filename = 'attendance_report_' . date('Y-m-d') . '.xlsx';
        break;
}

$schoolName = $setting->get('school_name', 'Hodoor School');
$schoolAddress = $setting->get('school_address', '-');
$schoolPhone = $setting->get('school_phone', '-');
$schoolEmail = $setting->get('school_email', '-');

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setRightToLeft(true);
$sheet->setTitle('تقرير الحضور');

/*
|--------------------------------------------------------------------------
| معلومات المدرسة
|--------------------------------------------------------------------------
*/
$sheet->mergeCells('A1:G1');
$sheet->setCellValue('A1', $schoolName);

$sheet->mergeCells('A2:G2');
$sheet->setCellValue('A2', $schoolAddress);

$sheet->mergeCells('A3:G3');
$sheet->setCellValue('A3', 'الهاتف: ' . $schoolPhone . ' | البريد: ' . $schoolEmail);

/*
|--------------------------------------------------------------------------
| عنوان التقرير
|--------------------------------------------------------------------------
*/
$sheet->mergeCells('A5:G5');
$sheet->setCellValue('A5', $pageTitle);

$sheet->mergeCells('A6:G6');
$sheet->setCellValue('A6', 'تاريخ التصدير: ' . date('Y-m-d H:i') . ' | عدد السجلات: ' . count($rows));

/*
|--------------------------------------------------------------------------
| رأس الجدول
|--------------------------------------------------------------------------
*/
$headers = [
    'عدد',
    'التاريخ',
    'الفصل',
    'اسم الطالب',
    'رقم الطالب',
    'الحالة',
    'ملاحظات'
];

$sheet->fromArray($headers, null, 'A8');

/*
|--------------------------------------------------------------------------
| البيانات
|--------------------------------------------------------------------------
*/
$rowNumber = 9;

if (!empty($rows)) {
    foreach ($rows as $index => $row) {
        $sheet->setCellValue('A' . $rowNumber, $index + 1);
        $sheet->setCellValue('B' . $rowNumber, $row['attendance_date'] ?? '');
        $sheet->setCellValue('C' . $rowNumber, $row['class_name'] ?? '');
        $sheet->setCellValue('D' . $rowNumber, $row['student_name'] ?? '');
        $sheet->setCellValue('E' . $rowNumber, $row['student_number'] ?? '');
        $sheet->setCellValue('F' . $rowNumber, clsHelper::attendanceStatus($row['status'] ?? ''));
        $sheet->setCellValue('G' . $rowNumber, $row['notes'] ?? '-');

        $rowNumber++;
    }
} else {
    $sheet->mergeCells('A9:G9');
    $sheet->setCellValue('A9', 'لا توجد بيانات');
    $rowNumber = 10;
}

$lastRow = max($rowNumber - 1, 8);

/*
|--------------------------------------------------------------------------
| تنسيق الخطوط والمحاذاة
|--------------------------------------------------------------------------
*/
$sheet->getStyle('A1:G' . $lastRow)
    ->getFont()
    ->setName('Tahoma')
    ->setSize(14);

$sheet->getStyle('A1:G' . $lastRow)
    ->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
    ->setVertical(Alignment::VERTICAL_CENTER);

/*
|--------------------------------------------------------------------------
| اسم المدرسة
|--------------------------------------------------------------------------
*/
$sheet->getStyle('A1')
    ->getFont()
    ->setBold(true)
    ->setSize(20);

$sheet->getRowDimension(1)->setRowHeight(35);

/*
|--------------------------------------------------------------------------
| عنوان المدرسة
|--------------------------------------------------------------------------
*/
$sheet->getStyle('A2:A3')
    ->getFont()
    ->setSize(14);

$sheet->getRowDimension(2)->setRowHeight(25);
$sheet->getRowDimension(3)->setRowHeight(25);

/*
|--------------------------------------------------------------------------
| عنوان التقرير
|--------------------------------------------------------------------------
*/
$sheet->getStyle('A5')
    ->getFont()
    ->setBold(true)
    ->setSize(18);

$sheet->getRowDimension(5)->setRowHeight(35);

/*
|--------------------------------------------------------------------------
| معلومات التقرير
|--------------------------------------------------------------------------
*/
$sheet->getStyle('A6')
    ->getFont()
    ->setSize(13);

$sheet->getRowDimension(6)->setRowHeight(28);

/*
|--------------------------------------------------------------------------
| رأس الجدول
|--------------------------------------------------------------------------
*/
$sheet->getStyle('A8:G8')
    ->getFont()
    ->setBold(true)
    ->setSize(14);

$sheet->getStyle('A8:G8')
    ->getFill()
    ->setFillType(Fill::FILL_SOLID)
    ->getStartColor()
    ->setRGB('3852B4');

$sheet->getStyle('A8:G8')
    ->getFont()
    ->getColor()
    ->setRGB('FFFFFF');

$sheet->getRowDimension(8)->setRowHeight(32);

/*
|--------------------------------------------------------------------------
| حدود الجدول
|--------------------------------------------------------------------------
*/
$sheet->getStyle('A8:G' . $lastRow)
    ->getBorders()
    ->getAllBorders()
    ->setBorderStyle(Border::BORDER_THIN);

$sheet->getStyle('A8:G' . $lastRow)
    ->getBorders()
    ->getAllBorders()
    ->getColor()
    ->setRGB('D1D5DB');

/*
|--------------------------------------------------------------------------
| خلفية رأس التقرير
|--------------------------------------------------------------------------
*/
$sheet->getStyle('A1:G6')
    ->getFill()
    ->setFillType(Fill::FILL_SOLID)
    ->getStartColor()
    ->setRGB('F8FAFC');

/*
|--------------------------------------------------------------------------
| تنسيق صف لا توجد بيانات
|--------------------------------------------------------------------------
*/
if (empty($rows)) {
    $sheet->getStyle('A9:G9')
        ->getFont()
        ->setBold(true)
        ->setSize(14);

    $sheet->getStyle('A9:G9')
        ->getFill()
        ->setFillType(Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('FEF3C7');

    $sheet->getRowDimension(9)->setRowHeight(32);
}

/*
|--------------------------------------------------------------------------
| تلوين حالات الحضور
|--------------------------------------------------------------------------
*/
if (!empty($rows)) {
    for ($i = 9; $i <= $lastRow; $i++) {
        $status = $sheet->getCell('F' . $i)->getValue();

        if ($status === 'حاضر') {
            $sheet->getStyle('F' . $i)
                ->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()
                ->setRGB('DCFCE7');
        } elseif ($status === 'غائب') {
            $sheet->getStyle('F' . $i)
                ->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()
                ->setRGB('FEE2E2');
        } elseif ($status === 'متأخر') {
            $sheet->getStyle('F' . $i)
                ->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()
                ->setRGB('FEF3C7');
        } elseif ($status === 'مستأذن') {
            $sheet->getStyle('F' . $i)
                ->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()
                ->setRGB('DBEAFE');
        }

        $sheet->getStyle('F' . $i)
            ->getFont()
            ->setBold(true);
    }
}

/*
|--------------------------------------------------------------------------
| عرض الأعمدة
|--------------------------------------------------------------------------
*/
$sheet->getColumnDimension('A')->setWidth(10);
$sheet->getColumnDimension('B')->setWidth(18);
$sheet->getColumnDimension('C')->setWidth(22);
$sheet->getColumnDimension('D')->setWidth(35);
$sheet->getColumnDimension('E')->setWidth(20);
$sheet->getColumnDimension('F')->setWidth(18);
$sheet->getColumnDimension('G')->setWidth(40);

/*
|--------------------------------------------------------------------------
| ارتفاع الصفوف
|--------------------------------------------------------------------------
*/
if (!empty($rows)) {
    for ($i = 9; $i <= $lastRow; $i++) {
        $sheet->getRowDimension($i)->setRowHeight(30);
    }
}

/*
|--------------------------------------------------------------------------
| تثبيت رأس الجدول
|--------------------------------------------------------------------------
*/
$sheet->freezePane('A9');

/*
|--------------------------------------------------------------------------
| فلاتر Excel
|--------------------------------------------------------------------------
*/
$sheet->setAutoFilter('A8:G' . $lastRow);

/*
|--------------------------------------------------------------------------
| إخراج الملف
|--------------------------------------------------------------------------
*/
if (ob_get_length()) {
    ob_end_clean();
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
header('Pragma: public');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;