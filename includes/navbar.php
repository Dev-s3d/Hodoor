<div class="navbar-custom bg-white shadow-sm px-3 d-flex justify-content-between align-items-center">

    <div class="d-flex align-items-center gap-2">
        <button class="btn btn-outline-secondary d-lg-none" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
            <i class="fa fa-bars"></i>
        </button>

        <h5 class="mb-0"><?= $title ?? '' ?></h5>
    </div>

    <div class="d-flex align-items-center">
        <div class="dropdown">
            <a href="#" class="text-decoration-none text-dark d-flex align-items-center gap-2 user-name"
               data-bs-toggle="dropdown" aria-expanded="false">
                <span><?= clsHelper::e($_SESSION['full_name']); ?></span>
                <i class="fa-regular fa-circle-user fs-5"></i>
            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                <li>
                    <a class="dropdown-item" href="<?= clsPath::profile(); ?>">
                        <i class="fa-regular fa-user me-2"></i>
                        الملف الشخصي
                    </a>
                </li>

                <li>
                    <a class="dropdown-item" href="<?= clsPath::profile(); ?>">
                        <i class="fa-regular fa-pen-to-square me-2"></i>
                        تعديل البيانات
                    </a>
                </li>

                <li>
                    <a class="dropdown-item" href="<?= clsPath::changePassword(); ?>">
                        <i class="fa-solid fa-key me-2"></i>
                        تغيير كلمة المرور
                    </a>
                </li>

                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>
                    <a class="dropdown-item text-danger" href="<?= clsPath::logout(); ?>">
                        <i class="fa-solid fa-right-from-bracket me-2"></i>
                        تسجيل الخروج
                    </a>
                </li>
            </ul>
        </div>
    </div>

</div>