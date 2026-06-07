<?php
$pageTitle = 'دليل التطوير';
include './includes/header.php';
include './includes/sidebar.php';
?>
<main class="documentation-content">
    <div class="doc-hero">
        <h1><i class="fa fa-screwdriver-wrench me-2"></i>دليل التطوير</h1>
        <p>طريقة تطوير المشروع وإضافة ميزات جديدة.</p>
    </div>

<section class="doc-section"><h2>قبل إضافة ميزة جديدة</h2><ul><li>هل تحتاج جدول جديد؟</li><li>هل تحتاج Class جديد؟</li><li>هل تحتاج صفحات Module؟</li><li>هل تحتاج صلاحيات؟</li><li>هل تحتاج Logs؟</li></ul></section>
<section class="doc-section"><h2>دورة التطوير</h2><pre class="doc-code">فكرة جديدة
↓
إنشاء جدول
↓
إنشاء Class
↓
إنشاء Module
↓
إضافة Validation
↓
إضافة Permissions
↓
إضافة Logs
↓
اختبار
↓
تحديث Documentation</pre></section>

<div class="doc-footer-nav"><div><a class="btn btn-outline-secondary" href="coding-standards.php"><i class="fa fa-arrow-right me-1"></i>معايير البرمجة</a></div><div><a class="btn btn-primary" href="testing-guide.php">دليل الاختبارات<i class="fa fa-arrow-left ms-1"></i></a></div></div>
</main>
<?php include './includes/footer.php'; ?>
