<?php

class clsSetting
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function get($key, $default = '')
    {
        $query = "SELECT setting_value FROM settings WHERE setting_key = :setting_key LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':setting_key' => $key
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $row['setting_value'] : $default;
    }

    public function set($key, $value)
    {
        $query = "SELECT id FROM settings WHERE setting_key = :setting_key LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':setting_key' => $key
        ]);

        $exists = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($exists) {
            $query = "UPDATE settings 
                      SET setting_value = :setting_value 
                      WHERE setting_key = :setting_key";

            $stmt = $this->conn->prepare($query);

            return $stmt->execute([
                ':setting_key' => $key,
                ':setting_value' => $value
            ]);
        }

        $query = "INSERT INTO settings (setting_key, setting_value)
                  VALUES (:setting_key, :setting_value)";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':setting_key' => $key,
            ':setting_value' => $value
        ]);
    }

    public function getAll()
    {
        $query = "SELECT * FROM settings ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAttendanceStatuses()
    {
        return [
            'present' => [
                'label' => 'حاضر',
                'active' => $this->get('enable_present', '1') == '1'
            ],
            'absent' => [
                'label' => 'غائب',
                'active' => $this->get('enable_absent', '1') == '1'
            ],
            'late' => [
                'label' => 'متأخر',
                'active' => $this->get('enable_late', '1') == '1'
            ],
            'excused' => [
                'label' => 'مستأذن',
                'active' => $this->get('enable_excused', '1') == '1'
            ],
        ];
    }

    public function getActiveAttendanceStatuses()
    {
        return array_filter($this->getAttendanceStatuses(), function ($status) {
            return $status['active'];
        });
    }

    public function isAttendanceStatusActive($status)
    {
        $statuses = $this->getAttendanceStatuses();

        return isset($statuses[$status]) && $statuses[$status]['active'];
    }

    public function getAttendanceStatusLabel($status)
    {
        $statuses = $this->getAttendanceStatuses();

        return $statuses[$status]['label'] ?? $status;
    }

    public function getAttendanceStatusBadgeClass($status)
    {
        if ($status === 'present') {
            return 'bg-success';
        }

        if ($status === 'absent') {
            return 'bg-danger';
        }

        if ($status === 'late') {
            return 'bg-warning text-dark';
        }

        if ($status === 'excused') {
            return 'bg-info text-dark';
        }

        return 'bg-secondary';
    }
}