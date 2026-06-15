<?= $this->extend('user/layout/main') ?>

<?= $this->section('extra_css') ?>
<style>
    :root {
        --primary-color: #15a362;
        --primary-light: #e8f5e9;
        --secondary-color: #6c757d;
        --border-radius: 12px;
    }
    
    .text-primary-custom {
        color: var(--primary-color) !important;
    }

    .bg-primary-custom {
        background-color: var(--primary-color) !important;
    }

    .bg-primary-light {
        background-color: var(--primary-light) !important;
        color: var(--primary-color) !important;
    }

    /* Card styling */
    .custom-card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        background-color: #fff;
        transition: all 0.3s ease;
    }

    /* Custom drop-down and input-groups */
    .custom-select-wrapper {
        position: relative;
    }

    .custom-select {
        border-radius: var(--border-radius);
        border: 1.5px solid #eaeaea;
        padding: 0.75rem 1rem;
        font-weight: 500;
        transition: all 0.2s ease-in-out;
        background-color: #fcfcfc;
    }

    .custom-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(21, 163, 98, 0.15);
        background-color: #fff;
    }

    .btn-search {
        border-radius: var(--border-radius);
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-search:hover, .btn-search:focus {
        background-color: #11844f;
        border-color: #11844f;
        color: white;
        transform: translateY(-1px);
    }

    /* Tabs styling */
    .nav-pills-custom .nav-link {
        color: var(--secondary-color);
        background: #f1f3f5;
        border-radius: 30px;
        padding: 8px 16px;
        margin-right: 8px;
        margin-bottom: 8px;
        font-size: 0.9rem;
        font-weight: 500;
        border: 1px solid transparent;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .nav-pills-custom .nav-link.active {
        background-color: var(--primary-color);
        color: white;
        box-shadow: 0 4px 10px rgba(21, 163, 98, 0.25);
    }

    /* Student Card for Mobile */
    .student-mobile-card {
        border-bottom: 1px solid #eee;
        padding: 0.5rem 0.25rem;
        margin-bottom: 0;
        background-color: #fff;
        transition: all 0.2s ease;
    }

    .student-mobile-card:hover {
        background-color: #f9fbf9;
    }

    /* Print Button */
    .btn-print {
        border-radius: 30px;
        background-color: #03a9f4;
        border: none;
        color: white;
        padding: 8px 20px;
        font-weight: 600;
        transition: all 0.2s;
        box-shadow: 0 4px 10px rgba(3, 169, 244, 0.2);
    }

    .btn-print:hover {
        background-color: #0288d1;
        color: white;
        transform: translateY(-1px);
    }

    /* Scrollable pills on mobile */
    .scrollable-pills-container {
        overflow-x: auto;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 4px;
    }

    .scrollable-pills-container::-webkit-scrollbar {
        height: 4px;
    }

    .scrollable-pills-container::-webkit-scrollbar-thumb {
        background-color: #e0e0e0;
        border-radius: 4px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
// Prepare room data with grouping for optgroup
$roomsByGrade = [];
for ($i = 1; $i <= 6; $i++) {
    for ($j = 1; $j <= 6; $j++) {
        $roomsByGrade["ม.{$i}"][] = "{$i}/{$j}";
    }
}
$currentList = $_GET['studentList'] ?? '';
?>

<div class="container-xxl p-0">
    <!-- Header -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <h4 class="fw-bold py-1 mb-0 text-dark d-flex align-items-center">
                    <i class="bx bx-group me-2 text-primary-custom fs-4"></i>รายชื่อนักเรียน
                </h4>
                <span class="badge bg-primary-custom text-white px-3 py-2 rounded-pill fs-7">ปีการศึกษา <?= esc($schoolyear->schyear_year) ?></span>
            </div>
        </div>
    </div>

    <!-- Search Form Card -->
    <div class="card custom-card p-3 mb-3">
        <form action="" method="get">
            <div class="row align-items-end g-2 justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="input-group">
                        <select name="studentList" id="studentListSelect" class="form-select custom-select py-2">
                            <option value="">-- เลือกห้องเรียน --</option>
                            <?php foreach ($roomsByGrade as $grade => $rooms) : ?>
                                <optgroup label="<?= $grade ?>">
                                    <?php foreach ($rooms as $room) : ?>
                                        <option <?= $room == $currentList ? 'selected' : '' ?> value="<?= $room ?>">
                                            มัธยมศึกษาปีที่ <?= $room ?>
                                        </option>
                                    <?php endforeach; ?>
                                </optgroup>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-search py-2">
                            <i class="bx bx-search-alt-2 me-1"></i> ค้นหา
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <?php if ($currentList) : ?>
        <!-- Info & Filter Tabs Card -->
        <div class="card custom-card mb-3">
            <div class="card-header border-bottom bg-transparent py-2 px-3">
                <div class="row align-items-center g-2">
                    <div class="col-12 col-md">
                        <h6 class="mb-1 fw-bold text-dark fs-6">
                            นักเรียนชั้นมัธยมศึกษาปีที่ <?= esc($currentList) ?>
                        </h6>
                        <div class="row g-2 mt-0">
                            <div class="col-12 col-sm-6">
                                <div class="d-flex align-items-center fs-7 text-muted">
                                    <i class="bx bx-id-card text-primary-custom me-1.5 fs-6"></i>
                                    <span class="me-1">ครูที่ปรึกษา:</span>
                                    <strong class="text-dark">
                                        <?php
                                        $teacherNames = [];
                                        foreach ($TeacRoom as $v_TeacRoom) {
                                            $teacherNames[] = esc($v_TeacRoom->pers_prefix . $v_TeacRoom->pers_firstname . ' ' . $v_TeacRoom->pers_lastname);
                                        }
                                        echo !empty($teacherNames) ? implode(', ', $teacherNames) : 'ยังไม่ได้มอบหมาย';
                                        ?>
                                    </strong>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="d-flex align-items-center fs-7 text-muted">
                                    <i class="bx bx-user-check text-primary-custom me-1.5 fs-6"></i>
                                    <span class="me-1">นักเรียน:</span>
                                    <strong class="text-dark">
                                        <?php
                                        $totalStudents = count($selStudent);
                                        $maleCount = 0;
                                        $femaleCount = 0;
                                        foreach ($selStudent as $s) {
                                            $prefix = trim($s->StudentPrefix);
                                            if ($prefix === 'เด็กชาย' || $prefix === 'นาย' || strpos($prefix, 'ด.ช.') !== false) {
                                                $maleCount++;
                                            } elseif ($prefix === 'เด็กหญิง' || $prefix === 'นางสาว' || $prefix === 'นาง' || strpos($prefix, 'ด.ญ.') !== false || strpos($prefix, 'น.ส.') !== false) {
                                                $femaleCount++;
                                            } else {
                                                $femaleCount++;
                                            }
                                        }
                                        ?>
                                        <?= $totalStudents ?> คน (ชาย <?= $maleCount ?> / หญิง <?= $femaleCount ?>)
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-auto text-md-end">
                        <a target="_blank" href="<?= base_url('StudentsList/Print/' . $currentList . '/All') ?>" class="btn btn-print w-100 w-md-auto py-1.5 fs-7">
                            <i class="bx bx-printer me-1"></i> พิมพ์ใบรายชื่อ
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tab Headers -->
            <?php if (count($checkLine) > 1) : ?>
                <div class="card-body py-3 px-4 bg-light bg-opacity-50">
                    <div class="scrollable-pills-container">
                        <ul class="nav nav-pills nav-pills-custom flex-nowrap mb-0" id="orders-table-tab" role="tablist">
                            <!-- All students tab -->
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" 
                                   id="tab-all-tab" 
                                   data-bs-toggle="tab" 
                                   href="#tab-all" 
                                   role="tab" 
                                   aria-controls="tab-all" 
                                   aria-selected="true">
                                    <i class="bx bx-list-ul me-1"></i>รายชื่อทั้งหมด
                                </a>
                            </li>
                            <?php foreach ($checkLine as $key => $v_checkLine) : ?>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link SelStudyLine" 
                                       id="tab-<?= $key ?>-tab" 
                                       data-bs-toggle="tab" 
                                       href="#tab-<?= $key ?>" 
                                       role="tab" 
                                       aria-controls="tab-<?= $key ?>" 
                                       aria-selected="false" 
                                       key_studyline="<?= esc($v_checkLine->StudentStudyLine); ?>" 
                                       key_room="<?php $SubRoom = explode('.', $v_checkLine->StudentClass); echo esc($SubRoom[1] ?? ''); ?>">
                                        <?= esc($v_checkLine->StudentStudyLine) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Tab Contents / Single List -->
            <div class="tab-content" id="orders-table-tab-content">
                <?php if (count($checkLine) > 1) : ?>
                    <!-- Tab Pane for All Students -->
                    <div class="tab-pane fade show active" id="tab-all" role="tabpanel" aria-labelledby="tab-all-tab">
                        <!-- Desktop Table -->
                        <div class="d-none d-md-block">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center px-4" style="width: 80px;">เลขที่</th>
                                            <th class="text-center" style="width: 140px;">เลขประจำตัว</th>
                                            <th class="px-3">ชื่อ - นามสกุล</th>
                                            <th>หลักสูตร/แผนการเรียน</th>
                                            <th class="text-center" style="width: 120px;">สถานะ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($selStudent as $v_selStudent) : ?>
                                            <tr>
                                                <td class="text-center fw-bold text-dark px-4"><?= esc($v_selStudent->StudentNumber) ?></td>
                                                <td class="text-center text-muted"><?= esc($v_selStudent->StudentCode) ?></td>
                                                <td class="px-3 fw-semibold text-dark">
                                                    <?= esc($v_selStudent->StudentPrefix . $v_selStudent->StudentFirstName . ' ' . $v_selStudent->StudentLastName) ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary-light"><?= esc($v_selStudent->StudentStudyLine) ?></span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-label-success px-3 py-2 rounded-pill"><?= esc($v_selStudent->StudentBehavior) ?></span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Mobile List -->
                        <div class="d-block d-md-none p-2">
                            <?php foreach ($selStudent as $v_selStudent) : ?>
                                <div class="student-mobile-card d-flex align-items-center justify-content-between py-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-primary-custom text-white rounded-circle d-flex align-items-center justify-content-center fw-bold fs-8" style="width: 26px; height: 26px; min-width: 26px;">
                                            <?= esc($v_selStudent->StudentNumber) ?>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark fs-7 lh-sm">
                                                <?= esc($v_selStudent->StudentPrefix . $v_selStudent->StudentFirstName . ' ' . $v_selStudent->StudentLastName) ?>
                                            </div>
                                            <div class="text-muted fs-9 lh-sm d-flex align-items-center gap-1 mt-0.5">
                                                <span>รหัส: <?= esc($v_selStudent->StudentCode) ?></span>
                                                <span class="text-light-muted">•</span>
                                                <span><?= esc($v_selStudent->StudentStudyLine) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="badge bg-label-success rounded-pill px-2 py-1 fs-9" style="font-size: 0.7rem !important;"><?= esc($v_selStudent->StudentBehavior) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <?php foreach ($checkLine as $key_tab => $v_checkLine_tab) : ?>
                        <div class="tab-pane fade" id="tab-<?= $key_tab ?>" role="tabpanel" aria-labelledby="tab-<?= $key_tab ?>-tab">
                            <!-- Desktop Table -->
                            <div class="d-none d-md-block">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center px-4" style="width: 80px;">เลขที่</th>
                                                <th class="text-center" style="width: 140px;">เลขประจำตัว</th>
                                                <th class="px-3">ชื่อ - นามสกุล</th>
                                                <th>หลักสูตร/แผนการเรียน</th>
                                                <th class="text-center" style="width: 120px;">สถานะ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $studentsInTab = 0;
                                            foreach ($selStudent as $v_selStudent) :
                                                if ($v_selStudent->StudentStudyLine == $v_checkLine_tab->StudentStudyLine) : 
                                                    $studentsInTab++;
                                            ?>
                                                    <tr>
                                                        <td class="text-center fw-bold text-dark px-4"><?= esc($v_selStudent->StudentNumber) ?></td>
                                                        <td class="text-center text-muted"><?= esc($v_selStudent->StudentCode) ?></td>
                                                        <td class="px-3 fw-semibold text-dark">
                                                            <?= esc($v_selStudent->StudentPrefix . $v_selStudent->StudentFirstName . ' ' . $v_selStudent->StudentLastName) ?>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-primary-light"><?= esc($v_selStudent->StudentStudyLine) ?></span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge bg-label-success px-3 py-2 rounded-pill"><?= esc($v_selStudent->StudentBehavior) ?></span>
                                                        </td>
                                                    </tr>
                                            <?php 
                                                endif;
                                            endforeach; 
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Mobile List -->
                            <div class="d-block d-md-none p-2">
                                <?php 
                                foreach ($selStudent as $v_selStudent) :
                                    if ($v_selStudent->StudentStudyLine == $v_checkLine_tab->StudentStudyLine) : 
                                ?>
                                        <div class="student-mobile-card d-flex align-items-center justify-content-between py-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="bg-primary-custom text-white rounded-circle d-flex align-items-center justify-content-center fw-bold fs-8" style="width: 26px; height: 26px; min-width: 26px;">
                                                    <?= esc($v_selStudent->StudentNumber) ?>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark fs-7 lh-sm">
                                                        <?= esc($v_selStudent->StudentPrefix . $v_selStudent->StudentFirstName . ' ' . $v_selStudent->StudentLastName) ?>
                                                    </div>
                                                    <div class="text-muted fs-9 lh-sm d-flex align-items-center gap-1 mt-0.5">
                                                        <span>รหัส: <?= esc($v_selStudent->StudentCode) ?></span>
                                                        <span class="text-light-muted">•</span>
                                                        <span><?= esc($v_selStudent->StudentStudyLine) ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="badge bg-label-success rounded-pill px-2 py-1 fs-9" style="font-size: 0.7rem !important;"><?= esc($v_selStudent->StudentBehavior) ?></span>
                                        </div>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                <?php else : ?>
                    <!-- Single Study Line (No tabs needed) -->
                    <div class="p-0">
                        <!-- Desktop Table -->
                        <div class="d-none d-md-block">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center px-4" style="width: 80px;">เลขที่</th>
                                            <th class="text-center" style="width: 140px;">เลขประจำตัว</th>
                                            <th class="px-3">ชื่อ - นามสกุล</th>
                                            <th>หลักสูตร/แผนการเรียน</th>
                                            <th class="text-center" style="width: 120px;">สถานะ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($selStudent as $v_selStudent) : ?>
                                            <tr>
                                                <td class="text-center fw-bold text-dark px-4"><?= esc($v_selStudent->StudentNumber) ?></td>
                                                <td class="text-center text-muted"><?= esc($v_selStudent->StudentCode) ?></td>
                                                <td class="px-3 fw-semibold text-dark">
                                                    <?= esc($v_selStudent->StudentPrefix . $v_selStudent->StudentFirstName . ' ' . $v_selStudent->StudentLastName) ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary-light"><?= esc($v_selStudent->StudentStudyLine) ?></span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-label-success px-3 py-2 rounded-pill"><?= esc($v_selStudent->StudentBehavior) ?></span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Mobile List -->
                        <div class="d-block d-md-none p-2">
                            <?php foreach ($selStudent as $v_selStudent) : ?>
                                <div class="student-mobile-card d-flex align-items-center justify-content-between py-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-primary-custom text-white rounded-circle d-flex align-items-center justify-content-center fw-bold fs-8" style="width: 26px; height: 26px; min-width: 26px;">
                                            <?= esc($v_selStudent->StudentNumber) ?>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark fs-7 lh-sm">
                                                <?= esc($v_selStudent->StudentPrefix . $v_selStudent->StudentFirstName . ' ' . $v_selStudent->StudentLastName) ?>
                                            </div>
                                            <div class="text-muted fs-9 lh-sm d-flex align-items-center gap-1 mt-0.5">
                                                <span>รหัส: <?= esc($v_selStudent->StudentCode) ?></span>
                                                <span class="text-light-muted">•</span>
                                                <span><?= esc($v_selStudent->StudentStudyLine) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="badge bg-label-success rounded-pill px-2 py-1 fs-9" style="font-size: 0.7rem !important;"><?= esc($v_selStudent->StudentBehavior) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php elseif (isset($_GET['studentList'])) : ?>
         <div class="card custom-card p-5 text-center">
             <div class="py-4">
                 <i class="bx bx-info-circle text-warning fs-1 mb-3"></i>
                 <h5 class="fw-bold text-dark">ไม่พบข้อมูลนักเรียน</h5>
                 <p class="text-muted mb-0">โปรดตรวจสอบห้องเรียนที่เลือก หรือเลือกห้องเรียนใหม่อีกครั้ง</p>
             </div>
         </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>