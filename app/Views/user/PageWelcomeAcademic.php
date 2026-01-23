<?= $this->extend('user/layout/main') ?>

<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Sophisticated Header -->
    <div class="row mb-5 mt-3">
        <div class="col-12 text-center text-md-start">
            <h5 class="text-uppercase ls-1 fw-semibold mb-1" style="color: #15a362;">Academic Services</h5>
            <h2 class="fw-bold text-dark mb-0" style="letter-spacing: -1px;">ระบบบริหารจัดการงานวิชาการดิจิทัล</h2>
            <div class="mt-2 text-muted">เข้าถึงระบบสารสนเทศและการบริการต่างๆ ของกลุ่มบริหารงานวิชาการ</div>
        </div>
    </div>

    <!-- Minimal System Grid -->
    <div class="row g-4">
        <!-- System 1: ตารางเรียน -->
        <div class="col-6 col-md-4 col-lg-3">
            <a href="<?= base_url('ClassSchedule') ?>" class="sys-card p-4 transition-all">
                <div class="sys-icon bg-label-primary mb-3">
                    <i class='bx bx-calendar-event fs-2'></i>
                </div>
                <h6 class="fw-bold mb-1 mt-2">ตารางเรียน</h6>
                <p class="small text-muted mb-0">ค้นหาตารางเรียนรายห้อง/รายบุคคล</p>
            </a>
        </div>

        <!-- System 2: ตารางสอบ -->
        <div class="col-6 col-md-4 col-lg-3">
            <a href="<?= base_url('ExamSchedule') ?>" class="sys-card p-4 transition-all">
                <div class="sys-icon bg-label-info mb-3">
                    <i class='bx bx-spreadsheet fs-2'></i>
                </div>
                <h6 class="fw-bold mb-1 mt-2">ตารางสอบ</h6>
                <p class="small text-muted mb-0">ตารางสอบกลางภาค/ปลายภาค</p>
            </a>
        </div>

        <!-- System 3: รายชื่อนักเรียน -->
        <div class="col-6 col-md-4 col-lg-3">
            <a href="<?= base_url('StudentsList') ?>" class="sys-card p-4 transition-all">
                <div class="sys-icon bg-label-success mb-3">
                    <i class='bx bx-group fs-2'></i>
                </div>
                <h6 class="fw-bold mb-1 mt-2">รายชื่อนักเรียน</h6>
                <p class="small text-muted mb-0">ตรวจสอบรายชื่อนักเรียนแยกตามห้อง</p>
            </a>
        </div>

        <!-- System 4: ผลการเรียน (Link to Student Login context) -->
        <div class="col-6 col-md-4 col-lg-3">
            <a href="https://student.skj.ac.th/" class="sys-card p-4 transition-all">
                <div class="sys-icon bg-label-danger mb-3">
                    <i class='bx bx-line-chart fs-2'></i>
                </div>
                <h6 class="fw-bold mb-1 mt-2">ผลการเรียน</h6>
                <p class="small text-muted mb-0">ตรวจสอบผลการเรียนรายเทอม</p>
            </a>
        </div>

         <!-- System 7: ประกันคุณภาพ -->
         <div class="col-6 col-md-4 col-lg-3">
            <a href="https://sites.google.com/skj.ac.th/skj68/home" target="_blank" class="sys-card p-4 transition-all">
                <div class="sys-icon bg-label-dark mb-3">
                    <i class='bx bx-check-shield fs-2'></i>
                </div>
                <h6 class="fw-bold mb-1 mt-2">ประกันคุณภาพ</h6>
                <p class="small text-muted mb-0">ข้อมูล QA และการประเมินการศึกษา</p>
            </a>
        </div>

        <!-- System 8: ดาวน์โหลดไฟล์ -->
        <div class="col-6 col-md-4 col-lg-3">
            <a href="https://documentcenter.skj.ac.th/" target="_blank" class="sys-card p-4 transition-all">
                <div class="sys-icon bg-label-info mb-3">
                    <i class='bx bx-download fs-2'></i>
                </div>
                <h6 class="fw-bold mb-1 mt-2">ดาวน์โหลดไฟล์</h6>
                <p class="small text-muted mb-0">คลังเอกสารและแบบฟอร์มวิชาการ</p>
            </a>
        </div>
    </div>
</div>

<!-- SVG Wave Decoration -->
<div class="footer-wave">
    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V0C49.1,15.46,108,30.2,170,38.12,235.59,46.24,271.32,58.33,321.39,56.44Z" class="shape-fill"></path>
    </svg>
</div>

<style>
    .ls-1 { letter-spacing: 0.1rem; }
    
    html, body {
        background-color: #f4fbf8 !important;
        background-image: 
            radial-gradient(#15a36220 2px, transparent 2px),
            radial-gradient(#15a36220 2px, transparent 2px) !important;
        background-size: 50px 50px !important;
        background-position: 0 0, 25px 25px !important;
        background-attachment: fixed !important;
    }

    .content-wrapper, .layout-page, .layout-wrapper {
        background: transparent !important;
    }

    .sys-card {
        display: block;
        height: 100%;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(21, 163, 98, 0.15);
        border-radius: 20px;
        text-decoration: none;
        color: inherit;
        text-align: center;
        position: relative;
        z-index: 2;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }

    .sys-card:hover {
        background: #fff;
        border-color: #15a362;
        box-shadow: 0 20px 40px rgba(21, 163, 98, 0.15);
        transform: translateY(-10px);
    }

    .sys-icon {
        width: 70px;
        height: 70px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        box-shadow: 0 8px 20px rgba(21, 163, 98, 0.1);
    }

    .sys-card h6 {
        color: #2b3c4d;
        font-size: 1.1rem;
        font-weight: 700;
        transition: color 0.2s;
    }

    .sys-card:hover h6 {
        color: #15a362;
    }

    .transition-all {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    /* Wave Decoration */
    .footer-wave {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        overflow: hidden;
        line-height: 0;
        transform: rotate(180deg);
        z-index: 0; /* Changed from -1 to 0 */
        pointer-events: none;
    }

    .footer-wave svg {
        position: relative;
        display: block;
        width: calc(160% + 1.3px);
        height: 200px;
    }

    .footer-wave .shape-fill {
        fill: #15a36215; /* Increased opacity from 08 to 15 */
    }

    @media (max-width: 576px) {
        .sys-card {
            padding: 1.5rem 1rem !important;
        }
        .sys-card p {
            display: none;
        }
        .sys-icon {
            width: 60px;
            height: 60px;
        }
        .footer-wave svg {
            height: 100px;
        }
    }
</style>

<?= $this->endSection() ?>