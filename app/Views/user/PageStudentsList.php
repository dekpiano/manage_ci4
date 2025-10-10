<?= $this->extend('user/layout/main') ?>

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

<div class="">
    <div class="">
       <div class="d-flex justify-content-between align-items-center">
                             <h3 class="page-title mb-0">รายชื่อนักเรียน ปีการศึกษา <?= $schoolyear->schyear_year ?></h3>
                        </div>

        <div class="card card-settings shadow-sm p-4">
            <div class="">
                <form class="settings-form" action="?" method="get">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6">
                            <label for="studentListSelect" class="form-label">เลือกห้องเรียน</label>
                            <div class="input-group">
                                <select name="studentList" id="studentListSelect" class="form-select">
                                    <option value="">-- ค้นหาห้องเรียน --</option>
                                    <?php foreach ($roomsByGrade as $grade => $rooms) : ?>
                                        <optgroup label="<?= $grade ?>">
                                            <?php foreach ($rooms as $room) : ?>
                                                <option <?= $room == $currentList ? 'selected' : '' ?> value="<?= $room ?>">
                                                    ม.<?= $room ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search" aria-hidden="true"></i> ค้นหา
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div><!--//card-body-->
        </div><!--//card-->

        <?php if ($currentList) : ?>
            <div class="row g-4 mt-4">
                <div class="col-12">
                    <div class="card card-orders-table shadow-sm">
                        <div class="card-header p-3">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto">
                                    <h4 class="card-title">
                                        นักเรียนชั้นมัธยมศึกษาปีที่ <?= $currentList ?>
                                    </h4>
                                    <p class="mb-0">
                                        <strong>ครูที่ปรึกษา:</strong>
                                        <?php
                                        $teacherNames = [];
                                        foreach ($TeacRoom as $v_TeacRoom) {
                                            $teacherNames[] = htmlspecialchars($v_TeacRoom->pers_prefix . $v_TeacRoom->pers_firstname . ' ' . $v_TeacRoom->pers_lastname);
                                        }
                                        echo implode(', ', $teacherNames);
                                        ?>
                                    </p>
                                </div>
                                <div class="col-auto">
                                    <a target="_blank" href="<?= base_url('StudentsList/Print/' . $currentList . '/All') ?>" class="btn btn-info text-white PrintNameRoom">
                                        <i class="bx bx-printer me-1" aria-hidden="true"></i> พิมพ์ใบรายชื่อ
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-12">
                                    <ul class="nav nav-pills" id="orders-table-tab" role="tablist">
                                        <?php foreach ($checkLine as $key => $v_checkLine) : ?>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link SelStudyLine <?= $key == 0 ? "active" : "" ?>" id="tab-<?= $key ?>-tab" data-bs-toggle="tab" href="#tab-<?= $key ?>" role="tab" aria-controls="tab-<?= $key ?>" aria-selected="<?= $key == 0 ? "true" : "false" ?>" key_studyline="<?= $v_checkLine->StudentStudyLine; ?>" key_room="<?php $SubRoom = explode('.', $v_checkLine->StudentClass); echo $SubRoom[1]; ?>">
                                                    <?= $key == 0 ? "รายชื่อทั้งหมด" : htmlspecialchars($v_checkLine->StudentStudyLine) ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div><!--//card-body-->
                        <div class="card-body p-0">
                            <div class="tab-content" id="orders-table-tab-content">
                                <?php foreach ($checkLine as $key_tab => $v_checkLine_tab) : ?>
                                    <div class="tab-pane fade <?= $key_tab == 0 ? "show active" : "" ?>" id="tab-<?= $key_tab ?>" role="tabpanel" aria-labelledby="tab-<?= $key_tab ?>-tab">
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0 text-left">
                                                <thead>
                                                    <tr>
                                                        <th class="cell text-center">ที่</th>
                                                        <th class="cell text-center">เลขประจำตัว</th>
                                                        <th class="cell">ชื่อ - นามสกุล</th>
                                                        <th class="cell text-center">หลักสูตร</th>
                                                        <th class="cell text-center">สถานะ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $studentsInTab = 0;
                                                    foreach ($selStudent as $v_selStudent) :
                                                        $isCorrectTab = ($key_tab == 0) || ($v_selStudent->StudentStudyLine == $v_checkLine_tab->StudentStudyLine);
                                                        if ($isCorrectTab) : 
                                                            $studentsInTab++;
                                                    ?>
                                                            <tr>
                                                                <td class="cell text-center"><?= htmlspecialchars($v_selStudent->StudentNumber) ?></td>
                                                                <td class="cell text-center"><?= htmlspecialchars($v_selStudent->StudentCode) ?></td>
                                                                <td class="cell">
                                                                    <?= htmlspecialchars($v_selStudent->StudentPrefix . $v_selStudent->StudentFirstName . ' ' . $v_selStudent->StudentLastName) ?>
                                                                </td>
                                                                <td class="cell text-center"><?= htmlspecialchars($v_selStudent->StudentStudyLine) ?></td>
                                                                <td class="cell text-center">
                                                                    <span class="badge bg-success"><?= htmlspecialchars($v_selStudent->StudentBehavior) ?></span>
                                                                </td>
                                                            </tr>
                                                    <?php 
                                                        endif;
                                                    endforeach; 
                                                    
                                                    if ($studentsInTab === 0):
                                                    ?>
                                                        <tr>
                                                            <td colspan="5" class="text-center p-4">ไม่พบข้อมูลนักเรียนในกลุ่มนี้</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div><!--//table-responsive-->
                                    </div><!--//tab-pane-->
                                <?php endforeach; ?>
                            </div><!--//tab-content-->
                        </div><!--//card-body-->
                    </div><!--//card-->
                </div>
            </div><!--//row-->
        <?php elseif (isset($_GET['studentList'])) : ?>
             <div class="row g-4 mt-4">
                <div class="col-12">
                    <div class="card card-stat shadow-sm">
                        <div class="card-body p-3 p-lg-4">
                            <div class="text-center">
                                <h4>ไม่พบข้อมูลนักเรียน</h4>
                                <p>โปรดตรวจสอบห้องเรียนที่เลือก หรือติดต่อผู้ดูแลระบบ</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div><!--//content-->
</div><!--//wrapper-->

<?= $this->endSection() ?>