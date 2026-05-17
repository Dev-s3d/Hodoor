<?php
require_once '../../config/bootstrap.php';

// إذا المستخدم مسجل دخول
if (clsHelper::auth('user_id') !== null) {
    if (clsHelper::isTeacher()) {
        clsHelper::redirect(clsPath::attendance() . 'index.php');
    }

    clsHelper::redirect(clsPath::dashboardIndex());
}

$rememberLogin = $_COOKIE['remember_user'] ?? '';
$loginValue = clsHelper::old('login', $rememberLogin);
?>

<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل دخول الإدارة - Hodoor</title>

    <link href="<?= clsPath::bootstrapCss(); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= clsPath::fontawesome(); ?>">
    <link rel="stylesheet" href="<?= clsPath::assets(); ?>css/login.css">
</head>

<body>

<div class="container login-wrapper d-flex align-items-center justify-content-center py-5">
    <div class="row w-100 justify-content-center">
        <div class="col-xl-10 col-lg-11">
            <div class="card login-card">
                <div class="row g-0">

                    <div class="col-lg-6">
                        <div class="login-side h-100 d-flex flex-column justify-content-center">
                            <div class="brand-icon">
                                <i class="fa-solid fa-school"></i>
                            </div>

                            <h2>مرحبًا بك في نظام Hodoor</h2>

                            <p>
                                نظام متكامل لإدارة حضور الطلاب، يتيح لك تسجيل الحضور والغياب
                                والتأخير بسهولة، مع تقارير دقيقة ولوحة تحكم احترافية.
                            </p>

                            <ul class="list-unstyled mt-4 mb-0">
                                <li class="mb-3">
                                    <i class="fa-solid fa-check text-success me-2"></i>
                                    تسجيل الحضور اليومي بسهولة
                                </li>

                                <li class="mb-3">
                                    <i class="fa-solid fa-check text-success me-2"></i>
                                    تقارير مفصلة للطلاب
                                </li>

                                <li class="mb-3">
                                    <i class="fa-solid fa-check text-success me-2"></i>
                                    إدارة الصفوف والطلاب
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="login-form-side">

                            <div class="text-center text-lg-start mb-4">
                                <h3 class="login-title">تسجيل دخول الإدارة</h3>
                                <p class="login-subtitle">أدخل بياناتك للوصول إلى لوحة التحكم</p>
                            </div>

                            <?php require_once '../../includes/alerts.php'; ?>

                            <form action="<?= clsPath::loginAction(); ?>" method="POST">

                                <div class="mb-3">
                                    <label class="form-label">اسم المستخدم أو البريد الإلكتروني</label>

                                    <input
                                            type="text"
                                            name="login"
                                            class="form-control"
                                            placeholder="أدخل البيانات"
                                            value="<?= $loginValue; ?>"
                                            required
                                    >
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">كلمة المرور</label>

                                    <div class="input-group">
                                        <input
                                                type="password"
                                                name="password"
                                                id="password"
                                                class="form-control"
                                                placeholder="أدخل كلمة المرور"
                                                required
                                        >

                                        <button
                                                type="button"
                                                class="btn btn-outline-primary"
                                                onclick="togglePassword()">
                                            <i class="fa-solid fa-eye" id="icon"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="remember"
                                                id="remember"
                                                <?= !empty($rememberLogin) ? 'checked' : ''; ?>
                                        >

                                        <label class="form-check-label" for="remember">
                                            تذكرني
                                        </label>
                                    </div>

                                    <a href="forgot_password.php" class="small-link text-primary">
                                        نسيت كلمة المرور؟
                                    </a>
                                </div>

                                <div class="d-grid">
                                    <button class="btn btn-primary btn-login">
                                        دخول
                                    </button>
                                </div>

                            </form>

                            <div class="text-center mt-4 text-muted small">
                                © <?= date('Y'); ?> Hodoor
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        let input = document.getElementById("password");
        let icon = document.getElementById("icon");

        if (input.type === "password") {
            input.type = "text";
            icon.classList.replace("fa-eye", "fa-eye-slash");
        } else {
            input.type = "password";
            icon.classList.replace("fa-eye-slash", "fa-eye");
        }
    }
</script>

<script src="<?= clsPath::bootstrapJs(); ?>"></script>

</body>
</html>