<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>

<style>
    :root {
        --primary-emerald: #15a362;
        --dark-emerald: #0d6d41;
        --light-emerald: #e8f5ee;
        --border-radius: 16px;
    }

    /* Hero Header */
    .hero-teaching {
        background: linear-gradient(135deg, var(--primary-emerald) 0%, var(--dark-emerald) 100%);
        border-radius: var(--border-radius);
        padding: 2.2rem;
        color: white;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(21, 163, 98, 0.15);
    }

    .hero-teaching::after {
        content: '';
        position: absolute;
        bottom: -30%;
        right: -5%;
        width: 280px;
        height: 280px;
        background: rgba(255, 255, 255, 0.06);
        border-radius: 50%;
        pointer-events: none;
    }

    /* Stat Card */
    .stat-card-workload {
        border: none;
        border-radius: var(--border-radius);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: white;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    }

    .stat-card-workload:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.07);
    }

    .stat-icon-wrapper {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    /* Group Card */
    .group-card-custom {
        border: none;
        border-radius: var(--border-radius);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: white;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .group-card-custom:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 30px rgba(21, 163, 98, 0.12);
        border-bottom: 4px solid var(--primary-emerald);
    }

    .group-icon-circle {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: var(--light-emerald);
        color: var(--primary-emerald);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        transition: all 0.3s;
    }

    .group-card-custom:hover .group-icon-circle {
        background: var(--primary-emerald);
        color: white;
        transform: scale(1.08) rotate(5deg);
    }

    .leader-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid white;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .btn-emerald {
        background-color: var(--primary-emerald);
        border-color: var(--primary-emerald);
        color: white;
    }

    .btn-emerald:hover {
        background-color: var(--dark-emerald);
        border-color: var(--dark-emerald);
        color: white;
        transform: translateY(-1px);
    }

    .progress-emerald {
        height: 8px;
        border-radius: 6px;
        background-color: #e9ecef;
    }

    .progress-emerald .progress-bar {
        background: linear-gradient(90deg, #15a362 0%, #20c997 100%);
        border-radius: 6px;
    }

    /* High-contrast Text and Badges */
    .text-emerald {
        color: var(--dark-emerald) !important;
    }
    .text-primary-emerald {
        color: var(--primary-emerald) !important;
    }
    .text-warning-dark {
        color: #b45309 !important;
    }
    .text-info-dark {
        color: #0369a1 !important;
    }
    .text-success-dark {
        color: #15803d !important;
    }
    .badge-group-id {
        background-color: #ffffff !important;
        color: var(--dark-emerald) !important;
        border: 1.5px solid #86efac !important;
        font-weight: 800 !important;
        font-family: monospace;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .badge-status-done {
        background-color: #d1fae5 !important;
        color: #065f46 !important;
        border: 1px solid #a7f3d0 !important;
        font-weight: 700 !important;
    }
    .badge-status-pending {
        background-color: #fef3c7 !important;
        color: #92400e !important;
        border: 1px solid #fde68a !important;
        font-weight: 700 !important;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y animate__animated animate__fadeIn">
    <!-- Hero Header -->
    <div class="hero-teaching">
        <div class="row align-items-center">
            <div class="col-md-7">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="<?= base_url('Admin/Home') ?>" class="text-white opacity-75">หน้าหลัก</a></li>
                        <li class="breadcrumb-item text-white opacity-75">งานหลักสูตรและนิเทศ</li>
                        <li class="breadcrumb-item active text-white" aria-current="page">ตรวจสอบตารางสอนกลุ่มสาระ</li>
                    </ol>
                </nav>
                <h2 class="fw-bold mb-1 text-white">
                    <i class="bx bx-calendar-check me-2"></i>ตรวจสอบการจัดตารางสอนกลุ่มสาระ
                </h2>
                <p class="mb-0 text-white opacity-75">
                    ติดตามและตรวจสอบภาระงานสอนที่หัวหน้ากลุ่มสาระการเรียนรู้บันทึกข้อมูลประจำภาคเรียน
                </p>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0" style="position: relative; z-index: 5;">
                <form method="GET" action="<?= base_url('Admin/Acade/Course/TeachingSchedule') ?>" class="d-inline-flex align-items-center gap-2 bg-white bg-opacity-20 p-2 rounded-pill shadow-sm">
                    <span class="text-white fw-bold ps-3 small"><i class="bx bx-calendar me-1"></i> ภาคเรียน/ปี:</span>
                    <select name="year_term" class="form-select form-select-sm fw-bold shadow-sm rounded-pill" style="min-width: 140px; background-color: #ffffff !important; color: #0d6d41 !important; border: 1.5px solid #ffffff !important;" onchange="this.form.submit()">
                        <?php foreach ($yearTerms as $yt): ?>
                        <option value="<?= esc($yt['label']) ?>" <?= ($selectedYearTerm == $yt['label']) ? 'selected' : '' ?>>
                            <?= esc($yt['label']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
        </div>
    </div>

    <!-- Summary Stats Row -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card-workload p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-1 fw-bold text-dark"><?= number_format($summary['total_teachers'] ?? 0) ?></h3>
                        <p class="text-muted mb-0 small">ครูทั้งหมดในโรงเรียน</p>
                    </div>
                    <div class="stat-icon-wrapper" style="background: #e8f5ee; color: var(--primary-emerald);">
                        <i class="bx bx-group"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card-workload p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-1 fw-bold text-success-dark"><?= number_format($summary['completed_teachers'] ?? 0) ?></h3>
                        <p class="text-muted mb-0 small">บันทึกภาระงานแล้ว (<?= $summary['progress_percent'] ?? 0 ?>%)</p>
                    </div>
                    <div class="stat-icon-wrapper" style="background: #e8f5e9; color: #2e7d32;">
                        <i class="bx bx-check-double"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card-workload p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-1 fw-bold text-warning-dark"><?= number_format($summary['pending_teachers'] ?? 0) ?></h3>
                        <p class="text-muted mb-0 small">ยังไม่มีข้อมูลภาระงาน</p>
                    </div>
                    <div class="stat-icon-wrapper" style="background: #fff8e1; color: #b45309;">
                        <i class="bx bx-time-five"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card-workload p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-1 fw-bold text-info-dark"><?= number_format($summary['total_hours'] ?? 0) ?></h3>
                        <p class="text-muted mb-0 small">รวมคาบสอน/สัปดาห์ (ทั้งโรงเรียน)</p>
                    </div>
                    <div class="stat-icon-wrapper" style="background: #e0f2fe; color: #0284c7;">
                        <i class="bx bx-book-reader"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Header -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h5 class="fw-bold mb-0 text-dark">
                <i class="bx bx-category me-2 text-success"></i>กลุ่มสาระการเรียนรู้ (8 กลุ่มสาระ + 1 งานแนะแนว)
            </h5>
            <small class="text-muted">คลิกเพื่อดูรายละเอียดและรายชื่อครูในแต่ละกลุ่มสาระ</small>
        </div>
        <span class="badge badge-status-done rounded-pill px-3 py-2 fw-bold">
            <i class="bx bx-calendar-check me-1"></i>ประจำภาคเรียนที่ <?= esc($selectedYearTerm) ?>
        </span>
    </div>

    <!-- Group Cards Grid -->
    <div class="row g-4 mb-4">
        <?php foreach ($groups as $grp): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card group-card-custom p-4">
                <!-- Group Top Info -->
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="group-icon-circle">
                            <?php if (!empty($grp->lear_icon) && strpos($grp->lear_icon, '<img') !== false): ?>
                                <span style="transform: scale(0.7);"><?= $grp->lear_icon ?></span>
                            <?php else: ?>
                                <i class="bx bx-book-bookmark"></i>
                            <?php endif; ?>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark"><?= esc($grp->lear_namethai) ?></h5>
                            <small class="text-muted"><?= esc($grp->lear_nameeng) ?></small>
                        </div>
                    </div>
                    <span class="badge badge-group-id rounded-pill px-3"><?= esc($grp->lear_id) ?></span>
                </div>

                <!-- Group Leader Info -->
                <div class="p-3 rounded-3 mb-3 d-flex align-items-center gap-3" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                    <?php 
                        if (!empty($grp->leader->pers_img)) {
                            $leaderImg = (strpos($grp->leader->pers_img, 'http://') === 0 || strpos($grp->leader->pers_img, 'https://') === 0)
                                ? $grp->leader->pers_img
                                : 'https://personnel.skj.ac.th/uploads/admin/Personnal/' . $grp->leader->pers_img;
                        } else {
                            $leaderImg = 'https://skj.ac.th/uploads/logo/LogoSKJ_4.png';
                        }
                        $leaderName = !empty($grp->leader) 
                            ? "{$grp->leader->pers_prefix}{$grp->leader->pers_firstname} {$grp->leader->pers_lastname}" 
                            : 'ยังไม่ได้ระบุหัวหน้ากลุ่มสาระ';
                    ?>
                    <img src="<?= esc($leaderImg) ?>" alt="<?= esc($leaderName) ?>" class="leader-avatar" onerror="this.src='https://skj.ac.th/uploads/logo/LogoSKJ_4.png';">
                    <div class="overflow-hidden">
                        <small class="d-block fw-bold" style="font-size: 0.72rem; color: #b45309;"><i class="bx bx-crown me-1"></i>หัวหน้ากลุ่มสาระฯ</small>
                        <span class="fw-bold text-dark text-truncate d-block small"><?= esc($leaderName) ?></span>
                    </div>
                </div>

                <!-- Progress & Stats -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1 small">
                        <span class="text-muted">ความคืบหน้าการจัด</span>
                        <span class="fw-bold <?= $grp->progress_percent == 100 ? 'text-success-dark' : 'text-emerald' ?>">
                            <?= $grp->completed_teachers ?>/<?= $grp->total_teachers ?> คน (<?= $grp->progress_percent ?>%)
                        </span>
                    </div>
                    <div class="progress progress-emerald">
                        <div class="progress-bar" role="progressbar" style="width: <?= $grp->progress_percent ?>%;" aria-valuenow="<?= $grp->progress_percent ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center small text-muted pt-2 border-top mb-4">
                    <span><i class="bx bx-time-five me-1"></i>รวมคาบสอน: <strong class="text-dark"><?= number_format($grp->total_hours) ?></strong> คาบ/สัปดาห์</span>
                    <?php if ($grp->pending_teachers > 0): ?>
                        <span class="badge badge-status-pending">รออีก <?= $grp->pending_teachers ?> คน</span>
                    <?php else: ?>
                        <span class="badge badge-status-done"><i class="bx bx-check me-1"></i>ครบทุกคน</span>
                    <?php endif; ?>
                </div>

                <!-- Action Button -->
                <div class="mt-auto">
                    <a href="<?= base_url('Admin/Acade/Course/TeachingSchedule/group/' . esc($grp->lear_id) . '?year_term=' . urlencode($selectedYearTerm)) ?>" 
                       class="btn btn-emerald w-100 rounded-pill fw-bold py-2 shadow-xs d-flex align-items-center justify-content-center gap-2">
                        <i class="bx bx-list-check fs-5"></i> ดูตารางสอนกลุ่มสาระ
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?= $this->endSection() ?>
