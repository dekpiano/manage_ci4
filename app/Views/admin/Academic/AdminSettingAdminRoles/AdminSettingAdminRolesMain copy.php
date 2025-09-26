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
<div class="app-wrapper">

    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <section class="cta-section theme-bg-light py-5">
                <div class="container text-center">

                    <h2 class="heading">จัดการข้อมูล<?= isset($title) ? esc($title) : '' ?></h2>
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
                            <option <?= (isset($Manager[0]->admin_rloes_userid) && isset($v_NameTeacher->pers_id) && $Manager[0]->admin_rloes_userid == $v_NameTeacher->pers_id) ? 'selected' : '';?>
                                value="<?= isset($v_NameTeacher->pers_id) ? esc($v_NameTeacher->pers_id) : '' ?>">
                                <?= (isset($v_NameTeacher->pers_prefix) ? esc($v_NameTeacher->pers_prefix) : '').(isset($v_NameTeacher->pers_firstname) ? esc($v_NameTeacher->pers_firstname) : '')." ".(isset($v_NameTeacher->pers_lastname) ? esc($v_NameTeacher->pers_lastname) : '') ?>
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
                            <option <?= (isset($Manager[1]->admin_rloes_userid) && isset($v_NameTeacher->pers_id) && $Manager[1]->admin_rloes_userid == $v_NameTeacher->pers_id) ? 'selected' : '';?>
                                value="<?= isset($v_NameTeacher->pers_id) ? esc($v_NameTeacher->pers_id) : '' ?>">
                                <?= (isset($v_NameTeacher->pers_prefix) ? esc($v_NameTeacher->pers_prefix) : '').(isset($v_NameTeacher->pers_firstname) ? esc($v_NameTeacher->pers_firstname) : '')." ".(isset($v_NameTeacher->pers_lastname) ? esc($v_NameTeacher->pers_lastname) : '') ?>
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
                            <option <?= (isset($Manager[2]->admin_rloes_userid) && isset($v_NameTeacher->pers_id) && $Manager[2]->admin_rloes_userid == $v_NameTeacher->pers_id) ? 'selected' : '';?>
                                value="<?= isset($v_NameTeacher->pers_id) ? esc($v_NameTeacher->pers_id) : '' ?>">
                                <?= (isset($v_NameTeacher->pers_prefix) ? esc($v_NameTeacher->pers_prefix) : '').(isset($v_NameTeacher->pers_firstname) ? esc($v_NameTeacher->pers_firstname) : '')." ".(isset($v_NameTeacher->pers_lastname) ? esc($v_NameTeacher->pers_lastname) : '') ?>
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

                     for ($j=3; $j <= 7; $j++){
                        $AdminID = strval(isset($Manager[$j]->admin_rloes_userid) ? $Manager[$j]->admin_rloes_userid : '');
                                if (!isset($studentTasks[$AdminID])) {
                                    $studentTasks[$AdminID] = [];
                                    $Ex = explode(',',isset($Manager[$j]->admin_rloes_nanetype) ? $Manager[$j]->admin_rloes_nanetype : ''); 
                                    foreach ($Ex as $key => $v_Ex) {
                                        $studentTasks[$AdminID][] = $v_Ex;
                                    }
                                }
        
                    }
                    // print_r($studentTasks);
                    
                ?>
               
                <?php for ($i=3; $i <= 7; $i++):?>
                
                <div class="row g-4 settings-section">
                    <div class="col-12 col-md-4">
                        <h3 class="section-title">เจ้าหน้าที่วิชาการ</h3>
                    </div>
                    <div class="col-12 col-md-8 person">
                        <select class="set_admin" aria-label=".form-select-lg example" id="set_admin<?=$i;?>"
                            name="set_admin" admin-id="<?= isset($Manager[$i]->admin_rloes_id) ? esc($Manager[$i]->admin_rloes_id) : '' ?>">
                            <option value="">กรุณาเลือกหัวหน้างาน</option>
                            <?php  foreach ($NameTeacher as $key => $v_NameTeacher) : ?>
                            <option <?= (isset($Manager[$i]->admin_rloes_userid) && isset($v_NameTeacher->pers_id) && $Manager[$i]->admin_rloes_userid == $v_NameTeacher->pers_id) ? 'selected' : '';?>
                                value="<?= isset($v_NameTeacher->pers_id) ? esc($v_NameTeacher->pers_id) : '' ?>">
                                <?= (isset($v_NameTeacher->pers_prefix) ? esc($v_NameTeacher->pers_prefix) : '').(isset($v_NameTeacher->pers_firstname) ? esc($v_NameTeacher->pers_firstname) : '')." ".(isset($v_NameTeacher->pers_lastname) ? esc($v_NameTeacher->pers_lastname) : '') ?>
                            </option>
                            <?php endforeach; ?>
                        </select>

                        <div class=" mb-3">
                            <?php 
                            $NameWork = ['งานทะเบียน','งานวัดและประเมินผล','งานหลักสูตร']; 
                            
                             foreach ($NameWork as $k_NameWork => $v_NameWork) : 
                                $isChecked = (isset($Manager[$i]->admin_rloes_userid) && isset($studentTasks[$Manager[$i]->admin_rloes_userid]) && in_array($v_NameWork, $studentTasks[$Manager[$i]->admin_rloes_userid])) ? 'checked' : '';
                                ?>
                         
                            <div class="form-check me-3">
                                <input class="form-check-input" type="checkbox" value="<?= esc($v_NameWork) ?>"
                                    id="opt_<?=$i?>_<?=$k_NameWork?>" name="opt[<?=$i?>][]" <?=$isChecked;?>>
                                <label class="form-check-label" for="opt_<?=$i?>_<?=$k_NameWork?>">
                                    <?= esc($v_NameWork) ?>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endfor; ?>


                <hr>

            </div>
        </div>

    </div>
</div>

