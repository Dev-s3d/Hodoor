<?php
$pageTitle = 'دليل التثبيت';
include './includes/header.php';
include './includes/sidebar.php';
?>
<main class="documentation-content">
    <div class="doc-hero">
        <h1><i class="fa fa-download me-2"></i>دليل التثبيت</h1>
        <p>طريقة تثبيت وتشغيل المشروع على بيئة محلية.</p>
    </div>

<section class="doc-section"><h2>متطلبات التشغيل</h2><ul><li>PHP 8.0 أو أحدث.</li><li>MySQL أو MariaDB.</li><li>Apache.</li><li>XAMPP أو MAMP أو Laragon.</li></ul></section>
<section class="doc-section"><h2>تحميل المشروع</h2><pre class="doc-code">git clone https://github.com/Dev-s3d/Hodoor.git</pre></section>
<section class="doc-section"><h2>إنشاء قاعدة البيانات</h2><pre class="doc-code">CREATE DATABASE hodoor CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;</pre></section>
<section class="doc-section"><h2>تشغيل المشروع</h2><pre class="doc-code">http://localhost/Hodoor</pre></section>

<div class="doc-footer-nav"><div><a class="btn btn-outline-secondary" href="database-architecture.php"><i class="fa fa-arrow-right me-1"></i>قاعدة البيانات</a></div><div><a class="btn btn-primary" href="coding-standards.php">معايير البرمجة<i class="fa fa-arrow-left ms-1"></i></a></div></div>
</main>
<?php include './includes/footer.php'; ?>
