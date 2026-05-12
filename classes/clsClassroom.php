<?php

class clsClassroom
{
    private $conn;

    public $id;
    public $class_name;
    public $class_code;
    public $level_name;
    public $created_at;

    /*
    |--------------------------------------------------------------------------
    | Constructor
    |--------------------------------------------------------------------------
    | استقبال اتصال قاعدة البيانات
    */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /*
    |--------------------------------------------------------------------------
    | fill
    |--------------------------------------------------------------------------
    | تعبئة خصائص الكائن من مصفوفة قادمة من قاعدة البيانات
    */
    private function fill($data)
    {
        $this->id = $data['id'] ?? null;
        $this->class_name = $data['class_name'] ?? null;
        $this->class_code = $data['class_code'] ?? null;
        $this->level_name = $data['level_name'] ?? null;
        $this->created_at = $data['created_at'] ?? null;
    }

    /*
    |--------------------------------------------------------------------------
    | reset
    |--------------------------------------------------------------------------
    | إعادة تعيين خصائص الكائن
    */
    public function reset()
    {
        $this->id = null;
        $this->class_name = null;
        $this->class_code = null;
        $this->level_name = null;
        $this->created_at = null;
    }

    /*
    |--------------------------------------------------------------------------
    | loadById
    |--------------------------------------------------------------------------
    | تحميل فصل عن طريق id
    */
    public function loadById($id)
    {
        if (!is_numeric($id)) {
            return false;
        }

        $query = "SELECT * FROM classrooms WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':id' => (int)$id
        ]);

        $classroom = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$classroom) {
            return false;
        }

        $this->fill($classroom);
        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | loadByCode
    |--------------------------------------------------------------------------
    | تحميل فصل عن طريق رمز الفصل
    */
    public function loadByCode($class_code)
    {
        $query = "SELECT * FROM classrooms WHERE class_code = :class_code LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':class_code' => $class_code
        ]);

        $classroom = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$classroom) {
            return false;
        }

        $this->fill($classroom);
        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | classCodeExists
    |--------------------------------------------------------------------------
    | التحقق من وجود رمز الفصل
    */
    public function classCodeExists($class_code)
    {
        $query = "SELECT id FROM classrooms WHERE class_code = :class_code LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':class_code' => $class_code
        ]);

        return $stmt->fetch() ? true : false;
    }

    /*
    |--------------------------------------------------------------------------
    | classCodeExistsExceptCurrent
    |--------------------------------------------------------------------------
    | التحقق من وجود رمز الفصل مع استثناء السجل الحالي
    */
    public function classCodeExistsExceptCurrent($class_code, $id)
    {
        $query = "SELECT id FROM classrooms WHERE class_code = :class_code AND id != :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':class_code' => $class_code,
            ':id' => (int)$id
        ]);

        return $stmt->fetch() ? true : false;
    }

    /*
    |--------------------------------------------------------------------------
    | insert
    |--------------------------------------------------------------------------
    | إضافة فصل جديد
    */
    public function insert()
    {
        $query = "INSERT INTO classrooms
                  (class_name, class_code, level_name, created_at)
                  VALUES
                  (:class_name, :class_code, :level_name, :created_at)";

        $stmt = $this->conn->prepare($query);

        $result = $stmt->execute([
            ':class_name' => $this->class_name,
            ':class_code' => $this->class_code,
            ':level_name' => $this->level_name,
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
    | تحديث بيانات الفصل
    */
    public function update()
    {
        if (empty($this->id)) {
            return false;
        }

        $query = "UPDATE classrooms SET
                    class_name = :class_name,
                    class_code = :class_code,
                    level_name = :level_name
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':class_name' => $this->class_name,
            ':class_code' => $this->class_code,
            ':level_name' => $this->level_name,
            ':id' => (int)$this->id
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | save
    |--------------------------------------------------------------------------
    | إذا فيه id يحدث، وإذا لا يضيف
    */
    public function save()
    {
        if (!empty($this->id)) {
            return $this->update();
        }

        return $this->insert();
    }

    /*
    |--------------------------------------------------------------------------
    | delete
    |--------------------------------------------------------------------------
    | حذف الفصل الحالي
    */
    public function delete()
    {
        if (empty($this->id)) {
            return false;
        }

        $query = "DELETE FROM classrooms WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':id' => (int)$this->id
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | getAll
    |--------------------------------------------------------------------------
    | جلب جميع الفصول
    */
    public function getAll()
    {
        $query = "SELECT * FROM classrooms ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | countAll
    |--------------------------------------------------------------------------
    | عدّ جميع الفصول
    */
    public function countAll()
    {
        $query = "SELECT COUNT(*) AS total FROM classrooms";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)($row['total'] ?? 0);
    }

    /*
    |--------------------------------------------------------------------------
    | countStudentsInClass
    |--------------------------------------------------------------------------
    | عدّ جميع الطلاب داخل الفصل
    */
    public function countStudentsInClass($idClass)
    {
        $query = "SELECT COUNT(*) AS total
              FROM students
              WHERE classroom_id = :idClass";

        $stmt = $this->conn->prepare($query);

        $stmt->execute([
            ':idClass' => (int)$idClass
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int)($row['total'] ?? 0);
    }

    /*
    |--------------------------------------------------------------------------
    | toArray
    |--------------------------------------------------------------------------
    | تحويل بيانات الكائن إلى مصفوفة
    */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'class_name' => $this->class_name,
            'class_code' => $this->class_code,
            'level_name' => $this->level_name,
            'created_at' => $this->created_at,
        ];
    }
}