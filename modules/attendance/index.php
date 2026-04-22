<?php
require_once '../../includes/app.php';
$title = 'الحضور';

$classroomObj = new clsClassroom($conn);
$classrooms = $classroomObj->getAll();

$today = date('Y-m-d');
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">
        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4">
            <?php require_once '../../includes/alerts.php'; ?>

            <div class="mb-4">
                <h1 class="mb-1">الحضور</h1>
                <p class="text-muted mb-0">اختر الفصل والتاريخ لبدء تسجيل الحضور</p>
            </div>

            <div class="row g-4">

                <div class="col-lg-7">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="mb-3">تسجيل الحضور</h5>

                            <form action="<?= clsPath::attendance(); ?>take.php" method="GET">
                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label class="form-label">الفصل</label>
                                        <select name="classroom_id" class="form-select">
                                            <option value="">اختر الفصل</option>
                                            <?php foreach ($classrooms as $classroom): ?>
                                                <option value="<?= $classroom['id']; ?>">
                                                    <?= clsHelper::e($classroom['class_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">التاريخ</label>
                                        <input type="date" name="attendance_date" class="form-control"
                                               value="<?= $today; ?>">
                                    </div>

                                </div>

                                <div class="mt-4 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-check me-1"></i>
                                        متابعة
                                    </button>

                                    <a href="<?= clsPath::attendance(); ?>daily.php" class="btn btn-outline-secondary">
                                        تقرير اليوم
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="mb-3">اختصارات</h5>

                            <div class="d-grid gap-2">
                                <a href="<?= clsPath::attendance(); ?>daily.php"
                                   class="btn btn-light border text-start">
                                    <i class="fa fa-calendar-day me-2"></i>
                                    تقرير الحضور اليومي
                                </a>

                                <a href="<?= clsPath::attendance(); ?>history.php"
                                   class="btn btn-light border text-start">
                                    <i class="fa fa-clock-rotate-left me-2"></i>
                                    سجل الحضور
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

<?php require_once '../../includes/footer.php'; ?>