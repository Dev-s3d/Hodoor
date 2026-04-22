CREATE TABLE users
(
    id         INT AUTO_INCREMENT PRIMARY KEY,
    full_name  VARCHAR(100) NOT NULL,
    username   VARCHAR(50)  NOT NULL UNIQUE,
    email      VARCHAR(100) NULL,
    password   VARCHAR(255) NOT NULL,
    role       ENUM('admin', 'teacher', 'supervisor') DEFAULT 'teacher',
    status     TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE classrooms
(
    id         INT AUTO_INCREMENT PRIMARY KEY,
    class_name VARCHAR(100) NOT NULL,
    class_code VARCHAR(30) NULL,
    level_name VARCHAR(50) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE students
(
    id             INT AUTO_INCREMENT PRIMARY KEY,
    classroom_id   INT          NOT NULL,
    student_name   VARCHAR(150) NOT NULL,
    student_number VARCHAR(50) UNIQUE,
    gender         ENUM('male', 'female') DEFAULT 'male',
    birth_date     DATE NULL,
    phone          VARCHAR(20) NULL,
    parent_name    VARCHAR(150) NULL,
    parent_phone   VARCHAR(20) NULL,
    address        TEXT NULL,
    status         TINYINT(1) DEFAULT 1,
    created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_students_classroom
        FOREIGN KEY (classroom_id) REFERENCES classrooms (id)
            ON DELETE CASCADE
);


CREATE TABLE attendance
(
    id              INT AUTO_INCREMENT PRIMARY KEY,
    student_id      INT  NOT NULL,
    classroom_id    INT  NOT NULL,
    attendance_date DATE NOT NULL,
    status          ENUM('present', 'absent', 'late', 'excused') NOT NULL DEFAULT 'present',
    notes           TEXT NULL,
    recorded_by     INT NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_attendance_student
        FOREIGN KEY (student_id) REFERENCES students (id)
            ON DELETE CASCADE,
    CONSTRAINT fk_attendance_classroom
        FOREIGN KEY (classroom_id) REFERENCES classrooms (id)
            ON DELETE CASCADE,
    CONSTRAINT fk_attendance_user
        FOREIGN KEY (recorded_by) REFERENCES users (id)
            ON DELETE SET NULL
);

ALTER TABLE attendance
    ADD CONSTRAINT unique_student_attendance_per_day
        UNIQUE (student_id, attendance_date);

CREATE TABLE settings
(
    id            INT AUTO_INCREMENT PRIMARY KEY,
    setting_key   VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT NULL
);



-- أولًا: أمثلة المستخدمين
INSERT INTO users (full_name, username, email, password, role, status, created_at) VALUES
('Saad Aldosaeri', 'saad', 'saad@hodoor.com', '123456', 'admin', 1, '2026-04-01 08:00:00'),
('Ahmed Ali', 'ahmed', 'ahmed@hodoor.com', '123456', 'teacher', 1, '2026-04-01 08:10:00'),
('Faisal Salem', 'faisal', 'faisal@hodoor.com', '123456', 'teacher', 1, '2026-04-01 08:20:00'),
('Nasser Mohammed', 'nasser', 'nasser@hodoor.com', '123456', 'supervisor', 1, '2026-04-01 08:30:00'),
('Khalid Abdullah', 'khalid', 'khalid@hodoor.com', '123456', 'teacher', 1, '2026-04-01 08:40:00'),
('Mona Ibrahim', 'mona', 'mona@hodoor.com', '123456', 'teacher', 1, '2026-04-01 08:50:00'),
('Sara Hassan', 'sara', 'sara@hodoor.com', '123456', 'supervisor', 1, '2026-04-01 09:00:00'),
('Yousef Ahmad', 'yousef', 'yousef@hodoor.com', '123456', 'teacher', 1, '2026-04-01 09:10:00'),
('Abeer Saleh', 'abeer', 'abeer@hodoor.com', '123456', 'teacher', 0, '2026-04-01 09:20:00'),
('Turki Rashid', 'turki', 'turki@hodoor.com', '123456', 'admin', 1, '2026-04-01 09:30:00');


-- ثانيًا: أمثلة الفصول
INSERT INTO classrooms (class_name, class_code, level_name, created_at) VALUES
('الصف الأول أ', 'A-101', 'ابتدائي', '2026-04-02 07:00:00'),
('الصف الأول ب', 'A-102', 'ابتدائي', '2026-04-02 07:05:00'),
('الصف الثاني أ', 'A-201', 'ابتدائي', '2026-04-02 07:10:00'),
('الصف الثاني ب', 'A-202', 'ابتدائي', '2026-04-02 07:15:00'),
('الصف الثالث أ', 'A-301', 'ابتدائي', '2026-04-02 07:20:00'),
('الصف الرابع أ', 'A-401', 'ابتدائي', '2026-04-02 07:25:00'),
('الصف الخامس أ', 'A-501', 'ابتدائي', '2026-04-02 07:30:00'),
('الصف السادس أ', 'A-601', 'ابتدائي', '2026-04-02 07:35:00'),
('الأول متوسط أ', 'M-101', 'متوسط', '2026-04-02 07:40:00'),
('الثاني متوسط أ', 'M-201', 'متوسط', '2026-04-02 07:45:00'),
('الثالث متوسط أ', 'M-301', 'متوسط', '2026-04-02 07:50:00'),
('الأول ثانوي أ', 'S-101', 'ثانوي', '2026-04-02 07:55:00');


-- ثالثًا: أمثلة الطلاب
-- سأربطهم مع الفصول حسب classroom_id من 1 إلى 12.

INSERT INTO students (
    classroom_id, student_name, student_number, gender, birth_date, phone,
    parent_name, parent_phone, address, status, created_at
) VALUES
(1, 'محمد أحمد', 'STU001', 'male', '2018-01-10', '0500000001', 'أحمد محمد', '0551000001', 'الرياض - حي النزهة', 1, '2026-04-03 08:00:00'),
(1, 'خالد سعد', 'STU002', 'male', '2018-02-15', '0500000002', 'سعد خالد', '0551000002', 'الرياض - حي اليرموك', 1, '2026-04-03 08:05:00'),
(1, 'عبدالله ناصر', 'STU003', 'male', '2018-03-20', '0500000003', 'ناصر عبدالله', '0551000003', 'الرياض - حي الحمراء', 1, '2026-04-03 08:10:00'),
(2, 'سارة علي', 'STU004', 'female', '2018-01-25', '0500000004', 'علي حسن', '0551000004', 'الرياض - حي الروضة', 1, '2026-04-03 08:15:00'),
(2, 'ريم فهد', 'STU005', 'female', '2018-04-11', '0500000005', 'فهد سالم', '0551000005', 'الرياض - حي الخليج', 1, '2026-04-03 08:20:00'),
(2, 'جود خالد', 'STU006', 'female', '2018-05-12', '0500000006', 'خالد راشد', '0551000006', 'الرياض - حي المونسية', 1, '2026-04-03 08:25:00'),
(3, 'تركي عبدالله', 'STU007', 'male', '2017-02-10', '0500000007', 'عبدالله تركي', '0551000007', 'الرياض - حي الفلاح', 1, '2026-04-03 08:30:00'),
(3, 'أنس صالح', 'STU008', 'male', '2017-06-18', '0500000008', 'صالح أنس', '0551000008', 'الرياض - حي قرطبة', 1, '2026-04-03 08:35:00'),
(3, 'مازن يوسف', 'STU009', 'male', '2017-07-07', '0500000009', 'يوسف مازن', '0551000009', 'الرياض - حي الورود', 1, '2026-04-03 08:40:00'),
(4, 'لين محمد', 'STU010', 'female', '2017-03-09', '0500000010', 'محمد خالد', '0551000010', 'الرياض - حي الرمال', 1, '2026-04-03 08:45:00'),
(4, 'نوف إبراهيم', 'STU011', 'female', '2017-04-14', '0500000011', 'إبراهيم سالم', '0551000011', 'الرياض - حي لبن', 1, '2026-04-03 08:50:00'),
(4, 'هيا منصور', 'STU012', 'female', '2017-09-22', '0500000012', 'منصور هيا', '0551000012', 'الرياض - حي الشفا', 1, '2026-04-03 08:55:00'),
(5, 'فهد ناصر', 'STU013', 'male', '2016-01-12', '0500000013', 'ناصر فهد', '0551000013', 'الرياض - حي السويدي', 1, '2026-04-03 09:00:00'),
(5, 'سلمان راشد', 'STU014', 'male', '2016-05-01', '0500000014', 'راشد سلمان', '0551000014', 'الرياض - حي العقيق', 1, '2026-04-03 09:05:00'),
(5, 'زيد حمد', 'STU015', 'male', '2016-08-19', '0500000015', 'حمد زيد', '0551000015', 'الرياض - حي الياسمين', 1, '2026-04-03 09:10:00'),
(6, 'رهف أحمد', 'STU016', 'female', '2016-02-17', '0500000016', 'أحمد رهف', '0551000016', 'الرياض - حي الصحافة', 1, '2026-04-03 09:15:00'),
(6, 'دانا صالح', 'STU017', 'female', '2016-03-21', '0500000017', 'صالح دانا', '0551000017', 'الرياض - حي التعاون', 1, '2026-04-03 09:20:00'),
(6, 'أريج خالد', 'STU018', 'female', '2016-10-05', '0500000018', 'خالد أريج', '0551000018', 'الرياض - حي الندى', 1, '2026-04-03 09:25:00'),
(7, 'مشعل علي', 'STU019', 'male', '2015-01-03', '0500000019', 'علي مشعل', '0551000019', 'الرياض - حي المروج', 1, '2026-04-03 09:30:00'),
(7, 'بدر فهد', 'STU020', 'male', '2015-02-08', '0500000020', 'فهد بدر', '0551000020', 'الرياض - حي السلي', 1, '2026-04-03 09:35:00'),
(8, 'لمياء يوسف', 'STU021', 'female', '2015-06-06', '0500000021', 'يوسف لمياء', '0551000021', 'الرياض - حي طويق', 1, '2026-04-03 09:40:00'),
(8, 'شهد ناصر', 'STU022', 'female', '2015-07-11', '0500000022', 'ناصر شهد', '0551000022', 'الرياض - حي بدر', 1, '2026-04-03 09:45:00'),
(9, 'عبدالرحمن عادل', 'STU023', 'male', '2014-01-10', '0500000023', 'عادل عبدالرحمن', '0551000023', 'الرياض - حي الربوة', 1, '2026-04-03 09:50:00'),
(9, 'حاتم سامي', 'STU024', 'male', '2014-03-15', '0500000024', 'سامي حاتم', '0551000024', 'الرياض - حي الملقا', 1, '2026-04-03 09:55:00'),
(10, 'رغد إبراهيم', 'STU025', 'female', '2013-05-18', '0500000025', 'إبراهيم رغد', '0551000025', 'الرياض - حي النرجس', 1, '2026-04-03 10:00:00'),
(10, 'مي عبدالعزيز', 'STU026', 'female', '2013-08-01', '0500000026', 'عبدالعزيز مي', '0551000026', 'الرياض - حي القيروان', 1, '2026-04-03 10:05:00'),
(11, 'أيمن خالد', 'STU027', 'male', '2012-02-12', '0500000027', 'خالد أيمن', '0551000027', 'الرياض - حي الملقا', 1, '2026-04-03 10:10:00'),
(11, 'حسن راكان', 'STU028', 'male', '2012-09-19', '0500000028', 'راكان حسن', '0551000028', 'الرياض - حي الغدير', 1, '2026-04-03 10:15:00'),
(12, 'تركي فيصل', 'STU029', 'male', '2011-04-14', '0500000029', 'فيصل تركي', '0551000029', 'الرياض - حي العليا', 1, '2026-04-03 10:20:00'),
(12, 'لجين ماجد', 'STU030', 'female', '2011-11-23', '0500000030', 'ماجد لجين', '0551000030', 'الرياض - حي المصيف', 1, '2026-04-03 10:25:00');



-- رابعًا: أوامر حذف البيانات التجريبية
-- حذف الطلاب
DELETE FROM students;

-- حذف الفصول
DELETE FROM classrooms;

-- حذف المستخدمين
DELETE FROM users;

-- خامسًا: إعادة العدادات من 1

-
- إذا تريد تبدأ الترقيم من جديد:

ALTER TABLE users AUTO_INCREMENT = 1;
ALTER TABLE classrooms AUTO_INCREMENT = 1;
ALTER TABLE students AUTO_INCREMENT = 1;

-- سادسًا: نسخة أسرع لو تريد مسح الكل دفعة واحدة
DELETE FROM students;
DELETE FROM classrooms;
DELETE FROM users;

ALTER TABLE students AUTO_INCREMENT = 1;
ALTER TABLE classrooms AUTO_INCREMENT = 1;
ALTER TABLE users AUTO_INCREMENT = 1;

-- سابعًا: أوامر مفيدة للفحص

-- عرض كل المستخدمين
SELECT * FROM users;

-- عرض كل الفصول
SELECT * FROM classrooms;

-- عرض كل الطلاب
SELECT * FROM students;

-- عرض الطلاب مع اسم الفصل
SELECT students.*, classrooms.class_name
FROM students
         LEFT JOIN classrooms ON classrooms.id = students.classroom_id;

-- عدد المستخدمين
SELECT COUNT(*) AS total_users FROM users;

-- عدد الفصول
SELECT COUNT(*) AS total_classrooms FROM classrooms;

-- عدد الطلاب
SELECT COUNT(*) AS total_students FROM students;

-- ثامنًا: إدخال مدير واحد فقط بشكل سريع
INSERT INTO users (full_name, username, email, password, role, status, created_at)
VALUES ('System Admin', 'admin', 'admin@hodoor.com', '123456', 'admin', 1, NOW());

-- تاسعًا: إدخال فصل واحد فقط بشكل سريع
INSERT INTO classrooms (class_name, class_code, level_name, created_at)
VALUES ('الصف الأول أ', 'A-101', 'ابتدائي', NOW());

-- عاشرًا: إدخال طالب واحد فقط بشكل سريع
INSERT INTO students (
    classroom_id, student_name, student_number, gender, birth_date, phone,
    parent_name, parent_phone, address, status, created_at
)
VALUES (
    1, 'محمد أحمد', 'STU001', 'male', '2018-01-10', '0500000001',
    'أحمد محمد', '0551000001', 'الرياض - حي النزهة', 1, NOW()
);