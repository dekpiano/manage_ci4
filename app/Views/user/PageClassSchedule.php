<?= $this->extend('user/layout/main') ?>

<?= $this->section('extra_css') ?>
<!-- Fancybox CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
<style>
    /* Theme Tokens */
    :root {
        --skj-primary: #15a362;
        --skj-primary-dark: #0d6d41;
        --skj-primary-light: #e8f5ee;
        --skj-gradient: linear-gradient(135deg, #15a362 0%, #10854e 100%);
    }

    /* Hero Section */
    .hero-section {
        background: var(--skj-gradient);
        padding: 3.5rem 0 5.5rem 0;
        color: #ffffff !important;
        text-align: center;
        position: relative;
        border-radius: 0 0 2rem 2rem;
        box-shadow: 0 10px 30px rgba(21, 163, 98, 0.2);
    }

    .hero-section * {
        color: #ffffff !important;
    }

    .page-title {
        font-weight: 800;
        letter-spacing: -0.5px;
        color: #ffffff !important;
    }

    .hero-subtitle {
        color: #ffffff !important;
        opacity: 0.95 !important;
        font-size: 1.05rem;
    }

    /* Search & Tab Control Card */
    .search-card {
        border-radius: 20px;
        border: none;
        background: #ffffff;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06);
        margin-top: -40px;
        position: relative;
        z-index: 10;
        border: 1px solid rgba(21, 163, 98, 0.12);
    }

    /* Modern Pill Navigation Tabs */
    .schedule-nav-pills {
        background: #f1f5f9;
        padding: 6px;
        border-radius: 50rem;
        display: inline-flex;
        border: 1px solid #e2e8f0;
    }

    .schedule-nav-pills .nav-link {
        border-radius: 50rem;
        font-weight: 700;
        padding: 0.6rem 1.8rem;
        color: #475569;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
    }

    .schedule-nav-pills .nav-link.active {
        background: #15a362;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(21, 163, 98, 0.35);
    }

    .schedule-nav-pills .nav-link:not(.active):hover {
        color: #15a362;
        background: rgba(21, 163, 98, 0.08);
    }

    /* Class Cards */
    .class-card {
        border-radius: 16px;
        border: 1px solid #edf2f7;
        background: #ffffff;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        cursor: pointer;
        height: 100%;
        border-bottom: 4px solid #15a362;
        position: relative;
        overflow: hidden;
    }

    .class-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(21, 163, 98, 0.15);
        border-color: #a7f3d0;
    }

    .class-icon {
        width: 52px;
        height: 52px;
        background: #e8f5ee;
        color: #15a362;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .class-card:hover .class-icon {
        background: #15a362;
        color: #ffffff;
        transform: scale(1.05);
    }

    /* Teacher Cards */
    .teacher-card {
        border-radius: 18px;
        border: 1px solid #edf2f7;
        background: #ffffff;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        cursor: pointer;
        height: 100%;
        border-bottom: 4px solid #0891b2;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .teacher-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 14px 28px rgba(8, 145, 178, 0.15);
        border-color: #a5f3fc;
    }

    .teacher-avatar-wrapper {
        position: relative;
        width: 68px;
        height: 68px;
        margin-bottom: 0.85rem;
    }

    .teacher-avatar-img {
        width: 68px;
        height: 68px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #ffffff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .teacher-status-badge {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 2px solid #ffffff;
    }

    .teacher-status-badge.bg-done {
        background-color: #15a362;
    }

    .teacher-status-badge.bg-pending {
        background-color: #fbbf24;
    }

    /* Workload Badges */
    .workload-pill {
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.35rem 0.65rem;
        border-radius: 50rem;
    }

    /* High Contrast Modal Header */
    .modal-teaching-header {
        background: linear-gradient(135deg, #15a362 0%, #0d6d41 100%);
        /* color: #ffffff !important; */
    }



    .modal-avatar-lg {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #ffffff;
    }

    /* Modal Stat Widget */
    .modal-stat-widget {
        background: #ffffff;
        border-radius: 14px;
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
    }

    .modal-stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }

    .modal-section-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }

    .modal-section-header {
        padding: 0.9rem 1.25rem;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    /* Subject Color Boxes & Timetable Grid */
    .timetable-grid-table {
        table-layout: fixed;
        min-width: 820px;
    }

    .timetable-grid-table th,
    .timetable-grid-table td {
        vertical-align: middle;
        text-align: center;
        padding: 4px;
    }

    .timetable-grid-table thead th {
        background-color: #f8fafc;
        font-weight: 700;
        font-size: 0.8rem;
    }

    .slot-cell {
        height: 72px;
        transition: background 0.2s ease;
    }

    .subject-pill-card {
        border-radius: 8px;
        padding: 5px 4px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: center;
        border: 1px solid transparent;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    .subject-pill-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
    }

    .subject-pill-code {
        font-weight: 800;
        font-size: 0.8rem;
        line-height: 1.1;
    }

    .subject-pill-name {
        font-size: 0.68rem;
        line-height: 1.1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .subject-pill-teacher {
        font-size: 0.65rem;
        opacity: 0.85;
        line-height: 1;
        margin-top: 2px;
    }

    /* 🌟 Maintenance / Closed Access State Card */
    .schedule-maintenance-card {
        background: linear-gradient(135deg, #ffffff 0%, #fffdf8 50%, #fef8ee 100%);
        border-radius: 24px;
        border: 1px solid rgba(245, 158, 11, 0.25);
        position: relative;
        overflow: hidden;
        box-shadow: 0 12px 35px rgba(245, 158, 11, 0.09);
    }

    .schedule-maintenance-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 6px;
        background: linear-gradient(90deg, #f59e0b, #fbbf24, #15a362);
    }

    .maintenance-icon-wrapper {
        width: 88px;
        height: 88px;
        border-radius: 26px;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #b45309;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.75rem;
        margin-bottom: 1.25rem;
        box-shadow: 0 10px 25px rgba(245, 158, 11, 0.22);
        position: relative;
    }

    .maintenance-icon-badge {
        position: absolute;
        bottom: -4px;
        right: -4px;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #ef4444;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        border: 2px solid #ffffff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }

    .maintenance-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 18px;
        border-radius: 50rem;
        background: rgba(245, 158, 11, 0.12);
        color: #b45309;
        font-weight: 700;
        font-size: 0.82rem;
        letter-spacing: 0.3px;
        border: 1px solid rgba(245, 158, 11, 0.3);
        margin-bottom: 1.25rem;
    }

    .maintenance-info-box {
        background: #ffffff;
        border-radius: 14px;
        padding: 1rem 1.15rem;
        border: 1px solid rgba(0, 0, 0, 0.06);
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        text-align: left;
        transition: all 0.25s ease;
    }

    .maintenance-info-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 18px rgba(0,0,0,0.06);
        border-color: rgba(21, 163, 98, 0.25);
    }

    .maintenance-dot-pulse {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #f59e0b;
        display: inline-block;
        position: relative;
    }

    .maintenance-dot-pulse::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        border-radius: 50%;
        background: #f59e0b;
        animation: pulse-ring 1.8s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
    }

    @keyframes pulse-ring {
        0% { transform: scale(0.95); opacity: 0.8; }
        50% { transform: scale(2.2); opacity: 0; }
        100% { transform: scale(0.95); opacity: 0; }
    }

    /* SweetAlert2 Safeguard */
    .swal2-container {
        z-index: 9999 !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="app-wrapper">
    <!-- Hero Header -->
    <div class="hero-section">
        <div class="container">
            <h1 class="page-title mb-2">ตารางเรียนและตารางสอน</h1>
            <p class="hero-subtitle mb-0">ตรวจสอบตารางเรียนประจำห้องเรียน และตารางสอนภาระงานรายครูได้ที่นี่</p>
        </div>
    </div>

    <div class="container-xl">
        <!-- Main Search Card -->
        <div class="card search-card p-4 mb-5">
            <!-- Mode Switcher Tabs -->
            <div class="d-flex justify-content-center mb-4">
                <ul class="nav nav-pills schedule-nav-pills" id="scheduleTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab-class-btn" data-bs-toggle="pill"
                            data-bs-target="#tab-class-content" type="button" role="tab">
                            <i class="bx bx-book-open fs-5"></i> ตารางเรียน (รายห้อง)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-teacher-btn" data-bs-toggle="pill"
                            data-bs-target="#tab-teacher-content" type="button" role="tab">
                            <i class="bx bx-user-check fs-5"></i> ตารางสอน (รายครู)
                        </button>
                    </li>
                </ul>
            </div>

            <!-- TAB 1: SEARCH CONTROLS FOR CLASS SCHEDULE -->
            <div class="tab-content" id="scheduleTabContent">
                <div class="tab-pane fade show active" id="tab-class-content" role="tabpanel">
                    <?php if (($class_schedule_onoff ?? 'open') === 'closed'): ?>
                        <div class="schedule-maintenance-card p-4 p-md-5 text-center my-2">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <!-- Status Badge -->
                                <div class="maintenance-chip">
                                    <span class="maintenance-dot-pulse"></span>
                                    <span>ปิดการเข้าดูชั่วคราว • UNDER MAINTENANCE</span>
                                </div>

                                <!-- Animated Icon -->
                                <div class="maintenance-icon-wrapper">
                                    <i class="bx bx-calendar-x"></i>
                                    <div class="maintenance-icon-badge">
                                        <i class="bx bx-lock-alt"></i>
                                    </div>
                                </div>

                                <!-- Title & Subtitle -->
                                <h3 class="fw-bold text-dark mb-2">ปิดการเข้าดูตารางเรียน (นักเรียน) ชั่วคราว</h3>
                                <p class="text-secondary mb-4" style="max-width: 620px; font-size: 1rem; line-height: 1.6;">
                                    ขณะนี้ระบบปิดการแสดงผลตารางเรียนประจำห้องเรียนของนักเรียนชั่วคราว อยู่ระหว่างการจัดและปรับปรุงข้อมูลตารางสอนโดย <strong>กลุ่มบริหารวิชาการ (งานหลักสูตรและนิเทศ)</strong>
                                </p>

                                <!-- 3 Feature Info Cards -->
                                <div class="row g-3 w-100 mb-4 justify-content-center" style="max-width: 780px;">
                                    <div class="col-md-4">
                                        <div class="maintenance-info-box h-100">
                                            <div class="d-flex align-items-center gap-2 mb-1 text-warning">
                                                <i class="bx bx-cog fs-4"></i>
                                                <span class="fw-bold text-dark small">จัดสรรคาบเรียน</span>
                                            </div>
                                            <p class="text-muted small mb-0">กำลังประมวลผลจัดสรรคาบเรียนและห้องเรียนให้สมบูรณ์</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="maintenance-info-box h-100">
                                            <div class="d-flex align-items-center gap-2 mb-1 text-success">
                                                <i class="bx bx-check-shield fs-4"></i>
                                                <span class="fw-bold text-dark small">ตรวจสอบความถูกต้อง</span>
                                            </div>
                                            <p class="text-muted small mb-0">ตรวจสอบความถูกต้องของรายวิชา ครูผู้สอน และห้องเรียน</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="maintenance-info-box h-100">
                                            <div class="d-flex align-items-center gap-2 mb-1 text-primary">
                                                <i class="bx bx-bell fs-4"></i>
                                                <span class="fw-bold text-dark small">เปิดให้ดูเร็วๆ นี้</span>
                                            </div>
                                            <p class="text-muted small mb-0">จะเปิดให้นักเรียนและผู้ปกครองเข้าดูทันทีหลังเสร็จสิ้น</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex align-items-center gap-2 flex-wrap justify-content-center">
                                    <?php if (($teacher_schedule_onoff ?? 'open') === 'open'): ?>
                                        <button type="button" class="btn btn-outline-success rounded-pill px-4 fw-bold" onclick="$('#tab-teacher-btn').click();" style="border-color: #15a362; color: #15a362;">
                                            <i class="bx bx-user-check me-1"></i> ดูตารางสอนครูผู้สอนแทน
                                        </button>
                                    <?php endif; ?>
                                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold border text-muted shadow-2xs" onclick="location.reload();">
                                        <i class="bx bx-refresh me-1"></i> รีเฟรชหน้านี้
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div
                            class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom flex-wrap gap-2">
                            <span class="small text-muted">
                                <i class="bx bx-info-circle me-1 text-success"></i> แหล่งข้อมูลตารางเรียน:
                                <strong
                                    class="text-dark"><?= ($display_mode === 'system') ? '🟢 ดึงสดจากระบบจัดตารางสอนกลาง' : '📁 ดึงจากไฟล์รูปภาพตารางเรียน' ?></strong>
                            </span>
                            <span
                                class="badge <?= ($display_mode === 'system') ? 'bg-label-success' : 'bg-label-info' ?> rounded-pill px-3 py-1 font-monospace"
                                style="font-size: 0.72rem;">
                                <?= ($display_mode === 'system') ? 'LIVE TIMETABLE MODE' : 'UPLOADED IMAGE MODE' ?>
                            </span>
                        </div>

                        <div class="row g-3 align-items-end">
                            <div class="col-md-5">
                                <label class="small fw-bold text-muted mb-2">ปีการศึกษา / ภาคเรียน</label>
                                <select id="SearchYearTerm" class="form-select border-light-success">
                                    <option value="">กำลังโหลดปีการศึกษาล่าสุด...</option>
                                </select>
                            </div>
                            <div class="col-md-7">
                                <label class="small fw-bold text-muted mb-2">ค้นหาห้องเรียน</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i
                                            class="bx bx-search text-muted"></i></span>
                                    <input type="text" id="FilterClass" class="form-control border-start-0"
                                        placeholder="พิมพ์ห้องเรียน เช่น 1/1, 2/1, 4/2, 5/1..." disabled>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- TAB 2: SEARCH CONTROLS FOR TEACHER SCHEDULE -->
                <div class="tab-pane fade" id="tab-teacher-content" role="tabpanel">
                    <?php if (($teacher_schedule_onoff ?? 'open') === 'closed'): ?>
                        <div class="schedule-maintenance-card p-4 p-md-5 text-center my-2">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <!-- Status Badge -->
                                <div class="maintenance-chip">
                                    <span class="maintenance-dot-pulse"></span>
                                    <span>ปิดการเข้าดูชั่วคราว • UNDER MAINTENANCE</span>
                                </div>

                                <!-- Animated Icon -->
                                <div class="maintenance-icon-wrapper">
                                    <i class="bx bx-id-card"></i>
                                    <div class="maintenance-icon-badge">
                                        <i class="bx bx-lock-alt"></i>
                                    </div>
                                </div>

                                <!-- Title & Subtitle -->
                                <h3 class="fw-bold text-dark mb-2">ปิดการเข้าดูตารางสอนครู (สาธารณะ) ชั่วคราว</h3>
                                <p class="text-secondary mb-4" style="max-width: 620px; font-size: 1rem; line-height: 1.6;">
                                    ขณะนี้ระบบปิดการแสดงผลตารางสอนรายบุคคลของครูผู้สอนชั่วคราว อยู่ระหว่างการจัดและปรับปรุงข้อมูลตารางสอนโดย <strong>กลุ่มบริหารวิชาการ (งานหลักสูตรและนิเทศ)</strong>
                                </p>

                                <!-- 3 Feature Info Cards -->
                                <div class="row g-3 w-100 mb-4 justify-content-center" style="max-width: 780px;">
                                    <div class="col-md-4">
                                        <div class="maintenance-info-box h-100">
                                            <div class="d-flex align-items-center gap-2 mb-1 text-info">
                                                <i class="bx bx-user-pin fs-4"></i>
                                                <span class="fw-bold text-dark small">จัดภาระงานสอน</span>
                                            </div>
                                            <p class="text-muted small mb-0">กำลังประมวลผลภาระงานสอนรายกลุ่มสาระการเรียนรู้</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="maintenance-info-box h-100">
                                            <div class="d-flex align-items-center gap-2 mb-1 text-success">
                                                <i class="bx bx-check-shield fs-4"></i>
                                                <span class="fw-bold text-dark small">ตรวจสอบความถูกต้อง</span>
                                            </div>
                                            <p class="text-muted small mb-0">ตรวจสอบคาบสอน กิจกรรม และภาระงานพิเศษของครู</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="maintenance-info-box h-100">
                                            <div class="d-flex align-items-center gap-2 mb-1 text-primary">
                                                <i class="bx bx-bell fs-4"></i>
                                                <span class="fw-bold text-dark small">เปิดให้ดูเร็วๆ นี้</span>
                                            </div>
                                            <p class="text-muted small mb-0">จะเปิดให้ค้นหาและดูตารางสอนทันทีหลังเสร็จสิ้น</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex align-items-center gap-2 flex-wrap justify-content-center">
                                    <?php if (($class_schedule_onoff ?? 'open') === 'open'): ?>
                                        <button type="button" class="btn btn-outline-success rounded-pill px-4 fw-bold" onclick="$('#tab-class-btn').click();" style="border-color: #15a362; color: #15a362;">
                                            <i class="bx bx-book-open me-1"></i> ดูตารางเรียนห้องเรียนแทน
                                        </button>
                                    <?php endif; ?>
                                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold border text-muted shadow-2xs" onclick="location.reload();">
                                        <i class="bx bx-refresh me-1"></i> รีเฟรชหน้านี้
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="small fw-bold text-muted mb-2">ปีการศึกษา / ภาคเรียน</label>
                                <select id="TeacherSearchYearTerm" class="form-select border-light-success">
                                    <option value="">กำลังโหลด...</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold text-muted mb-2">กลุ่มสาระการเรียนรู้</label>
                                <select id="TeacherSearchGroup" class="form-select border-light-success">
                                    <option value="">ทุกกลุ่มสาระการเรียนรู้</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label class="small fw-bold text-muted mb-2">ค้นหาชื่อครูผู้สอน / ตำแหน่ง</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i
                                            class="bx bx-search text-muted"></i></span>
                                    <input type="text" id="FilterTeacher" class="form-control border-start-0"
                                        placeholder="พิมพ์ชื่อ, นามสกุล หรือตำแหน่ง...">
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Dynamic Results State -->
        <div id="loading-state" class="text-center py-5" style="display: none;">
            <div class="spinner-border text-success" role="status" style="width: 3rem; height: 3rem;"></div>
            <p class="mt-3 text-muted fw-bold">กำลังค้นหาข้อมูล...</p>
        </div>

        <!-- Container for Class Schedule Results -->
        <div id="class-results-container" class="row g-4 mb-5" <?= (($class_schedule_onoff ?? 'open') === 'closed') ? 'style="display: none;"' : '' ?>>
            <div class="col-12 text-center py-5 text-muted" id="class-initial-msg">
                <i class="bx bx-calendar-event fs-1 d-block mb-3 opacity-25" style="font-size: 3.5rem !important;"></i>
                กรุณาเลือกปีการศึกษาและภาคเรียนเพื่อดูตารางเรียน
            </div>
        </div>

        <!-- Container for Teacher Schedule Results -->
        <div id="teacher-results-container" class="row g-4 mb-5" style="display: none;">
            <div class="col-12 text-center py-5 text-muted" id="teacher-initial-msg">
                <i class="bx bx-user-check fs-1 d-block mb-3 opacity-25" style="font-size: 3.5rem !important;"></i>
                กำลังโหลดข้อมูลตารางสอนรายครู...
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<!-- Modals Section rendered outside content wrapper -->
<?= $this->section('modals') ?>

<!-- Modal: ตารางสอนประจำครูผู้สอน (Live System Teacher Timetable Grid Modal) -->
<div class="modal fade" id="modalTeacherScheduleDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">

            <!-- Modal Header -->
            <div class="modal-header modal-teaching-header px-4 py-3 border-0">
                <div class="d-flex align-items-center gap-3">
                    <img id="m-teacher-img" src="https://skj.ac.th/uploads/logo/LogoSKJ_4.png" alt="ครูผู้สอน"
                        class="modal-avatar-lg shadow-sm">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                            <h4 class="fw-bold text-white mb-0" id="m-teacher-name">ตารางสอน ครู-</h4>
                            <span class="badge bg-white text-dark rounded-pill fw-bold px-3 py-1 shadow-xs"
                                style="font-size: 0.78rem;" id="m-teacher-term">ภาคเรียนที่ -</span>
                        </div>
                        <div class="d-flex align-items-center flex-wrap gap-2 text-white small opacity-90">
                            <span id="m-teacher-position" class="d-inline-flex align-items-center"><i
                                    class="bx bx-briefcase me-1"></i>ตำแหน่ง</span>
                            <span>•</span>
                            <span id="m-teacher-group" class="d-inline-flex align-items-center"><i
                                    class="bx bx-category me-1"></i>กลุ่มสาระ</span>
                            <span>•</span>
                            <span id="m-teacher-hours"
                                class="badge bg-white text-success rounded-pill fw-bold px-2 py-0.5">0
                                คาบ/สัปดาห์</span>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body p-4" style="background-color: #f8fafc;">
                <!-- Loading State in Modal -->
                <div id="m-teacher-loader" class="text-center py-5">
                    <div class="spinner-border text-success" role="status" style="width: 2.5rem; height: 2.5rem;"></div>
                    <p class="mt-2 text-muted fw-bold">กำลังประมวลผลตารางสอน...</p>
                </div>

                <!-- Timetable Grid Container -->
                <div id="m-teacher-grid-container" class="table-responsive rounded-3 border bg-white shadow-2xs"
                    style="display: none;">
                    <table class="table table-bordered mb-0 align-middle timetable-grid-table">
                        <thead id="m-teacher-table-head">
                            <!-- Injected via JS -->
                        </thead>
                        <tbody id="m-teacher-table-body">
                            <!-- Injected via JS -->
                        </tbody>
                    </table>
                </div>

                <!-- Color Legend / Notes -->
                <div
                    class="mt-3 p-3 bg-white rounded-3 border d-flex align-items-center justify-content-between flex-wrap gap-2 small text-muted">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <span class="fw-bold text-dark"><i class="bx bx-palette me-1 text-success"></i>
                            กลุ่มสาระฯ:</span>
                        <span class="d-inline-flex align-items-center"><span class="badge me-1"
                                style="background: #FFF3E0; color: #BF360C; border: 1px solid #FFB74D;">ไทย</span>
                            ภาษาไทย</span>
                        <span class="d-inline-flex align-items-center"><span class="badge me-1"
                                style="background: #E0F7FA; color: #006064; border: 1px solid #4DD0E1;">คณิต</span>
                            คณิตศาสตร์</span>
                        <span class="d-inline-flex align-items-center"><span class="badge me-1"
                                style="background: #E8F5E9; color: #1B5E20; border: 1px solid #81C784;">วิทย์</span>
                            วิทยาศาสตร์</span>
                        <span class="d-inline-flex align-items-center"><span class="badge me-1"
                                style="background: #F3E5F5; color: #4A148C; border: 1px solid #BA68C8;">สังคม</span>
                            สังคมฯ</span>
                        <span class="d-inline-flex align-items-center"><span class="badge me-1"
                                style="background: #EDE7F6; color: #311B92; border: 1px solid #9575CD;">อังกฤษ</span>
                            ภาษาอังกฤษ</span>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer px-4 py-3 bg-white border-top d-flex justify-content-between align-items-center">
                <span class="text-muted small d-inline-flex align-items-center">
                    <i class="bx bx-check-shield text-success me-1 fs-5"></i> ตารางสอนเชื่อมโยงสดจากระบบจัดตารางสอนกลาง
                </span>
                <div class="d-flex gap-2">
                    <a href="#" id="btn-modal-print" target="_blank"
                        class="btn btn-outline-secondary rounded-pill px-4 fw-bold shadow-xs">
                        <i class="bx bx-printer me-1"></i> พิมพ์ตารางสอน
                    </a>
                    <button type="button" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm"
                        style="background-color: #15a362; border-color: #15a362;" data-bs-dismiss="modal">
                        <i class="bx bx-x me-1"></i> ปิดหน้าต่าง
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal: ตารางเรียนประจำห้องเรียน (Live System Timetable Grid Modal) -->
<div class="modal fade" id="modalClassTimetableDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">

            <!-- Modal Header -->
            <div class="modal-header modal-teaching-header px-4 py-3 border-0">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-lg rounded-3 d-flex align-items-center justify-content-center bg-white shadow-sm"
                        style="width: 56px; height: 56px; color: #15a362; font-size: 1.8rem;">
                        <i class="bx bx-calendar-event"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                            <h4 class="fw-bold text-white mb-0" id="m-class-title">ตารางเรียน ชั้น ม.-</h4>
                            <span class="badge bg-white text-dark rounded-pill fw-bold px-3 py-1 shadow-xs"
                                style="font-size: 0.78rem;" id="">ภาคเรียนที่ -</span>
                        </div>
                        <p class="text-white small mb-0 opacity-90">
                            โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์
                        </p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body p-4" style="background-color: #f8fafc;">
                <!-- Loading State in Modal -->
                <div id="m-class-loader" class="text-center py-5">
                    <div class="spinner-border text-success" role="status" style="width: 2.5rem; height: 2.5rem;"></div>
                    <p class="mt-2 text-muted fw-bold">กำลังประมวลผลตารางเรียน...</p>
                </div>

                <!-- Timetable Grid Container -->
                <div id="m-class-grid-container" class="table-responsive rounded-3 border bg-white shadow-2xs"
                    style="display: none;">
                    <table class="table table-bordered mb-0 align-middle timetable-grid-table">
                        <thead id="m-class-table-head">
                            <!-- Injected via JS -->
                        </thead>
                        <tbody id="m-class-table-body">
                            <!-- Injected via JS -->
                        </tbody>
                    </table>
                </div>

                <!-- Color Legend / Notes -->
                <div
                    class="mt-3 p-3 bg-white rounded-3 border d-flex align-items-center justify-content-between flex-wrap gap-2 small text-muted">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <span class="fw-bold text-dark"><i class="bx bx-palette me-1 text-success"></i>
                            กลุ่มสาระฯ:</span>
                        <span class="d-inline-flex align-items-center"><span class="badge me-1"
                                style="background: #FFF3E0; color: #BF360C; border: 1px solid #FFB74D;">ไทย</span>
                            ภาษาไทย</span>
                        <span class="d-inline-flex align-items-center"><span class="badge me-1"
                                style="background: #E0F7FA; color: #006064; border: 1px solid #4DD0E1;">คณิต</span>
                            คณิตศาสตร์</span>
                        <span class="d-inline-flex align-items-center"><span class="badge me-1"
                                style="background: #E8F5E9; color: #1B5E20; border: 1px solid #81C784;">วิทย์</span>
                            วิทยาศาสตร์</span>
                        <span class="d-inline-flex align-items-center"><span class="badge me-1"
                                style="background: #F3E5F5; color: #4A148C; border: 1px solid #BA68C8;">สังคม</span>
                            สังคมฯ</span>
                        <span class="d-inline-flex align-items-center"><span class="badge me-1"
                                style="background: #EDE7F6; color: #311B92; border: 1px solid #9575CD;">อังกฤษ</span>
                            ภาษาอังกฤษ</span>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer px-4 py-3 bg-white border-top d-flex justify-content-between align-items-center">
                <span class="text-muted small d-inline-flex align-items-center">
                    <i class="bx bx-check-shield text-success me-1 fs-5"></i>
                    ตารางเรียนเชื่อมโยงสดจากระบบจัดตารางสอนกลาง
                </span>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4 fw-bold shadow-xs"
                        onclick="window.print()">
                        <i class="bx bx-printer me-1"></i> พิมพ์ตารางเรียน
                    </button>
                    <button type="button" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm"
                        style="background-color: #15a362; border-color: #15a362;" data-bs-dismiss="modal">
                        <i class="bx bx-x me-1"></i> ปิดหน้าต่าง
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>

<script>
    $(document).ready(function () {
        const uploadServerBaseUrl = '<?= env("upload.server.baseurl") ?>';
        const displayMode = '<?= $display_mode ?? "system" ?>'; // 'system' or 'upload'

        // State Variables
        let currentMode = 'class'; // 'class' or 'teacher'
        let allClassData = [];
        let allTeacherData = [];

        const activeYearOnly = '<?= get_selected_year_only() ?>';
        const activeTermOnly = '<?= get_selected_term_only() ?>';

        // Helper: Category Color Theme for subjects
        function getSubjectColorTheme(code) {
            if (!code) return { bg: '#F8F9FA', text: '#333333', border: '#E2E8F0', label: 'ทั่วไป' };
            const firstChar = String(code).trim().charAt(0);
            const map = {
                'ท': { bg: '#FFF3E0', text: '#BF360C', border: '#FFB74D', label: 'ภาษาไทย' },
                'ค': { bg: '#E0F7FA', text: '#006064', border: '#4DD0E1', label: 'คณิตศาสตร์' },
                'ว': { bg: '#E8F5E9', text: '#1B5E20', border: '#81C784', label: 'วิทยาศาสตร์และเทคโนโลยี' },
                'ส': { bg: '#F3E5F5', text: '#4A148C', border: '#BA68C8', label: 'สังคมศึกษาฯ' },
                'พ': { bg: '#FCE4EC', text: '#880E4F', border: '#F06292', label: 'สุขศึกษาและพลศึกษา' },
                'ศ': { bg: '#FFF9C4', text: '#E65100', border: '#FFD54F', label: 'ศิลปะ ดนตรี นาฏศิลป์' },
                'ง': { bg: '#E0F2F1', text: '#004D40', border: '#4DB6AC', label: 'การงานอาชีพ' },
                'อ': { bg: '#EDE7F6', text: '#311B92', border: '#9575CD', label: 'ภาษาอังกฤษ' },
                'จ': { bg: '#FBE9E7', text: '#BF360C', border: '#FF8A65', label: 'ภาษาจีน' },
                'ญ': { bg: '#FCE4EC', text: '#880E4F', border: '#F48FB1', label: 'ภาษาญี่ปุ่น' },
                'ก': { bg: '#F1F8E9', text: '#33691E', border: '#AED581', label: 'กิจกรรมพัฒนาผู้เรียน' },
                'I': { bg: '#E8EAF6', text: '#1A237E', border: '#7986CB', label: 'IS' },
                'i': { bg: '#E8EAF6', text: '#1A237E', border: '#7986CB', label: 'IS' }
            };
            if (map[firstChar]) return map[firstChar];

            return { bg: '#E3F2FD', text: '#0D47A1', border: '#64B5F6', label: 'วิชาเพิ่มเติม' };
        }

        // -------------------------------------------------------------
        // 1. CLASS SCHEDULE LOGIC
        // -------------------------------------------------------------
        function loadClassData() {
            const selectedOpt = $('#SearchYearTerm option:selected');
            const year = selectedOpt.data('year');
            const term = selectedOpt.data('term');

            if (!year || !term) return;

            $('#loading-state').show();
            $('#class-results-container').hide();

            if (displayMode === 'system') {
                // 🟢 System Timetable Mode
                $.ajax({
                    url: '<?= site_url('user/getsystemtimetableclasses') ?>',
                    method: 'GET',
                    data: { year: year, term: term },
                    success: function (data) {
                        allClassData = data;
                        $('#loading-state').hide();
                        $('#class-results-container').show();
                        $('#FilterClass').prop('disabled', false).val('');
                        renderSystemClassCards(data);
                    },
                    error: function () {
                        $('#loading-state').hide();
                        $('#class-results-container').show().html('<div class="col-12 text-center py-5 text-danger">เกิดข้อผิดพลาดในการโหลดตารางเรียนจากระบบ</div>');
                    }
                });
            } else {
                // 📁 Uploaded Image Mode
                $.ajax({
                    url: '<?= site_url('user/searchclassschedule') ?>',
                    method: 'GET',
                    data: { year: year, term: term },
                    success: function (data) {
                        allClassData = data;
                        $('#loading-state').hide();
                        $('#class-results-container').show();
                        $('#FilterClass').prop('disabled', false).val('');
                        renderClassCards(data);
                    },
                    error: function () {
                        $('#loading-state').hide();
                        $('#class-results-container').show().html('<div class="col-12 text-center py-5 text-danger">เกิดข้อผิดพลาดในการโหลดข้อมูล</div>');
                    }
                });
            }
        }

        // Load available Year/Terms from database (Sorted latest first)
        $.ajax({
            url: '<?= site_url('user/getscheduleyears') ?>',
            method: 'GET',
            success: function (yearTerms) {
                let html = '';
                if (!yearTerms || yearTerms.length === 0) {
                    html = '<option value="">ไม่พบข้อมูลปีการศึกษา</option>';
                    $('#SearchYearTerm').html(html);
                    return;
                }

                yearTerms.forEach((yt, index) => {
                    const isSelected = (index === 0) ? 'selected' : ''; // Always pick the latest by default
                    html += `<option value="${yt.term}/${yt.year}" data-year="${yt.year}" data-term="${yt.term}" ${isSelected}>${yt.label}</option>`;
                });

                $('#SearchYearTerm').html(html);
                // Instant load latest data
                loadClassData();
            },
            error: function () {
                $('#SearchYearTerm').html('<option value="">เกิดข้อผิดพลาดในการโหลดข้อมูล</option>');
            }
        });

        $('#SearchYearTerm').on('change', function () {
            loadClassData();
        });

        $('#FilterClass').on('input', function () {
            const query = $(this).val().toLowerCase().trim();
            if (displayMode === 'system') {
                const filtered = allClassData.filter(item =>
                    (item.class_name && item.class_name.toLowerCase().includes(query))
                );
                renderSystemClassCards(filtered);
            } else {
                const filtered = allClassData.filter(item =>
                    (item.schestu_classname && item.schestu_classname.toLowerCase().includes(query)) ||
                    (item.schestu_name && item.schestu_name.toLowerCase().includes(query))
                );
                renderClassCards(filtered);
            }
        });

        // Render cards for Live System Timetable mode
        function renderSystemClassCards(data) {
            if (!data || data.length === 0) {
                $('#class-results-container').html('<div class="col-12 text-center py-5 text-muted"><i class="bx bx-info-circle fs-2 d-block mb-2 text-warning"></i>ไม่พบข้อมูลตารางเรียนในระบบสำหรับภาคเรียนนี้</div>');
                return;
            }

            let html = '';
            data.forEach(item => {
                html += `
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card class-card shadow-sm p-3 btn-view-system-class" data-class="${item.class_name}">
                        <div class="class-icon">
                            <i class="bx bx-calendar-week"></i>
                        </div>
                        <h6 class="fw-bold mb-1 text-dark">ชั้น ม.${item.class_name}</h6>
                        <p class="text-muted small mb-0">${item.total_subjects || 0} รายวิชา • ${item.total_hours || 0} คาบ/สัปดาห์</p>
                        <div class="mt-2 pt-2 border-top text-end">
                            <span class="badge bg-label-success rounded-pill small"><i class="bx bx-search-alt me-1"></i>ดูตารางเรียน</span>
                        </div>
                    </div>
                </div>
            `;
            });
            $('#class-results-container').html(html);
        }

        // Render cards for Uploaded Image mode
        function renderClassCards(data) {
            if (!data || data.length === 0) {
                $('#class-results-container').html('<div class="col-12 text-center py-5 text-muted"><i class="bx bx-info-circle fs-2 d-block mb-2 text-warning"></i>ไม่พบข้อมูลตารางเรียนในภาคเรียนนี้</div>');
                return;
            }

            let html = '';
            data.forEach(item => {
                const imageUrl = uploadServerBaseUrl + item.schestu_year + '/' + item.schestu_term + '/' + item.schestu_filename;

                html += `
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card class-card shadow-sm p-3" data-fancybox="gallery" data-src="${imageUrl}" data-caption="ชั้น ม.${item.schestu_classname} (${item.schestu_name}) - ภาคเรียนที่ ${item.schestu_term}/${item.schestu_year}">
                        <div class="class-icon">
                            <i class="bx bx-book-open"></i>
                        </div>
                        <h6 class="fw-bold mb-1 text-dark">ชั้น ม.${item.schestu_classname}</h6>
                        <p class="text-muted small mb-0 text-truncate" title="${item.schestu_name}">${item.schestu_name}</p>
                        <div class="mt-2 text-end">
                            <span class="badge bg-label-success rounded-pill small"><i class="bx bx-zoom-in me-1"></i>คลิกดูตาราง</span>
                        </div>
                    </div>
                </div>
            `;
            });
            $('#class-results-container').html(html);
        }

        // Click handler for Live System Timetable Card
        $(document).on('click', '.btn-view-system-class', function () {
            const className = $(this).data('class');
            const selectedOpt = $('#SearchYearTerm option:selected');
            const year = selectedOpt.data('year') || activeYearOnly;
            const term = selectedOpt.data('term') || activeTermOnly;

            if (!className) return;

            $('#m-class-title').text(`ตารางเรียน ชั้น ม.${className}`);
            $('#m-class-term').text(`ภาคเรียนที่ ${term}/${year}`);
            $('#m-class-loader').show();
            $('#m-class-grid-container').hide();

            $('#modalClassTimetableDetail').modal('show');

            $.ajax({
                url: '<?= site_url('user/getpublicclasstimetabledetail') ?>',
                type: 'GET',
                data: {
                    class_name: className,
                    year: year,
                    term: term
                },
                dataType: 'json',
                success: function (res) {
                    $('#m-class-loader').hide();
                    if (res && res.status === 'success' && res.data) {
                        renderClassTimetableGrid(res.data);
                        $('#m-class-grid-container').show();
                    } else {
                        $('#m-class-table-body').html(`<tr><td colspan="12" class="text-center py-4 text-danger">${res.message || 'ไม่พบข้อมูลตารางเรียน'}</td></tr>`);
                        $('#m-class-grid-container').show();
                    }
                },
                error: function () {
                    $('#m-class-loader').hide();
                    $('#m-class-table-body').html('<tr><td colspan="12" class="text-center py-4 text-danger">เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์</td></tr>');
                    $('#m-class-grid-container').show();
                }
            });
        });

        function renderClassTimetableGrid(data) {
            const days = data.days || [];
            const periods = data.periods || [];
            const masterSlots = data.master_slots || [];
            const timetableData = data.timetable_data || [];
            const teacherMap = data.teacher_map || {};
            const lunchPeriod = data.lunch_period || 4;

            // 1. Build Header
            let headHtml = '<tr><th style="width: 90px; background-color: #f1f5f9;">วัน / คาบ</th>';
            periods.forEach(p => {
                const isLunch = (parseInt(p.period_number) === parseInt(lunchPeriod));
                const lunchTag = isLunch ? '<div class="text-danger fw-bold" style="font-size: 0.65rem;">พักกลางวัน</div>' : '';
                const timeRange = (p.start_time && p.end_time) ? `${p.start_time.substring(0, 5)} - ${p.end_time.substring(0, 5)}` : '';

                headHtml += `
                <th class="${isLunch ? 'bg-label-warning' : ''}" style="background-color: ${isLunch ? '#fff8e6' : '#f8fafc'};">
                    <div class="fw-bold text-dark">คาบ ${p.period_number}</div>
                    <div class="small text-muted fw-normal" style="font-size: 0.68rem;">${timeRange}</div>
                    ${lunchTag}
                </th>
            `;
            });
            headHtml += '</tr>';
            $('#m-class-table-head').html(headHtml);

            // 2. Build Body
            let bodyHtml = '';
            days.forEach(day => {
                if (!day.is_active) return;

                bodyHtml += `<tr><td class="fw-bold bg-light text-dark" style="font-size: 0.85rem;">${day.day_name}</td>`;

                periods.forEach(p => {
                    const isLunch = (parseInt(p.period_number) === parseInt(lunchPeriod));

                    // Check Master Slots
                    let masterSlot = masterSlots.find(ms => ms.day === day.day_key && parseInt(ms.period) === parseInt(p.period_number));

                    // Check Timetable Slot Data
                    let slotData = timetableData.find(td => td.day === day.day_key && parseInt(td.period) === parseInt(p.period_number));

                    let cellContent = '';

                    if (masterSlot) {
                        cellContent = `
                        <div class="subject-pill-card" style="background: #eef2ff; color: #3730a3; border-color: #c7d2fe;">
                            <div class="subject-pill-code" style="color: #3730a3;"><i class="bx bx-star me-1"></i>${masterSlot.subject_name}</div>
                            <div class="subject-pill-name text-muted">กิจกรรมกลาง</div>
                        </div>
                    `;
                    } else if (slotData) {
                        const theme = getSubjectColorTheme(slotData.tsub_code);
                        const tName = teacherMap[slotData.teacher_id] || '';
                        const roomInfo = slotData.room ? `<span class="badge bg-white text-dark ms-1 px-1 border">${slotData.room}</span>` : '';

                        cellContent = `
                        <div class="subject-pill-card" style="background: ${theme.bg}; border-color: ${theme.border};">
                            <div class="subject-pill-code" style="color: ${theme.text};">${slotData.tsub_code || '-'} ${roomInfo}</div>
                            <div class="subject-pill-name fw-bold" style="color: ${theme.text};" title="${slotData.tsub_name || ''}">${slotData.tsub_name || ''}</div>
                            ${tName ? `<div class="subject-pill-teacher" style="color: ${theme.text};"><i class="bx bx-user me-1"></i>${tName}</div>` : ''}
                        </div>
                    `;
                    } else {
                        cellContent = isLunch ? '<span class="badge bg-label-warning small px-2 py-1">พัก</span>' : '<span class="text-muted opacity-25">-</span>';
                    }

                    bodyHtml += `<td class="slot-cell ${isLunch ? 'bg-label-warning' : ''}" style="background-color: ${isLunch ? '#fffdf7' : '#ffffff'};">${cellContent}</td>`;
                });

                bodyHtml += '</tr>';
            });

            $('#m-class-table-body').html(bodyHtml);
        }


        // -------------------------------------------------------------
        // 2. TEACHER SCHEDULE LOGIC
        // -------------------------------------------------------------
        const isTeacherScheduleOpen = '<?= ($teacher_schedule_onoff ?? "open") ?>' === 'open';
        let isTeacherInitialized = false;

        function initTeacherSchedule() {
            if (!isTeacherScheduleOpen) {
                $('#teacher-results-container').show();
                return;
            }
            if (isTeacherInitialized) return;
            isTeacherInitialized = true;

            // Load distinct years (Sorted latest first)
            $.ajax({
                url: '<?= site_url('user/getteacherscheduleyears') ?>',
                method: 'GET',
                success: function (yearTerms) {
                    let html = '';
                    if (!yearTerms || yearTerms.length === 0) {
                        html = '<option value="">ไม่พบข้อมูลปีการศึกษา</option>';
                        $('#TeacherSearchYearTerm').html(html);
                        return;
                    }

                    yearTerms.forEach((yt, index) => {
                        const isSel = (index === 0) ? 'selected' : ''; // Default to the latest available in DB
                        html += `<option value="${yt.label}" data-year="${yt.year}" data-term="${yt.term}" ${isSel}>ภาคเรียนที่ ${yt.label}</option>`;
                    });
                    $('#TeacherSearchYearTerm').html(html);

                    loadTeacherData();
                }
            });

            // Load Learning Groups
            $.ajax({
                url: '<?= site_url('user/getlearninggroups') ?>',
                method: 'GET',
                success: function (groups) {
                    let html = '<option value="">ทุกกลุ่มสาระการเรียนรู้</option>';
                    groups.forEach(g => {
                        html += `<option value="${g.lear_id}">${g.lear_namethai}</option>`;
                    });
                    $('#TeacherSearchGroup').html(html);
                }
            });
        }

        function loadTeacherData() {
            const selectedOpt = $('#TeacherSearchYearTerm option:selected');
            const year = selectedOpt.data('year');
            const term = selectedOpt.data('term');
            const groupId = $('#TeacherSearchGroup').val();

            if (!year || !term) return;

            $('#loading-state').show();
            $('#teacher-results-container').hide();

            $.ajax({
                url: '<?= site_url('user/searchteacherschedule') ?>',
                method: 'GET',
                data: {
                    year: year,
                    term: term,
                    group_id: groupId
                },
                success: function (teachers) {
                    allTeacherData = teachers;
                    $('#loading-state').hide();
                    $('#teacher-results-container').show();
                    renderTeacherCards(teachers);
                },
                error: function () {
                    $('#loading-state').hide();
                    $('#teacher-results-container').show().html('<div class="col-12 text-center py-5 text-danger">เกิดข้อผิดพลาดในการโหลดข้อมูลตารางสอน</div>');
                }
            });
        }

        $('#TeacherSearchYearTerm, #TeacherSearchGroup').on('change', function () {
            loadTeacherData();
        });

        $('#FilterTeacher').on('input', function () {
            const query = $(this).val().toLowerCase().trim();
            if (!query) {
                renderTeacherCards(allTeacherData);
                return;
            }

            const filtered = allTeacherData.filter(t => {
                const fullName = `${t.pers_prefix || ''}${t.pers_firstname || ''} ${t.pers_lastname || ''}`.toLowerCase();
                const pos = (t.pers_position || '').toLowerCase();
                const grp = (t.group_name || t.pers_learning || '').toLowerCase();
                return fullName.includes(query) || pos.includes(query) || grp.includes(query);
            });

            renderTeacherCards(filtered);
        });

        function renderTeacherCards(data) {
            if (!data || data.length === 0) {
                $('#teacher-results-container').html('<div class="col-12 text-center py-5 text-muted"><i class="bx bx-user-x fs-1 d-block mb-2 text-warning"></i>ไม่พบข้อมูลตารางสอนครูในเงื่อนไขที่เลือก</div>');
                return;
            }

            let html = '';
            data.forEach(t => {
                const fullName = `${t.pers_prefix || ''}${t.pers_firstname || ''} ${t.pers_lastname || ''}`;
                let teacherImgUrl = 'https://skj.ac.th/uploads/logo/LogoSKJ_4.png';
                if (t.pers_img) {
                    teacherImgUrl = (t.pers_img.startsWith('http://') || t.pers_img.startsWith('https://'))
                        ? t.pers_img
                        : `https://personnel.skj.ac.th/uploads/admin/Personnal/${t.pers_img}`;
                }

                const totalHours = t.total_hours || 0;
                const statusClass = t.has_schedule ? 'bg-done' : 'bg-pending';
                const statusBadge = t.has_schedule
                    ? '<span class="badge bg-label-success rounded-pill small"><i class="bx bx-check-circle me-1"></i>มีตารางสอน</span>'
                    : '<span class="badge bg-label-secondary rounded-pill small">รอดำเนินการ</span>';

                html += `
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card teacher-card shadow-sm p-3 btn-view-teacher-public" data-id="${t.pers_id}">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="teacher-avatar-wrapper">
                                <img src="${teacherImgUrl}" alt="${fullName}" class="teacher-avatar-img" onerror="this.src='https://skj.ac.th/uploads/logo/LogoSKJ_4.png'">
                                <span class="teacher-status-badge ${statusClass}" title="${t.has_schedule ? 'จัดตารางแล้ว' : 'ยังไม่มีตาราง'}"></span>
                            </div>
                            <div class="overflow-hidden flex-grow-1">
                                <h6 class="fw-bold mb-0 text-dark text-truncate" title="${fullName}">${fullName}</h6>
                                <p class="text-muted small mb-0 text-truncate">${t.pers_position || 'ครูผู้สอน'}</p>
                                <small class="text-emerald fw-semibold text-truncate d-block" style="color: #0d6d41;">${t.group_name || ''}</small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-2 border-top mt-2">
                            <div class="d-flex align-items-center gap-1">
                                <i class="bx bx-time-five text-muted"></i>
                                <span class="small text-muted">ภาระสอน: <strong class="text-dark">${totalHours}</strong> คาบ</span>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-bold">
                                <i class="bx bx-search-alt me-1"></i>ดูตาราง
                            </button>
                        </div>
                    </div>
                </div>
            `;
            });
            $('#teacher-results-container').html(html);
        }

        // -------------------------------------------------------------
        // 3. TAB SWITCHING HANDLER
        // -------------------------------------------------------------
        $('#tab-class-btn').on('click', function () {
            currentMode = 'class';
            $('#teacher-results-container').hide();
            $('#class-results-container').show();
        });

        $('#tab-teacher-btn').on('click', function () {
            currentMode = 'teacher';
            $('#class-results-container').hide();
            $('#teacher-results-container').show();
            initTeacherSchedule();
        });

        // -------------------------------------------------------------
        // 4. MODAL DETAIL POPUP HANDLER
        // -------------------------------------------------------------
        $(document).on('click', '.btn-view-teacher-public', function () {
            const teacherId = $(this).data('id');
            if (!teacherId) return;

            const selectedOpt = $('#TeacherSearchYearTerm option:selected');
            const year = selectedOpt.data('year') || activeYearOnly;
            const term = selectedOpt.data('term') || activeTermOnly;

            // Reset and show loader in modal
            $('#m-teacher-name').text('ตารางสอน ครูผู้สอน');
            $('#m-teacher-term').text(`ภาคเรียนที่ ${term}/${year}`);
            $('#m-teacher-loader').show();
            $('#m-teacher-grid-container').hide();

            $('#modalTeacherScheduleDetail').modal('show');

            $.ajax({
                url: '<?= site_url('user/getteacherscheduledetail') ?>',
                type: 'GET',
                data: {
                    teacher_id: teacherId,
                    year: year,
                    term: term
                },
                dataType: 'json',
                success: function (res) {
                    $('#m-teacher-loader').hide();
                    if (res && res.status === 'success' && res.data) {
                        renderTeacherDetailModal(res.data, year, term);
                        $('#m-teacher-grid-container').show();
                    } else {
                        $('#m-teacher-table-body').html(`<tr><td colspan="12" class="text-center py-4 text-danger">${res.message || 'ไม่พบข้อมูลตารางสอน'}</td></tr>`);
                        $('#m-teacher-grid-container').show();
                    }
                },
                error: function () {
                    $('#m-teacher-loader').hide();
                    $('#m-teacher-table-body').html('<tr><td colspan="12" class="text-center py-4 text-danger">เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์</td></tr>');
                    $('#m-teacher-grid-container').show();
                }
            });
        });

        function renderTeacherDetailModal(data, year, term) {
            const t = data.teacher || {};
            const groupName = data.group_name || '';
            const totalHours = data.total_hours || (data.timetable_data ? data.timetable_data.length : 0);

            // 1. Header info
            const fullName = `${t.pers_prefix || ''}${t.pers_firstname || ''} ${t.pers_lastname || ''}`.trim() || 'ครูผู้สอน';
            $('#m-teacher-name').text(`ตารางสอน ${fullName}`);
            let teacherImgUrl = 'https://skj.ac.th/uploads/logo/LogoSKJ_4.png';
            if (t.pers_img) {
                teacherImgUrl = (t.pers_img.startsWith('http://') || t.pers_img.startsWith('https://'))
                    ? t.pers_img
                    : `https://personnel.skj.ac.th/uploads/admin/Personnal/${t.pers_img}`;
            }
            $('#m-teacher-img').attr('src', teacherImgUrl);
            $('#m-teacher-position').html(`<i class="bx bx-briefcase me-1"></i>${t.pers_position || 'ครูผู้สอน'}`);
            $('#m-teacher-group').html(`<i class="bx bx-category me-1"></i>${groupName || 'กลุ่มสาระฯ'}`);
            $('#m-teacher-term').text(`ภาคเรียนที่ ${term}/${year}`);
            $('#m-teacher-hours').text(`${totalHours} คาบ/สัปดาห์`);

            // Set Print Link
            $('#btn-modal-print').attr('href', `<?= base_url('TeacherSchedule/print') ?>/${t.pers_id}/${year}/${term}`);

            // 2. Render Weekly Timetable Grid
            renderTeacherTimetableGrid(data);
        }

        // Render Weekly Timetable Grid for Teacher
        function renderTeacherTimetableGrid(data) {
            const days = data.days || [];
            const periods = data.periods || [];
            const masterSlots = data.master_slots || [];
            const timetableData = data.timetable_data || [];
            const lunchPeriod = data.lunch_period || 4;

            if (!days || days.length === 0) {
                $('#m-teacher-table-body').html('<tr><td colspan="12" class="text-center py-5 text-muted"><i class="bx bx-calendar-x fs-2 d-block mb-2 text-warning"></i>ไม่พบข้อมูลตารางสอนรายสัปดาห์ในระบบสำหรับภาคเรียนนี้</td></tr>');
                return;
            }

            // 1. Build Header
            let headHtml = '<tr><th style="width: 90px; background-color: #f1f5f9;">วัน / คาบ</th>';
            periods.forEach(p => {
                const isLunch = (parseInt(p.period_number) === parseInt(lunchPeriod));
                const lunchTag = isLunch ? '<div class="text-danger fw-bold" style="font-size: 0.65rem;">พักกลางวัน</div>' : '';
                const timeRange = (p.start_time && p.end_time) ? `${p.start_time.substring(0, 5)} - ${p.end_time.substring(0, 5)}` : '';

                headHtml += `
                <th class="${isLunch ? 'bg-label-warning' : ''}" style="background-color: ${isLunch ? '#fff8e6' : '#f8fafc'};">
                    <div class="fw-bold text-dark">คาบ ${p.period_number}</div>
                    <div class="small text-muted fw-normal" style="font-size: 0.68rem;">${timeRange}</div>
                    ${lunchTag}
                </th>
            `;
            });
            headHtml += '</tr>';
            $('#m-teacher-table-head').html(headHtml);

            // 2. Build Body
            let bodyHtml = '';
            days.forEach(day => {
                if (!day.is_active) return;

                bodyHtml += `<tr><td class="fw-bold bg-light text-dark" style="font-size: 0.85rem;">${day.day_name}</td>`;

                periods.forEach(p => {
                    const isLunch = (parseInt(p.period_number) === parseInt(lunchPeriod));

                    // Check Master Slots (Case-insensitive matching)
                    let masterSlot = masterSlots.find(ms => String(ms.day).toUpperCase() === String(day.day_key).toUpperCase() && parseInt(ms.period) === parseInt(p.period_number));

                    // Check Teacher Slot Data (Case-insensitive matching)
                    let slotData = timetableData.find(td => String(td.day).toUpperCase() === String(day.day_key).toUpperCase() && parseInt(td.period) === parseInt(p.period_number));

                    let cellContent = '';

                    if (masterSlot) {
                        cellContent = `
                        <div class="subject-pill-card" style="background: #eef2ff; color: #3730a3; border-color: #c7d2fe;">
                            <div class="subject-pill-code" style="color: #3730a3;"><i class="bx bx-star me-1"></i>${masterSlot.subject_name}</div>
                            <div class="subject-pill-name text-muted">กิจกรรมกลาง</div>
                        </div>
                    `;
                    } else if (slotData) {
                        const theme = getSubjectColorTheme(slotData.tsub_code);
                        const classBadge = slotData.class_name ? `<span class="badge bg-white text-dark ms-1 px-1 border">ม.${slotData.class_name}</span>` : '';
                        const roomInfo = (slotData.room || slotData.room_name) ? `<div class="small text-muted" style="font-size: 0.65rem;">ห้อง ${slotData.room || slotData.room_name}</div>` : '';

                        cellContent = `
                        <div class="subject-pill-card" style="background: ${theme.bg}; border-color: ${theme.border};">
                            <div class="subject-pill-code" style="color: ${theme.text};">${slotData.tsub_code || '-'} ${classBadge}</div>
                            <div class="subject-pill-name fw-bold" style="color: ${theme.text};" title="${slotData.tsub_name || ''}">${slotData.tsub_name || ''}</div>
                            ${roomInfo}
                        </div>
                    `;
                    } else {
                        cellContent = isLunch ? '<span class="badge bg-label-warning small px-2 py-1">พัก</span>' : '<span class="text-muted opacity-25">-</span>';
                    }

                    bodyHtml += `<td class="slot-cell ${isLunch ? 'bg-label-warning' : ''}" style="background-color: ${isLunch ? '#fffdf7' : '#ffffff'};">${cellContent}</td>`;
                });

                bodyHtml += '</tr>';
            });

            $('#m-teacher-table-body').html(bodyHtml);
        }

        // Initialize Fancybox for class schedule images
        Fancybox.bind("[data-fancybox]", {
            compact: false,
            idle: false,
            dragToClose: false
        });
    });
</script>

<?= $this->endSection() ?>