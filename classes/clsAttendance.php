<?php

class clsAttendance
{
    private $conn;

    public $id;
    public $student_id;
    public $classroom_id;
    public $attendance_date;
    public $status;
    public $notes;
    public $recorded_by;
    public $created_at;

    /*
    |--------------------------------------------------------------------------
    | Constructor
    |--------------------------------------------------------------------------
    */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /*
    |--------------------------------------------------------------------------
    | fill
    |--------------------------------------------------------------------------
    */
    private function fill($data)
    {
        $this->id = $data['id'] ?? null;
        $this->student_id = $data['student_id'] ?? null;
        $this->classroom_id = $data['classroom_id'] ?? null;
        $this->attendance_date = $data['attendance_date'] ?? null;
        $this->status = $data['status'] ?? null;
        $this->notes = $data['notes'] ?? null;
        $this->recorded_by = $data['recorded_by'] ?? null;
        $this->created_at = $data['created_at'] ?? null;
    }

    /*
    |--------------------------------------------------------------------------
    | loadById
    |--------------------------------------------------------------------------
    */
    public function loadById($id)
    {
        if (!is_numeric($id)) {
            return false;
        }

        $query = "SELECT * FROM attendance WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':id' => (int)$id
        ]);

        $attendance = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$attendance) {
            return false;
        }

        $this->fill($attendance);
        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | existsForStudentOnDate
    |--------------------------------------------------------------------------
    | هل يوجد سجل حضور للطالب في هذا التاريخ؟
    */
    public function existsForStudentOnDate($student_id, $attendance_date)
    {
        $query = "SELECT id 
                  FROM attendance 
                  WHERE student_id = :student_id AND attendance_date = :attendance_date
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':student_id' => (int)$student_id,
            ':attendance_date' => $attendance_date
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? (int)$row['id'] : false;
    }

    /*
    |--------------------------------------------------------------------------
    | insert
    |--------------------------------------------------------------------------
    */
    public function insert()
    {
        $query = "INSERT INTO attendance
                  (student_id, classroom_id, attendance_date, status, notes, recorded_by, created_at)
                  VALUES
                  (:student_id, :classroom_id, :attendance_date, :status, :notes, :recorded_by, :created_at)";

        $stmt = $this->conn->prepare($query);

        $result = $stmt->execute([
            ':student_id' => $this->student_id,
            ':classroom_id' => $this->classroom_id,
            ':attendance_date' => $this->attendance_date,
            ':status' => $this->status,
            ':notes' => $this->notes,
            ':recorded_by' => $this->recorded_by,
            ':created_at' => $this->created_at ?? date('Y-m-d H:i:s')
        ]);

        if ($result) {
            $this->id = $this->conn->lastInsertId();
        }

        return $result;
    }

    /*
    |--------------------------------------------------------------------------
    | update
    |--------------------------------------------------------------------------
    */
    public function update()
    {
        if (empty($this->id)) {
            return false;
        }

        $query = "UPDATE attendance SET
                    student_id      = :student_id,
                    classroom_id    = :classroom_id,
                    attendance_date = :attendance_date,
                    status          = :status,
                    notes           = :notes,
                    recorded_by     = :recorded_by
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':student_id' => $this->student_id,
            ':classroom_id' => $this->classroom_id,
            ':attendance_date' => $this->attendance_date,
            ':status' => $this->status,
            ':notes' => $this->notes,
            ':recorded_by' => $this->recorded_by,
            ':id' => (int)$this->id
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | saveOrUpdate
    |--------------------------------------------------------------------------
    | إذا يوجد سجل لنفس الطالب في نفس التاريخ يحدثه، وإذا لا يضيفه
    */
    public function saveOrUpdate()
    {
        $existsId = $this->existsForStudentOnDate($this->student_id, $this->attendance_date);

        if ($existsId) {
            $this->id = $existsId;
            return $this->update();
        }

        return $this->insert();
    }

    /*
    |--------------------------------------------------------------------------
    | delete
    |--------------------------------------------------------------------------
    */
    public function delete()
    {
        if (empty($this->id)) {
            return false;
        }

        $query = "DELETE FROM attendance WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':id' => (int)$this->id
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | getAllByDateAndClassroom
    |--------------------------------------------------------------------------
    | جلب حضور يوم معين لفصل معين
    |--------------------------------------------------------------------------
    */
    public function getAllByDateAndClassroom($attendance_date, $classroom_id)
    {
        $query = "SELECT 
                    attendance.*,
                    students.student_name,
                    students.student_number
                  FROM attendance
                  LEFT JOIN students ON students.id = attendance.student_id
                  WHERE attendance.attendance_date = :attendance_date
                    AND attendance.classroom_id = :classroom_id
                  ORDER BY students.student_name ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':attendance_date' => $attendance_date,
            ':classroom_id' => (int)$classroom_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | getStudentAttendanceOnDate
    |--------------------------------------------------------------------------
    */
    public function getStudentAttendanceOnDate($student_id, $attendance_date)
    {
        $query = "SELECT * 
                  FROM attendance
                  WHERE student_id = :student_id
                    AND attendance_date = :attendance_date
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':student_id' => (int)$student_id,
            ':attendance_date' => $attendance_date
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | countByStatus
    |--------------------------------------------------------------------------
    | عدد سجلات الحضور حسب الحالة في تاريخ معين
    */
    public function countByStatus($attendance_date, $status, $classroom_id = null)
    {
        $query = "SELECT COUNT(*) AS total
                  FROM attendance
                  WHERE attendance_date = :attendance_date
                    AND status = :status";

        $params = [
            ':attendance_date' => $attendance_date,
            ':status' => $status
        ];

        if (!empty($classroom_id)) {
            $query .= " AND classroom_id = :classroom_id";
            $params[':classroom_id'] = (int)$classroom_id;
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)($row['total'] ?? 0);
    }

    /*
    |--------------------------------------------------------------------------
    | countAllByDate
    |--------------------------------------------------------------------------
    */
    public function countAllByDate($attendance_date, $classroom_id = null)
    {
        $query = "SELECT COUNT(*) AS total
                  FROM attendance
                  WHERE attendance_date = :attendance_date";

        $params = [
            ':attendance_date' => $attendance_date
        ];

        if (!empty($classroom_id)) {
            $query .= " AND classroom_id = :classroom_id";
            $params[':classroom_id'] = (int)$classroom_id;
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)($row['total'] ?? 0);
    }

    /*
    |--------------------------------------------------------------------------
    | getHistory
    |--------------------------------------------------------------------------
    | سجل الحضور العام مع فلاتر اختيارية
    */
    public function getHistory($filters = [])
    {
        $query = "SELECT
                    attendance.*,
                    students.student_name,
                    students.student_number,
                    classrooms.class_name
                  FROM attendance
                  LEFT JOIN students   ON students.id = attendance.student_id
                  LEFT JOIN classrooms ON classrooms.id = attendance.classroom_id
                  WHERE 1 = 1";

        $params = [];

        if (!empty($filters['attendance_date'])) {
            $query .= " AND attendance.attendance_date = :attendance_date";
            $params[':attendance_date'] = $filters['attendance_date'];
        }

        if (!empty($filters['classroom_id'])) {
            $query .= " AND attendance.classroom_id = :classroom_id";
            $params[':classroom_id'] = (int)$filters['classroom_id'];
        }

        if (!empty($filters['status'])) {
            $query .= " AND attendance.status = :status";
            $params[':status'] = $filters['status'];
        }

        $query .= " ORDER BY attendance.attendance_date DESC, classrooms.class_name ASC, students.student_name ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}