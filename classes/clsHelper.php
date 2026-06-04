<?php

class clsHelper
{
    /*
    |--------------------------------------------------------------------------
    | Password
    |--------------------------------------------------------------------------
    */

    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function verifyPassword($password, $hashedPassword)
    {
        return password_verify($password, $hashedPassword);
    }

    /*
    |--------------------------------------------------------------------------
    | Clean / Escape
    |--------------------------------------------------------------------------
    */

    public static function clean($value)
    {
        return trim($value);
    }

    public static function e($value)
    {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }

    /*
    |--------------------------------------------------------------------------
    | GET / POST
    |--------------------------------------------------------------------------
    */

    public static function post($key, $default = null)
    {
        return isset($_POST[$key]) ? trim($_POST[$key]) : $default;
    }

    public static function get($key, $default = null)
    {
        return isset($_GET[$key]) ? trim($_GET[$key]) : $default;
    }

    /*
    |--------------------------------------------------------------------------
    | Session Helpers
    |--------------------------------------------------------------------------
    */

    public static function sessionSet($group, $key, $value)
    {
        $_SESSION[$group][$key] = $value;
    }

    public static function sessionGet($group, $key, $default = null)
    {
        return $_SESSION[$group][$key] ?? $default;
    }

    public static function sessionRemove($group, $key = null)
    {
        if ($key === null) {
            unset($_SESSION[$group]);
            return;
        }

        unset($_SESSION[$group][$key]);
    }

    public static function sessionSetArray($group, $data)
    {
        $_SESSION[$group] = $data;
    }

    /*
    |--------------------------------------------------------------------------
    | Auth Session
    |--------------------------------------------------------------------------
    */

    public static function auth($key = null)
    {
        if ($key === null) {
            return $_SESSION['auth'] ?? [];
        }

        return self::sessionGet('auth', $key);
    }

    public static function clearAuth()
    {
        self::sessionRemove('auth');
    }

    public static function role()
    {
        return self::auth('role');
    }

    /*
    |--------------------------------------------------------------------------
    | Old Inputs
    |--------------------------------------------------------------------------
    */

    public static function old($key, $default = '')
    {
        return self::e(
            self::sessionGet('old', $key, $default)
        );
    }

    public static function forgetOld()
    {
        self::sessionRemove('old');
    }

    /*
    |--------------------------------------------------------------------------
    | Redirect
    |--------------------------------------------------------------------------
    */

    public static function redirect($path)
    {
        header("Location: $path");
        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | Flash Messages
    |--------------------------------------------------------------------------
    */

    public static function setMessage($type, $message)
    {
        self::sessionSet('flash', $type, $message);
    }

    public static function getMessage($type)
    {
        $message = self::sessionGet('flash', $type);

        self::sessionRemove('flash', $type);

        return $message;
    }

    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    */

    public static function isAdmin()
    {
        return self::role() === 'admin';
    }

    public static function isSupervisor()
    {
        return self::role() === 'supervisor';
    }

    public static function isTeacher()
    {
        return self::role() === 'teacher';
    }

    public static function hasRole($roles)
    {
        if (!is_array($roles)) {
            $roles = [$roles];
        }

        return in_array(self::role(), $roles);
    }

    public static function requireRole($roles)
    {
        if (self::hasRole($roles)) {
            return;
        }

        self::setMessage('error', 'غير مصرح لك بالدخول');

        if (self::isTeacher()) {
            self::redirect(clsPath::attendance() . 'index.php');
        }

        self::redirect(clsPath::dashboardIndex());
    }

    /*
    |--------------------------------------------------------------------------
    | Date Helpers
    |--------------------------------------------------------------------------
    */

    public static function now()
    {
        return date('Y-m-d H:i:s');
    }

    public static function today()
    {
        return date('Y-m-d');
    }

    public static function dateOnly($datetime)
    {
        if (empty($datetime)) {
            return '';
        }

        return date('Y-m-d', strtotime($datetime));
    }

    /*
    |--------------------------------------------------------------------------
    | Random
    |--------------------------------------------------------------------------
    */

    public static function random($length = 10)
    {
        return substr(
            str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'),
            0,
            $length
        );
    }

    /*
    |--------------------------------------------------------------------------
    | URL
    |--------------------------------------------------------------------------
    */

    public static function isActiveUrl($url)
    {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            ? 'https://'
            : 'http://';

        $currentUrl = $scheme . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        return strtok($currentUrl, '?') === strtok($url, '?');
    }

    public static function activeClass($url)
    {
        return self::isActiveUrl($url) ? 'active' : '';
    }

    /*
    |--------------------------------------------------------------------------
    | Debug
    |--------------------------------------------------------------------------
    */

    public static function dd($data)
    {
        echo "<pre dir='ltr'>";
        print_r($data);
        echo "</pre>";
        die();
    }

    public static function showSessions()
    {
        echo "<pre dir='ltr'>";
        print_r($_SESSION);
        echo "</pre>";
    }

    public static function attendanceStatus($status)
    {
        return match ($status) {
            'present' => 'حاضر',
            'absent' => 'غائب',
            'late' => 'متأخر',
            'excused' => 'مستأذن',
            default => '-'
        };
    }

    public static function logBadge($action)
    {
        $class = 'bg-info';

        switch ($action) {
            case 'تسجيل دخول':
                $class = 'bg-dark';
                break;

            case 'تسجيل خروج':
                $class = 'bg-secondary';
                break;

            case 'إضافة مستخدم':
            case 'إضافة طالب':
            case 'إضافة فصل':
                $class = 'bg-success';
                break;

            case 'تعديل مستخدم':
            case 'تعديل طالب':
            case 'تعديل فصل':
            case 'تعديل الإعدادات':
            case 'تعديل حضور':
            case 'تغيير كلمة المرور':
                $class = 'bg-warning text-dark';
                break;

            case 'حذف مستخدم':
            case 'حذف طالب':
            case 'حذف فصل':
                $class = 'bg-danger';
                break;

            case 'تحضير جديد':
                $class = 'bg-primary';
                break;
        }

        return '<span class="badge ' . $class . ' px-2">'
            . self::e($action)
            . '</span>';
    }

    public static function genderBadge($gender)
    {
        if ($gender === 'female') {
            return '<span class="badge bg-danger px-3">أنثى</span>';
        }

        return '<span class="badge bg-primary px-3">ذكر</span>';
    }

    public static function statusBadge($status)
    {
        if ((int)$status === 1) {
            return '<span class="badge bg-success px-3">مفعل</span>';
        }

        return '<span class="badge bg-secondary px-3">غير مفعل</span>';
    }

}