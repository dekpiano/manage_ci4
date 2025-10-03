<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="">

    <div class="d-flex align-items-center justify-content-between">
        <h3 class="page-title">จัดการ<?= isset($title) ? esc($title) : '' ?></h3>
    </div>

    <div class="">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="data-tab" data-bs-toggle="tab" data-bs-target="#data-tab-pane" type="button" role="tab" aria-controls="data-tab-pane" aria-selected="true">ข้อมูลจับคู่ครูกับวิชา</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="add-tab" data-bs-toggle="tab" data-bs-target="#add-tab-pane" type="button" role="tab" aria-controls="add-tab-pane" aria-selected="false">เพิ่มครูกับวิชา</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings-tab-pane" type="button" role="tab" aria-controls="settings-tab-pane" aria-selected="false">ตั้งค่าส่งแผน</button>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="data-tab-pane" role="tabpanel" aria-labelledby="data-tab" tabindex="0">
                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            ข้อมูลจับคู่ครูกับวิชา
                        </div>
                        <div class="d-flex align-items-center">
                            <form method="get" class="d-flex align-items-center">
                                <label for="onoff_year" class="form-label me-2 mb-0">เลือกปีการศึกษา</label>
                                <select name="onoff_year" id="onoff_year" class="form-select form-select-sm w-auto">
                                    <?php foreach ($CheckYearSendPlan as $key => $value):?>
                                    <option
                                        <?= (isset($term) && isset($year) && isset($value->seplan_term) && isset($value->seplan_year) && $term.'/'.$year == $value->seplan_term.'/'.$value->seplan_year) ? "selected" : ""?>
                                        value="<?= (isset($value->seplan_term) ? esc($value->seplan_term) : '').'/'.(isset($value->seplan_year) ? esc($value->seplan_year) : '') ?>">
                                        <?= (isset($value->seplan_term) ? esc($value->seplan_term) : '').'/'.(isset($value->seplan_year) ? esc($value->seplan_year) : '') ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover" id="TbSendPlan">
                            <thead>
                                <tr>
                                    <th>ปีการศึกษา</th>
                                    <th>รหัสวิชา</th>
                                    <th>ชื่อวิชา</th>
                                    <th>ระดับชั้น</th>
                                    <th>ประเภท</th>
                                    <th>ครูผู้สอน</th>
                                    <th>คำสั่ง</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($Plan) && !empty($Plan)): ?>
                                <?php foreach ($Plan as $row): ?>
                                <tr>
                                    <td><?= esc($row->seplan_term . '/' . $row->seplan_year) ?></td>
                                    <td><?= esc($row->seplan_coursecode) ?></td>
                                    <td><?= esc($row->seplan_namesubject) ?></td>
                                    <td><?= 'ม.' . esc($row->seplan_gradelevel) ?></td>
                                    <td><?= esc($row->seplan_typesubject) ?></td>
                                    <td><?= esc($row->pers_prefix . $row->pers_firstname . ' ' . $row->pers_lastname) ?>
                                    </td>
                                            <td>
                                                <a class="btn btn-primary EditTeach me-1"
                                                    PlanCode="<?= esc($row->seplan_coursecode) ?>"
                                                    PlanYear="<?= esc($row->seplan_year) ?>"
                                                    PlanTerm="<?= esc($row->seplan_term) ?>"
                                                    PlanTeacherID="<?= esc($row->pers_id) ?>" 
                                                    href="#" title="แก้ไข">
                                                    <i class='bx bx-edit'></i>
                                                </a>
                                                <a class="btn btn-danger DeleteTeach" href="javascript:void(0)"
                                                    delplancode="<?= esc($row->seplan_coursecode) ?>"
                                                    delplanyear="<?= esc($row->seplan_year) ?>"
                                                    delplanterm="<?= esc($row->seplan_term) ?>"
                                                    delplanname="<?= esc($row->seplan_namesubject) ?>" title="ลบ">
                                                    <i class='bx bx-trash'></i>
                                                </a>
                                            </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="add-tab-pane" role="tabpanel" aria-labelledby="add-tab" tabindex="0">
                <div class="card mt-3">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <form class="row g-3" id="FormUpdateSendPlan" method="post">
                            <div class="col-md-4">
                                <label for="SelectSubject" class="form-label">วิชาที่สอน</label>
                                <select class="form-select SelectSubject" id="SelectSubject" name="SelectSubject"
                                    data-placeholder="เลือกวิชาที่สอน" required>
                                    <option value="">เลือกวิชาที่สอน</option>
                                    <?php foreach ($Subject as $key => $v_Subject) :?>
                                    <option
                                        value="<?= isset($v_Subject->SubjectID) ? esc($v_Subject->SubjectID) : '' ?>">
                                        <?= (isset($v_Subject->SubjectCode) ? esc($v_Subject->SubjectCode) : '').' '.(isset($v_Subject->SubjectName) ? esc($v_Subject->SubjectName) : '') ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="SelectTeacher" class="form-label">ครูผู้สอน</label>
                                <select class="form-select SelectTeacher" id="SelectTeacher" name="SelectTeacher"
                                    data-placeholder="เลือกครูผู้สอน" required>
                                    <option value="">เลือกครูผู้สอน</option>
                                    <?php foreach ($Teacher as $key => $v_Teacher) :?>
                                    <option value="<?= isset($v_Teacher->pers_id) ? esc($v_Teacher->pers_id) : '' ?>">
                                        <?= (isset($v_Teacher->pers_prefix) ? esc($v_Teacher->pers_prefix) : '').(isset($v_Teacher->pers_firstname) ? esc($v_Teacher->pers_firstname) : '').' '.(isset($v_Teacher->pers_lastname) ? esc($v_Teacher->pers_lastname) : '') ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100 BtnAddTeacherSubject">
                                    <span class="spinner-border spinner-border-sm d-none" role="status"
                                        aria-hidden="true"></span>
                                    เพิ่มครูกับวิชา
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="settings-tab-pane" role="tabpanel" aria-labelledby="settings-tab"
                tabindex="0">
                <div class="card mt-3">
                    <div class="card-header bg-primary text-white">
                        ตั้งค่าส่งแผน
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mt-2">
                            <form action="#" method="post" id="FormSettingSendPlan">
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-3">
                                        <label for="seplanset_startdate" class="form-label">เริ่มต้น</label>
                                        <input type="datetime-local" name="seplanset_startdate"
                                            id="seplanset_startdate" class="form-control"
                                            value="<?= isset($CheckYear[0]->seplanset_startdate) ? esc($CheckYear[0]->seplanset_startdate) : '' ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="seplanset_enddate" class="form-label">สิ้นสุด</label>
                                        <input type="datetime-local" name="seplanset_enddate" id="seplanset_enddate"
                                            class="form-control"
                                            value="<?= isset($CheckYear[0]->seplanset_enddate) ? esc($CheckYear[0]->seplanset_enddate) : '' ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="seplanset_term" class="form-label">ปีการศึกษา</label>
                                        <div class="d-flex">
                                            <select name="seplanset_term" id="seplanset_term"
                                                class="form-select form-select-sm me-2">
                                                <?php for ($i=1; $i <=3 ; $i++):?>
                                                <option
                                                    <?= (isset($CheckYear[0]->seplanset_term) && $CheckYear[0]->seplanset_term == $i) ? 'selected' : ''?>
                                                    value="<?= esc($i) ?>">
                                                    <?= esc($i) ?>
                                                </option>
                                                <?php endfor; ?>
                                            </select>
                                            <select name="seplanset_year" id="seplanset_year"
                                                class="form-select form-select-sm">
                                                <?php $d = date("Y")+543; for ($i=$d-1; $i <= $d+1 ; $i++):?>
                                                <option
                                                    <?= (isset($CheckYear[0]->seplanset_year) && $CheckYear[0]->seplanset_year == $i) ? 'selected' : ''?>
                                                    value="<?= esc($i) ?>">
                                                    <?= esc($i) ?>
                                                </option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary w-100 BtnUpdateSendPlan">
                                            <span class="spinner-border spinner-border-sm d-none" role="status"
                                                aria-hidden="true"></span>
                                            บันทึก
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<!-- Modal -->
<div class="modal fade" id="editteacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขข้อมูล</h5>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate id="FromUpdateTeacher">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="up_seplan_year" class="form-label">ปีการศึกษา</label>
                            <input readonly type="text" class="form-control" placeholder="ปีการศึกษา"
                                id="up_seplan_year" name="up_seplan_year" required>
                            <div class="invalid-feedback">กรุณากรอปีการศึกษา</div>
                        </div>
                        <div class="col-sm-6">
                            <label for="up_seplan_term" class="form-label">ภาคเรียน</label>
                            <input readonly type="text" class="form-control" placeholder="ภาคเรียน" id="up_seplan_term"
                                name="up_seplan_term" required>
                            <div class="invalid-feedback">กรุณากรอภาคเรียน</div>
                        </div>

                        <div class="col-sm-12">
                            <label for="up_seplan_coursecode" class="form-label">รหัสวิชา</label>
                            <input readonly type="text" class="form-control" placeholder="รหัสวิชา"
                                id="up_seplan_coursecode" name="up_seplan_coursecode" required>
                            <div class="invalid-feedback">กรุณากรอกรหัสวิชา</div>
                        </div>
                        <div class="col-sm-12">
                            <label for="up_seplan_namesubject" class="form-label">ชื่อวิชา</label>
                            <input type="text" class="form-control" placeholder="ชื่อวิชา" id="up_seplan_namesubject"
                                name="up_seplan_namesubject" required readonly>
                            <div class="invalid-feedback">กรุณากรอกชื่อวิชา</div>
                        </div>
                        <div class="col-sm-12">
                            <label for="up_seplan_gradelevel" class="form-label">ระดับชั้น</label>
                            <select class="form-select" id="up_seplan_gradelevel" name="up_seplan_gradelevel" required
                                readonly>
                                <option value="">เลือกระดับชั้น</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                            </select>
                            <div class="invalid-feedback">กรุณาเลือระดับชั้น</div>
                        </div>
                        <div class="col-sm-12">
                            <label for="up_seplan_typesubject" class="form-label">ประเภท</label>
                            <select class="form-select" id="up_seplan_typesubject" name="up_seplan_typesubject" required
                                readonly>
                                <option value="">เลือกประเภท</option>
                                <option value="พื้นฐาน">พื้นฐาน</option>
                                <option value="เพิ่มเติม">เพิ่มเติม</option>
                            </select>
                            <div class="invalid-feedback">กรุณาเลือประเภท</div>
                        </div>
                        <div class="col-sm-12">
                            <label for="up_seplan_usersend" class="form-label">ครูผู้สอน</label>
                            <select class="form-select" id="up_seplan_usersend" name="up_seplan_usersend" required>
                                <option value="">เลือกครูผู้สอน</option>
                                <?php foreach ($Teacher as $key => $v_Teacher): ?>
                                <option value="<?= isset($v_Teacher->pers_id) ? esc($v_Teacher->pers_id) : '' ?>">
                                    <?= (isset($v_Teacher->pers_prefix) ? esc($v_Teacher->pers_prefix) : '').(isset($v_Teacher->pers_firstname) ? esc($v_Teacher->pers_firstname) : '').' '.(isset($v_Teacher->pers_lastname) ? esc($v_Teacher->pers_lastname) : '') ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">กรุณาครูผู้สอน</div>
                        </div>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="submit" class="btn btn-primary BtnUpdateTeacher">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            แก้ไข
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?= $this->endSection() ?>

        <?= $this->section('script') ?>
        <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.SelectSubject').select2({
                theme: 'bootstrap-5',
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ?
                    '100%' : 'style',
                placeholder: $(this).data('placeholder'),
                dropdownParent: $('#FormUpdateSendPlan')
            });

            $('.SelectTeacher').select2({
                theme: 'bootstrap-5',
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ?
                    '100%' : 'style',
                placeholder: $(this).data('placeholder'),
                dropdownParent: $('#FormUpdateSendPlan')
            });

            // FormSettingSendPlan submission
            $('#FormSettingSendPlan').submit(function(e) {
                e.preventDefault();
                var submitBtn = $('.BtnUpdateSendPlan');
                submitBtn.prop('disabled', true).find('.spinner-border').removeClass('d-none');
                var formData = $(this).serialize();
                $.ajax({
                    url: '<?= base_url('admin/academic/sendplan/update_setting') ?>',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('สำเร็จ!', response.message, 'success');
                        } else {
                            Swal.fire('ผิดพลาด!', response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาดในการส่งข้อมูล: ' + error,
                            'error');
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).find('.spinner-border').addClass(
                            'd-none');
                    }
                });
            });

            // FormUpdateSendPlan submission (Add Teacher with Subject)
            $('#FormUpdateSendPlan').submit(function(e) {
                e.preventDefault();
                var submitBtn = $('.BtnAddTeacherSubject');
                submitBtn.prop('disabled', true).find('.spinner-border').removeClass('d-none');
                var formData = $(this).serialize();
                $.ajax({
                    url: '<?= base_url('admin/academic/sendplan/add_teacher_subject') ?>',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('สำเร็จ!', response.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('ผิดพลาด!', response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาดในการส่งข้อมูล: ' + error,
                            'error');
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).find('.spinner-border').addClass(
                            'd-none');
                    }
                });
            });

            // EditTeach click handler
            $(document).on('click', '.EditTeach', function(e) {
                e.preventDefault();
                var planCode = $(this).attr('PlanCode');
                var planYear = $(this).attr('PlanYear');
                var planTerm = $(this).attr('PlanTerm');
                var planTeacherId = $(this).attr('PlanTeacherID');

                $.ajax({
                    url: '<?= base_url('admin/academic/sendplan/get_plan_details') ?>',
                    type: 'GET',
                    data: {
                        plan_code: planCode,
                        plan_year: planYear,
                        plan_term: planTerm,
                        plan_teacher_id: planTeacherId
                    },
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
                            $('#up_seplan_usersend').val(data.seplan_usersend);

                            $('#editteacher').modal('show');
                        } else {
                            Swal.fire('ผิดพลาด!', response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาดในการดึงข้อมูล: ' + error,
                            'error');
                    }
                });
            });

            // FromUpdateTeacher submission (inside modal)
            $('#FromUpdateTeacher').submit(function(e) {
                e.preventDefault();
                var submitBtn = $('.BtnUpdateTeacher');
                submitBtn.prop('disabled', true).find('.spinner-border').removeClass('d-none');
                var formData = $(this).serialize();
                $.ajax({
                    url: '<?= base_url('admin/academic/sendplan/update_teacher') ?>',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response) {
                            $('#editteacher').modal('hide');
                            Swal.fire('สำเร็จ!', response.message, 'success').then(() => {
                                $('#editteacher').modal('hide');
                                location.reload();
                            });
                        } else {
                            Swal.fire('ผิดพลาด!', response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาดในการส่งข้อมูล: ' + error,
                            'error');
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).find('.spinner-border').addClass(
                            'd-none');
                    }
                });
            });

            // DeleteTeach click handler
            $(document).on('click', '.DeleteTeach', function(e) {
                e.preventDefault();
                var delPlanCode = $(this).attr('delplancode');
                var delPlanYear = $(this).attr('delplanyear');
                var delPlanTerm = $(this).attr('delplanterm');
                var delPlanName = $(this).attr('delplanname');

                Swal.fire({
                    title: 'คุณแน่ใจหรือไม่?',
                    text: "คุณต้องการลบวิชา " + delPlanName + " ออกจากรายการหรือไม่?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ใช่, ลบเลย!',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?= base_url('admin/academic/sendplan/delete_teacher_subject') ?>',
                            type: 'POST',
                            data: {
                                plan_code: delPlanCode,
                                plan_year: delPlanYear,
                                plan_term: delPlanTerm
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    Swal.fire('ลบแล้ว!', response.message,
                                        'success').then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire('ผิดพลาด!', response.message,
                                    'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire('ผิดพลาด!',
                                    'เกิดข้อผิดพลาดในการลบข้อมูล: ' + error,
                                    'error');
                            }
                        });
                    }
                });
            });

            // Initialize DataTable
            $('#TbSendPlan').DataTable({
                // Client-side processing (no options needed for basic functionality)
            });

            // onoff_year change handler
            $('#onoff_year').change(function() {
                var selectedYear = $(this).val();
                if (selectedYear) {
                    window.location.href = '<?= base_url('Admin/Acade/Course/SendPlan') ?>?onoff_year=' + selectedYear;
                }
            });
        });
        </script>
        <?= $this->endSection() ?>