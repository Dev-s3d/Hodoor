<?php
$pageTitle = 'قاعدة البيانات';
include './includes/header.php';
include './includes/sidebar.php';
?>
<main class="documentation-content">
    <div class="doc-hero">
        <h1><i class="fa fa-database me-2"></i>قاعدة البيانات</h1>
        <p>شرح الجداول والعلاقات وطريقة تجهيز قاعدة البيانات.</p>
    </div>

<section class="doc-section"><h2>الجداول الأساسية</h2><pre class="doc-code">users
classrooms
students
attendance
settings</pre></section>
<section class="doc-section"><h2>جدول users</h2><p>يخزن بيانات المستخدمين وصلاحياتهم وحالة الحساب.</p></section>
<section class="doc-section"><h2>جدول students</h2><p>يخزن بيانات الطلاب ويربط كل طالب بفصل من خلال classroom_id.</p></section>
<section class="doc-section"><h2>جدول attendance</h2><p>يخزن سجلات الحضور اليومية ويمنع تكرار تسجيل نفس الطالب في نفس التاريخ.</p><pre class="doc-code">UNIQUE (student_id, attendance_date)</pre></section>
<section class="doc-section"><h2>العلاقات</h2><pre class="doc-code">classrooms.id → students.classroom_id
students.id → attendance.student_id
classrooms.id → attendance.classroom_id
users.id → attendance.recorded_by</pre></section>

<div class="doc-footer-nav"><div><a class="btn btn-outline-secondary" href="authentication.php"><i class="fa fa-arrow-right me-1"></i>المصادقة والصلاحيات</a></div><div><a class="btn btn-primary" href="installation-guide.php">دليل التثبيت<i class="fa fa-arrow-left ms-1"></i></a></div></div>
</main>
<?php include './includes/footer.php'; ?>
