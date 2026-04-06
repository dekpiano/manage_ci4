<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=K2D:wght@200;300;400;500;600&family=Outfit:wght@300;400;500;600;700&display=swap');

    :root {
        --primary-green: #15a362;
        --secondary-green: #2ecc71;
        --dark-green: #0e6b41;
        --soft-bg: #f8fafc;
        --glass-bg: rgba(255, 255, 255, 0.85);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        --hover-shadow: 0 20px 40px rgba(21, 163, 98, 0.12);
    }

    body {
        font-family: 'Outfit', 'K2D', sans-serif !important;
        background-color: var(--soft-bg);
    }

    .dashboard-container {
        padding: 2rem;
        animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Hero Section */
    .hero-v2 {
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
        border-radius: 24px;
        padding: 3rem;
        position: relative;
        overflow: hidden;
        border: none;
        box-shadow: 0 15px 35px rgba(21, 163, 98, 0.2);
        margin-bottom: 2.5rem;
    }

    .hero-v2::before {
        content: "";
        position: absolute;
        top: -100px;
        left: -100px;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .hero-v2::after {
        content: "";
        position: absolute;
        bottom: -50px;
        right: -50px;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .hero-content {
        position: relative;
        z-index: 5;
    }

    .hero-title {
        font-size: 2.2rem;
        font-weight: 700;
        letter-spacing: -0.5px;
        margin-bottom: 0.5rem;
    }

    .hero-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        font-weight: 300;
        margin-bottom: 2rem;
    }

    .btn-hero {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        color: var(--primary-green) !important;
        border: none;
        padding: 0.8rem 1.5rem;
        border-radius: 14px;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-hero:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        background: #fff;
    }

    /* Stat Cards */
    .premium-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid rgba(0,0,0,0.02);
        box-shadow: var(--card-shadow);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        overflow: hidden;
        position: relative;
    }

    .premium-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--hover-shadow);
        border-color: rgba(21, 163, 98, 0.1);
    }

    .premium-card .card-body {
        padding: 1.8rem;
    }

    .icon-wrapper {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        font-size: 1.8rem;
        transition: all 0.3s ease;
    }

    .premium-card:hover .icon-wrapper {
        transform: scale(1.1) rotate(5deg);
    }

    .stat-label {
        color: #64748b;
        font-size: 0.95rem;
        font-weight: 500;
        letter-spacing: 0.2px;
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.2rem;
    }

    .stat-unit {
        font-size: 0.8rem;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 8px;
        margin-left: 5px;
    }

    /* Progress Section */
    .section-title {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: var(--primary-green);
    }

    .performance-card {
        border-radius: 24px;
        border: none;
        box-shadow: var(--card-shadow);
        background: #fff;
    }

    .custom-progress {
        height: 8px;
        border-radius: 10px;
        background: #f1f5f9;
        overflow: visible;
        margin-bottom: 2rem;
    }

    .custom-progress-bar {
        border-radius: 10px;
        position: relative;
        transition: width 1.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .custom-progress-bar::after {
        content: "";
        position: absolute;
        right: -4px;
        top: -4px;
        width: 16px;
        height: 16px;
        background: #fff;
        border: 4px solid inherit;
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    /* Quick Actions */
    .action-tile {
        padding: 1.5rem;
        border-radius: 18px;
        background: #fff;
        border: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 15px;
        text-decoration: none !important;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
    }

    .action-tile:hover {
        background: var(--soft-bg);
        border-color: var(--primary-green);
        transform: translateX(5px);
    }

    .action-icon {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
    }

    .action-text h6 {
        margin: 0;
        font-weight: 600;
        color: #1e293b;
    }

    .action-text p {
        margin: 0;
        font-size: 0.8rem;
        color: #64748b;
    }

    /* Floating Illustration */
    .floating-img {
        animation: float 4s ease-in-out infinite;
    }

    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
        100% { transform: translateY(0px); }
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y dashboard-container">
    
    <!-- Premium Hero Section -->
    <div class="hero-v2 text-white">
        <div class="row align-items-center hero-content">
            <div class="col-lg-8">
                <span class="badge bg-white text-success mb-3 px-3 py-2 rounded-pill fw-bold">Academic Management</span>
                <h1 class="hero-title">สวัสดีครับ, คุณ <?= session()->get('fullname') ?>! 👋</h1>
                <p class="hero-subtitle">
                    ยินดีต้อนรับสู่ระบบบริหารจัดการงานวิชาการที่ทันสมัยที่สุด<br>
                    สถานะปัจจุบัน: <span class="fw-bold">ปีการศึกษา <?= $selectedYear ?></span> | ข้อมูลอัปเดตล่าสุด: <?= date('d/m/') . (date('Y') + 543) ?>
                </p>
                <div class="d-flex flex-wrap gap-3">
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
                     style="max-height: 300px; mix-blend-mode: multiply; filter: contrast(1.5) brightness(1.1) drop-shadow(0 30px 60px rgba(21, 163, 98, 0.4)); -webkit-mask-image: radial-gradient(circle, black 60%, rgba(0,0,0,0) 95%); transform: scale(1.2);">
            </div>
        </div>
    </div>

    <!-- Minimalist Stat Cards -->
    <div class="row g-4 mb-5">
        <!-- Students -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="premium-card h-100">
                <div class="card-body">
                    <div class="icon-wrapper bg-label-primary">
                        <i class='bx bxs-group'></i>
                    </div>
                    <span class="stat-label">นักเรียนทั้งหมด</span>
                    <div class="d-flex align-items-baseline">
                        <div class="stat-value text-primary"><?= number_format($total_students) ?></div>
                        <span class="stat-unit bg-label-primary text-primary">ปกติ</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teachers -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="premium-card h-100">
                <div class="card-body">
                    <div class="icon-wrapper bg-label-success">
                        <i class='bx bxs-briefcase'></i>
                    </div>
                    <span class="stat-label">บุคลากร/ครู</span>
                    <div class="d-flex align-items-baseline">
                        <div class="stat-value text-success"><?= number_format($total_teachers) ?></div>
                        <span class="stat-unit bg-label-success text-success">ท่าน</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subjects -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="premium-card h-100">
                <div class="card-body">
                    <div class="icon-wrapper bg-label-warning">
                        <i class='bx bxs-book-bookmark'></i>
                    </div>
                    <span class="stat-label">รายวิชาเรียน</span>
                    <div class="d-flex align-items-baseline">
                        <div class="stat-value text-warning"><?= number_format($total_subjects) ?></div>
                        <span class="stat-unit bg-label-warning text-warning">วิชา</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Classrooms -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="premium-card h-100">
                <div class="card-body">
                    <div class="icon-wrapper bg-label-info">
                        <i class='bx bxs-school'></i>
                    </div>
                    <span class="stat-label">ห้องเรียน</span>
                    <div class="d-flex align-items-baseline">
                        <div class="stat-value text-info"><?= number_format($total_classrooms) ?></div>
                        <span class="stat-unit bg-label-info text-info">ห้อง</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Performance Section -->
        <div class="col-lg-8">
            <h5 class="section-title"><i class='bx bx-trending-up'></i> สรุปความก้าวหน้า (Performance Tracker)</h5>
            <div class="performance-card card p-4">
                <div class="row pt-2">
                    <!-- Enrollment -->
                    <div class="col-md-6 mb-4">
                        <div class="d-flex justify-content-between mb-3 align-items-end">
                            <div>
                                <h6 class="mb-1 fw-bold">การลงทะเบียนเรียนปกติ</h6>
                                <p class="text-muted small mb-0"><?= $enrolled_students ?> จาก <?= $total_students ?> คน</p>
                            </div>
                            <?php $enroll_perc = ($total_students > 0) ? ($enrolled_students / $total_students * 100) : 0; ?>
                            <span class="fw-bold text-primary"><?= number_format($enroll_perc, 1) ?>%</span>
                        </div>
                        <div class="progress custom-progress">
                            <div class="progress-bar bg-primary custom-progress-bar" style="width: <?= $enroll_perc ?>%; border-color: #696cff;"></div>
                        </div>
                    </div>

                    <!-- Club -->
                    <div class="col-md-6 mb-4">
                        <div class="d-flex justify-content-between mb-3 align-items-end">
                            <div>
                                <h6 class="mb-1 fw-bold">การลงทะเบียนชุมนุม</h6>
                                <p class="text-muted small mb-0"><?= $club_registrations ?> จาก <?= $total_students ?> คน</p>
                            </div>
                            <?php $club_perc = ($total_students > 0) ? ($club_registrations / $total_students * 100) : 0; ?>
                            <span class="fw-bold text-success"><?= number_format($club_perc, 1) ?>%</span>
                        </div>
                        <div class="progress custom-progress">
                            <div class="progress-bar bg-success custom-progress-bar" style="width: <?= $club_perc ?>%; border-color: #71dd37;"></div>
                        </div>
                    </div>

                    <!-- Lesson Plan -->
                    <div class="col-md-6 mb-4">
                        <div class="d-flex justify-content-between mb-3 align-items-end">
                            <div>
                                <h6 class="mb-1 fw-bold">การส่งแผนการสอน (ผ่านการตรวจ)</h6>
                                <p class="text-muted small mb-0"><?= $plan_approved ?> / <?= $plan_total ?> แผน</p>
                            </div>
                            <?php $plan_perc = ($plan_total > 0) ? ($plan_approved / $plan_total * 100) : 0; ?>
                            <span class="fw-bold text-info"><?= number_format($plan_perc, 1) ?>%</span>
                        </div>
                        <div class="progress custom-progress">
                            <div class="progress-bar bg-info custom-progress-bar" style="width: <?= $plan_perc ?>%; border-color: #03c3ec;"></div>
                        </div>
                    </div>

                    <!-- Research -->
                    <div class="col-md-6 mb-4">
                        <div class="d-flex justify-content-between mb-3 align-items-end">
                            <div>
                                <h6 class="mb-1 fw-bold">รายงานผลการวิจัยในชั้นเรียน</h6>
                                <p class="text-muted small mb-0"><?= $research_total ?> ผลงานที่ได้รับ</p>
                            </div>
                            <span class="fw-bold text-warning">Active</span>
                        </div>
                        <div class="progress custom-progress">
                            <div class="progress-bar bg-warning custom-progress-bar" style="width: <?= ($research_total > 0) ? '100' : '5' ?>%; border-color: #ffab00;"></div>
                        </div>
                    </div>
                </div>
                <div class="bg-light p-3 rounded-3 mt-2 text-center">
                    <p class="mb-0 text-muted small"><i class='bx bx-info-circle me-1'></i> ข้อมูลถูกประมวลผลแบบเรียลไทม์เพื่อแม่นยำในการตัดสินใจบริหารงาน</p>
                </div>
            </div>
        </div>

        <!-- Quick Access Section -->
        <div class="col-lg-4">
            <h5 class="section-title"><i class='bx bx-grid-alt'></i> เมนูทางลัด (Quick Navigation)</h5>
            <div class="p-1">
                <?php if(in_array("งานทะเบียน", $Exp_Checkrloes)): ?>
                    <a href="<?= base_url('Admin/Acade/Registration/Students') ?>" class="action-tile">
                        <div class="action-icon bg-label-primary text-primary">
                            <i class='bx bxs-user-detail'></i>
                        </div>
                        <div class="action-text">
                            <h6>จัดการข้อมูลนักเรียน</h6>
                            <p>ค้นหา แก้ไข และตรวจสอบประวัติ</p>
                        </div>
                    </a>
                    <a href="<?= base_url('Admin/Acade/Registration/ClassRoom') ?>" class="action-tile">
                        <div class="action-icon bg-label-success text-success">
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
                        <div class="action-icon bg-label-info text-info">
                            <i class='bx bxs-check-shield'></i>
                        </div>
                        <div class="action-text">
                            <h6>ตรวจสอบแผนการสอน</h6>
                            <p>พิจารณาอนุมัติแผนการจัดการเรียนรู้</p>
                        </div>
                    </a>
                <?php endif; ?>

                <?php if(in_array("งานกิจกรรมพัฒนาผู้เรียน", $Exp_Checkrloes)): ?>
                    <a href="<?= base_url('Admin/Acade/DevelopStudents/Clubs/Main') ?>" class="action-tile">
                        <div class="action-icon bg-label-warning text-warning">
                            <i class='bx bxs-hot'></i>
                        </div>
                        <div class="action-text">
                            <h6>ระบบลงทะเบียนชุมนุม</h6>
                            <p>จัดการการเลือกชุมนุมของนักเรียน</p>
                        </div>
                    </a>
                <?php endif; ?>

                <?php if(empty(array_intersect(["งานทะเบียน", "งานหลักสูตร", "งานกิจกรรมพัฒนาผู้เรียน"], $Exp_Checkrloes))): ?>
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
            tile.style.transform = 'translateY(20px)';
            setTimeout(() => {
                tile.style.transition = 'all 0.5s ease';
                tile.style.opacity = '1';
                tile.style.transform = 'translateY(0)';
            }, 100 * index);
        });
    });
</script>

<?= $this->endSection() ?>