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
    .hero-settings {
        background: linear-gradient(135deg, var(--primary-emerald) 0%, var(--dark-emerald) 100%);
        border-radius: var(--border-radius);
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
        width: 300px; height: 300px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    /* Group Card */
    .group-card {
        border: none;
        border-radius: var(--border-radius);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: white;
        text-align: center;
        padding: 2rem 1.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .group-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(21,163,98,0.1);
        border-bottom: 4px solid var(--primary-emerald);
    }

    .group-icon-wrapper {
        width: 70px;
        height: 70px;
        border-radius: 20px;
        background: var(--light-emerald);
        color: var(--primary-emerald);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        margin: 0 auto 1.5rem;
        transition: all 0.3s;
    }

    .group-card:hover .group-icon-wrapper {
        background: var(--primary-emerald);
        color: white;
        transform: scale(1.1) rotate(5deg);
    }

    .group-title {
        font-weight: 700;
        color: #2c3e50;
        font-size: 1.15rem;
        margin-bottom: 0.5rem;
    }

    .group-desc {
        color: #7f8c8d;
        font-size: 0.85rem;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y animate__animated animate__fadeIn">
    <!-- Hero Header -->
    <div class="hero-settings">
        <div class="row align-items-center">
            <div class="col-md-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="<?= base_url('Admin/Home') ?>" class="text-white opacity-75">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">งานนิเทศ</li>
                    </ol>
                </nav>
                <h2 class="fw-bold mb-1 text-white">ตรวจสอบแผนการสอน</h2>
                <p class="mb-0 text-white opacity-75">กรุณาเลือกกลุ่มสาระการเรียนรู้เพื่อตรวจสอบข้อมูลแผนการจัดการเรียนรู้ของครูภายในกลุ่ม</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="icon-hero text-white opacity-25" style="font-size: 4rem;">
                    <i class="bx bxs-book-bookmark"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Learning Groups Grid -->
    <div class="row g-4">
        <?php if (empty($learningGroups)) : ?>
            <div class="col-12">
                <div class="card p-5 text-center border-0 shadow-sm" style="border-radius: 16px;">
                    <div class="mb-4">
                        <i class="bx bx-info-circle text-warning" style="font-size: 5rem;"></i>
                    </div>
                    <h4 class="fw-bold">ไม่พบข้อมูลกลุ่มสาระ</h4>
                    <p class="text-muted">ไม่พบข้อมูลกลุ่มสาระการเรียนรู้ในระบบขณะนี้</p>
                </div>
            </div>
        <?php else : ?>
            <?php foreach ($learningGroups as $group) : ?>
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <a href="<?= base_url('admin/academic/checkplan/plans/' . esc($group->lear_id)) ?>" class="text-decoration-none h-100 d-block">
                        <div class="group-card h-100">
                            <div class="group-icon-wrapper">
                                <i class='bx bx-book-reader'></i>
                            </div>
                            <h5 class="group-title text-uppercase"><?= esc($group->lear_namethai) ?></h5>
                            <p class="group-desc mb-0">ตรวจสอบความคืบหน้า <i class='bx bx-right-arrow-alt ms-1'></i></p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
