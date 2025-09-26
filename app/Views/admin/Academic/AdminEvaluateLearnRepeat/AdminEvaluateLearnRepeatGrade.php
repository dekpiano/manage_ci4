<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
.border-left-primary {
    border-left: .25rem solid #5BC3D5 !important;
}
</style>
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h2 class="heading">จัดการข้อมูล<?=$title;?></h2>
    </div>
    <hr>
    <!--//container-->
    </section>
    <section class="we-offer-area mt-5">
        <div class="container-fluid">

            <?php if($check_student): ?>
            <div class="card">
                <div class="card-body">

                    <div>
                        <div class="form-group row justify-content-center mb-3">
                            <div class="col-md-6 d-flex justify-content-center">
                                <div>
                                    ครูผู้สอน :<br>
                                    รายวิชา :
                                </div>
                                <div class="ms-3">
                                    <?=$Teacher->pers_prefix.$Teacher->pers_firstname.' '.$Teacher->pers_lastname;?><br>
                                    <?=$check_student[0]->SubjectCode.' '.$check_student[0]->SubjectName?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <form class="form_score">

                            <table id="tb_score" class="table table-hover table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th colspan="5">ข้อมูลนักเรียน</th>
                                        <th colspan="7">การประเมินผลการเรียน</th>
                                    </tr>
                                    <tr>
                                        <th>ชั้น</th>
                                        <th>เลขที่</th>
                                        <th>เลขประจำตัว</th>
                                        <th width="200">ชื่อ - นามสกุล</th>
                                        <?php 
                                        if(floatval($check_student[0]->SubjectUnit) == 0.5){ $TimeNum = 20; }
                                        elseif(floatval($check_student[0]->SubjectUnit) == 1){$TimeNum = 40;}
                                        elseif(floatval($check_student[0]->SubjectUnit) == 1.5){$TimeNum = 60;}
                                        ?>
                                        <th width="">เวลาเรียน<br> <small>(<?=intval($TimeNum);?> ชั่วโมง)</small>
                                        </th>
                                        <?php 
                                    $sum_scoer = 0;
                                    foreach ($set_score as $key => $v_set_score): 
                                        $sum_scoer += $v_set_score->regscore_score;
                                    ?>
                                        <th class="h6">
                                            <?=$v_set_score->regscore_namework?><br>
                                            (<?=$v_set_score->regscore_score?>)
                                        </th>
                                        <?php endforeach; ?>
                                        <th class="h6">คะแนนรวม (<?=$sum_scoer?>)</th>
                                        <th class="h6">เกรด</th>
                                        <th class="h6">สถานะนักเรียน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        foreach ($check_student as $key => $v_check_student) :
                                          
                                            if(1==1):  
                                            
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
                                            <input type="text" class="form-control sr-only" id="StudentID"
                                                name="StudentID[]" value="<?=$v_check_student->StudentID?>">
                                            <input type="text" class="form-control sr-only" id="SubjectID"
                                                name="SubjectID" value="<?=$check_student[0]->SubjectID?>">
                                            <input type="text" class="form-control sr-only" id="RegisterYear"
                                                name="RegisterYear" value="<?=$check_student[0]->RegisterYear?>">
                                            <input type="text" class="form-control sr-only" id="TimeNum"
                                                name="TimeNum" value="<?=$TimeNum?>">
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
                                                value="<?=$v_check_student->Score100 == "" ? "0" : $s[$key]?>"
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
                                                echo 
                                                '<span class="text-success">'.$v_check_student->StudentBehavior.'</span>';
                                            }else{
                                                echo 
                                                '<span class="text-danger">'.$v_check_student->StudentBehavior.'</span>';
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
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary "><i class="bi bi-pencil-square"></i>
                                    บันทึกคะแนน</button>
                                <a href="" class="btn btn-warning float-end"><i class="bi bi-printer"></i>
                                    พิมพ์รายงาน</a>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
            <?php else: ?>
            <div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
                <div class="inner">
                    <div class="app-card-body text-center">
                        <h3 class=""> ไม่มีนักเรียน เรียนซ้ำ ในรายวิชานี้!</h3>
                        <a class="btn app-btn-primary"
                            href="#" onclick="javascript:history.go(-1)">กลับหน้าหลัก</a>
                    </div>
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
    // console.log($(this).val());
    //   console.log($(this).attr('check-score-key'));

    if (num > key) {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'คุณกรอกคะแนนเกินคะแนนเก็บ<br>กรุณากรอกคะแนนใหม่',
            showConfirmButton: false,
            timer: 3000
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
                //window.location.reload();
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
                //window.location.reload();
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
        //console.log(sum);
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
        //console.log($(this).parent().index());
    });
});

$(".study_time").each(function() {
    $(this).keyup(function() {
        calculateTotal($(this).parent().index());
        //console.log();
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
    // calculateSum();
    calculateRowSum();
}

$(document).on('submit', '.form_score', function(e) {
    e.preventDefault();

    $.ajax({
        url: '../../../../../../admin/academic/ConAdminAcademicRepeat/insert_score',
        type: "post",
        data: $(this).serialize(), //this is formData
        success: function(data) {
            console.log(data);
            if (data > 0) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'บันทึกคะแนนสำเร็จ',
                    showConfirmButton: false,
                    timer: 2000
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {

                    }
                })
            } else {
                // window.location.reload();
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText);
        }
    });
});
</script>
<?= $this->endSection() ?>
