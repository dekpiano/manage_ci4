# 📝 Development Log - SkjSystem Academic 2025

รายการบันทึกการแก้ไขและพัฒนาโปรแกรม เพื่อใช้เป็นความจำในการทำงานร่วมกัน

---

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
