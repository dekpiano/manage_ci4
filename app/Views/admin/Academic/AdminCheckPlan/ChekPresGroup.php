<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
.teacher-card {
    transition: all 0.2s ease-in-out;
}
.teacher-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
.stat-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}
.avatar-lg {
    width: 60px;
    height: 60px;
    object-fit: cover;
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header & Filter -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">งานวิชาการ /</span> ตรวจสอบแผนการสอน
            </h4>
            <div class="text-muted">ตรวจสอบสถานะการส่งแผนการสอนรายบุคคล</div>
        </div>
        <div class="mt-3 mt-md-0">
             <form action="<?= current_url() ?>" method="get" id="yearTermForm">
                <div class="input-group">
                    <label class="input-group-text bg-white border-end-0" for="year_term_select"><i class="bx bx-calendar"></i></label>
                    <select name="year_term" id="year_term_select" class="form-select border-start-0" onchange="document.getElementById('yearTermForm').submit();">
                         <?php foreach ($year_terms as $yt) : ?>
                            <option value="<?= $yt->seplan_year . '/' . $yt->seplan_term ?>"
                                <?= ($selected_year_term == ($yt->seplan_year . '/' . $yt->seplan_term)) ? 'selected' : '' ?>>
                                ปีการศึกษา <?= $yt->seplan_year ?> / ภาคเรียนที่ <?= $yt->seplan_term ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
             </form>
        </div>
    </div>

    <!-- Stats Calculation Logic -->
    <?php
    $totalTeachers = count($groupedPlans);
    $countComplete = 0;
    $countPartial = 0;
    $countNotSent = 0;

    foreach ($groupedPlans as $teacher) {
        $plans = is_array($teacher) ? ($teacher['plans'] ?? []) : ($teacher->plans ?? []);
        $totalFiles = count($plans);
        
        // Since getPlansByGroupId returns raw rows (one row per file), 
        // we can count the number of files uploaded directly.
        // However, we don't know the exact number of required subjects here without pivoting.
        // So valid logic for now: 
        // - "Not Sent" if count is 0.
        // - "Sent" (Partial/Complete) if count > 0.
        
        // Refined Logic: Check if 'seplan_file' exists
        $filesUploaded = 0;
        foreach ($plans as $plan) {
            $p_file = is_array($plan) ? ($plan['seplan_file'] ?? null) : ($plan->seplan_file ?? null);
            if (!empty($p_file)) {
                $filesUploaded++;
            }
        }

        if ($filesUploaded == 0) {
            $countNotSent++;
        } else {
             // For now, assume if they uploaded anything, it's at least "Partial"
             // To distinguish Complete/Partial accurately w/o Pivot, we'd need total subjects count
             // Let's assume > 4 files is likely complete (rough heuristic) or just group them into 'Sent'
             if ($filesUploaded >= 5) { 
                 $countComplete++;
             } else {
                 $countPartial++;
             }
        }
    }
    ?>

    <!-- Stats Overview -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card bg-label-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md me-3">
                            <span class="avatar-initial rounded bg-primary text-white"><i class="bx bx-user"></i></span>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold"><?= $totalTeachers ?></h4>
                            <small class="text-primary fw-semibold">ครูที่มีภาระงาน</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card bg-label-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md me-3">
                            <span class="avatar-initial rounded bg-success text-white"><i class="bx bx-check-double"></i></span>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold"><?= $countComplete ?></h4>
                            <small class="text-success fw-semibold">ส่งครบทุกวิชา</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <div class="col-sm-6 col-xl-3">
            <div class="card stat-card bg-label-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md me-3">
                             <span class="avatar-initial rounded bg-warning text-white"><i class="bx bx-time"></i></span>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold"><?= $countPartial ?></h4>
                            <small class="text-warning fw-semibold">ส่งบางวิชา</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card bg-label-danger">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                         <div class="avatar avatar-md me-3">
                            <span class="avatar-initial rounded bg-danger text-white"><i class="bx bx-x"></i></span>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold"><?= $countNotSent ?></h4>
                            <small class="text-danger fw-semibold">ยังไม่ส่ง</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Teacher Grid -->
    <?php if (empty($groupedPlans)) : ?>
        <div class="card text-center p-5">
            <div class="card-body">
                <div class="avatar avatar-xl mx-auto mb-3">
                    <span class="avatar-initial rounded-circle bg-label-secondary"><i class="bx bx-search fs-1"></i></span>
                </div>
                <h3>ไม่พบข้อมูล</h3>
                <p class="text-muted">ยังไม่มีรายการแผนการสอนสำหรับปีการศึกษาที่เลือก</p>
            </div>
        </div>
    <?php else : ?>
        <div class="row g-4">
            <?php foreach ($groupedPlans as $teacherId => $teacherData) : ?>
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card h-100 teacher-card border shadow-none">
                    <div class="card-body text-center">
                        <div class="mx-auto mb-3">
                            <img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?= esc($teacherData['pers_img']) ?>"
                                onerror="this.src='<?= base_url('assets/img/avatars/1.png') ?>'"
                                alt="Avatar" class="rounded-circle avatar-lg border border-3 border-light shadow-sm">
                        </div>
                        <h6 class="mb-1 text-truncate" title="<?= esc($teacherData['pers_prefix'] . $teacherData['pers_firstname'] . ' ' . $teacherData['pers_lastname']) ?>">
                            <?= esc($teacherData['pers_prefix'] . $teacherData['pers_firstname'] . ' ' . $teacherData['pers_lastname']) ?>
                        </h6>
                        <small class="text-muted d-block mb-3 text-truncate"><?= esc($teacherData['lear_namethai']) ?></small>
                        
                        <div class="d-grid">
                            <button type="button" class="btn btn-outline-primary btn-sm view-teacher-plans-btn"
                                data-teacher-id="<?= esc($teacherData['pers_id']) ?>"
                                data-teacher-name="<?= esc($teacherData['pers_prefix'] . $teacherData['pers_firstname'] . ' ' . $teacherData['pers_lastname']) ?>"
                                data-learning-group="<?= esc($teacherData['lear_namethai']) ?>">
                                <i class="bx bx-search-alt me-1"></i> ตรวจสอบแผน
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
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white"><i class="bx bx-book-reader me-2"></i>ตรวจสอบแผนการสอน</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light">
                <div class="card shadow-sm mb-3">
                     <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-md me-3">
                                <span class="avatar-initial rounded-circle bg-label-primary"><i class="bx bx-user"></i></span>
                            </div>
                            <div>
                                <h6 class="mb-0" id="modal-teacher-name-full">Wait...</h6>
                                <small class="text-muted" id="modal-learning-group-full">Wait...</small>
                            </div>
                        </div>
                     </div>
                </div>

                <div class="card shadow-sm">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ปี/ภาค</th>
                                    <th>รหัสวิชา</th>
                                    <th>ชื่อวิชา</th>
                                    <th>ระดับ</th>
                                    <th>ประเภท</th>
                                    <th class="text-center">แบบตรวจแผน</th>
                                    <th class="text-center">บันทึกตรวจ</th>
                                    <th class="text-center">โครงการสอน</th>
                                    <th class="text-center">แผนการจัดการ</th>
                                    <th class="text-center">บันทึกหลังสอน</th>
                                </tr>
                            </thead>
                            <tbody id="plans-table-body">
                                <!-- AJAX Load -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
            </div>
        </div>
    </div>
</div>

<!-- Plan Details Modal -->
<div class="modal fade" id="planDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-label-info">
                <h5 class="modal-title"><i class="bx bx-file me-2"></i>รายละเอียดไฟล์แนบ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3 item-details">
                    <!-- Dynamic Content -->
                     <ul class="list-group list-group-flush" id="detail-plan-files"></ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approval Modal -->
<div class="modal fade" id="approvalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white"><i class="bx bx-check-shield me-2"></i>อนุมัติ/ตรวจสอบแผน</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="approval-plan-id">
                <input type="hidden" id="approval-level">
                <div class="mb-3">
                    <label for="approval-comment" class="form-label fw-bold">ความคิดเห็นเพิ่มเติม:</label>
                    <textarea class="form-control" id="approval-comment" rows="3" placeholder="ระบุข้อเสนอแนะ (ถ้ามี)"></textarea>
                </div>
                <div class="d-flex justify-content-between gap-2">
                     <button type="button" class="btn btn-label-danger flex-grow-1" id="reject-btn"><i class="bx bx-x me-1"></i>ส่งกลับแก้ไข (ไม่ผ่าน)</button>
                     <button type="button" class="btn btn-success flex-grow-1" id="approve-btn"><i class="bx bx-check me-1"></i>อนุมัติ (ผ่าน)</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
const UPLOAD_PLAN_BASE_URL = '<?= getenv('upload.server.baseurl.plan') ?>';

// Helper: Approval Button Render
function renderActionButtons(planFile, fileId, status1, comment1, status2, comment2, pathInfo) {
    if (!planFile) return '<span class="badge bg-label-secondary">ยังไม่แนบไฟล์</span>';

    const renderBtn = (lvl, status, comment) => {
        let btnClass = 'btn-secondary';
        let icon = 'bx-time';
        if (status === 'ผ่าน') { btnClass = 'btn-success'; icon = 'bx-check'; }
        else if (status === 'ไม่ผ่าน') { btnClass = 'btn-danger'; icon = 'bx-x'; }
        else if (status === 'รอตรวจ') { btnClass = 'btn-warning'; icon = 'bx-time'; }
        
        return `<button type="button" class="btn ${btnClass} btn-sm approval-btn" 
                data-plan-id="${fileId}" data-level="${lvl}" data-comment="${comment}">
                <i class="bx ${icon}"></i> ${lvl===1 ? 'หน.กลุ่ม' : 'หน.หลักสูตร'}
                </button>`;
    };

    const fullPath = `${UPLOAD_PLAN_BASE_URL}${pathInfo.year}/${pathInfo.term}/${pathInfo.subj}/${planFile}`;
    
    return `
    <div class="d-flex flex-column gap-1">
        <a href="${fullPath}" target="_blank" class="btn btn-label-info btn-sm w-100"><i class="bx bx-search-alt me-1"></i>ดูไฟล์</a>
        <div class="btn-group btn-group-sm w-100" role="group">
            ${renderBtn(1, status1, comment1)}
            ${renderBtn(2, status2, comment2)}
        </div>
    </div>`;
}

$(document).ready(function() {
    
    // View Teacher Plans Button
    $(document).on('click', '.view-teacher-plans-btn', function() {
        const teacherId = $(this).data('teacher-id');
        const teacherName = $(this).data('teacher-name');
        const learningGroup = $(this).data('learning-group');
        const [year, term] = $('#year_term_select').val().split('/');

        $('#modal-teacher-name-full').text(teacherName);
        $('#modal-learning-group-full').text(learningGroup);
        $('#plans-table-body').html('<tr><td colspan="10" class="text-center py-5"><div class="spinner-border text-primary"></div><p class="mt-2">กำลังโหลดข้อมูล...</p></td></tr>'); // Loading

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
                            <td><span class="badge bg-label-primary">${plan.seplan_year}/${plan.seplan_term}</span></td>
                            <td><small>${plan.seplan_coursecode}</small></td>
                            <td><span class="fw-bold">${plan.seplan_namesubject}</span></td>
                            <td><span class="badge bg-label-info">ม.${plan.seplan_class}</span></td>
                            <td>${plan.seplan_subject_type}</td>
                            
                            <!-- Columns for Files & Actions -->
                            <td class="text-center">${renderActionButtons(plan.check_plan_file, plan.check_plan_file_id, plan.check_plan_file_status1, plan.check_plan_file_comment1, plan.check_plan_file_status2, plan.check_plan_file_comment2, pathInfo)}</td>
                            
                            <td class="text-center">${renderActionButtons(plan.record_check_file, plan.record_check_file_id, plan.record_check_file_status1, plan.record_check_file_comment1, plan.record_check_file_status2, plan.record_check_file_comment2, pathInfo)}</td>
                            
                            <td class="text-center">${renderActionButtons(plan.project_plan_file, plan.project_plan_file_id, plan.project_plan_file_status1, plan.project_plan_file_comment1, plan.project_plan_file_status2, plan.project_plan_file_comment2, pathInfo)}</td>
                            
                            <td class="text-center">${renderActionButtons(plan.use_plan_file, plan.use_plan_file_id, plan.use_plan_file_status1, plan.use_plan_file_comment1, plan.use_plan_file_status2, plan.use_plan_file_comment2, pathInfo)}</td>
                            
                            <td class="text-center">${renderActionButtons(plan.after_teach_note_file, plan.after_teach_note_file_id, plan.after_teach_note_file_status1, plan.after_teach_note_file_comment1, plan.after_teach_note_file_status2, plan.after_teach_note_file_comment2, pathInfo)}</td>
                        </tr>`;
                        $('#plans-table-body').append(row);
                    });
                } else {
                    $('#plans-table-body').html('<tr><td colspan="10" class="text-center py-4">ไม่พบแผนการสอน</td></tr>');
                }
            },
            error: function() { $('#plans-table-body').html('<tr><td colspan="10" class="text-center text-danger">เกิดข้อผิดพลาดในการโหลด</td></tr>'); }
        });

        const checkPlanModal = new bootstrap.Modal(document.getElementById('checkPlanModal'));
        checkPlanModal.show();
    });
    
    // Approval Flow (Logic same as before but UI refined)
    let clickedButton;
    $(document).on('click', '.approval-btn', function() {
        clickedButton = $(this);
        $('#approval-plan-id').val($(this).data('plan-id'));
        $('#approval-level').val($(this).data('level'));
        $('#approval-comment').val($(this).data('comment'));
        new bootstrap.Modal(document.getElementById('approvalModal')).show();
    });

    // Approve / Reject Handler
    $(document).on('click', '#approve-btn, #reject-btn', function() {
        const status = $(this).attr('id') === 'approve-btn' ? 'ผ่าน' : 'ไม่ผ่าน';
        const planId = $('#approval-plan-id').val();
        const level = $('#approval-level').val();
        const comment = $('#approval-comment').val();
        
        // Disable buttons look
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
                    // Update Button UI directly
                    const btnClass = status === 'ผ่าน' ? 'btn-success' : 'btn-danger';
                    const icon = status === 'ผ่าน' ? 'bx-check' : 'bx-x';
                    clickedButton.removeClass('btn-secondary btn-warning btn-success btn-danger').addClass(btnClass);
                    clickedButton.html(`<i class="bx ${icon}"></i> ${level==1 ? 'หน.กลุ่ม' : 'หน.หลักสูตร'}`);
                    clickedButton.data('comment', comment); // Update local data
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            },
            error: function() { Swal.fire('Error', 'Connection Failed', 'error'); }
        });
    });

});
</script>
<?= $this->endSection() ?>