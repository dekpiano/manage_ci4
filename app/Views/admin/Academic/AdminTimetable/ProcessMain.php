<?= $this->extend('admin/layout/main') ?>

<?= $this->section('extra_css') ?>
<style>
    /* Modern Design System & Pro Palette */
    :root {
        --primary-theme: #15a362;
        --primary-gradient: linear-gradient(135deg, #15a362 0%, #0c7a46 100%);
        --primary-light: #e8f7f0;
        --primary-border: #b8e8ce;
        --card-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.05);
        --card-hover-shadow: 0 10px 30px 0 rgba(21, 163, 98, 0.12);
    }

    /* Page Header Styles */
    .timetable-header-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 1.25rem 1.75rem;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0,0,0,0.04);
        margin-bottom: 1.5rem;
    }

    .wizard-container {
        perspective: 1000px;
    }

    /* Import Mode Option Cards */
    .import-mode-option {
        border: 1.5px solid #e2e8f0 !important;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .import-mode-option:hover {
        border-color: #15a362 !important;
        background-color: #f8fdfa !important;
    }
    .import-mode-option:has(input:checked) {
        border-color: #15a362 !important;
        background-color: #f0fdf4 !important;
        box-shadow: 0 4px 12px rgba(21, 163, 98, 0.12) !important;
    }

    /* Card-based Navigation - Step Pills / Cards */
    .nav-cards-wrapper {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 1rem;
        margin-bottom: 1.75rem;
    }
    @media (max-width: 991.98px) {
        .nav-cards-wrapper {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 575.98px) {
        .nav-cards-wrapper {
            grid-template-columns: 1fr;
        }
    }

    .nav-card-item {
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid transparent !important;
        background: #ffffff;
        border-radius: 16px !important;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
    }
    .nav-card-item::before {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: transparent;
        transition: background 0.3s ease;
    }
    .nav-card-item:hover {
        transform: translateY(-4px);
        box-shadow: var(--card-hover-shadow) !important;
        border-color: rgba(21, 163, 98, 0.25) !important;
    }
    .nav-card-item.active {
        border-color: var(--primary-theme) !important;
        background: #ffffff !important;
        box-shadow: 0 8px 24px rgba(21, 163, 98, 0.15) !important;
    }
    .nav-card-item.active::before {
        background: var(--primary-theme);
    }
    .nav-card-item.active .nav-card-icon {
        background: var(--primary-gradient);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(21, 163, 98, 0.35);
    }
    .nav-card-item.active .step-number-tag {
        background-color: var(--primary-theme) !important;
        color: #ffffff !important;
    }

    .nav-card-icon {
        width: 44px;
        height: 44px;
        min-width: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #f4f6f8;
        color: #566a7f;
        font-size: 1.35rem;
        transition: all 0.3s ease;
    }
    .nav-card-title {
        font-size: 0.9rem;
        font-weight: 700;
        margin-bottom: 2px;
        color: #384551;
    }
    .nav-card-subtitle {
        font-size: 0.72rem;
        color: #8592a3;
    }

    .step-number-tag {
        font-size: 0.65rem;
        font-weight: 800;
        padding: 2px 7px;
        border-radius: 6px;
        background: #f0f2f4;
        color: #697a8d;
        display: inline-block;
        margin-bottom: 2px;
        transition: all 0.2s;
    }

    .hover-elevate {
        transition: all 0.25s ease;
        display: flex;
        align-items: center;
        text-align: left;
    }
    .hover-elevate:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08) !important;
    }

    /* Wizard Content Animation */
    .wizard-step {
        animation: fadeInStep 0.35s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
    }
    @keyframes fadeInStep {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Step Card Content Layout */
    .step-header-banner {
        padding: 1.5rem 1.75rem;
        background: #ffffff;
        border-bottom: 1px solid #edf1f4;
    }

    /* Step 3 Sidebar & Grid */
    .subject-card-wizard {
        transition: all 0.2s ease;
        border: 1px solid #e9ecef !important;
        border-left: 4px solid var(--primary-theme) !important;
        border-radius: 10px;
    }
    .subject-card-wizard:hover {
        transform: translateX(4px);
        box-shadow: 0 4px 14px rgba(0,0,0,0.06) !important;
    }

    .drag-target-hover {
        background-color: rgba(21, 163, 98, 0.1) !important;
        border: 2px dashed var(--primary-theme) !important;
        transform: scale(0.98);
    }

    .slot-empty:hover .lock-slot-wizard {
        opacity: 0.5 !important;
        background: #f8f9fa;
    }

    /* Glassmorphism for loaders */
    .glass-loader {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(6px);
        border-radius: 16px;
    }

    .locked-menu {
        opacity: 0.65;
        background: #fbfbfb !important;
        cursor: not-allowed !important;
    }
    .locked-menu:hover {
        transform: none !important;
        box-shadow: var(--card-shadow) !important;
    }

    /* 🔔 SweetAlert2 Layer Fix */
    .swal2-container {
        z-index: 9999 !important;
    }

    .progress-bar.bg-success {
        background-color: var(--primary-theme) !important;
    }

    /* Card Menu Step 1 */
    .card-setting-step1 {
        cursor: pointer;
        transition: all 0.25s ease;
        border: 1px solid #edf0f2 !important;
        border-radius: 16px !important;
        background: #ffffff;
    }
    .card-setting-step1:hover {
        border-color: var(--primary-theme) !important;
        background: #ffffff;
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(21, 163, 98, 0.1) !important;
    }
    .card-setting-step1:hover .avatar {
        transform: scale(1.08);
    }

    /* 🎨 Import Modal UI Enhancement */
    .subject-import-item { transition: opacity 0.2s ease; }
    .shadow-sm-hover:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08) !important;
        transform: translateY(-2px);
        border-color: var(--primary-theme) !important;
    }
    .scroll-custom::-webkit-scrollbar { width: 6px; }
    .scroll-custom::-webkit-scrollbar-thumb { background: #d0d7de; border-radius: 10px; }
    .transition-all { transition: all 0.3s ease; }

    /* ✅ Selected State for Import Cards */
    .subject-import-card {
        border: 1px solid #e0e0e0;
        background: #fff;
    }
    .subject-import-card.is-selected {
        background-color: #f1fbf4 !important;
        border-color: var(--primary-theme) !important;
        box-shadow: 0 0 0 1px var(--primary-theme);
    }
    .subject-import-card.is-selected .bg-checkbox-area {
        background-color: var(--primary-theme) !important;
        border-color: var(--primary-theme) !important;
    }
    .check-subject-wizard {
        width: 20px !important;
        height: 20px !important;
        cursor: pointer;
        transform: scale(1.3);
        margin: 0 !important;
    }
    .bg-checkbox-area {
        width: 50px;
        background: #f8f9fa;
        transition: all 0.2s ease;
    }

    /* Step Badge Numbers */
    .step-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--primary-theme);
        background: var(--primary-light);
        padding: 4px 12px;
        border-radius: 20px;
        border: 1px solid var(--primary-border);
    }

    /* Modern Tabs for Step 3 */
    .nav-tabs {
        background: #fbfcfd;
        border-bottom: 1px solid #edf1f4 !important;
        gap: 4px;
    }
    .nav-tabs .nav-link {
        color: #697a8d;
        border: none !important;
        border-bottom: 3px solid transparent !important;
        transition: all 0.2s ease;
        border-radius: 8px 8px 0 0 !important;
        background: transparent !important;
    }
    .nav-tabs .nav-link:hover {
        color: var(--primary-theme);
        background: rgba(21, 163, 98, 0.05) !important;
    }
    .nav-tabs .nav-link.active {
        color: var(--primary-theme) !important;
        border-bottom: 3px solid var(--primary-theme) !important;
        background: #ffffff !important;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.03);
    }

    /* Modern Surface and Sidebar Backgrounds */
    .step-sidebar-surface {
        background: #fbfcfd !important;
        border-color: #edf1f4 !important;
    }
    .step-search-surface {
        background: #ffffff !important;
        border-bottom: 1px solid #edf1f4 !important;
    }
    .modern-table-header th {
        background: #f8fafc !important;
        color: #475569 !important;
        font-weight: 700 !important;
        font-size: 0.8rem !important;
        border-bottom: 2px solid #e2e8f0 !important;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }
    .table-hover tbody tr:hover {
        background-color: #f7fbf9 !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Top Bar / Header Card -->
    <div class="timetable-header-card">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="step-pill">
                        <i class="bx bx-calendar-check"></i> ระบบจัดตารางสอนอัตโนมัติ
                    </span>
                </div>
                <h4 class="fw-bold mb-0 text-dark">
                    Timetable Process Wizard
                </h4>
                <p class="text-muted small mb-0 mt-1">กำหนดค่า มอบหมาย ล็อคเงื่อนไข และประมวลผลตารางด้วย AI อย่างเป็นขั้นตอน</p>
            </div>
            
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <button type="button" onclick="resetAllData()" class="btn btn-label-danger rounded-pill shadow-xs px-3">
                    <i class="bx bx-trash me-1"></i> ล้างข้อมูลทั้งหมด
                </button>
                <div class="dropdown">
                    <button class="btn btn-white border shadow-xs dropdown-toggle rounded-pill px-3 fw-bold" type="button" id="yearSelector" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class='bx bx-calendar-event me-2 text-success'></i>
                        <span>ปีการศึกษา <?= $selectedYear ?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 mt-2" aria-labelledby="yearSelector">
                        <li class="dropdown-header text-uppercase small pb-2">เลือกปีการศึกษา</li>
                        <?php foreach($available_years as $ay): ?>
                        <li>
                            <a class="dropdown-item py-2 change-year-btn <?= $ay->year == $selectedYear ? 'active bg-label-success' : '' ?>" 
                               href="javascript:void(0);" 
                               data-year="<?= $ay->year ?>">
                                <i class='bx bx-check me-2 <?= $ay->year == $selectedYear ? '' : 'opacity-0' ?>'></i>
                                ปีการศึกษา <?= $ay->year ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible shadow-sm border-start border-danger border-3 mt-3 mb-0" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bx bx-error-circle fs-3 me-2"></i>
                    <div class="fw-bold"><?= session()->getFlashdata('error') ?></div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible shadow-sm border-start border-success border-3 mt-3 mb-0" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bx bx-check-circle fs-3 me-2"></i>
                    <div class="fw-bold"><?= session()->getFlashdata('success') ?></div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>

    <!-- 📊 Dashboard-style Navigation Cards -->
    <div class="nav-cards-wrapper">
        <div class="card nav-card-item shadow-sm" onclick="goToStep(1)" id="nav-step-1">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="nav-card-icon me-3">
                        <i class='bx bx-slider-alt'></i>
                    </div>
                    <div class="overflow-hidden">
                        <span class="step-number-tag">STEP 1</span>
                        <p class="nav-card-title text-truncate">ตั้งค่าพื้นฐาน</p>
                        <p class="nav-card-subtitle text-truncate mb-0">วัน/เวลา/ช่วงพัก</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card nav-card-item shadow-sm" onclick="goToStep(2)" id="nav-step-2">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="nav-card-icon me-3">
                        <i class='bx bx-user-plus'></i>
                    </div>
                    <div class="overflow-hidden">
                        <span class="step-number-tag">STEP 2</span>
                        <p class="nav-card-title text-truncate">มอบหมายงาน</p>
                        <p class="nav-card-subtitle text-truncate mb-0">ครูสอน/วิชา/ห้อง</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card nav-card-item shadow-sm" onclick="goToStep(3)" id="nav-step-3">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="nav-card-icon me-3">
                        <i class='bx bx-lock-open-alt'></i>
                    </div>
                    <div class="overflow-hidden">
                        <span class="step-number-tag">STEP 3</span>
                        <p class="nav-card-title text-truncate">ล็อคเวลา</p>
                        <p class="nav-card-subtitle text-truncate mb-0">ล็อคครู/ล็อคห้อง</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card nav-card-item shadow-sm" onclick="goToStep(4)" id="nav-step-4">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="nav-card-icon me-3">
                        <i class='bx bx-brain'></i>
                    </div>
                    <div class="overflow-hidden">
                        <span class="step-number-tag">STEP 4</span>
                        <p class="nav-card-title text-truncate">ประมวลผล AI</p>
                        <p class="nav-card-subtitle text-truncate mb-0">จัดตารางอัตโนมัติ</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card nav-card-item shadow-sm" onclick="goToStep(5)" id="nav-step-5">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="nav-card-icon me-3">
                        <i class='bx <?= $overall_progress < 100 ? "bx-time-five text-warning" : "bx-check-double text-success" ?>'></i>
                    </div>
                    <div class="overflow-hidden">
                        <span class="step-number-tag <?= $overall_progress < 100 ? 'bg-warning text-dark' : '' ?>">STEP 5</span>
                        <p class="nav-card-title text-truncate">ตรวจสอบ</p>
                        <p class="nav-card-subtitle text-truncate mb-0"><?= $overall_progress < 100 ? "คืบหน้า {$overall_progress}%" : 'พิมพ์/ตรวจสอบ' ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-lg border-0 rounded-4 overflow-hidden wizard-container">
        <div class="card-body p-0 min-vh-50">
            
            <!-- --- STEP 1: BASIC SETTINGS --- -->
            <div class="wizard-step d-none" id="step-1">
                <div class="step-header-banner">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar avatar-md bg-label-success rounded-3 d-flex align-items-center justify-content-center">
                                <i class="bx bx-slider-alt fs-3 text-success"></i>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-label-success rounded-pill px-2 py-1 small">ขั้นตอนที่ 1</span>
                                    <h5 class="mb-0 fw-bold text-dark">ตั้งค่าพื้นฐานตารางสอน</h5>
                                </div>
                                <p class="text-muted small mb-0 mt-1">กำหนดวันเปิดเรียน คาบเรียน เวลาเริ่ม-สิ้นสุด และกิจกรรมส่วนกลางของภาคเรียนนี้</p>
                            </div>
                        </div>
                        <button class="btn btn-success rounded-pill px-4 next-step shadow-sm fw-bold" style="background: #15a362 !important; border: none;">
                            ไปขั้นตอนที่ 2: มอบหมายงาน <i class="bx bx-right-arrow-alt ms-1"></i>
                        </button>
                    </div>
                </div>

                <div class="p-4 p-lg-5">
                    <div class="row g-4">
                        <!-- 📅 Day Settings Card -->
                        <div class="col-md-4 col-lg-3">
                            <div class="card card-setting-step1 h-100 shadow-none" data-bs-toggle="modal" data-bs-target="#modalSettingDays">
                                <div class="card-body text-center py-4">
                                    <div class="avatar avatar-lg bg-label-success mx-auto mb-3">
                                        <i class="bx bx-calendar fs-2"></i>
                                    </div>
                                    <h6 class="fw-bold mb-1 text-dark">วันที่เปิดเรียน</h6>
                                    <p class="text-muted small mb-0">กำหนดวันเรียนในสัปดาห์</p>
                                </div>
                            </div>
                        </div>

                        <!-- ⏰ Period Settings Card -->
                        <div class="col-md-4 col-lg-3">
                            <div class="card card-setting-step1 h-100 shadow-none" data-bs-toggle="modal" data-bs-target="#modalSettingPeriods">
                                <div class="card-body text-center py-4">
                                    <div class="avatar avatar-lg bg-label-primary mx-auto mb-3">
                                        <i class="bx bx-time fs-2"></i>
                                    </div>
                                    <h6 class="fw-bold mb-1 text-dark">ตั้งค่าคาบเรียนและเวลา</h6>
                                    <p class="text-muted small mb-0">กำหนดเวลาและคาบพักกลางวัน</p>
                                </div>
                            </div>
                        </div>

                        <!-- 📚 Manage Subjects Card -->
                        <div class="col-md-4 col-lg-3">
                            <div class="card card-setting-step1 h-100 shadow-none" data-bs-toggle="modal" data-bs-target="#modalManageSubjects">
                                <div class="card-body text-center py-4">
                                    <div class="avatar avatar-lg bg-label-danger mx-auto mb-3">
                                        <i class="bx bx-book fs-2"></i>
                                    </div>
                                    <h6 class="fw-bold mb-1 text-dark">จัดการรายวิชา</h6>
                                    <p class="text-muted small mb-0">ดึงข้อมูลวิชาจากระบบทะเบียน</p>
                                </div>
                            </div>
                        </div>

                        <!-- 🏛️ Master Slots Card -->
                        <div class="col-md-4 col-lg-3">
                            <div class="card card-setting-step1 h-100 shadow-none" data-bs-toggle="modal" data-bs-target="#modalMasterSlots">
                                <div class="card-body text-center py-4">
                                    <div class="avatar avatar-lg bg-label-warning mx-auto mb-3">
                                        <i class="bx bx-calendar-star fs-2"></i>
                                    </div>
                                    <h6 class="fw-bold mb-1 text-dark">กิจกรรมส่วนกลาง</h6>
                                    <p class="text-muted small mb-0">ล็อคกิจกรรม (ชุมนุม, โฮมรูม)</p>
                                </div>
                            </div>
                        </div>


                    </div>

                    <!-- 💡 Instruction Alert -->
                    <div class="alert alert-info d-flex align-items-center mt-5 mb-0 border-0 shadow-sm rounded-4">
                        <i class='bx bx-bulb fs-3 me-2 text-info'></i>
                        <div>
                            <h6 class="alert-heading fw-bold mb-1">คำแนะนำการตั้งค่าพื้นฐาน</h6>
                            <p class="mb-0 small opacity-75">การเปลี่ยนแปลงข้อมูลในส่วนนี้ จะส่งผลให้ระบบ AI ต้องทำการจัดตารางสอนใหม่ทั้งหมด (ยกเว้นวิชาที่ถูกล็อคไว้) เพื่อให้แน่ใจว่าเงื่อนไขเวลาถูกต้องที่สุดครับ</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- --- STEP 2: ASSIGNMENT --- -->
            <div class="wizard-step d-none" id="step-2">
                <div class="step-header-banner">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar avatar-md bg-label-success rounded-3 d-flex align-items-center justify-content-center">
                                <i class="bx bx-user-plus fs-3 text-success"></i>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-label-success rounded-pill px-2 py-1 small">ขั้นตอนที่ 2</span>
                                    <h5 class="mb-0 fw-bold text-dark">การมอบหมายรายวิชาและผู้สอน</h5>
                                </div>
                                <p class="text-muted small mb-0 mt-1">กำหนดรายวิชา ครูผู้สอน ห้องเรียน และรูปแบบการแบ่งคาบเรียน (Period Split)</p>
                            </div>
                        </div>
                        <div class="d-flex gap-2 align-items-center flex-wrap">
                            <a href="<?= base_url('admin/academic/timetable/subject-groups') ?>" class="btn btn-label-info rounded-pill px-3 shadow-xs hover-elevate">
                                <i class="bx bx-layer fs-5 me-1"></i>
                                <span>จัดการกลุ่มเรียนพร้อมกัน</span>
                            </a>
                            <div id="group-actions" class="d-none animate__animated animate__fadeIn align-items-center gap-2">
                                <span class="badge bg-label-primary rounded-pill px-3 py-2 small fw-bold" id="selectedCountBadge">เลือก 0 รายการ</span>
                                <button type="button" class="btn btn-danger rounded-pill px-3 shadow-xs fw-bold" onclick="deleteSelectedAssignments()">
                                    <i class="bx bx-trash me-1"></i> ลบทั้งหมดจากที่เลือก (<span id="deleteSelectedCount">0</span>)
                                </button>
                                <button type="button" class="btn btn-success rounded-pill px-3 shadow-xs fw-bold" onclick="saveTeachingGroup()" style="background: #15a362 !important; border: none;">
                                    <i class="bx bx-package me-1"></i> มัดรวมกลุ่มสอนควบ
                                </button>
                                <button type="button" class="btn btn-label-secondary rounded-pill px-3" onclick="clearSelection()">
                                    ยกเลิก
                                </button>
                            </div>
                            <button type="button" class="btn btn-label-warning rounded-pill px-3 shadow-xs hover-elevate fw-bold" id="btnScanElectives" onclick="scanSmartElectives(true)">
                                <i class="bx bx-magic-wand fs-5 me-1"></i>
                                <span>สแกนวิชาเลือกคู่ขนาน</span>
                            </button>
                            <button type="button" class="btn btn-label-success rounded-pill px-3 shadow-xs hover-elevate fw-bold" onclick="openImportTeachingScheduleModal()">
                                <i class="bx bx-import fs-5 me-1"></i>
                                <span>ดึงข้อมูลจากตารางสอนกลุ่มสาระ</span>
                            </button>
                            <button class="btn btn-success rounded-pill px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalAddAssignment" style="background: #15a362 !important; border: none; color: #ffffff !important;">
                                <i class="bx bx-plus-circle fs-5 me-1"></i> เพิ่มการมอบหมาย
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Smart Electives Assistant Banner -->
                <div id="smartElectivesBanner" class="p-3 mx-4 my-3 rounded-3 border d-none" style="background: linear-gradient(135deg, #f0fdf4 0%, #e8f7f0 100%); border-color: #b8e8ce !important;">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar avatar-md bg-white rounded-circle shadow-xs d-flex align-items-center justify-content-center text-success flex-shrink-0">
                                <i class="bx bx-bulb fs-3" style="color: #15a362 !important;"></i>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-2">
                                    <h6 class="mb-0 fw-bold" style="color: #0c7a46;">ตรวจพบวิชาเลือกคู่ขนาน/แผนการเรียนเฉพาะทาง (5 คาบขึ้นไป) ที่สอนพร้อมกันในห้องเดียวกัน!</h6>
                                    <span class="badge rounded-pill bg-success fw-bold text-white" id="smartGroupCountBadge" style="background: #15a362 !important; color: #ffffff !important;">0 กลุ่ม</span>
                                </div>
                                <small class="text-muted">ระบบตรวจพบวิชาในห้องเดียวกันที่มี 5 คาบขึ้นไปและมีจำนวนคาบเท่ากัน (เช่น แผนกีฬา 9 คาบ, ศิลปกรรม 5-10 คาบ, การงานอาชีพ 5 คาบ) หากยังไม่มัดรวมกลุ่ม ชั่วโมงเรียนห้องจะถูกบวกซ้ำจนเกินสัปดาห์</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <button type="button" class="btn btn-sm btn-outline-success fw-bold rounded-pill px-3" id="btnToggleSmartGroupDetails" onclick="toggleSmartGroupDetails()">
                                <i class="bx bx-list-ul me-1"></i> ดูรายละเอียด (<span id="smartGroupTotalAssignments">0</span> รายการ)
                            </button>
                            <button type="button" class="btn btn-sm btn-success fw-bold rounded-pill px-3 shadow-xs" id="btnApplyAllSmartGroups" onclick="applyAllSmartGroups()" style="background: #15a362 !important; border-color: #15a362 !important; color: #ffffff !important;">
                                <i class="bx bx-check-double me-1"></i> มัดรวมทั้งหมดทันที (1-Click)
                            </button>
                        </div>
                    </div>
                    <!-- Detailed candidate cards container -->
                    <div id="smartGroupCardsWrapper" class="mt-3 pt-3 border-top d-none" style="border-color: rgba(21, 163, 98, 0.2) !important;">
                        <div class="row g-3" id="smartGroupCardsRow">
                            <!-- Dynamically populated candidate cards -->
                        </div>
                    </div>
                </div>

                <!-- Search and summary bar -->
                <div class="px-4 py-3 step-search-surface d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="input-group input-group-merge" style="max-width: 450px;">
                        <span class="input-group-text text-muted"><i class="bx bx-search fs-4"></i></span>
                        <input type="text" class="form-control" id="searchAssignmentInput" placeholder="ค้นหา วิชา, รหัสวิชา, หรือชื่อครูผู้สอน...">
                        <button class="btn btn-outline-secondary" type="button" id="btnClearSearch" style="display: none; border-color: #d9dee3;"><i class="bx bx-x fs-4"></i></button>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-bold shadow-xs" id="btnFilterGroupedOnly" onclick="toggleFilterGroupedOnly()">
                            <i class="bx bx-package me-1"></i>ดูเฉพาะกลุ่มที่มัดรวมแล้ว
                        </button>
                        <div class="badge p-2 px-3 rounded-pill border fs-6 shadow-xs" style="color: #15a362 !important; background-color: #e8f7f0 !important; border-color: #c3ebd6 !important;">
                            <i class="bx bx-book-open me-2" style="color: #15a362 !important;"></i>วิชาที่พบ: <span id="filteredSubjectCount" class="fw-bold">0</span> วิชา
                        </div>
                        <div class="badge bg-label-primary p-2 px-3 rounded-pill border border-primary-subtle fs-6 shadow-xs">
                            <i class="bx bx-time-five me-2"></i>ภาระงานสอนรวม: <span id="filteredPeriodCount" class="fw-bold">0</span> คาบ
                        </div>
                    </div>
                </div>
                <div class="table-responsive" style="max-height: 500px;" id="assignmentListContainer">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="modern-table-header sticky-top">
                            <tr>
                                <th class="text-center py-3" style="width: 50px;">
                                    <input class="form-check-input" type="checkbox" id="check-all-assignments">
                                </th>
                                <th class="ps-4 py-3">รหัส / ชื่อวิชา</th>
                                <th class="text-center py-3">ห้องเรียน</th>
                                <th class="text-center py-3">คาบ/สัปดาห์</th>
                                <th class="text-center py-3">รูปแบบการหั่นคาบ</th>
                                <th class="text-center py-3 pe-4">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($assignments)): ?>
                                <tr><td colspan="6" class="text-center py-5 text-muted">
                                    <img src="<?= base_url('assets/img/illustrations/empty-box.png') ?>" width="100" class="mb-3 d-block mx-auto opacity-50">
                                    ยังไม่มีข้อมูลการมอบหมาย
                                </td></tr>
                            <?php else: foreach($assignments as $g): 
                                $a = $g['data']; 
                                $tNames = array_column($g['teachers'], 'name');
                                
                                $search_texts = [];
                                foreach ($g['subjects'] as $sub) {
                                    $search_texts[] = $sub['code'];
                                    $search_texts[] = $sub['name'];
                                }
                                foreach ($g['teachers'] as $t) {
                                    $search_texts[] = $t['name'];
                                }
                                $search_str = mb_strtolower(implode(' ', $search_texts));
                                
                                $class_count = count($g['classes']);
                                $total_hours = $a->group_id ? $a->hours_per_week : ($a->hours_per_week * $class_count);
                            ?>
                                <tr class="assignment-row align-middle" data-search="<?= esc($search_str) ?>" data-hours="<?= $total_hours ?>">
                                    <td class="text-center">
                                        <input class="form-check-input assign-checkbox" type="checkbox" value="<?= implode(',', $g['ids']) ?>">
                                    </td>
                                    <td class="ps-4">
                                        <?php foreach($g['subjects'] as $sub): ?>
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <div class="fw-bold text-dark fs-6">[<?= $sub['code'] ?>] <?= $sub['name'] ?></div>
                                            <?php if($a->group_id): ?>
                                                <span class="badge bg-label-success border border-success-subtle p-0 px-1" style="font-size: 0.6rem;">
                                                    <i class="bx bx-package me-1"></i>กลุ่มเรียนพร้อมกัน
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <?php endforeach; ?>
                                        <div class="small text-muted mt-1"><i class='bx bx-user-voice me-1'></i><?= implode(', ', $tNames) ?></div>
                                    </td>
                                    <td class="text-center">
                                        <?php foreach($g['classes'] as $cls): ?>
                                            <span class="badge bg-label-info mb-1 rounded-pill"><?= $cls ?></span>
                                        <?php endforeach; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php 
                                        $class_count = count($g['classes']);
                                        if ($a->group_id) {
                                            // เรียนรวม/สอนควบ: นับเป็นคาบปกติเพราะสอนพร้อมกันในเวลาเดียว
                                            $total_hours = $a->hours_per_week;
                                            ?>
                                            <span class="fw-bold text-primary fs-6"><?= $total_hours ?> คาบ</span>
                                            <small class="text-success d-block fw-semibold" style="font-size: 0.7rem;">
                                                <i class="bx bx-package me-1" style="font-size: 0.8rem;"></i>สอนควบ <?= $class_count ?> ห้อง
                                            </small>
                                            <small class="text-muted d-block" style="font-size: 0.65rem;">
                                                (คิดภาระงานรวม <?= $total_hours ?> คาบ)
                                            </small>
                                            <?php
                                        } else if ($class_count > 1) {
                                            // สอนแยกห้อง: คาบสอนรวม = คาบต่อห้อง * จำนวนห้อง
                                            $total_hours = $a->hours_per_week * $class_count;
                                            ?>
                                            <span class="fw-bold text-success fs-6" style="color: #15a362 !important;">รวม <?= $total_hours ?> คาบ</span>
                                            <small class="text-muted d-block" style="font-size: 0.7rem;">
                                                (<?= $a->hours_per_week ?> คาบ × <?= $class_count ?> ห้อง)
                                            </small>
                                            <?php
                                        } else {
                                            // สอนห้องเดียวปกติ
                                            ?>
                                            <span class="fw-bold text-primary fs-6"><?= $a->hours_per_week ?> คาบ</span>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-label-warning rounded-pill"><?= $a->period_split ?: 'ยังไม่ได้กำหนด' ?></span>
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="d-flex justify-content-center gap-2">
                                            <button class="btn btn-sm btn-icon btn-label-warning rounded-pill btn-edit-assignment" 
                                                data-subject="<?= $a->subject_id ?>" 
                                                data-teachers="<?= implode(',', array_column($g['teachers'], 'id')) ?>"
                                                data-classes="<?= implode(',', $g['classes']) ?>"
                                                data-hours="<?= $a->hours_per_week ?>"
                                                data-split="<?= $a->period_split ?>"
                                                data-ids="<?= implode(',', $g['ids']) ?>">
                                                <i class="bx bx-edit-alt"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon btn-label-danger rounded-pill btn-delete-assignment" data-ids="<?= implode(',', $g['ids']) ?>">
                                                <i class="bx bx-trash-alt"></i>
                                            </button>
                                            <?php if($a->group_id): ?>
                                            <button type="button" class="btn btn-sm btn-icon btn-label-danger rounded-pill btn-delete-teaching-group" data-ids="<?= implode(',', $g['ids']) ?>" title="แยกกลุ่มสอนควบ">
                                                <i class="bx bx-unlink"></i>
                                            </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- --- STEP 3: CONSTRAINTS --- -->
            <div class="wizard-step d-none" id="step-3">
                <div class="step-header-banner">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar avatar-md bg-label-success rounded-3 d-flex align-items-center justify-content-center">
                                <i class="bx bx-lock-open-alt fs-3 text-success"></i>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-label-success rounded-pill px-2 py-1 small">ขั้นตอนที่ 3</span>
                                    <h5 class="mb-0 fw-bold text-dark">กำหนดเงื่อนไขและการล็อคเวลา (Constraints)</h5>
                                </div>
                                <p class="text-muted small mb-0 mt-1">ล็อคคาบวิชาเฉพาะเจาะจง กำหนดเวลาไม่ว่างของครู และกำหนดการล็อคการใช้งานห้องเรียน</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="nav-align-top mb-0">
                    <ul class="nav nav-tabs nav-fill border-bottom p-2" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active fw-bold py-3" role="tab" data-bs-toggle="tab" data-bs-target="#tab-subject-locks">
                                <i class="bx bx-book-bookmark me-2 fs-5"></i> 1. ล็อคคาบวิชาในห้องเรียน
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link fw-bold py-3" role="tab" data-bs-toggle="tab" data-bs-target="#tab-teacher-locks">
                                <i class="bx bx-user-x me-2 fs-5"></i> 2. ล็อคเวลาไม่ว่างของครู
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link fw-bold py-3" role="tab" data-bs-toggle="tab" data-bs-target="#tab-room-locks">
                                <i class="bx bx-building-house me-2 fs-5"></i> 3. ล็อคการใช้ห้องปฏิบัติการ
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content p-0 border-0 shadow-none bg-white">
                        <!-- 📌 Tab 1: Subject Locks -->
                        <div class="tab-pane fade show active" id="tab-subject-locks" role="tabpanel">
                            <div class="row g-0">
                                <div class="col-lg-3 border-end step-sidebar-surface p-4" style="min-height: 500px;">
                                    <label class="form-label fw-bold small text-uppercase mb-2">เลือกห้องเรียน</label>
                                    <select class="form-select border-primary shadow-sm rounded-3" id="wizardClassSelect">
                                        <option value="">-- เลือกห้องเรียน --</option>
                                        <?php foreach($assigned_classes as $c): ?>
                                        <option value="<?= $c->class_name ?>">ห้องเรียน <?= $c->class_name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="mt-4">
                                        <label class="form-label fw-bold small text-uppercase mb-2 d-flex justify-content-between">รายการวิชา <span class="badge bg-label-success" id="subjectCountBadge">0</span></label>
                                        <div id="wizardSubjectList" class="d-flex flex-column gap-3" style="max-height: 400px; overflow-y: auto;">
                                            <div class="text-center py-5 bg-white rounded-3 border border-dashed text-muted small">
                                                <i class="bx bx-mouse-alt fs-2 mb-2 d-block opacity-25"></i> เลือกห้องเรียนก่อน
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-9 p-0 bg-white min-vh-50">
                                    <div id="gridLoader" class="d-none glass-loader text-center py-5 h-100 d-flex flex-column align-items-center justify-content-center">
                                        <div class="spinner-grow text-success mb-3" role="status"></div>
                                        <h6 class="text-muted fw-bold">กำลังโหลดตารางห้องเรียน...</h6>
                                    </div>
                                    <div id="constraintGridContainer"></div>
                                </div>
                            </div>
                        </div>

                        <!-- 👨‍🏫 Tab 2: Teacher Locks -->
                        <div class="tab-pane fade" id="tab-teacher-locks" role="tabpanel">
                            <div class="row g-0">
                                <div class="col-lg-3 border-end step-sidebar-surface p-4">
                                    <label class="form-label fw-bold small text-uppercase mb-2">เลือกครูผู้สอน</label>
                                    <select class="form-select select2" id="wizardTeacherSelect">
                                        <option value="">-- เลือกครู --</option>
                                        <?php foreach($all_personnel as $p): ?>
                                        <option value="<?= $p->pers_id ?>"><?= $p->pers_prefix ?><?= $p->pers_firstname ?> <?= $p->pers_lastname ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="alert alert-warning border-0 shadow-sm mt-4 small">
                                        <i class="bx bx-info-circle me-1"></i> คลิกที่ช่องในตารางเพื่อ <b>"ล็อคเวลาไม่ว่าง"</b> ของครูคนนี้
                                    </div>
                                </div>
                                <div class="col-lg-9 p-0 bg-white min-vh-50">
                                    <div id="teacherGridLoader" class="d-none text-center py-5"><div class="spinner-border text-primary"></div></div>
                                    <div id="teacherConstraintGridContainer" class="p-3"></div>
                                </div>
                            </div>
                        </div>

                        <!-- 🏢 Tab 3: Room Locks -->
                        <div class="tab-pane fade" id="tab-room-locks" role="tabpanel">
                            <div class="row g-0">
                                <div class="col-lg-3 border-end step-sidebar-surface p-4">
                                    <label class="form-label fw-bold small text-uppercase mb-2">เลือกห้องเรียน/ห้องปฏิบัติการ</label>
                                    <select class="form-select select2" id="wizardRoomSelect">
                                        <option value="">-- เลือกห้อง --</option>
                                        <?php foreach($all_rooms as $r): ?>
                                        <option value="<?= $r->ClassName ?>">ห้อง <?= $r->ClassName ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-9 p-0 bg-white min-vh-50">
                                    <div id="roomGridLoader" class="d-none text-center py-5"><div class="spinner-border text-primary"></div></div>
                                    <div id="roomConstraintGridContainer" class="p-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- --- STEP 4: GENERATION --- -->
            <div class="wizard-step d-none" id="step-4">
                <div class="step-header-banner">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar avatar-md bg-label-success rounded-3 d-flex align-items-center justify-content-center">
                                <i class="bx bx-brain fs-3 text-success"></i>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-label-success rounded-pill px-2 py-1 small">ขั้นตอนที่ 4</span>
                                    <h5 class="mb-0 fw-bold text-dark">ระบบประมวลผลตารางสอนอัตโนมัติ (AI Engine)</h5>
                                </div>
                                <p class="text-muted small mb-0 mt-1">ประมวลผลและจัดคาบเรียนที่เหลือทั้งหมดโดยคำนึงถึงเงื่อนไขการล็อคเวลาและความขัดแย้ง 100%</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-4 p-lg-5">
                    <div class="card border-0 text-center rounded-4 p-4 p-lg-5" style="background: linear-gradient(180deg, #f7fdf9 0%, #edf9f2 100%); border: 1px solid #c9ebd8 !important;">
                        <div class="mb-3">
                            <div class="avatar avatar-xl d-inline-block shadow-sm rounded-circle p-1" style="background: #ffffff;">
                                <span class="avatar-initial rounded-circle text-white shadow" style="background: var(--primary-gradient); width: 60px; height: 60px;">
                                    <i class="bx bx-bot fs-2"></i>
                                </span>
                            </div>
                        </div>
                        <h3 class="fw-bold text-dark mb-2">พร้อมสำหรับการจัดตารางด้วย AI หรือยัง?</h3>
                        <p class="text-muted mx-auto mb-4 fs-6" style="max-width: 600px;">
                            ระบบ AI จะดึงเงื่อนไขที่คุณกำหนดไว้ทั้งหมดมาประมวลผลและเติมเต็มคาบเรียนที่ยังว่างอยู่ให้สมบูรณ์ โดยไม่เกิดข้อขัดแย้งของครู ห้อง และคาบเรียน
                        </p>

                        <!-- 🎛️ AI Settings & Search Depth -->
                        <div class="card bg-white border shadow-xs rounded-4 p-3 mb-4 mx-auto text-start" style="max-width: 650px;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label fw-bold text-dark mb-0 small"><i class="bx bx-cog me-1 text-success"></i> เลือกระดับความละเอียดการค้นหา (Search Depth)</label>
                                <span class="badge bg-label-success rounded-pill px-2 py-1 small" id="modeDescription">ค้นหารวดเร็ว (1-2 วิ)</span>
                            </div>
                            <div class="btn-group w-100" role="group" aria-label="AI Search Depth">
                                <input type="radio" class="btn-check" name="ai_depth_option" id="depth_10" value="10" checked>
                                <label class="btn btn-outline-success rounded-start-pill py-2" for="depth_10">
                                    <i class="bx bx-zap me-1"></i> ปกติ (10 รอบ)
                                </label>

                                <input type="radio" class="btn-check" name="ai_depth_option" id="depth_30" value="30">
                                <label class="btn btn-outline-success py-2" for="depth_30">
                                    <i class="bx bx-brain me-1"></i> เชิงลึก (30 รอบ)
                                </label>

                                <input type="radio" class="btn-check" name="ai_depth_option" id="depth_50" value="50">
                                <label class="btn btn-outline-success rounded-end-pill py-2" for="depth_50">
                                    <i class="bx bx-search-alt me-1"></i> ขั้นสูง (50 รอบ)
                                </label>
                            </div>
                            <div class="form-text small text-muted mt-2">
                                <i class="bx bx-info-circle me-1"></i> หากมีวิชาที่ครู 1 คนสอนหลายห้อง หรือล็อคเวลาไว้แน่น แนะนำให้เลือก <b>โหมดเชิงลึก 30 รอบ</b>
                            </div>
                        </div>

                        <!-- 🔍 Pre-flight Capacity Check Section -->
                        <div class="mb-4">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4 py-2 shadow-2xs" id="btnPreflightCheck">
                                <i class="bx bx-shield-quarter me-1 text-primary"></i> ตรวจสอบความจุและความพร้อมก่อนรัน (Pre-flight Check)
                            </button>
                        </div>
                        <div id="preflightResultContainer" class="mx-auto mb-4 text-start d-none" style="max-width: 650px;">
                            <!-- Rendered by JS -->
                        </div>

                        <div>
                            <button class="btn btn-success btn-lg px-5 py-3 rounded-pill shadow-lg fw-bold" id="btnAIGenerate" style="background: #15a362 !important; border: none; font-size: 1.05rem;">
                                <i class='bx bxs-magic-wand me-2 fs-4'></i> เริ่มประมวลผลจัดตาราง (AI Run)
                            </button>
                        </div>
                    </div>
                    <div id="aiReportContainer" class="mt-4 text-start mx-auto" style="max-width: 800px;">
                        <!-- Report generated by JS -->
                        <div class="row mt-3">
                            <div class="col-md-9 mx-auto">
                                <div class="alert alert-info border-0 shadow-xs d-flex align-items-center rounded-3 mb-0">
                                    <i class='bx bx-info-circle fs-4 me-2 text-info'></i>
                                    <div class="small"><b>หมายเหตุ:</b> ระบบจะคงวิชาและเวลาที่คุณล็อคไว้ในขั้นตอนที่ 3 เสมอ และจัดเฉพาะคาบอิสระที่เหลือให้ลงตัวครับ</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- --- STEP 5: FINISH --- -->
            <div class="wizard-step d-none" id="step-5">
                <div class="step-header-banner">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar avatar-md bg-label-success rounded-3 d-flex align-items-center justify-content-center">
                                <i class="bx bx-check-double fs-3 text-success"></i>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-label-success rounded-pill px-2 py-1 small">ขั้นตอนที่ 5</span>
                                    <h5 class="mb-0 fw-bold text-dark">ตรวจสอบและอนุมัติตารางสอน</h5>
                                </div>
                                <p class="text-muted small mb-0 mt-1">แสดงผลภาพรวม ตรวจสอบคุณภาพตารางเรียน และส่งต่อไปยัง Editor</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-4 p-lg-5">
                    <?php if($overall_progress < 100): ?>
                    <div class="text-center py-4">
                        <div class="mb-3">
                            <i class='bx bx-time-five text-warning pulse-animation' style="font-size: 5rem;"></i>
                        </div>
                        <h3 class="fw-bold text-dark">ตารางสอนยังจัดไม่ครบ 100% (ความคืบหน้า <?= $overall_progress ?>%)</h3>
                        <p class="text-muted mb-4 mx-auto" style="max-width: 620px;">
                            ตารางสอนในภาคเรียนนี้ถูกจัดไปแล้วบางส่วน (<span class="fw-bold text-warning"><?= $overall_progress ?>%</span>) 
                            คุณครูสามารถเลือกที่จะ <b>รัน AI ต่อในขั้นตอนที่ 4</b> หรือ <b>เปิดหน้า Editor เพื่อลากจัดวิชาที่เหลือด้วยตนเอง</b> ได้ทันทีครับ
                        </p>
                        <div class="d-flex justify-content-center flex-wrap gap-3 mb-4">
                            <a href="<?= base_url('admin/academic/timetable/editor') ?>" class="btn btn-warning btn-lg rounded-pill px-4 shadow">
                                <i class="bx bx-edit-alt me-2"></i> เข้าจัดการด้วยตนเองใน Editor
                            </a>
                            <button class="btn btn-primary btn-lg rounded-pill px-4 shadow" onclick="goToStep(4)">
                                <i class="bx bx-bot me-2"></i> ไปหน้าประมวลผล AI
                            </button>
                            <button class="btn btn-label-secondary btn-lg rounded-pill px-3" onclick="location.reload()">
                                <i class="bx bx-refresh me-1"></i> ตรวจสอบสถานะใหม่
                            </button>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="text-center">
                        <div class="mb-4">
                            <i class='bx bxs-check-circle text-success pulse-animation' style="font-size: 5rem;"></i>
                        </div>
                        <h2 class="fw-bold">ประมวลผลเสร็จสมบูรณ์ 100%</h2>
                        <p class="text-muted mb-4">ตารางสอนสำหรับภาคเรียน <span class="fw-bold text-success"><?= $term ?>/<?= $year ?></span> ถูกจัดเรียบร้อยและตรวจสอบความขัดแย้งแล้ว</p>
                        
                        <!-- 🌟 Public Display Mode Switcher Card in Step 5 -->
                        <div class="card border-0 shadow-sm mb-5 text-start mx-auto" style="max-width: 1000px; border-radius: 16px; background: linear-gradient(135deg, #ffffff 0%, #f8fdfa 100%); border-left: 5px solid #15a362 !important;">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar avatar-md rounded-circle d-flex align-items-center justify-content-center" style="background-color: #e8f7f0; color: #15a362; width: 48px; height: 48px; font-size: 1.5rem;">
                                            <i class="bx bx-broadcast"></i>
                                        </div>
                                        <div>
                                            <div class="d-flex align-items-center gap-2">
                                                <h5 class="mb-0 fw-bold text-dark">โหมดการเผยแพร่ตารางเรียน (Public Display Mode)</h5>
                                                <span class="badge <?= ($display_mode === 'system') ? 'bg-success' : 'bg-info' ?> rounded-pill px-3 py-1" id="badgeCurrentModeStep5">
                                                    <?= ($display_mode === 'system') ? '🟢 กำลังแสดงจากระบบจัดตารางสอน (Live)' : '📁 กำลังแสดงจากไฟล์รูปภาพ (Upload)' ?>
                                                </span>
                                            </div>
                                            <p class="text-muted small mb-0 mt-1">
                                                กำหนดว่าหน้าเว็บ <code>/ClassSchedule</code> สำหรับนักเรียนและบุคคลทั่วไป จะดึงข้อมูลจากตารางสอนในระบบ หรือไฟล์รูปภาพที่อัปโหลด
                                            </p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center gap-2 bg-white p-1 rounded-pill border shadow-2xs">
                                        <button type="button" class="btn btn-sm btn-timetable-mode-toggle rounded-pill px-3 fw-bold <?= ($display_mode === 'system') ? 'btn-success active-mode shadow-xs' : 'btn-light text-muted' ?>" data-mode="system" style="<?= ($display_mode === 'system') ? 'background-color: #15a362; border-color: #15a362;' : '' ?>">
                                            <i class="bx bx-grid-alt me-1"></i> ระบบจัดตารางสอน
                                        </button>
                                        <button type="button" class="btn btn-sm btn-timetable-mode-toggle rounded-pill px-3 fw-bold <?= ($display_mode === 'upload') ? 'btn-primary active-mode shadow-xs' : 'btn-light text-muted' ?>" data-mode="upload">
                                            <i class="bx bx-image me-1"></i> ไฟล์รูปภาพ
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- 📊 Live Preview Section -->
                        <div class="text-start mb-5 mx-auto" style="max-width: 1000px;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0 fw-bold"><i class='bx bx-show me-1 text-primary'></i> ตรวจสอบตารางเรียนรายห้อง</h5>
                                <div style="width: 250px;">
                                    <select class="form-select select2-simple" id="finishClassSelect">
                                        <option value="">-- เลือกห้องเรียน --</option>
                                        <?php foreach($assigned_classes as $c): ?>
                                        <option value="<?= $c->class_name ?>">ห้องเรียน <?= $c->class_name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div id="finishTimetableLoader" class="d-none text-center py-5">
                                <div class="spinner-border text-primary"></div>
                            </div>
                            <div id="finishTimetableContainer" class="bg-white rounded-3 shadow-sm border p-1" style="min-height: 200px;">
                                <div class="text-center py-5 text-muted">
                                    <i class="bx bx-mouse-alt fs-1 d-block mb-2 opacity-25"></i>
                                    <p>เลือกห้องเรียนด้านบนเพื่อแสดงตาราง</p>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center align-items-center flex-wrap gap-3 mt-4">
                            <button class="btn btn-label-warning btn-lg px-4 rounded-pill shadow-sm" id="btnAuditSchedule">
                                <i class='bx bx-shield-quarter me-2'></i> ตรวจสอบคุณภาพตาราง
                            </button>
                            <a href="<?= base_url('admin/academic/timetable/full') ?>" target="_blank" class="btn btn-label-success btn-lg px-4 rounded-pill shadow-sm">
                                <i class='bx bx-grid-alt me-2'></i> ตารางรวมทั้งโรงเรียน
                            </a>
                            <a href="<?= base_url('admin/academic/timetable/teacher-timetables') ?>" target="_blank" class="btn btn-label-info btn-lg px-4 rounded-pill shadow-sm">
                                <i class='bx bx-user me-2'></i> ตารางสอนรายครู
                            </a>
                            <a href="<?= base_url('admin/academic/timetable/class-timetables') ?>" target="_blank" class="btn btn-label-secondary btn-lg px-4 rounded-pill shadow-sm">
                                <i class='bx bx-group me-2'></i> ตารางเรียนรายห้อง
                            </a>
                            <a href="<?= base_url('admin/academic/timetable/editor') ?>" class="btn btn-primary btn-lg px-5 rounded-pill shadow-lg">
                                <i class='bx bx-edit-alt me-2'></i> ไปหน้าจัดการตาราง (Editor)
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>

        <!-- Footer Control Bar -->
        <div class="card-footer border-top bg-white py-3 px-4 shadow-sm">
            <div class="d-flex justify-content-between align-items-center">
                <button class="btn btn-label-secondary btn-lg rounded-pill px-4 prev-step d-none" id="btnPrev">
                    <i class="bx bx-chevron-left me-1"></i> ย้อนกลับ
                </button>
                <div class="text-center flex-grow-1">
                    <span class="text-muted small fw-bold text-uppercase" id="stepIndicator">ขั้นตอนที่ 1 จาก 5</span>
                    <div class="progress mt-1 mx-auto" style="height: 4px; width: 200px;">
                        <div class="progress-bar bg-success" role="progressbar" id="wizardProgressBar" style="width: 20%;"></div>
                    </div>
                </div>
                <button class="btn btn-primary btn-lg rounded-pill px-5 next-step shadow-sm" id="btnNext">
                    ถัดไป <i class="bx bx-chevron-right ms-1"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<!-- Modal: Import Teaching Schedule from Learning Groups -->
<div class="modal fade" id="modalImportTeachingSchedule" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 840px;">
        <form class="modal-content border-0 rounded-4 shadow-lg overflow-hidden" id="formImportTeachingSchedule">
            <?= csrf_field() ?>
            <!-- Header -->
            <div class="modal-header border-bottom py-3 px-4" style="background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%);">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md rounded-3 d-flex align-items-center justify-content-center shadow-xs" style="background: #e8f7f0; color: #15a362; width: 44px; height: 44px;">
                        <i class="bx bx-import fs-2" style="color: #15a362;"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <h5 class="modal-title fw-bold text-dark mb-0">ดึงข้อมูลจากตารางสอนกลุ่มสาระ</h5>
                            <span class="badge rounded-pill px-2 py-0 small fw-bold" style="background: #15a362; color: #ffffff !important; font-size: 0.7rem;">นำเข้าอัตโนมัติ</span>
                        </div>
                        <p class="text-muted small mb-0 mt-1">คัดลอกภาระงานสอนที่ครูในกลุ่มสาระฯ ได้เพิ่มไว้ เข้าสู่ขั้นตอนการจัดตารางสอน</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body p-4 bg-white">
                
                <!-- 1. Source & Target Transfer Card -->
                <div class="p-3 rounded-3 border mb-3" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                    <div class="row align-items-center g-3">
                        <div class="col-md-5">
                            <label class="form-label fw-bold text-dark small mb-1 d-flex align-items-center gap-1">
                                <i class="bx bx-server text-success fs-6"></i>
                                <span>ภาคเรียนต้นทาง (กลุ่มสาระ)</span>
                            </label>
                            <select class="form-select select2" id="import_source_year_term" name="source_year_term" required>
                                <?php if(!empty($teaching_schedule_years)): ?>
                                    <?php foreach($teaching_schedule_years as $tsy): ?>
                                        <option value="<?= $tsy->term ?>/<?= $tsy->year ?>" data-term="<?= $tsy->term ?>" data-year="<?= $tsy->year ?>" data-count="<?= $tsy->count ?>" <?= ($tsy->term.'/'.$tsy->year == $selectedYear) ? 'selected' : '' ?>>
                                            ภาคเรียนที่ <?= $tsy->term ?>/<?= $tsy->year ?> (<?= number_format($tsy->count) ?> รายการ)
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="<?= $selectedYear ?>" data-term="<?= $term ?>" data-year="<?= $year ?>" data-count="0">
                                        ภาคเรียนที่ <?= $selectedYear ?>
                                    </option>
                                <?php endif; ?>
                            </select>
                            <div class="text-muted small mt-1" style="font-size: 0.72rem;">
                                <i class="bx bx-info-circle me-1 text-muted"></i>ข้อมูลที่ครูในกลุ่มสาระบันทึกไว้
                            </div>
                        </div>

                        <div class="col-md-2 text-center d-none d-md-flex flex-column align-items-center justify-content-center">
                            <div class="avatar avatar-sm rounded-circle shadow-xs d-flex align-items-center justify-content-center border" style="background: #ffffff; color: #15a362; width: 36px; height: 36px;">
                                <i class="bx bx-right-arrow-alt fs-4"></i>
                            </div>
                            <span class="text-muted fw-bold mt-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">นำเข้าสู่</span>
                        </div>

                        <div class="col-md-5">
                            <label class="form-label fw-bold text-dark small mb-1 d-flex align-items-center gap-1">
                                <i class="bx bx-calendar-event text-primary fs-6"></i>
                                <span>ตารางสอนปลายทาง (ปีที่จัด)</span>
                            </label>
                            <select class="form-select select2" id="import_target_year_term" name="target_year_term" required>
                                <?php foreach($available_years as $ay): ?>
                                    <option value="<?= $ay->year ?>" <?= ($ay->year == $selectedYear) ? 'selected' : '' ?>>
                                        ภาคเรียนที่ <?= $ay->year ?> <?= ($ay->year == $selectedYear) ? '(ปีปัจจุบันที่เปิดอยู่)' : '' ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="text-muted small mt-1" style="font-size: 0.72rem;">
                                <i class="bx bx-check-shield me-1 text-success"></i>ตารางสอนที่จะบันทึกการมอบหมาย
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Live Preview Card -->
                <div class="card border rounded-3 mb-3 shadow-none overflow-hidden" style="background: #ffffff; border-color: #e2e8f0 !important;" id="importPreviewCard">
                    <div class="card-header py-2 px-3 border-bottom d-flex justify-content-between align-items-center" style="background: #f8fafc;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bx bx-bar-chart-alt-2 text-success fs-5"></i>
                            <span class="fw-bold small text-dark">สรุปข้อมูลที่จะถูกนำเข้า</span>
                            <span class="badge bg-label-info rounded-pill px-2 py-0 small" id="badgeSourceRecords">มีข้อมูล</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="small text-muted" style="font-size: 0.75rem;">ระดับชั้น: <strong id="prevGradeLevelsBadge" class="text-dark">-</strong></span>
                            <span class="spinner-border spinner-border-sm text-success d-none" id="previewLoadingSpinner" role="status"></span>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-2 text-center" id="previewStatsContainer">
                            <div class="col-3">
                                <div class="p-2 rounded-2 border" style="background: #f0fdf4; border-color: #bbf7d0 !important;">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <i class="bx bx-user-check text-success fs-5"></i>
                                        <span class="fs-4 fw-bold text-success" id="prevTeacherCount">-</span>
                                    </div>
                                    <small class="text-muted fw-semibold d-block" style="font-size: 0.72rem;">ครูผู้สอน</small>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="p-2 rounded-2 border" style="background: #eff6ff; border-color: #bfdbfe !important;">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <i class="bx bx-book text-primary fs-5"></i>
                                        <span class="fs-4 fw-bold text-primary" id="prevSubjectCount">-</span>
                                    </div>
                                    <small class="text-muted fw-semibold d-block" style="font-size: 0.72rem;">รายวิชา</small>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="p-2 rounded-2 border" style="background: #fffbeb; border-color: #fde68a !important;">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <i class="bx bx-building-house text-warning fs-5"></i>
                                        <span class="fs-4 fw-bold text-warning" id="prevClassroomCount">-</span>
                                    </div>
                                    <small class="text-muted fw-semibold d-block" style="font-size: 0.72rem;">ห้องเรียน</small>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="p-2 rounded-2 border" style="background: #f5f3ff; border-color: #ddd6fe !important;">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <i class="bx bx-time text-info fs-5" style="color: #7c3aed !important;"></i>
                                        <span class="fs-4 fw-bold text-info" id="prevHoursCount" style="color: #7c3aed !important;">-</span>
                                    </div>
                                    <small class="text-muted fw-semibold d-block" style="font-size: 0.72rem;">คาบ/สัปดาห์</small>
                                </div>
                            </div>
                        </div>

                        <!-- Sample items list with max-height and custom scroll -->
                        <div class="mt-2 pt-2 border-top" id="previewDetailsArea">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <small class="text-muted fw-semibold" style="font-size: 0.75rem;">
                                    <i class="bx bx-list-check me-1"></i>ตัวอย่างวิชาที่จะถูกนำเข้า:
                                </small>
                            </div>
                            <div class="d-flex flex-wrap gap-1 p-2 rounded-2 bg-light-subtle" id="prevSampleBadges" style="max-height: 72px; overflow-y: auto;">
                                <span class="text-muted small">กำลังโหลดข้อมูล...</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Import Mode Selection -->
                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small mb-2 d-flex align-items-center gap-1">
                        <i class="bx bx-cog text-secondary fs-6"></i>
                        <span>รูปแบบการนำเข้าข้อมูล (Import Mode)</span>
                    </label>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="border rounded-3 p-3 h-100 d-flex align-items-start gap-2 cursor-pointer bg-white shadow-xs position-relative w-100 mb-0 import-mode-option" for="importModeReplace">
                                <input name="import_mode" class="form-check-input mt-1 flex-shrink-0" type="radio" value="replace" id="importModeReplace" checked style="cursor: pointer; margin: 0; float: none;">
                                <div class="ms-1">
                                    <span class="fw-bold text-dark d-block">แทนที่ข้อมูลเดิม <span class="badge bg-label-success ms-1 small py-0">แนะนำ</span></span>
                                    <small class="text-muted d-block mt-1" style="font-size: 0.75rem; line-height: 1.3;">ล้างข้อมูลเดิม แล้วนำเข้าใหม่ล่าสุด</small>
                                </div>
                            </label>
                        </div>
                        <div class="col-6">
                            <label class="border rounded-3 p-3 h-100 d-flex align-items-start gap-2 cursor-pointer bg-white shadow-xs position-relative w-100 mb-0 import-mode-option" for="importModeAppend">
                                <input name="import_mode" class="form-check-input mt-1 flex-shrink-0" type="radio" value="append" id="importModeAppend" style="cursor: pointer; margin: 0; float: none;">
                                <div class="ms-1">
                                    <span class="fw-bold text-dark d-block">เพิ่มเฉพาะรายการใหม่</span>
                                    <small class="text-muted d-block mt-1" style="font-size: 0.75rem; line-height: 1.3;">คงของเดิมไว้ นำเข้าเฉพาะที่ยังไม่มี</small>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- 4. Advanced Options (Compact Switch Strip) -->
                <div class="p-2 px-3 rounded-3 border bg-light-subtle d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" id="chkAutoSyncSubjects" name="auto_sync_subjects" value="1" checked>
                        <label class="form-check-label fw-semibold text-dark small" for="chkAutoSyncSubjects">
                            ซิงค์ทะเบียนวิชาอัตโนมัติ
                        </label>
                    </div>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" id="chkMergeCoTeachers" name="merge_co_teachers" value="1" checked>
                        <label class="form-check-label fw-semibold text-dark small" for="chkMergeCoTeachers">
                            รวมครูคู่สอน (Co-teachers)
                        </label>
                    </div>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" id="chkSwitchToTargetYear" name="switch_to_target_year" value="1" checked>
                        <label class="form-check-label fw-semibold text-dark small" for="chkSwitchToTargetYear">
                            สลับไปยังปีปลายทางทันที
                        </label>
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <div class="modal-footer border-top py-3 px-4 bg-light-subtle d-flex justify-content-between align-items-center">
                <div class="small text-muted d-flex align-items-center gap-1">
                    <i class="bx bx-shield-quarter text-success fs-5"></i>
                    <span>ระบบจะตรวจสอบความซ้ำซ้อนและคำนวณคาบให้อัตโนมัติ</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-label-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        ยกเลิก
                    </button>
                    <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm fw-bold hover-elevate" id="btnConfirmImport" style="background: #15a362 !important; border: none;">
                        <i class="bx bx-check-double me-1"></i> เริ่มดึงข้อมูลเข้าสู่ตารางสอน
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Add Assignment (Classic Version) -->
<div class="modal fade" id="modalAddAssignment" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form class="modal-content border-0 rounded-4 shadow-lg" id="formAddAssignmentWizard">
            <?= csrf_field() ?>
            <input type="hidden" name="term" value="<?= $term ?>">
            <input type="hidden" name="year" value="<?= $year ?>">
            <input type="hidden" name="edit_ids" id="edit_ids" value="">
            <div class="modal-header bg-white border-bottom p-4">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-md bg-label-success p-2 rounded-3 me-3">
                        <i class="bx bx-user-plus fs-3"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-0">มอบหมายงานสอนใหม่</h5>
                        <small class="text-muted">เลือกรายวิชา ผู้สอน และกำหนดคาบเรียน</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-white" style="max-height: 80vh; overflow-y: auto;">
                <!-- Step 1: Subject -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label text-dark fw-bold mb-0">
                            <span class="step-badge-mini">1</span> รายวิชาที่สอน <span class="text-danger">*</span>
                        </label>
                        <div>
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill me-2" onclick="window.location.href='<?= base_url('admin/academic/timetable/subject-groups') ?>'">
                                <i class='bx bx-layer me-1'></i> จัดการกลุ่มเรียนพร้อมกัน
                            </button>
                            <button type="button" class="btn btn-sm btn-label-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#modalQuickAddSubject">
                                <i class="bx bx-plus me-1"></i> เพิ่มวิชาใหม่
                            </button>
                        </div>
                    </div>
                    <select class="form-select select2" name="subject_id" id="modal_subject_id" required data-placeholder="ค้นหาด้วยรหัสวิชาหรือชื่อวิชา...">
                        <option value=""></option>
                        <?php foreach($all_subjects as $s): ?>
                        <option value="<?= $s->tsub_id ?>"><?= ($s->tsub_code ? '['.$s->tsub_code.'] ' : '').$s->tsub_name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Step 2: Teachers -->
                <div class="mb-4">
                    <label class="form-label text-dark fw-bold mb-2">
                        <span class="step-badge-mini">2</span> คัดเลือกครูผู้สอน <span class="text-danger">*</span>
                    </label>
                    <select class="form-select select2" name="teacher_id[]" id="modal_teacher_id" multiple required data-placeholder="เลือกครูผู้สอน (สอนร่วมกันได้)...">
                        <?php foreach($all_personnel as $p): ?>
                        <option value="<?= $p->pers_id ?>"><?= $p->pers_prefix.$p->pers_firstname.' '.$p->pers_lastname ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Step 3: Class and Hours -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="form-label text-dark fw-bold mb-2">
                            <span class="step-badge-mini">3</span> ห้องเรียนที่สอน <span class="text-danger">*</span>
                        </label>
                        <select class="form-select select2" name="class_names[]" multiple required data-placeholder="เลือกห้องเรียน...">
                            <?php foreach($all_rooms as $r): ?>
                            <option value="ม.<?= $r->ClassName ?>">ม.<?= $r->ClassName ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-dark fw-bold mb-2">
                            <span class="step-badge-mini">4</span> คาบต่อสัปดาห์ <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="number" class="form-control fw-bold" name="hours_per_week" id="wizard_hours_per_week" value="2" min="1" max="10" required>
                            <span class="input-group-text bg-light text-muted fw-bold">คาบ</span>
                        </div>
                        <div id="wizard_hours_calc_info" class="small mt-1 fw-semibold d-flex flex-wrap align-items-center" style="color: #15a362 !important; font-size: 0.75rem;"></div>
                    </div>
                </div>

                <!-- Step 4: Split Pattern -->
                <div class="mb-0">
                    <div class="p-3 rounded-3 border bg-light">
                        <label class="form-label text-dark fw-bold mb-2 d-flex align-items-center">
                            <span class="step-badge-mini">5</span> รูปแบบการแบ่งคาบเรียน
                        </label>
                        <select class="form-select select2" name="period_split" id="wizard_period_split" required>
                            <!-- Options populated by JS -->
                        </select>
                        <small class="text-muted d-block mt-2">
                            <i class="bx bxs-bulb text-warning me-1"></i> ระบบจะจัดตารางให้ตามรูปแบบที่คุณเลือก เช่น 2+1 คาบ
                        </small>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="button" class="btn btn-label-secondary rounded-pill px-4" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="submit" class="btn btn-success rounded-pill px-5 shadow-sm fw-bold" style="background: #15a362 !important; border: none;">
                    <i class="bx bx-save me-1"></i> บันทึกข้อมูลการมอบหมาย
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Quick Add Subject -->
<div class="modal fade" id="modalQuickAddSubject" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom p-3">
                <h5 class="modal-title fw-bold mb-0"><i class="bx bx-book-add me-1 text-primary"></i> เพิ่มวิชาใหม่แบบเร่งด่วน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formQuickAddSubject">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">รหัสวิชา</label>
                        <input type="text" class="form-control" name="SubjectCode" placeholder="เช่น ส31101" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">ชื่อวิชา</label>
                        <input type="text" class="form-control" name="SubjectName" placeholder="เช่น สังคมศึกษา" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100 rounded-pill py-2 fw-bold" style="background: #15a362 !important; border: none;">บันทึกวิชาใหม่</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.step-badge-mini {
    width: 24px;
    height: 24px;
    background: #e0f5eb;
    color: #15a362;
    border: 1px solid #15a362;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 0.8rem;
    margin-right: 8px;
}
</style>

<!-- 🛠️ MODALS FOR STEP 1: BASIC SETTINGS -->

<!-- 📅 Modal Setting Days -->
<div class="modal fade" id="modalSettingDays" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom p-3">
                <h5 class="modal-title fw-bold mb-0"><i class="bx bx-calendar me-1 text-success"></i> วันที่เปิดเรียน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="list-group list-group-flush">
                    <?php foreach($days as $day): ?>
                    <div class="list-group-item d-flex justify-content-between align-items-center py-3 px-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-sm me-3">
                                <span class="avatar-initial rounded-pill bg-label-<?= ($day->day_key == 'SAT' || $day->day_key == 'SUN') ? 'danger' : 'success' ?>">
                                    <?= mb_substr($day->day_name, 0, 1) ?>
                                </span>
                            </div>
                            <span class="fw-bold"><?= $day->day_name ?></span>
                        </div>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input day-toggle" type="checkbox" 
                                data-id="<?= $day->day_id ?>" 
                                <?= $day->is_active ? 'checked' : '' ?>>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="p-4 bg-light border-top">
                    <div class="alert alert-warning d-flex align-items-center mb-0 border-0 shadow-none p-2">
                        <i class='bx bx-error-circle me-2'></i>
                        <div class="small">การเปิด/ปิดวันเรียน จะส่งผลต่อการสุ่มตาราง</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ⏰ Modal Setting Periods -->
<div class="modal fade" id="modalSettingPeriods" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom p-3">
                <div class="d-flex align-items-center">
                    <h5 class="modal-title fw-bold mb-0"><i class="bx bx-time me-1 text-primary"></i> คาบเรียนและเวลา</h5>
                    <button class="btn btn-sm btn-primary rounded-pill ms-3" id="btnAddPeriod">
                        <i class="bx bx-plus me-1"></i> เพิ่มคาบ
                    </button>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3">คาบที่</th>
                                <th class="py-3">ช่วงเวลา (เริ่ม - จบ)</th>
                                <th class="py-3">ประเภท</th>
                                <th class="text-center py-3 pe-4">ลบ</th>
                            </tr>
                        </thead>
                        <tbody id="periodsTableBody">
                            <?php foreach($periods as $p): ?>
                            <tr class="period-row" data-id="<?= $p->period_id ?>">
                                <td class="ps-4 align-middle fw-bold">คาบ <?= $p->period_number ?></td>
                                <td class="align-middle">
                                    <div class="input-group input-group-merge input-group-sm" style="width: 200px;">
                                        <input type="time" class="form-control period-time-input" data-field="start_time" value="<?= substr($p->start_time, 0, 5) ?>">
                                        <span class="input-group-text">-</span>
                                        <input type="time" class="form-control period-time-input" data-field="end_time" value="<?= substr($p->end_time, 0, 5) ?>">
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex flex-column gap-1">
                                        <select class="form-select form-select-sm period-type-select" style="width: 120px;">
                                            <option value="0" <?= !$p->is_break ? 'selected' : '' ?>>คาบเรียน</option>
                                            <option value="1" <?= $p->is_break ? 'selected' : '' ?>>พักกลางวัน</option>
                                        </select>
                                        <select class="form-select form-select-sm period-level-select" style="width: 120px; font-size: 0.7rem;">
                                            <option value="ALL" <?= $p->level_group == 'ALL' ? 'selected' : '' ?>>ทั้งหมด</option>
                                            <option value="Junior" <?= $p->level_group == 'Junior' ? 'selected' : '' ?>>ม.ต้น</option>
                                            <option value="Senior" <?= $p->level_group == 'Senior' ? 'selected' : '' ?>>ม.ปลาย</option>
                                        </select>
                                    </div>
                                </td>
                                <td class="text-center align-middle pe-4">
                                    <button class="btn btn-sm btn-icon btn-label-danger rounded-pill btn-delete-period">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light p-3 border-top">
                <small class="text-muted w-100"><i class='bx bx-info-circle me-1'></i> ข้อมูลเวลาและประเภทคาบจะถูกบันทึกอัตโนมัติเมื่อมีการแก้ไขครับ</small>
            </div>
        </div>
    </div>
</div>

<!-- 📚 Modal Manage Subjects -->
<div class="modal fade" id="modalManageSubjects" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom p-3">
                <div class="d-flex align-items-center">
                    <h5 class="modal-title fw-bold mb-0"><i class="bx bx-book me-1 text-danger"></i> จัดการรายวิชาตารางสอน</h5>
                    <div class="ms-3">
                        <button class="btn btn-sm btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalImportSubject">
                            <i class="bx bx-download me-1"></i> นำเข้าวิชา
                        </button>
                        <button class="btn btn-sm btn-label-primary rounded-pill px-3 ms-2" data-bs-toggle="modal" data-bs-target="#modalQuickAddSubject">
                            <i class="bx bx-plus me-1"></i> เพิ่มเอง
                        </button>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive" style="max-height: 450px;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light sticky-top">
                            <tr>
                                <th class="ps-4 py-3">รหัสวิชา</th>
                                <th class="py-3">ชื่อรายวิชา</th>
                                <th class="text-center py-3 pe-4">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody id="timetableSubjectsBody">
                            <?php if(empty($timetable_subjects)): ?>
                            <tr>
                                <td colspan="3" class="text-center py-5">
                                    <div class="text-muted small">ยังไม่มีข้อมูลวิชาในระบบตารางสอน</div>
                                </td>
                            </tr>
                            <?php else: ?>
                                <?php foreach($timetable_subjects as $ts): ?>
                                <tr>
                                    <td class="ps-4"><span class="badge bg-label-dark"><?= $ts->tsub_code ?: '-' ?></span></td>
                                    <td class="fw-bold text-dark"><?= $ts->tsub_name ?></td>
                                    <td class="text-center pe-4">
                                        <button class="btn btn-icon btn-sm text-danger btn-delete-tsub" data-id="<?= $ts->tsub_id ?>">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 📥 Modal Import Subject (Secondary Level) -->
<div class="modal fade" id="modalImportSubject" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom p-3">
                <h5 class="modal-title fw-bold mb-0"><i class="bx bx-download me-1 text-primary"></i> นำเข้าวิชาจากระบบทะเบียน (<?= $term ?>/<?= $year ?>)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formImportSubjectsWizard">
                    <?= csrf_field() ?>
                    <input type="hidden" name="term" value="<?= $term ?>">
                    <input type="hidden" name="year" value="<?= $year ?>">
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-8">
                            <div class="input-group input-group-merge shadow-none">
                                <span class="input-group-text border-0 bg-light rounded-start-pill ps-3"><i class="bx bx-search text-muted"></i></span>
                                <input type="text" class="form-control border-0 bg-light rounded-end-pill py-2" id="searchSubjectImport" placeholder="ค้นหารหัสวิชา หรือ ชื่อวิชา...">
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <button type="button" class="btn btn-label-secondary rounded-pill w-100" id="btnSelectAllSubjects">เลือกทั้งหมด</button>
                        </div>
                    </div>

                    <div class="row g-2 overflow-auto scroll-custom" style="max-height: 450px;" id="subjectImportList">
                        <?php 
                        $existingCodes = array_filter(array_column($timetable_subjects, 'tsub_code'));
                        foreach($academic_subjects as $as): 
                            $isJunior = in_array($as->SubjectClass, ['1', '2', '3']);
                            $isSenior = in_array($as->SubjectClass, ['4', '5', '6']);
                            $levelColor = $isJunior ? 'success' : ($isSenior ? 'warning' : 'primary');
                            $isImported = in_array($as->SubjectCode, $existingCodes);
                        ?>
                        <div class="col-md-6 subject-import-item <?= $isImported ? 'is-imported' : '' ?>" data-search="<?= strtolower($as->SubjectCode.' '.$as->SubjectName) ?>">
                            <div class="subject-import-card border rounded-3 overflow-hidden h-100 shadow-sm-hover transition-all <?= $isImported ? 'bg-light opacity-75' : '' ?>">
                                <label class="d-flex align-items-stretch w-100 <?= $isImported ? '' : 'cursor-pointer' ?> mb-0" for="<?= $isImported ? '' : 'as_wizard_'.$as->SubjectID ?>">
                                    <div class="d-flex align-items-center justify-content-center bg-checkbox-area border-end">
                                        <?php if($isImported): ?>
                                            <i class="bx bx-check-circle text-success fs-4"></i>
                                        <?php else: ?>
                                            <input class="form-check-input check-subject-wizard" type="checkbox" name="subject_ids[]" value="<?= $as->SubjectID ?>" id="as_wizard_<?= $as->SubjectID ?>">
                                        <?php endif; ?>
                                    </div>
                                    <div class="p-3 flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <span class="badge bg-label-dark font-monospace small px-2 py-1"><?= $as->SubjectCode ?></span>
                                            <?php if($isImported): ?>
                                                <span class="badge bg-success rounded-pill" style="font-size: 0.6rem;">นำเข้าแล้ว</span>
                                            <?php else: ?>
                                                <span class="badge bg-label-<?= $levelColor ?> rounded-pill" style="font-size: 0.6rem;">ม.<?= $as->SubjectClass ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="fw-bold text-dark text-truncate mb-1" style="max-width: 200px;" title="<?= $as->SubjectName ?>"><?= $as->SubjectName ?></div>
                                        <div class="d-flex gap-2">
                                            <small class="text-muted" style="font-size: 0.7rem;"><i class='bx bx-book-content me-1'></i><?= $as->SubjectType ?></small>
                                            <small class="text-muted" style="font-size: 0.7rem;"><i class='bx bx-star me-1'></i><?= $as->SubjectUnit ?> นก.</small>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            พบวิชาทั้งหมด <span class="fw-bold text-primary"><?= count($academic_subjects) ?></span> รายการ
                        </div>
                        <div>
                            <button type="button" class="btn btn-label-secondary rounded-pill px-4 me-2" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-success rounded-pill px-5 shadow-sm fw-bold" style="background: #15a362 !important; border: none;">นำเข้าที่เลือก</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 🏛️ Modal Master Slots (Grid View) -->
<div class="modal fade" id="modalMasterSlots" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down" style="max-width: 95%;">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom p-3">
                <div class="d-flex align-items-center">
                    <h5 class="modal-title fw-bold mb-0"><i class="bx bx-calendar-star me-1 text-warning"></i> ตั้งค่ากิจกรรมส่วนกลาง (Master Slots)</h5>
                    <div class="btn-group btn-group-sm rounded-pill ms-4 border shadow-none" role="group">
                        <input type="radio" class="btn-check" name="level_filter" id="filter_all" value="ALL" checked>
                        <label class="btn btn-outline-primary px-3" for="filter_all">ทั้งหมด</label>
                        <input type="radio" class="btn-check" name="level_filter" id="filter_junior" value="Junior">
                        <label class="btn btn-outline-primary px-3" for="filter_junior">ม.ต้น</label>
                        <input type="radio" class="btn-check" name="level_filter" id="filter_senior" value="Senior">
                        <label class="btn btn-outline-primary px-3" for="filter_senior">ม.ปลาย</label>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 overflow-auto" style="max-height: 80vh;">
                <div class="table-responsive">
                    <table class="table table-bordered m-0 border-0 text-center">
                        <thead>
                            <tr>
                                <th class="bg-light fw-bold py-3" style="min-width: 100px;">วัน / คาบ</th>
                                <?php foreach($periods as $p): ?>
                                <th class="bg-light p-0 py-2" style="min-width: 120px;">
                                    <div class="small fw-bold">คาบ <?= $p->period_number ?></div>
                                    <div class="text-muted" style="font-size: 0.65rem;"><?= date('H:i', strtotime($p->start_time)) ?> - <?= date('H:i', strtotime($p->end_time)) ?></div>
                                </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $dayMapShort = [
                                'MON' => ['จันทร์', '#ffebee', '#f44336'],
                                'TUE' => ['อังคาร', '#fce4ec', '#e91e63'],
                                'WED' => ['พุธ', '#e8f5e9', '#4caf50'],
                                'THU' => ['พฤหัสบดี', '#fff3e0', '#ff9800'],
                                'FRI' => ['ศุกร์', '#e3f2fd', '#2196f3'],
                                'SAT' => ['เสาร์', '#f3e5f5', '#9c27b0'],
                                'SUN' => ['อาทิตย์', '#fffde7', '#fbc02d']
                            ];
                            foreach($days as $day): 
                                if(!$day->is_active) continue;
                                $colors = $dayMapShort[$day->day_key] ?? ['#f8f9fa', '#6c757d'];
                            ?>
                            <tr>
                                <td class="fw-bold" style="background: <?= $colors[0] ?>; color: <?= $colors[1] ?>; vertical-align: middle;">
                                    <?= $day->day_name ?>
                                </td>
                                <?php foreach($periods as $p): ?>
                                <td class="p-0 position-relative">
                                    <div id="slot-<?= $day->day_key ?>-<?= $p->period_number ?>" 
                                         class="slot-master d-flex flex-column align-items-center justify-content-center p-2"
                                         style="height: 85px; min-width: 120px;"
                                         onclick="editMasterSlot('<?= $day->day_key ?>', '<?= $p->period_number ?>', '<?= $day->day_name ?>')">
                                        <div class="activity-display w-100">
                                            <i class="bx bx-plus text-muted opacity-25 fs-4"></i>
                                        </div>
                                    </div>
                                </td>
                                <?php endforeach; ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light p-3 border-top justify-content-start">
                <div class="d-flex gap-3 small">
                    <span class="d-flex align-items-center"><i class="bx bxs-square text-primary me-1"></i> ทุกระดับชั้น</span>
                    <span class="d-flex align-items-center"><i class="bx bxs-square text-success me-1"></i> ม.ต้น</span>
                    <span class="d-flex align-items-center"><i class="bx bxs-square text-warning me-1"></i> ม.ปลาย</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 📋 Modal Edit Master Slot Detail -->
<div class="modal fade" id="modalEditMasterSlot" tabindex="-1" aria-hidden="true" style="z-index: 10000;">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <form class="modal-content border-0 shadow-lg rounded-4" id="formMasterSlotWizard">
            <div class="modal-header bg-primary py-3">
                <h5 class="modal-title fw-bold text-white mb-0">กิจกรรมหลัก</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" id="modal_ms_day" name="day">
                <input type="hidden" id="modal_ms_period" name="period">
                
                <div class="text-center mb-3">
                    <span class="badge bg-label-primary fs-7 mb-1" id="modal_ms_info_day"></span>
                    <h6 class="fw-bold mb-0" id="modal_ms_info_period"></h6>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-uppercase">ระดับชั้น</label>
                    <select class="form-select rounded-pill" name="level_group" id="modal_ms_level_group">
                        <option value="ALL">ทุกระดับชั้น (ALL)</option>
                        <option value="Junior">มัธยมต้น (Junior)</option>
                        <option value="Senior">มัธยมปลาย (Senior)</option>
                    </select>
                </div>

                <div class="mb-0">
                    <label class="form-label fw-bold small text-uppercase">ชื่อกิจกรรม</label>
                    <input type="text" class="form-control rounded-pill" name="subject_name" id="modal_ms_subject_name" placeholder="เช่น ชุมนุม, ลูกเสือ" autocomplete="off">
                    <div class="form-text small mt-1 text-danger italic">* เว้นว่างเพื่อลบออก</div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0 p-4">
                <button type="button" class="btn btn-label-secondary rounded-pill px-4" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow">บันทึก</button>
            </div>
        </form>
    </div>
</div>

<style>
    .slot-master { transition: all 0.2s ease; cursor: pointer; border: 1px dashed transparent; }
    .slot-master:hover { background: rgba(21, 163, 98, 0.05); border-color: #15a362; }
    .slot-filled { background: #f0faf5; border: 2px solid #15a362 !important; border-radius: 8px; }
    .slot-filled .activity-name { color: #15a362; font-weight: 700; font-size: 0.8rem; }
    .slot-filled .level-badge { position: absolute; bottom: 4px; right: 4px; font-size: 0.55rem; padding: 2px 6px; }
</style>

<div class="modal fade" id="modalAIProcessing" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <div class="modal-body text-center p-5">
                <div class="mb-4">
                    <div class="spinner-border text-success" style="width: 4rem; height: 4rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <h4 class="fw-bold mb-2">กำลังประมวลผลตารางสอน...</h4>
                <p class="text-muted mb-0">ระบบ AI กำลังค้นหาช่วงเวลาที่เหมาะสมที่สุดให้คุณ กรุณาอย่าปิดหน้านี้จนกว่าจะเสร็จสิ้น</p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
// 🛡️ Global AJAX CSRF Sync
function getCookie(name) {
    let value = "; " + document.cookie;
    let parts = value.split("; " + name + "=");
    if (parts.length === 2) return parts.pop().split(";").shift();
}

$(document).ajaxSend(function(event, jqXHR, settings) {
    if (settings.type === 'POST') {
        let token = getCookie('csrf_cookie_name');
        if (token) {
            jqXHR.setRequestHeader('X-CSRF-TOKEN', token);
        }
    }
});

$(document).ajaxComplete(function(event, xhr, settings) {
    let token = getCookie('csrf_cookie_name');
    if (token) {
        // Update all hidden CSRF inputs on the page
        $('input[name="csrf_test_name"]').val(token);
    }
});

// 🪄 Persist Step and UI state
let currentStep = parseInt(localStorage.getItem('timetable_wizard_step')) || 1;
const totalSteps = 5;

// --- 🪄 Global Wizard Functions ---
window.goToStep = function(step) {
    currentStep = step;
    localStorage.setItem('timetable_wizard_step', step);
    updateWizard();
};

window.updateWizard = function() {
    // 🚨 Check for failure report from previous session
    const failureReport = sessionStorage.getItem('ai_failure_report');
    if (failureReport && currentStep === 4) {
        $('#aiReportContainer').html(failureReport);
        sessionStorage.removeItem('ai_failure_report');
        Swal.fire({ 
            icon: 'warning', 
            title: 'ประมวลผลไม่สมบูรณ์', 
            text: 'มีบางวิชาที่จัดลงตารางไม่ได้ กรุณาตรวจสอบรายละเอียดด้านล่างครับ',
            customClass: { container: 'swal2-container' }
        });
    }

    // Update Steps Visibility
    $('.wizard-step').addClass('d-none');
    $('#step-' + currentStep).removeClass('d-none');
    
    // Auto trigger smart electives scan when entering Step 2
    if (currentStep === 2 && typeof window.scanSmartElectives === 'function') {
        window.scanSmartElectives(false);
    }
    
    // Update Navigation Card Visuals
    $('.nav-card-item').removeClass('active d-none');
    $('#nav-step-' + currentStep).addClass('active');

    // Update Footer Controls
    if ($('#nav-step-' + currentStep).length) {
        $('#stepIndicator').text('เมนู: ' + $('#nav-step-' + currentStep + ' .nav-card-title').text());
    }
    $('#wizardProgressBar').css('width', (currentStep/totalSteps * 100) + '%');
    
    if(currentStep === 1) $('#btnPrev').addClass('d-none');
    else $('#btnPrev').removeClass('d-none');

    if(currentStep === totalSteps) $('#btnNext').addClass('d-none');
    else $('#btnNext').removeClass('d-none');

    // Scroll to top of card on step change
    if ($(".wizard-container").length && typeof $ === 'function') {
        const offset = $(".wizard-container").offset();
        if (offset) {
            $('html, body').animate({ scrollTop: offset.top - 100 }, 200);
        }
    }
};

window.refreshOverallProgress = function() {
    $.get('<?= base_url("admin/academic/timetable/get-progress") ?>', function(res) {
        if (res.overall_progress !== undefined) {
            $('#overallProgress').css('width', res.overall_progress + '%');
            $('#overallProgressText').text(res.overall_progress + '%');
            
            // Update Step 5 navigation card status
            const $nav5 = $('#nav-step-5');
            const $nav5Icon = $nav5.find('.nav-card-icon i');
            const $nav5Subtitle = $nav5.find('.nav-card-subtitle');

            $nav5.removeClass('locked-menu').attr('onclick', "goToStep(5)");
            if (res.overall_progress < 100) {
                $nav5Icon.removeClass('bx-check-double text-success').addClass('bx-time-five text-warning');
                $nav5Subtitle.text('ยังไม่สมบูรณ์ (' + res.overall_progress + '%)');
            } else {
                $nav5Icon.removeClass('bx-time-five text-warning').addClass('bx-check-double text-success');
                $nav5Subtitle.text('พิมพ์/ตรวจสอบ (100%)');
            }
        }
    });
};

window.refreshAssignmentList = function() {
    $.get(window.location.href, function(html) {
        const newList = $(html).find('#assignmentListContainer').html();
        $('#assignmentListContainer').html(newList);
        refreshOverallProgress();
        if (typeof window.filterAssignments === 'function') {
            window.filterAssignments();
        }
        if (typeof window.scanSmartElectives === 'function') {
            window.scanSmartElectives(false);
        }
    });
};

$(document).ready(function() {
    // --- 🏛️ Master Slots Management ---
    const masterData = <?= json_encode($master_slots) ?>;
    let currentMSFilter = 'ALL';

    window.renderMasterGrid = function() {
        // Reset all slots
        $('.slot-master').removeClass('slot-filled').css('border-color', 'transparent');
        $('.activity-display').html('<i class="bx bx-plus text-muted opacity-25 fs-4"></i>');

        masterData.forEach(item => {
            const show = (currentMSFilter === 'ALL') || (item.level_group === 'ALL') || (item.level_group === currentMSFilter);
            if (show) {
                const $slot = $(`#slot-${item.day}-${item.period}`);
                $slot.addClass('slot-filled');
                let badgeClass = 'bg-label-primary';
                if(item.level_group === 'Junior') badgeClass = 'bg-label-success';
                if(item.level_group === 'Senior') badgeClass = 'bg-label-warning';

                $slot.find('.activity-display').html(`
                    <div class="activity-name text-truncate px-1">${item.subject_name}</div>
                    <span class="badge ${badgeClass} level-badge rounded-pill">${item.level_group}</span>
                `);
            }
        });
    };

    window.editMasterSlot = function(day, period, dayName) {
        $('#modal_ms_day').val(day);
        $('#modal_ms_period').val(period);
        $('#modal_ms_info_day').text(dayName);
        $('#modal_ms_info_period').text('คาบที่ ' + period);

        const existing = masterData.find(m => m.day === day && m.period === period && m.level_group === currentMSFilter);
        $('#modal_ms_subject_name').val(existing ? existing.subject_name : '');
        $('#modal_ms_level_group').val(currentMSFilter);
        $('#modalEditMasterSlot').modal('show');
    };

    renderMasterGrid();

    $('input[name="level_filter"]').on('change', function() {
        currentMSFilter = $(this).val();
        renderMasterGrid();
    });

    $('#formMasterSlotWizard').on('submit', function(e) {
        e.preventDefault();
        const $btn = $(this).find('button[type="submit"]');
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>');

        $.post('<?= base_url("admin/academic/timetable/save-master-slot") ?>', $(this).serialize(), function(res) {
            if(res.status === 'success') {
                Swal.fire({ icon: 'success', title: 'สำเร็จ', timer: 1000, showConfirmButton: false }).then(() => location.reload());
            } else {
                Swal.fire('ผิดพลาด', res.message, 'error');
                $btn.prop('disabled', false).text('บันทึก');
            }
        });
    });

    // --- ➕ Quick Add Period Link ---
    $('#btnQuickAddPeriodMenu').on('click', function() {
        $('#modalSettingPeriods').modal('show');
        setTimeout(() => $('#btnAddPeriod').click(), 300);
    });
    // 🚀 Initialize UI state based on persisted step
    updateWizard();

    // --- 🪄 Wizard Logic ---
    $(document).on('click', '.btn-edit-assignment', function() {
        const $btn = $(this);
        const modal = $('#modalAddAssignment');
        const form = $('#formAddAssignmentWizard');

        $('#modal_subject_id').data('manual', false);
        
        // Populate Modal Fields
        modal.find('.modal-title').text('แก้ไขการมอบหมายงานสอน');
        modal.find('button[type="submit"]').removeClass('btn-success').addClass('btn-warning').html('<i class="bx bx-save me-1"></i> อัปเดตข้อมูลการมอบหมาย');
        
        form.find('select[name="subject_id"]').val($btn.data('subject')).trigger('change', { manual: false });
        form.find('select[name="teacher_id[]"]').val($btn.data('teachers').toString().split(',')).trigger('change');
        form.find('select[name="class_names[]"]').val($btn.data('classes').toString().split(',')).trigger('change');
        form.find('input[name="hours_per_week"]').val($btn.data('hours')).trigger('change');
        
        // Handle Split (Wait for updateSplitOptions to run after hours change)
        setTimeout(() => {
            form.find('select[name="period_split"]').val($btn.data('split')).trigger('change');
        }, 100);

        // Add hidden ID field for update
        form.find('#edit_ids').val($btn.data('ids'));
        
        modal.modal('show');
        initSelect2();
    });

    // Reset modal when closing or opening for ADD
    $('#modalAddAssignment').on('hidden.bs.modal', function () {
        const modal = $(this);
        modal.find('.modal-title').text('มอบหมายงานสอนใหม่');
        modal.find('button[type="submit"]').removeClass('btn-warning').addClass('btn-success').html('<i class="bx bx-save me-1"></i> บันทึกข้อมูลการมอบหมาย');
        $('#formAddAssignmentWizard')[0].reset();
        $('#formAddAssignmentWizard').find('select').val(null).trigger('change');
        $('#edit_ids').val('');
        initSelect2();
    });

    // --- 📚 Subject Management Logic ---
    $('#searchSubjectImport').on('keyup', function() {
        const value = $(this).val().toLowerCase();
        $('.subject-import-item').filter(function() {
            $(this).toggle($(this).data('search').indexOf(value) > -1)
        });
    });

    $('#btnSelectAllSubjects').on('click', function() {
        const allChecked = $('.check-subject-wizard:checked').length === $('.check-subject-wizard:not(:disabled)').length;
        const targetState = !allChecked;
        
        $('.check-subject-wizard').prop('checked', targetState);
        $('.subject-import-card').each(function() {
            if ($(this).find('.check-subject-wizard').length > 0) {
                $(this).toggleClass('is-selected', targetState);
            }
        });
        $(this).text(targetState ? 'ยกเลิกการเลือก' : 'เลือกทั้งหมด');
    });

    $(document).on('change', '.check-subject-wizard', function() {
        $(this).closest('.subject-import-card').toggleClass('is-selected', $(this).is(':checked'));
    });

    $('#formImportSubjectsWizard').on('submit', function(e) {
        e.preventDefault();
        const $btn = $(this).find('button[type="submit"]');
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> นำเข้า...');

        $.post('<?= base_url("admin/academic/timetable/import-subjects") ?>', $(this).serialize(), function(res) {
            if(res.status === 'success') {
                Swal.fire({ icon: 'success', title: 'นำเข้าสำเร็จ', timer: 1000, showConfirmButton: false }).then(() => location.reload());
            } else {
                Swal.fire('ผิดพลาด', res.message, 'error');
                $btn.prop('disabled', false).text('นำเข้าข้อมูล');
            }
        });
    });

    $(document).on('click', '.btn-delete-tsub', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'ยืนยันการลบวิชา?',
            text: "วิชานี้จะถูกลบออกจากระบบตารางสอน (ไม่มีผลกับระบบทะเบียน)",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ลบข้อมูล',
            cancelButtonText: 'ยกเลิก',
            customClass: { confirmButton: 'btn btn-danger', cancelButton: 'btn btn-label-secondary' }
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('<?= base_url("admin/academic/timetable/delete-subject") ?>', { id: id, '<?= csrf_token() ?>': '<?= csrf_hash() ?>' }, function(res) {
                    if(res.status === 'success') {
                        location.reload();
                    } else {
                        Swal.fire('ผิดพลาด', res.message, 'error');
                    }
                });
            }
        });
    });

    // --- 📅 Year Selection Logic ---
    $(document).on('click', '.change-year-btn', function() {
        const year = $(this).data('year');
        $.post('<?= base_url("admin/academic/timetable/change-year") ?>', { 
            year: year, 
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>' 
        }, function(res) {
            if(res.status === 'success') {
                location.reload();
            }
        });
    });


    // --- ⚙️ Step 1: Basic Settings Logic ---
    $('.day-toggle').on('change', function() {
        const id = $(this).data('id');
        const active = $(this).is(':checked') ? 1 : 0;
        $.post('<?= base_url("admin/academic/timetable/update-day") ?>', { 
            day_id: id, is_active: active, '<?= csrf_token() ?>': '<?= csrf_hash() ?>' 
        }, function() {
            refreshOverallProgress();
            Swal.fire({
                toast: true, position: 'top-end', icon: 'info',
                title: 'บันทึกวันเรียน สำเร็จ',
                showConfirmButton: false, timer: 1500
            });
        });
    });

    $(document).on('change', '.period-time-input, .period-type-select, .period-level-select', function() {
        const $row = $(this).closest('tr');
        const id = $row.data('id');
        const data = {
            period_id: id,
            period_number: $row.find('td:first').text().replace('คาบ ', ''),
            start_time: $row.find('.period-time-input[data-field="start_time"]').val(),
            end_time: $row.find('.period-time-input[data-field="end_time"]').val(),
            is_break: $row.find('.period-type-select').val(),
            level_group: $row.find('.period-level-select').val(),
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
        };
        $.post('<?= base_url("admin/academic/timetable/save-period") ?>', data, function() {
            Swal.fire({
                toast: true, position: 'top-end', icon: 'info',
                title: 'บันทึกเวลาคาบ และรีเซ็ตผล AI เพื่อความถูกต้อง',
                showConfirmButton: false, timer: 1500
            });
        });
    });

    $('#btnAddPeriod').on('click', function() {
        const nextPeriod = $('.period-row').length + 1;
        const data = {
            period_number: nextPeriod,
            start_time: '08:00',
            end_time: '09:00',
            is_break: 0,
            level_group: 'ALL',
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
        };
        $.post('<?= base_url("admin/academic/timetable/save-period") ?>', data, function(res) {
            // Append row dynamically
            const newRow = `
                <tr class="period-row" data-id="${res.period_id}">
                    <td class="ps-4 align-middle fw-bold">คาบ ${nextPeriod}</td>
                    <td class="align-middle">
                        <div class="input-group input-group-merge input-group-sm" style="width: 200px;">
                            <input type="time" class="form-control period-time-input" data-field="start_time" value="08:00">
                            <span class="input-group-text">-</span>
                            <input type="time" class="form-control period-time-input" data-field="end_time" value="09:00">
                        </div>
                    </td>
                    <td class="align-middle">
                        <div class="d-flex flex-column gap-1">
                            <select class="form-select form-select-sm period-type-select" style="width: 120px;">
                                <option value="0" selected>คาบเรียน</option>
                                <option value="1">พักกลางวัน</option>
                            </select>
                            <select class="form-select form-select-sm period-level-select" style="width: 120px; font-size: 0.7rem;">
                                <option value="ALL" selected>ทั้งหมด</option>
                                <option value="Junior">ม.ต้น</option>
                                <option value="Senior">ม.ปลาย</option>
                            </select>
                        </div>
                    </td>
                    <td class="text-center align-middle pe-4">
                        <button class="btn btn-sm btn-icon btn-label-danger rounded-pill btn-delete-period">
                            <i class="bx bx-trash"></i>
                        </button>
                    </td>
                </tr>`;
            $('#periodsTableBody').append(newRow);
            refreshOverallProgress();
        });
    });

    $(document).on('click', '.btn-delete-period', function() {
        const id = $(this).closest('tr').data('id');
        Swal.fire({
            title: 'ยืนยันการลบคาบเรียน?',
            text: "ข้อมูลคาบเรียนนี้จะหายไปจากระบบ",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ลบข้อมูล',
            cancelButtonText: 'ยกเลิก',
            customClass: { confirmButton: 'btn btn-danger', cancelButton: 'btn btn-label-secondary' }
        }).then((result) => {
            if (result.isConfirmed) {
                const $row = $(this).closest('tr');
                $.post('<?= base_url("admin/academic/timetable/delete-period") ?>', { period_id: id, '<?= csrf_token() ?>': '<?= csrf_hash() ?>' }, function() {
                    $row.fadeOut(300, function() { $(this).remove(); });
                    refreshOverallProgress();
                });
            }
        });
    });

    $('.next-step').on('click', function() {
        if (currentStep < totalSteps) { currentStep++; updateWizard(); }
    });

    $('.prev-step').on('click', function() {
        if (currentStep > 1) { currentStep--; updateWizard(); }
    });

    // Initialize Select2 with dynamic z-index for modals
    function initSelect2() {
        $('.select2').each(function() {
            if ($(this).hasClass("select2-hidden-accessible")) {
                $(this).select2('destroy');
            }
            $(this).select2({ 
                theme: 'bootstrap-5', 
                dropdownParent: $(this).closest('.modal').length ? $(this).closest('.modal') : $(document.body),
                width: '100%'
            });
        });
    }
    initSelect2();

    // --- 📚 Step 2: Assignments ---
    // 🚀 Dynamic Period Split Logic (from AssignmentForm)
    function updateSplitOptions() {
        const hours = parseInt($('#wizard_hours_per_week').val());
        const $split = $('#wizard_period_split');
        $split.empty();

        let options = [];
        if (hours === 1) {
            options = [{ val: '1', text: '1 คาบ (1 วัน)' }];
        } else if (hours === 2) {
            options = [
                { val: '2', text: '2 คาบ (รวดเดียว)' },
                { val: '1,1', text: '1 + 1 คาบ (แยก 2 วัน)' }
            ];
        } else if (hours === 3) {
            options = [
                { val: '2,1', text: '2 + 1 คาบ (แยก 2 วัน)' },
                { val: '3', text: '3 คาบ (รวดเดียว)' },
                { val: '1,1,1', text: '1 + 1 + 1 คาบ (แยก 3 วัน)' }
            ];
        } else if (hours === 4) {
            options = [
                { val: '2,2', text: '2 + 2 คาบ (แยก 2 วัน)' },
                { val: '4', text: '4 คาบ (รวดเดียว)' },
                { val: '2,1,1', text: '2 + 1 + 1 คาบ (แยก 3 วัน)' },
                { val: '1,1,1,1', text: '1 + 1 + 1 + 1 คาบ (แยก 4 วัน)' }
            ];
        } else if (hours === 5) {
            options = [
                { val: '2,2,1', text: '2 + 2 + 1 คาบ (แยก 3 วัน)' },
                { val: '3,2', text: '3 + 2 คาบ (แยก 2 วัน)' },
                { val: '2,1,1,1', text: '2 + 1 + 1 + 1 คาบ (แยก 4 วัน)' },
                { val: '1,1,1,1,1', text: '1 + 1 + 1 + 1 + 1 คาบ (แยก 5 วัน)' }
            ];
        } else if (hours === 6) {
            options = [
                { val: '2,2,2', text: '2 + 2 + 2 คาบ (แยก 3 วัน)' },
                { val: '3,3', text: '3 + 3 คาบ (แยก 2 วัน)' },
                { val: '2,2,1,1', text: '2 + 2 + 1 + 1 คาบ (แยก 4 วัน)' },
                { val: '6', text: '6 คาบ (รวดเดียว)' }
            ];
        } else if (hours === 7) {
            options = [
                { val: '2,2,2,1', text: '2 + 2 + 2 + 1 คาบ (แยก 4 วัน)' },
                { val: '2,2,1,1,1', text: '2 + 2 + 1 + 1 + 1 คาบ (แยก 5 วัน)' },
                { val: '3,2,2', text: '3 + 2 + 2 คาบ (แยก 3 วัน)' },
                { val: '7', text: '7 คาบ (รวดเดียว)' }
            ];
        } else if (hours === 8) {
            options = [
                { val: '2,2,2,2', text: '2 + 2 + 2 + 2 คาบ (แยก 4 วัน)' },
                { val: '2,2,1,1,1,1', text: '2 + 2 + 1 + 1 + 1 + 1 คาบ (แยก 6 วัน)' },
                { val: '3,3,2', text: '3 + 3 + 2 คาบ (แยก 3 วัน)' },
                { val: '8', text: '8 คาบ (รวดเดียว)' }
            ];
        } else if (hours === 9) {
            options = [
                { val: '2,2,2,2,1', text: '2 + 2 + 2 + 2 + 1 คาบ (แยก 5 วัน)' },
                { val: '3,3,3', text: '3 + 3 + 3 คาบ (แยก 3 วัน)' },
                { val: '9', text: '9 คาบ (รวดเดียว)' }
            ];
        } else if (hours === 10) {
            options = [
                { val: '2,2,2,2,2', text: '2 + 2 + 2 + 2 + 2 คาบ (แยก 5 วัน)' },
                { val: '3,3,2,2', text: '3 + 3 + 2 + 2 คาบ (แยก 4 วัน)' },
                { val: '10', text: '10 คาบ (รวดเดียว)' }
            ];
        } else if (hours > 10) {
            options = [{ val: hours.toString(), text: hours + ' คาบ (รวดเดียว)' }];
        }

        options.forEach(opt => {
            $split.append(new Option(opt.text, opt.val));
        });
        $split.trigger('change');
    }

    function updateHoursCalcInfo() {
        const hours = parseInt($('#wizard_hours_per_week').val()) || 0;
        const classes = $('#modalAddAssignment select[name="class_names[]"]').val() || [];
        const classCount = classes.length || 1;
        const totalPeriods = hours * classCount;
        
        let infoText = '<i class="bx bx-calculator me-1"></i> รวมภาระงานสอนทั้งสิ้น ' + totalPeriods + ' คาบ/สัปดาห์';
        if (classes.length > 1) {
            infoText += ' <small class="text-muted ms-1" style="font-size: 0.65rem;">(คิดจาก ' + hours + ' คาบ × ' + classCount + ' ห้องเรียน)</small>';
        }
        $('#wizard_hours_calc_info').html(infoText);
    }

    $('#wizard_hours_per_week').on('input change', function() {
        updateSplitOptions();
        updateHoursCalcInfo();
    });
    $('#modalAddAssignment select[name="class_names[]"]').on('change', updateHoursCalcInfo);
    updateSplitOptions(); // Initial call
    updateHoursCalcInfo(); // Initial call

    // 🚀 Suggested Teachers Logic
    const $teacherSelect = $('#modal_teacher_id');
    const originalTeacherOptions = $teacherSelect.html();

    // 🚀 Subject Details Fetch & Auto Hours Calculation in Modal
    function fetchModalSubjectInfo(subjectId, autoSetHours = true) {
        if (!subjectId) {
            $('#modal-subject-detail-badge').remove();
            return;
        }

        $.get('<?= base_url('admin/academic/timetable/get-subject-info') ?>', { subject_id: subjectId }, function(info) {
            if (info && info.status === 'success') {
                if (info.SubjectUnit !== null || info.SubjectHour !== null) {
                    if (autoSetHours) {
                        $('#wizard_hours_per_week').val(info.suggested_hours).trigger('change');
                    }
                    
                    let detailHtml = '<div class="alert alert-light-success d-flex align-items-center p-2 mb-0 mt-2" style="border: 1px dashed #15a362; border-radius: 0.5rem; background-color: #f4fbf7;">' +
                        '<i class="bx bx-info-circle text-success me-2 fs-5"></i>' +
                        '<div>' +
                        '<span class="badge bg-label-success me-2">ข้อมูลวิชา</span>' +
                        '<small class="text-dark fw-semibold">' +
                        'หน่วยกิต: <strong class="text-success">' + (info.SubjectUnit || '-') + '</strong> | ' +
                        'จำนวนชั่วโมง: <strong class="text-success">' + (info.SubjectHour || '-') + ' ชม.</strong> | ' +
                        'คำนวณคาบต่อสัปดาห์อัตโนมัติ: <strong class="text-success">' + info.suggested_hours + ' คาบ</strong>' +
                        '</small>' +
                        '</div>' +
                        '</div>';
                    
                    $('#modal-subject-detail-badge').remove();
                    $('<div id="modal-subject-detail-badge" class="mt-2"></div>').html(detailHtml).insertAfter($('#modal_subject_id').next('.select2-container'));
                } else {
                    $('#modal-subject-detail-badge').remove();
                }
            }
        });
    }

    $('#modal_subject_id').on('change', function(e, data) {
        const isManual = (data && data.manual !== undefined) ? data.manual : true;
        const subjectId = $(this).val();
        
        // Fetch Subject details and auto-calculate hours
        fetchModalSubjectInfo(subjectId, isManual);
        
        if (!isManual) return;
        
        if (!subjectId) {
            $teacherSelect.html(originalTeacherOptions).trigger('change');
            return;
        }
        
        $.get('<?= base_url('admin/academic/timetable/get-suggested-teachers') ?>', { subject_id: subjectId }, function(suggested) {
            if (suggested && suggested.length > 0) {
                const suggestedIds = suggested.map(s => s.pers_id.toString());
                const $options = $(originalTeacherOptions);
                
                const suggestedOpts = [];
                const otherOpts = [];

                $options.each(function() {
                    const val = $(this).val();
                    if (val) {
                        if (suggestedIds.includes(val.toString())) {
                            suggestedOpts.push($(this));
                        } else {
                            otherOpts.push($(this));
                        }
                    }
                });

                $teacherSelect.empty();
                if (suggestedOpts.length > 0) {
                    const $group = $('<optgroup label="ครูที่สอนวิชานี้ (ตามแผนการสอน)"></optgroup>');
                    suggestedOpts.forEach(opt => $group.append(opt));
                    $teacherSelect.append($group);
                }

                if (otherOpts.length > 0) {
                    const $otherGroup = $('<optgroup label="ครูท่านอื่นๆ"></optgroup>');
                    otherOpts.forEach(opt => $otherGroup.append(opt));
                    $teacherSelect.append($otherGroup);
                }
                
                $teacherSelect.val(suggestedIds).trigger('change');
                
                Swal.fire({
                    toast: true, position: 'top-end', icon: 'success',
                    title: 'แนะนำครูผู้สอนให้โดยอัตโนมัติ ' + suggested.length + ' ท่าน',
                    showConfirmButton: false, timer: 3000
                });
            } else {
                $teacherSelect.html(originalTeacherOptions).trigger('change');
            }
        });
    });

    // 🚀 Quick Add Subject Logic
    $('#formQuickAddSubject').on('submit', function(e) {
        e.preventDefault();
        const $btn = $(this).find('button[type="submit"]');
        $btn.prop('disabled', true).text('กำลังบันทึก...');

        $.ajax({
            url: '<?= base_url('admin/academic/timetable/quick-add-subject') ?>',
            type: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                if (res.status === 'success') {
                    // Context 1: Manage Subjects Modal in Step 1
                    if ($('#modalManageSubjects').is(':visible')) {
                        Swal.fire({ icon: 'success', title: 'เพิ่มวิชาสำเร็จ!', timer: 800, showConfirmButton: false }).then(() => {
                            location.reload();
                        });
                        return;
                    }

                    // Context 2: Assignment Form in Step 2
                    const displayName = (res.data.tsub_code ? '[' + res.data.tsub_code + '] ' : '') + res.data.tsub_name;
                    const newOption = new Option(displayName, res.data.tsub_id, true, true);
                    $('#modal_subject_id').append(newOption).trigger('change');
                    
                    $('#modalQuickAddSubject').modal('hide');
                    $('#formQuickAddSubject')[0].reset();
                    Swal.fire({ icon: 'success', title: 'เพิ่มวิชาสำเร็จ!', timer: 1000, showConfirmButton: false });
                } else {
                    Swal.fire('ข้อผิดพลาด', res.message, 'error');
                }
                $btn.prop('disabled', false).text('บันทึกวิชาใหม่');
            }
        });
    });

    $('#formAddAssignmentWizard').on('submit', function(e) {
        e.preventDefault();
        const $btn = $(this).find('button[type="submit"]');
        const oldHtml = $btn.html();
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> กำลังบันทึก...');
        
        $.post('<?= base_url("admin/academic/timetable/save-assignment") ?>', $(this).serialize(), function(res) {
            $btn.prop('disabled', false).html(oldHtml);
            if (res.status === 'success') {
                refreshAssignmentList();
                Swal.fire({ icon: 'success', title: 'บันทึกสำเร็จ', text: res.message, timer: 1500, showConfirmButton: false });
                $('#modalAddAssignment').modal('hide');
            } else {
                Swal.fire('ข้อผิดพลาด', res.message || 'ไม่สามารถบันทึกข้อมูลได้', 'error');
            }
        }).fail(function(xhr) {
            $btn.prop('disabled', false).html(oldHtml);
            let errMsg = 'เกิดข้อผิดพลาดจากเซิร์ฟเวอร์';
            try { errMsg = JSON.parse(xhr.responseText).message || errMsg; } catch(e) {}
            Swal.fire('Error ' + xhr.status, errMsg, 'error');
        });
    });

    // --- 🚀 Import Teaching Schedule from Learning Groups ---
    window.openImportTeachingScheduleModal = function() {
        $('#modalImportTeachingSchedule').modal('show');
        // Trigger initial preview load
        triggerTeachingSchedulePreview();
    };

    function triggerTeachingSchedulePreview() {
        const val = $('#import_source_year_term').val();
        if (!val) return;
        const parts = val.split('/');
        const term = parts[0];
        const year = parts[1];

        $('#previewLoadingSpinner').removeClass('d-none');
        $('#prevSampleBadges').html('<span class="text-muted small">กำลังโหลดข้อมูลตัวอย่าง...</span>');

        $.ajax({
            url: '<?= base_url('admin/academic/timetable/get-teaching-schedule-preview') ?>',
            type: 'GET',
            data: { source_term: term, source_year: year },
            dataType: 'json',
            success: function(res) {
                $('#previewLoadingSpinner').addClass('d-none');
                if (res.status === 'success') {
                    $('#prevTeacherCount').text(res.teacher_count || 0);
                    $('#prevSubjectCount').text(res.subject_count || 0);
                    $('#prevClassroomCount').text(res.classroom_count || 0);
                    $('#prevHoursCount').text(res.total_weekly_hours || 0);

                    $('#badgeSourceRecords').text(res.total_rows + ' รายการ').removeClass('bg-label-warning bg-label-danger').addClass('bg-label-success');

                    if (res.grade_levels && res.grade_levels.length > 0) {
                        $('#prevGradeLevelsBadge').text(res.grade_levels.join(', '));
                    } else {
                        $('#prevGradeLevelsBadge').text('-');
                    }

                    let badgesHtml = '';
                    if (res.sample_subjects && Object.keys(res.sample_subjects).length > 0) {
                        $.each(res.sample_subjects, function(code, name) {
                            badgesHtml += '<span class="badge bg-label-primary rounded-pill mb-1 me-1" style="font-size: 0.72rem;">[' + code + '] ' + name + '</span>';
                        });
                    }
                    if (res.co_teachers_count > 0) {
                        badgesHtml += '<span class="badge bg-label-warning rounded-pill mb-1 me-1" style="font-size: 0.72rem;"><i class="bx bx-group me-1"></i>มีครูคู่สอน ' + res.co_teachers_count + ' รายการ</span>';
                    }
                    $('#prevSampleBadges').html(badgesHtml || '<span class="text-muted small">-</span>');
                    $('#btnConfirmImport').prop('disabled', false);
                } else {
                    $('#prevTeacherCount').text('0');
                    $('#prevSubjectCount').text('0');
                    $('#prevClassroomCount').text('0');
                    $('#prevHoursCount').text('0');
                    $('#badgeSourceRecords').text('ไม่พบข้อมูล').removeClass('bg-label-success').addClass('bg-label-warning');
                    $('#prevGradeLevelsBadge').text('-');
                    $('#prevSampleBadges').html('<span class="text-danger small">' + (res.message || 'ไม่มีข้อมูลในเทอมนี้') + '</span>');
                    $('#btnConfirmImport').prop('disabled', true);
                }
            },
            error: function() {
                $('#previewLoadingSpinner').addClass('d-none');
                $('#prevSampleBadges').html('<span class="text-danger small">ไม่สามารถดึงข้อมูลพรีวิวได้</span>');
            }
        });
    }

    $('#import_source_year_term').on('change', function() {
        const selectedVal = $(this).val();
        // Also sync target year if option exists
        if ($('#import_target_year_term option[value="' + selectedVal + '"]').length > 0) {
            $('#import_target_year_term').val(selectedVal).trigger('change');
        }
        triggerTeachingSchedulePreview();
    });

    $('#formImportTeachingSchedule').on('submit', function(e) {
        e.preventDefault();
        
        const sourceVal = $('#import_source_year_term').val();
        const targetVal = $('#import_target_year_term').val();
        if (!sourceVal || !targetVal) {
            Swal.fire({ icon: 'warning', title: 'กรุณาเลือกปีการศึกษา', text: 'ต้องระบุทั้งปีการศึกษาต้นทางและปลายทางครับ' });
            return;
        }

        const sourceParts = sourceVal.split('/');
        const targetParts = targetVal.split('/');
        const mode = $('input[name="import_mode"]:checked').val();
        const modeText = (mode === 'replace') ? 'ล้างข้อมูลเดิมและแทนที่ใหม่ทั้งหมด' : 'เพิ่มเฉพาะรายการใหม่';

        Swal.fire({
            title: 'ยืนยันการดึงข้อมูลงานสอน?',
            html: '<div class="text-start small p-2">' +
                '<p class="mb-1"><strong>ปีการศึกษาต้นทาง (กลุ่มสาระ):</strong> ภาคเรียนที่ ' + sourceVal + '</p>' +
                '<p class="mb-1"><strong>ปีการศึกษาปลายทาง (ตารางสอน):</strong> ภาคเรียนที่ ' + targetVal + '</p>' +
                '<p class="mb-0 text-success"><strong>รูปแบบ:</strong> ' + modeText + '</p>' +
                (mode === 'replace' ? '<div class="alert alert-warning p-2 mt-2 mb-0" style="font-size: 0.75rem;"><i class="bx bx-error me-1"></i>ระบบจะล้างข้อมูลการมอบหมายเดิมของภาคเรียนที่ ' + targetVal + ' และนำเข้าข้อมูลใหม่แทนที่ครับ</div>' : '') +
                '</div>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#15a362',
            cancelButtonColor: '#8592a3',
            confirmButtonText: '<i class="bx bx-check me-1"></i> ยืนยันการดึงข้อมูล',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'กำลังดึงข้อมูลงานสอน...',
                    html: 'ระบบกำลังนำเข้ารายวิชา ครูผู้สอน และห้องเรียน กรุณารอสักครู่',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '<?= base_url('admin/academic/timetable/import-teaching-schedule') ?>',
                    type: 'POST',
                    data: {
                        source_term: sourceParts[0],
                        source_year: sourceParts[1],
                        target_term: targetParts[0],
                        target_year: targetParts[1],
                        mode: mode,
                        merge_co_teachers: $('#chkMergeCoTeachers').is(':checked') ? 1 : 0,
                        auto_sync_subjects: $('#chkAutoSyncSubjects').is(':checked') ? 1 : 0,
                        switch_to_target_year: $('#chkSwitchToTargetYear').is(':checked') ? 1 : 0,
                        <?= csrf_token() ?>: $('input[name="<?= csrf_token() ?>"]').val()
                    },
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 'success') {
                            $('#modalImportTeachingSchedule').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'ดึงข้อมูลสำเร็จ!',
                                text: res.message,
                                confirmButtonColor: '#15a362'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'ไม่สามารถนำเข้าข้อมูลได้',
                                text: res.message || 'เกิดข้อผิดพลาดในการนำเข้า',
                                confirmButtonColor: '#15a362'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้: ' + (xhr.responseJSON?.message || xhr.statusText),
                            confirmButtonColor: '#15a362'
                        });
                    }
                });
            }
        });
    });

    $(document).on('click', '.btn-delete-assignment', function() {
        const ids = $(this).data('ids');
        Swal.fire({ 
            title: 'ต้องการลบการมอบหมาย?', 
            text: "การลบข้อมูลนี้อาจส่งผลต่อตารางที่จัดไว้แล้ว",
            icon: 'warning', 
            showCancelButton: true,
            confirmButtonText: 'ยืนยันการลบ',
            cancelButtonText: 'ยกเลิก',
            customClass: { confirmButton: 'btn btn-danger', cancelButton: 'btn btn-label-secondary' }
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('<?= base_url('admin/academic/timetable/delete-assignment') ?>', { ids: ids, '<?= csrf_token() ?>': '<?= csrf_hash() ?>' }, function() { 
                    refreshAssignmentList();
                    Swal.fire({ icon: 'success', title: 'ลบข้อมูลสำเร็จ', timer: 1500, showConfirmButton: false });
                });
            }
        });
    });

    // --- 🖱️ Drag & Drop Functions ---
    window._lastHighlighted = window._lastHighlighted || [];
    
    window.drag = function(ev, id, code, name, periods, teacherId, hasJunior, hasSenior) {
        ev.dataTransfer.setData("subject_id", id);
        ev.dataTransfer.setData("num_periods", periods);
        window._dragPeriods = parseInt(periods);
        window._dragCode = code;
        window._dragTeacherId = teacherId || ''; 
        window._dragHasJunior = !!hasJunior;
        window._dragHasSenior = !!hasSenior;
    };

    window.allowDrop = function(ev) { ev.preventDefault(); };

    window.clearAllHighlights = function() {
        if (!window._lastHighlighted) window._lastHighlighted = [];
        window._lastHighlighted.forEach(function(td) {
            $(td).find('.lock-slot-wizard').removeClass('drag-target-hover bg-label-danger border-danger');
            $(td).find('.lock-slot-wizard .forbidden-msg').remove();
        });
        window._lastHighlighted = [];
    };

    window.isTeacherBusy = function(day, period, teacherId) {
        if (!teacherId) return false;
        const tids = teacherId.toString().split(',').map(s => s.trim()).filter(s => s !== '');
        
        // 1. Check Manual Locks
        const hasLock = tids.some(tid => 
            window._teacherLocks && window._teacherLocks.some(lock => lock.teacher_id == tid && lock.day == day && lock.period == period)
        );
        if (hasLock) return true;

        // 2. Check Existing Assignments (Busy)
        const isBusy = tids.some(tid => 
            window._teacherBusy && window._teacherBusy.some(b => b.day == day && b.period == period && b.teacher_id.toString().split(',').includes(tid))
        );
        
        return isBusy;
    };

    window.highlightSlots = function(td, isEnter) {
        if (!isEnter) {
            setTimeout(function() {
                const hovered = document.querySelectorAll('.slot-empty:hover');
                if (hovered.length === 0) clearAllHighlights();
            }, 50);
            return;
        }

        clearAllHighlights();
        const $row = $(td).closest('tr');
        const allCells = $row.find('td').toArray(); // ใช้ทุกช่องเพื่อตรวจจับการซ้อนทับที่ถูกต้อง
        const startIdx = allCells.indexOf(td);
        if (startIdx === -1) return;

        const count = window._dragPeriods;
        for (let i = 0; i < count; i++) {
            const target = allCells[startIdx + i];
            if (!target) break;
            
            const $target = $(target);
            const d = $target.data('day');
            const p = $target.data('period');
            
            // 🍱 Dynamic Lunch / Break Check from Cell
            let isForbidden = $target.hasClass('slot-forbidden') || $target.data('is-forbidden') == 1;

            const isEmpty = $target.hasClass('slot-empty');

            if (isForbidden) {
                $target.addClass('bg-label-danger border-danger').append('<div class="forbidden-msg text-danger fw-bold" style="font-size:0.4rem; position:absolute; bottom:2px; left:0; width:100%; text-align:center;">ติดคาบพัก</div>');
            } else if (!isEmpty && i > 0) { // i > 0 คือช่องถัดไปในบล็อกที่ไม่ว่าง
                $target.addClass('bg-label-danger border-danger').append('<div class="forbidden-msg text-danger fw-bold" style="font-size:0.4rem; position:absolute; bottom:2px; left:0; width:100%; text-align:center;">มีวิชาอยู่แล้ว</div>');
            } else if (window.isTeacherBusy(d, p, window._dragTeacherId)) {
                const $slot = $target.find('.lock-slot-wizard');
                $slot.addClass('bg-label-danger border-danger');
                $slot.append('<div class="forbidden-msg text-danger fw-bold" style="font-size:0.4rem; position:absolute; bottom:2px; left:0; width:100%; text-align:center;">ครูไม่ว่าง</div>');
            } else {
                $target.find('.lock-slot-wizard').addClass('drag-target-hover');
            }
            window._lastHighlighted.push(target);
        }
    };

    window.dropConstraint = function(ev, day, period) {
        ev.preventDefault(); 
        const id = ev.dataTransfer.getData("subject_id"); 
        const numPeriods = parseInt(ev.dataTransfer.getData("num_periods")) || 1;
        const cls = $('#wizardClassSelect').val();

        let hasConflict = false;
        let conflictMsg = '';
        
        const $row = $(ev.target).closest('tr');
        const allCells = $row.find('td').toArray();
        let targetCell = $(ev.target).hasClass('slot-empty') ? ev.target : $(ev.target).closest('td')[0];
        const startIdx = allCells.indexOf(targetCell);

        for (let i = 0; i < numPeriods; i++) {
            const cell = allCells[startIdx + i];
            if (!cell) {
                hasConflict = true;
                conflictMsg = 'จำนวนคาบเกินเวลาที่กำหนด';
                break;
            }
            
            const $cell = $(cell);
            const d = $cell.data('day');
            const p = $cell.data('period');

            // 🍱 Dynamic Lunch / Break Check from Cell
            let isForbidden = $cell.hasClass('slot-forbidden') || $cell.data('is-forbidden') == 1;

            const isEmpty = $cell.hasClass('slot-empty');

            if (isForbidden) {
                hasConflict = true;
                conflictMsg = 'ไม่สามารถวางทับคาบพักกลางวันของวิชาในกลุ่มได้';
                break;
            }
            if (!isEmpty && i > 0) {
                hasConflict = true;
                conflictMsg = 'คาบถัดไปในบล็อกนี้มีการลงวิชาอื่นไว้แล้ว';
                break;
            }
            if (window.isTeacherBusy(d, p, window._dragTeacherId)) {
                hasConflict = true;
                conflictMsg = 'ครูผู้สอนไม่ว่างในคาบนี้';
                break;
            }
        }

        clearAllHighlights();

        if (hasConflict) {
            Swal.fire({ icon: 'error', title: 'ไม่สามารถวางได้', text: conflictMsg });
            return;
        }

        $.ajax({
            url: '<?= base_url("admin/academic/timetable/save-subject-lock") ?>',
            type: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            data: { 
                class_name: cls, day: day, period: period, num_periods: numPeriods, subject_id: id, 
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>' 
            },
            success: function(res) { 
                if (res.status === 'success') {
                    refreshConstraintGrid();
                    refreshOverallProgress();
                } else {
                    Swal.fire({ icon: 'error', title: 'เกิดข้อผิดพลาด', text: res.message });
                }
            },
            error: function() {
                Swal.fire({ icon: 'error', title: 'เกิดข้อผิดพลาด', text: 'ไม่สามารถบันทึกได้' });
            }
        });
    };

    window.removeLockWizard = function(day, period) {
        const cls = $('#wizardClassSelect').val();
        $.ajax({
            url: '<?= base_url("admin/academic/timetable/save-subject-lock") ?>',
            type: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            data: { class_name: cls, day: day, period: period, num_periods: 1, subject_id: '', '<?= csrf_token() ?>': '<?= csrf_hash() ?>' },
            success: function() { 
                refreshConstraintGrid();
                refreshOverallProgress();
            }
        });
    };

    // --- 🗓️ Step 3: Subject Constraints ---
    // Load Master Lock Grid on start (Summary of all classes)
    function loadDefaultGrid() {
        $('#gridLoader').removeClass('d-none');
        $.get('<?= base_url("admin/academic/timetable/get-master-lock-grid") ?>', function(html) {
            $('#gridLoader').addClass('d-none');
            $('#constraintGridContainer').html(html);
        });
    }
    loadDefaultGrid();

    $('#wizardClassSelect').on('change', function() {
        const className = $(this).val(); 
        if (!className) {
            loadDefaultGrid();
            $('#wizardSubjectList').html('<div class="text-center py-5 bg-white rounded-3 border border-dashed text-muted shadow-sm"><i class="bx bx-mouse-alt fs-2 mb-2 d-block opacity-25"></i><p class="small mb-0">กรุณาเลือกห้องเรียนก่อน</p></div>');
            return;
        }

        $('#gridLoader').removeClass('d-none');
        $('#constraintGridContainer').addClass('opacity-50');

        $.get('<?= base_url("admin/academic/timetable/get-constraint-grid") ?>', { class: className }, function(html) {
            $('#gridLoader').addClass('d-none');
            $('#constraintGridContainer').removeClass('opacity-50').html(html);
            
            // 🔄 REAL-TIME SYNC: Update the Left Sidebar Subject List
            const $newHtml = $(html);
            const $subList = $newHtml.find('#tempSubjectList').length ? $newHtml.find('#tempSubjectList') : $newHtml.filter('#tempSubjectList');
            
            if ($subList.length) {
                $('#wizardSubjectList').hide().html($subList.html()).fadeIn(200);
                $('#subjectCountBadge').text($subList.find('.subject-card-wizard').length);
                
                // Re-init tooltips if any
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                });
            }
        });
    });

    function loadTeacherSummary() {
        $('#teacherGridLoader').removeClass('d-none');
        $.get('<?= base_url("admin/academic/timetable/get-teacher-constraint-summary") ?>', function(html) {
            $('#teacherGridLoader').addClass('d-none');
            $('#teacherConstraintGridContainer').removeClass('opacity-50').html(html);
        });
    }

    $('#wizardTeacherSelect').on('change', function() {
        const teacherId = $(this).val();
        if (!teacherId) {
            loadTeacherSummary();
            return;
        }
        
        $('#teacherGridLoader').removeClass('d-none');
        $('#teacherConstraintGridContainer').addClass('opacity-50');

        $.get('<?= base_url("admin/academic/timetable/get-teacher-constraint-grid") ?>', { teacher_id: teacherId }, function(html) {
            $('#teacherGridLoader').addClass('d-none');
            $('#teacherConstraintGridContainer').removeClass('opacity-50').html(html);
        });
    });
    
    // Initial load of summary
    loadTeacherSummary();

    window.refreshConstraintGrid = function() {
        const className = $('#wizardClassSelect').val();
        if (className) {
            const timestamp = new Date().getTime();
            $('#gridLoader').removeClass('d-none');
            
            $.ajax({
                url: '<?= base_url("admin/academic/timetable/get-constraint-grid") ?>',
                type: 'GET',
                data: { class: className, _t: timestamp },
                cache: false,
                success: function(html) {
                    $('#gridLoader').addClass('d-none');
                    $('#constraintGridContainer').removeClass('opacity-50').html(html);
                    
                    // 🔄 REAL-TIME SYNC
                    const $tempDiv = $('<div>').append($.parseHTML(html));
                    const $subList = $tempDiv.find('#tempSubjectList');
                    
                    if ($subList.length) {
                        $('#wizardSubjectList').empty().append($subList.html()).show();
                        
                        const newCount = $subList.find('.subject-card-wizard').length;
                        $('#subjectCountBadge').text(newCount);

                        // Re-init tooltips
                        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                            return new bootstrap.Tooltip(tooltipTriggerEl)
                        });
                    }
                }
            });
        } else {
            loadDefaultGrid();
        }
    };

    $('#wizardRoomSelect').on('change', function() {
        const roomName = $(this).val();
        if (!roomName) {
            $('#roomConstraintGridContainer').html('<div class="text-center py-5 text-muted small"><i class="bx bx-building-house fs-2 d-block opacity-25"></i> เลือกห้องเพื่อจัดการเวลาไม่ว่าง</div>');
            return;
        }
        
        $('#roomGridLoader').removeClass('d-none');
        $('#roomConstraintGridContainer').addClass('opacity-50');

        $.get('<?= base_url("admin/academic/timetable/get-room-constraint-grid") ?>', { room_name: roomName }, function(html) {
            $('#roomGridLoader').addClass('d-none');
            $('#roomConstraintGridContainer').removeClass('opacity-50').html(html);
        });
    });

    window.toggleTeacherLock = function(td, teacherId, day, period) {
        const $div = $(td).find('.lock-slot-teacher');
        const isLocked = $div.hasClass('bg-danger');
        const action = isLocked ? 'unlock' : 'lock';

        $.post('<?= base_url("admin/academic/timetable/save-teacher-constraint") ?>', {
            teacher_id: teacherId, day: day, period: period, action: action,
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
        }, function(res) {
            if (res.status === 'success') {
                $div.toggleClass('bg-danger text-white');
                $div.html(action === 'lock' ? '<i class="bx bx-x fs-4"></i>' : '');
                refreshOverallProgress();
            }
        });
    };

    window.toggleRoomLock = function(td, roomName, day, period) {
        const $div = $(td).find('.lock-slot-room');
        const isLocked = $div.hasClass('bg-warning');
        const action = isLocked ? 'unlock' : 'lock';

        $.post('<?= base_url("admin/academic/timetable/save-room-constraint") ?>', {
            room_name: roomName, day: day, period: period, action: action,
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
        }, function(res) {
            if (res.status === 'success') {
                $div.toggleClass('bg-warning text-white');
                $div.html(action === 'lock' ? '<i class="bx bx-block fs-4"></i>' : '');
                refreshOverallProgress();
            }
        });
    };

    // --- 🧠 Step 4: AI Engine Settings & Actions ---
    $('input[name="ai_depth_option"]').on('change', function() {
        const val = $(this).val();
        if (val === '10') {
            $('#modeDescription').text('ค้นหารวดเร็ว (1-2 วิ)').removeClass('bg-label-warning bg-label-info').addClass('bg-label-success');
        } else if (val === '30') {
            $('#modeDescription').text('ค้นหาเชิงลึก (3-5 วิ - แนะนำ)').removeClass('bg-label-success bg-label-warning').addClass('bg-label-info');
        } else if (val === '50') {
            $('#modeDescription').text('ค้นหาละเอียดสูงสุด (5-10 วิ)').removeClass('bg-label-success bg-label-info').addClass('bg-label-warning');
        }
    });

    // 🔍 Pre-flight Capacity Check
    $('#btnPreflightCheck').on('click', function() {
        const $btn = $(this);
        const origHtml = $btn.html();
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> กำลังวิเคราะห์ความจุและความพร้อม...');

        $.ajax({
            url: '<?= base_url('admin/academic/timetable/preflight-check') ?>',
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                $btn.prop('disabled', false).html(origHtml);
                const $container = $('#preflightResultContainer');
                $container.empty().removeClass('d-none');

                if (res.status === 'success') {
                    let html = `
                        <div class="card border-0 shadow-sm rounded-4 p-3 mb-2" style="background: #eafaf1; border-left: 4px solid #15a362 !important;">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bx bx-check-circle fs-3 text-success"></i>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-success">ความจุภาพรวมสมบูรณ์ (100% Ready)</h6>
                                        <small class="text-muted">ตรวจสอบ ${res.total_classes} ห้องเรียน และครู ${res.total_teachers} ท่าน ไม่พบห้องหรือครูที่มีภาระงานเกินความจุ</small>
                                    </div>
                                </div>
                                <span class="badge bg-success rounded-pill px-3 py-2">พร้อมประมวลผล</span>
                            </div>
                        </div>
                    `;
                    $container.html(html);
                } else {
                    let badgeColor = (res.status === 'error') ? 'bg-danger' : 'bg-warning';
                    let badgeText = (res.status === 'error') ? 'พบปัญหาความจุเกิน' : 'มีจุดที่ควรระวัง';
                    let headerTitle = (res.status === 'error') ? 'พบเงื่อนไขที่อาจทำให้จัดไม่สำเร็จ' : 'พบข้อควรระวัง';

                    let issuesList = '';
                    if (res.issues && res.issues.length > 0) {
                        issuesList += '<div class="list-group list-group-flush mt-2">';
                        res.issues.forEach(iss => {
                            let icon = (iss.type === 'danger') ? 'bx-error-circle text-danger' : 'bx-info-circle text-warning';
                            issuesList += `
                                <div class="list-group-item px-2 py-2 bg-transparent border-bottom">
                                    <div class="d-flex align-items-start gap-2">
                                        <i class="bx ${icon} fs-5 mt-1"></i>
                                        <div class="small">
                                            <div class="fw-bold text-dark">${iss.title}</div>
                                            <div class="text-muted">${iss.message}</div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                        issuesList += '</div>';
                    }

                    let html = `
                        <div class="card border-0 shadow-sm rounded-4 p-3 mb-2" style="background: #fff8f0; border-left: 4px solid ${(res.status === 'error' ? '#ff3e1d' : '#ffab00')} !important;">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bx ${(res.status === 'error' ? 'bx-error-alt text-danger' : 'bx-bell text-warning')} fs-3"></i>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark">${headerTitle}</h6>
                                        <small class="text-muted">ตรวจพบประเด็นใน ${res.class_capacity_issues || 0} ห้องเรียน (จาก ${res.total_classes} ห้อง) และครู ${res.teacher_capacity_issues || 0} ท่าน (จาก ${res.total_teachers} ท่าน)</small>
                                    </div>
                                </div>
                                <span class="badge ${badgeColor} rounded-pill px-3 py-1">${badgeText}</span>
                            </div>
                            ${issuesList}
                            ${res.status === 'error' ? '<div class="alert alert-danger border-0 p-2 mt-2 mb-0 small"><i class="bx bx-bulb me-1"></i> แนะนำ: เข้าไปแก้ไขชั่วโมงใน Step 2 หรือปลดล็อคเวลาครูใน Step 3 ก่อนรัน เพื่อให้ AI จัดได้ 100% ครับ</div>' : ''}
                        </div>
                    `;
                    $container.html(html);
                }
            },
            error: function() {
                $btn.prop('disabled', false).html(origHtml);
                Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถเชื่อมต่อการตรวจสอบ Pre-flight ได้', 'error');
            }
        });
    });

    function renderFailureReport(res) {
        if (!res.failed_list || res.failed_list.length === 0) return;
        const failCount = res.best_fail_count || res.fail_count || res.failed_list.length;
        let persistentHtml = `
            <div class="alert alert-danger border-0 shadow-sm mb-4 text-start">
                <div class="d-flex">
                    <i class="bx bx-error-circle fs-3 me-2 mt-1"></i>
                    <div>
                        <h6 class="alert-heading fw-bold mb-1">ประมวลผลไม่สำเร็จ (จัดไม่ได้ ${failCount} รายการ)</h6>
                        <p class="mb-2 small">ระบบได้ <b>ยกเลิกการเปลี่ยนแปลง</b> เพื่อรักษาข้อมูลเดิมไว้ กรุณาแก้ไขข้อขัดแย้งตามคำแนะนำด้านล่าง:</p>
                        <div class="table-responsive bg-white rounded-3 shadow-sm border border-danger-subtle">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="bg-danger text-white">
                                    <tr><th>ห้อง</th><th>วิชา</th><th>ครูผู้สอน</th><th class="text-center">คาบ</th><th>สาเหตุขัดแย้ง</th></tr>
                                </thead>
                                <tbody>`;

        res.failed_list.forEach(item => {
            let reasonHtml = '';
            if (item.reasons && item.reasons.length > 0) {
                reasonHtml = `<ul class="mb-0 ps-3 small text-danger">`;
                item.reasons.forEach(r => { reasonHtml += `<li>${r}</li>`; });
                reasonHtml += `</ul>`;
            } else {
                reasonHtml = `<span class="text-muted small">ไม่พบช่องว่างที่เหมาะสม</span>`;
            }

            persistentHtml += `<tr>
                <td class="fw-bold text-primary">${item.class_name}</td>
                <td><span class="badge bg-label-secondary me-1">${item.subject_code}</span> ${item.subject_name}</td>
                <td class="small">${item.teacher_name}</td>
                <td class="text-center"><span class="badge bg-danger rounded-pill">${item.block_size}</span></td>
                <td>${reasonHtml}</td>
            </tr>`;
        });
        persistentHtml += `</tbody></table></div>`;

        persistentHtml += `
            <div class="bg-label-info p-3 rounded-3 border border-info-subtle mt-3">
                <h6 class="fw-bold mb-2 text-info"><i class="bx bx-bulb me-1"></i> กลยุทธ์แก้ไขให้สำเร็จ:</h6>
                <ul class="small mb-0 ps-3 text-dark">
                    <li><b>เลือกโหมดค้นหาเชิงลึก (30 หรือ 50 รอบ):</b> ช่วยให้ AI ลองสลับลำดับการวางวิชาได้หลากหลายรูปแบบมากขึ้น</li>
                    <li><b>วิชาที่คาบคู่/คาบยาว:</b> หากวิชามี 3-4 คาบ ลองหั่นคาบ (ใน Step 2) ให้เล็กลง เช่น 2+1 หรือ 2+2</li>
                    <li><b>ภาระงานครู:</b> ตรวจสอบว่าครูท่านนี้ถูก "ล็อคเวลาไม่ว่าง" (ใน Step 3) มากเกินไปหรือไม่</li>
                    <li><b>จัดต่อใน Editor:</b> สามารถเลือก "บันทึกรอบที่ดีที่สุด" แล้วเปิดโหมด Editor เพื่อลากวางด้วยมือได้ทันที</li>
                </ul>
            </div>
        `;
        persistentHtml += `</div></div></div></div>`;

        if (res.processing_log && res.processing_log.length > 0) {
            persistentHtml += `
                <div class="mt-4">
                    <h6 class="fw-bold mb-2"><i class="bx bx-list-check me-1"></i> บันทึกการประมวลผล (Processing Log):</h6>
                    <div class="p-3 bg-dark text-success rounded-3 small shadow-inner" style="max-height: 200px; overflow-y: auto; font-family: 'Courier New', Courier, monospace; border: 1px solid #15a362;">`;
            res.processing_log.forEach(log => {
                persistentHtml += `<div class="mb-1">> ${log}</div>`;
            });
            persistentHtml += `</div></div>`;
        }

        sessionStorage.setItem('ai_failure_report', persistentHtml);
        localStorage.setItem('timetable_wizard_step', 4);
        location.reload();
    }

    // 🤖 AI Generate Trigger
    $('#btnAIGenerate').on('click', function() {
        const selectedDepth = $('input[name="ai_depth_option"]:checked').val() || 10;

        Swal.fire({ 
            title: 'ยืนยันการประมวลผล?', 
            text: `ระบบจะทำการค้นหาและคำนวณคาบเรียนที่เหลือทั้งหมด (${selectedDepth} รอบ)`,
            icon: 'question', 
            showCancelButton: true,
            confirmButtonText: 'เริ่มจัดตาราง',
            cancelButtonText: 'ตรวจสอบอีกครั้ง',
            customClass: { confirmButton: 'btn btn-primary', cancelButton: 'btn btn-label-secondary' }
        }).then((result) => {
            if (result.isConfirmed) {
                // Clear previous reports
                sessionStorage.removeItem('ai_failure_report');
                $('#aiReportContainer').empty();

                $('#modalAIProcessing').modal('show');
                $.ajax({
                    url: '<?= base_url('admin/academic/timetable/auto-generate') ?>', 
                    type: 'POST', 
                    data: {
                        max_attempts: selectedDepth,
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                    },
                    headers: { 'X-CSRF-TOKEN': '<?= csrf_hash() ?>' },
                    success: function(res) { 
                        $('#modalAIProcessing').modal('hide'); 
                        if (res.status === 'success') { 
                            if (res.debug && res.debug.total_assignments === 0) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'ไม่พบข้อมูลงานสอน',
                                    text: `ไม่พบข้อมูลการมอบหมายงานสอนในปีการศึกษา ${res.debug.term}/${res.debug.year} กรุณาตรวจสอบข้อมูลในขั้นตอนที่ 1 และ 2`,
                                    confirmButtonText: 'รับทราบ'
                                });
                                return;
                            }

                            if (res.fail_count === 0) {
                                const attemptText = res.winning_attempt ? ` (ลงตัวในรอบที่ ${res.winning_attempt})` : '';
                                Swal.fire({
                                    icon: 'success',
                                    title: 'จัดตารางสำเร็จ 100%!',
                                    text: `ระบบได้ทำการจัดตารางสอนเสร็จสมบูรณ์เรียบร้อยแล้วครับ${attemptText}`,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    localStorage.setItem('timetable_wizard_step', 5);
                                    location.reload();
                                });
                            }
                        } else if (res.status === 'partial_success') {
                            Swal.fire({
                                icon: 'info',
                                title: 'บันทึกคาบเรียนที่ดีที่สุดสำเร็จ!',
                                html: `ระบบได้บันทึกคาบเรียนจากรอบที่ดีที่สุด (รอบที่ ${res.winning_attempt}) เรียบร้อยแล้ว<br><span class="text-danger fw-semibold">เหลืออีก ${res.failed_count} รายการที่ยังไม่ได้จัด</span><br>ระบบจะพาท่านไปยังหน้า Editor เพื่อจัดคาบที่เหลือต่อด้วยตนเองครับ`,
                                confirmButtonText: 'เปิดหน้า Editor',
                                confirmButtonColor: '#15a362'
                            }).then(() => {
                                window.location.href = '<?= base_url('admin/academic/timetable/editor') ?>';
                            });
                        } else {
                            // 🔴 กรณีมีข้อขัดแย้ง
                            if (res.can_save_best) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: `ประมวลผล ${selectedDepth} รอบแล้ว`,
                                    html: `
                                        <p class="mb-2">มีคาบเรียนที่ติดขัดข้อจำกัดหนาแน่น <b>${res.best_fail_count} รายการ</b> (จัดลงตัวได้มากที่สุดในรอบที่ ${res.best_attempt_num})</p>
                                        <div class="alert alert-warning text-start small border-0 mb-2">
                                            <b>ท่านต้องการดำเนินการอย่างไรต่อ?</b>
                                            <ul class="mb-0 ps-3 mt-1">
                                                <li><b>บันทึกรอบที่ดีที่สุด:</b> นำคาบที่จัดได้ลงตาราง แล้วไปจัดส่วนที่เหลือต่อใน Editor</li>
                                                <li><b>ค้นหาเชิงลึก 50 รอบ:</b> ให้ AI ลองค้นหาเพิ่มอีก 50 รอบ</li>
                                            </ul>
                                        </div>
                                    `,
                                    showCancelButton: true,
                                    showDenyButton: true,
                                    confirmButtonText: '<i class="bx bx-save me-1"></i> บันทึกรอบนี้ แล้วไป Editor',
                                    denyButtonText: '<i class="bx bx-brain me-1"></i> ค้นหาเชิงลึก 50 รอบ',
                                    cancelButtonText: 'ดูรายงานข้อขัดแย้ง',
                                    confirmButtonColor: '#15a362',
                                    denyButtonColor: '#696cff',
                                    cancelButtonColor: '#8592a3',
                                    customClass: {
                                        popup: 'swal2-wide'
                                    }
                                }).then((choice) => {
                                    if (choice.isConfirmed) {
                                        $('#modalAIProcessing').modal('show');
                                        $.ajax({
                                            url: '<?= base_url('admin/academic/timetable/auto-generate') ?>',
                                            type: 'POST',
                                            data: {
                                                save_best: true,
                                                max_attempts: selectedDepth,
                                                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                                            },
                                            headers: { 'X-CSRF-TOKEN': '<?= csrf_hash() ?>' },
                                            success: function(resp) {
                                                $('#modalAIProcessing').modal('hide');
                                                if (resp.status === 'partial_success' || resp.status === 'success') {
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'บันทึกสำเร็จ!',
                                                        text: 'กำลังเปิดหน้า Editor เพื่อให้ท่านจัดคาบที่เหลือต่อ...',
                                                        timer: 1500,
                                                        showConfirmButton: false
                                                    }).then(() => {
                                                        window.location.href = '<?= base_url('admin/academic/timetable/editor') ?>';
                                                    });
                                                } else {
                                                    Swal.fire('เกิดข้อผิดพลาด', resp.message || 'ไม่สามารถบันทึกได้', 'error');
                                                }
                                            },
                                            error: function() {
                                                $('#modalAIProcessing').modal('hide');
                                                Swal.fire('ข้อผิดพลาด', 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้', 'error');
                                            }
                                        });
                                    } else if (choice.isDenied) {
                                        $('#depth_50').prop('checked', true).trigger('change');
                                        $('#btnAIGenerate').trigger('click');
                                    } else {
                                        renderFailureReport(res);
                                    }
                                });
                            } else if (res.failed_list && res.failed_list.length > 0) {
                                renderFailureReport(res);
                            } else {
                                let errorDetail = res.message || 'เกิดข้อผิดพลาดในการประมวลผล';
                                if (res.line) errorDetail += ` (บรรทัดที่: ${res.line})`;
                                if (res.file) errorDetail += ` ในไฟล์: ${res.file.split(/[\\/]/).pop()}`;

                                let logHtml = '';
                                if (res.processing_log && res.processing_log.length > 0) {
                                    logHtml = `<div class="mt-3 p-2 bg-dark text-success text-start rounded-2 small" style="max-height: 150px; overflow-y: auto; font-family: monospace;">`;
                                    res.processing_log.forEach(log => { logHtml += `<div>> ${log}</div>`; });
                                    logHtml += `</div>`;
                                }

                                Swal.fire({
                                    icon: 'error',
                                    title: 'เกิดข้อผิดพลาดทางเทคนิค',
                                    html: `
                                        <div class="text-start">
                                            <p class="mb-2 fw-bold text-danger">สาเหตุ:</p>
                                            <div class="p-2 bg-light rounded border mb-2 small" style="font-family: monospace;">
                                                ${errorDetail}
                                            </div>
                                            ${logHtml}
                                            <p class="mt-2 small text-muted">กรุณาแจ้งแอดมินหรือตรวจสอบการตั้งค่า "คาบเรียน" อีกครั้งครับ</p>
                                        </div>
                                    `,
                                    confirmButtonText: 'รับทราบ'
                                });
                            }
                        }
                    },
                    error: function() {
                        $('#modalAIProcessing').modal('hide');
                        Swal.fire('ข้อผิดพลาด', 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้', 'error');
                    }
                });
            }
        });
    });

    // --- 🌟 Step 5: Public Display Mode Switcher ---
    $(document).on('click', '.btn-timetable-mode-toggle', function() {
        const mode = $(this).data('mode');
        const modeTitle = (mode === 'system') ? 'ระบบจัดตารางสอน (Live Timetable)' : 'ไฟล์รูปภาพที่อัปโหลด (Uploaded Images)';

        Swal.fire({
            title: 'เปลี่ยนโหมดแสดงตารางเรียน?',
            text: `ต้องการเปลี่ยนเป็น "${modeTitle}" สำหรับหน้าเว็บ /ClassSchedule ใช่หรือไม่?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'ใช่, เปลี่ยนโหมด',
            cancelButtonText: 'ยกเลิก',
            confirmButtonColor: '#15a362',
            cancelButtonColor: '#8592a3'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'กำลังบันทึกการตั้งค่า...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                $.ajax({
                    url: '<?= base_url('admin/academic/timetable/toggle-display-mode') ?>',
                    type: 'POST',
                    data: { mode: mode },
                    dataType: 'json',
                    success: function(res) {
                        if (res && res.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'สำเร็จ!',
                                text: res.message,
                                confirmButtonColor: '#15a362'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด!',
                                text: res.message || 'ไม่สามารถเปลี่ยนโหมดได้',
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด!',
                            text: 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                });
            }
        });
    });

    // --- 🧭 Wizard Navigation Buttons (Next / Prev) ---
    $(document).on('click', '.next-step, #btnNext', function(e) {
        e.preventDefault();
        if (currentStep < totalSteps) {
            goToStep(currentStep + 1);
        }
    });

    $(document).on('click', '.prev-step, #btnPrev', function(e) {
        e.preventDefault();
        if (currentStep > 1) {
            goToStep(currentStep - 1);
        }
    });

    // --- 🎉 Step 5: Finish & Review ---
    $('.select2-simple').select2({ theme: 'bootstrap-5', width: '100%' });

    $('#finishClassSelect').on('change', function() {
        const className = $(this).val();
        if (!className) {
            $('#finishTimetableContainer').html('<div class="text-center py-5 text-muted"><i class="bx bx-mouse-alt fs-1 d-block mb-2 opacity-25"></i><p>เลือกห้องเรียนด้านบนเพื่อแสดงตาราง</p></div>');
            return;
        }

        $('#finishTimetableLoader').removeClass('d-none');
        $('#finishTimetableContainer').addClass('opacity-50');

        $.get('<?= base_url("admin/academic/timetable/view-class-timetable") ?>', { class: className }, function(html) {
            $('#finishTimetableLoader').addClass('d-none');
            $('#finishTimetableContainer').removeClass('opacity-50').html(html);
        });
    });

    // --- 🛡️ Advanced Integrity Check (Audit) ---
    $('#btnAuditSchedule').on('click', function() {
        const $btn = $(this);
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> กำลังสแกน...');

        $.get('<?= base_url('admin/academic/timetable/audit') ?>', function(res) {
            $btn.prop('disabled', false).html('<i class="bx bx-shield-quarter me-2"></i> ตรวจสอบคุณภาพตาราง');
            
            if (res.status === 'success') {
                let html = `
                    <div class="text-start">
                        <p class="mb-4 text-muted">ระบบทำการตรวจสอบตารางเรียนด้วยกฎเชิงวิชาการขั้นสูง พบจุดที่ควรพิจารณาแก้ไขดังนี้:</p>
                        <div class="list-group list-group-flush shadow-sm rounded-3 overflow-hidden border">
                `;

                if (res.warnings.length === 0) {
                    html += `
                        <div class="list-group-item text-center py-5">
                            <i class='bx bx-check-double text-success fs-1 mb-2'></i>
                            <h6 class="fw-bold mb-0">ยินดีด้วย! ตารางของคุณมีคุณภาพยอดเยี่ยม</h6>
                            <p class="small text-muted mb-0">ไม่พบข้อขัดแย้งหรือภาระงานที่หนักเกินไป</p>
                        </div>
                    `;
                } else {
                    res.warnings.forEach(w => {
                        const icon = w.severity === 'warning' ? 'bx-error text-warning' : 'bx-info-circle text-info';
                        html += `
                            <div class="list-group-item list-group-item-action d-flex align-items-start p-3">
                                <i class='bx ${icon} fs-4 me-3 mt-1'></i>
                                <div>
                                    <div class="d-flex align-items-center mb-1">
                                        <h6 class="fw-bold mb-0 me-2">${w.title}</h6>
                                        <span class="badge bg-label-secondary small">${w.target}</span>
                                    </div>
                                    <p class="small mb-0 text-muted">${w.message}</p>
                                </div>
                            </div>
                        `;
                    });
                }

                html += `</div></div>`;

                Swal.fire({
                    title: 'ผลการตรวจสอบคุณภาพตาราง',
                    html: html,
                    width: '700px',
                    confirmButtonText: 'รับทราบ',
                    customClass: { confirmButton: 'btn btn-primary px-5 rounded-pill' }
                });
            }
        });
    });

    // --- 📦 Grouping & Bulk Actions Logic ---
    $(document).on('change', '#check-all-assignments', function() {
        const isChecked = $(this).is(':checked');
        $('.assignment-row:visible .assign-checkbox').prop('checked', isChecked);
        toggleGroupActions();
    });

    $(document).on('change', '.assign-checkbox', function() {
        const totalVisible = $('.assignment-row:visible .assign-checkbox').length;
        const checkedVisible = $('.assignment-row:visible .assign-checkbox:checked').length;
        $('#check-all-assignments').prop('checked', totalVisible > 0 && totalVisible === checkedVisible);
        toggleGroupActions();
    });

    function toggleGroupActions() {
        const count = $('.assign-checkbox:checked').length;
        if (count >= 1) {
            $('#group-actions').removeClass('d-none').addClass('d-flex');
            $('#selectedCountBadge').text('เลือก ' + count + ' รายการ');
            $('#deleteSelectedCount').text(count);
        } else {
            $('#group-actions').addClass('d-none').removeClass('d-flex');
        }
    }

    window.clearSelection = function() {
        $('.assign-checkbox, #check-all-assignments').prop('checked', false);
        toggleGroupActions();
    };

    window.deleteSelectedAssignments = function() {
        const idGroups = [];
        $('.assign-checkbox:checked').each(function() {
            const val = $(this).val();
            if (val) {
                idGroups.push(val);
            }
        });

        if (idGroups.length === 0) {
            Swal.fire({ icon: 'warning', title: 'กรุณาเลือกรายการที่ต้องการลบ', confirmButtonColor: '#15a362' });
            return;
        }

        const allIds = idGroups.join(',');
        const totalSelectedItems = idGroups.length;

        Swal.fire({
            title: 'ยืนยันการลบทั้งหมดจากที่เลือก?',
            text: 'ต้องการลบข้อมูลการมอบหมายที่เลือกไว้ทั้งหมดจำนวน ' + totalSelectedItems + ' รายการใช่หรือไม่? (การลบนี้จะส่งผลต่อตารางสอนที่จัดไว้)',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff3e1d',
            cancelButtonColor: '#8592a3',
            confirmButtonText: '<i class="bx bx-trash me-1"></i> ใช่, ลบทั้งหมดจากที่เลือก',
            cancelButtonText: 'ยกเลิก',
            customClass: {
                container: 'swal2-container'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'กำลังลบข้อมูล...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                const csrfToken = $('input[name="<?= csrf_token() ?>"]').val() || '<?= csrf_hash() ?>';

                $.ajax({
                    url: '<?= base_url('admin/academic/timetable/delete-assignment') ?>',
                    type: 'POST',
                    data: {
                        ids: allIds,
                        "<?= csrf_token() ?>": csrfToken
                    },
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 'success') {
                            clearSelection();
                            refreshAssignmentList();
                            Swal.fire({
                                icon: 'success',
                                title: 'ลบข้อมูลสำเร็จ',
                                text: 'ลบรายการที่เลือกเรียบร้อยแล้วครับ',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({ icon: 'error', title: 'ผิดพลาด', text: res.message || 'ไม่สามารถลบข้อมูลได้', confirmButtonColor: '#15a362' });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้: ' + (xhr.responseJSON?.message || xhr.statusText),
                            confirmButtonColor: '#15a362'
                        });
                    }
                });
            }
        });
    };

    window.saveTeachingGroup = function() {
        const ids = [];
        $('.assign-checkbox:checked').each(function() {
            ids.push($(this).val());
        });

        if (ids.length < 2) {
            Swal.fire('คำแนะนำ', 'กรุณาเลือกวิชาอย่างน้อย 2 รายการเพื่อมัดรวมกลุ่ม', 'info');
            return;
        }

        Swal.fire({
            title: 'ยืนยันการมัดรวมกลุ่ม?',
            text: "วิชาที่เลือกจะถูกจัดตารางในเวลาเดียวกันเสมอ และนับภาระงานสอนครูรวมกัน",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#15a362',
            confirmButtonText: 'ตกลง, มัดรวมเลย',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // 🔄 Get current CSRF from hidden input if exists, or use the initial hash
                const csrfToken = $('input[name="<?= csrf_token() ?>"]').val() || '<?= csrf_hash() ?>';
                
                $.post('<?= base_url('admin/academic/timetable/save-teaching-group') ?>', {
                    "<?= csrf_token() ?>": csrfToken,
                    ids: ids.join(',')
                }, function(res) {
                    // 🔄 Update token in all inputs if server returned a new one
                    if (res.csrf_hash) {
                        $('input[name="<?= csrf_token() ?>"]').val(res.csrf_hash);
                    }
                    
                    if (res.status === 'success') {
                        Swal.fire('สำเร็จ', res.message, 'success');
                        refreshAssignmentList();
                    } else {
                        Swal.fire('ผิดพลาด', res.message, 'error');
                    }
                });
            }
        });
    };

    $(document).on('click', '.btn-delete-teaching-group', function() {
        const ids = $(this).data('ids');
        Swal.fire({
            title: 'แยกกลุ่มสอนควบ?',
            text: "วิชาในกลุ่มนี้จะถูกแยกออกจากกันและจัดตารางอิสระ",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'ตกลง, แยกกลุ่ม',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                const csrfToken = $('input[name="<?= csrf_token() ?>"]').val() || '<?= csrf_hash() ?>';
                $.post('<?= base_url('admin/academic/timetable/delete-teaching-group') ?>', {
                    "<?= csrf_token() ?>": csrfToken,
                    ids: ids
                }, function(res) {
                    if (res.csrf_hash) {
                        $('input[name="<?= csrf_token() ?>"]').val(res.csrf_hash);
                    }
                    if (res.status === 'success') {
                        Swal.fire('สำเร็จ', res.message, 'success');
                        refreshAssignmentList();
                    }
                });
            }
        });
    });

    // --- 🔍 Timetable Assignment Filter ---
    window.filterAssignments = function() {
        let searchVal = $('#searchAssignmentInput').val() || '';
        searchVal = searchVal.trim().toLowerCase();
        
        let words = searchVal.split(/\s+/).filter(w => w.length > 0);
        let totalHours = 0;
        let visibleCount = 0;
        
        if (words.length === 0) {
            $('#btnClearSearch').hide();
            $('.assignment-row').show();
            $('.assignment-row').each(function() {
                totalHours += parseFloat($(this).data('hours')) || 0;
                visibleCount++;
            });
        } else {
            $('#btnClearSearch').show();
            $('.assignment-row').each(function() {
                let rowSearchText = $(this).data('search') || '';
                let isMatch = true;
                for (let i = 0; i < words.length; i++) {
                    if (rowSearchText.indexOf(words[i]) === -1) {
                        isMatch = false;
                        break;
                    }
                }
                if (isMatch) {
                    $(this).show();
                    totalHours += parseFloat($(this).data('hours')) || 0;
                    visibleCount++;
                } else {
                    $(this).hide();
                }
            });
        }
        
        $('#filteredSubjectCount').text(visibleCount);
        $('#filteredPeriodCount').text(totalHours);
    };

    $(document).on('input', '#searchAssignmentInput', function() {
        window.filterAssignments();
    });

    $(document).on('click', '#btnClearSearch', function() {
        $('#searchAssignmentInput').val('');
        $('#btnFilterGroupedOnly').removeClass('active btn-success text-white').addClass('btn-outline-success');
        window.filterAssignments();
    });

    window.toggleFilterGroupedOnly = function() {
        const $btn = $('#btnFilterGroupedOnly');
        if ($btn.hasClass('active')) {
            $btn.removeClass('active btn-success text-white').addClass('btn-outline-success');
            $('#searchAssignmentInput').val('');
        } else {
            $btn.addClass('active btn-success text-white').removeClass('btn-outline-success');
            $('#searchAssignmentInput').val('กลุ่มเรียนพร้อมกัน');
        }
        window.filterAssignments();
    };

    // Run initial filter calculation
    window.filterAssignments();

    // --- 🪄 Smart Electives Auto-Detection & 1-Click Grouping ---
    let cachedCandidates = [];

    window.scanSmartElectives = function(userInitiated = false) {
        if (userInitiated) {
            $('#btnScanElectives').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>กำลังสแกน...');
        }

        $.ajax({
            url: '<?= base_url('admin/academic/timetable/detect-suggested-groups') ?>',
            method: 'GET',
            dataType: 'json',
            success: function(res) {
                if (userInitiated) {
                    $('#btnScanElectives').prop('disabled', false).html('<i class="bx bx-magic-wand fs-5 me-1"></i><span>สแกนวิชาเลือกคู่ขนาน</span>');
                }

                if (res.status === 'success' && res.count > 0) {
                    cachedCandidates = res.candidates || [];
                    $('#smartElectivesBanner').removeClass('d-none');
                    $('#smartGroupCountBadge').text(res.count + ' กลุ่ม');
                    $('#smartGroupTotalAssignments').text(res.total_assignments);
                    
                    renderSmartGroupCards(cachedCandidates);

                    if (userInitiated) {
                        Swal.fire({
                            icon: 'info',
                            title: 'ตรวจพบ ' + res.count + ' กลุ่มวิชาเลือกคู่ขนาน',
                            text: 'พบ ' + res.total_assignments + ' รายการที่สอนพร้อมกันในห้องเดียวกัน สามารถกดยืนยันมัดรวมได้ทันที',
                            confirmButtonColor: '#15a362',
                            customClass: { container: 'swal2-container' }
                        });
                        $('#smartGroupCardsWrapper').removeClass('d-none');
                    }
                } else {
                    cachedCandidates = [];
                    $('#smartElectivesBanner').addClass('d-none');
                    $('#smartGroupCardsRow').empty();

                    if (userInitiated) {
                        Swal.fire({
                            icon: 'success',
                            title: 'ไม่พบวิชาเลือกคู่ขนานที่ตกค้าง',
                            text: 'ข้อมูลการมอบหมายทั้งหมดจัดกลุ่มถูกต้องเรียบร้อยแล้ว หรือไม่มีวิชาเลือกที่สอนพร้อมกัน',
                            confirmButtonColor: '#15a362',
                            customClass: { container: 'swal2-container' }
                        });
                    }
                }
            },
            error: function(xhr) {
                if (userInitiated) {
                    $('#btnScanElectives').prop('disabled', false).html('<i class="bx bx-magic-wand fs-5 me-1"></i><span>สแกนวิชาเลือกคู่ขนาน</span>');
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาดในการสแกน',
                        text: xhr.responseJSON?.message || 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้',
                        confirmButtonColor: '#15a362',
                        customClass: { container: 'swal2-container' }
                    });
                }
            }
        });
    };

    function renderSmartGroupCards(candidates) {
        const $row = $('#smartGroupCardsRow');
        $row.empty();

        candidates.forEach((c) => {
            const className = c.class_name || c.class || '';
            const categoryTitle = c.category_title || c.category || 'วิชาเลือกคู่ขนาน';
            const hoursPerWeek = c.hours_per_week || c.hours || 0;
            const subjectCount = c.subject_count || c.total_subjects || (c.items?.length) || 0;
            const subjectsList = c.items || c.subjects || [];
            const assignIds = c.assign_ids || [];

            let subjectsHtml = '';
            subjectsList.forEach(s => {
                const code = s.subject_code || s.code || '';
                const name = s.subject_name || s.name || '';
                const teachersStr = s.teacher_names || (Array.isArray(s.teachers) ? s.teachers.join(', ') : (s.teachers || 'ยังไม่ระบุครู'));
                subjectsHtml += `
                    <li class="d-flex justify-content-between align-items-center py-1 border-bottom">
                        <div class="text-truncate me-2" style="max-width: 65%;">
                            <span class="badge bg-light text-dark fw-bold me-1">${code}</span>
                            <span class="text-dark small" title="${name}">${name}</span>
                        </div>
                        <span class="badge bg-label-secondary small text-truncate" style="max-width: 35%;">${teachersStr}</span>
                    </li>
                `;
            });

            const cardHtml = `
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 border shadow-xs" style="border-color: #b8e8ce !important; background: #ffffff;">
                        <div class="card-body p-3 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="d-flex align-items-center gap-1">
                                        <span class="badge bg-label-success fw-bold px-2 py-1">${className}</span>
                                        <span class="badge bg-label-primary fw-bold px-2 py-1 text-truncate" style="max-width: 140px;" title="${categoryTitle}">${categoryTitle}</span>
                                    </div>
                                    <span class="badge rounded-pill border text-muted px-2 py-1">${hoursPerWeek} คาบ/สัปดาห์</span>
                                </div>
                                <div class="small text-muted mb-2 fw-semibold">
                                    <i class="bx bx-layer me-1"></i>วิชาที่เรียนพร้อมกัน (${subjectCount} วิชา):
                                </div>
                                <ul class="list-unstyled mb-3" style="max-height: 140px; overflow-y: auto;">
                                    ${subjectsHtml}
                                </ul>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-success w-100 rounded-pill fw-bold" onclick="applySingleCandidateGroup([${assignIds.join(',')}], '${className} - ${categoryTitle}')">
                                <i class="bx bx-package me-1"></i> มัดรวมเฉพาะกลุ่มนี้
                            </button>
                        </div>
                    </div>
                </div>
            `;
            $row.append(cardHtml);
        });
    }

    window.toggleSmartGroupDetails = function() {
        $('#smartGroupCardsWrapper').toggleClass('d-none');
    };

    window.applyAllSmartGroups = function() {
        if (!cachedCandidates || cachedCandidates.length === 0) {
            Swal.fire({
                title: 'คำแนะนำ',
                text: 'ไม่พบกลุ่มวิชาเลือกที่ต้องมัดรวม',
                icon: 'info',
                confirmButtonColor: '#15a362',
                customClass: { container: 'swal2-container' }
            });
            return;
        }

        const totalGroups = cachedCandidates.length;
        const totalAssignments = cachedCandidates.reduce((acc, c) => acc + (c.assign_ids?.length || 0), 0);

        Swal.fire({
            title: 'ยืนยันมัดรวมวิชาเลือกอัตโนมัติ?',
            html: `ระบบจะสร้างกลุ่มเรียนพร้อมกัน (Teaching Group) จำนวน <b>${totalGroups} กลุ่ม</b> (ครอบคลุม <b>${totalAssignments} รายการ</b>)<br><small class="text-muted">วิชาในกลุ่มเดียวกันจะถูกจัดตารางเวลาเดียวกัน และห้องเรียนจะไม่ถูกคิดชั่วโมงซ้ำซ้อน</small>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#15a362',
            confirmButtonText: '<i class="bx bx-check-double me-1"></i> ใช่, มัดรวมทั้งหมดทันที',
            cancelButtonText: 'ยกเลิก',
            customClass: { container: 'swal2-container' }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'กำลังมัดรวมกลุ่มวิชา...',
                    text: 'กรุณารอสักครู่',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                const csrfToken = $('input[name="<?= csrf_token() ?>"]').val() || '<?= csrf_hash() ?>';

                $.ajax({
                    url: '<?= base_url('admin/academic/timetable/apply-all-suggested-groups') ?>',
                    method: 'POST',
                    data: {
                        "<?= csrf_token() ?>": csrfToken
                    },
                    dataType: 'json',
                    success: function(res) {
                        if (res.csrf_hash) {
                            $('input[name="<?= csrf_token() ?>"]').val(res.csrf_hash);
                        }

                        if (res.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'มัดรวมกลุ่มสำเร็จ!',
                                text: res.message,
                                confirmButtonColor: '#15a362',
                                customClass: { container: 'swal2-container' }
                            });
                            refreshAssignmentList();
                            scanSmartElectives(false);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด',
                                text: res.message,
                                confirmButtonColor: '#15a362',
                                customClass: { container: 'swal2-container' }
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: xhr.responseJSON?.message || 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้',
                            confirmButtonColor: '#15a362',
                            customClass: { container: 'swal2-container' }
                        });
                    }
                });
            }
        });
    };

    window.applySingleCandidateGroup = function(assignIds, groupName) {
        if (!assignIds || assignIds.length < 2) {
            Swal.fire({
                title: 'คำแนะนำ',
                text: 'กลุ่มต้องมีอย่างน้อย 2 วิชา',
                icon: 'warning',
                confirmButtonColor: '#15a362',
                customClass: { container: 'swal2-container' }
            });
            return;
        }

        Swal.fire({
            title: 'มัดรวมกลุ่ม ' + groupName + '?',
            text: 'วิชาในกลุ่มนี้ (' + assignIds.length + ' วิชา) จะถูกจัดตารางในเวลาเดียวกันเสมอ',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#15a362',
            confirmButtonText: 'ตกลง, มัดรวมเลย',
            cancelButtonText: 'ยกเลิก',
            customClass: { container: 'swal2-container' }
        }).then((result) => {
            if (result.isConfirmed) {
                const csrfToken = $('input[name="<?= csrf_token() ?>"]').val() || '<?= csrf_hash() ?>';

                $.post('<?= base_url('admin/academic/timetable/save-teaching-group') ?>', {
                    "<?= csrf_token() ?>": csrfToken,
                    ids: assignIds.join(',')
                }, function(res) {
                    if (res.csrf_hash) {
                        $('input[name="<?= csrf_token() ?>"]').val(res.csrf_hash);
                    }
                    if (res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'มัดรวมสำเร็จ',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false,
                            customClass: { container: 'swal2-container' }
                        });
                        refreshAssignmentList();
                        scanSmartElectives(false);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'ผิดพลาด',
                            text: res.message,
                            confirmButtonColor: '#15a362',
                            customClass: { container: 'swal2-container' }
                        });
                    }
                });
            }
        });
    };

    // Auto scan smart electives on load
    scanSmartElectives(false);
});
function resetAllData() {
    Swal.fire({
        title: 'ยืนยันการล้างข้อมูลทั้งหมด?',
        text: "ข้อมูลการล็อควิชาและตารางสอนที่ประมวลผลแล้วของปีการศึกษานี้จะถูกลบออกทั้งหมด!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff3e1d',
        cancelButtonColor: '#8592a3',
        confirmButtonText: 'ใช่, ล้างข้อมูลเลย!',
        cancelButtonText: 'ยกเลิก',
        customClass: {
            container: 'swal2-container'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'กรุณารอสักครู่...',
                html: 'กำลังล้างข้อมูลในฐานข้อมูล',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            $.ajax({
                url: '<?= base_url('admin/academic/timetable/reset-all-data') ?>',
                method: 'POST',
                data: { <?= csrf_token() ?>: '<?= csrf_hash() ?>' },
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'ล้างข้อมูลสำเร็จ',
                            text: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์', 'error');
                }
            });
        }
    });
}
</script>
<?= $this->endSection() ?>
