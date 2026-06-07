<?php
$pageTitle = 'دليل الاختبارات';
include './includes/header.php';
include './includes/sidebar.php';
?>
<main class="documentation-content">
    <div class="doc-hero">
        <h1><i class="fa fa-vial-circle-check me-2"></i>دليل الاختبارات</h1>
        <p>سيناريوهات اختبار النظام قبل اعتماد أي نسخة.</p>
    </div>

<section class="doc-section"><h2>أهداف الاختبار</h2><ul><li>سلامة تسجيل الدخول.</li><li>صحة الصلاحيات.</li><li>عمل الطلاب والفصول والحضور.</li><li>سلامة التقارير والسجلات.</li></ul></section>
<section class="doc-section"><h2>اختبار الحضور</h2><ul><li>اختيار فصل وتاريخ.</li><li>تسجيل حالة كل طالب.</li><li>منع التكرار.</li><li>تعديل سجل حضور.</li></ul></section>
<section class="doc-section"><h2>قائمة التحقق</h2><ul><li>تسجيل الدخول يعمل.</li><li>الإدارة تعمل.</li><li>التقارير تعمل.</li><li>Logs تعمل.</li><li>لا توجد أخطاء PHP.</li></ul></section>

<div class="doc-footer-nav"><div><a class="btn btn-outline-secondary" href="project-guidelines.php"><i class="fa fa-arrow-right me-1"></i>دليل التطوير</a></div><div><a class="btn btn-primary" href="security-guide.php">دليل الأمان<i class="fa fa-arrow-left ms-1"></i></a></div></div>
</main>
<?php include './includes/footer.php'; ?>
