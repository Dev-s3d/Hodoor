<div class="navbar-custom bg-white shadow-sm px-3 d-flex justify-content-between align-items-center">

    <div class="d-flex align-items-center gap-2">

        <button
                class="btn btn-primary d-lg-none d-flex justify-content-center align-items-center p-2"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#mobileSidebar"
                aria-controls="mobileSidebar">

            <i class="fa fa-bars"></i>

        </button>

        <h5 class="mb-0">
            <?= clsHelper::e($title ?? ''); ?>
        </h5>

    </div>

    <div class="d-flex align-items-center">

        <div class="dropdown">

            <a href="#"
               class="text-decoration-none text-dark d-flex align-items-center gap-2"
               data-bs-toggle="dropdown">

                <span class="fw-semibold">

                    <?= clsHelper::e(
                            clsHelper::auth('full_name')
                    ); ?>

                </span>

                <i class="fa-regular fa-circle-user fs-4"></i>

            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow border-0">

                <li class="px-3 py-2">

                    <div class="fw-bold">

                        <?= clsHelper::e(
                                clsHelper::auth('full_name')
                        ); ?>

                    </div>

                    <small class="text-muted">

                        <?= clsHelper::e(
                                clsHelper::auth('email')
                        ); ?>

                    </small>

                </li>

                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>

                    <a class="dropdown-item"
                       href="<?= clsPath::viewProfile(); ?>">
                        <i class="fa-regular fa-user me-2"></i>
                        الملف الشخصي
                    </a>

                </li>

                <li>

                    <a class="dropdown-item"
                       href="<?= clsPath::editProfile(); ?>">
                        <i class="fa-regular fa-pen-to-square me-2"></i>
                        تعديل البيانات
                    </a>

                </li>

                <li>

                    <a class="dropdown-item"
                       href="<?= clsPath::changePassword(); ?>">
                        <i class="fa-solid fa-key me-2"></i>
                        تغيير كلمة المرور
                    </a>

                </li>

                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>

                    <a class="dropdown-item text-danger"
                       href="<?= clsPath::logout(); ?>">
                        <i class="fa-solid fa-right-from-bracket me-2"></i>
                        تسجيل الخروج
                    </a>

                </li>

            </ul>

        </div>

    </div>

</div>