<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
.border-left-primary {
    border-left: .25rem solid #5BC3D5 !important;
}

.toolbar {
    float: left;
}

.dataTables_length {
    float: left;
}
</style>
<div class="">
    <div class="container-xl">

        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="page-title mb-0">จัดการข้อมูล<?= isset($title) ? esc($title) : '' ?></h1>
            </div>
            <div class="col-auto">
                <div class="page-utilities">
                    <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                        <div class="col-auto">
                        </div>
                        <div class="col-auto">
                            <a class="btn btn-primary"
                                href="<?= site_url('Admin/Acade/Registration/Enroll/Add/'). (isset($SchoolYear->schyear_year) ? $SchoolYear->schyear_year : '') ?>" title="ลงทะเบียนเรียน">
                                <i class="bx bx-plus-circle"></i> ลงทะเบียนเรียน
                            </a>
                        </div>
                    </div>
                    <!--//row-->
                </div>
                <!--//table-utilities-->
            </div>
            <!--//col-auto-->
        </div>
        <hr>
        <section class="we-offer-area">
            <div class="card card-orders-table pt-2">
                <div class="card-body">
                    <input type="text" name="schyear_year" id="schyear_year" value="<?= isset($SchoolYear->schyear_year) ? esc($SchoolYear->schyear_year) : '' ?>" style="display:none;">
                    <div class="card card-settings shadow-sm">
                        <div class="card-body">
                            <div class="mt-2 d-flex align-items-center justify-content-center">
                                <label for="">เลือกดูปี</label>
                                <select class="form-select w-auto ms-2" id="CheckYearEnroll" name="CheckYearEnroll">
                                    <?php foreach ($GroupYear as $key => $v_GroupYear) : ?>
                                    <option <?= isset($SchoolYear->schyear_year) && isset($v_GroupYear->SubjectYear) && $SchoolYear->schyear_year == $v_GroupYear->SubjectYear ? "selected" : ""?> value="<?= isset($v_GroupYear->SubjectYear) ? esc($v_GroupYear->SubjectYear) : '' ?>"><?= isset($v_GroupYear->SubjectYear) ? esc($v_GroupYear->SubjectYear) : '' ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive  p-3">
                        <table class="table table-hover mb-0 text-left" id="tbErollSubject">
                            <thead>
                                <tr>
                                    <th class="cell">ปีการศึกษา</th>
                                    <th class="cell">รหัสวิชา</th>
                                    <th class="cell">ชื่อวิชา</th>
                                    <th class="cell">กลุ่มสาระ</th>
                                    <th class="cell">ชั้น</th>
                                    <th class="cell">ครูผู้สอน</th>
                                    <th class="cell">นักเรียน</th>
                                    <th class="cell">คำสั่ง</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!--//table-responsive-->
                </div>
                <!--//card-body-->
            </div>

        </section>

        <!--//row-->
    </div>


</div>
<?= $this->endSection() ?>



<?= $this->section('script') ?>
<script>
let tbErollSubject;
TB_ErollSubject($('#schyear_year').val());
$(document).on('change', '#CheckYearEnroll', function() {
    //alert($(this).val());
    TB_ErollSubject($(this).val());
});

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
