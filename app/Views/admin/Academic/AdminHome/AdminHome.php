<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Welcome Banner -->
    <div class="card bg-primary text-white mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="card-title text-white mb-0">ยินดีต้อนรับกลับมา</h2>
                    <p class="mb-0">ระบบงานสารสนเทศโรงเรียน สำหรับ Admin และเจ้าหน้าที่</p>
                </div>
                <div class="col-md-4 text-end">
                    <img src="<?= base_url('assets/images/welcome.svg') ?>" alt="Welcome" height="80">
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title mb-1">จำนวนนักเรียนทั้งหมด</h5>
                            <h3 class="mb-0">2,500</h3>
                        </div>
                        <div class="avatar bg-light-primary p-2">
                            <i class="bx bx-user text-primary fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between"> 
                        <div>
                            <h5 class="card-title mb-1">จำนวนครู</h5>
                            <h3 class="mb-0">150</h3>
                        </div>
                        <div class="avatar bg-light-info p-2">
                            <i class="bx bx-chalkboard text-info fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title mb-1">จำนวนห้องเรียน</h5>
                            <h3 class="mb-0">60</h3>
                        </div>
                        <div class="avatar bg-light-success p-2">
                            <i class="bx bx-building-house text-success fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title mb-1">รายวิชาทั้งหมด</h5>
                            <h3 class="mb-0">120</h3>
                        </div>
                        <div class="avatar bg-light-warning p-2">
                            <i class="bx bx-book text-warning fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar & Notifications -->
    <div class="row">
        <!-- Calendar -->
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">ปฏิทินกิจกรรมวิชาการ</h5>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">ประกาศและแจ้งเตือน</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">ประกาศตารางสอบปลายภาค</h6>
                                <small>3 วันที่แล้ว</small>
                            </div>
                            <p class="mb-1 text-muted">ตารางสอบปลายภาคเรียนที่ 1/2566</p>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">ส่งผลการเรียน</h6>
                                <small class="text-danger">เหลือ 2 วัน</small>
                            </div>
                            <p class="mb-1 text-muted">กำหนดส่งผลการเรียนภาคเรียนที่ 1/2566</p>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">ลงทะเบียนเรียนซ้ำ</h6>
                                <small>1 สัปดาห์ที่แล้ว</small>
                            </div>
                            <p class="mb-1 text-muted">เปิดระบบลงทะเบียนเรียนซ้ำ ภาคเรียนที่ 2/2566</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">เมนูลัด</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <a href="#" class="card text-center h-100 py-3">
                                <div class="card-body">
                                    <i class="bx bx-calendar mb-2 fs-1 text-primary"></i>
                                    <h6 class="card-title mb-0">จัดตารางเรียน</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="card text-center h-100 py-3">
                                <div class="card-body">
                                    <i class="bx bx-spreadsheet mb-2 fs-1 text-success"></i>
                                    <h6 class="card-title mb-0">บันทึกผลการเรียน</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="card text-center h-100 py-3">
                                <div class="card-body">
                                    <i class="bx bx-user-plus mb-2 fs-1 text-info"></i>
                                    <h6 class="card-title mb-0">ลงทะเบียนเรียน</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="card text-center h-100 py-3">
                                <div class="card-body">
                                    <i class="bx bx-file mb-2 fs-1 text-warning"></i>
                                    <h6 class="card-title mb-0">รายงานผล</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>