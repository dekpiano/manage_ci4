<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=K2D:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700&display=swap');

    :root {
        --primary-green: #15a362;
        --primary-green-rgb: 21, 163, 98;
        --dark-green: #0d6d41;
        --card-bg: #ffffff;
        --text-main: #2b3445;
        --text-muted: #64748b;
        --border-color: #f1f5f9;
        --transition-base: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        font-family: 'K2D', 'Outfit', sans-serif !important;
        background-color: #f4f6f8;
        color: var(--text-main);
    }

    /* 🟢 Hero Welcome Banner */
    .hero-banner {
        background: linear-gradient(135deg, #15a362 0%, #0d6d41 60%, #084c2c 100%);
        border-radius: 20px;
        padding: 2rem 2.25rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 12px 28px rgba(21, 163, 98, 0.22);
        margin-bottom: 2rem;
    }

    .hero-banner::before {
        content: "";
        position: absolute;
        top: -60px;
        right: -60px;
        width: 240px;
        height: 240px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.18) 0%, rgba(255, 255, 255, 0) 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .hero-banner::after {
        content: "";
        position: absolute;
        bottom: -50px;
        left: 25%;
        width: 170px;
        height: 170px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0) 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .hero-banner h1, .hero-banner h2, .hero-banner h3, .hero-banner h4, .hero-banner p, .hero-banner .hero-text {
        color: #ffffff !important;
        opacity: 1 !important;
    }

    .hero-avatar {
        width: 68px;
        height: 68px;
        border-radius: 16px;
        border: 3px solid rgba(255, 255, 255, 0.95);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.18);
        object-fit: cover;
        background-color: #ffffff;
    }

    .badge-role {
        background-color: #ffffff !important;
        color: #0d6d41 !important;
        font-weight: 700 !important;
        font-size: 0.825rem;
        padding: 0.35rem 0.9rem;
        border-radius: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .badge-year {
        background-color: rgba(255, 255, 255, 0.22) !important;
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.45);
        font-weight: 600;
        font-size: 0.825rem;
        padding: 0.35rem 0.9rem;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .hero-date-box {
        background: rgba(255, 255, 255, 0.16);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 14px;
        padding: 0.85rem 1.25rem;
        backdrop-filter: blur(8px);
        color: #ffffff !important;
    }

    /* 🔍 Search Input */
    .search-wrapper {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .search-input {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        padding: 0.85rem 1rem 0.85rem 2.85rem;
        font-size: 0.95rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        transition: var(--transition-base);
        width: 100%;
        color: #1e293b;
    }

    .search-input:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 4px rgba(21, 163, 98, 0.15);
        outline: none;
    }

    .search-icon {
        position: absolute;
        left: 1.1rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.35rem;
        color: #94a3b8;
        pointer-events: none;
    }

    .clear-search-btn {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        font-size: 1.2rem;
        display: none;
    }

    /* 🏷️ Filter Pills */
    .filter-pills-container {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 2rem;
    }

    .filter-pill {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        color: #475569;
        padding: 0.55rem 1.15rem;
        border-radius: 30px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition-base);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        user-select: none;
    }

    .filter-pill:hover {
        background: #f8fafc;
        border-color: var(--primary-green);
        color: var(--primary-green);
    }

    .filter-pill.active {
        background: var(--primary-green) !important;
        border-color: var(--primary-green) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(21, 163, 98, 0.32);
    }

    /* 🏢 Department Cards */
    .dept-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #eef2f6;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.04);
        margin-bottom: 2rem;
        overflow: hidden;
        transition: var(--transition-base);
    }

    .dept-card:hover {
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.07);
    }

    .dept-card-header {
        padding: 1.35rem 1.75rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .dept-header-title {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .dept-header-icon {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .dept-title-text {
        font-size: 1.2rem;
        font-weight: 700;
        margin: 0;
    }

    .dept-subtitle-text {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin: 0;
    }

    .dept-badge-access {
        padding: 0.35rem 0.85rem;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .dept-card-body {
        padding: 1.5rem 1.75rem;
    }

    /* 🎴 Menu Action Tile */
    .menu-tile {
        background: #f8fafc;
        border: 1.5px solid #edf2f7;
        border-radius: 14px;
        padding: 1.15rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        text-decoration: none !important;
        transition: var(--transition-base);
        position: relative;
    }

    .menu-tile:hover {
        background: #ffffff;
        border-color: var(--primary-green);
        transform: translateY(-3px);
        box-shadow: 0 8px 22px rgba(21, 163, 98, 0.12);
    }

    .menu-tile-top {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 0.65rem;
    }

    .menu-tile-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex-shrink: 0;
        transition: var(--transition-base);
    }

    .menu-tile:hover .menu-tile-icon {
        transform: scale(1.08);
    }

    .menu-tile-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 2px 0;
        line-height: 1.35;
        transition: color 0.2s ease;
    }

    .menu-tile:hover .menu-tile-title {
        color: var(--primary-green);
    }

    .menu-tile-desc {
        font-size: 0.775rem;
        color: var(--text-muted);
        margin: 0;
        line-height: 1.45;
    }

    .menu-tile-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        margin-top: 0.75rem;
        padding-top: 0.5rem;
        border-top: 1px dashed rgba(0, 0, 0, 0.06);
    }

    .menu-tile-arrow {
        font-size: 0.825rem;
        font-weight: 600;
        color: var(--primary-green);
        display: inline-flex;
        align-items: center;
        gap: 3px;
        transition: transform 0.2s ease;
    }

    .menu-tile:hover .menu-tile-arrow {
        transform: translateX(4px);
    }

    /* Subgroup Header */
    .menu-subgroup-title {
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #94a3b8;
        margin: 1.25rem 0 0.75rem 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .menu-subgroup-title::after {
        content: "";
        flex-grow: 1;
        height: 1px;
        background: #e2e8f0;
    }

    .menu-subgroup-title:first-child {
        margin-top: 0;
    }

    /* Empty Search State */
    .empty-search-state {
        display: none;
        text-align: center;
        padding: 4rem 2rem;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    }
</style>

<?php 
// ตรวจสอบสิทธิ์รายฝ่าย
$hasRegis    = in_array("งานทะเบียน", $Exp_Checkrloes) || !empty($is_superadmin) || !empty($is_manager);
$hasEval     = in_array("งานวัดและประเมินผล", $Exp_Checkrloes) || in_array("งานวัดผล", $Exp_Checkrloes) || !empty($is_superadmin) || !empty($is_manager);
$hasCurric   = in_array("งานหลักสูตร", $Exp_Checkrloes) || !empty($is_superadmin) || !empty($is_manager);
$hasResearch = in_array("งานวิจัย", $Exp_Checkrloes) || !empty($is_superadmin) || !empty($is_manager);
$hasActiv    = in_array("งานกิจกรรมพัฒนาผู้เรียน", $Exp_Checkrloes) || !empty($is_superadmin) || !empty($is_manager);
$hasGuid     = in_array("งานแนะแนว", $Exp_Checkrloes) || !empty($is_superadmin) || !empty($is_manager);
$hasAdmin    = !empty($is_superadmin) || !empty($is_manager);

$hasAnyRole = $hasRegis || $hasEval || $hasCurric || $hasResearch || $hasActiv || $hasGuid || $hasAdmin;
?>

<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- 🟢 Hero Welcome Banner -->
    <div class="hero-banner">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <?php 
                    $userImg = !empty($admin->pers_img) ? $admin->pers_img : base_url('public/assets/img/avatars/1.png');
                    if (strpos($userImg, 'http') === false) {
                        $userImg = 'https://skj.ac.th/uploads/general_information/personnel_img/' . $admin->pers_img;
                    }
                    ?>
                    <img src="<?= $userImg ?>" alt="Profile" class="hero-avatar" onerror="this.src='https://skj.ac.th/uploads/logo/LogoSKJ_4.png'">
                    <div>
                        <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                            <span class="badge-role">
                                <i class='bx bxs-user-badge'></i>
                                <?php 
                                if (!empty($is_superadmin)) {
                                    echo "ผู้ดูแลระบบสูงสุด (Superadmin)";
                                } elseif (!empty($is_manager)) {
                                    echo "ผู้บริหาร / จัดการระบบ";
                                } elseif (!empty($Exp_Checkrloes)) {
                                    echo implode(', ', array_slice($Exp_Checkrloes, 0, 3));
                                } else {
                                    echo "บุคลากรวิชาการ";
                                }
                                ?>
                            </span>
                            <span class="badge-year">
                                <i class='bx bx-calendar-event'></i> ภาคเรียน <?= $selectedYear ?>
                            </span>
                        </div>
                        <h2 class="fw-bold mb-0 text-white" style="font-size: 1.65rem;">
                            สวัสดีครับ/ค่ะ, <?= esc(session()->get('fullname')) ?> 👋
                        </h2>
                    </div>
                </div>
                <p class="mb-0 hero-text" style="font-size: 0.95rem; line-height: 1.6;">
                    ศูนย์กลางระบบบริหารจัดการงานวิชาการ โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์<br class="d-none d-md-inline">
                    เลือกเข้าใช้งานระบบงานต่าง ๆ ตามภาระหน้าที่และสิทธิ์การเข้าถึงของคุณ
                </p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <div class="hero-date-box d-inline-block text-start">
                    <div class="small opacity-75 mb-1"><i class='bx bx-calendar me-1'></i> วันที่ปัจจุบัน (พ.ศ.)</div>
                    <div class="fw-bold fs-6 text-white">
                        <?= date('d') . ' ' . [
                            '01' => 'มกราคม', '02' => 'กุมภาพันธ์', '03' => 'มีนาคม', '04' => 'เมษายน',
                            '05' => 'พฤษภาคม', '06' => 'มิถุนายน', '07' => 'กรกฎาคม', '08' => 'สิงหาคม',
                            '09' => 'กันยายน', '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม'
                        ][date('m')] . ' ' . (date('Y') + 543) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if($hasAnyRole): ?>
    <!-- 🔍 Real-Time Search & Category Filters -->
    <div class="row align-items-center g-3 mb-2">
        <div class="col-12 col-md-7">
            <div class="search-wrapper mb-0">
                <i class='bx bx-search search-icon'></i>
                <input type="text" id="menuSearchInput" class="search-input" placeholder="พิมพ์ค้นหาเมนูหรือระบบงาน... เช่น ตารางสอน, 0 ร, แผนการสอน, ปพ.1, ชุมนุม">
                <button type="button" id="btnClearSearch" class="clear-search-btn" title="ล้างคำค้นหา"><i class='bx bx-x'></i></button>
            </div>
        </div>
        <div class="col-12 col-md-5 text-md-end">
            <span class="text-muted small">
                <i class='bx bx-check-shield me-1 text-success'></i> แสดงเฉพาะระบบงานที่คุณได้รับสิทธิ์การใช้งาน
            </span>
        </div>
    </div>

    <!-- 🏷️ Filter Pills (แสดงเฉพาะฝ่ายที่ได้รับสิทธิ์) -->
    <div class="filter-pills-container">
        <button type="button" class="filter-pill active" data-filter="all">
            <i class='bx bx-grid-alt'></i> ทั้งหมดที่มีสิทธิ์
        </button>
        <?php if($hasRegis): ?>
        <button type="button" class="filter-pill" data-filter="dept-registration">
            <i class='bx bx-user-pin text-primary'></i> ทะเบียนและสถิติ
        </button>
        <?php endif; ?>
        <?php if($hasEval): ?>
        <button type="button" class="filter-pill" data-filter="dept-evaluation">
            <i class='bx bx-bar-chart-alt-2 text-info'></i> วัดผลและประเมินผล
        </button>
        <?php endif; ?>
        <?php if($hasCurric): ?>
        <button type="button" class="filter-pill" data-filter="dept-curriculum">
            <i class='bx bx-calendar-star text-success'></i> หลักสูตร/ตารางสอน
        </button>
        <?php endif; ?>
        <?php if($hasResearch): ?>
        <button type="button" class="filter-pill" data-filter="dept-research">
            <i class='bx bx-search-alt text-purple' style="color: #7c3aed;"></i> วิจัยในชั้นเรียน
        </button>
        <?php endif; ?>
        <?php if($hasActiv): ?>
        <button type="button" class="filter-pill" data-filter="dept-activities">
            <i class='bx bx-extension text-danger'></i> กิจกรรมพัฒนาผู้เรียน
        </button>
        <?php endif; ?>
        <?php if($hasGuid): ?>
        <button type="button" class="filter-pill" data-filter="dept-guidance">
            <i class='bx bx-street-view text-warning'></i> แนะแนว
        </button>
        <?php endif; ?>
        <?php if($hasAdmin): ?>
        <button type="button" class="filter-pill" data-filter="dept-admin">
            <i class='bx bx-cog text-secondary'></i> การตั้งค่าระบบ
        </button>
        <?php endif; ?>
    </div>

    <!-- Empty Search State -->
    <div id="emptySearchState" class="empty-search-state">
        <div class="mb-3">
            <i class='bx bx-search-alt-2 text-muted' style="font-size: 4rem;"></i>
        </div>
        <h5 class="fw-bold text-dark">ไม่พบเมนูหรือระบบงานที่ตรงกับคำค้นหา</h5>
        <p class="text-muted mb-3">ลองเปลี่ยนคำค้นหา เช่น "ตารางสอน", "0 ร", "ปพ.1", "แผนการสอน", หรือ "ลงทะเบียน"</p>
        <button type="button" class="btn btn-outline-success rounded-pill px-4" onclick="document.getElementById('btnClearSearch').click();">
            <i class='bx bx-refresh me-1'></i> ล้างการค้นหา
        </button>
    </div>

    <!-- ======================================================== -->
    <!-- 1. 👥 ฝ่ายงานทะเบียนและสถิตินักเรียน -->
    <!-- ======================================================== -->
    <?php if($hasRegis): ?>
    <div class="dept-card" data-department="dept-registration">
        <div class="dept-card-header">
            <div class="dept-header-title">
                <div class="dept-header-icon" style="background: rgba(2, 132, 199, 0.12); color: #0284c7;">
                    <i class='bx bxs-user-detail'></i>
                </div>
                <div>
                    <h5 class="dept-title-text" style="color: #0284c7;">1. งานทะเบียนและสถิตินักเรียน</h5>
                    <p class="dept-subtitle-text">Registration & Student Records Management</p>
                </div>
            </div>
            <div>
                <span class="dept-badge-access bg-label-success text-success">
                    <i class='bx bx-check-circle'></i> มีสิทธิ์เข้าใช้งาน
                </span>
            </div>
        </div>
        <div class="dept-card-body">
            <div class="menu-subgroup-title"><i class='bx bx-user-pin'></i> บริหารจัดการข้อมูลนักเรียนและห้องเรียน</div>
            <div class="row g-3 mb-3">
                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Registration/Students') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(2, 132, 199, 0.1); color: #0284c7;">
                                <i class='bx bxs-group'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">ภาพรวมจัดการนักเรียน</h6>
                                <p class="menu-tile-desc">ตรวจสอบรายชื่อ ค้นหา และดูสถานะนักเรียนทั้งหมด</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Registration/Students/Add') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(21, 163, 98, 0.1); color: #15a362;">
                                <i class='bx bxs-user-plus'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">เพิ่มนักเรียนใหม่</h6>
                                <p class="menu-tile-desc">บันทึกประวัตินักเรียนเข้าใหม่รายบุคคล</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Registration/Students/Edit') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(234, 88, 12, 0.1); color: #ea580c;">
                                <i class='bx bxs-edit-alt'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">ค้นหา / แก้ไขรายบุคคล</h6>
                                <p class="menu-tile-desc">ตรวจสอบและแก้ไขประวัติ ข้อมูลผู้ปกครอง และสถานะ</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Registration/Students/AdjustNumber') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(124, 58, 237, 0.1); color: #7c3aed;">
                                <i class='bx bx-sort-numbered'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">จัดเลขที่ห้องเรียน</h6>
                                <p class="menu-tile-desc">จัดเรียงและกำหนดเลขที่นักเรียนตามห้องประจำชั้น</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Registration/Students/Lifecycle') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(5, 150, 105, 0.1); color: #059669;">
                                <i class='bx bxs-graduation'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">เลื่อนชั้น / จบการศึกษา</h6>
                                <p class="menu-tile-desc">ปรับสถานะเลื่อนชั้นประจำปี และบันทึกผู้สำเร็จการศึกษา</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Registration/ClassRoom') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(37, 99, 235, 0.1); color: #2563eb;">
                                <i class='bx bxs-door-open'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">จัดการห้องเรียน / ที่ปรึกษา</h6>
                                <p class="menu-tile-desc">กำหนดห้องเรียน แผนการเรียน และครูที่ปรึกษาประจำห้อง</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="menu-subgroup-title"><i class='bx bx-collection'></i> การลงทะเบียนเรียนและรับสมัคร</div>
            <div class="row g-3">
                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Registration/Enroll') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(21, 163, 98, 0.1); color: #15a362;">
                                <i class='bx bx-list-check'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">ลงทะเบียนเรียนปกติ</h6>
                                <p class="menu-tile-desc">บันทึกและจัดการการลงทะเบียนรายวิชาตามแผนการเรียน</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Registration/Repeat') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(220, 38, 38, 0.1); color: #dc2626;">
                                <i class='bx bx-refresh'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">ลงทะเบียนเรียนซ้ำ</h6>
                                <p class="menu-tile-desc">จัดการนักเรียนลงทะเบียนเรียนซ้ำรายวิชาที่ผลการเรียนไม่ผ่าน</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Executive/ReportEnroll/Main') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(14, 165, 233, 0.1); color: #0ea5e9;">
                                <i class='bx bx-user-plus'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">งานรับสมัครนักเรียนใหม่</h6>
                                <p class="menu-tile-desc">รายงานและบริหารจัดการระบบรับสมัครนักเรียนเข้าใหม่</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- ======================================================== -->
    <!-- 2. 📊 ฝ่ายงานวัดผลและประเมินผลการเรียน -->
    <!-- ======================================================== -->
    <?php if($hasEval): ?>
    <div class="dept-card" data-department="dept-evaluation">
        <div class="dept-card-header">
            <div class="dept-header-title">
                <div class="dept-header-icon" style="background: rgba(79, 70, 229, 0.12); color: #4f46e5;">
                    <i class='bx bx-bar-chart-alt-2'></i>
                </div>
                <div>
                    <h5 class="dept-title-text" style="color: #4f46e5;">2. งานวัดผลและประเมินผล</h5>
                    <p class="dept-subtitle-text">Measurement, Evaluation & Academic Reporting</p>
                </div>
            </div>
            <div>
                <span class="dept-badge-access bg-label-success text-success">
                    <i class='bx bx-check-circle'></i> มีสิทธิ์เข้าใช้งาน
                </span>
            </div>
        </div>
        <div class="dept-card-body">
            <div class="menu-subgroup-title"><i class='bx bx-file'></i> รายงานผลการเรียนและเอกสาร ปพ.</div>
            <div class="row g-3 mb-3">
                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Evaluate/ReportPerson') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(79, 70, 229, 0.1); color: #4f46e5;">
                                <i class='bx bx-id-card'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">รายงานผลการเรียนรายบุคคล (ปพ.1/6)</h6>
                                <p class="menu-tile-desc">พิมพ์ใบระเบียนแสดงผลการเรียน ปพ.1 และสมุดรายงาน ปพ.6</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Evaluate/ReportRoom') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(2, 132, 199, 0.1); color: #0284c7;">
                                <i class='bx bx-spreadsheet'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">รายงานผลการเรียนรายห้อง</h6>
                                <p class="menu-tile-desc">รายงานสรุปผลการเรียนและเกรดเฉลี่ยรายห้องเรียน</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Evaluate/ReportAcademicSummary?SelLern=0') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(21, 163, 98, 0.1); color: #15a362;">
                                <i class='bx bx-pie-chart-alt-2'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">สรุปผลสัมฤทธิ์ทางการเรียน</h6>
                                <p class="menu-tile-desc">สรุปภาพรวมผลสัมฤทธิ์ 8 กลุ่มสาระฯ ประจำปีการศึกษา</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Evaluate/ReportAcademicSummaryRoyalRoseStandard?SelLern=0') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(225, 29, 72, 0.1); color: #e11d48;">
                                <i class='bx bx-award'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">มาตรฐานกุหลาบหลวง</h6>
                                <p class="menu-tile-desc">ประเมินและติดตามผลสัมฤทธิ์ตามเกณฑ์มาตรฐานกุหลาบหลวง</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Evaluate/EditGrade') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(220, 38, 38, 0.1); color: #dc2626;">
                                <i class='bx bx-edit'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">แก้ไขผลการเรียน (0 ร มส มผ)</h6>
                                <p class="menu-tile-desc">ระบบอนุมัติและแก้ไขผลการเรียนตกค้างสำหรับแอดมิน</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Registration/ExamSchedule') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(217, 119, 6, 0.1); color: #d97706;">
                                <i class='bx bx-calendar-event'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">จัดการตารางสอบ</h6>
                                <p class="menu-tile-desc">จัดผังและตารางสอบกลางภาค-ปลายภาค</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="menu-subgroup-title"><i class='bx bx-cog'></i> บันทึกคะแนนและตั้งค่าระบบวัดผล</div>
            <div class="row g-3">
                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Evaluate/ReportTeacherSaveScore') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                                <i class='bx bx-user-check'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">บันทึกคะแนน (รายครู)</h6>
                                <p class="menu-tile-desc">ติดตามและตรวจสอบสถานะการกรอกคะแนนของครูผู้สอน</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Evaluate/ReportScoreRoomMain') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                                <i class='bx bx-building'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">บันทึกคะแนน (รายห้อง)</h6>
                                <p class="menu-tile-desc">ตรวจสอบคะแนนเก็บและคะแนนสอบแบบรายห้องเรียน</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Evaluate/SaveScore') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(100, 116, 139, 0.1); color: #64748b;">
                                <i class='bx bx-time'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">ตั้งค่าช่วงเวลากรอกคะแนน</h6>
                                <p class="menu-tile-desc">เปิด-ปิดระบบและกำหนดช่วงเวลากรอกคะแนนของครู</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Evaluate/AcademicResult') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(100, 116, 139, 0.1); color: #64748b;">
                                <i class='bx bx-show'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">ตั้งค่าแสดงผลการเรียน</h6>
                                <p class="menu-tile-desc">กำหนดการเปิด-ปิดการแสดงผลการเรียนออนไลน์สำหรับนักเรียน</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('admin/academic/characteristics/settings') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(124, 58, 237, 0.1); color: #7c3aed;">
                                <i class='bx bx-check-shield'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">ประเมินคุณลักษณะอันพึงประสงค์</h6>
                                <p class="menu-tile-desc">ตั้งค่าเกณฑ์และตัวชี้วัดคุณลักษณะ 8 ประการ</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('admin/academic/rwl/settings') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(2, 132, 199, 0.1); color: #0284c7;">
                                <i class='bx bx-book-reader'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">ประเมินการอ่าน คิดวิเคราะห์ และเขียน</h6>
                                <p class="menu-tile-desc">ตั้งค่าเกณฑ์และข้อคำถามการประเมินการอ่านฯ</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- ======================================================== -->
    <!-- 3. 📖 ฝ่ายงานหลักสูตรและนิเทศการสอน -->
    <!-- ======================================================== -->
    <?php if($hasCurric): ?>
    <div class="dept-card" data-department="dept-curriculum">
        <div class="dept-card-header">
            <div class="dept-header-title">
                <div class="dept-header-icon" style="background: rgba(21, 163, 98, 0.12); color: #15a362;">
                    <i class='bx bx-calendar-star'></i>
                </div>
                <div>
                    <h5 class="dept-title-text" style="color: #15a362;">3. งานหลักสูตรและนิเทศการสอน</h5>
                    <p class="dept-subtitle-text">Curriculum, Timetable & Supervision</p>
                </div>
            </div>
            <div>
                <span class="dept-badge-access bg-label-success text-success">
                    <i class='bx bx-check-circle'></i> มีสิทธิ์เข้าใช้งาน
                </span>
            </div>
        </div>
        <div class="dept-card-body">
            <div class="menu-subgroup-title"><i class='bx bx-magic-wand'></i> ระบบจัดตารางสอนอัตโนมัติ (Auto Timetable AI)</div>
            <div class="row g-3 mb-3">
                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('admin/academic/timetable/process') ?>" class="menu-tile" style="border: 2px solid rgba(21, 163, 98, 0.35); background: #f0faf5;">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: #15a362; color: #ffffff;">
                                <i class='bx bx-magic-wand'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title text-success">จัดการและจัดตารางสอน (Auto)</h6>
                                <p class="menu-tile-desc">ระบบจัดตารางสอนอัจฉริยะ มอบหมายคาบ และประมวลผลตาราง</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow fw-bold">เริ่มจัดตาราง <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('admin/academic/timetable/full') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(2, 132, 199, 0.1); color: #0284c7;">
                                <i class='bx bx-calendar'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">ตารางสอนรวม (Master)</h6>
                                <p class="menu-tile-desc">ดูและพิมพ์ตารางสอนรวมทั้งโรงเรียนทุกระดับชั้น</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('admin/academic/timetable/teacher-timetables') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(37, 99, 235, 0.1); color: #2563eb;">
                                <i class='bx bx-user-check'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">ตารางสอนรายครู</h6>
                                <p class="menu-tile-desc">ดูและส่งออกตารางสอนรายบุคคลของครูผู้สอนทุกคน</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('admin/academic/timetable/class-timetables') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(217, 119, 6, 0.1); color: #d97706;">
                                <i class='bx bx-book-reader'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">ตารางเรียนรายห้อง</h6>
                                <p class="menu-tile-desc">ดูและพิมพ์ตารางเรียนประจำห้องเรียน ม.1 - ม.6</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('admin/academic/timetable/teacher-constraints') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(220, 38, 38, 0.1); color: #dc2626;">
                                <i class='bx bx-time-five'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">เงื่อนไขเวลาครูผู้สอน</h6>
                                <p class="menu-tile-desc">กำหนดคาบว่าง วันติดภารกิจ หรือข้อจำกัดเวลาสอนของครู</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('admin/academic/timetable/subject-groups') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(124, 58, 237, 0.1); color: #7c3aed;">
                                <i class='bx bx-layer'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">กลุ่มวิชาเรียนพร้อมกัน</h6>
                                <p class="menu-tile-desc">กำหนดวิชาบังคับเลือกและวิชาที่เรียนรวมหลายห้องพร้อมกัน</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="menu-subgroup-title"><i class='bx bx-book'></i> โครงสร้างหลักสูตรและนิเทศแผนการสอน</div>
            <div class="row g-3">
                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Course/MasterSubject') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(2, 132, 199, 0.1); color: #0284c7;">
                                <i class='bx bx-archive'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">คลังวิชาหลักสูตรกลาง</h6>
                                <p class="menu-tile-desc">จัดการรหัสวิชา คำอธิบายรายวิชา และโครงสร้างหลักสูตร</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Course/RegisterSubject') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(21, 163, 98, 0.1); color: #15a362;">
                                <i class='bx bx-book-open'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">จัดการวิชาเรียนประจำเทอม</h6>
                                <p class="menu-tile-desc">เปิดรายวิชา กำหนดห้องเรียน และมอบหมายครูผู้สอน</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Course/TeachingSchedule') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(217, 119, 6, 0.1); color: #d97706;">
                                <i class='bx bx-calendar-check'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">ตรวจสอบตารางสอนกลุ่มสาระ</h6>
                                <p class="menu-tile-desc">ตรวจสอบชั่วโมงสอนและภาระงานครูรายกลุ่มสาระการเรียนรู้</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('admin/academic/checkplan') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(5, 150, 105, 0.1); color: #059669;">
                                <i class='bx bx-check-shield'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">ตรวจแผนการสอน</h6>
                                <p class="menu-tile-desc">ตรวจสอบและพิจารณาอนุมัติแผนการจัดการเรียนรู้ของครู</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('admin/academic/report/checkplan') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(14, 165, 233, 0.1); color: #0ea5e9;">
                                <i class='bx bx-file-blank'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">รายงานการส่งแผนการสอน</h6>
                                <p class="menu-tile-desc">สรุปสถิติความก้าวหน้าการส่งแผนการสอนแยกกลุ่มสาระ</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Course/SendPlan') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(100, 116, 139, 0.1); color: #64748b;">
                                <i class='bx bx-cog'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">ตั้งค่าส่งแผนการสอน</h6>
                                <p class="menu-tile-desc">กำหนดรอบและปฏิทินเวลาการส่งแผนการจัดการเรียนรู้</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Registration/RoomOnline') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(124, 58, 237, 0.1); color: #7c3aed;">
                                <i class='bx bx-laptop'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">จัดการห้องเรียนออนไลน์</h6>
                                <p class="menu-tile-desc">จัดการลิงก์ห้องเรียนและแพลตฟอร์มการสอนออนไลน์</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('admin/academic/competition') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(234, 88, 12, 0.1); color: #ea580c;">
                                <i class='bx bx-trophy'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">ผลงานการแข่งขันทางวิชาการ</h6>
                                <p class="menu-tile-desc">บันทึกรางวัลและเกียรติประวัติการแข่งขันของนักเรียน</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- ======================================================== -->
    <!-- 4. 🔬 ฝ่ายงานวิจัยเพื่อพัฒนาคุณภาพการศึกษา -->
    <!-- ======================================================== -->
    <?php if($hasResearch): ?>
    <div class="dept-card" data-department="dept-research">
        <div class="dept-card-header">
            <div class="dept-header-title">
                <div class="dept-header-icon" style="background: rgba(124, 58, 237, 0.12); color: #7c3aed;">
                    <i class='bx bx-search-alt-2'></i>
                </div>
                <div>
                    <h5 class="dept-title-text" style="color: #7c3aed;">4. งานวิจัยเพื่อพัฒนาคุณภาพการศึกษา</h5>
                    <p class="dept-subtitle-text">Educational & Classroom Action Research</p>
                </div>
            </div>
            <div>
                <span class="dept-badge-access bg-label-success text-success">
                    <i class='bx bx-check-circle'></i> มีสิทธิ์เข้าใช้งาน
                </span>
            </div>
        </div>
        <div class="dept-card-body">
            <div class="row g-3">
                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Research/Setup') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(124, 58, 237, 0.1); color: #7c3aed;">
                                <i class='bx bx-cog'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">ตั้งค่าส่งงานวิจัยในชั้นเรียน</h6>
                                <p class="menu-tile-desc">กำหนดรอบ กำหนดการ และหัวข้อการส่งวิจัยในชั้นเรียน</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Research/Report') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(37, 99, 235, 0.1); color: #2563eb;">
                                <i class='bx bx-file'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">รายงานสรุปการส่งงานวิจัย</h6>
                                <p class="menu-tile-desc">ตรวจสอบผลงาน รายชื่อครูที่ส่ง และสรุปรายงานวิจัย</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- ======================================================== -->
    <!-- 5. ⛺ ฝ่ายกิจกรรมพัฒนาผู้เรียน -->
    <!-- ======================================================== -->
    <?php if($hasActiv): ?>
    <div class="dept-card" data-department="dept-activities">
        <div class="dept-card-header">
            <div class="dept-header-title">
                <div class="dept-header-icon" style="background: rgba(234, 88, 12, 0.12); color: #ea580c;">
                    <i class='bx bx-extension'></i>
                </div>
                <div>
                    <h5 class="dept-title-text" style="color: #ea580c;">5. กิจกรรมพัฒนาผู้เรียน (ชุมนุม & ลูกเสือ)</h5>
                    <p class="dept-subtitle-text">Student Development, Clubs & Scouts</p>
                </div>
            </div>
            <div>
                <span class="dept-badge-access bg-label-success text-success">
                    <i class='bx bx-check-circle'></i> มีสิทธิ์เข้าใช้งาน
                </span>
            </div>
        </div>
        <div class="dept-card-body">
            <div class="menu-subgroup-title"><i class='bx bx-extension'></i> กิจกรรมชุมนุม</div>
            <div class="row g-3 mb-3">
                <div class="col-12 col-sm-6 col-lg-3 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/DevelopStudents/Clubs/Main') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(234, 88, 12, 0.1); color: #ea580c;">
                                <i class='bx bx-slider-alt'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">จัดการชุมนุม</h6>
                                <p class="menu-tile-desc">เปิด-ปิดระบบ กำหนดจำนวนรับ และครูที่ปรึกษาชุมนุม</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/DevelopStudents/Clubs/All') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(2, 132, 199, 0.1); color: #0284c7;">
                                <i class='bx bx-list-ul'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">รายชื่อชุมนุมทั้งหมด</h6>
                                <p class="menu-tile-desc">ดูรายการชุมนุมประจำปีการศึกษาและสมาชิก</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 menu-item-col">
                    <a href="<?= base_url('admin/academic/develop-students/student-registrations') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(21, 163, 98, 0.1); color: #15a362;">
                                <i class='bx bx-user-check'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">ข้อมูลลงทะเบียนชุมนุม</h6>
                                <p class="menu-tile-desc">ตรวจสอบรายชื่อนักเรียนที่ลงทะเบียนและยังไม่ได้เลือก</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/DevelopStudents/Clubs/Report') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(79, 70, 229, 0.1); color: #4f46e5;">
                                <i class='bx bx-file'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">รายงานสรุปชุมนุม</h6>
                                <p class="menu-tile-desc">รายงานผลการประเมิน ผ/มผ กิจกรรมชุมนุม</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="menu-subgroup-title"><i class='bx bx-compass'></i> กิจกรรมลูกเสือ - เนตรนารี</div>
            <div class="row g-3">
                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/DevelopStudents/Scout/All') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(217, 119, 6, 0.1); color: #d97706;">
                                <i class='bx bx-compass'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">จัดการกองลูกเสือ-เนตรนารี</h6>
                                <p class="menu-tile-desc">จัดกลุ่มกองลูกเสือ มอบหมายผู้กำกับกองและสมาชิก</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/DevelopStudents/Scout/Report') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(5, 150, 105, 0.1); color: #059669;">
                                <i class='bx bx-file-blank'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">รายงานสรุปลูกเสือ</h6>
                                <p class="menu-tile-desc">สรุปผลการประเมินกิจกรรมลูกเสือ-เนตรนารีประจำภาคเรียน</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- ======================================================== -->
    <!-- 6. 🧭 ฝ่ายงานแนะแนว -->
    <!-- ======================================================== -->
    <?php if($hasGuid): ?>
    <div class="dept-card" data-department="dept-guidance">
        <div class="dept-card-header">
            <div class="dept-header-title">
                <div class="dept-header-icon" style="background: rgba(14, 165, 233, 0.12); color: #0ea5e9;">
                    <i class='bx bx-street-view'></i>
                </div>
                <div>
                    <h5 class="dept-title-text" style="color: #0ea5e9;">6. งานแนะแนวและส่งต่อการศึกษา</h5>
                    <p class="dept-subtitle-text">Guidance & Graduation Statistics</p>
                </div>
            </div>
            <div>
                <span class="dept-badge-access bg-label-success text-success">
                    <i class='bx bx-check-circle'></i> มีสิทธิ์เข้าใช้งาน
                </span>
            </div>
        </div>
        <div class="dept-card-body">
            <div class="row g-3">
                <div class="col-12 col-sm-6 col-lg-4 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Guidance/GraduationStats') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(14, 165, 233, 0.1); color: #0ea5e9;">
                                <i class='bx bx-trending-up'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">สถิติเด็กจบแล้วไปไหน</h6>
                                <p class="menu-tile-desc">บันทึกและติดตามข้อมูลการศึกษาต่อและการประกอบอาชีพ</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- ======================================================== -->
    <!-- 7. ⚙️ การตั้งค่าและดูแลระบบขั้นสูง (Manager / Superadmin) -->
    <!-- ======================================================== -->
    <?php if($hasAdmin): ?>
    <div class="dept-card" data-department="dept-admin">
        <div class="dept-card-header">
            <div class="dept-header-title">
                <div class="dept-header-icon" style="background: rgba(51, 65, 85, 0.12); color: #334155;">
                    <i class='bx bx-shield-quarter'></i>
                </div>
                <div>
                    <h5 class="dept-title-text" style="color: #334155;">7. การตั้งค่าและดูแลระบบ (System Administration)</h5>
                    <p class="dept-subtitle-text">Roles, Permissions, API & System Maintenance</p>
                </div>
            </div>
            <div>
                <span class="dept-badge-access bg-label-primary text-primary">
                    <i class='bx bx-shield-alt-2'></i> ผู้ดูแลระบบ (Superadmin / Manager)
                </span>
            </div>
        </div>
        <div class="dept-card-body">
            <div class="row g-3">
                <div class="col-12 col-sm-6 col-lg-3 menu-item-col">
                    <a href="<?= base_url('Admin/Acade/Setting/AdminRoles') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(51, 65, 85, 0.1); color: #334155;">
                                <i class='bx bx-user-check'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">จัดการบทบาทและสิทธิ์</h6>
                                <p class="menu-tile-desc">กำหนดสิทธิ์และหน้าที่ของบุคลากรในระบบวิชาการ</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 menu-item-col">
                    <a href="<?= base_url('admin/academic/api') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(2, 132, 199, 0.1); color: #0284c7;">
                                <i class='bx bx-code-block'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">จัดการ API Integration</h6>
                                <p class="menu-tile-desc">ตั้งค่า API Token และจุดเชื่อมต่อบริการภายนอก</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <?php if(!empty($is_superadmin)): ?>
                <div class="col-12 col-sm-6 col-lg-3 menu-item-col">
                    <a href="<?= base_url('admin/academic/backup') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(21, 163, 98, 0.1); color: #15a362;">
                                <i class='bx bx-cloud-download'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">สำรองฐานข้อมูล</h6>
                                <p class="menu-tile-desc">ส่งออกและสำรองฐานข้อมูล Database สำรองฉุกเฉิน</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 menu-item-col">
                    <a href="<?= base_url('diagnostic/register-class') ?>" class="menu-tile">
                        <div class="menu-tile-top">
                            <div class="menu-tile-icon" style="background: rgba(234, 88, 12, 0.1); color: #ea580c;">
                                <i class='bx bx-list-check'></i>
                            </div>
                            <div>
                                <h6 class="menu-tile-title">ตรวจสอบห้องเรียน (Audit)</h6>
                                <p class="menu-tile-desc">เครื่องมือตรวจสอบความสมบูรณ์ของข้อมูลการลงทะเบียน</p>
                            </div>
                        </div>
                        <div class="menu-tile-footer">
                            <span class="menu-tile-arrow">เข้าสู่ระบบ <i class='bx bx-right-arrow-alt'></i></span>
                        </div>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php else: ?>
    <!-- ⚠️ กรณีผู้ใช้ยังไม่ได้รับสิทธิ์ใด ๆ -->
    <div class="card text-center p-5 border-0 shadow-sm rounded-4">
        <div class="mb-3">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: rgba(234, 88, 12, 0.1); color: #ea580c;">
                <i class='bx bx-shield-x fs-1'></i>
            </div>
        </div>
        <h4 class="fw-bold text-dark mb-2">ท่านยังไม่ได้รับมอบหมายสิทธิ์ในระบบงานวิชาการ</h4>
        <p class="text-muted mb-4">กรุณาติดต่อผู้ดูแลระบบเพื่อเปิดสิทธิ์การใช้งานตามภาระหน้าที่ของคุณ</p>
        <div>
            <a href="<?= base_url('welcome') ?>" class="btn btn-outline-secondary rounded-pill px-4">
                <i class='bx bx-arrow-back me-1'></i> กลับหน้าหลักระบบ
            </a>
        </div>
    </div>
    <?php endif; ?>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('menuSearchInput');
    const btnClearSearch = document.getElementById('btnClearSearch');
    const filterPills = document.querySelectorAll('.filter-pill');
    const deptCards = document.querySelectorAll('.dept-card');
    const emptyState = document.getElementById('emptySearchState');

    let activeFilter = 'all';

    // Search and Filter handler
    function filterCards() {
        if (!searchInput) return;
        const query = searchInput.value.trim().toLowerCase();
        btnClearSearch.style.display = query.length > 0 ? 'block' : 'none';

        let totalVisibleCards = 0;

        deptCards.forEach(card => {
            const cardDept = card.getAttribute('data-department');

            // Filter by category tab
            let matchesCategory = false;
            if (activeFilter === 'all') {
                matchesCategory = true;
            } else if (activeFilter === cardDept) {
                matchesCategory = true;
            }

            if (!matchesCategory) {
                card.style.display = 'none';
                return;
            }

            // Search within card
            if (query === '') {
                card.style.display = 'block';
                card.querySelectorAll('.menu-item-col').forEach(el => el.style.display = 'block');
                card.querySelectorAll('.menu-subgroup-title').forEach(el => el.style.display = 'flex');
                totalVisibleCards++;
            } else {
                const menuItems = card.querySelectorAll('.menu-item-col');
                let visibleItemsInCard = 0;

                menuItems.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    if (text.includes(query)) {
                        item.style.display = 'block';
                        visibleItemsInCard++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                if (visibleItemsInCard > 0 || card.querySelector('.dept-card-header').textContent.toLowerCase().includes(query)) {
                    card.style.display = 'block';
                    totalVisibleCards++;
                } else {
                    card.style.display = 'none';
                }
            }
        });

        // Toggle Empty Search State
        if (emptyState) {
            emptyState.style.display = totalVisibleCards === 0 ? 'block' : 'none';
        }
    }

    // Filter pill click
    filterPills.forEach(pill => {
        pill.addEventListener('click', function() {
            filterPills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            activeFilter = this.getAttribute('data-filter');
            filterCards();
        });
    });

    // Search input typing
    if (searchInput) {
        searchInput.addEventListener('input', filterCards);
    }

    // Clear search button
    if (btnClearSearch) {
        btnClearSearch.addEventListener('click', function() {
            searchInput.value = '';
            searchInput.focus();
            filterCards();
        });
    }
});
</script>

<?= $this->endSection() ?>
