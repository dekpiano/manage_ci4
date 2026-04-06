<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
.stat-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}
.stat-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    font-size: 1.5rem;
}
.stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    line-height: 1.2;
}
.stat-label {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 4px;
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Page Header -->
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">งานหลักสูตร /</span> จัดการรายวิชา
            </h4>
            <p class="text-muted mb-0">ปีการศึกษา: <strong id="headerYear"><?= isset($SchoolYear->schyear_year) ? esc($SchoolYear->schyear_year) : '-' ?></strong></p>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAddSubject" aria-expanded="false" aria-controls="collapseAddSubject">
                <i class="bx bx-plus-circle me-1"></i> เพิ่มรายวิชาใหม่
            </button>
        </div>
    </div>

    <!-- Dashboard Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Subjects -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-primary" id="stat-total">0</div>
                            <div class="stat-label">รายวิชาทั้งหมด</div>
                        </div>
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bx bx-book"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted"><i class="bx bx-calendar me-1"></i>ในปีการศึกษาปัจจุบัน</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Basic Subjects -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-success" id="stat-basic">0</div>
                            <div class="stat-label">วิชาพื้นฐาน</div>
                        </div>
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="bx bx-book-reader"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted"><i class="bx bx-check-circle me-1"></i>วิชาบังคับ</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Advanced Subjects -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-info" id="stat-advanced">0</div>
                            <div class="stat-label">วิชาเพิ่มเติม</div>
                        </div>
                        <div class="stat-icon bg-info bg-opacity-10 text-info">
                            <i class="bx bx-book-bookmark"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted"><i class="bx bx-star me-1"></i>วิชาเลือก/เสรี</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Status -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-warning" id="stat-year"><?= isset($SchoolYear->schyear_year) ? esc($SchoolYear->schyear_year) : '-' ?></div>
                            <div class="stat-label">ปีการศึกษา</div>
                        </div>
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bx bx-calendar-event"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted"><i class="bx bx-info-circle me-1"></i>กำลังดำเนินการ</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="CheckYearNow" id="CheckYearNow" value="<?= isset($selectedYear) ? esc($selectedYear) : (isset($SchoolYear->schyear_year) ? esc($SchoolYear->schyear_year) : '') ?>">

    <!-- Add Form (Collapse) -->
    <div class="collapse mb-4" id="collapseAddSubject">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="card-title mb-0 text-white"><i class="bx bx-plus-circle me-2"></i>เพิ่มข้อมูลรายวิชาใหม่</h5>
            </div>
            <div class="card-body mt-4">
                <form id="form-subject">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">ปีการศึกษา</label>
                            <select class="form-select" required name="SubjectYear" id="SubjectYear">
                                <option value="">เลือกปีการศึกษา</option>
                                <?php $d = date('Y')+541; 
                                for($j=1; $j<=3; $j++):
                                    for ($i=$d; $i <= $d+2 ; $i++) :?>
                                <option <?= (isset($selectedYear) && $selectedYear == $j.'/'.$i) ? "selected" : ""?>
                                    value="<?= esc($j.'/'.$i) ?>"><?= esc($j.'/'.$i) ?></option>
                                <?php endfor; endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">ระดับชั้น</label>
                            <select class="form-select" required name="SubjectClass" id="SubjectClass">
                                <option value="">เลือกระดับชั้น</option>
                                <?php foreach ($classroom->LevelClass() as $v_sara):?>
                                <option value="<?= esc($v_sara) ?>"><?= esc($v_sara) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">รหัสวิชา (ค้นหาจาก Google Sheets)</label>
                            <select id="SubjectCode" name="SubjectCode" class="form-select select2">
                                <option value="">-- พิมพ์เพื่อค้นหา --</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">ชื่อวิชา</label>
                            <input type="text" class="form-control" required name="SubjectName" id="SubjectName">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">หน่วยกิต</label>
                            <select class="form-select" required name="SubjectUnit" id="SubjectUnit">
                                <option value="">เลือก</option>
                                <?php foreach (["0.5","1.0","1.5","2.0","2.5","3.0","3.5","4.0","4.5","5.0"] as $v_Unit):?>
                                <option value="<?= esc($v_Unit) ?>"><?= esc($v_Unit) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">ชั่วโมง</label>
                            <select class="form-select" required name="SubjectHour" id="SubjectHour">
                                <option value="">เลือก</option>
                                <?php foreach (["20","40","60","80","100","120","140","160","180","200"] as $v_Hour):?>
                                <option value="<?= esc($v_Hour) ?>"><?= esc($v_Hour) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">ประเภทวิชา</label>
                            <select class="form-select" required name="SubjectType" id="SubjectType">
                                <option value="">เลือก</option>
                                <option value="1/พื้นฐาน">1/พื้นฐาน</option>
                                <option value="2/เพิ่มเติม">2/เพิ่มเติม</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">สาระหลัก</label>
                            <select class="form-select" required name="FirstGroup" id="FirstGroup">
                                <option value="">เลือกสาระหลัก</option>
                                <?php foreach ($classroom->GroupSaraMain() as $v_sara):?>
                                <option value="<?= esc($v_sara) ?>"><?= esc($v_sara) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">สาระย่อย</label>
                            <select class="form-select" required name="SecondGroup" id="SecondGroup">
                                <option value="">เลือกสาระย่อย</option>
                                <?php foreach ($classroom->GroupSaraSecond() as $v_sara):?>
                                <option value="<?= esc($v_sara) ?>"><?= esc($v_sara) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-12 text-end">
                            <hr class="mt-2 mb-3">
                            <button type="button" class="btn btn-label-secondary me-2" data-bs-toggle="collapse" data-bs-target="#collapseAddSubject">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Data Table Section -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-list-ul me-2"></i>รายการวิชาเรียน
                    </h5>
                </div>
                <div class="col-auto">
                    <div class="d-flex align-items-center gap-2">
                        <label for="SelectSubject" class="form-label mb-0 fw-medium">เลือกปี:</label>
                        <select class="form-select form-select-sm SelectSubject" id="SelectSubject" style="width: auto; min-width: 140px;">
                            <option selected value="">เลือกปีการศึกษา</option>
                            <?php foreach ($GroupYear as $key => $v_GroupYear): ?>
                            <option <?= (isset($v_GroupYear->SubjectYear) && isset($selectedYear) && $v_GroupYear->SubjectYear == $selectedYear) ? "selected" : ""?>
                                value="<?= isset($v_GroupYear->SubjectYear) ? esc($v_GroupYear->SubjectYear) : '' ?>">
                                <?= isset($v_GroupYear->SubjectYear) ? esc($v_GroupYear->SubjectYear) : '' ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="tbSubject">
                    <thead class="table-light">
                        <tr>
                            <th class="cell">ปีการศึกษา</th>
                            <th class="cell">รหัสวิชา</th>
                            <th class="cell">ชื่อวิชา</th>
                            <th class="cell">สาระ</th>
                            <th class="cell">ชั้น</th>
                            <th class="cell">ปีที่เรียน</th>
                            <th class="cell text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTable Content -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal แก้ไขข้อมูล -->
<div class="modal fade" id="ModalUpdateSubject" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="form-update-subject">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white"><i class="bx bx-edit me-2"></i>แก้ไขข้อมูลรายวิชา</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <input type="hidden" name="Up_SubjectID" id="Up_SubjectID">

                        <div class="col-md-6">
                            <label class="form-label fw-bold">ปีการศึกษา</label>
                            <select class="form-select" required name="Up_SubjectYear" id="Up_SubjectYear">
                                <option value="">เลือกปีการศึกษา</option>
                                <?php $d = date('Y')+541; for ($i=$d; $i <= $d+2 ; $i++) :?>
                                <option value="1/<?= esc($i);?>">1/<?= esc($i);?></option>
                                <option value="2/<?= esc($i);?>">2/<?= esc($i);?></option>
                                <option value="3/<?= esc($i);?>">3/<?= esc($i);?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">ระดับชั้น</label>
                            <select class="form-select" required name="Up_SubjectClass" id="Up_SubjectClass">
                                <option value="">เลือกระดับชั้น</option>
                                <?php foreach ($classroom->LevelClass() as $v_sara):?>
                                <option value="<?= esc($v_sara) ?>"><?= esc($v_sara) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">รหัสวิชา</label>
                            <input type="text" class="form-control" required name="Up_SubjectCode" id="Up_SubjectCode">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-bold">ชื่อวิชา</label>
                            <input type="text" class="form-control" required name="Up_SubjectName" id="Up_SubjectName">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">หน่วยกิต</label>
                            <input type="text" class="form-control" required name="Up_SubjectUnit" id="Up_SubjectUnit">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">ชั่วโมง</label>
                            <input type="text" class="form-control" required name="Up_SubjectHour" id="Up_SubjectHour">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">ประเภทวิชา</label>
                            <select class="form-select" required name="Up_SubjectType" id="Up_SubjectType">
                                <option value="">เลือกประเภทวิชา</option>
                                <option value="1/พื้นฐาน">1/พื้นฐาน</option>
                                <option value="2/เพิ่มเติม">2/เพิ่มเติม</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">สาระหลัก</label>
                            <select class="form-select" required name="Up_FirstGroup" id="Up_FirstGroup">
                                <option value="">เลือกสาระหลัก</option>
                                <?php foreach ($classroom->GroupSaraMain() as $v_sara):?>
                                <option value="<?= esc($v_sara) ?>"><?= esc($v_sara) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">สาระย่อย</label>
                            <select class="form-select" required name="Up_SecondGroup" id="Up_SecondGroup">
                                <option value="">เลือกสาระย่อย</option>
                                <?php foreach ($classroom->GroupSaraSecond() as $v_sara):?>
                                <option value="<?= esc($v_sara) ?>"><?= esc($v_sara) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x me-1"></i>ยกเลิก
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-1"></i>บันทึกการแก้ไข
                    </button>
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

    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap-5',
        dropdownAutoWidth: true,
        width: '100%'
    });

    // Load initial table
    loadTable(currentYear);

    // Update stats function
    function updateStats(data) {
        if (!data || !Array.isArray(data)) return;
        
        const total = data.length;
        
        // Robust checking for SubjectType
        const basic = data.filter(row => {
            let type = (row.SubjectType || '').toString();
            return type.includes('พื้นฐาน') || type.startsWith('1');
        }).length;
        
        const advanced = data.filter(row => {
            let type = (row.SubjectType || '').toString();
            return type.includes('เพิ่มเติม') || type.startsWith('2');
        }).length;

        // Animate numbers
        $('#stat-total').fadeOut(150, function() { $(this).text(total).fadeIn(150); });
        $('#stat-basic').fadeOut(150, function() { $(this).text(basic).fadeIn(150); });
        $('#stat-advanced').fadeOut(150, function() { $(this).text(advanced).fadeIn(150); });
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
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/Thai.json"
            },
            ajax: {
                url: "<?= site_url('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectSelect') ?>",
                type: "POST",
                data: { "keyYear": Year },
                dataSrc: function(json) {
                    // Safety check: sometimes data is in json.data, sometimes it IS json
                    let rows = (json.data) ? json.data : json;
                    updateStats(rows); 
                    return rows;
                }
            },
            columns: [
                {
                    data: 'SubjectYear',
                    render: function(data) {
                        return '<span class="badge bg-label-primary">' + data + '</span>';
                    }
                },
                {
                    data: 'SubjectCode',
                    render: function(data) {
                        return '<span class="fw-bold text-primary">' + data + '</span>';
                    }
                },
                { data: 'SubjectName' },
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
                { data: 'SubjectYear' },
                {
                    data: 'SubjectID',
                    className: 'text-center',
                    render: function(data) {
                        return `
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-warning text-white EditSubject" idSbuj="${data}" title="แก้ไข"><i class="bx bx-edit"></i></button>
                            <button type="button" class="btn btn-danger delete_subject" idSbuj="${data}" title="ลบ"><i class="bx bx-trash"></i></button>
                        </div>`;
                    }
                }
            ]
        });
    }

    // Load Subjects from Google Sheets
    let api_url = "https://sheets.googleapis.com/v4/spreadsheets/1RbMq3N-4itgCJCnnc8TsZ8k4XZNlEz_kOLkKBvEsajQ/values/main1?key=AIzaSyATVgVTJM7ou3XdyBH-FsxVd9uj_A32tCc";

    $.getJSON(api_url, function(data) {
        let rows = data.values;
        rows.shift();

        let subjects = rows.map(row => ({
            id: row[0],
            text: row[0] + ' : ' + row[1],
            SubjectName: row[1],
            SubjectUnit: row[2],
            SubjectHour: row[3],
            SubjectType: row[4],
            FirstGroup: row[5],
            SecondGroup: row[6],
            SubjectClass: row[7]
        }));

        $("#SubjectCode").select2({
            placeholder: "พิมพ์รหัสวิชา หรือ ชื่อวิชา",
            allowClear: true,
            minimumInputLength: 2,
            data: subjects,
            theme: 'bootstrap-5',
            width: '100%'
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
        const unitMap = { 0.5: 20, 1.0: 40, 1.5: 60, 2.0: 80 };
        $('#SubjectHour').val(unitMap[$(this).val()] || '');
    });

    // Form Submit (Add)
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
                    Swal.fire({
                        icon: 'success',
                        title: 'บันทึกสำเร็จ',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    tablel_Subject.ajax.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'ไม่สามารถบันทึกได้',
                        text: 'รายวิชานี้มีอยู่แล้วในภาคเรียนนี้',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            }
        });
    });

    // Edit Button
    $(document).on('click', '.EditSubject', function() {
        let id = $(this).attr('idSbuj');
        $('#ModalUpdateSubject').modal('show');
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
            }
        });
    });

    // Update Form
    $(document).on('submit', '#form-update-subject', function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?= site_url('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectUpdate') ?>',
            type: 'post',
            data: $(this).serialize(),
            success: function(data) {
                $('#ModalUpdateSubject').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'แก้ไขสำเร็จ',
                    showConfirmButton: false,
                    timer: 1500
                });
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
