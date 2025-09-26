<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<input type="hidden" id="KeyStatus" value="<?= esc(service('request')->uri->getSegment(5) ?? '') ?>">
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h2 class="heading"><?= isset($title) ? esc($title) : '' ?></h2>
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="classFilter" class="form-label">เลือกระดับชั้น</label>
                            <select class="form-select" id="classFilter" name="classFilter">
                                <option value="">ทั้งหมด</option>
                                <?php foreach ($class_list as $v_class) : ?>
                                <option value="ม.<?= esc($v_class) ?>">ม.<?= esc($v_class) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="school_year_filter" class="form-label">เลือกปีการศึกษา</label>
                            <select class="form-select" id="school_year_filter" name="school_year_filter">
                                <option value="">ทั้งหมด</option>
                                <?php foreach ($school_years as $year) : ?>
                                <option value="<?= esc($year->schyear_year) ?>" <?= (isset($SchoolYear->schyear_year) && $SchoolYear->schyear_year == $year->schyear_year) ? 'selected' : '' ?>><?= esc($year->schyear_year) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                <table class="table table-bordered" id="tbStudent">
                        <thead>
                            <tr>
                                <th>เลขประจำตัว</th>
                                <th>ชื่อ - นามสกุล</th>
                                <th>ชั้น</th>
                                <th>เลขที่</th>
                                <th>สายการเรียน</th>
                                <th>สถานะนักเรียน</th>
                                <th>สถานะพฤติกรรม</th>
                                <th class="manage-column">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<style>
    #studentDetailModal .form-floating label {
        color: black !important;
    }
    #studentDetailModal .form-control,
    #studentDetailModal .form-select {
        color: black !important;
    }
    div.toolbar {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    div.toolbar label {
        margin-right: 10px;
    }
    .manage-column {
        min-width: 100px;
        text-align: center;
    }

    /* Custom Modal Styles */
    #studentDetailModal .modal-content {
        background-color: #f8f9fa; /* A light gray background */
        border-radius: 0.5rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); /* A more prominent shadow */
        border: none;
    }
    #studentDetailModal .modal-header {
        background-color: #4e73df; /* A nice blue for the header */
        color: white;
        border-bottom: none;
    }
    #studentDetailModal .modal-header .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
    }
    #studentDetailModal .modal-body {
        background-color: #ffffff; /* White background for the form area */
    }
    #studentDetailModal .modal-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">เปลี่ยนสถานะ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="keystu" name="" value="">
                <?php $Status = array('เลือกสถานะ','1/ปกติ','2/ย้ายสถานศึกษา','3/ขาดประจำ','4/พักการเรียน','5/จบการศึกษา' ); ?>
                <select class="form-select StudentStatus" id="StudentStatus" name="StudentStatus">
                    <?php foreach ($Status as $key => $v_Status) : ?>
                    <option value="<?= esc($v_Status) ?>"><?= esc($v_Status) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" id="saveStudentStatus">บันทึก</button>
            </div>
        </div>
    </div>
</div>

<!-- Student Detail Modal -->
<div class="modal fade" id="studentDetailModal" tabindex="-1" aria-labelledby="studentDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="editStudentForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentDetailModalLabel">แก้ไขข้อมูลนักเรียน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="studentDetailContent">
                        <!-- Student details form will be loaded here dynamically -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    let tbStudent;

    // Initialize DataTable
    function initDataTable(classFilter = '', schoolYearFilter = '') {
        const keyStatus = $('#KeyStatus').val();
        console.log('KeyStatus sent to controller:', keyStatus);
        tbStudent = $('#tbStudent').DataTable({
            "processing": true,
            "serverSide": true,
            "destroy": true,
            "order": [[ 0, "asc" ]], // Default order by StudentCode
            "ajax": {
                "url": "<?= site_url('Admin/Academic/ConAdminStudents/AdminStudentsNormalShow/') ?>" + keyStatus,
                "type": "POST",
                "data": function (d) {
                    d.classFilter = classFilter;
                    d.school_year = schoolYearFilter;
                }
            },
            "columns": [
                { "data": "StudentCode" },
                { "data": "Fullname" },
                { "data": "StudentClass" },
                { "data": "StudentNumber" },
                { "data": "StudentStudyLine" },
                { "data": "StudentStatus" },
                { "data": "StudentBehavior" },
                {
                    "data": "StudentID",
                    "render": function(data, type, row) {
                        return `
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-warning edit-student" data-id="${data}" title="แก้ไขข้อมูลนักเรียน">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-info change-status" data-id="${data}" data-status="${row.StudentStatus}" title="เปลี่ยนสถานะนักเรียน">
                                    <i class="bi bi-arrow-repeat"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger delete-student" data-id="${data}" title="ลบนักเรียน">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        `;
                    }
                }
            ]
        });
    }

    // Initial load
    initDataTable();

    // Filter by class
    $('#classFilter').on('change', function() {
        const classFilter = $(this).val();
        const schoolYearFilter = $('#school_year_filter').val();
        initDataTable(classFilter, schoolYearFilter); // Call initDataTable with new filters
    });

    // Filter by school year
    $('#school_year_filter').on('change', function() {
        const classFilter = $('#classFilter').val();
        const schoolYearFilter = $(this).val();
        initDataTable(classFilter, schoolYearFilter); // Call initDataTable with new filters
    });

    // Change Status Modal
    $(document).on('click', '.change-status', function() {
        const studentId = $(this).data('id');
        const currentStatus = $(this).data('status');
        $('#keystu').val(studentId);
        $('#StudentStatus').val(currentStatus); // Set current status in dropdown
        $('#exampleModal').modal('show');
    });

    $('#saveStudentStatus').on('click', function() {
        const studentId = $('#keystu').val();
        const newStatus = $('#StudentStatus').val();

        $.ajax({
            url: '<?= site_url('Admin/Academic/ConAdminStudents/AdminUpdateStudentStatus') ?>',
            type: 'POST',
            data: {
                KeyStuId: studentId,
                ValueStudentStatus: newStatus
            },
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire('สำเร็จ!', 'เปลี่ยนสถานะนักเรียนเรียบร้อยแล้ว', 'success');
                    $('#exampleModal').modal('hide');
                    tbStudent.ajax.reload();
                } else {
                    Swal.fire('ผิดพลาด!', response.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาดในการเปลี่ยนสถานะ: ' + error, 'error');
            }
        });
    });

    // Edit Student Modal
    $(document).on('click', '.edit-student', function() {
        const studentId = $(this).data('id');
        $('#studentDetailContent').html('<div class="text-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        $('#studentDetailModal').modal('show');

        $.ajax({
            url: '<?= site_url('Admin/Academic/ConAdminStudents/get_student_details/') ?>' + studentId,
            type: 'GET',
            success: function(response) {
                if (response.student_data) {
                    let formHtml = '';
                    // Basic student info
                    formHtml += '<input type="hidden" name="StudentID" value="' + response.student_data.StudentID + '">';
                    formHtml += '<div class="row g-3 mb-3">';
                    formHtml += '<div class="col-md-4"><div class="form-floating"><select class="form-select" name="StudentPrefix"><option value="">คำนำหน้า</option>';
                    ['เด็กชาย', 'เด็กหญิง', 'นาย', 'นางสาว'].forEach(prefix => {
                        formHtml += '<option value="' + prefix + '" ' + (response.student_data.StudentPrefix === prefix ? 'selected' : '') + '>' + prefix + '</option>';
                    });
                    formHtml += '</select><label>คำนำหน้า</label></div></div>';
                    formHtml += '<div class="col-md-4"><div class="form-floating"><input type="text" class="form-control" name="StudentFirstName" value="' + response.student_data.StudentFirstName + '"><label>ชื่อ</label></div></div>';
                    formHtml += '<div class="col-md-4"><div class="form-floating"><input type="text" class="form-control" name="StudentLastName" value="' + response.student_data.StudentLastName + '"><label>นามสกุล</label></div></div>';
                    formHtml += '</div>';

                    formHtml += '<div class="row g-3 mb-3">';
                    formHtml += '<div class="col-md-4"><div class="form-floating"><input type="text" class="form-control" name="StudentCode" value="' + response.student_data.StudentCode + '" readonly><label>เลขประจำตัว</label></div></div>';
                    formHtml += '<div class="col-md-4"><div class="form-floating"><input type="text" class="form-control" name="StudentIDNumber" value="' + response.student_data.StudentIDNumber + '"><label>เลขประจำตัวประชาชน</label></div></div>';
                    formHtml += '<div class="col-md-4"><div class="form-floating"><input type="date" class="form-control" name="StudentDateBirth" value="' + response.student_data.StudentDateBirth + '"><label>วันเกิด</label></div></div>';
                    formHtml += '</div>';

                    formHtml += '<div class="row g-3 mb-3">';
                    formHtml += '<div class="col-md-4"><div class="form-floating"><select class="form-select" name="StudentClass"><option value="">เลือกระดับชั้น</option>';
                    response.class_list.forEach(cls => {
                        formHtml += '<option value="ม.' + cls + '" ' + (response.student_data.StudentClass === ('ม.' + cls) ? 'selected' : '') + '>ม.' + cls + '</option>';
                    });
                    formHtml += '</select><label>ระดับชั้น</label></div></div>';
                    formHtml += '<div class="col-md-4"><div class="form-floating"><input type="text" class="form-control" name="StudentNumber" value="' + response.student_data.StudentNumber + '"><label>เลขที่</label></div></div>';
                    formHtml += '<div class="col-md-4"><div class="form-floating"><select class="form-select" name="StudentStudyLine"><option value="">เลือกสายการเรียน</option>';
                    response.study_line_list.forEach(line => {
                        formHtml += '<option value="' + line + '" ' + (response.student_data.StudentStudyLine === line ? 'selected' : '') + '>' + line + '</option>';
                    });
                    formHtml += '</select><label>สายการเรียน</label></div></div>';
                    formHtml += '</div>';

                    formHtml += '<div class="row g-3 mb-3">';
                    formHtml += '<div class="col-md-6"><div class="form-floating"><select class="form-select" name="StudentStatus"><option value="">เลือกสถานะนักเรียน</option>';
                    ['1/ปกติ', '2/ย้ายสถานศึกษา', '3/ขาดประจำ', '4/พักการเรียน', '5/จบการศึกษา'].forEach(status => {
                        formHtml += '<option value="' + status + '" ' + (response.student_data.StudentStatus === status ? 'selected' : '') + '>' + status + '</option>';
                    });
                    formHtml += '</select><label>สถานะนักเรียน</label></div></div>';
                    formHtml += '<div class="col-md-6"><div class="form-floating"><select class="form-select" name="StudentBehavior"><option value="">เลือกสถานะพฤติกรรม</option>';
                    ['ปกติ', 'ขาดเรียนนาน', 'จำหน่าย'].forEach(behavior => {
                        formHtml += '<option value="' + behavior + '" ' + (response.student_data.StudentBehavior === behavior ? 'selected' : '') + '>' + behavior + '</option>';
                    });
                    formHtml += '</select><label>สถานะพฤติกรรม</label></div></div>';
                    formHtml += '</div>';

                    // Add more fields as needed, e.g., for personnel data
                    // For simplicity, I'm only adding a few common fields here.
                    // You would need to fetch and display all relevant fields from both tb_students and personnel.tb_students
                    // based on your update_student_details controller logic.

                    $('#studentDetailContent').html(formHtml);
                } else {
                    $('#studentDetailContent').html('<div class="alert alert-danger">ไม่พบข้อมูลนักเรียน</div>');
                }
            },
            error: function(xhr, status, error) {
                $('#studentDetailContent').html('<div class="alert alert-danger">เกิดข้อผิดพลาดในการดึงข้อมูล: ' + error + '</div>');
            }
        });
    });

    $('#editStudentForm').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
            url: '<?= site_url('Admin/Academic/ConAdminStudents/update_student_details') ?>',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire('สำเร็จ!', 'บันทึกข้อมูลนักเรียนเรียบร้อยแล้ว', 'success');
                    $('#studentDetailModal').modal('hide');
                    tbStudent.ajax.reload();
                } else {
                    Swal.fire('ผิดพลาด!', response.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' + error, 'error');
            }
        });
    });

    // Delete Student
    $(document).on('click', '.delete-student', function() {
        const studentId = $(this).data('id');
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "คุณต้องการลบข้อมูลนักเรียนนี้หรือไม่?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= site_url('Admin/Academic/ConAdminStudents/AdminStudentsDelete/') ?>' + studentId,
                    type: 'POST',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('ลบสำเร็จ!', response.message, 'success');
                            tbStudent.ajax.reload();
                        } else {
                            Swal.fire('ผิดพลาด!', response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาดในการลบข้อมูล: ' + error, 'error');
                    }
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>