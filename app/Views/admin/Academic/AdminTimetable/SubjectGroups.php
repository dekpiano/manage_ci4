<?= $this->extend('admin/layout/main') ?>

<?= $this->section('extra_css') ?>
<style>
    .group-card {
        transition: all 0.3s ease;
        border-left: 5px solid #15a362;
    }
    .group-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .assignment-item {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 10px 15px;
        margin-bottom: 8px;
        border: 1px solid #eee;
    }
    .swal2-container {
        z-index: 9999 !important;
    }
    .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__rendered .select2-selection__choice {
        background-color: #15a362;
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 2px 8px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">วิชาการ / ตารางสอน /</span> กลุ่มวิชาเรียนพร้อมกัน (Simultaneous Groups)</h4>
            <div class="text-muted small">จัดกลุ่มวิชาที่ต้องเรียนในเวลาเดียวกัน (วิชาเลือก/วิชาขนานห้อง)</div>
        </div>
        <button class="btn btn-primary rounded-pill" onclick="openGroupModal()">
            <i class="bx bx-plus me-1"></i> สร้างกลุ่มใหม่
        </button>
    </div>

    <div class="row">
        <?php if(empty($groups)): ?>
        <div class="col-12 text-center py-5">
            <img src="https://illustrations.popsy.co/green/group-work.svg" alt="no-data" style="height: 200px;">
            <h5 class="mt-4 text-muted">ยังไม่มีการสร้างกลุ่มวิชาเรียนพร้อมกัน</h5>
            <p class="text-muted small">เริ่มต้นโดยการคลิกปุ่ม "สร้างกลุ่มใหม่" ด้านบน</p>
        </div>
        <?php else: ?>
            <?php foreach($groups as $group): 
                // Get assignments in this group
                $group_assignments = array_filter($assignments, function($a) use ($group) {
                    return $a->group_id == $group->group_id;
                });
            ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm group-card border-0">
                    <div class="card-header d-flex justify-content-between align-items-center pb-2">
                        <h5 class="card-title mb-0 fw-bold text-primary"><?= $group->group_name ?></h5>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="javascript:void(0);" onclick="editGroup(<?= htmlspecialchars(json_encode($group)) ?>, <?= htmlspecialchars(json_encode(array_column($group_assignments, 'assign_id'))) ?>)">
                                    <i class="bx bx-edit-alt me-1"></i> แก้ไข
                                </a>
                                <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="deleteGroup(<?= $group->group_id ?>)">
                                    <i class="bx bx-trash me-1"></i> ลบกลุ่ม
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="small text-muted mb-3">วิชาที่เรียนพร้อมกัน (<?= count($group_assignments) ?> รายการ):</div>
                        <?php if(empty($group_assignments)): ?>
                            <div class="text-center py-3 bg-light rounded-3 text-muted small">ยังไม่มีวิชาในกลุ่มนี้</div>
                        <?php else: ?>
                            <?php foreach($group_assignments as $ga): ?>
                            <div class="assignment-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold fs-7">[<?= $ga->tsub_code ?>] <?= $ga->tsub_name ?></div>
                                    <div class="text-muted" style="font-size: 0.65rem;">ห้อง <?= $ga->class_name ?> | <?= $ga->hours_per_week ?> ชม./สัปดาห์</div>
                                </div>
                                <span class="badge bg-label-success rounded-pill">LOCK</span>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Group Management -->
<div class="modal fade" id="modalGroup" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold" id="modalTitle">สร้างกลุ่มวิชาเรียนพร้อมกัน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="groupForm">
                <div class="modal-body">
                    <input type="hidden" name="group_id" id="group_id">
                    <div class="mb-4">
                        <label class="form-label fw-bold">ชื่อกลุ่ม (เช่น กลุ่มวิชาเลือก ม.4)</label>
                        <input type="text" class="form-control rounded-pill" name="group_name" id="group_name" placeholder="ระบุชื่อกลุ่ม..." required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold d-flex justify-content-between">
                            เลือกงานสอนที่จะเรียนพร้อมกัน 
                            <span class="badge bg-label-primary fs-tiny">ปีการศึกษา <?= $term ?>/<?= $year ?></span>
                        </label>
                        <select class="form-select select2" name="assignment_ids[]" id="assignment_ids" multiple data-placeholder="ค้นหาวิชาหรือห้องเรียน...">
                            <?php foreach($assignments as $a): ?>
                            <option value="<?= $a->assign_id ?>">
                                [<?= $a->class_name ?>] <?= $a->tsub_code ?> - <?= $a->tsub_name ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text text-muted small mt-2">
                            * วิชาที่เลือกมาใส่กลุ่มนี้ จะถูกจัดตารางให้อยู่ในคาบเดียวกันเสมอ
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-label-secondary rounded-pill" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    $('.select2').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#modalGroup')
    });

    $('#groupForm').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        
        $.post('<?= base_url("admin/academic/timetable/save-joint-group") ?>', formData, function(res) {
            if(res.status === 'success') {
                $('#modalGroup').modal('hide');
                Swal.fire({ icon: 'success', title: 'สำเร็จ', text: res.message, timer: 1500, showConfirmButton: false })
                    .then(() => window.location.reload());
            } else {
                Swal.fire('ผิดพลาด', res.message, 'error');
            }
        });
    });
});

function openGroupModal() {
    $('#group_id').val('');
    $('#group_name').val('');
    $('#assignment_ids').val([]).trigger('change');
    $('#modalTitle').text('สร้างกลุ่มวิชาเรียนพร้อมกัน');
    $('#modalGroup').modal('show');
}

function editGroup(group, selectedIds) {
    $('#group_id').val(group.group_id);
    $('#group_name').val(group.group_name);
    $('#assignment_ids').val(selectedIds).trigger('change');
    $('#modalTitle').text('แก้ไขกลุ่มวิชาเรียนพร้อมกัน');
    $('#modalGroup').modal('show');
}

function deleteGroup(id) {
    Swal.fire({
        title: 'ยืนยันการลบกลุ่ม?',
        text: "วิชาในกลุ่มจะยังคงอยู่แต่จะไม่ถูกบังคับให้เรียนพร้อมกันอีกต่อไป",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#15a362',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่, ลบเลย!',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('<?= base_url("admin/academic/timetable/delete-joint-group") ?>/' + id, { '<?= csrf_token() ?>': '<?= csrf_hash() ?>' }, function(res) {
                if(res.status === 'success') {
                    Swal.fire({ icon: 'success', title: 'ลบสำเร็จ', timer: 1000, showConfirmButton: false })
                        .then(() => window.location.reload());
                }
            });
        }
    });
}
</script>
<?= $this->endSection() ?>
