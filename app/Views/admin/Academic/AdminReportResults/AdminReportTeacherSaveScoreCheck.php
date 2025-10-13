<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
.border-left-primary {
    border-left: .25rem solid #5BC3D5 !important;
}
</style>
<div class="">
    <div class="d-flex justify-content-between">
        <div class="col-auto justify-content-start">
            <a href="javascript:history.back()" class="btn btn-secondary"><i class="bx bx-arrow-back me-2"></i> ย้อนกลับ</a>
            <h3 class="app-page-title d-inline-block ms-2"><?=$title;?></h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" onclick="history.back(); return false;">หน้าหลัก</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?=$title;?></li>
                </ol>
            </nav>
        </div>

    </div>

    <div class="row g-2 align-items-center mb-3">
        <div class="col-auto">
            <label for="readOnlyYear" class="form-label fw-bold">ปีการศึกษาที่เลือก:</label>
        </div>
        <div class="col-auto">
            <input type="text" id="readOnlyYear" class="form-control" readonly value="<?= esc($Term) ?>/<?= esc($Year) ?>">
        </div>
    </div>

    <!--//container-->
    </section>
    <section class="we-offer-area">
        <div class="">

            <div class="accordion" id="subjectAccordion">
                <?php foreach ($checkSubject as $key => $v_checkSubject) : ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading<?= $key ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $key ?>" aria-expanded="false" aria-controls="collapse<?= $key ?>">
                                <h5><?= $v_checkSubject->SubjectCode ?> วิชา <?= $v_checkSubject->SubjectName ?></h5>
                            </button>
                        </h2>
                        <div id="collapse<?= $key ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $key ?>" data-bs-parent="#subjectAccordion">
                            <div class="accordion-body">
                                <table class="table table-hover table-bordered mb-0 text-left">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="cell">เลขประจำตัว</th>
                                            <th class="cell">ระดับชั้น</th>
                                            <th class="cell">ชื่อ - นามสกุล</th>
                                            <th class="cell">สถานะ</th>
                                            <th class="cell">ก่อนกลางภาค</th>
                                            <th class="cell">สอบกลางภาค</th>
                                            <th class="cell">หลังกลางภาค</th>
                                            <th class="cell">สอบปลายภาค</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $foundScores = false;
                                        foreach ($CheckScore as $v_CheckScore) :
                                            if ($v_checkSubject->SubjectID == $v_CheckScore->SubjectID) :
                                                $foundScores = true;
                                                $subScore = explode('|', $v_CheckScore->Score100); ?>
                                                <tr>
                                                    <td class="text-center"><?= $v_CheckScore->StudentCode ?></td>
                                                    <td class="text-center"><?= $v_CheckScore->RegisterClass ?></td>
                                                    <td><?= $v_CheckScore->StudentPrefix ?><?= $v_CheckScore->StudentFirstName ?> <?= $v_CheckScore->StudentLastName ?></td>
                                                    <td class="text-center"><?= $v_CheckScore->StudentBehavior ?></td>
                                                    <td class="text-center"><?= @$subScore[0] ?></td>
                                                    <td class="text-center"><?= @$subScore[1] ?></td>
                                                    <td class="text-center"><?= @$subScore[2] ?></td>
                                                    <td class="text-center"><?= @$subScore[3] ?></td>
                                                </tr>
                                        <?php endif;
                                        endforeach; 
                                        
                                        if (!$foundScores) : ?>
                                            <tr>
                                                <td colspan="9" class="text-center">ไม่พบข้อมูลคะแนนสำหรับวิชานี้</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>

</div>
</section>

</div>
<?= $this->endSection() ?>
