<?php
$pageTitle = 'لقطات الشاشة';
include './includes/header.php';
include './includes/sidebar.php';

$screenshots = [
        ['01-login-page.png', 'صفحة تسجيل الدخول', 'تعرض واجهة تسجيل الدخول إلى النظام.'],
        ['02-home-page.png', 'الصفحة الرئيسية', 'تعرض صفحة التعريف والمميزات وطريقة العمل.'],
        ['03-dashboard.png', 'لوحة التحكم', 'تعرض الإحصائيات العامة ومؤشرات النظام.'],
        ['04-users-management.png', 'إدارة المستخدمين', 'تعرض قائمة المستخدمين والصلاحيات.'],
        ['05-user-create.png', 'إضافة مستخدم', 'تعرض نموذج إضافة مستخدم جديد.'],
        ['06-students-management.png', 'إدارة الطلاب', 'تعرض جدول الطلاب والبحث والإجراءات.'],
        ['07-student-profile.png', 'ملف الطالب', 'تعرض بيانات الطالب بشكل مفصل.'],
        ['08-classrooms-management.png', 'إدارة الفصول', 'تعرض قائمة الفصول الدراسية.'],
        ['09-classroom-view.png', 'عرض الفصل', 'تعرض تفاصيل الفصل والبيانات المرتبطة به.'],
        ['10-attendance-page.png', 'تسجيل الحضور', 'تعرض صفحة تسجيل الحضور اليومية.'],
        ['11-attendance-history.png', 'سجل الحضور', 'تعرض سجلات الحضور السابقة.'],
        ['12-student-report.png', 'تقرير الطالب', 'تعرض تقرير حضور طالب محدد.'],
        ['13-classroom-report.png', 'تقرير الفصل', 'تعرض تقرير حضور فصل كامل.'],
        ['14-absence-report.png', 'تقرير الغياب', 'تعرض الطلاب الغائبين.'],
        ['15-late-report.png', 'تقرير التأخير', 'تعرض الطلاب المتأخرين.'],
        ['16-settings-page.png', 'الإعدادات', 'تعرض إعدادات النظام.'],
        ['17-system-logs.png', 'سجل العمليات', 'تعرض العمليات المسجلة داخل النظام.'],
        ['18-documentation-home.png', 'مركز التوثيق', 'تعرض صفحة التوثيق داخل الموقع.'],
        ['19-mobile-view.png', 'عرض الجوال', 'تعرض توافق النظام مع شاشات الجوال.'],
];
?>

    <main class="documentation-content">

        <div class="doc-hero">
            <h1>
                <i class="fa fa-images me-2"></i>
                لقطات الشاشة
            </h1>

            <p>
                هذا القسم يعرض صورًا من واجهات مشروع Hodoor لتوضيح شكل النظام وتجربة الاستخدام.
            </p>
        </div>

        <div class="row g-4">
            <?php foreach ($screenshots as $screenshot): ?>
                <?php
                $imagePath = './images/' . $screenshot[0];

                if (!file_exists($imagePath)) {
                    continue;
                }
                ?>

                <div class="col-lg-6">
                    <div class="doc-section">
                        <img src="images/<?= clsHelper::e($screenshot[0]); ?>"
                             class="doc-image"
                             alt="<?= clsHelper::e($screenshot[1]); ?>">

                        <h5 class="doc-gallery-title">
                            <?= clsHelper::e($screenshot[1]); ?>
                        </h5>

                        <p class="mb-0">
                            <?= clsHelper::e($screenshot[2]); ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </main>

<?php include './includes/footer.php'; ?>