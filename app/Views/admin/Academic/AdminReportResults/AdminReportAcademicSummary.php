<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
    :root {
        --primary-green: #15a362;
        --dark-green: #0d6d41;
        --light-green: #e8f5e9;
        --header-green: #ABDD93;
        --border-green: #15a362;
    }

    /* Compact Hero Section - High Contrast */
    .hero-header {
        background: linear-gradient(135deg, #15a362 0%, #0d6d41 100%) !important;
        border-radius: 10px;
        padding: 0.65rem 1.25rem;
        margin-bottom: 0.6rem;
        color: #ffffff !important;
        box-shadow: 0 4px 15px rgba(21, 163, 98, 0.15);
        position: relative;
        overflow: hidden;
    }

    .hero-header h1,
    .hero-header h2,
    .hero-header h3,
    .hero-header h4,
    .hero-header h5,
    .hero-header h6 {
        color: #ffffff !important;
        font-weight: 700 !important;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .hero-header p,
    .hero-header span,
    .hero-header div {
        color: #ffffff;
    }

    .hero-header p {
        color: #ffffff !important;
        opacity: 1 !important;
        font-size: 0.82rem;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .hero-header .bx {
        color: #ffffff !important;
    }

    .hero-header .hero-badge {
        background-color: #ffffff !important;
        color: #0d6d41 !important;
        font-weight: 700 !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15) !important;
        border: 1px solid rgba(255, 255, 255, 0.8) !important;
    }

    .hero-header .hero-badge .bx {
        color: #15a362 !important;
    }

    /* Search / Filter Container */
    .filter-panel-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04) !important;
        border: 1px solid #eef2f6 !important;
        margin-bottom: 0.65rem;
    }

    .filter-divider {
        height: 1px;
        background: #f1f3f5;
        margin: 0.65rem 0;
    }

    /* Select2 Bootstrap 5 Unified Styling */
    .select2-container--bootstrap-5 .select2-selection {
        min-height: 38px !important;
        height: 38px !important;
        display: flex !important;
        align-items: center !important;
        border-radius: 8px !important;
        border: 1px solid #d9dee3 !important;
        font-size: 0.85rem !important;
        background-color: #fff !important;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        line-height: 36px !important;
        padding-left: 10px !important;
        color: #435971 !important;
        font-weight: 500;
    }

    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
        right: 8px !important;
    }

    .select2-container--bootstrap-5.select2-container--focus .select2-selection,
    .select2-container--bootstrap-5.select2-container--open .select2-selection {
        border-color: #15a362 !important;
        box-shadow: 0 0 0 0.2rem rgba(21, 163, 98, 0.15) !important;
    }

    /* Filter Submit Button */
    .btn-filter-submit {
        height: 38px;
        background-color: #15a362 !important;
        border-color: #15a362 !important;
        border-radius: 8px !important;
        font-size: 0.85rem;
        transition: all 0.2s ease-in-out;
    }

    .btn-filter-submit:hover {
        background-color: #0d6d41 !important;
        border-color: #0d6d41 !important;
        box-shadow: 0 4px 12px rgba(21, 163, 98, 0.25) !important;
        transform: translateY(-1px);
    }

    /* Search input group */
    .search-input-group .form-control,
    .search-input-group .input-group-text,
    .search-input-group .btn {
        height: 34px !important;
        border-color: #d9dee3;
    }
    .search-input-group:focus-within .form-control,
    .search-input-group:focus-within .input-group-text {
        border-color: #15a362 !important;
    }

    /* Single-Screen Sticky Table Container */
    .table-sticky-container {
        height: calc(100vh - 250px);
        max-height: calc(100vh - 250px);
        min-height: 420px;
        overflow-y: auto;
        overflow-x: hidden;
        border-radius: 10px;
        border: 1.5px solid #529432;
        background: #fff;
        box-shadow: 0 4px 16px rgba(0,0,0,0.04);
    }

    /* Table Styles - Fixed 100% Fit Width (No Horizontal Scroll) */
    #ReportSummaryTeacher {
        table-layout: fixed !important;
        width: 100% !important;
        border-collapse: separate !important;
        border-spacing: 0;
        margin-bottom: 0 !important;
        font-size: 0.78rem !important;
    }

    /* Sticky Headers (Top) */
    #ReportSummaryTeacher thead tr:first-child th {
        position: sticky;
        top: 0;
        z-index: 25;
        background-color: #ABDD93 !important;
        border-top: none;
        border-bottom: 1px solid #529432 !important;
        color: #1b3815 !important;
        font-weight: 700;
        vertical-align: middle !important;
        padding: 6px 2px !important;
        font-size: 0.78rem;
        text-align: center;
    }

    #ReportSummaryTeacher thead tr:nth-child(2) th {
        position: sticky;
        top: 32px;
        z-index: 25;
        background-color: #ABDD93 !important;
        border-bottom: 2px solid #529432 !important;
        color: #1b3815 !important;
        font-weight: 700;
        vertical-align: middle !important;
        padding: 5px 2px !important;
        font-size: 0.76rem;
        text-align: center;
    }

    /* Sticky Footer (Bottom Totals) */
    #ReportSummaryTeacher tfoot tr th,
    #ReportSummaryTeacher tfoot tr td {
        position: sticky;
        bottom: 0;
        z-index: 20;
        background-color: #e8f5e9 !important;
        border-top: 2px solid #15a362 !important;
        border-bottom: none;
        color: #0d6d41 !important;
        font-weight: 700;
        padding: 6px 2px !important;
        font-size: 0.78rem;
        text-align: center;
    }

    #ReportSummaryTeacher tbody td {
        border-color: #edf2f7;
        vertical-align: middle;
        padding: 4px 2px !important;
        font-size: 0.77rem;
        line-height: 1.25;
        text-align: center;
    }

    #ReportSummaryTeacher tbody tr:hover td {
        background-color: #f0fdf4 !important;
    }

    /* Text Truncation inside fixed cells */
    .cell-truncate {
        display: block;
        width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .bg-grade-high { background-color: #f1f8e9 !important; }
    .bg-grade-low { background-color: #fffde7 !important; }
    .bg-status-danger { background-color: #ffebee !important; }

    .fade-in-up {
        animation: fadeInUp 0.25s ease-out forwards;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Select2 Bootstrap 5 Compact Fixes */
    .select2-container--bootstrap-5 .select2-selection {
        min-height: 34px !important;
        height: 34px !important;
        display: flex !important;
        align-items: center !important;
        border-radius: 6px !important;
        font-size: 0.84rem !important;
    }
    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        line-height: 32px !important;
        padding-left: 8px !important;
    }

    /* SweetAlert Top Layer Rule */
    .swal2-container {
        z-index: 9999 !important;
    }

    /* Print styling */
    @media print {
        @page { size: landscape; margin: 8mm; }
        body {
            background: #fff !important;
            color: #000 !important;
        }
        .layout-navbar, .layout-menu, .hero-header, .search-container, #tableControlBar, .btn, .breadcrumb {
            display: none !important;
        }
        .table-sticky-container {
            height: auto !important;
            max-height: none !important;
            overflow: visible !important;
            border: 1px solid #000 !important;
            box-shadow: none !important;
        }
        #ReportSummaryTeacher thead tr th,
        #ReportSummaryTeacher tfoot tr th,
        #ReportSummaryTeacher tfoot tr td {
            position: static !important;
            color: #000 !important;
            background: #eee !important;
            box-shadow: none !important;
        }
        .container-fluid {
            padding: 0 !important;
            margin: 0 !important;
        }
    }
</style>

<div class="container-fluid flex-grow-1 px-3 py-2">
    <!-- Compact Hero Header -->
    <div class="hero-header fade-in-up">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background: rgba(255, 255, 255, 0.22); border: 1.5px solid rgba(255, 255, 255, 0.5);">
                    <i class='bx bx-bar-chart-alt-2 fs-4 text-white'></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0 text-white" style="color: #ffffff !important;">รายงานสรุปผลสัมฤทธิ์ทางการเรียน</h5>
                    <p class="mb-0 text-white" style="color: #ffffff !important; opacity: 1 !important; font-size: 0.80rem;">
                        <?= esc($selectedLernName ?? 'ทุกกลุ่มสาระการเรียนรู้') ?> • สถิติการตัดเกรด ค่าเฉลี่ย และผลการเรียนรายวิชา
                    </p>
                </div>
            </div>
            <div class="d-inline-flex flex-wrap gap-2">
                <?php if (!empty($KeyYear) && $KeyYear != '0'): ?>
                    <span class="badge hero-badge py-1 px-2.5 rounded-pill shadow-sm" style="font-size: 0.8rem;">
                        <i class='bx bx-calendar-check me-1'></i> ปีการศึกษา <?= esc($KeyYear) ?>
                    </span>
                <?php endif; ?>
                <?php if (!empty($selectedLernName) && $selectedLernName !== 'ทุกกลุ่มสาระการเรียนรู้'): ?>
                    <span class="badge hero-badge py-1 px-2.5 rounded-pill shadow-sm" style="font-size: 0.8rem;">
                        <i class='bx bx-bookmark-alt-plus me-1'></i> <?= esc($selectedLernName) ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Unified Filter & Table Tools Panel (Sneat Style) -->
    <div class="card border-0 shadow-sm filter-panel-card fade-in-up">
        <div class="card-body p-3">
            <form method="get" action="<?= site_url('Admin/Acade/Evaluate/ReportAcademicSummary'); ?>" id="formFilterSummary">
                <div class="row g-2 align-items-end">
                    <!-- Academic Year: 25% on desktop -->
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label class="form-label text-dark fw-bold mb-1 d-flex align-items-center gap-1" style="font-size: 0.82rem;">
                            <i class='bx bx-calendar text-success fs-6'></i> ปีการศึกษา <span class="text-danger">*</span>
                        </label>
                        <select class="form-select select2" name="KeyYear" id="KeyYear">
                            <option value="0">-- เลือกปีการศึกษา --</option>
                            <?php foreach ($CheckYear as $v_CheckYear) : ?>
                                <option <?= (isset($KeyYear) && $KeyYear == $v_CheckYear->RegisterYear) ? 'selected' : '' ?> value="<?= esc($v_CheckYear->RegisterYear) ?>">
                                    ปีการศึกษา <?= esc($v_CheckYear->RegisterYear) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Learning Area: 50% on desktop (Plenty of space for long names) -->
                    <div class="col-lg-6 col-md-5 col-sm-6">
                        <label class="form-label text-dark fw-bold mb-1 d-flex align-items-center gap-1" style="font-size: 0.82rem;">
                            <i class='bx bx-book-bookmark text-success fs-6'></i> กลุ่มสาระการเรียนรู้
                        </label>
                        <select class="form-select select2" name="SelLern" id="SelLern">
                            <option value="0">-- ทั้งหมด / ทุกกลุ่มสาระการเรียนรู้ --</option>
                            <?php foreach ($lern as $v_lern) : ?>
                                <option <?= (service('request')->getGet('SelLern') == $v_lern->lear_id) ? "selected" : "" ?> value="<?= esc($v_lern->lear_id) ?>">
                                    <?= esc($v_lern->lear_namethai) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Submit Query Button: 25% on desktop -->
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <button class="btn btn-success w-100 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2 btn-filter-submit" type="submit">
                            <i class="bx bx-filter-alt fs-5"></i> ดึงข้อมูลรายงาน
                        </button>
                    </div>
                </div>
            </form>

            <?php if (!empty($Showdata)) : ?>
                <!-- Clean Divider separating Query from In-Table Tools -->
                <div class="filter-divider"></div>

                <!-- Table Controls: Quick Live Search & Data Export Buttons -->
                <div class="row g-2 align-items-center justify-content-between" id="tableControlBar">
                    <div class="col-lg-4 col-md-5 col-sm-12">
                        <div class="input-group input-group-sm search-input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted ps-2 pe-1">
                                <i class='bx bx-search text-success'></i>
                            </span>
                            <input type="text" id="quickFilterInput" class="form-control form-control-sm bg-light border-start-0 ps-1" placeholder="ค้นหาด่วน เช่น ชื่อครู, รหัสวิชา, ชั้น..." style="font-size: 0.82rem;">
                            <button class="btn btn-outline-secondary d-none border-start-0" id="btnClearSearch" type="button" title="ล้างคำค้นหา"><i class='bx bx-x'></i></button>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <span id="filteredCountBadge" class="badge bg-label-success py-1 px-2.5 d-none fw-normal" style="font-size: 0.78rem;">
                            <i class='bx bx-check-circle me-1'></i> <span id="filteredCountText"></span>
                        </span>
                    </div>
                    <div class="col-lg-5 col-md-4 col-sm-6 text-sm-end" id="exportSummaryButtons">
                        <!-- DataTables Export Buttons will attach here -->
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if (empty($Showdata)) : ?>
        <div class="card border-0 shadow-sm bg-white text-center py-5 fade-in-up" style="border-radius: 10px;">
            <div class="avatar avatar-xl mx-auto mb-3" style="width: 70px; height: 70px;">
                <span class="avatar-initial rounded-circle bg-label-success"><i class="bx bx-search-alt" style="font-size: 2.2rem; color: #15a362;"></i></span>
            </div>
            <h6 class="text-dark fw-bold mb-1">ไม่พบข้อมูล หรือกรุณาเลือกเงื่อนไขเพื่อแสดงรายงาน</h6>
            <p class="text-muted small mb-0">เลือกปีการศึกษาและกลุ่มสาระการเรียนรู้ด้านบนเพื่อดูสถิติและผลการเรียน</p>
        </div>
    <?php else : ?>

        <!-- Data Table with 100% Fit Width across all 19 columns -->
        <div class="fade-in-up">
            <div class="table-sticky-container">
                <table class="table table-hover mb-0" id="ReportSummaryTeacher">
                    <colgroup>
                        <col style="width: 13%;">  <!-- 1: ครูผู้สอน -->
                        <col style="width: 16.5%;"> <!-- 2: รายวิชา / รหัสวิชา -->
                        <col style="width: 4%;">   <!-- 3: ชั้น -->
                        <col style="width: 3.5%;"> <!-- 4: นก. -->
                        <col style="width: 4%;">   <!-- 5: นร. -->
                        <col style="width: 3.3%;"> <!-- 6: 4 -->
                        <col style="width: 3.3%;"> <!-- 7: 3.5 -->
                        <col style="width: 3.3%;"> <!-- 8: 3 -->
                        <col style="width: 3.3%;"> <!-- 9: 2.5 -->
                        <col style="width: 3.3%;"> <!-- 10: 2 -->
                        <col style="width: 3.3%;"> <!-- 11: 1.5 -->
                        <col style="width: 3.3%;"> <!-- 12: 1 -->
                        <col style="width: 3.3%;"> <!-- 13: 0 -->
                        <col style="width: 3.3%;"> <!-- 14: ร -->
                        <col style="width: 3.3%;"> <!-- 15: มส -->
                        <col style="width: 4.5%;"> <!-- 16: 3+ -->
                        <col style="width: 7%;">   <!-- 17: % 3+ -->
                        <col style="width: 7.5%;"> <!-- 18: เฉลี่ย -->
                        <col style="width: 7%;">   <!-- 19: SD -->
                    </colgroup>
                    <thead>
                        <tr>
                            <th rowspan="2">ครูผู้สอน</th>
                            <th rowspan="2">รายวิชา / รหัสวิชา</th>
                            <th rowspan="2">ชั้น</th>
                            <th rowspan="2">นก.</th>
                            <th rowspan="2" class="bg-primary text-white" style="background-color: #2b76f5 !important;">นร.</th>
                            <th colspan="8" class="text-white" style="background-color: #15a362 !important;">ผลการเรียน (จำนวนคน)</th>
                            <th colspan="2" class="bg-warning text-dark text-nowrap">สถานะ</th>
                            <th colspan="4" class="text-white" style="background-color: #0288d1 !important;">สถิติรวม</th>
                        </tr>
                        <tr>
                            <th class="bg-grade-high text-dark">4</th>
                            <th class="bg-grade-high text-dark">3.5</th>
                            <th class="bg-grade-high text-dark">3</th>
                            <th>2.5</th>
                            <th>2</th>
                            <th>1.5</th>
                            <th>1</th>
                            <th class="text-danger bg-grade-low">0</th>
                            <th class="bg-status-danger text-dark">ร</th>
                            <th class="bg-status-danger text-dark">มส</th>
                            <th class="text-white border-white" style="background-color: #0288d1 !important;">3+</th>
                            <th class="text-white border-white" style="background-color: #0288d1 !important;">% 3+</th>
                            <th class="text-white border-white" style="background-color: #0288d1 !important;">เฉลี่ย</th>
                            <th class="text-white border-white" style="background-color: #0288d1 !important;">SD</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($Showdata as $v_data) : 
                            $totalNumeric = (int)$v_data->TotalNumeric;
                            $goodCount = (int)$v_data->G4_0 + (int)$v_data->G3_5 + (int)$v_data->G3_0;
                            $goodPercent = ($totalNumeric > 0) ? ($goodCount / $totalNumeric) * 100 : 0;
                            $teacherName = $v_data->pers_prefix . $v_data->pers_firstname . ' ' . $v_data->pers_lastname;
                        ?>
                            <tr>
                                <td class="text-start px-1 border-end">
                                    <span class="cell-truncate fw-medium text-dark" title="<?= esc($teacherName) ?>">
                                        <?= esc($teacherName) ?>
                                    </span>
                                </td>
                                <td class="text-start px-1 border-end">
                                    <div class="d-flex align-items-center gap-1 overflow-hidden" title="<?= esc($v_data->SubjectCode . ' ' . $v_data->SubjectName) ?>">
                                        <span class="badge bg-label-success px-1 py-0 flex-shrink-0" style="font-size: 0.70rem;"><?= esc($v_data->SubjectCode) ?></span> 
                                        <span class="cell-truncate text-dark"><?= esc($v_data->SubjectName) ?></span>
                                    </div>
                                </td>
                                <td class="border-end fw-bold"><?= esc($v_data->StudentClass) ?></td>
                                <td class="border-end"><?= number_format((float)$v_data->SubjectUnit, 1) ?></td>
                                <td class="border-end fw-bold text-primary bg-light"><?= esc($v_data->SumStu) ?></td>
                                
                                <td class="border-end bg-grade-high"><?= $v_data->G4_0 ?: '0' ?></td>
                                <td class="border-end bg-grade-high"><?= $v_data->G3_5 ?: '0' ?></td>
                                <td class="border-end bg-grade-high"><?= $v_data->G3_0 ?: '0' ?></td>
                                
                                <td class="border-end"><?= $v_data->G2_5 ?: '0' ?></td>
                                <td class="border-end"><?= $v_data->G2_0 ?: '0' ?></td>
                                <td class="border-end"><?= $v_data->G1_5 ?: '0' ?></td>
                                <td class="border-end"><?= $v_data->G1_0 ?: '0' ?></td>
                                <td class="border-end text-danger fw-bold bg-grade-low"><?= $v_data->G0 ?: '0' ?></td>
                                
                                <td class="border-end bg-status-danger"><?= $v_data->G_W ?: '0' ?></td>
                                <td class="border-end bg-status-danger"><?= $v_data->G_MS ?: '0' ?></td>
                                
                                <td class="border-end fw-bold bg-light text-success"><?= $goodCount ?></td>
                                <td class="border-end fw-bold <?= $goodPercent >= 50 ? 'text-success' : 'text-danger' ?> bg-light">
                                    <?= number_format($goodPercent, 1) ?>%
                                </td>
                                <td class="border-end fw-bold bg-light table-info"><?= number_format((float)$v_data->MeanGrade, 2) ?></td>
                                <td class="fw-bold bg-light"><?= number_format((float)$v_data->SDGrade, 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <?php if (!empty($summaryStats)) : ?>
                        <tfoot>
                            <tr>
                                <th colspan="2" class="text-center border-end">
                                    <i class='bx bx-calculator me-1'></i> รวมทั้งสิ้น (<?= number_format($summaryStats['countSections']) ?> กลุ่มเรียน)
                                </th>
                                <th class="border-end">-</th>
                                <th class="border-end">-</th>
                                <th class="border-end text-primary fw-bold"><?= number_format($summaryStats['totalSumStu']) ?></th>
                                
                                <th class="border-end"><?= number_format($summaryStats['totalG4_0']) ?></th>
                                <th class="border-end"><?= number_format($summaryStats['totalG3_5']) ?></th>
                                <th class="border-end"><?= number_format($summaryStats['totalG3_0']) ?></th>
                                
                                <th class="border-end"><?= number_format($summaryStats['totalG2_5']) ?></th>
                                <th class="border-end"><?= number_format($summaryStats['totalG2_0']) ?></th>
                                <th class="border-end"><?= number_format($summaryStats['totalG1_5']) ?></th>
                                <th class="border-end"><?= number_format($summaryStats['totalG1_0']) ?></th>
                                <th class="border-end text-danger fw-bold"><?= number_format($summaryStats['totalG0']) ?></th>
                                
                                <th class="border-end text-danger"><?= number_format($summaryStats['totalG_W']) ?></th>
                                <th class="border-end text-danger"><?= number_format($summaryStats['totalG_MS']) ?></th>
                                
                                <th class="border-end text-success fw-bold"><?= number_format($summaryStats['totalGood']) ?></th>
                                <th class="border-end fw-bold <?= $summaryStats['totalGoodPercent'] >= 50 ? 'text-success' : 'text-danger' ?>">
                                    <?= number_format($summaryStats['totalGoodPercent'], 1) ?>%
                                </th>
                                <th class="border-end fw-bold"><?= number_format($summaryStats['overallMean'], 2) ?></th>
                                <th>-</th>
                            </tr>
                        </tfoot>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Select2 Initialization with bootstrap-5 theme
    $('.select2').each(function() {
        $(this).select2({ 
            theme: 'bootstrap-5',
            width: '100%'
        });
    });

    // Form submission with Global Loader or SweetAlert
    $('#formFilterSummary').on('submit', function() {
        if ($('#KeyYear').val() === '0') {
            Swal.fire({ 
                icon: 'warning', 
                title: 'กรุณาเลือกปีการศึกษา', 
                text: 'โปรดเลือกปีการศึกษาที่ต้องการดูข้อมูลสรุปผลสัมฤทธิ์',
                confirmButtonColor: '#15a362',
                customClass: { container: 'swal2-top-layer' }
            });
            return false;
        }
        if (typeof window.showGlobalLoading === 'function') {
            let yearTxt = $('#KeyYear option:selected').text().trim();
            let lernTxt = $('#SelLern option:selected').text().trim();
            window.showGlobalLoading('กำลังประมวลผลข้อมูลสรุป...', yearTxt + ' • ' + lernTxt);
        } else {
            Swal.fire({
                title: 'กำลังดึงข้อมูลสรุป...',
                text: 'ระบบกำลังวิเคราะห์สถิติทางการเรียนให้คุณ กรุณารอสักครู่',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });
        }
        return true;
    });

    // Initialize DataTable with Export Buttons and Instant Search
    if ($('#ReportSummaryTeacher').length && !$.fn.DataTable.isDataTable('#ReportSummaryTeacher')) {
        let table = $('#ReportSummaryTeacher').DataTable({
            dom: 'rt',
            buttons: [
                { 
                    extend: 'excelHtml5', 
                    text: '<i class="bx bxs-file-export me-1"></i> Excel',
                    className: 'btn btn-success btn-sm border-0 shadow-sm me-1 py-1',
                    style: 'background-color: #15a362;',
                    title: 'สรุปผลสัมฤทธิ์ทางการเรียน_<?= esc($KeyYear ?? "") ?>_<?= esc($selectedLernName ?? "") ?>',
                    footer: true
                },
                { 
                    extend: 'print', 
                    text: '<i class="bx bx-printer me-1"></i> พิมพ์',
                    className: 'btn btn-outline-secondary btn-sm border-0 shadow-sm py-1',
                    title: 'สรุปผลสัมฤทธิ์ทางการเรียน ปีการศึกษา <?= esc($KeyYear ?? "") ?> - <?= esc($selectedLernName ?? "") ?>',
                    footer: true,
                    customize: function (win) {
                        $(win.document.body).css('font-size', '9pt');
                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }
            ],
            ordering: false,
            paging: false,
            info: false,
            autoWidth: false,
            responsive: false,
            scrollX: false
        });

        // Append export buttons to top bar
        table.buttons().container().appendTo('#exportSummaryButtons');

        // Quick Search / Instant Filter
        $('#quickFilterInput').on('keyup input', function() {
            let query = $(this).val();
            table.search(query).draw();

            if (query.trim() !== '') {
                $('#btnClearSearch').removeClass('d-none');
                let info = table.page.info();
                $('#filteredCountText').text('พบ ' + info.recordsDisplay + ' จาก ' + info.recordsTotal + ' รายการ');
                $('#filteredCountBadge').removeClass('d-none');
            } else {
                $('#btnClearSearch').addClass('d-none');
                $('#filteredCountBadge').addClass('d-none');
            }
        });

        // Clear quick search button
        $('#btnClearSearch').on('click', function() {
            $('#quickFilterInput').val('').trigger('input').focus();
        });
    }
});
</script>
<?= $this->endSection() ?>