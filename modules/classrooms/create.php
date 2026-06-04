<?php
require_once '../../includes/app.php';

clsHelper::requireRole(['admin', 'supervisor']);

$title = 'إضافة فصل جديد';
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">

        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4 classrooms">

            <?php require_once '../../includes/alerts.php'; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">إضافة فصل جديد</h1>
                    <p class="text-muted mb-0">أدخل بيانات الفصل لإضافته إلى النظام</p>
                </div>

                <a href="<?= clsPath::classrooms(); ?>index.php"
                   class="btn btn-outline-secondary">
                    <i class="fa fa-arrow-right me-1"></i>
                    الرجوع
                </a>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">

                    <div class="d-flex align-items-center flex-wrap gap-3">

                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                             style="width:75px;height:75px;">
                            <i class="fa fa-school text-primary fs-2"></i>
                        </div>

                        <div>
                            <h4 class="mb-1">فصل جديد</h4>
                            <p class="text-muted mb-0">
                                قم بتعبئة بيانات الفصل الدراسي
                            </p>
                        </div>

                    </div>

                </div>
            </div>

            <form action="<?= clsPath::classrooms(); ?>store.php" method="POST">

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">

                        <h5 class="mb-4">
                            <i class="fa fa-id-card text-primary me-1"></i>
                            بيانات الفصل
                        </h5>

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-chalkboard text-primary me-1"></i>
                                    اسم الفصل
                                </label>
                                <input type="text"
                                       name="class_name"
                                       class="form-control"
                                       value="<?= clsHelper::old('class_name'); ?>"
                                       placeholder="مثال: الصف الأول أ">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-solid fa-fingerprint text-primary me-1"></i>
                                    رمز الفصل
                                </label>
                                <input type="text"
                                       name="class_code"
                                       class="form-control"
                                       value="<?= clsHelper::old('class_code'); ?>"
                                       placeholder="مثال: A-101">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fa-brands fa-gitter text-primary me-1"></i>
                                    المرحلة / المستوى
                                </label>
                                <input type="text"
                                       name="level_name"
                                       class="form-control"
                                       value="<?= clsHelper::old('level_name'); ?>"
                                       placeholder="مثال: ابتدائي">
                            </div>

                        </div>

                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">

                    <a href="<?= clsPath::classrooms(); ?>index.php"
                       class="btn btn-light border">
                        إلغاء
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save me-1"></i>
                        حفظ الفصل
                    </button>

                </div>

            </form>

        </div>

    </div>

<?php require_once '../../includes/footer.php'; ?>