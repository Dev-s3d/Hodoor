<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$documentationLinks = [
    'index.php' => ['الرئيسية', 'fa-book-open'],
    'overview.php' => ['نظرة عامة', 'fa-circle-info'],
    'project-structure.php' => ['هيكل المشروع', 'fa-folder-tree'],
    'system-flow.php' => ['دورة عمل النظام', 'fa-diagram-project'],
    'classes-reference.php' => ['مرجع الكلاسات', 'fa-code'],
    'authentication.php' => ['المصادقة والصلاحيات', 'fa-user-shield'],
    'database-architecture.php' => ['قاعدة البيانات', 'fa-database'],
    'installation-guide.php' => ['دليل التثبيت', 'fa-download'],
    'coding-standards.php' => ['معايير البرمجة', 'fa-list-check'],
    'project-guidelines.php' => ['دليل التطوير', 'fa-screwdriver-wrench'],
    'testing-guide.php' => ['دليل الاختبارات', 'fa-vial-circle-check'],
    'security-guide.php' => ['دليل الأمان', 'fa-lock'],
    'screenshots.php' => ['لقطات الشاشة', 'fa-images'],
    'faq.php' => ['الأسئلة الشائعة', 'fa-circle-question'],
    'changelog.php' => ['سجل التغييرات', 'fa-clock-rotate-left'],
];
?>
<aside class="documentation-sidebar">
    <h5><i class="fa fa-book-open text-primary me-1"></i> توثيق Hodoor</h5>
    <?php foreach ($documentationLinks as $file => $data): ?>
        <a href="<?= $file; ?>" class="<?= $currentPage === $file ? 'active' : ''; ?>">
            <i class="fa <?= $data[1]; ?>"></i>
            <?= clsHelper::e($data[0]); ?>
        </a>
    <?php endforeach; ?>
</aside>
