<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">วิชาการ /</span> ตั้งค่าบทบาท
    </h4>

    <?php
    // Prepare data for easier access
    $roles = [];
    foreach ($Manager as $role) {
        $roles[$role->admin_rloes_id] = $role;
    }

    $teachers = [];
    $admin_user_ids = array_column($Manager, 'admin_rloes_userid');
    foreach ($NameTeacher as $teacher) {
        $teachers[$teacher->pers_id] = $teacher->pers_prefix . $teacher->pers_firstname . ' ' . $teacher->pers_lastname;
    }

    function getTeacherName($userId, $teachers)
    {
        return $teachers[$userId] ?? '<span class="text-danger">ยังไม่กำหนด</span>';
    }
    ?>

    <!-- Major Roles -->
    <div class="card mb-4">
        <h5 class="card-header">ผู้บริหารฝ่ายวิชาการ</h5>
        <div class="card-body">
            <div class="list-group">
                <!-- Manager -->
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">ผู้อำนวยการโรงเรียน</h6>
                        <small class="text-muted" id="name-manager"><?= getTeacherName(@$roles[1]->admin_rloes_userid, $teachers) ?></small>
                    </div>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#changeRoleModal" data-role-id="1" data-role-name="ผู้อำนวยการโรงเรียน">
                        <i class='bx bx-edit-alt me-1'></i>เปลี่ยน
                    </button>
                </div>
                <!-- Deputy -->
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">รองผู้อำนวยการฝ่ายวิชาการ</h6>
                        <small class="text-muted" id="name-deputy"><?= getTeacherName(@$roles[2]->admin_rloes_userid, $teachers) ?></small>
                    </div>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#changeRoleModal" data-role-id="2" data-role-name="รองผู้อำนวยการฝ่ายวิชาการ">
                        <i class='bx bx-edit-alt me-1'></i>เปลี่ยน
                    </button>
                </div>
                <!-- Leader -->
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">หัวหน้าฝ่ายวิชาการ</h6>
                        <small class="text-muted" id="name-leader"><?= getTeacherName(@$roles[3]->admin_rloes_userid, $teachers) ?></small>
                    </div>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#changeRoleModal" data-role-id="3" data-role-name="หัวหน้าฝ่ายวิชาการ">
                        <i class='bx bx-edit-alt me-1'></i>เปลี่ยน
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Staff and Permissions -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">เจ้าหน้าที่ฝ่ายวิชาการและสิทธิ์การเข้าถึง</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                <i class='bx bx-plus me-1'></i> เพิ่มเจ้าหน้าที่
            </button>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ชื่อ-นามสกุล</th>
                        <th>บทบาท</th>
                        <th>สิทธิ์การเข้าถึงระบบ</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <?php foreach ($Manager as $user_role) : ?>
                        <?php if ($user_role->admin_rloes_status == 'admin') : ?>
                            <tr>
                                <td><strong><?= getTeacherName($user_role->admin_rloes_userid, $teachers) ?></strong></td>
                                <td><span class="badge bg-label-info me-1"><?= ucfirst($user_role->admin_rloes_status) ?></span></td>
                                <td>
                                    <?php
                                    $permissions = explode('|', $user_role->admin_rloes_nanetype);
                                    foreach ($permissions as $permission) {
                                        if (!empty($permission)) {
                                            echo '<span class="badge bg-label-secondary me-1">' . htmlspecialchars($permission) . '</span>';
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editPermissionsModal" 
                                                data-user-id="<?= $user_role->admin_rloes_userid ?>" 
                                                data-user-name="<?= getTeacherName($user_role->admin_rloes_userid, $teachers) ?>"
                                                data-permissions="<?= htmlspecialchars($user_role->admin_rloes_nanetype) ?>">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-icon btn-outline-danger delete-staff-btn" 
                                                data-user-id="<?= $user_role->admin_rloes_userid ?>"
                                                data-user-name="<?= getTeacherName($user_role->admin_rloes_userid, $teachers) ?>">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<!-- Add Staff Modal -->
<div class="modal fade" id="addStaffModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เพิ่มเจ้าหน้าที่ฝ่ายวิชาการ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="add-teacher-select" class="form-label">เลือกบุคลากร</label>
                    <select id="add-teacher-select" class="form-select">
                        <option value="">-- เลือกรายชื่อ --</option>
                        <?php foreach ($NameTeacher as $teacher) : ?>
                            <?php if (!in_array($teacher->pers_id, $admin_user_ids)) : ?>
                                <option value="<?= $teacher->pers_id ?>"><?= $teacher->pers_prefix . $teacher->pers_firstname . ' ' . $teacher->pers_lastname ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" id="save-new-staff-btn">บันทึก</button>
            </div>
        </div>
    </div>
</div>

<!-- Change Role Modal -->
<div class="modal fade" id="changeRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeRoleModalLabel">เปลี่ยนผู้รับผิดชอบ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="role-id-input">
                <div class="mb-3">
                    <label for="teacher-select" class="form-label">เลือกบุคลากร</label>
                    <select id="teacher-select" class="form-select">
                        <option value="">-- เลือกรายชื่อ --</option>
                        <?php foreach ($NameTeacher as $teacher) : ?>
                            <option value="<?= $teacher->pers_id ?>"><?= $teacher->pers_prefix . $teacher->pers_firstname . ' ' . $teacher->pers_lastname ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" id="save-role-btn">บันทึก</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Permissions Modal -->
<div class="modal fade" id="editPermissionsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">แก้ไขสิทธิ์: <span id="permission-user-name"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="permission-user-id-input">
                <p>เลือกสิทธิ์การเข้าถึงระบบสำหรับฝ่ายวิชาการ</p>
                <?php 
                    $all_permissions = ['งานทะเบียน', 'งานหลักสูตร', 'งานวัดและประเมินผล', 'งานกิจกรรมพัฒนาผู้เรียน']; 
                ?>
                <div id="permissions-checkbox-list">
                    <?php foreach($all_permissions as $perm): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="<?= $perm ?>" id="perm-<?= str_replace('-', '', $perm) ?>">
                            <label class="form-check-label" for="perm-<?= str_replace('-', '', $perm) ?>">
                                <?= $perm ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" id="save-permissions-btn">บันทึก</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2 for the teacher selection dropdowns
        $('#teacher-select').select2({
            theme: "bootstrap-5",
            dropdownParent: $('#changeRoleModal'), // Important for modals
            placeholder: "-- เลือกรายชื่อ --",
            allowClear: true
        });
        $('#add-teacher-select').select2({
            theme: "bootstrap-5",
            dropdownParent: $('#addStaffModal'), // Important for modals
            placeholder: "-- เลือกรายชื่อ --",
            allowClear: true
        });

        let roleIdToUpdate;
        let roleName;

        // --- Change Role Modal Logic ---
        $('#changeRoleModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            roleIdToUpdate = button.data('role-id');
            roleName = button.data('role-name');
            const modalTitle = `เปลี่ยนผู้รับผิดชอบ: ${roleName}`;
            $(this).find('.modal-title').text(modalTitle);
            
            // Reset Select2 on modal open
            $('#teacher-select').val(null).trigger('change');
        });

        $('#save-role-btn').on('click', function() {
            const teacherId = $('#teacher-select').val();
            if (!teacherId) {
                Swal.fire({ icon: 'warning', title: 'กรุณาเลือกบุคลากร' });
                return;
            }

            let url;
            if (roleIdToUpdate == 1) url = '<?= site_url("ConAdminSettingAdminRoles/AcademicSettingManager") ?>';
            if (roleIdToUpdate == 2) url = '<?= site_url("ConAdminSettingAdminRoles/AcademicSettingDeputy") ?>';
            if (roleIdToUpdate == 3) url = '<?= site_url("ConAdminSettingAdminRoles/AcademicSettingLeader") ?>';
            
            if (!url) return;

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    'TeachID': teacherId,
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#save-role-btn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> กำลังบันทึก...');
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({ icon: 'success', title: 'บันทึกข้อมูลสำเร็จ', showConfirmButton: false, timer: 1500 });
                        $('#changeRoleModal').modal('hide');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        Swal.fire({ icon: 'error', title: 'เกิดข้อผิดพลาด', text: 'ไม่สามารถบันทึกข้อมูลได้' });
                    }
                },
                error: function() {
                    Swal.fire({ icon: 'error', title: 'การเชื่อมต่อล้มเหลว', text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้' });
                },
                complete: function() {
                    $('#save-role-btn').prop('disabled', false).text('บันทึก');
                }
            });
        });

        // --- Add Staff Modal Logic ---
        $('#addStaffModal').on('show.bs.modal', function() {
            // Reset Select2 on modal open
            $('#add-teacher-select').val(null).trigger('change');
        });

        $('#save-new-staff-btn').on('click', function() {
            const teacherId = $('#add-teacher-select').val();
            if (!teacherId) {
                Swal.fire({ icon: 'warning', title: 'กรุณาเลือกบุคลากร' });
                return;
            }

            $.ajax({
                url: '<?= site_url("ConAdminSettingAdminRoles/addAcademicStaff") ?>',
                type: 'POST',
                data: {
                    'pers_id': teacherId,
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#save-new-staff-btn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> กำลังบันทึก...');
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({ icon: 'success', title: 'เพิ่มเจ้าหน้าที่สำเร็จ', showConfirmButton: false, timer: 1500 });
                        $('#addStaffModal').modal('hide');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        Swal.fire({ icon: 'error', title: 'เกิดข้อผิดพลาด', text: response.message || 'ไม่สามารถเพิ่มข้อมูลได้' });
                    }
                },
                error: function() {
                    Swal.fire({ icon: 'error', title: 'การเชื่อมต่อล้มเหลว', text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้' });
                },
                complete: function() {
                    $('#save-new-staff-btn').prop('disabled', false).text('บันทึก');
                }
            });
        });

        // --- Delete Staff Logic ---
        $('.delete-staff-btn').on('click', function() {
            const userId = $(this).data('user-id');
            const userName = $(this).data('user-name');

            Swal.fire({
                title: `ต้องการลบ ${userName}?`,
                text: "คุณแน่ใจหรือไม่ที่จะลบบุคลากรท่านนี้ออกจากเจ้าหน้าที่ฝ่ายวิชาการ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= site_url("ConAdminSettingAdminRoles/deleteAcademicStaff") ?>',
                        type: 'POST',
                        data: {
                            'user_id': userId,
                            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({ icon: 'success', title: 'ลบข้อมูลสำเร็จ', showConfirmButton: false, timer: 1500 });
                                setTimeout(() => location.reload(), 1000);
                            } else {
                                Swal.fire({ icon: 'error', title: 'เกิดข้อผิดพลาด', text: response.message || 'ไม่สามารถลบข้อมูลได้' });
                            }
                        },
                        error: function() {
                            Swal.fire({ icon: 'error', title: 'การเชื่อมต่อล้มเหลว', text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้' });
                        }
                    });
                }
            });
        });


        // --- Edit Permissions Modal Logic ---
        let permissionUserId;
        $('#editPermissionsModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            permissionUserId = button.data('user-id');
            const userName = button.data('user-name');
            const currentPermissions = button.data('permissions').split('|');

            $('#permission-user-name').text(userName);
            $('#permission-user-id-input').val(permissionUserId);

            // Reset and set checkboxes
            $('#permissions-checkbox-list input[type="checkbox"]').prop('checked', false);
            currentPermissions.forEach(function(perm) {
                if(perm) {
                    $('#permissions-checkbox-list input[value="' + perm + '"]').prop('checked', true);
                }
            });
        });

        $('#save-permissions-btn').on('click', function() {
            const selectedPermissions = [];
            $('#permissions-checkbox-list input:checked').each(function() {
                selectedPermissions.push($(this).val());
            });

            const dataToSend = {
                'option': [{
                    'mainKey': permissionUserId,
                    'options': selectedPermissions
                }],
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            };

            $.ajax({
                url: '<?= site_url("ConAdminSettingAdminRoles/SelectWork") ?>',
                type: 'POST',
                data: dataToSend,
                dataType: 'json',
                beforeSend: function() {
                    $('#save-permissions-btn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> กำลังบันทึก...');
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({ icon: 'success', title: 'บันทึกสิทธิ์สำเร็จ', showConfirmButton: false, timer: 1500 });
                        $('#editPermissionsModal').modal('hide');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        Swal.fire({ icon: 'error', title: 'เกิดข้อผิดพลาด', text: response.message || 'ไม่สามารถบันทึกข้อมูลได้' });
                    }
                },
                error: function() {
                    Swal.fire({ icon: 'error', title: 'การเชื่อมต่อล้มเหลว', text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้' });
                },
                complete: function() {
                    $('#save-permissions-btn').prop('disabled', false).text('บันทึก');
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>
