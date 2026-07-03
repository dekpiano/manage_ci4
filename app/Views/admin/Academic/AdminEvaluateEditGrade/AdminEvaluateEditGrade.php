<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
    :root {
        --primary-green: #15a362;
        --primary-green-hover: #128c53;
        --primary-green-rgb: 21, 163, 98;
        --soft-green: #f0faf5;
        --card-shadow: 0 8px 26px rgba(0, 0, 0, 0.04);
        --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .page-title-wrapper {
        border-left: 5px solid var(--primary-green);
        padding-left: 15px;
        margin-bottom: 1.5rem;
    }

    .card-premium {
        border: none;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        background: #ffffff;
        transition: var(--transition-smooth);
        overflow: hidden;
    }

    .card-premium:hover {
        box-shadow: 0 12px 30px rgba(21, 163, 98, 0.08);
    }

    .table-premium thead th {
        background-color: var(--primary-green) !important;
        color: #ffffff !important;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        border: none;
        padding: 12px;
    }

    .table-premium thead tr:first-child th {
        border-bottom: 1px solid rgba(255, 255, 255, 0.2) !important;
    }

    .table-premium tbody td, 
    .table-premium tbody th {
        vertical-align: middle;
        padding: 12px;
        border-color: #f1f5f9;
    }

    .input-score-custom {
        text-align: center;
        font-weight: 700;
        border-radius: 8px;
        border: 1.5px solid #e2e8f0;
        padding: 6px 12px;
        max-width: 80px;
        margin: 0 auto;
        color: #334155;
        transition: var(--transition-smooth);
    }

    .input-score-custom:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(21, 163, 98, 0.15);
        outline: none;
        background-color: #fff;
    }

    .badge-status {
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 30px;
        font-size: 0.8rem;
    }

    .btn-green-premium {
        background-color: var(--primary-green) !important;
        border-color: var(--primary-green) !important;
        color: #ffffff !important;
        font-weight: 600;
        border-radius: 10px;
        padding: 10px 24px;
        transition: var(--transition-smooth);
        box-shadow: 0 4px 12px rgba(21, 163, 98, 0.2);
    }

    .btn-green-premium:hover {
        background-color: var(--primary-green-hover) !important;
        border-color: var(--primary-green-hover) !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(21, 163, 98, 0.3);
    }

    .btn-warning-premium {
        background-color: #ff9f43 !important;
        border-color: #ff9f43 !important;
        color: #ffffff !important;
        font-weight: 600;
        border-radius: 10px;
        padding: 10px 24px;
        transition: var(--transition-smooth);
        box-shadow: 0 4px 12px rgba(255, 159, 67, 0.2);
    }

    .btn-warning-premium:hover {
        background-color: #ea8a2e !important;
        border-color: #ea8a2e !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(255, 159, 67, 0.3);
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="page-title-wrapper d-flex flex-column justify-content-center">
        <h4 class="fw-bold mb-1" style="color: #1e293b;">จัดการข้อมูล<?=$title;?></h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?=base_url('Admin/Home');?>">หน้าหลัก</a></li>
                <li class="breadcrumb-item"><a href="<?=base_url('Admin/Acade/Evaluate/AcademicRepeat');?>">ประเมินผลการเรียน</a></li>
                <li class="breadcrumb-item active" aria-current="page">แก้ไขคะแนน</li>
            </ol>
        </nav>
    </div>

    <!-- Subject & Teacher Info Card -->
    <div class="card card-premium mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-7 d-flex align-items-center mb-3 mb-md-0">
                    <div class="avatar avatar-md me-3 bg-light-green p-2 rounded-3 text-center d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class='bx bx-book-open text-success fs-3'></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1" style="color: #1e293b;"><?=$check_student[0]->SubjectCode.' '.$check_student[0]->SubjectName?></h5>
                        <p class="text-muted mb-0">ครูผู้สอน: <?=$Teacher->pers_prefix.$Teacher->pers_firstname.' '.$Teacher->pers_lastname;?></p>
                    </div>
                </div>
                <div class="col-md-5 text-md-end">
                    <span class="badge bg-label-success px-3 py-2 rounded-pill fw-bold" style="font-size: 0.85rem;">
                        <i class='bx bx-calendar-event me-1'></i> ปีการศึกษา <?=$check_student[0]->RegisterYear?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Score Form -->
    <div class="row">
        <div class="col-12">
            <?php if($check_student): ?>
            <div class="card card-premium">
                <div class="card-body p-0">
                    <div class="p-3 text-success d-flex align-items-center gap-2 border-bottom" style="background-color: rgba(21, 163, 98, 0.08); font-size: 0.9rem;">
                        <i class='bx bx-info-circle fs-4'></i>
                        <div class="fw-semibold">
                            💡 หมายเหตุ: ระบบจะบันทึกคะแนนและเวลาเรียนให้โดยอัตโนมัติ (Auto-save) ทันทีที่มีการกรอกหรือเปลี่ยนข้อมูลในตาราง คุณสามารถแก้ไขข้อมูลได้ทันทีโดยไม่ต้องกดปุ่มบันทึกใดๆ
                        </div>
                    </div>
                    <div class="table-responsive">
                        <form class="form_score_0W">
                            <table id="tb_score" class="table table-premium table-hover mb-0">
                                <thead class="text-center">
                                    <tr>
                                        <th colspan="4" class="align-middle border-end border-white">ข้อมูลนักเรียน</th>
                                        <th colspan="8" class="align-middle">การประเมินผลการเรียน</th>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">ชั้น</th>
                                        <th class="align-middle">เลขที่</th>
                                        <th class="align-middle">เลขประจำตัว</th>
                                        <th class="align-middle" width="220">ชื่อ - นามสกุล</th>
                                        <?php 
                                        if(floatval($check_student[0]->SubjectUnit) == 0.5){ $TimeNum = 20; }
                                        elseif(floatval($check_student[0]->SubjectUnit) == 1){$TimeNum = 40;}
                                        elseif(floatval($check_student[0]->SubjectUnit) == 1.5){$TimeNum = 60;}
                                        ?>
                                        <th class="align-middle">เวลาเรียน<br><small class="opacity-75">(<?=intval($TimeNum);?> ชม.)</small></th>
                                        <?php 
                                        $sum_scoer = 0;
                                        foreach ($set_score as $key => $v_set_score): 
                                            $sum_scoer += $v_set_score->regscore_score;
                                        ?>
                                        <th class="align-middle">
                                            <?=$v_set_score->regscore_namework?><br>
                                            <small class="opacity-75">(<?=$v_set_score->regscore_score?>)</small>
                                        </th>
                                        <?php endforeach; ?>
                                        <th class="align-middle">คะแนนรวม<br><small class="opacity-75">(<?=$sum_scoer?>)</small></th>
                                        <th class="align-middle">เกรด</th>
                                        <th class="align-middle">สถานะพฤติกรรม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach ($check_student as $key => $v_check_student) :
                                        if($v_check_student->Grade <= 0 && $v_check_student->Grade != 'มส' || $v_check_student->Grade_Type == 'แก้ 0 ร'):  
                                    ?>
                                    <tr>
                                        <td class="align-middle text-center fw-bold"><?=$v_check_student->StudentClass?></td>
                                        <td class="align-middle text-center fw-bold"><?=$v_check_student->StudentNumber?></td>
                                        <td class="align-middle text-center text-muted"><?=$v_check_student->StudentCode?></td>
                                        <td class="align-middle fw-semibold text-slate">
                                            <?=$v_check_student->StudentPrefix?><?=$v_check_student->StudentFirstName?> <?=$v_check_student->StudentLastName?>
                                            <div class="text-muted fw-normal" style="font-size: 0.75rem;"><?=($v_check_student->Grade_Type);?></div> 
                                            <input type="text" class="form-control d-none" id="StudentID" name="StudentID[]" value="<?=$v_check_student->StudentID?>">
                                            <input type="text" class="form-control d-none" id="SubjectID" name="SubjectID" value="<?=$check_student[0]->SubjectID?>">
                                            <input type="text" class="form-control d-none" id="RegisterYear" name="RegisterYear" value="<?=$check_student[0]->RegisterYear?>">
                                            <input type="text" class="form-control d-none" id="TimeNum" name="TimeNum" value="<?=$TimeNum?>">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control input-score-custom study_time KeyEnter"
                                                id="study_time" check-time="<?=$TimeNum;?>" name="study_time[]"
                                                value="<?=$v_check_student->StudyTime == "" ? "" : $v_check_student->StudyTime?>"
                                                autocomplete="off">
                                        </td>
                                        <?php 
                                        foreach ($set_score as $key => $v_set_score): 
                                            $s = explode("|",$v_check_student->Score100);
                                            if($onoff_savescore[0]->onoff_name == $v_set_score->regscore_namework){
                                                $onoff_status = $onoff_savescore[0]->onoff_status;
                                            }elseif($onoff_savescore[1]->onoff_name == $v_set_score->regscore_namework){
                                                $onoff_status = $onoff_savescore[1]->onoff_status;
                                            }elseif($onoff_savescore[2]->onoff_name == $v_set_score->regscore_namework){
                                                $onoff_status = $onoff_savescore[2]->onoff_status;
                                            }elseif($onoff_savescore[3]->onoff_name == $v_set_score->regscore_namework){
                                                $onoff_status = $onoff_savescore[3]->onoff_status;
                                            }
                                        ?>
                                        <td>
                                            <input type="text" class="form-control input-score-custom check_score KeyEnter"
                                                check-score-key="<?=$v_set_score->regscore_score?>"
                                                id="<?=$v_check_student->StudentID?>"
                                                name="<?=$v_check_student->StudentID?>[]"
                                                value="<?=$v_check_student->Score100 == "" ? "" : $s[$key]?>"
                                                <?=$checkOnOff[6]->onoff_status == "off" ? "readonly" : ""?>
                                                autocomplete="off">
                                        </td>
                                        <?php endforeach; ?>
                                        <td class="align-middle text-center fw-bold fs-5 subtot text-success"></td>
                                        <td class="align-middle text-center">
                                            <span class="badge bg-label-success fs-6 px-3 py-1 fw-bold grade"></span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <?php if($v_check_student->StudentBehavior == "ปกติ"): ?>
                                                <span class="badge bg-label-success badge-status"><i class='bx bx-check-circle me-1'></i><?=$v_check_student->StudentBehavior?></span>
                                            <?php else: ?>
                                                <span class="badge bg-label-danger badge-status"><i class='bx bx-error-circle me-1'></i><?=$v_check_student->StudentBehavior?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                </tbody>
                            </table>
                            

                        </form>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="card card-premium text-center p-5">
                <div class="card-body">
                    <div class="avatar avatar-lg mx-auto bg-light-green p-3 rounded-circle mb-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                        <i class='bx bx-info-circle text-success fs-1'></i>
                    </div>
                    <h4 class="fw-bold mb-2">ไม่มีข้อมูลนักเรียนที่ต้องประเมิน</h4>
                    <p class="text-muted mb-4">ไม่พบรายชื่อนักเรียนเรียนซ้ำในวิชานี้ที่ต้องได้รับการแก้ไขคะแนน</p>
                    <a class="btn btn-green-premium" href="<?=base_url('Admin/Acade/Evaluate/AcademicRepeat');?>">กลับหน้าหลัก</a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).on('keyup', '.check_score', function() {
    var num = parseInt($(this).val());
    var key = parseInt($(this).attr('check-score-key'));

    if (num > key) {
        Swal.fire({
            icon: 'error',
            title: 'กรอกคะแนนเกินกำหนด!',
            text: 'กรุณากรอกคะแนนไม่เกิน ' + key + ' คะแนน',
            showConfirmButton: true,
            confirmButtonColor: '#15a362',
            customClass: { popup: 'swal2-popup-on-top' }
        }).then(() => {
            $(this).val("0");
            calculateRowSum();
        })
    }
});

$(document).on('keyup', '.study_time', function() {
    var num = parseInt($(this).val());
    var key = parseInt($(this).attr('check-time'));

    if (num > key) {
        Swal.fire({
            icon: 'error',
            title: 'กรอกเวลาเรียนเกินกำหนด!',
            text: 'กรุณากรอกเวลาเรียนไม่เกิน ' + key + ' ชั่วโมง',
            showConfirmButton: true,
            confirmButtonColor: '#15a362',
            customClass: { popup: 'swal2-popup-on-top' }
        }).then(() => {
            $(this).val("0");
            calculateRowSum();
        })
    }
});

function calculateRowSum() {
    var TimeNum = $('.study_time').attr('check-time');
    $('table tbody tr').each(function() {
        var sum = 0;
        var study_time;
        var Check_ro = 0;
        $(this).find('td').each(function() {
            if ($(this).find('.check_score').val() == "ร") {
                Check_ro += 1;
            } else {
                sum += parseInt($(this).find('.check_score').val()) || 0;
            }
        });
        study_time = $(this).find('.study_time').val()

        $(this).find('.subtot').html(sum);
        var gradeEl = $(this).find('.grade');
        if (80 * TimeNum / 100 > study_time) {
            gradeEl.html('มส').removeClass('bg-label-success').addClass('bg-label-danger');
        } else if (Check_ro > 0) {
            gradeEl.html('ร').removeClass('bg-label-success').addClass('bg-label-warning');
        } else {
            var calculatedGrade = check_grade(sum);
            gradeEl.html(calculatedGrade);
            if (calculatedGrade == '0') {
                gradeEl.removeClass('bg-label-success bg-label-warning').addClass('bg-label-danger');
            } else {
                gradeEl.removeClass('bg-label-danger bg-label-warning').addClass('bg-label-success');
            }
        }
    });
}

function check_grade(sum) {
    if ((sum > 100) || (sum < 0)) {
        var grade = "คะแนนเกิน";
    } else if ((sum >= 79.5) && (sum <= 100)) {
        var grade = 4;
    } else if ((sum >= 74.5) && (sum <= 79.4)) {
        var grade = 3.5;
    } else if ((sum >= 69.5) && (sum <= 74.4)) {
        var grade = 3;
    } else if ((sum >= 64.5) && (sum <= 69.4)) {
        var grade = 2.5;
    } else if ((sum >= 59.5) && (sum <= 64.4)) {
        var grade = 2;
    } else if ((sum >= 54.5) && (sum <= 59.4)) {
        var grade = 1.5;
    } else if ((sum >= 49.5) && (sum <= 54.4)) {
        var grade = 1;
    } else if (sum <= 49.4) {
        var grade = 0;
    }
    return grade;
}
calculateRowSum();

$(".check_score").each(function() {
    $(this).keyup(function() {
        calculateTotal($(this).parent().index());
    });
});

$(".study_time").each(function() {
    $(this).keyup(function() {
        calculateTotal($(this).parent().index());
    });
});

function calculateTotal(index) {
    var total = 0;
    $('#tb_score tbody tr td').filter(function() {
        if ($(this).index() == index) {
            total += parseInt($(this).find('.check_score').val()) || 0;
        }
    });
    $('#tb_score tbody tr td.totalCol:eq(' + index + ')').html(total);
    calculateRowSum();
}

$(document).ready(function() {
    $('#tb_score').DataTable({
        "responsive": true,
        "autoWidth": false,
        "paging": false, 
        "searching": false, 
        "info": false, 
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.13.7/i18n/Thai.json"
        }
    });

    // Event listener for study_time changes
    $(document).on('change', '.study_time', function() {
        var $row = $(this).closest('tr');
        var studentId = $row.find('input[name="StudentID[]"]').val();
        var subjectId = $('input[name="SubjectID"]').val(); 
        var registerYear = $('input[name="RegisterYear"]').val(); 
        var studyTime = $(this).val();

        $.ajax({
            url: '<?= site_url('Admin/Acade/Evaluate/ConAdminSaveScore/update_study_time') ?>', 
            type: 'POST',
            data: {
                student_id: studentId,
                subject_id: subjectId,
                register_year: registerYear,
                study_time: studyTime
            },
            success: function(response) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'บันทึกเวลาเรียนสำเร็จ',
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: { popup: 'swal2-popup-on-top' }
                });
                console.log('Study time updated:', response);
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาดในการบันทึกเวลาเรียน',
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: { popup: 'swal2-popup-on-top' }
                });
                console.error('Error updating study time:', error);
            }
        });
    });

    // Event listener for check_score changes
    $(document).on('change', '.check_score', function() {
        var $row = $(this).closest('tr');
        var studentId = $row.find('input[name="StudentID[]"]').val();
        var subjectId = $('input[name="SubjectID"]').val(); 
        var registerYear = $('input[name="RegisterYear"]').val(); 
        var scoreValue = $(this).val();
        var scoreIndex = $(this).closest('td').index() - 5; 

        $.ajax({
            url: '<?= site_url('Admin/Acade/Evaluate/ConAdminSaveScore/update_score') ?>', 
            type: 'POST',
            data: {
                student_id: studentId,
                subject_id: subjectId,
                register_year: registerYear,
                score_index: scoreIndex, 
                score_value: scoreValue
            },
            success: function(response) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'บันทึกคะแนนสำเร็จ',
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: { popup: 'swal2-popup-on-top' }
                });
                console.log('Score updated:', response);
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาดในการบันทึกคะแนน',
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: { popup: 'swal2-popup-on-top' }
                });
                console.error('Error updating score:', error);
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
