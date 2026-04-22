<?php
require_once '../../includes/app.php';
$title = 'حذف المستخدم';

$id = clsHelper::get('id');

$user = new clsUser($conn);

if (!$id || !$user->loadById($id)) {
    clsHelper::setMessage('error', 'المستخدم غير موجود');
    clsHelper::redirect(clsPath::users() . 'index.php');
}
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">

        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">حذف المستخدم</h1>
                    <p class="text-muted mb-0">تأكيد حذف المستخدم من النظام</p>
                </div>

                <a href="<?= clsPath::users(); ?>index.php" class="btn btn-outline-secondary">
                    <i class="fa fa-arrow-right me-1"></i>
                    الرجوع
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <div class="alert alert-warning">
                        هل أنت متأكد من حذف المستخدم:
                        <strong><?= clsHelper::e($user->full_name); ?></strong> ؟
                    </div>

                    <form action="<?= clsPath::users(); ?>delete.php?id=<?= $user->id; ?>" method="POST">
                        <input type="hidden" name="id" value="<?= clsHelper::e($user->id); ?>">

                        <div class="d-flex gap-2">
                            <button type="submit" name="confirm_delete" class="btn btn-danger">
                                <i class="fa fa-trash me-1"></i>
                                نعم، احذف
                            </button>

                            <a href="<?= clsPath::users(); ?>index.php" class="btn btn-light border">
                                إلغاء
                            </a>
                        </div>
                    </form>

                    <?php
                    // إذا تم إرسال النموذج نحذف المستخدم
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
                        $postId = clsHelper::post('id');

                        if ($postId != $user->id) {
                            clsHelper::setMessage('error', 'بيانات غير صحيحة');
                            clsHelper::redirect(clsPath::users() . 'index.php');
                        }

                        if ($user->delete()) {
                            clsHelper::setMessage('success', 'تم حذف المستخدم بنجاح');
                        } else {
                            clsHelper::setMessage('error', 'حدث خطأ أثناء حذف المستخدم');
                        }

                        clsHelper::redirect(clsPath::users() . 'index.php');
                    }
                    ?>

                </div>
            </div>

        </div>

    </div>

<?php require_once '../../includes/footer.php'; ?>