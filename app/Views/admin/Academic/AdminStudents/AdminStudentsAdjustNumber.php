<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
    /* ===== Green Theme & Contrast Standard ===== */
    :root {
        --primary-green: #15a362;
        --dark-green: #0d6d41;
        --light-green: #e8f5ee;
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    .adjust-page-header {
        background: linear-gradient(135deg, #15a362 0%, #0d6d41 100%);
        border-radius: 16px;
        padding: 2.25rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 12px 35px rgba(21, 163, 98, 0.28);
    }

    .adjust-page-header::after {
        content: "";
        position: absolute;
        top: -60px;
        right: -60px;
        width: 260px;
        height: 260px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        pointer-events: none;
    }

    .adjust-page-header .header-content { position: relative; z-index: 2; }
    .adjust-page-header .header-title { color: #ffffff !important; opacity: 1 !important; font-weight: 800; letter-spacing: -0.5px; }
    .adjust-page-header .header-subtitle { color: #ffffff !important; opacity: 1 !important; font-weight: 500; font-size: 0.95rem; }
    .adjust-page-header .breadcrumb-item a,
    .adjust-page-header .breadcrumb-item.active,
    .adjust-page-header .breadcrumb-item + .breadcrumb-item::before {
        color: #ffffff !important;
        opacity: 1 !important;
        font-weight: 500;
    }

    /* Card Styling */
    .premium-card {
        border: none;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        background-color: #ffffff;
    }

    .classroom-select-card {
        margin-top: -3.5rem;
        z-index: 10;
        position: relative;
        border: 1px solid rgba(21, 163, 98, 0.15);
    }

    /* ===== Form Floating & Animated Select2 ===== */
    .form-floating-custom {
        position: relative;
    }

    /* Label resting in vertical center before selection */
    .form-floating-custom > label,
    .form-floating-custom > .form-select ~ label {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 58px;
        padding: 1.15rem 1rem 0.5rem;
        overflow: hidden;
        text-align: start;
        text-overflow: ellipsis;
        white-space: nowrap;
        pointer-events: none;
        border: 1px solid transparent;
        transform-origin: 0 0;
        transform: scale(1) translateY(0) !important;
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), color 0.2s ease, opacity 0.2s ease !important;
        color: #697a8d !important;
        font-size: 0.95rem;
        line-height: 1.25;
        z-index: 5;
        margin: 0;
    }

    .form-floating-custom > .select2-container--bootstrap-5 {
        width: 100% !important;
    }

    .form-floating-custom > .select2-container--bootstrap-5 .select2-selection {
        height: 58px !important;
        min-height: 58px !important;
        padding: 0 1rem !important;
        border-radius: 12px !important;
        border: 1.5px solid #d9dee3 !important;
        display: flex !important;
        align-items: center !important;
        background-color: #fff !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    .form-floating-custom > .select2-container--bootstrap-5.select2-container--focus .select2-selection,
    .form-floating-custom > .select2-container--bootstrap-5.select2-container--open .select2-selection,
    .form-floating-custom.is-focused > .select2-container--bootstrap-5 .select2-selection {
        border-color: #15a362 !important;
        box-shadow: 0 0 0 0.25rem rgba(21, 163, 98, 0.15) !important;
    }

    /* Rendered text inside select: hidden at rest, visible when floated */
    .form-floating-custom:not(.is-floated):not(.is-focused):not(:has(.select2-container--open)) .select2-selection__rendered {
        opacity: 0 !important;
        transition: opacity 0.2s ease;
    }

    .form-floating-custom.is-floated .select2-selection__rendered,
    .form-floating-custom.is-focused .select2-selection__rendered,
    .form-floating-custom:has(.select2-container--open) .select2-selection__rendered {
        opacity: 1 !important;
        padding-top: 1.35rem !important;
        padding-left: 0 !important;
        padding-right: 1.5rem !important;
        color: #212529 !important;
        font-weight: 600 !important;
        font-size: 1rem !important;
        line-height: 1.25 !important;
        transition: opacity 0.2s ease, padding 0.2s ease;
    }

    .form-floating-custom > .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
        top: 50% !important;
        transform: translateY(-50%) !important;
        right: 1rem !important;
        transition: transform 0.25s ease !important;
    }

    .form-floating-custom > .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow,
    .form-floating-custom.is-focused .select2-selection--single .select2-selection__arrow {
        transform: translateY(-50%) rotate(180deg) !important;
    }

    /* When Floated or Focused: Animate label down slightly from the very top */
    .form-floating-custom.is-floated > label,
    .form-floating-custom.is-focused > label,
    .form-floating-custom:has(.select2-container--open) > label,
    .form-floating-custom:has(.select2-container--focus) > label {
        transform: scale(.8) translateY(-0.55rem) translateX(.15rem) !important;
        color: #15a362 !important;
        font-weight: 600 !important;
    }

    .select2-container--bootstrap-5 .select2-dropdown .select2-results__options .select2-results__option--highlighted {
        background-color: #15a362 !important;
        color: #ffffff !important;
    }

    .select2-container--bootstrap-5 .select2-dropdown .select2-results__options .select2-results__option[aria-selected="true"] {
        background-color: #e8f5ed !important;
        color: #15a362 !important;
        font-weight: 600 !important;
    }

    /* Table Styling */
    .table-header-custom {
        background: #f8f9fa;
        border-bottom: 2px solid rgba(21, 163, 98, 0.12) !important;
    }
    .table-header-custom th {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.78rem;
        letter-spacing: 0.5px;
        color: #566a7f;
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .adjust-number-input {
        max-width: 90px;
        text-align: center;
        font-weight: 800;
        border: 2px solid #eaedf1;
        border-radius: 10px;
        padding: 0.45rem;
        font-size: 1.05rem;
        color: var(--primary-green);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        background-color: #ffffff;
    }

    .adjust-number-input:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 0.25rem rgba(21, 163, 98, 0.15);
        transform: scale(1.05);
    }

    .student-row { transition: all 0.15s ease; }
    .student-row:hover {
        background-color: rgba(21, 163, 98, 0.04) !important;
    }

    /* Quick Action Toolbar */
    .quick-tools-card {
        background: #fdfdfd;
        border: 1px solid rgba(21, 163, 98, 0.12);
        border-radius: 12px;
        padding: 0.85rem 1.25rem;
    }

    .btn-tool {
        font-weight: 600;
        font-size: 0.85rem;
        border-radius: 8px;
        padding: 0.45rem 0.85rem;
        transition: all 0.2s ease;
    }
    .btn-tool:hover {
        transform: translateY(-1px);
    }

    /* Save Floating Button (FAB) */
    .btn-save-fab {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        padding: 0.85rem 1.75rem;
        border-radius: 50px;
        box-shadow: 0 10px 25px rgba(21, 163, 98, 0.35);
        z-index: 1000;
        font-weight: 700;
        color: #ffffff !important;
        opacity: 1 !important;
        display: none;
    }

    /* Save Feedback */
    .adjust-number-input.save-success {
        border-color: var(--primary-green) !important;
        background-color: rgba(21, 163, 98, 0.08) !important;
        color: var(--primary-green) !important;
        box-shadow: 0 0 0 0.25rem rgba(21, 163, 98, 0.15) !important;
    }

    /* Empty State Styling */
    .empty-state-icon-box {
        width: 100px;
        height: 100px;
        background-color: var(--light-green);
        border: 2px dashed var(--primary-green);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
        color: var(--primary-green);
        transition: transform 0.3s ease;
    }
    .empty-state-icon-box:hover {
        transform: scale(1.05) rotate(5deg);
    }

    .swal2-container {
        z-index: 99999 !important;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Premium Header -->
    <div class="adjust-page-header">
        <div class="header-content d-flex justify-content-between align-items-center">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="<?= base_url('Admin/Acade/Registration/Students') ?>"><i class="bx bx-user me-1"></i>จัดการนักเรียน</a></li>
                        <li class="breadcrumb-item active" aria-current="page">ปรับเลขที่รายห้อง</li>
                    </ol>
                </nav>
                <h2 class="header-title mb-1">✨ จัดการเลขที่นักเรียนรายห้องเรียน</h2>
                <p class="header-subtitle mb-0">ระบบจัดเลขที่นักเรียน (สถานะ: 1/ปกติ) พร้อมเครื่องมือจัดเรียงและรันเลขที่อัตโนมัติ</p>
            </div>
            <div class="d-none d-md-block text-white opacity-75">
                <i class="bx bx-list-ol" style="font-size: 4rem;"></i>
            </div>
        </div>
    </div>

    <!-- Classroom Selection Panel -->
    <div class="card premium-card classroom-select-card mb-4">
        <div class="card-body p-4">
            <div class="row g-4 align-items-center">
                <div class="col-md-5">
                    <div class="form-floating form-floating-custom" id="floatingClassroomContainer">
                        <select id="classroomSelector" class="form-select" style="width: 100%;">
                            <option value=""></option>
                            <?php foreach($classroom as $v_room): ?>
                                <option value="ม.<?= esc($v_room) ?>">ม.<?= esc($v_room) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="classroomSelector">
                            <i class="bx bx-door-open me-1 text-success"></i> เลือกระดับชั้น/ห้องเรียนที่ต้องการจัดการ
                        </label>
                    </div>
                </div>
                <div class="col-md-7">
                    <div id="roomSummary" class="d-none d-md-flex align-items-center gap-3">
                        <div class="p-3 bg-label-success rounded-3 border border-success border-opacity-10 d-flex align-items-center">
                            <i class="bx bx-group fs-2 me-2 text-success"></i>
                            <div>
                                <small class="d-block text-muted text-uppercase mb-0 fw-bold" style="font-size: 0.65rem;">นักเรียนในห้อง</small>
                                <span class="h5 mb-0 fw-bold text-success"><span id="studentCount">0</span> คน</span>
                            </div>
                        </div>
                        <div class="p-3 bg-label-primary rounded-3 border border-primary border-opacity-10 d-none d-lg-flex align-items-center">
                            <i class="bx bx-male-female fs-2 me-2 text-primary"></i>
                            <div>
                                <small class="d-block text-muted text-uppercase mb-0 fw-bold" style="font-size: 0.65rem;">เพศ ชาย / หญิง</small>
                                <span class="h6 mb-0 fw-bold text-primary">
                                    <span id="maleCount">0</span> ชาย / <span id="femaleCount">0</span> หญิง
                                </span>
                            </div>
                        </div>
                        <div class="ms-auto d-flex gap-2">
                            <button type="button" id="saveNumbersBtnHeader" class="btn btn-success px-4" style="background-color: #15a362; border-color: #15a362;">
                                <i class="bx bx-save me-1"></i> บันทึกข้อมูล
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Action Toolbar (Shown when classroom is selected) -->
    <div class="card premium-card mb-4 d-none" id="quickToolsContainer">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-label-success p-2 rounded-circle me-1">
                        <i class="bx bx-slider-alt text-success fs-5"></i>
                    </span>
                    <div>
                        <div class="fw-bold text-dark" style="font-size: 0.9rem;">เครื่องมือจัดเลขที่อัตโนมัติ</div>
                        <small class="text-muted">คลิกเพื่อเรียงลำดับและกำหนดเลขที่ให้อัตโนมัติ</small>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-outline-success btn-tool" id="btnAutoRun">
                        <i class="bx bx-sort-up me-1"></i> รัน 1..N ตามแถว
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-tool" id="btnSortByCode">
                        <i class="bx bx-id-card me-1"></i> เรียงตามรหัสนักเรียน
                    </button>
                    <button type="button" class="btn btn-outline-info btn-tool" id="btnSortByGender">
                        <i class="bx bx-male-female me-1"></i> แยก ชาย ➔ หญิง
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-tool" id="btnSortByName">
                        <i class="bx bx-sort-a-z me-1"></i> เรียงตามชื่อ (ก-ฮ)
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-tool" id="btnClearNumbers">
                        <i class="bx bx-eraser me-1"></i> ล้างเลขที่
                    </button>
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
                        <th width="8%" class="ps-4 text-center">ปัจจุบัน</th>
                        <th width="14%">รหัสประจำตัว</th>
                        <th width="10%" class="text-center">เพศ</th>
                        <th width="38%">ชื่อ - นามสกุล</th>
                        <th width="12%" class="text-center">สถานะ</th>
                        <th width="18%" class="pe-4 text-center">ระบุเลขที่</th>
                    </tr>
                </thead>
                <tbody id="studentTableBody">
                    <!-- Loaded via AJAX -->
                </tbody>
            </table>
        </div>
        <div class="card-footer py-4 border-top bg-light-subtle rounded-bottom-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="text-muted small">
                    <i class="bx bx-info-circle me-1 text-success"></i> ระบบจะแสดงผลเฉพาะนักเรียนที่มีสถานะ <b>1/ปกติ</b> เท่านั้น | สามารถพิมพ์เปลี่ยนเลขที่ได้ทันที ระบบจะบันทึกให้อัตโนมัติ
                </div>
                <button type="button" id="saveNumbersBtn" class="btn btn-success btn-lg px-5 shadow-sm" style="background-color: #15a362; border-color: #15a362;">
                    <i class="bx bx-save me-1"></i> ยืนยันการบันทึกข้อมูลทั้งหมด
                </button>
            </div>
        </div>
    </div>

    <!-- Empty State -->
    <div id="emptyState" class="card premium-card text-center py-5 mt-2">
        <div class="card-body py-5">
            <div class="empty-state-icon-box">
                <i class="bx bx-door-open" style="font-size: 3.5rem;"></i>
            </div>
            <h4 class="text-dark fw-bold mb-2">กรุณาเลือกระดับชั้น/ห้องเรียนด้านบน</h4>
            <p class="text-muted mb-0 mx-auto" style="max-width: 480px;">
                เลือกระดับชั้นเพื่อดึงรายชื่อนักเรียนและเปิดใช้งานเครื่องมือจัดเลขที่อัตโนมัติ สะดวก รวดเร็ว และแม่นยำ
            </p>
        </div>
    </div>

    <!-- Save Floating Button -->
    <button type="button" id="saveNumbersBtnFab" class="btn btn-success btn-save-fab" style="background-color: #15a362; border-color: #15a362;">
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

    // Helper: Sync form-floating label state
    function syncClassroomFloatingLabel() {
        const val = $('#classroomSelector').val();
        const $container = $('#floatingClassroomContainer');
        if (val && val.toString().trim() !== '') {
            $container.addClass('is-floated');
        } else {
            $container.removeClass('is-floated');
        }
    }

    // Initialize Select2 with Bootstrap 5 theme
    const $selector = $('#classroomSelector').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: '',
        allowClear: true,
        dropdownParent: $('body')
    });

    $selector.on('select2:opening select2:open', function() {
        $('#floatingClassroomContainer').addClass('is-focused is-floated');
    });

    $selector.on('select2:closing select2:close', function() {
        $('#floatingClassroomContainer').removeClass('is-focused');
        syncClassroomFloatingLabel();
    });

    // Load Students on Selection
    $selector.on('change', function() {
        syncClassroomFloatingLabel();
        const className = $(this).val();
        if (!className) {
            $('#studentListContainer, #quickToolsContainer, #roomSummary, #saveNumbersBtnFab').addClass('d-none');
            $('#emptyState').removeClass('d-none');
            currentStudents = [];
            return;
        }

        loadStudents(className);
    });

    function loadStudents(className) {
        Swal.fire({
            title: 'กำลังดึงข้อมูลนักเรียน...',
            text: 'ห้อง ' + className,
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        $.post("<?= base_url('Admin/Acade/Registration/Students/AdjustNumberData') ?>", { className: className }, function(data) {
            currentStudents = Array.isArray(data) ? data : [];
            renderTable(currentStudents);
            
            // Stats
            $('#studentCount').text(currentStudents.length);
            let males = 0, females = 0;
            currentStudents.forEach(s => {
                const sex = (s.StudentSex || '').trim();
                const prefix = (s.StudentPrefix || '').trim();
                if (sex === 'ชาย' || prefix === 'นาย' || prefix === 'เด็กชาย' || prefix === 'ด.ช.') males++;
                else females++;
            });
            $('#maleCount').text(males);
            $('#femaleCount').text(females);

            $('#studentListContainer, #quickToolsContainer, #roomSummary').removeClass('d-none');
            $('#emptyState').addClass('d-none');
            
            checkFabVisibility();
            Swal.close();
        }).fail(function() {
            Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถดึงข้อมูลนักเรียนได้ กรุณาลองใหม่อีกครั้ง', 'error');
        });
    }

    function renderTable(students) {
        const tbody = $('#studentTableBody');
        tbody.empty();

        if (students.length === 0) {
            tbody.append('<tr><td colspan="6" class="text-center py-5 text-muted">ไม่พบนักเรียนที่มีสถานะ "1/ปกติ" ในห้องนี้</td></tr>');
            return;
        }

        students.forEach((s) => {
            const statusBadge = `<span class="badge bg-label-success" style="font-size: 0.75rem;"><i class="bx bxs-circle me-1" style="font-size: 0.5rem;"></i> ${s.StudentStatus || 'ปกติ'}</span>`;
            
            const sexStr = (s.StudentSex || '').trim();
            const prefixStr = (s.StudentPrefix || '').trim();
            const isMale = sexStr === 'ชาย' || prefixStr === 'นาย' || prefixStr === 'เด็กชาย' || prefixStr === 'ด.ช.';
            const sexBadge = isMale 
                ? `<span class="badge bg-label-info"><i class="bx bx-male me-1"></i>ชาย</span>`
                : `<span class="badge bg-label-danger"><i class="bx bx-female me-1"></i>หญิง</span>`;

            const row = $(`
                <tr class="student-row" data-id="${s.StudentID}">
                    <td class="ps-4 text-center">
                        <span class="badge bg-label-secondary font-monospace current-number-badge" style="min-width: 34px; font-size: 0.85rem;">
                            ${s.StudentNumber || '-'}
                        </span>
                    </td>
                    <td>
                        <span class="text-primary fw-bold font-monospace">
                            <i class="bx bx-id-card me-1 opacity-50"></i>${s.StudentCode}
                        </span>
                    </td>
                    <td class="text-center">${sexBadge}</td>
                    <td class="fw-medium text-dark">${s.StudentPrefix || ''}${s.StudentFirstName || ''} ${s.StudentLastName || ''}</td>
                    <td class="text-center">${statusBadge}</td>
                    <td class="pe-4 text-center">
                        <input type="number" class="form-control adjust-number-input mx-auto" 
                                data-id="${s.StudentID}" 
                                value="${s.StudentNumber || ''}" 
                                min="1" max="100" 
                                placeholder="-">
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
        
        validateDuplicates();

        if (input.hasClass('border-danger')) {
            return;
        }

        const numbers = {};
        numbers[id] = trimmed;

        $.post("<?= base_url('Admin/Acade/Registration/Students/AdjustNumberUpdate') ?>", { numbers: numbers }, function(res) {
            if (res.status === 'success') {
                input.addClass('save-success is-valid');
                input.closest('tr').find('.current-number-badge').text(trimmed || '-');
                
                // Update local memory
                const match = currentStudents.find(st => st.StudentID == id);
                if (match) match.StudentNumber = trimmed;

                let indicator = input.parent().find('.save-indicator');
                if (indicator.length === 0) {
                    input.after('<div class="save-indicator text-success mt-1 fw-bold" style="font-size: 0.72rem;"><i class="bx bx-check-circle me-1"></i>บันทึกแล้ว</div>');
                    indicator = input.parent().find('.save-indicator');
                } else {
                    indicator.show();
                }
                setTimeout(() => { 
                    indicator.fadeOut(); 
                    input.removeClass('is-valid'); 
                }, 2000);

            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด: ' + (res.message || 'ไม่สามารถบันทึกได้')
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
                            input.after('<div class="duplicate-error text-danger fw-bold mt-1" style="font-size: 0.68rem;"><i class="bx bx-error-circle me-1"></i>เลขที่ซ้ำ</div>');
                        }
                    });
                }
            }
        }

        if (actualDuplicateFound) {
            $('#saveNumbersBtn, #saveNumbersBtnHeader, #saveNumbersBtnFab').prop('disabled', true);
        }
    }

    // ==========================================
    // Smart Sorting & Auto-Numbering Operations
    // ==========================================

    // 1. Run 1..N based on current visible rows
    $('#btnAutoRun').on('click', function() {
        if (currentStudents.length === 0) return;
        
        let counter = 1;
        $('#studentTableBody tr').each(function() {
            const input = $(this).find('.adjust-number-input');
            input.val(counter++);
            input.removeClass('border-danger text-danger save-success');
        });
        
        validateDuplicates();
        Toast.fire({
            icon: 'info',
            title: 'รันเลขที่ 1 ถึง ' + (counter - 1) + ' เรียบร้อยแล้ว (อย่าลืมกดบันทึก)'
        });
    });

    // 2. Sort by Student Code ASC & re-number
    $('#btnSortByCode').on('click', function() {
        if (currentStudents.length === 0) return;

        Swal.fire({
            title: 'เรียงตามรหัสประจำตัว?',
            text: 'จะเรียงลำดับนักเรียนตามรหัสประจำตัวจากน้อยไปมาก และรันเลขที่ 1 ถึง ' + currentStudents.length,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#15a362',
            confirmButtonText: 'ยืนยันเรียงลำดับ',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                currentStudents.sort((a, b) => {
                    const codeA = parseInt((a.StudentCode || '').toString().replace(/\D/g, ''), 10) || 0;
                    const codeB = parseInt((b.StudentCode || '').toString().replace(/\D/g, ''), 10) || 0;
                    return codeA - codeB;
                });
                applySortedListAndRenumber();
            }
        });
    });

    // 3. Separate Male -> Female, then by Code
    $('#btnSortByGender').on('click', function() {
        if (currentStudents.length === 0) return;

        Swal.fire({
            title: 'แยก ชาย ➔ หญิง?',
            text: 'จะจัดกลุ่มนักเรียนชายขึ้นก่อน แล้วตามด้วยนักเรียนหญิง จากนั้นรันเลขที่ 1 ถึง ' + currentStudents.length,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#15a362',
            confirmButtonText: 'ยืนยันแยกเพศ',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                const isMale = (s) => {
                    const sex = (s.StudentSex || '').trim();
                    const prefix = (s.StudentPrefix || '').trim();
                    return sex === 'ชาย' || prefix === 'นาย' || prefix === 'เด็กชาย' || prefix === 'ด.ช.';
                };

                currentStudents.sort((a, b) => {
                    const aMale = isMale(a) ? 0 : 1;
                    const bMale = isMale(b) ? 0 : 1;
                    if (aMale !== bMale) return aMale - bMale;

                    const codeA = parseInt((a.StudentCode || '').toString().replace(/\D/g, ''), 10) || 0;
                    const codeB = parseInt((b.StudentCode || '').toString().replace(/\D/g, ''), 10) || 0;
                    return codeA - codeB;
                });
                applySortedListAndRenumber();
            }
        });
    });

    // 4. Sort by Name (ก-ฮ)
    $('#btnSortByName').on('click', function() {
        if (currentStudents.length === 0) return;

        Swal.fire({
            title: 'เรียงตามชื่อ (ก-ฮ)?',
            text: 'จะเรียงลำดับตามชื่อ-นามสกุลภาษาไทย และรันเลขที่ 1 ถึง ' + currentStudents.length,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#15a362',
            confirmButtonText: 'ยืนยันเรียงชื่อ',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                currentStudents.sort((a, b) => {
                    const nameA = (a.StudentFirstName || '').toString().trim();
                    const nameB = (b.StudentFirstName || '').toString().trim();
                    const comp = nameA.localeCompare(nameB, 'th');
                    if (comp !== 0) return comp;
                    return (a.StudentLastName || '').toString().trim().localeCompare((b.StudentLastName || '').toString().trim(), 'th');
                });
                applySortedListAndRenumber();
            }
        });
    });

    // 5. Clear All Numbers
    $('#btnClearNumbers').on('click', function() {
        if (currentStudents.length === 0) return;

        Swal.fire({
            title: 'ล้างเลขที่ทั้งหมด?',
            text: 'ช่องระบุเลขที่จะถูกล้างเป็นค่าว่างทั้งหมดในห้องนี้',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'ใช่, ล้างเลขที่',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $('.adjust-number-input').val('');
                validateDuplicates();
                Toast.fire({
                    icon: 'warning',
                    title: 'ล้างเลขที่เรียบร้อยแล้ว กด "บันทึกข้อมูล" เพื่อยืนยัน'
                });
            }
        });
    });

    function applySortedListAndRenumber() {
        currentStudents.forEach((st, idx) => {
            st.StudentNumber = idx + 1;
        });
        renderTable(currentStudents);
        validateDuplicates();
        Toast.fire({
            icon: 'success',
            title: 'จัดเรียงและรันเลขที่เรียบร้อยแล้ว กรุณากด "บันทึกข้อมูล"'
        });
    }

    // ==========================================
    // Save All Numbers to Database
    // ==========================================
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

        if (!hasChanges) {
            Toast.fire({ icon: 'info', title: 'ไม่มีข้อมูลที่ต้องบันทึก' });
            return;
        }

        Swal.fire({
            title: 'ยืนยันการบันทึก?',
            text: "ข้อมูลเลขที่นักเรียนทั้งหมดในห้องนี้จะถูกอัปเดตลงสู่ฐานข้อมูล",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#15a362',
            confirmButtonText: 'ใช่, บันทึกตอนนี้',
            cancelButtonText: 'ตรวจสอบอีกครั้ง'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'กำลังบันทึก...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                $.post("<?= base_url('Admin/Acade/Registration/Students/AdjustNumberUpdate') ?>", { numbers: numbers }, function(res) {
                    if (res.status === 'success') {
                        $('.adjust-number-input').each(function() {
                            const val = $(this).val();
                            const row = $(this).closest('tr');
                            row.find('.current-number-badge').text(val || '-');
                            $(this).addClass('save-success');
                        });

                        Swal.fire({
                            icon: 'success',
                            title: 'บันทึกสำเร็จ!',
                            text: res.message,
                            timer: 1600,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire('ผิดพลาด!', res.message || 'ไม่สามารถบันทึกข้อมูลได้', 'error');
                    }
                }).fail(function() {
                    Swal.fire('ผิดพลาด!', 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้', 'error');
                });
            }
        });
    }

    $('#saveNumbersBtn, #saveNumbersBtnHeader, #saveNumbersBtnFab').on('click', saveNumbers);

    // Floating Button Visibility
    function checkFabVisibility() {
        if (!$('#studentListContainer').hasClass('d-none') && $(window).scrollTop() > 300) {
            $('#saveNumbersBtnFab').fadeIn();
        } else {
            $('#saveNumbersBtnFab').fadeOut();
        }
    }

    $(window).scroll(checkFabVisibility);
    syncClassroomFloatingLabel();
});
</script>
<?= $this->endSection() ?>
