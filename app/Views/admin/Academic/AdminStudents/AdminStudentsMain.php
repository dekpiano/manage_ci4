<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
/* ===== Custom CSS Variables - Green Theme ===== */
:root {
    --primary-green: #28a745;
    --primary-green-dark: #1e7e34;
    --primary-green-light: #d4edda;
    --gradient-green: linear-gradient(135deg, #28a745 0%, #20c997 50%, #17a2b8 100%);
    --glass-bg: rgba(255, 255, 255, 0.25);
    --card-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
    --hover-shadow: 0 16px 48px rgba(0, 0, 0, 0.12);
}

/* ===== Page Container ===== */
.students-dashboard {
    padding: 1.5rem;
    background: linear-gradient(180deg, #f8fdf9 0%, #ffffff 100%);
    min-height: 100vh;
}

/* ===== Welcome Banner - Modern Glass Style ===== */
.welcome-banner {
    background: var(--gradient-green);
    border-radius: 20px;
    padding: 2.5rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(40, 167, 69, 0.3);
}

.welcome-banner::before {
    content: '';
    position: absolute;
    top: -100px;
    right: -100px;
    width: 350px;
    height: 350px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    animation: float 6s ease-in-out infinite;
}

.welcome-banner::after {
    content: '';
    position: absolute;
    bottom: -80px;
    left: -80px;
    width: 250px;
    height: 250px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 50%;
    animation: float 8s ease-in-out infinite reverse;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(5deg); }
}

.welcome-banner .content {
    position: relative;
    z-index: 1;
}

.welcome-banner h1 {
    font-size: 2rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 0.5rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.welcome-banner p {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1rem;
    margin: 0;
}

.welcome-banner .icon-wrapper {
    font-size: 8rem;
    color: rgba(255, 255, 255, 0.15);
    position: absolute;
    right: 2rem;
    top: 50%;
    transform: translateY(-50%);
}

/* ===== Stat Cards - Glassmorphism ===== */
.stat-card {
    background: #fff;
    border-radius: 16px;
    border: none;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    box-shadow: var(--card-shadow);
    position: relative;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    border-radius: 16px 16px 0 0;
}

.stat-card.card-success::before { background: var(--gradient-green); }
.stat-card.card-danger::before { background: linear-gradient(90deg, #dc3545, #ff6b6b); }
.stat-card.card-warning::before { background: linear-gradient(90deg, #ffc107, #ffda44); }
.stat-card.card-primary::before { background: linear-gradient(90deg, #007bff, #17a2b8); }

.stat-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--hover-shadow);
}

.stat-card .card-body {
    padding: 1.5rem;
}

.stat-icon-wrapper {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    transition: transform 0.3s ease;
}

.stat-card:hover .stat-icon-wrapper {
    transform: scale(1.1) rotate(-5deg);
}

/* Global Gradient Backgrounds */
.bg-success-gradient { background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important; color: #fff !important; }
.bg-danger-gradient { background: linear-gradient(135deg, #dc3545 0%, #ff6b6b 100%) !important; color: #fff !important; }
.bg-warning-gradient { background: linear-gradient(135deg, #ffc107 0%, #ffda44 100%) !important; color: #fff !important; }
.bg-primary-gradient { background: linear-gradient(135deg, #007bff 0%, #17a2b8 100%) !important; color: #fff !important; }

.stat-icon-wrapper.bg-success-gradient { color: #fff; }
.stat-icon-wrapper.bg-danger-gradient { color: #fff; }
.stat-icon-wrapper.bg-warning-gradient { color: #fff; }
.stat-icon-wrapper.bg-primary-gradient { color: #fff; }

.stat-value {
    font-size: 2.5rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.95rem;
    color: #6c757d;
    font-weight: 500;
}

.stat-trend {
    display: inline-flex;
    align-items: center;
    font-size: 0.8rem;
    padding: 0.25rem 0.5rem;
    border-radius: 20px;
    margin-top: 0.5rem;
}

.stat-trend.up {
    background: #d4edda;
    color: #28a745;
}

.stat-trend.down {
    background: #f8d7da;
    color: #dc3545;
}

/* ===== Chart Cards ===== */
.chart-card {
    background: #fff;
    border-radius: 16px;
    border: none;
    box-shadow: var(--card-shadow);
    overflow: hidden;
    transition: all 0.3s ease;
}

.chart-card:hover {
    box-shadow: var(--hover-shadow);
}

.chart-card .card-header {
    background: transparent;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #f0f0f0;
}

.chart-card .card-header h5 {
    font-weight: 700;
    color: #2c3e50;
    margin: 0;
}

.chart-container {
    position: relative;
}

/* ===== Recent Card ===== */
.recent-card {
    background: #fff;
    border-radius: 16px;
    border: none;
    box-shadow: var(--card-shadow);
    overflow: hidden;
}

.recent-card .card-header {
    background: transparent;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.recent-card .card-header h5 {
    font-weight: 700;
    color: #2c3e50;
    margin: 0;
}

.recent-card .table thead th {
    background: #f8fdf9;
    color: #28a745;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    padding: 1rem 1.5rem;
    border-top: none;
}

.recent-card .table tbody td {
    padding: 1rem 1.5rem;
    vertical-align: middle;
    color: #4a5568;
    border-bottom: 1px solid #f7fafc;
}

/* ===== Quick Actions ===== */
.quick-action-btn {
    background: #fff;
    border-radius: 16px;
    padding: 1.25rem 1rem;
    display: flex;
    align-items: center;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid #f0f0f0;
    box-shadow: 0 4px 6px rgba(0,0,0,0.02);
}

.quick-action-btn:hover {
    transform: translateX(8px);
    background: #f8fdf9;
    border-color: var(--primary-green-light);
    box-shadow: 0 8px 15px rgba(40, 167, 69, 0.1);
}

.quick-action-btn .action-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-right: 1.25rem;
    transition: all 0.3s ease;
}

.quick-action-btn:hover .action-icon {
    transform: rotate(-10deg);
}

.quick-action-btn .action-icon.bg-success { background: var(--primary-green-light) !important; color: var(--primary-green) !important; }
.quick-action-btn .action-icon.bg-info { background: #e0f2ff !important; color: #007bff !important; }
.quick-action-btn .action-icon.bg-warning { background: #fff8e1 !important; color: #ffc107 !important; }

.quick-action-btn .action-title {
    font-weight: 700;
    color: #2d3748;
    display: block;
    margin-bottom: 0.15rem;
}

.quick-action-btn .action-subtitle {
    font-size: 0.8rem;
    color: #6c757d;
}

.quick-action-btn .action-arrow {
    color: #adb5bd;
    font-size: 1.25rem;
    transition: transform 0.3s ease;
}

.quick-action-btn:hover .action-arrow {
    transform: translateX(5px);
    color: var(--primary-green);
}

/* ===== Topbar Utilities ===== */
.btn-white {
    background: #fff;
    color: #333;
    transition: all 0.3s ease;
}

.btn-white:hover {
    background: #f8f9fa;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
}

.bg-light-success { background-color: #f1fbf3 !important; }
.bg-light-info { background-color: #f0f7ff !important; }
.bg-light-warning { background-color: #fffaf0 !important; }
.bg-light-primary { background-color: #f0f4ff !important; }
.bg-light-secondary { background-color: #f8f9fa !important; }

.behavior-card { border-width: 2px !important; border-style: dashed !important; }

.transition-all { transition: all 0.3s ease; }
.transition-all:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.05); }

/* ===== Loading Spinner ===== */
.loading-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem;
}

.loading-wrapper .spinner-grow {
    width: 3rem;
    height: 3rem;
}

/* ===== Responsive ===== */
@media (max-width: 768px) {
    .welcome-banner {
        padding: 1.5rem;
    }
    
    .welcome-banner h1 {
        font-size: 1.5rem;
    }
    
    .welcome-banner .icon-wrapper {
        display: none;
    }
    
    .stat-value {
        font-size: 2rem;
    }
}
</style>

<div class="students-dashboard">
    <!-- Top Filter Bar -->
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/academic/home') ?>">วิชาการ</a></li>
                    <li class="breadcrumb-item active">จัดการนักเรียน</li>
                </ol>
            </nav>
            <div class="dropdown">
                <button class="btn btn-white shadow-sm border-0 dropdown-toggle rounded-pill px-4" type="button" id="yearSelector" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class='bx bx-calendar-event me-2 text-primary'></i>ปีการศึกษา <?= get_selected_year() ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3" aria-labelledby="yearSelector">
                    <li class="dropdown-header">เลือกปีการศึกษา</li>
                    <?php foreach($school_years as $year): ?>
                        <li>
                            <a class="dropdown-item <?= $year->schyear_year == get_selected_year() ? 'active bg-success text-white' : '' ?>" 
                               href="<?= base_url('Admin/Acade/Registration/Students/ChangeYear/'.$year->schyear_year) ?>">
                                ปีการศึกษา <?= $year->schyear_year ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <!-- Welcome Banner -->
    <div class="welcome-banner mb-4">
        <div class="content">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <h1>
                        <i class="bx bx-book-reader me-2"></i>จัดการข้อมูลนักเรียน
                    </h1>
                    <p>ระบบจัดการข้อมูลนักเรียนในสถานศึกษา สำหรับตรวจสอบ แก้ไข และบริหารจัดการนักเรียนทั้งหมด</p>
                </div>
                <div class="col-md-3 text-end d-none d-md-block">
                    <div class="icon-wrapper">
                        <i class="bx bxs-graduation"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Stats -->
    <div class="row g-4 mb-4">
        <!-- Normal Students -->
        <div class="col-sm-6 col-xl-4">
            <a href="<?=base_url('Admin/Acade/Registration/Students/normal')?>" class="text-decoration-none">
                <div class="card stat-card card-success h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <div class="stat-value text-success"><?=$CountNormalStu->stunormal ?? 0?></div>
                                <div class="stat-label">นักเรียนปกติ</div>
                                <div class="stat-trend up">
                                    <i class="bx bx-check-circle me-1"></i>สถานะปกติ
                                </div>
                            </div>
                            <div class="stat-icon-wrapper bg-success-gradient">
                                <i class="bx bx-user-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Absent Students -->
        <div class="col-sm-6 col-xl-4">
            <a href="<?=base_url('Admin/Acade/Registration/Students/absent_long')?>" class="text-decoration-none">
                <div class="card stat-card card-danger h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <div class="stat-value text-danger"><?=$CountAbsentStu->stuabsent ?? 0?></div>
                                <div class="stat-label">ขาดเรียนนาน</div>
                                <div class="stat-trend down">
                                    <i class="bx bx-error-circle me-1"></i>ต้องติดตาม
                                </div>
                            </div>
                            <div class="stat-icon-wrapper bg-danger-gradient">
                                <i class="bx bx-user-x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>


        <!-- All Students -->
        <div class="col-sm-6 col-xl-4">
            <a href="<?=base_url('Admin/Acade/Registration/Students/studying')?>" class="text-decoration-none">
                <div class="card stat-card card-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <div class="stat-value text-primary"><?=$CountAllStu->stuall ?? 0?></div>
                                <div class="stat-label">นักเรียนทั้งหมด</div>
                                <div class="stat-trend up">
                                    <i class="bx bx-id-card me-1"></i>กำลังศึกษา
                                </div>
                            </div>
                            <div class="stat-icon-wrapper bg-primary-gradient">
                                <i class="bx bx-group"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row g-4 mb-4">
        <!-- Bar Chart - Students by Class -->
        <div class="col-xl-7 col-12">
            <div class="card chart-card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="bx bx-bar-chart-alt-2 me-2"></i>จำนวนนักเรียนแต่ละระดับชั้น</h5>
                    <span class="badge bg-light text-muted border">แยกชาย-หญิง</span>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="chart-bar-students-by-class"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Doughnut Chart - Gender -->
        <div class="col-xl-5 col-12">
            <div class="card chart-card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="bx bx-pie-chart-alt me-2"></i>สัดส่วนนักเรียนชาย-หญิง</h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <div class="chart-container flex-grow-1" style="height: 200px;">
                        <canvas id="chart-doughnut-gender"></canvas>
                    </div>
                    <div class="row g-3 mt-3">
                        <div class="col-6">
                            <div class="gender-stat">
                                <div class="icon male">
                                    <i class="bx bx-male"></i>
                                </div>
                                <div class="count" id="stats_male_student">0</div>
                                <div class="label">นักเรียนชาย</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="gender-stat">
                                <div class="icon female">
                                    <i class="bx bx-female"></i>
                                </div>
                                <div class="count" id="stats_female_student">0</div>
                                <div class="label">นักเรียนหญิง</div>
                            </div>
                        </div>
                    </div>
        </div>
    </div>
</div>
</div>
    <!-- Quick Actions Horizontal -->
    <div class="row g-3 mb-4">
        <!-- Export Students -->
        <div class="col-lg col-md-4 col-sm-6">
            <a href="<?= site_url('admin/academic/students/export/all') ?>" class="quick-action-btn h-100">
                <div class="action-icon rounded-3 me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);">
                    <i class="bx bx-export text-white"></i>
                </div>
                <div class="action-content">
                    <div class="action-title mb-0" style="font-weight: 700; color: #2d3748; font-size: 0.9rem;">ส่งออกข้อมูล</div>
                    <div class="small text-muted" style="font-size: 0.75rem;">Excel Report</div>
                </div>
            </a>
        </div>

        <!-- Student Lifecycle Management -->
        <div class="col-lg col-md-4 col-sm-6">
            <a href="<?=base_url('Admin/Acade/Registration/Students/Lifecycle')?>" class="quick-action-btn h-100">
                <div class="action-icon rounded-3 me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                    <i class="bx bx-recycle text-white"></i>
                </div>
                <div class="action-content">
                    <div class="action-title mb-0" style="font-weight: 700; color: #2d3748; font-size: 0.9rem;">จัดประเภท</div>
                    <div class="small text-muted" style="font-size: 0.75rem;">เลื่อนชั้น/จบ</div>
                </div>
            </a>
        </div>

        <!-- View Normal Students -->
        <div class="col-lg col-md-4 col-sm-6">
            <a href="<?=base_url('Admin/Acade/Registration/Students/normal')?>" class="quick-action-btn h-100">
                <div class="action-icon rounded-3 me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; background: linear-gradient(135deg, #6c757d 0%, #adb5bd 100%);">
                    <i class="bx bx-search-alt text-white"></i>
                </div>
                <div class="action-content">
                    <div class="action-title mb-0" style="font-weight: 700; color: #2d3748; font-size: 0.9rem;">ค้นหานักเรียน</div>
                    <div class="small text-muted" style="font-size: 0.75rem;">รายชื่อทั้งหมด</div>
                </div>
            </a>
        </div>

        <!-- Adjust Student Numbers -->
        <div class="col-lg col-md-4 col-sm-6">
            <a href="<?=base_url('Admin/Acade/Registration/Students/AdjustNumber')?>" class="quick-action-btn h-100">
                <div class="action-icon rounded-3 me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; background: linear-gradient(135deg, #3f51b5 0%, #2196f3 100%);">
                    <i class="bx bx-list-ol text-white"></i>
                </div>
                <div class="action-content">
                    <div class="action-title mb-0" style="font-weight: 700; color: #2d3748; font-size: 0.9rem;">ปรับเลขที่</div>
                    <div class="small text-muted" style="font-size: 0.75rem;">จัดการเลขที่ห้อง</div>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Students Table Section -->
    <div class="row">
        <div class="col-12">
            <div class="card recent-card">
                <div class="card-header">
                    <h5><i class="bx bx-time-five me-2"></i>นักเรียนที่เพิ่มล่าสุด</h5>
                    <a href="<?=base_url('Admin/Acade/Registration/Students/studying')?>" class="btn btn-sm btn-outline-success">
                        <i class="bx bx-list-ul me-1"></i>ดูทั้งหมด
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table recent-table">
                            <thead>
                                <tr>
                                    <th>รหัสนักเรียน</th>
                                    <th>ชื่อ-สกุล</th>
                                    <th>ระดับชั้น</th>
                                    <th>สถานะ</th>
                                    <th class="text-center">การจัดการ</th>
                                </tr>
                            </thead>
                            <tbody id="recent_students_table">
                                <tr>
                                    <td colspan="5">
                                        <div class="loading-wrapper">
                                            <div class="spinner-grow text-success" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <p class="text-muted mt-3 mb-0">กำลังโหลดข้อมูล...</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Global Search & Direct Edit Section -->
    <div class="row mt-4 mb-5">
        <div class="col-12">
            <div class="card premium-card border-0 shadow-sm" style="background: rgba(108, 117, 125, 0.05); border-left: 5px solid #6c757d !important;">
                <div class="card-body p-4">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-7">
                            <h5 class="fw-bold mb-1 text-dark"><i class="bx bx-search-alt-2 me-2"></i>🔍 ค้นหาข้อมูลนักเรียนเพื่อแก้ไขรายบุคคล</h5>
                            <p class="text-muted small mb-0">กรณีต้องการแก้ไขข้อมูลที่อยู่นอกเหนือกราฟสถิติด้านบน หรือต้องการแก้ไขรายบุคคลแบบเร่งด่วน ค้นหาได้ที่นี่</p>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input type="text" id="globalSearchInput" class="form-control border-secondary bg-white" placeholder="พิมพ์ชื่อ-นามสกุล หรือ รหัสประจำตัว...">
                                <button class="btn btn-secondary" type="button" id="globalSearchBtn">
                                    <i class="bx bx-search me-1"></i> ค้นหา
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="globalSearchResult" class="d-none">
                        <div class="table-responsive bg-white rounded-3 shadow-sm mt-3 border">
                            <table class="table table-hover align-middle mb-0">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th class="ps-3 py-3" width="15%">รหัสประจำตัว</th>
                                        <th width="35%">ชื่อ - นามสกุล</th>
                                        <th width="15%">ระดับห้องเรียน</th>
                                        <th width="15%">สถานะ</th>
                                        <th class="pe-3 text-center" width="20%">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody id="globalSearchBody">
                                    <!-- Loaded via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // --- Element References ---
    const statsMale = document.getElementById('stats_male_student');
    const statsFemale = document.getElementById('stats_female_student');
    const recentStudentsTable = document.getElementById('recent_students_table');

    // --- Bar Chart (Students by Class) ---
    const barChartCanvas = document.getElementById('chart-bar-students-by-class');
    const barChartCtx = barChartCanvas ? barChartCanvas.getContext('2d') : null;
    let barChart;

    if (barChartCtx) {
        barChart = new Chart(barChartCtx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [
                    {
                        label: 'ชาย',
                        data: [],
                        backgroundColor: 'rgba(40, 167, 69, 0.8)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        borderWidth: 0,
                        borderRadius: 8,
                        borderSkipped: false
                    },
                    {
                        label: 'หญิง',
                        data: [],
                        backgroundColor: 'rgba(253, 126, 20, 0.8)',
                        borderColor: 'rgba(253, 126, 20, 1)',
                        borderWidth: 0,
                        borderRadius: 8,
                        borderSkipped: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { 
                    y: { 
                        beginAtZero: true,
                        grid: { 
                            color: 'rgba(0,0,0,0.03)',
                            drawBorder: false
                        },
                        ticks: {
                            font: { weight: '500' }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { weight: '500' }
                        }
                    }
                },
                plugins: { 
                    legend: { 
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 20,
                            font: { weight: '500' }
                        }
                    } 
                }
            }
        });
    }

    // --- Doughnut Chart (Gender) ---
    const doughnutChartCanvas = document.getElementById('chart-doughnut-gender');
    const doughnutChartCtx = doughnutChartCanvas ? doughnutChartCanvas.getContext('2d') : null;
    let doughnutChart;

    if (doughnutChartCtx) {
        doughnutChart = new Chart(doughnutChartCtx, {
            type: 'doughnut',
            data: {
                labels: ['ชาย', 'หญิง'],
                datasets: [{
                    data: [0, 0],
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.9)',
                        'rgba(253, 126, 20, 0.9)'
                    ],
                    borderWidth: 0,
                    hoverOffset: 10,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    // --- Load Dashboard Data ---
    function loadDashboardData() {
        fetch('<?=base_url("admin/academic/ConAdminStudents/getDashboardData")?>')
            .then(response => response.json())
            .then(data => {
                // Update Gender Stats
                if (statsMale) statsMale.textContent = data.gender_count.male || '0';
                if (statsFemale) statsFemale.textContent = data.gender_count.female || '0';

                // Update Bar Chart
                if (barChart) {
                    barChart.data.labels = data.students_by_class.labels;
                    if(data.students_by_class.datasets && data.students_by_class.datasets.length >= 2) {
                        barChart.data.datasets[0].data = data.students_by_class.datasets[0].data;
                        barChart.data.datasets[1].data = data.students_by_class.datasets[1].data;
                    }
                    barChart.update();
                }

                // Update Doughnut Chart
                if (doughnutChart) {
                    doughnutChart.data.datasets[0].data[0] = data.gender_count.male || 0;
                    doughnutChart.data.datasets[0].data[1] = data.gender_count.female || 0;
                    doughnutChart.update();
                }

                // Update Recent Students Table
                let tableHtml = '';
                if (data.recent_students && data.recent_students.length > 0) {
                    data.recent_students.forEach(student => {
                        tableHtml += `
                            <tr>
                                <td><span class="student-badge badge-code">${student.StudentCode}</span></td>
                                <td><span class="fw-medium">${student.Fullname}</span></td>
                                <td><span class="student-badge badge-class">${student.StudentClass}</span></td>
                                <td><span class="student-badge badge-status">${student.StudentStatus}</span></td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-outline-success rounded-pill px-3" href="<?=base_url('Admin/Acade/Registration/Students/normal')?>">
                                        <i class="bx bx-search me-1"></i>ค้นหา
                                    </a>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    tableHtml = '<tr><td colspan="5" class="text-center py-5 text-muted"><i class="bx bx-info-circle me-1"></i>ไม่พบข้อมูลนักเรียนล่าสุด</td></tr>';
                }
                recentStudentsTable.innerHTML = tableHtml;
            })
            .catch(error => {
                console.error('Error loading dashboard data:', error);
                recentStudentsTable.innerHTML = '<tr><td colspan="5" class="text-center py-5 text-danger"><i class="bx bx-error-circle me-1"></i>ไม่สามารถโหลดข้อมูลได้</td></tr>';
                Swal.fire({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ไม่สามารถโหลดข้อมูล Dashboard ได้: ' + error.message,
                    icon: 'error',
                    confirmButtonText: 'ตกลง',
                    confirmButtonColor: '#28a745'
                });
            });
    }

    // Load data on page load
    loadDashboardData();

    // Handle Import Students button
    const importStudentsBtn = document.getElementById('importStudentsBtn');
    if (importStudentsBtn) {
        importStudentsBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const updateUrl = this.href;

            Swal.fire({
                title: 'กำลังนำเข้าข้อมูลนักเรียน',
                html: '<div class="py-4"><div class="spinner-border text-success" style="width: 3rem; height: 3rem;" role="status"></div></div><p class="text-muted">กรุณารอสักครู่ ระบบกำลังดึงและประมวลผลข้อมูลจาก Google Sheet...</p>',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            window.location.href = updateUrl;
        });
    }

    // --- Global Search Logic for Dashboard ---
    const globalSearchBtn = document.getElementById('globalSearchBtn');
    const globalSearchInput = document.getElementById('globalSearchInput');
    const globalSearchResult = document.getElementById('globalSearchResult');
    const globalSearchBody = document.getElementById('globalSearchBody');

    if (globalSearchBtn) {
        globalSearchBtn.addEventListener('click', performGlobalSearch);
        globalSearchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') performGlobalSearch();
        });
    }

    function performGlobalSearch() {
        const query = globalSearchInput.value.trim();
        if (query.length < 2) {
            Swal.fire({
                icon: 'warning',
                title: 'โปรดระบุคำค้นหา',
                text: 'กรุณาพิมพ์อย่างน้อย 2 ตัวอักษร',
                timer: 2000,
                showConfirmButton: false
            });
            return;
        }

        Swal.fire({
            title: 'กำลังค้นหา...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        // Use FormData for POST
        const formData = new FormData();
        formData.append('search', query);

        // เปลี่ยนมาใช้ $.post เพื่อให้ใช้งานร่วมกับ Global CSRF Setup ได้ครับ 💎
        $.post("<?= base_url('Admin/Acade/Registration/Students/AdjustNumberGlobalSearch') ?>", { search: query })
        .done(function(data) {
            globalSearchBody.innerHTML = '';
            
            // ตรวจสอบว่า data เป็น Array หรือไม่ป้องกัน Error .forEach
            if (!Array.isArray(data) || data.length === 0) {
                globalSearchBody.innerHTML = '<tr><td colspan="5" class="text-center py-4 text-muted">ไม่พบข้อมูลนักเรียนที่ค้นหา</td></tr>';
            } else {
                data.forEach(s => {
                    const statusClass = (s.StudentStatus && s.StudentStatus.includes('ปกติ')) ? 'bg-label-success' : 'bg-label-danger';
                    const editUrl = "<?= base_url('Admin/Acade/Registration/Students/Edit') ?>/" + s.StudentID;
                    
                    globalSearchBody.innerHTML += `
                        <tr>
                            <td class="ps-3"><span class="fw-bold text-primary font-monospace">${s.StudentCode || ''}</span></td>
                            <td><span class="fw-medium">${s.StudentPrefix || ''}${s.StudentFirstName || ''} ${s.StudentLastName || ''}</span></td>
                            <td><span class="badge bg-label-info">${s.StudentClass || 'N/A'}</span></td>
                            <td><span class="badge ${statusClass}">${s.StudentStatus || '-'}</span></td>
                            <td class="pe-3 text-center">
                                <button type="button" class="btn btn-sm btn-icon btn-outline-secondary edit-student" data-id="${s.StudentID}">
                                    <i class="bx bx-edit-alt"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
            }
            
            globalSearchResult.classList.remove('d-none');
            Swal.close();

            // Scroll down to see results
            globalSearchResult.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        })
        .fail(function(xhr, status, error) {
            console.error('Error:', error);
            Swal.fire('ผิดพลาด', 'ไม่สามารถค้นหาข้อมูลได้: ' + (xhr.responseJSON ? xhr.responseJSON.message : error), 'error');
        });
    }

    // เพิ่มตัวดักฟังสำหรับปุ่มแก้ไขในผลการค้นหา (เพราะมันโหลดมาใหม่แบบ Dynamic)
    $(document).on('click', '.edit-student', function() {
        const studentId = $(this).data('id');
        // เรียกใช้ Modal แก้ไขตัวเดียวกับที่หน้าหลักใช้ครับ (ถ้ามี)
        window.location.href = "<?= base_url('Admin/Acade/Registration/Students/normal') ?>?edit=" + studentId;
    });
});
</script>
<?= $this->endSection() ?>