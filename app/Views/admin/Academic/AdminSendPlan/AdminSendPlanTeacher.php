<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>

<style>
    :root {
        --primary-emerald: #15a362;
        --dark-emerald: #0d6d41;
        --light-emerald: #e8f5ee;
        --border-radius: 16px;
    }

    /* Hero Header */
    .hero-management {
        background: linear-gradient(135deg, var(--primary-emerald) 0%, var(--dark-emerald) 100%);
        border-radius: var(--border-radius);
        padding: 2rem 2.5rem;
        color: white;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(21, 163, 98, 0.15);
    }

    .hero-management::after {
        content: '';
        position: absolute;
        bottom: -20%;
        right: -5%;
        width: 300px; height: 300px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        pointer-events: none;
    }

    /* Stats Card Premium */
    .stat-card-premium {
        border: none;
        border-radius: var(--border-radius);
        background: white;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        height: 100%;
        border-bottom: 4px solid transparent;
    }

    .stat-card-premium:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }

    .stat-card-primary { border-bottom-color: #696cff; }
    .stat-card-success { border-bottom-color: var(--primary-emerald); }
    .stat-card-info { border-bottom-color: #03c3ec; }
    .stat-card-warning { border-bottom-color: #ffab00; }

    .stat-icon-premium {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    /* Table Styling */
    .table-premium thead th {
        background-color: #f8f9fa;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #566a7f;
        padding: 1rem;
        border-top: none;
    }

    .btn-emerald {
        background-color: var(--primary-emerald);
        border-color: var(--primary-emerald);
        color: white;
    }
    .btn-emerald:hover {
        background-color: var(--dark-emerald);
        border-color: var(--dark-emerald);
        color: white;
    }
    .btn-outline-emerald {
        color: var(--primary-emerald);
        border-color: var(--primary-emerald);
    }
    .btn-outline-emerald:hover {
        background-color: var(--primary-emerald);
        color: white;
    }

    .text-emerald { color: var(--primary-emerald) !important; }
    .bg-light-emerald { background-color: var(--light-emerald) !important; }

    .modal-emerald-header {
        background: linear-gradient(135deg, var(--primary-emerald) 0%, var(--dark-emerald) 100%);
        border: none;
    }

    /* Select2 Emerald */
    .select2-container--bootstrap-5 .select2-selection {
        border-radius: 10px;
    }
    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        color: #566a7f;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y animate__animated animate__fadeIn">
    <!-- Hero Header -->
    <div class="hero-management">
        <div class="row align-items-center">
            <div class="col-md-7">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="<?= site_url('Admin/Home') ?>" class="text-white opacity-75">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">จัดการแผนการสอน</li>
                    </ol>
                </nav>
                <h2 class="fw-bold mb-1 text-white">จัดการข้อมูลการส่งแผนการสอน</h2>
                <div class="d-flex align-items-center mt-2">
                    <span class="badge bg-white text-emerald px-3 py-2 rounded-pill fw-bold">
                        ปีการศึกษา: <?= isset($CheckYear[0]->seplanset_term) ? $CheckYear[0]->seplanset_term.'/'.$CheckYear[0]->seplanset_year : '-' ?>
                    </span>
                    <small class="ms-3 text-white opacity-75">
                        <i class="bx bx-time-five me-1"></i> 
                        เปิดรับ: <?= isset($CheckYear[0]->seplanset_startdate) ? date('d/m/', strtotime($CheckYear[0]->seplanset_startdate)) . (date('Y', strtotime($CheckYear[0]->seplanset_startdate)) + 543) : '-' ?>
                    </small>
                </div>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                <button class="btn btn-outline-white text-white fw-bold px-4 py-2 me-2 shadow-sm border-2" data-bs-toggle="modal" data-bs-target="#modalSettings">
                    <i class="bx bx-cog me-1"></i> ตั้งค่าปฏิทิน
                </button>
                <button class="btn btn-white text-emerald fw-bold px-4 py-2 shadow-sm border-0 animate__animated animate__pulse animate__infinite" data-bs-toggle="collapse" data-bs-target="#collapseAddPair">
                    <i class="bx bx-link-alt me-1"></i> จับคู่ครู-รายวิชา
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card-premium stat-card-primary p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-0 fw-bold text-primary" id="stat-total">0</h4>
                        <p class="text-muted mb-0 small uppercase fw-semibold">รายการทั้งหมด</p>
                    </div>
                    <div class="stat-icon-premium bg-label-primary">
                        <i class="bx bx-list-ul"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card-premium stat-card-success p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-0 fw-bold text-success" id="stat-subjects">0</h4>
                        <p class="text-muted mb-0 small uppercase fw-semibold">รายวิชาที่เปิดสอน</p>
                    </div>
                    <div class="stat-icon-premium bg-label-success">
                        <i class="bx bx-book"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card-premium stat-card-info p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-0 fw-bold text-info" id="stat-teachers">0</h4>
                        <p class="text-muted mb-0 small uppercase fw-semibold">ครูผู้สอน</p>
                    </div>
                    <div class="stat-icon-premium bg-label-info">
                        <i class="bx bx-user-voice"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card-premium stat-card-warning p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-0 fw-bold text-warning" id="stat-types">-</h4>
                        <p class="text-muted mb-0 small uppercase fw-semibold">พื้นฐาน / เพิ่มเติม</p>
                    </div>
                    <div class="stat-icon-premium bg-label-warning">
                        <i class="bx bx-pie-chart-alt-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pair Form -->
    <div class="collapse mb-4" id="collapseAddPair">
        <div class="card border-0 shadow-sm" style="border-radius: 20px;">
            <div class="card-header bg-label-success py-3 d-flex align-items-center">
                <i class="bx bx-link me-2"></i>
                <h5 class="card-title mb-0 fw-bold">จับคู่ครูผู้สอนและรายวิชา</h5>
            </div>
            <div class="card-body p-4">
                <form id="FormUpdateSendPlan" class="row g-4">
                    <div class="col-md-3">
                        <label for="SelectYear" class="form-label fw-bold">ปีการศึกษา / ภาคเรียน</label>
                        <select name="SelectYear" id="SelectYear" class="form-select rounded-3">
                            <?php 
                                $all_years = [];
                                foreach ($CheckYearSendPlan as $v) {
                                    $all_years[] = $v->seplan_term . '/' . $v->seplan_year;
                                }

                                // Calculate Next Term
                                if (!empty($all_years)) {
                                    // Get the latest one by sorting
                                    usort($all_years, function($a, $b) {
                                        $pa = explode('/', $a); $pb = explode('/', $b);
                                        return ($pa[1] == $pb[1]) ? ($pa[0] - $pb[0]) : ($pa[1] - $pb[1]);
                                    });
                                    $latest = end($all_years);
                                    list($l_term, $l_year) = explode('/', $latest);
                                    
                                    if ($l_term == 1) {
                                        $next_val = "2/" . $l_year;
                                    } else {
                                        $next_val = "1/" . ($l_year + 1);
                                    }
                                    
                                    if (!in_array($next_val, $all_years)) {
                                        $all_years[] = $next_val;
                                    }
                                }
                                
                                // Display all unique years
                                foreach ($all_years as $val):
                                    $isSelected = (isset($term) && isset($year) && $term.'/'.$year == $val) ? "selected" : "";
                            ?>
                                <option value="<?= esc($val) ?>" <?= $isSelected ?>>ปีการศึกษา <?= esc($val) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="SelectSubject" class="form-label fw-bold">เลือกรายวิชา</label>
                        <select class="form-select SelectSubject" id="SelectSubject" name="SelectSubject" data-placeholder="-- ค้นหารายวิชา --" required>
                            <option value="">เลือกวิชาที่สอน</option>
                            <?php foreach ($Subject as $key => $v_Subject) :?>
                            <option value="<?= isset($v_Subject->SubjectID) ? esc($v_Subject->SubjectID) : '' ?>">
                                <?= (isset($v_Subject->SubjectCode) ? esc($v_Subject->SubjectCode) : '').' '.(isset($v_Subject->SubjectName) ? esc($v_Subject->SubjectName) : '') ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="SelectTeacher" class="form-label fw-bold">เลือกครูผู้สอน</label>
                        <select class="form-select SelectTeacher" id="SelectTeacher" name="SelectTeacher" data-placeholder="-- ค้นหาครู --" required>
                            <option value="">เลือกครูผู้สอน</option>
                            <?php foreach ($Teacher as $key => $v_Teacher) :?>
                            <option value="<?= isset($v_Teacher->pers_id) ? esc($v_Teacher->pers_id) : '' ?>">
                                <?= (isset($v_Teacher->pers_prefix) ? esc($v_Teacher->pers_prefix) : '').(isset($v_Teacher->pers_firstname) ? esc($v_Teacher->pers_firstname) : '').' '.(isset($v_Teacher->pers_lastname) ? esc($v_Teacher->pers_lastname) : '') ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-emerald w-100 BtnAddTeacherSubject py-2 rounded-3 shadow-sm fw-bold">
                            <i class="bx bx-save me-1"></i> บันทึกการจับคู่
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
        <div class="card-header bg-white py-4 px-4 d-flex justify-content-between align-items-center border-bottom">
            <h5 class="card-title mb-0 fw-bold">
                <i class="bx bx-table me-2 text-emerald"></i>รายการจับคู่การสอนปีปัจจุบัน
            </h5>
            <div class="d-flex align-items-center gap-2">
                <label class="mb-0 small fw-bold text-muted">ภาคเรียน/ปี:</label>
                <select name="onoff_year" id="onoff_year" class="form-select form-select-sm rounded-pill px-3" style="width: 150px; background-color: #f8f9fa;">
                    <?php foreach ($CheckYearSendPlan as $key => $value):?>
                    <option <?= (isset($term) && isset($year) && isset($value->seplan_term) && isset($value->seplan_year) && $term.'/'.$year == $value->seplan_term.'/'.$value->seplan_year) ? "selected" : ""?>
                        value="<?= (isset($value->seplan_term) ? esc($value->seplan_term) : '').'/'.(isset($value->seplan_year) ? esc($value->seplan_year) : '') ?>">
                        <?= (isset($value->seplan_term) ? esc($value->seplan_term) : '').'/'.(isset($value->seplan_year) ? esc($value->seplan_year) : '') ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-premium mb-0" id="TbSendPlan">
                    <thead>
                        <tr>
                            <th class="text-center">ปีการศึกษา</th>
                            <th>รหัสวิชา</th>
                            <th>ชื่อวิชา</th>
                            <th class="text-center">ระดับ</th>
                            <th>ประเภท</th>
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

<!-- Modal Settings -->
<div class="modal fade" id="modalSettings" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <form id="FormSettingSendPlan">
                <div class="modal-header modal-emerald-header">
                    <h5 class="modal-title text-white fw-bold"><i class="bx bx-calendar-edit me-2"></i>ตั้งค่าระยะเวลารับแผน</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label fw-bold">วันที่เปิดรับแผน</label>
                            <input type="datetime-local" name="seplanset_startdate" class="form-control rounded-3" value="<?= isset($CheckYear[0]->seplanset_startdate) ? esc($CheckYear[0]->seplanset_startdate) : '' ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">วันที่ปิดรับแผน</label>
                            <input type="datetime-local" name="seplanset_enddate" class="form-control rounded-3 border-danger-subtle" value="<?= isset($CheckYear[0]->seplanset_enddate) ? esc($CheckYear[0]->seplanset_enddate) : '' ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">กำหนดเทอม/ปี (ระบบจัดเก็บหลัก)</label>
                            <div class="row g-2">
                                <div class="col-4">
                                    <select name="seplanset_term" class="form-select rounded-3">
                                        <?php for ($i=1; $i <=3 ; $i++):?>
                                        <option <?= (isset($CheckYear[0]->seplanset_term) && $CheckYear[0]->seplanset_term == $i) ? 'selected' : ''?> value="<?= esc($i) ?>"><?= esc($i) ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col-8">
                                    <select name="seplanset_year" class="form-select rounded-3">
                                        <?php $d = date("Y")+543; for ($i=$d-1; $i <= $d+1 ; $i++):?>
                                        <option <?= (isset($CheckYear[0]->seplanset_year) && $CheckYear[0]->seplanset_year == $i) ? 'selected' : ''?> value="<?= esc($i) ?>"><?= esc($i) ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-label-secondary rounded-pill px-4" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-emerald rounded-pill px-4 BtnUpdateSendPlan shadow-sm">บันทึกตั้งค่า</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Teacher -->
<div class="modal fade" id="editteacher" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <form id="FromUpdateTeacher">
                <div class="modal-header bg-label-warning border-0">
                    <h5 class="modal-title fw-bold">
                        <div class="stat-icon-premium bg-warning text-white d-inline-flex me-2 shadow-sm" style="width: 32px; height: 32px; font-size: 1rem;">
                            <i class="bx bx-user-pin"></i>
                        </div>
                        เปลี่ยนตัวผู้สอน
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="bg-light p-3 rounded-3 mb-4">
                        <div class="row g-2">
                             <div class="col-12"><small class="text-muted fw-bold">รายวิชา:</small> <span class="fw-bold text-dark" id="display-course-name"></span></div>
                             <div class="col-12"><small class="text-muted fw-bold">รหัส/ชั้น:</small> <span id="display-course-code"></span> <span class="badge bg-secondary ms-1">ม.<span id="display-grade"></span></span></div>
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
                            <option value="">-- ค้นหาครู --</option>
                            <?php foreach ($Teacher as $key => $v_Teacher): ?>
                            <option value="<?= isset($v_Teacher->pers_id) ? esc($v_Teacher->pers_id) : '' ?>">
                                <?= (isset($v_Teacher->pers_prefix) ? esc($v_Teacher->pers_prefix) : '').(isset($v_Teacher->pers_firstname) ? esc($v_Teacher->pers_firstname) : '').' '.(isset($v_Teacher->pers_lastname) ? esc($v_Teacher->pers_lastname) : '') ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-label-secondary rounded-pill px-4" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-warning text-white rounded-pill px-4 BtnUpdateTeacher shadow-sm">ยืนยันการเปลี่ยน</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Select2 Init
    $('.SelectSubject, .SelectTeacher').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#collapseAddPair')
    });
    
    $('#editteacher').on('shown.bs.modal', function () {
        $('.SelectTeacherEdit').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#editteacher')
        });
    });

    // Update Stats
    function updateStats(data) {
        if (!data || !Array.isArray(data)) return;
        const total = data.length;
        const subjects = [...new Set(data.map(item => item.seplan_coursecode))].length;
        const teachers = [...new Set(data.map(item => item.pers_id))].length;
        
        const basic = data.filter(d => d.seplan_typesubject && d.seplan_typesubject.includes('พื้นฐาน')).length;
        const advanced = data.filter(d => d.seplan_typesubject && d.seplan_typesubject.includes('เพิ่มเติม')).length;

        $('#stat-total').fadeOut(150, function() { $(this).text(total).fadeIn(150); });
        $('#stat-subjects').fadeOut(150, function() { $(this).text(subjects).fadeIn(150); });
        $('#stat-teachers').fadeOut(150, function() { $(this).text(teachers).fadeIn(150); });
        $('#stat-types').fadeOut(150, function() { $(this).text(basic + " / " + advanced).fadeIn(150); });
    }

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
                    d.year = year;
                    d.term = term;
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
                    return '<span class="badge bg-label-secondary font-monospace">'+row.seplan_term+'/'+row.seplan_year+'</span>';
                }
            },
            {
                "data": "seplan_coursecode",
                "render": function(data) { return '<span class="fw-bold text-dark">'+data+'</span>'; }
            },
            { 
               "data": "seplan_namesubject",
               "render": function(data) { return '<div class="text-truncate" style="max-width: 250px;" title="'+data+'">'+data+'</div>'; }
            },
            {
                "data": "seplan_gradelevel",
                "className": "text-center",
                "render": function(data) { return '<span class="badge bg-light text-dark shadow-xs border">ม.'+data+'</span>'; }
            },
            { 
                "data": "seplan_typesubject",
                "render": function(data) { return '<small class="fw-semibold text-muted">'+(data || '-')+'</small>'; }
            },
            {
                "data": null,
                "render": function(data, type, row) {
                    return `
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xs me-2"><span class="avatar-initial rounded-circle bg-label-success"><i class="bx bx-user" style="font-size: 10px;"></i></span></div>
                        <span class="small fw-bold">${row.pers_prefix}${row.pers_firstname} ${row.pers_lastname}</span>
                    </div>`;
                }
            },
            {
                "data": null,
                "className": "text-center",
                "render": function(data, type, row) {
                    return `
                    <div class="d-flex justify-content-center gap-1">
                        <button type="button" class="btn btn-icon btn-sm btn-label-warning EditTeach" 
                            PlanCode="${row.seplan_coursecode}" PlanYear="${row.seplan_year}" PlanTerm="${row.seplan_term}" PlanTeacherID="${row.pers_id}">
                            <i class="bx bx-edit-alt"></i>
                        </button>
                        <button type="button" class="btn btn-icon btn-sm btn-label-danger DeleteTeach"
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

    $('#FormSettingSendPlan').submit(function(e) {
        e.preventDefault();
        var submitBtn = $('.BtnUpdateSendPlan');
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> กำลังบันทึก...');
        $.ajax({
            url: '<?= base_url('admin/academic/course/update_setting') ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success') {
                    Swal.fire({icon: 'success', title: 'สำเร็จ!', text: response.message, timer: 2000, showConfirmButton: false});
                    setTimeout(() => location.reload(), 2000);
                } else {
                    Swal.fire('ผิดพลาด!', response.message, 'error');
                }
            },
            error: function() { Swal.fire('ผิดพลาด!', 'Server Error', 'error'); },
            complete: function() { submitBtn.prop('disabled', false).text('บันทึกตั้งค่า'); }
        });
    });

    $('#FormUpdateSendPlan').submit(function(e) {
        e.preventDefault();
        var submitBtn = $('.BtnAddTeacherSubject');
        submitBtn.prop('disabled', true).html('<span class="spinner-grow spinner-grow-sm me-1"></span>...');
        $.ajax({
            url: '<?= base_url('admin/academic/course/add_teacher_subject') ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({icon: 'success', title: 'เพิ่มข้อมูลเรียบร้อย', timer: 1000, showConfirmButton: false});
                    table.ajax.reload();
                    $('#SelectSubject, #SelectTeacher').val('').trigger('change');
                } else {
                    Swal.fire('ผิดพลาด!', response.message, 'error');
                }
            },
            complete: function() { submitBtn.prop('disabled', false).html('<i class="bx bx-plus me-1"></i> เพิ่มข้อมูล'); }
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
                if(response){
                     $('#editteacher').modal('hide');
                     Swal.fire({icon: 'success', title: 'แก้ไขสำเร็จ', timer: 1000, showConfirmButton: false});
                     table.ajax.reload();
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
            title: 'ยืนยันการลบ?',
            text: `ต้องการลบข้อมูลวิชา "${$(this).attr('delplanname')}" ใช่หรือไม่?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff3e1d',
            confirmButtonText: 'ลบข้อมูล'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('<?= base_url('admin/academic/course/delete_teacher_subject') ?>', delData, function(res) {
                    Swal.fire({icon: 'success', title: 'ลบสำเร็จ', timer: 1000, showConfirmButton: false});
                    table.ajax.reload();
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>