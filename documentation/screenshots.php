<?php
$pageTitle = 'لقطات الشاشة';
include './includes/header.php';
include './includes/sidebar.php';
?>
<main class="documentation-content">
    <div class="doc-hero">
        <h1><i class="fa fa-images me-2"></i>لقطات الشاشة</h1>
        <p>تنظيم صور المشروع الرسمية المستخدمة في العرض والتوثيق.</p>
    </div>

<section class="doc-section"><h2>مكان حفظ الصور</h2><pre class="doc-code">docs/screenshots/
├── login-page.png
├── dashboard.png
├── students-index.png
├── attendance-page.png
└── reports-page.png</pre></section>
<section class="doc-section"><h2>الصور المقترحة</h2><ul><li>تسجيل الدخول.</li><li>لوحة التحكم.</li><li>إدارة الطلاب.</li><li>تسجيل الحضور.</li><li>التقارير.</li><li>السجلات.</li></ul></section>

<div class="doc-footer-nav"><div><a class="btn btn-outline-secondary" href="security-guide.php"><i class="fa fa-arrow-right me-1"></i>دليل الأمان</a></div><div><a class="btn btn-primary" href="faq.php">الأسئلة الشائعة<i class="fa fa-arrow-left ms-1"></i></a></div></div>
</main>
<?php include './includes/footer.php'; ?>
