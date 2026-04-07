<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>

<style>
    :root {
        --primary-emerald: #15a362;
        --dark-emerald: #0d6d41;
        --light-emerald: #e8f5ee;
        --border-radius: 16px;
    }

    /* Hero Header */
    .hero-settings {
        background: linear-gradient(135deg, var(--primary-emerald) 0%, var(--dark-emerald) 100%);
        border-radius: var(--border-radius);
        padding: 2rem 2.5rem;
        color: white;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(21, 163, 98, 0.15);
    }

    .hero-settings::after {
        content: '';
        position: absolute;
        bottom: -20%;
        right: -5%;
        width: 300px; height: 300px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        pointer-events: none;
    }

    /* Stats Card Premium */
    .stat-card-premium {
        border: none;
        border-radius: var(--border-radius);
        background: white;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border-left: 5px solid transparent;
        height: 100%;
    }

    .stat-card-premium:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }

    .stat-card-primary { border-left-color: #696cff; }
    .stat-card-success { border-left-color: var(--primary-emerald); }
    .stat-card-warning { border-left-color: #ffab00; }
    .stat-card-danger { border-left-color: #ff3e1d; }

    .stat-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    /* Teacher Card */
    .teacher-card-premium {
        border: none;
        border-radius: var(--border-radius);
        background: white;
        transition: all 0.3s;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid rgba(0,0,0,0.03);
    }

    .teacher-card-premium:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        border-color: var(--primary-emerald);
    }

    .teacher-avatar-wrapper {
        position: relative;
        padding-top: 1.5rem;
        margin-bottom: 1rem;
    }

    .avatar-premium {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    /* Utils */
    .text-emerald { color: var(--primary-emerald) !important; }
    .bg-emerald { background-color: var(--primary-emerald) !important; }
    .btn-emerald {
        background-color: var(--primary-emerald);
        border-color: var(--primary-emerald);
        color: white;
    }
    .btn-emerald:hover {
        background-color: var(--dark-emerald);
        border-color: var(--dark-emerald);
        color: white;
    }
    .btn-outline-emerald {
        color: var(--primary-emerald);
        border-color: var(--primary-emerald);
    }
    .btn-outline-emerald:hover {
        background-color: var(--primary-emerald);
        border-color: var(--primary-emerald);
        color: white;
    }

    .badge-emerald {
        background-color: var(--light-emerald);
        color: var(--primary-emerald);
    }

    .modal-emerald-header {
        background: linear-gradient(135deg, var(--primary-emerald) 0%, var(--dark-emerald) 100%);
        border: none;
    }

    .table-premium thead th {
        background-color: #f8f9fa;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #566a7f;
        padding: 1rem;
        border-top: none;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y animate__animated animate__fadeIn">
    <!-- Hero Header -->
    <div class="hero-settings">
        <div class="row align-items-center">
            <div class="col-md-7">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/academic/checkplan') ?>" class="text-white opacity-75">เลือกกลุ่มสาระ</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">ตรวจสอบแผน</li>
                    </ol>
                </nav>
                <h2 class="fw-bold mb-1 text-white">ตรวจสอบความคืบหน้าแผนการสอน</h2>
                <p class="mb-0 text-white opacity-75">
                    <i class="bx bx-group me-1"></i> <?= esc($title) ?> | 
                    <span class="badge bg-white text-emerald ms-2 px-3"><?= esc($selected_year_term) ?></span>
                </p>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                <form action="<?= current_url() ?>" method="get" id="yearTermForm" class="d-inline-block">
                    <div class="input-group input-group-merge shadow-sm" style="border-radius: 12px; overflow: hidden;">
                        <span class="input-group-text border-0 ps-3 bg-white text-emerald"><i class="bx bx-calendar"></i></span>
                        <select name="year_term" id="year_term_select" class="form-select border-0 pe-4" style="background-color: white;" onchange="document.getElementById('yearTermForm').submit();">
                            <?php foreach ($year_terms as $yt) : ?>
                                <option value="<?= $yt->seplan_year . '/' . $yt->seplan_term ?>"
                                    <?= ($selected_year_term == ($yt->seplan_year . '/' . $yt->seplan_term)) ? 'selected' : '' ?>>
                                    ปีการศึกษา <?= $yt->seplan_year ?> / เทอม <?= $yt->seplan_term ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Logic for Stats -->
    <?php
    $totalTeachers = count($groupedPlans);
    $countComplete = 0; $countPartial = 0; $countNotSent = 0;
    foreach ($groupedPlans as $teacher) {
        $plans = is_array($teacher) ? ($teacher['plans'] ?? []) : ($teacher->plans ?? []);
        $filesUploaded = 0;
        foreach ($plans as $plan) {
            $p_file = is_array($plan) ? ($plan['seplan_file'] ?? null) : ($plan->seplan_file ?? null);
            if (!empty($p_file)) $filesUploaded++;
        }
        if ($filesUploaded == 0) $countNotSent++;
        else if ($filesUploaded >= 5) $countComplete++;
        else $countPartial++;
    }
    ?>

    <!-- Stats Row -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card-premium stat-card-primary p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-0 fw-bold text-primary"><?= $totalTeachers ?></h3>
                        <p class="text-muted mb-0 small uppercase fw-semibold">ครูทั้งหมดในกลุ่ม</p>
                    </div>
                    <div class="stat-icon-box bg-label-primary">
                        <i class="bx bx-user"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card-premium stat-card-success p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-0 fw-bold text-success"><?= $countComplete ?></h3>
                        <p class="text-muted mb-0 small uppercase fw-semibold">ส่งครบถ้วน</p>
                    </div>
                    <div class="stat-icon-box bg-label-success">
                        <i class="bx bx-check-double"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card-premium stat-card-warning p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-0 fw-bold text-warning"><?= $countPartial ?></h3>
                        <p class="text-muted mb-0 small uppercase fw-semibold">รอดำเนินการ</p>
                    </div>
                    <div class="stat-icon-box bg-label-warning">
                        <i class="bx bx-time"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card-premium stat-card-danger p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-0 fw-bold text-danger"><?= $countNotSent ?></h3>
                        <p class="text-muted mb-0 small uppercase fw-semibold">ยังไม่ส่งข้อมูล</p>
                    </div>
                    <div class="stat-icon-box bg-label-danger">
                        <i class="bx bx-x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Teacher Grid -->
    <?php if (empty($groupedPlans)) : ?>
        <div class="card text-center p-5 border-0 shadow-sm animate__animated animate__zoomIn" style="border-radius: 20px;">
            <div class="card-body">
                <div class="avatar avatar-xl mx-auto mb-3" style="width: 100px; height: 100px;">
                    <span class="avatar-initial rounded-circle bg-label-secondary"><i class="bx bx-search-alt-2 fs-1"></i></span>
                </div>
                <h4 class="fw-bold">ไม่พบข้อมูลรายบุคคล</h4>
                <p class="text-muted">ยังไม่มีรายการแผนการสอนสำหรับปีการศึกษาที่เลือกในกลุ่มสาระนี้</p>
            </div>
        </div>
    <?php else : ?>
        <div class="row g-4">
            <?php foreach ($groupedPlans as $teacherId => $teacherData) : ?>
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card teacher-card-premium h-100">
                    <div class="card-body p-4 text-center">
                        <div class="teacher-avatar-wrapper">
                            <img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?= esc($teacherData['pers_img']) ?>"
                                onerror="this.src='<?= base_url('assets/img/avatars/1.png') ?>'"
                                alt="Avatar" class="avatar-premium">
                            <div class="mt-3">
                                <h6 class="mb-1 fw-bold text-dark text-truncate" title="<?= esc($teacherData['pers_prefix'] . $teacherData['pers_firstname'] . ' ' . $teacherData['pers_lastname']) ?>">
                                    <?= esc($teacherData['pers_prefix'] . $teacherData['pers_firstname'] . ' ' . $teacherData['pers_lastname']) ?>
                                </h6>
                                <p class="text-muted small mb-3 mb-0"><?= esc($teacherData['lear_namethai']) ?></p>
                            </div>
                        </div>
                        
                        <div class="d-grid pt-2">
                            <button type="button" class="btn btn-emerald btn-sm view-teacher-plans-btn rounded-pill"
                                data-teacher-id="<?= esc($teacherData['pers_id']) ?>"
                                data-teacher-name="<?= esc($teacherData['pers_prefix'] . $teacherData['pers_firstname'] . ' ' . $teacherData['pers_lastname']) ?>"
                                data-learning-group="<?= esc($teacherData['lear_namethai']) ?>">
                                <i class="bx bx-file-find me-1"></i> ตรวจสอบแผน
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Check Plan Modal -->
<div class="modal fade" id="checkPlanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-sm-down modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header modal-emerald-header">
                <div class="d-flex align-items-center">
                    <div class="icon-wrapper me-3 bg-white text-emerald rounded p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                        <i class="bx bx-book-content"></i>
                    </div>
                    <h5 class="modal-title fw-bold text-white mb-0">ตรวจสอบรายการแผนการจัดการเรียนรู้</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <!-- Teacher Info Snippet -->
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden;">
                    <div class="card-body p-3 bg-white">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="avatar avatar-md">
                                    <span class="avatar-initial rounded-circle bg-emerald text-white"><i class="bx bx-user"></i></span>
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="mb-0 fw-bold" id="modal-teacher-name-full">...</h6>
                                <p class="text-muted small mb-0" id="modal-learning-group-full">...</p>
                            </div>
                            <div class="col-auto text-end">
                                <span class="badge badge-emerald py-2 px-3 rounded-pill">สถานะปัจจุบัน</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 16px;">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover table-premium mb-0">
                            <thead>
                                <tr>
                                    <th>รายปี/เทอม</th>
                                    <th>รหัส/ชื่อวิชา</th>
                                    <th>ระดับ/ประเภท</th>
                                    <th class="text-center">แบบตรวจ</th>
                                    <th class="text-center">บันทึกตรวจ</th>
                                    <th class="text-center">โครงการสอน</th>
                                    <th class="text-center">แผนการจัดการ</th>
                                    <th class="text-center">บันทึกหลังสอน</th>
                                </tr>
                            </thead>
                            <tbody id="plans-table-body" class="bg-white">
                                <!-- AJAX Load -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-white border-top">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
            </div>
        </div>
    </div>
</div>

<!-- Plan Details Modal -->
<div class="modal fade" id="planDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark"><i class="bx bx-info-circle me-2 text-info"></i>รายละเอียดเพิ่มเติม</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group list-group-flush" id="detail-plan-files" style="border-radius: 12px; overflow: hidden;"></ul>
            </div>
        </div>
    </div>
</div>

<!-- Approval Modal -->
<div class="modal fade" id="approvalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0" style="border-radius: 25px; overflow: hidden;">
            <div class="modal-header modal-emerald-header">
                <h5 class="modal-title text-white fw-bold"><i class="bx bx-check-shield me-2"></i>ประเมินและอนุมัติแผน</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pt-5">
                <input type="hidden" id="approval-plan-id">
                <input type="hidden" id="approval-level">
                <div class="mb-4">
                    <label for="approval-comment" class="form-label fw-bold text-dark">ข้อเสนอแนะสำหรับการพิจารณา:</label>
                    <textarea class="form-control border-secondary opacity-75" id="approval-comment" rows="4" placeholder="กรอกความคิดเห็นเพื่อให้ครูนำไปประกอบการปรับปรุง"></textarea>
                </div>
                <div class="row g-3">
                    <div class="col-6">
                        <button type="button" class="btn btn-label-danger w-100 py-3 rounded-pill h-100" id="reject-btn">
                            <i class="bx bx-undo me-1"></i> ส่งกลับให้แก้ไข
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-emerald w-100 py-3 rounded-pill h-100 shadow-sm" id="approve-btn">
                            <i class="bx bx-check-circle me-1"></i> อนุมัติผ่านเกณฑ์
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
const UPLOAD_PLAN_BASE_URL = '<?= getenv('upload.server.baseurl.plan') ?>';

// Improved Action Button Look for Emerald UI
function renderActionButtons(planFile, fileId, status1, comment1, status2, comment2, pathInfo) {
    if (!planFile) return '<span class="badge bg-label-secondary opacity-50 small">ยังไม่แนบไฟล์</span>';

    const renderBtn = (lvl, status, comment) => {
        let btnClass = 'btn-label-secondary';
        let icon = 'bx-timer';
        if (status === 'ผ่าน') { btnClass = 'btn-success'; icon = 'bx-check'; }
        else if (status === 'ไม่ผ่าน') { btnClass = 'btn-danger'; icon = 'bx-error-circle'; }
        else if (status === 'รอตรวจ') { btnClass = 'btn-warning'; icon = 'bx-loader-circle'; }
        
        return `<button type="button" class="btn ${btnClass} btn-xs approval-btn px-2 flex-grow-1" style="font-size: 10px;"
                data-plan-id="${fileId}" data-level="${lvl}" data-comment="${comment || ''}">
                <i class="bx ${icon} me-1"></i> ${lvl===1 ? 'หน.ก' : 'หน.ว'}
                </button>`;
    };

    const fullPath = `${UPLOAD_PLAN_BASE_URL}${pathInfo.year}/${pathInfo.term}/${pathInfo.subj}/${planFile}`;
    
    return `
    <div style="min-width: 130px;">
        <div class="d-flex gap-1 mb-1">
            <a href="${fullPath}" target="_blank" class="btn btn-emerald btn-xs flex-grow-1"><i class="bx bxs-file-pdf"></i> ไฟล์</a>
            <button type="button" class="btn btn-label-info btn-xs info-detail-btn" data-id="${fileId}"><i class="bx bx-show-alt"></i></button>
        </div>
        <div class="d-flex gap-1">
            ${renderBtn(1, status1, comment1)}
            ${renderBtn(2, status2, comment2)}
        </div>
    </div>`;
}

$(document).ready(function() {
    
    // View Teacher Plans Loader
    $(document).on('click', '.view-teacher-plans-btn', function() {
        const teacherId = $(this).data('teacher-id');
        const teacherName = $(this).data('teacher-name');
        const learningGroup = $(this).data('learning-group');
        const [year, term] = $('#year_term_select').val().split('/');

        $('#modal-teacher-name-full').text(teacherName);
        $('#modal-learning-group-full').text(learningGroup);
        $('#plans-table-body').html('<tr><td colspan="8" class="text-center py-5"><div class="spinner-grow text-success"></div><p class="mt-3 fw-bold text-emerald">กำลังโหลตฐานข้อมูลและสแกนไฟล์...</p></td></tr>');

        $.ajax({
            url: `<?= site_url("admin/academic/checkplan/teacherplans/") ?>${teacherId}?year=${year}&term=${term}`,
            type: 'GET',
            dataType: 'json',
            success: function(plans) {
                $('#plans-table-body').empty();
                if (plans.length > 0) {
                    plans.forEach(plan => {
                        const pathInfo = { year: plan.seplan_year, term: plan.seplan_term, subj: plan.seplan_namesubject };
                        const row = `
                        <tr>
                            <td class="align-middle text-center"><small class="badge bg-label-secondary">${plan.seplan_year}/${plan.seplan_term}</small></td>
                            <td class="align-middle">
                                <div class="fw-bold text-dark">${plan.seplan_namesubject}</div>
                                <div class="text-muted small">${plan.seplan_coursecode}</div>
                            </td>
                            <td class="align-middle">
                                <div><span class="badge bg-label-info mb-1">ม.${plan.seplan_class}</span></div>
                                <div class="small opacity-75">${plan.seplan_subject_type}</div>
                            </td>
                            
                            <td class="text-center align-middle">${renderActionButtons(plan.check_plan_file, plan.check_plan_file_id, plan.check_plan_file_status1, plan.check_plan_file_comment1, plan.check_plan_file_status2, plan.check_plan_file_comment2, pathInfo)}</td>
                            <td class="text-center align-middle">${renderActionButtons(plan.record_check_file, plan.record_check_file_id, plan.record_check_file_status1, plan.record_check_file_comment1, plan.record_check_file_status2, plan.record_check_file_comment2, pathInfo)}</td>
                            <td class="text-center align-middle">${renderActionButtons(plan.project_plan_file, plan.project_plan_file_id, plan.project_plan_file_status1, plan.project_plan_file_comment1, plan.project_plan_file_status2, plan.project_plan_file_comment2, pathInfo)}</td>
                            <td class="text-center align-middle">${renderActionButtons(plan.use_plan_file, plan.use_plan_file_id, plan.use_plan_file_status1, plan.use_plan_file_comment1, plan.use_plan_file_status2, plan.use_plan_file_comment2, pathInfo)}</td>
                            <td class="text-center align-middle">${renderActionButtons(plan.after_teach_note_file, plan.after_teach_note_file_id, plan.after_teach_note_file_status1, plan.after_teach_note_file_comment1, plan.after_teach_note_file_status2, plan.after_teach_note_file_comment2, pathInfo)}</td>
                        </tr>`;
                        $('#plans-table-body').append(row);
                    });
                } else {
                    $('#plans-table-body').html('<tr><td colspan="8" class="text-center py-5 text-muted">ไม่พบข้อมูลแผนการสอนที่ส่งในปีการศึกษานี้</td></tr>');
                }
            },
            error: function() { $('#plans-table-body').html('<tr><td colspan="8" class="text-center text-danger py-4">ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้</td></tr>'); }
        });

        new bootstrap.Modal(document.getElementById('checkPlanModal')).show();
    });

    // Info Detail Handler
    $(document).on('click', '.info-detail-btn', function() {
        const planId = $(this).data('id');
        $('#detail-plan-files').html('<li class="list-group-item text-center p-4"><div class="spinner-border spinner-border-sm text-emerald"></div></li>');
        new bootstrap.Modal(document.getElementById('planDetailsModal')).show();

        $.ajax({
            url: `<?= site_url("admin/academic/checkplan/plandetails/") ?>${planId}`,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                let html = `
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                        <span class="text-muted small"><i class="bx bx-calendar me-2"></i>วันที่ส่งข้อมูล:</span>
                        <span class="fw-bold text-dark">${data.seplan_createdate}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                        <span class="text-muted small"><i class="bx bx-bookmark-alt me-2"></i>ประเภทไฟล์:</span>
                        <span class="badge badge-emerald rounded-pill">${data.type_name}</span>
                    </li>
                    <li class="list-group-item p-3">
                        <div class="fw-bold text-dark mb-2 small"><i class="bx bxs-user-detail me-2 text-primary"></i>ความเห็น หน.กลุ่มสาระ:</div>
                        <div class="p-3 bg-light rounded text-muted italic" style="font-size: 0.85rem;">${data.seplan_comment1 || '--- ยังไม่มีข้อเสนอแนะ ---'}</div>
                        <div class="mt-2 text-end">
                            <span class="badge ${data.seplan_status1 === 'ผ่าน' ? 'bg-success' : (data.seplan_status1 === 'ไม่ผ่าน' ? 'bg-danger' : 'bg-warning')} px-3">
                                <i class="bx ${data.seplan_status1 === 'ผ่าน' ? 'bx-check-circle' : 'bx-timer'} me-1"></i> ${data.seplan_status1 || 'รอตรวจ'}
                            </span>
                        </div>
                    </li>
                    <li class="list-group-item p-3">
                        <div class="fw-bold text-dark mb-2 small"><i class="bx bxs-check-shield me-2 text-info"></i>ความเห็น หน.งานหลักสูตร:</div>
                        <div class="p-3 bg-light rounded text-muted italic" style="font-size: 0.85rem;">${data.seplan_comment2 || '--- ยังไม่มีข้อเสนอแนะ ---'}</div>
                        <div class="mt-2 text-end">
                            <span class="badge ${data.seplan_status2 === 'ผ่าน' ? 'bg-success' : (data.seplan_status2 === 'ไม่ผ่าน' ? 'bg-danger' : 'bg-warning')} px-3">
                                <i class="bx ${data.seplan_status2 === 'ผ่าน' ? 'bx-check-circle' : 'bx-timer'} me-1"></i> ${data.seplan_status2 || 'รอตรวจ'}
                            </span>
                        </div>
                    </li>
                `;
                $('#detail-plan-files').html(html);
            }
        });
    });
    
    let clickedButton;
    $(document).on('click', '.approval-btn', function() {
        clickedButton = $(this);
        $('#approval-plan-id').val($(this).data('plan-id'));
        $('#approval-level').val($(this).data('level'));
        $('#approval-comment').val($(this).data('comment'));
        new bootstrap.Modal(document.getElementById('approvalModal')).show();
    });

    $(document).on('click', '#approve-btn, #reject-btn', function() {
        const status = $(this).attr('id') === 'approve-btn' ? 'ผ่าน' : 'ไม่ผ่าน';
        const planId = $('#approval-plan-id').val();
        const level = $('#approval-level').val();
        const comment = $('#approval-comment').val();
        const modal = bootstrap.Modal.getInstance(document.getElementById('approvalModal'));
        
        $.ajax({
            url: '<?= site_url("admin/academic/checkplan/updateplanstatus") ?>',
            type: 'POST',
            data: { plan_id: planId, level: level, status: status, comment: comment, '<?= csrf_token() ?>': '<?= csrf_hash() ?>' },
            dataType: 'json',
            success: function(res) {
                modal.hide();
                if(res.success) {
                    Swal.fire({ icon: 'success', title: 'บันทึกสำเร็จ', timer: 1000, showConfirmButton: false});
                    const btnClass = status === 'ผ่าน' ? 'btn-success' : 'btn-danger';
                    const icon = status === 'ผ่าน' ? 'bx-check' : 'bx-error-circle';
                    clickedButton.removeClass('btn-label-secondary btn-warning btn-success btn-danger').addClass(btnClass);
                    clickedButton.html(`<i class="bx ${icon} me-1"></i> ${level==1 ? 'หน.ก' : 'หน.ว'}`);
                    clickedButton.data('comment', comment);
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            }
        });
    });

});
</script>
<?= $this->endSection() ?>