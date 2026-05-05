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
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">

        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4">

            <?php require_once '../../includes/alerts.php'; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">حذف الفصل</h1>
                    <p class="text-muted mb-0">تأكيد حذف الفصل من النظام</p>
                </div>

                <a href="<?= clsPath::classrooms(); ?>index.php" class="btn btn-outline-secondary">
                    <i class="fa fa-arrow-right me-1"></i>
                    الرجوع
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <div class="alert alert-warning">
                        هل أنت متأكد من حذف الفصل:
                        <strong><?= clsHelper::e($classroom->class_name); ?></strong> ؟
                    </div>

                    <form action="<?= clsPath::classrooms(); ?>delete.php?id=<?= $classroom->id; ?>" method="POST">
                        <input type="hidden" name="id" value="<?= clsHelper::e($classroom->id); ?>">

                        <div class="d-flex gap-2">
                            <button type="submit" name="confirm_delete" class="btn btn-danger">
                                <i class="fa fa-trash me-1"></i>
                                نعم، احذف
                            </button>

                            <a href="<?= clsPath::classrooms(); ?>index.php" class="btn btn-light border">
                                إلغاء
                            </a>
                        </div>
                    </form>

                    <?php
                    /*
                    |--------------------------------------------------------------------------
                    | عند إرسال النموذج نحذف الفصل
                    |--------------------------------------------------------------------------
                    */
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
                        $postId = clsHelper::post('id');

                        if ($postId != $classroom->id) {
                            clsHelper::setMessage('error', 'بيانات غير صحيحة');
                            clsHelper::redirect(clsPath::classrooms() . 'index.php');
                        }

                        if ($classroom->delete()) {
                            clsHelper::setMessage('success', 'تم حذف الفصل بنجاح');
                        } else {
                            clsHelper::setMessage('error', 'حدث خطأ أثناء حذف الفصل');
                        }

                        clsHelper::redirect(clsPath::classrooms() . 'index.php');
                    }
                    ?>

                </div>
            </div>

        </div>

    </div>

<?php require_once '../../includes/footer.php'; ?>