<?php
$pageTitle = 'هيكل المشروع';
include './includes/header.php';
include './includes/sidebar.php';
?>
<main class="documentation-content">
    <div class="doc-hero">
        <h1><i class="fa fa-folder-tree me-2"></i>هيكل المشروع</h1>
        <p>شرح المجلدات والملفات الرئيسية داخل Hodoor.</p>
    </div>

    <section class="doc-section"><h2>الهيكل العام</h2>
        <pre class="doc-code">Hodoor/
├── assets/
├── classes/
├── config/
├── docs/
├── documentation/
├── includes/
├── modules/
├── storage/
├── index.php
├── README.md
└── CHANGELOG.md</pre>
    </section>
    <section class="doc-section"><h2>assets</h2>
        <p>يحتوي على CSS و JavaScript والصور والمكتبات الخارجية.</p></section>
    <section class="doc-section"><h2>classes</h2>
        <p>يحتوي على الكلاسات الأساسية مثل clsUser و clsStudent و clsAttendance و clsHelper.</p></section>
    <section class="doc-section"><h2>modules</h2>
        <p>يحتوي على صفحات النظام مثل auth و dashboard و users و students و classrooms و attendance و reports.</p>
    </section>
    <section class="doc-section"><h2>docs و documentation</h2>
        <p><strong>docs</strong> لملفات Markdown في GitHub، و <strong>documentation</strong> لصفحات التوثيق داخل الموقع.
        </p></section>

    <div class="doc-footer-nav">
        <div><a class="btn btn-outline-secondary" href="overview.php"><i class="fa fa-arrow-right me-1"></i>نظرة
                عامة</a></div>
        <div><a class="btn btn-primary" href="system-flow.php">دورة عمل النظام<i class="fa fa-arrow-left ms-1"></i></a>
        </div>
    </div>
</main>
<?php include './includes/footer.php'; ?>
