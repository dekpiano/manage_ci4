<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
    /* ===== Green Premium Design System ===== */
    :root {
        --primary-green: #15a362;
        --secondary-green: #2ecc71;
        --gradient-green: linear-gradient(135deg, #15a362 0%, #20c997 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    .adjust-page-header {
        background: var(--gradient-green);
        border-radius: 16px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 12px 40px rgba(21, 163, 98, 0.25);
    }

    .adjust-page-header::after {
        content: "";
        position: absolute;
        top: -50px;
        right: -50px;
        width: 250px;
        height: 250px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .header-content { position: relative; z-index: 2; }
    .header-title { color: #fff; font-weight: 800; letter-spacing: -0.5px; }
    .header-subtitle { color: rgba(255, 255, 255, 0.85); font-weight: 400; }

    /* Card Styling */
    .premium-card {
        border: none;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        transition: transform 0.3s ease;
    }

    .classroom-select-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        margin-top: -3.5rem;
        z-index: 10;
        position: relative;
        border: 1px solid rgba(21, 163, 98, 0.1);
    }

    /* Table Styling */
    .table-header-custom {
        background: #f8f9fa;
        border-bottom: 2px solid rgba(21, 163, 98, 0.1) !important;
    }
    .table-header-custom th {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        color: #566a7f;
    }

    .adjust-number-input {
        max-width: 90px;
        text-align: center;
        font-weight: 800;
        border: 2px solid #eaedf1;
        border-radius: 8px;
        padding: 0.5rem;
        font-size: 1rem;
        color: var(--primary-green);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .adjust-number-input:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 0.25rem rgba(21, 163, 98, 0.15);
        transform: scale(1.05);
    }

    .student-row { transition: all 0.2s ease; cursor: default; }
    .student-row:hover {
        background-color: rgba(21, 163, 98, 0.04) !important;
    }

    .btn-save-fab {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        padding: 1rem 2rem;
        border-radius: 50px;
        box-shadow: 0 10px 25px rgba(21, 163, 98, 0.3);
        z-index: 1000;
        font-weight: 700;
        display: none;
    }

    /* ===== Modern standalone Select2 Styling ===== */
    .select2-modern + .select2-container--bootstrap-5 .select2-selection {
        border-radius: 12px !important;
        border: 2px solid #eaedf1 !important;
        min-height: 52px !important;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
        background-color: #fff !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03) !important;
    }
    .select2-modern + .select2-container--bootstrap-5.select2-container--focus .select2-selection {
        border-color: var(--primary-green) !important;
        box-shadow: 0 0 0 0.25rem rgba(21, 163, 98, 0.15) !important;
        transform: translateY(-1px);
    }
    .select2-modern + .select2-container--bootstrap-5 .select2-selection__rendered {
        padding-left: 1.25rem !important;
        font-weight: 700;
        color: #566a7f;
        font-size: 1.05rem;
    }

    /* SweetAlert2 On Top Always */
    .swal2-container {
        z-index: 99999 !important;
    }

    /* Green highlight when saved successfully */
    .adjust-number-input.save-success {
        border-color: var(--primary-green) !important;
        background-color: rgba(21, 163, 98, 0.1) !important;
        color: var(--primary-green) !important;
        box-shadow: 0 0 0 0.25rem rgba(21, 163, 98, 0.1) !important;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Premium Header -->
    <div class="adjust-page-header">
        <div class="header-content d-flex justify-content-between align-items-center">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="<?= base_url('Admin/Acade/Registration/Students') ?>" class="text-white opacity-75">จัดการนักเรียน</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">ปรับเลขที่รายห้อง</li>
                    </ol>
                </nav>
                <h2 class="header-title mb-1 text-white">✨ จัดการเลขที่นักเรียนรายห้องเรียน</h2>
                <p class="header-subtitle mb-0">ปรับเลขที่นักเรียน (สถานะ: ปกติ) สะดวก รวดเร็ว</p>
            </div>
            <div class="d-none d-md-block">
                <i class="bx bx-list-ol bx-lg text-white opacity-50"></i>
            </div>
        </div>
    </div>

    <!-- Classroom Selection Panel -->
    <div class="card premium-card classroom-select-card mb-4">
        <div class="card-body p-4">
            <div class="row g-4 align-items-center">
                <div class="col-md-5">
                    <label class="form-label fw-bold text-dark mb-2"><i class="bx bx-door-open me-1 text-success"></i> เลือกระดับชั้น/ห้องเรียนที่ต้องการจัดการ</label>
                    <select id="classroomSelector" class="form-select select2-modern" style="font-weight: 600;">
                        <option value="">-- โปรดเลือกห้องเรียน --</option>
                        <?php foreach($classroom as $v_room): ?>
                            <option value="ม.<?= esc($v_room) ?>">ม.<?= esc($v_room) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-7">
                    <div id="roomSummary" class="d-none animate__animated animate__fadeIn d-md-flex align-items-center gap-3">
                        <div class="p-3 bg-label-success rounded-3 border border-success border-opacity-10 d-flex align-items-center">
                            <i class="bx bx-group fs-2 me-2"></i>
                            <div>
                                <small class="d-block text-muted text-uppercase mb-0 fw-bold" style="font-size: 0.65rem;">นักเรียนในห้อง</small>
                                <span class="h5 mb-0 fw-bold text-success"><span id="studentCount">0</span> คน</span>
                            </div>
                        </div>
                        <div class="ms-auto d-flex gap-2">
                            <button type="button" id="saveNumbersBtnHeader" class="btn btn-success px-4">
                                <i class="bx bx-save me-1"></i> บันทึกข้อมูล
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Table Card -->
    <div class="card premium-card border-0 d-none" id="studentListContainer">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="studentTable">
                <thead class="table-header-custom">
                    <tr>
                        <th width="10%" class="ps-4 text-center">ปัจจุบัน</th>
                        <th width="15%">รหัสประจำตัว</th>
                        <th width="40%">ชื่อ - นามสกุล</th>
                        <th width="15%" class="text-center">สถานะ</th>
                        <th width="20%" class="pe-4 text-center">ระบุเลขที่</th>
                    </tr>
                </thead>
                <tbody id="studentTableBody">
                    <!-- Loaded via AJAX -->
                </tbody>
            </table>
        </div>
        <div class="card-footer py-4 border-top bg-light-subtle rounded-bottom-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small italic">
                    <i class="bx bx-info-circle me-1"></i> ระบบจะแสดงผลเฉพาะนักเรียนที่มีสถานะ <b>1/ปกติ</b> เท่านั้น
                </div>
                <button type="button" id="saveNumbersBtn" class="btn btn-success btn-lg px-5 shadow-sm">
                    <i class="bx bx-save me-1"></i> ยืนยันการอัปเดตข้อมูล
                </button>
            </div>
        </div>
    </div>

    <!-- Empty State -->
    <div id="emptyState" class="text-center py-5 mt-4">
        <div class="mb-4">
            <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800926.png" alt="Select" style="max-height: 200px; opacity: 0.6;">
        </div>
        <h4 class="text-muted fw-bold">กรุณาเลือกห้องเรียนด้านบน</h4>
        <p class="text-muted">เลือกห้องเรียนเพื่อดึงรายชื่อนักเรียนและจัดการเลขที่ภายในคลิกเดียว</p>
    </div>

    <!-- Save Floating Button -->
    <button type="button" id="saveNumbersBtnFab" class="btn btn-success btn-save-fab">
        <i class="bx bx-save me-1"></i> บันทึกรายการใหม่
    </button>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    let currentStudents = [];
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });

    // Initialize Select2 for classroom selector
    $('#classroomSelector').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: '-- โปรดเลือกห้องเรียน --',
        allowClear: true,
        dropdownParent: $('body')
    });

    // --- Load Students on Selection ---
    $('#classroomSelector').on('change', function() {
        const className = $(this).val();
        if (!className) {
            $('#studentListContainer, #roomSummary, #saveNumbersBtnFab').addClass('d-none');
            $('#emptyState').removeClass('d-none');
            return;
        }

        loadStudents(className);
    });

    function loadStudents(className) {
        Swal.fire({
            title: 'กำลังดึงข้อมูลนักเรียน...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        $.post("<?= base_url('Admin/Acade/Registration/Students/AdjustNumberData') ?>", { className: className }, function(data) {
            currentStudents = data;
            renderTable(currentStudents);
            
            $('#studentCount').text(currentStudents.length);
            $('#studentListContainer, #roomSummary').removeClass('d-none');
            $('#emptyState').addClass('d-none');
            
            // Show FAB if table is long
            checkFabVisibility();
            
            Swal.close();
        });
    }

    function renderTable(students) {
        const tbody = $('#studentTableBody');
        tbody.empty();

        if (students.length === 0) {
            tbody.append('<tr><td colspan="5" class="text-center py-5 text-muted">ไม่พบนักเรียนที่มีสถานะ "ปกติ" ในห้องนี้</td></tr>');
            return;
        }

        students.forEach((s) => {
            const statusBadge = `<span class="badge bg-label-success" style="font-size: 0.7rem;"><i class="bx bxs-circle me-1" style="font-size: 0.5rem;"></i> ${s.StudentStatus}</span>`;
            
            const row = $(`
                <tr class="student-row">
                    <td class="ps-4 text-center">
                        <span class="badge bg-label-secondary font-monospace current-number-badge" style="width: 32px">${s.StudentNumber || '-'}</span>
                    </td>
                    <td><span class="text-primary fw-bold font-monospace">${s.StudentCode}</span></td>
                    <td class="fw-medium text-dark">${s.StudentPrefix}${s.StudentFirstName} ${s.StudentLastName}</td>
                    <td class="text-center">${statusBadge}</td>
                    <td class="pe-4 text-center">
                        <input type="number" class="form-control adjust-number-input mx-auto" 
                                data-id="${s.StudentID}" value="${s.StudentNumber || ''}" min="1" max="60">
                    </td>
                </tr>
            `);
            tbody.append(row);
        });
    }

    // --- Duplicate Number Check & Autosave on Change ---
    $(document).on('input', '.adjust-number-input', function() {
        $(this).removeClass('save-success border-success');
        validateDuplicates();
    });

    $(document).on('change', '.adjust-number-input', function() {
        const input = $(this);
        const id = input.data('id');
        const val = input.val();

        input.removeClass('save-success border-success is-valid');

        const trimmed = val !== undefined && val !== null ? val.toString().trim() : '';
        
        // Re-validate duplicates
        validateDuplicates();

        // If THIS specific input has a duplicate error, do not auto-save it
        if (input.hasClass('border-danger')) {
            return;
        }

        const numbers = {};
        numbers[id] = trimmed;

        $.post("<?= base_url('Admin/Acade/Registration/Students/AdjustNumberUpdate') ?>", { numbers: numbers }, function(res) {
            if (res.status === 'success') {
                input.addClass('save-success is-valid');
                input.closest('tr').find('.current-number-badge').text(trimmed || '-');
                
                // Show inline checkmark
                let indicator = input.parent().find('.save-indicator');
                if (indicator.length === 0) {
                    input.after('<div class="save-indicator text-success mt-1 fw-bold" style="font-size: 0.75rem;"><i class="bx bx-check-circle me-1"></i>บันทึกแล้ว</div>');
                    indicator = input.parent().find('.save-indicator');
                } else {
                    indicator.show();
                }
                setTimeout(() => { 
                    indicator.fadeOut(); 
                    input.removeClass('is-valid'); 
                }, 2500);

            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด: ' + res.message
                });
            }
        }).fail(function() {
            Toast.fire({
                icon: 'error',
                title: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้'
            });
        });
    });

    function validateDuplicates() {
        const inputs = $('.adjust-number-input');
        const values = {};
        let duplicateFound = false;

        // Reset states
        inputs.removeClass('border-danger text-danger').parent().find('.duplicate-error').remove();
        $('#saveNumbersBtn, #saveNumbersBtnHeader, #saveNumbersBtnFab').prop('disabled', false);

        inputs.each(function() {
            const val = $(this).val();
            if (val !== undefined && val !== null) {
                const trimmed = val.toString().trim();
                const numVal = parseInt(trimmed, 10);
                if (trimmed !== '' && !isNaN(numVal) && numVal > 0) {
                    if (values[trimmed]) {
                        values[trimmed].push($(this));
                        duplicateFound = true;
                    } else {
                        values[trimmed] = [$(this)];
                    }
                }
            }
        });

        let actualDuplicateFound = false;
        if (duplicateFound) {
            for (const val in values) {
                if (values[val].length > 1) {
                    actualDuplicateFound = true;
                    values[val].forEach(input => {
                        input.addClass('border-danger text-danger');
                        if (input.parent().find('.duplicate-error').length === 0) {
                            input.after('<div class="duplicate-error text-danger fw-bold mt-1" style="font-size: 0.65rem;"><i class="bx bx-error-circle me-1"></i>เลขที่ซ้ำ</div>');
                        }
                    });
                }
            }
        }

        if (actualDuplicateFound) {
            $('#saveNumbersBtn, #saveNumbersBtnHeader, #saveNumbersBtnFab').prop('disabled', true);
        }
    }

    // (saveNumbersSilent removed as requested)

    function saveNumbers() {
        const numbers = {};
        const seenValues = new Set();
        let hasChanges = false;
        let duplicateCheck = false;

        $('.adjust-number-input').each(function() {
            const id = $(this).data('id');
            const val = $(this).val();
            
            if (val !== undefined && val !== null) {
                const trimmed = val.toString().trim();
                const numVal = parseInt(trimmed, 10);
                if (trimmed !== '' && !isNaN(numVal) && numVal > 0) {
                    if (seenValues.has(trimmed)) {
                        duplicateCheck = true;
                    }
                    seenValues.add(trimmed);
                }
                numbers[id] = trimmed;
                hasChanges = true;
            }
        });

        if (duplicateCheck) {
            Swal.fire('ไม่สามารถบันทึกได้!', 'พบเลขที่ซ้ำกันในห้องนี้ กรุณาแก้ไขก่อนดำเนินการต่อ', 'error');
            validateDuplicates();
            return;
        }

        if (!hasChanges) return;

        Swal.fire({
            title: 'ยืนยันการบันทึก?',
            text: "ข้อมูลเลขที่นักเรียนในห้องนี้จะถูกอัปเดตทั้งหมด",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#15a362',
            confirmButtonText: 'ใช่, บันทึกตอนนี้',
            cancelButtonText: 'ตรวจสอบอีกครั้ง'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'กำลังบันทึก...',
                    didOpen: () => { Swal.showLoading(); }
                });

                $.post("<?= base_url('Admin/Acade/Registration/Students/AdjustNumberUpdate') ?>", { numbers: numbers }, function(res) {
                    if (res.status === 'success') {
                        // Mark inputs as saved successfully
                        $('.adjust-number-input').each(function() {
                            const val = $(this).val();
                            const row = $(this).closest('tr');
                            row.find('.current-number-badge').text(val || '-');
                            $(this).addClass('save-success');
                        });

                        Swal.fire({
                            icon: 'success',
                            title: 'สำเร็จ!',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire('ผิดพลาด!', res.message, 'error');
                    }
                });
            }
        });
    }

    $('#saveNumbersBtn, #saveNumbersBtnHeader, #saveNumbersBtnFab').on('click', saveNumbers);

    // --- Floating Button Visibility ---
    function checkFabVisibility() {
        if (!$('#studentListContainer').hasClass('d-none') && $(window).scrollTop() > 300) {
            $('#saveNumbersBtnFab').fadeIn();
        } else {
            $('#saveNumbersBtnFab').fadeOut();
        }
    }

    $(window).scroll(checkFabVisibility);
});
</script>
<?= $this->endSection() ?>
