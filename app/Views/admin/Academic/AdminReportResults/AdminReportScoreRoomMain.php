<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>

<style>
    :root {
        --primary-emerald: #15a362;
        --dark-emerald: #0d6d41;
        --light-emerald: #e8f5ee;
        --border-radius: 16px;
    }

    /* Hero Section */
    .hero-settings {
        background: linear-gradient(135deg, var(--primary-emerald) 0%, var(--dark-emerald) 100%);
        border-radius: 1.5rem;
        padding: 2.5rem;
        color: white;
        margin-bottom: 2.5rem;
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
    }

    .status-badge {
        font-size: 0.75rem;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 700;
    }

    .status-active {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    /* Premium Card */
    .settings-card {
        border: none;
        border-radius: 1.25rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.03);
        transition: transform 0.3s ease;
    }

    .icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        background: var(--light-emerald);
        color: var(--primary-emerald);
        margin-bottom: 1.5rem;
    }

    /* Table Container Styling */
    .table-container-score {
        position: relative;
        max-height: 75vh;
        overflow: auto;
        border: 1px solid #edf1f4;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }

    /* Baseline Table Sticky Header */
    .table-score-report {
        border-collapse: separate !important;
        border-spacing: 0 !important;
    }

    .table-score-report thead th {
        position: sticky !important;
        top: 0;
        z-index: 40;
        background-color: #fcfdfe !important;
        border-bottom: 2px solid #e9ecef !important;
        border-right: 1px solid #e9ecef !important;
        white-space: nowrap;
        font-weight: 700;
        color: #495057;
        font-size: 0.72rem;
        letter-spacing: 0.3px;
        padding: 10px 8px !important;
    }

    .table-score-report thead tr:nth-child(2) th {
        top: 48px !important; 
        z-index: 39;
        font-size: 0.65rem;
        background-color: #f8f9fa !important;
    }

    .sticky-col {
        position: sticky !important;
        background-color: #fff !important;
        z-index: 10;
        white-space: nowrap;
        border-right: 1px solid #e9ecef !important;
        font-size: 0.82rem;
    }
    
    .table-score-report thead th.sticky-col {
        z-index: 110 !important;
        background-color: #fcfdfe !important;
        top: 0 !important;
    }
    
    .table-score-report thead tr:nth-child(2) th.sticky-col {
        top: 48px !important;
        z-index: 109 !important;
    }

    .sticky-col-1 { left: 0; min-width: 50px; text-align: center; color: #adb5bd; }
    .sticky-col-2 { left: 50px; min-width: 90px; text-align: center; font-weight: 500; color: #6c757d; }
    .sticky-col-3 { 
        left: 140px; 
        min-width: 220px; 
        font-weight: 600;
        color: #212529;
        border-right: 3px solid var(--primary-emerald) !important;
        box-shadow: 6px 0 10px rgba(0,0,0,0.04);
    }

    .subject-header-group {
        border-bottom: 3px solid var(--primary-emerald) !important;
        background-color: rgba(21, 163, 98, 0.04) !important;
    }

    .score-cell {
        text-align: center;
        font-size: 0.85rem;
        min-width: 48px;
        padding: 8px 4px !important;
        transition: background-color 0.2s ease;
    }
    .score-cell:hover { background-color: rgba(21, 163, 98, 0.05) !important; }
    .score-cell.has-score { background-color: rgba(21, 163, 98, 0.1) !important; color: var(--primary-emerald); font-weight: 600; }
    .score-cell.no-score { background-color: #fff8e1 !important; color: #b78103; }

    .btn-emerald {
        background-color: var(--primary-emerald);
        border-color: var(--primary-emerald);
        color: white;
        font-weight: 600;
        border-radius: 10px;
        padding: 0.6rem 1.25rem;
        transition: all 0.3s ease;
    }

    .btn-emerald:hover {
        background-color: var(--dark-emerald);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(21, 163, 98, 0.2);
    }

    .bg-group-pre { background-color: rgba(21, 163, 98, 0.02) !important; }
    .bg-group-mid { background-color: rgba(21, 163, 98, 0.04) !important; }
    .bg-group-post { background-color: rgba(21, 163, 98, 0.06) !important; }
    .bg-group-final { background-color: rgba(21, 163, 98, 0.08) !important; }

    .select2-container--bootstrap-5 .select2-selection {
        border: 2px solid #edf1f4;
        border-radius: 12px !important;
        min-height: 48px;
        display: flex;
        align-items: center;
    }
    .select2-container--bootstrap-5.select2-container--focus .select2-selection {
        border-color: var(--primary-emerald) !important;
        box-shadow: 0 0 0 0.25rem rgba(21, 163, 98, 0.1) !important;
    }
</style>

<div class="animate__animated animate__fadeIn">
    <!-- Hero Section -->
    <div class="hero-settings">
        <div class="row align-items-center">
            <div class="col-lg-8 animate__animated animate__slideInLeft">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style2 mb-2">
                        <li class="breadcrumb-item"><a href="<?= base_url('Admin/Home') ?>" class="text-white opacity-75">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">รายงานคะแนนรายห้อง</li>
                    </ol>
                </nav>
                <h2 class="fw-bold mb-2 text-white">
                    <i class='bx bx-spreadsheet me-2'></i>
                    <span><?= isset($title) ? esc($title) : 'รายงานผลการบันทึกคะแนน (รายห้องเรียน)' ?></span>
                </h2>
                <div class="d-flex align-items-center mt-3">
                    <span class="status-badge status-active">
                        <i class='bx bxs-circle me-1 small animate__animated animate__pulse animate__infinite'></i>
                        ระบบพร้อมตรวจสอบ
                    </span>
                    <?php if(isset($Class)): ?>
                    <span class="text-white-50 ms-3 small">
                        <i class='bx bx-chalkboard me-1'></i> ห้องเรียน: ม.<?= esc($Class) ?>/<?= esc($RoomValue) ?>
                    </span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block animate__animated animate__zoomIn">
                <i class='bx bx-table text-white opacity-25' style="font-size: 8rem;"></i>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card settings-card mb-4">
        <div class="card-body py-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="KeyCheckYear" class="form-label fw-bold text-dark small uppercase">ปีการศึกษา</label>
                    <select class="form-select select2" id="KeyCheckYear" name="KeyCheckYear">
                        <option value="">-- เลือกปีการศึกษา --</option>
                        <?php foreach ($CheckYear as $v_CheckYear) : ?>
                            <?php 
                                $currentVal = (!empty($Term) && !empty($Year)) ? ($Term . '/' . $Year) : get_selected_year();
                                $isSelected = ($currentVal == $v_CheckYear->RegisterYear) ? 'selected' : '';
                            ?>
                            <option value="<?= esc($v_CheckYear->RegisterYear) ?>" <?= $isSelected ?>>
                                <?= esc($v_CheckYear->RegisterYear) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="SelectRoomReportScore" class="form-label fw-bold text-dark small uppercase">ห้องเรียน</label>
                    <select class="form-select select2" id="SelectRoomReportScore" name="SelectRoomReportScore">
                        <option value="">-- เลือกห้องเรียน --</option>
                        <?php foreach ($Room as $v_Room) : ?>
                            <?php 
                                $currentRoom = ($Class ?? '') . '/' . ($RoomValue ?? '');
                                $isSelected = ($currentRoom == $v_Room) ? 'selected' : '';
                            ?>
                            <option value="<?= esc($v_Room) ?>" <?= $isSelected ?>>ม.<?= esc($v_Room) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="button" id="btnSearch" class="btn btn-emerald w-100">
                        <i class="bx bx-search-alt-2 me-1"></i> ค้นหาข้อมูลรายห้อง
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php if(isset($stu) && !empty($stu)): ?>
    <!-- Summary Row -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card settings-card">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper mx-auto shadow-sm">
                        <i class='bx bx-user-check'></i>
                    </div>
                    <h3 class="fw-bold mb-1"><?= count($stu) ?></h3>
                    <p class="text-muted mb-0 small fw-bold">จำนวนนักเรียน</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card settings-card">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper mx-auto shadow-sm" style="background: rgba(26, 188, 156, 0.1); color: #1abc9c;">
                        <i class='bx bx-book-open'></i>
                    </div>
                    <h3 class="fw-bold mb-1"><?= count($RegisSubject) ?></h3>
                    <p class="text-muted mb-0 small fw-bold">จำนวนรายวิชา</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card settings-card">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper mx-auto shadow-sm" style="background: rgba(52, 152, 219, 0.1); color: #3498db;">
                        <i class='bx bx-chalkboard'></i>
                    </div>
                    <h3 class="fw-bold mb-1">ม.<?= esc($Class) ?>/<?= esc($RoomValue) ?></h3>
                    <p class="text-muted mb-0 small fw-bold">ห้องเรียนปัจจุบัน</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card settings-card">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper mx-auto shadow-sm" style="background: rgba(243, 156, 18, 0.1); color: #f39c12;">
                        <i class='bx bx-printer'></i>
                    </div>
                    <p class="text-muted mb-2 small fw-bold">เครื่องมือรายงาน</p>
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-emerald btn-sm rounded-pill" id="btnPrint"><i class='bx bx-printer'></i></button>
                        <button type="button" class="btn btn-outline-success btn-sm rounded-pill" id="btnExportExcel"><i class='bx bx-file'></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card settings-card border-top border-emerald border-4">
        <div class="card-header bg-white border-bottom-0 py-4 px-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="icon-wrapper bg-label-success me-3 mb-0" style="width: 45px; height: 45px; font-size: 1.25rem;">
                        <i class='bx bx-table'></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-0 fw-bold">ตารางคะแนนสะสมรายวิชา</h5>
                        <small class="text-muted">แยกตามประเภทการทดสอบ (ก่อน, กลาง, หลัง, ปลาย)</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-container-score">
                <table class="table table-bordered table-score-report mb-0" id="tblScoreRoom">
                    <thead>
                        <tr>
                            <th class="text-center align-middle sticky-col sticky-col-1" rowspan="2">#</th>
                            <th class="text-center align-middle sticky-col sticky-col-2" rowspan="2">รหัส</th>
                            <th class="align-middle sticky-col sticky-col-3" rowspan="2">ชื่อ-นามสกุล</th>
                            <?php foreach ($RegisSubject as $subject): ?>
                                <th colspan="4" class="text-center subject-header-group" title="<?= esc($subject->SubjectCode) ?> - <?= esc($subject->SubjectName) ?>">
                                    <div class="fw-bold text-emerald small truncate" style="max-width: 150px; margin: 0 auto;"><?= esc($subject->SubjectName) ?></div>
                                    <div class="text-muted x-small"><?= esc($subject->SubjectCode) ?></div>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <?php foreach ($RegisSubject as $subject): ?>
                                <th class="text-center bg-group-pre x-small">ก่อน</th>
                                <th class="text-center bg-group-mid x-small">กลาง</th>
                                <th class="text-center bg-group-post x-small">หลัง</th>
                                <th class="text-center bg-group-final x-small" style="border-right: 2px solid #dee2e6 !important;">ปลาย</th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <?php foreach ($stu as $idx => $student) : ?>
                            <tr>
                                <td class="text-center text-muted sticky-col sticky-col-1"><?= $idx + 1 ?></td>
                                <td class="text-center small sticky-col sticky-col-2"><?= esc($student->StudentCode) ?></td>
                                <td class="text-nowrap sticky-col sticky-col-3 fw-bold"><?= esc($student->StudentPrefix . $student->StudentFirstName . ' ' . $student->StudentLastName) ?></td>
                                <?php foreach ($RegisSubject as $subject) : ?>
                                    <?php
                                        $scoreString = $scoresMap[(string)$student->StudentID][(string)$subject->SubjectID] ?? '';
                                        $sc = ['', '', '', ''];
                                        if ($scoreString) { $p = explode('|', $scoreString); $sc[0]=$p[0]??''; $sc[1]=$p[1]??''; $sc[2]=$p[2]??''; $sc[3]=$p[3]??''; }
                                    ?>
                                    <td class="text-center score-cell bg-group-pre <?= ($sc[0]!=='') ? 'has-score' : '' ?>"><?= ($sc[0]!=='') ? esc($sc[0]) : '-' ?></td>
                                    <td class="text-center score-cell bg-group-mid <?= ($sc[1]!=='') ? 'has-score' : '' ?>"><?= ($sc[1]!=='') ? esc($sc[1]) : '-' ?></td>
                                    <td class="text-center score-cell bg-group-post <?= ($sc[2]!=='') ? 'has-score' : '' ?>"><?= ($sc[2]!=='') ? esc($sc[2]) : '-' ?></td>
                                    <td class="text-center score-cell bg-group-final last-of-group <?= ($sc[3]!=='') ? 'has-score' : '' ?>" style="border-right: 2px solid #dee2e6 !important;"><?= ($sc[3]!=='') ? esc($sc[3]) : '-' ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php else: ?>
    <!-- Empty State -->
    <div class="card settings-card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <div class="icon-wrapper mx-auto mb-4" style="width: 100px; height: 100px; font-size: 3rem;">
                <i class="bx bx-spreadsheet"></i>
            </div>
            <h4 class="fw-bold">กรุณาเลือกปีการศึกษาและห้องเรียน</h4>
            <p class="text-muted mx-auto" style="max-width: 450px;">ระบุเงื่อนไขที่ต้องการตรวจสอบ เพื่อแสดงรายงานผลการบันทึกคะแนนรายวิชาของนักเรียนแบบรายห้อง</p>
        </div>
    </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%'
    });

    // Sort Year Dropdown (newest first)
    let select = $('#KeyCheckYear');
    let options = select.find('option').not('[value=""]');
    let selectedValue = select.val();
    
    options.sort(function(a, b) {
        let aVal = a.value.split('/');
        let bVal = b.value.split('/');
        if (aVal.length < 2 || bVal.length < 2) return 0;
        let aYear = parseInt(aVal[1], 10);
        let bYear = parseInt(bVal[1], 10);
        let aTerm = parseInt(aVal[0], 10);
        let bTerm = parseInt(bVal[0], 10);
        
        if (aYear !== bYear) return bYear - aYear;
        return bTerm - aTerm;
    });
    
    select.find('option').not('[value=""]').remove();
    select.append(options).val(selectedValue);

    // Search Button
    $('#btnSearch').on('click', function() {
        let selectedYear = $('#KeyCheckYear').val();
        let selectedRoom = $('#SelectRoomReportScore').val();
        let path = window.location.pathname.includes('Executive') ? 'Executive' : 'Evaluate';
        const baseUrl = '<?= site_url("Admin/Acade/") ?>' + path + '/ReportScoreRoomMain';

        if (!selectedYear || !selectedRoom) {
            Swal.fire({ icon: 'warning', title: 'กรุณาเลือกข้อมูลให้ครบ', confirmButtonColor: '#15a362' });
            return;
        }

        Swal.fire({
            title: 'กำลังโหลดข้อมูล...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });
        
        window.location.href = baseUrl + '/' + selectedYear + '/' + selectedRoom;
    });

    // Export Excel
    $('#btnExportExcel').on('click', function() {
        <?php if(isset($Term) && isset($Year) && isset($Class) && isset($RoomValue)): ?>
            let path = window.location.pathname.includes('Executive') ? 'Executive' : 'Evaluate';
            const exportUrl = '<?= site_url("Admin/Acade/") ?>' + path + '/ExportScoreRoomToExcel/<?= $Term ?>/<?= $Year ?>/<?= $Class ?>/<?= $RoomValue ?>';
            
            Swal.fire({
                title: 'กำลังเตรียมไฟล์ Excel...',
                text: 'กรุณารอสักครู่',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });
            
            window.location.href = exportUrl;
            setTimeout(() => { Swal.close(); }, 2000);
        <?php else: ?>
            Swal.fire({
                icon: 'warning',
                title: 'กรุณาเลือกข้อมูลก่อน',
                text: 'เลือกปีการศึกษาและห้องเรียน แล้วกดค้นหาก่อนส่งออก',
                confirmButtonColor: '#15a362'
            });
        <?php endif; ?>
    });

    // Print
    $('#btnPrint').on('click', function() {
        window.print();
    });
});
</script>
<?= $this->endSection() ?>