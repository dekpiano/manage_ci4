<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
.border-left-primary {
    border-left: .25rem solid #5BC3D5 !important;
}
</style>
<div class="">
    <div class="">
        <h2 class="heading mb-4">จัดการข้อมูล<?=$title;?></h2>
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=base_url('Admin/Home');?>">หน้าหลัก</a></li>
                <li class="breadcrumb-item"><a href="<?=base_url('Admin/Acade/Evaluate/AcademicRepeat');?>">ประเมินผลการเรียน</a></li>
                <li class="breadcrumb-item active" aria-current="page">แก้ไขคะแนน</li>
            </ol>
        </nav>
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">ข้อมูลรายวิชาและผู้สอน</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <p class="mb-1"><strong>ครูผู้สอน:</strong> <?=$Teacher->pers_prefix.$Teacher->pers_firstname.' '.$Teacher->pers_lastname;?></p>
                        <p class="mb-0"><strong>รายวิชา:</strong> <?=$check_student[0]->SubjectCode.' '.$check_student[0]->SubjectName?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--//container-->
    </section>
    <section class="we-offer-area mt-3">
        <div class="container-fluid">

            <?php if($check_student): ?>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <form class="form_score_0W">

                                <table id="tb_score" class="table table-striped table-hover table-bordered">
                                    <thead class="text-center bg-light">
                                        <tr>
                                            <th colspan="4" class="align-middle">ข้อมูลนักเรียน</th>
                                            <th colspan="8" class="align-middle">การประเมินผลการเรียน</th>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">ชั้น</th>
                                            <th class="align-middle">เลขที่</th>
                                            <th class="align-middle">เลขประจำตัว</th>
                                            <th class="align-middle" width="200">ชื่อ - นามสกุล</th>
                                            <?php 
                                        if(floatval($check_student[0]->SubjectUnit) == 0.5){ $TimeNum = 20; }
                                        elseif(floatval($check_student[0]->SubjectUnit) == 1){$TimeNum = 40;}
                                        elseif(floatval($check_student[0]->SubjectUnit) == 1.5){$TimeNum = 60;}
                                        ?>
                                            <th class="align-middle" width="">เวลาเรียน<br> <small>(<?=intval($TimeNum);?> ชั่วโมง)</small>
                                            </th>
                                            <?php 
                                    $sum_scoer = 0;
                                    foreach ($set_score as $key => $v_set_score): 
                                        $sum_scoer += $v_set_score->regscore_score;
                                    ?>
                                            <th class="h6 align-middle">
                                                <?=$v_set_score->regscore_namework?><br>
                                                (<?=$v_set_score->regscore_score?>)
                                            </th>
                                            <?php endforeach; ?>
                                            <th class="h6 align-middle">คะแนนรวม (<?=$sum_scoer?>)</th>
                                            <th class="h6 align-middle">เกรด</th>
                                            <th class="h6 align-middle">สถานะนักเรียน</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        foreach ($check_student as $key => $v_check_student) :
                                         // echo $v_check_student->Grade;
                                            if($v_check_student->Grade <= 0 && $v_check_student->Grade != 'มส' || $v_check_student->Grade_Type == 'แก้ 0 ร'):  
                                            
                                        ?>
                                        <tr>
                                            <th class="align-middle text-center"><?=$v_check_student->StudentClass?>
                                            </th>
                                            <td class="align-middle text-center fw-bold"><?=$v_check_student->StudentNumber?>
                                            </td>
                                            <td class="align-middle text-center fw-bold"><?=$v_check_student->StudentCode?></td>
                                            <td class="align-middle fw-bold">
                                                <?=$v_check_student->StudentPrefix?><?=$v_check_student->StudentFirstName?>
                                                <?=$v_check_student->StudentLastName?> <br>
                                                <small class="fw-normal"><?=($v_check_student->Grade_Type);?></small> 
                                                <input type="text" class="form-control" id="StudentID"
                                                    name="StudentID[]" value="<?=$v_check_student->StudentID?>" style="display: none;">
                                                <input type="text" class="form-control sr-only" id="SubjectID"
                                                    name="SubjectID" value="<?=$check_student[0]->SubjectID?>" style="display: none;">
                                                <input type="text" class="form-control sr-only" id="RegisterYear"
                                                    name="RegisterYear" value="<?=$check_student[0]->RegisterYear?>" style="display: none;">
                                                <input type="text" class="form-control sr-only" id="TimeNum"
                                                    name="TimeNum" value="<?=$TimeNum?>" style="display: none;">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control study_time KeyEnter"
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
                                                <input type="text" class="form-control check_score KeyEnter"
                                                    check-score-key="<?=$v_set_score->regscore_score?>"
                                                    id="<?=$v_check_student->StudentID?>"
                                                    name="<?=$v_check_student->StudentID?>[]"
                                                    value="<?=$v_check_student->Score100 == "" ? "" : $s[$key]?>"
                                                    <?=$checkOnOff[6]->onoff_status == "off" ? "readonly" : ""?>
                                                    autocomplete="off">
                                            </td>
                                            <?php endforeach; ?>
                                            <td class="align-middle">
                                                <div class="subtot text-center font-weight-bold"></div>
                                            </td>
                                            <td class="align-middle">
                                                <div class="grade text-center font-weight-bold"></div>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php 
                                            if($v_check_student->StudentBehavior == "ปกติ"){ 
                                                echo '<span class="text-success">'.$v_check_student->StudentBehavior.'</span>';
                                            }else{
                                                echo '<span class="text-danger">'.$v_check_student->StudentBehavior.'</span>';
                                            }
                                            ?>
                                            </td>
                                        </tr>
                                        <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-between mt-3">
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-pencil-square me-2"></i>
                                        บันทึกคะแนน</button>
                                    <a href="" class="btn btn-warning"><i class="bi bi-printer me-2"></i>
                                        พิมพ์รายงาน</a>
                                </div>
                            </form>


                        </div>

                    </div>
                </div>
            <?php else: ?>
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center p-5">
                    <h3 class="text-muted mb-4">ไม่มีนักเรียนเรียนซ้ำในรายวิชานี้!</h3>
                    <a class="btn btn-primary mt-3"
                        href="<?=base_url('Admin/Acade/Evaluate/AcademicRepeat');?>">กลับหน้าหลัก</a>
                </div>
            </div>

            <?php endif; ?>





        </div>
    </section>

</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).on('keyup', '.check_score', function() {
    var num = parseInt($(this).val());
    var key = parseInt($(this).attr('check-score-key'));

    if (num > key) {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'คุณกรอกคะแนนเกินคะแนนเก็บ<br>กรุณากรอกคะแนนใหม่',
            showConfirmButton: false,
            timer: 3000
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
                $(this).val("0");
            }
        })
    }
});

$(document).on('keyup', '.study_time', function() {
    var num = parseInt($(this).val());
    var key = parseInt($(this).attr('check-time'));

    if (num > key) {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'คุณกรอกเวลาเรียนเกินกำหนด ' + key + 'ชั่วโมง <br>กรุณากรอกเวลาเรียนใหม่',
            showConfirmButton: false,
            timer: 3000
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
                $(this).val("0");
            }
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
        if (80 * TimeNum / 100 > study_time) {
            $(this).find('.grade').html('มส');
        } else if (Check_ro > 0) {
            $(this).find('.grade').html('ร');
        } else {
            $(this).find('.grade').html(check_grade(sum));
        }
        if (sum >= 50) {
            //    $(this).find('.check_score').attr('readonly','0');
            //    $(this).find('.study_time').attr('readonly','0');
        }
    });
}

function check_grade(sum) {
    if ((sum > 100) || (sum < 0)) {
        var grade = "ไม่สามารถคิดเกรดได้ คะแนนเกิน";
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
        "paging": false, // Disable pagination for this table as it's an input form
        "searching": false, // Disable searching
        "info": false, // Disable "Showing X of Y entries"
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.13.7/i18n/Thai.json"
        }
    });

    // Event listener for study_time changes
    $(document).on('change', '.study_time', function() {
        var $row = $(this).closest('tr');
        var studentId = $row.find('input[name="StudentID[]"]').val();
        var subjectId = $('input[name="SubjectID"]').val(); // SubjectID is outside the loop, so it's a single input
        var registerYear = $('input[name="RegisterYear"]').val(); // RegisterYear is outside the loop, so it's a single input
        var studyTime = $(this).val();

        // Perform AJAX call to save study time
        $.ajax({
            url: '<?= site_url('Admin/Acade/Evaluate/ConAdminSaveScore/update_study_time') ?>', // Placeholder URL
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
                    timer: 1500
                });
                console.log('Study time updated:', response);
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาดในการบันทึกเวลาเรียน',
                    showConfirmButton: false,
                    timer: 1500
                });
                console.error('Error updating study time:', error);
            }
        });
    });

    // Event listener for check_score changes
    $(document).on('change', '.check_score', function() {
        var $row = $(this).closest('tr');
        var studentId = $row.find('input[name="StudentID[]"]').val();
        var subjectId = $('input[name="SubjectID"]').val(); // SubjectID is outside the loop, so it's a single input
        var registerYear = $('input[name="RegisterYear"]').val(); // RegisterYear is outside the loop, so it's a single input
        var scoreValue = $(this).val();
        var scoreIndex = $(this).closest('td').index() - 5; // Assuming score columns start from the 6th column (index 5)

        // Perform AJAX call to save score
        $.ajax({
            url: '<?= site_url('Admin/Acade/Evaluate/ConAdminSaveScore/update_score') ?>', // Placeholder URL
            type: 'POST',
            data: {
                student_id: studentId,
                subject_id: subjectId,
                register_year: registerYear,
                score_index: scoreIndex, // To identify which score in the array
                score_value: scoreValue
            },
            success: function(response) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'บันทึกคะแนนสำเร็จ',
                    showConfirmButton: false,
                    timer: 1500
                });
                console.log('Score updated:', response);
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาดในการบันทึกคะแนน',
                    showConfirmButton: false,
                    timer: 1500
                });
                console.error('Error updating score:', error);
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
