<?php

class clsUser
{
    private $conn;

    public $id;
    public $full_name;
    public $username;
    public $email;
    public $password;
    public $role;
    public $status;
    public $created_at;

    /*
    |--------------------------------------------------------------------------
    | Constructor
    |--------------------------------------------------------------------------
    | يستقبل اتصال قاعدة البيانات من الخارج
    */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /*
    |--------------------------------------------------------------------------
    | fill
    |--------------------------------------------------------------------------
    | تعبئة خصائص الكائن من بيانات قادمة من قاعدة البيانات
    */
    private function fill($data)
    {
        $this->id = $data['id'] ?? null;
        $this->full_name = $data['full_name'] ?? null;
        $this->username = $data['username'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->password = $data['password'] ?? null;
        $this->role = $data['role'] ?? null;
        $this->status = $data['status'] ?? null;
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
        $this->full_name = null;
        $this->username = null;
        $this->email = null;
        $this->password = null;
        $this->role = null;
        $this->status = null;
        $this->created_at = null;
    }

    /*
    |--------------------------------------------------------------------------
    | loadById
    |--------------------------------------------------------------------------
    | تحميل مستخدم عن طريق الـ ID
    */
    public function loadById($id)
    {
        if (!is_numeric($id)) {
            return false;
        }

        $query = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':id' => (int)$id
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return false;
        }

        $this->fill($user);
        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | loadByUsername
    |--------------------------------------------------------------------------
    | تحميل مستخدم عن طريق اسم المستخدم
    */
    public function loadByUsername($username)
    {
        $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':username' => $username
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return false;
        }

        $this->fill($user);
        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | loadByEmail
    |--------------------------------------------------------------------------
    | تحميل مستخدم عن طريق البريد الإلكتروني
    */
    public function loadByEmail($email)
    {
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':email' => $email
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return false;
        }

        $this->fill($user);
        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | loadByLogin
    |--------------------------------------------------------------------------
    | تحميل مستخدم عن طريق username أو email
    */
    public function loadByLogin($login)
    {
        $query = "SELECT * FROM users WHERE username = :login OR email = :login LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':login' => $login
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return false;
        }

        $this->fill($user);
        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | usernameExists
    |--------------------------------------------------------------------------
    | التحقق من وجود اسم مستخدم مسبقًا
    */
    public function usernameExists($username)
    {
        $query = "SELECT id FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':username' => $username
        ]);

        return $stmt->fetch() ? true : false;
    }

    /*
    |--------------------------------------------------------------------------
    | emailExists
    |--------------------------------------------------------------------------
    | التحقق من وجود بريد إلكتروني مسبقًا
    */
    public function emailExists($email)
    {
        $query = "SELECT id FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':email' => $email
        ]);

        return $stmt->fetch() ? true : false;
    }

    /*
    |--------------------------------------------------------------------------
    | usernameExistsExceptCurrent
    |--------------------------------------------------------------------------
    | التحقق من وجود اسم مستخدم لمستخدم آخر أثناء التعديل
    */
    public function usernameExistsExceptCurrent($username, $id)
    {
        $query = "SELECT id FROM users WHERE username = :username AND id != :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':username' => $username,
            ':id' => (int)$id
        ]);

        return $stmt->fetch() ? true : false;
    }

    /*
    |--------------------------------------------------------------------------
    | emailExistsExceptCurrent
    |--------------------------------------------------------------------------
    | التحقق من وجود إيميل لمستخدم آخر أثناء التعديل
    */
    public function emailExistsExceptCurrent($email, $id)
    {
        $query = "SELECT id FROM users WHERE email = :email AND id != :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':email' => $email,
            ':id' => (int)$id
        ]);

        return $stmt->fetch() ? true : false;
    }

    /*
    |--------------------------------------------------------------------------
    | checkPassword
    |--------------------------------------------------------------------------
    | التحقق من كلمة المرور المدخلة مع المشفرة الموجودة في الكائن
    */
    public function checkPassword($password)
    {
        if (empty($this->password)) {
            return false;
        }

        return clsHelper::verifyPassword($password, $this->password);
    }

    /*
    |--------------------------------------------------------------------------
    | isActive
    |--------------------------------------------------------------------------
    | التحقق من أن الحساب فعال
    */
    public function isActive()
    {
        return (int)$this->status === 1;
    }

    /*
    |--------------------------------------------------------------------------
    | isAdmin
    |--------------------------------------------------------------------------
    | التحقق من أن المستخدم مدير
    */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /*
    |--------------------------------------------------------------------------
    | insert
    |--------------------------------------------------------------------------
    | إضافة مستخدم جديد
    | ملاحظة: يجب أن تكون كلمة المرور مشفرة قبل الاستدعاء
    */
    public function insert()
    {
        $query = "INSERT INTO users 
                  (full_name, username, email, password, role, status, created_at)
                  VALUES
                  (:full_name, :username, :email, :password, :role, :status, :created_at)";

        $stmt = $this->conn->prepare($query);

        $result = $stmt->execute([
            ':full_name' => $this->full_name,
            ':username' => $this->username,
            ':email' => $this->email,
            ':password' => $this->password,
            ':role' => $this->role ?? 'teacher',
            ':status' => $this->status ?? 1,
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
    | تحديث بيانات المستخدم بدون تغيير كلمة المرور
    */
    public function update()
    {
        if (empty($this->id)) {
            return false;
        }

        $query = "UPDATE users SET
                    full_name = :full_name,
                    username  = :username,
                    email     = :email,
                    role      = :role,
                    status    = :status
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':full_name' => $this->full_name,
            ':username' => $this->username,
            ':email' => $this->email,
            ':role' => $this->role,
            ':status' => $this->status,
            ':id' => (int)$this->id
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | updatePassword
    |--------------------------------------------------------------------------
    | تحديث كلمة المرور لمستخدم محدد
    */
    public function updatePassword($newPassword)
    {
        if (empty($this->id)) {
            return false;
        }

        $hashedPassword = clsHelper::hashPassword($newPassword);

        $query = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $result = $stmt->execute([
            ':password' => $hashedPassword,
            ':id' => (int)$this->id
        ]);

        if ($result) {
            $this->password = $hashedPassword;
        }

        return $result;
    }

    /*
    |--------------------------------------------------------------------------
    | save
    |--------------------------------------------------------------------------
    | لو فيه id يحدث، ولو ما فيه id يضيف
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
    | حذف المستخدم الحالي
    */
    public function delete()
    {
        if (empty($this->id)) {
            return false;
        }

        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':id' => (int)$this->id
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | getAll
    |--------------------------------------------------------------------------
    | جلب جميع المستخدمين
    */
    public function getAll()
    {
        $query = "SELECT * FROM users ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | getAllActive
    |--------------------------------------------------------------------------
    | جلب جميع المستخدمين المفعلين فقط
    */
    public function getAllActive()
    {
        $query = "SELECT * FROM users WHERE status = 1 ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | countAll
    |--------------------------------------------------------------------------
    | عدد المستخدمين
    */
    public function countAll()
    {
        $query = "SELECT COUNT(*) as total FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$row['total'];
    }

    /*
    |--------------------------------------------------------------------------
    | countActive
    |--------------------------------------------------------------------------
    | عدد المستخدمين المفعلين
    */
    public function countActive()
    {
        $query = "SELECT COUNT(*) as total FROM users WHERE status = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$row['total'];
    }

    /*
    |--------------------------------------------------------------------------
    | login
    |--------------------------------------------------------------------------
    | تنفيذ تسجيل الدخول
    | يرجع true عند النجاح
    */
    public function login($login, $password)
    {
        if (!$this->loadByLogin($login)) {
            return false;
        }

        //if (!$this->isActive()) {
        // return false;
        //}

        if (!$this->checkPassword($password)) {
            return false;
        }

        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | createSession
    |--------------------------------------------------------------------------
    | إنشاء جلسة للمستخدم الحالي بعد تسجيل الدخول
    */
    public function createSession()
    {
        session_regenerate_id(true);

        $_SESSION['user_id'] = $this->id;
        $_SESSION['full_name'] = $this->full_name;
        $_SESSION['username'] = $this->username;
        $_SESSION['email'] = $this->email;
        $_SESSION['role'] = $this->role;
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
            'full_name' => $this->full_name,
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
            'role' => $this->role,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }

    /*
|--------------------------------------------------------------------------
| countByRole
|--------------------------------------------------------------------------
| عدّ المستخدمين حسب الدور
*/
    public function countByRole($role)
    {
        $query = "SELECT COUNT(*) AS total FROM users WHERE role = :role";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':role' => $role
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)($row['total'] ?? 0);
    }

    /*
    |--------------------------------------------------------------------------
    | getAllUsers
    |--------------------------------------------------------------------------
    | جلب جميع المستخدمين
    */
    public function getAllUsers()
    {
        $query = "SELECT * FROM users ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}