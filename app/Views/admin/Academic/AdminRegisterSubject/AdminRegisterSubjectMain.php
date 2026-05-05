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
        padding: 2.5rem;
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
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        pointer-events: none;
    }

    /* Stats Card Premium */
    .stat-card-premium {
        border: none;
        border-radius: var(--border-radius);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: white;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    }

    .stat-card-premium:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08);
    }

    .stat-icon-box {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        transition: all 0.3s;
    }

    .stat-card-premium:hover .stat-icon-box {
        transform: scale(1.1) rotate(-5deg);
    }

    /* Emerald UI Elements */
    .settings-card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        background: white;
    }

    .settings-card-header {
        background-color: white;
        border-bottom: 1px solid #f1f3f5;
        padding: 1.5rem;
        border-top-left-radius: var(--border-radius);
        border-top-right-radius: var(--border-radius);
    }

    .icon-wrapper {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--light-emerald);
        color: var(--primary-emerald);
        font-size: 1.2rem;
    }

    .btn-emerald {
        background-color: var(--primary-emerald);
        border-color: var(--primary-emerald);
        color: white;
        border-radius: 10px;
        padding: 0.6rem 1.25rem;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-emerald:hover {
        background-color: var(--dark-emerald);
        border-color: var(--dark-emerald);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(21, 163, 98, 0.2);
    }

    /* DataTable Overrides */
    .table thead th {
        background-color: #f8f9fa;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        font-weight: 700;
        color: #495057;
        border-bottom: 2px solid #eef2f7;
    }

    .badge-emerald {
        background-color: var(--light-emerald);
        color: var(--dark-emerald);
        border: 1px solid rgba(21, 163, 98, 0.2);
    }

    .form-label { font-weight: 600; color: #444; }
    .form-control, .form-select { border-radius: 10px; padding: 0.6rem 1rem; border: 1px solid #e2e8f0; }
    .form-control:focus, .form-select:focus { border-color: var(--primary-emerald); box-shadow: 0 0 0 3px rgba(21, 163, 98, 0.1); }

    /* Subject Picker */
    .subject-picker-item {
        transition: all 0.2s;
        border: 1px solid transparent;
    }
    .subject-picker-item:hover {
        background-color: var(--light-emerald);
        border-color: rgba(21, 163, 98, 0.1);
    }
    .subject-picker-item.selected {
        background-color: #e8f5ee;
        border-color: var(--primary-emerald);
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y animate__animated animate__fadeIn">
    <!-- Hero Header -->
    <div class="hero-settings">
        <div class="row align-items-center">
            <div class="col-md-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="<?= base_url('Admin/Home') ?>" class="text-white opacity-75">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">งานหลักสูตร</li>
                    </ol>
                </nav>
                <h2 class="fw-bold mb-1 text-white">จัดการรายวิชา</h2>
                <p class="mb-0 text-white opacity-75">ปีการศึกษาที่ดำเนินการ: <span id="headerYear" class="fw-bold"><?= esc($selectedYear) ?></span></p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0" style="position: relative; z-index: 5;">
                <button class="btn btn-white text-emerald fw-bold border-0 shadow-lg px-4 py-2 rounded-pill" type="button" data-bs-toggle="modal" data-bs-target="#ModalAddSubject">
                    <i class="bx bx-plus-circle me-1"></i> เพิ่มรายวิชาจากฐานข้อมูลกลาง
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card-premium p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-1 fw-bold text-dark" id="stat-total">0</h3>
                        <p class="text-muted mb-0 small">รายวิชาทั้งหมด</p>
                    </div>
                    <div class="stat-icon-box" style="background: var(--light-emerald); color: var(--primary-emerald);">
                        <i class="bx bx-book-content"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card-premium p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-1 fw-bold text-success" id="stat-basic">0</h3>
                        <p class="text-muted mb-0 small">วิชาพื้นฐาน</p>
                    </div>
                    <div class="stat-icon-box" style="background: #e8f5e9; color: #2e7d32;">
                        <i class="bx bx-book-open"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card-premium p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-1 fw-bold text-info" id="stat-advanced">0</h3>
                        <p class="text-muted mb-0 small">วิชาเพิ่มเติม</p>
                    </div>
                    <div class="stat-icon-box" style="background: #e1f5fe; color: #0288d1;">
                        <i class="bx bx-bookmark-plus"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card-premium p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-1 fw-bold text-warning" id="stat-year"><?= esc($selectedYear) ?></h3>
                        <p class="text-muted mb-0 small">ปีการศึกษาที่ดำเนินการ</p>
                    </div>
                    <div class="stat-icon-box" style="background: #fff8e1; color: #f57c00;">
                        <i class="bx bx-calendar-event"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="CheckYearNow" value="<?= isset($selectedYear) ? esc($selectedYear) : '' ?>">

    <!-- Data Table Card -->
    <div class="card settings-card">
        <div class="settings-card-header d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="icon-wrapper me-3">
                    <i class="bx bx-list-ul"></i>
                </div>
                <h5 class="mb-0 fw-bold">รายการวิชาที่เปิดสอน</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center">
                    <label class="me-2 fw-bold text-muted small uppercase">เลือกปีการศึกษา:</label>
                    <select class="form-select form-select-sm SelectSubject shadow-sm border-emerald" style="min-width: 160px; border-radius: 12px;">
                        <option value="">ทั้งหมด</option>
                        <?php 
                        $years = array_column($GroupYear, 'SubjectYear');
                        if (!in_array($selectedYear, $years)) {
                            array_unshift($years, $selectedYear);
                        }
                        foreach ($years as $v_Year): ?>
                        <option <?= (isset($selectedYear) && $v_Year == $selectedYear) ? "selected" : ""?>
                            value="<?= esc($v_Year) ?>">
                            <?= esc($v_Year) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover w-100" id="tbSubject">
                    <thead>
                        <tr>
                            <th>ปีการศึกษา</th>
                            <th>รหัสวิชา</th>
                            <th>ชื่อรายวิชา</th>
                            <th>กลุ่มสาระ</th>
                            <th>ระดับชั้น</th>
                            <th class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Subject -->
<div class="modal fade animate__animated animate__fadeIn" id="ModalAddSubject" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content shadow-lg border-0" style="border-radius: 20px;">
            <form id="form-subject-bulk">
                <div class="modal-header px-4 py-3" style="background: var(--primary-emerald);">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper me-3 bg-white text-emerald">
                            <i class="bx bx-plus-circle"></i>
                        </div>
                        <h5 class="modal-title text-white fw-bold mb-0">เพิ่มรายวิชาใหม่ (จากฐานข้อมูลกลาง)</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <!-- Left Column: Config -->
                        <div class="col-lg-4 border-end">
                            <div class="mb-4">
                                <label class="form-label d-flex align-items-center">
                                    <span class="badge bg-emerald me-2">1</span> ภาคเรียน/ปีการศึกษา
                                </label>
                                <select class="form-select shadow-sm" required name="SubjectYear" id="SubjectYear">
                                    <option value="">เลือกภาคเรียน</option>
                                    <?php $d = date('Y')+541; 
                                    for ($i=$d+2; $i >= $d-1 ; $i--) :
                                        for($j=2; $j>=1; $j--):?>
                                    <option <?= (isset($selectedYear) && $selectedYear == $j.'/'.$i) ? "selected" : ""?>
                                        value="<?= esc($j.'/'.$i) ?>"><?= esc($j.'/'.$i) ?></option>
                                    <?php endfor; endfor; ?>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label d-flex align-items-center">
                                    <span class="badge bg-emerald me-2">2</span> ระดับชั้นที่เปิดสอน
                                </label>
                                <select class="form-select shadow-sm" required name="SubjectClass" id="SubjectClass">
                                    <option value="">เลือกระดับชั้น</option>
                                    <?php foreach ($classroom->LevelClass() as $v_sara):?>
                                    <option value="<?= esc($v_sara) ?>"><?= esc($v_sara) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="alert alert-soft-emerald small border-0">
                                <i class="bx bx-info-circle me-1"></i> 
                                เลือกปีและระดับชั้นก่อน จากนั้นเลือกวิชาจากรายการด้านขวาเพื่อทำการบันทึกข้อมูลแบบกลุ่ม (Bulk Insert)
                            </div>
                        </div>

                        <!-- Right Column: Subject Picker -->
                        <div class="col-lg-8">
                            <label class="form-label d-flex align-items-center justify-content-between mb-3">
                                <span class="d-flex align-items-center"><span class="badge bg-emerald me-2">3</span> เลือกรายวิชา</span>
                                <span class="text-muted small" id="checked-count">เลือกแล้ว 0 วิชา</span>
                            </label>
                            
                            <div class="input-group mb-3 shadow-sm rounded-pill overflow-hidden border">
                                <span class="input-group-text bg-white border-0"><i class="bx bx-search text-muted"></i></span>
                                <input type="text" id="search-central-subject" class="form-control border-0 px-2" placeholder="ค้นหารหัสวิชา หรือ ชื่อวิชา...">
                                <button class="btn btn-outline-secondary border-0 btn-sm px-3" type="button" id="clear-search"><i class="bx bx-x"></i></button>
                            </div>

                            <div class="subject-picker-container border rounded-3 p-3" style="max-height: 400px; overflow-y: auto; background: #fcfcfc;">
                                <div class="mb-2 pb-2 border-bottom d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-all-subjects">
                                        <label class="form-check-label fw-bold text-dark" for="check-all-subjects">เลือกทั้งหมด</label>
                                    </div>
                                    <span class="badge bg-label-secondary" id="total-source-count">ทั้งหมด 0 รายการ</span>
                                </div>
                                <div id="central-subject-list" class="mt-2">
                                    <div class="text-center py-5 text-muted">
                                        <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                        กำลังโหลดข้อมูลจากฐานข้อมูลกลาง...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3 bg-light border-0" style="border-radius: 0 0 20px 20px;">
                    <button type="button" class="btn btn-label-secondary rounded-pill px-4" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-emerald px-5 shadow-sm rounded-pill fw-bold" id="btn-submit-bulk">
                        <i class="bx bx-save me-1"></i> บันทึกวิชาเรียนที่เลือก
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Update -->
<div class="modal fade animate__animated animate__fadeIn" id="ModalUpdateSubject" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0" style="border-radius: 20px;">
            <form id="form-update-subject">
                <div class="modal-header px-4 py-3" style="background: var(--primary-emerald);">
                    <h5 class="modal-title text-white fw-bold"><i class="bx bx-edit me-2"></i>แก้ไขข้อมูลรายวิชา</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <input type="hidden" name="Up_SubjectID" id="Up_SubjectID">
                        <div class="col-md-6">
                            <label class="form-label">ภาคเรียน/ปีการศึกษา</label>
                            <select class="form-select" required name="Up_SubjectYear" id="Up_SubjectYear">
                                <?php $d = date('Y')+541; for ($i=$d+2; $i >= $d-1 ; $i--) :?>
                                <option value="1/<?= esc($i);?>">1/<?= esc($i);?></option>
                                <option value="2/<?= esc($i);?>">2/<?= esc($i);?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ระดับชั้น</label>
                            <select class="form-select" required name="Up_SubjectClass" id="Up_SubjectClass">
                                <?php foreach ($classroom->LevelClass() as $v_sara):?>
                                <option value="<?= esc($v_sara) ?>"><?= esc($v_sara) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">รหัสวิชา</label>
                            <input type="text" class="form-control" required name="Up_SubjectCode" id="Up_SubjectCode">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">ชื่อวิชา</label>
                            <input type="text" class="form-control" required name="Up_SubjectName" id="Up_SubjectName">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">หน่วยกิต / ชั่วโมง</label>
                            <div class="input-group">
                                <input type="text" class="form-control" required name="Up_SubjectUnit" id="Up_SubjectUnit" placeholder="นก.">
                                <input type="text" class="form-control" required name="Up_SubjectHour" id="Up_SubjectHour" placeholder="ชม.">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">ประเภทวิชา</label>
                            <select class="form-select" required name="Up_SubjectType" id="Up_SubjectType">
                                <option value="1/พื้นฐาน">1/พื้นฐาน</option>
                                <option value="2/เพิ่มเติม">2/เพิ่มเติม</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">สาระหลัก</label>
                            <select class="form-select" required name="Up_FirstGroup" id="Up_FirstGroup">
                                <?php foreach ($classroom->GroupSaraMain() as $v_sara):?>
                                <option value="<?= esc($v_sara) ?>"><?= esc($v_sara) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">สาระย่อย</label>
                            <select class="form-select" required name="Up_SecondGroup" id="Up_SecondGroup">
                                <?php foreach ($classroom->GroupSaraSecond() as $v_sara):?>
                                <option value="<?= esc($v_sara) ?>"><?= esc($v_sara) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3 bg-light border-0" style="border-radius: 0 0 20px 20px;">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-emerald px-4 shadow-sm">บันทึกการแก้ไข</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    let tablel_Subject;
    let currentYear = $('#CheckYearNow').val();
    let centralSubjects = [];

    loadTable(currentYear);

    function updateStats(data) {
        if (!data || !Array.isArray(data)) return;
        const total = data.length;
        const basic = data.filter(row => {
            let type = (row.SubjectType || '').toString();
            return type.includes('พื้นฐาน') || type.startsWith('1');
        }).length;
        const advanced = data.filter(row => {
            let type = (row.SubjectType || '').toString();
            return type.includes('เพิ่มเติม') || type.startsWith('2');
        }).length;

        $('#stat-total').text(total);
        $('#stat-basic').text(basic);
        $('#stat-advanced').text(advanced);
    }

    $(document).on('change', '.SelectSubject', function() {
        const selectedYear = $(this).val();
        $('#headerYear').text(selectedYear || '-');
        $('#stat-year').text(selectedYear || '-');
        loadTable(selectedYear);
    });

    function loadTable(Year) {
        if ($.fn.DataTable.isDataTable('#tbSubject')) {
            $('#tbSubject').DataTable().destroy();
        }

        tablel_Subject = $('#tbSubject').DataTable({
            responsive: true,
            processing: true,
            language: { url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/Thai.json" },
            ajax: {
                url: "<?= site_url('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectSelect') ?>",
                type: "POST",
                data: { "keyYear": Year },
                dataSrc: function(json) {
                    let rows = (json.data) ? json.data : json;
                    updateStats(rows); 
                    return rows;
                }
            },
            columns: [
                {
                    data: 'SubjectYear',
                    render: function(data) {
                        return '<span class="badge badge-emerald rounded-pill px-3">' + data + '</span>';
                    }
                },
                {
                    data: 'SubjectCode',
                    render: function(data) {
                        return '<span class="fw-bold text-dark">' + data + '</span>';
                    }
                },
                { data: 'SubjectName', className: 'fw-medium' },
                {
                    data: 'FirstGroup',
                    render: function(data) {
                        return '<span class="badge bg-label-info">' + data + '</span>';
                    }
                },
                {
                    data: 'SubjectClass',
                    render: function(data) {
                        return '<span class="badge bg-label-warning">' + data + '</span>';
                    }
                },
                {
                    data: 'SubjectID',
                    className: 'text-center',
                    render: function(data) {
                        return `
                        <div class="d-flex justify-content-center gap-2">
                            <button type="button" class="btn btn-sm btn-icon btn-label-warning EditSubject" idSbuj="${data}"><i class="bx bx-edit"></i></button>
                            <button type="button" class="btn btn-sm btn-icon btn-label-danger delete_subject" idSbuj="${data}"><i class="bx bx-trash"></i></button>
                        </div>`;
                    }
                }
            ]
        });
    }

    // Central Database Integration (Google Sheets CSV)
    const csv_url = "https://docs.google.com/spreadsheets/d/e/2PACX-1vSkmM4H4BP9GDxlVIHb7Eon1xR1jqwmeASdrKAfJLJ3Iplg1cRZGmgkNhNX5Q6ZkrhDSx95WF7h8HHE/pub?output=csv";

    function parseCSV(csvText) {
        const lines = csvText.split(/\r?\n/);
        const result = [];
        const splitLine = (line) => {
            const pattern = /("([^"]*)"|([^,]*))(,|$)/g;
            const fields = [];
            let match;
            while ((match = pattern.exec(line)) !== null) {
                let field = match[2] !== undefined ? match[2] : match[3];
                fields.push(field);
                if (match.index === pattern.lastIndex) pattern.lastIndex++;
                if (match[4] === "") break;
            }
            return fields;
        };

        for (let i = 1; i < lines.length; i++) {
            if (!lines[i].trim()) continue;
            const row = splitLine(lines[i]);
            if (row.length < 2) continue;
            result.push({
                code: row[0],
                name: row[1],
                unit: row[2],
                hour: row[3],
                type: row[4],
                firstGroup: row[5],
                secondGroup: row[6],
                class: row[7],
                searchString: (row[0] + ' ' + row[1]).toLowerCase()
            });
        }
        return result;
    }

    function renderSubjectList(list) {
        const container = $('#central-subject-list');
        container.empty();
        
        if (list.length === 0) {
            container.append('<div class="text-center py-4 text-muted">ไม่พบข้อมูลที่ตรงกับการค้นหา</div>');
            return;
        }

        list.forEach((sub, index) => {
            container.append(`
                <div class="subject-picker-item p-2 mb-1 rounded d-flex align-items-center" data-index="${index}">
                    <div class="form-check mb-0">
                        <input class="form-check-input subject-checkbox" type="checkbox" 
                            id="chk-${index}" 
                            data-code="${sub.code}" 
                            data-name="${sub.name}"
                            data-unit="${sub.unit}"
                            data-hour="${sub.hour}"
                            data-type="${sub.type}"
                            data-first="${sub.firstGroup}"
                            data-second="${sub.secondGroup}"
                            data-class="${sub.class}">
                        <label class="form-check-label ms-2 d-block" for="chk-${index}">
                            <span class="fw-bold text-dark me-2">${sub.code}</span>
                            <span class="text-muted">${sub.name}</span>
                        </label>
                    </div>
                </div>
            `);
        });
        
        $('#total-source-count').text(`ทั้งหมด ${list.length} รายการ`);
    }

    fetch(csv_url)
        .then(response => response.text())
        .then(csvText => {
            centralSubjects = parseCSV(csvText);
            renderSubjectList(centralSubjects);
        })
        .catch(error => {
            console.error("CSV Fetch Error:", error);
            $('#central-subject-list').html('<div class="alert alert-danger">ไม่สามารถโหลดข้อมูลจากฐานข้อมูลกลางได้</div>');
        });

    // Search and Filter
    $('#search-central-subject').on('input', function() {
        const query = $(this).val().toLowerCase();
        const filtered = centralSubjects.filter(sub => sub.searchString.includes(query));
        renderSubjectList(filtered);
    });

    $('#clear-search').click(function() {
        $('#search-central-subject').val('').trigger('input');
    });

    // Checkbox Interactions
    $(document).on('change', '.subject-checkbox', function() {
        $(this).closest('.subject-picker-item').toggleClass('selected', $(this).is(':checked'));
        const count = $('.subject-checkbox:checked').length;
        $('#checked-count').text(`เลือกแล้ว ${count} วิชา`).toggleClass('text-emerald fw-bold', count > 0);
    });

    $('#check-all-subjects').change(function() {
        const isChecked = $(this).is(':checked');
        $('.subject-checkbox:visible').prop('checked', isChecked).trigger('change');
    });

    // Bulk Submit
    $('#form-subject-bulk').submit(function(e) {
        e.preventDefault();
        const year = $('#SubjectYear').val();
        const level = $('#SubjectClass').val();
        const checked = $('.subject-checkbox:checked');

        if (checked.length === 0) {
            Swal.fire('คำเตือน!', 'กรุณาเลือกวิชาอย่างน้อย 1 วิชา', 'warning');
            return;
        }

        const subjects = [];
        checked.each(function() {
            subjects.push({
                SubjectCode: $(this).data('code'),
                SubjectName: $(this).data('name'),
                SubjectUnit: $(this).data('unit'),
                SubjectHour: $(this).data('hour'),
                SubjectType: $(this).data('type'),
                FirstGroup: $(this).data('first'),
                SecondGroup: $(this).data('second'),
                SubjectClass: $(this).data('class') || level, // Use from CSV or from Form
                SubjectYear: year
            });
        });

        const submitBtn = $('#btn-submit-bulk');
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> กำลังบันทึก...');

        $.ajax({
            url: '<?= site_url('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectBulkInsert') ?>',
            type: 'POST',
            data: { 
                subjects: subjects,
                year: year
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({ 
                        icon: 'success', 
                        title: 'สำเร็จ!', 
                        text: response.message,
                        showConfirmButton: false, 
                        timer: 2000 
                    });
                    $('#ModalAddSubject').modal('hide');
                    tablel_Subject.ajax.reload();
                    // Reset form
                    $('.subject-checkbox').prop('checked', false).trigger('change');
                    $('#check-all-subjects').prop('checked', false);
                } else {
                    Swal.fire('ผิดพลาด!', response.message, 'error');
                }
            },
            complete: function() {
                submitBtn.prop('disabled', false).html('<i class="bx bx-save me-1"></i> บันทึกวิชาเรียนที่เลือก');
            }
        });
    });

    // Edit and Delete
    $(document).on('click', '.EditSubject', function() {
        let id = $(this).attr('idSbuj');
        $.ajax({
            url: '<?= site_url('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectEdit') ?>',
            type: 'post',
            data: { KeySubj: id },
            dataType: 'json',
            success: function(data) {
                let d = data[0];
                $('#Up_SubjectYear').val(d.SubjectYear);
                $('#Up_SubjectClass').val(d.SubjectClass);
                $('#Up_SubjectCode').val(d.SubjectCode);
                $('#Up_SubjectName').val(d.SubjectName);
                $('#Up_SubjectUnit').val(d.SubjectUnit);
                $('#Up_SubjectHour').val(d.SubjectHour);
                $('#Up_SubjectType').val(d.SubjectType);
                $('#Up_FirstGroup').val(d.FirstGroup);
                $('#Up_SecondGroup').val(d.SecondGroup);
                $('#Up_SubjectID').val(d.SubjectID);
                $('#ModalUpdateSubject').modal('show');
            }
        });
    });

    $(document).on('submit', '#form-update-subject', function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?= site_url('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectUpdate') ?>',
            type: 'post',
            data: $(this).serialize(),
            success: function(data) {
                $('#ModalUpdateSubject').modal('hide');
                Swal.fire({ icon: 'success', title: 'ปรับปรุงข้อมูลสำเร็จ', showConfirmButton: false, timer: 1500 });
                tablel_Subject.ajax.reload();
            }
        });
    });

    $(document).on('click', '.delete_subject', function() {
        let id = $(this).attr("idSbuj");
        Swal.fire({
            title: 'ยืนยันการลบ?',
            text: "ข้อมูลรายวิชาจะถูกลบถาวร",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= site_url('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectDelete/') ?>' + id,
                    type: 'DELETE',
                    success: function(data) {
                        Swal.fire('ลบสำเร็จ!', 'ข้อมูลถูกลบออกจากระบบแล้ว', 'success');
                        tablel_Subject.ajax.reload();
                    }
                });
            }
        })
    });
});
</script>
<?= $this->endSection() ?>
