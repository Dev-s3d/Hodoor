<?php
$pageTitle = 'دليل الأمان';
include './includes/header.php';
include './includes/sidebar.php';
?>
<main class="documentation-content">
    <div class="doc-hero">
        <h1><i class="fa fa-lock me-2"></i>دليل الأمان</h1>
        <p>شرح الطبقات الأمنية المستخدمة داخل Hodoor.</p>
    </div>

<section class="doc-section"><h2>الطبقات الأمنية</h2><pre class="doc-code">Validation → Authentication → Authorization → Business Logic → Database</pre></section>
<section class="doc-section"><h2>حماية الجلسات</h2><pre class="doc-code">session_regenerate_id(true);</pre></section>
<section class="doc-section"><h2>حماية كلمات المرور</h2><pre class="doc-code">password_hash($password, PASSWORD_DEFAULT);
password_verify($password, $hashedPassword);</pre></section>
<section class="doc-section"><h2>الحماية من SQL Injection</h2><p>استخدم PDO Prepared Statements في كل الاستعلامات.</p></section>

<div class="doc-footer-nav"><div><a class="btn btn-outline-secondary" href="testing-guide.php"><i class="fa fa-arrow-right me-1"></i>دليل الاختبارات</a></div><div><a class="btn btn-primary" href="screenshots.php">لقطات الشاشة<i class="fa fa-arrow-left ms-1"></i></a></div></div>
</main>
<?php include './includes/footer.php'; ?>
