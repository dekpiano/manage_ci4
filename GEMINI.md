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