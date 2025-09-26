<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
.border-left-primary {
    border-left: .25rem solid #5BC3D5 !important;
}

th.rotated-text {
    position: relative;
    height: 200px;
    white-space: nowrap;
    padding: 0 !important;
    overflow: auto;
}

th.rotated-text>div {
    position: absolute;
    top: 100%;
    left: 50%;
    transform: rotate(-90deg) translateY(-50%);
    transform-origin: 0 0;
}

th.rotated-text>div>span {
    display: inline-block;
    padding: 0px 15px;
    padding-left: 5px;
}
</style>
<style>
.fixTableHead {
    overflow-y: auto;
    height: 600px;
}

.fixTableHead thead th {
    position: sticky;
    top: 0;
}

table {
    border-collapse: collapse;
    width: 100%;
}

th,
td {
    padding: 8px 15px;
    border: 2px solid #529432;
}

th {
    background: #ABDD93;
}
</style>
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="app-page-title mb-0"><?= isset($title) ? esc($title) : '' ?> <?= isset($totip) ? esc($totip) : '';?></h1>
        </div>
        <div class="col-auto">
            <div class="page-utilities">
                <div class="row g-2 justify-content-start justify-content-md-end align-items-center">

                    <div class="col-auto">
                        <?php if((service('request')->uri->getSegment(3) ?? '') === "Executive") :?>
                        <form action="<?= site_url('Admin/Acade/Executive/ReportRoom');?>" method="post">
                            <?php else:
                            ?><form action="<?= site_url('Admin/Acade/Evaluate/ReportRoom');?>" method="post">
                                <?php endif; ?>
                                <div class="d-flex">
                                    <div class="col-auto me-2">
                                        <select class="form-select w-auto" name="KeyCheckYear" id="KeyCheckYear">
                                            <option selected="" value="">ปีการศึกษา...</option>
                                            <?php foreach ($CheckYear as $key => $v_CheckYear) : ?>
                                            <option <?= isset($KeyCheckYear) && isset($v_CheckYear->RegisterYear) && $KeyCheckYear == $v_CheckYear->RegisterYear ? 'selected' : ''?>
                                                value="<?= isset($v_CheckYear->RegisterYear) ? esc($v_CheckYear->RegisterYear) : '' ?>">
                                                <?= isset($v_CheckYear->RegisterYear) ? esc($v_CheckYear->RegisterYear) : '' ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <select class="form-select w-auto" name="keyroom" id="keyroom">
                                            <option selected="" value="">ห้อง...</option>
                                            <?php foreach ($this->classroom->ListRoom() as $key => $v_ListRoom) : ?>
                                            <option <?= isset($keyroom) && $keyroom == "ม.".$v_ListRoom ? "selected" : ""?>
                                                value="ม.<?= esc($v_ListRoom) ?>"><?= esc($v_ListRoom) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                    </div>
                    <div class="col-auto">
                        <button class="btn app-btn-primary clickLoder" type="submit">ค้นหา</button>
                    </div>
                    </form>
                </div>
                <!--//row-->
            </div>
            <!--//table-utilities-->
        </div>
        <!--//col-auto-->
    </div>
    <!--//container-->
    </section>
    <section class="we-offer-area">
        <div class="container-fluid">

            <?php if(!isset($Nodata) || $Nodata == 0): ?>
            <div class="card">
                <div class="card-body">
                    <h2 class="text-center">กรุณาเลือกห้องเรียนก่อน...</h2>
                </div>
            </div>
            <?php else: ?>
            <div class="card" style="width: 1600px;">
                <div class="card-body">
                    <div class="table-responsive fixTableHead">
                        <table class="table table-bordered" id="tblGradeSumRoom">
                            <thead>
                                <tr class="text-center table-success">
                                    <th class="cell align-middle" style="width:20px">ลำดับที่</th>
                                    <th class="cell align-middle" style="width:230px">ชื่อ - นามสกุล</th>
                                    <?php foreach ($subject as $key => $v_subject):
                                    ?>
                                    <th class="rotated-text">
                                        <div>
                                            <span>
                                                <?= (isset($v_subject->SubjectUnit) ? esc($v_subject->SubjectUnit) : '').' '.(isset($v_subject->SubjectCode) ? esc($v_subject->SubjectCode) : '').' '.(isset($v_subject->SubjectName) ? esc($v_subject->SubjectName) : '') ?>
                                            </span>
                                        </div>
                                    </th>
                                    <?php endforeach; ?>
                                    <th class="cell align-middle">GPA เกรดเฉลี่ย</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php 
                                // NOTE: This logic should be in the controller
                                foreach ($CheckSub as $key => $v_stu) : 
                                ?>
                                    <tr>
                                        <td class="text-center "> <?= isset($v_stu[1]) ? esc($v_stu[1]) : '' ?></td>
                                        <td class="text-nowrap "><?=
                                        isset($v_stu[2]) ? esc($v_stu[2]) : '' ?></td>
                                        <?php $i = 4;
                                        
                                        foreach ($subject as $key1 => $v_RegisSubject): 
                                            $sub = explode("/", isset($v_stu[$i]) ? $v_stu[$i] : '');
                                        ?>
                                        <td class="text-center">
                                            <div class="showGrade" data_unit="<?= isset($v_RegisSubject->SubjectUnit) ? esc($v_RegisSubject->SubjectUnit) : '' ?>">
                                                <?php echo isset($sub[1]) ? esc($sub[1]) : '';  ?>
                                            </div>
                                        </td>
                                        <?php $i++; endforeach; ?>
                                        <td class="cell totalGrade text-center">

                                        </td> 
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>

    </div>
    </section>

</div>
<?= $this->endSection() ?>
