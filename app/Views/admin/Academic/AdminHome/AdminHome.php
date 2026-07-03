<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=K2D:wght@200;300;400;500;600;700&family=Outfit:wght@300;400;500;600;700&display=swap');

    :root {
        --primary-green: #15a362;
        --primary-green-rgb: 21, 163, 98;
        --secondary-green: #2ecc71;
        --dark-green: #0e6b41;
        --soft-bg: #f8fafc;
        --glass-bg: rgba(255, 255, 255, 0.9);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        --hover-shadow: 0 20px 40px rgba(21, 163, 98, 0.12);
        --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        font-family: 'Outfit', 'K2D', sans-serif !important;
        background-color: var(--soft-bg);
    }

    /* Mobile-first Layout & Padding */
    .dashboard-container {
        padding: 1rem;
        animation: fadeIn 0.6s ease-out;
    }

    @media (min-width: 768px) {
        .dashboard-container {
            padding: 2rem;
        }
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Premium Hero Section - Mobile First */
    .hero-v2 {
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
        border-radius: 20px;
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
        border: none;
        box-shadow: 0 15px 35px rgba(21, 163, 98, 0.2);
        margin-bottom: 1.5rem;
    }

    @media (min-width: 768px) {
        .hero-v2 {
            border-radius: 24px;
            padding: 3rem;
            margin-bottom: 2.5rem;
        }
    }

    .hero-v2::before {
        content: "";
        position: absolute;
        top: -80px;
        left: -80px;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
        border-radius: 50%;
    }

    .hero-v2::after {
        content: "";
        position: absolute;
        bottom: -40px;
        right: -40px;
        width: 180px;
        height: 180px;
        background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, transparent 70%);
        border-radius: 50%;
    }

    .hero-content {
        position: relative;
        z-index: 5;
    }

    .hero-title {
        font-size: 1.5rem;
        font-weight: 700;
        letter-spacing: -0.5px;
        margin-bottom: 0.5rem;
    }

    @media (min-width: 768px) {
        .hero-title {
            font-size: 2.4rem;
        }
    }

    .hero-subtitle {
        font-size: 0.9rem;
        opacity: 0.95;
        font-weight: 300;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    @media (min-width: 768px) {
        .hero-subtitle {
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }
    }

    .btn-hero {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        color: var(--primary-green) !important;
        border: none;
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: var(--transition-smooth);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%; /* Full-width buttons on mobile for better touch target */
    }

    @media (min-width: 576px) {
        .btn-hero {
            width: auto;
        }
    }

    .btn-hero:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        background: #ffffff;
    }

    /* Minimalist Stat Cards - 2 Columns on Mobile */
    .premium-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid rgba(0,0,0,0.03);
        box-shadow: var(--card-shadow);
        transition: var(--transition-smooth);
        overflow: hidden;
    }

    .premium-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--hover-shadow);
        border-color: rgba(var(--primary-green-rgb), 0.15);
    }

    .premium-card .card-body {
        padding: 1.25rem;
    }

    @media (min-width: 768px) {
        .premium-card {
            border-radius: 20px;
        }
        .premium-card .card-body {
            padding: 1.75rem;
        }
    }

    .icon-wrapper {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        font-size: 1.4rem;
        transition: var(--transition-smooth);
    }

    @media (min-width: 768px) {
        .icon-wrapper {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            font-size: 1.6rem;
        }
    }

    .premium-card:hover .icon-wrapper {
        transform: scale(1.1) rotate(5deg);
    }

    .stat-label {
        color: #64748b;
        font-size: 0.85rem;
        font-weight: 500;
        display: block;
        margin-bottom: 0.25rem;
    }

    @media (min-width: 768px) {
        .stat-label {
            font-size: 0.95rem;
        }
    }

    .stat-value {
        font-size: 1.4rem;
        font-weight: 700;
        color: #1e293b;
    }

    @media (min-width: 768px) {
        .stat-value {
            font-size: 1.8rem;
        }
    }

    .stat-unit {
        font-size: 0.7rem;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 6px;
        margin-left: 4px;
    }

    /* Custom Sneat Color badges override */
    .bg-light-green {
        background-color: rgba(21, 163, 98, 0.08) !important;
        color: var(--primary-green) !important;
    }

    /* Performance Tracker */
    .section-title {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 1.1rem;
    }

    @media (min-width: 768px) {
        .section-title {
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
        }
    }

    .section-title i {
        color: var(--primary-green);
    }

    .performance-card {
        border-radius: 20px;
        border: none;
        box-shadow: var(--card-shadow);
        background: #ffffff;
        padding: 1.25rem;
    }

    @media (min-width: 768px) {
        .performance-card {
            border-radius: 24px;
            padding: 2rem;
        }
    }

    .custom-progress {
        height: 6px;
        border-radius: 10px;
        background: #f1f5f9;
        overflow: visible;
        margin-bottom: 1.5rem;
    }

    .custom-progress-bar {
        border-radius: 10px;
        position: relative;
        transition: width 1.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        background-color: var(--primary-green) !important;
    }

    .custom-progress-bar::after {
        content: "";
        position: absolute;
        right: -3px;
        top: -3px;
        width: 12px;
        height: 12px;
        background: #ffffff;
        border: 3px solid var(--primary-green);
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0,0,0,0.15);
    }

    /* Quick Actions List */
    .action-tile {
        padding: 1rem;
        border-radius: 16px;
        background: #ffffff;
        border: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none !important;
        transition: var(--transition-smooth);
        margin-bottom: 0.75rem;
        box-shadow: var(--card-shadow);
    }

    .action-tile:hover {
        background: #ffffff;
        border-color: var(--primary-green);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(21, 163, 98, 0.08);
    }

    .action-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .action-text h6 {
        margin: 0 0 2px 0;
        font-weight: 600;
        color: #1e293b;
        font-size: 0.9rem;
    }

    .action-text p {
        margin: 0;
        font-size: 0.75rem;
        color: #64748b;
    }

    /* Floating Image */
    .floating-img {
        animation: float 4s ease-in-out infinite;
    }

    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y dashboard-container">
    
    <!-- Premium Hero Section -->
    <div class="hero-v2 text-white">
        <div class="row align-items-center hero-content">
            <div class="col-lg-8">
                <span class="badge bg-white text-success mb-3 px-3 py-2 rounded-pill fw-bold" style="font-size: 0.8rem;">Academic Management</span>
                <h1 class="hero-title mb-2">
                    <span class="d-block opacity-75 fs-6 fw-normal mb-1">สวัสดีครับ 👋</span>
                    <span class="d-block fw-bold" style="word-break: break-word; line-height: 1.2; font-size: calc(1.4rem + 1.2vw);"><?= session()->get('fullname') ?></span>
                </h1>
                <p class="hero-subtitle mb-3">
                    ยินดีต้อนรับสู่ระบบบริหารจัดการงานวิชาการที่ทันสมัย<br class="d-none d-sm-inline">
                    สถานะปัจจุบัน: <span class="fw-bold text-warning">ปีการศึกษา <?= $selectedYear ?></span> | อัปเดต: <?= date('d/m/') . (date('Y') + 543) ?>
                </p>
                <div class="d-flex flex-column flex-sm-row gap-2 mt-2">
                    <?php if(in_array("งานทะเบียน", $Exp_Checkrloes)): ?>
                        <a href="<?= base_url('Admin/Acade/Registration/Students') ?>" class="btn btn-hero">
                            <i class='bx bx-user-circle'></i> จัดการนักเรียน
                        </a>
                    <?php endif; ?>
                    <?php if(in_array("งานหลักสูตร", $Exp_Checkrloes)): ?>
                        <a href="<?= base_url('admin/academic/checkplan') ?>" class="btn btn-hero">
                            <i class='bx bx-task'></i> ตรวจแผนการสอน
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-center">
                <img src="<?= base_url('public/assets/img/dashboard/hero-academic.png') ?>" 
                     alt="Academic Affairs Illustration" class="img-fluid floating-img" 
                     style="max-height: 250px; mix-blend-mode: multiply; filter: contrast(1.3) brightness(1.1) drop-shadow(0 20px 40px rgba(21, 163, 98, 0.4)); -webkit-mask-image: radial-gradient(circle, black 60%, rgba(0,0,0,0) 95%); transform: scale(1.1);">
            </div>
        </div>
    </div>

    <!-- Minimalist Stat Cards - 2 Columns on Mobile, 4 on Desktop -->
    <div class="row g-3 g-md-4 mb-4 mb-md-5">
        <!-- Students -->
        <div class="col-6 col-md-3">
            <div class="premium-card h-100">
                <div class="card-body">
                    <div class="icon-wrapper bg-light-green">
                        <i class='bx bxs-group'></i>
                    </div>
                    <span class="stat-label">นักเรียนทั้งหมด</span>
                    <div class="d-flex align-items-baseline flex-wrap">
                        <div class="stat-value text-success"><?= number_format($total_students) ?></div>
                        <span class="stat-unit bg-light-green text-success">คน</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teachers -->
        <div class="col-6 col-md-3">
            <div class="premium-card h-100">
                <div class="card-body">
                    <div class="icon-wrapper bg-light-green">
                        <i class='bx bxs-briefcase'></i>
                    </div>
                    <span class="stat-label">บุคลากร/ครู</span>
                    <div class="d-flex align-items-baseline flex-wrap">
                        <div class="stat-value text-success"><?= number_format($total_teachers) ?></div>
                        <span class="stat-unit bg-light-green text-success">ท่าน</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subjects -->
        <div class="col-6 col-md-3">
            <div class="premium-card h-100">
                <div class="card-body">
                    <div class="icon-wrapper bg-light-green">
                        <i class='bx bxs-book-bookmark'></i>
                    </div>
                    <span class="stat-label">รายวิชาเรียน</span>
                    <div class="d-flex align-items-baseline flex-wrap">
                        <div class="stat-value text-success"><?= number_format($total_subjects) ?></div>
                        <span class="stat-unit bg-light-green text-success">วิชา</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Classrooms -->
        <div class="col-6 col-md-3">
            <div class="premium-card h-100">
                <div class="card-body">
                    <div class="icon-wrapper bg-light-green">
                        <i class='bx bxs-school'></i>
                    </div>
                    <span class="stat-label">ห้องเรียน</span>
                    <div class="d-flex align-items-baseline flex-wrap">
                        <div class="stat-value text-success"><?= number_format($total_classrooms) ?></div>
                        <span class="stat-unit bg-light-green text-success">ห้อง</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Performance Section -->
        <div class="col-lg-8">
            <h5 class="section-title"><i class='bx bx-trending-up'></i> สรุปความก้าวหน้า (Performance Tracker)</h5>
            <div class="performance-card card">
                <div class="row">
                    <!-- Enrollment -->
                    <div class="col-md-6 mb-4">
                        <div class="d-flex justify-content-between mb-2 align-items-end">
                            <div>
                                <h6 class="mb-0 fw-bold" style="font-size: 0.95rem;">การลงทะเบียนเรียนปกติ</h6>
                                <p class="text-muted small mb-0"><?= $enrolled_students ?> จาก <?= $total_students ?> คน</p>
                            </div>
                            <?php $enroll_perc = ($total_students > 0) ? ($enrolled_students / $total_students * 100) : 0; ?>
                            <span class="fw-bold text-success" style="font-size: 0.9rem;"><?= number_format($enroll_perc, 1) ?>%</span>
                        </div>
                        <div class="progress custom-progress">
                            <div class="progress-bar custom-progress-bar" style="width: <?= $enroll_perc ?>%;"></div>
                        </div>
                    </div>

                    <!-- Club -->
                    <div class="col-md-6 mb-4">
                        <div class="d-flex justify-content-between mb-2 align-items-end">
                            <div>
                                <h6 class="mb-0 fw-bold" style="font-size: 0.95rem;">การลงทะเบียนชุมนุม</h6>
                                <p class="text-muted small mb-0"><?= $club_registrations ?> จาก <?= $total_students ?> คน</p>
                            </div>
                            <?php $club_perc = ($total_students > 0) ? ($club_registrations / $total_students * 100) : 0; ?>
                            <span class="fw-bold text-success" style="font-size: 0.9rem;"><?= number_format($club_perc, 1) ?>%</span>
                        </div>
                        <div class="progress custom-progress">
                            <div class="progress-bar custom-progress-bar" style="width: <?= $club_perc ?>%;"></div>
                        </div>
                    </div>

                    <!-- Lesson Plan -->
                    <div class="col-md-6 mb-4">
                        <div class="d-flex justify-content-between mb-2 align-items-end">
                            <div>
                                <h6 class="mb-0 fw-bold" style="font-size: 0.95rem;">การส่งแผนการสอน (ผ่านการตรวจ)</h6>
                                <p class="text-muted small mb-0"><?= $plan_approved ?> / <?= $plan_total ?> แผน</p>
                            </div>
                            <?php $plan_perc = ($plan_total > 0) ? ($plan_approved / $plan_total * 100) : 0; ?>
                            <span class="fw-bold text-success" style="font-size: 0.9rem;"><?= number_format($plan_perc, 1) ?>%</span>
                        </div>
                        <div class="progress custom-progress">
                            <div class="progress-bar custom-progress-bar" style="width: <?= $plan_perc ?>%;"></div>
                        </div>
                    </div>

                    <!-- Research -->
                    <div class="col-md-6 mb-4">
                        <div class="d-flex justify-content-between mb-2 align-items-end">
                            <div>
                                <h6 class="mb-0 fw-bold" style="font-size: 0.95rem;">รายงานผลการวิจัยในชั้นเรียน</h6>
                                <p class="text-muted small mb-0"><?= $research_total ?> ผลงานที่ได้รับ</p>
                            </div>
                            <span class="fw-bold text-success" style="font-size: 0.9rem;">เปิดระบบ</span>
                        </div>
                        <div class="progress custom-progress">
                            <div class="progress-bar custom-progress-bar" style="width: <?= ($research_total > 0) ? '100' : '5' ?>%;"></div>
                        </div>
                    </div>
                </div>
                <div class="bg-light p-3 rounded-3 mt-1 text-center">
                    <p class="mb-0 text-muted small"><i class='bx bx-info-circle me-1'></i> ข้อมูลถูกประมวลผลแบบเรียลไทม์เพื่อประสิทธิภาพสูงสุด</p>
                </div>
            </div>
        </div>

        <!-- Quick Access Section -->
        <div class="col-lg-4">
            <h5 class="section-title"><i class='bx bx-grid-alt'></i> เมนูทางลัด (Quick Navigation)</h5>
            <div class="p-0">
                <?php if(in_array("งานทะเบียน", $Exp_Checkrloes)): ?>
                    <a href="<?= base_url('Admin/Acade/Registration/Students') ?>" class="action-tile">
                        <div class="action-icon bg-light-green text-success">
                            <i class='bx bxs-user-detail'></i>
                        </div>
                        <div class="action-text">
                            <h6>จัดการข้อมูลนักเรียน</h6>
                            <p>ค้นหา แก้ไข และตรวจสอบประวัติ</p>
                        </div>
                    </a>
                    <a href="<?= base_url('Admin/Acade/Registration/ClassRoom') ?>" class="action-tile">
                        <div class="action-icon bg-light-green text-success">
                            <i class='bx bxs-door-open'></i>
                        </div>
                        <div class="action-text">
                            <h6>บริหารจัดการห้องเรียน</h6>
                            <p>กำหนดชั้นเรียนและจำนวนนักเรียน</p>
                        </div>
                    </a>
                <?php endif; ?>

                <?php if(in_array("งานหลักสูตร", $Exp_Checkrloes)): ?>
                    <a href="<?= base_url('admin/academic/checkplan') ?>" class="action-tile">
                        <div class="action-icon bg-light-green text-success">
                            <i class='bx bxs-check-shield'></i>
                        </div>
                        <div class="action-text">
                            <h6>ตรวจสอบแผนการสอน</h6>
                            <p>พิจารณาอนุมัติแผนการจัดการเรียนรู้</p>
                        </div>
                    </a>
                <?php endif; ?>

                <?php if(in_array("งานวัดและประเมินผล", $Exp_Checkrloes)): ?>
                    <a href="<?= base_url('Admin/Acade/Evaluate/EditGrade') ?>" class="action-tile">
                        <div class="action-icon bg-light-green text-success">
                            <i class='bx bxs-edit-alt'></i>
                        </div>
                        <div class="action-text">
                            <h6>แก้ไขผลการเรียน (0 ร)</h6>
                            <p>จัดการ/แก้ไขผลการเรียนของนักเรียนสำหรับแอดมิน</p>
                        </div>
                    </a>
                <?php endif; ?>

                <?php if(in_array("งานกิจกรรมพัฒนาผู้เรียน", $Exp_Checkrloes)): ?>
                    <a href="<?= base_url('Admin/Acade/DevelopStudents/Clubs/Main') ?>" class="action-tile">
                        <div class="action-icon bg-light-green text-success">
                            <i class='bx bxs-hot'></i>
                        </div>
                        <div class="action-text">
                            <h6>ระบบลงทะเบียนชุมนุม</h6>
                            <p>จัดการการเลือกชุมนุมของนักเรียน</p>
                        </div>
                    </a>
                <?php endif; ?>

                <?php if(empty(array_intersect(["งานทะเบียน", "งานหลักสูตร", "งานกิจกรรมพัฒนาผู้เรียน", "งานวัดและประเมินผล"], $Exp_Checkrloes))): ?>
                    <div class="card p-5 text-center border-0 shadow-none bg-transparent">
                        <i class='bx bx-lock-alt fs-1 text-muted mb-3'></i>
                        <p class="text-muted">คุณยังไม่ได้รับสิทธิ์เข้าถึง<br>เมนูทางลัดในส่วนนี้</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Simple entry animation for tiles
        const tiles = document.querySelectorAll('.action-tile, .premium-card');
        tiles.forEach((tile, index) => {
            tile.style.opacity = '0';
            tile.style.transform = 'translateY(15px)';
            setTimeout(() => {
                tile.style.transition = 'all 0.4s ease';
                tile.style.opacity = '1';
                tile.style.transform = 'translateY(0)';
            }, 80 * index);
        });
    });
</script>

<?= $this->endSection() ?>