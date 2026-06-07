<?php
$pageTitle = 'الأسئلة الشائعة';
include './includes/header.php';
include './includes/sidebar.php';
?>
<main class="documentation-content">
    <div class="doc-hero">
        <h1><i class="fa fa-circle-question me-2"></i>الأسئلة الشائعة</h1>
        <p>إجابات مختصرة لأكثر المشاكل والأسئلة المتكررة.</p>
    </div>

<section class="doc-section"><h2>أين أضع ملفات المشروع؟</h2><p>داخل htdocs في XAMPP أو MAMP، أو www في Laragon.</p></section>
<section class="doc-section"><h2>لا أستطيع تسجيل الدخول</h2><ul><li>تحقق من اسم المستخدم.</li><li>تحقق من كلمة المرور.</li><li>تحقق من أن status = 1.</li></ul></section>
<section class="doc-section"><h2>لماذا لا تظهر بعض القوائم؟</h2><p>لأن القوائم تعتمد على صلاحية المستخدم الحالي.</p></section>

<div class="doc-footer-nav"><div><a class="btn btn-outline-secondary" href="screenshots.php"><i class="fa fa-arrow-right me-1"></i>لقطات الشاشة</a></div><div><a class="btn btn-primary" href="changelog.php">سجل التغييرات<i class="fa fa-arrow-left ms-1"></i></a></div></div>
</main>
<?php include './includes/footer.php'; ?>
