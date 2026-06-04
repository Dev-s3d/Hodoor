<?php
require_once '../../includes/app.php';

clsHelper::requireRole(['admin', 'supervisor']);

$title = 'حذف الطالب';

$id = clsHelper::get('id');

$student = new clsStudent($conn);

if (!$id || !$student->loadById($id)) {
    clsHelper::setMessage('error', 'الطالب غير موجود');
    clsHelper::redirect(clsPath::students() . 'index.php');
}

$classroom = new clsClassroom($conn);
$className = '-';

if (!empty($student->classroom_id) && $classroom->loadById($student->classroom_id)) {
    $className = $classroom->class_name;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    $postId = clsHelper::post('id');

    if ($postId != $student->id) {
        clsHelper::setMessage('error', 'بيانات غير صحيحة');
        clsHelper::redirect(clsPath::students() . 'index.php');
    }

    $studentName = $student->student_name;
    $studentNumber = $student->student_number;

    if ($student->delete()) {
        clsHelper::setMessage('success', 'تم حذف الطالب بنجاح');

        clsLog::add(
                $conn,
                'حذف طالب',
                'تم حذف الطالب: ' . $studentName . ' - رقم الطالب: ' . $studentNumber
        );
    } else {
        clsHelper::setMessage('error', 'حدث خطأ أثناء حذف الطالب');
    }

    clsHelper::redirect(clsPath::students() . 'index.php');
}
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">

        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4 students">

            <?php require_once '../../includes/alerts.php'; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">حذف الطالب</h1>
                    <p class="text-muted mb-0">تأكيد حذف الطالب من النظام</p>
                </div>

                <div class="d-flex gap-2">
                    <a href="<?= clsPath::students(); ?>view.php?id=<?= $student->id; ?>"
                       class="btn btn-outline-primary">
                        <i class="fa fa-eye me-1"></i>
                        عرض
                    </a>

                    <a href="<?= clsPath::students(); ?>index.php"
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
                                هذه العملية قد تحذف بيانات الطالب من النظام.
                            </p>
                        </div>

                    </div>

                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <div class="alert alert-warning mb-4">
                        هل أنت متأكد من حذف الطالب:
                        <strong><?= clsHelper::e($student->student_name); ?></strong> ؟
                    </div>

                    <div class="row g-3 mb-4">

                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">اسم الطالب</small>
                            <div class="fw-semibold">
                                <?= clsHelper::e($student->student_name); ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">رقم الطالب</small>
                            <div class="fw-semibold">
                                <?= clsHelper::e($student->student_number ?: '-'); ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">الفصل</small>
                            <div class="fw-semibold">
                                <?= clsHelper::e($className); ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">الحالة</small>
                            <div>
                                <?php if ((int)$student->status === 1): ?>
                                    <span class="badge bg-success px-3">مفعل</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary px-3">غير مفعل</span>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>

                    <form action="<?= clsPath::students(); ?>delete.php?id=<?= $student->id; ?>" method="POST">
                        <input type="hidden" name="id" value="<?= clsHelper::e($student->id); ?>">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= clsPath::students(); ?>view.php?id=<?= $student->id; ?>"
                               class="btn btn-light border">
                                إلغاء
                            </a>

                            <button type="submit"
                                    name="confirm_delete"
                                    class="btn btn-danger">
                                <i class="fa fa-trash me-1"></i>
                                نعم، احذف الطالب
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

<?php require_once '../../includes/footer.php'; ?>