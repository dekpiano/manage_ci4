<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
.table-danger,
.table-danger>th,
.table-danger>td {
    background-color: #f8d7da !important;
}

.table-info,
.table-info>th,
.table-info>td {
    background-color: #cff4fc !important;
}
</style>

<div class="content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">

        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="page-title mb-0">จัดการข้อมูลลงทะเบียนเรียนซ้ำ</h1>
                <?php if(isset($DataRepeat) && $DataRepeat) :?>
                <div class="text-muted">
                    <?= (isset($DataRepeat[0]->SubjectCode) ? 'รหัสวิชา: ' . esc($DataRepeat[0]->SubjectCode) : '') . ' ' . (isset($DataRepeat[0]->SubjectName) ? 'ชื่อวิชา: ' . esc($DataRepeat[0]->SubjectName) : '') ?>
                    <?php
                        $subjectTeacherName = '';
                        // Assuming DataRepeatTeacher[0]->RepeatTeacher holds the pers_id of the regular teacher for this subject.
                        // If this is not the correct source, the controller needs to provide a specific variable for this.
                        if (isset($DataRepeat[0]->SubjectID) && isset($DataRepeatTeacher[0]->RepeatTeacher)) {
                            $defaultTeacherId = $DataRepeatTeacher[0]->RepeatTeacher;
                            foreach ($Teacher as $v_Teache) {
                                if (isset($v_Teache->pers_id) && $v_Teache->pers_id == $defaultTeacherId) {
                                    $subjectTeacherName = (isset($v_Teache->pers_prefix) ? esc($v_Teache->pers_prefix) : '') .
                                                          (isset($v_Teache->pers_firstname) ? esc($v_Teache->pers_firstname) : '') . ' ' .
                                                          (isset($v_Teache->pers_lastname) ? esc($v_Teache->pers_lastname) : '');
                                    break;
                                }
                            }
                        }
                        if (!empty($subjectTeacherName)) {
                            echo ' (ครูผู้สอน: ' . $subjectTeacherName . ')';
                        }
                    ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-auto">
                <a class="btn btn-secondary" href="<?= site_url('Admin/Acade/Registration/Repeat') ?>">
                    <i class="bi-arrow-left"></i> ย้อนกลับ
                </a>
            </div>
        </div>

        <?php if(isset($DataRepeat) && $DataRepeat) :?>
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="statusFilter" class="form-label">สถานะ:</label>
                        <select id="statusFilter" class="form-select">
                            <option value="ทั้งหมด">ทั้งหมด</option>
                            <option value="ต้องเรียนซ้ำ" selected>ต้องเรียนซ้ำ</option>
                            <option value="ลงทะเบียนเรียนซ้ำ">ลงทะเบียนเรียนซ้ำ</option>
                            <option value="ผ่านการเรียนซ้ำ">ผ่านการเรียนซ้ำ</option>
                            <option value="เรียนปกติ">เรียนปกติ</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="classFilter" class="form-label">ห้องเรียน:</label>
                        <select id="classFilter" class="form-select">
                            <option value="ทั้งหมด">ทั้งหมด</option>
                            <?php
                        $uniqueClasses = [];
                        foreach ($DataRepeat as $v_DataRepeat) {
                            if (isset($v_DataRepeat->StudentClass)) {
                                $uniqueClasses[$v_DataRepeat->StudentClass] = $v_DataRepeat->StudentClass;
                            }
                        }
                        sort($uniqueClasses); // Sort classes numerically/alphabetically
                        foreach ($uniqueClasses as $class) {
                            echo '<option value="' . esc($class) . '">' . esc($class) . '</option>';
                        }
                    ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>



        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="bi-person-lines-fill"></i> รายชื่อนักเรียน
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-left" id="students-table">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 40px;">เลือกที่เรียนซ้ำ</th>
                                <th>ห้อง</th>
                                <th>เลขที่</th>
                                <th>รหัสประจำตัว</th>
                                <th>ชื่อนักเรียน</th>
                                <th>ผลการเรียนเดิม</th>
                                <th>สถานะ</th>
                                <th>ครูผู้สอน</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($DataRepeat as $key => $v_DataRepeat) : ?>
                            <?php
                                $isRegisteredForRepeat = (isset($v_DataRepeat->RepeatStatus) && $v_DataRepeat->RepeatStatus == "ไม่ผ่าน");
                                $hasPassedRepeat = (isset($v_DataRepeat->RepeatStatus) && $v_DataRepeat->RepeatStatus == "ผ่าน");
                                $needsRepeat = (isset($v_DataRepeat->Grade) && ($v_DataRepeat->Grade == "มส" ||  $v_DataRepeat->Grade <= 0));

                                $rowClass = '';
                                $statusText = 'เรียนปกติ';
                                $statusClass = 'badge bg-secondary';

                                if ($hasPassedRepeat) {
                                    $rowClass = 'table-success';
                                    $statusText = 'ผ่านการเรียนซ้ำ'; // Simplified for data-status
                                    $statusClass = 'badge bg-success';
                                } elseif ($isRegisteredForRepeat) {
                                    $rowClass = 'table-info';
                                    $statusText = 'ลงทะเบียนเรียนซ้ำ'; // Simplified for data-status
                                    $statusClass = 'badge bg-info';
                                } elseif ($needsRepeat) {
                                    $rowClass = 'table-danger';
                                    $statusText = 'ต้องเรียนซ้ำ'; // Simplified for data-status
                                    $statusClass = 'badge bg-danger';
                                }
                            ?>
                            <tr class="<?= $rowClass ?>" data-status="<?= $statusText ?>"
                                data-class="<?= isset($v_DataRepeat->StudentClass) ? esc($v_DataRepeat->StudentClass) : '' ?>">
                                <td class="text-center">
                                    <input type="checkbox" name="SelRepeat[]" data-bs-target=".myModal"
                                        value="<?= isset($v_DataRepeat->StudentID) ? esc($v_DataRepeat->StudentID) : '' ?>"
                                        class="form-check-input SelRepeat"
                                        <?= $isRegisteredForRepeat ? "checked" : "" ?>>
                                </td>
                                <td class="text-center">
                                    <?= isset($v_DataRepeat->StudentClass) ? esc($v_DataRepeat->StudentClass) : '' ?>
                                </td>
                                <td class="text-center">
                                    <?= isset($v_DataRepeat->StudentNumber) ? esc($v_DataRepeat->StudentNumber) : '' ?>
                                </td>
                                <td class="text-center">
                                    <?= isset($v_DataRepeat->StudentCode) ? esc($v_DataRepeat->StudentCode) : '' ?></td>
                                <td>
                                    <?= (isset($v_DataRepeat->StudentPrefix) ? esc($v_DataRepeat->StudentPrefix) : '').(isset($v_DataRepeat->StudentFirstName) ? esc($v_DataRepeat->StudentFirstName) : '').' '.(isset($v_DataRepeat->StudentLastName) ? esc($v_DataRepeat->StudentLastName) : '') ?>
                                </td>
                                <td class="text-center">
                                    <?= isset($v_DataRepeat->Grade) ? esc($v_DataRepeat->Grade) : '' ?></td>
                                <td class="text-center"><span class="<?= $statusClass ?>"><?= $statusText ?></span></td>
                                <td><?= isset($v_DataRepeat->RepeatTeacherName) ? esc($v_DataRepeat->RepeatTeacherName) : '' ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php else :  ?>
        <div class="card shadow-sm text-center border-left-decoration">
            <div class="card-body p-5">
                <div class="icon-stack icon-stack-lg bg-primary-soft text-primary mb-4">
                    <i class="bi-info-circle"></i>
                </div>
                <h3>ยังไม่มีข้อมูลการลงทะเบียนเรียน</h3>
                <p class="text-muted">ไม่พบข้อมูลนักเรียนที่ต้องลงทะเบียนเรียนซ้ำในรายวิชานี้</p>
                <a class="btn btn-primary" href="<?= site_url('Admin/Acade/Registration/Repeat') ?>">ย้อนกลับ</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- โมเดล -->
<div class="modal fade myModal" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">เลือกครูสอน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="FormRegisRepeatUpdate" method="post">
                <div class="modal-body">
                    <select name="RepeatTeacher" id="RepeatTeacher" class="form-select">
                        <option value="">เลือกครูสอน...</option>
                        <?php
                        // Assuming $defaultSubjectTeacherId is provided by the controller
                        // and holds the pers_id of the teacher who regularly teaches this subject.
                        // If not, DataRepeatTeacher[0]->RepeatTeacher is used as a fallback/last assigned teacher.
                        $defaultTeacherToSelect = isset($DataRepeat[0]->TeacherID) ? $DataRepeat[0]->TeacherID : null;
                        // If a more specific 'regular teacher' ID is passed from the controller, use it here.
                        // Example: $defaultTeacherToSelect = isset($defaultSubjectTeacherId) ? $defaultSubjectTeacherId : $defaultTeacherToSelect;

                        foreach ($Teacher as $key => $v_Teache):
                            $isSelected = '';
                            if (isset($v_Teache->pers_id) && $defaultTeacherToSelect !== null && $defaultTeacherToSelect == $v_Teache->pers_id) {
                                $isSelected = 'selected';
                            }
                        ?>
                        <option <?= $isSelected ?>
                            value="<?= isset($v_Teache->pers_id) ? esc($v_Teache->pers_id) : '' ?>">
                            <?= (isset($v_Teache->pers_prefix) ? esc($v_Teache->pers_prefix) : '').(isset($v_Teache->pers_firstname) ? esc($v_Teache->pers_firstname) : '').' '.(isset($v_Teache->pers_lastname) ? esc($v_Teache->pers_lastname) : '') ?>
                        </option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="modal-footer">
                    <input type="text" name="StuID" id="StuID" value="" style="display:none;">
                    <input type="text" id="YearRepeat" name="YearRepeat"
                        value="<?= isset($DataRepeat[0]->RegisterYear) ? esc($DataRepeat[0]->RegisterYear) : '' ?>"
                        style="display:none;">
                    <input type="text" id="SubjectRepeat" name="SubjectRepeat"
                        value="<?= isset($DataRepeat[0]->SubjectID) ? esc($DataRepeat[0]->SubjectID) : '' ?>"
                        style="display:none;">

                    <button type="submit" class="btn btn-primary" id="btnSaveRepeat">บันทึก</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
var lastCheckedCheckbox = null; // ตัวแปรเก็บ checkbox ล่าสุดที่ถูกติ๊ก
// เมื่อ checkbox ถูกคลิก
$(document).on("change", '.SelRepeat', function() {
    var targetModal = $(this).data('bs-target'); // ได้ค่าจาก data-bs-target (เช่น .myModal)

    if ($(this).is(':checked')) {
        $('#StuID').val($(this).val()); // ได้ค่าจาก data-bs-target (เช่น .myModal)

        $(targetModal).modal('show'); // ใช้ jQuery เปิดโมเดล
        lastCheckedCheckbox = $(this); // เก็บ checkbox ที่ถูกติ๊ก
    } else {
        // ถ้า checkbox ไม่ถูกเลือกให้ปิดโมเดล
        lastCheckedCheckbox = $(this);
        Swal.fire({
            title: 'คำถาม?',
            text: "คุณต้องการถอนเรียนออกจากเรียนซ้ำหรือไม่?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: '<?= site_url('admin/academic/ConAdminRegisRepeat/AdminRegisRepeatAdd') ?>',
                    type: 'post',
                    data: {
                        DelStuID: $(this).val(),
                        YearRepeat: $('#YearRepeat').val(),
                        SubjectRepeat: $('#SubjectRepeat').val(),
                        DelStatus: "Del"
                    },
                    error: function() {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'ระบบผิดพลาด ลองใหม่อีกครั้ง!',
                            showConfirmButton: false,
                            timer: 3000
                        })
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status === 'success') {
                            $(targetModal).modal('hide'); // ใช้ jQuery ปิดโมเดล
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: response.message + ' (' + response
                                    .affected_rows + ' แถว)',
                                showConfirmButton: false,
                                timer: 3000
                            }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    location.reload(true);
                                }
                            });

                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'warning',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 3000
                            })
                        }

                    }
                });

            } else {
                lastCheckedCheckbox.prop('checked', true);
                lastCheckedCheckbox = null;
            }
        });

        $(targetModal).modal('hide'); // ใช้ jQuery ปิดโมเดล
    }
});

// เมื่อโมเดลถูกปิด (ทั้งจากปุ่มปิดหรือคลิกภายนอก)
$('.myModal').on('hidden.bs.modal', function() {
    // รีเซ็ต checkbox ที่เกี่ยวข้องกับโมเดลนั้นๆ ที่ถูกเลือกเท่านั้น
    if (lastCheckedCheckbox) {
        lastCheckedCheckbox.prop('checked', false); // รีเซ็ต checkbox ที่ถูกติ๊ก
        lastCheckedCheckbox = null; // รีเซ็ตตัวแปรเพื่อไม่ให้เก็บค่าไว้
    }

});



$(document).on("submit", "#FormRegisRepeatUpdate", function(e) {
    e.preventDefault();
    //console.log($(this).serialize());
    $.ajax({
        url: '<?= site_url('admin/academic/ConAdminRegisRepeat/AdminRegisRepeatAdd') ?>',
        type: 'post',
        data: $(this).serialize(),
        error: function() {
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'ระบบผิดพลาด ลองใหม่อีกครั้ง!',
                showConfirmButton: false,
                timer: 3000
            })
        },
        success: function(response) {
            console.log(response);
            if (response.status === 'success') {
                $('#myModal').modal('hide'); // ใช้ jQuery ปิดโมเดล
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: response.message + ' (' + response.affected_rows + ' แถว)',
                    showConfirmButton: false,
                    timer: 3000
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        location.reload(true);
                    }
                });

            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'warning',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 3000
                })
            }

        }
    });
});

// Filter logic
function filterStudents() {
    const selectedStatus = $('#statusFilter').val();
    const selectedClass = $('#classFilter').val();

    $('#students-table tbody tr').each(function() {
        const rowStatus = $(this).data('status');
        const rowClass = $(this).data('class');

        const statusMatch = (selectedStatus === 'ทั้งหมด' || rowStatus === selectedStatus);
        const classMatch = (selectedClass === 'ทั้งหมด' || rowClass === selectedClass);

        if (statusMatch && classMatch) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
}

$(document).ready(function() {
    // Initial filter on page load
    filterStudents();

    // Attach change event listeners to filters
    $('#statusFilter, #classFilter').on('change', filterStudents);
});
</script>
<?= $this->endSection() ?>