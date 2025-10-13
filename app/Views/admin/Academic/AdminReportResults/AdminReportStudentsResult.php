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

    /* Accordion Item Styling */
    .accordion-item {
        border: 1px solid #dee2e6;
        border-radius: .375rem;
        margin-bottom: 1rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        overflow: hidden; /* Ensures the border-radius is respected by child elements */
    }

    /* Accordion Header (Button) Styling */
    .accordion-button {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #212529;
    }

    /* Styling for the button when it's NOT collapsed (i.e., the accordion item is open) */
    .accordion-button:not(.collapsed) {
        background-color: #4CAF50; /* Reusing the theme's green color */
        color: white;
        box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.125);
    }

    /* Customizing the accordion icon color to be visible on both backgrounds */
    .accordion-button:not(.collapsed)::after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='white'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
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
                    <li class="breadcrumb-item"><a href="<?= site_url('Admin/Home') ?>">หน้าหลัก</a></li>
                    <li class="breadcrumb-item"><a href="javascript:history.back()">รายงานผลการเรียนรายบุคคล</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $stu->StudentPrefix.$stu->StudentFirstName.' '.$stu->StudentLastName ?></li>
                </ol>
            </nav>
            <h3 class="page-title">จัดการข้อมูล<?=$title;?> ของ
                <?=$stu->StudentPrefix.$stu->StudentFirstName.' '.$stu->StudentLastName?> ชั้น
                <?=$stu->StudentClass?></h3>
            <hr class="mb-4">
        </div>

        <div class="mb-5">
            <div class="accordion" id="semesterAccordion">
                <?php 
                asort($scoreYear);
                foreach ($scoreYear as $key_year => $v_scoreYear) : 
                ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading<?= $key_year ?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $key_year ?>" aria-expanded="false" aria-controls="collapse<?= $key_year ?>">
                            ภาคเรียนที่ <?= $v_scoreYear->RegisterYear ?>
                        </button>
                    </h2>
                    <div id="collapse<?= $key_year ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $key_year ?>" data-bs-parent="#semesterAccordion">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card mb-3 mb-md-0">
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
                                    <div class="card">

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
                <?php endforeach; ?>
            </div>
        </div>


    </div>
    <!--//container-fluid-->

<!--//content-->
<?= $this->endSection() ?>
