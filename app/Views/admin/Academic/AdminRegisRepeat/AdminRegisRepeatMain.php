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

<div class="container-xl">
    <!-- Page Header -->
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="page-title mb-0">
                <i class="bx bx-refresh me-2"></i>จัดการข้อมูล<?= isset($title) ? esc($title) : '' ?>
            </h1>
            <p class="text-muted mb-0 mt-1">ปีการศึกษา: <strong id="header-selected-year"><?= isset($selectedYear) ? esc($selectedYear) : '' ?></strong></p>
        </div>
        <div class="col-auto">
            <button class="btn btn-warning" onclick="showStudentDetailsModal()">
                <i class="bx bx-show me-1"></i>ดูรายชื่อนักเรียนลงทะเรียน (ซ้ำ)
            </button>
        </div>
    </div>

    <!-- Dashboard Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Repeat Subjects Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-danger" id="stat-repeat-subjects"><?= isset($total_subjects_repeat) ? number_format($total_subjects_repeat) : 0 ?></div>
                            <div class="stat-label">รายวิชาที่มีเรียนซ้ำ</div>
                        </div>
                        <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                            <i class="bx bx-book-bookmark"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted" id="stat-repeat-year"><i class="bx bx-calendar me-1"></i>ในปีการศึกษา <?= isset($selectedYear) ? esc($selectedYear) : '-' ?></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Repeat Students Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-warning" id="stat-repeat-students"><?= isset($total_repeat_students) ? number_format($total_repeat_students) : 0 ?></div>
                            <div class="stat-label">นักเรียนเรียนซ้ำ</div>
                        </div>
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bx bx-user-x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted"><i class="bx bx-id-card me-1"></i><span id="stat-repeat-registrations"><?= isset($total_repeat_registrations) ? number_format($total_repeat_registrations) : 0 ?> รายการเรียนซ้ำ</span></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Repeat Teachers Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-info" id="stat-repeat-teachers"><?= isset($total_repeat_teachers) ? number_format($total_repeat_teachers) : 0 ?></div>
                            <div class="stat-label">ครูดูแลเรียนซ้ำ</div>
                        </div>
                        <div class="stat-icon bg-info bg-opacity-10 text-info">
                            <i class="bx bx-user-voice"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted"><i class="bx bx-chalkboard me-1"></i>รับผิดชอบนักเรียนเรียนซ้ำ</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Info Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-success" id="stat-selected-year"><?= isset($selectedYear) ? esc($selectedYear) : '-' ?></div>
                            <div class="stat-label">ปีการศึกษาที่เลือก</div>
                        </div>
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="bx bx-calendar-check"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted"><i class="bx bx-info-circle me-1"></i>ข้อมูลการเรียนซ้ำ</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Section -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-list-ul me-2"></i>รายการลงทะเบียนเรียนซ้ำ
                    </h5>
                </div>
                <div class="col-auto">
                    <div class="d-flex align-items-center gap-2">
                        <label for="CheckYearRegisRepeat" class="form-label mb-0 fw-medium">เลือกปี:</label>
                        <select class="form-select form-select-sm" id="CheckYearRegisRepeat" name="CheckYearRegisRepeat" style="width: auto; min-width: 140px;">
                            <?php foreach ($GroupYear as $key => $v_GroupYear) : ?>
                            <option <?= (isset($selectedYear) && isset($v_GroupYear->SubjectYear) && $selectedYear == $v_GroupYear->SubjectYear) ? "selected" : "" ?> value="<?= isset($v_GroupYear->SubjectYear) ? esc($v_GroupYear->SubjectYear) : '' ?>"><?= isset($v_GroupYear->SubjectYear) ? esc($v_GroupYear->SubjectYear) : '' ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <input type="hidden" name="schyear_year" id="schyear_year" value="<?= isset($SchoolYear->schyear_year) ? esc($SchoolYear->schyear_year) : '' ?>">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="tbRegisRepeatSubject">
                    <thead class="table-light">
                        <tr>
                            <th class="cell">เรียนปี</th>
                            <th class="cell">รหัสวิชา</th>
                            <th class="cell">ชื่อวิชา</th>
                            <th class="cell">กลุ่มสาระ</th>
                            <th class="cell">ชั้น</th>
                            <th class="cell">ครูผู้สอน</th>
                            <th class="cell text-center">คำสั่ง</th>
                            <th class="cell text-center">เรียนซ้ำ</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>



    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title ShowSubjectName" id="staticBackdropLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover" id="tb_ShowRegisRepeat">
                        <thead>
                            <tr>
                                <th scope="col">ห้อง</th>
                                <th scope="col">เลขที่</th>
                                <th scope="col">เลขประจำตัว</th>
                                <th scope="col">ชื่อ - นามสกุล</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Student Details Modal -->
    <div class="modal fade" id="StudentDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bx bx-user-circle me-2"></i>รายชื่อนักเรียนที่ลงทะเบียนเรียนซ้ำ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="bx bx-info-circle me-1"></i> รายชื่อนักเรียนที่ลงทะเบียนเรียนซ้ำในปีการศึกษา <strong id="student-modal-year"></strong>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover w-100" id="tb_StudentDetails">
                            <thead class="table-light">
                                <tr>
                                    <th>ห้อง</th>
                                    <th>เลขที่</th>
                                    <th>เลขประจำตัว</th>
                                    <th>ชื่อ - นามสกุล</th>
                                    <th class="text-center">จำนวนวิชา</th>
                                    <th>วิชาที่ลงทะเบียน</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                    <!-- <button type="button" class="btn btn-primary">Export PDF</button> -->
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
let tbRegisRepeatSubject;

// Initialize on page load
TB_RegisRepeatSubject($('#CheckYearRegisRepeat').val());

// Year change handler
$(document).on('change', '#CheckYearRegisRepeat', function() {
    var selectedYear = $(this).val();
    
    // Save selected year to session
    $.post("<?= site_url('Admin/SetSelectedYear') ?>", { year: selectedYear });
    
    // Reload table with new year
    TB_RegisRepeatSubject(selectedYear);
    
    // Update dashboard stats
    updateRepeatDashboardStats(selectedYear);
});

// Function to update dashboard statistics
function updateRepeatDashboardStats(year) {
    $.ajax({
        url: "<?= site_url('Admin/Academic/ConAdminRegisRepeat/getDashboardStats') ?>",
        type: "POST",
        data: { year: year },
        dataType: "json",
        beforeSend: function() {
            // Show loading animation on stat cards
            $('.stat-value').html('<i class="bx bx-loader-alt bx-spin"></i>');
        },
        success: function(response) {
            if (response.status === 'success') {
                var data = response.data;
                
                // Update stat cards with animation
                animateValue('#stat-repeat-subjects', data.total_subjects_repeat);
                animateValue('#stat-repeat-students', data.total_repeat_students);
                animateValue('#stat-repeat-teachers', data.total_repeat_teachers);
                
                // Update sub-text
                $('#stat-repeat-registrations').text(numberFormat(data.total_repeat_registrations) + ' รายการเรียนซ้ำ');
                $('#stat-repeat-year').html('<i class="bx bx-calendar me-1"></i>ในปีการศึกษา ' + data.year);
                $('#stat-selected-year').text(data.year);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching dashboard stats:', error);
        }
    });
}

// Function to show student details modal
function showStudentDetailsModal() {
    var year = $('#CheckYearRegisRepeat').val();
    $('#student-modal-year').text(year);
    $('#StudentDetailsModal').modal('show');
    
    if ($.fn.DataTable.isDataTable('#tb_StudentDetails')) {
        $('#tb_StudentDetails').DataTable().destroy();
    }
    
    $('#tb_StudentDetails').DataTable({
        destroy: true,
        processing: true,
        ajax: {
            url: "<?= site_url('Admin/Academic/ConAdminRegisRepeat/getRepeatStudentDetails') ?>",
            type: "POST",
            data: { year: year }
        },
        columns: [
            { data: 'StudentClass' },
            { data: 'StudentNumber' },
            { data: 'StudentCode' },
            { 
                data: null,
                render: function(data, type, row) {
                    return (data.StudentPrefix || '') + (data.StudentFirstName || '') + ' ' + (data.StudentLastName || '');
                }
            },
            { 
                data: 'SubjectCount',
                className: 'text-center',
                render: function(data) {
                    return '<span class="badge bg-label-warning">' + data + '</span>';
                }
            },
            { 
                data: 'RepeatedSubjects',
                render: function(data) {
                    return data ? '<small class="text-muted">' + data + '</small>' : '-';
                }
            }
        ],
        order: [[0, 'asc'], [1, 'asc']],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/th.json"
        }
    });
}
// Helper function to format numbers with commas
function numberFormat(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

// Helper function to animate stat value changes
function animateValue(selector, value) {
    $(selector).fadeOut(150, function() {
        $(this).text(numberFormat(value)).fadeIn(150);
    });
}

function TB_RegisRepeatSubject(Year) {
    tbRegisRepeatSubject = $('#tbRegisRepeatSubject').DataTable({
        destroy: true,
        "order": [
            [7, "desc"]
        ],
        'processing': true,
        "ajax": {
            url: "<?= site_url('admin/academic/ConAdminRegisRepeat/AdminRegisRepeatShow') ?>",
            "type": "POST",
            data: { "keyYear": Year }
        },
        'columns': [
            { data: 'SubjectYear' },
            { data: 'SubjectCode' },
            { data: 'SubjectName' },
            { data: 'FirstGroup' },
            { data: 'SubjectClass' },
            {
                data: 'TeacherName',
                render: function(data, type, row) {
                    return data;
                }
            },
            {
                data: 'SubjectID',
                render: function(data, type, row) {
                    return '<a class="btn-sm app-btn-primary" href="<?= site_url('Admin/Acade/Registration/Repeat/Detail/') ?>' + (row.SubjectYear ? row.SubjectYear : '') + '/' + (row.SubjectID ? row.SubjectID : '') + '/' + (row.TeacherID ? row.TeacherID : '') +'">ลงทะเบียนเรียนซ้ำ</a>';
                }
            },
            {
                data: 'SumRepeat',
                render: function(data, type, row) {
                    return '<span class="badge bg-warning text-black-50">' +data +' คน </span>';
                }
            }
        ]
    });
}

// The following functions related to displaying student details and canceling repeat registration
// will be placed here based on the original Academic.js structure.
$(document).on("click", ".ShowRegisRepeat", function() {

    $('#tb_ShowRegisRepeat tbody tr').remove();

    $.post("<?= site_url('admin/academic/ConAdminRegisRepeat/AdminRegisRepeatShow') ?>", {
        subid: $(this).attr('sub-id'),
        teachid: $(this).attr('teach-id')
    }, function(data, status) {
        //console.log(data);
        $('.ShowSubjectName').html("วิชา " + (data[0].SubjectName ? data[0].SubjectName : '') + "<br>ครูผู้สอน " + (data[0].pers_prefix ? data[0].pers_prefix : '') + (data[0].pers_firstname ? data[0].pers_firstname : '') + ' ' + (data[0].pers_lastname ? data[0].pers_lastname : ''));
        $.each(data, function(index, value) {
            $('#tb_ShowRegisRepeat tbody').append('<tr class="DelTableRow"><td>' + (value.StudentClass ? value.StudentClass : '') + '</td><td>' + (value.StudentNumber ? value.StudentNumber : '') + '</td><td>' + (value.StudentCode ? value.StudentCode : '') + '</td><td>' + (value.StudentPrefix ? value.StudentPrefix : '') + (value.StudentFirstName ? value.StudentFirstName : '') + ' ' + (value.StudentLastName ? value.StudentLastName : '') + '</td></tr>');
        });
    }, 'json');

});

$(document).on("click", ".CancelRegisRepeat", function() {
    console.log($(this).attr('key-teacher'));
    Swal.fire({
        title: 'ต้องการลบการลงทะเบียนหรือไม่?',
        text: 'เมื่อลบการลงทะเบียนวิชานี้แล้ว คะแนนและรายชื่อนักเรียนในวิชานี้ จะถูกลบทั้งหมด',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
    }).then((result) => {
        if (result.isConfirmed) {
            $(this).parents('tr').remove();

            $.post("<?= site_url('admin/academic/ConAdminRegisRepeat/AdminRegisRepeatCancel') ?>", {
                KeyTeacher: $(this).attr('key-teacher'),
                KeySubject: $(this).attr('key-subject')
            }, function(data, status) {
                console.log(data);

            });

            Swal.fire(
                'ลบข้อมูลเรียบร้อย!',
                'Your data has been deleted.',
                'success'
            )
        }
    })
});
</script>
<?= $this->endSection() ?>
