<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
.border-left-primary {
    border-left: .25rem solid #5BC3D5 !important;
}
</style>
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl d-flex justify-content-between">
        <div class="col-auto justify-content-start">
            <h1 class="app-page-title"><?=$title;?></h1>
        </div>

    </div>
    <!--//container-->
    </section>
    <section class="we-offer-area">
        <div class="container-fluid">

            <?php foreach ($checkSubject as $key => $v_checkSubject) : ?>

            <div class="card mb-3">
                <div class="card-body">
                    <table class="table app-table-hover table-bordered mb-0 text-left" id="">
                        <thead>
                            <tr class="text-center">
                                <th class="cell" colspan="5"><h5><?=$v_checkSubject->SubjectCode?> วิชา <?=$v_checkSubject->SubjectName?></h5> </th>
                                <th class="cell" colspan="4"> <h5>คะแนน</h5>  </th>
                            </tr>
                            <tr class="text-center">
                                <th class="cell">ห้อง</th>
                                <th class="cell">เลขที่</th>
                                <th class="cell">เลขประจำตัว</th>
                                <th class="cell">ชื่อ - นามสกุล</th>
                                <th class="cell">สถานะ</th>
                                <th class="cell">ก่อนกลางภาค</th>
                                <th class="cell">สอบกลางภาค</th>
                                <th class="cell">หลังกลางภาค</th>
                                <th class="cell">สอบปลายภาค</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($CheckScore as $key => $v_CheckScore) : 
                            if($v_checkSubject->SubjectID == $v_CheckScore->SubjectID) :
                               $subScore = explode('|',$v_CheckScore->Score100);?>
                            <tr>
                                <td class="text-center"><?=$v_CheckScore->StudentClass?></td>
                                <td class="text-center"><?=$v_CheckScore->StudentNumber?></td>
                                <td class="text-center"><?=$v_CheckScore->StudentCode?></td>
                                <td><?=$v_CheckScore->StudentPrefix?><?=$v_CheckScore->StudentFirstName?>
                                    <?=$v_CheckScore->StudentLastName?></td>
                                <td class="text-center"><?=$v_CheckScore->StudentBehavior?></td>
                                <td class="text-center"><?=@$subScore[0]?></td>
                                <td class="text-center"><?=@$subScore[1]?></td>
                                <td class="text-center"><?=@$subScore[2]?></td>
                                <td class="text-center"><?=@$subScore[3]?></td>
                            </tr>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endforeach; ?>

        </div>

</div>
</section>

</div>
<?= $this->endSection() ?>
