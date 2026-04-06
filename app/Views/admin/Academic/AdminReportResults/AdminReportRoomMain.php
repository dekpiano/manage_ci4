<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>

<style>
    :root {
        --primary-green: #15a362;
        --secondary-green: #e9f7ef;
        --dark-green: #15a362;
        --glass-bg: rgba(255, 255, 255, 0.9);
    }

    .hero-section {
        background: #15a362; /* Solid primary color for better readability */
        background: linear-gradient(135deg, #15a362 0%, #15a362 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(21, 163, 98, 0.15);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .hero-section .breadcrumb-item a, 
    .hero-section .breadcrumb-item.active {
        color: rgba(255, 255, 255, 0.8) !important;
        font-size: 0.9rem;
    }

    .hero-section h2 {
        color: #ffffff !important;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .hero-section p {
        color: rgba(255, 255, 255, 0.9) !important;
        font-weight: 300;
    }

    /* Modern Filter Bar */
    .search-container {
        background: #fff;
        border-radius: 15px;
        padding: 1.2rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border: 1px solid #e9ecef;
        margin-bottom: 1.5rem;
    }

    .search-container .select2-container--bootstrap-5 .select2-selection {
        border: 1px solid #eee;
        background-color: #fcfcfc;
        border-radius: 10px;
        height: 45px;
        line-height: 45px;
    }

    /* Table Styles - Fixed Layout with Page-Level Sticky Header */
    #tblGradeSumRoom {
        table-layout: fixed; 
        width: 100%;
        border-collapse: collapse !important;
        background: #fff;
    }

    #tblGradeSumRoom thead th {
        background-color: #ABDD93 !important;
        border: 1px solid #529432 !important;
        color: #000 !important;
        font-weight: 700;
        vertical-align: middle !important;
        position: sticky; /* Make it sticky against the nearest scroll parent (likely the page) */
        top: -1px; /* Slight offset to hide the gap */
        z-index: 50; /* Ensure it stays above content */
    }

    /* Remove Sorting Icons (if any generated) */
    .table.dataTable thead .sorting,
    .table.dataTable thead .sorting_asc,
    .table.dataTable thead .sorting_desc {
        background-image: none !important;
        cursor: default !important;
    }

    #tblGradeSumRoom th, #tblGradeSumRoom td {
        word-wrap: break-word;
        overflow: hidden;
        text-overflow: ellipsis;
        padding: 8px 4px !important; /* Smaller padding for more space */
    }

    /* Adjusted column widths for 'Fit' feel */
    .col-idx { width: 35px !important; }
    .col-name { width: 190px !important; }
    .col-stu-id { width: 90px !important; }
    .col-subject { width: 38px !important; } /* Subjects even narrower to fit screen */
    .col-gpa { width: 65px !important; }

    .table thead {
        position: sticky;
        top: 0;
        z-index: 21;
    }

    .table tbody td {
        border: 1px solid #529432 !important;
        padding: 8px 12px;
        vertical-align: middle !important;
    }

    th.rotated-text {
        position: relative;
        height: 180px;
        white-space: nowrap;
        vertical-align: bottom !important;
        padding: 10px !important;
    }

    th.rotated-text > div {
        transform: rotate(-90deg);
        position: absolute;
        bottom: 30px;
        left: 50%;
        width: 150px;
        transform-origin: left bottom;
    }

    th.rotated-text > div > span {
        display: inline-block;
        font-size: 11px;
        font-weight: 500;
        line-height: normal;
    }

    .grade-badge {
        font-weight: 700;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        display: inline-block;
    }

    .grade-success { background-color: #d1e7dd; color: #0f5132; }
    .grade-warning { background-color: #fff3cd; color: #856404; }
    .grade-danger { background-color: #f8d7da; color: #842029; }

    .fade-in-up {
        animation: fadeInUp 0.6s ease-out backwards;
    }

    .fade-in-up { animation: fadeInUp 0.6s ease-out backwards; }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container-fluid p-3">
    <!-- Hero Header -->
    <div class="hero-section fade-in-up">
        <div class="row align-items-center g-3">
            <div class="col-md-9">
                <h2 class="text-white fw-bold mb-1">
                    <i class='bx bx-table me-2'></i>รายงานผลการเรียนรายห้อง
                </h2>
                <p class="mb-0 text-white opacity-75">
                    ตรวจสอบข้อมูลการเรียนรายวิชาและเกรดเฉลี่ยรายบุคคล
                </p>
            </div>
        </div>
    </div>

    <!-- Filter Bar - Clean Design -->
    <?php 
        $currentSegment = service('request')->getUri()->getSegment(3) ?? '';
        $formAction = ($currentSegment === "Executive") 
            ? site_url('Admin/Acade/Executive/ReportRoom') 
            : site_url('Admin/Acade/Evaluate/ReportRoom');
    ?>
    <form action="<?= $formAction ?>" method="post" id="formSearchRoom">
        <?= csrf_field() ?>
        <div class="search-container fade-in-up" style="animation-delay: 0.1s;">
            <div class="row align-items-center g-3">
                <div class="col-md-5">
                    <label class="form-label fw-bold text-dark mb-1 small"><i class='bx bx-calendar me-1'></i>ปีการศึกษา/ภาคเรียน</label>
                    <select class="form-select select2" name="KeyCheckYear" id="KeyCheckYear">
                        <option value="">-- เลือกปี --</option>
                        <?php foreach ($CheckYear as $v_CheckYear) : ?>
                        <option <?= (isset($KeyCheckYear) && $KeyCheckYear == $v_CheckYear->RegisterYear) ? 'selected' : ''?> value="<?= esc($v_CheckYear->RegisterYear) ?>">
                            ปีการศึกษา <?= esc($v_CheckYear->RegisterYear) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-bold text-dark mb-1 small"><i class='bx bx-door-open me-1'></i>ระดับห้องเรียน</label>
                    <select class="form-select select2" name="keyroom" id="keyroom">
                        <option value="0">-- เลือกทุกห้องเรียน --</option>
                        <?php foreach ($room as $v_room) : ?>
                            <option <?= (isset($keyroom) && $keyroom == $v_room) ? "selected" : "" ?> value="<?= esc($v_room) ?>">
                                ชั้นมัธยมศึกษาปีที่ <?= esc($v_room) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-lg-2 pt-lg-4">
                    <button class="btn btn-success w-100" style="height: 45px; border-radius: 10px;" type="submit">
                        <i class='bx bx-search-alt me-1'></i> ค้นข้อมูล
                    </button>
                </div>
                <div class="col-lg-4 text-end pt-lg-4">
                    <div class="d-inline-flex gap-2">
                        <span class="badge bg-success p-2 small"><i class='bx bx-user me-1'></i><?= count($stu ?? []) ?> คน</span>
                        <span class="badge bg-primary p-2 small"><i class='bx bx-book me-1'></i><?= count($subject ?? []) ?> วิชา</span>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Export Buttons Area (Outside Card) -->
    <div id="tableButtons" class="text-end mb-3 fade-in-up" style="animation-delay: 0.15s;"></div>

    <!-- Main Content Section -->
    <div class="fade-in-up" style="animation-delay: 0.1s;">
        <?php if(!isset($Nodata) || $Nodata == 0): ?>
            <div class="card border-0 text-center py-5 shadow-sm" style="border-radius: 15px;">
                <div class="bg-success bg-opacity-10 d-inline-flex p-4 rounded-circle mb-3 mx-auto">
                    <i class='bx bx-search-alt text-success' style="font-size: 4rem;"></i>
                </div>
                <h3 class="fw-bold text-dark">กรุณาเลือกปีและห้องเรียน</h3>
                <p class="text-muted">ตารางจะปรับความกว้างให้รองรับระดับวิชาที่หลากหลายอัตโนมัติ</p>
            </div>
        <?php else: ?>
            <!-- Table Wrapper - No Overflow to allow sticky -->
            <div class="shadow-sm bg-white" style="border-radius: 12px; border: 2px solid #529432;">
                <table class="table mb-0" id="tblGradeSumRoom">
                    <thead>
                        <tr class="text-center">
                            <th class="col-idx">ที่</th>
                            <th class="col-name text-start">ชื่อ - นามสกุล</th>
                            <th class="col-stu-id">รหัสนักเรียน</th>
                            <?php if (!empty($subject)): ?>
                                <?php foreach ($subject as $v_subject): ?>
                                    <th class="rotated-text col-subject border-end">
                                        <div>
                                            <span>
                                                <?= (isset($v_subject->SubjectUnit) ? esc($v_subject->SubjectUnit) : '').' '.(isset($v_subject->SubjectCode) ? esc($v_subject->SubjectCode) : '').' '.(isset($v_subject->SubjectName) ? esc($v_subject->SubjectName) : '') ?>
                                            </span>
                                        </div>
                                    </th>
                                <?php endforeach; ?>
                                <th class="col-gpa bg-light fw-bold">GPA</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($CheckSub)): foreach ($CheckSub as $v_stu) : ?>
                            <tr>
                                <td class="col-idx text-center border-end"><?= esc($v_stu[1] ?? '-') ?></td>
                                <td class="col-name text-nowrap fw-medium border-end text-start"><?= esc($v_stu[2] ?? '-') ?></td>
                                <td class="col-stu-id text-center border-end"><?= esc($v_stu[3] ?? '-') ?></td>
                                <?php 
                                    $colIdx = 4;
                                    foreach ($subject as $v_RegisSubject): 
                                        $gradeData = explode("/", $v_stu[$colIdx] ?? '');
                                        $gradeValue = $gradeData[1] ?? '';
                                ?>
                                    <td class="col-subject text-center border-end"><?= esc($gradeValue) ?></td>
                                <?php $colIdx++; endforeach; ?>
                                <td class="col-gpa text-center fw-bold bg-light">
                                    <?= number_format(end($v_stu), 2); ?>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Initialize Select2 with Bootstrap 5 Theme
    $('.select2').each(function() {
        $(this).select2({ 
            theme: 'bootstrap-5',
            width: '100%'
        });
    });

    // Handle Form Filter Logic
    $('#formSearchRoom').on('submit', function() {
        let selectedYear = $('#KeyCheckYear').val();
        let selectedRoom = $('#keyroom').val();

        if (!selectedYear) {
            Swal.fire({ icon: 'warning', title: 'กรุณาเลือกปีการศึกษา', confirmButtonColor: '#15a362' });
            return false;
        }
        if (!selectedRoom) {
            Swal.fire({ icon: 'warning', title: 'กรุณาเลือกระดับห้องเรียน', confirmButtonColor: '#15a362' });
            return false;
        }

        Swal.fire({
            title: 'กำลังประมวลผลข้อมูล...',
            text: 'ระบบกำลังดึงคะแนนของนักเรียนห้อง ' + selectedRoom + ' ทั้งหมด กรุณารอสักครู่',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });
        return true;
    });

    // Sort the dropdown
    var select = $('#KeyCheckYear');
    var options = select.find('option');
    var selectedValue = select.val();
    var placeholder = options.filter('[value=""]');
    options = options.not('[value=""]');

    options.sort(function(a, b) {
        var aVal = a.value.split('/');
        var bVal = b.value.split('/');
        if (aVal.length < 2 || bVal.length < 2) return 0;
        var aYear = parseInt(aVal[1], 10);
        var bYear = parseInt(bVal[1], 10);
        var aTerm = parseInt(aVal[0], 10);
        var bTerm = parseInt(bVal[0], 10);

        if (aYear !== bYear) {
            return bYear - aYear; // Sort by year descending
        }
        return bTerm - aTerm; // Then by term descending
    });

    select.empty().append(placeholder).append(options);
    select.val(selectedValue);
    // Initialize DataTable with specific 'Plain' config
    if ($('#tblGradeSumRoom').length && !$.fn.DataTable.isDataTable('#tblGradeSumRoom')) {
        let table = $('#tblGradeSumRoom').DataTable({
            "order": [], // No initial sort
            "ordering": false, // Disable all sorting
            dom: 'rt', 
            buttons: [
                { 
                    extend: 'excelHtml5', 
                    text: '<i class="bx bx-file me-1"></i> ดาวน์โหลด Excel',
                    className: 'btn btn-success p-2 px-3 border-0 shadow-sm me-2',
                    title: 'รายงานผลการเรียนรายห้อง_<?= esc($keyroom ?? "") ?>_<?= esc($KeyCheckYear ?? "") ?>',
                    exportOptions: { columns: ':visible' }
                },
                { 
                    extend: 'print', 
                    text: '<i class="bx bx-printer me-1"></i> พิมพ์รายงาน',
                    className: 'btn btn-secondary p-2 px-3 border-0 shadow-sm',
                    exportOptions: { columns: ':visible' }
                }
            ],
            paging: false,
            searching: false,
            info: false,
            autoWidth: false,
            responsive: false
        });

        // Move to external container (Right side)
        table.buttons().container().appendTo('#tableButtons');
    }
});
</script>
<?= $this->endSection() ?>