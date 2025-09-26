<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
    /* Custom styles for better UX/UI */
    body {
        font-size: 0.95rem; /* Adjust base font size for overall balance */
    }
    .page-title {
        font-size: 2.2rem; /* Larger title */
        margin-bottom: 1.5rem;
    }
    h3 {
        font-size: 1.6rem;
    }
    h4 {
        font-size: 1.2rem;
    }
    .border-left-decoration {
        border-left: .25rem solid var(--bs-primary) !important; /* Use Bootstrap primary color */
    }
    .card-stat .icon-holder {
        font-size: 2.8rem; /* Slightly larger icons */
        color: var(--bs-primary);
        margin-bottom: 0.8rem;
        display: inline-block;
    }
    .card-stat.normal-student-card .icon-holder { color: var(--bs-success); }
    .card-stat.absent-student-card .icon-holder { color: var(--bs-danger); }
    .card-stat.dismissed-student-card .icon-holder { color: var(--bs-warning); }
    .card-stat.all-student-card .icon-holder { color: var(--bs-info); }

    .card-stat .stats-figure {
        font-size: 2.5rem; /* Larger stats numbers */
        font-weight: 700;
        color: var(--bs-heading-color);
    }
    .card-stat .stats-meta {
        font-size: 1rem; /* Readable meta text */
        color: var(--bs-secondary-color);
    }
    .card-link-mask {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 1;
    }
    .list-group-item-action:hover {
        background-color: var(--bs-light);
    }
    .chart-container {
        position: relative;
        height: 300px; /* Fixed height for charts */
        width: 100%;
    }
    .table th, .table td {
        font-size: 0.9rem; /* Adjust table font size for readability */
    }
</style>
<div class="content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">

       
        <div class="card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
            <div class="inner">
                <div class="card-body p-3 p-lg-4">
                    <h3 class="mb-3">หน้าสรุปภาพรวมข้อมูลนักเรียน</h3>
                    <div class="row gx-5 gy-3">
                        <div class="col-12 col-lg-9">
                            <div>ในส่วนนี้จะแสดงข้อมูลสรุปของนักเรียนทั้งหมดในระบบ และมีทางลัดสำหรับจัดการข้อมูลในส่วนที่สำคัญ</div>
                        </div>
                        <!-- <div class="col-12 col-lg-3">
                            <a class="btn btn-primary" href="https://docs.google.com/spreadsheets/d/1Je4jmVm3l84xDMAJDqQtdrRB13wWwFl2Fy2b7FvX1Ec/edit?gid=0#gid=0" target="_blank"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-earmark-arrow-up me-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.5 11.5a.5.5 0 0 1-1 0V7.707L6.354 8.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1-.708 0l2 2a.5.5 0 0 1-.708.708L8.5 7.707V11.5z"/>
                            <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                            </svg>อัพเดพข้อมูลจาก Google Sheet</a>
                        </div> -->
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>

        <!-- ส่วนที่ 1: สรุปข้อมูลภาพรวม (Key Metrics) -->
        <div class="row g-4 mb-4">
            <div class="col-6 col-lg-3">
                <div class="card card-stat shadow-sm h-100 all-student-card">
                    <div class="card-body p-3 p-lg-4">
                        <div class="icon-holder mb-2">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h4 class="stats-type mb-1">นักเรียนทั้งหมด</h4>
                        <div class="stats-figure"><?=$CountAllStu->stuall?></div>
                        <div class="stats-meta">คน</div>
                    </div>
                    <a class="card-link-mask" href="<?=base_url('Admin/Acade/Registration/Students/studying')?>"></a>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card card-stat shadow-sm h-100 normal-student-card">
                    <div class="card-body p-3 p-lg-4">
                        <div class="icon-holder mb-2">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <h4 class="stats-type mb-1">นักเรียนปกติ</h4>
                        <div class="stats-figure"><?=$CountNormalStu->stunormal?></div>
                        <div class="stats-meta">คน</div>
                    </div>
                    <a class="card-link-mask" href="<?=base_url('Admin/Acade/Registration/Students/normal')?>"></a>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card card-stat shadow-sm h-100 absent-student-card">
                    <div class="card-body p-3 p-lg-4">
                        <div class="icon-holder mb-2">
                            <i class="bi bi-person-x-fill"></i>
                        </div>
                        <h4 class="stats-type mb-1">นักเรียนขาดเรียนนาน</h4>
                        <div class="stats-figure"><?=$CountAbsentStu->stuabsent?></div>
                        <div class="stats-meta text-danger">คน</div>
                    </div>
                    <a class="card-link-mask" href="<?=base_url('Admin/Acade/Registration/Students/absent_long')?>"></a>
                </div>
            </div>
             <div class="col-6 col-lg-3">
                <div class="card card-stat shadow-sm h-100 dismissed-student-card">
                    <div class="card-body p-3 p-lg-4">
                        <div class="icon-holder mb-2">
                            <i class="bi bi-person-dash-fill"></i>
                        </div>
                        <h4 class="stats-type mb-1">นักเรียนจำหน่าย</h4>
                        <div class="stats-figure">--</div> <!-- Placeholder, needs controller logic -->
                        <div class="stats-meta text-warning">คน</div>
                    </div>
                    <a class="card-link-mask" href="<?=base_url('Admin/Acade/Registration/Students/dismissed')?>"></a>
                </div>
            </div>
        </div>

        <!-- ส่วนที่ 2: การแสดงผลด้วยภาพ -->
        <div class="row g-4 mb-4">
            <div class="col-12 col-lg-7">
                <div class="card card-chart h-100 shadow-sm">
                    <div class="card-header p-3">
                        <h4 class="card-title">จำนวนนักเรียนแต่ละระดับชั้น</h4>
                    </div>
                    <div class="card-body p-3 p-lg-4">
                        <div class="chart-container">
                            <canvas id="chart-bar-students-by-class"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="card card-chart h-100 shadow-sm">
                    <div class="card-header p-3">
                        <h4 class="card-title">สัดส่วนนักเรียนชาย-หญิง</h4>
                    </div>
                    <div class="card-body p-3 p-lg-4">
                        <div class="chart-container">
                            <canvas id="chart-doughnut-gender"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ส่วนที่ 3: รายการล่าสุด และ ทางลัด -->
        <div class="row g-4 mb-4">
            <div class="col-12 col-lg-7">
                <div class="card card-orders-table shadow-sm mb-5">
                    <div class="card-body">
                        <div class="p-3">
                            <h4 class="card-title">นักเรียนที่เพิ่มล่าสุด</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 text-left">
                                <thead>
                                    <tr>
                                        <th class="cell">รหัสนักเรียน</th>
                                        <th class="cell">ชื่อ-สกุล</th>
                                        <th class="cell">ระดับชั้น</th>
                                        <th class="cell">สถานะ</th>
                                        <th class="cell"></th>
                                    </tr>
                                </thead>
                                <tbody id="recent_students_table">
                                    <tr>
                                        <td colspan="5" class="text-center p-3">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
             <div class="col-12 col-lg-5">
                <div class="card card-basic d-flex flex-column align-items-start shadow-sm">
                    <div class="card-header p-3 border-bottom-0">
                        <h4 class="card-title">ทางลัด</h4>
                    </div>
                    <div class="card-body px-4 py-2">
                       <ul class="list-group list-group-flush">
                            <li class="list-group-item list-group-item-action" style="cursor: pointer;"><i class="bi bi-person-plus-fill me-2"></i> <a href="https://docs.google.com/spreadsheets/d/1Je4jmVm3l84xDMAJDqQtdrRB13wWwFl2Fy2b7FvX1Ec/edit?gid=0#gid=0" target="_blank" rel="noopener noreferrer">เพิ่มข้อมูลนักเรียน</a> </li>
                            <li class="list-group-item list-group-item-action" style="cursor: pointer;"><i class="bi bi-file-earmark-excel-fill me-2"></i> <a href="<?=base_url('Admin/Acade/Registration/StudentsUpdate')?>">นำเข้าข้อมูลนักเรียน</a> </li>
                            <li class="list-group-item list-group-item-action" style="cursor: pointer;"><i class="bi bi-download me-2"></i> ส่งออกข้อมูลทั้งหมด</li>
                       </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<!-- สคริปต์สำหรับ Chart และโหลดข้อมูล -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // --- Element สำหรับแสดงผล ---
    const statsMale = document.getElementById('stats_male_student');
    const statsFemale = document.getElementById('stats_female_student');
    const recentStudentsTable = document.getElementById('recent_students_table');

    // --- Context สำหรับ Chart ---
    const barChartCanvas = document.getElementById('chart-bar-students-by-class');
    const barChartCtx = barChartCanvas ? barChartCanvas.getContext('2d') : null;
    let barChart; // Declare barChart here

    if (barChartCtx) {
        barChart = new Chart(barChartCtx, {
            type: 'bar',
            data: {
                labels: [], // จะถูกเติมจาก API
                datasets: [
                    {
                        label: 'ชาย',
                        data: [], // จะถูกเติมจาก API
                        backgroundColor: 'rgba(54, 162, 235, 0.5)'
                    },
                    {
                        label: 'หญิง',
                        data: [], // จะถูกเติมจาก API
                        backgroundColor: 'rgba(255, 99, 132, 0.5)'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { 
                    y: { 
                        beginAtZero: true 
                    } 
                },
                plugins: { 
                    legend: { 
                        display: true // แสดงคำอธิบาย ชาย/หญิง
                    } 
                }
            }
        });
    }

    const doughnutChartCanvas = document.getElementById('chart-doughnut-gender');
    const doughnutChartCtx = doughnutChartCanvas ? doughnutChartCanvas.getContext('2d') : null;
    let doughnutChart; // Declare doughnutChart here

    if (doughnutChartCtx) {
        doughnutChart = new Chart(doughnutChartCtx, {
            type: 'doughnut',
            data: {
                labels: ['ชาย', 'หญิง'],
                datasets: [{
                    data: [0, 0],
                    backgroundColor: ['rgb(54, 162, 235)', 'rgb(255, 99, 132)'],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });
    }

    // --- ฟังก์ชันสำหรับโหลดข้อมูลแดชบอร์ด ---
    function loadDashboardData() {
        fetch('<?=base_url("admin/academic/ConAdminStudents/getDashboardData")?>')
            .then(response => response.json())
            .then(data => {
                // 1. อัปเดต Key Metrics
                if (statsMale) {
                    statsMale.textContent = data.gender_count.male || '0';
                }
                if (statsFemale) {
                    statsFemale.textContent = data.gender_count.female || '0';
                }

                // 2. อัปเดตกราฟแท่ง (นักเรียนตามระดับชั้น แยกชาย/หญิง)
                if (barChart) {
                    barChart.data.labels = data.students_by_class.labels;
                    // ตรวจสอบว่ามี datasets หรือไม่ก่อนที่จะเข้าถึง
                    if(data.students_by_class.datasets && data.students_by_class.datasets.length >= 2) {
                        barChart.data.datasets[0].data = data.students_by_class.datasets[0].data; // ชาย
                        barChart.data.datasets[1].data = data.students_by_class.datasets[1].data; // หญิง
                    }
                    barChart.update();
                }

                // 3. อัปเดตกราฟวงกลม (สัดส่วนเพศ)
                if (doughnutChart) {
                    doughnutChart.data.datasets[0].data[0] = data.gender_count.male || 0;
                    doughnutChart.data.datasets[0].data[1] = data.gender_count.female || 0;
                    doughnutChart.update();
                }

                // 4. อัปเดตตารางนักเรียนล่าสุด
                let tableHtml = '';
                if (data.recent_students && data.recent_students.length > 0) {
                    data.recent_students.forEach(student => {
                        tableHtml += `
                            <tr>
                                <td class="cell">${student.StudentCode}</td>
                                <td class="cell"><span class="truncate">${student.Fullname}</span></td>
                                <td class="cell">${student.StudentClass}</td>
                                <td class="cell"><span class="badge bg-success">${student.StudentStatus}</span></td>
                                <td class="cell"><a class="btn-sm btn-secondary" href="<?=base_url('Admin/Acade/Registration/Students/Edit/')?>${student.StudentID}">ดูรายละเอียด</a></td>
                            </tr>
                        `;
                    });
                } else {
                    tableHtml = '<tr><td colspan="5" class="text-center">ไม่พบข้อมูลนักเรียนล่าสุด</td></tr>';
                }
                recentStudentsTable.innerHTML = tableHtml;

            })
            .catch(error => {
                console.error('Error loading dashboard data:', error);
                statsMale.textContent = 'Error';
                statsFemale.textContent = 'Error';
                recentStudentsTable.innerHTML = '<tr><td colspan="5" class="text-center text-danger">ไม่สามารถโหลดข้อมูลได้</td></tr>';
                Swal.fire({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ไม่สามารถโหลดข้อมูล Dashboard ได้: ' + error.message,
                    icon: 'error',
                    confirmButtonText: 'ตกลง'
                });
            });
    }

    // เรียกใช้ฟังก์ชันเมื่อหน้าเว็บโหลดเสร็จ
    loadDashboardData();
});
</script>
<?= $this->endSection() ?>