<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
    .card-header-custom {
        background-color: #4CAF50; /* A more subdued green */
        color: white;
        font-weight: bold;
        text-align: center;
    }
    .table-footer-summary {
        background-color: #e9ecef; /* Light gray for summary row */
        font-weight: bold;
    }
    .table th, .table td {
        vertical-align: middle;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.03);
    }
    .text-right-align {
        text-align: right;
    }
</style>
<?php 
        $AllUnit = 0; $AllGrade = 0; 
        foreach ($scoreYear as $key_year => $v_scoreYear) {
            $SubGrade = 0;
            foreach ($scoreStudent as $key => $score ){
                if($v_scoreYear->RegisterYear == $score->RegisterYear && $v_scoreYear->RegisterYear == $score->SubjectYear){
                    $AllUnit += floatval(floatval($score->SubjectUnit));
                    if($score->Grade == 'ร' || $score->Grade == 'มส' || $score->Grade == ''){
                        $SubGrade += (floatval($score->SubjectUnit)*0);
                    }else{
                        if(floatval($score->Score100) == ''){
                            $SubGrade += ((floatval($score->SubjectUnit))*($score->Grade));
                        }else{
                            $SubGrade += ((floatval($score->SubjectUnit))*($score->Grade));
                        }
                    }
                }
               
            }$AllGrade += $SubGrade; 
            //echo $AllUnit.'<br>'; 
            
        }            
        ?>


    <div class="">
        <div class="">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= site_url('admin') ?>">หน้าหลัก</a></li>
                    <li class="breadcrumb-item"><a href="<?= site_url('Admin/Acade') ?>">งานวิชาการ</a></li>
                    <li class="breadcrumb-item"><a href="<?= site_url('Admin/Acade/Evaluate') ?>">รายงานผล</a></li>
                    <li class="breadcrumb-item active" aria-current="page">ผลการเรียนนักเรียนรายบุคคล</li>
                </ol>
            </nav>
            <h3 class="page-title">จัดการข้อมูล<?=$title;?> ของ
                <?=$stu->StudentPrefix.$stu->StudentFirstName.' '.$stu->StudentLastName?> ชั้น
                <?=$stu->StudentClass?></h3>
            <hr class="mb-4">
        </div>

        <div class="mb-5">
            <div class="row">
                <?php asort($scoreYear);
            
            foreach ($scoreYear as $key_year => $v_scoreYear) : 
            
            ?>
                <div class="col-md-12">
                    <div class="card mb-5">
                        <div class="card-header card-header-custom">
                            ภาคเรียนที่
                            <?=$v_scoreYear->RegisterYear?>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card mb-5">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-striped">
                                                <thead class="bg-light">
                                                    <tr class="text-center table-success">
                                                        <th scope="col">รหัสวิชา</th>
                                                        <th scope="col">ชื่อวิชา</th>
                                                        <th scope="col">ประเภท</th>
                                                        <th scope="col" class="text-right-align">หน่วยกิต</th>
                                                        <th scope="col" class="text-center">เกรด</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php  $SumUnit = 0; $SumGrade = 0; $scoreLevel=0; $CountSubjectAll = 0;
                                    foreach ($scoreStudent as $key => $score ):                                         
                                    if($v_scoreYear->RegisterYear == $score->RegisterYear && $v_scoreYear->RegisterYear == $score->SubjectYear):
                                        $c = floatval($score->Score100);
                                        $type = explode("/",$score->SubjectType);
                                        $CountSubjectAll += 1;
                                     ?>
                                                    <tr>
                                                        <th scope="row"><?=$score->SubjectCode;?></th>
                                                        <td><?=$score->SubjectName;?></td>
                                                        <td class="text-center"><?=$type[1]?></td>
                                                        <td class="text-right-align">
                                                            <?=number_format(floatval($score->SubjectUnit),1);?>
                                                        </td>

                                                        <?php if($score->Grade == 'ร' || $score->Grade == 'มส' || $score->Grade == ''){ ?>
                                                        <td class="text-center"><?=$score->Grade?></td>
                                                        <?php }else{ ?>
                                                        <td class="text-center"><?=$score->Grade?></td>
                                                        <?php } ?>


                                                    </tr>
                                                    <?php $SumUnit += floatval($score->SubjectUnit);
                                    if($score->Grade == 'ร' || $score->Grade == 'มส' || $score->Grade == ''){
                                        $scoreLevel += (floatval($score->SubjectUnit)*0);
                                        $SumGrade += (floatval($score->SubjectUnit)*0);
                                    }else{
                                        if(floatval($score->Score100) == ''){
                                            $SumGrade += ((floatval($score->SubjectUnit))*($score->Grade));
                                        }else{
                                            $scoreLevel += floatval($score->Score100);
                                            $SumGrade += ((floatval($score->SubjectUnit))*($score->Grade));
                                        }
                                    }
                                     endif; 
                                     endforeach;?>
                                                   <tr class="text-center table-footer-summary">
                                                    <th ></th>
                                                    <th >วิชาทั้งหมด <?=$CountSubjectAll;?> วิชา</th>
                                                    <th colspan=2 class="text-right-align">หน่วยกิตทั้งหมด <?=$SumUnit;?></th>
                                                    <th class="text-center">
                                                        <?= ($SumUnit != 0) ? substr($SumGrade/$SumUnit,0,4) : 'N/A' ;?>
                                                    </th>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card mb-5">

                                        <table class="table">
                                            <thead class="text-center table-success">
                                                <tr>
                                                    <th colspan="3">กิจกรรมพัฒนาผู้เรียน</th>
                                                </tr>
                                                <tr>
                                                    <th scope="col">กิจกรรม</th>
                                                    <th scope="col">ผลการประเมิน</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>กิจกรรมแนะแนว</th>
                                                    <td class="text-center"><span class="text-success">ผ่าน</span>
                                                    </td>
                                                </tr>
                                                <?php if($stu->StudentClass <= 'ม.4/1') : ?>
                                                <tr>
                                                    <th scope="row">ลูกเสือ/เนตรนารี/ยุวฯ/บพ.</th>
                                                    <td class="text-center">
                                                        <?php 
                                                                if(in_array($stu->StudentCode,$checkChunum)){
                                                                    echo '<span class="text-danger">ไม่ผ่าน</span>';
                                                                }else{
                                                                    echo '<span class="text-success">ผ่าน</span>';
                                                                }
                                                            ?>
                                                    </td>
                                                </tr>
                                                <?php endif; ?>
                                                <tr>
                                                    <th scope="row">กิจรรมชุมชน</th>
                                                    <td class="text-center">
                                                        <?php 
                                                                if(in_array($stu->StudentCode,$checkRuksun)){
                                                                    echo '<span class="text-danger">ไม่ผ่าน</span>';
                                                                }else{
                                                                    echo '<span class="text-success">ผ่าน</span>';
                                                                }
                                                            ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>กิจกรรมเพื่อสังคม</th>
                                                    <td class="text-center"><span class="text-success">ผ่าน</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php  endforeach;?>
            </div>

        </div>


    </div>
    <!--//container-fluid-->

<!--//content-->
<?= $this->endSection() ?>
