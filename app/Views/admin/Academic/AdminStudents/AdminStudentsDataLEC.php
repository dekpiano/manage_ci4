<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Header -->
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">จัดการข้อมูลนักเรียน /</span> ข้อมูลนักเรียนสำหรับ LEC
    </h4>

    <div class="row g-4">
        <!-- Sidebar Filters & Column Selectors -->
        <div class="col-12 col-xl-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom py-3">
                    <h5 class="card-title mb-0 text-success fw-bold">
                        <i class="bx bx-filter-alt me-2"></i>ตัวกรองข้อมูลนักเรียน
                    </h5>
                </div>
                <div class="card-body pt-3">
                    <!-- Filters Form -->
                    <form id="filterForm">
                        <!-- Class Filter -->
                        <div class="mb-3">
                            <label for="classFilter" class="form-label fw-bold">ระดับชั้น / ห้องเรียน</label>
                            <select id="classFilter" name="classFilter" class="form-select border-light-subtle">
                                <option value="">--- ทั้งหมด ---</option>
                                <option value="ม.1">ม.1 ทั้งหมด</option>
                                <option value="ม.2">ม.2 ทั้งหมด</option>
                                <option value="ม.3">ม.3 ทั้งหมด</option>
                                <option value="ม.4">ม.4 ทั้งหมด</option>
                                <option value="ม.5">ม.5 ทั้งหมด</option>
                                <option value="ม.6">ม.6 ทั้งหมด</option>
                                <option value="" disabled>───────────────────</option>
                                <?php if (!empty($class_list)): ?>
                                    <?php foreach ($class_list as $cls): ?>
                                        <option value="ม.<?= $cls ?>">ม.<?= $cls ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div class="mb-3">
                            <label for="statusFilter" class="form-label fw-bold">สถานะนักเรียน</label>
                            <select id="statusFilter" name="statusFilter" class="form-select border-light-subtle">
                                <option value="">--- ทั้งหมด ---</option>
                                <option value="1/ปกติ" selected>1/ปกติ</option>
                                <option value="2/ย้ายสถานศึกษา">2/ย้ายสถานศึกษา</option>
                                <option value="3/ขาดประจำ">3/ขาดประจำ</option>
                                <option value="4/พักการเรียน">4/พักการเรียน</option>
                                <option value="5/จบการศึกษา">5/จบการศึกษา</option>
                            </select>
                        </div>

                        <!-- Behavior Filter -->
                        <div class="mb-3">
                            <label for="behaviorFilter" class="form-label fw-bold">สถานะพฤติกรรม</label>
                            <select id="behaviorFilter" name="behaviorFilter" class="form-select border-light-subtle">
                                <option value="">--- ทั้งหมด ---</option>
                                <option value="ปกติ" selected>ปกติ</option>
                                <option value="ขาดเรียนนาน">ขาดเรียนนาน</option>
                                <option value="พฤติกรรมเสี่ยง">พฤติกรรมเสี่ยง</option>
                                <option value="จำหน่าย">จำหน่าย</option>
                            </select>
                        </div>

                        <!-- Gender Filter -->
                        <div class="mb-3">
                            <label for="genderFilter" class="form-label fw-bold">เพศ</label>
                            <select id="genderFilter" name="genderFilter" class="form-select border-light-subtle">
                                <option value="">--- ทั้งหมด ---</option>
                                <option value="ชาย">ชาย</option>
                                <option value="หญิง">หญิง</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Export Column Selection Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom py-3">
                    <h5 class="card-title mb-0 text-success fw-bold">
                        <i class="bx bx-select-multiple me-2"></i>เลือกคอลัมน์สำหรับส่งออก
                    </h5>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-success btn-xs" id="selectAllCols">เลือกทั้งหมด</button>
                        <button type="button" class="btn btn-outline-secondary btn-xs" id="clearAllCols">ล้างทั้งหมด</button>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <form id="exportColumnsForm" action="<?= base_url('Admin/Acade/Registration/Students/DataExport') ?>" method="get">
                        <!-- Hidden inputs for filters to pass with export -->
                        <input type="hidden" name="classFilter" id="exportClassFilter">
                        <input type="hidden" name="statusFilter" id="exportStatusFilter">
                        <input type="hidden" name="behaviorFilter" id="exportBehaviorFilter">
                        <input type="hidden" name="genderFilter" id="exportGenderFilter">
                        <input type="hidden" name="format" id="exportFormat" value="excel">

                        <!-- Column Groups -->
                        <div class="mb-4">
                            <div class="text-xs text-uppercase text-muted fw-bold mb-2 border-bottom pb-1">
                                <i class="bx bx-id-card me-1"></i>ข้อมูลหลักของนักเรียน
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentCode" id="col_StudentCode" checked>
                                <label class="form-check-label" for="col_StudentCode">เลขประจำตัวนักเรียน</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentIDNumber" id="col_StudentIDNumber" checked>
                                <label class="form-check-label" for="col_StudentIDNumber">เลขประจำตัวประชาชน</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentPrefix" id="col_StudentPrefix" checked>
                                <label class="form-check-label" for="col_StudentPrefix">คำนำหน้าชื่อ</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentFirstName" id="col_StudentFirstName" checked>
                                <label class="form-check-label" for="col_StudentFirstName">ชื่อจริง</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentLastName" id="col_StudentLastName" checked>
                                <label class="form-check-label" for="col_StudentLastName">นามสกุล</label>
                            </div>

                        </div>

                        <div class="mb-4">
                            <div class="text-xs text-uppercase text-muted fw-bold mb-2 border-bottom pb-1">
                                <i class="bx bx-book-bookmark me-1"></i>ข้อมูลระดับชั้นเรียน
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentClass" id="col_StudentClass" checked>
                                <label class="form-check-label" for="col_StudentClass">ระดับชั้น</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentNumber" id="col_StudentNumber" checked>
                                <label class="form-check-label" for="col_StudentNumber">เลขที่</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentStudyLine" id="col_StudentStudyLine" checked>
                                <label class="form-check-label" for="col_StudentStudyLine">สายการเรียน</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="YearIn" id="col_YearIn">
                                <label class="form-check-label" for="col_YearIn">ปีการศึกษาที่เข้าเรียน</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="YearFinish" id="col_YearFinish">
                                <label class="form-check-label" for="col_YearFinish">ปีการศึกษาที่จำหน่าย/จบ</label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="text-xs text-uppercase text-muted fw-bold mb-2 border-bottom pb-1">
                                <i class="bx bx-user-check me-1"></i>ข้อมูลส่วนตัวและสถานะ
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentDateBirth" id="col_StudentDateBirth" checked>
                                <label class="form-check-label" for="col_StudentDateBirth">วันเกิด (พ.ศ.)</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentDateEntrance" id="col_StudentDateEntrance">
                                <label class="form-check-label" for="col_StudentDateEntrance">วันที่เข้าเรียน (พ.ศ.)</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentNationality" id="col_StudentNationality">
                                <label class="form-check-label" for="col_StudentNationality">สัญชาติ</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentRace" id="col_StudentRace">
                                <label class="form-check-label" for="col_StudentRace">เชื้อชาติ</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentRegion" id="col_StudentRegion">
                                <label class="form-check-label" for="col_StudentRegion">ศาสนา</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentStatus" id="col_StudentStatus" checked>
                                <label class="form-check-label" for="col_StudentStatus">สถานะนักเรียน</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="StudentBehavior" id="col_StudentBehavior" checked>
                                <label class="form-check-label" for="col_StudentBehavior">สถานะพฤติกรรม</label>
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div class="mb-4">
                            <div class="text-xs text-uppercase text-muted fw-bold mb-2 border-bottom pb-1">
                                <i class="bx bx-home me-1"></i>ข้อมูลที่อยู่ตามทะเบียนบ้าน
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="stu_hNumber" id="col_stu_hNumber">
                                <label class="form-check-label" for="col_stu_hNumber">บ้านเลขที่</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="stu_hTambon" id="col_stu_hTambon">
                                <label class="form-check-label" for="col_stu_hTambon">ตำบล (แขวง)</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="stu_hDistrict" id="col_stu_hDistrict">
                                <label class="form-check-label" for="col_stu_hDistrict">อำเภอ (เขต)</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="stu_hProvince" id="col_stu_hProvince">
                                <label class="form-check-label" for="col_stu_hProvince">จังหวัด</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="stu_hPostCode" id="col_stu_hPostCode">
                                <label class="form-check-label" for="col_stu_hPostCode">รหัสไปรษณีย์</label>
                            </div>
                        </div>

                        <!-- Additional Personal Info -->
                        <div class="mb-4">
                            <div class="text-xs text-uppercase text-muted fw-bold mb-2 border-bottom pb-1">
                                <i class="bx bx-user me-1"></i>ข้อมูลประวัติส่วนตัวเพิ่มเติม
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="stu_nickName" id="col_stu_nickName">
                                <label class="form-check-label" for="col_stu_nickName">ชื่อเล่น</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="stu_phone" id="col_stu_phone">
                                <label class="form-check-label" for="col_stu_phone">เบอร์โทรศัพท์นักเรียน</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="stu_email" id="col_stu_email">
                                <label class="form-check-label" for="col_stu_email">อีเมล</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="stu_bloodType" id="col_stu_bloodType">
                                <label class="form-check-label" for="col_stu_bloodType">กรุ๊ปเลือด</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="stu_birthDay" id="col_stu_birthDay">
                                <label class="form-check-label" for="col_stu_birthDay">วันเกิด (จาก skjacth_personnel)</label>
                            </div>
                        </div>

                        <!-- Parent Info -->
                        <div class="mb-4">
                            <div class="text-xs text-uppercase text-muted fw-bold mb-2 border-bottom pb-1">
                                <i class="bx bx-group me-1"></i>ข้อมูลบิดา / มารดา / ผู้ปกครอง
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="FatherName" id="col_FatherName">
                                <label class="form-check-label" for="col_FatherName">ชื่อ - นามสกุลบิดา</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="MotherName" id="col_MotherName">
                                <label class="form-check-label" for="col_MotherName">ชื่อ - นามสกุลมารดา</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input col-chk" type="checkbox" name="columns[]" value="GuardianName" id="col_GuardianName">
                                <label class="form-check-label" for="col_GuardianName">ชื่อ - นามสกุลผู้ปกครอง</label>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row g-2 mt-2">
                            <div class="col-6">
                                <button type="button" class="btn btn-success w-100 d-flex align-items-center justify-content-center py-2" id="btnExportExcel" style="background-color: #15a362; border-color: #15a362;">
                                    <i class="bx bxs-file-json me-1 fs-5"></i> Excel (.xlsx)
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-outline-success w-100 d-flex align-items-center justify-content-center py-2" id="btnExportCSV" style="color: #15a362; border-color: #15a362;">
                                    <i class="bx bx-file me-1 fs-5"></i> CSV (.csv)
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Live Preview Data Table -->
        <div class="col-12 col-xl-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0 text-success fw-bold">
                        <i class="bx bx-list-ol me-2"></i>รายการพรีวิวข้อมูลนักเรียน
                    </h5>
                    <span class="badge bg-label-success rounded-pill fw-bold" id="previewCountBadge" style="color: #15a362; background-color: #e8f5ed;">
                        ค้นพบ: - คน
                    </span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover border-top w-100 text-nowrap" id="tbStudent">
                            <thead>
                                <tr>
                                    <th>เลขประจำตัว</th>
                                    <th>ชื่อ - นามสกุล</th>
                                    <th class="text-center">ชั้น</th>
                                    <th class="text-center">เลขที่</th>
                                    <th>สายการเรียน</th>
                                    <th class="text-center">สถานะ</th>
                                    <th class="text-center">พฤติกรรม</th>
                                    <th class="text-center">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 & Modal Backdrop Override Style (Required by UX/UI guidelines) -->
<style>
    .swal2-container {
        z-index: 9999 !important;
    }
    /* Disable modal backdrop for this page to prevent any clicking interference */
    .modal-backdrop {
        display: none !important;
        visibility: hidden !important;
    }
</style>

<!-- DataTables & Interactions JS -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    let table = null;

    // Move recruitment details modal to body immediately on load to prevent z-index backdrop issues
    $('#studentRecruitModal').appendTo('body');

    // Make absolutely sure that the backdrop is destroyed when modal is hidden
    $(document).on('hidden.bs.modal', '#studentRecruitModal', function() {
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css('overflow', '');
    });

    // Load DataTables
    function initializeDataTable() {
        table = $('#tbStudent').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: '<?= base_url("Admin/Acade/Registration/Students/DataShow") ?>',
                type: 'POST',
                data: function(d) {
                    d.classFilter = $('#classFilter').val();
                    d.statusFilter = $('#statusFilter').val();
                    d.behaviorFilter = $('#behaviorFilter').val();
                    d.genderFilter = $('#genderFilter').val();
                },
                error: function(xhr, error, thrown) {
                    console.error('DataTables Error:', error, thrown);
                }
            },
            columns: [
                { data: 'StudentCode', className: 'fw-bold text-nowrap' },
                { data: 'Fullname', className: 'text-nowrap fw-semibold' },
                { data: 'StudentClass', className: 'text-center fw-bold text-success' },
                { data: 'StudentNumber', className: 'text-center' },
                { data: 'StudentStudyLine' },
                { 
                    data: 'StudentStatus',
                    className: 'text-center',
                    render: function(data) {
                        let color = 'secondary';
                        if (data === '1/ปกติ') color = 'success';
                        else if (data === '2/ย้ายสถานศึกษา') color = 'warning';
                        else if (data === '5/จบการศึกษา') color = 'primary';
                        return `<span class="badge bg-label-${color}">${data}</span>`;
                    }
                },
                { 
                    data: 'StudentBehavior',
                    className: 'text-center',
                    render: function(data) {
                        let color = 'secondary';
                        if (data === 'ปกติ') color = 'success';
                        else if (data === 'ขาดเรียนนาน') color = 'danger';
                        else if (data === 'จำหน่าย') color = 'dark';
                        return `<span class="badge bg-${color}">${data}</span>`;
                    }
                },
                {
                    data: 'StudentID',
                    className: 'text-center',
                    orderable: false,
                    render: function(data, type, row) {
                        return `
                            <button type="button" class="btn btn-sm btn-success btn-view-recruit" data-id="${data}" style="background-color: #15a362; border-color: #15a362;">
                                <i class="bx bx-show me-1"></i>ดูข้อมูล
                            </button>
                        `;
                    }
                }
            ],
            language: {
                processing: '<div class="spinner-border text-success" role="status"><span class="visually-hidden">กำลังโหลด...</span></div>',
                lengthMenu: 'แสดง _MENU_ รายการ',
                zeroRecords: 'ไม่พบข้อมูลนักเรียน',
                info: 'แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ คน',
                infoEmpty: 'แสดง 0 ถึง 0 จากทั้งหมด 0 คน',
                infoFiltered: '(กรองจากทั้งหมด _MAX_ คน)',
                search: 'ค้นหาด่วน:',
                paginate: {
                    first: 'หน้าแรก',
                    last: 'หน้าสุดท้าย',
                    next: '<i class="bx bx-chevron-right"></i>',
                    previous: '<i class="bx bx-chevron-left"></i>'
                }
            },
            order: [[2, 'asc'], [3, 'asc']], // Order by class first, then number
            drawCallback: function(settings) {
                // Update dynamic total counts badge
                const api = this.api();
                const totalFiltered = api.page.info().recordsFiltered;
                $('#previewCountBadge').text(`ค้นพบ: ${totalFiltered} คน`);
            }
        });
    }

    initializeDataTable();

    // Catch custom server-side errors
    table.on('xhr.dt', function(e, settings, json, xhr) {
        if (json && json.error) {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาดในการโหลดข้อมูล',
                html: `<div class="text-start fs-7 text-danger p-2 bg-light border rounded" style="font-family: monospace; white-space: pre-wrap; font-size: 13px;">` + json.error + `</div>`,
                confirmButtonText: 'ตกลง',
                confirmButtonColor: '#15a362'
            });
        }
    });

    // Redraw table on filter change
    $('#classFilter, #statusFilter, #behaviorFilter, #genderFilter').on('change', function() {
        if (table) {
            table.draw();
        }
    });

    // Checklist toggles
    $('#selectAllCols').on('click', function() {
        $('.col-chk').prop('checked', true);
    });

    // Clear all cols checklist toggle (preserve at least one required to avoid empty query error)
    $('#clearAllCols').on('click', function() {
        $('.col-chk').prop('checked', false);
        $('#col_StudentCode').prop('checked', true); // Safe fallback
    });

    // Handle export clicks
    function triggerExport(format) {
        // Collect checked columns
        const checkedCols = [];
        $('.col-chk:checked').each(function() {
            checkedCols.push($(this).val());
        });

        if (checkedCols.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'โปรดเลือกคอลัมน์',
                text: 'กรุณาเลือกคอลัมน์ที่จะส่งออกอย่างน้อย 1 คอลัมน์ครับ!',
                confirmButtonColor: '#15a362'
            });
            return;
        }

        // Set hidden filter inputs
        $('#exportClassFilter').val($('#classFilter').val());
        $('#exportStatusFilter').val($('#statusFilter').val());
        $('#exportBehaviorFilter').val($('#behaviorFilter').val());
        $('#exportGenderFilter').val($('#genderFilter').val());
        $('#exportFormat').val(format);

        // Submit form
        $('#exportColumnsForm').submit();

        // Premium alert toast
        Swal.fire({
            icon: 'success',
            title: 'เริ่มดาวน์โหลดไฟล์',
            text: `ระบบกำลังดึงข้อมูลและเตรียมไฟล์ ${format.toUpperCase()} ให้กับคุณครับ`,
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    }

    $('#btnExportExcel').on('click', function() {
        triggerExport('excel');
    });

    $('#btnExportCSV').on('click', function() {
        triggerExport('csv');
    });

    // AJAX click handler to view student recruitment details modal
    $(document).on('click', '.btn-view-recruit', function() {
        const studentId = $(this).data('id');
        
        // Show SweetAlert2 loading spinner first
        Swal.fire({
            title: 'กำลังดึงข้อมูลใบสมัคร...',
            html: '<div class="py-3"><div class="spinner-border text-success" style="width: 3rem; height: 3rem;"></div></div>',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Fetch detailed content
        $.ajax({
            url: '<?= base_url("Admin/Academic/ConAdminStudents/get_student_admission_details") ?>/' + studentId,
            type: 'GET',
            success: function(responseHtml) {
                Swal.close();
                setTimeout(function() {
                    $('#studentRecruitContent').html(responseHtml);
                    $('#studentRecruitModal').appendTo('body').modal('show');
                }, 150);
            },
            error: function(xhr, status, error) {
                Swal.close();
                setTimeout(function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถโหลดข้อมูลผู้สมัครได้: ' + error,
                        confirmButtonColor: '#15a362'
                    });
                }, 150);
            }
        });
    });
});
</script>

<!-- Student Admission Details Modal -->
<div class="modal fade" id="studentRecruitModal" tabindex="-1" aria-labelledby="studentRecruitModalLabel" aria-hidden="true" data-bs-backdrop="false" style="z-index: 1060;">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header py-3" style="background-color: #15a362; border-bottom: none;">
                <h5 class="modal-title text-white fw-bold" id="studentRecruitModalLabel">
                    <i class="bx bx-user-circle me-2 fs-4"></i>ประวัติข้อมูลการรับสมัครเรียนรายบุคคล (Admission)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light-subtle" id="studentRecruitContent">
                <!-- Dynamically loaded student recruitment details -->
            </div>
            <div class="modal-footer py-2 border-top bg-light">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                    <i class="bx bx-x me-1"></i>ปิดหน้าต่าง
                </button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>