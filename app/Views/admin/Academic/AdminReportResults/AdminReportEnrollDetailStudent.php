<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0"><?=$title?></h1>
            </div>               
        </div>
        <!--//row-->
        <div class="row mb-5 p-2 ">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center"> 
                            <img
                                src="https://admission.skj.ac.th/uploads/recruitstudent/m<?=$recruit_regLevel?>/img/<?=$recruit_img?>" alt="Admin"
                                class="rounded-circle" width="150">
                            <div class="mt-3">
                                <h4><?=$DataStudent->stu_prefix.$DataStudent->stu_fristName.' '.$DataStudent->stu_lastName?></h4>
                                <p class="text-secondary mb-1"><?=$DataStudent->stu_nickName?></p>
                                <p class="btn btn-primary"><?=$DataStudent->stu_phone?></p>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">ชื่อ - นามสกุลจริง</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> <?=$DataStudent->stu_prefix.$DataStudent->stu_fristName.' '.$DataStudent->stu_lastName?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">วัน เดือน เกิด</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"><?=$DataStudent->stu_birthDay?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">สถานที่เกิด</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> 
                                <?=$DataStudent->stu_birthHospital?>
                                ตำบล <?=$DataStudent->stu_birthTambon?>
                                อำเภอ <?=$DataStudent->stu_birthDistrict?>
                                จังหวัด <?=$DataStudent->stu_birthProvirce?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">รหัสประจำตัวประชาชน 13 หลัก</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> <?=$DataStudent->stu_iden?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">เชื้อชาติ</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> <?=$DataStudent->stu_nationality?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">สัญชาติ</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> <?=$DataStudent->stu_race?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">ศาสนา</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> <?=$DataStudent->stu_religion?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">กรุ๊ปเลือด</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> <?=$DataStudent->stu_bloodType?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">โรคประจำตัว</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> <?=$DataStudent->stu_diseaes?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">จำนวนพี่น้อง (รวมตัวเอง)</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> <?=$DataStudent->stu_numberSibling?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">เป็นลูกคนที่</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> <?=$DataStudent->stu_firstChild?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">มีพี่น้องโรงเรียนเดียวกัน</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> <?=$DataStudent->stu_numberSiblingSkj?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">ชื่อเล่น</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> <?=$DataStudent->stu_nickName?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">ความพิการ</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> <?=$DataStudent->stu_disablde?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">น้ำหนัก</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> <?=$DataStudent->stu_wieght?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">ส่วนสูง</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> <?=$DataStudent->stu_hieght?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">ความสามารถพิเศษ</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> <?=$DataStudent->stu_talent?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">สภาพบิดา - มารดา</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> <?=$DataStudent->stu_parenalStatus?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">สภาพความเป็นอยู่ปัจจุบัน</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> <?=$DataStudent->stu_presentLife?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">ที่อยู่ตามทะเบียนบ้าน</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">                                   
                                บ้านเลขที่ <?=$DataStudent->stu_hNumber?>
                                หมู่ <?=$DataStudent->stu_hMoo?>
                                ถนน <?=$DataStudent->stu_hRoad?>
                                ต.<?=$DataStudent->stu_hTambon?>
                                อ.<?=$DataStudent->stu_hDistrict?>
                                จ.<?=$DataStudent->stu_hProvince?>
                                <?=$DataStudent->stu_hPostCode?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">โทรศัพท์ (นักเรียน)</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> <?=$DataStudent->stu_phone?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">ที่อยู่ปัจจุบัน</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> 
                            บ้านเลขที่ <?=$DataStudent->stu_cNumber?>
                                หมู่ <?=$DataStudent->stu_cMoo?>
                                ถนน <?=$DataStudent->stu_cRoad?>
                                ต.<?=$DataStudent->stu_cTumbao?>
                                อ.<?=$DataStudent->stu_cDistrict?>
                                จ.<?=$DataStudent->stu_cProvince?>
                                <?=$DataStudent->stu_cPostcode?>
                            </div>
                        </div>                           
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">ลักษณะที่พัก</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> <?=$DataStudent->stu_natureRoom?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">ระยะทางห่างจากโรงเรียน</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> <?=$DataStudent->stu_farSchool?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">เดินทางโดย</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> <?=$DataStudent->stu_travel?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">จบการศึกษาชั้น</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> <?=$DataStudent->stu_gradLevel?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">จากโรงเรียน</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> 
                                <?=$DataStudent->stu_schoolfrom?>
                                ต.<?=$DataStudent->stu_schoolTambao?>
                                อ.<?=$DataStudent->stu_schoolDistrict?>
                                จ.<?=$DataStudent->stu_schoolProvince?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">เคยเป็นนักเรียน สกจ.</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> <?=$DataStudent->stu_usedStudent?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">โทรศัพท์ติดต่อฉุกเฉิน</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> <?=$DataStudent->stu_phoneUrgent?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">โทรศัพท์เพื่อนบ้านใกล้เคียง</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"> <?=$DataStudent->stu_phoneFriend?></div>
                        </div>
                    </div>
                </div>
              
            </div>
        </div>


    </div>
    <!--//container-fluid-->
</div>
<!--//app-content-->
<?= $this->endSection() ?>
