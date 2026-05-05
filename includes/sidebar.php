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
                   class="nav-link text-white <?= clsHelper::activeClass(clsPath::dashboardIndex()); ?>">
                    <i class="fa fa-home me-2"></i> الرئيسية
                </a>
            </li>
        <?php endif; ?>

        <?php if (clsHelper::isAdmin()): ?>
            <li class="nav-item mb-2">
                <a href="<?= clsPath::users(); ?>index.php"
                   class="nav-link text-white <?= clsHelper::activeClass(clsPath::users() . 'index.php'); ?>">
                    <i class="fa fa-user-cog me-2"></i> المستخدمين
                </a>
            </li>
        <?php endif; ?>

        <?php if (clsHelper::hasRole(['admin', 'supervisor'])): ?>
            <li class="nav-item mb-2">
                <a href="<?= clsPath::classrooms(); ?>index.php"
                   class="nav-link text-white <?= clsHelper::activeClass(clsPath::classrooms() . 'index.php'); ?>">
                    <i class="fa fa-school me-2"></i> الفصول
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="<?= clsPath::students(); ?>index.php"
                   class="nav-link text-white <?= clsHelper::activeClass(clsPath::students() . 'index.php'); ?>">
                    <i class="fa fa-users me-2"></i> الطلاب
                </a>
            </li>
        <?php endif; ?>

        <?php if (clsHelper::hasRole(['admin', 'supervisor', 'teacher'])): ?>
            <li class="nav-item mb-2">
                <a href="<?= clsPath::attendance(); ?>index.php"
                   class="nav-link text-white <?= clsHelper::activeClass(clsPath::attendance() . 'index.php'); ?>">
                    <i class="fa fa-check me-2"></i> الحضور
                </a>
            </li>
        <?php endif; ?>

        <?php if (clsHelper::hasRole(['admin', 'supervisor', 'teacher'])): ?>
            <li class="nav-item mb-2">
                <a href="<?= clsPath::reports(); ?>daily_report.php"
                   class="nav-link text-white <?= clsHelper::activeClass(clsPath::reports() . 'daily_report.php'); ?>">
                    <i class="fa fa-chart-bar me-2"></i> التقارير اليومية
                </a>
            </li>
        <?php endif; ?>

        <?php if (clsHelper::isAdmin()): ?>
            <li class="nav-item mb-2">
                <a href="<?= clsPath::settings(); ?>index.php"
                   class="nav-link text-white <?= clsHelper::activeClass(clsPath::settings() . 'index.php'); ?>">
                    <i class="fa fa-cog me-2"></i> الإعدادات
                </a>
            </li>
        <?php endif; ?>

        <li class="nav-item mt-3">
            <a href="<?= clsPath::logout(); ?>" class="nav-link text-danger">
                <i class="fa fa-sign-out-alt me-2"></i> تسجيل الخروج
            </a>
        </li>

    </ul>

</div>

<!-- Sidebar Mobile Offcanvas -->
<div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="mobileSidebar">
    <div class="offcanvas-header border-bottom border-secondary">
        <h5 class="offcanvas-title">Hodoor</h5>
        <button type="button" class="btn-close btn-close-white ms-0 me-auto" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <ul class="nav flex-column">

            <?php if (clsHelper::hasRole(['admin', 'supervisor'])): ?>
                <li class="nav-item mb-2">
                    <a href="<?= clsPath::dashboardIndex(); ?>"
                       class="nav-link text-white <?= clsHelper::activeClass(clsPath::dashboardIndex()); ?>">
                        <i class="fa fa-home me-2"></i> الرئيسية
                    </a>
                </li>
            <?php endif; ?>

            <?php if (clsHelper::isAdmin()): ?>
                <li class="nav-item mb-2">
                    <a href="<?= clsPath::users(); ?>index.php"
                       class="nav-link text-white <?= clsHelper::activeClass(clsPath::users() . 'index.php'); ?>">
                        <i class="fa fa-user-cog me-2"></i> المستخدمين
                    </a>
                </li>
            <?php endif; ?>

            <?php if (clsHelper::hasRole(['admin', 'supervisor'])): ?>
                <li class="nav-item mb-2">
                    <a href="<?= clsPath::classrooms(); ?>index.php"
                       class="nav-link text-white <?= clsHelper::activeClass(clsPath::classrooms() . 'index.php'); ?>">
                        <i class="fa fa-school me-2"></i> الفصول
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="<?= clsPath::students(); ?>index.php"
                       class="nav-link text-white <?= clsHelper::activeClass(clsPath::students() . 'index.php'); ?>">
                        <i class="fa fa-users me-2"></i> الطلاب
                    </a>
                </li>
            <?php endif; ?>

            <?php if (clsHelper::hasRole(['admin', 'supervisor', 'teacher'])): ?>
                <li class="nav-item mb-2">
                    <a href="<?= clsPath::attendance(); ?>index.php"
                       class="nav-link text-white <?= clsHelper::activeClass(clsPath::attendance() . 'index.php'); ?>">
                        <i class="fa fa-check me-2"></i> الحضور
                    </a>
                </li>
            <?php endif; ?>

            <?php if (clsHelper::hasRole(['admin', 'supervisor', 'teacher'])): ?>
                <li class="nav-item mb-2">
                    <a href="<?= clsPath::reports(); ?>daily_report.php"
                       class="nav-link text-white <?= clsHelper::activeClass(clsPath::reports() . 'daily_report.php'); ?>">
                        <i class="fa fa-chart-bar me-2"></i> التقارير اليومية
                    </a>
                </li>
            <?php endif; ?>

            <?php if (clsHelper::isAdmin()): ?>
                <li class="nav-item mb-2">
                    <a href="<?= clsPath::settings(); ?>index.php"
                       class="nav-link text-white <?= clsHelper::activeClass(clsPath::settings() . 'index.php'); ?>">
                        <i class="fa fa-cog me-2"></i> الإعدادات
                    </a>
                </li>
            <?php endif; ?>

            <li class="nav-item mt-3">
                <a href="<?= clsPath::logout(); ?>" class="nav-link text-danger">
                    <i class="fa fa-sign-out-alt me-2"></i> تسجيل الخروج
                </a>
            </li>

        </ul>
    </div>
</div>