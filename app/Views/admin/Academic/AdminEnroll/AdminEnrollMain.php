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
.year-selector-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}
</style>

<div class="container-xl">
    <!-- Page Header -->
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="page-title mb-0">
                <i class="bx bx-book-open me-2"></i>จัดการข้อมูล<?= isset($title) ? esc($title) : '' ?>
            </h1>
            <p class="text-muted mb-0 mt-1">ปีการศึกษา: <strong><?= isset($selectedYear) ? esc($selectedYear) : '' ?></strong></p>
        </div>
        <div class="col-auto">
            <a class="btn btn-primary" href="<?= site_url('Admin/Acade/Registration/Enroll/Add/'). (isset($SchoolYear->schyear_year) ? $SchoolYear->schyear_year : '') ?>" title="ลงทะเบียนเรียน">
                <i class="bx bx-plus-circle me-1"></i> ลงทะเบียนเรียน
            </a>
        </div>
    </div>

    <!-- Dashboard Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Subjects Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-primary" id="stat-total-subjects"><?= isset($total_subjects) ? number_format($total_subjects) : 0 ?></div>
                            <div class="stat-label">รายวิชาทั้งหมด</div>
                        </div>
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bx bx-book"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted" id="stat-selected-year"><i class="bx bx-calendar me-1"></i>ในปีการศึกษา <?= isset($selectedYear) ? esc($selectedYear) : '-' ?></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Registered Students Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-success" id="stat-total-students"><?= isset($total_registered_students) ? number_format($total_registered_students) : 0 ?></div>
                            <div class="stat-label">นักเรียนลงทะเบียน</div>
                        </div>
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="bx bx-user-check"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted"><i class="bx bx-id-card me-1"></i><span id="stat-total-registrations"><?= isset($total_registrations) ? number_format($total_registrations) : 0 ?> รายการลงทะเบียน</span></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teachers Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-info" id="stat-total-teachers"><?= isset($total_teachers) ? number_format($total_teachers) : 0 ?></div>
                            <div class="stat-label">ครูผู้สอน</div>
                        </div>
                        <div class="stat-icon bg-info bg-opacity-10 text-info">
                            <i class="bx bx-user-circle"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted"><i class="bx bx-chalkboard me-1"></i>มีรายวิชาสอน</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subject Groups Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-warning" id="stat-total-groups"><?= isset($total_groups) ? number_format($total_groups) : 0 ?></div>
                            <div class="stat-label">กลุ่มสาระการเรียนรู้</div>
                        </div>
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bx bx-category"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted"><i class="bx bx-layer me-1"></i>เปิดสอนในปีนี้</small>
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
                        <i class="bx bx-list-ul me-2"></i>รายการลงทะเบียนเรียน
                    </h5>
                </div>
                <div class="col-auto">
                    <div class="d-flex align-items-center gap-2">
                        <label for="CheckYearEnroll" class="form-label mb-0 fw-medium">เลือกปี:</label>
                        <select class="form-select form-select-sm" id="CheckYearEnroll" name="CheckYearEnroll" style="width: auto; min-width: 140px;">
                            <?php foreach ($GroupYear as $key => $v_GroupYear) : ?>
                            <option <?= isset($selectedYear) && isset($v_GroupYear->SubjectYear) && $selectedYear == $v_GroupYear->SubjectYear ? "selected" : ""?> value="<?= isset($v_GroupYear->SubjectYear) ? esc($v_GroupYear->SubjectYear) : '' ?>"><?= isset($v_GroupYear->SubjectYear) ? esc($v_GroupYear->SubjectYear) : '' ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <input type="hidden" name="schyear_year" id="schyear_year" value="<?= isset($SchoolYear->schyear_year) ? esc($SchoolYear->schyear_year) : '' ?>">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="tbErollSubject">
                    <thead class="table-light">
                        <tr>
                            <th class="cell">ปีการศึกษา</th>
                            <th class="cell">รหัสวิชา</th>
                            <th class="cell">ชื่อวิชา</th>
                            <th class="cell">กลุ่มสาระ</th>
                            <th class="cell">ชั้น</th>
                            <th class="cell">ครูผู้สอน</th>
                            <th class="cell text-center">นักเรียน</th>
                            <th class="cell text-center">คำสั่ง</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>



<?= $this->section('script') ?>
<script>
let tbErollSubject;

// Initialize on page load
TB_ErollSubject($('#CheckYearEnroll').val());

// Year change handler
$(document).on('change', '#CheckYearEnroll', function() {
    var selectedYear = $(this).val();
    
    // Save selected year to session
    $.post("<?= site_url('Admin/SetSelectedYear') ?>", { year: selectedYear });
    
    // Reload table with new year
    TB_ErollSubject(selectedYear);
    
    // Update dashboard stats
    updateDashboardStats(selectedYear);
});

// Function to update dashboard statistics
function updateDashboardStats(year) {
    $.ajax({
        url: "<?= site_url('Admin/Academic/ConAdminEnroll/getDashboardStats') ?>",
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
                animateValue('#stat-total-subjects', data.total_subjects);
                animateValue('#stat-total-students', data.total_registered_students);
                animateValue('#stat-total-teachers', data.total_teachers);
                animateValue('#stat-total-groups', data.total_groups);
                
                // Update sub-text
                $('#stat-total-registrations').text(numberFormat(data.total_registrations) + ' รายการลงทะเบียน');
                $('#stat-selected-year').text('ในปีการศึกษา ' + data.year);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching dashboard stats:', error);
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

function TB_ErollSubject(Year) {
    tbErollSubject = $('#tbErollSubject').DataTable({
        destroy: true,
        "order": [
            [1, "asc"]
        ],
        'processing': true,
        "ajax": {
            url: "<?= site_url('Admin/Academic/ConAdminEnroll/AdminEnrollSubject') ?>",
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
                    return '<span class="badge bg-success rounded-pill ShowEnroll" sub-id="' + row.SubjectID + '" teach-id="' + row.TeacherID + '" year-id="' + row.SubjectYear + '">ลงทะเบียนแล้ว</span>';
                }
            },
            {
                data: 'SubjectID',
                render: function(data, type, row) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="คำสั่ง">' +
                        '<a href="<?= site_url('Admin/Acade/Registration/Enroll/Edit/') ?>' + row.SubjectID + '/' + row.TeacherID + '" class="btn btn-success text-white" title="จัดการนักเรียน"><i class="bx bx-edit"></i></a>' +
                        '<a href="<?= site_url('Admin/Acade/Registration/Enroll/Delete/') ?>' + row.SubjectID + '/' + row.TeacherID + '" class="btn btn-warning" title="ถอนรายชื่อ / เปลี่ยนครูสอน"><i class="bx bx-transfer"></i></a>' +
                        '<a href="#" class="btn btn-danger text-white CancelEnroll" key-subject="' + row.SubjectID + '" key-teacher="' + row.TeacherID + '" title="ลบลงทะเบียน"><i class="bx bx-trash"></i></a>' +
                        '</div>';
                }
            }
        ]
    });
}

$(document).on("click", ".ShowEnroll", function() {
    const subId = $(this).attr('sub-id');
    const teachId = $(this).attr('teach-id');
    const yearId = $(this).attr('year-id');

    $.post("<?= site_url('admin/academic/ConAdminEnroll/AdminEnrollShow') ?>", {
        subid: subId,
        teachid: teachId,
        yearid: yearId
    }, function(data, status) {
        if (data && data.length > 0) {
            const subjectName = data[0].SubjectName;
            const teacherName = data[0].pers_prefix + data[0].pers_firstname + ' ' + data[0].pers_lastname;
            let tableContent = `
                <p><strong>วิชา:</strong> ${subjectName}</p>
                <p><strong>ครูผู้สอน:</strong> ${teacherName}</p>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ห้อง</th>
                            <th scope="col">เลขที่</th>
                            <th scope="col">เลขประจำตัว</th>
                            <th scope="col">ชื่อ - นามสกุล</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            $.each(data, function(index, value) {
                tableContent += `
                    <tr>
                        <td>${value.StudentClass}</td>
                        <td>${value.StudentNumber}</td>
                        <td>${value.StudentCode}</td>
                        <td>${value.StudentPrefix}${value.StudentFirstName} ${value.StudentLastName}</td>
                    </tr>
                `;
            });
            tableContent += `
                    </tbody>
                </table>
            `;

            Swal.fire({
                title: 'รายชื่อนักเรียนที่ลงทะเบียนแล้ว',
                html: tableContent,
                icon: 'info',
                width: '80%',
                showCloseButton: true,
                showConfirmButton: false,
                focusConfirm: false,
            });
        } else {
            Swal.fire({
                title: 'ไม่พบข้อมูล',
                text: 'ไม่พบนักเรียนที่ลงทะเบียนในวิชานี้',
                icon: 'warning',
                confirmButtonText: 'ตกลง'
            });
        }
    }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
        Swal.fire({
            title: 'เกิดข้อผิดพลาด',
            text: 'ไม่สามารถดึงข้อมูลได้: ' + textStatus,
            icon: 'error',
            confirmButtonText: 'ตกลง'
        });
    });
});

$(document).on("click", ".CancelEnroll", function() {
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

            $.post("<?= site_url('admin/academic/ConAdminEnroll/AdminEnrollCancel') ?>", {
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
