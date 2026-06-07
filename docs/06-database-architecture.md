# هيكلية قاعدة البيانات (Database Architecture)

يشرح هذا الملف هيكل قاعدة البيانات الخاصة بمشروع Hodoor، والجداول الأساسية المستخدمة داخل النظام، والعلاقات بينها،
وطريقة إنشاء قاعدة جديدة وتشغيل المشروع عليها.

---

# مقدمة

يعتمد مشروع Hodoor على قاعدة بيانات MySQL لتخزين بيانات النظام الأساسية مثل:

* المستخدمين
* الفصول الدراسية
* الطلاب
* سجلات الحضور
* إعدادات النظام

تم تصميم قاعدة البيانات بطريقة بسيطة وواضحة تساعد على سهولة الفهم والتطوير والتوسعة مستقبلاً.

---

# اسم قاعدة البيانات المقترح

يمكن إنشاء قاعدة البيانات بالاسم التالي:

```sql
CREATE
DATABASE hodoor;
```

بعد إنشاء قاعدة البيانات يتم استيراد ملف SQL الخاص بالمشروع.

المسار المقترح لملف القاعدة:

```text
database/hodoor.sql
```

---

# إعداد الاتصال بقاعدة البيانات

بعد استيراد قاعدة البيانات، يجب تعديل بيانات الاتصال من ملف قاعدة البيانات داخل المشروع.

المسار المتوقع:

```text
config/database.php
```

أو حسب الكلاس المستخدم للاتصال بقاعدة البيانات:

```text
classes/clsDatabase.php
```

مثال بيانات الاتصال:

```php
$host = 'localhost';
$dbname = 'hodoor';
$username = 'root';
$password = '';
```

في حال استخدام MAMP قد تكون البيانات مثل:

```php
$host = 'localhost';
$dbname = 'hodoor';
$username = 'root';
$password = 'root';
```

---

# الجداول الأساسية

تحتوي قاعدة البيانات على الجداول التالية:

```text
users
classrooms
students
attendance
settings
```

---

# جدول users

يستخدم جدول `users` لتخزين بيانات مستخدمي النظام.

## وظيفة الجدول

هذا الجدول مسؤول عن:

* بيانات تسجيل الدخول.
* صلاحيات المستخدم.
* حالة الحساب.
* معلومات المستخدم الأساسية.

## الحقول

| الحقل      | النوع        | الوصف             |
|------------|--------------|-------------------|
| id         | INT          | رقم المستخدم      |
| full_name  | VARCHAR(100) | الاسم الكامل      |
| username   | VARCHAR(50)  | اسم المستخدم      |
| email      | VARCHAR(100) | البريد الإلكتروني |
| password   | VARCHAR(255) | كلمة المرور       |
| role       | ENUM         | نوع المستخدم      |
| status     | TINYINT      | حالة المستخدم     |
| created_at | TIMESTAMP    | تاريخ الإنشاء     |

## أنواع المستخدمين

```text
admin
teacher
supervisor
```

## ملاحظات

* الحقل `username` يجب أن يكون فريدًا.
* الحقل `role` يحدد صلاحيات المستخدم داخل النظام.
* الحقل `status` يستخدم لتفعيل أو تعطيل الحساب.

> ملاحظة أمنية مهمة: يجب تخزين كلمة المرور بشكل مشفر باستخدام `password_hash()`، وليس كنص عادي.

---

# جدول classrooms

يستخدم جدول `classrooms` لتخزين بيانات الفصول الدراسية.

## وظيفة الجدول

هذا الجدول مسؤول عن:

* أسماء الفصول.
* أكواد الفصول.
* المستوى الدراسي.

## الحقول

| الحقل      | النوع        | الوصف            |
|------------|--------------|------------------|
| id         | INT          | رقم الفصل        |
| class_name | VARCHAR(100) | اسم الفصل        |
| class_code | VARCHAR(30)  | كود الفصل        |
| level_name | VARCHAR(50)  | المرحلة الدراسية |
| created_at | TIMESTAMP    | تاريخ الإنشاء    |

## مثال

```text
الصف الأول أ
A-101
ابتدائي
```

---

# جدول students

يستخدم جدول `students` لتخزين بيانات الطلاب.

## وظيفة الجدول

هذا الجدول مسؤول عن:

* بيانات الطالب الأساسية.
* ربط الطالب بالفصل.
* بيانات ولي الأمر.
* حالة الطالب.

## الحقول

| الحقل          | النوع        | الوصف                     |
|----------------|--------------|---------------------------|
| id             | INT          | رقم الطالب                |
| classroom_id   | INT          | رقم الفصل المرتبط بالطالب |
| student_name   | VARCHAR(150) | اسم الطالب                |
| student_number | VARCHAR(50)  | رقم الطالب                |
| gender         | ENUM         | الجنس                     |
| birth_date     | DATE         | تاريخ الميلاد             |
| phone          | VARCHAR(20)  | رقم جوال الطالب           |
| parent_name    | VARCHAR(150) | اسم ولي الأمر             |
| parent_phone   | VARCHAR(20)  | رقم ولي الأمر             |
| address        | TEXT         | العنوان                   |
| status         | TINYINT      | حالة الطالب               |
| created_at     | TIMESTAMP    | تاريخ الإنشاء             |

## العلاقة مع جدول الفصول

كل طالب مرتبط بفصل واحد من جدول:

```text
classrooms
```

العلاقة:

```text
students.classroom_id → classrooms.id
```

## قاعدة الحذف

عند حذف الفصل يتم حذف الطلاب المرتبطين به تلقائيًا بسبب:

```sql
ON DELETE
CASCADE
```

---

# جدول attendance

يستخدم جدول `attendance` لتخزين سجلات حضور الطلاب.

## وظيفة الجدول

هذا الجدول مسؤول عن:

* تسجيل حضور الطالب.
* تحديد حالة الطالب.
* حفظ تاريخ الحضور.
* معرفة من قام بتسجيل الحضور.
* منع تكرار حضور الطالب في نفس اليوم.

## الحقول

| الحقل           | النوع     | الوصف                    |
|-----------------|-----------|--------------------------|
| id              | INT       | رقم سجل الحضور           |
| student_id      | INT       | رقم الطالب               |
| classroom_id    | INT       | رقم الفصل                |
| attendance_date | DATE      | تاريخ الحضور             |
| status          | ENUM      | حالة الحضور              |
| notes           | TEXT      | ملاحظات                  |
| recorded_by     | INT       | المستخدم الذي سجل الحضور |
| created_at      | TIMESTAMP | تاريخ الإنشاء            |

## حالات الحضور

```text
present
absent
late
excused
```

ومعناها:

| القيمة  | المعنى |
|---------|--------|
| present | حاضر   |
| absent  | غائب   |
| late    | متأخر  |
| excused | مستأذن |

---

# منع تكرار الحضور

يوجد قيد يمنع تكرار تسجيل حضور نفس الطالب في نفس اليوم:

```sql
UNIQUE (student_id, attendance_date)
```

وهذا يعني:

```text
لا يمكن تسجيل نفس الطالب أكثر من مرة في نفس التاريخ
```

---

# علاقات جدول attendance

## علاقة الحضور بالطالب

```text
attendance.student_id → students.id
```

عند حذف الطالب يتم حذف سجلات حضوره:

```sql
ON DELETE
CASCADE
```

## علاقة الحضور بالفصل

```text
attendance.classroom_id → classrooms.id
```

عند حذف الفصل يتم حذف سجلات الحضور المرتبطة به:

```sql
ON DELETE
CASCADE
```

## علاقة الحضور بالمستخدم

```text
attendance.recorded_by → users.id
```

عند حذف المستخدم يتم تحويل القيمة إلى NULL:

```sql
ON DELETE
SET NULL
```

---

# جدول settings

يستخدم جدول `settings` لتخزين إعدادات النظام.

## وظيفة الجدول

هذا الجدول مسؤول عن حفظ الإعدادات العامة التي يمكن تعديلها من لوحة التحكم.

## الحقول

| الحقل         | النوع        | الوصف         |
|---------------|--------------|---------------|
| id            | INT          | رقم الإعداد   |
| setting_key   | VARCHAR(100) | مفتاح الإعداد |
| setting_value | TEXT         | قيمة الإعداد  |

## أمثلة محتملة

```text
site_name
attendance_present_status
attendance_absent_status
attendance_late_status
attendance_excused_status
```

---

# مخطط العلاقات

```text
users
  │
  └── attendance.recorded_by

classrooms
  │
  ├── students.classroom_id
  │
  └── attendance.classroom_id

students
  │
  └── attendance.student_id

settings
  └── إعدادات مستقلة
```

---

# العلاقة العامة بين الجداول

```text
الفصل يحتوي على عدة طلاب
الطالب له عدة سجلات حضور
الفصل له عدة سجلات حضور
المستخدم يمكنه تسجيل عدة سجلات حضور
الإعدادات تتحكم ببعض خيارات النظام
```

---

# بيانات تجريبية

يمكن إرفاق بيانات تجريبية مع المشروع لتسهيل تجربة النظام مباشرة بعد التثبيت.

البيانات التجريبية يمكن أن تشمل:

* مستخدم مدير.
* مستخدم مشرف.
* مستخدم معلم.
* عدة فصول.
* عدة طلاب.
* سجلات حضور تجريبية.

---

# بيانات دخول مقترحة للتجربة

```text
Username: admin
Password: 123456
Role: admin
```

> يجب تغيير كلمة المرور بعد تشغيل المشروع.

---

# أوامر فحص مفيدة

## عرض المستخدمين

```sql
SELECT *
FROM users;
```

## عرض الفصول

```sql
SELECT *
FROM classrooms;
```

## عرض الطلاب

```sql
SELECT *
FROM students;
```

## عرض الطلاب مع اسم الفصل

```sql
SELECT students.*, classrooms.class_name
FROM students
         LEFT JOIN classrooms ON classrooms.id = students.classroom_id;
```

## عدد المستخدمين

```sql
SELECT COUNT(*) AS total_users
FROM users;
```

## عدد الفصول

```sql
SELECT COUNT(*) AS total_classrooms
FROM classrooms;
```

## عدد الطلاب

```sql
SELECT COUNT(*) AS total_students
FROM students;
```

---

# أوامر تنظيف البيانات التجريبية

في حال أراد المطور حذف البيانات التجريبية والبدء من جديد:

```sql
DELETE
FROM attendance;
DELETE
FROM students;
DELETE
FROM classrooms;
DELETE
FROM users;
```

ثم إعادة العدادات:

```sql
ALTER TABLE attendance AUTO_INCREMENT = 1;
ALTER TABLE students AUTO_INCREMENT = 1;
ALTER TABLE classrooms AUTO_INCREMENT = 1;
ALTER TABLE users AUTO_INCREMENT = 1;
```

> يجب حذف جدول attendance أولًا لأنه مرتبط بالطلاب والفصول والمستخدمين.

---

# إنشاء مدير واحد فقط

في حال أراد المطور إنشاء مستخدم مدير فقط:

```sql
INSERT INTO users (full_name, username, email, password, role, status, created_at)
VALUES ('System Admin', 'admin', 'admin@hodoor.com', '123456', 'admin', 1, NOW());
```

> يفضل استبدال كلمة المرور بنسخة مشفرة من `password_hash()` قبل اعتماد المشروع نهائيًا.

---

# إنشاء فصل واحد فقط

```sql
INSERT INTO classrooms (class_name, class_code, level_name, created_at)
VALUES ('الصف الأول أ', 'A-101', 'ابتدائي', NOW());
```

---

# إنشاء طالب واحد فقط

```sql
INSERT INTO students (classroom_id,
                      student_name,
                      student_number,
                      gender,
                      birth_date,
                      phone,
                      parent_name,
                      parent_phone,
                      address,
                      status,
                      created_at)
VALUES (1,
        'محمد أحمد',
        'STU001',
        'male',
        '2018-01-10',
        '0500000001',
        'أحمد محمد',
        '0551000001',
        'الرياض - حي النزهة',
        1,
        NOW());
```

---

# ملاحظات مهمة للمطور

عند تشغيل المشروع على جهاز جديد يجب تنفيذ الخطوات التالية:

1. إنشاء قاعدة بيانات جديدة.
2. استيراد ملف SQL.
3. تعديل بيانات الاتصال.
4. التأكد من اسم قاعدة البيانات.
5. التأكد من اسم المستخدم وكلمة المرور.
6. فتح المشروع من المتصفح.
7. تسجيل الدخول بحساب المدير التجريبي.

---

# ملاحظات أمنية

قبل رفع المشروع بشكل نهائي يفضل التأكد من التالي:

* عدم استخدام كلمات مرور نصية.
* تشفير كلمات المرور باستخدام `password_hash()`.
* استخدام `password_verify()` عند تسجيل الدخول.
* عدم رفع بيانات حقيقية داخل ملف SQL.
* جعل البيانات التجريبية واضحة أنها للتجربة فقط.
* حذف أي بيانات حساسة قبل نشر المشروع.

---

# الخلاصة

تم تصميم قاعدة بيانات Hodoor بشكل بسيط ومنظم لتخدم نظام حضور مدرسي قابل للتطوير.

تعتمد القاعدة على علاقة واضحة بين:

* المستخدمين
* الفصول
* الطلاب
* الحضور
* الإعدادات

ويمكن لأي مطور إنشاء قاعدة جديدة واستيراد ملف SQL ثم تعديل بيانات الاتصال فقط لتشغيل المشروع.
