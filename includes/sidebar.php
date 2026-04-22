<!-- Sidebar Desktop -->
<div class="sidebar bg-dark text-white p-3 d-none d-lg-block">

    <h4 class="mb-4 text-center">Hodoor</h4>

    <ul class="nav flex-column">

        <li class="nav-item mb-2">
            <a href="<?= clsPath::dashboardIndex(); ?>" class="nav-link text-white">
                <i class="fa fa-home me-2"></i> الرئيسية
            </a>
        </li>

        <?php if ($_SESSION['role'] === 'admin'): ?>
            <li class="nav-item mb-2">
                <a href="<?= clsPath::users(); ?>index.php" class="nav-link text-white">
                    <i class="fa fa-user-cog me-2"></i> المستخدمين
                </a>
            </li>
        <?php endif; ?>

        <li class="nav-item mb-2">
            <a href="<?= clsPath::students(); ?>index.php" class="nav-link text-white">
                <i class="fa fa-users me-2"></i> الطلاب
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="<?= clsPath::classrooms(); ?>index.php" class="nav-link text-white">
                <i class="fa fa-school me-2"></i> الفصول
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="<?= clsPath::attendance(); ?>index.php" class="nav-link text-white">
                <i class="fa fa-check me-2"></i> الحضور
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="<?= clsPath::reports(); ?>daily_report.php" class="nav-link text-white">
                <i class="fa fa-chart-bar me-2"></i> التقارير
            </a>
        </li>

        <li class="nav-item mt-3">
            <a href="<?= clsPath::logout(); ?>" class="nav-link text-danger">
                <i class="fa fa-sign-out-alt me-2"></i> تسجيل الخروج
            </a>
        </li>

    </ul>

</div>

<!-- Sidebar Mobile Offcanvas -->
<div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="mobileSidebar"
     aria-labelledby="mobileSidebarLabel">
    <div class="offcanvas-header border-bottom border-secondary">
        <h5 class="offcanvas-title" id="mobileSidebarLabel">Hodoor</h5>
        <button type="button" class="btn-close btn-close-white ms-0 me-auto" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
        <ul class="nav flex-column">

            <li class="nav-item mb-2">
                <a href="<?= clsPath::dashboardIndex(); ?>" class="nav-link text-white">
                    <i class="fa fa-home me-2"></i> الرئيسية
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="<?= clsPath::users(); ?>index.php" class="nav-link text-white">
                    <i class="fa fa-user-cog me-2"></i> المستخدمين
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="<?= clsPath::students(); ?>index.php" class="nav-link text-white">
                    <i class="fa fa-users me-2"></i> الطلاب
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="<?= clsPath::classrooms(); ?>index.php" class="nav-link text-white">
                    <i class="fa fa-school me-2"></i> الفصول
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="<?= clsPath::attendance(); ?>index.php" class="nav-link text-white">
                    <i class="fa fa-check me-2"></i> الحضور
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="<?= clsPath::reports(); ?>daily_report.php" class="nav-link text-white">
                    <i class="fa fa-chart-bar me-2"></i> التقارير
                </a>
            </li>

            <li class="nav-item mt-3">
                <a href="<?= clsPath::logout(); ?>" class="nav-link text-danger">
                    <i class="fa fa-sign-out-alt me-2"></i> تسجيل الخروج
                </a>
            </li>

        </ul>
    </div>
</div>