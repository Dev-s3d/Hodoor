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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    $postId = clsHelper::post('id');

    if ($postId != $student->id) {
        clsHelper::setMessage('error', 'بيانات غير صحيحة');
        clsHelper::redirect(clsPath::students() . 'index.php');
    }

    if ($student->delete()) {
        clsHelper::setMessage('success', 'تم حذف الطالب بنجاح');
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

        <div class="content p-4">
            <?php require_once '../../includes/alerts.php'; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">حذف الطالب</h1>
                    <p class="text-muted mb-0">تأكيد حذف الطالب من النظام</p>
                </div>

                <a href="<?= clsPath::students(); ?>index.php" class="btn btn-outline-secondary">
                    <i class="fa fa-arrow-right me-1"></i>
                    الرجوع
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <div class="alert alert-warning">
                        هل أنت متأكد من حذف الطالب:
                        <strong><?= clsHelper::e($student->student_name); ?></strong> ؟
                    </div>

                    <form action="<?= clsPath::students(); ?>delete.php?id=<?= $student->id; ?>" method="POST">
                        <input type="hidden" name="id" value="<?= clsHelper::e($student->id); ?>">

                        <div class="d-flex gap-2">
                            <button type="submit" name="confirm_delete" class="btn btn-danger">
                                <i class="fa fa-trash me-1"></i>
                                نعم، احذف
                            </button>

                            <a href="<?= clsPath::students(); ?>index.php" class="btn btn-light border">
                                إلغاء
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

<?php require_once '../../includes/footer.php'; ?>