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
    .hero-backup {
        background: linear-gradient(135deg, var(--primary-emerald) 0%, var(--dark-emerald) 100%);
        border-radius: var(--border-radius);
        padding: 2.5rem;
        color: white;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(21, 163, 98, 0.15);
    }

    .hero-backup::after {
        content: '\ec83'; /* Boxicons 'bx-cloud-upload' icon */
        font-family: 'boxicons' !important;
        position: absolute;
        bottom: -20px;
        right: 10px;
        font-size: 15rem;
        color: rgba(255, 255, 255, 0.05);
        pointer-events: none;
    }

    /* Table List Layout */
    .table-container-card {
        border: none;
        border-radius: var(--border-radius);
        background: white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        overflow: hidden;
    }

    .table-list-header {
        background-color: var(--light-emerald);
        border-bottom: 1px solid rgba(21, 163, 98, 0.1);
        padding: 1.5rem;
    }

    .form-check-input:checked {
        background-color: var(--primary-emerald);
        border-color: var(--primary-emerald);
    }

    .badge-emerald {
        background-color: var(--light-emerald);
        color: var(--primary-emerald);
        font-weight: 600;
        border-radius: 8px;
        padding: 6px 12px;
    }

    .btn-emerald {
        background-color: var(--primary-emerald);
        border-color: var(--primary-emerald);
        color: white;
        font-weight: 500;
        padding: 0.8rem 1.5rem;
        border-radius: 12px;
        transition: all 0.3s;
    }

    .btn-emerald:hover {
        background-color: var(--dark-emerald);
        border-color: var(--dark-emerald);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(21, 163, 98, 0.3);
        color: white;
    }

    .table-row:hover {
        background-color: #fcfdfc;
    }

    .select-all-card {
        cursor: pointer;
        transition: all 0.3s;
    }

    .select-all-card:hover {
        background-color: var(--light-emerald);
    }

    /* Animation */
    .animate-in {
        animation: fadeInSlideUp 0.6s ease-out forwards;
    }

    @keyframes fadeInSlideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Hero Header -->
    <div class="hero-backup animate-in">
        <div class="row align-items-center">
            <div class="col-md-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/home') ?>" class="text-white opacity-75">Home</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">System Backup</li>
                    </ol>
                </nav>
                <h1 class="fw-bold text-white mb-2"><i class='bx bx-data me-2'></i>ตัวช่วยสำรองข้อมูลอัจฉริยะ</h1>
                <p class="mb-0 text-white opacity-75">
                    จัดเก็บข้อมูลสำคัญของคุณด้วยความปลอดภัยสูงสุด สำหรับผู้ดูแลระบบขั้นสูงเท่านั้น
                </p>
            </div>
            <div class="col-md-4 text-md-end mt-4 mt-md-0">
                <div class="badge bg-white text-emerald p-2 px-3 rounded-pill shadow-sm">
                    <i class='bx bx-shield-quarter me-1'></i> SQL Standard Format
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-12 animate-in" style="animation-delay: 0.1s;">
            <form action="<?= base_url('admin/academic/backup/run') ?>" method="post" id="backupForm">
                <?= csrf_field() ?>
                
                <div class="card table-container-card">
                    <div class="table-list-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-bold text-dark"><i class='bx bx-table me-2 text-emerald'></i>เลือกตารางข้อมูลที่ต้องการ</h4>
                            <p class="mb-0 text-muted small">ฐานข้อมูลปัจจุบัน: <span class="fw-bold text-emerald"><?= esc($db_name) ?></span></p>
                        </div>
                        <div class="d-flex gap-2">
                             <button type="button" class="btn btn-outline-secondary rounded-pill btn-sm px-3" id="btn-select-all">
                                <i class='bx bx-check-double me-1'></i> เลือกทั้งหมด
                            </button>
                             <button type="button" class="btn btn-outline-secondary rounded-pill btn-sm px-3" id="btn-deselect-all">
                                <i class='bx bx-x me-1'></i> ยกเลิกทั้งหมด
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="bg-light">
                                    <th width="80" class="text-center">เลือก</th>
                                    <th>ชื่อตาราง (Table Name)</th>
                                    <th class="text-center">จำนวนแถว (Rows)</th>
                                    <th class="text-center">สถานะความสำคัญ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tables as $index => $table) : ?>
                                <tr class="table-row">
                                    <td class="text-center align-middle">
                                        <div class="form-check d-flex justify-content-center">
                                            <input class="form-check-input table-checkbox" type="checkbox" name="tables[]" value="<?= esc($table['name']) ?>" id="check-<?= $index ?>">
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <label for="check-<?= $index ?>" class="fw-bold text-dark cursor-pointer d-flex align-items-center">
                                            <i class='bx bx-cube-alt me-2 text-muted'></i>
                                            <?= esc($table['name']) ?>
                                        </label>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge-emerald"><?= number_format($table['rows']) ?> แถว</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?php if($table['rows'] > 1000): ?>
                                            <span class="badge bg-label-warning text-warning fw-semibold rounded-pill px-3">High Capacity</span>
                                        <?php else: ?>
                                            <span class="badge bg-label-success text-success fw-semibold rounded-pill px-3">Stable</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer bg-white border-top p-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <p class="text-muted small mb-0">
                                    <i class='bx bx-info-circle me-1'></i> 
                                    ระบบจะสร้างไฟล์ .sql ที่ประกอบด้วยคำสั่งในการสร้างตาราง (CREATE) และข้อมูลทั้งหมด (INSERT) โดยปิดการตรวจสอบ Foreign Key ชั่วคราวในขณะนำเข้าข้อมูลใหม่
                                </p>
                            </div>
                            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                <button type="submit" class="btn btn-emerald btn-lg w-100 w-md-auto" id="btn-backup-now">
                                    <i class='bx bx-cloud-download me-2'></i> เริ่มต้นกระบวนการสำรองข้อมูล
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        // Select All handler
        $('#btn-select-all').on('click', function() {
            $('.table-checkbox').prop('checked', true);
        });

        // Deselect All handler
        $('#btn-deselect-all').on('click', function() {
            $('.table-checkbox').prop('checked', false);
        });

        // Form Submit handler with Confirmation
        $('#backupForm').on('submit', function(e) {
            e.preventDefault();
            const form = this;
            const checkedCount = $('.table-checkbox:checked').length;
            
            if (checkedCount === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'กรุณาเลือกตาราง',
                    text: 'คุณต้องเลือกอย่างน้อย 1 ตาราง เพื่อทำการสำรองข้อมูล',
                    confirmButtonColor: '#15a362'
                });
                return false;
            }

            Swal.fire({
                title: 'ยืนยันการสำรองข้อมูล?',
                text: `คุณกำลังจะสำรองข้อมูลจำนวน ${checkedCount} ตาราง`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#15a362',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'ตกลง, เริ่มเลย',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    const originalContent = $('#btn-backup-now').html();
                    $('#btn-backup-now').html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> กำลังดำเนินการ...');
                    $('#btn-backup-now').addClass('disabled');

                    // Submit the form
                    form.submit();

                    // Reset button after a short delay (enough for browser to handle the download)
                    setTimeout(function() {
                        $('#btn-backup-now').html(originalContent);
                        $('#btn-backup-now').removeClass('disabled');
                    }, 3000);
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>
