<?php
$pageTitle = 'مركز توثيق مشروع Hodoor';
include './includes/header.php';
include './includes/sidebar.php';
?>
<main class="documentation-content">
    <div class="doc-hero">
        <h1><i class="fa fa-book-open me-2"></i>مركز توثيق مشروع Hodoor</h1>
        <p>صفحة مخصصة لاستعراض جميع أجزاء التوثيق الخاصة بالمشروع بشكل منظم وسهل القراءة.</p>
    </div>
<div class="row g-4">
<?php
$cards = [
    ['نظرة عامة', 'شرح فكرة المشروع وأهدافه والتقنيات المستخدمة.', 'overview.php', 'fa-circle-info'],
    ['هيكل المشروع', 'شرح المجلدات والملفات الرئيسية داخل النظام.', 'project-structure.php', 'fa-folder-tree'],
    ['دورة عمل النظام', 'شرح تدفق العمليات داخل Hodoor.', 'system-flow.php', 'fa-diagram-project'],
    ['مرجع الكلاسات', 'شرح الكلاسات ومسؤولية كل Class.', 'classes-reference.php', 'fa-code'],
    ['المصادقة والصلاحيات', 'شرح تسجيل الدخول والجلسات والأدوار.', 'authentication.php', 'fa-user-shield'],
    ['قاعدة البيانات', 'شرح الجداول والعلاقات وطريقة الربط.', 'database-architecture.php', 'fa-database'],
    ['دليل التثبيت', 'طريقة تشغيل المشروع محليًا واستيراد القاعدة.', 'installation-guide.php', 'fa-download'],
    ['معايير البرمجة', 'قواعد كتابة وتنظيم الكود داخل المشروع.', 'coding-standards.php', 'fa-list-check'],
    ['دليل التطوير', 'طريقة إضافة ميزات وجداول وصفحات جديدة.', 'project-guidelines.php', 'fa-screwdriver-wrench'],
    ['دليل الاختبارات', 'سيناريوهات اختبار النظام قبل الاعتماد.', 'testing-guide.php', 'fa-vial-circle-check'],
    ['دليل الأمان', 'شرح الحماية والجلسات والصلاحيات و PDO.', 'security-guide.php', 'fa-lock'],
    ['لقطات الشاشة', 'تنظيم صور المشروع الرسمية داخل README.', 'screenshots.php', 'fa-images'],
    ['الأسئلة الشائعة', 'إجابات المشاكل والأسئلة المتكررة.', 'faq.php', 'fa-circle-question'],
    ['سجل التغييرات', 'تاريخ إصدارات المشروع والتحديثات.', 'changelog.php', 'fa-clock-rotate-left'],
];
?>
<?php foreach ($cards as $card): ?>
    <div class="col-md-6 col-xl-4">
        <div class="doc-card">
            <div class="doc-card-icon"><i class="fa <?= $card[3]; ?>"></i></div>
            <h5><?= clsHelper::e($card[0]); ?></h5>
            <p><?= clsHelper::e($card[1]); ?></p>
            <a href="<?= clsHelper::e($card[2]); ?>" class="btn btn-outline-primary btn-sm">استعراض <i class="fa fa-arrow-left ms-1"></i></a>
        </div>
    </div>
<?php endforeach; ?>
</div>
<div class="doc-footer-nav"><div></div><div><a class="btn btn-primary" href="overview.php">ابدأ التوثيق<i class="fa fa-arrow-left ms-1"></i></a></div></div>
</main>
<?php include './includes/footer.php'; ?>
