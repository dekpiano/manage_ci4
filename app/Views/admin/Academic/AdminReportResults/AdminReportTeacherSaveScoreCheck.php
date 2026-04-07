<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
    :root {
        --primary-emerald: #15a362;
        --dark-emerald: #0d6d41;
        --light-emerald: #e8f5ee;
    }

    /* Hero Section */
    .hero-settings {
        background: linear-gradient(135deg, var(--primary-emerald) 0%, var(--dark-emerald) 100%);
        border-radius: 1.5rem;
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

    /* Form Controls */
    .btn-emerald {
        background-color: var(--primary-emerald);
        border-color: var(--primary-emerald);
        color: white;
        padding: 0.7rem 2rem;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-emerald:hover {
        background-color: var(--dark-emerald);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(21, 163, 98, 0.2);
    }

    /* Table Styling Custom */
    .table-custom thead th {
        background-color: var(--light-emerald);
        color: var(--dark-emerald);
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        font-weight: 700;
        border: none;
        padding: 1rem;
    }

    .table-custom tbody td {
        padding: 1rem;
        border-bottom: 1px solid #f2f2f2;
    }

    .card-title-balanced {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .text-emerald {
        color: var(--primary-emerald) !important;
    }
</style>

<div class="animate__animated animate__fadeIn">
    <!-- Hero Section - Exact RWL Mirror -->
    <div class="hero-settings animate__animated animate__fadeIn">
        <div class="row align-items-center">
            <div class="col-lg-8 animate__animated animate__slideInLeft">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style2 mb-2">
                        <li class="breadcrumb-item"><a href="<?= base_url('Admin/Home') ?>" class="text-white opacity-75">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">ตรวจสอบคะแนน</li>
                    </ol>
                </nav>
                <h2 class="fw-bold mb-2 text-white card-title-balanced">
                    <i class='bx bx-user-check'></i>
                    <span>ตรวจสอบคะแนนครูรายบุคคล (ละเอียด)</span>
                </h2>
                <div class="d-flex align-items-center mt-3">
                    <span class="status-badge status-active">
                        <i class='bx bxs-circle me-1 small animate__animated animate__pulse animate__infinite'></i>
                        <?= isset($Teacher) ? esc($Teacher->pers_prefix.$Teacher->pers_firstname.' '.$Teacher->pers_lastname) : '-' ?>
                    </span>
                    <span class="text-white-50 ms-3 small d-flex align-items-center">
                        <i class='bx bx-calendar-event me-1'></i> ภาคเรียน/ปีการศึกษา <?= esc($Term) ?>/<?= esc($Year) ?>
                    </span>
                </div>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block animate__animated animate__zoomIn">
                <i class='bx bxs-user-detail text-white opacity-25' style="font-size: 8rem;"></i>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card settings-card animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
                <div class="card-body p-4">
                    <div class="icon-wrapper shadow-sm">
                        <i class='bx bx-book-content'></i>
                    </div>
                    <h4 class="fw-bold mb-1"><?= count($checkSubject ?? []) ?></h4>
                    <p class="text-muted mb-0">จำนวนรายวิชาที่สอน</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card settings-card animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                <div class="card-body p-4">
                    <div class="icon-wrapper shadow-sm">
                        <i class='bx bxs-user-account'></i>
                    </div>
                    <h4 class="fw-bold mb-1">
                        <?php 
                            $stuSet = [];
                            foreach($CheckScore as $sc) { $stuSet[$sc->StudentID] = true; }
                            echo count($stuSet);
                        ?>
                    </h4>
                    <p class="text-muted mb-0">จำนวนนักเรียนทั้งหมด</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card settings-card animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
                <div class="card-body p-4">
                    <div class="icon-wrapper shadow-sm">
                        <i class='bx bx-refresh'></i>
                    </div>
                    <label class="form-label text-muted small mb-2 d-block">เปลี่ยนปีการศึกษา</label>
                    <select class="form-select border-0 bg-light fw-bold text-emerald" id="selectYear">
                        <?php foreach ($CheckYearSaveScore as $yearRow) : ?>
                            <?php 
                                $yearVal = $yearRow->RegisterYear; 
                                $isSelected = ($Term.'/'.$Year == $yearVal) ? 'selected' : '';
                            ?>
                            <option value="<?= esc($yearVal) ?>" <?= $isSelected ?>><?= esc($yearVal) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Subjects List Card (Main Container) -->
    <div class="card settings-card border-top border-emerald border-4 animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
        <div class="card-header bg-white py-4 px-4 border-bottom-0">
            <h5 class="fw-bold mb-0 d-flex align-items-center">
                <i class='bx bx-list-check me-2 text-emerald fs-4'></i> รายละเอียดคะแนนรายชื่อนักเรียน
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="accordion accordion-flush" id="subjectAccordion">
                <?php foreach ($checkSubject as $key => $v_checkSubject) : ?>
                    <?php 
                        $totalS = 0; $compS = 0;
                        foreach ($CheckScore as $v_CS) {
                            if ($v_checkSubject->SubjectID == $v_CS->SubjectID) {
                                $totalS++; $subS = explode('|', $v_CS->Score100); $isC = true;
                                for ($i=0; $i<4; $i++) { if (!isset($subS[$i]) || $subS[$i] === '' || $subS[$i] === '-'){ $isC = false; break; } }
                                if ($isC) $compS++;
                            }
                        }
                        $perc = ($totalS > 0) ? round(($compS / $totalS) * 100) : 0;
                    ?>
                    <div class="accordion-item border-bottom">
                        <h2 class="accordion-header" id="heading<?= $key ?>">
                            <button class="accordion-button collapsed py-4 px-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $key ?>">
                                <div class="d-flex align-items-center w-100 me-3">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-success fw-bold"><?= esc($v_checkSubject->SubjectCode[0]) ?></span>
                                    </div>
                                    <div class="me-auto">
                                        <h6 class="mb-0 fw-bold"><?= esc($v_checkSubject->SubjectCode) ?> - <?= esc($v_checkSubject->SubjectName) ?></h6>
                                        <small class="text-muted"><?= $totalS ?> นักเรียน • ความเรียบร้อย <?= $perc ?>%</small>
                                    </div>
                                    <div class="ms-3 d-none d-md-block">
                                        <div class="progress" style="width: 100px; height: 6px; border-radius: 10px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: <?= $perc ?>%"></div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                        </h2>
                        <div id="collapse<?= $key ?>" class="accordion-collapse collapse" data-bs-parent="#subjectAccordion">
                            <div class="accordion-body p-0 border-top">
                                <div class="table-responsive">
                                    <table class="table table-custom mb-0 score-table" id="table_<?= $key ?>">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 70px;">#</th>
                                                <th>เลขประจำตัว</th>
                                                <th>ชื่อ-นามสกุล</th>
                                                <th class="text-center">ก่อนกลาง</th>
                                                <th class="text-center">กลางภาค</th>
                                                <th class="text-center">หลังกลาง</th>
                                                <th class="text-center">ปลายภาค</th>
                                                <th class="text-center">รวม (100)</th>
                                                <th class="text-center">สถานะ</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white">
                                            <?php $idx = 1; foreach ($CheckScore as $v_CS) : if ($v_checkSubject->SubjectID == $v_CS->SubjectID) : ?>
                                                <?php 
                                                    $bits = explode('|', $v_CS->Score100); $sum = 0; $full = true;
                                                    foreach($bits as $b) { if(is_numeric($b)) $sum += $b; else $full = false; }
                                                ?>
                                                <tr>
                                                    <td class="text-center text-muted"><?= $idx++ ?></td>
                                                    <td><span class="badge bg-label-primary"><?= esc($v_CS->StudentCode) ?></span></td>
                                                    <td class="fw-bold"><?= esc($v_CS->StudentPrefix.$v_CS->StudentFirstName.' '.$v_CS->StudentLastName) ?></td>
                                                    <td class="text-center"><?= $bits[0] ?? '-' ?></td>
                                                    <td class="text-center"><?= $bits[1] ?? '-' ?></td>
                                                    <td class="text-center"><?= $bits[2] ?? '-' ?></td>
                                                    <td class="text-center"><?= $bits[3] ?? '-' ?></td>
                                                    <td class="text-center fw-bold text-emerald"><?= $sum ?: '-' ?></td>
                                                    <td class="text-center">
                                                        <?php if($full): ?>
                                                            <span class="badge bg-success shadow-none">ครบถวน</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-label-danger shadow-none">ไม่สมบูรณ์</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endif; endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="mt-4 text-center mb-5">
        <a href="javascript:history.back()" class="btn btn-emerald px-5 shadow-sm">
            <i class='bx bx-arrow-back me-1'></i> กลับไปยังหน้ารายงานหลัก
        </a>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Academic Year Filter
    $('#selectYear').on('change', function() {
        var val = $(this).val();
        if (val) {
            var spl = val.split('/');
            var tid = '<?= $TeacID ?>';
            var path = window.location.pathname.includes('Executive') ? 'Executive' : 'Evaluate';
            var url = '<?= base_url('Admin/Acade') ?>/' + path + '/ReportTeacherSaveScoreCheck/' + spl[0] + '/' + spl[1] + '/' + tid;
            
            Swal.fire({
                title: 'กำลังเปลี่ยนข้อมูล...', text: 'ปีการศึกษา ' + val,
                allowOutsideClick: false, didOpen: () => { Swal.showLoading(); }
            });
            window.location.href = url;
        }
    });

    // Initialize DataTables for Accordion Tables
    $('.accordion-button').on('click', function() {
        var tid = $(this).attr('data-bs-target');
        var tbl = $(tid).find('.score-table');
        if (tbl.length && !$.fn.DataTable.isDataTable(tbl)) {
            setTimeout(function() {
                tbl.DataTable({
                    "language": {
                        "lengthMenu": "_MENU_ รายการ", "zeroRecords": "ไม่พบข้อมูล",
                        "info": "หน้า _PAGE_ จาก _PAGES_", "search": "ค้นหา:",
                        "paginate": { "next": "ถัดไป", "previous": "ก่อนหน้า" }
                    },
                    "pageLength": 25, "dom": '<"p-3 d-flex justify-content-between align-items-center"f>rtip'
                });
            }, 150);
        }
    });
});
</script>
<?= $this->endSection() ?>
