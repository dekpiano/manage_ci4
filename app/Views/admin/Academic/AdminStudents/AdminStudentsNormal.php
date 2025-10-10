<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<input type="hidden" id="KeyStatus" value="<?= esc(service('request')->uri->getSegment(5) ?? '') ?>">
<div class="">
    <div class="">
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
    .truncate-text {
        max-width: 180px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: default;
    }

    /* Custom Modal Styles */
    #studentDetailModal .modal-content {
        background-color: #f8f9fa; /* A light gray background */
        border-radius: 0.5rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); /* A more prominent shadow */
        border: none;
    }
    #studentDetailModal .modal-header {
        border-bottom: none;
    }
    #studentDetailModal .modal-body {
        background-color: #ffffff; /* White background for the form area */
    }
    #studentDetailModal .modal-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
    }

    /* Custom styles for jquery.thailand.js typeahead dropdown */
    .twitter-typeahead {
        width: 100%; /* Make it fill the container */
    }
    .tt-menu {
        width: 100%;
        margin-top: 2px;
        padding: .5rem 0;
        background-color: #fff;
        border: 1px solid rgba(0,0,0,.15);
        border-radius: .25rem;
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.175);
        z-index: 1100; /* Ensure it appears above modal content */
    }
    .tt-suggestion {
        display: block;
        width: 100%;
        padding: .25rem 1.5rem;
        clear: both;
        font-weight: 400;
        color: #212529;
        text-align: inherit;
        white-space: nowrap;
        background-color: transparent;
        border: 0;
    }
    .tt-suggestion.tt-cursor, .tt-suggestion:hover {
        color: #1e2125;
        background-color: #e9ecef;
    }

    /* Fix for floating labels with jquery.thailand.js */
    .form-floating.label-floated> label {
        opacity: .65;
        transform: scale(.90) translateY(-.5rem) translateX(.15rem);
        
    }
.form-floating:focus label {
        opacity: .65;
        transform: scale(.90) translateY(-.5rem) translateX(.15rem);
        
    }
    .floating-new {
padding: 23px 14px 11px;
    }
    .form-control:focus {
    border-width: 2px;
    padding-block: calc(0.543rem - 2px);
    padding-inline: calc(0.9375rem - 2px);
    padding: 23px 14px 11px;
}
.floating-label-new{
    /* padding-top: 4px !important;  */
    /* font-size: 13px; */
}
</style>



<!-- Student Detail Modal -->
<div class="modal fade" id="studentDetailModal" tabindex="-1" aria-labelledby="studentDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="editStudentForm" method="post">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="studentDetailModalLabel">แก้ไขข้อมูลนักเรียน</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="studentDetailContent">
                        <!-- Student details form will be loaded here dynamically -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i> ปิด</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
// Function to fix floating labels for inputs wrapped by typeahead.js
function updateFloatingLabels() {
    // A slight delay to ensure value is updated by the library before we check it
    setTimeout(function() {
        $('.form-floating .twitter-typeahead .tt-input').each(function () {
            var $input = $(this);
            var $parent = $input.closest('.form-floating');
            // Use trim() to correctly handle empty or whitespace-only values
            if ($input.val() && $input.val().trim().length > 0) {
                $parent.addClass('label-floated');
            } else {
                $parent.removeClass('label-floated');
            }
        });
    }, 50);
}

$(document).ready(function() {
    // Display success message from session flashdata
    <?php if (session()->getFlashdata('msg') === 'YES'): ?>
        Swal.fire({
            icon: '<?= session()->getFlashdata('status') ?>',
            title: '<?= session()->getFlashdata('messge') ?>',
            showConfirmButton: false,
            timer: 2000
        });
    <?php endif; ?>

    const keyStatus = $('#KeyStatus').val();
    console.log('KeyStatus sent to controller:', keyStatus);
    const tbStudent = $('#tbStudent').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [[ 0, "asc" ]], // Default order by StudentCode
        "ajax": {
            "url": "<?= site_url('Admin/Academic/ConAdminStudents/AdminStudentsNormalShow/') ?>" + keyStatus,
            "type": "POST",
            "data": function (d) {
                d.classFilter = $('#classFilter').val();
                d.school_year = $('#school_year_filter').val() || '';
            }
        },
        "columns": [
            { "data": "StudentCode" },
            { 
                "data": "Fullname",
                "className": "truncate-text",
                "render": function(data, type, row) {
                    if (type === 'display') {
                        return '<span title="' + data + '">' + data + '</span>';
                    }
                    return data;
                }
            },
            { "data": "StudentClass" },
            { "data": "StudentNumber" },
            { 
                "data": "StudentStudyLine",
                "className": "truncate-text",
                "render": function(data, type, row) {
                    if (type === 'display') {
                        return '<span title="' + data + '">' + data + '</span>';
                    }
                    return data;
                }
            },
            { "data": "StudentStatus" },
            { "data": "StudentBehavior" },
            {
                "data": "StudentID",
                "render": function(data, type, row) {
                    return `
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-warning edit-student" data-id="${data}" title="แก้ไขข้อมูลนักเรียน">
                                <i class="bi bi-pencil-square"></i> แก้ไข
                            </button>
                            <button type="button" class="btn btn-sm btn-danger delete-student" data-id="${data}" title="ลบนักเรียน">
                                <i class="bi bi-trash"></i> ลบ
                            </button>
                        </div>
                    `;
                }
            }
        ]
    });

    // Filter by class
    $('#classFilter').on('change', function() {
        tbStudent.ajax.reload();
        
    });

    // Filter by school year
    $('#school_year_filter').on('change', function() {
        tbStudent.ajax.reload();
    });

    // Edit Student Modal
    $(document).on('click', '.edit-student', function() {
        const studentId = $(this).data('id');
        // Show loading spinner
        $('#studentDetailContent').html('<div class="text-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        // Show modal
        $('#studentDetailModal').modal('show');

        // Fetch form content
        $.ajax({
            url: '<?= site_url('Admin/Academic/ConAdminStudents/get_student_details/') ?>' + studentId,
            type: 'GET',
            success: function(responseHtml) {
                // Inject the returned HTML form
                $('#studentDetailContent').html(responseHtml);

                // Initialize Thailand Address Autocomplete
                $.Thailand({
                    database: 'https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/database/db.json',
                    
                    // Home Address
                    $district: $('#stu_hTambon'),
                    $amphoe: $('#stu_hDistrict'),
                    $province: $('#stu_hProvince'),
                    $zipcode: $('#stu_hPostCode'),
                });

                // Current Address
                $.Thailand({
                    database: 'https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/database/db.json',

                    $district: $('#stu_cTumbao'),
                    $amphoe: $('#stu_cDistrict'),
                    $province: $('#stu_cProvince'),
                    $zipcode: $('#stu_cPostcode'),
                });

                // --- FIX FOR FLOATING LABELS ---
                // Initial check for pre-filled values
                updateFloatingLabels();

                // Bind events for when the value changes
                $('#studentDetailContent').on('keyup change typeahead:change typeahead:select', '.twitter-typeahead .tt-input', updateFloatingLabels);

            },
            error: function(xhr, status, error) {
                // Show error message
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
                console.log('Response from update_student_details:', response);
                if (response.status === 'success') {
                    Swal.fire('สำเร็จ!', 'บันทึกข้อมูลนักเรียนเรียบร้อยแล้ว', 'success');
                    $('#studentDetailModal').modal('hide');
                    tbStudent.ajax.reload();
                } else {
                    Swal.fire('ผิดพลาด!', response.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' + xhr.responseText, 'error');
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