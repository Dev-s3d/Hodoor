<?php
$pageTitle = 'نظرة عامة';
include './includes/header.php';
include './includes/sidebar.php';
?>
<main class="documentation-content">
    <div class="doc-hero">
        <h1><i class="fa fa-circle-info me-2"></i>نظرة عامة</h1>
        <p>تعريف شامل بفكرة المشروع وأهدافه ومكوناته الأساسية.</p>
    </div>

<section class="doc-section"><h2>نبذة عن المشروع</h2><p>Hodoor هو نظام لإدارة حضور الطلاب تم تطويره باستخدام PHP و MySQL بأسلوب البرمجة الكائنية OOP.</p><p>يهدف المشروع إلى مساعدة المدارس والمعاهد والمراكز التعليمية على إدارة الطلاب والفصول والحضور والتقارير بطريقة منظمة وسهلة.</p></section>
<section class="doc-section"><h2>المشكلة التي يعالجها المشروع</h2><ul><li>صعوبة متابعة الحضور بالطرق الورقية.</li><li>صعوبة استخراج التقارير والإحصائيات.</li><li>استهلاك وقت كبير أثناء التحضير اليومي.</li><li>ضعف تتبع الغياب والتأخير.</li></ul></section>
<section class="doc-section"><h2>أهداف المشروع</h2><ul><li>أتمتة تسجيل الحضور.</li><li>تنظيم بيانات الطلاب والفصول.</li><li>توفير تقارير دقيقة.</li><li>توفير صلاحيات للمستخدمين.</li><li>تسجيل العمليات المهمة.</li></ul></section>
<section class="doc-section"><h2>التقنيات المستخدمة</h2><table class="doc-table"><tr><th>التقنية</th><th>الاستخدام</th></tr><tr><td>PHP</td><td>تطوير النظام</td></tr><tr><td>MySQL</td><td>قاعدة البيانات</td></tr><tr><td>PDO</td><td>الاتصال الآمن</td></tr><tr><td>Bootstrap RTL</td><td>تصميم عربي متجاوب</td></tr><tr><td>Font Awesome</td><td>الأيقونات</td></tr></table></section>

<div class="doc-footer-nav"><div><a class="btn btn-outline-secondary" href="index.php"><i class="fa fa-arrow-right me-1"></i>مركز التوثيق</a></div><div><a class="btn btn-primary" href="project-structure.php">هيكل المشروع<i class="fa fa-arrow-left ms-1"></i></a></div></div>
</main>
<?php include './includes/footer.php'; ?>
