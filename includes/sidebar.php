<?php
$dashboardActive = clsHelper::activeClass(clsPath::dashboardIndex());

$systemOpen = clsHelper::isActiveUrl(clsPath::users() . 'index.php')
        || clsHelper::isActiveUrl(clsPath::settings() . 'index.php');

$schoolOpen = clsHelper::isActiveUrl(clsPath::classrooms() . 'index.php')
        || clsHelper::isActiveUrl(clsPath::students() . 'index.php');

$attendanceOpen = clsHelper::isActiveUrl(clsPath::attendance() . 'index.php')
        || clsHelper::isActiveUrl(clsPath::attendance() . 'daily.php')
        || clsHelper::isActiveUrl(clsPath::attendance() . 'history.php');

$reportsOpen = clsHelper::isActiveUrl(clsPath::reports() . 'daily_report.php')
        || clsHelper::isActiveUrl(clsPath::reports() . 'weekly_report.php')
        || clsHelper::isActiveUrl(clsPath::reports() . 'monthly_report.php')
        || clsHelper::isActiveUrl(clsPath::reports() . 'classroom_report.php')
        || clsHelper::isActiveUrl(clsPath::reports() . 'student_report.php')
        || clsHelper::isActiveUrl(clsPath::reports() . 'absences_report.php')
        || clsHelper::isActiveUrl(clsPath::reports() . 'late_report.php');
?>

<!-- Sidebar Desktop -->
<div class="sidebar text-white p-3 d-none d-lg-block">

    <h4 class="mb-4">
        <i class="fa fa-check-circle text-primary me-1"></i>
        Hodoor
    </h4>

    <ul class="nav flex-column">

        <?php if (clsHelper::hasRole(['admin', 'supervisor'])): ?>
            <li class="nav-item mb-2">
                <a href="<?= clsPath::dashboardIndex(); ?>"
                   class="nav-link text-white <?= $dashboardActive; ?>">
                    <i class="fa fa-home me-2"></i>
                    الرئيسية
                </a>
            </li>
        <?php endif; ?>

        <?php if (clsHelper::isAdmin()): ?>
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex justify-content-between align-items-center <?= $systemOpen ? 'active' : ''; ?>"
                   data-bs-toggle="collapse"
                   href="#desktopSystemMenu"
                   role="button">
                    <span>
                        <i class="fa fa-user-shield me-2"></i>
                        إدارة النظام
                    </span>
                    <i class="fa fa-angle-down small"></i>
                </a>

                <div class="collapse <?= $systemOpen ? 'show' : ''; ?>" id="desktopSystemMenu">
                    <ul class="nav flex-column sidebar-submenu mt-2">
                        <li class="nav-item">
                            <a href="<?= clsPath::users(); ?>index.php"
                               class="nav-link text-white <?= clsHelper::activeClass(clsPath::users() . 'index.php'); ?>">
                                <i class="fa fa-user-cog me-2"></i>
                                المستخدمين
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= clsPath::settings(); ?>index.php"
                               class="nav-link text-white <?= clsHelper::activeClass(clsPath::settings() . 'index.php'); ?>">
                                <i class="fa fa-cog me-2"></i>
                                الإعدادات
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        <?php endif; ?>

        <?php if (clsHelper::hasRole(['admin', 'supervisor'])): ?>
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex justify-content-between align-items-center <?= $schoolOpen ? 'active' : ''; ?>"
                   data-bs-toggle="collapse"
                   href="#desktopSchoolMenu"
                   role="button">
                    <span>
                        <i class="fa fa-school me-2"></i>
                        إدارة المدرسة
                    </span>
                    <i class="fa fa-angle-down small"></i>
                </a>

                <div class="collapse <?= $schoolOpen ? 'show' : ''; ?>" id="desktopSchoolMenu">
                    <ul class="nav flex-column sidebar-submenu mt-2">
                        <li class="nav-item">
                            <a href="<?= clsPath::classrooms(); ?>index.php"
                               class="nav-link text-white <?= clsHelper::activeClass(clsPath::classrooms() . 'index.php'); ?>">
                                <i class="fa fa-chalkboard me-2"></i>
                                الفصول
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= clsPath::students(); ?>index.php"
                               class="nav-link text-white <?= clsHelper::activeClass(clsPath::students() . 'index.php'); ?>">
                                <i class="fa fa-users me-2"></i>
                                الطلاب
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        <?php endif; ?>

        <?php if (clsHelper::hasRole(['admin', 'supervisor', 'teacher'])): ?>
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex justify-content-between align-items-center <?= $attendanceOpen ? 'active' : ''; ?>"
                   data-bs-toggle="collapse"
                   href="#desktopAttendanceMenu"
                   role="button">
                    <span>
                        <i class="fa fa-check-circle me-2"></i>
                        الحضور
                    </span>
                    <i class="fa fa-angle-down small"></i>
                </a>

                <div class="collapse <?= $attendanceOpen ? 'show' : ''; ?>" id="desktopAttendanceMenu">
                    <ul class="nav flex-column sidebar-submenu mt-2">
                        <li class="nav-item">
                            <a href="<?= clsPath::attendance(); ?>index.php"
                               class="nav-link text-white <?= clsHelper::activeClass(clsPath::attendance() . 'index.php'); ?>">
                                <i class="fa fa-clipboard-check me-2"></i>
                                تسجيل الحضور
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= clsPath::attendance(); ?>daily.php"
                               class="nav-link text-white <?= clsHelper::activeClass(clsPath::attendance() . 'daily.php'); ?>">
                                <i class="fa fa-calendar-day me-2"></i>
                                حضور اليوم
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= clsPath::attendance(); ?>history.php"
                               class="nav-link text-white <?= clsHelper::activeClass(clsPath::attendance() . 'history.php'); ?>">
                                <i class="fa fa-clock-rotate-left me-2"></i>
                                سجل الحضور
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        <?php endif; ?>

        <?php if (clsHelper::hasRole(['admin', 'supervisor', 'teacher'])): ?>
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex justify-content-between align-items-center <?= $reportsOpen ? 'active' : ''; ?>"
                   data-bs-toggle="collapse"
                   href="#desktopReportsMenu"
                   role="button">
                    <span>
                        <i class="fa fa-chart-bar me-2"></i>
                        التقارير
                    </span>
                    <i class="fa fa-angle-down small"></i>
                </a>

                <div class="collapse <?= $reportsOpen ? 'show' : ''; ?>" id="desktopReportsMenu">
                    <ul class="nav flex-column sidebar-submenu mt-2">
                        <li class="nav-item">
                            <a href="<?= clsPath::reports(); ?>daily_report.php"
                               class="nav-link text-white <?= clsHelper::activeClass(clsPath::reports() . 'daily_report.php'); ?>">
                                التقرير اليومي
                            </a>
                        </li>

                        <?php if (clsHelper::hasRole(['admin', 'supervisor'])): ?>
                            <li class="nav-item">
                                <a href="<?= clsPath::reports(); ?>weekly_report.php"
                                   class="nav-link text-white <?= clsHelper::activeClass(clsPath::reports() . 'weekly_report.php'); ?>">
                                    التقرير الأسبوعي
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?= clsPath::reports(); ?>monthly_report.php"
                                   class="nav-link text-white <?= clsHelper::activeClass(clsPath::reports() . 'monthly_report.php'); ?>">
                                    التقرير الشهري
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?= clsPath::reports(); ?>classroom_report.php"
                                   class="nav-link text-white <?= clsHelper::activeClass(clsPath::reports() . 'classroom_report.php'); ?>">
                                    تقرير فصل
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?= clsPath::reports(); ?>student_report.php"
                                   class="nav-link text-white <?= clsHelper::activeClass(clsPath::reports() . 'student_report.php'); ?>">
                                    تقرير طالب
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?= clsPath::reports(); ?>absences_report.php"
                                   class="nav-link text-white <?= clsHelper::activeClass(clsPath::reports() . 'absences_report.php'); ?>">
                                    تقرير الغياب
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?= clsPath::reports(); ?>late_report.php"
                                   class="nav-link text-white <?= clsHelper::activeClass(clsPath::reports() . 'late_report.php'); ?>">
                                    تقرير التأخير
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </li>
        <?php endif; ?>

        <li class="nav-item mt-3">
            <a href="<?= clsPath::logout(); ?>" class="nav-link text-danger">
                <i class="fa fa-sign-out-alt me-2"></i>
                تسجيل الخروج
            </a>
        </li>

    </ul>
</div>

<!-- Sidebar Mobile Offcanvas -->
<div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="mobileSidebar">
    <div class="offcanvas-header border-bottom border-primary">
        <button type="button" class="btn-close btn-close-white ms-0 me-auto" data-bs-dismiss="offcanvas"></button>
        <h5 class="offcanvas-title">Hodoor</h5>
    </div>

    <div class="offcanvas-body">
        <ul class="nav flex-column">

            <?php if (clsHelper::hasRole(['admin', 'supervisor'])): ?>
                <li class="nav-item mb-2">
                    <a href="<?= clsPath::dashboardIndex(); ?>"
                       class="nav-link text-white <?= $dashboardActive; ?>">
                        <i class="fa fa-home me-2"></i>
                        الرئيسية
                    </a>
                </li>
            <?php endif; ?>

            <?php if (clsHelper::isAdmin()): ?>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white d-flex justify-content-between align-items-center <?= $systemOpen ? 'active' : ''; ?>"
                       data-bs-toggle="collapse"
                       href="#mobileSystemMenu">
                        <span>
                            <i class="fa fa-user-shield me-2"></i>
                            إدارة النظام
                        </span>
                        <i class="fa fa-angle-down small"></i>
                    </a>

                    <div class="collapse <?= $systemOpen ? 'show' : ''; ?>" id="mobileSystemMenu">
                        <ul class="nav flex-column sidebar-submenu mt-2">
                            <li class="nav-item">
                                <a href="<?= clsPath::users(); ?>index.php"
                                   class="nav-link text-white <?= clsHelper::activeClass(clsPath::users() . 'index.php'); ?>">
                                    المستخدمين
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?= clsPath::settings(); ?>index.php"
                                   class="nav-link text-white <?= clsHelper::activeClass(clsPath::settings() . 'index.php'); ?>">
                                    الإعدادات
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>

            <?php if (clsHelper::hasRole(['admin', 'supervisor'])): ?>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white d-flex justify-content-between align-items-center <?= $schoolOpen ? 'active' : ''; ?>"
                       data-bs-toggle="collapse"
                       href="#mobileSchoolMenu">
                        <span>
                            <i class="fa fa-school me-2"></i>
                            إدارة المدرسة
                        </span>
                        <i class="fa fa-angle-down small"></i>
                    </a>

                    <div class="collapse <?= $schoolOpen ? 'show' : ''; ?>" id="mobileSchoolMenu">
                        <ul class="nav flex-column sidebar-submenu mt-2">
                            <li class="nav-item">
                                <a href="<?= clsPath::classrooms(); ?>index.php"
                                   class="nav-link text-white <?= clsHelper::activeClass(clsPath::classrooms() . 'index.php'); ?>">
                                    الفصول
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?= clsPath::students(); ?>index.php"
                                   class="nav-link text-white <?= clsHelper::activeClass(clsPath::students() . 'index.php'); ?>">
                                    الطلاب
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>

            <?php if (clsHelper::hasRole(['admin', 'supervisor', 'teacher'])): ?>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white d-flex justify-content-between align-items-center <?= $attendanceOpen ? 'active' : ''; ?>"
                       data-bs-toggle="collapse"
                       href="#mobileAttendanceMenu">
                        <span>
                            <i class="fa fa-check-circle me-2"></i>
                            الحضور
                        </span>
                        <i class="fa fa-angle-down small"></i>
                    </a>

                    <div class="collapse <?= $attendanceOpen ? 'show' : ''; ?>" id="mobileAttendanceMenu">
                        <ul class="nav flex-column sidebar-submenu mt-2">
                            <li class="nav-item">
                                <a href="<?= clsPath::attendance(); ?>index.php"
                                   class="nav-link text-white <?= clsHelper::activeClass(clsPath::attendance() . 'index.php'); ?>">
                                    تسجيل الحضور
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?= clsPath::attendance(); ?>daily.php"
                                   class="nav-link text-white <?= clsHelper::activeClass(clsPath::attendance() . 'daily.php'); ?>">
                                    حضور اليوم
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?= clsPath::attendance(); ?>history.php"
                                   class="nav-link text-white <?= clsHelper::activeClass(clsPath::attendance() . 'history.php'); ?>">
                                    سجل الحضور
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>

            <?php if (clsHelper::hasRole(['admin', 'supervisor', 'teacher'])): ?>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white d-flex justify-content-between align-items-center <?= $reportsOpen ? 'active' : ''; ?>"
                       data-bs-toggle="collapse"
                       href="#mobileReportsMenu">
                        <span>
                            <i class="fa fa-chart-bar me-2"></i>
                            التقارير
                        </span>
                        <i class="fa fa-angle-down small"></i>
                    </a>

                    <div class="collapse <?= $reportsOpen ? 'show' : ''; ?>" id="mobileReportsMenu">
                        <ul class="nav flex-column sidebar-submenu mt-2">
                            <li class="nav-item">
                                <a href="<?= clsPath::reports(); ?>daily_report.php"
                                   class="nav-link text-white <?= clsHelper::activeClass(clsPath::reports() . 'daily_report.php'); ?>">
                                    التقرير اليومي
                                </a>
                            </li>

                            <?php if (clsHelper::hasRole(['admin', 'supervisor'])): ?>
                                <li class="nav-item">
                                    <a href="<?= clsPath::reports(); ?>weekly_report.php" class="nav-link text-white">
                                        التقرير الأسبوعي
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= clsPath::reports(); ?>monthly_report.php" class="nav-link text-white">
                                        التقرير الشهري
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= clsPath::reports(); ?>classroom_report.php"
                                       class="nav-link text-white">
                                        تقرير فصل
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= clsPath::reports(); ?>student_report.php" class="nav-link text-white">
                                        تقرير طالب
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= clsPath::reports(); ?>absences_report.php" class="nav-link text-white">
                                        تقرير الغياب
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= clsPath::reports(); ?>late_report.php" class="nav-link text-white">
                                        تقرير التأخير
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>

            <li class="nav-item mt-3">
                <a href="<?= clsPath::logout(); ?>" class="nav-link text-danger">
                    <i class="fa fa-sign-out-alt me-2"></i>
                    تسجيل الخروج
                </a>
            </li>

        </ul>
    </div>
</div>