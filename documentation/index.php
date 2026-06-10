<?php
$pageTitle = 'مركز التوثيق';
include './includes/header.php';
include './includes/sidebar.php';
?>

    <main class="documentation-content">

        <div class="doc-hero">
            <h1>
                <i class="fa fa-book-open me-2"></i>
                مركز توثيق مشروع Hodoor
            </h1>

            <p>
                صفحة مخصصة لاستعراض جميع أجزاء التوثيق الخاصة بالمشروع بشكل منظم وسهل القراءة.
            </p>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="doc-meta-box">
                    <span>اسم المشروع</span>
                    <strong>Hodoor</strong>
                </div>
            </div>

            <div class="col-md-3">
                <div class="doc-meta-box">
                    <span>الإصدار</span>
                    <strong>1.0.0</strong>
                </div>
            </div>

            <div class="col-md-3">
                <div class="doc-meta-box">
                    <span>لغة البرمجة</span>
                    <strong>PHP OOP</strong>
                </div>
            </div>

            <div class="col-md-3">
                <div class="doc-meta-box">
                    <span>قاعدة البيانات</span>
                    <strong>MySQL</strong>
                </div>
            </div>

        </div>

        <?php if (file_exists('./images/03-dashboard.png')): ?>
            <div class="doc-section">
                <h2>لمحة من المشروع</h2>
                <p>
                    تعرض الصورة التالية لوحة التحكم الرئيسية في نظام Hodoor بعد تجهيز البيانات التجريبية.
                </p>

                <img src="images/03-dashboard.png" class="doc-image" alt="لوحة تحكم Hodoor">
            </div>
        <?php endif; ?>

        <div class="row g-4">

            <?php
            $cards = [
                    ['نظرة عامة', 'شرح فكرة المشروع وأهدافه والتقنيات المستخدمة.', 'overview.php', 'fa-circle-info'],
                    ['هيكل المشروع', 'شرح المجلدات والملفات الرئيسية داخل النظام.', 'project-structure.php', 'fa-folder-tree'],
                    ['دورة عمل النظام', 'شرح تدفق العمليات داخل Hodoor.', 'system-flow.php', 'fa-diagram-project'],
                    ['مرجع الكلاسات', 'شرح الكلاسات ومسؤولية كل Class.', 'classes-reference.php', 'fa-code'],
                    ['المصادقة والصلاحيات', 'شرح تسجيل الدخول والجلسات والصلاحيات.', 'authentication.php', 'fa-user-shield'],
                    ['قاعدة البيانات', 'شرح الجداول والعلاقات وطريقة الربط.', 'database-architecture.php', 'fa-database'],
                    ['دليل التثبيت', 'طريقة تشغيل المشروع محليًا.', 'installation-guide.php', 'fa-download'],
                    ['معايير البرمجة', 'قواعد كتابة وتنظيم الكود.', 'coding-standards.php', 'fa-list-check'],
                    ['دليل التطوير', 'طريقة إضافة ميزات جديدة.', 'project-guidelines.php', 'fa-screwdriver-wrench'],
                    ['دليل الاختبارات', 'سيناريوهات اختبار النظام.', 'testing-guide.php', 'fa-vial-circle-check'],
                    ['دليل الأمان', 'شرح الحماية والأمان داخل المشروع.', 'security-guide.php', 'fa-lock'],
                    ['لقطات الشاشة', 'استعراض صور المشروع وصفحاته الأساسية.', 'screenshots.php', 'fa-image'],
                    ['الأسئلة الشائعة', 'إجابات المشاكل والأسئلة المتكررة.', 'faq.php', 'fa-circle-question'],
                    ['سجل التغييرات', 'تاريخ إصدارات المشروع والتحديثات.', 'changelog.php', 'fa-clock-rotate-left'],
            ];
            ?>


            <?php foreach ($cards as $card): ?>
                <div class="col-md-6 col-xl-4">
                    <div class="doc-card">
                        <div class="doc-card-icon">
                            <i class="fa <?= clsHelper::e($card[3]); ?>"></i>
                        </div>

                        <h5><?= clsHelper::e($card[0]); ?></h5>

                        <p><?= clsHelper::e($card[1]); ?></p>

                        <a href="<?= clsHelper::e($card[2]); ?>" class="btn btn-outline-primary btn-sm">
                            استعراض
                            <i class="fa fa-arrow-left ms-1"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>


        </div>

    </main>

<?php include './includes/footer.php'; ?>