<?php

class clsReport
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /*
    |--------------------------------------------------------------------------
    | تقرير يومي
    |--------------------------------------------------------------------------
    */
    public function getDailyReport($attendance_date, $classroom_id = null)
    {
        $query = "SELECT
                    attendance.*,
                    students.student_name,
                    students.student_number,
                    classrooms.class_name
                  FROM attendance
                  LEFT JOIN students   ON students.id = attendance.student_id
                  LEFT JOIN classrooms ON classrooms.id = attendance.classroom_id
                  WHERE attendance.attendance_date = :attendance_date";

        $params = [
            ':attendance_date' => $attendance_date
        ];

        if (!empty($classroom_id)) {
            $query .= " AND attendance.classroom_id = :classroom_id";
            $params[':classroom_id'] = (int)$classroom_id;
        }

        $query .= " ORDER BY classrooms.class_name ASC, students.student_name ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | تقرير أسبوعي
    |--------------------------------------------------------------------------
    */
    public function getWeeklyReport($date_from, $date_to, $classroom_id = null)
    {
        $query = "SELECT
                    attendance.*,
                    students.student_name,
                    students.student_number,
                    classrooms.class_name
                  FROM attendance
                  LEFT JOIN students   ON students.id = attendance.student_id
                  LEFT JOIN classrooms ON classrooms.id = attendance.classroom_id
                  WHERE attendance.attendance_date BETWEEN :date_from AND :date_to";

        $params = [
            ':date_from' => $date_from,
            ':date_to' => $date_to
        ];

        if (!empty($classroom_id)) {
            $query .= " AND attendance.classroom_id = :classroom_id";
            $params[':classroom_id'] = (int)$classroom_id;
        }

        $query .= " ORDER BY attendance.attendance_date DESC, classrooms.class_name ASC, students.student_name ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | تقرير شهري
    |--------------------------------------------------------------------------
    */
    public function getMonthlyReport($year, $month, $classroom_id = null)
    {
        $query = "SELECT
                    attendance.*,
                    students.student_name,
                    students.student_number,
                    classrooms.class_name
                  FROM attendance
                  LEFT JOIN students   ON students.id = attendance.student_id
                  LEFT JOIN classrooms ON classrooms.id = attendance.classroom_id
                  WHERE YEAR(attendance.attendance_date) = :year
                    AND MONTH(attendance.attendance_date) = :month";

        $params = [
            ':year' => (int)$year,
            ':month' => (int)$month
        ];

        if (!empty($classroom_id)) {
            $query .= " AND attendance.classroom_id = :classroom_id";
            $params[':classroom_id'] = (int)$classroom_id;
        }

        $query .= " ORDER BY attendance.attendance_date DESC, classrooms.class_name ASC, students.student_name ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | تقرير حسب الفصل
    |--------------------------------------------------------------------------
    */
    public function getClassroomReport($classroom_id, $date_from = null, $date_to = null)
    {
        $query = "SELECT
                    attendance.*,
                    students.student_name,
                    students.student_number,
                    classrooms.class_name
                  FROM attendance
                  LEFT JOIN students   ON students.id = attendance.student_id
                  LEFT JOIN classrooms ON classrooms.id = attendance.classroom_id
                  WHERE attendance.classroom_id = :classroom_id";

        $params = [
            ':classroom_id' => (int)$classroom_id
        ];

        if (!empty($date_from) && !empty($date_to)) {
            $query .= " AND attendance.attendance_date BETWEEN :date_from AND :date_to";
            $params[':date_from'] = $date_from;
            $params[':date_to'] = $date_to;
        }

        $query .= " ORDER BY attendance.attendance_date DESC, students.student_name ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | تقرير حسب الطالب
    |--------------------------------------------------------------------------
    */
    public function getStudentReport($student_id, $date_from = null, $date_to = null)
    {
        $query = "SELECT
                    attendance.*,
                    students.student_name,
                    students.student_number,
                    classrooms.class_name
                  FROM attendance
                  LEFT JOIN students   ON students.id = attendance.student_id
                  LEFT JOIN classrooms ON classrooms.id = attendance.classroom_id
                  WHERE attendance.student_id = :student_id";

        $params = [
            ':student_id' => (int)$student_id
        ];

        if (!empty($date_from) && !empty($date_to)) {
            $query .= " AND attendance.attendance_date BETWEEN :date_from AND :date_to";
            $params[':date_from'] = $date_from;
            $params[':date_to'] = $date_to;
        }

        $query .= " ORDER BY attendance.attendance_date DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | تقرير الغياب
    |--------------------------------------------------------------------------
    */
    public function getAbsencesReport($date_from = null, $date_to = null, $classroom_id = null)
    {
        $query = "SELECT
                    attendance.*,
                    students.student_name,
                    students.student_number,
                    classrooms.class_name
                  FROM attendance
                  LEFT JOIN students   ON students.id = attendance.student_id
                  LEFT JOIN classrooms ON classrooms.id = attendance.classroom_id
                  WHERE attendance.status = 'absent'";

        $params = [];

        if (!empty($date_from) && !empty($date_to)) {
            $query .= " AND attendance.attendance_date BETWEEN :date_from AND :date_to";
            $params[':date_from'] = $date_from;
            $params[':date_to'] = $date_to;
        }

        if (!empty($classroom_id)) {
            $query .= " AND attendance.classroom_id = :classroom_id";
            $params[':classroom_id'] = (int)$classroom_id;
        }

        $query .= " ORDER BY attendance.attendance_date DESC, classrooms.class_name ASC, students.student_name ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | تقرير التأخير
    |--------------------------------------------------------------------------
    */
    public function getLateReport($date_from = null, $date_to = null, $classroom_id = null)
    {
        $query = "SELECT
                    attendance.*,
                    students.student_name,
                    students.student_number,
                    classrooms.class_name
                  FROM attendance
                  LEFT JOIN students   ON students.id = attendance.student_id
                  LEFT JOIN classrooms ON classrooms.id = attendance.classroom_id
                  WHERE attendance.status = 'late'";

        $params = [];

        if (!empty($date_from) && !empty($date_to)) {
            $query .= " AND attendance.attendance_date BETWEEN :date_from AND :date_to";
            $params[':date_from'] = $date_from;
            $params[':date_to'] = $date_to;
        }

        if (!empty($classroom_id)) {
            $query .= " AND attendance.classroom_id = :classroom_id";
            $params[':classroom_id'] = (int)$classroom_id;
        }

        $query .= " ORDER BY attendance.attendance_date DESC, classrooms.class_name ASC, students.student_name ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | ملخص حسب الحالة
    |--------------------------------------------------------------------------
    */
    public function getSummaryByStatus($date_from = null, $date_to = null, $classroom_id = null)
    {
        $query = "SELECT status, COUNT(*) AS total
                  FROM attendance
                  WHERE 1 = 1";

        $params = [];

        if (!empty($date_from) && !empty($date_to)) {
            $query .= " AND attendance_date BETWEEN :date_from AND :date_to";
            $params[':date_from'] = $date_from;
            $params[':date_to'] = $date_to;
        }

        if (!empty($classroom_id)) {
            $query .= " AND classroom_id = :classroom_id";
            $params[':classroom_id'] = (int)$classroom_id;
        }

        $query .= " GROUP BY status";

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}