<?= $this->extend('admin/layout/main') ?>

<?= $this->section('extra_css') ?>
<style>
    /* Modern Design System */
    :root {
        --primary-gradient: linear-gradient(135deg, #15a362 0%, #0d6e42 100%);
        --glass-bg: rgba(255, 255, 255, 0.9);
        --glass-border: rgba(255, 255, 255, 0.2);
    }

    .wizard-container {
        perspective: 1000px;
    }

    /* Card-based Navigation */
    .nav-cards-wrapper {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 1rem;
        margin-bottom: 2.5rem;
    }
    .nav-card-item {
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid transparent !important;
        background: #fff;
        border-radius: 15px !important;
    }
    .nav-card-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
    }
    .nav-card-item.active {
        border-color: #15a362 !important;
        background: rgba(21, 163, 98, 0.04) !important;
    }
    .nav-card-item.active .nav-card-icon {
        background: var(--primary-gradient);
        color: white;
        box-shadow: 0 4px 10px rgba(21, 163, 98, 0.3);
    }
    .nav-card-icon {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #f8f9fa;
        color: #697a8d;
        font-size: 1.25rem;
        transition: all 0.3s ease;
    }
    .nav-card-title {
        font-size: 0.85rem;
        font-weight: 700;
        margin-bottom: 0;
    }
    .nav-card-subtitle {
        font-size: 0.65rem;
        color: #888;
    }

    .hover-elevate {
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        text-align: left;
    }
    .hover-elevate:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }

    /* Wizard Content */
    .wizard-step {
        animation: slideInUp 0.5s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
    }
    @keyframes slideInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .hero-gradient {
        background: var(--primary-gradient);
        color: white;
        border-radius: 20px;
        position: relative;
        overflow: hidden;
    }
    .hero-gradient::after {
        content: "";
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    /* Step 3 Sidebar & Grid */
    .subject-card-wizard {
        transition: all 0.2s ease;
        border: 1px solid #eee !important;
        border-left: 4px solid #15a362 !important;
    }
    .subject-card-wizard:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08) !important;
    }

    .drag-target-hover {
        background-color: rgba(21, 163, 98, 0.1) !important;
        border: 2px dashed #15a362 !important;
        transform: scale(0.98);
    }

    .slot-empty:hover .lock-slot-wizard {
        opacity: 0.5 !important;
        background: #f8f9fa;
    }

    /* Glassmorphism for loaders */
    .glass-loader {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(5px);
        border-radius: 15px;
    }

    .locked-menu {
        opacity: 0.7;
        background: #f8f9fa !important;
        cursor: not-allowed !important;
    }
    .locked-menu:hover {
        transform: none !important;
        box-shadow: none !important;
    }

    /* 🔔 SweetAlert2 Layer Fix */
    .swal2-container {
        z-index: 9999 !important;
    }

    .progress-bar.bg-success {
        background-color: #15a362 !important;
    }

    /* Card Menu Step 1 */
    .card-setting-step1 {
        cursor: pointer;
        transition: all 0.3s ease;
        border: 1px solid #f0f2f4 !important;
    }
    .card-setting-step1:hover {
        border-color: #15a362 !important;
        background: rgba(21, 163, 98, 0.02);
    }
    .card-setting-step1:hover .avatar {
        transform: scale(1.1);
    }

    /* 🎨 Import Modal UI Enhancement */
    .subject-import-item { transition: opacity 0.2s ease; }
    .shadow-sm-hover:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08) !important;
        transform: translateY(-2px);
        border-color: #15a362 !important;
    }
    .scroll-custom::-webkit-scrollbar { width: 5px; }
    .scroll-custom::-webkit-scrollbar-thumb { background: #e0e0e0; border-radius: 10px; }
    .transition-all { transition: all 0.3s ease; }

    /* ✅ Selected State for Import Cards */
    .subject-import-card {
        border: 1px solid #e0e0e0;
        background: #fff;
    }
    .subject-import-card.is-selected {
        background-color: #f1fbf4 !important;
        border-color: #15a362 !important;
        box-shadow: 0 0 0 1px #15a362;
    }
    .subject-import-card.is-selected .bg-checkbox-area {
        background-color: #15a362 !important;
        border-color: #15a362 !important;
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
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <span class="text-muted fw-light">วิชาการ / ตารางสอน /</span> Timetable Wizard 🪄
        </h4>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible shadow-sm border-start border-danger border-3 mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bx bx-error-circle fs-3 me-2"></i>
                    <div class="fw-bold"><?= session()->getFlashdata('error') ?></div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible shadow-sm border-start border-success border-3 mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bx bx-check-circle fs-3 me-2"></i>
                    <div class="fw-bold"><?= session()->getFlashdata('success') ?></div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <div class="d-flex gap-2">
            <button type="button" onclick="resetAllData()" class="btn btn-label-danger rounded-pill shadow-sm px-3">
                <i class="bx bx-trash me-1"></i> ล้างข้อมูลทั้งหมด
            </button>
            <div class="dropdown">
            <button class="btn btn-white border shadow-sm dropdown-toggle rounded-pill px-3" type="button" id="yearSelector" data-bs-toggle="dropdown" aria-expanded="false">
                <i class='bx bx-calendar-event me-2 text-success'></i>
                <span class="fw-bold">ปีการศึกษา <?= $selectedYear ?></span>
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

    <!-- 📊 Dashboard-style Navigation Cards -->
    <div class="nav-cards-wrapper">
        <div class="card nav-card-item shadow-sm d-none" onclick="goToStep(1)" id="nav-step-1">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="nav-card-icon me-2">
                        <i class='bx bx-cog'></i>
                    </div>
                    <div class="overflow-hidden">
                        <p class="nav-card-title text-nowrap">1. ตั้งค่าพื้นฐาน</p>
                        <p class="nav-card-subtitle text-nowrap mb-0">วัน/เวลา/ช่วงพัก</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card nav-card-item shadow-sm" onclick="goToStep(2)" id="nav-step-2">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="nav-card-icon me-2">
                        <i class='bx bx-user-plus'></i>
                    </div>
                    <div class="overflow-hidden">
                        <p class="nav-card-title text-nowrap">2. มอบหมายงาน</p>
                        <p class="nav-card-subtitle text-nowrap mb-0">ครูสอน/วิชา/ห้อง</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card nav-card-item shadow-sm" onclick="goToStep(3)" id="nav-step-3">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="nav-card-icon me-2">
                        <i class='bx bx-grid-alt'></i>
                    </div>
                    <div class="overflow-hidden">
                        <p class="nav-card-title text-nowrap">3. ล็อคเวลา</p>
                        <p class="nav-card-subtitle text-nowrap mb-0">ล็อคครู/ล็อคห้อง</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card nav-card-item shadow-sm" onclick="goToStep(4)" id="nav-step-4">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="nav-card-icon me-2">
                        <i class='bx bx-bot'></i>
                    </div>
                    <div class="overflow-hidden">
                        <p class="nav-card-title text-nowrap">4. ประมวลผล AI</p>
                        <p class="nav-card-subtitle text-nowrap mb-0">ประมวลผลตาราง</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card nav-card-item shadow-sm <?= $overall_progress < 100 ? 'locked-menu' : '' ?>" onclick="<?= $overall_progress < 100 ? "Swal.fire({icon:'warning', title:'กรุณาประมวลผล AI ก่อน', text:'ข้อมูลมีการเปลี่ยนแปลง จำเป็นต้องประมวลผลในขั้นตอนที่ 4 ให้สำเร็จ 100% ก่อนจึงจะดูตารางได้ครับ'})" : 'goToStep(5)' ?>" id="nav-step-5">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="nav-card-icon me-2">
                        <i class='bx <?= $overall_progress < 100 ? "bx-lock-alt text-danger" : "bx-check-double" ?>'></i>
                    </div>
                    <div class="overflow-hidden">
                        <p class="nav-card-title text-nowrap">5. ตรวจสอบ</p>
                        <p class="nav-card-subtitle text-nowrap mb-0"><?= $overall_progress < 100 ? 'รอกระบวนการขั้นตอนที่ 4' : 'พิมพ์/ตรวจสอบ' ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-lg border-0 rounded-4 overflow-hidden wizard-container">
        <div class="card-body p-0 min-vh-50">
            
            <!-- --- STEP 1: BASIC SETTINGS --- -->
            <div class="wizard-step d-none" id="step-1">
                <div class="p-4 bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 fw-bold text-primary">ตั้งค่าพื้นฐานตารางสอน</h5>
                            <p class="text-muted small mb-0">กำหนดวันเรียนและเวลาเรียนของภาคเรียนนี้</p>
                        </div>
                        <button class="btn btn-primary rounded-pill px-4 next-step">
                            ไปขั้นตอนถัดไป <i class="bx bx-right-arrow-alt ms-1"></i>
                        </button>
                    </div>
                </div>

                <div class="p-4">
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
                <div class="p-4 bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 fw-bold text-primary">การมอบหมายวิชาเรียน</h5>
                            <p class="text-muted small mb-0">กรุณาตรวจสอบรายวิชา ครูผู้สอน และห้องเรียนให้ครบถ้วน</p>
                        </div>
                        <div class="d-flex gap-3 align-items-center">
                            <a href="<?= base_url('admin/academic/timetable/subject-groups') ?>" class="btn btn-label-info btn-lg rounded-4 shadow-sm border-2 px-4 hover-elevate">
                                <i class="bx bx-layer fs-4 me-2"></i>
                                <div>
                                    <div class="fw-bold fs-6">จัดการกลุ่มเรียนพร้อมกัน</div>
                                    <div style="font-size: 0.65rem; opacity: 0.8;">วิชาเลือก, วิชาขนานห้อง (Joint Groups)</div>
                                </div>
                            </a>
                            <div id="group-actions" class="d-none animate__animated animate__fadeIn">
                                <button class="btn btn-success btn-lg rounded-4 px-4 shadow" onclick="saveTeachingGroup()">
                                    <i class="bx bx-package me-1"></i> มัดรวมกลุ่มสอนควบ
                                </button>
                                <button class="btn btn-label-secondary btn-lg rounded-4 px-4" onclick="clearSelection()">
                                    ยกเลิก
                                </button>
                            </div>
                            <button class="btn btn-primary btn-lg rounded-4 px-4 shadow" data-bs-toggle="modal" data-bs-target="#modalAddAssignment">
                                <i class="bx bx-plus-circle fs-4 me-2"></i> เพิ่มการมอบหมาย
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive" style="max-height: 500px;" id="assignmentListContainer">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-label-secondary sticky-top">
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
                            <?php else: foreach($assignments as $g): $a = $g['data']; $tNames = array_column($g['teachers'], 'name'); ?>
                                <tr>
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
                                    <td class="text-center fw-bold text-primary"><?= $a->hours_per_week ?> คาบ</td>
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
                <div class="nav-align-top mb-0">
                    <ul class="nav nav-tabs nav-fill border-bottom p-2 bg-light" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active fw-bold" role="tab" data-bs-toggle="tab" data-bs-target="#tab-subject-locks">
                                <i class="bx bx-book-bookmark me-1"></i> ล็อคคาบวิชา
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link fw-bold" role="tab" data-bs-toggle="tab" data-bs-target="#tab-teacher-locks">
                                <i class="bx bx-user-x me-1"></i> ล็อคเวลาครู
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link fw-bold" role="tab" data-bs-toggle="tab" data-bs-target="#tab-room-locks">
                                <i class="bx bx-building-house me-1"></i> ล็อคการใช้ห้อง
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content p-0 border-0 shadow-none">
                        <!-- 📌 Tab 1: Subject Locks -->
                        <div class="tab-pane fade show active" id="tab-subject-locks" role="tabpanel">
                            <div class="row g-0">
                                <div class="col-lg-3 border-end bg-light p-4" style="min-height: 500px;">
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
                                <div class="col-lg-3 border-end bg-light p-4">
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
                                <div class="col-lg-3 border-end bg-light p-4">
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
                <div class="p-5">
                    <div class="card bg-label-primary border-0 shadow-none p-5 text-center rounded-4">
                        <div class="mb-4">
                            <div class="avatar avatar-xl d-inline-block">
                                <span class="avatar-initial rounded-circle bg-primary shadow-lg"><i class="bx bx-cog bx-spin text-white"></i></span>
                            </div>
                        </div>
                        <h3 class="fw-bold text-primary">พร้อมสำหรับการประมวลผลขั้นสุดท้าย?</h3>
                        <p class="text-muted mx-auto mb-5" style="max-width: 500px;">
                            AI จะนำเงื่อนไขที่คุณกำหนดไว้ทั้งหมดมาคำนวณและเติมเต็มตารางในส่วนที่เหลือ 
                            โดยใช้เวลารวดเร็วและมีความแม่นยำสูง
                        </p>
                        <button class="btn btn-primary btn-lg px-5 rounded-pill shadow-lg" id="btnAIGenerate">
                            <i class='bx bxs-magic-wand me-2'></i> เริ่มประมวลผลด้วย AI 
                        </button>
                    </div>
                    <div id="aiReportContainer" class="mt-4 text-start mx-auto" style="max-width: 800px;">
                        <!-- Report generated by JS -->
                        <div class="row mt-4">
                            <div class="col-md-8 mx-auto">
                                <div class="alert alert-info border-0 shadow-sm d-flex align-items-center">
                                    <i class='bx bx-info-circle fs-4 me-2'></i>
                                    <div class="small">หมายเหตุ: ระบบจะลบข้อมูลตารางเดิมของเทอมนี้และจัดให้ใหม่ตามเงื่อนไขที่ล็อคไว้</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- --- STEP 5: FINISH --- -->
            <div class="wizard-step d-none" id="step-5">
                <div class="p-4">
                    <?php if($overall_progress < 100): ?>
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class='bx bx-shield-quarter text-warning pulse-animation' style="font-size: 6rem;"></i>
                        </div>
                        <h2 class="fw-bold">ต้องประมวลผล AI ใหม่</h2>
                        <p class="text-muted mb-4 mx-auto" style="max-width: 600px;">
                            เนื่องจากมีการเปลี่ยนแปลงข้อมูลพื้นฐาน งานสอน หรือเงื่อนไขเวลา 
                            ระบบจึงทำการล้างตารางส่วนที่ไม่ได้ล็อคไว้เพื่อความถูกต้อง 
                            คุณครูจำเป็นต้องไปที่เมนู <b>"4. ประมวลผล AI"</b> เพื่อจัดตารางให้เสร็จสมบูรณ์ 100% ก่อนจึงจะดูหน้านี้ได้ครับ
                        </p>
                        <div class="d-flex justify-content-center gap-3">
                            <button class="btn btn-primary btn-lg rounded-pill px-5 shadow" onclick="goToStep(4)">
                                <i class="bx bx-bot me-2"></i> ไปหน้าประมวลผล AI
                            </button>
                            <button class="btn btn-label-secondary btn-lg rounded-pill px-4" onclick="location.reload()">
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

                        <div class="d-flex justify-content-center gap-3">
                            <button class="btn btn-label-warning btn-lg px-5 rounded-pill shadow-sm" id="btnAuditSchedule">
                                <i class='bx bx-shield-quarter me-2'></i> ตรวจสอบคุณภาพตาราง
                            </button>
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
            
            // Update Step 5 navigation card lock status
            const $nav5 = $('#nav-step-5');
            const $nav5Icon = $nav5.find('.nav-card-icon i');
            const $nav5Subtitle = $nav5.find('.nav-card-subtitle');

            if (res.overall_progress < 100) {
                $nav5.addClass('locked-menu').attr('onclick', "Swal.fire({icon:'warning', title:'กรุณาประมวลผล AI ก่อน', text:'ข้อมูลมีการเปลี่ยนแปลง จำเป็นต้องประมวลผลในขั้นตอนที่ 4 ให้สำเร็จ 100% ก่อนจึงจะดูตารางได้ครับ'})");
                $nav5Icon.removeClass('bx-check-double').addClass('bx-lock-alt text-danger');
                $nav5Subtitle.text('รอกระบวนการขั้นตอนที่ 4');
            } else {
                $nav5.removeClass('locked-menu').attr('onclick', "goToStep(5)");
                $nav5Icon.removeClass('bx-lock-alt text-danger').addClass('bx-check-double');
                $nav5Subtitle.text('พิมพ์/ตรวจสอบ');
            }
        }
    });
};

window.refreshAssignmentList = function() {
    $.get(window.location.href, function(html) {
        const newList = $(html).find('#assignmentListContainer').html();
        $('#assignmentListContainer').html(newList);
        refreshOverallProgress();
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

    $('#wizard_hours_per_week').on('input change', updateSplitOptions);
    updateSplitOptions(); // Initial call

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
            
            // 🍱 Intelligent Mixed-Level Lunch Check
            let isForbidden = $target.hasClass('slot-forbidden') || $target.data('is-forbidden') == 1;
            if (!isForbidden) {
                if (window._dragHasJunior && p == 4) isForbidden = true;
                if (window._dragHasSenior && p == 5) isForbidden = true;
            }

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

            // 🍱 Intelligent Mixed-Level Lunch Check
            let isForbidden = $cell.hasClass('slot-forbidden') || $cell.data('is-forbidden') == 1;
            if (!isForbidden) {
                if (window._dragHasJunior && p == 4) isForbidden = true;
                if (window._dragHasSenior && p == 5) isForbidden = true;
            }

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

    // --- 🧠 Step 4: AI Engine ---
    $('#btnAIGenerate').on('click', function() {
        Swal.fire({ 
            title: 'ยืนยันการประมวลผล?', 
            text: "ระบบจะใช้เวลาครู่หนึ่งในการคำนวณคาบเรียนที่เหลือทั้งหมด",
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
                                // 🟢 สำเร็จ 100% -> แสดงแจ้งเตือนและรีโหลดเพื่อปลดล็อค Step 5 (PHP)
                                Swal.fire({
                                    icon: 'success',
                                    title: 'จัดตารางสำเร็จ 100%',
                                    text: 'ระบบได้ทำการจัดตารางสอนเสร็จสมบูรณ์แล้วครับ',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    localStorage.setItem('timetable_wizard_step', 5);
                                    location.reload();
                                });
                            } else {
                                // 🟡 สำเร็จบางส่วน (ในทางทฤษฎีไม่ควรถึงจุดนี้เพราะ controller จะ return error ถ้า fail_count > 0)
                                sessionStorage.setItem('ai_failure_report', res.message || 'พบข้อผิดพลาดบางส่วน');
                                localStorage.setItem('timetable_wizard_step', 4);
                                location.reload();
                            }
                        } else {
                            // 🔴 กรณี Error (Rollback) หรือ ประมวลผลไม่สมบูรณ์ (Fail Count > 0)
                            if (res.failed_list && res.failed_list.length > 0) {
                                // เก็บรายงานลง sessionStorage เพื่อแสดงแบบ persistent หลัง reload
                                let persistentHtml = `
                                    <div class="alert alert-danger border-0 shadow-sm mb-4 text-start">
                                        <div class="d-flex">
                                            <i class="bx bx-error-circle fs-3 me-2 mt-1"></i>
                                            <div>
                                                <h6 class="alert-heading fw-bold mb-1">ประมวลผลไม่สำเร็จ (จัดไม่ได้ ${res.fail_count} รายการ)</h6>
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
                                
                                // 💡 Add Actionable Suggestions
                                persistentHtml += `
                                    <div class="bg-label-info p-3 rounded-3 border border-info-subtle mt-3">
                                        <h6 class="fw-bold mb-2 text-info"><i class="bx bx-bulb me-1"></i> กลยุทธ์แก้ไขให้สำเร็จ:</h6>
                                        <ul class="small mb-0 ps-3 text-dark">
                                            <li><b>วิชาที่คาบคู่/คาบยาว:</b> หากวิชามี 3-4 คาบ ลองหั่นคาบ (ใน Step 2) ให้เล็กลง เช่น 2+1 หรือ 2+2</li>
                                            <li><b>ภาระงานครู:</b> ตรวจสอบว่าครูท่านนี้ถูก "ล็อคเวลาไม่ว่าง" (ใน Step 3) มากเกินไปหรือไม่</li>
                                            <li><b>ล็อควิชาด้วยมือ:</b> ลองนำวิชาที่จัดไม่ได้ไปวางในตาราง (Step 3) ในช่องที่ว่างอยู่แล้วกด "ล็อค" ไว้ ระบบ AI จะขยับวิชาอื่นหลบให้เองครับ</li>
                                        </ul>
                                    </div>
                                `;
                                persistentHtml += `</div></div></div></div>`;
                                
                                // 📜 Add Detailed Processing Log
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
                            } else {
                                // 🚨 Detailed Error Reporting for Technical Issues
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

    // --- 📦 Grouping Logic (Combined Classes) ---
    $(document).on('change', '#check-all-assignments', function() {
        $('.assign-checkbox').prop('checked', $(this).is(':checked'));
        toggleGroupActions();
    });

    $(document).on('change', '.assign-checkbox', function() {
        toggleGroupActions();
    });

    function toggleGroupActions() {
        const count = $('.assign-checkbox:checked').length;
        if (count >= 1) {
            $('#group-actions').removeClass('d-none');
        } else {
            $('#group-actions').addClass('d-none');
        }
    }

    window.clearSelection = function() {
        $('.assign-checkbox, #check-all-assignments').prop('checked', false);
        toggleGroupActions();
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
