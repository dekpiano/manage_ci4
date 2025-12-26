<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-white"><i class='bx bx-edit-alt me-2'></i>บันทึกผลการเรียน: <?= esc($SubjectName) ?> (<?= esc($SubjectCode) ?>)</h5>
            <a href="<?= site_url('Admin/Acade/Evaluate/SaveScore') ?>" class="btn btn-sm btn-outline-light">
                <i class='bx bx-arrow-back'></i> ย้อนกลับ
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <form id="form_score">
                    <?= csrf_field() ?>
                    <input type="hidden" name="SubjectID" value="<?= esc($SubjectID) ?>">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th rowspan="2" class="text-center align-middle" style="width: 50px;">เลขที่</th>
                                <th rowspan="2" class="text-center align-middle" style="width: 100px;">รหัสนักเรียน</th>
                                <th rowspan="2" class="text-center align-middle">ชื่อ-นามสกุล</th>
                                <th rowspan="2" class="text-center align-middle" style="width: 100px;">สถานะ</th>
                                <th colspan="<?= count($set_score) ?>" class="text-center">คะแนนเก็บแยกตามส่วน</th>
                                <th rowspan="2" class="text-center align-middle" style="width: 80px;">รวม</th>
                                <th rowspan="2" class="text-center align-middle" style="width: 80px;">เกรด</th>
                            </tr>
                            <tr>
                                <?php foreach ($set_score as $v_set_score): ?>
                                    <th class="text-center small py-1" style="min-width: 80px;">
                                        <?= esc($v_set_score->regscore_namework) ?><br>
                                        <span class="badge bg-secondary">(<?= esc($v_set_score->regscore_score) ?>)</span>
                                    </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($check_student as $key_student => $v_check_student): ?>
                                <tr>
                                    <td class="text-center"><?= esc($v_check_student->StudentNumber) ?></td>
                                    <td class="text-center"><?= esc($v_check_student->StudentCode) ?></td>
                                    <td>
                                        <?= esc($v_check_student->StudentPrefix . $v_check_student->StudentFirstName . ' ' . $v_check_student->StudentLastName) ?>
                                        <?php if(isset($v_check_student->Grade_Type) && !empty($v_check_student->Grade_Type)): ?>
                                            <br><small class="text-danger fw-bold">(<?= esc($v_check_student->Grade_Type) ?>)</small>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-label-success">ปกติ</span>
                                    </td>
                                    <?php 
                                        foreach ($set_score as $key => $v_set_score): 
                                        $s = explode("|", isset($v_check_student->Score100) ? $v_check_student->Score100 : '');
                                        
                                        // แยกประเภทนักเรียน
                                        $isRepeatStudent = (isset($v_check_student->Grade_Type) && (strpos($v_check_student->Grade_Type, 'เรียนซ้ำ') !== false || strpos($v_check_student->Grade_Type, 'แก้') !== false));
                                        
                                        // ตั้งค่า Master Toggle ตรวจสอบ
                                        $masterOpen = $isRepeatStudent 
                                            ? (isset($OnOffRepeat->onoff_status) && $OnOffRepeat->onoff_status == "on") 
                                            : (isset($OnOffNormal->onoff_status) && $OnOffNormal->onoff_status == "on");
                                            
                                        // ตั้งค่าช่วงเวลา (Period) ตรวจสอบ
                                        $periodsToCheck = $isRepeatStudent ? $OnOffRepeatPeriods : $OnOffNormalPeriods;
                                        $periodOpen = false;
                                        foreach ($periodsToCheck as $p) {
                                            if ($p->onoff_name == $v_set_score->regscore_namework) {
                                                $periodOpen = ($p->onoff_status == "on");
                                                break;
                                            }
                                        }

                                        $isReadOnly = !($masterOpen && $periodOpen);
                                    ?>
                                        <td>
                                            <input type="text" class="form-control text-center check_score KeyEnter"
                                                check-score-key="<?= isset($v_set_score->regscore_score) ? esc($v_set_score->regscore_score) : '' ?>"
                                                id="<?= isset($v_check_student->StudentID) ? esc($v_check_student->StudentID) : '' ?>"
                                                name="<?= isset($v_check_student->StudentID) ? esc($v_check_student->StudentID) : '' ?>[]"
                                                value="<?= (isset($v_check_student->Score100) && $v_check_student->Score100 == "") ? "" : (isset($s[$key]) ? esc($s[$key]) : '') ?>"
                                                <?= ($isReadOnly) ? "readonly" : "" ?>
                                                <?= ($isReadOnly) ? "style='background-color: #f8f9fa; pointer-events: none; opacity: 0.6;'" : "" ?>
                                                autocomplete="off">
                                        </td>
                                    <?php endforeach; ?>
                                    <td class="text-center fw-bold bg-light">
                                        <span class="total_score" id="total_<?= esc($v_check_student->StudentID) ?>">
                                            <?= (isset($v_check_student->Score100) && $v_check_student->Score100 == "") ? "" : array_sum($s) ?>
                                        </span>
                                    </td>
                                    <td class="text-center fw-bold bg-light">
                                        <span class="grade_result" id="grade_<?= esc($v_check_student->StudentID) ?>">
                                            <?= esc($v_check_student->Grade) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).on("keyup", ".check_score", function() {
    var self = $(this);
    var max = parseInt(self.attr('check-score-key'));
    var val = self.val();
    
    // Validate score
    if(val != "" && (isNaN(val) || parseInt(val) > max || parseInt(val) < 0)) {
        self.addClass('is-invalid');
        Swal.fire({
            icon: 'error',
            title: 'คะแนนไม่ถูกต้อง',
            text: 'กรุณากรอกคะแนนระหว่าง 0 - ' + max,
            timer: 1500
        });
        self.val("");
    } else {
        self.removeClass('is-invalid');
        calculateTotal(self.attr('id'));
    }
});

function calculateTotal(studentID) {
    var total = 0;
    var inputs = $("input[id='" + studentID + "']");
    var allFilled = true;
    
    inputs.each(function() {
        if($(this).val() == "") {
            allFilled = false;
        } else {
            total += parseInt($(this).val());
        }
    });

    $("#total_" + studentID).text(allFilled ? total : "");
    updateGrade(studentID, total, allFilled);
    
    // Auto save via AJAX
    saveScore(studentID);
}

function updateGrade(studentID, total, allFilled) {
    var grade = "";
    if (allFilled) {
        if (total >= 80) grade = "4";
        else if (total >= 75) grade = "3.5";
        else if (total >= 70) grade = "3";
        else if (total >= 65) grade = "2.5";
        else if (total >= 60) grade = "2";
        else if (total >= 55) grade = "1.5";
        else if (total >= 50) grade = "1";
        else grade = "0";
    }
    $("#grade_" + studentID).text(grade);
}

function saveScore(studentID) {
    var formData = $("#form_score").serialize();
    $.post("<?= site_url('admin/academic/ConAdminSaveScore/insert_score_0W') ?>", formData, function(res) {
        console.log("Score saved for student: " + studentID);
    });
}
</script>
<?= $this->endSection() ?>