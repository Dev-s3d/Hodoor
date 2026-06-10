<?php
$currentPage = basename($_SERVER['PHP_SELF']);

$documentationLinks = [
        'index.php' => 'الرئيسية',
        'overview.php' => 'نظرة عامة',
        'project-structure.php' => 'هيكل المشروع',
        'system-flow.php' => 'دورة عمل النظام',
        'classes-reference.php' => 'مرجع الكلاسات',
        'authentication.php' => 'المصادقة والصلاحيات',
        'database-architecture.php' => 'قاعدة البيانات',
        'installation-guide.php' => 'دليل التثبيت',
        'coding-standards.php' => 'معايير البرمجة',
        'project-guidelines.php' => 'دليل التطوير',
        'testing-guide.php' => 'دليل الاختبارات',
        'security-guide.php' => 'دليل الأمان',
        'screenshots.php' => 'لقطات الشاشة',
        'faq.php' => 'الأسئلة الشائعة',
        'changelog.php' => 'سجل التغييرات',
];
?>

<aside class="documentation-sidebar">
    <h5>
        <i class="fa fa-book-open text-primary me-1"></i>
        توثيق Hodoor
    </h5>

    <?php foreach ($documentationLinks as $file => $title): ?>
        <a href="<?= clsHelper::e($file); ?>" class="<?= $currentPage === $file ? 'active' : ''; ?>">
            <?= clsHelper::e($title); ?>
        </a>
    <?php endforeach; ?>
</aside>