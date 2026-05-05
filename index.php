<?php
require_once './config/bootstrap.php';
?>

<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hodoor | نظام إدارة الحضور المدرسي</title>

    <link rel="stylesheet" href="<?= clsPath::bootstrapCss(); ?>">
    <link rel="stylesheet" href="<?= clsPath::fontawesome(); ?>">
    <link rel="stylesheet" href="<?= clsPath::css(); ?>home.css">

</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm py-3">
    <div class="container">

        <a class="navbar-brand fw-bold fs-3" href="<?= clsPath::home(); ?>">
            <i class="fa fa-check-circle text-primary me-1"></i>
            Hodoor
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse mt-3 mt-lg-0" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-lg-3">
                <li class="nav-item">
                    <a class="nav-link active" href="#home">الرئيسية</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#features">المميزات</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#how">طريقة العمل</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#about">عن النظام</a>
                </li>
            </ul>

            <div class="d-flex gap-2">
                <a href="<?= clsPath::login(); ?>" class="btn btn-main">
                    دخول النظام
                </a>
            </div>
        </div>

    </div>
</nav>

<!-- Hero -->
<section class="hero" id="home">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-6">
                <h1 class="hero-title mb-4">
                    نظام <span>Hodoor</span><br>
                    لإدارة حضور الطلاب بسهولة
                </h1>

                <p class="lead text-muted mb-4">
                    منصة بسيطة ومنظمة تساعد المدرسة على تسجيل حضور الطلاب يوميًا،
                    متابعة الغياب والتأخير، واستخراج تقارير واضحة للإدارة والمعلمين.
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a href="<?= clsPath::login(); ?>" class="btn btn-main btn-lg">
                        <i class="fa fa-right-to-bracket me-1"></i>
                        دخول لوحة التحكم
                    </a>

                    <a href="#features" class="btn btn-outline-secondary btn-lg rounded-3">
                        تعرف على المميزات
                    </a>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card hero-card scale-up-hor-right">
                    <div class="card-body p-4 p-md-5 ">

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="fw-bold mb-1">ملخص الحضور اليوم</h4>
                                <p class="text-muted mb-0">واجهة مبسطة وسريعة</p>
                            </div>

                            <div class="feature-icon mb-0">
                                <i class="fa fa-chart-column"></i>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-6">
                                <div class="stat-box">
                                    <div class="text-muted small">حاضر</div>
                                    <h3 class="text-success mb-0">145</h3>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="stat-box">
                                    <div class="text-muted small">غائب</div>
                                    <h3 class="text-danger mb-0">12</h3>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="stat-box">
                                    <div class="text-muted small">متأخر</div>
                                    <h3 class="text-warning mb-0">7</h3>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="stat-box">
                                    <div class="text-muted small">مستأذن</div>
                                    <h3 class="text-info mb-0">4</h3>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="alert alert-primary mb-0">
                                <i class="fa fa-circle-info me-1"></i>
                                لوحة تحكم تعرض حالة الحضور بشكل مباشر.
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Features -->
<section class="py-5" id="features">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="section-title">مميزات النظام</h2>
            <p class="text-muted">كل ما تحتاجه المدرسة لتنظيم الحضور في مكان واحد</p>
        </div>

        <div class="row g-4">

            <div class="col-md-6 col-lg-4">
                <div class="card feature-card shadow-sm">
                    <div class="card-body p-4">
                        <div class="feature-icon">
                            <i class="fa fa-user-check"></i>
                        </div>
                        <h5 class="fw-bold">تسجيل حضور سريع</h5>
                        <p class="text-muted mb-0">
                            اختيار الفصل والتاريخ ثم تسجيل حالة كل طالب بسهولة.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card feature-card shadow-sm">
                    <div class="card-body p-4">
                        <div class="feature-icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <h5 class="fw-bold">إدارة الطلاب</h5>
                        <p class="text-muted mb-0">
                            إضافة الطلاب وربطهم بالفصول وتنظيم بياناتهم الأساسية.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card feature-card shadow-sm">
                    <div class="card-body p-4">
                        <div class="feature-icon">
                            <i class="fa fa-school"></i>
                        </div>
                        <h5 class="fw-bold">إدارة الفصول</h5>
                        <p class="text-muted mb-0">
                            إنشاء الفصول والشعب وربط كل طالب بفصله المناسب.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card feature-card shadow-sm">
                    <div class="card-body p-4">
                        <div class="feature-icon">
                            <i class="fa fa-chart-bar"></i>
                        </div>
                        <h5 class="fw-bold">تقارير واضحة</h5>
                        <p class="text-muted mb-0">
                            تقارير يومية وأسبوعية وشهرية للغياب والتأخير والحضور.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card feature-card shadow-sm">
                    <div class="card-body p-4">
                        <div class="feature-icon">
                            <i class="fa fa-user-shield"></i>
                        </div>
                        <h5 class="fw-bold">صلاحيات المستخدمين</h5>
                        <p class="text-muted mb-0">
                            صلاحيات للمدير والمشرف والمعلم حسب طبيعة العمل.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card feature-card shadow-sm">
                    <div class="card-body p-4">
                        <div class="feature-icon">
                            <i class="fa fa-mobile-screen"></i>
                        </div>
                        <h5 class="fw-bold">متوافق مع الأجهزة</h5>
                        <p class="text-muted mb-0">
                            تصميم متجاوب يعمل على الجوال والتابلت والكمبيوتر.
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- How it works -->
<section class="py-5 bg-white" id="how">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="section-title">كيف يعمل النظام؟</h2>
            <p class="text-muted">خطوات بسيطة لتسجيل الحضور اليومي</p>
        </div>

        <div class="row g-4">

            <div class="col-md-3">
                <div class="text-center">
                    <div class="feature-icon mx-auto">
                        <i class="fa fa-right-to-bracket"></i>
                    </div>
                    <h5 class="fw-bold">1. تسجيل الدخول</h5>
                    <p class="text-muted">يدخل المستخدم إلى النظام حسب صلاحياته.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="text-center">
                    <div class="feature-icon mx-auto">
                        <i class="fa fa-school"></i>
                    </div>
                    <h5 class="fw-bold">2. اختيار الفصل</h5>
                    <p class="text-muted">يتم تحديد الفصل والتاريخ المطلوب.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="text-center">
                    <div class="feature-icon mx-auto">
                        <i class="fa fa-list-check"></i>
                    </div>
                    <h5 class="fw-bold">3. تسجيل الحالات</h5>
                    <p class="text-muted">حاضر، غائب، متأخر، أو مستأذن.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="text-center">
                    <div class="feature-icon mx-auto">
                        <i class="fa fa-chart-line"></i>
                    </div>
                    <h5 class="fw-bold">4. عرض التقارير</h5>
                    <p class="text-muted">تقارير واضحة تساعد الإدارة على المتابعة.</p>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- About -->
<section class="py-5" id="about">
    <div class="container">
        <div class="row align-items-center g-4">

            <div class="col-lg-6">
                <h2 class="section-title mb-3">عن Hodoor</h2>

                <p class="text-muted fs-5">
                    Hodoor هو نظام حضور مدرسي يساعد على تحويل عملية التحضير من طريقة ورقية تقليدية
                    إلى نظام إلكتروني منظم وسهل الاستخدام.
                </p>

                <p class="text-muted">
                    يهدف النظام إلى تقليل الأخطاء، تسريع عملية التحضير، وتوفير تقارير دقيقة عن حضور الطلاب
                    وغيابهم وتأخرهم.
                </p>

                <a href="<?= clsPath::login(); ?>" class="btn btn-main mt-3">
                    ابدأ الآن
                </a>
            </div>

            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">مناسب لـ</h5>

                        <ul class="list-unstyled mb-0">
                            <li class="mb-3">
                                <i class="fa fa-check text-success me-2"></i>
                                المدارس الابتدائية والمتوسطة والثانوية
                            </li>

                            <li class="mb-3">
                                <i class="fa fa-check text-success me-2"></i>
                                المشرفين والإداريين
                            </li>

                            <li class="mb-3">
                                <i class="fa fa-check text-success me-2"></i>
                                المعلمين المسؤولين عن التحضير
                            </li>

                            <li class="mb-0">
                                <i class="fa fa-check text-success me-2"></i>
                                إدارة تقارير الحضور والغياب
                            </li>
                        </ul>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="card border-0 shadow-none rounded-4">
            <div class="card-body p-4 p-md-5 text-center">
                <h2 class="fw-bold mb-3">جاهز لإدارة حضور الطلاب؟</h2>
                <p class="text-muted mb-4">
                    ادخل إلى لوحة التحكم وابدأ تنظيم الحضور والتقارير بسهولة.
                </p>

                <a href="<?= clsPath::login(); ?>" class="btn btn-main btn-lg">
                    دخول النظام
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="py-4 mt-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <strong>Hodoor</strong>
                <span class="text-white-50"> - نظام إدارة الحضور المدرسي</span>
            </div>

            <div class="text-white-50">
                جميع الحقوق محفوظة © <?= date('Y'); ?>
            </div>
        </div>
    </div>
</footer>

<script src="<?= clsPath::bootstrapJs(); ?>"></script>
</body>

</html>