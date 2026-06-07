<?php
$pageTitle = 'المصادقة والصلاحيات';
include './includes/header.php';
include './includes/sidebar.php';
?>
<main class="documentation-content">
    <div class="doc-hero">
        <h1><i class="fa fa-user-shield me-2"></i>المصادقة والصلاحيات</h1>
        <p>شرح تسجيل الدخول والجلسات والأدوار داخل النظام.</p>
    </div>

<section class="doc-section"><h2>المصادقة</h2><p>هي التحقق من هوية المستخدم من خلال اسم المستخدم وكلمة المرور.</p></section>
<section class="doc-section"><h2>بيانات الجلسة</h2><pre class="doc-code">$_SESSION['user_id']
$_SESSION['full_name']
$_SESSION['username']
$_SESSION['email']
$_SESSION['role']</pre></section>
<section class="doc-section"><h2>الصلاحيات</h2><table class="doc-table"><tr><th>الدور</th><th>الصلاحيات</th></tr><tr><td>Admin</td><td>كامل الصلاحيات.</td></tr><tr><td>Supervisor</td><td>الطلاب والفصول والحضور والتقارير.</td></tr><tr><td>Teacher</td><td>الحضور وبعض التقارير.</td></tr></table></section>
<section class="doc-section"><h2>حماية الصفحات</h2><pre class="doc-code">clsHelper::requireRole(['admin']);</pre></section>

<div class="doc-footer-nav"><div><a class="btn btn-outline-secondary" href="classes-reference.php"><i class="fa fa-arrow-right me-1"></i>مرجع الكلاسات</a></div><div><a class="btn btn-primary" href="database-architecture.php">قاعدة البيانات<i class="fa fa-arrow-left ms-1"></i></a></div></div>
</main>
<?php include './includes/footer.php'; ?>
