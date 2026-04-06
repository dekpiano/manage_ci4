<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
.stat-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}
.stat-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    font-size: 1.5rem;
}
.stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    line-height: 1.2;
}
.stat-label {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 4px;
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Page Header -->
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">งานวิชาการ /</span> จัดการแผนการสอน
            </h4>
            <p class="text-muted mb-0">ปีการศึกษา: <strong id="headerYear"><?= isset($CheckYear[0]->seplanset_term) ? $CheckYear[0]->seplanset_term.'/'.$CheckYear[0]->seplanset_year : '-' ?></strong></p>
            <small class="text-primary"><i class="bx bx-calendar-event me-1"></i> 
                <?= isset($CheckYear[0]->seplanset_startdate) ? date('d/m/', strtotime($CheckYear[0]->seplanset_startdate)) . (date('Y', strtotime($CheckYear[0]->seplanset_startdate)) + 543) . date(' H:i', strtotime($CheckYear[0]->seplanset_startdate)) : '-' ?> 
                ถึง 
                <?= isset($CheckYear[0]->seplanset_enddate) ? date('d/m/', strtotime($CheckYear[0]->seplanset_enddate)) . (date('Y', strtotime($CheckYear[0]->seplanset_enddate)) + 543) . date(' H:i', strtotime($CheckYear[0]->seplanset_enddate)) : '-' ?>
            </small>
        </div>
        <div class="col-auto">
            <div class="d-flex gap-2">
                <button class="btn btn-label-primary" data-bs-toggle="modal" data-bs-target="#modalSettings">
                    <i class="bx bx-cog me-1"></i> ตั้งค่าระบบ
                </button>
                <button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseAddPair" aria-expanded="false" aria-controls="collapseAddPair">
                    <i class="bx bx-plus-circle me-1"></i> เพิ่มการจับคู่ครู-วิชา
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Plans -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-primary" id="stat-total">0</div>
                            <div class="stat-label">รายการทั้งหมด</div>
                        </div>
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bx bx-list-ul"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subjects -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-success" id="stat-subjects">0</div>
                            <div class="stat-label">รายวิชาที่เปิด</div>
                        </div>
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="bx bx-book"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teachers -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-info" id="stat-teachers">0</div>
                            <div class="stat-label">ครูผู้สอน</div>
                        </div>
                        <div class="stat-icon bg-info bg-opacity-10 text-info">
                            <i class="bx bx-user-voice"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Basic/Advanced Ratio -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-warning" id="stat-types">-</div>
                            <div class="stat-label">พื้นฐาน / เพิ่มเติม</div>
                        </div>
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bx bx-pie-chart-alt-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Collapse Add Form -->
    <div class="collapse mb-4" id="collapseAddPair">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="card-title mb-0 text-white"><i class="bx bx-link me-2"></i>จับคู่ครูผู้สอนกับรายวิชา</h5>
            </div>
            <div class="card-body mt-4">
                <form id="FormUpdateSendPlan" class="row g-3">
                    <div class="col-md-5">
                        <label for="SelectSubject" class="form-label fw-bold">เลือกรายวิชา</label>
                        <select class="form-select SelectSubject" id="SelectSubject" name="SelectSubject" data-placeholder="-- พิมพ์ชื่อวิชา หรือ รหัสวิชา --" required>
                            <option value="">เลือกวิชาที่สอน</option>
                            <?php foreach ($Subject as $key => $v_Subject) :?>
                            <option value="<?= isset($v_Subject->SubjectID) ? esc($v_Subject->SubjectID) : '' ?>">
                                <?= (isset($v_Subject->SubjectCode) ? esc($v_Subject->SubjectCode) : '').' '.(isset($v_Subject->SubjectName) ? esc($v_Subject->SubjectName) : '') ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="SelectTeacher" class="form-label fw-bold">เลือกครูผู้สอน</label>
                        <select class="form-select SelectTeacher" id="SelectTeacher" name="SelectTeacher" data-placeholder="-- พิมพ์ชื่อครู --" required>
                            <option value="">เลือกครูผู้สอน</option>
                            <?php foreach ($Teacher as $key => $v_Teacher) :?>
                            <option value="<?= isset($v_Teacher->pers_id) ? esc($v_Teacher->pers_id) : '' ?>">
                                <?= (isset($v_Teacher->pers_prefix) ? esc($v_Teacher->pers_prefix) : '').(isset($v_Teacher->pers_firstname) ? esc($v_Teacher->pers_firstname) : '').' '.(isset($v_Teacher->pers_lastname) ? esc($v_Teacher->pers_lastname) : '') ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 BtnAddTeacherSubject py-2">
                            <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>
                            <i class="bx bx-plus me-1"></i> เพิ่มข้อมูล
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-list-ul me-2"></i>รายการจับคู่การสอน
                    </h5>
                </div>
                <div class="col-auto">
                    <div class="d-flex align-items-center gap-2">
                        <label for="onoff_year" class="form-label mb-0 fw-medium text-nowrap">ปีการศึกษา:</label>
                        <select name="onoff_year" id="onoff_year" class="form-select form-select-sm" style="min-width: 140px;">
                            <?php foreach ($CheckYearSendPlan as $key => $value):?>
                            <option <?= (isset($term) && isset($year) && isset($value->seplan_term) && isset($value->seplan_year) && $term.'/'.$year == $value->seplan_term.'/'.$value->seplan_year) ? "selected" : ""?>
                                value="<?= (isset($value->seplan_term) ? esc($value->seplan_term) : '').'/'.(isset($value->seplan_year) ? esc($value->seplan_year) : '') ?>">
                                <?= (isset($value->seplan_term) ? esc($value->seplan_term) : '').'/'.(isset($value->seplan_year) ? esc($value->seplan_year) : '') ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="TbSendPlan">
                    <thead class="table-light">
                        <tr>
                            <th class="cell">ปีการศึกษา</th>
                            <th class="cell">รหัสวิชา</th>
                            <th class="cell">ชื่อวิชา</th>
                            <th class="cell">ระดับชั้น</th>
                            <th class="cell">ประเภท</th>
                            <th class="cell">ครูผู้สอน</th>
                            <th class="cell text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Settings -->
<div class="modal fade" id="modalSettings" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="FormSettingSendPlan">
                <div class="modal-header bg-label-primary">
                    <h5 class="modal-title"><i class="bx bx-cog me-2"></i>ตั้งค่าระบบส่งแผน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold">ช่วงเวลาเปิดระบบ</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                <input type="datetime-local" name="seplanset_startdate" class="form-control" value="<?= isset($CheckYear[0]->seplanset_startdate) ? esc($CheckYear[0]->seplanset_startdate) : '' ?>">
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">ช่วงเวลาปิดระบบ</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-calendar-x"></i></span>
                                <input type="datetime-local" name="seplanset_enddate" class="form-control" value="<?= isset($CheckYear[0]->seplanset_enddate) ? esc($CheckYear[0]->seplanset_enddate) : '' ?>">
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">ปีการศึกษาปัจจุบันของระบบ</label>
                            <div class="row g-2">
                                <div class="col-4">
                                    <select name="seplanset_term" class="form-select">
                                        <?php for ($i=1; $i <=3 ; $i++):?>
                                        <option <?= (isset($CheckYear[0]->seplanset_term) && $CheckYear[0]->seplanset_term == $i) ? 'selected' : ''?> value="<?= esc($i) ?>"><?= esc($i) ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col-8">
                                    <select name="seplanset_year" class="form-select">
                                        <?php $d = date("Y")+543; for ($i=$d-1; $i <= $d+1 ; $i++):?>
                                        <option <?= (isset($CheckYear[0]->seplanset_year) && $CheckYear[0]->seplanset_year == $i) ? 'selected' : ''?> value="<?= esc($i) ?>"><?= esc($i) ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary BtnUpdateSendPlan">
                        <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span> บันทึกการตั้งค่า
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Teacher -->
<div class="modal fade" id="editteacher" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="FromUpdateTeacher">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white"><i class="bx bx-edit me-2"></i>แก้ไขข้อมูล</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-bold">ปีการศึกษา</label>
                            <input readonly type="text" class="form-control" id="up_seplan_year" name="up_seplan_year">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">ภาคเรียน</label>
                            <input readonly type="text" class="form-control" id="up_seplan_term" name="up_seplan_term">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">รหัสวิชา</label>
                            <input readonly type="text" class="form-control" id="up_seplan_coursecode" name="up_seplan_coursecode">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">ชื่อวิชา</label>
                            <input readonly type="text" class="form-control bg-light" id="up_seplan_namesubject" name="up_seplan_namesubject">
                        </div>
                        <div class="col-6">
                             <input type="hidden" name="up_seplan_gradelevel" id="up_seplan_gradelevel">
                             <input type="hidden" name="up_seplan_typesubject" id="up_seplan_typesubject"> 
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">เปลี่ยนครูผู้สอน</label>
                            <select class="form-select SelectTeacherEdit" id="up_seplan_usersend" name="up_seplan_usersend" style="width: 100%;">
                                <option value="">เลือกครูผู้สอน</option>
                                <?php foreach ($Teacher as $key => $v_Teacher): ?>
                                <option value="<?= isset($v_Teacher->pers_id) ? esc($v_Teacher->pers_id) : '' ?>">
                                    <?= (isset($v_Teacher->pers_prefix) ? esc($v_Teacher->pers_prefix) : '').(isset($v_Teacher->pers_firstname) ? esc($v_Teacher->pers_firstname) : '').' '.(isset($v_Teacher->pers_lastname) ? esc($v_Teacher->pers_lastname) : '') ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-warning BtnUpdateTeacher text-white">
                        <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span> แก้ไขข้อมูล
                    </button>
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
    
    // Select2 in Modal needs specific dropdownParent
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
                "render": function(data, type, row) {
                    return '<span class="badge bg-label-primary">'+row.seplan_term+'/'+row.seplan_year+'</span>';
                }
            },
            {
                "data": "seplan_coursecode",
                "render": function(data) { return '<span class="fw-bold text-dark">'+data+'</span>'; }
            },
            { "data": "seplan_namesubject" },
            {
                "data": "seplan_gradelevel",
                "render": function(data) { return '<span class="badge bg-label-info">ม.'+data+'</span>'; }
            },
            { "data": "seplan_typesubject" },
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<i class="bx bx-user me-1 text-muted"></i>' + row.pers_prefix + row.pers_firstname + ' ' + row.pers_lastname;
                }
            },
            {
                "data": null,
                "className": "text-center",
                "render": function(data, type, row) {
                    return `
                    <div class="dropdown">
                        <button type="button" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item EditTeach" href="#" 
                                PlanCode="${row.seplan_coursecode}" PlanYear="${row.seplan_year}" PlanTerm="${row.seplan_term}" PlanTeacherID="${row.pers_id}">
                                <i class="bx bx-edit-alt me-2 text-warning"></i>แก้ไข
                            </a>
                            <a class="dropdown-item DeleteTeach" href="javascript:void(0)"
                                delplancode="${row.seplan_coursecode}" delplanyear="${row.seplan_year}" delplanterm="${row.seplan_term}" 
                                delplanteacherid="${row.pers_id}" delplanname="${row.seplan_namesubject}">
                                <i class="bx bx-trash me-2 text-danger"></i>ลบ
                            </a>
                        </div>
                    </div>`;
                }
            }
        ]
    });

    // Form Submissions and Event Handlers (Logic kept from original file)
    $('#onoff_year').change(function() { table.ajax.reload(); });

    $('#FormSettingSendPlan').submit(function(e) {
        e.preventDefault();
        var submitBtn = $('.BtnUpdateSendPlan');
        submitBtn.prop('disabled', true).find('.spinner-border').removeClass('d-none');
        $.ajax({
            url: '<?= base_url('admin/academic/course/update_setting') ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                response.status === 'success' ? Swal.fire('สำเร็จ!', response.message, 'success') : Swal.fire('ผิดพลาด!', response.message, 'error');
                $('#modalSettings').modal('hide');
                // Optional: Reload page to update header year if needed
             },
            error: function() { Swal.fire('ผิดพลาด!', 'Server Error', 'error'); },
            complete: function() { submitBtn.prop('disabled', false).find('.spinner-border').addClass('d-none'); }
        });
    });

    $('#FormUpdateSendPlan').submit(function(e) {
        e.preventDefault();
        var submitBtn = $('.BtnAddTeacherSubject');
        submitBtn.prop('disabled', true).find('.spinner-border').removeClass('d-none');
        $.ajax({
            url: '<?= base_url('admin/academic/course/add_teacher_subject') ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire('สำเร็จ!', response.message, 'success');
                    table.ajax.reload();
                    $('#SelectSubject, #SelectTeacher').val('').trigger('change'); // Reset Form
                } else {
                    Swal.fire('ผิดพลาด!', response.message, 'error');
                }
            },
            error: function() { Swal.fire('ผิดพลาด!', 'Server Error', 'error'); },
            complete: function() { submitBtn.prop('disabled', false).find('.spinner-border').addClass('d-none'); }
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
                    $('#up_seplan_year').val(data.seplan_year);
                    $('#up_seplan_term').val(data.seplan_term);
                    $('#up_seplan_coursecode').val(data.seplan_coursecode);
                    $('#up_seplan_namesubject').val(data.seplan_namesubject);
                    $('#up_seplan_gradelevel').val(data.seplan_gradelevel);
                    $('#up_seplan_typesubject').val(data.seplan_typesubject);
                    $('#up_seplan_usersend').val(data.seplan_usersend).trigger('change');
                    $('#editteacher').modal('show');
                } else {
                    Swal.fire('ผิดพลาด!', response.message, 'error');
                }
            }
        });
    });

    $('#FromUpdateTeacher').submit(function(e) {
        e.preventDefault();
        // Similar AJAX logic for update...
         $.ajax({
            url: '<?= base_url('admin/academic/course/update_teacher') ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if(response){
                     $('#editteacher').modal('hide');
                     Swal.fire('สำเร็จ', 'บันทึกเรียบร้อย', 'success');
                     table.ajax.reload();
                }
            }
        });
    });
    
    // Delete Logic (Keep existing SweetAlert flow)
    $(document).on('click', '.DeleteTeach', function(e) { /* ... existing delete logic ... */ 
        e.preventDefault();
        var delData = {
            plan_code: $(this).attr('delplancode'),
            plan_year: $(this).attr('delplanyear'),
            plan_term: $(this).attr('delplanterm'),
            plan_teacher_id: $(this).attr('delplanteacherid')
        };
        Swal.fire({
            title: 'ยืนยันการลบ?',
            text: "ต้องการลบข้อมูลนี้ใช่หรือไม่?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ลบเลย'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('<?= base_url('admin/academic/course/delete_teacher_subject') ?>', delData, function(res) {
                    Swal.fire('ลบสำเร็จ', '', 'success');
                    table.ajax.reload();
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>