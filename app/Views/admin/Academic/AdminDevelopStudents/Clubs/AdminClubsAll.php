<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div class="page-title">
            <h4 class="fw-bold py-1 mb-0">
                <span class="text-muted fw-light">วิชาการ / พัฒนาผู้เรียน / ชุมนุม /</span> จัดการชุมนุมทั้งหมด
            </h4>
            <div class="text-muted small">บันทึกข้อมูลและจัดการรายชื่อนักเรียนในแต่ละชุมนุม</div>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= site_url('Admin/Acade/DevelopStudents/Clubs/Main') ?>">หน้าแรกชุมนุม</a></li>
                <li class="breadcrumb-item active">จัดการชุมนุม</li>
            </ol>
        </nav>
    </div>

    <!-- Main Card -->
    <div class="card shadow-sm border-0 overflow-hidden">
        <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <div class="p-2 bg-label-primary rounded me-1">
                    <i class="bx bx-collection fs-4"></i>
                </div>
                <h5 class="mb-0 fw-bold">รายการชุมนุมที่เปิดสอน</h5>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <div class="input-group input-group-merge shadow-sm" style="min-width: 200px;">
                    <span class="input-group-text"><i class="bx bx-calendar text-primary"></i></span>
                    <?php 
                        $activeClubYearTerm = get_selected_term_only() . '/' . get_selected_year_only();
                    ?>
                    <select id="academicYearFilter" name="academicYearFilter" class="form-select fw-semibold">
                        <?php foreach ($YearAll as $key => $v_YearAll) : 
                            $ytVal = (isset($v_YearAll['club_trem']) ? $v_YearAll['club_trem'] : '') . '/' . (isset($v_YearAll['club_year']) ? $v_YearAll['club_year'] : '');
                        ?>
                        <option
                            value="<?= esc($ytVal) ?>"
                            <?= ($ytVal == $activeClubYearTerm) ? 'selected' : '' ?>>
                             ภาคเรียนที่ <?= (isset($v_YearAll['club_trem']) ? esc($v_YearAll['club_trem']) : '') ?> / ปีการศึกษา <?= (isset($v_YearAll['club_year']) ? esc($v_YearAll['club_year']) : '') ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="button" class="btn btn-primary shadow px-4 py-2 BtnAddClub text-nowrap">
                    <i class="bx bx-plus-circle me-1"></i> เพิ่มชุมนุมใหม่
                </button>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle mb-0" id="TbClubs" style="width: 100%;">
                    <thead class="bg-light-primary border-top-0">
                        <tr>
                            <th class="text-center py-3" style="width: 50px;">#</th>
                            <th class="py-3"><i class="bx bx-calendar me-1 small"></i>ปีการศึกษา</th>
                            <th class="py-3"><i class="bx bx-label me-1 small"></i>ชื่อชุมนุม</th>
                            <th class="py-3"><i class="bx bx-user-voice me-1 small"></i>ครูที่ปรึกษา</th>
                            <th class="text-center py-3"><i class="bx bx-group me-1 small"></i>รับจำนวน</th>
                            <th class="text-center py-3"><i class="bx bx-user-check me-1 small"></i>ยอดปัจจุบัน</th>
                            <th class="text-center py-3"><i class="bx bx-clipboard me-1 small"></i>ทะเบียน</th>
                            <th class="text-center py-3"><i class="bx bx-cog me-1 small"></i>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <!-- AJAX content -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<style>
    .swal2-container { z-index: 100000 !important; }
    .bg-light-primary { background-color: #f0f2ff !important; }
    #TbClubs thead th { 
        text-transform: uppercase; 
        font-size: 0.8rem; 
        letter-spacing: 0.5px; 
        color: #566a7f;
        border-bottom: 2px solid #e7e7ff !important;
    }
    .select2-container--bootstrap-5 .select2-selection { 
        border-radius: 0.375rem !important; 
        border-color: #d9dee3 !important;
    }
    .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice {
        background-color: #e7e7ff !important;
        color: #696cff !important;
        border: none !important;
        border-radius: 4px !important;
        padding: 2px 8px !important;
        font-weight: 500 !important;
        margin-top: 5px !important;
    }
    .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice__remove {
        color: #696cff !important;
        margin-right: 5px !important;
    }
    .select2-container--bootstrap-5.select2-container--focus .select2-selection {
        border-color: #696cff !important;
        box-shadow: 0 0 0.25rem 0.05rem rgba(105, 108, 255, 0.1) !important;
    }
    .card-hover:hover { transform: translateY(-3px); transition: all 0.3s ease; }
</style>

<!-- Modal Add/Edit Clubs -->
<div class="modal fade" id="ModalAddClubs" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-bottom bg-label-primary py-3">
                <h5 class="modal-title fw-bold" id="clubModalLabel text-primary">
                    <i class="bx bx-edit-alt me-2"></i>ข้อมูลชุมนุม
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="FormAddClubs">
                    <input type="hidden" name="club_id" id="club_id">
                    
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="form-floating">
                                <select class="form-select" id="club_year" name="club_year" required>
                                    <option value="" disabled>เลือกปีการศึกษา</option>
                                    <?php 
                                        $activeOnlyYear = get_selected_year_only();
                                        $currY = (int)date('Y') + 543;
                                        for ($yi = $currY - 1; $yi <= $currY + 2; $yi++):
                                    ?>
                                    <option value="<?= $yi ?>" <?= ($yi == $activeOnlyYear) ? 'selected' : '' ?>><?= $yi ?></option>
                                    <?php endfor; ?>
                                </select>
                                <label for="club_year">ปีการศึกษา</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating">
                                <select class="form-select" id="club_trem" name="club_trem" required>
                                    <option value="" disabled>เลือกภาคเรียน</option>
                                    <option value="1" <?= (get_selected_term_only() == '1') ? 'selected' : '' ?>>1</option>
                                    <option value="2" <?= (get_selected_term_only() == '2') ? 'selected' : '' ?>>2</option>
                                </select>
                                <label for="club_trem">ภาคเรียน (เทอม)</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" id="club_name" name="club_name" placeholder="ชื่อชุมนุม" required>
                        <label for="club_name">ชื่อหัวข้อชุมนุม</label>
                    </div>

                    <div class="form-floating mb-4">
                        <textarea class="form-control" id="club_description" name="club_description" style="height: 100px" placeholder="รายละเอียด"></textarea>
                        <label for="club_description">รายละเอียดหรือคำอธิบายชุดกิจกรรม</label>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="club_max_participants" name="club_max_participants" placeholder="รับจำนวน" required min="1">
                                <label for="club_max_participants">จำนวนนักเรียนที่รับ (คน)</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating">
                                <select class="form-select" id="club_level" name="club_level" required>
                                    <option value="" disabled selected>เลือกกลุ่มระดับชั้น</option>
                                    <option value="ม.ต้น">ม.ต้น</option>
                                    <option value="ม.ปลาย">ม.ปลาย</option>
                                    <option value="ม.ต้น และ ม.ปลาย">ม.ต้น และ ม.ปลาย</option>
                                    <option value="ม.ต้น หรือ ม.ปลาย">ม.ต้น หรือ ม.ปลาย</option>
                                </select>
                                <label for="club_level">ระดับชั้นที่รับ</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small text-uppercase mb-2">
                             <i class="bx bx-user-check text-primary me-1"></i> ครูที่ปรึกษาชุมนุม (เลือกได้หลายชื่อ)
                        </label>
                        <div class="select2-primary">
                            <select class="form-select select2" id="club_faculty_advisor" name="club_faculty_advisor[]" multiple required style="width: 100%;">
                            </select>
                        </div>
                        <div class="form-text small">พิมพ์รายชื่อครูที่ต้องการค้นหาและเลือก</div>
                    </div>

                    <hr class="my-4">

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg shadow">
                            <i class="bx bx-save me-1"></i> บันทึกข้อมูลชุมนุม
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Manage Students -->
<div class="modal fade" id="ModalAddStudents" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light py-3">
                <div class="d-flex align-items-center">
                    <div class="p-2 bg-primary rounded me-3 shadow-sm text-white">
                        <i class="bx bx-user-circle fs-4"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0 text-dark" id="AddStudentsTitle">จัดการนักเรียน</h5>
                        <small class="text-muted">เพิ่มและยกเลิกรายการนักเรียนในชุมนุม</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="row g-0">
                    <!-- Left Column: Add Student -->
                    <div class="col-lg-4 border-end bg-light p-4">
                        <h6 class="fw-bold mb-3">ค้นหาและเพิ่มนักเรียน</h6>
                        <form id="FormAddStudentToClub">
                            <input type="hidden" name="club_id" class="club_id" value="">
                            <div class="mb-4">
                                <label class="form-label small fw-bold">เลือกรายชื่อนักเรียน</label>
                                <select id="studentSelect" name="student_ids[]" multiple class="form-select shadow-sm" style="width: 100%;">
                                </select>
                            </div>
                            <button type="button" id="btnAddStudentToClub" class="btn btn-primary w-100 shadow py-2">
                                <i class="bx bx-plus me-1"></i> ยืนยันการเพิ่มนักเรียน
                            </button>
                            
                            <div class="mt-4 p-3 bg-white rounded border border-dashed">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bx bx-info-circle text-info me-2 fs-4"></i>
                                    <span class="fw-bold">ข้อมูลสรุป</span>
                                </div>
                                <div class="h3 mb-0 text-primary" id="registeredCountDisplay">0 <small class="text-muted fs-6">คน</small></div>
                                <div class="text-muted small mt-1">จำนวนคงเหลือ <span id="remainingCapacity">0</span> จากโควตาทั้งหมด</div>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Right Column: Registered List -->
                    <div class="col-lg-8 p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">รายชื่อนักเรียนที่ลงทะเบียนแล้ว</h6>
                            <span class="badge bg-label-primary px-3 py-2" id="registeredCount">โหลดข้อมูล...</span>
                        </div>
                        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                            <table class="table table-hover align-middle border" id="TbShowStudentRegisClub" style="width:100%;">
                                <thead class="bg-light sticky-top" style="z-index: 10;">
                                    <tr>
                                        <th class="text-center" style="width: 50px;">#</th>
                                        <th style="width: 80px;">ชั้น</th>
                                        <th style="width: 80px;">เลขที่</th>
                                        <th style="width: 120px;">รหัสนักเรียน</th>
                                        <th>ชื่อ-นามสกุล</th>
                                        <th class="text-center" style="width: 100px;">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody id="addedStudentsList">
                                    <!-- AJAX Content -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    $('#academicYearFilter').change(function() {
        table.ajax.reload();
    });

    const table = $('#TbClubs').DataTable({
        processing: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/th.json"
        },
        ajax: {
            url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsShow') ?>",
            type: "GET",
            dataSrc: "data",
            data: function(d) {
                d.year = decodeURIComponent($('#academicYearFilter').val());
            }
        },
        columns: [
            {
                data: null,
                className: 'text-center',
                render: function(data, type, row, meta) {
                    return `<span class="fw-semibold">${meta.row + 1}</span>`;
                },
                orderable: false
            },
            {
                data: null,
                render: function(data, type, row) {
                    return `<span class="badge bg-label-secondary">${row.club_trem}/${row.club_year}</span>`;
                }
            },
            {
                data: "club_name",
                render: function(data) {
                    return `<span class="fw-bold text-primary">${data}</span>`;
                }
            },
            {
                data: null,
                render: function(data, type, row) {
                    return `<div class="small w-px-200 text-truncate" title="${row.advisor_names}">${row.advisor_names}</div>`;
                }
            },
            {
                data: null,
                className: 'text-center',
                render: function(data, type, row) {
                    return `<span class="badge bg-label-dark fw-bold px-3">${row.club_max_participants}</span>`;
                }
            },
            {
                data: null,
                className: 'text-center',
                render: function(data, type, row) {
                    const percent = Math.round((row.member_count / row.club_max_participants) * 100);
                    let color = percent >= 100 ? 'danger' : (percent > 80 ? 'warning' : 'success');
                    return `
                        <div>
                            <span class="fw-bold text-${color}">${row.member_count}</span>
                            <div class="progress mt-1" style="height: 4px; width: 60px; margin: 0 auto;">
                                <div class="progress-bar bg-${color}" role="progressbar" style="width: ${percent > 100 ? 100 : percent}%"></div>
                            </div>
                        </div>
                    `;
                }
            },
            {
                data: null,
                className: 'text-center',
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-sm btn-outline-primary BtnAddStudents shadow-sm px-3" data-id="${row.club_id}" clubname="${row.club_name}" max="${row.club_max_participants}" count="${row.member_count}">
                            <i class="bx bx-user-plus me-1"></i>จัดการ
                        </button>
                    `;
                }
            },
            {
                data: null,
                className: 'text-center',
                render: function(data, type, row) {
                    return `
                        <div class="d-flex gap-2 justify-content-center">
                            <button class="btn btn-sm btn-icon btn-label-primary edit-btn" data-id="${row.club_id}" title="แก้ไข">
                                <i class="bx bx-edit-alt"></i>
                            </button>
                            <button class="btn btn-sm btn-icon btn-label-danger delete-btn" data-id="${row.club_id}" title="ลบ">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        drawCallback: function() {
            $('.dataTables_filter input').addClass('form-control shadow-sm').attr('placeholder', 'ค้นหาชุมนุม...');
            $('.dataTables_length select').addClass('form-select shadow-sm');
        }
    });

    // Add Club Logic
    $(document).on('click', '.BtnAddClub', function() {
        $('#ModalAddClubs').modal('show');
        $('#FormAddClubs')[0].reset();
        $('#club_id').val('');
        $('#club_level').val('');
        $('#club_faculty_advisor').val(null).trigger('change');
        $('#clubModalLabel').html('<i class="bx bx-plus-circle me-2"></i>เพิ่มชุมนุมใหม่');

        if ($('#club_faculty_advisor').data('select2')) {
            $('#club_faculty_advisor').select2('destroy');
        }

        $('#club_faculty_advisor').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#ModalAddClubs'),
            placeholder: 'ค้นหาและเลือกครูที่ปรึกษา',
            ajax: {
                url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsTeacherList') ?>",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return { results: data.map(t => ({ id: t.pers_id, text: t.FullName })) };
                }
            }
        });
    });

    $(document).on('submit', '#FormAddClubs', function(e) {
        e.preventDefault();
        const selectedAdvisors = $('#club_faculty_advisor').val();
        if (!selectedAdvisors || selectedAdvisors.length === 0) {
            Swal.fire({ icon: 'error', title: 'ผิดพลาด', text: 'กรุณาเลือกที่ปรึกษาชุมนุมอย่างน้อย 1 ท่าน' });
            return;
        }

        const url = $('#club_id').val() ? 
            "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsUpdate') ?>" : 
            "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsInsert') ?>";

        let formData = $(this).serializeArray();
        formData.push({ name: 'advisors', value: JSON.stringify(selectedAdvisors) });

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.status === 'success') {
                    $('#ModalAddClubs').modal('hide');
                    table.ajax.reload();
                    Swal.fire({ icon: 'success', title: 'สำเร็จ', text: 'บันทึกข้อมูลเรียบร้อยแล้ว', timer: 1500, showConfirmButton: false });
                } else {
                    Swal.fire({ icon: 'error', title: 'แจ้งเตือน', text: response.message || 'บันทึกไม่สำเร็จ' });
                }
            }
        });
    });

    // Edit Club Logic
    $(document).on('click', '.edit-btn', function() {
        const clubId = $(this).data('id');
        $.ajax({
            url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsEdit/') ?>" + clubId,
            type: "GET",
            dataType: "json",
            success: function(data) {
                $('#clubModalLabel').html('<i class="bx bx-edit-alt me-2 text-warning"></i>แก้ไขข้อมูลชุมนุม');
                $('#club_id').val(data.club_id);
                $('#club_year').val(data.club_year);
                $('#club_trem').val(data.club_trem);
                $('#club_name').val(data.club_name);
                $('#club_description').val(data.club_description);
                $('#club_max_participants').val(data.club_max_participants);
                $('#club_level').val(data.club_level);
                
                // Init Select2 with preselected data
                if ($('#club_faculty_advisor').data('select2')) {
                    $('#club_faculty_advisor').select2('destroy');
                }
                
                $('#club_faculty_advisor').empty();
                data.preselected_advisor_details.forEach(advisor => {
                    const newOption = new Option(advisor.FullName, advisor.pers_id, true, true);
                    $('#club_faculty_advisor').append(newOption);
                });
                
                $('#club_faculty_advisor').select2({
                    theme: 'bootstrap-5',
                    dropdownParent: $('#ModalAddClubs'),
                    placeholder: 'ค้นหาและเลือกครูที่ปรึกษา',
                    ajax: {
                        url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsTeacherList') ?>",
                        dataType: 'json',
                        processResults: function(res) {
                            return { results: res.map(t => ({ id: t.pers_id, text: t.FullName })) };
                        }
                    }
                });
                
                $('#ModalAddClubs').modal('show');
            }
        });
    });

    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'ต้องการลบข้อมูล?',
            text: "ข้อมูลนักเรียนและเวลาเรียนทั้งหมดในชุมนี้จะถูกลบออกด้วย!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff3e1d',
            confirmButtonText: 'ยืนยันการลบ',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsDelete/') ?>" + id,
                    type: "POST",
                    success: function() {
                        table.ajax.reload();
                        Swal.fire('ลบข้อมูลเรียบร้อย!', '', 'success');
                    }
                });
            }
        });
    });

    // Student Management Logic
    let current_max = 0;
    $(document).on('click', '.BtnAddStudents', function() {
        const club_id = $(this).data('id');
        const clubname = $(this).attr('clubname');
        current_max = parseInt($(this).attr('max'));
        
        $('#AddStudentsTitle').text("จัดการนักเรียนชุมนุม " + clubname);
        $('.club_id').val(club_id);
        
        loadRegisteredStudents(club_id);
        $('#ModalAddStudents').modal('show');

        if ($('#studentSelect').data('select2')) {
            $('#studentSelect').select2('destroy');
        }

        $('#studentSelect').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#ModalAddStudents'),
            placeholder: 'ค้นหาด้วยชื่อ-สกุล หรือชั้นเรียน...',
            ajax: {
                url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsStudentList') ?>",
                dataType: 'json',
                processResults: function(data) {
                    return { results: data.map(s => ({ id: s.StudentID, text: s.FullName })) };
                }
            }
        });
    });

    function loadRegisteredStudents(clubId) {
        $.ajax({
            url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsTbShowStudentList') ?>",
            type: "GET",
            data: { club_id: clubId },
            dataType: 'json',
            success: function(data) {
                let rows = '';
                data.forEach((s, i) => {
                    rows += `<tr>
                        <td class="text-center font-bold">${i + 1}</td>
                        <td class="small">${s.StudentClass}</td>
                        <td class="small">${s.StudentNumber}</td>
                        <td class="small fw-semibold">${s.StudentCode}</td>
                        <td class="fw-bold">${s.Fullname}</td>
                        <td class="text-center">
                            <button class="btn btn-icon btn-label-danger btn-sm remove-btn" data-id="${s.StudentID}">
                                <i class="bx bx-x"></i>
                            </button>
                        </td>
                    </tr>`;
                });
                $('#addedStudentsList').html(rows || '<tr><td colspan="5" class="text-center py-4 text-muted small">ไม่พบรายชื่อนักเรียน</td></tr>');
                const count = data.length;
                $('#registeredCount').text("ทั้งหมด: " + count + " คน");
                $('#registeredCountDisplay').html(count + ' <small class="text-muted fs-6">คน</small>');
                $('#remainingCapacity').text(current_max - count);
            }
        });
    }

    $(document).on('click', '#btnAddStudentToClub', function() {
        const student_ids = $('#studentSelect').val();
        const club_id = $('.club_id').val();
        if (!student_ids) return Swal.fire('กรุณาเลือกนักเรียน', '', 'warning');

        $.ajax({
            url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsAddStudentToClub') ?>",
            type: 'POST',
            data: { student_ids, club_id },
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    Swal.fire({ icon: 'success', title: 'เพิ่มนักเรียนแล้ว', timer: 1000, showConfirmButton: false });
                    loadRegisteredStudents(club_id);
                    $('#studentSelect').val(null).trigger('change');
                    table.ajax.reload();
                } else if (res.status === 'duplicate') {
                    Swal.fire({ 
                        icon: "warning", 
                        title: "พบข้อมูลซ้ำ!", 
                        text: "นักเรียนบางคนลงทะเบียนชุมนุมนี้ไปแล้ว:\n" + res.duplicate_students.join(', ')
                    });
                } else {
                    Swal.fire('ผิดพลาด', res.message, 'error');
                }
            }
        });
    });

    $(document).on('click', '.remove-btn', function() {
        const student_id = $(this).data('id');
        const club_id = $('.club_id').val();
        Swal.fire({
            title: 'ยกเลิกการลงทะเบียน?',
            text: 'แน่ใจหรือไม่ว่าต้องการลบรายชื่อนักเรียนออกจากชุมนุมนี้',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'ลบออก',
            cancelButtonText: 'ปิด'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubDeleteStudentToClub') ?>",
                    type: "POST",
                    data: { club_id, student_id },
                    success: function() {
                        loadRegisteredStudents(club_id);
                        table.ajax.reload();
                        Swal.fire('ลบเรียบร้อย!', '', 'success');
                    }
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
