<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
/* ===== Dashboard Stat Cards ===== */
.stat-card {
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
}
.stat-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 35px rgba(0,0,0,0.12);
}
.stat-icon {
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    font-size: 1.75rem;
}
.stat-value {
    font-size: 2.25rem;
    font-weight: 700;
    line-height: 1.1;
}
.stat-label {
    font-size: 0.9rem;
    color: #6c757d;
    margin-top: 6px;
}
.stat-meta {
    font-size: 0.75rem;
    color: #a1a5b7;
}

/* ===== Chart Section ===== */
.chart-container {
    position: relative;
    height: 280px;
    width: 100%;
}

/* ===== Shortcut Cards ===== */
.shortcut-card {
    transition: all 0.2s ease;
    border-radius: 10px;
}
.shortcut-card:hover {
    background-color: rgba(40, 167, 69, 0.08);
    transform: scale(1.02);
}

/* ===== Recent Students Table ===== */
.recent-table th {
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    color: #6c757d;
    border-bottom-width: 2px;
}
.recent-table td {
    vertical-align: middle;
    padding: 0.85rem;
}

/* ===== Welcome Banner ===== */
.welcome-banner {
    background: linear-gradient(135deg, #28a745 0%, #218838 50%, #1e7e34 100%);
    border-radius: 16px;
    color: #fff;
    padding: 2rem;
    position: relative;
    overflow: hidden;
}
.welcome-banner::before {
    content: '';
    position: absolute;
    top: -40%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
}
.welcome-banner h2 {
    font-size: 1.75rem;
    font-weight: 700;
}
.welcome-banner p {
    opacity: 0.9;
    margin-bottom: 0;
}
</style>

<div class="container-xl py-4">
    <!-- Welcome Banner -->
    <div class="welcome-banner mb-4 shadow-lg">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="mb-2">
                    <i class="bx bx-user-circle me-2"></i>จัดการข้อมูลนักเรียน
                </h2>
                <p>ระบบสรุปภาพรวมและจัดการข้อมูลนักเรียนทั้งหมดในสถานศึกษา</p>
            </div>
            <div class="col-md-4 text-end d-none d-md-block">
                <i class="bx bx-graduation" style="font-size: 6rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>

    <!-- Dashboard Stats -->
    <div class="row g-4 mb-4">
        <!-- Normal Students -->
        <div class="col-sm-6 col-xl-3">
            <a href="<?=base_url('Admin/Acade/Registration/Students/normal')?>" class="text-decoration-none">
                <div class="card stat-card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <div class="stat-value text-success" id="stat-normal"><?=$CountNormalStu->stunormal ?? 0?></div>
                                <div class="stat-label">นักเรียนปกติ</div>
                            </div>
                            <div class="stat-icon bg-success bg-opacity-10 text-success">
                                <i class="bx bx-user-check"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="stat-meta"><i class="bx bx-check-circle me-1"></i>สถานะปกติ</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Absent Students -->
        <div class="col-sm-6 col-xl-3">
            <a href="<?=base_url('Admin/Acade/Registration/Students/absent_long')?>" class="text-decoration-none">
                <div class="card stat-card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <div class="stat-value text-danger" id="stat-absent"><?=$CountAbsentStu->stuabsent ?? 0?></div>
                                <div class="stat-label">ขาดเรียนนาน</div>
                            </div>
                            <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                                <i class="bx bx-user-x"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="stat-meta text-danger"><i class="bx bx-error-circle me-1"></i>ต้องติดตาม</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Dismissed Students -->
        <div class="col-sm-6 col-xl-3">
            <a href="<?=base_url('Admin/Acade/Registration/Students/dismissed')?>" class="text-decoration-none">
                <div class="card stat-card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <div class="stat-value text-warning" id="stat-dismissed">--</div>
                                <div class="stat-label">นักเรียนจำหน่าย</div>
                            </div>
                            <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                                <i class="bx bx-user-minus"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="stat-meta"><i class="bx bx-info-circle me-1"></i>พ้นสภาพ</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- All Students -->
        <div class="col-sm-6 col-xl-3">
            <a href="<?=base_url('Admin/Acade/Registration/Students/studying')?>" class="text-decoration-none">
                <div class="card stat-card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <div class="stat-value text-primary" id="stat-all"><?=$CountAllStu->stuall ?? 0?></div>
                                <div class="stat-label">นักเรียนทั้งหมด</div>
                            </div>
                            <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                                <i class="bx bx-group"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="stat-meta"><i class="bx bx-id-card me-1"></i>กำลังศึกษา</span>
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
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-bar-chart-alt-2 text-success me-2"></i>จำนวนนักเรียนแต่ละระดับชั้น
                    </h5>
                    <span class="badge bg-light text-muted">แยกชาย-หญิง</span>
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
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-pie-chart-alt text-success me-2"></i>สัดส่วนนักเรียนชาย-หญิง
                    </h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <div class="chart-container flex-grow-1">
                        <canvas id="chart-doughnut-gender"></canvas>
                    </div>
                    <div class="row mt-3 text-center">
                        <div class="col-6">
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="badge bg-success rounded-circle p-2 me-2"><i class="bx bx-male"></i></span>
                                <div>
                                    <div class="fw-bold" id="stats_male_student">0</div>
                                    <small class="text-muted">นักเรียนชาย</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="badge bg-warning rounded-circle p-2 me-2"><i class="bx bx-female"></i></span>
                                <div>
                                    <div class="fw-bold" id="stats_female_student">0</div>
                                    <small class="text-muted">นักเรียนหญิง</small>
                                </div>
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
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-time-five text-success me-2"></i>นักเรียนที่เพิ่มล่าสุด
                    </h5>
                    <a href="<?=base_url('Admin/Acade/Registration/Students/studying')?>" class="btn btn-sm btn-outline-success">
                        <i class="bx bx-list-ul me-1"></i>ดูทั้งหมด
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover recent-table mb-0">
                            <thead class="table-light">
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
                                    <td colspan="5" class="text-center py-4">
                                        <div class="spinner-border text-success" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="text-muted mt-2 mb-0">กำลังโหลดข้อมูล...</p>
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
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-zap text-success me-2"></i>ทางลัด
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <!-- Add Student -->
                        <a href="https://docs.google.com/spreadsheets/d/1Je4jmVm3l84xDMAJDqQtdrRB13wWwFl2Fy2b7FvX1Ec/edit?gid=0#gid=0" target="_blank" class="btn btn-outline-success text-start shortcut-card py-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-success bg-opacity-10 p-2 me-3">
                                    <i class="bx bx-user-plus text-success" style="font-size: 1.25rem;"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">เพิ่มข้อมูลนักเรียน</div>
                                    <small class="text-muted">Google Sheet</small>
                                </div>
                                <i class="bx bx-chevron-right ms-auto text-muted"></i>
                            </div>
                        </a>

                        <!-- Import Students -->
                        <a href="<?=base_url('Admin/Acade/Registration/StudentsUpdate')?>" id="importStudentsBtn" class="btn btn-outline-success text-start shortcut-card py-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-success bg-opacity-10 p-2 me-3">
                                    <i class="bx bx-import text-success" style="font-size: 1.25rem;"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">นำเข้าข้อมูลนักเรียน</div>
                                    <small class="text-muted">จาก Google Sheet</small>
                                </div>
                                <i class="bx bx-chevron-right ms-auto text-muted"></i>
                            </div>
                        </a>

                        <!-- Export Students -->
                        <a href="<?= site_url('admin/academic/students/export/all') ?>" class="btn btn-outline-info text-start shortcut-card py-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-info bg-opacity-10 p-2 me-3">
                                    <i class="bx bx-export text-info" style="font-size: 1.25rem;"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">ส่งออกข้อมูลทั้งหมด</div>
                                    <small class="text-muted">ดาวน์โหลด Excel</small>
                                </div>
                                <i class="bx bx-chevron-right ms-auto text-muted"></i>
                            </div>
                        </a>

                        <!-- View Normal Students -->
                        <a href="<?=base_url('Admin/Acade/Registration/Students/normal')?>" class="btn btn-outline-secondary text-start shortcut-card py-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-secondary bg-opacity-10 p-2 me-3">
                                    <i class="bx bx-search-alt text-secondary" style="font-size: 1.25rem;"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">ค้นหานักเรียน</div>
                                    <small class="text-muted">รายชื่อนักเรียนปกติ</small>
                                </div>
                                <i class="bx bx-chevron-right ms-auto text-muted"></i>
                            </div>
                        </a>
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
                        backgroundColor: 'rgba(40, 167, 69, 0.7)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        borderWidth: 1,
                        borderRadius: 6
                    },
                    {
                        label: 'หญิง',
                        data: [],
                        backgroundColor: 'rgba(255, 193, 7, 0.7)',
                        borderColor: 'rgba(255, 193, 7, 1)',
                        borderWidth: 1,
                        borderRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { 
                    y: { 
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                },
                plugins: { 
                    legend: { 
                        display: true,
                        position: 'top'
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
                    backgroundColor: ['rgba(40, 167, 69, 0.85)', 'rgba(255, 193, 7, 0.85)'],
                    borderWidth: 0,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
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
                                <td><span class="badge bg-light text-dark">${student.StudentCode}</span></td>
                                <td><span class="fw-medium">${student.Fullname}</span></td>
                                <td><span class="badge bg-primary bg-opacity-10 text-primary">${student.StudentClass}</span></td>
                                <td><span class="badge bg-success">${student.StudentStatus}</span></td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-outline-success" href="<?=base_url('Admin/Acade/Registration/Students/normal')?>">
                                        <i class="bx bx-search me-1"></i>ค้นหา
                                    </a>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    tableHtml = '<tr><td colspan="5" class="text-center py-4 text-muted">ไม่พบข้อมูลนักเรียนล่าสุด</td></tr>';
                }
                recentStudentsTable.innerHTML = tableHtml;
            })
            .catch(error => {
                console.error('Error loading dashboard data:', error);
                recentStudentsTable.innerHTML = '<tr><td colspan="5" class="text-center py-4 text-danger"><i class="bx bx-error-circle me-1"></i>ไม่สามารถโหลดข้อมูลได้</td></tr>';
                Swal.fire({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ไม่สามารถโหลดข้อมูล Dashboard ได้: ' + error.message,
                    icon: 'error',
                    confirmButtonText: 'ตกลง'
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
                html: '<i class="bx bx-loader-circle bx-spin bx-lg"></i><br><br>กรุณารอสักครู่ ระบบกำลังดึงและประมวลผลข้อมูลจาก Google Sheet...',
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