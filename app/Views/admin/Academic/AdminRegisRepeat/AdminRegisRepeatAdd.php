<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
/* ===== Custom CSS Variables - Green Theme #15a362 ===== */
:root {
    --primary-green: #15a362;
    --primary-green-dark: #128a52;
    --primary-green-light: #1bc676;
    --gradient-green: linear-gradient(135deg, #15a362 0%, #1bc676 50%, #20c997 100%);
}

/* ===== Welcome Banner ===== */
.welcome-banner {
    background: var(--gradient-green);
    border-radius: 16px;
    padding: 1.75rem 2rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 15px 40px rgba(21, 163, 98, 0.25);
}
.welcome-banner::before {
    content: '';
    position: absolute;
    top: -50px;
    right: -50px;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}
.welcome-banner .content { position: relative; z-index: 1; }
.welcome-banner h1 { font-size: 1.5rem; font-weight: 700; color: #fff; margin-bottom: 0.5rem; }
.welcome-banner .subject-info {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 0.75rem;
    margin-top: 0.75rem;
}
.welcome-banner .subject-badge {
    background: rgba(255, 255, 255, 0.2);
    padding: 0.4rem 0.8rem;
    border-radius: 25px;
    color: #fff;
    font-weight: 600;
    font-size: 0.85rem;
}
.welcome-banner .teacher-text {
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.9rem;
}
.welcome-banner .icon-wrapper {
    font-size: 4rem;
    color: rgba(255, 255, 255, 0.12);
    position: absolute;
    right: 1.5rem;
    top: 50%;
    transform: translateY(-50%);
}
.btn-back {
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: #fff;
    padding: 0.5rem 1rem;
    border-radius: 10px;
    font-weight: 500;
    transition: all 0.3s ease;
}
.btn-back:hover {
    background: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.5);
    color: #fff;
}

/* ===== Controls Card ===== */
.controls-card {
    border-radius: 12px;
    border: none;
    overflow: hidden;
}
.controls-card .card-header {
    background: transparent;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    padding: 1rem 1.25rem;
}
.controls-card .card-header h5 { font-weight: 600; color: #212529; margin: 0; }
.controls-card .card-header h5 i { color: var(--primary-green); }

/* ===== Table Card ===== */
.table-card {
    border-radius: 12px;
    border: none;
    overflow: hidden;
}
.table-card .card-header {
    background: transparent;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    padding: 1rem 1.25rem;
}
.table-card .card-header h5 { font-weight: 600; color: #212529; margin: 0; }
.table-card .card-header h5 i { color: var(--primary-green); }

/* ===== Table Styling ===== */
#students-table thead th {
    background: linear-gradient(180deg, #f8f9fa 0%, #e9ecef 100%);
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    color: #495057;
    padding: 0.85rem 1rem;
    border-bottom: 2px solid #dee2e6;
}
#students-table tbody td {
    padding: 0.75rem 1rem;
    vertical-align: middle;
    border-bottom: 1px solid rgba(0, 0, 0, 0.03);
}
#students-table tbody tr:hover { background: rgba(21, 163, 98, 0.04) !important; }

/* Row Status Colors */
#students-table tbody tr.table-danger { background: rgba(220, 53, 69, 0.08) !important; }
#students-table tbody tr.table-info { background: rgba(23, 162, 184, 0.1) !important; }
#students-table tbody tr.table-success { background: rgba(21, 163, 98, 0.1) !important; }

/* ===== Buttons ===== */
.btn-register {
    background: var(--gradient-green);
    border: none;
    color: #fff;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}
.btn-register:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(21, 163, 98, 0.35);
    color: #fff;
}
.btn-view-students {
    background: linear-gradient(135deg, #ffc107 0%, #ffda44 100%);
    border: none;
    color: #212529;
    padding: 0.5rem 1rem;
    border-radius: 10px;
    font-weight: 500;
    transition: all 0.3s ease;
}
.btn-view-students:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4);
    color: #212529;
}

/* ===== Custom Checkbox ===== */
.form-check-input {
    width: 1.25em;
    height: 1.25em;
    cursor: pointer;
}
.form-check-input:checked {
    background-color: var(--primary-green);
    border-color: var(--primary-green);
}
.form-check-input:focus {
    border-color: var(--primary-green);
    box-shadow: 0 0 0 3px rgba(21, 163, 98, 0.2);
}

/* ===== Select2 Styling ===== */
.select2-container--bootstrap-5 .select2-selection {
    border-radius: 8px;
    border: 2px solid #e9ecef;
}
.select2-container--bootstrap-5 .select2-selection--single:focus,
.select2-container--bootstrap-5.select2-container--focus .select2-selection {
    border-color: var(--primary-green);
    box-shadow: 0 0 0 3px rgba(21, 163, 98, 0.15);
}

/* ===== Badges ===== */
.selection-badge {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(135deg, rgba(21, 163, 98, 0.1) 0%, rgba(21, 163, 98, 0.2) 100%);
    padding: 0.4rem 0.85rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.8rem;
    color: var(--primary-green);
}
.selection-badge i { margin-right: 0.35rem; }

.status-badge {
    padding: 0.35rem 0.7rem;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.8rem;
}
.status-badge.danger { background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); color: #721c24; }
.status-badge.info { background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%); color: #0c5460; }
.status-badge.success { background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); color: var(--primary-green); }
.status-badge.secondary { background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%); color: #495057; }

.grade-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 10px;
    font-weight: 700;
    font-size: 1rem;
}
.grade-badge.fail { background: linear-gradient(135deg, #dc3545 0%, #ff6b6b 100%); color: #fff; }
.grade-badge.pass { background: linear-gradient(135deg, #15a362 0%, #20c997 100%); color: #fff; }

/* ===== Modal Styling ===== */
.modal .modal-content { border-radius: 12px; border: none; overflow: hidden; }
#SubjectStudentDetailsModal .modal-header {
    background: var(--gradient-green);
    border-bottom: none;
    padding: 1rem 1.25rem;
}
#SubjectStudentDetailsModal .modal-header .modal-title { color: #fff; font-weight: 600; }
#SubjectStudentDetailsModal .modal-header .btn-close { filter: brightness(0) invert(1); opacity: 0.8; }

/* ===== Empty State ===== */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}
.empty-state i {
    font-size: 5rem;
    color: #e9ecef;
    margin-bottom: 1.5rem;
}
.empty-state h5 { color: #6c757d; font-weight: 600; }
.empty-state p { color: #adb5bd; font-size: 0.9rem; }
</style>

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Welcome Banner -->
    <div class="welcome-banner mb-4">
        <div class="content">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="bx bx-edit-alt me-2"></i>จัดการข้อมูลลงทะเบียนเรียนซ้ำ</h1>
                    <?php if(isset($DataRepeat) && $DataRepeat) :?>
                    <div class="subject-info">
                        <span class="subject-badge">
                            <i class="bx bx-book-alt me-1"></i><?= isset($DataRepeat[0]->SubjectCode) ? esc($DataRepeat[0]->SubjectCode) : '' ?>
                        </span>
                        <span class="teacher-text"><?= isset($DataRepeat[0]->SubjectName) ? esc($DataRepeat[0]->SubjectName) : '' ?></span>
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
                                echo '<span class="teacher-text"><i class="bx bx-user me-1"></i>ครูผู้สอน: ' . $subjectTeacherName . '</span>';
                            }
                        ?>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-4 text-end d-none d-md-block">
                    <button class="btn-view-students me-2" onclick="showSubjectStudentDetailsModal()">
                        <i class="bx bx-show me-1"></i>ดูรายชื่อนักเรียน
                    </button>
                    <a class="btn-back" href="<?= site_url('Admin/Acade/Registration/Repeat') ?>">
                        <i class="bx bx-arrow-back me-1"></i>ย้อนกลับ
                    </a>
                </div>
            </div>
        </div>
        <div class="icon-wrapper d-none d-lg-block">
            <i class="bx bxs-book-reader"></i>
        </div>
    </div>

    <?php if(isset($DataRepeat) && $DataRepeat) :?>
    
    <!-- Controls Card -->
    <div class="card controls-card shadow-sm mb-4">
        <div class="card-header">
            <h5><i class="bx bx-slider-alt me-2"></i>ตัวเลือกและการจัดการ</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <!-- Filters -->
                <div class="col-md-3">
                    <label for="statusFilter" class="form-label fw-semibold"><i class="bx bx-filter me-1"></i>สถานะ:</label>
                    <select id="statusFilter" class="form-select">
                        <option value="ทั้งหมด">ทั้งหมด</option>
                        <option value="ต้องเรียนซ้ำ" selected>ต้องเรียนซ้ำ</option>
                        <option value="ลงทะเบียนเรียนซ้ำ">ลงทะเบียนเรียนซ้ำ</option>
                        <option value="ผ่านการเรียนซ้ำ">ผ่านการเรียนซ้ำ</option>
                        <option value="เรียนปกติ">เรียนปกติ</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="classFilter" class="form-label fw-semibold"><i class="bx bx-door-open me-1"></i>ห้องเรียน:</label>
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
                
                <!-- Vertical Divider -->
                <div class="col-md-1 d-none d-md-flex justify-content-center align-items-center">
                    <div class="vr h-100 text-muted"></div>
                </div>

                <!-- Bulk Actions -->
                <div class="col-md-5">
                   <label class="form-label fw-semibold text-success"><i class="bx bx-check-double me-1"></i>การจัดการแบบกลุ่ม:</label>
                   <div class="d-flex gap-2 align-items-end">
                        <div class="flex-grow-1">
                            <select id="GlobalTeacherSelect" class="form-select">
                            <option value="">เลือกครูเพื่อลงทะเบียน...</option>
                            <?php 
                            $regularTeacherID = isset($DataRepeat[0]->TeacherID) ? $DataRepeat[0]->TeacherID : null;
                            
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
                        <button id="BtnBulkRegister" class="btn btn-register" disabled>
                            <i class="bx bx-check-circle me-1"></i>ลงทะเบียน
                        </button>
                        <button id="BtnBulkCancel" class="btn btn-outline-danger" disabled>
                            <i class="bx bx-trash me-1"></i>ยกเลิก
                        </button>
                   </div>
                   <small class="text-muted mt-1 d-block"><i class="bx bx-info-circle me-1"></i>เลือกนักเรียนในตารางด้านล่างเพื่อดำเนินการ</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Students Table Card -->
    <div class="card table-card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5><i class="bx bx-list-ul me-2"></i>รายชื่อนักเรียน</h5>
            <span class="selection-badge" id="SelectionCount"><i class="bx bx-user-check"></i>เลือก 0 คน</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="students-table">
                    <thead>
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

                            $statusText = 'เรียนปกติ';
                            $statusClass = 'secondary';
                            $rowClass = '';
                            $gradeClass = (isset($v_DataRepeat->Grade) && ($v_DataRepeat->Grade == "มส" || $v_DataRepeat->Grade <= 0)) ? 'fail' : 'pass';

                            if ($hasPassedRepeat) {
                                $statusText = 'ผ่านการเรียนซ้ำ'; 
                                $statusClass = 'success';
                                $rowClass = 'table-success';
                            } elseif ($isRegisteredForRepeat) {
                                $statusText = 'ลงทะเบียนเรียนซ้ำ';
                                $statusClass = 'info';
                                $rowClass = 'table-info';
                            } elseif ($needsRepeat) {
                                $statusText = 'ต้องเรียนซ้ำ';
                                $statusClass = 'danger';
                                $rowClass = 'table-danger';
                            }
                        ?>
                        <tr class="<?= $rowClass ?>" data-status="<?= $statusText ?>"
                            data-class="<?= isset($v_DataRepeat->StudentClass) ? esc($v_DataRepeat->StudentClass) : '' ?>">
                            <td class="text-center">
                                <input type="checkbox" name="SelRepeat[]" 
                                    value="<?= isset($v_DataRepeat->StudentID) ? esc($v_DataRepeat->StudentID) : '' ?>"
                                    class="form-check-input SelRepeat"
                                    <?= $hasPassedRepeat ? 'disabled' : '' ?>>
                            </td>
                            <td class="text-center">
                                <span class="fw-semibold"><?= isset($v_DataRepeat->StudentClass) ? esc($v_DataRepeat->StudentClass) : '' ?></span>
                            </td>
                            <td class="text-center"><?= isset($v_DataRepeat->StudentNumber) ? esc($v_DataRepeat->StudentNumber) : '' ?></td>
                            <td class="text-center">
                                <span class="fw-medium"><?= isset($v_DataRepeat->StudentCode) ? esc($v_DataRepeat->StudentCode) : '' ?></span>
                            </td>
                            <td class="fw-medium ps-4">
                                <?= (isset($v_DataRepeat->StudentPrefix) ? esc($v_DataRepeat->StudentPrefix) : '').(isset($v_DataRepeat->StudentFirstName) ? esc($v_DataRepeat->StudentFirstName) : '').' '.(isset($v_DataRepeat->StudentLastName) ? esc($v_DataRepeat->StudentLastName) : '') ?>
                            </td>
                            <td class="text-center">
                                <span class="grade-badge <?= $gradeClass ?>"><?= isset($v_DataRepeat->Grade) ? esc($v_DataRepeat->Grade) : '' ?></span>
                            </td>
                            <td class="text-center">
                                <span class="status-badge <?= $statusClass ?>"><?= $statusText ?></span>
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
    <!-- Empty State -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="empty-state">
                <i class="bx bx-info-circle"></i>
                <h5>ยังไม่มีข้อมูลการลงทะเบียนเรียน</h5>
                <p>ไม่พบข้อมูลนักเรียนที่ต้องลงทะเบียนเรียนซ้ำในรายวิชานี้ หรือยังไม่มีการดึงข้อมูลเข้าระบบ</p>
                <a class="btn btn-register mt-3" href="<?= site_url('Admin/Acade/Registration/Repeat') ?>">
                    <i class="bx bx-arrow-back me-1"></i>ย้อนกลับไปหน้ารวม
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Student Details Modal for Specific Subject -->
<div class="modal fade" id="SubjectStudentDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bx bx-user-circle me-2"></i>รายชื่อนักเรียนที่ลงทะเบียนเรียนซ้ำ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success d-flex align-items-center">
                    <i class="bx bx-book-alt bx-sm me-2"></i>
                    <div>รายวิชา: <strong><?= isset($DataRepeat[0]->SubjectCode) ? esc($DataRepeat[0]->SubjectCode) : '' ?> <?= isset($DataRepeat[0]->SubjectName) ? esc($DataRepeat[0]->SubjectName) : '' ?></strong></div>
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
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x me-1"></i>ปิด
                </button>
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
    
    if ($.fn.DataTable.isDataTable('#tb_SubjectStudentDetails')) {
        $('#tb_SubjectStudentDetails').DataTable().destroy();
    }
    
    var subjectID = $('#SubjectRepeat').val();
    
    $('#tb_SubjectStudentDetails').DataTable({
        destroy: true,
        processing: true,
        ajax: {
            url: "<?= site_url('Admin/Academic/ConAdminRegisRepeat/getRepeatStudentDetailsBySubject') ?>",
            type: "POST",
            data: { subject_id: subjectID }
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
                    return data ? '<span class="text-success"><i class="bx bx-user me-1"></i>' + data + '</span>' : '-';
                }
            },
            { 
                 data: 'RepeatYear',
                 className: 'text-center',
                 render: function(data) {
                    return data ? '<span class="badge bg-label-success">' + data + '</span>' : '-';
                }
             }
        ],
        order: [[0, 'asc'], [1, 'asc']],
        language: {
            processing: '<div class="py-3"><div class="spinner-border text-success"></div></div>',
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
        dropdownParent: $('body')
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
            }
        });
        updateSelectionState();
    }

    $('#statusFilter, #classFilter').on('change', filterStudents);
    filterStudents();

    // --- 2. Selection Logic ---
    $('#SelectAll').on('change', function() {
        const isChecked = $(this).is(':checked');
        $('.SelRepeat:visible:not(:disabled)').prop('checked', isChecked);
        updateSelectionState();
    });

    $(document).on('change', '.SelRepeat', function() {
        updateSelectionState();
        const allVisible = $('.SelRepeat:visible:not(:disabled)');
        const allChecked = $('.SelRepeat:visible:checked');
        $('#SelectAll').prop('checked', allVisible.length > 0 && allVisible.length === allChecked.length);
        $('#SelectAll').prop('indeterminate', allChecked.length > 0 && allChecked.length < allVisible.length);
    });

    function updateSelectionState() {
        const checkedCount = $('.SelRepeat:checked').length;
        $('#SelectionCount').html('<i class="bx bx-user-check me-1"></i>เลือก ' + checkedCount + ' คน');
        const teacherSelected = $('#GlobalTeacherSelect').val() !== '';
        $('#BtnBulkRegister').prop('disabled', !(checkedCount > 0 && teacherSelected));
        $('#BtnBulkCancel').prop('disabled', !(checkedCount > 0));
    }

    $('#GlobalTeacherSelect').on('change', updateSelectionState);

    // --- 3. Action Logic ---
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
            confirmButtonColor: '#15a362',
            confirmButtonText: '<i class="bx bx-check me-1"></i>ยืนยัน',
            cancelButtonText: '<i class="bx bx-x me-1"></i>ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                performBulkAction('register', selectedStudents, teacherID);
            }
        });
    });

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
            confirmButtonColor: '#dc3545',
            confirmButtonText: '<i class="bx bx-trash me-1"></i>ยืนยันลบ',
            cancelButtonText: '<i class="bx bx-x me-1"></i>ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                performBulkAction('delete', selectedStudents, null);
            }
        });
    });

    function performBulkAction(action, studentIDs, teacherID) {
        const formData = {
            YearRepeat: $('#YearRepeat').val(),
            SubjectRepeat: $('#SubjectRepeat').val(),
        };

        if (action === 'register') {
            formData.StuID = studentIDs;
            formData.RepeatTeacher = teacherID;
        } else if (action === 'delete') {
            formData.DelStuID = studentIDs;
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
                    html: '<div class="py-3"><div class="spinner-border text-success" style="width: 3rem; height: 3rem;"></div></div>',
                    allowOutsideClick: false,
                    showConfirmButton: false
                });
            },
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ!',
                        text: response.message + ' (' + response.affected_rows + ' รายการ)',
                        confirmButtonColor: '#15a362',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: response.message,
                        confirmButtonColor: '#dc3545'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง',
                    confirmButtonColor: '#dc3545'
                });
            }
        });
    }

});
</script>
<?= $this->endSection() ?>