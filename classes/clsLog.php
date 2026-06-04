<?php

class clsLog
{
    public static function add($conn, $action, $description = null)
    {
        $userId = clsHelper::auth('user_id');

        $userName = clsHelper::auth('full_name')
            ?: clsHelper::auth('username')
                ?: clsHelper::auth('email')
                    ?: 'غير معروف';

        $ip = self::getIpAddress();
        $agent = $_SERVER['HTTP_USER_AGENT'] ?? null;

        $sql = "INSERT INTO system_logs
                (user_id, user_name, action, description, ip_address, user_agent)
                VALUES
                (:user_id, :user_name, :action, :description, :ip_address, :user_agent)";

        $stmt = $conn->prepare($sql);

        return $stmt->execute([
            ':user_id' => $userId,
            ':user_name' => $userName,
            ':action' => $action,
            ':description' => $description,
            ':ip_address' => $ip,
            ':user_agent' => $agent
        ]);
    }

    public static function all($conn, $limit = 100)
    {
        $sql = "SELECT *
                FROM system_logs
                ORDER BY id DESC
                LIMIT :limit";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function search($conn, $keyword = '', $action = '', $date = '', $limit = 300)
    {
        $sql = "SELECT *
                FROM system_logs
                WHERE 1=1";

        $params = [];

        if (!empty($keyword)) {
            $sql .= " AND (
                user_name LIKE :keyword
                OR action LIKE :keyword
                OR description LIKE :keyword
                OR ip_address LIKE :keyword
            )";

            $params[':keyword'] = '%' . $keyword . '%';
        }

        if (!empty($action)) {
            $sql .= " AND action = :action";
            $params[':action'] = $action;
        }

        if (!empty($date)) {
            $sql .= " AND DATE(created_at) = :date";
            $params[':date'] = $date;
        }

        $sql .= " ORDER BY id DESC LIMIT :limit";

        $stmt = $conn->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getActions($conn)
    {
        $sql = "SELECT DISTINCT action
                FROM system_logs
                WHERE action IS NOT NULL
                ORDER BY action ASC";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function latest($conn, $limit = 10)
    {
        return self::all($conn, $limit);
    }

    public static function countAll($conn)
    {
        $stmt = $conn->query("SELECT COUNT(*) FROM system_logs");
        return (int)$stmt->fetchColumn();
    }

    public static function countToday($conn)
    {
        $sql = "SELECT COUNT(*)
                FROM system_logs
                WHERE DATE(created_at) = CURDATE()";

        $stmt = $conn->query($sql);

        return (int)$stmt->fetchColumn();
    }

    public static function countActions($conn)
    {
        $sql = "SELECT COUNT(DISTINCT action)
                FROM system_logs";

        $stmt = $conn->query($sql);

        return (int)$stmt->fetchColumn();
    }

    public static function countUniqueUsers($conn)
    {
        $sql = "SELECT COUNT(DISTINCT user_id)
                FROM system_logs
                WHERE user_id IS NOT NULL";

        $stmt = $conn->query($sql);

        return (int)$stmt->fetchColumn();
    }

    public static function countByAction($conn, $action)
    {
        $sql = "SELECT COUNT(*)
                FROM system_logs
                WHERE action = :action";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':action' => $action
        ]);

        return (int)$stmt->fetchColumn();
    }

    public static function getByUser($conn, $userId, $limit = 100)
    {
        $sql = "SELECT *
                FROM system_logs
                WHERE user_id = :user_id
                ORDER BY id DESC
                LIMIT :limit";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':user_id', (int)$userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByAction($conn, $action, $limit = 100)
    {
        $sql = "SELECT *
                FROM system_logs
                WHERE action = :action
                ORDER BY id DESC
                LIMIT :limit";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':action', $action);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private static function getIpAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]);
        }

        return $_SERVER['REMOTE_ADDR'] ?? null;
    }
}