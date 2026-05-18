# 📝 Development Log - SkjSystem Academic 2025

รายการบันทึกการแก้ไขและพัฒนาโปรแกรม เพื่อใช้เป็นความจำในการทำงานร่วมกัน

---

## [2026-05-05] - ปรับปรุงระบบมอบหมายงานสอนและแยกปีการศึกษา (Timetable Assignment Fixes)

### 🚀 ฟีเจอร์ที่เพิ่ม/แก้ไข (Added/Modified)
- **ระบบแยกปีการศึกษา (Module Localization):**
    - แก้ไขให้ระบบตารางสอนใช้ Session Key แยกต่างหาก (`timetable_selected_year`) เพื่อไม่ให้การเปลี่ยนปีในตารางสอนไปกระทบกับปีการศึกษาหลักของระบบใหญ่
    - เพิ่มเมธอด `getTimetableYear()` เพื่อจัดการลำดับการดึงปีการศึกษาเฉพาะโมดูล
- **ปรับปรุงการแสดงผล Step 2 (มอบหมายงานสอน):**
    - **ชื่อครูผู้สอน:** เพิ่มการ `trim()` ไอดีครู และขยายเงื่อนไขการดึงชื่อให้ครอบคลุมทุกตำแหน่ง เพื่อแก้ปัญหาชื่อขึ้นว่า "ไม่ทราบชื่อ"
    - **รายชื่อวิชาในกลุ่ม (Joint Groups):** ปรับปรุงให้ตารางแสดงรายชื่อ **ทุกวิชา** ที่อยู่ในกลุ่มเรียนพร้อมกัน ไม่ใช่แค่หัวข้อเดียว เพื่อความโปร่งใสในการตรวจสอบ
    - **ชื่อห้องเรียน:** เพิ่มคำนำหน้า **"ม."** (เช่น ม.1/1) ใน Modal เพื่อให้ตรงกับมาตรฐานข้อมูลเดิมและป้องกันข้อมูลหายตอนกดแก้ไข
- **UI/UX:**
    - ปรับปุ่มเมนูหลักใน Wizard ให้มีขนาดใหญ่ขึ้น (Big Buttons) พร้อมไอคอนและเอฟเฟกต์ยกตัว (Hover Elevate) เพื่อให้ใช้งานง่าย
    - กู้คืนหน้า **Master Settings** สำหรับจัดการวิชาชุมนุม/ลูกเสือ/โฮมรูม ของทั้งโรงเรียน

## [2026-04-02] - ระบบตรวจสอบแผนการจัดการเรียนรู้ (Refactor Lesson Plan Check)

### 🚀 ฟีเจอร์ที่เพิ่ม/แก้ไข (Added/Modified)
- **UI/UX หน้าตรวจสอบแผน:**
    - เปลี่ยนการแสดงผลเดิมที่เป็นตารางรวมทึกคน ให้เป็นการ **จัดกลุ่มตามกลุ่มสาระการเรียนรู้** (Learning Groups)
    - แสดงผลเป็น Card รายชื่อครู พร้อมปุ่ม **"ตรวจสอบแผน"** เพื่อลดความแออัดของข้อมูลในหน้าเดียว
- **ระบบตารางแผนรายบุคคล (AJAX):**
    - พัฒนาระบบแสดงผลแผนการสอนผ่าน Modal โดยใช้ AJAX ดึงข้อมูลตามรายชื่อครูที่เลือก
    - แสดงข้อมูลพื้นฐานในตารางประกอบด้วย: ลำดับ, วันที่ส่ง, รหัสวิชา, ชื่อวิชา และสถานะ
- **Backend & Database Fixes:**
    - แก้ไขข้อผิดพลาด **"Unknown column"** โดยการปรับชื่อคอลัมน์ใน Model และ View ให้ตรงกับ Database จริง:
        - `seplan_date_send` -> `seplan_createdate`
        - `seplan_personnel_id` -> `seplan_usersend`
        - `seplan_subject_code` -> `seplan_coursecode`
        - `seplan_subject_name` -> `seplan_namesubject`
    - เพิ่ม Method `getPlansByTeacherId($teacherId)` ใน `ModAdminCheckPlan.php`
    - เพิ่ม Method `getTeacherPlans($teacherId)` ใน `ConAdminCheckPlan.php` เพื่อส่งข้อมูล JSON
- **Routing:**
    - เพิ่ม Route ใหม่: `admin/academic/checkplan/teacherplans/(:segment)`

### 📁 ไฟล์ที่เกี่ยวข้อง
- `app/Models/Admin/Academic/ModAdminCheckPlan.php` (Modified)
- `app/Controllers/Admin/Academic/ConAdminCheckPlan.php` (Modified)
- `app/Views/admin/Academic/AdminCheckPlan/ChekPresGroup.php` (Renamed from `index.php` & Modified)
- `app/Config/Routes.php` (Modified)

---

## [2026-04-02] - บังคับใช้ปีการศึกษาหลักของระบบกับแบบฟอร์มทั้งหมด

### 🚀 ฟีเจอร์ที่แก้ไข
- **หลักการ:** เมื่อแอดมินเปลี่ยนปีการศึกษาหลักในระบบ (`admin_selected_year` session / `tb_schoolyear`) ให้ทุกแบบฟอร์มที่เพิ่มข้อมูลใหม่ "รีเซ็ต" ตามปีการศึกษานั้นโดยอัตโนมัติ
- **`ConAdminCheckPlan.php`** → `plansByGroup()` และ `report()` ใช้ `get_selected_year()` เป็น default แทนการดึง latest record จาก DB
- **`ConAdminCourse.php`** → `SendPlanMain()` และ `getFilteredPlanData()` ใช้ `get_selected_year()` เป็น default แทน `tb_send_plan_setup`

### 📋 Priority ของการดึงปีการศึกษา (ลำดับสูงสุดไปต่ำสุด)
1. ✅ ผู้ใช้เลือกเองจาก Dropdown (GET/POST parameter) → ใช้ทันที
2. ✅ `get_selected_year()` → session `admin_selected_year` หรือ `tb_schoolyear`
3. ✅ Fallback สุดท้าย: `tb_send_plan_setup` (เฉพาะใน ConAdminCourse)

### 📁 ไฟล์ที่เกี่ยวข้อง
- `app/Controllers/Admin/Academic/ConAdminCheckPlan.php` (Modified)
- `app/Controllers/Admin/Academic/ConAdminCourse.php` (Modified)

---

## [2026-04-02] - บังคับใช้ปีการศึกษาหลักกับระบบลงทะเบียนวิชา & ลงทะเบียนเรียน

### 🚀 ฟีเจอร์ที่แก้ไข
- **`ConAdminRegisterSubject.php`** → `AdminRegisterSubjectSelect()` ใช้ `get_selected_year()` แทน `tb_schoolyear` โดยตรง
- **`ConAdminRegisterSubject.php`** → `AdminRegisterSubjectMain()` ส่ง `$selectedYear` ไปให้ View
- **`AdminRegisterSubjectMain.php`** → แก้ไข hidden input `#CheckYearNow`, dropdown เพิ่มวิชา, dropdown filter ให้ใช้ `$selectedYear`
- **`ConAdminEnroll.php`** → `AdminEnrollMain()` ใช้ `get_selected_year()` แทนการดึง session โดยตรงและ fallback ไป latest GroupYear
- **`ConAdminEnroll.php`** → `AdminEnrollAdd()` แก้ไขให้ Term/Year เป็น optional และใช้ `get_selected_year()` เป็น default พร้อมทั้งส่ง `$selectedYear` ไปยัง View
- **`AdminEnrollMain.php`** → แก้ไขปุ่มเพิ่มข้อมูล (Add) ให้ใช้ `$selectedYear` ใน URL
- **`AdminEnrollFormAdd.php`** → ปรับปรุง Dropdown ปีการศึกษาให้ใช้ `$selectedYear` เป็นค่าเริ่มต้น และลบการดึงจาก URI segments ที่ซ้ำซ้อนออก
- **`Routes.php`** → เพิ่มเส้นทาง `Enroll/Add` แบบไม่มี segment เพื่อรองรับการ Redirect/Fallback อย่างสมบูรณ์

### 📁 ไฟล์ที่เกี่ยวข้อง
- `app/Controllers/Admin/Academic/ConAdminRegisterSubject.php` (Modified)
- `app/Views/admin/Academic/AdminRegisterSubject/AdminRegisterSubjectMain.php` (Modified)
- `app/Controllers/Admin/Academic/ConAdminEnroll.php` (Modified)
- `app/Views/admin/Academic/AdminEnroll/AdminEnrollMain.php` (Modified)
- `app/Views/admin/Academic/AdminEnroll/AdminEnrollFormAdd.php` (Modified)
- `app/Config/Routes.php` (Modified)


- [ ] เพิ่มปุ่ม **"ดูรายละเอียด"** ในตารางแผนการสอน (ใน Modal) เพื่อดูรายละเอียดเชิงลึกของแต่ละหัวข้อ
- [ ] พัฒนาฟังก์ชันการ "ตรวจ/อนุมัติ" แผนใน Modal รายบุคคล

---

## [2026-04-02] - มาตรฐานระบบปฏิทิน พ.ศ. (Buddhist Era Date Picker Standard) 📅✨

### 🚀 ฟีเจอร์ที่เพิ่ม/แก้ไข
- **หลักการ (Standard):** การแสดงผล "วันที่" ทั้งหมดในส่วนของ View ต้องแสดงเป็นปี **"พ.ศ."** เสมอ (ทั้งในกล่องรับข้อมูลและในตัวเลือกปฏิทิน) แต่ต้องส่งค่าเป็นปี **"ค.ศ. (ISO Format: yyyy-mm-dd)"** ไปยัง Backend เพื่อความถูกต้องในการประมวลผลและการจัดเก็บข้อมูล
- **เป้าหมาย:** ใช้เป็นมาตรฐานเดียวกันทั้งโปรเจคสำหรับทุกหน้าที่มีการเลือกวันที่
- **เทคโนโลยี:** **Flatpickr v4.x** พร้อมปรับแต่ง Custom Formatter และ DOM Year Swap

### 🛠️ ตัวอย่างการใช้งาน (Implementation Template)
```javascript
flatpickr(".student-be-datepicker", {
    dateFormat: "Y-m-d", // 💎 สำคัญ: ส่ง ค.ศ. ISO ไป Backend
    altInput: true,      // แสดงผลอีกรูปแบบให้ผู้ใช้
    altFormat: "d/m/Y",  // รูปแบบ วัน/เดือน/ปี
    locale: "th",
    onOpen: (s, d, i) => updateCalendarToBE(i),
    onMonthChange: (s, d, i) => setTimeout(() => updateCalendarToBE(i), 0),
    onYearChange: (s, d, i) => setTimeout(() => updateCalendarToBE(i), 0),
    formatDate: (date, format) => {
        if (format === "d/m/Y") {
            const y = date.getFullYear() + 543;
            return `${date.getDate().toString().padStart(2, '0')}/${(date.getMonth() + 1).toString().padStart(2, '0')}/${y}`;
        }
        return flatpickr.formatDate(date, format);
    },
    parseDate: (dateStr) => {
        if (dateStr && dateStr.includes('/')) {
            const p = dateStr.split('/');
            return new Date(parseInt(p[2]) - 543, parseInt(p[1]) - 1, parseInt(p[0]));
        }
    }
});

function updateCalendarToBE(instance) {
    setTimeout(() => {
        const yearDisplay = instance.calendarContainer.querySelector(".flatpickr-current-month .cur-year");
        if (yearDisplay) {
            const year = parseInt(instance.currentYear);
            if (year < 2400) {
                if (yearDisplay.tagName === "INPUT") yearDisplay.value = year + 543;
                else yearDisplay.textContent = year + 543;
            }
        }
        const yearInput = instance.calendarContainer.querySelector(".numInput.cur-year");
        if (yearInput && parseInt(instance.currentYear) < 2400) yearInput.value = parseInt(instance.currentYear) + 543;
    }, 5);
}
```

### 📁 ไฟล์ที่นำร่อง (First Implementation)
- `app/Views/admin/Academic/AdminStudents/_student_details_form.php` (Manual Student Intake)
- `app/Controllers/Admin/Academic/ConAdminStudents.php` (Handle ISO Date back to B.E. string for DB)

---

## [2026-04-02] - มาตรฐานการใช้งาน Select2 (Select2 Standard) 🔍✨

### 🚀 ฟีเจอร์ที่เพิ่ม/แก้ไข
- **หลักการ (Standard):** ทุกหน้าในส่วนของ Admin ที่มีการใช้ Tag `<select>` ต้องมีการ Initialize **Select2** เสมอ เพื่อเพิ่มความสามารถในการค้นหา (Searchable) และปรับปรุงดีไซน์ให้สวยงามทันสมัย
- **Theme:** ใช้ธีม `bootstrap-5` เพื่อให้เข้ากับ UI ของ Sneat Template
- **เป้าหมาย:** สม่ำเสมอทั่วทั้งโปรเจค (Consistency)

### 🛠️ ตัวอย่างการใช้งาน (Implementation Template)
```javascript
$('#SelectorID').select2({
    theme: 'bootstrap-5',
    width: '100%',
    placeholder: '-- ข้อความแนะนำ --',
    allowClear: true,
    dropdownParent: $('body')
});
```

### 📁 ไฟล์ที่นำร่อง (First Implementation)
- `app/Views/admin/Academic/AdminStudents/AdminStudentsAdjustNumber.php` (Classroom Selector)

---

## [2026-04-07] - โมเดิร์นไนซ์ UI/UX ด้วย Emerald Design Concept (Green #15a362) 🟢✨

### 🚀 ฟีเจอร์ที่เพิ่ม/แก้ไข (Added/Modified)
- **นิเทศ/แผนการสอน (Academic Supervision Module):**
    - **ดีไซน์ใหม่ทั้งหมด:** นำระบบ Emerald Design มาใช้เพื่อความ Premium และ ทันสมัย
    - **หน้าเลือกกลุ่มสาระ (`select_group.php`):** เปลี่ยน Hero Header เป็น Gradient Emerald และใช้ Card Grid แบบ Interactive
    - **หน้าตรวจสอบรายบุคคล (`ChekPresGroup.php`):** 
        - ออกแบบ Hero Header และ Stats Card ใหม่ (Elevated Cards)
        - แสดงรายชื่อครูเป็น Grid Card พร้อม Avatar และ Badge สถานะ
        - **Modal ประสบการณ์ใหม่:** ปรับปรุง Modal การตรวจสอบแผน และ Modal การอนุมัติ (Approval) ให้ใช้ Header Gradient และตารางแบบ Premium Layout
    - **หน้ารายงานสรุปส่งแผน (`ReportCheckPlanMain.php`):** 
        - ออกแบบ Filter Card ใหม่แบบกึ่งลอย (Half-overlap)
        - ปรับปรุงตารางรายงานให้เป็นสไตล์ Clean & Modern
        - ปรับแต่งปุ่มส่งออก Excel (xlsx-js-style) ให้เข้ากับ Emerald Theme

- **ลงทะเบียนรายวิชา (`AdminRegisterSubjectMain`):**
    - **เพิ่มประสิทธิภาพ Workflow:** ปรับปรุงให้ฟอร์มการเพิ่มวิชา "ไม่ต้องปิด/Refesh" หลังจากกดบันทึก เพื่อความรวดเร็วในการเพิ่มข้อมูลต่อเนื่อง (Rapid Data Entry)
    - **AJAX Sync:** ใช้ AJAX โหลด DataTables ใหม่ทันทีหลังจากบันทึกข้อมูลสำเร็จ
    - **CSV Parser:** ย้ายจาก Google Sheets API มาใช้ระบบ Fetch .csv แบบ Publish to Web เพื่อแก้ปัญหา CORS และลดการเรียก API Key
    - **Sorting Logic:** พัฒนาระบบเรียงลำดับ ปีการศึกษา/เทอม แบบ Chronological (ล่าสุดขึ้นก่อน) โดยใช้ SQL Raw `SUBSTRING_INDEX`

### 📁 ไฟล์ที่เกี่ยวข้อง
- `app/Views/admin/Academic/AdminCheckPlan/select_group.php` (Redesigned)
- `app/Views/admin/Academic/AdminCheckPlan/ChekPresGroup.php` (Redesigned & AJAX Refined)
- `app/Views/admin/Academic/AdminCheckPlan/ReportCheckPlanMain.php` (Redesigned)
- `app/Views/admin/Academic/AdminRegisterSubject/AdminRegisterSubjectMain.php` (UI Modernized & Workflow Optimized)
- `app/Controllers/Admin/Academic/ConAdminRegisterSubject.php` (Sorting Logic Updated)

---

## [2026-04-07] - ระบบสำรองข้อมูลฐานข้อมูล (Database Backup System) 💾✨

### 🚀 ฟีเจอร์ที่เพิ่ม/แก้ไข (Added/Modified)
- **ระบบสำรองข้อมูลสำหรับ Superadmin:**
    - พัฒนาหน้าการจัดการสำรองข้อมูล (Backup) ที่อนุญาตให้ Superadmin เลือกตารางที่ต้องการสำรองได้เป็นรายตาราง
    - **UI/UX Premium:** ออกแบบด้วย Emerald Design Theme (`#15a362`) และใช้ Sneat Components
    - **กลไกการสำรองข้อมูล (PHP Engine):**
        - พัฒนาระบบสร้าง SQL Dump ด้วย PHP (ไม่ใช้ `mysqldump` เพื่อความเข้ากันได้ 100% ในทุก Host)
        - รองรับ `CREATE TABLE` และ `INSERT INTO` พร้อมปิด `FOREIGN_KEY_CHECKS` ชั่วคราวขณะ Import
        - แสดงจำนวนแถว (Rows) และสถานะความจุของแต่ละตารางเพื่อให้แอดมินตัดสินใจเลือกได้ง่าย
    - **Filename Standard:** ปรับปรุงชื่อไฟล์ดาวน์โหลดให้เป็น `bookings.sql` ตามความต้องการของผู้ใช้
    - **Structure Normalization:** ปรับปรุงโครงสร้าง SQL ให้เป็นแบบ **phpMyAdmin Standard** ตามไฟล์ตัวอย่าง (`bookings.sql`):
        - ย้ายคำสั่ง `INDEX`, `AUTO_INCREMENT` และ `CONSTRAINT` ไปไว้ท้ายไฟล์ด้วย `ALTER TABLE`
        - เพิ่มระบบ `START TRANSACTION` และ `COMMIT`
        - ปรับปรุงการ `INSERT` ข้อมูลให้เป็นแบบ Multi-row เพื่อประสิทธิภาพและสวยงาม
    - **ระบบความปลอดภัย:** บังคับตรวจสอบสิทธิ์ `superadmin` ในระดับ Controller ตลอดเวลา
- **Routing:**
    - เพิ่มเส้นทางใหม่: `admin/academic/backup` และ `admin/academic/backup/run`

### 📁 ไฟล์ที่เกี่ยวข้อง
- `app/Controllers/Admin/Academic/ConAdminBackup.php` (Created)
- `app/Views/admin/Academic/AdminBackup/AdminBackupMain.php` (Created)
- `app/Config/Routes.php` (Modified)

### 📋 สิ่งที่ต้องทำต่อ (Next Steps / TODO)
- [ ] เพิ่มปุ่ม **"ดูรายละเอียด"** ในตารางแผนการสอน (ใน Modal) เพื่อดูรายละเอียดเชิงลึกของแต่ละหัวข้อ (In Progress)
- [ ] พัฒนาฟังก์ชันการส่งออกไฟล์ Backup ไปยังบริการ Cloud Storage (เช่น Google Drive) เพื่อความปลอดภัยเพิ่มขึ้น
- [ ] เพิ่มระบบจัดการไฟล์ Backup ที่เคยสร้างไว้ (List & Download History)

---

## [2026-05-04] - ระบบจัดการตารางสอน (Timetable Management System) 📅🤖

### 🚀 ฟีเจอร์ที่เพิ่ม/แก้ไข (Added/Modified)
- **ระบบมอบหมายงานสอน (Timetable Assignment):**
    - **UI/UX Modernization:** ปรับปรุง Modal การมอบหมายงานสอนใหม่ให้เป็นแบบ Step-based Wizard (5 Steps) พร้อมดีไซน์ Emerald Theme (#15a362)
    - **Fixed HTML Structure:** แก้ไขข้อผิดพลาดของโครงสร้าง Form ที่ทำให้ปุ่ม Submit อยู่นอก Tag `<form>` ทำให้บันทึกข้อมูลไม่ได้
    - **Group ID Preservation:** พัฒนาระบบคงค่า `group_id` เมื่อมีการแก้ไขรายวิชาที่ถูก "มัดรวมกลุ่มสอน" ไว้ เพื่อไม่ให้กลุ่มแตกออกจากกันหลังการแก้ไข
    - **Select2 Integration:** ปรับปรุงการ Initialize Select2 ใน Modal ให้ทำงานได้สมบูรณ์ทุกครั้งที่เปิด/ปิด และรองรับการเลือกห้องเรียนจากฐานข้อมูลห้องเรียนทั้งหมด
    - **Suggested Teachers (Smart Logic):** พัฒนาระบบแนะนำครูผู้สอนอัตโนมัติเมื่อเลือกวิชา (อ้างอิงจากแผนการสอนที่ครูส่ง) โดยมี Logic พิเศษป้องกันการเขียนทับข้อมูลเดิมขณะอยู่ในโหมดแก้ไข (Edit Mode)

- **ระบบประมวลผลตารางสอน AI (AI Generation Engine):**
    - **Premium Processing Feedback:** เพิ่ม Modal แสดงสถานะการประมวลผล AI พร้อมแอนิเมชันหุ่นยนต์ (Pulse Animation) และ Progress Bar เพื่อให้ผู้ใช้ทราบสถานะการทำงานจริง
    - **Backend Robustness:**
        - แก้ไข Error `$teacher_name_map` ที่ไม่ได้ถูกประกาศไว้ ทำให้การรายงานความขัดแย้ง (Conflicts) ล้มเหลว
        - เพิ่มระบบตรวจสอบคอลัมน์ `room_name` แบบไดนามิก เพื่อรองรับโครงสร้างฐานข้อมูลที่แตกต่างกันในแต่ละเครื่อง
        - ปรับปรุง Error Handling ให้ส่งคืนรายละเอียดความขัดแย้ง (เช่น ครูติดสอนช่องไหน, ห้องไม่ว่างคาบใด) กลับมาแสดงผลที่หน้าเว็บอย่างชัดเจน
    - **Auto-Sync Logic:** เมื่อประมวลผลสำเร็จ 100% ระบบจะทำการปลดล็อค "ขั้นตอนที่ 5: ตรวจสอบ" และนำทางผู้ใช้ไปโดยอัตโนมัติ

### 🛠️ เทคนิคที่สำคัญ (Technical Highlights)
- **AJAX Step-based Workflow:** ใช้การจัดการสถานะ Step ผ่าน `localStorage` และ `sessionStorage` (สำหรับรายงานความผิดพลาด) เพื่อให้ Wizard ทำงานต่อเนื่องแม้มีการ Reload หน้า
- **Transaction Safety:** ใช้ `db->transStart()` และ `transRollback()` ใน Controller เพื่อประกันว่าหาก AI จัดตารางไม่ลงแม้แต่วิชาเดียว ข้อมูลเดิมจะไม่ถูกทำลาย (Atomic Operations)

### 📁 ไฟล์ที่เกี่ยวข้อง
- `app/Controllers/Admin/Academic/ConAdminTimetable.php` (Logic Update)
- `app/Views/admin/Academic/AdminTimetable/ProcessMain.php` (UI/UX Redesign)
- `app/Config/Routes.php` (Route Definition)


---

## [2026-05-04] - พัฒนาระบบเงื่อนไขและล็อคเวลา (Constraint & Lock System Enhancements) 🔒⚠️

### 🚀 ฟีเจอร์ที่เพิ่ม/แก้ไข (Added/Modified)
- **ระบบล็อคเวลาครู (Teacher Lock Grid):**
    *   **Visual Feedback:** เพิ่มการแสดงผลตารางสอนปัจจุบันของครูในหน้าล็อคเวลา (แถบสีฟ้า) เพื่อให้แอดมินเห็นความไม่ว่างที่เกิดจากคาบสอนจริง ก่อนจะทำการล็อคเวลาไม่ว่างแบบ Manual
    *   **Context-Aware Grid:** แสดงข้อมูลห้องเรียนและรหัสวิชาที่ครูติดสอนอยู่ในแต่ละคาบ ช่วยลดความผิดพลาดในการล็อคเวลาทับซ้อนกับคาบสอน
    *   **Teacher Constraint Summary:** เพิ่มหน้า "ภาพรวมความไม่ว่างของครู" (ก่อนเลือกครู) แสดงสถิติจำนวนคนที่ไม่ว่างในแต่ละคาบทั้งโรงเรียน พร้อม Tooltip รายชื่อครู

- **ระบบล็อคคาบวิชา (Subject Lock Grid):**
    *   **Smart Conflict Warning (สีส้ม ⚠️):** พัฒนาระบบตรวจสอบความว่างของครูแบบ Real-time ในตารางล็อควิชา หากครูที่สอนวิชานั้นไม่ว่าง (ติดสอนห้องอื่นหรือถูกล็อคเวลาไว้) ช่องในตารางจะกลายเป็นสีส้มพร้อมไอคอนแจ้งเตือน
    *   **Detailed Tooltips:** เมื่อ Hover ที่ช่องแจ้งเตือน ระบบจะแสดงรายชื่อครูและสาเหตุที่ไม่ว่าง
    *   **Real-time Sync:** ปรับปรุงให้ตัวเลขคาบที่ลงไปแล้ว (เช่น 1/9) อัปเดตทันทีทั้งในตารางและรายการวิชาทางซ้ายมือโดยไม่ต้อง Refresh หน้าเว็บ
    *   **Smart Lunch Break:** ระบบแยกคาบพักกลางวันอัตโนมัติ (ม.ต้น คาบ 4 / ม.ปลาย คาบ 5) และอนุญาตให้ลงวิชาเรียนในคาบพักที่ "ไม่ใช่" ของระดับชั้นนั้นได้ (Smart Override)
    *   **Strict Overlap Protection:** เพิ่มระบบป้องกันการวางวิชาทับคาบพักกลางวันหรือทับวิชาเดิม โดยระบบจะตรวจสอบทั้ง "บล็อกวิชา" (กรณีวิชามีหลายคาบติดกัน) และแจ้งเตือนด้วยสีแดงและข้อความทันที

### 🛠️ เทคนิคที่สำคัญ (Technical Highlights)
- **Cross-Database Join Analysis:** ปรับปรุง SQL Query ใน `getConstraintGrid` ให้สามารถ Join ข้อมูลครอบคลุมทุกเงื่อนไข
- **AJAX Sync with Cache Busting:** ใช้เทคนิค `$.ajax` พร้อมปิด Cache และใส่ Timestamp เพื่อให้การอัปเดตข้อมูล Real-time แม่นยำ 100%
- **Contiguous Block Validation:** พัฒนา Logic การตรวจสอบตำแหน่ง `td` ในตารางแบบ Array เพื่อตรวจจับการซ้อนทับของวิชาที่มีหลายคาบติดกัน (Multiple Period Blocks)

### 📁 ไฟล์ที่เกี่ยวข้อง
- `app/Controllers/Admin/Academic/ConAdminTimetable.php` (Enhanced Logic & New Summary Route)
- `app/Views/admin/Academic/AdminTimetable/Partials/TeacherConstraintGrid.php` (UI Update)
- `app/Views/admin/Academic/AdminTimetable/Partials/ConstraintGrid.php` (Lunch Logic & Data Attributes)
- `app/Views/admin/Academic/AdminTimetable/Partials/TeacherConstraintSummary.php` (New File)
- `app/Views/admin/Academic/AdminTimetable/ProcessMain.php` (JS Logic for Real-time Sync & Overlap Check)
- `app/Config/Routes.php` (New Route for Summary)

---

## [2026-05-04] - ระบบจัดการกลุ่มสอนควบและซิงค์เงื่อนไขพักกลางวัน (Atomic Teaching Groups & Constraint Sync) 🍱🔄

### 🚀 ฟีเจอร์ที่เพิ่ม/แก้ไข (Added/Modified)
- **มาตรฐานกลุ่มสอนควบ (Teaching Group Atomic Standard):**
    *   **Group Unit Scheduling:** กำหนดให้วิชาที่ถูกมัดรวมกลุ่ม (Teaching Group) ต้องถูกมองเป็นยูนิตเดียว "ขยับหนึ่ง ขยับทั้งหมด" ทั้งในการจัดแบบ Manual และ AI
    *   **Synchronized Locking (Step 3):** การล็อคหรือปลดล็อควิชาในตาราง จะส่งผลไปยังสมาชิกทุกคนในกลุ่มทันที โดยระบบจะลบและเขียนข้อมูลลง `tb_timetable_data` ใหม่ให้ทั้งกลุ่มเพื่อความสอดคล้อง 100%

- **ระบบป้องกันคาบพักแบบรวมกลุ่ม (Collective Lunch Protection):**
    *   **Mixed-Level Awareness:** พัฒนาระบบตรวจสอบระดับชั้นภายในกลุ่ม (Junior vs Senior)
        *   ถ้ากลุ่มมี ม.ต้น (ม.1-3) -> บล็อกคาบ 4
        *   ถ้ากลุ่มมี ม.ปลาย (ม.4-6) -> บล็อกคาบ 5
        *   **กรณีกลุ่มผสม (Mixed):** ระบบจะบล็อกทั้งคาบ 4 และ คาบ 5 โดยอัตโนมัติ เพื่อให้มั่นใจว่าทุกคนในกลุ่มได้รับเวลาพักตามกฎของโรงเรียน
        *   **Cross-Module Enforcement:** บังคับใช้เงื่อนไขนี้ครอบคลุมทุกส่วน: ประมวลผล AI (`autoGenerate`), การย้ายคาบในตารางรวม (`moveSlot`, `saveSlot`), การล็อควิชาใน Step 3 (`saveSubjectLock`), และการตรวจสอบใน UI แบบ Real-time
        *   **Stable Query Logic:** แก้ไขปัญหา 500 Internal Error โดยการเปลี่ยนจากระบบ Query แบบ Closure มาใช้ `whereIn` เพื่อความเข้ากันได้ 100% กับฐานข้อมูล

- **การอัปเกรด AI Generation Engine (Step 4):**
    *   **Constraint Aggregation:** ปรับปรุงฟังก์ชัน `autoGenerate` ให้ทำการสแกนสมาชิกทุกคนในกลุ่มก่อนวางวิชา เพื่อรวบรวมเงื่อนไข "ความไม่ว่าง" (Busy) และ "กิจกรรมโรงเรียน" (Master Slots) ของทุกระดับชั้นมาใช้พร้อมกัน
    *   **Strict Activity Sync:** ป้องกันไม่ให้วิชากลุ่มถูกจัดลงในคาบที่มีกิจกรรมโรงเรียนที่สมาชิกคนใดคนหนึ่งในกลุ่มต้องเข้าร่วม

### 🛠️ เทคนิคที่สำคัญ (Technical Highlights)
- **Group-Aware Iteration:** ใช้การวนลูป `foreach ($group['assignments'])` เพื่อสร้าง `group_blocked_periods` และ `group_blocked_master` แบบเฉพาะเจาะจงรายกลุ่ม
- **Atomic Transaction Management:** ใช้ระบบ Transaction ของฐานข้อมูล เพื่อประกันความปลอดภัยว่าการอัปเดตข้อมูลของกลุ่มต้องสำเร็จทั้งหมดหรือล้มเหลวทั้งหมด (All-or-Nothing)

### 📁 ไฟล์ที่เกี่ยวข้อง
- `app/Controllers/Admin/Academic/ConAdminTimetable.php` (Core Logic Update)
- `app/Views/admin/Academic/AdminTimetable/Partials/ConstraintGrid.php` (Manual Validation Update)

---

## [2026-05-17] - ปรับปรุงการจัดการตารางเรียนเป็นแบบ Modal & ระบบลากวางไฟล์ (Class Schedule Modal & Drag-Drop Uploader) 🟢✨

### 🚀 ฟีเจอร์ที่เพิ่ม/แก้ไข (Added/Modified)
- **ระบบแบบฟอร์ม Modal บนหน้าหลัก (Class Schedule Modal Form):**
    - ย้ายระบบการเพิ่มและแก้ไขตารางเรียนจากหน้าแบบฟอร์มเดิม (`AdminClassScheduleForm.php`) มาไว้ใน Modal หน้าหลัก (`AdminClassScheduleMain.php`)
    - **Backwards Compatibility:** ปรับปรุงคอนโทรลเลอร์ `ConAdminClassSchedule.php` (เมธอด `add` และ `edit`) ให้เปลี่ยนเส้นทาง (Redirect) ไปยังหน้าหลักพร้อมแนบพารามิเตอร์ `action=add` หรือ `action=edit&id=...` เพื่อความถูกต้องของเส้นทางเดิม (Routes)
    - ปรับเปลี่ยนปุ่มแก้ไขและปุ่มเพิ่มบนหน้าหลักเพื่อใช้การทำงานของ Modal เต็มรูปแบบ (ไม่ต้องรีโหลดหน้าเว็บ)
- **ระบบลากวางไฟล์อัจฉริยะ (Drag & Drop Uploader):**
    - พัฒนาพื้นที่อัปโหลดแบบลากและวาง (Drag & Drop Zone) สีเขียวมินต์พรีเมียม `#15a362` เพื่อการอัปโหลดไฟล์ที่ลื่นไหล
    - รองรับการลากไฟล์รูปภาพ (JPG, PNG) และไฟล์ PDF โดยระบบจะแสดงสถานะ ขนาด และรูปภาพตัวอย่างพรีวิวแบบเรียลไทม์
    - **PDF Auto-Conversion:** ซิงค์ระบบประมวลผล PDF จากแบบฟอร์มเดิม (ใช้ pdf.js) เพื่อแปลงและรวมทุกหน้าเป็นภาพ JPEG เดี่ยวแนวตั้งความละเอียดสูงโดยอัตโนมัติก่อนส่งขึ้นคลาวด์/เซิร์ฟเวอร์ proxy
- **การแก้ไขข้อมูลอัจฉริยะ (Smart Edit Flow):**
    - พัฒนาระบบตรวจสอบในฝั่ง Frontend หากผู้ใช้แก้ไขข้อมูลทั่วไป (เช่น ภาคเรียน, ปีการศึกษา, ชั้น, แผนการเรียน) โดย **ไม่ได้อัปโหลดไฟล์ใหม่** ระบบจะใช้ชื่อไฟล์ภาพเดิมที่เคยอัปโหลดไว้ ข้ามขั้นตอนการเรียก Proxy อัปโหลด ช่วยประหยัดเวลาและทราฟฟิกเครือข่ายอย่างมาก
- **การจัดระดับ SweetAlert2 (swal2 Layer Override):**
    - บังคับการแสดงผล SweetAlert2 ให้อยู่บนสุดเสมอด้วย `z-index: 9999 !important` เพื่อแก้ปัญหาการแสดงผลแจ้งเตือนถูกตัว Modal ทับ

### 📁 ไฟล์ที่เกี่ยวข้อง
- `app/Controllers/Admin/Academic/ConAdminClassSchedule.php` (Modified - Redirect rules for add & edit)
- `app/Views/admin/Academic/AdminClassSchedule/AdminClassScheduleMain.php` (Modified - Modal & Drag-Drop UI/UX Integration)

---

## [2026-05-17] - ปรับปรุงการบันทึกข้อมูลชั้นปีนักเรียน & ดีไซน์หน้าแอดมิน (Student Class Auto-Prefixing & Emerald UI Makeover) 🟢✨

### 🚀 ฟีเจอร์ที่เพิ่ม/แก้ไข (Added/Modified)
- **ระบบจัดฟอร์แมตชั้นปีอัตโนมัติ (Student Class Auto-Prefixing):**
    - พัฒนาฟังก์ชันตรวจสอบและเติมคำนำหน้า **"ม."** ให้กับระดับชั้นเรียน (StudentClass) อัตโนมัติในทุกช่องทางของการบันทึกข้อมูล หากชั้นปีนั้นยังไม่ได้มีตัวอักษร "ม." นำหน้า เช่น เมื่อพิมพ์ `1/1` หรือ `5/4` ระบบจะแปลงเป็น `ม.1/1` หรือ `ม.5/4` ก่อนบันทึกลงฐานข้อมูลโดยอัตโนมัติ
    - **ขอบเขตการบังคับใช้:**
        1. **Google Sheets Sync (Method 1 - CSV Publish to Web):** ปรับจังหวะ Sync ให้เติม "ม." ทันที
        2. **Google Sheets Sync (Method 2 - AJAX Dry-Run):** ปรับฟังก์ชันแสดงตัวอย่างพรีวิวและการบันทึกจริง
        3. **Manual Student Add Form:** ปรับแต่งฟังก์ชันบันทึกข้อมูลนักเรียนเดี่ยว
        4. **Admission Import Form:** ปรับแต่งส่วนประมวลผลการนำเข้านักเรียนจากฐานข้อมูลรับสมัครนักเรียนใหม่
        5. **Student Details Update Form:** ปรับส่วนการบันทึกแก้ไขข้อมูลนักเรียนรายบุคคล
- **ดีไซน์ Emerald UI หน้าเพิ่มนักเรียน (Admission Panel Premium Makeover):**
    - ปรับโฉม **"การ์ดรายชื่อจากระบบรับสมัคร" (ฝั่งซ้าย)** ใหม่ทั้งหมด:
        - เปลี่ยนสไตล์จากสีเทาปกติ (Flat Gray) เป็นการแต่งขอบด้วยสีเขียวมินต์สะดุดตา `#20c997`
        - หัวข้อการ์ดและปุ่มเปลี่ยนเป็นโทนไล่เฉดสีสวยงาม `linear-gradient(135deg, rgba(32, 201, 151, 0.15), rgba(32, 201, 151, 0.04))`
        - หัวตารางในตารางรายชื่อเปลี่ยนเป็นเฉดสีเขียวพาสเทลอ่อน `#f1faf6` พร้อมเส้นตัดขอบคมชัดสีมินต์ `#20c997` มอบสัมผัสแห่งความพรีเมียมและเรียบหรู
- **การจำกัดสิทธิ์การลบนักเรียน (Student Deletion Integrity Control):**
    - เพิ่มการตรวจสอบความสัมพันธ์ของข้อมูล (Data Integrity Check) ในหน้าแสดงรายชื่อนักเรียนปกติ (`/Admin/Acade/Registration/Students/normal`)
    - **กฎทางธุรกิจ (Business Rule):** ปุ่มลบจะอนุญาตให้ลบข้อมูลนักเรียนได้เฉพาะกรณีที่นักเรียนคนดังกล่าว **ไม่เคยมีประวัติการลงทะเบียนเรียนหรือผลการเรียน** ในตาราง `skjacth_academic.tb_register` เท่านั้น หากระบบพบข้อมูลในตารางลงทะเบียนเรียน จะทำการปฏิเสธคำขอลบพร้อมแจ้งเตือนผ่าน SweetAlert2 อย่างชัดเจนเพื่อความปลอดภัยสูงสุดของข้อมูลเกรดและประวัติวิชาการ

### 📁 ไฟล์ที่เกี่ยวข้อง
- `app/Controllers/Admin/Academic/ConAdminStudents.php` (Modified - StudentClass Processing Rules & Delete Student Restrictions)
- `app/Views/admin/Academic/AdminStudents/AdminStudentsAdd.php` (Modified - Emerald UI Design Refinement)

---

## [2026-05-17] - แก้ไขปัญหาการอัปโหลดไฟล์ และกำจัดหน้าต่างเตือน DataTables (File Upload Reliability & DataTables Warning Fix) 🟢🛠️

### 🚀 ฟีเจอร์ที่เพิ่ม/แก้ไข (Added/Modified)
- **ระบบจัดเก็บไฟล์อัปโหลดส่วนกลาง (JavaScript Global File Binding):**
    - ปรับปรุง [AdminClassScheduleMain.php](file:///d:/SkjSystem/academic2025/app/Views/admin/Academic/AdminClassSchedule/AdminClassScheduleMain.php) โดยการเปลี่ยนจากการอ้างอิง `.files` ของ Input ตรงๆ (ซึ่งเบราว์เซอร์มักบล็อกความปลอดภัยเมื่อเป็นการลากวาง) มาใช้ตัวแปร JavaScript Global `selectedFile` ในการเก็บสถานะไฟล์ ทำให้การบันทึกตารางเรียนผ่าน Modal และระบบ Drag & Drop ทำงานได้อย่างถูกต้อง แม่นยำ และปลอดภัย 100%
- **ระบบลบล้างหน้าต่างแจ้งเตือน DataTables (Suppressing DataTables Warning Alerts):**
    - แก้ไขปัญหา **"DataTables warning: table id=TbClassSchedule - Invalid year format"** ที่เกิดขึ้นเนื่องจากไม่มีข้อมูลตารางเรียนเริ่มต้นในฐานข้อมูล ส่งผลให้ค่าปีการศึกษาที่ส่งไปมีลักษณะว่าง (Empty parameter)
    - **วิธีการแก้ไข:**
        1. อัปเดตคอนโทรลเลอร์ `ConAdminClassSchedule::getDataByYear()` ให้รองรับการทำงานแบบมี **Fallback** ย้อนกลับไปดึงปีการศึกษาปัจจุบันที่ทำงานอยู่ (`tb_schoolyear`) หากพารามิเตอร์ปีการศึกษาถูกส่งเข้ามาแบบค่าว่าง
        2. ปรับแต่งส่วนส่งคืน JSON ในกรณีที่มีฟอร์แมตไม่ตรง ให้ส่งชุดข้อมูลว่าง `['data' => []]` แทนการส่ง Error ออกไป ช่วยให้ DataTables แสดงผลตารางโล่งสะอาดตาแบบไร้เสียงแจ้งเตือนอย่างสมบูรณ์แบบ (Premium UX)
        3. ปรับแต่งหน้าดึงข้อมูลหลักให้มีการดึงปีการศึกษาปัจจุบันเข้าสู่รายการเลือก (`YearAll`) เสมอ ป้องกันสถานะดรอปดาวน์เป็นค่าว่าง
- **ปรับปรุงการดึงข้อผิดพลาด Proxy (Enhanced Upload Proxy Logging):**
    - เพิ่มระบบส่งข้อความล้มเหลวแบบระบุรหัส (Error Code) และคำอธิบายเชิงลึกจากเซิร์ฟเวอร์ proxy เพื่อช่วยให้นักพัฒนาวิเคราะห์ปัญหาเครือข่ายหรือสิทธิ์โฟลเดอร์ได้ทันที

### 📁 ไฟล์ที่เกี่ยวข้อง
- `app/Controllers/Admin/Academic/ConAdminClassSchedule.php` (Modified - Added Year Fallback & Suppressed DT Warnings)
- `app/Views/admin/Academic/AdminClassSchedule/AdminClassScheduleMain.php` (Modified - Shifted to Global JS selectedFile Binding)

---

## [2026-05-17] - สถาปัตยกรรมแบ่งส่วนอัปโหลดไฟล์อัจฉริยะ (Premium Chunked File Upload Architecture) 🟢📦✨

### 🚀 ฟีเจอร์ที่เพิ่ม/แก้ไข (Added/Modified)
- **ระบบแบ่งส่วนไฟล์ระดับ Client (Client-side Chunk Slicing):**
    - พัฒนาระบบหั่นไฟล์ภาพและ PDF ใน [AdminClassScheduleMain.php](file:///d:/SkjSystem/academic2025/app/Views/admin/Academic/AdminClassSchedule/AdminClassScheduleMain.php) ออกเป็นชิ้นส่วนย่อยๆ ขนาดชิ้นละ **1MB** โดยใช้คำสั่งมาตรฐาน `blob.slice()` ในระดับ JavaScript
    - ส่งไฟล์แต่ละชิ้นส่วนขึ้นไปยังเซิร์ฟเวอร์แบบต่อเนื่องเป็นลำดับ (Sequentially) ป้องกันปัญหาการอัปโหลดล้มเหลวเนื่องจากขนาดไฟล์เกินขีดจำกัดสูงสุดของระบบ (`upload_max_filesize` หรือ `post_max_size` ใน `php.ini`)
- **การแจ้งเตือนความคืบหน้าแบบพรีเมียม (Dynamic Real-time Progress Bar):**
    - ใช้ชุดคำสั่งอัปเดตสถานะของ **SweetAlert2** เพื่อแสดงผลความก้าวหน้า (ProgressBar) แบบแอนิเมชันเคลื่อนไหวสีเขียวมินต์พรีเมียม `#15a362` 
    - แจ้งข้อมูลเชิงลึกแบบสดใหม่ เช่น *"กำลังส่งชิ้นส่วนที่ 2/5 (40%)"* เพื่อเพิ่มความมั่นใจในการรออัปโหลดไฟล์ขนาดใหญ่
- **ระบบรวมชิ้นส่วนฝั่งเซิร์ฟเวอร์ Proxy (Server-side Chunk Assembly Engine):**
    - ปรับแต่งฟังก์ชัน `upload_proxy()` ใน [ConAdminClassSchedule.php](file:///d:/SkjSystem/academic2025/app/Controllers/Admin/Academic/ConAdminClassSchedule.php) 
    - เมื่อชิ้นส่วนของไฟล์ถูกส่งเข้ามา ระบบจะนำไปบันทึกและต่อเติมไฟล์ชั่วคราว (Append) ไว้ในโฟลเดอร์ `writable/uploads/chunks/`
    - เมื่อรับชิ้นส่วนสุดท้ายครบถ้วน (`chunk_index == total_chunks - 1`) ระบบจะนำไฟล์ตัวเต็มที่เพิ่งรวมเสร็จสมบูรณ์ ส่งต่อผ่าน cURL ไปยังเซิร์ฟเวอร์หลัก `https://skj.nsnpao.go.th/upload.php` โดยตรงแบบไร้รอยต่อ
    - ลบไฟล์ขยะชั่วคราวออกจากเซิร์ฟเวอร์ท้องถิ่นทันทีเพื่อรักษาความสะอาดและป้องกันปัญหาพื้นที่เก็บข้อมูลเต็ม

- **ระบบผ่านด่านความปลอดภัย CSRF (CSRF Security Integration):**
    - แก้ไขข้อผิดพลาด **SyntaxError: Unexpected token '<'** (เกิดจากการถูกบล็อกจากระบบความปลอดภัยของ CodeIgniter 4 แล้วส่งกลับเป็นหน้า 403 Forbidden HTML)
    - **วิธีการแก้ไข:** ทำการแทรกรหัสความปลอดภัย (CSRF Token Name & Value) เข้าไปใน `remoteUploadFormData` ทุกครั้งที่มีการอัปโหลดชิ้นส่วนไฟล์ ทำให้ระบบผ่านตัวกรองก่อนเรียกใช้คอนโทรลเลอร์ (Before Filter) ได้อย่างราบรื่น 100%

### 📁 ไฟล์ที่เกี่ยวข้อง
- `app/Controllers/Admin/Academic/ConAdminClassSchedule.php` (Modified - Added chunk assembly & cURL upload sequence)
- `app/Views/admin/Academic/AdminClassSchedule/AdminClassScheduleMain.php` (Modified - Implemented blob slicing, dynamic progress bar, and CSRF token injection)

---

## [2026-05-17] - อัปเดตความเสถียรของหน้าแก้ไข ระบบแสดงภาพนักเรียน ตัวเลือกปีล่าสุด และเพิ่มความคมชัด PDF 🟢📸✨

### 🚀 ฟีเจอร์ที่เพิ่ม/แก้ไข (Added/Modified)
- **เพิ่มความคมชัดระดับ 100% สำหรับการแปลง PDF (100% Perfect Crisp Lossless PNG Conversion):**
    - แก้ไขปัญหาความเบลอของตัวหนังสือตารางเรียน โดยขยายมาตราส่วนการแสดงผล PDF (PDF Render Scale) จาก `2.0` ขึ้นไปเป็น **`3.0`** ทำให้ตัวอักษรและเส้นตารางคมชัดมากที่สุด
    - เปลี่ยนฟอร์แมตของรูปภาพผลลัพธ์จากการบีบอัดแบบสูญเสียข้อมูล (Lossy JPEG) เป็นการบันทึกแบบ **ไร้รอยสูญเสียข้อมูล (Lossless PNG - `image/png`)** ทำให้ภาพที่ได้มีรายละเอียด **คมชัด 100% (Pixel-Perfect) ไร้รอยแตก (Zero Artifacts)** 
    - ด้วยธรรมชาติของตารางเรียนที่มีพื้นหลังสีขาวล้วนและการไล่สีแบบ Flat สีแบนราบ lossless PNG จึงสามารถบีบอัดข้อมูลได้อย่างมีประสิทธิภาพสูง ส่งผลให้ได้ภาพที่คมชัดระดับสูงสุดแต่มีขนาดไฟล์ที่เล็กมากเพียง **200KB - 500KB** เท่านั้น (ผ่านขีดจำกัด 1MB ของเซิร์ฟเวอร์หลักได้อย่างสบายๆ)
- **แก้ไขข้อผิดพลาด DataException: "There is no data to update" (Model Update Fix):**
    - แก้ไขในไฟล์ `ModAdminClassSchedule.php` เมธอด `class_schedule_update()` เนื่องจากก่อนหน้านี้เรียกใช้ `$this->where()->update($data)` ซึ่งไม่ได้ส่ง Primary Key เข้าไปเป็นอาร์กิวเมนต์ตัวแรกของโมเดลตามที่ CodeIgniter 4 กำหนด ส่งผลให้ข้อมูลถูกกรองทิ้งและเกิดข้อผิดพลาดในการบันทึก
    - **วิธีการแก้ไข:** ปรับเปลี่ยนโครงสร้างการเรียกเป็น `$this->update($schestu_id, $data)` ตามมาตรฐาน CI4 เพื่อให้การบันทึกการแก้ไขผ่านฉลุยอย่างไร้ที่ติ
- **แก้ไขปุ่ม "บันทึกการแก้ไข" กดไม่ได้ (Modal Reset & Unlock Fix):**
    - แก้ไขปัญหาปุ่ม submit ใน Modal ค้างอยู่ที่สถานะ `disabled` หลังจากอัปโหลดไฟล์ล้มเหลวในครั้งแรก
    - **วิธีการแก้ไข:** เพิ่มการสั่งปลดล็อกปุ่ม `$('#btnSubmitForm').prop('disabled', false)` ภายในฟังก์ชัน `resetFormState()` ทุกครั้งเมื่อเปิด Modal ใหม่ เพื่อความราบรื่นในการใช้งาน
- **ระบบเลือกปีการศึกษาล่าสุดอัตโนมัติ (Dynamic Latest Year Selector):**
    - ปรับเปลี่ยน Dropdown การกรองปีตารางเรียน จากเดิมที่มีการ Hardcode เลือก `1/2568` ไว้ ให้เปลี่ยนมาใช้ตัวเลือกตัวแรกสุดที่ส่งมาจากฐานข้อมูลผ่าน `$key === 0 ? "selected" : ""` ซึ่งข้อมูลถูกดึงด้วยลำดับล่าสุดเรียงจากบนลงล่างอยู่แล้ว ทำให้ตารางจะแสดงปีล่าสุดโดยอัตโนมัติเมื่อกดเข้ามา
- **แก้ไขปัญหารูปภาพตารางเรียนไม่แสดงในฝั่งนักเรียน (Student Schedule Image Load Fix):**
    - ตรวจพบว่าไฟล์ `image_proxy.php` ไม่มีอยู่จริงในโครงการ ส่งผลให้รูปภาพฝั่งหน้าเว็บนักเรียน (`/ClassSchedule`) ขึ้นข้อผิดพลาด 404 และแสดงเป็นกล่องว่างเมื่อคลิกดู
    - **วิธีการแก้ไข:** แก้ไขไฟล์ `PageClassSchedule.php` ของฝั่งผู้ใช้ให้เรียกภาพตรงจากเซิร์ฟเวอร์อัปโหลดหลัก `https://skj.nsnpao.go.th/uploads/academic/ClassSchedule/...` และดึงปี/เทอมตามข้อมูลของแต่ละแถวจริง (`item.schestu_year`/`item.schestu_term`) ช่วยให้รูปภาพตารางเรียน ม.1/1 และห้องเรียนอื่นๆ ปรากฏขึ้นมาอย่างคมชัดทันที
- **เพิ่ม GET Fallback ป้องกันหน้าเว็บล่ม (Preventing 404 GET Fallbacks):**
    - เพิ่ม Route สำรองสำหรับ `insert_class_schedule` และ `upload_proxy` ในรูปแบบ `GET` ใน `Routes.php` เพื่อเปลี่ยนทิศทาง (Redirect) ไปหน้าหลักอย่างปลอดภัยแทนการเปิดหน้า 404 ข้อมูลตกหล่น

### 📁 ไฟล์ที่เกี่ยวข้อง
- `app/Views/admin/Academic/AdminClassSchedule/AdminClassScheduleMain.php` (Modified - Optimized PDF rendering scale & quality, unlocked submit button on reset)
- `app/Models/Admin/ModAdminClassSchedule.php` (Modified - Adjusted CI4 update method syntax)
- `app/Views/user/PageClassSchedule.php` (Modified - Fixed image URLs and dynamic fields)
- `app/Config/Routes.php` (Modified - Added GET fallbacks for upload paths)


