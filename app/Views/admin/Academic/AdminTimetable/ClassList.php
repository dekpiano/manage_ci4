<?= $this->extend('admin/layout/main') ?>

<?= $this->section('extra_css') ?>
<style>
    .class-btn {
        transition: all 0.2s ease;
        border-radius: 0.8rem;
        border: 1px solid rgba(21, 163, 98, 0.1);
        background: #fff;
        padding: 1.5rem;
        text-align: center;
        display: block;
        text-decoration: none;
        color: #333;
    }
    .class-btn:hover {
        background: #15a362;
        color: #fff !important;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(21, 163, 98, 0.2);
    }
    .level-section {
        margin-bottom: 3rem;
    }
    .level-title {
        border-bottom: 2px solid #f0f2f4;
        padding-bottom: 0.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">ตารางเรียนรายห้อง</h4>
            <div class="text-muted">เลือกห้องเรียนเพื่อเรียกดูตารางเรียนของนักเรียน</div>
        </div>
        <a href="<?= base_url('admin/academic/timetable/full') ?>" class="btn btn-label-primary rounded-pill">
            <i class="bx bx-grid-alt me-1"></i> ดูตารางรวมทั้งหมด
        </a>
    </div>

    <?php if(empty($groupedClasses)): ?>
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bx bx-info-circle fs-1 text-muted mb-3"></i>
                <h5>ไม่พบข้อมูลห้องเรียน</h5>
                <p class="text-muted">โปรดมอบหมายงานสอนและประมวลผลตารางก่อน</p>
            </div>
        </div>
    <?php else: ?>
        <?php foreach($groupedClasses as $level => $classes): ?>
        <div class="level-section">
            <h5 class="fw-bold level-title text-dark">
                <span class="badge bg-success p-2 rounded-circle"><i class="bx bx-building fs-5"></i></span>
                ระดับชั้น <?= $level ?>
            </h5>
            <div class="row g-3">
                <?php foreach($classes as $className): ?>
                <div class="col-6 col-md-3 col-lg-2">
                    <a href="<?= base_url('admin/academic/timetable/view-class') ?>?class=<?= urlencode($className) ?>" class="class-btn shadow-sm">
                        <div class="fw-bold fs-5 mb-1"><?= $className ?></div>
                        <div class="small opacity-75">ดูตารางเรียน</div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
