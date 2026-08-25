<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<!-- SweetAlert2 Layering Standard -->
<style>
    .swal2-container {
        z-index: 9999 !important;
    }
    
    /* Emerald Green Custom Theme Styles */
    :root {
        --emerald-primary: #15a362;
        --emerald-light: #e8f7f0;
        --emerald-hover: #11824e;
    }

    .bg-emerald {
        background-color: var(--emerald-primary) !important;
        color: #ffffff !important;
    }

    .bg-emerald-light {
        background-color: var(--emerald-light) !important;
        color: var(--emerald-primary) !important;
    }

    .text-emerald {
        color: var(--emerald-primary) !important;
    }

    .border-emerald {
        border-color: var(--emerald-primary) !important;
    }

    .btn-emerald {
        background-color: var(--emerald-primary) !important;
        border-color: var(--emerald-primary) !important;
        color: #ffffff !important;
    }

    .btn-emerald:hover, .btn-emerald:focus, .btn-emerald:active {
        background-color: var(--emerald-hover) !important;
        border-color: var(--emerald-hover) !important;
        color: #ffffff !important;
    }

    .btn-outline-emerald {
        color: var(--emerald-primary) !important;
        border-color: var(--emerald-primary) !important;
        background-color: transparent;
    }

    .btn-outline-emerald:hover {
        background-color: var(--emerald-primary) !important;
        color: #ffffff !important;
    }

    /* Micro-interactions & animations */
    .stat-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(21, 163, 98, 0.15) !important;
        border-color: rgba(21, 163, 98, 0.2);
    }

    .badge-status {
        font-weight: 600;
        padding: 0.5em 0.85em;
        border-radius: 30px;
    }

    /* Custom scrollbar for tables */
    .table-responsive::-webkit-scrollbar {
        height: 6px;
    }
    .table-responsive::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.15);
        border-radius: 4px;
    }
    
    /* Loading overlay */
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255,255,255,0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }
    .loading-overlay.active {
        opacity: 1;
        pointer-events: auto;
    }
    
    /* Active filter buttons style */
    .btn-check:checked + .btn-outline-emerald {
        background-color: var(--emerald-primary) !important;
        color: white !important;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Page Header & Breadcrumb -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between py-3 mb-4 gap-3">
        <h4 class="fw-bold mb-0">
            <span class="text-muted fw-light">งานแนะแนว /</span> ข้อมูลสถิติเด็กจบแล้วไปไหน
        </h4>
        <a href="/admin/academic/api" target="_blank" class="btn btn-emerald-light text-emerald fw-semibold d-flex align-items-center gap-2" style="border: 1px solid #15a362; border-radius: 8px; font-size: 13px; padding: 8px 16px;">
            <i class="bx bx-code-alt fs-4"></i>
            <span>ลิงก์ระบบ API (สถิติเด็กจบ)</span>
        </a>
    </div>

    <!-- 1. Standalone Top Horizontal Filter Bar -->
    <div class="card mb-4 bg-white shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-body py-3 px-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div class="d-flex align-items-center">
                <div class="avatar avatar-md bg-emerald-light me-3 rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bx bx-calendar fs-3 text-emerald"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold text-dark">สถิติปลายทางของผู้สำเร็จการศึกษา</h5>
                    <small class="text-muted">ปีการศึกษาสำหรับการรายงานสถิติการเรียนต่อและทำงานของนักเรียน</small>
                </div>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    <label for="SelYearFinish" class="form-label mb-0 fw-semibold text-dark text-nowrap">ปีการศึกษาที่จบ:</label>
                    <?php $activeGradYear = get_selected_year_only(); ?>
                    <select class="form-select border-2 border-emerald" id="SelYearFinish" style="width: 160px; height: 40px; font-weight: 600;">
                        <?php if (!empty($SelYears)) : ?>
                            <?php foreach ($SelYears as $idx => $y) : ?>
                                <option value="<?= esc($y->YearFinish) ?>" <?= ($y->YearFinish == $activeGradYear) ? 'selected' : ($idx === 0 && empty($activeGradYear) ? 'selected' : '') ?>>ปี พ.ศ. <?= esc($y->YearFinish) ?></option>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <option value="">ไม่มีข้อมูลการศึกษา</option>
                        <?php endif; ?>
                    </select>
                </div>
                <button class="btn btn-emerald d-flex align-items-center justify-content-center" id="BtnRefresh" style="height: 40px; width: 40px; padding: 0;">
                    <i class="bx bx-refresh fs-3"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- 2. Four Equal-Sized Stat & Chart Cards in a Single Symmetric Row -->
    <div class="row g-4 mb-4">
        <!-- Card 1: Total Graduates -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card h-100 stat-card shadow-sm border-0 position-relative overflow-hidden" style="border-radius: 12px;">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="fw-semibold text-muted d-block mb-1 small text-uppercase" style="letter-spacing: 0.5px; font-size: 10px;">สำเร็จการศึกษา</span>
                        <h2 class="mb-0 fw-bold text-dark fs-2" id="totalGraduates">-</h2>
                        <span class="badge bg-emerald-light text-emerald px-2 py-1 mt-2 rounded-pill fw-semibold" style="font-size: 10px;">
                            <i class="bx bx-check-circle me-1"></i> ผู้เรียนปกติ
                        </span>
                    </div>
                    <div class="avatar bg-emerald-light rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bx bx-graduation fs-2 text-emerald"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Further Studies -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card h-100 stat-card shadow-sm border-0 position-relative overflow-hidden" style="border-left: 4px solid var(--emerald-primary); border-radius: 12px;">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="fw-semibold text-muted d-block mb-1 small text-uppercase" style="letter-spacing: 0.5px; font-size: 10px;">ศึกษาต่อต่างสถาบัน</span>
                        <h2 class="mb-0 fw-bold text-emerald fs-2" id="studyingCount">-</h2>
                        <span class="text-muted mt-2 d-inline-block" style="font-size: 11px;">คิดเป็น <span class="fw-bold text-dark fs-6" id="studyingPercent">-</span> ของทั้งหมด</span>
                    </div>
                    <div class="avatar bg-emerald-light rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bx bx-book-open fs-2 text-emerald"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Working -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card h-100 stat-card shadow-sm border-0 position-relative overflow-hidden" style="border-left: 4px solid #ffab00; border-radius: 12px;">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="fw-semibold text-muted d-block mb-1 small text-uppercase" style="letter-spacing: 0.5px; font-size: 10px;">ประกอบอาชีพ / ทำงาน</span>
                        <h2 class="mb-0 fw-bold text-warning fs-2" id="workingCount">-</h2>
                        <span class="text-muted mt-2 d-inline-block" style="font-size: 11px;">คิดเป็น <span class="fw-bold text-dark fs-6" id="workingPercent">-</span> ของทั้งหมด</span>
                    </div>
                    <div class="avatar bg-light-warning rounded-circle p-3 d-flex align-items-center justify-content-center" style="background-color: #fff3e0; color: #ffab00; width: 56px; height: 56px;">
                        <i class="bx bx-briefcase fs-2"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: Doughnut Chart Card -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm border-0" style="border-radius: 12px;">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <!-- Doughnut Chart Container -->
                    <div style="position: relative; width: 90px; height: 90px; flex-shrink: 0;" class="my-auto">
                        <canvas id="GradStatsChart"></canvas>
                    </div>

                    <!-- Custom Chart Legend -->
                    <div class="flex-grow-1 ms-3 d-flex flex-column justify-content-center">
                        <div class="d-flex justify-content-between align-items-center mb-1 pb-1 border-bottom" style="font-size: 10px;">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-emerald me-2 rounded-circle" style="width: 8px; height: 8px; padding: 0;">&nbsp;</span>
                                <span class="fw-semibold text-dark">ศึกษาต่อ</span>
                            </div>
                            <span class="fw-bold text-dark" id="legendStudyPercent">0%</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-1 pb-1 border-bottom" style="font-size: 10px;">
                            <div class="d-flex align-items-center">
                                <span class="badge me-2 rounded-circle" style="background-color: #ffab00; width: 8px; height: 8px; padding: 0;">&nbsp;</span>
                                <span class="fw-semibold text-dark">ทำงาน</span>
                            </div>
                            <span class="fw-bold text-dark" id="legendWorkPercent">0%</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center" style="font-size: 10px;">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-secondary me-2 rounded-circle" style="width: 8px; height: 8px; padding: 0;">&nbsp;</span>
                                <span class="fw-semibold text-muted">ยังไม่ระบุ</span>
                            </div>
                            <span class="fw-bold text-muted" id="legendOtherPercent">0%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Full-Width Live Search & Filter Table Row -->
    <div class="row g-4">
        <!-- Student List Table (Master) -->
        <div class="col-12">
            <div class="card shadow-sm border-0 position-relative overflow-hidden" id="TableCard" style="border-radius: 12px;">
                <!-- Loading Overlay -->
                <div class="loading-overlay" id="TableLoading">
                    <div class="spinner-border text-emerald" role="status">
                        <span class="visually-hidden">กำลังโหลด...</span>
                    </div>
                </div>

                <div class="card-header border-bottom d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 py-3 px-4">
                    <h5 class="mb-0 d-flex align-items-center fw-bold text-dark">
                        <i class="bx bx-group me-2 fs-4 text-emerald"></i>
                        <span>รายชื่อและข้อมูลปลายทางของผู้สำเร็จการศึกษา</span>
                    </h5>
                    
                    <!-- Search Field & Export Excel Button -->
                    <div class="d-flex gap-2 align-items-center">
                        <div class="input-group input-group-merge" style="max-width: 250px;">
                            <span class="input-group-text border-2 border-end-0 border-emerald bg-white"><i class="bx bx-search text-emerald fs-5"></i></span>
                            <input type="text" class="form-control border-2 border-start-0 border-emerald ps-0" placeholder="ค้นหาชื่อ รหัสประจำตัว..." aria-label="Search" id="TxtSearch">
                        </div>
                        <button class="btn btn-emerald d-flex align-items-center gap-1" id="BtnExportExcel" style="height: 40px;">
                            <i class="bx bx-download fs-5"></i>
                            <span>ส่งออก Excel</span>
                        </button>
                    </div>
                </div>

                <!-- Filter Toggle Group -->
                <div class="px-4 pt-3 d-flex flex-wrap gap-2 align-items-center justify-content-between border-bottom pb-3">
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="statusFilter" id="btnFilterAll" checked value="all">
                        <label class="btn btn-sm btn-outline-emerald rounded-pill px-3 me-2" for="btnFilterAll">ทั้งหมด</label>

                        <input type="radio" class="btn-check" name="statusFilter" id="btnFilterStudy" value="ศึกษาต่อ">
                        <label class="btn btn-sm btn-outline-emerald rounded-pill px-3 me-2" for="btnFilterStudy">ศึกษาต่อ</label>

                        <input type="radio" class="btn-check" name="statusFilter" id="btnFilterWork" value="ทำงาน">
                        <label class="btn btn-sm btn-outline-emerald rounded-pill px-3 me-2" for="btnFilterWork">ทำงาน</label>

                        <input type="radio" class="btn-check" name="statusFilter" id="btnFilterOther" value="ยังไม่ระบุ">
                        <label class="btn btn-sm btn-outline-emerald rounded-pill px-3" for="btnFilterOther">ยังไม่ระบุ</label>
                    </div>

                    <div class="small text-muted fw-semibold">
                        แสดงข้อมูลที่กรองแล้ว <span class="fw-bold text-emerald" id="filteredCount">0</span> จาก <span id="totalStudentsCount" class="text-dark">0</span> คน
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive text-nowrap" style="max-height: 480px;">
                        <table class="table table-hover table-striped mb-0 align-middle">
                            <thead class="sticky-top bg-white border-bottom shadow-sm">
                                <tr>
                                    <th class="text-center fw-bold" width="60">ลำดับ</th>
                                    <th class="fw-bold" width="120">เลขประจำตัว</th>
                                    <th class="fw-bold">ชื่อ-นามสกุล</th>
                                    <th class="text-center fw-bold" width="100">ชั้นเรียน</th>
                                    <th class="text-center fw-bold" width="120">เส้นทางชีวิต</th>
                                    <th class="fw-bold">รายละเอียดสถาบัน / สถานที่ทำงาน</th>
                                    <th class="text-center fw-bold" width="90">ดำเนินการ</th>
                                </tr>
                            </thead>

                            <tbody id="studentTableBody">
                                <!-- Dynamic Rows -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>    
                    </div>

                    <!-- Guidance Tip Card -->
                    <div class="mt-4 p-3 bg-emerald-light rounded border border-emerald w-100">
                        <h6 class="fw-bold text-emerald mb-1"><i class="bx bx-bulb me-1"></i> คำแนะนำงานแนะแนว</h6>
                        <p class="small mb-0 text-dark" style="line-height: 1.4;">
                            ข้อมูลสถิตินี้จะช่วยประกอบการจัดแผนการเรียนและการแนะแนวการศึกษาต่อแก่นักเรียนปัจจุบัน เพื่อสร้างเป้าหมายในอาชีพและทางเลือกการศึกษาในอนาคตได้อย่างมีประสิทธิภาพสูงสุด
                        </p>
                    </div>
                </div>
            </div>
        </div>
</div>

<!-- Modal สำหรับกรอก/แก้ไขข้อมูลเส้นทางชีวิตของผู้สำเร็จการศึกษา -->
<div class="modal fade" id="EditGraduationModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg border-emerald">
            <div class="modal-header bg-emerald text-white">
                <h5 class="modal-title text-white" id="modalEditTitle">
                    <i class="bx bx-edit-alt me-1 fs-4"></i> บันทึกข้อมูลเส้นทางชีวิตผู้สำเร็จการศึกษา
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="FrmSaveGraduation">
                <div class="modal-body text-start" style="white-space: normal;">
                    <!-- Student Info Summary inside modal -->
                    <div class="d-flex align-items-center mb-4 p-3 bg-emerald-light rounded border border-emerald">
                        <div class="avatar avatar-md bg-emerald text-white me-3 rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bx bx-user fs-3"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark" id="modalStudentName">-</h6>
                            <span class="text-muted small">บันทึกเข้าฐานข้อมูลประวัติโรงเรียนโดยตรง</span>
                        </div>
                    </div>

                    <!-- Hidden Fields -->
                    <input type="hidden" id="modalStudentIden" name="iden">

                    <!-- Year Finish Field -->
                    <div class="mb-3">
                        <label for="modalYearFinish" class="form-label fw-bold text-dark">ปีการศึกษาที่สำเร็จการศึกษา (พ.ศ.)</label>
                        <input type="number" class="form-control border-2 border-emerald" id="modalYearFinish" name="year_finish" required min="2560" max="2600" placeholder="เช่น 2568">
                    </div>

                    <!-- Status Selector -->
                    <div class="mb-3">
                        <label for="modalStatus" class="form-label fw-bold text-dark">สถานะหลังสำเร็จการศึกษา</label>
                        <select class="form-select border-2 border-emerald" id="modalStatus" name="status" required>
                            <option value="ยังไม่ระบุ">ยังไม่ระบุ / อื่นๆ</option>
                            <option value="ศึกษาต่อ">ศึกษาต่อสถาบันอุดมศึกษา / โรงเรียนอื่น</option>
                            <option value="ทำงาน">ทำงาน / ประกอบอาชีพ</option>
                        </select>
                    </div>

                    <!-- Dynamic Input: Education details -->
                    <div class="mb-3 d-none" id="divEducation">
                        <label for="modalEduDetails" class="form-label fw-bold text-dark">ระบุชื่อสถาบันการศึกษา / มหาวิทยาลัย (คณะ/สาขา)</label>
                        <input type="text" class="form-control border-2 border-emerald mb-2" id="modalEduDetails" placeholder="เช่น มหาวิทยาลัยเกษตรศาสตร์ (คณะวิศวกรรมศาสตร์)">
                        <div class="mt-2">
                            <span class="text-muted small d-block mb-1 fw-semibold"><i class="bx bx-bolt text-emerald"></i> ปุ่มด่วนสถาบันการศึกษายอดนิยม:</span>
                            <div class="d-flex flex-wrap gap-1">
                                <button type="button" class="btn btn-xs btn-outline-emerald rounded-pill btn-quick-edu mb-1" data-value="มหาวิทยาลัยเกษตรศาสตร์">ม.เกษตรศาสตร์</button>
                                <button type="button" class="btn btn-xs btn-outline-emerald rounded-pill btn-quick-edu mb-1" data-value="จุฬาลงกรณ์มหาวิทยาลัย">จุฬาลงกรณ์ฯ</button>
                                <button type="button" class="btn btn-xs btn-outline-emerald rounded-pill btn-quick-edu mb-1" data-value="มหาวิทยาลัยธรรมศาสตร์">ม.ธรรมศาสตร์</button>
                                <button type="button" class="btn btn-xs btn-outline-emerald rounded-pill btn-quick-edu mb-1" data-value="มหาวิทยาลัยศรีนครินทรวิโรฒ">มศว</button>
                                <button type="button" class="btn btn-xs btn-outline-emerald rounded-pill btn-quick-edu mb-1" data-value="มหาวิทยาลัยมหิดล">ม.มหิดล</button>
                                <button type="button" class="btn btn-xs btn-outline-emerald rounded-pill btn-quick-edu mb-1" data-value="มหาวิทยาลัยเชียงใหม่">ม.เชียงใหม่</button>
                                <button type="button" class="btn btn-xs btn-outline-emerald rounded-pill btn-quick-edu mb-1" data-value="มหาวิทยาลัยรามคำแหง">ม.รามคำแหง</button>
                                <button type="button" class="btn btn-xs btn-outline-emerald rounded-pill btn-quick-edu mb-1" data-value="มหาวิทยาลัยบูรพา">ม.บูรพา</button>
                                <button type="button" class="btn btn-xs btn-outline-emerald rounded-pill btn-quick-edu mb-1" data-value="มหาวิทยาลัยศิลปากร">ม.ศิลปากร</button>
                                <button type="button" class="btn btn-xs btn-outline-emerald rounded-pill btn-quick-edu mb-1" data-value="สถาบันการจัดการปัญญาภิวัฒน์">ม.ปัญญาภิวัฒน์</button>
                                <button type="button" class="btn btn-xs btn-outline-emerald rounded-pill btn-quick-edu mb-1" data-value="วิทยาลัยเทคนิค">วิทยาลัยเทคนิค</button>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Input: Job/Work details -->
                    <div class="mb-3 d-none" id="divCareer">
                        <label for="modalCareerDetails" class="form-label fw-bold text-dark">ระบุชื่อสถานที่ทำงาน / บริษัท (ตำแหน่งงาน/อาชีพ)</label>
                        <input type="text" class="form-control border-2 border-emerald mb-2" id="modalCareerDetails" placeholder="เช่น บจก. เทคโนโลยี จำกัด (พนักงานโปรแกรมเมอร์)">
                        <div class="mt-2">
                            <span class="text-muted small d-block mb-1 fw-semibold"><i class="bx bx-bolt text-warning"></i> ปุ่มด่วนเส้นทางชีวิต / อาชีพยอดนิยม:</span>
                            <div class="d-flex flex-wrap gap-1">
                                <button type="button" class="btn btn-xs btn-outline-warning rounded-pill btn-quick-career mb-1" data-value="ประกอบธุรกิจส่วนตัว / ค้าขาย">ธุรกิจส่วนตัว/ค้าขาย</button>
                                <button type="button" class="btn btn-xs btn-outline-warning rounded-pill btn-quick-career mb-1" data-value="รับราชการ / รัฐวิสาหกิจ">รับราชการ/รัฐวิสาหกิจ</button>
                                <button type="button" class="btn btn-xs btn-outline-warning rounded-pill btn-quick-career mb-1" data-value="พนักงานบริษัทเอกชน">พนักงานบริษัทเอกชน</button>
                                <button type="button" class="btn btn-xs btn-outline-warning rounded-pill btn-quick-career mb-1" data-value="พนักงานโรงงานอุตสาหกรรม">พนักงานโรงงาน</button>
                                <button type="button" class="btn btn-xs btn-outline-warning rounded-pill btn-quick-career mb-1" data-value="อาชีพอิสระ / ฟรีแลนซ์">อาชีพอิสระ/ฟรีแลนซ์</button>
                                <button type="button" class="btn btn-xs btn-outline-warning rounded-pill btn-quick-career mb-1" data-value="เกษตรกรรม (ทำสวน/ทำไร่)">เกษตรกรรม</button>
                                <button type="button" class="btn btn-xs btn-outline-warning rounded-pill btn-quick-career mb-1" data-value="ธุรกิจออนไลน์ / ค้าขายออนไลน์">ค้าขายออนไลน์</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top pt-3">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-emerald px-4"><i class="bx bx-save me-1"></i> บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Load Chart.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Client Side Controller & AJAX -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize Elements
        const selYear = document.getElementById("SelYearFinish");
        const btnRefresh = document.getElementById("BtnRefresh");
        const txtSearch = document.getElementById("TxtSearch");
        const tableBody = document.getElementById("studentTableBody");
        const filteredCountSpan = document.getElementById("filteredCount");
        const totalStudentsCountSpan = document.getElementById("totalStudentsCount");
        const loader = document.getElementById("TableLoading");
        
        // Stats Cards Elements
        const totalGraduatesH2 = document.getElementById("totalGraduates");
        const studyingCountH2 = document.getElementById("studyingCount");
        const studyingPercentSpan = document.getElementById("studyingPercent");
        const workingCountH2 = document.getElementById("workingCount");
        const workingPercentSpan = document.getElementById("workingPercent");

        // Legend Elements
        const legendStudyPercent = document.getElementById("legendStudyPercent");
        const legendWorkPercent = document.getElementById("legendWorkPercent");
        const legendOtherPercent = document.getElementById("legendOtherPercent");

        // Modal Elements
        const editModal = new bootstrap.Modal(document.getElementById("EditGraduationModal"));
        const modalStudentName = document.getElementById("modalStudentName");
        const modalStudentIden = document.getElementById("modalStudentIden");
        const modalStatus = document.getElementById("modalStatus");
        const modalEduDetails = document.getElementById("modalEduDetails");
        const modalCareerDetails = document.getElementById("modalCareerDetails");
        const divEducation = document.getElementById("divEducation");
        const divCareer = document.getElementById("divCareer");
        const frmSaveGraduation = document.getElementById("FrmSaveGraduation");

        let rawStudentsData = []; // Store raw list loaded via AJAX
        let activeStatusFilter = "all";
        let gradChart = null; // Store Chart.js instance

        // Setup Chart
        function initChart(studying, working, other) {
            const ctx = document.getElementById('GradStatsChart').getContext('2d');
            
            if (gradChart) {
                gradChart.destroy();
            }

            const total = studying + working + other;
            const dataValues = total > 0 ? [studying, working, other] : [0, 0, 1];
            const bgColors = total > 0 ? ['#15a362', '#ffab00', '#8592a3'] : ['#e0e0e0', '#e0e0e0', '#e0e0e0'];

            gradChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['ศึกษาต่อ', 'ทำงาน', 'ยังไม่ระบุ/อื่นๆ'],
                    datasets: [{
                        data: dataValues,
                        backgroundColor: bgColors,
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    if (total === 0) return 'ไม่มีข้อมูล';
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    const val = context.raw;
                                    const pct = ((val / total) * 100).toFixed(1);
                                    return `${label}${val} คน (${pct}%)`;
                                }
                            }
                        }
                    },
                    cutout: '70%'
                }
            });
        }

        // Fetch Data from Server
        function loadGraduationStats() {
            const selectedYearValue = selYear.value;
            if (!selectedYearValue) return;

            loader.classList.add("active");

            const formData = new FormData();
            formData.append("keyYear", selectedYearValue);
            formData.append("<?= csrf_token() ?>", "<?= csrf_hash() ?>");

            fetch("<?= base_url('Admin/Acade/Guidance/GraduationStats/Data') ?>", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(res => {
                loader.classList.remove("active");
                if (res.status === "success") {
                    totalGraduatesH2.textContent = res.summary.total + " คน";
                    studyingCountH2.textContent = res.summary.studying + " คน";
                    studyingPercentSpan.textContent = res.summary.studying_percent + "%";
                    workingCountH2.textContent = res.summary.working + " คน";
                    workingPercentSpan.textContent = res.summary.working_percent + "%";

                    legendStudyPercent.textContent = res.summary.studying_percent + "%";
                    legendWorkPercent.textContent = res.summary.working_percent + "%";
                    legendOtherPercent.textContent = res.summary.other_percent + "%";

                    rawStudentsData = res.students;
                    totalStudentsCountSpan.textContent = res.students.length;

                    initChart(res.summary.studying, res.summary.working, res.summary.other);
                    renderFilteredTable();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด!',
                        text: res.message || 'ไม่สามารถดึงข้อมูลได้',
                        confirmButtonColor: '#15a362'
                    });
                }
            })
            .catch(err => {
                loader.classList.remove("active");
                console.error("AJAX Error:", err);
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาดในการเชื่อมต่อ!',
                    text: 'กรุณาตรวจสอบระบบอินเทอร์เน็ตหรือติดต่อผู้ดูแลระบบ',
                    confirmButtonColor: '#15a362'
                });
            });
        }

        // Render Table with Filtering & Searching
        function renderFilteredTable() {
            const searchTerm = txtSearch.value.trim().toLowerCase();
            
            const filteredList = rawStudentsData.filter(student => {
                if (activeStatusFilter !== "all" && student.status !== activeStatusFilter) {
                    return false;
                }
                
                if (searchTerm) {
                    const matchesName = student.fullname.toLowerCase().includes(searchTerm);
                    const matchesCode = student.student_code.toLowerCase().includes(searchTerm);
                    const matchesClass = student.class.toLowerCase().includes(searchTerm);
                    const matchesDestination = student.destination.toLowerCase().includes(searchTerm);
                    return matchesName || matchesCode || matchesClass || matchesDestination;
                }

                return true;
            });

            filteredCountSpan.textContent = filteredList.length;

            if (filteredList.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="text-muted">
                                <i class="bx bx-search-alt-2 fs-1 d-block mb-2"></i>
                                ไม่พบรายชื่อข้อมูลผู้สำเร็จการศึกษาในเงื่อนไขการค้นหานี้
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            let html = "";
            filteredList.forEach(s => {
                let badgeClass = "bg-secondary";
                if (s.status === "ศึกษาต่อ") badgeClass = "bg-emerald";
                else if (s.status === "ทำงาน") badgeClass = "bg-warning";

                html += `
                    <tr>
                        <td class="text-center fw-bold text-muted">${s.index}</td>
                        <td class="fw-semibold text-dark">${s.student_code}</td>
                        <td>
                            <span class="fw-semibold text-dark">${s.fullname}</span>
                        </td>
                        <td class="text-center text-secondary">${s.class}</td>
                        <td class="text-center">
                            <span class="badge ${badgeClass} text-white px-3 py-2 rounded-pill fw-semibold" style="font-size: 11px;">
                                ${s.status}
                            </span>
                        </td>
                        <td class="text-dark fw-medium text-wrap">${s.destination}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-icon btn-emerald rounded-circle btn-edit-grad" 
                                    data-iden="${s.student_iden}" 
                                    data-fullname="${s.fullname}" 
                                    data-status="${s.status}" 
                                    data-destination="${s.destination}"
                                    data-year-finish="${s.year_finish || ''}"
                                    title="บันทึกข้อมูลเส้นทางชีวิต">
                                <i class="bx bx-edit"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });

            tableBody.innerHTML = html;
        }

        // Toggle Fields based on Status Choice
        function toggleModalFields(status) {
            if (status === "ศึกษาต่อ") {
                divEducation.classList.remove("d-none");
                divCareer.classList.add("d-none");
                modalEduDetails.required = true;
                modalCareerDetails.required = false;
            } else if (status === "ทำงาน") {
                divEducation.classList.add("d-none");
                divCareer.classList.remove("d-none");
                modalEduDetails.required = false;
                modalCareerDetails.required = true;
            } else {
                divEducation.classList.add("d-none");
                divCareer.classList.add("d-none");
                modalEduDetails.required = false;
                modalCareerDetails.required = false;
            }
        }

        modalStatus.addEventListener("change", function() {
            toggleModalFields(this.value);
        });

        // Event delegation for table edit buttons
        tableBody.addEventListener("click", function(e) {
            const btn = e.target.closest(".btn-edit-grad");
            if (btn) {
                const iden = btn.getAttribute("data-iden");
                const fullname = btn.getAttribute("data-fullname");
                const status = btn.getAttribute("data-status");
                const destination = btn.getAttribute("data-destination");
                const yearFinish = btn.getAttribute("data-year-finish");

                modalStudentIden.value = iden;
                modalStudentName.textContent = fullname;
                modalStatus.value = status;
                document.getElementById("modalYearFinish").value = yearFinish || "";

                // Reset values
                modalEduDetails.value = "";
                modalCareerDetails.value = "";

                if (status === "ศึกษาต่อ") {
                    modalEduDetails.value = destination !== "-" ? destination : "";
                } else if (status === "ทำงาน") {
                    modalCareerDetails.value = destination !== "-" ? destination : "";
                }

                toggleModalFields(status);
                editModal.show();
            }
        });

        // Handle Quick Select button clicks for Education
        document.querySelectorAll(".btn-quick-edu").forEach(btn => {
            btn.addEventListener("click", function() {
                const val = this.getAttribute("data-value");
                modalEduDetails.value = val;
                modalEduDetails.focus();
            });
        });

        // Handle Quick Select button clicks for Career
        document.querySelectorAll(".btn-quick-career").forEach(btn => {
            btn.addEventListener("click", function() {
                const val = this.getAttribute("data-value");
                modalCareerDetails.value = val;
                modalCareerDetails.focus();
            });
        });

        // Handle Save Form Submission
        frmSaveGraduation.addEventListener("submit", function(e) {
            e.preventDefault();

            const iden = modalStudentIden.value;
            const status = modalStatus.value;
            const yearFinish = document.getElementById("modalYearFinish").value.trim();
            let destination = "";

            if (status === "ศึกษาต่อ") {
                destination = modalEduDetails.value.trim();
            } else if (status === "ทำงาน") {
                destination = modalCareerDetails.value.trim();
            }

            // Show loading SweetAlert2
            Swal.fire({
                title: 'กำลังบันทึกข้อมูล...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const formData = new FormData();
            formData.append("iden", iden);
            formData.append("status", status);
            formData.append("destination", destination);
            formData.append("year_finish", yearFinish);
            formData.append("<?= csrf_token() ?>", "<?= csrf_hash() ?>");

            fetch("<?= base_url('Admin/Acade/Guidance/GraduationStats/Save') ?>", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(res => {
                Swal.close();
                if (res.status === "success") {
                    editModal.hide();
                    Swal.fire({
                        icon: 'success',
                        title: 'บันทึกสำเร็จ!',
                        text: res.message,
                        confirmButtonColor: '#15a362',
                        timer: 2000
                    }).then(() => {
                        loadGraduationStats();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด!',
                        text: res.message || 'ไม่สามารถบันทึกข้อมูลลงฐานข้อมูลได้',
                        confirmButtonColor: '#15a362'
                    });
                }
            })
            .catch(err => {
                Swal.close();
                console.error("Save Error:", err);
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาดในการส่งข้อมูล!',
                    text: 'กรุณาตรวจสอบการเชื่อมต่ออินเทอร์เน็ตหรือติดต่อแอดมิน',
                    confirmButtonColor: '#15a362'
                });
            });
        });

        // Add Listeners
        selYear.addEventListener("change", loadGraduationStats);
        btnRefresh.addEventListener("click", loadGraduationStats);
        txtSearch.addEventListener("input", renderFilteredTable);

        // Status Filter Buttons Listener
        document.querySelectorAll("input[name='statusFilter']").forEach(radio => {
            radio.addEventListener("change", function(e) {
                activeStatusFilter = e.target.value;
                renderFilteredTable();
            });
        });

        // Initialize display
        // Excel Export Logic
        const btnExportExcel = document.getElementById("BtnExportExcel");
        if (btnExportExcel) {
            btnExportExcel.addEventListener("click", function() {
                const selectedYear = selYear.value;
                let csvContent = "\uFEFF"; // UTF-8 BOM
                csvContent += "ลำดับ,เลขประจำตัว,ชื่อ-นามสกุล,ชั้นเรียน,เส้นทางชีวิต,รายละเอียดสถาบัน/สถานที่ทำงาน\n";
                
                const rows = tableBody.querySelectorAll("tr");
                if (rows.length === 0 || (rows.length === 1 && rows[0].classList.contains("no-data"))) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'ไม่พบข้อมูล',
                        text: 'ไม่มีข้อมูลสำหรับส่งออกในปีการศึกษานี้',
                        confirmButtonColor: '#15a362'
                    });
                    return;
                }
                
                let index = 1;
                rows.forEach(row => {
                    if (row.style.display !== "none" && !row.classList.contains("no-data")) {
                        const cols = row.querySelectorAll("td");
                        if (cols.length >= 6) {
                            const studentCode = cols[1].textContent.trim();
                            const fullName = cols[2].textContent.trim();
                            const className = cols[3].textContent.trim();
                            
                            // Status badge text
                            const status = cols[4].querySelector(".badge") ? cols[4].querySelector(".badge").textContent.trim() : "ยังไม่ระบุ";
                            
                            // Details
                            const details = cols[5].textContent.trim().replace(/"/g, '""'); // Escape double quotes
                            
                            csvContent += `"${index}","${studentCode}","${fullName}","${className}","${status}","${details}"\n`;
                            index++;
                        }
                    }
                });
                
                const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                const url = URL.createObjectURL(blob);
                const link = document.createElement("a");
                link.setAttribute("href", url);
                link.setAttribute("download", `รายงานสถิติปลายทางผู้สำเร็จการศึกษา_ปี_${selectedYear}.csv`);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                
                Swal.fire({
                    icon: 'success',
                    title: 'ส่งออกข้อมูลสำเร็จ',
                    text: `ดาวน์โหลดไฟล์รายงานปีการศึกษา ${selectedYear} เรียบร้อยแล้ว`,
                    timer: 2000,
                    showConfirmButton: false
                });
            });
        }

        loadGraduationStats();
    });
</script>
<?= $this->endSection() ?>
