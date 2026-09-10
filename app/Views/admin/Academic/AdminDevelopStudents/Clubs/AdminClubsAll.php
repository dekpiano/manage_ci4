<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <?php 
        $isScoutPage = !empty($is_scout_page) || (isset($default_category) && $default_category === 'scout');
        $initialCategory = $isScoutPage ? 'scout' : (!empty($default_category) ? $default_category : 'club');
    ?>
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div class="page-title">
            <h4 class="fw-bold py-1 mb-0">
                <?php if ($isScoutPage): ?>
                    <span class="text-muted fw-light">วิชาการ / พัฒนาผู้เรียน /</span> กิจกรรมลูกเสือ - เนตรนารี
                <?php else: ?>
                    <span class="text-muted fw-light">วิชาการ / พัฒนาผู้เรียน /</span> จัดการชุมนุมทั้งหมด
                <?php endif; ?>
            </h4>
            <div class="text-muted small">
                <?= $isScoutPage 
                    ? 'บริหารจัดการกองลูกเสือสามัญรุ่นใหญ่, เนตรนารี, ยุวกาชาด, ผู้บำเพ็ญประโยชน์ และนักศึกษาวิชาทหาร (รด.)' 
                    : 'บันทึกข้อมูลและจัดการรายชื่อนักเรียนในแต่ละชุมนุมตามความถนัดและความสนใจ' ?>
            </div>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= site_url('Admin/Acade/DevelopStudents/Clubs/Main') ?>" class="text-success">หน้าแรกพัฒนาผู้เรียน</a></li>
                <li class="breadcrumb-item active"><?= $isScoutPage ? 'กิจกรรมลูกเสือ-เนตรนารี' : 'จัดการชุมนุม' ?></li>
            </ol>
        </nav>
    </div>

    <!-- 4 Balanced Metric / KPI Summary Cards -->
    <?php if ($isScoutPage): ?>
    <div class="row g-3 mb-4">
        <!-- Card 1: กองลูกเสือที่เปิด -->
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 scout-kpi-card" style="border-bottom: 3.5px solid #15a362 !important;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold">กองลูกเสือที่เปิด</span>
                        <div class="avatar avatar-sm">
                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-compass fs-4 text-success"></i></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h4 class="mb-0 fw-bold text-dark" id="statScoutTroops">0</h4>
                        <span class="text-muted ms-1 small">กอง/หมู่</span>
                    </div>
                    <small class="text-success fw-semibold" style="font-size: 0.75rem;">ภาคเรียนที่ <?= get_selected_term_only() ?>/<?= get_selected_year_only() ?></small>
                </div>
            </div>
        </div>

        <!-- Card 2: สมาชิกลูกเสือ-เนตรนารี -->
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 scout-kpi-card" style="border-bottom: 3.5px solid #2ecc71 !important;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold">กำลังพลทั้งหมด</span>
                        <div class="avatar avatar-sm">
                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-user-check fs-4 text-success"></i></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h4 class="mb-0 fw-bold text-success" id="statScoutStudents">0</h4>
                        <span class="text-muted ms-1 small">คน</span>
                    </div>
                    <small class="text-success fw-semibold" style="font-size: 0.75rem;">สังกัดกองเรียบร้อย</small>
                </div>
            </div>
        </div>

        <!-- Card 3: ผู้กำกับและวิทยากร -->
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 scout-kpi-card" style="border-bottom: 3.5px solid #11824e !important;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold">ผู้กำกับและวิทยากร</span>
                        <div class="avatar avatar-sm">
                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-award fs-4 text-success"></i></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h4 class="mb-0 fw-bold text-dark" id="statScoutLeaders">0</h4>
                        <span class="text-muted ms-1 small">คน</span>
                    </div>
                    <small class="text-success fw-semibold" style="font-size: 0.75rem;">ผู้รับผิดชอบกิจกรรม</small>
                </div>
            </div>
        </div>

        <!-- Card 4: อัตราความจุเป้าหมาย -->
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 scout-kpi-card" style="border-bottom: 3.5px solid #15a362 !important;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold">ความจุเป้าหมาย</span>
                        <div class="avatar avatar-sm">
                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-pie-chart-alt-2 fs-4 text-success"></i></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h4 class="mb-0 fw-bold text-dark" id="statScoutPercent">0%</h4>
                        <span class="text-muted ms-1 small" id="statScoutQuota">จาก 0 คน</span>
                    </div>
                    <div class="progress mt-2" style="height: 5px; background-color: #f0f2f5; border-radius: 6px;">
                        <div class="progress-bar bg-success" id="statScoutProgressBar" role="progressbar" style="width: 0%; border-radius: 6px; background-color: #15a362 !important;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="row g-3 mb-4">
        <!-- Card 1: ชุมนุมที่เปิดสอน -->
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100" style="border-bottom: 3.5px solid #15a362 !important;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold">ชุมนุมที่เปิดสอน</span>
                        <div class="avatar avatar-sm">
                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-extension fs-4 text-success"></i></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h4 class="mb-0 fw-bold text-dark" id="statClubTotal">0</h4>
                        <span class="text-muted ms-1 small">ชุมนุม</span>
                    </div>
                    <small class="text-success fw-semibold" style="font-size: 0.75rem;">ภาคเรียนที่ <?= get_selected_term_only() ?>/<?= get_selected_year_only() ?></small>
                </div>
            </div>
        </div>

        <!-- Card 2: นักเรียนลงทะเบียน -->
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100" style="border-bottom: 3.5px solid #2ecc71 !important;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold">นักเรียนลงทะเบียน</span>
                        <div class="avatar avatar-sm">
                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-user-check fs-4 text-success"></i></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h4 class="mb-0 fw-bold text-success" id="statClubStudents">0</h4>
                        <span class="text-muted ms-1 small">คน</span>
                    </div>
                    <small class="text-success fw-semibold" style="font-size: 0.75rem;">ลงทะเบียนแล้ว</small>
                </div>
            </div>
        </div>

        <!-- Card 3: ครูที่ปรึกษา -->
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100" style="border-bottom: 3.5px solid #03c3ec !important;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold">ครูที่ปรึกษา</span>
                        <div class="avatar avatar-sm">
                            <span class="avatar-initial rounded bg-label-info"><i class="bx bx-user-voice fs-4 text-info"></i></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h4 class="mb-0 fw-bold text-info" id="statClubTeachers">0</h4>
                        <span class="text-muted ms-1 small">คน</span>
                    </div>
                    <small class="text-info fw-semibold" style="font-size: 0.75rem;">ครูผู้ดูแล</small>
                </div>
            </div>
        </div>

        <!-- Card 4: อัตราการลงทะเบียน -->
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100" style="border-bottom: 3.5px solid #696cff !important;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold">อัตราการลงทะเบียน</span>
                        <div class="avatar avatar-sm">
                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-pie-chart-alt-2 fs-4 text-primary"></i></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h4 class="mb-0 fw-bold text-dark" id="statClubPercent">0%</h4>
                        <span class="text-muted ms-1 small" id="statClubQuota">จาก 0 คน</span>
                    </div>
                    <div class="progress mt-2" style="height: 5px; background-color: #f0f2f5; border-radius: 6px;">
                        <div class="progress-bar bg-primary" id="statClubProgressBar" role="progressbar" style="width: 0%; border-radius: 6px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Main Card -->
    <div class="card shadow-sm border-0 overflow-hidden">
        <div class="card-header bg-white border-bottom py-3">
            <div class="row align-items-center g-3">
                <div class="col-12 col-xl-5">
                    <div class="d-flex align-items-center gap-2">
                        <div class="p-2 bg-label-success text-success rounded me-1 flex-shrink-0">
                            <i class="bx <?= $isScoutPage ? 'bx-compass' : 'bx-collection' ?> fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold"><?= $isScoutPage ? 'ทำเนียบกองลูกเสือ - เนตรนารีและกิจกรรมบำเพ็ญประโยชน์' : 'รายการชุมนุมที่เปิดสอน' ?></h5>
                            <small class="text-muted"><?= $isScoutPage ? 'จัดการกองลูกเสือ ผู้กำกับ และจัดสรรรายชื่อนักเรียน' : 'จัดการชุมนุมและโควตารับสมัคร' ?></small>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-xl-7">
                    <div class="d-flex align-items-center justify-content-xl-end gap-2 flex-nowrap overflow-x-auto pb-1 pb-xl-0">
                        <!-- Academic Year Filter -->
                        <div class="input-group input-group-merge shadow-sm flex-shrink-0" style="width: 200px; min-width: 175px;">
                            <span class="input-group-text bg-light border-end-0 py-2 px-2"><i class="bx bx-calendar text-success"></i></span>
                            <?php 
                                $activeClubYearTerm = get_selected_term_only() . '/' . get_selected_year_only();
                            ?>
                            <select id="academicYearFilter" name="academicYearFilter" class="form-select fw-semibold border-start-0 py-2 ps-2 pe-3" style="font-size: 0.85rem;">
                                <?php foreach ($YearAll as $key => $v_YearAll) : 
                                    $ytVal = (isset($v_YearAll['club_trem']) ? $v_YearAll['club_trem'] : '') . '/' . (isset($v_YearAll['club_year']) ? $v_YearAll['club_year'] : '');
                                ?>
                                <option
                                    value="<?= esc($ytVal) ?>"
                                    <?= ($ytVal == $activeClubYearTerm) ? 'selected' : '' ?>>
                                     <?= (isset($v_YearAll['club_trem']) ? esc($v_YearAll['club_trem']) : '') ?> / <?= (isset($v_YearAll['club_year']) ? esc($v_YearAll['club_year']) : '') ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Schedule Attendance Button -->
                        <button type="button" class="btn btn-outline-success shadow-sm px-3 py-2 text-nowrap flex-shrink-0" id="MenuSetDateAttendancer" title="กำหนดเวลาเรียน/ตารางเวลาเช็คชื่อ" style="font-size: 0.85rem;">
                            <i class="bx bx-calendar-event me-1"></i> <?= $isScoutPage ? 'กำหนดเวลาเรียนลูกเสือ' : 'กำหนดเวลาเรียนชุมนุม' ?> (พ.ศ.)
                        </button>

                        <!-- Report Link Button -->
                        <?php if ($isScoutPage): ?>
                            <a href="<?= site_url('Admin/Acade/DevelopStudents/Scout/Report') ?>" class="btn btn-outline-secondary shadow-sm px-3 py-2 text-nowrap flex-shrink-0" title="ดูรายงานการมาเรียนและผลประเมินลูกเสือ" style="font-size: 0.85rem;">
                                <i class="bx bx-bar-chart-alt-2 me-1"></i> รายงานผลลูกเสือ
                            </a>
                        <?php else: ?>
                            <a href="<?= site_url('Admin/Acade/DevelopStudents/Clubs/Report') ?>" class="btn btn-outline-secondary shadow-sm px-3 py-2 text-nowrap flex-shrink-0" title="ดูรายงานการมาเรียนและผลประเมินชุมนุม" style="font-size: 0.85rem;">
                                <i class="bx bx-bar-chart-alt-2 me-1"></i> รายงานผลชุมนุม
                            </a>
                        <?php endif; ?>

                        <!-- Add Button -->
                        <button type="button" class="btn btn-skj-green shadow-sm px-3 py-2 BtnAddClub text-nowrap flex-shrink-0" style="font-size: 0.85rem;">
                            <span id="btnAddClubText">
                                <?php if ($isScoutPage): ?>
                                    <i class="bx bx-plus-circle me-1"></i> เพิ่มกองลูกเสือใหม่
                                <?php else: ?>
                                    <i class="bx bx-plus-circle me-1"></i> เพิ่มชุมนุมใหม่
                                <?php endif; ?>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Activity Category Tabs -->
        <div class="px-4 pt-3 pb-2 border-bottom bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
            <?php if ($isScoutPage): ?>
            <!-- Scout-specific Category Tabs -->
            <ul class="nav nav-pills" id="activityCategoryTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active fw-bold px-3 py-2" data-category="all-scout" type="button">
                        <i class="bx bx-compass me-1"></i> ทุกกองลูกเสือ-เนตรนารี
                        <span class="badge rounded-pill bg-white text-dark shadow-sm ms-1" id="badgeCountScoutAll">0</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold px-3 py-2" data-category="scout-guide" type="button">
                        <i class="bx bx-badge-check me-1"></i> ลูกเสือ - เนตรนารี (ม.1 - ม.3)
                        <span class="badge rounded-pill bg-label-success ms-1" id="badgeCountGuide">0</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold px-3 py-2" data-category="scout-redcross" type="button">
                        <i class="bx bx-plus-medical me-1"></i> ยุวกาชาด
                        <span class="badge rounded-pill bg-label-danger ms-1" id="badgeCountRedCross">0</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold px-3 py-2" data-category="scout-volunteer" type="button">
                        <i class="bx bx-heart me-1"></i> ผู้บำเพ็ญประโยชน์
                        <span class="badge rounded-pill bg-label-info ms-1" id="badgeCountVolunteer">0</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold px-3 py-2" data-category="scout-army" type="button">
                        <i class="bx bx-shield-quarter me-1"></i> นศท. (รด.) ม.ปลาย
                        <span class="badge rounded-pill bg-label-dark ms-1" id="badgeCountArmy">0</span>
                    </button>
                </li>
            </ul>
            <div class="small text-muted d-none d-lg-block" id="categoryDescText">
                <i class="bx bx-compass me-1 text-success"></i>กำลังแสดง: <b class="text-success">กิจกรรมลูกเสือ - เนตรนารี</b> (กิจกรรมภาคบังคับตามหลักสูตร)
            </div>
            <?php else: ?>
            <!-- Clubs-specific Category Tabs -->
            <ul class="nav nav-pills" id="activityCategoryTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link <?= ($initialCategory == 'club') ? 'active' : '' ?> fw-bold px-3 py-2" data-category="club" type="button">
                        <i class="bx bx-extension me-1"></i> กิจกรรมชุมนุม 
                        <span class="badge rounded-pill <?= ($initialCategory == 'club') ? 'bg-white text-dark shadow-sm' : 'bg-label-primary' ?> ms-1" id="badgeCountClub">0</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link <?= ($initialCategory == 'scout') ? 'active' : '' ?> fw-bold px-3 py-2" data-category="scout" type="button">
                        <i class="bx bx-compass me-1"></i> กิจกรรมลูกเสือ - เนตรนารี
                        <span class="badge rounded-pill <?= ($initialCategory == 'scout') ? 'bg-white text-dark shadow-sm' : 'bg-label-success' ?> ms-1" id="badgeCountScout">0</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link <?= ($initialCategory == 'all') ? 'active' : '' ?> fw-bold px-3 py-2" data-category="all" type="button">
                        <i class="bx bx-list-ul me-1"></i> ทั้งหมด
                        <span class="badge rounded-pill bg-label-secondary ms-1" id="badgeCountAll">0</span>
                    </button>
                </li>
            </ul>
            <div class="small text-muted d-none d-md-block" id="categoryDescText">
                <i class="bx bx-extension me-1 text-primary"></i>กำลังแสดง: <b class="text-primary">กิจกรรมชุมนุม</b> (ตามความถนัด/สนใจ)
            </div>
            <?php endif; ?>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle mb-0" id="TbClubs" style="width: 100%;">
                    <thead class="bg-light-primary border-top-0">
                        <tr>
                            <th class="text-center py-3" style="width: 50px;">#</th>
                            <th class="py-3" style="width: 90px;"><i class="bx bx-calendar me-1 small"></i>ปี/เทอม</th>
                            <th class="py-3"><i class="bx <?= $isScoutPage ? 'bx-compass text-success' : 'bx-label text-success' ?> me-1 small"></i><?= $isScoutPage ? 'ชื่อกอง / หมู่กิจกรรม' : 'ชื่อชุมนุม' ?></th>
                            <th class="py-3"><i class="bx <?= $isScoutPage ? 'bx-award text-success' : 'bx-user-voice text-success' ?> me-1 small"></i><?= $isScoutPage ? 'ผู้กำกับลูกเสือ' : 'ครูที่ปรึกษา' ?></th>
                            <th class="text-center py-3" style="width: 100px;"><i class="bx bx-group me-1 small"></i><?= $isScoutPage ? 'เป้าหมายรับ' : 'รับจำนวน' ?></th>
                            <th class="text-center py-3" style="width: 120px;"><i class="bx bx-user-check me-1 small"></i><?= $isScoutPage ? 'ยอดกำลังพล' : 'ยอดปัจจุบัน' ?></th>
                            <th class="text-center py-3" style="width: 130px;"><i class="bx bx-clipboard me-1 small"></i><?= $isScoutPage ? 'ทะเบียนลูกเสือ' : 'ทะเบียน' ?></th>
                            <th class="text-center py-3" style="width: 80px;"><i class="bx bx-cog me-1 small"></i>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <!-- AJAX content -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<style>
    .swal2-container { z-index: 100000 !important; }
    .bg-light-primary { background-color: #f0f8f4 !important; }
    #TbClubs thead th { 
        text-transform: uppercase; 
        font-size: 0.8rem; 
        letter-spacing: 0.5px; 
        color: #566a7f;
        border-bottom: 2px solid #e0f2e9 !important;
    }
    .select2-container--bootstrap-5 .select2-selection { 
        border-radius: 0.375rem !important; 
        border-color: #d9dee3 !important;
    }
    .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice {
        background-color: #e8f5ed !important;
        color: #15a362 !important;
        border: none !important;
        border-radius: 4px !important;
        padding: 2px 8px !important;
        font-weight: 500 !important;
        margin-top: 5px !important;
    }
    .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice__remove {
        color: #15a362 !important;
        margin-right: 5px !important;
    }
    .select2-container--bootstrap-5.select2-container--focus .select2-selection {
        border-color: #15a362 !important;
        box-shadow: 0 0 0.25rem 0.05rem rgba(21, 163, 98, 0.15) !important;
    }
    .card-hover:hover { transform: translateY(-3px); transition: all 0.3s ease; }

    /* Custom styles for Student Modal Add By Class */
    #pills-tab-add-mode .nav-link {
        color: #566a7f;
        border-radius: 0.375rem;
        transition: all 0.2s ease;
    }
    #pills-tab-add-mode .nav-link.active {
        background-color: #15a362 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 6px rgba(21, 163, 98, 0.3);
    }
    #genderFilterGroup .btn-check:checked + .btn-outline-secondary {
        background-color: #15a362 !important;
        border-color: #15a362 !important;
        color: #ffffff !important;
    }
    .student-preview-row:hover {
        background-color: #f6fcf8;
    }
    .bg-label-success {
        background-color: #e8f5ed !important;
        color: #15a362 !important;
    }
    .text-skj-green {
        color: #15a362 !important;
    }
    .btn-skj-green {
        background-color: #15a362 !important;
        border-color: #15a362 !important;
        color: #ffffff !important;
    }
    .btn-skj-green:hover, .btn-skj-green:focus {
        background-color: #11824e !important;
        border-color: #11824e !important;
        color: #ffffff !important;
    }
    .btn-outline-skj-green {
        color: #15a362 !important;
        border-color: #15a362 !important;
    }
    .btn-outline-skj-green:hover, .btn-outline-skj-green:focus {
        background-color: #15a362 !important;
        border-color: #15a362 !important;
        color: #ffffff !important;
    }
    .scout-kpi-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .scout-kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.08) !important;
    }
    /* Activity Category Tabs Modern Styling */
    #activityCategoryTabs .nav-link {
        border-radius: 50rem;
        padding: 0.45rem 1.1rem;
        transition: all 0.25s ease-in-out;
        color: #566a7f;
        border: 1px solid #eceef1;
    }
    #activityCategoryTabs .nav-link:hover {
        background-color: #f8fafc;
        border-color: #d9dee3;
    }
    #activityCategoryTabs .nav-link.active[data-category="club"] {
        background-color: #15a362 !important;
        border-color: #15a362 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(21, 163, 98, 0.3);
    }
    #activityCategoryTabs .nav-link.active[data-category="scout"],
    #activityCategoryTabs .nav-link.active[data-category="all-scout"] {
        background-color: #15a362 !important;
        border-color: #15a362 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(21, 163, 98, 0.35);
    }
    #activityCategoryTabs .nav-link.active[data-category="scout-guide"] {
        background-color: #11824e !important;
        border-color: #11824e !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(17, 130, 78, 0.35);
    }
    #activityCategoryTabs .nav-link.active[data-category="scout-redcross"] {
        background-color: #ea5455 !important;
        border-color: #ea5455 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(234, 84, 85, 0.35);
    }
    #activityCategoryTabs .nav-link.active[data-category="scout-volunteer"] {
        background-color: #03c3ec !important;
        border-color: #03c3ec !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(3, 195, 236, 0.35);
    }
    #activityCategoryTabs .nav-link.active[data-category="scout-army"] {
        background-color: #4b4b4b !important;
        border-color: #4b4b4b !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(75, 75, 75, 0.35);
    }
    #activityCategoryTabs .nav-link.active[data-category="all"] {
        background-color: #566a7f !important;
        border-color: #566a7f !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(86, 106, 127, 0.25);
    }
</style>

<?= view('admin/Academic/AdminDevelopStudents/Clubs/AdminClubSetDateAttendance.php'); ?>

<!-- Modal Add/Edit Clubs -->
<div class="modal fade" id="ModalAddClubs" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-bottom bg-label-success py-3" id="clubModalHeader">
                <h5 class="modal-title fw-bold text-success" id="clubModalLabel">
                    <i class="bx bx-edit-alt me-2"></i>ข้อมูลชุมนุม
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="FormAddClubs">
                    <input type="hidden" name="club_id" id="club_id">
                    
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="form-floating">
                                <select class="form-select" id="club_year" name="club_year" required>
                                    <option value="" disabled>เลือกปีการศึกษา</option>
                                    <?php 
                                        $activeOnlyYear = get_selected_year_only();
                                        $currY = (int)date('Y') + 543;
                                        for ($yi = $currY - 1; $yi <= $currY + 2; $yi++):
                                    ?>
                                    <option value="<?= $yi ?>" <?= ($yi == $activeOnlyYear) ? 'selected' : '' ?>><?= $yi ?></option>
                                    <?php endfor; ?>
                                </select>
                                <label for="club_year">ปีการศึกษา</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating">
                                <select class="form-select" id="club_trem" name="club_trem" required>
                                    <option value="" disabled>เลือกภาคเรียน</option>
                                    <option value="1" <?= (get_selected_term_only() == '1') ? 'selected' : '' ?>>1</option>
                                    <option value="2" <?= (get_selected_term_only() == '2') ? 'selected' : '' ?>>2</option>
                                </select>
                                <label for="club_trem">ภาคเรียน (เทอม)</label>
                            </div>
                        </div>
                    </div>

                    <!-- ประเภทกิจกรรม (Activity Type Selection) -->
                    <div class="mb-3 p-3 rounded bg-light border">
                        <label class="form-label fw-bold text-dark small mb-2 d-flex justify-content-between align-items-center">
                            <span><i class="bx bx-category text-primary me-1"></i>ประเภทกิจกรรม</span>
                            <span class="badge bg-label-info font-monospace small">เลือกเพื่อให้ระบบจัดหมวดหมู่อัตโนมัติ</span>
                        </label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="modal_activity_type" id="modal_type_club" value="club" checked>
                                <label class="btn btn-outline-primary w-100 py-2 d-flex align-items-center justify-content-center gap-1" for="modal_type_club">
                                    <i class="bx bx-extension"></i>
                                    <span class="fw-semibold">กิจกรรมชุมนุม</span>
                                </label>
                            </div>
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="modal_activity_type" id="modal_type_scout" value="scout">
                                <label class="btn btn-outline-success w-100 py-2 d-flex align-items-center justify-content-center gap-1" for="modal_type_scout">
                                    <i class="bx bx-compass"></i>
                                    <span class="fw-semibold">ลูกเสือ - เนตรนารี</span>
                                </label>
                            </div>
                        </div>

                        <!-- Quick suggestions for Scout -->
                        <div id="scoutQuickPresets" class="mt-2 pt-2 border-top d-none">
                            <div class="small text-muted mb-1">
                                <i class="bx bx-bolt-circle text-success me-1"></i>เลือกชื่อมาตรฐานด่วน:
                            </div>
                            <div class="d-flex flex-wrap gap-1">
                                <button type="button" class="btn btn-xs btn-label-secondary scout-preset-btn" data-name="ลูกเสือ - เนตรนารี ระดับชั้นมัธยมศึกษาปีที่ 1" data-level="ม.ต้น" data-desc="กิจกรรมลูกเสือ - เนตรนารี ระดับชั้นมัธยมศึกษาปีที่ 1">ลูกเสือ ม.1</button>
                                <button type="button" class="btn btn-xs btn-label-secondary scout-preset-btn" data-name="ลูกเสือ - เนตรนารี ระดับชั้นมัธยมศึกษาปีที่ 2" data-level="ม.ต้น" data-desc="กิจกรรมลูกเสือ - เนตรนารี ระดับชั้นมัธยมศึกษาปีที่ 2">ลูกเสือ ม.2</button>
                                <button type="button" class="btn btn-xs btn-label-secondary scout-preset-btn" data-name="ลูกเสือ - เนตรนารี ระดับชั้นมัธยมศึกษาปีที่ 3" data-level="ม.ต้น" data-desc="กิจกรรมลูกเสือ - เนตรนารี ระดับชั้นมัธยมศึกษาปีที่ 3">ลูกเสือ ม.3</button>
                                <button type="button" class="btn btn-xs btn-label-secondary scout-preset-btn" data-name="ยุวกาชาด ระดับชั้นมัธยมศึกษาตอนต้น" data-level="ม.ต้น" data-desc="กิจกรรมยุวกาชาด ระดับชั้นมัธยมศึกษาตอนต้น">ยุวกาชาด</button>
                                <button type="button" class="btn btn-xs btn-label-secondary scout-preset-btn" data-name="ผู้บำเพ็ญประโยชน์ ระดับชั้นมัธยมศึกษาตอนต้น" data-level="ม.ต้น" data-desc="กิจกรรมผู้บำเพ็ญประโยชน์ ระดับชั้นมัธยมศึกษาตอนต้น">ผู้บำเพ็ญประโยชน์</button>
                                <button type="button" class="btn btn-xs btn-label-secondary scout-preset-btn" data-name="นักศึกษาวิชาทหาร (รด.)" data-level="ม.ปลาย" data-desc="กิจกรรมนักศึกษาวิชาทหาร (นศท.) ระดับชั้นมัธยมศึกษาตอนปลาย">รด./นศท. ม.ปลาย</button>
                            </div>
                        </div>
                    </div>

                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" id="club_name" name="club_name" placeholder="ชื่อชุมนุม" required>
                        <label for="club_name">ชื่อหัวข้อชุมนุม / กิจกรรม</label>
                    </div>

                    <div class="form-floating mb-4">
                        <textarea class="form-control" id="club_description" name="club_description" style="height: 100px" placeholder="รายละเอียด"></textarea>
                        <label for="club_description">รายละเอียดหรือคำอธิบายชุดกิจกรรม</label>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="club_max_participants" name="club_max_participants" placeholder="รับจำนวน" required min="1">
                                <label for="club_max_participants">จำนวนนักเรียนที่รับ (คน)</label>
                            </div>
                            <div id="quotaSuggestionAlert" class="alert alert-warning py-2 px-3 mt-2 small d-none mb-0" role="alert">
                                <i class="bx bx-info-circle me-1"></i>
                                <span id="quotaSuggestionMessage">แนะนำปรับเป็น <b>0</b> คน</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating">
                                <select class="form-select" id="club_level" name="club_level" required>
                                    <option value="" disabled selected>เลือกกลุ่มระดับชั้น</option>
                                    <option value="ม.ต้น">ม.ต้น</option>
                                    <option value="ม.ปลาย">ม.ปลาย</option>
                                    <option value="ม.ต้น และ ม.ปลาย">ม.ต้น และ ม.ปลาย</option>
                                    <option value="ม.ต้น หรือ ม.ปลาย">ม.ต้น หรือ ม.ปลาย</option>
                                </select>
                                <label for="club_level">ระดับชั้นที่รับ</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small text-uppercase mb-2">
                             <i class="bx bx-user-check text-primary me-1"></i> ครูที่ปรึกษาชุมนุม (เลือกได้หลายชื่อ)
                        </label>
                        <div class="select2-primary">
                            <select class="form-select select2" id="club_faculty_advisor" name="club_faculty_advisor[]" multiple required style="width: 100%;">
                            </select>
                        </div>
                        <div class="form-text small">พิมพ์รายชื่อครูที่ต้องการค้นหาและเลือก</div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-label-secondary flex-grow-1" data-bs-dismiss="modal">
                            <i class="bx bx-x me-1"></i> ยกเลิก
                        </button>
                        <button type="submit" class="btn btn-skj-green flex-grow-1 shadow" id="btnSubmitClubForm">
                            <i class="bx bx-save me-1"></i> บันทึกข้อมูล
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Manage Students -->
<div class="modal fade" id="ModalAddStudents" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered" style="max-width: 1240px; width: 95%;">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom py-3" style="background-color: #f6fcf8; border-color: #e0f2e9 !important;">
                <div class="d-flex align-items-center">
                    <div class="p-2 rounded me-3 shadow-sm text-white" style="background-color: #15a362;">
                        <i class="bx bx-group fs-4"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0 text-dark" id="AddStudentsTitle">จัดการนักเรียน</h5>
                        <small class="text-muted">เพิ่มและยกเลิกรายการนักเรียนในชุมนุม</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="row g-0">
                    <!-- Left Column: Add Student -->
                    <div class="col-lg-5 col-xl-4 border-end bg-light p-3 p-xl-4 d-flex flex-column" style="background-color: #fafbfc !important;">
                        <input type="hidden" name="club_id" class="club_id" value="">
                        
                        <!-- Nav Tabs: Mode Switcher -->
                        <ul class="nav nav-pills nav-fill mb-3 p-1 rounded bg-white border shadow-sm" id="pills-tab-add-mode" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active py-2 fw-semibold" id="tab-class-batch-btn" data-bs-toggle="pill" data-bs-target="#tab-class-batch" type="button" role="tab">
                                    <i class="bx bx-buildings me-1"></i> เพิ่มเป็นรายห้อง
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link py-2 fw-semibold" id="tab-student-individual-btn" data-bs-toggle="pill" data-bs-target="#tab-student-individual" type="button" role="tab">
                                    <i class="bx bx-user me-1"></i> ค้นหารายคน
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content flex-grow-1" id="pills-tabContent-add-mode">
                            <!-- TAB 1: ADD BY CLASSROOM -->
                            <div class="tab-pane fade show active" id="tab-class-batch" role="tabpanel">
                                <!-- Classroom Select -->
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-dark d-flex justify-content-between align-items-center">
                                        <span><i class="bx bx-chalkboard me-1 text-skj-green"></i> เลือกห้องเรียน</span>
                                        <span class="badge bg-label-success" id="badgeTotalFoundRoom">0 ห้อง</span>
                                    </label>
                                    <select id="classroomSelect" class="form-select shadow-sm fw-semibold">
                                        <option value="">-- กำลังโหลดห้องเรียน... --</option>
                                    </select>
                                </div>

                                <!-- Gender Filter -->
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-dark d-block">
                                        <i class="bx bx-male-female me-1 text-skj-green"></i> ตัวกรองกลุ่มนักเรียน / เพศ
                                    </label>
                                    <div class="btn-group w-100 shadow-sm" role="group" id="genderFilterGroup">
                                        <input type="radio" class="btn-check" name="class_gender" id="gender_all" value="all" checked>
                                        <label class="btn btn-outline-secondary btn-sm py-2" for="gender_all">
                                            ทั้งหมด
                                        </label>

                                        <input type="radio" class="btn-check" name="class_gender" id="gender_male" value="male">
                                        <label class="btn btn-outline-secondary btn-sm py-2" for="gender_male" title="สำหรับลูกเสือ">
                                            👦 ชาย (ลูกเสือ)
                                        </label>

                                        <input type="radio" class="btn-check" name="class_gender" id="gender_female" value="female">
                                        <label class="btn btn-outline-secondary btn-sm py-2" for="gender_female" title="สำหรับเนตรนารี/ยุวกาชาด">
                                            👧 หญิง (เนตรนารี)
                                        </label>
                                    </div>
                                </div>

                                <!-- Live Student Preview Box -->
                                <div class="card border shadow-none mb-3">
                                    <div class="card-header bg-white py-2 px-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="checkbox" id="checkAllClassStudents" checked>
                                            <label class="form-check-label fw-bold small user-select-none" for="checkAllClassStudents">
                                                เลือกทั้งหมด
                                            </label>
                                        </div>
                                        <span class="small fw-semibold text-muted" id="classStudentSummary">
                                            เลือก 0 คน
                                        </span>
                                    </div>
                                    <div class="card-body p-0" style="max-height: 250px; overflow-y: auto;" id="classStudentPreviewList">
                                        <div class="text-center py-4 text-muted small">
                                            <i class="bx bx-info-circle fs-3 d-block mb-1 text-muted"></i>
                                            กรุณาเลือกห้องเรียนเพื่อดูรายชื่อนักเรียน
                                        </div>
                                    </div>
                                </div>

                                <!-- Allow Transfer Checkbox if student in another club -->
                                <div class="form-check form-switch mb-3 p-2 bg-white rounded border border-warning-subtle" id="boxAllowTransfer" style="display: none;">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" id="allowTransferSwitch" checked>
                                    <label class="form-check-label small fw-semibold text-dark" for="allowTransferSwitch">
                                        ย้ายนักเรียนจากชุมนุมเดิมอัตโนมัติ (หากเลือกคนที่อยู่ชุมนุมอื่น)
                                    </label>
                                </div>

                                <!-- Button Add by Class -->
                                <button type="button" id="btnAddClassToClub" class="btn btn-skj-green w-100 py-2 shadow fw-bold mb-3" disabled>
                                    <i class="bx bx-user-plus me-1"></i> เพิ่มนักเรียนเข้าชุมนุม (<span id="btnSelectedCount">0</span> คน)
                                </button>
                            </div>

                            <!-- TAB 2: ADD BY INDIVIDUAL (SELECT2) -->
                            <div class="tab-pane fade" id="tab-student-individual" role="tabpanel">
                                <form id="FormAddStudentToClub">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-dark">
                                            <i class="bx bx-search me-1 text-skj-green"></i> ค้นหาและเลือกรายชื่อนักเรียน
                                        </label>
                                        <select id="studentSelect" name="student_ids[]" multiple class="form-select shadow-sm" style="width: 100%;">
                                        </select>
                                        <div class="form-text small">พิมพ์ค้นหาด้วย ชื่อ, นามสกุล หรือรหัสนักเรียน</div>
                                    </div>
                                    <button type="button" id="btnAddStudentToClub" class="btn btn-skj-green w-100 py-2 shadow fw-bold mb-3">
                                        <i class="bx bx-plus me-1"></i> ยืนยันการเพิ่มนักเรียน
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Summary Capacity Card -->
                        <div class="p-3 bg-white rounded border shadow-sm mt-auto">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-pie-chart-alt-2 text-skj-green me-2 fs-4"></i>
                                    <span class="fw-bold small text-dark">ยอดสมาชิกในชุมนุม</span>
                                </div>
                                <span class="badge bg-label-success" id="capacityPercentBadge">0%</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-baseline">
                                <div class="h4 mb-0 text-skj-green fw-bold" id="registeredCountDisplay">0 <small class="text-muted fs-6 fw-normal">คน</small></div>
                                <div class="text-muted small d-flex align-items-center">
                                    <span>โควตารับ <span class="fw-bold text-dark" id="maxCapacityDisplay">0</span> คน</span>
                                    <button type="button" class="btn btn-xs btn-outline-primary ms-1 py-0 px-1 border-0" id="btnQuickEditQuota" title="คลิกเพื่อแก้ไขโควตารับคน">
                                        <i class="bx bx-edit-alt fs-6"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar bg-success" id="capacityProgressBar" role="progressbar" style="width: 0%"></div>
                            </div>
                            <div class="text-muted small mt-2 d-flex justify-content-between">
                                <span>คงเหลือ: <b id="remainingCapacity" class="text-dark">0</b> คน</span>
                                <span id="capacityWarningText" class="text-danger fw-bold" style="display: none;"></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column: Registered List -->
                    <div class="col-lg-7 col-xl-8 p-3 p-xl-4">
                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">รายชื่อนักเรียนที่ลงทะเบียนแล้ว</h6>
                                <div class="small text-muted" id="registeredSubText">กำลังโหลด...</div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-sm btn-outline-danger shadow-sm" id="btnBatchDelete" style="display: none;">
                                    <i class="bx bx-trash me-1"></i> ลบที่เลือก (<span id="selectedDeleteCount">0</span>)
                                </button>
                                <span class="badge bg-label-success px-3 py-2 fs-6" id="registeredCount">0 คน</span>
                            </div>
                        </div>

                        <!-- Quick Search in Registered Table -->
                        <div class="mb-3">
                            <div class="input-group input-group-merge shadow-sm">
                                <span class="input-group-text bg-white border-end-0"><i class="bx bx-search text-muted"></i></span>
                                <input type="text" id="searchRegisStudent" class="form-control border-start-0" placeholder="พิมพ์เพื่อค้นหาชื่อ, เลขที่, ห้อง ในตารางนี้...">
                            </div>
                        </div>

                        <!-- Registered Students Table (No horizontal scrollbar, perfectly responsive) -->
                        <div class="rounded border bg-white shadow-sm" style="max-height: 480px; overflow-y: auto; overflow-x: hidden;">
                            <table class="table table-hover align-middle mb-0" id="TbShowStudentRegisClub" style="width: 100%;">
                                <thead class="bg-light sticky-top" style="z-index: 5;">
                                    <tr>
                                        <th class="text-center py-2 px-1" style="width: 34px;">
                                            <input class="form-check-input" type="checkbox" id="checkAllRegistered">
                                        </th>
                                        <th class="text-center py-2 px-1" style="width: 36px;">#</th>
                                        <th class="text-center py-2 px-1 text-nowrap" style="width: 60px;">ชั้น</th>
                                        <th class="text-center py-2 px-1 text-nowrap" style="width: 50px;">เลขที่</th>
                                        <th class="py-2 px-2 text-nowrap" style="width: 85px;">รหัส</th>
                                        <th class="py-2 px-2 text-nowrap">ชื่อ-นามสกุล</th>
                                        <th class="text-center py-2 px-1 text-nowrap" style="width: 55px;">เพศ</th>
                                        <th class="text-center py-2 px-1 text-nowrap" style="width: 50px;">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody id="addedStudentsList">
                                    <!-- AJAX Content -->
                                </tbody>
                            </table>
                        </div>
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
    const isScoutPage = <?= $isScoutPage ? 'true' : 'false' ?>;
    let currentActivityCategory = isScoutPage ? 'all-scout' : '<?= $initialCategory ?>';

    $('#academicYearFilter').change(function() {
        table.ajax.reload();
    });

    // DataTables search filter for activity category (Club categories vs Scout sub-categories)
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex, rowData, counter) {
            if (!settings || !settings.nTable || settings.nTable.id !== 'TbClubs') return true;
            const name = (rowData && rowData.club_name) || '';
            const isScout = (rowData && (rowData.is_scout === true || rowData.activity_type === 'scout')) 
                || /ลูกเสือ|เนตรนารี|ยุวกาชาด|ผู้บำเพ็ญประโยชน์|นศท|รักษาดินแดน|รด\./i.test(name);
            
            if (isScoutPage) {
                // On Scout page, only display scout/guidance activities
                if (!isScout) return false;

                if (currentActivityCategory === 'all-scout' || currentActivityCategory === 'scout' || currentActivityCategory === 'all') {
                    return true;
                } else if (currentActivityCategory === 'scout-guide') {
                    return /ลูกเสือ|เนตรนารี/i.test(name);
                } else if (currentActivityCategory === 'scout-redcross') {
                    return /ยุวกาชาด/i.test(name);
                } else if (currentActivityCategory === 'scout-volunteer') {
                    return /ผู้บำเพ็ญประโยชน์/i.test(name);
                } else if (currentActivityCategory === 'scout-army') {
                    return /นศท|รักษาดินแดน|รด\./i.test(name);
                }
                return true;
            } else {
                if (currentActivityCategory === 'all') return true;
                if (currentActivityCategory === 'scout') return isScout;
                if (currentActivityCategory === 'club') return !isScout;
                return true;
            }
        }
    );

    // Compute Scout Dashboard Stats & Tab Badges
    function updateScoutDashboardStats(data) {
        if (!data) return;
        const scoutRows = data.filter(r => {
            return (r.is_scout === true || r.activity_type === 'scout') ||
                /ลูกเสือ|เนตรนารี|ยุวกาชาด|ผู้บำเพ็ญประโยชน์|นศท|รักษาดินแดน|รด\./i.test(r.club_name || '');
        });

        const totalTroops = scoutRows.length;
        let totalStudents = 0;
        let totalQuota = 0;
        const advisorSet = new Set();

        let countGuide = 0;
        let countRedCross = 0;
        let countVolunteer = 0;
        let countArmy = 0;

        scoutRows.forEach(r => {
            const count = parseInt(r.member_count) || 0;
            const max = parseInt(r.club_max_participants) || 0;
            totalStudents += count;
            totalQuota += max;

            if (r.club_faculty_advisor) {
                r.club_faculty_advisor.split('|').forEach(id => {
                    const clean = id.trim();
                    if (clean) advisorSet.add(clean);
                });
            }

            const name = r.club_name || '';
            if (/ลูกเสือ|เนตรนารี/i.test(name)) countGuide++;
            if (/ยุวกาชาด/i.test(name)) countRedCross++;
            if (/ผู้บำเพ็ญประโยชน์/i.test(name)) countVolunteer++;
            if (/นศท|รักษาดินแดน|รด\./i.test(name)) countArmy++;
        });

        const percent = totalQuota > 0 ? Math.round((totalStudents / totalQuota) * 100) : 0;

        $('#statScoutTroops').text(totalTroops.toLocaleString());
        $('#statScoutStudents').text(totalStudents.toLocaleString());
        $('#statScoutLeaders').text(advisorSet.size.toLocaleString());
        $('#statScoutPercent').text(percent + '%');
        $('#statScoutQuota').text(`จากเป้าหมาย ${totalQuota.toLocaleString()} คน`);
        $('#statScoutProgressBar').css('width', (percent > 100 ? 100 : percent) + '%');

        $('#badgeCountScoutAll').text(totalTroops.toLocaleString());
        $('#badgeCountGuide').text(countGuide.toLocaleString());
        $('#badgeCountRedCross').text(countRedCross.toLocaleString());
        $('#badgeCountVolunteer').text(countVolunteer.toLocaleString());
        $('#badgeCountArmy').text(countArmy.toLocaleString());
    }

    // Compute Clubs Dashboard Stats
    function updateClubDashboardStats(data, counts) {
        if (!data) return;
        const clubRows = data.filter(r => {
            const isScout = (r.is_scout === true || r.activity_type === 'scout') ||
                /ลูกเสือ|เนตรนารี|ยุวกาชาด|ผู้บำเพ็ญประโยชน์|นศท|รักษาดินแดน|รด\./i.test(r.club_name || '');
            return !isScout;
        });

        const totalClubs = clubRows.length;
        let totalStudents = 0;
        let totalQuota = 0;
        const advisorSet = new Set();

        clubRows.forEach(r => {
            totalStudents += parseInt(r.member_count) || 0;
            totalQuota += parseInt(r.club_max_participants) || 0;
            if (r.club_faculty_advisor) {
                r.club_faculty_advisor.split('|').forEach(id => {
                    const clean = id.trim();
                    if (clean) advisorSet.add(clean);
                });
            }
        });

        const percent = totalQuota > 0 ? Math.round((totalStudents / totalQuota) * 100) : 0;

        $('#statClubTotal').text(totalClubs.toLocaleString());
        $('#statClubStudents').text(totalStudents.toLocaleString());
        $('#statClubTeachers').text(advisorSet.size.toLocaleString());
        $('#statClubPercent').text(percent + '%');
        $('#statClubQuota').text(`จากเป้าหมาย ${totalQuota.toLocaleString()} คน`);
        $('#statClubProgressBar').css('width', (percent > 100 ? 100 : percent) + '%');

        if (counts) {
            $('#badgeCountAll').text(counts.all || data.length);
            $('#badgeCountClub').text(counts.club || totalClubs);
            $('#badgeCountScout').text(counts.scout || (data.length - totalClubs));
        }
    }

    const table = $('#TbClubs').DataTable({
        processing: true,
        language: {
            emptyTable: "ไม่พบข้อมูลในตาราง",
            info: "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
            infoEmpty: "แสดง 0 ถึง 0 จาก 0 รายการ",
            infoFiltered: "(กรองข้อมูลจากทั้งหมด _MAX_ รายการ)",
            lengthMenu: "แสดง _MENU_ รายการ",
            loadingRecords: "กำลังโหลด...",
            processing: "กำลังประมวลผล...",
            search: "ค้นหา:",
            zeroRecords: "ไม่พบรายการที่ตรงกับการค้นหา",
            paginate: {
                first: "หน้าแรก",
                previous: "ก่อนหน้า",
                next: "ถัดไป",
                last: "หน้าสุดท้าย"
            }
        },
        ajax: {
            url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsShow') ?>",
            type: "GET",
            dataSrc: function(json) {
                const data = json.data || [];
                if (isScoutPage) {
                    updateScoutDashboardStats(data);
                } else {
                    updateClubDashboardStats(data, json.counts);
                }
                return data;
            },
            data: function(d) {
                d.year = decodeURIComponent($('#academicYearFilter').val());
            }
        },
        columns: [
            {
                data: null,
                className: 'text-center',
                render: function(data, type, row, meta) {
                    return `<span class="fw-semibold">${meta.row + 1}</span>`;
                },
                orderable: false
            },
            {
                data: null,
                render: function(data, type, row) {
                    return `<span class="badge bg-label-secondary">${row.club_trem}/${row.club_year}</span>`;
                }
            },
            {
                data: "club_name",
                render: function(data, type, row) {
                    const name = data || '';
                    let typeBadge = '';
                    if (isScoutPage) {
                        if (/ยุวกาชาด/i.test(name)) {
                            typeBadge = `<span class="badge bg-label-danger me-1 px-2 py-1"><i class="bx bx-plus-medical me-1"></i>ยุวกาชาด</span>`;
                        } else if (/ผู้บำเพ็ญประโยชน์/i.test(name)) {
                            typeBadge = `<span class="badge bg-label-info me-1 px-2 py-1"><i class="bx bx-heart me-1"></i>ผู้บำเพ็ญประโยชน์</span>`;
                        } else if (/นศท|รักษาดินแดน|รด\./i.test(name)) {
                            typeBadge = `<span class="badge bg-label-dark me-1 px-2 py-1"><i class="bx bx-shield-quarter me-1"></i>นศท. (รด.)</span>`;
                        } else {
                            typeBadge = `<span class="badge bg-label-success text-success me-1 px-2 py-1"><i class="bx bx-compass me-1"></i>ลูกเสือ-เนตรนารี</span>`;
                        }
                    } else {
                        const isScout = (row.is_scout === true || row.activity_type === 'scout')
                            || /ลูกเสือ|เนตรนารี|ยุวกาชาด|ผู้บำเพ็ญประโยชน์|นศท|รักษาดินแดน|รด\./i.test(name);
                        typeBadge = isScout 
                            ? `<span class="badge bg-label-success text-success me-1 px-2 py-1"><i class="bx bx-compass me-1"></i>ลูกเสือ-เนตรนารี</span>` 
                            : `<span class="badge bg-label-success text-success me-1 px-2 py-1"><i class="bx bx-extension me-1"></i>ชุมนุม</span>`;
                    }

                    const levelBadge = row.club_level ? `<span class="badge bg-label-secondary font-monospace ms-1 small">${row.club_level}</span>` : '';

                    return `
                        <div>
                            <div class="d-flex align-items-center flex-wrap gap-1 mb-1">
                                ${typeBadge}
                                ${levelBadge}
                                <span class="fw-bold text-dark ms-1">${name}</span>
                            </div>
                            ${row.club_description ? `<small class="text-muted d-block text-truncate" style="max-width: 320px;" title="${row.club_description}"><i class="bx bx-info-circle me-1 small"></i>${row.club_description}</small>` : ''}
                        </div>
                    `;
                }
            },
            {
                data: null,
                render: function(data, type, row) {
                    const iconClass = isScoutPage ? 'bx bx-award text-success' : 'bx bx-user-voice text-success';
                    if (!row.advisor_names || row.advisor_names.trim() === '') {
                        return `<span class="text-muted fst-italic small"><i class="${iconClass} me-1"></i>ยังไม่ได้ระบุ</span>`;
                    }

                    const advNames = row.advisor_names.split(',').map(s => s.trim()).filter(Boolean);
                    if (advNames.length === 0) {
                        return `<span class="text-muted fst-italic small"><i class="${iconClass} me-1"></i>ยังไม่ได้ระบุ</span>`;
                    }

                    if (advNames.length === 1) {
                        return `<div class="small d-flex align-items-center text-nowrap"><i class="${iconClass} me-1.5 flex-shrink-0"></i><span class="text-dark fw-semibold">${advNames[0]}</span></div>`;
                    }

                    // กรณีมีผู้กำกับลูกเสือ/ครูที่ปรึกษาหลายท่าน ให้แสดงผลบรรทัดละคน
                    let listHtml = `<div class="d-flex flex-column gap-1 py-1" style="min-width: 190px;">`;
                    advNames.forEach(name => {
                        listHtml += `
                            <div class="d-flex align-items-center small text-nowrap">
                                <i class="${iconClass} me-1.5 flex-shrink-0" style="font-size: 0.95rem;"></i>
                                <span class="text-dark fw-semibold">${name}</span>
                            </div>
                        `;
                    });
                    listHtml += `</div>`;
                    return listHtml;
                }
            },
            {
                data: null,
                className: 'text-center',
                render: function(data, type, row) {
                    return `<span class="badge bg-label-secondary fw-semibold px-2 py-1">${row.club_max_participants} คน</span>`;
                }
            },
            {
                data: null,
                className: 'text-center',
                render: function(data, type, row) {
                    const max = parseInt(row.club_max_participants) || 0;
                    const count = parseInt(row.member_count) || 0;
                    const percent = max > 0 ? Math.round((count / max) * 100) : 0;
                    const color = isScoutPage
                        ? (percent >= 100 ? 'success' : (percent >= 75 ? 'warning' : 'info'))
                        : (percent >= 100 ? 'danger' : (percent >= 80 ? 'warning' : 'success'));
                    return `
                        <div class="d-inline-flex flex-column align-items-center" style="min-width: 95px;">
                            <span class="fw-bold text-${color} small mb-1">${count} คน <small class="text-muted">(${percent}%)</small></span>
                            <div class="progress w-100" style="height: 5px; background-color: #f0f2f5; border-radius: 10px;">
                                <div class="progress-bar bg-${color}" role="progressbar" style="width: ${percent > 100 ? 100 : percent}%; border-radius: 10px;"></div>
                            </div>
                        </div>
                    `;
                }
            },
            {
                data: null,
                className: 'text-center',
                render: function(data, type, row) {
                    const btnLabel = isScoutPage ? 'ทะเบียนลูกเสือ' : 'ทะเบียน';
                    return `
                        <button class="btn btn-sm btn-outline-success BtnAddStudents shadow-sm px-3 text-nowrap" data-id="${row.club_id}" clubname="${row.club_name}" max="${row.club_max_participants}" count="${row.member_count}">
                            <i class="bx bx-user-check me-1"></i> ${btnLabel} (<span class="fw-bold">${row.member_count}</span>)
                        </button>
                    `;
                }
            },
            {
                data: null,
                className: 'text-center',
                render: function(data, type, row) {
                    return `
                        <div class="d-flex gap-1 justify-content-center">
                            <button class="btn btn-sm btn-icon btn-label-secondary edit-btn" data-id="${row.club_id}" title="แก้ไข">
                                <i class="bx bx-edit-alt"></i>
                            </button>
                            <button class="btn btn-sm btn-icon btn-label-danger delete-btn" data-id="${row.club_id}" title="ลบ">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        drawCallback: function() {
            const placeholderText = isScoutPage ? 'ค้นหากองลูกเสือ, ผู้กำกับ...' : 'ค้นหาชุมนุม, ครูที่ปรึกษา...';
            $('.dataTables_filter input').addClass('form-control shadow-sm').attr('placeholder', placeholderText);
            $('.dataTables_length select').addClass('form-select shadow-sm');
        }
    });

    // Handle Category Tabs Switch
    $('#activityCategoryTabs button').on('click', function() {
        $('#activityCategoryTabs button').removeClass('active');
        $(this).addClass('active');

        currentActivityCategory = $(this).data('category');

        if (isScoutPage) {
            // Scout tab styling
            $('#activityCategoryTabs button').each(function() {
                const cat = $(this).data('category');
                const badge = $(this).find('.badge');
                if ($(this).hasClass('active')) {
                    badge.removeClass('bg-label-warning bg-label-danger bg-label-info bg-label-dark bg-label-secondary bg-label-success').addClass('bg-white text-dark shadow-sm');
                } else {
                    badge.removeClass('bg-white text-dark shadow-sm');
                    if (cat === 'all-scout') badge.addClass('bg-label-success text-success');
                    else if (cat === 'scout-guide') badge.addClass('bg-label-success text-success');
                    else if (cat === 'scout-redcross') badge.addClass('bg-label-danger text-danger');
                    else if (cat === 'scout-volunteer') badge.addClass('bg-label-info text-info');
                    else if (cat === 'scout-army') badge.addClass('bg-label-dark text-dark');
                }
            });

            if (currentActivityCategory === 'all-scout') {
                $('#categoryDescText').html('<i class="bx bx-compass me-1 text-success"></i>กำลังแสดง: <b class="text-success">ทุกกองลูกเสือ-เนตรนารีและกิจกรรมบำเพ็ญประโยชน์</b> (กิจกรรมภาคบังคับ)');
            } else if (currentActivityCategory === 'scout-guide') {
                $('#categoryDescText').html('<i class="bx bx-badge-check me-1 text-success"></i>กำลังแสดง: <b class="text-success">กองลูกเสือ - เนตรนารี (ระดับชั้น ม.1 - ม.3)</b>');
            } else if (currentActivityCategory === 'scout-redcross') {
                $('#categoryDescText').html('<i class="bx bx-plus-medical me-1 text-danger"></i>กำลังแสดง: <b class="text-danger">กิจกรรมยุวกาชาด</b>');
            } else if (currentActivityCategory === 'scout-volunteer') {
                $('#categoryDescText').html('<i class="bx bx-heart me-1 text-info"></i>กำลังแสดง: <b class="text-info">กิจกรรมผู้บำเพ็ญประโยชน์</b>');
            } else if (currentActivityCategory === 'scout-army') {
                $('#categoryDescText').html('<i class="bx bx-shield-quarter me-1 text-success"></i>กำลังแสดง: <b class="text-success">กิจกรรมนักศึกษาวิชาทหาร (นศท. / รด. ม.ปลาย)</b>');
            }
        } else {
            // Club tab styling
            $('#activityCategoryTabs button').each(function() {
                const cat = $(this).data('category');
                const badge = $(this).find('.badge');
                if ($(this).hasClass('active')) {
                    badge.removeClass('bg-label-primary bg-label-warning bg-label-secondary bg-label-success').addClass('bg-white text-dark shadow-sm');
                } else {
                    badge.removeClass('bg-white text-dark shadow-sm');
                    if (cat === 'club') badge.addClass('bg-label-success text-success');
                    else if (cat === 'scout') badge.addClass('bg-label-success text-success');
                    else badge.addClass('bg-label-secondary text-secondary');
                }
            });

            // Update description text and add button text
            if (currentActivityCategory === 'club') {
                $('#categoryDescText').html('<i class="bx bx-extension me-1 text-success"></i>กำลังแสดง: <b class="text-success">กิจกรรมชุมนุม</b> (ตามความถนัด/สนใจ)');
                $('#btnAddClubText').html('<i class="bx bx-plus-circle me-1"></i> เพิ่มชุมนุมใหม่');
                $('.BtnAddClub').removeClass('btn-warning').addClass('btn-skj-green');
            } else if (currentActivityCategory === 'scout') {
                $('#categoryDescText').html('<i class="bx bx-compass me-1 text-success"></i>กำลังแสดง: <b class="text-success">กิจกรรมลูกเสือ - เนตรนารี</b> (กิจกรรมภาคบังคับ)');
                $('#btnAddClubText').html('<i class="bx bx-plus-circle me-1"></i> เพิ่มกิจกรรมลูกเสือ/เนตรนารี');
                $('.BtnAddClub').removeClass('btn-warning').addClass('btn-skj-green');
            } else {
                $('#categoryDescText').html('<i class="bx bx-list-ul me-1 text-secondary"></i>กำลังแสดง: <b>กิจกรรมทั้งหมด</b> (ชุมนุม + ลูกเสือ-เนตรนารี)');
                $('#btnAddClubText').html('<i class="bx bx-plus-circle me-1"></i> เพิ่มกิจกรรมใหม่');
                $('.BtnAddClub').removeClass('btn-warning').addClass('btn-skj-green');
            }
        }

        table.draw();
    });

    // Add Club Logic
    $(document).on('click', '.BtnAddClub', function() {
        $('#ModalAddClubs').modal('show');
        $('#FormAddClubs')[0].reset();
        $('#club_id').val('');
        $('#club_level').val('');
        $('#club_faculty_advisor').val(null).trigger('change');

        // Preset category radio based on page or active tab
        if (isScoutPage || currentActivityCategory === 'scout' || currentActivityCategory.startsWith('scout-') || currentActivityCategory === 'all-scout') {
            $('#modal_type_scout').prop('checked', true).trigger('change');
            $('#clubModalLabel').html('<i class="bx bx-compass me-2 text-success"></i>เพิ่มกองลูกเสือ - เนตรนารีใหม่');
            $('#club_level').val('ม.ต้น');
            $('#clubModalHeader').removeClass('bg-label-warning').addClass('bg-label-success');
            $('#clubModalLabel').removeClass('text-warning').addClass('text-success');
            $('#btnSubmitClubForm').removeClass('btn-warning').addClass('btn-skj-green');
            $('#btnSubmitClubForm').html('<i class="bx bx-save me-1"></i> บันทึกข้อมูลกองลูกเสือ');
        } else {
            $('#modal_type_club').prop('checked', true).trigger('change');
            $('#clubModalLabel').html('<i class="bx bx-plus-circle me-2 text-success"></i>เพิ่มชุมนุมใหม่');
            $('#clubModalHeader').removeClass('bg-label-warning').addClass('bg-label-success');
            $('#clubModalLabel').removeClass('text-warning').addClass('text-success');
            $('#btnSubmitClubForm').removeClass('btn-warning').addClass('btn-skj-green');
            $('#btnSubmitClubForm').html('<i class="bx bx-save me-1"></i> บันทึกข้อมูลชุมนุม');
        }

        if ($('#club_faculty_advisor').data('select2')) {
            $('#club_faculty_advisor').select2('destroy');
        }

        $('#club_faculty_advisor').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#ModalAddClubs'),
            placeholder: isScoutPage ? 'ค้นหาและเลือกผู้กำกับลูกเสือ' : 'ค้นหาและเลือกครูที่ปรึกษา',
            ajax: {
                url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsTeacherList') ?>",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return { results: data.map(t => ({ id: t.pers_id, text: t.FullName })) };
                }
            }
        });
    });

    // Radio button changes in Modal
    $('input[name="modal_activity_type"]').on('change', function() {
        if ($('#modal_type_scout').is(':checked')) {
            $('#scoutQuickPresets').removeClass('d-none');
            $('#clubModalHeader').removeClass('bg-label-warning').addClass('bg-label-success');
            $('#clubModalLabel').removeClass('text-warning').addClass('text-success');
            $('#btnSubmitClubForm').removeClass('btn-warning').addClass('btn-skj-green');
            if (!$('#club_name').val()) {
                $('#club_level').val('ม.ต้น');
            }
        } else {
            $('#scoutQuickPresets').addClass('d-none');
            $('#clubModalHeader').removeClass('bg-label-warning').addClass('bg-label-success');
            $('#clubModalLabel').removeClass('text-warning').addClass('text-success');
            $('#btnSubmitClubForm').removeClass('btn-warning').addClass('btn-skj-green');
        }
    });

    // Scout quick preset buttons
    $(document).on('click', '.scout-preset-btn', function() {
        const name = $(this).data('name');
        const level = $(this).data('level');
        const desc = $(this).data('desc');

        $('#club_name').val(name);
        if (level) $('#club_level').val(level);
        if (desc && !$('#club_description').val()) $('#club_description').val(desc);
    });

    let return_to_students_modal_club_id = null;
    let is_submitting_quota_change = false;

    // Open Modal to Edit Club / Quota
    function openEditClubModal(clubId, returnToStudents = false, suggestedQuota = null) {
        return_to_students_modal_club_id = returnToStudents ? clubId : null;
        is_submitting_quota_change = false;

        $.ajax({
            url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsEdit/') ?>" + clubId,
            type: "GET",
            dataType: "json",
            success: function(data) {
                if (returnToStudents) {
                    $('#clubModalLabel').html('<i class="bx bx-edit-alt me-2 text-success"></i>ปรับปรุงโควตารับคนและข้อมูล');
                    if (suggestedQuota && suggestedQuota > data.club_max_participants) {
                        $('#club_max_participants').val(suggestedQuota);
                        $('#quotaSuggestionMessage').html(`แนะนำปรับเพิ่มเป็นอย่างน้อย <b>${suggestedQuota}</b> คน (ตามจำนวนนักเรียนที่เลือกไว้)`);
                        $('#quotaSuggestionAlert').removeClass('d-none');
                    } else {
                        $('#club_max_participants').val(data.club_max_participants);
                        $('#quotaSuggestionAlert').addClass('d-none');
                    }
                    // ซ่อน Modal จัดการนักเรียนชั่วคราว
                    $('#ModalAddStudents').modal('hide');
                } else {
                    $('#clubModalLabel').html('<i class="bx bx-edit-alt me-2 text-success"></i>แก้ไขข้อมูล');
                    $('#club_max_participants').val(data.club_max_participants);
                    $('#quotaSuggestionAlert').addClass('d-none');
                }

                $('#club_id').val(data.club_id);
                $('#club_year').val(data.club_year);
                $('#club_trem').val(data.club_trem);
                $('#club_name').val(data.club_name);
                $('#club_description').val(data.club_description);
                $('#club_level').val(data.club_level);

                // Preselect activity category radio
                const isClubScout = /ลูกเสือ|เนตรนารี|ยุวกาชาด|ผู้บำเพ็ญประโยชน์|นศท|รักษาดินแดน/.test(data.club_name || '');
                if (isClubScout) {
                    $('#modal_type_scout').prop('checked', true).trigger('change');
                } else {
                    $('#modal_type_club').prop('checked', true).trigger('change');
                }
                
                // Init Select2 with preselected data
                if ($('#club_faculty_advisor').data('select2')) {
                    $('#club_faculty_advisor').select2('destroy');
                }
                
                $('#club_faculty_advisor').empty();
                if (data.preselected_advisor_details && data.preselected_advisor_details.length > 0) {
                    data.preselected_advisor_details.forEach(advisor => {
                        const newOption = new Option(advisor.FullName, advisor.pers_id, true, true);
                        $('#club_faculty_advisor').append(newOption);
                    });
                }
                
                $('#club_faculty_advisor').select2({
                    theme: 'bootstrap-5',
                    dropdownParent: $('#ModalAddClubs'),
                    placeholder: 'ค้นหาและเลือกครูที่ปรึกษา',
                    ajax: {
                        url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsTeacherList') ?>",
                        dataType: 'json',
                        processResults: function(res) {
                            return { results: res.map(t => ({ id: t.pers_id, text: t.FullName })) };
                        }
                    }
                });
                
                setTimeout(() => {
                    $('#ModalAddClubs').modal('show');
                    if (returnToStudents) {
                        setTimeout(() => {
                            $('#club_max_participants').focus().select();
                        }, 400);
                    }
                }, returnToStudents ? 250 : 0);
            },
            error: function() {
                Swal.fire({ icon: 'error', title: 'ผิดพลาด', text: 'ไม่สามารถโหลดข้อมูลชุมนุมได้' });
            }
        });
    }

    // Hook when ModalAddClubs is hidden (if canceled or closed without saving, return to students modal)
    $('#ModalAddClubs').on('hidden.bs.modal', function() {
        $('#quotaSuggestionAlert').addClass('d-none');
        if (return_to_students_modal_club_id && !is_submitting_quota_change) {
            return_to_students_modal_club_id = null;
            setTimeout(() => {
                $('#ModalAddStudents').modal('show');
            }, 200);
        }
    });

    $(document).on('submit', '#FormAddClubs', function(e) {
        e.preventDefault();
        const selectedAdvisors = $('#club_faculty_advisor').val();
        if (!selectedAdvisors || selectedAdvisors.length === 0) {
            Swal.fire({ icon: 'error', title: 'ผิดพลาด', text: 'กรุณาเลือกที่ปรึกษาชุมนุมอย่างน้อย 1 ท่าน' });
            return;
        }

        const $btnSubmit = $('#btnSubmitClubForm');
        const origBtnHtml = $btnSubmit.html();
        $btnSubmit.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> กำลังบันทึก...');

        const url = $('#club_id').val() ? 
            "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsUpdate') ?>" : 
            "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsInsert') ?>";

        let formData = $(this).serializeArray();
        formData.push({ name: 'advisors', value: JSON.stringify(selectedAdvisors) });

        const willReturn = return_to_students_modal_club_id !== null;
        const targetClubId = return_to_students_modal_club_id;
        const newMaxParticipants = parseInt($('#club_max_participants').val()) || current_max;

        is_submitting_quota_change = true;

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.status === 'success') {
                    $('#ModalAddClubs').modal('hide');
                    table.ajax.reload(null, false);

                    if (willReturn) {
                        current_max = newMaxParticipants;
                        $('#maxCapacityDisplay').text(newMaxParticipants);
                        $(`.BtnAddStudents[data-id="${targetClubId}"]`).attr('max', newMaxParticipants);

                        setTimeout(() => {
                            $('#ModalAddStudents').modal('show');
                            loadRegisteredStudents(targetClubId);

                            Swal.fire({
                                icon: 'success',
                                title: 'ปรับโควตาเรียบร้อยแล้ว!',
                                html: `โควตารับใหม่คือ <b>${newMaxParticipants}</b> คน<br><span class="text-success small">คุณสามารถกดบันทึกเพิ่มนักเรียนต่อได้ทันทีครับ</span>`,
                                timer: 2500,
                                showConfirmButton: true,
                                confirmButtonColor: '#15a362',
                                confirmButtonText: 'รับทราบ'
                            });

                            return_to_students_modal_club_id = null;
                            is_submitting_quota_change = false;
                        }, 300);
                    } else {
                        Swal.fire({ icon: 'success', title: 'สำเร็จ', text: 'บันทึกข้อมูลเรียบร้อยแล้ว', timer: 1500, showConfirmButton: false });
                        return_to_students_modal_club_id = null;
                        is_submitting_quota_change = false;
                    }
                } else {
                    is_submitting_quota_change = false;
                    Swal.fire({ icon: 'error', title: 'แจ้งเตือน', text: response.message || 'บันทึกไม่สำเร็จ' });
                }
            },
            error: function() {
                is_submitting_quota_change = false;
                Swal.fire({ icon: 'error', title: 'ผิดพลาด', text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้' });
            },
            complete: function() {
                $btnSubmit.prop('disabled', false).html(origBtnHtml);
            }
        });
    });

    // Edit Club Logic
    $(document).on('click', '.edit-btn', function() {
        const clubId = $(this).data('id');
        openEditClubModal(clubId, false, null);
    });

    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'ต้องการลบข้อมูล?',
            text: "ข้อมูลนักเรียนและเวลาเรียนทั้งหมดในชุมนี้จะถูกลบออกด้วย!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff3e1d',
            confirmButtonText: 'ยืนยันการลบ',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsDelete/') ?>" + id,
                    type: "POST",
                    success: function() {
                        table.ajax.reload();
                        Swal.fire('ลบข้อมูลเรียบร้อย!', '', 'success');
                    }
                });
            }
        });
    });

    // Student Management Logic
    let current_club_id = 0;
    let current_max = 0;
    let current_count = 0;
    let registered_students_cache = [];
    let classroom_students_cache = [];

    // Load Classrooms into dropdowns
    function loadClassroomsList(selectedRoom = '') {
        $.ajax({
            url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubGetClassroom') ?>",
            type: "GET",
            dataType: "json",
            success: function(res) {
                let options = '<option value="">-- กรุณาเลือกห้องเรียน --</option>';
                if (res.classrooms && res.classrooms.length > 0) {
                    $('#badgeTotalFoundRoom').text(res.classrooms.length + ' ห้อง');
                    res.classrooms.forEach(c => {
                        const isSel = (c.StudentClass === selectedRoom) ? 'selected' : '';
                        options += `<option value="${c.StudentClass}" ${isSel}>${c.StudentClass}</option>`;
                    });
                } else {
                    $('#badgeTotalFoundRoom').text('0 ห้อง');
                }
                $('#classroomSelect').html(options);
            }
        });
    }

    $(document).on('click', '.BtnAddStudents', function() {
        current_club_id = $(this).data('id');
        const clubname = $(this).attr('clubname');
        current_max = parseInt($(this).attr('max')) || 0;
        
        const isClubScout = /ลูกเสือ|เนตรนารี|ยุวกาชาด|ผู้บำเพ็ญประโยชน์|นศท|รักษาดินแดน|รด\./i.test(clubname || '');
        const typeBadge = isClubScout 
            ? '<span class="badge bg-label-success ms-2"><i class="bx bx-compass me-1"></i>ลูกเสือ - เนตรนารี</span>'
            : '<span class="badge bg-label-primary ms-2"><i class="bx bx-extension me-1"></i>ชุมนุม</span>';
        
        if (isScoutPage || isClubScout) {
            $('#AddStudentsTitle').html(`ทะเบียนกำลังพล: <span class="text-skj-green">${clubname}</span> ${typeBadge}`);
            $('#btnAddClassToClub').html('<i class="bx bx-user-plus me-1"></i> เพิ่มเข้ากองลูกเสือ (<span id="btnSelectedCount">0</span> คน)');
        } else {
            $('#AddStudentsTitle').html(`จัดการนักเรียน: <span class="text-skj-green">${clubname}</span> ${typeBadge}`);
            $('#btnAddClassToClub').html('<i class="bx bx-user-plus me-1"></i> เพิ่มนักเรียนเข้าชุมนุม (<span id="btnSelectedCount">0</span> คน)');
        }
        $('.club_id').val(current_club_id);
        $('#maxCapacityDisplay').text(current_max);
        
        // Reset controls
        $('#checkAllClassStudents').prop('checked', true);
        $('#gender_all').prop('checked', true);
        $('#boxAllowTransfer').hide();
        $('#allowTransferSwitch').prop('checked', true);
        $('#btnAddClassToClub').prop('disabled', true);
        $('#btnSelectedCount').text('0');
        $('#classStudentSummary').text('เลือก 0 คน');
        $('#classStudentPreviewList').html(`
            <div class="text-center py-4 text-muted small">
                <i class="bx bx-info-circle fs-3 d-block mb-1 text-muted"></i>
                กรุณาเลือกห้องเรียนเพื่อดูรายชื่อนักเรียน
            </div>
        `);
        $('#searchRegisStudent').val('');
        $('#checkAllRegistered').prop('checked', false);
        $('#btnBatchDelete').hide();
        $('#selectedDeleteCount').text('0');

        // Switch to Classroom Tab by default
        $('#tab-class-batch-btn').tab('show');

        // Load data
        loadClassroomsList();
        loadRegisteredStudents(current_club_id);
        $('#ModalAddStudents').modal('show');

        // Init Select2 for Individual tab
        if ($('#studentSelect').data('select2')) {
            $('#studentSelect').select2('destroy');
        }

        $('#studentSelect').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#ModalAddStudents'),
            placeholder: 'ค้นหาด้วยชื่อ-สกุล หรือชั้นเรียน...',
            ajax: {
                url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsStudentList') ?>",
                dataType: 'json',
                processResults: function(data) {
                    return { results: data.map(s => ({ id: s.StudentID, text: s.FullName })) };
                }
            }
        });
    });

    // When Classroom or Gender changes -> Fetch students of that class
    $('#classroomSelect, input[name="class_gender"]').on('change', function() {
        const selectedRoom = $('#classroomSelect').val();
        const selectedGender = $('input[name="class_gender"]:checked').val() || 'all';

        if (!selectedRoom) {
            $('#classStudentPreviewList').html(`
                <div class="text-center py-4 text-muted small">
                    <i class="bx bx-info-circle fs-3 d-block mb-1 text-muted"></i>
                    กรุณาเลือกห้องเรียนเพื่อดูรายชื่อนักเรียน
                </div>
            `);
            $('#btnAddClassToClub').prop('disabled', true);
            $('#btnSelectedCount').text('0');
            $('#classStudentSummary').text('เลือก 0 คน');
            $('#boxAllowTransfer').hide();
            return;
        }

        $('#classStudentPreviewList').html(`
            <div class="text-center py-4 text-muted small">
                <div class="spinner-border spinner-border-sm text-success mb-2" role="status"></div>
                <div>กำลังโหลดรายชื่อนักเรียนห้อง ${selectedRoom}...</div>
            </div>
        `);

        $.ajax({
            url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubGetStudentsByClass') ?>",
            type: "POST",
            data: {
                club_id: current_club_id,
                classrooms: [selectedRoom],
                gender: selectedGender
            },
            dataType: "json",
            success: function(res) {
                if (res.status === 'success') {
                    classroom_students_cache = res.students || [];
                    renderClassStudentPreview(res.students, res.summary);
                } else {
                    $('#classStudentPreviewList').html(`
                        <div class="text-center py-4 text-danger small">
                            <i class="bx bx-error-circle fs-3 d-block mb-1"></i>
                            เกิดข้อผิดพลาดในการโหลดข้อมูล
                        </div>
                    `);
                }
            },
            error: function() {
                $('#classStudentPreviewList').html(`
                    <div class="text-center py-4 text-danger small">
                        <i class="bx bx-error-circle fs-3 d-block mb-1"></i>
                        ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้
                    </div>
                `);
            }
        });
    });

    // Render Preview Rows
    function renderClassStudentPreview(students, summary) {
        if (!students || students.length === 0) {
            $('#classStudentPreviewList').html(`
                <div class="text-center py-4 text-muted small">
                    <i class="bx bx-user-x fs-3 d-block mb-1 text-muted"></i>
                    ไม่พบนักเรียนตามเงื่อนไขที่เลือก
                </div>
            `);
            $('#btnAddClassToClub').prop('disabled', true);
            $('#btnSelectedCount').text('0');
            $('#classStudentSummary').text('เลือก 0 คน');
            $('#boxAllowTransfer').hide();
            return;
        }

        let hasOtherClub = false;
        let rows = '<div class="list-group list-group-flush">';

        students.forEach(s => {
            let badgeHtml = '';
            let disabledAttr = '';
            let checkedAttr = '';

            if (s.status_code === 'already_here') {
                badgeHtml = '<span class="badge bg-label-info ms-auto small">อยู่ในชุมนุมนี้แล้ว</span>';
                disabledAttr = 'disabled';
                checkedAttr = '';
            } else if (s.status_code === 'in_other_club') {
                badgeHtml = `<span class="badge bg-label-warning ms-auto small text-truncate" style="max-width: 140px;" title="${s.other_club_name}">อยู่: ${s.other_club_name}</span>`;
                checkedAttr = ''; // Unchecked by default for transfer
                hasOtherClub = true;
            } else if (s.has_dual_club) {
                badgeHtml = `<span class="badge bg-label-success ms-auto small text-truncate" style="max-width: 170px;" title="${s.status_text}"><i class="bx bx-check me-1"></i>${s.status_text}</span>`;
                checkedAttr = 'checked';
            } else {
                badgeHtml = '<span class="badge bg-label-success ms-auto small">พร้อมเพิ่ม</span>';
                checkedAttr = 'checked';
            }

            const sexIcon = (s.computed_sex === 'ชาย') ? 
                '<span class="badge bg-label-primary px-1 me-1">ช</span>' : 
                '<span class="badge bg-label-danger px-1 me-1">ญ</span>';

            rows += `
                <label class="list-group-item list-group-item-action d-flex align-items-center py-2 px-3 border-0 border-bottom student-preview-row ${disabledAttr ? 'opacity-75 bg-light' : 'cursor-pointer'}">
                    <input class="form-check-input me-2 class-student-checkbox" type="checkbox" value="${s.StudentID}" data-status="${s.status_code}" ${checkedAttr} ${disabledAttr}>
                    <span class="text-muted small me-2" style="min-width: 24px;">#${s.StudentNumber || '-'}</span>
                    <span class="me-1">${sexIcon}</span>
                    <span class="fw-semibold small text-dark me-2 text-truncate" style="max-width: 170px;">${s.FullName}</span>
                    ${badgeHtml}
                </label>
            `;
        });
        rows += '</div>';

        $('#classStudentPreviewList').html(rows);

        if (hasOtherClub) {
            $('#boxAllowTransfer').slideDown();
        } else {
            $('#boxAllowTransfer').slideUp();
        }

        updateClassSelectionCount();
    }

    // Check All / Uncheck All in preview
    $('#checkAllClassStudents').on('change', function() {
        const isChecked = $(this).is(':checked');
        $('.class-student-checkbox:not(:disabled)').prop('checked', isChecked);
        updateClassSelectionCount();
    });

    // Single student preview check change
    $(document).on('change', '.class-student-checkbox', function() {
        updateClassSelectionCount();
        const totalEligible = $('.class-student-checkbox:not(:disabled)').length;
        const totalChecked = $('.class-student-checkbox:not(:disabled):checked').length;
        $('#checkAllClassStudents').prop('checked', totalEligible > 0 && totalEligible === totalChecked);
    });

    function updateClassSelectionCount() {
        const checkedBoxes = $('.class-student-checkbox:not(:disabled):checked');
        const count = checkedBoxes.length;
        const total = $('.class-student-checkbox').length;

        $('#btnSelectedCount').text(count);
        $('#classStudentSummary').text(`เลือก ${count} จาก ${total} คน`);

        if (count > 0) {
            $('#btnAddClassToClub').prop('disabled', false);
        } else {
            $('#btnAddClassToClub').prop('disabled', true);
        }
    }

    // Helper to execute adding students via AJAX
    function executeAddStudentsToClub(studentIds, allowTransfer, callbackSuccess) {
        const $btnAddClass = $('#btnAddClassToClub');
        const origAddClassHtml = $btnAddClass.html();
        const $btnAddStudent = $('#btnAddStudentToClub');
        const origAddStudentHtml = $btnAddStudent.html();

        $btnAddClass.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> กำลังบันทึก...');
        $btnAddStudent.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> กำลังบันทึก...');

        Swal.fire({
            title: 'กำลังบันทึกข้อมูล...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        $.ajax({
            url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsAddStudentToClub') ?>",
            type: "POST",
            data: {
                club_id: current_club_id,
                student_ids: studentIds,
                allow_transfer: allowTransfer
            },
            dataType: "json",
            success: function(res) {
                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ!',
                        text: res.message || `เพิ่มนักเรียนแล้ว ${res.added_count || studentIds.length} คน`,
                        timer: 1800,
                        showConfirmButton: false
                    });
                    loadRegisteredStudents(current_club_id);
                    table.ajax.reload(null, false);
                    if (typeof callbackSuccess === 'function') {
                        callbackSuccess(res);
                    }
                } else if (res.status === 'info') {
                    Swal.fire({ icon: 'info', title: 'แจ้งเตือน', text: res.message });
                } else {
                    Swal.fire({ icon: 'error', title: 'ผิดพลาด', text: res.message || 'เกิดข้อผิดพลาดในการบันทึก' });
                }
            },
            error: function() {
                Swal.fire({ icon: 'error', title: 'ผิดพลาด', text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้' });
            },
            complete: function() {
                $btnAddClass.prop('disabled', false).html(origAddClassHtml);
                $btnAddStudent.prop('disabled', false).html(origAddStudentHtml);
            }
        });
    }

    // Submit Add by Classroom Batch
    $('#btnAddClassToClub').on('click', function() {
        const selectedIds = [];
        let transferCount = 0;

        $('.class-student-checkbox:not(:disabled):checked').each(function() {
            selectedIds.push($(this).val());
            if ($(this).data('status') === 'in_other_club') {
                transferCount++;
            }
        });

        if (selectedIds.length === 0) {
            Swal.fire({ icon: 'warning', title: 'แจ้งเตือน', text: 'กรุณาเลือกนักเรียนอย่างน้อย 1 คน' });
            return;
        }

        const totalAfterAdd = current_count + selectedIds.length;
        const willExceed = (current_max > 0) && (totalAfterAdd > current_max);
        const excess = totalAfterAdd - current_max;
        const allowTransfer = $('#allowTransferSwitch').is(':checked') ? 1 : 0;

        if (willExceed) {
            Swal.fire({
                title: 'จำนวนเกินโควตารับ!',
                html: `
                    <div class="text-start p-3 bg-label-warning rounded mb-3 small">
                        <div class="mb-1">• สมาชิกปัจจุบัน: <b>${current_count}</b> คน</div>
                        <div class="mb-1">• กำลังจะเพิ่มอีก: <b>${selectedIds.length}</b> คน (รวมเป็น <b>${totalAfterAdd}</b> คน)</div>
                        <div class="mb-1">• โควตารับปัจจุบัน: <b>${current_max}</b> คน</div>
                        <div class="text-danger fw-bold mt-2">⚠️ จะเกินโควตาไป ${excess} คน</div>
                    </div>
                    <div class="fw-bold text-dark mb-1 fs-6">ต้องการปรับเพิ่มโควตารับคนเพิ่มหรือไม่?</div>
                    <div class="text-muted small">หากเลือก "ใช่" ระบบจะพาไปแก้ไขโควตา และเมื่อเสร็จจะกลับมาหน้านี้ทันที</div>
                `,
                icon: 'warning',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonColor: '#15a362',
                denyButtonColor: '#ffab00',
                cancelButtonColor: '#8592a3',
                confirmButtonText: '<i class="bx bx-edit me-1"></i> ใช่, ไปแก้ไขโควตา',
                denyButtonText: 'เพิ่มเลย (ไม่เพิ่มโควตา)',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    openEditClubModal(current_club_id, true, totalAfterAdd);
                } else if (result.isDenied) {
                    executeAddStudentsToClub(selectedIds, allowTransfer, function() {
                        $('#classroomSelect').trigger('change');
                    });
                }
            });
            return;
        }

        let confirmText = `ต้องการเพิ่มนักเรียนจำนวน ${selectedIds.length} คน เข้าสู่ชุมนุมนี้หรือไม่?`;
        if (transferCount > 0) {
            confirmText += `\n(มีนักเรียน ${transferCount} คนที่ลงชุมนุมอื่นแล้ว จะถูกย้ายมาชุมนุมนี้)`;
        }

        Swal.fire({
            title: 'ยืนยันการเพิ่มนักเรียน?',
            text: confirmText,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#15a362',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'ยืนยันเพิ่มนักเรียน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                executeAddStudentsToClub(selectedIds, allowTransfer, function() {
                    $('#classroomSelect').trigger('change');
                });
            }
        });
    });

    // Load Registered Students in this Club
    function loadRegisteredStudents(clubId) {
        $('#registeredSubText').text('กำลังโหลดข้อมูล...');
        $.ajax({
            url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsTbShowStudentList') ?>",
            type: "GET",
            data: { club_id: clubId },
            dataType: 'json',
            success: function(data) {
                registered_students_cache = data || [];
                renderRegisteredStudentsTable(data);
            },
            error: function() {
                $('#registeredSubText').text('โหลดข้อมูลไม่สำเร็จ');
                $('#addedStudentsList').html('<tr><td colspan="8" class="text-center py-4 text-danger small">ไม่สามารถโหลดข้อมูลนักเรียนได้</td></tr>');
            }
        });
    }

    // Render Registered Table
    function renderRegisteredStudentsTable(data) {
        let rows = '';
        let maleCount = 0;
        let femaleCount = 0;

        data.forEach((s, i) => {
            const isMale = (s.StudentSex === 'ชาย' || ['เด็กชาย', 'นาย'].includes(s.StudentPrefix));
            if (isMale) maleCount++; else femaleCount++;

            const sexBadge = isMale ? 
                '<span class="badge bg-label-primary px-2 py-1 small">ชาย</span>' : 
                '<span class="badge bg-label-danger px-2 py-1 small">หญิง</span>';

            rows += `<tr class="regis-student-row" data-search="${(s.StudentClass + ' ' + s.StudentNumber + ' ' + s.StudentCode + ' ' + s.Fullname).toLowerCase()}">
                <td class="text-center">
                    <input class="form-check-input check-registered-item" type="checkbox" value="${s.StudentID}">
                </td>
                <td class="text-center fw-semibold text-muted small">${i + 1}</td>
                <td class="text-center small fw-bold text-dark text-nowrap">${s.StudentClass || '-'}</td>
                <td class="text-center small text-nowrap">${s.StudentNumber || '-'}</td>
                <td class="small fw-semibold text-primary text-nowrap">${s.StudentCode || '-'}</td>
                <td class="fw-bold text-dark text-nowrap">${s.Fullname}</td>
                <td class="text-center text-nowrap">${sexBadge}</td>
                <td class="text-center text-nowrap">
                    <button class="btn btn-icon btn-label-danger btn-sm remove-btn" data-id="${s.StudentID}" title="ลบออกจากชุมนุม">
                        <i class="bx bx-trash"></i>
                    </button>
                </td>
            </tr>`;
        });

        $('#addedStudentsList').html(rows || '<tr><td colspan="8" class="text-center py-4 text-muted small"><i class="bx bx-info-circle fs-4 d-block mb-1"></i>ยังไม่มีนักเรียนลงทะเบียนในชุมนุมนี้</td></tr>');

        const count = data.length;
        current_count = count;

        $('#registeredCount').text(`${count} คน`);
        $('#registeredSubText').html(`ทั้งหมด <b>${count}</b> คน (ชาย ${maleCount}, หญิง ${femaleCount})`);
        $('#registeredCountDisplay').html(`${count} <small class="text-muted fs-6 fw-normal">คน</small>`);
        
        const remaining = current_max - count;
        $('#remainingCapacity').text(remaining);

        // Progress bar and warnings
        let percent = current_max > 0 ? Math.round((count / current_max) * 100) : 0;
        let barColor = 'bg-success';
        if (percent >= 100) {
            barColor = 'bg-danger';
            $('#capacityWarningText').show().text(percent > 100 ? `(เกินโควตา ${count - current_max} คน)` : '(เต็มโควตา)');
        } else if (percent >= 80) {
            barColor = 'bg-warning';
            $('#capacityWarningText').hide();
        } else {
            barColor = 'bg-success';
            $('#capacityWarningText').hide();
        }

        $('#capacityProgressBar')
            .removeClass('bg-success bg-warning bg-danger')
            .addClass(barColor)
            .css('width', Math.min(percent, 100) + '%');
        $('#capacityPercentBadge').text(percent + '%');

        // Reset batch delete
        $('#checkAllRegistered').prop('checked', false);
        $('#btnBatchDelete').hide();
        $('#selectedDeleteCount').text('0');

        // Apply quick search if filter had text
        if ($('#searchRegisStudent').val().trim() !== '') {
            $('#searchRegisStudent').trigger('keyup');
        }
    }

    // Quick search in registered students table
    $('#searchRegisStudent').on('keyup', function() {
        const query = $(this).val().toLowerCase().trim();
        if (!query) {
            $('.regis-student-row').show();
            return;
        }
        $('.regis-student-row').each(function() {
            const searchData = $(this).data('search') || '';
            if (searchData.indexOf(query) !== -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Check All Registered Items
    $('#checkAllRegistered').on('change', function() {
        const isChecked = $(this).is(':checked');
        $('.check-registered-item:visible').prop('checked', isChecked);
        updateBatchDeleteButton();
    });

    $(document).on('change', '.check-registered-item', function() {
        updateBatchDeleteButton();
        const visibleTotal = $('.check-registered-item:visible').length;
        const checkedTotal = $('.check-registered-item:visible:checked').length;
        $('#checkAllRegistered').prop('checked', visibleTotal > 0 && visibleTotal === checkedTotal);
    });

    function updateBatchDeleteButton() {
        const selectedCount = $('.check-registered-item:checked').length;
        $('#selectedDeleteCount').text(selectedCount);
        if (selectedCount > 0) {
            $('#btnBatchDelete').fadeIn(150);
        } else {
            $('#btnBatchDelete').fadeOut(150);
        }
    }

    // Batch Delete Students
    $('#btnBatchDelete').on('click', function() {
        const selectedIds = [];
        $('.check-registered-item:checked').each(function() {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length === 0) return;

        Swal.fire({
            title: `ยืนยันการลบนักเรียน ${selectedIds.length} คน?`,
            text: 'รายชื่อที่เลือกจะถูกลบออกจากชุมนุมนี้ทันที',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff3e1d',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'ยืนยันลบข้อมูล',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubBatchDeleteStudents') ?>",
                    type: "POST",
                    data: {
                        club_id: current_club_id,
                        student_ids: selectedIds
                    },
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire({ icon: 'success', title: 'ลบเรียบร้อย!', text: res.message, timer: 1500, showConfirmButton: false });
                            loadRegisteredStudents(current_club_id);
                            table.ajax.reload(null, false);
                            if ($('#classroomSelect').val()) {
                                $('#classroomSelect').trigger('change');
                            }
                        } else {
                            Swal.fire({ icon: 'error', title: 'ผิดพลาด', text: res.message });
                        }
                    },
                    error: function() {
                        Swal.fire({ icon: 'error', title: 'ผิดพลาด', text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้' });
                    }
                });
            }
        });
    });

    // Quick Edit Quota from Student Modal
    $(document).on('click', '#btnQuickEditQuota', function(e) {
        e.preventDefault();
        if (current_club_id) {
            openEditClubModal(current_club_id, true, null);
        }
    });

    // Individual Add Student (Tab 2)
    $(document).on('click', '#btnAddStudentToClub', function() {
        const student_ids = $('#studentSelect').val();
        if (!student_ids || student_ids.length === 0) {
            return Swal.fire({ icon: 'warning', title: 'แจ้งเตือน', text: 'กรุณาเลือกนักเรียนอย่างน้อย 1 คน' });
        }

        const totalAfterAdd = current_count + student_ids.length;
        const willExceed = (current_max > 0) && (totalAfterAdd > current_max);
        const excess = totalAfterAdd - current_max;

        if (willExceed) {
            Swal.fire({
                title: 'จำนวนเกินโควตารับ!',
                html: `
                    <div class="text-start p-3 bg-label-warning rounded mb-3 small">
                        <div class="mb-1">• สมาชิกปัจจุบัน: <b>${current_count}</b> คน</div>
                        <div class="mb-1">• กำลังจะเพิ่มอีก: <b>${student_ids.length}</b> คน (รวมเป็น <b>${totalAfterAdd}</b> คน)</div>
                        <div class="mb-1">• โควตารับปัจจุบัน: <b>${current_max}</b> คน</div>
                        <div class="text-danger fw-bold mt-2">⚠️ จะเกินโควตาไป ${excess} คน</div>
                    </div>
                    <div class="fw-bold text-dark mb-1 fs-6">ต้องการปรับเพิ่มโควตารับคนเพิ่มหรือไม่?</div>
                    <div class="text-muted small">หากเลือก "ใช่" ระบบจะพาไปแก้ไขโควตา และเมื่อเสร็จจะกลับมาหน้านี้ทันที</div>
                `,
                icon: 'warning',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonColor: '#15a362',
                denyButtonColor: '#ffab00',
                cancelButtonColor: '#8592a3',
                confirmButtonText: '<i class="bx bx-edit me-1"></i> ใช่, ไปแก้ไขโควตา',
                denyButtonText: 'เพิ่มเลย (ไม่เพิ่มโควตา)',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    openEditClubModal(current_club_id, true, totalAfterAdd);
                } else if (result.isDenied) {
                    executeAddStudentsToClub(student_ids, 1, function() {
                        $('#studentSelect').val(null).trigger('change');
                        if ($('#classroomSelect').val()) {
                            $('#classroomSelect').trigger('change');
                        }
                    });
                }
            });
            return;
        }

        executeAddStudentsToClub(student_ids, 1, function() {
            $('#studentSelect').val(null).trigger('change');
            if ($('#classroomSelect').val()) {
                $('#classroomSelect').trigger('change');
            }
        });
    });

    // Delete single student
    $(document).on('click', '.remove-btn', function() {
        const student_id = $(this).data('id');
        Swal.fire({
            title: 'ยกเลิกการลงทะเบียน?',
            text: 'แน่ใจหรือไม่ว่าต้องการลบรายชื่อนักเรียนออกจากชุมนุมนี้',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ff3e1d',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'ลบออก',
            cancelButtonText: 'ปิด'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubDeleteStudentToClub') ?>",
                    type: "POST",
                    data: { club_id: current_club_id, student_id: student_id },
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 'success') {
                            loadRegisteredStudents(current_club_id);
                            table.ajax.reload(null, false);
                            Swal.fire({ icon: 'success', title: 'ลบเรียบร้อย!', timer: 1000, showConfirmButton: false });
                            if ($('#classroomSelect').val()) {
                                $('#classroomSelect').trigger('change');
                            }
                        } else {
                            Swal.fire({ icon: 'error', title: 'ผิดพลาด', text: res.message || 'ไม่สามารถลบข้อมูลได้' });
                        }
                    },
                    error: function() {
                        Swal.fire({ icon: 'error', title: 'ผิดพลาด', text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้' });
                    }
                });
            }
        });
    });

    // =========================================================================
    // ระบบกำหนดเวลาเรียน (ตารางเวลาเช็คชื่อ) ปฏิทินไทย พ.ศ.
    // =========================================================================

    // Helper ฟังก์ชันแปลงปีใน Flatpickr ให้เป็น พ.ศ.
    function updateCalendarToBE(instance) {
        setTimeout(() => {
            const yearDisplay = instance.calendarContainer.querySelector(".flatpickr-current-month .cur-year");
            if (yearDisplay) {
                const year = parseInt(instance.currentYear);
                if (year < 2400) {
                    if (yearDisplay.tagName === "INPUT") yearDisplay.value = year + 543;
                    else yearDisplay.textContent = year + 543;
                }
            }
            const yearInput = instance.calendarContainer.querySelector(".numInput.cur-year");
            if (yearInput && parseInt(instance.currentYear) < 2400) {
                yearInput.value = parseInt(instance.currentYear) + 543;
            }
        }, 5);
    }

    // เมื่อกดปุ่ม "กำหนดเวลาเรียน"
    $(document).on('click', '#MenuSetDateAttendancer', function () { 
        $.ajax({
            url: '<?= site_url('admin/academic/ConAdminDevelopStudents/ClubCreateWeeks') ?>',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    loadWeeksData();
                    $('#ClubSetDateAttendance').modal('show');
                } else {
                    Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: response.message || 'ไม่สามารถเริ่มต้นตั้งค่าตารางเช็คชื่อได้' });
                }
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์' });
            }
        });
    });

    // โหลดข้อมูลตารางเวลาเรียน (พ.ศ. แสดงผลแบบ 2 คอลัมน์กระชับ)
    function loadWeeksData() {
        $.ajax({
            url: '<?= site_url('admin/academic/ConAdminDevelopStudents/ClubGetWeeksToUpdate') ?>',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                let rows1 = '';
                let rows2 = '';
                let totalWeeks = 0;
                let openWeeks = 0;

                if (response.status === 'success' && response.data && response.data.length > 0) {
                    totalWeeks = response.data.length;
                    const half = Math.ceil(totalWeeks / 2);

                    response.data.forEach(function (week, index) {
                        let checked = (week.tcs_week_status == "เปิด") ? "checked" : "";
                        if (week.tcs_week_status == "เปิด") openWeeks++;

                        let rowHtml = `<tr id="week-row-${week.tcs_schedule_id}" class="${checked ? '' : 'table-light opacity-75'}">
                            <td class="text-center fw-bold py-1">
                                <span class="badge ${checked ? 'bg-label-success' : 'bg-label-secondary'} px-2 py-0.5" style="font-size: 0.775rem;">สัปดาห์ ${index + 1}</span>
                            </td>
                            <td class="py-1">
                                <div class="input-group input-group-merge input-group-sm">
                                    <span class="input-group-text py-0 px-2"><i class="bx bx-calendar text-success" style="font-size: 0.9rem;"></i></span>
                                    <input type="text" class="form-control form-control-sm tcs_academic_year py-1" id="tcs_academic_year${index + 1}" data-id="${week.tcs_schedule_id}" value="${week.tcs_start_date || ''}" placeholder="วว/ดด/ปปปป">
                                </div>
                            </td>
                            <td class="text-center py-1">
                                <div class="form-check form-switch d-flex justify-content-center mb-0">
                                    <input class="form-check-input status-btn" type="checkbox" data-status="${week.tcs_week_status}" data-id="${week.tcs_schedule_id}" ${checked}>
                                </div>
                            </td>
                        </tr>`;

                        if (index < half) {
                            rows1 += rowHtml;
                        } else {
                            rows2 += rowHtml;
                        }
                    });

                    $('#part1Label').html(`<i class="bx bx-list-ol me-1 text-primary"></i>สัปดาห์ที่ 1 - ${half}`);
                    $('#part2Label').html(`<i class="bx bx-list-ol me-1 text-primary"></i>สัปดาห์ที่ ${half + 1} - ${totalWeeks}`);
                } else {
                    rows1 = '<tr><td colspan="3" class="text-center py-3 text-muted small">ไม่มีข้อมูลสัปดาห์</td></tr>';
                    rows2 = '<tr><td colspan="3" class="text-center py-3 text-muted small">-</td></tr>';
                }

                $('#TbDateWeeksCol1 tbody').html(rows1);
                $('#TbDateWeeksCol2 tbody').html(rows2);
                $('#TbDateWeeks tbody').html(rows1 + rows2);

                // Update Counters
                $('#countWeeksTotal').text(totalWeeks);
                $('#countWeeksOpen').text(openWeeks);
                $('#countWeeksClosed').text(totalWeeks - openWeeks);

                // ผูก Flatpickr ปฏิทินไทย พ.ศ. ให้กับทุกช่อง
                initWeeksFlatpickr();
            }
        });
    }

    // ฟังก์ชันผูก Flatpickr ปฏิทินไทย พ.ศ.
    function initWeeksFlatpickr() {
        $(".tcs_academic_year").flatpickr({
            disableMobile: true,
            dateFormat: "Y-m-d", // ส่งค่า ค.ศ. ISO ให้ Backend บันทึก
            altInput: true,      // แสดงผลแบบ พ.ศ. ให้ผู้ใช้เห็น
            altFormat: "d/m/Y",  // รูปแบบ วัน/เดือน/ปี พ.ศ.
            locale: "th",
            allowInput: true,
            onOpen: (s, d, i) => updateCalendarToBE(i),
            onMonthChange: (s, d, i) => updateCalendarToBE(i),
            onYearChange: (s, d, i) => updateCalendarToBE(i),
            formatDate: (date, format) => {
                if (format === "d/m/Y") {
                    const y = date.getFullYear() + 543;
                    return `${date.getDate().toString().padStart(2, '0')}/${(date.getMonth() + 1).toString().padStart(2, '0')}/${y}`;
                }
                return flatpickr.formatDate(date, format);
            },
            parseDate: (dateStr) => {
                if (dateStr && dateStr.includes('/')) {
                    const p = dateStr.split('/');
                    return new Date(parseInt(p[2]) - 543, parseInt(p[1]) - 1, parseInt(p[0]));
                }
                return flatpickr.parseDate(dateStr, "Y-m-d");
            },
            onChange: function(selectedDates, dateStr, instance) {
                const id = $(instance.element).data('id');
                if (!dateStr || !id) return;

                $.ajax({
                    url: '<?= site_url('admin/academic/developstudents/update_schedule') ?>',
                    type: 'POST',
                    data: {
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                        id: id,
                        date: dateStr
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 1500, timerProgressBar: true });
                            Toast.fire({ icon: 'success', title: 'บันทึกวันที่แล้ว' });
                        } else {
                            Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: response.message || 'ไม่สามารถบันทึกได้' });
                        }
                    },
                    error: function() {
                        Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์' });
                    }
                });
            }
        });
    }

    // บันทึกสถานะเปิด/ปิดสัปดาห์
    $(document).on('change', '.status-btn', function() {
        const checkbox = $(this);
        const id = checkbox.data('id');
        const currentStatus = checkbox.data('status');
        const newStatus = (currentStatus === 'เปิด') ? 'ปิด' : 'เปิด';

        $.ajax({
            url: '<?= site_url('admin/academic/ConAdminDevelopStudents/ClubUpdateStatus') ?>',
            type: 'POST',
            data: {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                id: id,
                status: newStatus
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    checkbox.data('status', newStatus);
                    const row = checkbox.closest('tr');
                    if (newStatus === 'เปิด') {
                        row.removeClass('table-light opacity-75');
                        row.find('.badge').removeClass('bg-label-secondary').addClass('bg-label-success');
                    } else {
                        row.addClass('table-light opacity-75');
                        row.find('.badge').removeClass('bg-label-success').addClass('bg-label-secondary');
                    }
                    const total = $('.status-btn').length;
                    const open = $('.status-btn:checked').length;
                    $('#countWeeksOpen').text(open);
                    $('#countWeeksClosed').text(total - open);

                    const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 1500, timerProgressBar: true });
                    Toast.fire({ icon: 'success', title: 'อัปเดตสถานะสำเร็จ' });
                } else {
                    checkbox.prop('checked', !checkbox.prop('checked'));
                    Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: response.message || 'ไม่สามารถบันทึกได้' });
                }
            },
            error: function() {
                checkbox.prop('checked', !checkbox.prop('checked'));
                Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์' });
            }
        });
    });

    $(document).on('submit', '#FormClubSetDateAttendance', function (e) {
        e.preventDefault();
        $('#ClubSetDateAttendance').modal('hide');
    });
});
</script>
<?= $this->endSection() ?>
