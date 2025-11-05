<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Academic /</span> Check Lesson Plan</h4>

    <div class="row">
        <?php if (empty($groupedPlans)) : ?>
            <div class="col">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">ไม่พบข้อมูล</h5>
                        <p class="card-text">ไม่พบรายการแผนการสอนที่ส่งเข้ามาในขณะนี้</p>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <?php foreach ($groupedPlans as $teacherId => $teacherData) : ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0 me-3">
                                    <img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?= esc($teacherData['pers_img']) ?>" alt="Teacher Image" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0"><?= esc($teacherData['pers_prefix'] . $teacherData['pers_firstname'] . ' ' . $teacherData['pers_lastname']) ?></h6>
                                    <small class="text-muted"><?= esc($teacherData['lear_namethai']) ?></small>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="card-text mb-1"><strong>จำนวนแผนที่ส่ง:</strong> <?= count($teacherData['plans']) ?></p>
                                </div>

                                <button type="button" class="btn btn-primary btn-sm view-teacher-plans-btn" 
                                        data-teacher-id="<?= esc($teacherData['pers_id']) ?>" 
                                        data-teacher-name="<?= esc($teacherData['pers_prefix'] . $teacherData['pers_firstname'] . ' ' . $teacherData['pers_lastname']) ?>" 
                                        data-learning-group="<?= esc($teacherData['lear_namethai']) ?>">
                                    ตรวจสอบแผน
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<!-- Check Plan Modal -->
<div class="modal fade" id="checkPlanModal" tabindex="-1" aria-labelledby="checkPlanModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="checkPlanModalLabel">แผนการสอนของ <span id="modal-teacher-name-full"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>กลุ่มสาระ:</strong> <span id="modal-learning-group-full"></span></p>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>ปีการศึกษา/ภาคเรียน</th>
                <th>รหัสวิชา</th>
                <th>ชื่อวิชา</th>
                <th>ระดับ</th>
                <th>ประเภท</th>
                <th>แบบตรวจแผน</th>
                <th>บันทึกตรวจ</th>
                <th>โครงการสอน</th>
                <th>แผนการสอนหน้าเดียว</th>
                <th>บันทึกหลังสอน</th>
              </tr>
            </thead>
            <tbody id="plans-table-body">
              <!-- Plans will be loaded here via AJAX -->
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<!-- Approval Modal -->
<div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="approvalModalLabel">อนุมัติแผน</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="approval-plan-id">
        <input type="hidden" id="approval-level">
        <div class="mb-3">
          <label for="approval-comment" class="form-label">ความคิดเห็น:</label>
          <textarea class="form-control" id="approval-comment" rows="3"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-danger" id="reject-btn">ไม่อนุมัติ</button>
        <button type="button" class="btn btn-success" id="approve-btn">อนุมัติ</button>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
const UPLOAD_PLAN_BASE_URL = '<?= getenv('upload.server.baseurl.plan') ?>';
$(document).ready(function() {
    // Handle the click event for the 'ตรวจสอบแผน' button to open and populate the modal
    $(document).on('click', '.view-teacher-plans-btn', function() {
        const teacherId = $(this).data('teacher-id');
        const teacherName = $(this).data('teacher-name');
        const learningGroup = $(this).data('learning-group');

        $('#modal-teacher-name-full').text(teacherName);
        $('#modal-learning-group-full').text(learningGroup);
        $('#plans-table-body').empty(); // Clear previous plans

        $.ajax({
            url: '<?= site_url("admin/academic/checkplan/teacherplans/") ?>' + teacherId,
            type: 'GET',
            dataType: 'json',
            success: function(plans) {
                if (plans.length > 0) {
                    plans.forEach(function(plan) {
                        const status1_class = plan.seplan_status1 === 'ผ่าน' ? 'btn-success' : (plan.seplan_status1 === 'ไม่ผ่าน' ? 'btn-danger' : (plan.seplan_status1 === 'รอตรวจ' ? 'btn-warning' : 'btn-secondary'));
                        const status1_icon = plan.seplan_status1 === 'ผ่าน' ? '<i class="bx bx-check"></i> ' : (plan.seplan_status1 === 'ไม่ผ่าน' ? '<i class="bx bx-x"></i> ' : (plan.seplan_status1 === 'รอตรวจ' ? '<i class="bx bx-time"></i> ' : ''));

                        const status2_class = plan.seplan_status2 === 'ผ่าน' ? 'btn-success' : (plan.seplan_status2 === 'ไม่ผ่าน' ? 'btn-danger' : (plan.seplan_status2 === 'รอตรวจ' ? 'btn-warning' : 'btn-secondary'));
                        const status2_icon = plan.seplan_status2 === 'ผ่าน' ? '<i class="bx bx-check"></i> ' : (plan.seplan_status2 === 'ไม่ผ่าน' ? '<i class="bx bx-x"></i> ' : (plan.seplan_status2 === 'รอตรวจ' ? '<i class="bx bx-time"></i> ' : ''));

                        const row = `
                            <tr>
                                <td>${plan.seplan_year}/${plan.seplan_term}</td>
                                <td>${plan.seplan_coursecode}</td>
                                <td>${plan.seplan_namesubject}</td>
                                <td>${plan.seplan_class}</td>
                                <td>${plan.seplan_subject_type}</td>
                                <td>
                                    ${plan.check_plan_file ? `
                                        <div class="btn-group">
                                            <a href="${UPLOAD_PLAN_BASE_URL}${plan.seplan_year}/${plan.seplan_term}/${plan.seplan_namesubject}/${plan.check_plan_file}" target="_blank" class="btn btn-info btn-sm">ดู</a>
                                            <button type="button" class="btn ${plan.check_plan_file_status1 === 'ผ่าน' ? 'btn-success' : (plan.check_plan_file_status1 === 'ไม่ผ่าน' ? 'btn-danger' : (plan.check_plan_file_status1 === 'รอตรวจ' ? 'btn-warning' : 'btn-secondary'))} btn-sm approval-btn" data-plan-id="${plan.check_plan_file_id}" data-level="1" data-comment="${plan.check_plan_file_comment1}">${plan.check_plan_file_status1 === 'ผ่าน' ? '<i class="bx bx-check"></i>' : (plan.check_plan_file_status1 === 'ไม่ผ่าน' ? '<i class="bx bx-x"></i>' : (plan.check_plan_file_status1 === 'รอตรวจ' ? '<i class="bx bx-time"></i>' : ''))}หน.กลุ่ม</button>
                                            <button type="button" class="btn ${plan.check_plan_file_status2 === 'ผ่าน' ? 'btn-success' : (plan.check_plan_file_status2 === 'ไม่ผ่าน' ? 'btn-danger' : (plan.check_plan_file_status2 === 'รอตรวจ' ? 'btn-warning' : 'btn-secondary'))} btn-sm approval-btn" data-plan-id="${plan.check_plan_file_id}" data-level="2" data-comment="${plan.check_plan_file_comment2}">${plan.check_plan_file_status2 === 'ผ่าน' ? '<i class="bx bx-check"></i>' : (plan.check_plan_file_status2 === 'ไม่ผ่าน' ? '<i class="bx bx-x"></i>' : (plan.check_plan_file_status2 === 'รอตรวจ' ? '<i class="bx bx-time"></i>' : ''))}หน.หลักสูตร</button>
                                        </div>
                                    ` : ''}
                                </td>
                                <td>
                                    ${plan.record_check_file ? `
                                        <div class="btn-group">
                                            <a href="${UPLOAD_PLAN_BASE_URL}${plan.seplan_year}/${plan.seplan_term}/${plan.seplan_namesubject}/${plan.record_check_file}" target="_blank" class="btn btn-info btn-sm">ดู</a>
                                            <button type="button" class="btn ${plan.record_check_file_status1 === 'ผ่าน' ? 'btn-success' : (plan.record_check_file_status1 === 'ไม่ผ่าน' ? 'btn-danger' : (plan.record_check_file_status1 === 'รอตรวจ' ? 'btn-warning' : 'btn-secondary'))} btn-sm approval-btn" data-plan-id="${plan.record_check_file_id}" data-level="1" data-comment="${plan.record_check_file_comment1}">${plan.record_check_file_status1 === 'ผ่าน' ? '<i class="bx bx-check"></i>' : (plan.record_check_file_status1 === 'ไม่ผ่าน' ? '<i class="bx bx-x"></i>' : (plan.record_check_file_status1 === 'รอตรวจ' ? '<i class="bx bx-time"></i>' : ''))}หน.กลุ่ม</button>
                                            <button type="button" class="btn ${plan.record_check_file_status2 === 'ผ่าน' ? 'btn-success' : (plan.record_check_file_status2 === 'ไม่ผ่าน' ? 'btn-danger' : (plan.record_check_file_status2 === 'รอตรวจ' ? 'btn-warning' : 'btn-secondary'))} btn-sm approval-btn" data-plan-id="${plan.record_check_file_id}" data-level="2" data-comment="${plan.record_check_file_comment2}">${plan.record_check_file_status2 === 'ผ่าน' ? '<i class="bx bx-check"></i>' : (plan.record_check_file_status2 === 'ไม่ผ่าน' ? '<i class="bx bx-x"></i>' : (plan.record_check_file_status2 === 'รอตรวจ' ? '<i class="bx bx-time"></i>' : ''))}หน.หลักสูตร</button>
                                        </div>
                                    ` : ''}
                                </td>
                                <td>
                                    ${plan.project_plan_file ? `
                                        <div class="btn-group">
                                            <a href="${UPLOAD_PLAN_BASE_URL}${plan.seplan_year}/${plan.seplan_term}/${plan.seplan_namesubject}/${plan.project_plan_file}" target="_blank" class="btn btn-info btn-sm">ดู</a>
                                            <button type="button" class="btn ${plan.project_plan_file_status1 === 'ผ่าน' ? 'btn-success' : (plan.project_plan_file_status1 === 'ไม่ผ่าน' ? 'btn-danger' : (plan.project_plan_file_status1 === 'รอตรวจ' ? 'btn-warning' : 'btn-secondary'))} btn-sm approval-btn" data-plan-id="${plan.project_plan_file_id}" data-level="1" data-comment="${plan.project_plan_file_comment1}">${plan.project_plan_file_status1 === 'ผ่าน' ? '<i class="bx bx-check"></i>' : (plan.project_plan_file_status1 === 'ไม่ผ่าน' ? '<i class="bx bx-x"></i>' : (plan.project_plan_file_status1 === 'รอตรวจ' ? '<i class="bx bx-time"></i>' : ''))}หน.กลุ่ม</button>
                                            <button type="button" class="btn ${plan.project_plan_file_status2 === 'ผ่าน' ? 'btn-success' : (plan.project_plan_file_status2 === 'ไม่ผ่าน' ? 'btn-danger' : (plan.project_plan_file_status2 === 'รอตรวจ' ? 'btn-warning' : 'btn-secondary'))} btn-sm approval-btn" data-plan-id="${plan.project_plan_file_id}" data-level="2" data-comment="${plan.project_plan_file_comment2}">${plan.project_plan_file_status2 === 'ผ่าน' ? '<i class="bx bx-check"></i>' : (plan.project_plan_file_status2 === 'ไม่ผ่าน' ? '<i class="bx bx-x"></i>' : (plan.project_plan_file_status2 === 'รอตรวจ' ? '<i class="bx bx-time"></i>' : ''))}หน.หลักสูตร</button>
                                        </div>
                                    ` : ''}
                                </td>
                                <td>
                                    ${plan.use_plan_file ? `
                                        <div class="btn-group">
                                            <a href="${UPLOAD_PLAN_BASE_URL}${plan.seplan_year}/${plan.seplan_term}/${plan.seplan_namesubject}/${plan.use_plan_file}" target="_blank" class="btn btn-info btn-sm">ดู</a>
                                            <button type="button" class="btn ${plan.use_plan_file_status1 === 'ผ่าน' ? 'btn-success' : (plan.use_plan_file_status1 === 'ไม่ผ่าน' ? 'btn-danger' : (plan.use_plan_file_status1 === 'รอตรวจ' ? 'btn-warning' : 'btn-secondary'))} btn-sm approval-btn" data-plan-id="${plan.use_plan_file_id}" data-level="1" data-comment="${plan.use_plan_file_comment1}">${plan.use_plan_file_status1 === 'ผ่าน' ? '<i class="bx bx-check"></i>' : (plan.use_plan_file_status1 === 'ไม่ผ่าน' ? '<i class="bx bx-x"></i>' : (plan.use_plan_file_status1 === 'รอตรวจ' ? '<i class="bx bx-time"></i>' : ''))}หน.กลุ่ม</button>
                                            <button type="button" class="btn ${plan.use_plan_file_status2 === 'ผ่าน' ? 'btn-success' : (plan.use_plan_file_status2 === 'ไม่ผ่าน' ? 'btn-danger' : (plan.use_plan_file_status2 === 'รอตรวจ' ? 'btn-warning' : 'btn-secondary'))} btn-sm approval-btn" data-plan-id="${plan.use_plan_file_id}" data-level="2" data-comment="${plan.use_plan_file_comment2}">${plan.use_plan_file_status2 === 'ผ่าน' ? '<i class="bx bx-check"></i>' : (plan.use_plan_file_status2 === 'ไม่ผ่าน' ? '<i class="bx bx-x"></i>' : (plan.use_plan_file_status2 === 'รอตรวจ' ? '<i class="bx bx-time"></i>' : ''))}หน.หลักสูตร</button>
                                        </div>
                                    ` : ''}
                                </td>
                                <td>
                                    ${plan.after_teach_note_file ? `
                                        <div class="btn-group">
                                            <a href="${UPLOAD_PLAN_BASE_URL}${plan.seplan_year}/${plan.seplan_term}/${plan.seplan_namesubject}/${plan.after_teach_note_file}" target="_blank" class="btn btn-info btn-sm">ดู</a>
                                            <button type="button" class="btn ${plan.after_teach_note_file_status1 === 'ผ่าน' ? 'btn-success' : (plan.after_teach_note_file_status1 === 'ไม่ผ่าน' ? 'btn-danger' : (plan.after_teach_note_file_status1 === 'รอตรวจ' ? 'btn-warning' : 'btn-secondary'))} btn-sm approval-btn" data-plan-id="${plan.after_teach_note_file_id}" data-level="1" data-comment="${plan.after_teach_note_file_comment1}">${plan.after_teach_note_file_status1 === 'ผ่าน' ? '<i class="bx bx-check"></i>' : (plan.after_teach_note_file_status1 === 'ไม่ผ่าน' ? '<i class="bx bx-x"></i>' : (plan.after_teach_note_file_status1 === 'รอตรวจ' ? '<i class="bx bx-time"></i>' : ''))}หน.กลุ่ม</button>
                                            <button type="button" class="btn ${plan.after_teach_note_file_status2 === 'ผ่าน' ? 'btn-success' : (plan.after_teach_note_file_status2 === 'ไม่ผ่าน' ? 'btn-danger' : (plan.after_teach_note_file_status2 === 'รอตรวจ' ? 'btn-warning' : 'btn-secondary'))} btn-sm approval-btn" data-plan-id="${plan.after_teach_note_file_id}" data-level="2" data-comment="${plan.after_teach_note_file_comment2}">${plan.after_teach_note_file_status2 === 'ผ่าน' ? '<i class="bx bx-check"></i>' : (plan.after_teach_note_file_status2 === 'ไม่ผ่าน' ? '<i class="bx bx-x"></i>' : (plan.after_teach_note_file_status2 === 'รอตรวจ' ? '<i class="bx bx-time"></i>' : ''))}หน.หลักสูตร</button>
                                        </div>
                                    ` : ''}
                                </td>
                            </tr>
                        `;
                        $('#plans-table-body').append(row);
                    });
                } else {
                    $('#plans-table-body').append('<tr><td colspan="6" class="text-center">ไม่พบแผนการสอนสำหรับครูท่านนี้</td></tr>');
                }
            },
            error: function() {
                $('#plans-table-body').append('<tr><td colspan="13" class="text-center">เกิดข้อผิดพลาดในการดึงข้อมูลแผนการสอน</td></tr>');
            }
        });

        const checkPlanModal = new bootstrap.Modal(document.getElementById('checkPlanModal'));
        checkPlanModal.show();
    });

            let clickedButton;

            // Handle the click event for the approval buttons
            $(document).on('click', '.approval-btn', function() {
                clickedButton = $(this);
                const planId = $(this).data('plan-id');
                const level = $(this).data('level');
                const comment = $(this).data('comment');

                $('#approval-plan-id').val(planId);
                $('#approval-level').val(level);
                $('#approval-comment').val(comment);

                const approvalModal = new bootstrap.Modal(document.getElementById('approvalModal'));
                approvalModal.show();
            });

            // Handle approve/reject buttons in the approval modal
            $(document).on('click', '#approve-btn, #reject-btn', function() {
                const planId = $('#approval-plan-id').val();
                const level = $('#approval-level').val();
                const comment = $('#approval-comment').val();
                const status = $(this).attr('id') === 'approve-btn' ? 'ผ่าน' : 'ไม่ผ่าน';

                $.ajax({
                    url: '<?= site_url("admin/academic/checkplan/updateplanstatus") ?>',
                    type: 'POST',
                    data: {
                        plan_id: planId,
                        level: level,
                        status: status,
                        comment: comment,
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            const approvalModal = bootstrap.Modal.getInstance(document.getElementById('approvalModal'));
                            approvalModal.hide();

                            // Update the button color and icon
                            const status_class = status === 'ผ่าน' ? 'btn-success' : 'btn-danger';
                            const icon_class = status === 'ผ่าน' ? 'bx bx-check' : 'bx bx-x';
                            clickedButton.removeClass('btn-secondary btn-warning btn-success btn-danger').addClass(status_class);
                            clickedButton.html(`<i class="${icon_class}"></i> ${level == 1 ? 'หน.กลุ่ม' : 'หน.หลักสูตร'}`);

                            Swal.fire({
                                icon: 'success',
                                title: 'บันทึกข้อมูลสำเร็จ',
                                showConfirmButton: false,
                                timer: 1500
                            });

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด',
                                text: response.message || 'ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่อีกครั้ง'
                            });
                        }
                    },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้'
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>