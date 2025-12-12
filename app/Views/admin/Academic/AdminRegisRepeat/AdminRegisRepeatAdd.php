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

/* Custom Checkbox Size */
.form-check-input {
    width: 1.25em;
    height: 1.25em;
    cursor: pointer;
}
</style>

<div class="content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">

        <!-- Header -->
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="page-title mb-0">จัดการข้อมูลลงทะเบียนเรียนซ้ำ</h1>
                <?php if(isset($DataRepeat) && $DataRepeat) :?>
                <div class="text-muted mt-2">
                    <span class="badge bg-primary me-2"><?= isset($DataRepeat[0]->SubjectCode) ? esc($DataRepeat[0]->SubjectCode) : '' ?></span>
                    <?= isset($DataRepeat[0]->SubjectName) ? esc($DataRepeat[0]->SubjectName) : '' ?>
                    <?php
                        $subjectTeacherName = '';
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
                            echo '<span class="ms-2 text-muted"><i class="bx bx-user me-1"></i>ครูผู้สอน: ' . $subjectTeacherName . '</span>';
                        }
                    ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-auto">
                <button class="btn btn-warning me-2" onclick="showSubjectStudentDetailsModal()">
                    <i class="bx bx-show me-1"></i>ดูรายชื่อนักเรียน
                </button>
                <a class="btn btn-label-secondary" href="<?= site_url('Admin/Acade/Registration/Repeat') ?>">
                    <i class="bx bx-arrow-back me-1"></i> ย้อนกลับ
                </a>
            </div>
        </div>

        <?php if(isset($DataRepeat) && $DataRepeat) :?>
        
        <!-- Controls Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header border-bottom">
                <h5 class="card-title mb-0"><i class="bx bx-slider-alt me-2"></i>ตัวเลือกและการจัดการ</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <!-- Filters -->
                    <div class="col-md-3">
                        <label for="statusFilter" class="form-label fw-bold">สถานะ:</label>
                        <select id="statusFilter" class="form-select">
                            <option value="ทั้งหมด">ทั้งหมด</option>
                            <option value="ต้องเรียนซ้ำ" selected>ต้องเรียนซ้ำ</option>
                            <option value="ลงทะเบียนเรียนซ้ำ">ลงทะเบียนเรียนซ้ำ</option>
                            <option value="ผ่านการเรียนซ้ำ">ผ่านการเรียนซ้ำ</option>
                            <option value="เรียนปกติ">เรียนปกติ</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="classFilter" class="form-label fw-bold">ห้องเรียน:</label>
                        <select id="classFilter" class="form-select">
                            <option value="ทั้งหมด">ทั้งหมด</option>
                            <?php
                        $uniqueClasses = [];
                        foreach ($DataRepeat as $v_DataRepeat) {
                            if (isset($v_DataRepeat->StudentClass)) {
                                $uniqueClasses[$v_DataRepeat->StudentClass] = $v_DataRepeat->StudentClass;
                            }
                        }
                        sort($uniqueClasses); 
                        foreach ($uniqueClasses as $class) {
                            echo '<option value="' . esc($class) . '">' . esc($class) . '</option>';
                        }
                    ?>
                        </select>
                    </div>
                    
                    <!-- Vertical Divider (Visual only in larger screens) -->
                    <div class="col-md-1 d-none d-md-flex justify-content-center align-items-center">
                        <div class="vr h-100 text-muted"></div>
                    </div>

                    <!-- Bulk Actions -->
                    <div class="col-md-5">
                       <label class="form-label fw-bold text-primary">การจัดการแบบกลุ่ม (Bulk Action):</label>
                       <div class="d-flex gap-2 align-items-end">
                            <div class="flex-grow-1">
                                <select id="GlobalTeacherSelect" class="form-select">
                                <option value="">เลือกครูเพื่อลงทะเบียน...</option>
                                <?php 
                                $regularTeacherID = isset($DataRepeat[0]->TeacherID) ? $DataRepeat[0]->TeacherID : null;
                                
                                // Organize teachers: Regular one first
                                $sortedTeachers = [];
                                $regularTeacherObj = null;
                                
                                foreach ($Teacher as $t) {
                                    if ($regularTeacherID && isset($t->pers_id) && $t->pers_id == $regularTeacherID) {
                                        $regularTeacherObj = $t;
                                    } else {
                                        $sortedTeachers[] = $t;
                                    }
                                }
                                
                                if ($regularTeacherObj) {
                                    array_unshift($sortedTeachers, $regularTeacherObj);
                                }
                                
                                foreach ($sortedTeachers as $v_Teache): 
                                    $isRegular = ($regularTeacherID && isset($v_Teache->pers_id) && $v_Teache->pers_id == $regularTeacherID);
                                    $selected = $isRegular ? 'selected' : '';
                                    $tName = (isset($v_Teache->pers_prefix) ? esc($v_Teache->pers_prefix) : '').(isset($v_Teache->pers_firstname) ? esc($v_Teache->pers_firstname) : '').' '.(isset($v_Teache->pers_lastname) ? esc($v_Teache->pers_lastname) : '');
                                    if ($isRegular) $tName .= ' (ครูประจำวิชา)';
                                ?>
                                <option value="<?= isset($v_Teache->pers_id) ? esc($v_Teache->pers_id) : '' ?>" <?= $selected ?>>
                                    <?= $tName ?>
                                </option>
                                <?php endforeach;?>
                            </select>
                            </div>
                            <button id="BtnBulkRegister" class="btn btn-primary" disabled>
                                <i class="bx bx-check-circle me-1"></i>ลงทะเบียน
                            </button>
                            <button id="BtnBulkCancel" class="btn btn-outline-danger" disabled>
                                <i class="bx bx-trash me-1"></i>ยกเลิก
                            </button>
                       </div>
                       <small class="text-muted mt-1 d-block">* เลือกนักเรียนในตารางด้านล่างเพื่อดำเนินการ</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Students Table Card -->
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <h5 class="card-title mb-0">
                    <i class="bx bx-list-ul me-2"></i>รายชื่อนักเรียน
                </h5>
                <span class="badge bg-label-primary" id="SelectionCount">เลือก 0 คน</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0 text-left align-middle" id="students-table">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th style="width: 50px;">
                                    <input type="checkbox" id="SelectAll" class="form-check-input">
                                </th>
                                <th>ห้อง</th>
                                <th>เลขที่</th>
                                <th>รหัสประจำตัว</th>
                                <th class="text-start ps-4">ชื่อ - นามสกุล</th>
                                <th>ผลการเรียนเดิม</th>
                                <th>สถานะ</th>
                                <th>ครูผู้สอน (เรียนซ้ำ)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($DataRepeat as $key => $v_DataRepeat) : ?>
                            <?php
                                $isRegisteredForRepeat = (isset($v_DataRepeat->RepeatStatus) && $v_DataRepeat->RepeatStatus == "ไม่ผ่าน");
                                $hasPassedRepeat = (isset($v_DataRepeat->RepeatStatus) && $v_DataRepeat->RepeatStatus == "ผ่าน");
                                $needsRepeat = (isset($v_DataRepeat->Grade) && ($v_DataRepeat->Grade == "มส" ||  $v_DataRepeat->Grade <= 0));

                                // Logic for display status text and class
                                $statusText = 'เรียนปกติ';
                                $statusBadgeClass = 'badge bg-label-secondary';
                                $rowClass = '';

                                if ($hasPassedRepeat) {
                                    $statusText = 'ผ่านการเรียนซ้ำ'; 
                                    $statusBadgeClass = 'badge bg-success';
                                    $rowClass = 'table-success';
                                } elseif ($isRegisteredForRepeat) {
                                    $statusText = 'ลงทะเบียนเรียนซ้ำ';
                                    $statusBadgeClass = 'badge bg-info';
                                    $rowClass = 'table-info';
                                } elseif ($needsRepeat) {
                                    $statusText = 'ต้องเรียนซ้ำ';
                                    $statusBadgeClass = 'badge bg-danger';
                                    $rowClass = 'table-danger';
                                }
                            ?>
                            <tr class="<?= $rowClass ?>" data-status="<?= $statusText ?>"
                                data-class="<?= isset($v_DataRepeat->StudentClass) ? esc($v_DataRepeat->StudentClass) : '' ?>">
                                <td class="text-center">
                                    <input type="checkbox" name="SelRepeat[]" 
                                        value="<?= isset($v_DataRepeat->StudentID) ? esc($v_DataRepeat->StudentID) : '' ?>"
                                        class="form-check-input SelRepeat"
                                        <?= $hasPassedRepeat ? 'disabled' : '' ?>> <!-- Disable if passed -->
                                </td>
                                <td class="text-center font-monospace">
                                    <?= isset($v_DataRepeat->StudentClass) ? esc($v_DataRepeat->StudentClass) : '' ?>
                                </td>
                                <td class="text-center">
                                    <?= isset($v_DataRepeat->StudentNumber) ? esc($v_DataRepeat->StudentNumber) : '' ?>
                                </td>
                                <td class="text-center">
                                    <?= isset($v_DataRepeat->StudentCode) ? esc($v_DataRepeat->StudentCode) : '' ?></td>
                                <td class="fw-medium ps-4">
                                    <?= (isset($v_DataRepeat->StudentPrefix) ? esc($v_DataRepeat->StudentPrefix) : '').(isset($v_DataRepeat->StudentFirstName) ? esc($v_DataRepeat->StudentFirstName) : '').' '.(isset($v_DataRepeat->StudentLastName) ? esc($v_DataRepeat->StudentLastName) : '') ?>
                                </td>
                                <td class="text-center fw-bold text-danger">
                                    <?= isset($v_DataRepeat->Grade) ? esc($v_DataRepeat->Grade) : '' ?>
                                </td>
                                <td class="text-center">
                                    <span class="<?= $statusBadgeClass ?>"><?= $statusText ?></span>
                                    <?php if (($hasPassedRepeat || $isRegisteredForRepeat) && isset($v_DataRepeat->RepeatYear) && !empty($v_DataRepeat->RepeatYear)): ?>
                                        <div class="small text-muted mt-1">
                                            <i class="bx bx-calendar-alt me-1"></i><?= esc($v_DataRepeat->RepeatYear) ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center text-muted small">
                                    <?= isset($v_DataRepeat->RepeatTeacherName) && !empty($v_DataRepeat->RepeatTeacherName) ? '<i class="bx bx-user me-1"></i>'.esc($v_DataRepeat->RepeatTeacherName) : '-' ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Hidden Inputs for context -->
        <input type="hidden" id="YearRepeat" value="<?= isset($DataRepeat[0]->RegisterYear) ? esc($DataRepeat[0]->RegisterYear) : '' ?>">
        <input type="hidden" id="SubjectRepeat" value="<?= isset($DataRepeat[0]->SubjectID) ? esc($DataRepeat[0]->SubjectID) : '' ?>">

        <?php else :  ?>
        <div class="card shadow-sm text-center border-left-decoration">
            <div class="card-body p-5">
                <div class="icon-stack icon-stack-lg bg-label-primary text-primary mb-4 rounded-circle d-inline-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 2rem;">
                    <i class="bx bx-info-circle"></i>
                </div>
                <h3>ยังไม่มีข้อมูลการลงทะเบียนเรียน</h3>
                <p class="text-muted">ไม่พบข้อมูลนักเรียนที่ต้องลงทะเบียนเรียนซ้ำในรายวิชานี้ หรือยังไม่มีการดึงข้อมูลเข้าระบบ</p>
                <a class="btn btn-primary mt-3" href="<?= site_url('Admin/Acade/Registration/Repeat') ?>">ย้อนกลับไปหน้ารวม</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Student Details Modal for Specific Subject -->
<div class="modal fade" id="SubjectStudentDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bx bx-user-circle me-2"></i>รายชื่อนักเรียนที่ลงทะเบียนเรียนซ้ำในรายวิชานี้</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="bx bx-info-circle me-1"></i> รายวิชา: <strong><?= isset($DataRepeat[0]->SubjectCode) ? esc($DataRepeat[0]->SubjectCode) : '' ?> <?= isset($DataRepeat[0]->SubjectName) ? esc($DataRepeat[0]->SubjectName) : '' ?></strong>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover w-100" id="tb_SubjectStudentDetails">
                        <thead class="table-light">
                            <tr>
                                <th>ห้อง</th>
                                <th>เลขที่</th>
                                <th>เลขประจำตัว</th>
                                <th>ชื่อ - นามสกุล</th>
                                <th>ครูผู้สอน (เรียนซ้ำ)</th>
                                <th>ปีการศึกษา</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
// Function to show student details modal for this subject
function showSubjectStudentDetailsModal() {
    $('#SubjectStudentDetailsModal').modal('show');
    
    // Check if DataTable already exists and clear it, or initialize it
    if ($.fn.DataTable.isDataTable('#tb_SubjectStudentDetails')) {
        $('#tb_SubjectStudentDetails').DataTable().destroy();
    }
    
    // We already have the data in $DataRepeat (PHP variable), so we can filter and process it here in JS
    // This avoids another AJAX call if the data is already on the page.
    // However, if we want strict consistency with backend state (in case of updates), AJAX is better.
    // BUT since we just want to see "Registered" students for *this* subject, we can re-use the page data for instant feedback.
    
    // Let's filter the data from the table present on the page!
    // Or better, let's fetch it via AJAX to be 100% sure we get the current DB state, 
    // especially since we have bulk updates that might not refresh the whole page immediately in some designs (though here we do reload).
    
    var subjectID = $('#SubjectRepeat').val();
    
    $('#tb_SubjectStudentDetails').DataTable({
        destroy: true,
        processing: true,
        ajax: {
            url: "<?= site_url('Admin/Academic/ConAdminRegisRepeat/getRepeatStudentDetailsBySubject') ?>",
            type: "POST",
            data: { 
                subject_id: subjectID
            }
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
                data: 'RepeatTeacherName',
                 render: function(data) {
                    return data ? '<span class="text-primary"><i class="bx bx-user me-1"></i>' + data + '</span>' : '-';
                }
            },
            { 
                 data: 'RepeatYear',
                 className: 'text-center',
                 render: function(data) {
                    return data ? '<span class="badge bg-label-info">' + data + '</span>' : '-';
                }
             }
        ],
        order: [[0, 'asc'], [1, 'asc']],
         language: {
            url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/th.json"
        }
    });
}

$(document).ready(function() {
    
    // --- 0. Initialize Select2 ---
    $('#GlobalTeacherSelect').select2({
        theme: 'bootstrap-5',
        placeholder: 'เลือกครูเพื่อลงทะเบียน...',
        allowClear: true,
        width: '100%',
        dropdownParent: $('body') // Ensure dropdown isn't clipped if in a modal/card
    });

    // --- 1. Filtering Logic ---
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
                // If hiding a row, uncheck it to avoid action on hidden items
                // Use a check to prevent unnecessary unchecking if the user wants to keep selection across filters? 
                // Usually safer to uncheck or just ignore in bulk action logic.
                // For simplicity, let's keep them checked but visible only.
            }
        });
        updateSelectionState(); // update buttons
    }

    $('#statusFilter, #classFilter').on('change', filterStudents);
    filterStudents(); // Run on load

    // --- 2. Selection Logic (Select All & Individual) ---
    
    // Select All Checkbox
    $('#SelectAll').on('change', function() {
        const isChecked = $(this).is(':checked');
        // Only select visible checkboxes
        $('.SelRepeat:visible:not(:disabled)').prop('checked', isChecked);
        updateSelectionState();
    });

    // Individual Checkbox
    $(document).on('change', '.SelRepeat', function() {
        updateSelectionState();
        
        // Update SelectAll state
        const allVisible = $('.SelRepeat:visible:not(:disabled)');
        const allChecked = $('.SelRepeat:visible:checked');
        $('#SelectAll').prop('checked', allVisible.length > 0 && allVisible.length === allChecked.length);
        $('#SelectAll').prop('indeterminate', allChecked.length > 0 && allChecked.length < allVisible.length);
    });

    // Update Buttons State based on selection
    function updateSelectionState() {
        const checkedCount = $('.SelRepeat:checked').length;
        $('#SelectionCount').text('เลือก ' + checkedCount + ' คน');

        const teacherSelected = $('#GlobalTeacherSelect').val() !== '';
        
        // Register Button: Needs selection AND teacher
        $('#BtnBulkRegister').prop('disabled', !(checkedCount > 0 && teacherSelected));
        
        // Cancel Button: Needs selection only
        $('#BtnBulkCancel').prop('disabled', !(checkedCount > 0));
    }

    $('#GlobalTeacherSelect').on('change', updateSelectionState);

    // --- 3. Action Logic (Register & Cancel) ---

    // Register Button Click
    $('#BtnBulkRegister').click(function() {
        const teacherID = $('#GlobalTeacherSelect').val();
        const teacherName = $('#GlobalTeacherSelect option:selected').text().trim();
        const selectedStudents = [];
        
        $('.SelRepeat:checked').each(function() {
            selectedStudents.push($(this).val());
        });

        if (selectedStudents.length === 0 || !teacherID) return;

        Swal.fire({
            title: 'ยืนยันลงทะเบียน?',
            html: `ต้องการลงทะเบียนให้นักเรียน <b>${selectedStudents.length} คน</b><br>กับครู <b>${teacherName}</b> ใช่หรือไม่?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0d6efd', /* Bootstrap primary */
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                performBulkAction('register', selectedStudents, teacherID);
            }
        });
    });

    // Cancel Button Click
    $('#BtnBulkCancel').click(function() {
        const selectedStudents = [];
        $('.SelRepeat:checked').each(function() {
            selectedStudents.push($(this).val());
        });

        if (selectedStudents.length === 0) return;

        Swal.fire({
            title: 'ยืนยันยกเลิก?',
            html: `ต้องการยกเลิกการลงทะเบียนของนักเรียน <b>${selectedStudents.length} คน</b> ใช่หรือไม่?<br><small class="text-danger">ข้อมูลการเรียนซ้ำจะถูกลบออก</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545', /* Bootstrap danger */
            confirmButtonText: 'ยืนยันลบ',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                performBulkAction('delete', selectedStudents, null);
            }
        });
    });

    // Core AJAX Function
    function performBulkAction(action, studentIDs, teacherID) {
        // Prepare Data
        const formData = {
            YearRepeat: $('#YearRepeat').val(),
            SubjectRepeat: $('#SubjectRepeat').val(),
        };

        if (action === 'register') {
            formData.StuID = studentIDs; // Array
            formData.RepeatTeacher = teacherID;
        } else if (action === 'delete') {
            formData.DelStuID = studentIDs; // Array
            formData.DelStatus = "Del";
        }

        $.ajax({
            url: '<?= site_url('admin/academic/ConAdminRegisRepeat/AdminRegisRepeatAdd') ?>',
            type: 'post',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                Swal.fire({
                    title: 'กำลังบันทึก...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ!',
                        text: response.message + ' (' + response.affected_rows + ' รายการ)',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง'
                });
            }
        });
    }

});
</script>
<?= $this->endSection() ?>