<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
.switchToggle input[type=checkbox] {
    height: 0;
    width: 0;
    visibility: hidden;
    position: absolute;
}

.switchToggle label {
    cursor: pointer;
    text-indent: -9999px;
    width: 70px;
    max-width: 70px;
    height: 30px;
    background: #d1d1d1;
    display: block;
    border-radius: 100px;
    position: relative;
}

.switchToggle label:after {
    content: '';
    position: absolute;
    top: 2px;
    left: 2px;
    width: 26px;
    height: 26px;
    background: #fff;
    border-radius: 90px;
    transition: 0.3s;
}

.switchToggle input:checked+label,
.switchToggle input:checked+input+label {
    background: #3e98d3;
}

.switchToggle input+label:before,
.switchToggle input+input+label:before {
    content: 'ปิด';
    position: absolute;
    top: 5px;
    left: 35px;
    width: 26px;
    height: 26px;
    border-radius: 90px;
    transition: 0.3s;
    text-indent: 0;
    color: #fff;
}

.switchToggle input:checked+label:before,
.switchToggle input:checked+input+label:before {
    content: 'เปิด';
    position: absolute;
    top: 5px;
    left: 10px;
    width: 26px;
    height: 26px;
    border-radius: 90px;
    transition: 0.3s;
    text-indent: 0;
    color: #fff;
}

.switchToggle input:checked+label:after,
.switchToggle input:checked+input+label:after {
    left: calc(100% - 2px);
    transform: translateX(-100%);
}

.switchToggle label:active:after {
    width: 60px;
}

.toggle-switchArea {
    margin: 10px 0 10px 0;
}

.ss-main .ss-single-selected {
    height: 50px;
    padding-left: 12px;
    font-size: 1.2rem;
}
</style>
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <section class="cta-section theme-bg-light py-5">
            <div class="container text-center">

                <h2 class="heading">จัดการข้อมูล<?=$title;?></h2>
            </div>
            <!--//container-->
        </section>
        <div class="container-xl">
            <div class="row g-4 settings-section">
                <div class="col-12 col-md-4">
                    <h3 class="section-title">ผู้อำนวยการ</h3>
                </div>
                <div class="col-12 col-md-8">
                    <select class="mb-3" aria-label=".form-select-lg example" id="set_executive"
                        name="set_executive">
                        <option value="">กรุณาเลือกหัวหน้างาน</option>
                        <?php  foreach ($NameTeacher as $key => $v_NameTeacher) : ?>
                        <option <?=$Manager[0]->admin_rloes_userid == $v_NameTeacher->pers_id ? 'selected' : '';?>
                            value="<?=$v_NameTeacher->pers_id?>">
                            <?=$v_NameTeacher->pers_prefix.$v_NameTeacher->pers_firstname." ".$v_NameTeacher->pers_lastname?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <hr>

            <div class="row g-4 settings-section">
                <div class="col-12 col-md-4">
                    <h3 class="section-title">รองฯ วิชาการ</h3>
                </div>
                <div class="col-12 col-md-8">
                    <select class="mb-3" aria-label=".form-select-lg example" id="set_deputy" name="set_deputy">
                        <option value="">กรุณาเลือกหัวหน้างาน</option>
                        <?php  foreach ($NameTeacher as $key => $v_NameTeacher) : ?>
                        <option <?=$Manager[1]->admin_rloes_userid == $v_NameTeacher->pers_id ? 'selected' : '';?>
                            value="<?=$v_NameTeacher->pers_id?>">
                            <?=$v_NameTeacher->pers_prefix.$v_NameTeacher->pers_firstname." ".$v_NameTeacher->pers_lastname?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <hr>


            <div class="row g-4 settings-section">
                <div class="col-12 col-md-4">
                    <h3 class="section-title">หัวหน้างานวิชาการ</h3>
                </div>
                <div class="col-12 col-md-8">
                    <select class="mb-3" aria-label=".form-select-lg example" id="set_leader" name="set_leader">
                        <option value="">กรุณาเลือกหัวหน้างาน</option>
                        <?php  foreach ($NameTeacher as $key => $v_NameTeacher) : ?>
                        <option <?=$Manager[2]->admin_rloes_userid == $v_NameTeacher->pers_id ? 'selected' : '';?>
                            value="<?=$v_NameTeacher->pers_id?>">
                            <?=$v_NameTeacher->pers_prefix.$v_NameTeacher->pers_firstname." ".$v_NameTeacher->pers_lastname?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <hr>

            <?php   $studentTasks = [];

                        // $studentTasks = [
                        //     'pers_073' => ['งานทะเบียน'],
                        //     'pers_049' => ['งานทะเบียน'],
                        //     'pers_015' => ['งานทะเบียน', 'งานวัดและประเมินผล']
                        // ];

                        foreach ($Manager as $k_Manager => $v_Manager){
                            if($v_Manager->admin_rloes_status === "admin"){
                                $AdminID = strval($Manager[$k_Manager]->admin_rloes_userid);
                                if (!isset($studentTasks[$AdminID])) {
                                    $studentTasks[$AdminID] = [];
                                    
                                }
                                $db_value = $Manager[$k_Manager]->admin_rloes_nanetype;
                                $Ex = explode('|',$db_value);                              
                                    foreach ($Ex as $key => $v_Ex) {
                                        $studentTasks[$AdminID][] = $v_Ex;
                                    }
                            }
                            
                        }
                        
                            //print_r($studentTasks);
                    
                ?>

                <?php foreach ($Manager as $k_Manager => $v_Manager):
                    if($v_Manager->admin_rloes_status === "admin"):
                ?>

                <div class="row g-4 settings-section">
                    <div class="col-12 col-md-4">
                        <h3 class="section-title">เจ้าหน้าที่วิชาการ</h3>
                    </div>
                    <div class="col-12 col-md-8 person">
                        <select class="set_admin" aria-label=".form-select-lg example" id="set_admin<?=$k_Manager;?>"
                            name="set_admin" admin-id="<?=$v_Manager->admin_rloes_id;?>">
                            <option value="">กรุณาเลือกหัวหน้างาน</option>
                            <?php  foreach ($NameTeacher as $key => $v_NameTeacher) : ?>
                            <option <?=$v_Manager->admin_rloes_userid == $v_NameTeacher->pers_id ? 'selected' : '';?>
                                value="<?=$v_NameTeacher->pers_id?>">
                                <?=$v_NameTeacher->pers_prefix.$v_NameTeacher->pers_firstname." ".$v_NameTeacher->pers_lastname?>
                            </option>
                            <?php endforeach; ?>
                        </select>

                        <div class="d-flex mb-3">
                            <div class="me-3">
                            <b>งานหลัก : </b>
                            </div>
                        
                            <?php 
                            $NameWork = ['งานทะเบียน','งานวัดและประเมินผล','งานหลักสูตร','งานพัฒนาผู้เรียน']; 
                            
                             foreach ($NameWork as $k_NameWork => $v_NameWork) : 
                                $k_ManagersChecked = isset($studentTasks[$v_Manager->admin_rloes_userid]) && in_array($v_NameWork, $studentTasks[$v_Manager->admin_rloes_userid]) ? 'checked' : '';
                                ?>

                            <div class="form-check me-3">                               
                                <input class="form-check-input" type="checkbox" value="<?=$v_NameWork;?>"
                                    id="opt_<?=$k_Manager?>_<?=$k_NameWork?>" name="opt[<?=$k_Manager?>][]"
                                    <?=$k_ManagersChecked;?>>
                                <label class="form-check-label" for="opt_<?=$k_Manager?>_<?=$k_NameWork?>">
                                    <?=$v_NameWork;?>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <?php endif; ?>
                <?php endforeach; ?>


                <hr>

            </div>
        </div>

    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    // ใช้ querySelectorAll เพื่อเลือกทุก select ที่มี class .my-select
    document.querySelectorAll('.set_admin').forEach(function(selectElement) {
        new SlimSelect({
            select: selectElement
        });
    });
    
    // ฟังก์ชันเพื่อส่งข้อมูลไปยังเซิร์ฟเวอร์
    function sendData() {
        // สร้างอาเรย์เก็บค่าที่เลือกสำหรับทุกบุคคล
        var selectedOptions = {};
        
        // ตรวจสอบ checkbox ที่ถูกติ๊กสำหรับแต่ละกลุ่ม
        $('div.person').each(function(index) {
            var options = [];
            var mainKey = $(this).find('.set_admin').val();
            // วนลูปตรวจสอบทุก checkbox ภายใน div.person แต่ละกลุ่ม
            $(this).find('input[type="checkbox"]').each(function() {
                if ($(this).is(':checked')) {
                    // ถ้า checkbox ถูกติ๊ก เก็บค่าปกติ
                    options.push($(this).val());
                } else {
                    // ถ้า checkbox ไม่ถูกติ๊ก ให้เก็บค่าเป็น 0
                   // options.push('x');
                }
            });

            selectedOptions[index] = {
                mainKey: mainKey, // เก็บ key หลัก
                options: options // เก็บข้อมูลสำหรับ checkbox
            };
        });
        
        
        // ส่งค่าผ่าน AJAX
        $.ajax({
            url: '../../../admin/academic/ConAdminSettingAdminRoles/SelectWork', // แทนที่ด้วย URL ของเซิร์ฟเวอร์ที่คุณต้องการส่งข้อมูล
            type: 'POST',
            data: {option: selectedOptions},
            success: function(response) {
                // ทำการจัดการกับการตอบกลับจากเซิร์ฟเวอร์
                console.log('Response from server:', response);
            },
            error: function(xhr, status, error) {
                // จัดการกับข้อผิดพลาด
                console.error('AJAX Error:', xhr.responseText);
            }
        });
    }

// ตรวจสอบ checkbox เมื่อมีการเปลี่ยนแปลง
    $('input[type="checkbox"],.set_admin').change(function() {
        sendData(); // เรียกใช้ฟังก์ชันเพื่อส่งข้อมูล
    });
</script>
<?= $this->endSection() ?>