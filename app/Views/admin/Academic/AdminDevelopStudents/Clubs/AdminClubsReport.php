<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Page Header -->
    <div class="d-flex align-items-md-center justify-content-between mb-4 flex-column flex-md-row gap-3">
        <div>
            <h4 class="fw-bold py-1 mb-0">
                <span class="text-muted fw-light">วิชาการ / พัฒนาผู้เรียน / ชุมนุม /</span> รายงาน
            </h4>
            <div class="text-muted small">รายงานบันทึกการมาเรียนและผลการประเมินชุมนุม</div>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="<?= site_url('Admin/Acade/DevelopStudents/Clubs/Main') ?>" class="btn btn-outline-secondary px-3">
                <i class="bx bx-arrow-back me-1"></i> กลับหน้าหลัก
            </a>
            <button class="btn btn-success px-3 d-none" id="btnExportExcel">
                <i class="bx bx-download me-1"></i> ส่งออก Excel
            </button>
            <button class="btn btn-info px-3 d-none" id="btnPrint" onclick="window.print();">
                <i class="bx bx-printer me-1"></i> พิมพ์
            </button>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-2 bg-label-primary rounded me-3">
                            <i class="bx bx-filter-alt fs-4"></i>
                        </div>
                        <h5 class="mb-0">ตัวกรองข้อมูล</h5>
                    </div>
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">ปีการศึกษา</label>
                            <select class="form-select" id="filterYear">
                                <?php if (!empty($AcademicYears)): ?>
                                    <?php foreach ($AcademicYears as $y): ?>
                                        <option value="<?= esc($y->club_year) ?>" <?= ($y->club_year == ($currentYear ?? '')) ? 'selected' : '' ?>>
                                            <?= esc($y->club_year) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="">ไม่มีข้อมูล</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">ภาคเรียน</label>
                            <select class="form-select" id="filterTerm">
                                <option value="1">ภาคเรียนที่ 1</option>
                                <option value="2">ภาคเรียนที่ 2</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">ชุมนุม</label>
                            <select class="form-select select2" id="filterClub">
                                <option value="all">-- ทุกชุมนุม --</option>
                                <?php if (!empty($Clubs)): ?>
                                    <?php foreach ($Clubs as $club): ?>
                                        <option value="<?= esc($club->club_id) ?>"><?= esc($club->club_name) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary w-100" id="btnSearch">
                                <i class="bx bx-search me-1"></i> ค้นหา
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Tab Selector -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100 report-tab-card active" data-target="#content-attendance" id="card-tab-attendance" style="cursor: pointer; transition: all 0.3s ease;">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="avatar avatar-lg">
                                <span class="avatar-initial rounded-circle bg-primary shadow" style="width:56px;height:56px;">
                                    <i class="bx bx-calendar-check fs-2 text-white"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1 fw-bold">รายงานบันทึกการมาเรียน</h5>
                            <p class="mb-0 text-muted small">สถิติมา / ขาด / ลาป่วย / ลากิจ แยกรายสัปดาห์</p>
                        </div>
                        <div class="ms-2">
                            <i class="bx bx-chevron-right fs-3 text-primary report-tab-arrow"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100 report-tab-card" data-target="#content-evaluation" id="card-tab-evaluation" style="cursor: pointer; transition: all 0.3s ease;">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="avatar avatar-lg">
                                <span class="avatar-initial rounded-circle bg-success shadow" style="width:56px;height:56px;">
                                    <i class="bx bx-check-shield fs-2 text-white"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1 fw-bold">รายงานการประเมิน</h5>
                            <p class="mb-0 text-muted small">ผลประเมิน ผ่าน / ไม่ผ่าน ตามที่ครูชุมนุมบันทึก</p>
                        </div>
                        <div class="ms-2">
                            <i class="bx bx-chevron-right fs-3 text-success report-tab-arrow"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Content -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="tab-content">
                    <!-- ==================== TAB 1: บันทึกการมาเรียน ==================== -->
                    <div class="tab-pane fade show active" id="content-attendance" role="tabpanel">
                        <div class="card-body">
                            <!-- Summary Cards Attendance -->
                            <div class="row g-3 mb-4 d-none" id="attendSummaryCards">
                                <div class="col-6 col-lg-3">
                                    <div class="d-flex align-items-center p-3 rounded bg-light">
                                        <div class="avatar avatar-sm me-2">
                                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-group"></i></span>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">นักเรียนทั้งหมด</small>
                                            <span class="fw-bold" id="attendTotal">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <div class="d-flex align-items-center p-3 rounded bg-light">
                                        <div class="avatar avatar-sm me-2">
                                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-check"></i></span>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">สัปดาห์ที่เช็คแล้ว</small>
                                            <span class="fw-bold text-success" id="attendWeeksChecked">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <div class="d-flex align-items-center p-3 rounded bg-light">
                                        <div class="avatar avatar-sm me-2">
                                            <span class="avatar-initial rounded bg-label-info"><i class="bx bx-calendar"></i></span>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">สัปดาห์ทั้งหมด</small>
                                            <span class="fw-bold" id="attendWeeksTotal">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <div class="d-flex align-items-center p-3 rounded bg-light">
                                        <div class="avatar avatar-sm me-2">
                                            <span class="avatar-initial rounded bg-label-danger"><i class="bx bx-x"></i></span>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">นักเรียนขาดมาก (≥3 ครั้ง)</small>
                                            <span class="fw-bold text-danger" id="attendHighAbsent">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Loading -->
                            <div class="text-center py-5 d-none" id="attendLoading">
                                <div class="spinner-border text-primary" role="status"></div>
                                <p class="text-muted mt-2">กำลังโหลดข้อมูล...</p>
                            </div>

                            <!-- Empty State -->
                            <div class="text-center py-5" id="attendEmpty">
                                <i class="bx bx-calendar-check text-muted mb-3" style="font-size: 4rem; opacity: 0.3;"></i>
                                <h5 class="text-muted">เลือกเงื่อนไขแล้วกด "ค้นหา" เพื่อดูรายงาน</h5>
                                <p class="text-muted small">แสดงสถิติการมาเรียน มา/ขาด/ลาป่วย/ลากิจ แต่ละสัปดาห์</p>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive d-none overflow-hidden" id="attendTableContainer">
                                <table class="table table-hover table-bordered table-sm table-compact-report" id="attendTable" width="100%">
                                    <thead class="table-light text-center" id="attendTableHead">
                                        <!-- Dynamic header: ลำดับ, ชื่อ, ชุมนุม, สัปดาห์1..N, สรุป -->
                                    </thead>
                                    <tbody id="attendTableBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- ==================== TAB 2: การประเมิน ==================== -->
                    <div class="tab-pane fade" id="content-evaluation" role="tabpanel">
                        <div class="card-body">
                            <!-- Summary Cards Evaluation -->
                            <div class="row g-3 mb-4 d-none" id="evalSummaryCards">
                                <div class="col-sm-6 col-lg-3">
                                    <div class="d-flex align-items-center p-3 rounded bg-light">
                                        <div class="avatar avatar-sm me-2">
                                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-group"></i></span>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">นักเรียนทั้งหมด</small>
                                            <span class="fw-bold" id="evalTotal">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="d-flex align-items-center p-3 rounded bg-light">
                                        <div class="avatar avatar-sm me-2">
                                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-check-circle"></i></span>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">ผ่าน</small>
                                            <span class="fw-bold text-success" id="evalPass">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="d-flex align-items-center p-3 rounded bg-light">
                                        <div class="avatar avatar-sm me-2">
                                            <span class="avatar-initial rounded bg-label-danger"><i class="bx bx-x-circle"></i></span>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">ไม่ผ่าน</small>
                                            <span class="fw-bold text-danger" id="evalFail">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="d-flex align-items-center p-3 rounded bg-light">
                                        <div class="avatar avatar-sm me-2">
                                            <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-error"></i></span>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">ยังไม่ประเมิน</small>
                                            <span class="fw-bold text-warning" id="evalPending">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mb-4 d-none" id="evalProgressSection">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-semibold small">อัตราผ่าน</span>
                                    <span class="fw-bold text-success" id="evalPassPercent">0%</span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-success" id="evalPassBar" style="width: 0%"></div>
                                    <div class="progress-bar bg-danger" id="evalFailBar" style="width: 0%"></div>
                                    <div class="progress-bar bg-warning" id="evalPendingBar" style="width: 0%"></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <small><i class="bx bxs-circle text-success me-1"></i>ผ่าน</small>
                                    <small><i class="bx bxs-circle text-danger me-1"></i>ไม่ผ่าน</small>
                                    <small><i class="bx bxs-circle text-warning me-1"></i>ยังไม่ประเมิน</small>
                                </div>
                            </div>

                            <!-- Loading -->
                            <div class="text-center py-5 d-none" id="evalLoading">
                                <div class="spinner-border text-primary" role="status"></div>
                                <p class="text-muted mt-2">กำลังโหลดข้อมูล...</p>
                            </div>

                            <!-- Empty State -->
                            <div class="text-center py-5" id="evalEmpty">
                                <i class="bx bx-check-shield text-muted mb-3" style="font-size: 4rem; opacity: 0.3;"></i>
                                <h5 class="text-muted">เลือกเงื่อนไขแล้วกด "ค้นหา" เพื่อดูรายงาน</h5>
                                <p class="text-muted small">แสดงผลการประเมิน ผ่าน/ไม่ผ่าน ตามที่ครูชุมนุมบันทึก</p>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive d-none" id="evalTableContainer">
                                <table class="table table-hover table-striped table-compact-report" id="evalTable" width="100%">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" style="width: 50px;">ลำดับ</th>
                                            <th style="width: 100px;">เลขประจำตัว</th>
                                            <th>ชื่อ - นามสกุล</th>
                                            <th>ชั้น/ห้อง</th>
                                            <th>ชุมนุม</th>
                                            <th>ครูที่ปรึกษาชุมนุม</th>
                                            <th class="text-center" style="width: 130px;">ผลการประเมิน</th>
                                        </tr>
                                    </thead>
                                    <tbody id="evalTableBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {

    // Initial Select2
    $('#filterClub').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: '-- เลือกชุมนุม --',
    });

    // ========== ค้นหา ==========
    $('#btnSearch').on('click', function() {
        loadAttendanceReport();
        loadEvaluationReport();
    });

    // ========== TAB 1: รายงานบันทึกการมาเรียน ==========
    function loadAttendanceReport() {
        const year = $('#filterYear').val();
        const term = $('#filterTerm').val();
        const clubId = $('#filterClub').val();

        if (!year) { return; }

        $('#attendEmpty').addClass('d-none');
        $('#attendTableContainer').addClass('d-none');
        $('#attendSummaryCards').addClass('d-none');
        $('#attendLoading').removeClass('d-none');

        $.ajax({
            url: '<?= site_url("admin/academic/ConAdminDevelopStudents/ClubAttendanceReportData") ?>',
            type: 'POST',
            data: {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                year: year,
                term: term,
                club_id: clubId
            },
            dataType: 'json',
            success: function(res) {
                $('#attendLoading').addClass('d-none');

                if (res.status === 'success' && res.data.length > 0) {
                    renderAttendanceTable(res.data, res.weeks);
                    updateAttendanceSummary(res.summary);
                    $('#attendTableContainer').removeClass('d-none');
                    $('#attendSummaryCards').removeClass('d-none');
                    $('#btnExportExcel, #btnPrint').removeClass('d-none');
                } else if (res.status === 'error') {
                    showAttendanceEmpty('Error: ' + (res.message || 'Unknown'));
                    console.error('Server Error:', res);
                } else {
                    showAttendanceEmpty('ไม่พบข้อมูลบันทึกการมาเรียนตามเงื่อนไขที่เลือก');
                }
            },
            error: function(xhr) {
                $('#attendLoading').addClass('d-none');
                console.error('AJAX Error:', xhr.status, xhr.responseText);
                showAttendanceEmpty('Error ' + xhr.status + ': ' + (xhr.responseText || '').substring(0, 200));
            }
        });
    }

    function showAttendanceEmpty(msg) {
        $('#attendEmpty').html(`
            <i class="bx bx-search-alt text-muted mb-3" style="font-size: 4rem; opacity: 0.3;"></i>
            <h5 class="text-muted">${msg}</h5>
        `).removeClass('d-none');
    }

    function renderAttendanceTable(data, weeks) {
        // Header
        let headHtml = '<tr><th class="text-center" style="width:30px;">#</th>';
        headHtml += '<th class="student-name-col">ชื่อ-นามสกุล</th><th style="width:40px;">ห้อง</th><th class="text-start">ชุมนุม</th>';
        weeks.forEach(function(w) {
            headHtml += `<th class="text-center week-col"><small>${w.week_number}</small></th>`;
        });
        headHtml += '<th class="text-center summary-col text-success">ม</th>';
        headHtml += '<th class="text-center summary-col text-danger">ข</th>';
        headHtml += '<th class="text-center summary-col text-warning">ป</th>';
        headHtml += '<th class="text-center summary-col text-info">ก</th></tr>';
        $('#attendTableHead').html(headHtml);

        // Body
        let bodyHtml = '';
        data.forEach(function(row, idx) {
            bodyHtml += `<tr>`;
            bodyHtml += `<td class="text-center">${idx + 1}</td>`;
            bodyHtml += `<td class="student-name-col" title="${row.student_name}">${row.student_name}</td>`;
            bodyHtml += `<td class="text-center">${row.student_class}</td>`;
            bodyHtml += `<td class="text-start"><small>${row.club_name}</small></td>`;

            // สถานะแต่ละสัปดาห์
            weeks.forEach(function(w) {
                const weekData = row.weekly[w.week_number] || '';
                let icon = '', cls = '';
                if (weekData === 'มา') { icon = 'bx-check'; cls = 'text-success'; }
                else if (weekData === 'ขาด') { icon = 'bx-x'; cls = 'text-danger'; }
                else if (weekData === 'ลาป่วย') { icon = 'bx-plus-medical'; cls = 'text-warning'; }
                else if (weekData === 'ลากิจ') { icon = 'bx-briefcase'; cls = 'text-info'; }
                else { icon = 'bx-minus'; cls = 'text-muted'; }
                bodyHtml += `<td class="text-center"><i class="bx ${icon} ${cls}"></i></td>`;
            });

            // สรุปรายบุคคล
            bodyHtml += `<td class="text-center fw-bold text-success">${row.sum_ma}</td>`;
            bodyHtml += `<td class="text-center fw-bold text-danger">${row.sum_khad}</td>`;
            bodyHtml += `<td class="text-center fw-bold text-warning">${row.sum_puay}</td>`;
            bodyHtml += `<td class="text-center fw-bold text-info">${row.sum_kij}</td>`;
            bodyHtml += `</tr>`;
        });
        $('#attendTableBody').html(bodyHtml);
    }

    function updateAttendanceSummary(summary) {
        $('#attendTotal').text(summary.total_students);
        $('#attendWeeksChecked').text(summary.weeks_checked);
        $('#attendWeeksTotal').text(summary.weeks_total);
        $('#attendHighAbsent').text(summary.high_absent);
    }

    // ========== TAB 2: รายงานการประเมิน ==========
    function loadEvaluationReport() {
        const year = $('#filterYear').val();
        const term = $('#filterTerm').val();
        const clubId = $('#filterClub').val();

        if (!year) { return; }

        $('#evalEmpty').addClass('d-none');
        $('#evalTableContainer').addClass('d-none');
        $('#evalSummaryCards').addClass('d-none');
        $('#evalProgressSection').addClass('d-none');
        $('#evalLoading').removeClass('d-none');

        $.ajax({
            url: '<?= site_url("admin/academic/ConAdminDevelopStudents/ClubReportData") ?>',
            type: 'POST',
            data: {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                year: year,
                term: term,
                club_id: clubId
            },
            dataType: 'json',
            success: function(res) {
                $('#evalLoading').addClass('d-none');

                if (res.status === 'success' && res.data.length > 0) {
                    renderEvalTable(res.data);
                    updateEvalSummary(res.summary);
                    $('#evalTableContainer').removeClass('d-none');
                    $('#evalSummaryCards').removeClass('d-none');
                    $('#evalProgressSection').removeClass('d-none');
                } else {
                    showEvalEmpty('ไม่พบข้อมูลการประเมินตามเงื่อนไขที่เลือก');
                }
            },
            error: function() {
                $('#evalLoading').addClass('d-none');
                showEvalEmpty('ไม่สามารถโหลดข้อมูลได้');
            }
        });
    }

    function showEvalEmpty(msg) {
        $('#evalEmpty').html(`
            <i class="bx bx-search-alt text-muted mb-3" style="font-size: 4rem; opacity: 0.3;"></i>
            <h5 class="text-muted">${msg}</h5>
        `).removeClass('d-none');
    }

    function renderEvalTable(data) {
        let html = '';
        data.forEach(function(row, idx) {
            let badgeClass, badgeIcon, badgeText;

            if (row.result === 'ผ') {
                badgeClass = 'bg-label-success';
                badgeIcon = 'bx-check-circle';
                badgeText = 'ผ่าน';
            } else if (row.result === 'มผ') {
                badgeClass = 'bg-label-danger';
                badgeIcon = 'bx-x-circle';
                badgeText = 'ไม่ผ่าน';
            } else {
                badgeClass = 'bg-label-warning';
                badgeIcon = 'bx-time';
                badgeText = 'ยังไม่ประเมิน';
            }

            html += `<tr>
                <td class="text-center">${idx + 1}</td>
                <td>${row.student_code || '-'}</td>
                <td>${row.student_prefix}${row.student_firstname} ${row.student_lastname}</td>
                <td>${row.student_class || '-'}</td>
                <td>${row.club_name || '-'}</td>
                <td>${row.advisor_name || '-'}</td>
                <td class="text-center">
                    <span class="badge ${badgeClass} px-3 py-2">
                        <i class="bx ${badgeIcon} me-1"></i>${badgeText}
                    </span>
                </td>
            </tr>`;
        });
        $('#evalTableBody').html(html);
    }

    function updateEvalSummary(summary) {
        const total = summary.total || 0;
        const pass = summary.pass || 0;
        const fail = summary.fail || 0;
        const pending = summary.pending || 0;

        $('#evalTotal').text(total);
        $('#evalPass').text(pass);
        $('#evalFail').text(fail);
        $('#evalPending').text(pending);

        if (total > 0) {
            const passP = ((pass / total) * 100).toFixed(1);
            const failP = ((fail / total) * 100).toFixed(1);
            const pendingP = ((pending / total) * 100).toFixed(1);
            $('#evalPassBar').css('width', passP + '%');
            $('#evalFailBar').css('width', failP + '%');
            $('#evalPendingBar').css('width', pendingP + '%');
            $('#evalPassPercent').text(passP + '%');
        }
    }

    // ========== Card Tab Switching ==========
    $('.report-tab-card').on('click', function() {
        // สลับ active card
        $('.report-tab-card').removeClass('active');
        $(this).addClass('active');
        // สลับ tab content
        var target = $(this).data('target');
        $('.tab-pane').removeClass('show active');
        $(target).addClass('show active');
    });

    // ========== Export CSV ==========
    $('#btnExportExcel').on('click', function() {
        const activeTab = $('.tab-pane.active').attr('id');
        const tableId = activeTab === 'content-attendance' ? 'attendTable' : 'evalTable';
        const table = document.getElementById(tableId);
        let csv = [];
        table.querySelectorAll("tr").forEach(function(row) {
            let cols = row.querySelectorAll("td, th");
            let rowData = [];
            cols.forEach(function(col) { rowData.push('"' + col.innerText.replace(/"/g, '""') + '"'); });
            csv.push(rowData.join(","));
        });
        const blob = new Blob(["\uFEFF" + csv.join("\n")], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement("a");
        link.href = URL.createObjectURL(blob);
        link.download = "รายงานชุมนุม_" + $('#filterYear').val() + ".csv";
        link.click();
    });
});
</script>

<style>
    .report-tab-card {
        border: 2px solid transparent !important;
        opacity: 0.7;
    }
    .report-tab-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.12) !important;
        opacity: 1;
    }
    .report-tab-card.active {
        border: 2px solid #696cff !important;
        box-shadow: 0 0.5rem 1.5rem rgba(105, 108, 255, 0.2) !important;
        opacity: 1;
        transform: translateY(-2px);
    }
    .report-tab-card.active .report-tab-arrow {
        animation: bounceRight 1.5s ease infinite;
    }
    @keyframes bounceRight {
        0%, 100% { transform: translateX(0); }
        50% { transform: translateX(5px); }
    }
    /* ตารางแบบ Compact พิเศษ */
    .table-compact-report {
        font-size: 0.75rem; /* ย่อตัวหนังสือลง */
    }
    .table-compact-report th, 
    .table-compact-report td {
        padding: 0.4rem 0.2rem !important; /* ลดช่องว่างภายในช่อง */
        vertical-align: middle;
        white-space: nowrap; /* ไม่ให้ตัดบรรทัด */
    }
    .table-compact-report .student-name-col {
        max-width: 150px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        text-align: left !important;
    }
    .week-col {
        width: 30px !important;
        min-width: 30px !important;
        padding: 0.4rem 0 !important;
    }
    .summary-col {
        width: 35px !important;
        font-weight: bold;
    }
    
    @media print {
        .container-p-y { padding-top: 0 !important; }
        .card { box-shadow: none !important; border: 1px solid #eee !important; }
        .report-tab-card, .filter-section, .page-header { display: none !important; }
    }
</style>
<?= $this->endSection() ?>
