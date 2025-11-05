<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Academic /</span> เลือกกลุ่มสาระการเรียนรู้</h4>

    <div class="row">
        <?php if (empty($learningGroups)) : ?>
            <div class="col">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">ไม่พบข้อมูลกลุ่มสาระ</h5>
                        <p class="card-text">ไม่พบข้อมูลกลุ่มสาระการเรียนรู้ในระบบ</p>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <?php foreach ($learningGroups as $group) : ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <a href="<?= base_url('admin/academic/checkplan/plans/' . esc($group->lear_id)) ?>" class="card h-100 text-decoration-none">
                        <div class="card-body text-center">
                            <div class="avatar avatar-md border-primary rounded-circle mx-auto mb-3">
                                <i class="bx bxs-book-reader fs-2"></i>
                            </div>
                            <h5 class="card-title"><?= esc($group->lear_namethai) ?></h5>
                            <p class="card-text">คลิกเพื่อดูแผนการสอน</p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
