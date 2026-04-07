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
        pointer-events: none; /* ป้องกันการทับซ้อนบุ่ม */
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
                <p class="mb-0 text-white opacity-75">ปีการศึกษาปัจจุบัน: <span id="headerYear" class="fw-bold"><?= isset($SchoolYear->schyear_year) ? esc($SchoolYear->schyear_year) : '-' ?></span></p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0" style="position: relative; z-index: 5;">
                <button class="btn btn-emerald bg-white text-dark border-0 shadow-lg" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAddSubject">
                    <i class="bx bx-plus-circle me-1"></i> เพิ่มรายวิชาใหม่
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
                        <h3 class="mb-1 fw-bold text-warning" id="stat-year"><?= isset($SchoolYear->schyear_year) ? esc($SchoolYear->schyear_year) : '-' ?></h3>
                        <p class="text-muted mb-0 small">ปีการศึกษาที่ดำเนินการ</p>
                    </div>
                    <div class="stat-icon-box" style="background: #fff8e1; color: #f57c00;">
                        <i class="bx bx-calendar-event"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="CheckYearNow" id="CheckYearNow" value="<?= isset($selectedYear) ? esc($selectedYear) : (isset($SchoolYear->schyear_year) ? esc($SchoolYear->schyear_year) : '') ?>">

    <!-- Collapse Add Form -->
    <div class="collapse mb-4" id="collapseAddSubject">
        <div class="card settings-card animate__animated animate__fadeIn">
            <div class="settings-card-header d-flex align-items-center" style="background: var(--primary-emerald);">
                <div class="icon-wrapper me-3 bg-white text-emerald">
                    <i class="bx bx-plus-circle"></i>
                </div>
                <h5 class="mb-0 fw-bold text-white">รายละเอียดรายวิชาใหม่</h5>
            </div>
            <div class="card-body p-4 pt-5">
                <form id="form-subject">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <label class="form-label">ภาคเรียน/ปีการศึกษา</label>
                            <select class="form-select" required name="SubjectYear" id="SubjectYear">
                                <option value="">เลือกภาคเรียน</option>
                                <?php $d = date('Y')+541; 
                                for ($i=$d+2; $i >= $d-1 ; $i--) :
                                    for($j=2; $j>=1; $j--):?>
                                <option <?= (isset($selectedYear) && $selectedYear == $j.'/'.$i) ? "selected" : ""?>
                                    value="<?= esc($j.'/'.$i) ?>"><?= esc($j.'/'.$i) ?></option>
                                <?php endfor; endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">ระดับชั้นที่เปิดสอน</label>
                            <select class="form-select" required name="SubjectClass" id="SubjectClass">
                                <option value="">เลือกระดับชั้น</option>
                                <?php foreach ($classroom->LevelClass() as $v_sara):?>
                                <option value="<?= esc($v_sara) ?>"><?= esc($v_sara) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ค้นหารหัสวิชา (จากฐานข้อมูลกลาง)</label>
                            <select id="SubjectCode" name="SubjectCode" class="form-select select2">
                                <option value="">-- พิมพ์รหัสวิชาเพื่อค้นหา --</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">ชื่อรายวิชา</label>
                            <input type="text" class="form-control" required name="SubjectName" id="SubjectName" placeholder="เช่น ภาษาไทยพื้นฐาน">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">หน่วยกิต</label>
                            <select class="form-select" required name="SubjectUnit" id="SubjectUnit">
                                <option value="">-</option>
                                <?php foreach (["0.5","1.0","1.5","2.0","2.5","3.0","3.5","4.0","4.5","5.0"] as $v_Unit):?>
                                <option value="<?= esc($v_Unit) ?>"><?= esc($v_Unit) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">จำนวนชั่วโมง</label>
                            <select class="form-select" required name="SubjectHour" id="SubjectHour">
                                <option value="">-</option>
                                <?php foreach (["20","40","60","80","100","120","140","160","180","200"] as $v_Hour):?>
                                <option value="<?= esc($v_Hour) ?>"><?= esc($v_Hour) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">ประเภทวิชา</label>
                            <select class="form-select" required name="SubjectType" id="SubjectType">
                                <option value="">-</option>
                                <option value="1/พื้นฐาน">1/พื้นฐาน</option>
                                <option value="2/เพิ่มเติม">2/เพิ่มเติม</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">กลุ่มสาระการเรียนรู้หลัก</label>
                            <select class="form-select" required name="FirstGroup" id="FirstGroup">
                                <option value="">เลือกกลุ่มสาระ</option>
                                <?php foreach ($classroom->GroupSaraMain() as $v_sara):?>
                                <option value="<?= esc($v_sara) ?>"><?= esc($v_sara) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">สาระย่อย (ถ้ามี)</label>
                            <select class="form-select" required name="SecondGroup" id="SecondGroup">
                                <option value="">เลือกสาระย่อย</option>
                                <?php foreach ($classroom->GroupSaraSecond() as $v_sara):?>
                                <option value="<?= esc($v_sara) ?>"><?= esc($v_sara) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-12 text-end pt-3">
                            <button type="button" class="btn btn-label-secondary me-2" data-bs-toggle="collapse" data-bs-target="#collapseAddSubject">ยกเลิก</button>
                            <button type="submit" class="btn btn-emerald px-4 shadow-sm">บันทึกวิชาเรียน</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                        <?php foreach ($GroupYear as $v_GroupYear): ?>
                        <option <?= (isset($v_GroupYear->SubjectYear) && isset($selectedYear) && $v_GroupYear->SubjectYear == $selectedYear) ? "selected" : ""?>
                            value="<?= isset($v_GroupYear->SubjectYear) ? esc($v_GroupYear->SubjectYear) : '' ?>">
                            <?= isset($v_GroupYear->SubjectYear) ? esc($v_GroupYear->SubjectYear) : '' ?>
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

    $('.select2').select2({
        theme: 'bootstrap-5',
        dropdownAutoWidth: true,
        width: '100%'
    });

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

    // Google Sheets Integration (via Published CSV)
    const csv_url = "https://docs.google.com/spreadsheets/d/e/2PACX-1vSkmM4H4BP9GDxlVIHb7Eon1xR1jqwmeASdrKAfJLJ3Iplg1cRZGmgkNhNX5Q6ZkrhDSx95WF7h8HHE/pub?output=csv";

    function parseCSV(csvText) {
        const lines = csvText.split(/\r?\n/);
        const result = [];
        // Helper to handle quoted CSV fields
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
                id: row[0],
                text: row[0] + ' : ' + row[1],
                SubjectName: row[1],
                SubjectUnit: row[2],
                SubjectHour: row[3],
                SubjectType: row[4],
                FirstGroup: row[5],
                SecondGroup: row[6],
                SubjectClass: row[7]
            });
        }
        return result;
    }

    fetch(csv_url)
        .then(response => response.text())
        .then(csvText => {
            const subjects = parseCSV(csvText);
            $("#SubjectCode").select2({
                placeholder: "พิมพ์รหัสวิชา หรือ ชื่อวิชา",
                allowClear: true,
                minimumInputLength: 2,
                data: subjects,
                theme: 'bootstrap-5'
            });
        })
        .catch(error => {
            console.error("CSV Fetch Error:", error);
            $("#SubjectCode").select2({
                placeholder: "⚠️ ไม่สามารถโหลดข้อมูลรายวิชาได้ (CSV Error)",
                theme: 'bootstrap-5'
            });
        });

    $("#SubjectCode").on("select2:select", function(e) {
        let selected = e.params.data;
        $("#SubjectName").val(selected.SubjectName);
        $("#SubjectUnit").val(selected.SubjectUnit);
        $("#SubjectHour").val(selected.SubjectHour);
        $("#SubjectType").val(selected.SubjectType);
        $("#FirstGroup").val(selected.FirstGroup);
        $("#SecondGroup").val(selected.SecondGroup);
        $("#SubjectClass").val(selected.SubjectClass);
    });

    $(document).on('change', '#SubjectUnit', function() {
        const unitMap = { 0.5: 20, 1.0: 40, 1.5: 60, 2.0: 80, 2.5: 100, 3.0: 120 };
        $('#SubjectHour').val(unitMap[$(this).val()] || '');
    });

    // CRUD Ops
    $(document).on('submit', '#form-subject', function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?= site_url('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectInsert') ?>',
            type: 'post',
            data: $(this).serialize(),
            success: function(data) {
                if (data > 0) {
                    $('#form-subject')[0].reset();
                    $('#SubjectCode').val(null).trigger('change');
                    Swal.fire({ icon: 'success', title: 'เพิ่มวิชาเรียนสำเร็จ', showConfirmButton: false, timer: 1500 });
                    tablel_Subject.ajax.reload();
                    // bootstrap.Collapse.getInstance(document.getElementById('collapseAddSubject')).hide(); // ไม่ต้องพับคืนเพื่อให้ป้อนต่อได้
                } else {
                    Swal.fire({ icon: 'error', title: 'ข้อมูลซ้ำ', text: 'รายวิชานี้มีอยู่แล้วในเทอมนี้' });
                }
            }
        });
    });

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

    // Delete
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
