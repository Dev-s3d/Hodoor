<?php
$pageTitle = 'معايير البرمجة';
include './includes/header.php';
include './includes/sidebar.php';
?>
<main class="documentation-content">
    <div class="doc-hero">
        <h1><i class="fa fa-list-check me-2"></i>معايير البرمجة</h1>
        <p>قواعد كتابة وتنظيم الكود داخل مشروع Hodoor.</p>
    </div>

<section class="doc-section"><h2>المبادئ العامة</h2><ul><li>فصل المسؤوليات.</li><li>إعادة استخدام الكود.</li><li>تقليل التكرار.</li><li>سهولة الصيانة.</li></ul></section>
<section class="doc-section"><h2>تسمية الكلاسات</h2><pre class="doc-code">clsUser.php
clsStudent.php
clsAttendance.php</pre></section>
<section class="doc-section"><h2>تسمية الصفحات</h2><pre class="doc-code">index.php
create.php
store.php
view.php
edit.php
update.php
delete.php</pre></section>
<section class="doc-section"><h2>قاعدة البيانات</h2><p>يجب استخدام PDO و Prepared Statements دائمًا.</p></section>

<div class="doc-footer-nav"><div><a class="btn btn-outline-secondary" href="installation-guide.php"><i class="fa fa-arrow-right me-1"></i>دليل التثبيت</a></div><div><a class="btn btn-primary" href="project-guidelines.php">دليل التطوير<i class="fa fa-arrow-left ms-1"></i></a></div></div>
</main>
<?php include './includes/footer.php'; ?>
