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
<div class="">
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h3 class="page-title mb-0"><?= isset($title) ? esc($title) : '' ?> <?= isset($totip) ? esc($totip) : '';?>
            </h3>
        </div>
        <div class="col-auto">
            <div class="page-utilities">
                <div class="row g-2 justify-content-start justify-content-md-end align-items-center">

                    <div class="card p-2">
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
                                                <option
                                                    <?= isset($KeyCheckYear) && isset($v_CheckYear->RegisterYear) && $KeyCheckYear == $v_CheckYear->RegisterYear ? 'selected' : ''?>
                                                    value="<?= isset($v_CheckYear->RegisterYear) ? esc($v_CheckYear->RegisterYear) : '' ?>">
                                                    <?= isset($v_CheckYear->RegisterYear) ? esc($v_CheckYear->RegisterYear) : '' ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-auto me-2">
                                            <select class="form-select w-auto" name="keyroom" id="keyroom">
                                                <option selected="" value="">ห้อง...</option>
                                                <?php foreach ($Room as $key => $v_ListRoom) : ?>
                                                <option
                                                    <?= isset($keyroom) && $keyroom == "ม.".$v_ListRoom ? "selected" : ""?>
                                                    value="ม.<?= esc($v_ListRoom) ?>"><?= esc($v_ListRoom) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                    <div class="col-auto">
                        <button class="btn btn-primary clickLoder" type="submit"><i class="bx bx-search me-2"></i>ค้นหา</button>
                    </div>

                    </form>

                        </div>

                    </div>

                    
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
        <div class="">

            <?php if(!isset($Nodata) || $Nodata == 0): ?>
            <div class="card">
                <div class="card-body">
                    <h2 class="text-center">กรุณาเลือกห้องเรียนก่อน...</h2>
                </div>
            </div>
            <?php else: ?>
            <div class="card">
                <div class="card-body">
                    <div class="fixTableHead">
                        <table class="table table-bordered" id="tblGradeSumRoom">
                            <thead>
                                <tr class="text-center table-success">
                                    <th class="cell align-middle" style="width:20px">ลำดับที่</th>
                                    <th class="cell align-middle" style="width:230px">ชื่อ - นามสกุล</th>
                                    <?php if (empty($subject)): ?>
                                    <th class="cell align-middle" colspan="20">
                                        ไม่พบรายวิชาสำหรับปีการศึกษาและห้องเรียนที่เลือก</th>
                                    <?php else: ?>
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
                                    <?php endif; ?>
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
                                        <div class="showGrade"
                                            data_unit="<?= isset($v_RegisSubject->SubjectUnit) ? esc($v_RegisSubject->SubjectUnit) : '' ?>">
                                            <?php echo isset($sub[1]) ? esc($sub[1]) : '';  ?>
                                        </div>
                                    </td>
                                    <?php $i++; endforeach; ?>
                                    <td class="cell totalGrade text-center">
                                        <?= number_format(end($v_stu), 2); ?>
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

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Only initialize DataTable if the table exists and has data
    if ($.fn.DataTable.isDataTable('#tblGradeSumRoom')) {
        $('#tblGradeSumRoom').DataTable().destroy();
    }
    
    $('#tblGradeSumRoom').DataTable({
        "order": [
            [0, "asc"]
        ],
        dom: '<"row"<"col-md-6"B><"col-md-6"f>>rtip',
        buttons: [
            { extend: 'copy', className: 'btn btn-secondary me-1' },
            { extend: 'excelHtml5', className: 'btn btn-success me-1' },
            { extend: 'pdf', className: 'btn btn-danger me-1' },
            { extend: 'print', className: 'btn btn-info me-1' }
        ],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        pageLength: -1,
        autoWidth: false // Disable autoWidth for better responsiveness
    });
});
</script>
<?= $this->endSection() ?>