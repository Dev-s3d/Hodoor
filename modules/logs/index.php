<?php
require_once '../../includes/app.php';

clsHelper::requireRole(['admin']);

$title = "سجل النظام";

$search = trim($_GET['search'] ?? '');
$action = trim($_GET['action'] ?? '');
$date = trim($_GET['date'] ?? '');

$logs = clsLog::search($conn, $search, $action, $date, 300);

$totalLogs = clsLog::countAll($conn);
$todayLogs = clsLog::countToday($conn);
$totalActions = clsLog::countActions($conn);
$totalUsers = clsLog::countUniqueUsers($conn);
$actions = clsLog::getActions($conn);
?>

<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/sidebar.php'; ?>

    <div class="main-content w-100">

        <?php require_once '../../includes/navbar.php'; ?>

        <div class="content p-4 logs">

            <?php require_once '../../includes/alerts.php'; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">سجل النظام</h1>
                    <p class="text-muted mb-0">متابعة العمليات التي تمت داخل النظام</p>
                </div>

                <span class="badge bg-primary px-3 py-2">
                نتائج العرض: <?= clsHelper::e(count($logs)); ?>
            </span>
            </div>

            <div class="row g-3 mb-4">

                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-muted">إجمالي السجلات</h6>
                            <div class="d-flex justify-content-between">
                                <h3 class="mb-0"><?= clsHelper::e($totalLogs); ?></h3>
                                <i class="fa fa-history text-primary font-size-30"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-muted">سجلات اليوم</h6>
                            <div class="d-flex justify-content-between">
                                <h3 class="mb-0"><?= clsHelper::e($todayLogs); ?></h3>
                                <i class="fa fa-calendar-day text-success font-size-30"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-muted">أنواع العمليات</h6>
                            <div class="d-flex justify-content-between">
                                <h3 class="mb-0"><?= clsHelper::e($totalActions); ?></h3>
                                <i class="fa fa-layer-group text-warning font-size-30"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-muted">المستخدمون</h6>
                            <div class="d-flex justify-content-between">
                                <h3 class="mb-0"><?= clsHelper::e($totalUsers); ?></h3>
                                <i class="fa fa-users text-danger font-size-30"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">

                    <form method="GET" class="row g-3 align-items-end">

                        <div class="col-md-4">
                            <label class="form-label">بحث</label>
                            <input type="text"
                                   name="search"
                                   class="form-control"
                                   placeholder="المستخدم، العملية، الوصف، IP"
                                   value="<?= clsHelper::e($search); ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">نوع العملية</label>
                            <select name="action" class="form-select">
                                <option value="">كل العمليات</option>

                                <?php foreach ($actions as $item): ?>
                                    <option value="<?= clsHelper::e($item); ?>"
                                            <?= $action === $item ? 'selected' : ''; ?>>
                                        <?= clsHelper::e($item); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">التاريخ</label>
                            <input type="date"
                                   name="date"
                                   class="form-control"
                                   value="<?= clsHelper::e($date); ?>">
                        </div>

                        <div class="col-md-2 d-flex gap-2">
                            <button type="submit"
                                    class="btn btn-primary w-100"
                                    title="بحث">
                                <i class="fa fa-search"></i>
                            </button>

                            <a href="<?= clsPath::root(); ?>modules/logs/index.php"
                               class="btn btn-outline-secondary"
                               title="إعادة تعيين">
                                <i class="fa fa-rotate-right"></i>
                            </a>
                        </div>

                    </form>

                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">
                            <i class="fa fa-list text-primary me-1"></i>
                            قائمة السجلات
                        </h5>

                        <small class="text-muted">
                            عرض آخر 300 سجل كحد أقصى
                        </small>
                    </div>

                    <div class="table-responsive text-center">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>المستخدم</th>
                                <th>العملية</th>
                                <th>الوصف</th>
                                <th>IP</th>
                                <th>التاريخ</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php if (!empty($logs)): ?>
                                <?php foreach ($logs as $index => $log): ?>
                                    <tr>
                                        <td><?= clsHelper::e($index + 1); ?></td>

                                        <td>
                                            <i class="fa fa-user text-secondary me-1"></i>
                                            <?= clsHelper::e($log['user_name']); ?>
                                        </td>

                                        <td>
                                            <?= clsHelper::logBadge($log['action']); ?>
                                        </td>

                                        <td class="text-start">
                                            <?= clsHelper::e($log['description'] ?: '-'); ?>
                                        </td>

                                        <td>
                                            <small class="text-muted">
                                                <?= clsHelper::e($log['ip_address'] ?: '-'); ?>
                                            </small>
                                        </td>

                                        <td>
                                            <small>
                                                <?= clsHelper::e($log['created_at']); ?>
                                            </small>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        لا توجد سجلات مطابقة
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>

    </div>

<?php require_once '../../includes/footer.php'; ?>