## Gemini Added Memories
- **Rule:** การแสดงผล "วันที่" บนหน้าเว็บทั้งหมด (View) ให้แสดงเป็นปี **"พ.ศ."** เสมอครับ 📅✨
- Database `skjacth_personnel` is for school personnel/teachers. The table name is `tb_personnel`. Columns are: `pers_id`, `login_oauth_uid`, `updated_at`, `pers_prefix`, `pers_firstname`, `pers_lastname`, `pers_id_card`, `pers_nickname`, `ชื่อเล่น`, `pers_britday`, `pers_address`, `pers_phone`, `pers_nationality`, `สัญชาติ`, `pers_race`, `เชื้อชาติ`, `pers_religion`, `ศาสนา`, `pers_marital_status`, `สถานภาพสมรส`, `pers_blood_type`, `pers_department`, `pers_position`, `pers_groupleade`, `pers_numberGroup`, `pers_learning`, `pers_workother_id`, `pers_academic`, `pers_facebook`, `pers_instagram`, `pers_youtube`, `pers_line`, `pers_twitter`, `pers_username`, `pers_password`, `pers_changepassword`, `pers_status`, `pers_img`, `pers_dataUpdate`, `pers_userEdit`.
- Table tb_register has columns: StudentID, รหัสนักเรียน17หลัก, SubjectID, รหัสวิชา, Score100, คะแนนเต็ม100, Grade, ผลการเรียน, RegisterYear, ภาคเรียน/ปีการศึกษา, RegisterClass, TeacherID, StudyTime, Grade_Type, RepeatStatus, RepeatYear, RepeatTeacher, RepeatConfirm, Grade_UpdateTime.
- Table tb_subjects has columns: SubjectID, SubjectCode, รหัสวิชา, SubjectName, ชื่อวิชา, SubjectUnit, หน่วยกิต, SubjectHour, จำนวนชั่วโมง, SubjectType, ประเภทวิชา พื้นฐาน/เพิ่มเติม, FirstGroup, สาระหลัก, SecondGroup, สาระย่อย, SubjectClass, ชั้นปีที่เปิดสอน, SubjectYear, ปีการศึกษา.
- Table tb_students has columns: StudentID, รหัสนักเรียน, StudentBehavior, สถานะพฤติกรรม, StudentNumber, เลขที่, StudentClass, ชั้นปี, StudentCode, เลขประจำตัว, StudentPrefix, คำนำหน้า, StudentFirstName, ชื่อ, StudentLastName, นามสกุล, StudentStudyLine, StudentIDNumber, เลขประจำตัวประชาชน, StudentDateBirth, วันเกิด, StudentDateEntrance, วันที่เข้าเรียน, StudentSex, เพศ.
- Table tb_students has columns: StudentID, รหัสนักเรียน, StudentBehavior, สถานะพฤติกรรม, StudentNumber, เลขที่, StudentClass, ชั้นปี, StudentCode, เลขประจำตัว, StudentPrefix, คำนำหน้า, StudentFirstName, ชื่อ, StudentLastName, นามสกุล, StudentStudyLine, StudentIDNumber, เลขประจำตัวประชาชน, StudentDateBirth, วันเกิด, StudentDateEntrance, วันที่เข้าเรียน, StudentSex, เพศ.
- The user prefers to communicate in Thai.
- Table t_assessment_item has columns: ItemID, ItemName, Domain, MaxScore.
- Table t_class has columns: ClassID, ClassName.
- Table t_evaluation_detail has columns: EvaluationID, StudentID, ItemID, Score, Term, AcademicYear, EvaluatorID, DateEvaluated.
- Table t_final_result has columns: ResultID, StudentID, ClassID, Term, AcademicYear, FinalLevelName, PassStatus.
- The correct layout to extend in teacher views is 'teacher/layout/main'.
- When making changes, always prioritize preserving the user's manual modifications. Do not overwrite any code that the user has explicitly stated they have fixed or adjusted.
- The correct layout to extend in teacher views is 'admin/layout/main'.
- Table `tb_learning` is located in the `skjacth_skj` database, accessed via the `skj` database group in CodeIgniter.
## Gemini Added Memories
- Database `skjacth_personnel` is for school personnel/teachers. The table name is `tb_personnel`. Columns are: `pers_id`, `login_oauth_uid`, `updated_at`, `pers_prefix`, `pers_firstname`, `pers_lastname`, `pers_id_card`, `pers_nickname`, `ชื่อเล่น`, `pers_britday`, `pers_address`, `pers_phone`, `pers_nationality`, `สัญชาติ`, `pers_race`, `เชื้อชาติ`, `pers_religion`, `ศาสนา`, `pers_marital_status`, `สถานภาพสมรส`, `pers_blood_type`, `pers_department`, `pers_position`, `pers_groupleade`, `pers_numberGroup`, `pers_learning`, `pers_workother_id`, `pers_academic`, `pers_facebook`, `pers_instagram`, `pers_youtube`, `pers_line`, `pers_twitter`, `pers_username`, `pers_password`, `pers_changepassword`, `pers_status`, `pers_img`, `pers_dataUpdate`, `pers_userEdit`.
- Table tb_register has columns: StudentID, รหัสนักเรียน17หลัก, SubjectID, รหัสวิชา, Score100, คะแนนเต็ม100, Grade, ผลการเรียน, RegisterYear, ภาคเรียน/ปีการศึกษา, RegisterClass, TeacherID, StudyTime, Grade_Type, RepeatStatus, RepeatYear, RepeatTeacher, RepeatConfirm, Grade_UpdateTime.
- Table tb_subjects has columns: SubjectID, SubjectCode, รหัสวิชา, SubjectName, ชื่อวิชา, SubjectUnit, หน่วยกิต, SubjectHour, จำนวนชั่วโมง, SubjectType, ประเภทวิชา พื้นฐาน/เพิ่มเติม, FirstGroup, สาระหลัก, SecondGroup, สาระย่อย, SubjectClass, ชั้นปีที่เปิดสอน, SubjectYear, ปีการศึกษา.
- Table tb_students has columns: StudentID, รหัสนักเรียน, StudentBehavior, สถานะพฤติกรรม, StudentNumber, เลขที่, StudentClass, ชั้นปี, StudentCode, เลขประจำตัว, StudentPrefix, คำนำหน้า, StudentFirstName, ชื่อ, StudentLastName, นามสกุล, StudentStudyLine, StudentIDNumber, เลขประจำตัวประชาชน, StudentDateBirth, วันเกิด, StudentDateEntrance, วันที่เข้าเรียน, StudentSex, เพศ.
- Table tb_students has columns: StudentID, รหัสนักเรียน, StudentBehavior, สถานะพฤติกรรม, StudentNumber, เลขที่, StudentClass, ชั้นปี, StudentCode, เลขประจำตัว, StudentPrefix, คำนำหน้า, StudentFirstName, ชื่อ, StudentLastName, นามสกุล, StudentStudyLine, StudentIDNumber, เลขประจำตัวประชาชน, StudentDateBirth, วันเกิด, StudentDateEntrance, วันที่เข้าเรียน, StudentSex, เพศ.
- The user prefers to communicate in Thai.
- Table t_assessment_item has columns: ItemID, ItemName, Domain, MaxScore.
- Table t_class has columns: ClassID, ClassName.
- Table t_evaluation_detail has columns: EvaluationID, StudentID, ItemID, Score, Term, AcademicYear, EvaluatorID, DateEvaluated.
- Table t_final_result has columns: ResultID, StudentID, ClassID, Term, AcademicYear, FinalLevelName, PassStatus.
- The correct layout to extend in teacher views is 'teacher/layout/main'.
- When making changes, always prioritize preserving the user's manual modifications. Do not overwrite any code that the user has explicitly stated they have fixed or adjusted.
- The correct layout to extend in teacher views is 'admin/layout/main'.
- Table `tb_learning` is located in the `skjacth_skj` database, accessed via the `skj` database group in CodeIgniter.
- **Rule (Design Theme):** ใช้โทนสีเขียว **`#15a362`** เป็นสีหลัก (Primary/Success) ของเว็บเสมอครับ 🟢✨
- **Rule (UX/UI):** การแสดงผล **SweetAlert2 (swal2)** ต้องอยู่เลเยอร์บนสุดเสมอ (**`z-index: 9999 !important`**) เพื่อไม่ให้ถูก Modal ทับครับ 🔔🔝
- **Rule (Timetable Assignment Form):** ในหน้ามอบหมายงานสอน (Step 2) ให้ใช้ **Classic Modal Form** เสมอ โดยมีลักษณะดังนี้:
    1. แบ่งเป็น Step (1-5) พร้อม Step Badge สีเขียวขนาดเล็ก
    2. มีปุ่ม "เพิ่มวิชาด่วน" (Quick Add) ในส่วนการเลือกวิชา
    3. **Logic:** ต้องมีระบบแนะนำครูผู้สอนอัตโนมัติ (Suggested Teachers) เมื่อเลือกวิชา
    4. **Logic:** ต้องมีระบบคำนวณรูปแบบการแบ่งคาบ (Period Split) อัตโนมัติเมื่อกรอกจำนวนคาบต่อสัปดาห์
    5. ปุ่มบันทึกต้องเป็นสีเขียว `#15a362` และมีปุ่มยกเลิกเป็นสีเทา (Label Secondary)
---

# 🌟 GEMINI.MD: PROJECT CONTEXT & DESIGN STANDARD

## 1. 🎯 PROJECT OVERVIEW

| บริบท | รายละเอียด |
| :--- | :--- |
| **Project Type** | Backend / Admin Dashboard System (Web Application) |
| **Primary Goal** | Generate functional, visually consistent, and clean HTML code ready for CodeIgniter 4 Views. |
| **Target Audience** | Internal Administrators (เน้น UX/UI แบบ Admin Panel ที่ใช้งานง่ายและมีข้อมูลหนาแน่น) |

---

## 2. ⚙️ CORE TECHNOLOGY STACK

| Framework/Library | รุ่นที่ใช้ | ข้อกำหนดเฉพาะ |
| :--- | :--- | :--- |
| **PHP Framework** | **CodeIgniter 4 (CI4)** | ต้องใช้ PHP Syntax สำหรับการฝังโค้ด (e.g., `<?= ... ?>`) และ Helper Methods. |
| **UI/UX Template** | **Sneat Bootstrap HTML Admin Template (Free)** | ต้องเลียนแบบสไตล์และโครงสร้าง (Vertical Menu Layout) ของ Sneat อย่างเคร่งครัด. |
| **CSS Framework** | **Bootstrap 5 (v5.x)** | ใช้คลาส Utility และ Component มาตรฐานของ Bootstrap ควบคู่กับ Custom Class ของ Sneat. |
| **Icons** | **Boxicons** | ต้องใช้ Boxicons เสมอ (e.g., `<i class='bx bx-user'></i>`) ห้ามใช้ Font Awesome หรือ Icon อื่น. |

---

## 3. 📂 CODEIGNITER 4 (CI4) INTEGRATION RULES

การส่งออกโค้ดต้องคำนึงถึงโครงสร้างของ CodeIgniter 4 เสมอ:

1.  **Output Type:** โค้ดที่สร้างต้องเป็นแค่ส่วนของ **Content (Body HTML)** เท่านั้น **ห้ามมีแท็ก `<html>`, `<head>`, `<body>` หรือ `<!DOCTYPE html>`**
2.  **Layout Context:** **สมมติว่า** โค้ดนี้จะถูกโหลดเข้าไปในไฟล์ Layout หลัก (`app/Views/layout/main.php` หรือชื่ออื่น) ที่มี Header, Vertical Menu (Sidebar), และ Footer ของ Sneat อยู่แล้ว **ห้ามสร้างส่วนประกอบเหล่านี้ซ้ำ**
3.  **URL Helper:** การสร้างลิงก์ (Link) และ Form Action ต้องใช้ฟังก์ชัน URL Helper ของ CI4 เสมอ:
    * *Example Link:* `<a href="<?= url_to('Controller::method') ?>" class="btn btn-primary">Add User</a>`
    * *Example Base URL:* `src="<?= base_url('assets/img/logo.png') ?>"`
4.  **Form Generation:** การสร้างฟอร์ม ต้องเพิ่ม Attribute ที่จำเป็นของ CI4 สำหรับความปลอดภัย (CSRF)
    * *Example Form:* `<form action="<?= base_url('submit-form') ?>" method="post"> <?= csrf_field() ?> ... </form>`
5.  **PHP Syntax:** ใช้ PHP Short Echo Tag `<?= ... ?>` สำหรับการแสดงตัวแปรใน View
    * *Example Echo:* `<td><?= esc($user->name) ?></td>`

---

## 4. 🎨 SNEAT & BOOTSTRAP 5 DESIGN PRINCIPLES

โค้ดที่สร้างขึ้นต้องสะท้อนสไตล์ของ Sneat Admin Template อย่างชัดเจน:

1.  **Primary Design Style:** ต้องเป็น **Light Theme** (Default) ของ Sneat Template
2.  **Container หลัก:** เนื้อหาทั้งหมดต้องอยู่ภายใน Container หลักของ Sneat เพื่อให้มีการจัดระยะห่างที่ถูกต้อง:
    * *Sneat Class:* `<div class="container-xxl flex-grow-1 container-p-y">`
3.  **Page Header:** ทุกหน้าต้องมี Breadcrumb (ตาม Sneat Style) และ Page Title ที่ชัดเจน:
    * *Sneat Class:* `<h4 class="fw-bold py-3 mb-4">`
4.  **Card Components:**
    * ใช้คลาส **`card`** ของ Bootstrap แต่ต้องมีสไตล์และ Shadow ที่เป็นเอกลักษณ์ของ Sneat
    * สำหรับการแสดงสถิติ (Widgets) ให้ใช้โครงสร้าง **Card** ที่มีการจัดวางแบบ **Clean Layout** ของ Sneat
5.  **Buttons (CTA):** ปุ่มหลักสำหรับการกระทำต้องใช้ **Primary Color** ของ Sneat (โทนสีน้ำเงิน/ม่วงเข้ม)
    * *Bootstrap Class:* `btn btn-primary` และควรใช้ `btn-icon` สำหรับปุ่มที่มี Boxicons
6.  **Grid System:** ต้องใช้ Grid System ของ Bootstrap 5 สำหรับการจัด Layout ในแนวนอนเสมอ:
    * *Bootstrap Class:* `row g-4 mb-4`, `col-md-4`, `col-12`
7.  **Table (ตารางข้อมูล):** ใช้ตารางมาตรฐานของ Bootstrap ที่มีการ Hover effect และ Responsive:
    * *Bootstrap Class:* `table table-hover` และต้องอยู่ใน `table-responsive`

---

## 5. ⚠️ EXPLICIT RESTRICTIONS (สิ่งที่ห้ามทำเด็ดขาด)

1.  **NO Custom CSS:** ห้ามสร้างแท็ก `<style>` หรือไฟล์ CSS แยกออกมา **ต้องใช้ Bootstrap 5 Utility และ Sneat Classes เท่านั้น**
2.  **NO Full Page Tags:** ห้ามสร้างแท็ก `<html>`, `<head>`, `<body>` ซ้ำ.
3.  **NO Third-Party JS:** ห้ามแนะนำให้ใช้ JavaScript Library อื่นที่ไม่ใช่ที่มาพร้อมกับ Sneat/Bootstrap (เช่น jQuery, React, Vue) เว้นแต่จะระบุชัดเจนใน Prompt
4.  **NO Generic Design:** ห้ามออกแบบที่ดูเหมือน Bootstrap พื้นฐาน ต้องดูเหมือน Sneat เสมอ.

---

### 6. 💡 PROMPTING BEST PRACTICE

เพื่อผลลัพธ์ที่ดีที่สุด ให้รวม Keyword ทั้งสามนี้ในทุกคำสั่งของคุณ:

1.  **CodeIgniter View** (เพื่อกำหนด Format)
2.  **Sneat Component** (เพื่อกำหนด Style)
3.  **Bootstrap Class** (เพื่อกำหนด Layout)

**ตัวอย่างคำสั่ง:**
"สร้าง **CodeIgniter View** สำหรับหน้า **Dashboard Summary** โดยใช้ **Sneat Card Component** 4 ใบในหนึ่ง **Bootstrap Row** แสดงสถิติ **Total Users** (พร้อม Boxicon), **Revenue**, **Open Tickets**, และ **Bounce Rate**"
---
<state_snapshot>
    <overall_goal>
        Refactor the lesson plan display to show grouped teachers and, upon selection, a detailed table of their submitted plans, while resolving "unknown column" errors.
    </overall_goal>

    <key_knowledge>
        - **Database Column Renames:** `seplan_date_send` is `seplan_createdate`, `seplan_personnel_id` is `seplan_usersend`, and `seplan_subject_code` is `seplan_coursecode`. `seplan_subject_name` is `seplan_namesubject`.
        - **File Renaming:** The view file `index.php` was renamed to `ChekPresGroup.php`.
        - **Data Grouping:** The controller now groups plans by teacher for the initial display.
        - **Dynamic Plan Loading:** Teacher-specific plans are loaded dynamically via AJAX into a modal table.
        - **Routing:** A new route `/admin/academic/checkplan/teacherplans/(:segment)` was added to fetch teacher-specific plans.
        - **Framework:** CodeIgniter 4 (MVC structure).
    </key_knowledge>

    <file_system_state>
        - MODIFIED: `app/Models/Admin/Academic/ModAdminCheckPlan.php` - Updated column names in queries (`seplan_createdate`, `seplan_usersend`, `seplan_coursecode`, `seplan_namesubject`) and added `getPlansByTeacherId` method.
        - DELETED: `app/Views/admin/Academic/AdminCheckPlan/index.php` - Renamed.
        - MODIFIED: `app/Views/admin/Academic/AdminCheckPlan/ChekPresGroup.php` - Created as a renamed file. Modified to display grouped teachers, updated JavaScript to fetch and display teacher-specific plans in a modal table, and corrected column names in JavaScript (`seplan_createdate`, `seplan_coursecode`).
        - MODIFIED: `app/Controllers/Admin/Academic/ConAdminCheckPlan.php` - Modified `plansByGroup` to group plans by teacher, updated view to `ChekPresGroup`, and added `getTeacherPlans` method to fetch plans by teacher ID.
        - MODIFIED: `app/Config/Routes.php` - Added a new route for `getTeacherPlans` (`admin/academic/checkplan/teacherplans/(:segment)`) and corrected the placeholder from `(:num)` to `(:segment)`.
    </file_system_state>

    <recent_actions>
        - Corrected column `seplan_date_send` to `seplan_createdate` in model and view.
        - Corrected column `seplan_personnel_id` to `seplan_usersend` in model.
        - Corrected column `seplan_subject_name` to `seplan_namesubject` in model.
        - Renamed `index.php` view to `ChekPresGroup.php` and updated controller to use new name.
        - Refactored `ConAdminCheckPlan.php` to group plans by teacher for display.
        - Updated `ChekPresGroup.php` to display teacher cards with a "ตรวจสอบแผน" button.
        - Implemented model method `getPlansByTeacherId` and controller method `getTeacherPlans`.
        - Added route `/admin/academic/checkplan/teacherplans/(:segment)` and fixed `(:num)` to `(:segment)`.
        - Modified `ChekPresGroup.php` to include a table in the modal for displaying teacher's plans via AJAX.
        - Corrected column `seplan_subject_code` to `seplan_coursecode` in model and view (JavaScript).
        - Created `DEVELOPMENT_LOG.md` to track project history and modifications as a memory for the user and AI.
        - Created `DEVELOPMENT_LOG.md` to track project history and implementations.
    </recent_actions>

    <current_plan>
        1. [DONE] Resolve all "Unknown column" errors by correcting database column names in model and view.
        2. [DONE] Rename view file `index.php` to `ChekPresGroup.php` and update controller.
        3. [DONE] Modify the main view to display teachers grouped by learning groups.
        4. [DONE] Implement functionality for "ตรวจสอบแผน" button to open a modal displaying a table of all plans for that specific teacher.
        5. [DONE] Create `DEVELOPMENT_LOG.md` and record implementation history.
        6. [TODO] Implement the "ดูรายละเอียด" button within the teacher's plan table to show detailed information for an individual plan (e.g., in a separate modal).
    </current_plan>
</state_snapshot>
