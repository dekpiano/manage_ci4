<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
    :root {
        --primary-emerald: #15a362;
        --dark-emerald: #0d6d41;
        --light-emerald: #e8f5ee;
    }

    /* Hero Section */
    .hero-settings {
        background: linear-gradient(135deg, var(--primary-emerald) 0%, var(--dark-emerald) 100%);
        border-radius: 1.5rem;
        padding: 2.5rem;
        color: white;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(21, 163, 98, 0.15);
    }

    .hero-settings::after {
        content: '';
        position: absolute;
        bottom: -20%;
        right: -5%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .status-badge {
        font-size: 0.75rem;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 700;
    }

    .status-active {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    /* Premium Card */
    .settings-card {
        border: none;
        border-radius: 1.25rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.03);
        transition: transform 0.3s ease;
    }

    .icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        background: var(--light-emerald);
        color: var(--primary-emerald);
        margin-bottom: 1.5rem;
    }

    /* Form Controls */
    .form-check-input:checked {
        background-color: var(--primary-emerald);
        border-color: var(--primary-emerald);
    }

    .btn-emerald {
        background-color: var(--primary-emerald);
        border-color: var(--primary-emerald);
        color: white;
        padding: 0.7rem 2rem;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-emerald:hover {
        background-color: var(--dark-emerald);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(21, 163, 98, 0.2);
    }

    .form-check-lg .form-check-input {
        width: 3.5rem;
        height: 1.75rem;
        cursor: pointer;
    }

    /* Select2 Emerald Styling */
    .select2-container--default .select2-selection--single {
        border: 1px solid #d9dee3;
        border-radius: 0.5rem;
        height: calc(2.25rem + 2px); /* Standard Bootstrap height */
        display: flex;
        align-items: center;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        background-color: #fff;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #697a8d;
        padding-left: 0.875rem;
        font-size: 0.9375rem;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100%;
        right: 8px;
    }

    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: var(--primary-emerald) !important;
        box-shadow: 0 0 0 0.25rem rgba(21, 163, 98, 0.1);
        outline: 0;
    }

    .select2-dropdown {
        border: 1px solid #d9dee3;
        border-top: none;
        border-radius: 0 0 0.5rem 0.5rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        z-index: 9999;
    }

    .select2-results__option--highlighted[aria-selected] {
        background-color: var(--primary-emerald) !important;
    }

    /* Balanced Alignment */
    .row-balanced {
        display: flex;
        align-items: center;
    }
    
    .form-label-balanced {
        margin-bottom: 0;
        font-weight: 600;
        color: #566a7f;
    }

    .card-title-balanced {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Hero Section -->
    <div class="hero-settings animate__animated animate__fadeIn">
        <div class="row align-items-center">
            <div class="col-lg-8 animate__animated animate__slideInLeft">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style2 mb-2">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white opacity-75">วิชาการ</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">ตั้งค่าคุณลักษณะฯ</li>
                    </ol>
                </nav>
                <h2 class="fw-bold mb-2 text-white card-title-balanced">
                    <i class='bx bx-cog'></i>
                    <span>ตั้งค่าระบบประเมินคุณลักษณะอันพึงประสงค์</span>
                </h2>
                <div class="d-flex align-items-center mt-3">
                    <span class="status-badge <?= ($settings->onoff_status === 'on' || $settings->onoff_status === 'true') ? 'status-active' : 'bg-light text-dark opacity-75' ?>">
                        <i class='bx bxs-circle me-1 small animate__animated animate__pulse animate__infinite'></i>
                        <?= ($settings->onoff_status === 'on' || $settings->onoff_status === 'true') ? 'ระบบกำลังเปิดใช้งาน' : 'ระบบปิดการใช้งาน' ?>
                    </span>
                    <span class="text-white-50 ms-3 small d-flex align-items-center"><i class='bx bx-calendar-event me-1'></i> <?= $settings->onoff_year ?: '-' ?></span>
                </div>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block animate__animated animate__zoomIn">
                <i class='bx bx-slider-alt text-white opacity-25' style="font-size: 8rem;"></i>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Configuration -->
        <div class="col-md-8">
            <div class="card settings-card animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
                <div class="card-body p-sm-5 p-4">
                    <div class="icon-wrapper shadow-sm">
                        <i class='bx bxs-check-shield'></i>
                    </div>
                    <h5 class="fw-bold mb-4 d-flex align-items-center"><i class='bx bx-list-check me-2 text-emerald'></i> กำหนดค่าพื้นฐานของระบบ</h5>
                    
                    <form action="<?= base_url('admin/academic/characteristics/update') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="row mb-4 row-balanced">
                            <label class="col-sm-4 form-label-balanced fw-semibold" for="status-toggle">สถานะระบบปัจจุบัน</label>
                            <div class="col-sm-8">
                                <div class="form-check form-switch form-check-lg m-0">
                                    <input class="form-check-input" type="checkbox" id="status-toggle" name="status" value="on" 
                                           <?= ($settings->onoff_status === 'on' || $settings->onoff_status === 'true') ? 'checked' : '' ?>>
                                    <label class="form-check-label ms-3 text-muted small" for="status-toggle">
                                        ( เลื่อนเพื่อเปิดหรือปิดใช้งาน )
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4 row-balanced">
                            <label class="col-sm-4 form-label-balanced fw-semibold" for="year-term-select">ปีการศึกษา/ภาคเรียน</label>
                            <div class="col-sm-8">
                                <div class="w-100">
                                    <select id="year-term-select" class="form-select select2" name="year_term" required>
                                        <option value="">เลือกปีการศึกษา/ภาคเรียน...</option>
                                        <?php foreach ($school_years as $year) : ?>
                                            <option value="<?= $year->year_term ?>" <?= ($settings->onoff_year == $year->year_term) ? 'selected' : '' ?>>
                                                ปีการศึกษา <?= explode('/', $year->year_term)[1] ?> / ภาคเรียนที่ <?= explode('/', $year->year_term)[0] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-text text-emerald mt-2 small d-flex align-items-center">
                                    <i class='bx bx-info-circle me-1'></i> <span>กำหนดช่วงเวลาสำหรับประมวลผลรายชื่อนักเรียน</span>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 opacity-50">

                        <div class="d-flex justify-content-end gap-2">
                             <a href="javascript:history.back();" class="btn btn-outline-secondary px-4 rounded-3">ยกเลิก</a>
                             <button type="submit" class="btn btn-emerald px-4 shadow-sm">
                                <i class='bx bx-save me-1'></i> บันทึกการตั้งค่า
                             </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Information / Help -->
        <div class="col-md-4">
            <div class="card settings-card h-100 animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-emerald mb-3"><i class='bx bxs-bulb me-1'></i> คำแนะนำการใช้งาน</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3 d-flex">
                            <i class='bx bx-check-double text-success me-2 mt-1'></i>
                            <span class="small text-muted">เมื่อคุณครูเข้ามาประเมิน ระบบจะบันทึกข้อมูลตาม ปีการศึกษา/ภาคเรียน ที่ระบุไว้นี้</span>
                        </li>
                        <li class="mb-3 d-flex">
                            <i class='bx bx-check-double text-success me-2 mt-1'></i>
                            <span class="small text-muted">หากมีการเปลี่ยนภาคเรียน ข้อมูลเดิมจะไม่หายไป แต่ครูจะเห็นใบประเมินของเทอมใหม่แทน</span>
                        </li>
                        <li class="d-flex">
                            <i class='bx bx-check-double text-success me-2 mt-1'></i>
                            <span class="small text-muted">ควรปิดระบบเมื่อสิ้นสุดช่วงเวลาประเมิน เพื่อป้องกันการแก้ไขข้อมูลย้อนหลัง</span>
                        </li>
                    </ul>
                    
                    <div class="mt-4 p-3 rounded-3 bg-light border-start border-4 border-success">
                        <p class="mb-0 small text-dark fw-bold">ระบบอัตโนมัติ</p>
                        <p class="mb-0 x-small text-muted">ระบบจะทำการ Sync ข้อมูลครูที่ปรึกษาและรายชื่อนักเรียนโดยอัตโนมัติเมื่อเปิดใช้งานเทอมใหม่</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        // Initialize Select2
        if ($.fn.select2) {
            $('#year-term-select').select2({
                width: '100%',
                placeholder: 'เลือกปีการศึกษา/ภาคเรียน...',
                allowClear: false
            });
        }

        <?php if (session()->getFlashdata('swal_alert')) : ?>
            const alertData = <?= json_encode(session()->getFlashdata('swal_alert')) ?>;
            Swal.fire({
                icon: alertData.type,
                title: alertData.title,
                text: alertData.text,
                showConfirmButton: false,
                timer: 2000,
                customClass: {
                    popup: 'rounded-4'
                }
            });
        <?php endif; ?>
    });
</script>
<?= $this->endSection() ?>
