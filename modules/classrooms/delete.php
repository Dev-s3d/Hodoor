<?php
require_once '../../includes/app.php';

clsHelper::requireRole(['admin', 'supervisor']);

$title = 'حذف الفصل';

$id = clsHelper::get('id');

$classroom = new clsClassroom($conn);

if (!$id || !$classroom->loadById($id)) {
    clsHelper::setMessage('error', 'الفصل غير موجود');
    clsHelper::redirect(clsPath::classrooms() . 'index.php');
}

$totalStudents = $classroom->studentsCount();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    $postId = clsHelper::post('id');

    if ($postId != $classroom->id) {
        clsHelper::setMessage('error', 'بيانات غير صحيحة');
        clsHelper::redirect(clsPath::classrooms() . 'index.php');
    }

    if ($classroom->hasStudents()) {
        clsHelper::setMessage('error', 'لا يمكن حذف الفصل لأنه يحتوي على طلاب. انقل الطلاب أو احذفهم أولاً.');
        clsHelper::redirect(clsPath::classrooms() . 'view.php?id=' . urlencode($classroom->id));
    }

    $className = $classroom->class_name;
    $classCode = $classroom->class_code;

    if ($classroom->delete()) {
        clsHelper::setMessage('success', 'تم حذف الفصل بنجاح');

        clsLog::add(
                $conn,
                'حذف فصل',
                'تم حذف الفصل: ' . $className . ' - الرمز: ' . $classCode
        );
    } else {
        clsHelper::setMessage('error', 'حدث خطأ أثناء حذف الفصل');
    }

    clsHelper::redirect(clsPath::classrooms() . 'index.php');
}
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">

        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4 classrooms">

            <?php require_once '../../includes/alerts.php'; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">حذف الفصل</h1>
                    <p class="text-muted mb-0">تأكيد حذف الفصل من النظام</p>
                </div>

                <div class="d-flex gap-2">
                    <a href="<?= clsPath::classrooms(); ?>view.php?id=<?= $classroom->id; ?>"
                       class="btn btn-outline-primary">
                        <i class="fa fa-eye me-1"></i>
                        عرض
                    </a>

                    <a href="<?= clsPath::classrooms(); ?>index.php"
                       class="btn btn-outline-secondary">
                        <i class="fa fa-arrow-right me-1"></i>
                        الرجوع
                    </a>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">

                    <div class="d-flex align-items-center flex-wrap gap-3">

                        <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center"
                             style="width:75px;height:75px;">
                            <i class="fa fa-triangle-exclamation text-danger fs-2"></i>
                        </div>

                        <div>
                            <h4 class="mb-1 text-danger">تنبيه قبل الحذف</h4>
                            <p class="text-muted mb-0">
                                لا يمكن التراجع عن هذه العملية بعد تنفيذها.
                            </p>
                        </div>

                    </div>

                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <?php if ($totalStudents > 0): ?>

                        <div class="alert alert-danger mb-4">
                            لا يمكن حذف هذا الفصل حالياً لأنه يحتوي على
                            <strong><?= clsHelper::e($totalStudents); ?></strong>
                            طالب. يجب نقل الطلاب أو حذفهم أولاً.
                        </div>

                    <?php else: ?>

                        <div class="alert alert-warning mb-4">
                            هل أنت متأكد من حذف الفصل:
                            <strong><?= clsHelper::e($classroom->class_name); ?></strong> ؟
                        </div>

                    <?php endif; ?>

                    <div class="row g-3 mb-4">

                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">اسم الفصل</small>
                            <div class="fw-semibold">
                                <?= clsHelper::e($classroom->class_name); ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">رمز الفصل</small>
                            <div class="fw-semibold">
                                <?= clsHelper::e($classroom->class_code ?: '-'); ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">المرحلة / المستوى</small>
                            <div class="fw-semibold">
                                <?= clsHelper::e($classroom->level_name ?: '-'); ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">عدد الطلاب</small>
                            <div>
                            <span class="badge bg-primary px-3">
                                <?= clsHelper::e($totalStudents); ?> طالب
                            </span>
                            </div>
                        </div>

                    </div>

                    <?php if ($totalStudents > 0): ?>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= clsPath::classrooms(); ?>view.php?id=<?= $classroom->id; ?>"
                               class="btn btn-primary">
                                <i class="fa fa-users me-1"></i>
                                عرض طلاب الفصل
                            </a>

                            <a href="<?= clsPath::classrooms(); ?>index.php"
                               class="btn btn-light border">
                                الرجوع للفصول
                            </a>
                        </div>

                    <?php else: ?>

                        <form action="<?= clsPath::classrooms(); ?>delete.php?id=<?= $classroom->id; ?>" method="POST">
                            <input type="hidden" name="id" value="<?= clsHelper::e($classroom->id); ?>">

                            <div class="d-flex justify-content-end gap-2">

                                <a href="<?= clsPath::classrooms(); ?>view.php?id=<?= $classroom->id; ?>"
                                   class="btn btn-light border">
                                    إلغاء
                                </a>

                                <button type="submit"
                                        name="confirm_delete"
                                        class="btn btn-danger">
                                    <i class="fa fa-trash me-1"></i>
                                    نعم، احذف الفصل
                                </button>

                            </div>
                        </form>

                    <?php endif; ?>

                </div>
            </div>

        </div>

    </div>

<?php require_once '../../includes/footer.php'; ?>