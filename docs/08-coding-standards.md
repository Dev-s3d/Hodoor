# معايير البرمجة والتطوير (Coding Standards)

يشرح هذا الملف المعايير والقواعد المتبعة أثناء تطوير مشروع Hodoor.

الهدف من هذه المعايير هو:

* الحفاظ على تنظيم المشروع.
* توحيد أسلوب كتابة الكود.
* تسهيل الصيانة والتطوير.
* تقليل الأخطاء البرمجية.
* تسهيل فهم المشروع للمطورين الجدد.

---

# المبادئ العامة

يعتمد مشروع Hodoor على المبادئ التالية:

* فصل المسؤوليات.
* إعادة استخدام الكود.
* تقليل التكرار.
* سهولة القراءة.
* سهولة التوسع.
* كتابة كود واضح ومفهوم.

---

# أسلوب البرمجة

يعتمد المشروع على:

```text
Object Oriented Programming (OOP)
```

ويجب تجنب كتابة منطق الأعمال مباشرة داخل الصفحات.

---

# تسمية الملفات

## الكلاسات

يجب أن تبدأ جميع الكلاسات بـ:

```text
cls
```

مثال:

```text
clsUser.php
clsStudent.php
clsAttendance.php
clsReport.php
```

---

## الصفحات

يتم استخدام أسماء واضحة تعبر عن وظيفة الصفحة.

مثال:

```text
index.php
create.php
store.php
edit.php
update.php
delete.php
view.php
```

---

## الملفات المساعدة

أمثلة:

```text
app.php
header.php
footer.php
sidebar.php
navbar.php
alerts.php
```

---

# تسمية المتغيرات

يتم استخدام أسلوب:

```text
snake_case
```

مثال:

```php
$student_name
$classroom_id
$attendance_date
$parent_phone
```

---

# تسمية الدوال

يتم استخدام أسماء واضحة تصف الوظيفة.

مثال:

```php
getAll()
loadById()
save()
update()
delete()
count()
search()
```

---

# كتابة الكلاسات

كل Class يجب أن يكون مسؤولاً عن مهمة واحدة فقط.

مثال:

```text
clsStudent
```

مسؤول عن:

* الطلاب فقط

وليس:

* الطلاب
* الحضور
* التقارير

في نفس الوقت.

---

# فصل منطق الأعمال

غير مسموح بكتابة استعلامات SQL مباشرة داخل صفحات العرض.

خطأ:

```php
$query = "SELECT * FROM students";
```

داخل:

```text
index.php
```

---

الصحيح:

```php
$studentObj = new clsStudent($conn);

$students = $studentObj->getAll();
```

---

# قواعد التعامل مع قاعدة البيانات

يجب استخدام:

```text
PDO
```

في جميع الاستعلامات.

---

## استخدام Prepared Statements

مثال:

```php
$stmt = $this->conn->prepare(
    "SELECT * FROM students WHERE id = ?"
);

$stmt->execute([$id]);
```

---

## يمنع

كتابة استعلامات مباشرة بهذه الطريقة:

```php
$sql = "SELECT * FROM students WHERE id = $id";
```

---

# التحقق من البيانات

يجب استخدام:

```text
clsValidator
```

قبل تنفيذ أي عملية حفظ أو تعديل.

مثال:

```php
clsValidator::required($student_name);
```

---

# حماية المخرجات

يجب استخدام:

```php
clsHelper::e()
```

عند عرض أي بيانات قادمة من قاعدة البيانات.

مثال:

```php
<?= clsHelper::e($student_name); ?>
```

---

# إدارة الجلسات

يجب استخدام:

```php
clsHelper::sessionSet()
```

و

```php
clsHelper::sessionGet()
```

بدلاً من التعامل المباشر مع Session كلما أمكن.

---

# الصلاحيات

أي صفحة حساسة يجب أن تحتوي على:

```php
clsHelper::requireRole()
```

في بداية الصفحة.

مثال:

```php
clsHelper::requireRole([
    'admin'
]);
```

---

# تسجيل العمليات

أي عملية مهمة يجب تسجيلها داخل Logs.

مثال:

```text
إضافة مستخدم
تعديل مستخدم
حذف مستخدم
إضافة طالب
تعديل طالب
حذف طالب
تسجيل حضور
```

---

مثال:

```php
clsLog::add(
    $conn,
    'إضافة طالب',
    'تمت إضافة طالب جديد'
);
```

---

# تنظيم الصفحات

كل Module يجب أن يحتوي على الصفحات التالية متى كانت مناسبة:

```text
index.php
create.php
store.php
view.php
edit.php
update.php
delete.php
```

---

# إنشاء Module جديد

عند إضافة جزء جديد للنظام.

مثال:

```text
modules/subjects/
```

يجب أن يحتوي على:

```text
subjects/
│
├── index.php
├── create.php
├── store.php
├── view.php
├── edit.php
├── update.php
└── delete.php
```

---

ويجب إنشاء Class خاص به:

```text
classes/clsSubject.php
```

---

# ترتيب الصفحة

أي صفحة داخل النظام يجب أن تعتمد الهيكل التالي:

```php
require_once '../../includes/app.php';

clsHelper::requireRole([
    'admin'
]);

include '../../includes/header.php';
include '../../includes/sidebar.php';
include '../../includes/navbar.php';
```

---

ثم:

```php
محتوى الصفحة
```

---

ثم:

```php
include '../../includes/footer.php';
```

---

# الرسائل والتنبيهات

يجب استخدام النظام الموحد للتنبيهات.

أمثلة:

```php
clsHelper::sessionSet(
    'success',
    'تمت العملية بنجاح'
);
```

---

أو:

```php
clsHelper::sessionSet(
    'error',
    'حدث خطأ أثناء التنفيذ'
);
```

---

# هيكلية CSS

يفضل تقسيم ملفات CSS حسب الوظيفة.

مثال:

```text
dashboard.css
sidebar.css
navbar.css
footer.css
```

---

# هيكلية JavaScript

يفضل عدم وضع JavaScript داخل الصفحات إلا عند الضرورة.

ويفضل استخدام:

```text
assets/js/
```

---

# التعليقات البرمجية

يجب كتابة تعليق عند وجود منطق غير واضح.

مثال:

```php
/*
|--------------------------------------------------------------------------
| Check if attendance already exists
|--------------------------------------------------------------------------
*/
```

---

# التطوير المستقبلي

عند إضافة ميزة جديدة يجب الالتزام بالتالي:

1. إنشاء جدول جديد عند الحاجة.
2. إنشاء Class مستقل.
3. إنشاء Module مستقل.
4. إضافة صلاحيات مناسبة.
5. إضافة Logs.
6. تحديث التوثيق.

---

# مراجعة الكود

قبل رفع أي تحديث:

* مراجعة الأخطاء.
* مراجعة الصلاحيات.
* مراجعة Validation.
* مراجعة Logs.
* مراجعة المسارات.

---

# الخلاصة

تم اعتماد هذه المعايير لضمان أن يبقى مشروع Hodoor:

* منظمًا.
* قابلًا للصيانة.
* سهل الفهم.
* سهل التطوير.
* جاهزًا للتوسع مستقبلاً.

ويجب الالتزام بهذه المعايير عند تطوير أي جزء جديد داخل النظام.
