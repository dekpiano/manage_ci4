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
                            <h3 class="mb-0"><?= $total_students ?></h3>
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
                            <h3 class="mb-0"><?= $total_teachers ?></h3>
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
                            <h3 class="mb-0"><?= $total_classrooms ?></h3>
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
                            <h3 class="mb-0"><?= $total_subjects ?></h3>
                        </div>
                        <div class="avatar bg-light-warning p-2">
                            <i class="bx bx-book text-warning fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

 
</div>
<?= $this->endSection() ?>