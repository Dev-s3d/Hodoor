<?php
$pageTitle = 'دورة عمل النظام';
include './includes/header.php';
include './includes/sidebar.php';
?>
<main class="documentation-content">
    <div class="doc-hero">
        <h1><i class="fa fa-diagram-project me-2"></i>دورة عمل النظام</h1>
        <p>شرح كيفية عمل النظام من تسجيل الدخول إلى حفظ البيانات.</p>
    </div>

<section class="doc-section"><h2>التدفق العام</h2><pre class="doc-code">المستخدم
↓
تسجيل الدخول
↓
التحقق من الصلاحيات
↓
لوحة التحكم
↓
الوحدات المختلفة
↓
قاعدة البيانات
↓
سجل العمليات</pre></section>
<section class="doc-section"><h2>تسجيل الدخول</h2><pre class="doc-code">login.php → login_action.php → clsUser::login() → إنشاء Session → لوحة التحكم</pre></section>
<section class="doc-section"><h2>تسجيل الحضور</h2><pre class="doc-code">اختيار الفصل والتاريخ
↓
تحميل الطلاب
↓
تحديد الحالة
↓
save.php
↓
clsAttendance
↓
قاعدة البيانات
↓
clsLog</pre></section>

<div class="doc-footer-nav"><div><a class="btn btn-outline-secondary" href="project-structure.php"><i class="fa fa-arrow-right me-1"></i>هيكل المشروع</a></div><div><a class="btn btn-primary" href="classes-reference.php">مرجع الكلاسات<i class="fa fa-arrow-left ms-1"></i></a></div></div>
</main>
<?php include './includes/footer.php'; ?>
