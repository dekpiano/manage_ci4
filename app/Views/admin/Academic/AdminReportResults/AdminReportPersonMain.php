<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
.border-left-primary {
    border-left: .25rem solid #5BC3D5 !important;
}
</style>
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">จัดการข้อมูล<?= isset($title) ? esc($title) : '' ?></h1>
        <hr class="mb-4">
    </div>
    <!--//container-->
    </section>
    <section class="we-offer-area">
        <div class="container-fluid">

                <div class="card">
                    <div class="card-body">
                        <table class="table app-table-hover mb-0 text-left ShowStudent" id="">
                            <thead>
                                <tr>
                                    <th class="cell">เลขประจำตัว</th>
                                    <th class="cell">เลขที่</th>
                                    <th class="cell">ชื่อ</th>
                                    <th class="cell">นามสกุล</th>
                                    <th class="cell">ระดับชั้น</th>
                                    <th class="cell">ดูผลการเรียน</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($stu as $key => $v_stu) : ?>
                                <tr>
                                    <td class="cell"><?= isset($v_stu->StudentCode) ? esc($v_stu->StudentCode) : '' ?></td>
                                    <td class="cell"><?= isset($v_stu->StudentNumber) ? esc($v_stu->StudentNumber) : '' ?></td>
                                    <td class="cell"><?= (isset($v_stu->StudentPrefix) ? esc($v_stu->StudentPrefix) : '').(isset($v_stu->StudentFirstName) ? esc($v_stu->StudentFirstName) : '') ?></td>
                                    <td class="cell"><?= isset($v_stu->StudentLastName) ? esc($v_stu->StudentLastName) : '' ?></td>
                                    <td class="cell"><?= isset($v_stu->StudentClass) ? esc($v_stu->StudentClass) : '' ?></td>

                                    <td class="cell">
                                        <?php // NOTE: This logic should be in the controller
                                        $level = service('request')->uri->getSegment(3) ?? '';
                                        if($level === "Executive") :?>
                                        <a class="btn-sm app-btn-secondary clickLoad-spin"
                                            href="<?= site_url('Admin/Acade/Executive/ReportPerson/'.(isset($v_stu->StudentID) ? esc($v_stu->StudentID, 'url') : ''));?>">
                                            <i class="bi bi-eye-fill"></i> ดูผลการเรียน
                                        </a>
                                        <?php else: ?>
                                            <a class="btn-sm btn-primary clickLoad-spin"
                                            href="<?= site_url('Admin/Acade/Evaluate/ReportPerson/'.(isset($v_stu->StudentID) ? esc($v_stu->StudentID, 'url') : ''));?>">
                                            <i class="bi bi-eye-fill"></i> ดูผลการเรียน
                                        </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

    </div>
    </section>

</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$('.ShowStudent').DataTable({
    "order": [
        [4, "asc"],
        [1, "asc"]
    ]
});
</script>
<?= $this->endSection() ?>
