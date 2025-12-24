<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
    .dashboard-hero {
        background: linear-gradient(135deg, #15a362 0%, #2ecc71 100%);
        border: none;
        overflow: hidden;
        position: relative;
    }
    .dashboard-hero .card-body { position: relative; z-index: 2; }
    .dashboard-hero::after {
        content: "";
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        z-index: 1;
    }
    
    .stat-card {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .icon-box {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }
    
    .progress-item { margin-bottom: 1.5rem; }
    .progress-item:last-child { margin-bottom: 0; }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Welcome Section -->
    <div class="card dashboard-hero text-white mb-4">
        <div class="card-body py-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold text-white mb-1">ยินดีต้อนรับกลับมา, คุณ <?= session()->get('fullname') ?>! 👋</h2>
                    <p class="mb-3 opacity-75">ระบบบริหารจัดการงานวิชาการ (Academic Management System) ปีการศึกษา <?= $selectedYear ?></p>
                    <div class="d-flex gap-2">
                        <?php if(in_array("งานทะเบียน", $Exp_Checkrloes)): ?>
                            <a href="<?= base_url('Admin/Acade/Registration/Students') ?>" class="btn btn-white btn-sm text-success fw-bold">จัดการนักเรียน</a>
                        <?php endif; ?>
                        <?php if(in_array("งานหลักสูตร", $Exp_Checkrloes)): ?>
                            <a href="<?= base_url('admin/academic/checkplan') ?>" class="btn btn-white btn-sm text-success fw-bold">ตรวจแผนการสอน</a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-4 text-center d-none d-md-block">
                    <img src="https://img.freepik.com/free-vector/academic-excellence-concept-illustration_114360-11603.jpg" alt="Edu" height="150" class="rounded-pill shadow-sm bg-white p-2">
                </div>
            </div>
        </div>
    </div>

    <!-- Main Summary Cards -->
    <div class="row g-4 mb-4">
        <!-- Students -->
        <div class="col-6 col-sm-6 col-md-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-muted d-block mb-1">นักเรียนทั้งหมด</span>
                            <div class="d-flex align-items-end">
                                <h3 class="card-title mb-0 me-2 fw-bold text-primary"><?= number_format($total_students) ?></h3>
                                <small class="text-success mb-1">(ปกติ)</small>
                            </div>
                        </div>
                        <div class="icon-box bg-label-primary">
                            <i class="bx bx-group fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teachers -->
        <div class="col-6 col-sm-6 col-md-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-muted d-block mb-1">บุคลากร/ครู</span>
                            <div class="d-flex align-items-end">
                                <h3 class="card-title mb-0 me-2 fw-bold text-info"><?= number_format($total_teachers) ?></h3>
                                <small class="text-info mb-1">ท่าน</small>
                            </div>
                        </div>
                        <div class="icon-box bg-label-info">
                            <i class="bx bx-chalkboard fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subjects -->
        <div class="col-6 col-sm-6 col-md-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-muted d-block mb-1">รายวิชาเรียน</span>
                            <div class="d-flex align-items-end">
                                <h3 class="card-title mb-0 me-2 fw-bold text-success"><?= number_format($total_subjects) ?></h3>
                                <small class="text-success mb-1">วิชา</small>
                            </div>
                        </div>
                        <div class="icon-box bg-label-success">
                            <i class="bx bx-book-content fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Classrooms -->
        <div class="col-6 col-sm-6 col-md-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-muted d-block mb-1">ห้องเรียน</span>
                            <div class="d-flex align-items-end">
                                <h3 class="card-title mb-0 me-2 fw-bold text-warning"><?= number_format($total_classrooms) ?></h3>
                                <small class="text-warning mb-1">ห้อง</small>
                            </div>
                        </div>
                        <div class="icon-box bg-label-warning">
                            <i class="bx bx-building fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Column: Performance Tracking -->
        <div class="col-md-8">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bx bx-chart me-2"></i>สรุปความก้าวหน้าการดำเนินงาน</h5>
                    <span class="badge bg-label-success">ปีการศึกษา <?= $selectedYear ?></span>
                </div>
                <div class="card-body pb-0">
                    <div class="row">
                        <!-- Enrollment Progress -->
                        <div class="col-md-6 progress-item">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-medium">การลงทะเบียนเรียนปกติ</span>
                                <span class="text-muted small"><?= $enrolled_students ?> / <?= $total_students ?> คน</span>
                            </div>
                            <?php $enroll_perc = ($total_students > 0) ? ($enrolled_students / $total_students * 100) : 0; ?>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-primary" style="width: <?= $enroll_perc ?>%"></div>
                            </div>
                        </div>

                        <!-- Club Registration -->
                        <div class="col-md-6 progress-item">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-medium">การลงทะเบียนชุมนุม</span>
                                <span class="text-muted small"><?= $club_registrations ?> / <?= $total_students ?> คน</span>
                            </div>
                            <?php $club_perc = ($total_students > 0) ? ($club_registrations / $total_students * 100) : 0; ?>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success" style="width: <?= $club_perc ?>%"></div>
                            </div>
                        </div>

                        <!-- Lesson Plan Submission -->
                        <div class="col-md-6 progress-item">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-medium">การส่งแผนการสอน (ผ่านการตรวจ)</span>
                                <span class="text-muted small"><?= $plan_approved ?> / <?= $plan_total ?> แผน</span>
                            </div>
                            <?php $plan_perc = ($plan_total > 0) ? ($plan_approved / $plan_total * 100) : 0; ?>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-info" style="width: <?= $plan_perc ?>%"></div>
                            </div>
                        </div>

                        <!-- Research Submission -->
                        <div class="col-md-6 progress-item">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-medium">สถิติการส่งงานวิจัย</span>
                                <span class="text-muted small"><?= $research_total ?> งานวิจัย</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-warning" style="width: <?= ($research_total > 0) ? '100' : '0' ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light border-0 mt-3 text-center">
                    <small class="text-muted">ข้อมูลอัปเดตแบบ Real-time ตามฐานข้อมูลปัจจุบัน</small>
                </div>
            </div>
        </div>

        <!-- Right Column: Quick Navigation -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold border-start border-4 border-success ps-2">เมนูทางลัด (Quick Actions)</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <?php if(in_array("งานทะเบียน", $Exp_Checkrloes)): ?>
                            <a href="<?= base_url('Admin/Acade/Registration/Students') ?>" class="btn btn-outline-primary d-flex align-items-center justify-content-between p-3">
                                <span class="d-flex align-items-center"><i class="bx bx-user-plus me-2 fs-4"></i> ค้นหา/แก้ไขข้อมูลนักเรียน</span>
                                <i class="bx bx-chevron-right"></i>
                            </a>
                            <a href="<?= base_url('Admin/Acade/Registration/ClassRoom') ?>" class="btn btn-outline-success d-flex align-items-center justify-content-between p-3">
                                <span class="d-flex align-items-center"><i class="bx bx-door-open me-2 fs-4"></i> จัดการห้องเรียน</span>
                                <i class="bx bx-chevron-right"></i>
                            </a>
                        <?php endif; ?>

                        <?php if(in_array("งานหลักสูตร", $Exp_Checkrloes)): ?>
                            <a href="<?= base_url('admin/academic/checkplan') ?>" class="btn btn-outline-info d-flex align-items-center justify-content-between p-3">
                                <span class="d-flex align-items-center"><i class="bx bx-badge-check me-2 fs-4"></i> ตรวจสอบแผนการสอน</span>
                                <i class="bx bx-chevron-right"></i>
                            </a>
                        <?php endif; ?>

                        <?php if(in_array("งานกิจกรรมพัฒนาผู้เรียน", $Exp_Checkrloes)): ?>
                            <a href="<?= base_url('Admin/Acade/DevelopStudents/Clubs/Main') ?>" class="btn btn-outline-warning d-flex align-items-center justify-content-between p-3">
                                <span class="d-flex align-items-center"><i class="bx bx-landscape me-2 fs-4"></i> ระบบลงทะเบียนชุมนุม</span>
                                <i class="bx bx-chevron-right"></i>
                            </a>
                        <?php endif; ?>

                        <?php if(empty(array_intersect(["งานทะเบียน", "งานหลักสูตร", "งานกิจกรรมพัฒนาผู้เรียน"], $Exp_Checkrloes))): ?>
                            <div class="text-center py-4">
                                <i class="bx bx-info-circle fs-1 text-muted mb-2"></i>
                                <p class="text-muted small">คุณยังไม่มีสิทธิ์เข้าถึงเมนูทางลัด<br>รับผิดชอบเฉพาะส่วนที่ได้รับมอบหมาย</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>