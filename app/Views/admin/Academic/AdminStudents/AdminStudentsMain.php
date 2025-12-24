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

.stat-icon-wrapper.bg-success-gradient {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: #fff;
}

.stat-icon-wrapper.bg-danger-gradient {
    background: linear-gradient(135deg, #dc3545 0%, #ff6b6b 100%);
    color: #fff;
}

.stat-icon-wrapper.bg-warning-gradient {
    background: linear-gradient(135deg, #ffc107 0%, #ffda44 100%);
    color: #fff;
}

.stat-icon-wrapper.bg-primary-gradient {
    background: linear-gradient(135deg, #007bff 0%, #17a2b8 100%);
    color: #fff;
}

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
    border-bottom: 1px solid rgba(0,0,0,0.05);
    padding: 1.25rem 1.5rem;
}

.chart-card .card-header h5 {
    font-weight: 600;
    color: #212529;
    margin: 0;
}

.chart-card .card-header h5 i {
    color: var(--primary-green);
}

.chart-card .card-body {
    padding: 1.5rem;
}

.chart-container {
    position: relative;
    height: 280px;
    width: 100%;
}

/* Gender Stats Cards */
.gender-stat {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 1rem;
    text-align: center;
    transition: all 0.3s ease;
}

.gender-stat:hover {
    background: #e9ecef;
    transform: scale(1.02);
}

.gender-stat .icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
}

.gender-stat .icon.male {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: #fff;
}

.gender-stat .icon.female {
    background: linear-gradient(135deg, #fd7e14 0%, #ffc107 100%);
    color: #fff;
}

.gender-stat .count {
    font-size: 1.5rem;
    font-weight: 700;
    color: #212529;
}

.gender-stat .label {
    font-size: 0.85rem;
    color: #6c757d;
}

/* ===== Recent Students Table ===== */
.recent-card {
    background: #fff;
    border-radius: 16px;
    border: none;
    box-shadow: var(--card-shadow);
    overflow: hidden;
}

.recent-card .card-header {
    background: transparent;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    padding: 1.25rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.recent-card .card-header h5 {
    font-weight: 600;
    color: #212529;
    margin: 0;
}

.recent-card .card-header h5 i {
    color: var(--primary-green);
}

.recent-table {
    margin-bottom: 0;
}

.recent-table thead th {
    background: #f8f9fa;
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6c757d;
    border-bottom: none;
    padding: 1rem 1.25rem;
}

.recent-table tbody td {
    padding: 1rem 1.25rem;
    vertical-align: middle;
    border-color: rgba(0,0,0,0.03);
}

.recent-table tbody tr {
    transition: background 0.2s ease;
}

.recent-table tbody tr:hover {
    background: rgba(40, 167, 69, 0.03);
}

.student-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.student-badge.badge-code {
    background: #e9ecef;
    color: #495057;
}

.student-badge.badge-class {
    background: #e3f2fd;
    color: #1976d2;
}

.student-badge.badge-status {
    background: #d4edda;
    color: #28a745;
}

/* ===== Quick Actions ===== */
.quick-actions-card {
    background: #fff;
    border-radius: 16px;
    border: none;
    box-shadow: var(--card-shadow);
    height: 100%;
}

.quick-actions-card .card-header {
    background: transparent;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    padding: 1.25rem 1.5rem;
}

.quick-actions-card .card-header h5 {
    font-weight: 600;
    color: #212529;
    margin: 0;
}

.quick-actions-card .card-header h5 i {
    color: var(--primary-green);
}

.quick-action-btn {
    display: flex;
    align-items: center;
    width: 100%;
    padding: 1rem;
    border: 2px solid transparent;
    border-radius: 12px;
    background: #f8f9fa;
    transition: all 0.3s ease;
    text-decoration: none;
    color: inherit;
}

.quick-action-btn:hover {
    background: #fff;
    border-color: var(--primary-green);
    transform: translateX(5px);
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.15);
}

.quick-action-btn .action-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    margin-right: 1rem;
    transition: transform 0.3s ease;
}

.quick-action-btn:hover .action-icon {
    transform: scale(1.1);
}

.quick-action-btn .action-content {
    flex: 1;
}

.quick-action-btn .action-title {
    font-weight: 600;
    color: #212529;
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
    <!-- Welcome Banner -->
    <div class="welcome-banner mb-4">
        <div class="content">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1>
                        <i class="bx bx-book-reader me-2"></i>จัดการข้อมูลนักเรียน
                    </h1>
                    <p>ระบบจัดการข้อมูลนักเรียนในสถานศึกษา สำหรับตรวจสอบ แก้ไข และบริหารจัดการนักเรียนทั้งหมด</p>
                </div>
                <div class="col-md-4 text-end d-none d-md-block">
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
        <div class="col-sm-6 col-xl-3">
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
        <div class="col-sm-6 col-xl-3">
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

        <!-- Dismissed Students -->
        <div class="col-sm-6 col-xl-3">
            <a href="<?=base_url('Admin/Acade/Registration/Students/dismissed')?>" class="text-decoration-none">
                <div class="card stat-card card-warning h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <div class="stat-value text-warning" id="stat-dismissed">--</div>
                                <div class="stat-label">นักเรียนจำหน่าย</div>
                                <div class="stat-trend">
                                    <i class="bx bx-info-circle me-1"></i>พ้นสภาพ
                                </div>
                            </div>
                            <div class="stat-icon-wrapper bg-warning-gradient">
                                <i class="bx bx-user-minus"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- All Students -->
        <div class="col-sm-6 col-xl-3">
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

    <!-- Quick Actions & Recent Students -->
    <div class="row g-4">
        <!-- Recent Students Table -->
        <div class="col-xl-8 col-12">
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

        <!-- Quick Actions -->
        <div class="col-xl-4 col-12">
            <div class="card quick-actions-card">
                <div class="card-header">
                    <h5><i class="bx bx-rocket me-2"></i>เมนูลัด</h5>
                </div>
                <div class="card-body d-flex flex-column gap-3">
                    <!-- Add Student -->
                    <a href="https://docs.google.com/spreadsheets/d/1Je4jmVm3l84xDMAJDqQtdrRB13wWwFl2Fy2b7FvX1Ec/edit?gid=0#gid=0" target="_blank" class="quick-action-btn">
                        <div class="action-icon" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                            <i class="bx bx-user-plus text-white"></i>
                        </div>
                        <div class="action-content">
                            <div class="action-title">เพิ่มข้อมูลนักเรียน</div>
                            <div class="action-subtitle">Google Sheet</div>
                        </div>
                        <i class="bx bx-chevron-right action-arrow"></i>
                    </a>

                    <!-- Import Students -->
                    <a href="<?=base_url('Admin/Acade/Registration/StudentsUpdate')?>" id="importStudentsBtn" class="quick-action-btn">
                        <div class="action-icon" style="background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%);">
                            <i class="bx bx-import text-white"></i>
                        </div>
                        <div class="action-content">
                            <div class="action-title">นำเข้าข้อมูลนักเรียน</div>
                            <div class="action-subtitle">จาก Google Sheet</div>
                        </div>
                        <i class="bx bx-chevron-right action-arrow"></i>
                    </a>

                    <!-- Export Students -->
                    <a href="<?= site_url('admin/academic/students/export/all') ?>" class="quick-action-btn">
                        <div class="action-icon" style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);">
                            <i class="bx bx-export text-white"></i>
                        </div>
                        <div class="action-content">
                            <div class="action-title">ส่งออกข้อมูลทั้งหมด</div>
                            <div class="action-subtitle">ดาวน์โหลด Excel</div>
                        </div>
                        <i class="bx bx-chevron-right action-arrow"></i>
                    </a>

                    <!-- View Normal Students -->
                    <a href="<?=base_url('Admin/Acade/Registration/Students/normal')?>" class="quick-action-btn">
                        <div class="action-icon" style="background: linear-gradient(135deg, #6c757d 0%, #adb5bd 100%);">
                            <i class="bx bx-search-alt text-white"></i>
                        </div>
                        <div class="action-content">
                            <div class="action-title">ค้นหานักเรียน</div>
                            <div class="action-subtitle">รายชื่อนักเรียนปกติ</div>
                        </div>
                        <i class="bx bx-chevron-right action-arrow"></i>
                    </a>
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
});
</script>
<?= $this->endSection() ?>