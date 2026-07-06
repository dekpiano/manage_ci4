<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>

<style>
    :root {
        --primary-emerald: #15a362;
        --dark-emerald: #0d6d41;
        --light-emerald: #e8f5ee;
        --accent-gold: #ffab00;
        --glass-bg: rgba(255, 255, 255, 0.9);
        --border-radius-lg: 24px;
        --border-radius-md: 16px;
        --shadow-premium: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    /* Premium Header */
    .premium-header {
        background: linear-gradient(135deg, var(--primary-emerald) 0%, var(--dark-emerald) 100%);
        border-radius: var(--border-radius-lg);
        padding: 3rem 2rem;
        color: white;
        margin-bottom: -4rem; /* Overlay stats */
        position: relative;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(21, 163, 98, 0.2);
    }

    .premium-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    /* Glass Stats */
    .glass-stats-container {
        position: relative;
        z-index: 2;
    }

    .stat-card-glass {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: var(--border-radius-md);
        padding: 1.5rem;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-premium);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .stat-card-glass:hover {
        transform: translateY(-8px);
        background: white;
    }

    .stat-icon-box {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    /* Wizard Style Form */
    .assignment-wizard {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 2.5rem;
        box-shadow: var(--shadow-premium);
        border: none;
    }

    .step-badge {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: var(--light-emerald);
        color: var(--primary-emerald);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.8rem;
        margin-right: 8px;
    }

    .form-section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }

    /* Enhanced Table */
    .card-table-registry {
        background: white;
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-premium);
        border: none;
    }

    .table-registry thead th {
        background-color: #fcfcfc;
        border-bottom: 2px solid #f1f1f1;
        padding: 1.2rem 1rem;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        color: #8e94a9;
    }

    .table-registry tbody td {
        padding: 1.2rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f8f9fa;
    }

    /* Custom Buttons */
    .btn-emerald-premium {
        background: var(--primary-emerald);
        color: white;
        border-radius: 12px;
        padding: 0.8rem 1.5rem;
        font-weight: 600;
        border: none;
        box-shadow: 0 4px 15px rgba(21, 163, 98, 0.3);
        transition: all 0.3s ease;
    }

    .btn-emerald-premium:hover {
        background: var(--dark-emerald);
        transform: scale(1.02);
        color: white;
    }

    /* Avatar & Badges */
    .teacher-avatar-group {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .avatar-wrapper {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        overflow: hidden;
        background: #f1f1f1;
    }

    .avatar-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .badge-modern {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .badge-soft-emerald { background: var(--light-emerald); color: var(--primary-emerald); }
    .badge-soft-primary { background: #e7e7ff; color: #696cff; }
    .badge-soft-warning { background: #fff2d6; color: #ffab00; }

    /* Animations */
    .hover-scale { transition: transform 0.2s ease; }
    .hover-scale:hover { transform: scale(1.05); }

    /* Select2 Skinning */
    .select2-container--bootstrap-5 .select2-selection {
        border: 1px solid #dee2e6;
        border-radius: 12px !important;
        min-height: 45px;
        padding-top: 4px;
    }

    /* SweetAlert2 always on top */
    .swal2-container { z-index: 9999 !important; }
</style>

<div class="container-xxl flex-grow-1 container-p-y animate__animated animate__fadeIn">
    
    <!-- Premium Header Area -->
    <div class="premium-header">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="<?= site_url('Admin/Home') ?>" class="text-white opacity-75">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">มอบหมายงานสอน</li>
                    </ol>
                </nav>
                <h1 class="display-6 fw-bold mb-1">จัดการรายวิชาผู้สอน</h1>
                <p class="lead opacity-75 mb-0">จับคู่ครูผู้สอนกับรายวิชาเพื่อเตรียมการส่งแผนการจัดการเรียนรู้</p>
            </div>
            <div class="col-lg-5 text-lg-end mt-4 mt-lg-0">
                <div class="d-inline-flex gap-2">
                    <button class="btn btn-white text-emerald fw-bold px-4 py-2 shadow-sm rounded-pill border-0" data-bs-toggle="modal" data-bs-target="#modalSettings">
                        <i class="bx bx-calendar-star me-2"></i> กำหนดช่วงเวลารับแผน
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Glass Stats Overlay -->
    <div class="container glass-stats-container">
        <div class="row g-4">
            <div class="col-sm-6 col-xl-3">
                <div class="stat-card-glass">
                    <div class="stat-icon-box bg-label-primary">
                        <i class="bx bx-collection"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 fw-bold" id="stat-total">0</h3>
                        <small class="text-muted fw-semibold">รวมงานสอน</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="stat-card-glass">
                    <div class="stat-icon-box bg-label-success">
                        <i class="bx bx-book-open"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 fw-bold" id="stat-subjects">0</h3>
                        <small class="text-muted fw-semibold">วิชาที่เปิดสอน</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="stat-card-glass">
                    <div class="stat-icon-box bg-label-info">
                        <i class="bx bx-user-check"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 fw-bold" id="stat-teachers">0</h3>
                        <small class="text-muted fw-semibold">ครูผู้สอนในระบบ</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="stat-card-glass">
                    <div class="stat-icon-box bg-label-warning">
                        <i class="bx bx-git-branch"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 fw-bold" id="stat-types">-</h3>
                        <small class="text-muted fw-semibold">พื้นฐาน / เพิ่มเติม</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="row mt-5 pt-4 g-4">
        
        <!-- Assignment Wizard (Left) -->
        <div class="col-xl-4 col-lg-5">
            <div class="assignment-wizard">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-label-success p-2 rounded-3 me-3">
                        <i class="bx bx-link-alt fs-4"></i>
                    </div>
                    <h4 class="mb-0 fw-bold">มอบหมายงานใหม่</h4>
                </div>

                <form id="FormUpdateSendPlan" class="row g-4">
                    <!-- Step 1: Select Year -->
                    <div class="col-12">
                        <label class="form-section-title"><span class="step-badge">1</span> ปีการศึกษา</label>
                        <select name="SelectYear" id="SelectYear" class="form-select rounded-3">
                            <?php 
                                $all_years = [];
                                foreach ($CheckYearSendPlan as $v) {
                                    $all_years[] = $v->seplan_term . '/' . $v->seplan_year;
                                }
                                if (!empty($all_years)) {
                                    usort($all_years, function($a, $b) {
                                        $pa = explode('/', $a); $pb = explode('/', $b);
                                        return ($pa[1] == $pb[1]) ? ($pa[0] - $pb[0]) : ($pa[1] - $pb[1]);
                                    });
                                    $latest = end($all_years);
                                    list($l_term, $l_year) = explode('/', $latest);
                                    $next_val = ($l_term == 1) ? "2/" . $l_year : "1/" . ($l_year + 1);
                                    if (!in_array($next_val, $all_years)) $all_years[] = $next_val;
                                }
                                foreach ($all_years as $val):
                                    $isSelected = (isset($term) && isset($year) && $term.'/'.$year == $val) ? "selected" : "";
                            ?>
                                <option value="<?= esc($val) ?>" <?= $isSelected ?>>ปีการศึกษา <?= esc($val) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Step 2: Select Teacher -->
                    <div class="col-12">
                        <label class="form-section-title"><span class="step-badge">2</span> ครูผู้สอน</label>
                        <select class="form-select SelectTeacher" id="SelectTeacher" name="SelectTeacher" data-placeholder="-- ค้นหาครูผู้สอน --" required>
                            <option value="">เลือกครูผู้สอน</option>
                            <?php foreach ($Teacher as $v_Teacher) :?>
                            <option value="<?= esc($v_Teacher->pers_id) ?>">
                                <?= esc($v_Teacher->pers_prefix.$v_Teacher->pers_firstname.' '.$v_Teacher->pers_lastname) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Step 3: Select Subjects -->
                    <div class="col-12">
                        <label class="form-section-title"><span class="step-badge">3</span> รายวิชา</label>
                        <select class="form-select SelectSubject" id="SelectSubject" name="SelectSubject[]" multiple="multiple" data-placeholder="-- ค้นหารายวิชา (เลือกได้หลายวิชา) --" required>
                            <?php foreach ($Subject as $v_Subject) :?>
                            <option value="<?= esc($v_Subject->SubjectID) ?>">
                                <?= esc($v_Subject->SubjectCode.' '.$v_Subject->SubjectName) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Step 4: Submit -->
                    <div class="col-12 pt-3">
                        <button type="submit" class="btn btn-emerald-premium w-100 BtnAddTeacherSubject py-3">
                            <i class="bx bx-check-circle me-2"></i> ยืนยันการมอบหมายงาน
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Registry Table (Right) -->
        <div class="col-xl-8 col-lg-7">
            <div class="card-table-registry">
                <div class="card-header bg-white py-4 px-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div>
                        <h4 class="mb-1 fw-bold text-dark">รายชื่อการมอบหมายงาน</h4>
                        <p class="text-muted mb-0 small">ตารางแสดงรายการวิชาและครูผู้สอนที่จับคู่แล้ว</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="small fw-bold text-muted">แสดงข้อมูลปี:</span>
                        <select id="onoff_year" class="form-select form-select-sm rounded-pill px-3 shadow-sm" style="width: 140px;">
                            <?php 
                                $years_list = [];
                                foreach ($CheckYearSendPlan as $v) $years_list[] = $v->seplan_term . '/' . $v->seplan_year;
                                if (!in_array($term.'/'.$year, $years_list)) $years_list[] = $term.'/'.$year;
                                usort($years_list, function($a, $b) {
                                    $pa = explode('/', $a); $pb = explode('/', $b);
                                    return ($pa[1] == $pb[1]) ? ($pb[0] - $pa[0]) : ($pb[1] - $pa[1]);
                                });
                                foreach ($years_list as $val):
                            ?>
                            <option <?= ($term.'/'.$year == $val) ? "selected" : ""?> value="<?= esc($val) ?>"><?= esc($val) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-registry mb-0" id="TbSendPlan">
                            <thead>
                                <tr>
                                    <th class="text-center">ปี/เทอม</th>
                                    <th>รหัส/ชื่อวิชา</th>
                                    <th class="text-center">ระดับชั้น</th>
                                    <th>ประเภทวิชา</th>
                                    <th>ครูผู้สอน</th>
                                    <th class="text-center">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Settings -->
<div class="modal fade" id="modalSettings" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: var(--border-radius-lg); overflow: hidden;">
            <form id="FormSettingSendPlan">
                <div class="modal-header bg-label-emerald py-4 px-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-emerald text-white p-2 rounded-3 me-3">
                            <i class="bx bx-calendar-edit fs-4"></i>
                        </div>
                        <h5 class="modal-title fw-bold mb-0">ตั้งค่าปฏิทินการรับแผน</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-soft-emerald border-0 mb-4 d-flex align-items-center">
                        <i class="bx bx-info-circle fs-4 me-2"></i>
                        <small>กำหนดช่วงเวลาที่ครูสามารถอัปโหลดแผนการสอนเข้าสู่ระบบได้</small>
                    </div>
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label fw-bold">วันที่เปิดรับแผน</label>
                            <input type="datetime-local" name="seplanset_startdate" class="form-control rounded-3" value="<?= esc($CheckYear[0]->seplanset_startdate ?? '') ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">วันที่สิ้นสุดการรับแผน</label>
                            <input type="datetime-local" name="seplanset_enddate" class="form-control rounded-3 border-danger-subtle" value="<?= esc($CheckYear[0]->seplanset_enddate ?? '') ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">กำหนดค่าเทอม/ปี หลักของระบบ</label>
                            <div class="row g-2">
                                <div class="col-4">
                                    <select name="seplanset_term" class="form-select rounded-3">
                                        <?php for ($i=1; $i <=3 ; $i++):?>
                                        <option <?= (($CheckYear[0]->seplanset_term ?? 0) == $i) ? 'selected' : ''?> value="<?= esc($i) ?>"><?= esc($i) ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col-8">
                                    <select name="seplanset_year" class="form-select rounded-3">
                                        <?php $d = date("Y")+543; for ($i=$d-1; $i <= $d+1 ; $i++):?>
                                        <option <?= (($CheckYear[0]->seplanset_year ?? 0) == $i) ? 'selected' : ''?> value="<?= esc($i) ?>"><?= esc($i) ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-label-secondary rounded-pill px-4" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-emerald-premium rounded-pill px-4 BtnUpdateSendPlan">บันทึกการตั้งค่า</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Teacher -->
<div class="modal fade" id="editteacher" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: var(--border-radius-lg); overflow: hidden;">
            <form id="FromUpdateTeacher">
                <div class="modal-header bg-label-warning py-4 px-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning text-white p-2 rounded-3 me-3 shadow-sm">
                            <i class="bx bx-user-pin fs-4"></i>
                        </div>
                        <h5 class="modal-title fw-bold mb-0">เปลี่ยนตัวผู้สอน</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="card bg-lighter border-0 mb-4">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge badge-soft-warning">ข้อมูลวิชาปัจจุบัน</span>
                                <span class="badge bg-secondary">ม.<span id="display-grade"></span></span>
                            </div>
                            <h5 class="fw-bold text-dark mb-1" id="display-course-name"></h5>
                            <p class="text-muted small mb-0"><i class="bx bx-barcode me-1"></i>รหัสวิชา: <span id="display-course-code"></span></p>
                        </div>
                        <input type="hidden" id="up_seplan_year" name="up_seplan_year">
                        <input type="hidden" id="up_seplan_term" name="up_seplan_term">
                        <input type="hidden" id="up_seplan_coursecode" name="up_seplan_coursecode">
                        <input type="hidden" id="up_seplan_namesubject" name="up_seplan_namesubject">
                        <input type="hidden" name="up_seplan_gradelevel" id="up_seplan_gradelevel">
                        <input type="hidden" name="up_seplan_typesubject" id="up_seplan_typesubject"> 
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">เลือกครูผู้สอนท่านใหม่</label>
                        <select class="form-select SelectTeacherEdit" id="up_seplan_usersend" name="up_seplan_usersend" style="width: 100%;">
                            <option value="">-- ค้นหาครูผู้สอน --</option>
                            <?php foreach ($Teacher as $v_Teacher): ?>
                            <option value="<?= esc($v_Teacher->pers_id) ?>">
                                <?= esc($v_Teacher->pers_prefix.$v_Teacher->pers_firstname.' '.$v_Teacher->pers_lastname) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-label-secondary rounded-pill px-4" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-warning text-white rounded-pill px-4 shadow-sm fw-bold">ยืนยันการเปลี่ยนแปลง</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Premium Select2 Settings
    function initSelect2() {
        $('.SelectTeacher').select2({
            theme: 'bootstrap-5',
            placeholder: '-- ค้นหาครูผู้สอน --',
            allowClear: true
        });
        $('.SelectSubject').select2({
            theme: 'bootstrap-5',
            placeholder: '-- เลือกรายวิชา (หลายรายการ) --',
            allowClear: true,
            closeOnSelect: false
        });
    }
    
    initSelect2();

    $('#editteacher').on('shown.bs.modal', function () {
        $('.SelectTeacherEdit').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#editteacher')
        });
    });

    // Dynamic Subject Loading
    $('#SelectYear').change(function() {
        const yearTerm = $(this).val();
        const subjectSelect = $('#SelectSubject');
        
        subjectSelect.prop('disabled', true);
        
        $.ajax({
            url: '<?= base_url('admin/academic/course/getSubjectsByYear') ?>',
            type: 'GET',
            data: { yearTerm: yearTerm },
            dataType: 'json',
            success: function(data) {
                subjectSelect.empty();
                if (data && data.length > 0) {
                    data.forEach(function(sub) {
                        subjectSelect.append(new Option(sub.SubjectCode + ' ' + sub.SubjectName, sub.SubjectID));
                    });
                }
                subjectSelect.trigger('change');
            },
            complete: function() {
                subjectSelect.prop('disabled', false);
            }
        });
    });

    // Enhanced Stats Animation
    function updateStats(data) {
        if (!data || !Array.isArray(data)) return;
        const total = data.length;
        const subjects = [...new Set(data.map(item => item.seplan_coursecode))].length;
        const teachers = [...new Set(data.map(item => item.pers_id))].length;
        const basic = data.filter(d => d.seplan_typesubject && d.seplan_typesubject.includes('พื้นฐาน')).length;
        const advanced = data.filter(d => d.seplan_typesubject && d.seplan_typesubject.includes('เพิ่มเติม')).length;

        animateCounter('#stat-total', total);
        animateCounter('#stat-subjects', subjects);
        animateCounter('#stat-teachers', teachers);
        $('#stat-types').text(basic + " / " + advanced);
    }

    function animateCounter(id, target) {
        $({ countNum: $(id).text() }).animate({ countNum: target }, {
            duration: 800,
            easing: 'swing',
            step: function() { $(id).text(Math.floor(this.countNum)); },
            complete: function() { $(id).text(this.countNum); }
        });
    }

    // DataTable Premium Config
    var table = $('#TbSendPlan').DataTable({
        "processing": true,
        "serverSide": false,
        "language": {
            url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/Thai.json"
        },
        "ajax": {
            "url": '<?= base_url('admin/academic/course/getPlansTableData') ?>',
            "type": 'GET',
            "data": function(d) {
                const yearTerm = $('#onoff_year').val();
                if (yearTerm) {
                    const [term, year] = yearTerm.split('/');
                    d.year = year; d.term = term;
                }
            },
            "dataSrc": function(json) {
                updateStats(json);
                return json;
            }
        },
        "columns": [
            {
                "data": null,
                "className": "text-center",
                "render": function(data, type, row) {
                    return '<span class="badge-modern badge-soft-primary font-monospace">'+row.seplan_term+'/'+row.seplan_year+'</span>';
                }
            },
            {
                "data": "seplan_coursecode",
                "render": function(data, type, row) { 
                    return `<div><span class="fw-bold text-dark d-block">${data}</span>
                            <small class="text-muted d-inline-block text-truncate" style="max-width: 180px;">${row.seplan_namesubject}</small></div>`; 
                }
            },
            {
                "data": "seplan_gradelevel",
                "className": "text-center",
                "render": function(data) { return '<span class="badge bg-light text-dark border">ม.'+data+'</span>'; }
            },
            { 
                "data": "seplan_typesubject",
                "render": function(data) { 
                    let cls = data && data.includes('พื้นฐาน') ? 'badge-soft-emerald' : 'badge-soft-warning';
                    return `<span class="badge-modern ${cls}">${data || '-'}</span>`; 
                }
            },
            {
                "data": null,
                "render": function(data, type, row) {
                    const avatarUrl = row.pers_img ? `https://personnel.skj.ac.th/uploads/admin/Personnal/${row.pers_img}` : '<?= base_url("assets/img/avatars/1.png") ?>';
                    return `
                    <div class="teacher-avatar-group">
                        <div class="avatar-wrapper shadow-xs border border-white">
                            <img src="${avatarUrl}" onerror="this.src='<?= base_url('assets/img/avatars/1.png') ?>'" alt="Avatar">
                        </div>
                        <div>
                            <span class="d-block fw-bold small text-dark">${row.pers_prefix}${row.pers_firstname} ${row.pers_lastname}</span>
                            <span class="text-muted" style="font-size: 10px;">ID: ${row.pers_id}</span>
                        </div>
                    </div>`;
                }
            },
            {
                "data": null,
                "className": "text-center",
                "render": function(data, type, row) {
                    return `
                    <div class="d-flex justify-content-center gap-1">
                        <button type="button" class="btn btn-icon btn-sm btn-label-warning EditTeach hover-scale" 
                            PlanCode="${row.seplan_coursecode}" PlanYear="${row.seplan_year}" PlanTerm="${row.seplan_term}" PlanTeacherID="${row.pers_id}">
                            <i class="bx bx-edit-alt"></i>
                        </button>
                        <button type="button" class="btn btn-icon btn-sm btn-label-danger DeleteTeach hover-scale"
                            delplancode="${row.seplan_coursecode}" delplanyear="${row.seplan_year}" delplanterm="${row.seplan_term}" 
                            delplanteacherid="${row.pers_id}" delplanname="${row.seplan_namesubject}">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>`;
                }
            }
        ]
    });

    $('#onoff_year').change(function() { table.ajax.reload(); });

    // Submit Handling with SweetAlert Premium
    $('#FormSettingSendPlan').submit(function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'บันทึกการตั้งค่า?',
            text: "ระบบจะใช้ข้อมูลนี้เป็นช่วงเวลาหลักในการรับแผนการสอน",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#15a362',
            confirmButtonText: 'บันทึกข้อมูล'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('admin/academic/course/update_setting') ?>',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if(response.status === 'success') {
                            Swal.fire({icon: 'success', title: 'สำเร็จ!', text: response.message, timer: 1500, showConfirmButton: false});
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            Swal.fire('ผิดพลาด!', response.message, 'error');
                        }
                    }
                });
            }
        });
    });

    $('#FormUpdateSendPlan').submit(function(e) {
        e.preventDefault();
        const submitBtn = $('.BtnAddTeacherSubject');
        submitBtn.prop('disabled', true).html('<span class="spinner-grow spinner-grow-sm me-1"></span> กำลังบันทึก...');
        
        $.ajax({
            url: '<?= base_url('admin/academic/course/add_teacher_subject') ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'มอบหมายงานสำเร็จ',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000,
                        toast: true,
                        position: 'top-end'
                    });
                    table.ajax.reload();
                    $('#SelectSubject').val(null).trigger('change');
                } else {
                    Swal.fire('แจ้งเตือน!', response.message, 'warning');
                }
            },
            complete: function() { 
                submitBtn.prop('disabled', false).html('<i class="bx bx-check-circle me-2"></i> ยืนยันการมอบหมายงาน'); 
            }
        });
    });

    $(document).on('click', '.EditTeach', function(e) {
        e.preventDefault();
        var params = {
            plan_code: $(this).attr('PlanCode'),
            plan_year: $(this).attr('PlanYear'),
            plan_term: $(this).attr('PlanTerm'),
            plan_teacher_id: $(this).attr('PlanTeacherID')
        };
        $.ajax({
            url: '<?= base_url('admin/academic/course/get_plan_details') ?>',
            type: 'GET',
            data: params,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success' && response.data) {
                    var data = response.data;
                    $('#display-course-name').text(data.seplan_namesubject);
                    $('#display-course-code').text(data.seplan_coursecode);
                    $('#display-grade').text(data.seplan_gradelevel);
                    $('#up_seplan_year').val(data.seplan_year);
                    $('#up_seplan_term').val(data.seplan_term);
                    $('#up_seplan_coursecode').val(data.seplan_coursecode);
                    $('#up_seplan_namesubject').val(data.seplan_namesubject);
                    $('#up_seplan_gradelevel').val(data.seplan_gradelevel);
                    $('#up_seplan_typesubject').val(data.seplan_typesubject);
                    $('#up_seplan_usersend').val(data.seplan_usersend).trigger('change');
                    $('#editteacher').modal('show');
                }
            }
        });
    });

    $('#FromUpdateTeacher').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?= base_url('admin/academic/course/update_teacher') ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#editteacher').modal('hide');
                    Swal.fire({
                        icon: 'success', 
                        title: 'แก้ไขสำเร็จ', 
                        text: response.message,
                        timer: 1500, 
                        showConfirmButton: false, 
                        toast: true, 
                        position: 'top-end'
                    });
                    table.ajax.reload();
                } else {
                    Swal.fire('แจ้งเตือน!', response.message, 'warning');
                }
            }
        });
    });

    $(document).on('click', '.DeleteTeach', function(e) {
        e.preventDefault();
        var delData = {
            plan_code: $(this).attr('delplancode'),
            plan_year: $(this).attr('delplanyear'),
            plan_term: $(this).attr('delplanterm'),
            plan_teacher_id: $(this).attr('delplanteacherid')
        };
        Swal.fire({
            title: 'ต้องการลบข้อมูลนี้?',
            text: `วิชา "${$(this).attr('delplanname')}" จะถูกลบออกจากรายการมอบหมายงาน`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff3e1d',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'ใช่, ฉันต้องการลบ',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('<?= base_url('admin/academic/course/delete_teacher_subject') ?>', delData, function(res) {
                    Swal.fire({icon: 'success', title: 'ลบสำเร็จ', timer: 1000, showConfirmButton: false, toast: true, position: 'top-end'});
                    table.ajax.reload();
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>