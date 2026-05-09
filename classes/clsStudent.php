<?php

class clsStudent
{
    private $conn;

    public $id;
    public $classroom_id;
    public $student_name;
    public $student_number;
    public $gender;
    public $birth_date;
    public $phone;
    public $parent_name;
    public $parent_phone;
    public $address;
    public $status;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    private function fill($data)
    {
        $this->id = $data['id'] ?? null;
        $this->classroom_id = $data['classroom_id'] ?? null;
        $this->student_name = $data['student_name'] ?? null;
        $this->student_number = $data['student_number'] ?? null;
        $this->gender = $data['gender'] ?? null;
        $this->birth_date = $data['birth_date'] ?? null;
        $this->phone = $data['phone'] ?? null;
        $this->parent_name = $data['parent_name'] ?? null;
        $this->parent_phone = $data['parent_phone'] ?? null;
        $this->address = $data['address'] ?? null;
        $this->status = $data['status'] ?? null;
        $this->created_at = $data['created_at'] ?? null;
    }

    public function loadById($id)
    {
        if (!is_numeric($id)) {
            return false;
        }

        $query = "SELECT * FROM students WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':id' => (int)$id
        ]);

        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$student) {
            return false;
        }

        $this->fill($student);
        return true;
    }

    public function studentNumberExists($student_number)
    {
        $query = "SELECT id FROM students WHERE student_number = :student_number LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':student_number' => $student_number
        ]);

        return $stmt->fetch() ? true : false;
    }

    public function studentNumberExistsExceptCurrent($student_number, $id)
    {
        $query = "SELECT id FROM students WHERE student_number = :student_number AND id != :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':student_number' => $student_number,
            ':id' => (int)$id
        ]);

        return $stmt->fetch() ? true : false;
    }

    public function insert()
    {
        $query = "INSERT INTO students
                  (classroom_id, student_name, student_number, gender, birth_date, phone, parent_name, parent_phone, address, status, created_at)
                  VALUES
                  (:classroom_id, :student_name, :student_number, :gender, :birth_date, :phone, :parent_name, :parent_phone, :address, :status, :created_at)";

        $stmt = $this->conn->prepare($query);

        $result = $stmt->execute([
            ':classroom_id' => $this->classroom_id,
            ':student_name' => $this->student_name,
            ':student_number' => $this->student_number,
            ':gender' => $this->gender,
            ':birth_date' => $this->birth_date,
            ':phone' => $this->phone,
            ':parent_name' => $this->parent_name,
            ':parent_phone' => $this->parent_phone,
            ':address' => $this->address,
            ':status' => $this->status ?? 1,
            ':created_at' => $this->created_at ?? date('Y-m-d H:i:s')
        ]);

        if ($result) {
            $this->id = $this->conn->lastInsertId();
        }

        return $result;
    }

    public function update()
    {
        if (empty($this->id)) {
            return false;
        }

        $query = "UPDATE students SET
                    classroom_id   = :classroom_id,
                    student_name   = :student_name,
                    student_number = :student_number,
                    gender         = :gender,
                    birth_date     = :birth_date,
                    phone          = :phone,
                    parent_name    = :parent_name,
                    parent_phone   = :parent_phone,
                    address        = :address,
                    status         = :status
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':classroom_id' => $this->classroom_id,
            ':student_name' => $this->student_name,
            ':student_number' => $this->student_number,
            ':gender' => $this->gender,
            ':birth_date' => $this->birth_date,
            ':phone' => $this->phone,
            ':parent_name' => $this->parent_name,
            ':parent_phone' => $this->parent_phone,
            ':address' => $this->address,
            ':status' => $this->status,
            ':id' => (int)$this->id
        ]);
    }

    public function delete()
    {
        if (empty($this->id)) {
            return false;
        }

        $query = "DELETE FROM students WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':id' => (int)$this->id
        ]);
    }

    public function countAll()
    {
        $query = "SELECT COUNT(*) AS total FROM students";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)($row['total'] ?? 0);
    }

    public function getAll()
    {
        $query = "SELECT students.*, classrooms.class_name
                  FROM students
                  LEFT JOIN classrooms ON classrooms.id = students.classroom_id
                  ORDER BY students.id DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllByClassroomId($classroom_id)
    {
        $query = "SELECT * FROM students WHERE classroom_id = :classroom_id ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':classroom_id' => (int)$classroom_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
|--------------------------------------------------------------------------
| getPaginated
|--------------------------------------------------------------------------
| جلب الطلاب على دفعات بدل جلب الكل
*/
    public function getPaginated($limit, $offset)
    {
        $query = "SELECT students.*, classrooms.class_name
              FROM students
              LEFT JOIN classrooms ON classrooms.id = students.classroom_id
              ORDER BY students.id DESC
              LIMIT :limit OFFSET :offset";

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countByGender($Ge = "male")
    {
        $Gender = $Ge === 'male' ? "male" : "female";

        $query = "SELECT COUNT(*) AS total 
              FROM students 
              WHERE gender = :gender";

        $stmt = $this->conn->prepare($query);

        $stmt->execute([
            ':gender' => $Gender
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int)($row['total'] ?? 0);
    }

    public function countByStatus($st = "active")
    {
        $status = $st === 'active' ? 1 : 0;

        $query = "SELECT COUNT(*) AS total 
              FROM students 
              WHERE status = :status";

        $stmt = $this->conn->prepare($query);

        $stmt->execute([
            ':status' => $status
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int)($row['total'] ?? 0);
    }
}