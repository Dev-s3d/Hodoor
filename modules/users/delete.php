<?php
require_once '../../includes/app.php';

clsHelper::requireRole(['admin']);

$title = 'حذف المستخدم';

$id = clsHelper::get('id');

$user = new clsUser($conn);

if (!$id || !$user->loadById($id)) {
    clsHelper::setMessage('error', 'المستخدم غير موجود');
    clsHelper::redirect(clsPath::users() . 'index.php');
}

if ((int)$user->id === (int)clsHelper::auth('user_id')) {
    clsHelper::setMessage('error', 'لا يمكنك حذف حسابك الحالي');
    clsHelper::redirect(clsPath::users() . 'index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    $postId = clsHelper::post('id');

    if ($postId != $user->id) {
        clsHelper::setMessage('error', 'بيانات غير صحيحة');
        clsHelper::redirect(clsPath::users() . 'index.php');
    }

    $deletedUserName = $user->full_name;
    $deletedUsername = $user->username;

    if ($user->delete()) {
        clsHelper::setMessage('success', 'تم حذف المستخدم بنجاح');

        clsLog::add(
                $conn,
                'حذف مستخدم',
                'تم حذف المستخدم: ' . $deletedUserName . ' (' . $deletedUsername . ')'
        );
    } else {
        clsHelper::setMessage('error', 'حدث خطأ أثناء حذف المستخدم');
    }

    clsHelper::redirect(clsPath::users() . 'index.php');
}
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">

        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4 users">

            <?php require_once '../../includes/alerts.php'; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">حذف المستخدم</h1>
                    <p class="text-muted mb-0">تأكيد حذف المستخدم من النظام</p>
                </div>

                <div class="d-flex gap-2">
                    <a href="<?= clsPath::users(); ?>view.php?id=<?= $user->id; ?>"
                       class="btn btn-outline-primary">
                        <i class="fa fa-eye me-1"></i>
                        عرض
                    </a>

                    <a href="<?= clsPath::users(); ?>index.php"
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
                                لا يمكن التراجع عن حذف المستخدم بعد تنفيذ العملية.
                            </p>
                        </div>

                    </div>

                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <div class="alert alert-warning mb-4">
                        هل أنت متأكد من حذف المستخدم:
                        <strong><?= clsHelper::e($user->full_name); ?></strong> ؟
                    </div>

                    <div class="row g-3 mb-4">

                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">الاسم الكامل</small>
                            <div class="fw-semibold">
                                <?= clsHelper::e($user->full_name); ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">اسم المستخدم</small>
                            <div class="fw-semibold">
                                <?= clsHelper::e($user->username); ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">البريد الإلكتروني</small>
                            <div class="fw-semibold">
                                <?= clsHelper::e($user->email ?: '-'); ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">الدور</small>
                            <div class="fw-semibold">
                                <?= clsHelper::e($user->role); ?>
                            </div>
                        </div>

                    </div>

                    <form action="<?= clsPath::users(); ?>delete.php?id=<?= $user->id; ?>" method="POST">
                        <input type="hidden" name="id" value="<?= clsHelper::e($user->id); ?>">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= clsPath::users(); ?>view.php?id=<?= $user->id; ?>"
                               class="btn btn-light border">
                                إلغاء
                            </a>

                            <button type="submit"
                                    name="confirm_delete"
                                    class="btn btn-danger">
                                <i class="fa fa-trash me-1"></i>
                                نعم، احذف المستخدم
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

    </div>

<?php require_once '../../includes/footer.php'; ?>