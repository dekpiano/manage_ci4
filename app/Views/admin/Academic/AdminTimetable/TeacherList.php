<?= $this->extend('admin/layout/main') ?>

<?= $this->section('extra_css') ?>
<style>
    .teacher-item-micro {
        transition: all 0.2s ease;
        border: 1px solid #f0f2f4;
        border-radius: 0.5rem;
        background: #fff;
        padding: 0.5rem;
    }
    .teacher-item-micro:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        border-color: #15a362;
        background: #fdfdfd;
    }
    .avatar-micro {
        width: 40px;
        height: 40px;
        flex-shrink: 0;
    }
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .learning-group-sticky {
        position: sticky;
        top: 0;
        z-index: 10;
        background: #f5f5f9;
        margin-top: 1.5rem;
        padding: 0.5rem 0;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-0"><i class="bx bx-user-check me-2"></i>ตารางสอนรายครู</h4>
            <div class="text-muted small">ปีการศึกษา <?= $term ?>/<?= $year ?> • แสดงข้อมูลครูผู้สอนทุกคนแยกตามกลุ่มสาระฯ</div>
        </div>
        <a href="<?= base_url('admin/academic/timetable/full') ?>" class="btn btn-label-primary btn-sm rounded-pill">
            <i class="bx bx-grid-alt me-1"></i> ดูตารางรวม
        </a>
    </div>

    <?php foreach($groupedTeachers as $groupName => $teachers): ?>
    <div class="learning-group-sticky border-bottom mb-3">
        <h6 class="fw-bold mb-0 text-primary d-flex align-items-center">
            <i class="bx bxs-folder-open me-2"></i> 
            กลุ่มสาระฯ <?= $groupName ?> 
            <span class="ms-2 badge bg-label-primary rounded-pill small"><?= count($teachers) ?></span>
        </h6>
    </div>

    <div class="row g-2 mb-4">
        <?php foreach($teachers as $t): ?>
        <div class="col-12 col-sm-6 col-md-4 col-xl-3">
            <a href="<?= base_url('admin/academic/timetable/view-teacher') ?>?id=<?= $t->pers_id ?>" class="text-decoration-none">
                <div class="teacher-item-micro d-flex align-items-center shadow-none">
                    <div class="avatar avatar-micro me-2">
                        <?php if($t->pers_img): ?>
                            <img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?= $t->pers_img ?>" alt="Avatar" class="rounded-circle object-fit-cover border">
                        <?php else: ?>
                            <span class="avatar-initial rounded-circle bg-label-success" style="font-size: 0.8rem;">
                                <?= mb_substr($t->pers_firstname, 0, 1) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="overflow-hidden">
                        <div class="fw-bold text-dark small text-truncate" title="<?= $t->pers_prefix.$t->pers_firstname.' '.$t->pers_lastname ?>">
                            <?= $t->pers_prefix.$t->pers_firstname.' '.$t->pers_lastname ?>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-label-info p-0 px-1 me-1" style="font-size: 0.6rem;"><?= $t->posi_name ?></span>
                            <span class="text-muted" style="font-size: 0.6rem; white-space: nowrap;"><?= $groupName ?></span>
                        </div>
                    </div>
                    <div class="ms-auto ps-2 text-end">
                        <div class="badge bg-label-success rounded-pill mb-1" style="font-size: 0.6rem;">
                            <?= ($t->total_hours ?: 0) ?> คาบ
                        </div>
                        <div class="d-block"><i class='bx bx-chevron-right text-muted opacity-50'></i></div>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
</div>
<?= $this->endSection() ?>
