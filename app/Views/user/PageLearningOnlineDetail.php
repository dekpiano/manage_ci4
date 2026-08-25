<?= $this->extend('user/layout/main') ?>

<?= $this->section('content') ?>

<style>
    /* Hero Banner */
    .learn-hero {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 50%, #1e3a8a 100%);
        border-radius: 0 0 35px 35px;
        padding: 45px 20px 40px;
        color: #ffffff;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.15);
    }
    .learn-hero h1 {
        font-weight: 800;
        font-size: 2.2rem;
        color: #ffffff;
        margin-bottom: 8px;
    }
    .learn-hero p {
        color: #cbd5e1;
        font-size: 1rem;
        margin-bottom: 0;
    }

    /* Filter & Search Bar */
    .filter-bar-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 20px 25px;
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.06);
        border: 1.5px solid #e2e8f0;
        margin-top: -30px;
        margin-bottom: 30px;
        position: relative;
        z-index: 5;
    }

    /* Room Cards */
    .online-room-card {
        background: #ffffff;
        border-radius: 22px;
        border: 2px solid #e2e8f0;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
        padding: 24px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    .online-room-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 36px rgba(2, 132, 199, 0.14);
        border-color: #38bdf8;
    }

    .room-header {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        margin-bottom: 16px;
    }
    .teacher-avatar {
        width: 58px;
        height: 58px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #38bdf8;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        flex-shrink: 0;
        background: #f1f5f9;
    }

    .room-course-code {
        font-size: 0.85rem;
        font-weight: 700;
        color: #0284c7;
        background: #e0f2fe;
        padding: 3px 10px;
        border-radius: 8px;
        display: inline-block;
        margin-bottom: 4px;
    }
    .room-course-name {
        font-size: 1.15rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 2px;
        line-height: 1.35;
    }
    .room-teacher-name {
        font-size: 0.88rem;
        color: #475569;
        font-weight: 600;
    }

    .room-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 18px;
    }
    .badge-classlevel {
        background: #dbeafe;
        color: #1e40af;
        border: 1px solid #bfdbfe;
        font-weight: 700;
        font-size: 0.78rem;
        padding: 4px 10px;
        border-radius: 20px;
    }
    .badge-term {
        background: #f1f5f9;
        color: #334155;
        border: 1px solid #cbd5e1;
        font-weight: 600;
        font-size: 0.78rem;
        padding: 4px 10px;
        border-radius: 20px;
    }

    /* Action Buttons */
    .btn-classroom {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        color: #ffffff !important;
        font-weight: 700;
        border: none;
        border-radius: 12px;
        padding: 10px 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 0.92rem;
        transition: all 0.25s ease;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
        text-decoration: none;
    }
    .btn-classroom:hover {
        background: linear-gradient(135deg, #047857 0%, #059669 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.35);
    }

    .btn-meet {
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
        color: #ffffff !important;
        font-weight: 700;
        border: none;
        border-radius: 12px;
        padding: 10px 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 0.92rem;
        transition: all 0.25s ease;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
        text-decoration: none;
    }
    .btn-meet:hover {
        background: linear-gradient(135deg, #b91c1c 0%, #dc2626 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(239, 68, 68, 0.35);
    }

    /* Google Site Banner */
    .group-site-card {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border: 2px solid #93c5fd;
        border-radius: 20px;
        padding: 20px 25px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 15px;
    }
</style>

<div class="app-wrapper">
    
    <!-- Hero Banner -->
    <div class="learn-hero">
        <div class="container-xl">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2" style="font-size: 0.85rem;">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>" class="text-white opacity-75">หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('LearningOnline') ?>" class="text-white opacity-75">ห้องเรียนออนไลน์</a></li>
                    <li class="breadcrumb-item text-white active fw-bold" aria-current="page">
                        <?= !empty($learGroup) ? esc($learGroup->lear_namethai) : 'รายวิชาออนไลน์' ?>
                    </li>
                </ol>
            </nav>
            <h1>
                <i class="bx bx-book-reader me-2 text-warning"></i>
                <?= !empty($learGroup) ? 'กลุ่มสาระฯ ' . esc($learGroup->lear_namethai) : 'ห้องเรียนออนไลน์' ?>
            </h1>
            <p>
                เข้าถึง Google Classroom และห้องเรียนสด Google Meet เพื่อการเรียนรู้ที่มีประสิทธิภาพ
            </p>
        </div>
    </div>

    <div class="container-xl mb-5">

        <!-- Top Action / Google Site Banner if available -->
        <?php if (!empty($learGroup) && !empty($learGroup->lear_link)) : ?>
        <div class="group-site-card">
            <div class="d-flex align-items-center gap-3">
                <div class="fs-1 text-primary">
                    <i class="bx bx-globe"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1" style="color: #0f172a;">เว็บไซต์บทเรียนออนไลน์ (Google Sites)</h5>
                    <p class="mb-0 small" style="color: #334155;">รวบรวมสื่อการสอน ใบความรู้ และแบบฝึกหัดของกลุ่มสาระฯ <?= esc($learGroup->lear_namethai) ?></p>
                </div>
            </div>
            <a href="<?= esc($learGroup->lear_link) ?>" target="_blank" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm d-inline-flex align-items-center gap-2" style="background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%); border: none;">
                <span>เข้าสู่เว็บไซต์กลุ่มสาระฯ</span>
                <i class="bx bx-link-external"></i>
            </a>
        </div>
        <?php endif; ?>

        <!-- Filter & Search Controls -->
        <div class="filter-bar-card">
            <div class="row g-3 align-items-center">
                <div class="col-md-6">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <span class="fw-bold small me-1" style="color: #0f172a;">เลือกระดับชั้น:</span>
                        <a href="<?= current_url() ?>" class="btn btn-sm <?= empty($keyroom) ? 'btn-primary' : 'btn-outline-secondary' ?> rounded-pill px-3 fw-bold">ทั้งหมด</a>
                        <?php for ($i = 1; $i <= 6; $i++) : ?>
                            <a href="<?= current_url() . '?s=' . $i ?>" class="btn btn-sm <?= ($keyroom == $i) ? 'btn-primary' : 'btn-outline-secondary' ?> rounded-pill px-3 fw-bold">
                                ม.<?= $i ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bx bx-search text-muted"></i></span>
                        <input type="text" id="filterInput" class="form-control bg-light border-start-0" placeholder="พิมพ์ค้นหาชื่อวิชา รหัสวิชา หรือชื่อครูผู้สอน..." onkeyup="filterCards()">
                    </div>
                </div>
            </div>
        </div>

        <!-- Room Cards Grid -->
        <?php if (!empty($room) && count($room) > 0) : ?>
        <div class="row g-4" id="roomsContainer">
            <?php foreach ($room as $r) : ?>
                <?php 
                    $teacherFullName = trim(($r->pers_prefix ?? '') . ($r->pers_firstname ?? '') . ' ' . ($r->pers_lastname ?? ''));
                    $teacherImg = !empty($r->pers_img) ? base_url('uploads/personnel/' . $r->pers_img) : 'https://img.icons8.com/color/96/teacher.png';
                ?>
                <div class="col-lg-4 col-md-6 room-item" 
                     data-search="<?= strtolower(esc($r->roomon_coursecode . ' ' . $r->roomon_coursename . ' ' . $teacherFullName . ' ม.' . $r->roomon_classlevel)) ?>">
                    <div class="online-room-card">
                        <div>
                            <!-- Header: Teacher info & Course title -->
                            <div class="room-header">
                                <img src="<?= $teacherImg ?>" alt="Teacher" class="teacher-avatar" onerror="this.src='https://img.icons8.com/color/96/teacher.png'">
                                <div>
                                    <span class="room-course-code"><?= esc($r->roomon_coursecode) ?></span>
                                    <h4 class="room-course-name"><?= esc($r->roomon_coursename) ?></h4>
                                    <div class="room-teacher-name">
                                        <i class="bx bx-user me-1 text-primary"></i><?= esc($teacherFullName ?: 'ครูผู้สอน') ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Badges -->
                            <div class="room-badges">
                                <span class="badge-classlevel">
                                    <i class="bx bx-group me-1"></i>ชั้น ม.<?= esc($r->roomon_classlevel) ?>
                                </span>
                                <?php if (!empty($r->roomon_year)) : ?>
                                <span class="badge-term">
                                    <i class="bx bx-calendar me-1"></i>เทอม <?= esc($r->roomon_term) ?>/<?= esc($r->roomon_year) ?>
                                </span>
                                <?php endif; ?>
                            </div>

                            <?php if (!empty($r->roomon_note)) : ?>
                            <div class="p-2 rounded-3 bg-light text-muted small mb-3 border">
                                <i class="bx bx-info-circle me-1 text-info"></i><?= esc($r->roomon_note) ?>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2 mt-2">
                            <?php if (!empty($r->roomon_linkroom)) : ?>
                            <a href="<?= esc($r->roomon_linkroom) ?>" target="_blank" class="btn-classroom">
                                <i class="bx bx-chalkboard fs-5"></i>
                                <span>เข้าห้องเรียน Google Classroom</span>
                            </a>
                            <?php endif; ?>

                            <?php if (!empty($r->roomon_liveroom)) : ?>
                            <a href="<?= esc($r->roomon_liveroom) ?>" target="_blank" class="btn-meet">
                                <i class="bx bx-video fs-5"></i>
                                <span>เข้าห้องเรียนสด Google Meet</span>
                            </a>
                            <?php endif; ?>

                            <?php if (empty($r->roomon_linkroom) && empty($r->roomon_liveroom)) : ?>
                            <div class="text-center text-muted small py-2 bg-light rounded-3">
                                ยังไม่มีลิงก์ห้องเรียนสำหรับวิชานี้
                            </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div id="noResults" class="text-center py-5 d-none">
            <div class="fs-1 text-muted mb-2"><i class="bx bx-search-alt"></i></div>
            <h5 class="fw-bold text-dark">ไม่พบห้องเรียนที่ค้นหา</h5>
            <p class="text-muted small">ลองเปลี่ยนคำค้นหา หรือเลือกระดับชั้นอื่น</p>
        </div>

        <?php else : ?>
        <div class="card border-0 rounded-4 shadow-sm p-5 text-center bg-white">
            <div class="text-primary mb-3">
                <i class="bx bx-book-open display-3"></i>
            </div>
            <h4 class="fw-bold mb-2" style="color: #0f172a;">ไม่พบข้อมูลห้องเรียนออนไลน์ในกลุ่มสาระฯ นี้</h4>
            <p class="mb-4" style="color: #475569;">ขณะนี้ยังไม่มีการเปิดห้องเรียนออนไลน์ หรือยังไม่มีข้อมูลสำหรับตัวกรองที่เลือก</p>
            <div class="d-flex justify-content-center gap-2">
                <a href="<?= base_url('LearningOnline') ?>" class="btn btn-outline-primary rounded-pill px-4 fw-bold">
                    <i class="bx bx-arrow-back me-1"></i> เลือกกลุ่มสาระฯ อื่น
                </a>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<script>
function filterCards() {
    var input = document.getElementById('filterInput').value.toLowerCase().trim();
    var cards = document.querySelectorAll('.room-item');
    var visibleCount = 0;

    cards.forEach(function(card) {
        var searchData = card.getAttribute('data-search') || '';
        if (searchData.includes(input)) {
            card.style.display = '';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    var noResults = document.getElementById('noResults');
    if (noResults) {
        if (visibleCount === 0 && cards.length > 0) {
            noResults.classList.remove('d-none');
        } else {
            noResults.classList.add('d-none');
        }
    }
}
</script>

<?= $this->endSection() ?>
