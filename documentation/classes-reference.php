<?php
$pageTitle = 'مرجع الكلاسات';
include './includes/header.php';
include './includes/sidebar.php';
?>
<main class="documentation-content">
    <div class="doc-hero">
        <h1><i class="fa fa-code me-2"></i>مرجع الكلاسات</h1>
        <p>شرح مسؤولية كل Class داخل مشروع Hodoor.</p>
    </div>

    <section class="doc-section"><h2>clsUser</h2>
        <ul>
            <li>تسجيل الدخول.</li>
            <li>إنشاء الجلسة.</li>
            <li>إدارة المستخدمين.</li>
            <li>التحقق من حالة الحساب.</li>
        </ul>
    </section>
    <section class="doc-section"><h2>clsStudent</h2>
        <ul>
            <li>إضافة الطلاب.</li>
            <li>تعديل بيانات الطلاب.</li>
            <li>حذف الطلاب.</li>
            <li>البحث وعرض البيانات.</li>
        </ul>
    </section>
    <section class="doc-section"><h2>clsClassroom</h2>
        <ul>
            <li>إدارة الفصول.</li>
            <li>جلب الفصول.</li>
            <li>ربط الطلاب بالفصول.</li>
        </ul>
    </section>
    <section class="doc-section"><h2>clsAttendance</h2>
        <ul>
            <li>تسجيل الحضور.</li>
            <li>تعديل الحضور.</li>
            <li>منع التكرار.</li>
            <li>عرض السجلات.</li>
        </ul>
    </section>
    <section class="doc-section"><h2>clsHelper و clsValidator</h2>
        <p>clsHelper للدوال المساعدة والجلسات والصلاحيات، و clsValidator للتحقق من المدخلات.</p></section>

    <div class="doc-footer-nav">
        <div>
            <a class="btn btn-outline-secondary" href="system-flow.php">
                <i class="fa fa-arrow-right me-1"></i>
                دورة عمل النظام
            </a>
        </div>

        <div>
            <a class="btn btn-primary" href="authentication.php">
                المصادقة والصلاحيات
                <i class="fa fa-arrow-left ms-1"></i>
            </a>
        </div>
    </div>
</main>
<?php include './includes/footer.php'; ?>
