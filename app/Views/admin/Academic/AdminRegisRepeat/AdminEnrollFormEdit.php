<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
.border-left-primary {
    border-left: .25rem solid #5BC3D5 !important;
}

.ss-main .ss-single-selected {
    height: 40px;
}
</style>
<div class="container-xl">
    <div class="app-content pt-3 p-md-3 p-lg-4">


        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">จัดการข้อมูล<?=$title;?></h1>
            </div>
            <div class="col-auto">
                <div class="page-utilities">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?=base_url('Admin/Acade/Registration/Enroll')?>">หน้าหลัก</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><?=$title;?></li>
                        </ol>
                    </nav>
                </div>
                <!--//table-utilities-->
            </div>
        </div>
        <!--//row-->

        </section>
        <hr class="mb-4">
        <section class="we-offer-area">
            <form id="FormEnrollUpdate" class="needs-validation" method="post" novalidate>

                <div class="row g-4 settings-section">
                    <div class="col-12 col-md-4">
                        <h3 class="section-title">วิชาเรียน</h3>
                        <div class="section-intro">ให้เลือกวิชาเรียนที่ลงทะเบียน </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="app-card app-card-settings shadow-sm p-4">
                            <div class="app-card-body">
                            <?=$Register[0]->SubjectCode?> <?=$Register[0]->SubjectName?>
                                <input type="hidden" name="subjectregisupdate" id="subjectregisupdate"
                                    value="<?=$Register[0]->SubjectID?>">
                                <div class="invalid-feedback">
                                    กรุณาเลือกวิชาเรียน
                                </div>
                            </div>
                            <!--//app-card-body-->

                        </div>
                        <!--//app-card-->
                    </div>
                </div>
                <hr class="mb-4">
                <div class="row g-4 settings-section">
                    <div class="col-12 col-md-4">
                        <h3 class="section-title">ครูผู้สอน</h3>
                        <div class="section-intro">ให้เลือกครูผู้สอนในวิชาที่ลงทะเบียน </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="app-card app-card-settings shadow-sm p-4">
                            <div class="app-card-body">
                                <select name="teacherregis" id="teacherregis" class="teacherregis" required>
                                    <option value="">เลือกครูผู้สอน</option>
                                    <?php foreach ($teacher as $key => $v_teacher): ?>
                                    <option <?=$v_teacher->pers_id == $Register[0]->TeacherID? "selected" : ""?>
                                        value="<?=$v_teacher->pers_id?>">
                                        <?=$v_teacher->pers_prefix.$v_teacher->pers_firstname.' '.$v_teacher->pers_lastname?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    กรุณาเลือกคุณครู
                                </div>
                            </div>
                            <!--//app-card-body-->

                        </div>
                        <!--//app-card-->
                    </div>
                </div>

                <hr class="mb-4">
                <div class="row g-4 settings-section">
                    <div class="col-12 col-md-4">
                        <h3 class="section-title">นักเรียน</h3>
                        <div class="section-intro">
                            ให้เลือกนักเรียนที่จะเรียนในวิชาที่ลงทะเบียน
                            <p>
                                - ให้เลือกห้องเรียนก่อน <br>
                                - เลือกนักเรียนจากด้านซ้าย เลือกไปด้านขวา <br>
                                - ** สามารถเลือกนักเรียนกี่ห้องก็ได้ ให้เลือกห้องเรียนใหม่เท่านั้นเอง
                            </p>

                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="app-card app-card-settings shadow-sm p-4">
                            <div class="app-card-body">
                                <select name="RoomEdit" id="RoomEdit" class="mb-3 w-auto" required>
                                    <option value="">เลือกห้องเรียน</option>
                                    <?php $ListRoom = $this->classroom->ListRoom();
                                    foreach ($ListRoom as $key => $v_ListRoom): ?>
                                    <option value="<?=$v_ListRoom?>">
                                        ม.<?=$v_ListRoom?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    กรุณาเลือห้องเรียน
                                </div>
                                <!-- <div class="table-responsive">
                                <table class="table mb-0 text-left" id="TB_showStudent">
                                    <thead>
                                        <tr>
                                            <th class="cell">เลือก</th>
                                            <th class="cell">เลขนักเรียน</th>
                                            <th class="cell">ชื่อ - สกุล</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div> -->

                                <div class="row mt-3">
                                    
                                    <div class="col-lg-5">
                                    <p>รายชื่อนักเรียน</p>
                                        <select name="from[]" id="multiselect" class="form-control" size="20"
                                            multiple="multiple" style="height:20rem">
                                        </select>
                                    </div>

                                    <div class="col-lg-2 align-self-center">
                                   
                                        <button type="button" id="multiselect_rightAll"
                                            class="btn btn-primary w-100 mb-1">เลือกทั้งหมด</button>
                                        <button type="button" id="multiselect_rightSelected"
                                            class="btn btn-primary w-100 mb-1">เลือก</i></button>
                                        <button type="button" id="multiselect_leftSelected"
                                            class="btn btn-primary w-100 mb-1">ลบ</button>
                                        <button type="button" id="multiselect_leftAll"
                                            class="btn btn-primary w-100 mb-1">ยกเลิกทั้งหมด</button>
                                    </div>

                                    <div class="col-lg-5">
                                    <p>รายชื่อนักเรียนที่เพิ่งเข้ามาใหม่</p>
                                        <select name="to[]" id="multiselect_to" class="form-control" size="8"
                                            required multiple="multiple" style="height:20rem">
                                            <!-- <?php foreach ($Register as $key => $v_Register) : ?>
                                            <option value="<?=$v_Register->StudentID?>"> <?=$v_Register->StudentClass?> <?=sprintf("%02d",$v_Register->StudentNumber)?>  <?=$v_Register->StudentPrefix.$v_Register->StudentFirstName.' '.$v_Register->StudentLastName?></option>
                                            <?php endforeach; ?> -->
                                        </select>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <button type="button" id="multiselect_move_up"
                                                    class="btn btn-block"><i
                                                        class="glyphicon glyphicon-arrow-up"></i></button>
                                            </div>
                                            <div class="col-lg-6">
                                                <button type="button" id="multiselect_move_down"
                                                    class="btn btn-block col-sm-6"><i
                                                        class="glyphicon glyphicon-arrow-down"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--//app-card-body-->
                        </div>
                        <!--//app-card-->
                        <div class="mt-3">
                            <button type="submit" class="btn btn-success w-100">บันทึก</button>
                        </div>

                    </div>
                </div>

    </div>
    </form>
    <!--//container-->
    </section>

</div>
</div>
<?= $this->endSection() ?>
