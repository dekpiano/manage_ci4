<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>

<?php
    $subCount = !empty($subject) ? count($subject) : 0;
    // For A4 Landscape, 32% is reserved for static columns (No 3.5%, Name 16.5%, Code 6.5%, GPA 5.5%), remaining 68% for subjects
    $subWidthPercent = ($subCount > 0) ? round(68 / $subCount, 3) : 0;
    $subHeaderFontSize = ($subCount > 22) ? '5.8pt' : (($subCount > 16) ? '6.5pt' : '7pt');
    $subCellFontSize = ($subCount > 22) ? '6.8pt' : (($subCount > 16) ? '7.2pt' : '7.8pt');
    $nameFontSize = ($subCount > 22) ? '7pt' : (($subCount > 16) ? '7.5pt' : '8pt');
    $rotatedTextHeight = ($subCount > 22) ? '12px' : (($subCount > 16) ? '13px' : '15px');
?>

<style>
    :root {
        --primary-green: #15a362;
        --primary-green-hover: #11824e;
        --secondary-green: #e9f7ef;
        --border-green: #c8e6c9;
        --dark-green: #0f683e;
    }

    .swal2-container {
        z-index: 9999 !important;
    }

    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #15a362 0%, #0d7947 100%);
        border-radius: 16px;
        padding: 1.8rem 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 8px 24px rgba(21, 163, 98, 0.2);
        color: #fff;
    }

    .hero-section h2 {
        color: #ffffff !important;
        font-weight: 700;
    }

    /* Filter Bar */
    .search-container {
        background: #ffffff;
        border-radius: 14px;
        padding: 1.25rem 1.5rem;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid #eef0f2;
        margin-bottom: 1.5rem;
    }

    .search-container .select2-container--bootstrap-5 .select2-selection {
        border: 1px solid #dce2e6;
        border-radius: 8px;
        height: 42px;
        line-height: 42px;
    }

    /* Summary Stats Cards */
    .stat-card {
        border-radius: 12px;
        border: 1px solid #eef2f5;
        background: #fff;
        padding: 1rem 1.25rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    /* Table Toolbar */
    .table-toolbar {
        background: #ffffff;
        border-radius: 12px 12px 0 0;
        border: 1px solid #e3e8ee;
        border-bottom: none;
        padding: 0.9rem 1.2rem;
    }

    /* ==========================================================================
       FREEZE PANES TABLE (2D STICKY: TOP HEADER & LEFT/RIGHT COLUMNS)
       ========================================================================== */
    .table-freeze-container {
        position: relative;
        max-height: calc(100vh - 290px);
        min-height: 380px;
        overflow: auto;
        background: #ffffff;
        border: 1px solid #d8e2dc;
        border-radius: 0 0 12px 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    }

    .table-freeze-container.is-fullscreen {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        max-height: 100vh !important;
        z-index: 9998 !important;
        border-radius: 0 !important;
        padding: 15px;
    }

    .table-freeze {
        table-layout: fixed !important;
        border-collapse: separate !important;
        border-spacing: 0;
        width: max-content;
        min-width: 100%;
        margin-bottom: 0;
    }

    .table-freeze th,
    .table-freeze td {
        padding: 8px 4px;
        vertical-align: middle;
        border-bottom: 1px solid #d2ded7;
        border-right: 1px solid #d2ded7;
        box-sizing: border-box;
        background-clip: padding-box;
    }

    /* 1. Top Sticky Headers */
    .table-freeze thead th {
        position: sticky;
        top: 0;
        z-index: 20;
        background-color: #edf7f1 !important;
        color: #1f3d24;
        font-weight: 700;
        border-bottom: 2px solid #15a362 !important;
        text-align: center;
    }

    /* 2. Left Sticky Columns */
    /* Col 1: ที่ */
    .sticky-col-idx {
        position: sticky;
        left: 0;
        width: 48px !important;
        min-width: 48px !important;
        max-width: 48px !important;
        text-align: center;
        box-sizing: border-box;
    }
    /* Col 2: ชื่อ - นามสกุล */
    .sticky-col-name {
        position: sticky;
        left: 48px;
        width: 220px !important;
        min-width: 220px !important;
        max-width: 220px !important;
        text-align: left;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        box-sizing: border-box;
    }
    /* Col 3: รหัสนักเรียน */
    .sticky-col-code {
        position: sticky;
        left: 268px; /* 48 + 220 */
        width: 90px !important;
        min-width: 90px !important;
        max-width: 90px !important;
        text-align: center;
        box-shadow: 4px 0 8px -3px rgba(0, 0, 0, 0.15);
        box-sizing: border-box;
    }
    /* Col Last: GPA (Right Sticky) */
    .sticky-col-gpa {
        position: sticky;
        right: 0;
        width: 76px !important;
        min-width: 76px !important;
        max-width: 76px !important;
        text-align: center;
        box-shadow: -4px 0 8px -3px rgba(0, 0, 0, 0.15);
        box-sizing: border-box;
    }

    /* Body Sticky Backgrounds */
    .table-freeze tbody td.sticky-col-idx,
    .table-freeze tbody td.sticky-col-name,
    .table-freeze tbody td.sticky-col-code {
        background-color: #ffffff;
        z-index: 10;
    }
    .table-freeze tbody td.sticky-col-gpa {
        background-color: #fafbfc;
        z-index: 10;
    }

    /* 3. Corner Headers (Intersecting Top Sticky & Left/Right Sticky) */
    .table-freeze thead th.sticky-col-idx,
    .table-freeze thead th.sticky-col-name,
    .table-freeze thead th.sticky-col-code,
    .table-freeze thead th.sticky-col-gpa {
        z-index: 35;
        background-color: #ddf1e4 !important;
    }

    /* 4. Subject Columns & Vertical Rotated Headers */
    .col-subject-header {
        height: 250px;
        width: 80px;
        min-width: 80px;
        max-width: 80px;
        padding: 0 !important;
        position: relative;
        vertical-align: middle !important;
        background-color: #edf7f1 !important;
        text-align: center;
        box-sizing: border-box;
        transition: width 0.2s ease, min-width 0.2s ease;
    }

    .subject-header-wrap {
        position: relative;
        width: 100%;
        height: 250px;
        margin: 0 auto;
        overflow: hidden;
    }

    /* Dead Center Rotated Text */
    .subject-rotated-text {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 225px;
        height: 28px;
        line-height: 28px;
        transform: translate(-50%, -50%) rotate(-90deg);
        transform-origin: center center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-align: left;
        font-size: 0.82rem;
        font-weight: 600;
        color: #1f3d24;
        cursor: help;
        user-select: none;
        display: inline-flex;
        align-items: center;
    }

    .badge-unit {
        display: inline-block;
        background: #e8f5e9;
        color: #15a362;
        border: 1px solid #c8e6c9;
        border-radius: 4px;
        padding: 0 5px;
        font-size: 0.72rem;
        font-weight: 700;
        line-height: 18px;
        vertical-align: middle;
        flex-shrink: 0;
    }

    .subject-code-tag {
        color: #15a362;
        font-weight: 700;
        flex-shrink: 0;
    }

    .subject-name-tag {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .col-subject-cell {
        width: 80px;
        min-width: 80px;
        max-width: 80px;
        text-align: center;
        font-size: 0.88rem;
        box-sizing: border-box;
        transition: width 0.2s ease, min-width 0.2s ease;
    }

    /* Size Variations (Toggleable) */
    .table-freeze.tbl-size-compact .col-subject-header,
    .table-freeze.tbl-size-compact .col-subject-cell,
    .table-freeze.tbl-size-compact col.col-sub-w {
        width: 62px !important;
        min-width: 62px !important;
        max-width: 62px !important;
    }

    .table-freeze.tbl-size-wide .col-subject-header,
    .table-freeze.tbl-size-wide .col-subject-cell,
    .table-freeze.tbl-size-wide col.col-sub-w {
        width: 105px !important;
        min-width: 105px !important;
        max-width: 105px !important;
    }


    /* Row Hover Sync */
    .table-freeze tbody tr:hover td {
        background-color: #f1faf5 !important;
    }
    .table-freeze tbody tr:hover td.sticky-col-gpa {
        background-color: #e8f7ee !important;
    }

    /* Grade Badges */
    .badge-grade {
        display: inline-block;
        min-width: 26px;
        padding: 2px 4px;
        font-weight: 700;
        border-radius: 4px;
        font-size: 0.82rem;
        line-height: 1.2;
    }
    .grade-zero {
        background-color: #fee2e2;
        color: #dc2626;
        border: 1px solid #fca5a5;
    }
    .grade-incomplete {
        background-color: #fef3c7;
        color: #b45309;
        border: 1px solid #fcd34d;
    }
    .grade-nosit {
        background-color: #ffedd5;
        color: #c2410c;
        border: 1px solid #fdba74;
    }
    .grade-failed {
        background-color: #fee2e2;
        color: #dc2626;
        border: 1px solid #fca5a5;
    }
    .grade-passed {
        background-color: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
    }
    .grade-high {
        color: #15a362;
        font-weight: 700;
    }
    .grade-normal {
        color: #334155;
    }
    .grade-low {
        color: #64748b;
    }

    /* GPA Badges */
    .badge-gpa {
        display: inline-block;
        padding: 3px 6px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.86rem;
    }
    .gpa-high {
        background-color: #d1fae5;
        color: #065f46;
    }
    .gpa-med {
        background-color: #f1f5f9;
        color: #334155;
    }
    .gpa-low {
        background-color: #fee2e2;
        color: #991b1b;
    }

    /* Print Styles: Fit 100% perfectly on A4 Landscape */
    @media print {
        @page {
            size: A4 landscape;
            margin: 5mm 6mm;
        }

        html, body {
            width: 100% !important;
            height: auto !important;
            background: #fff !important;
            color: #000 !important;
            margin: 0 !important;
            padding: 0 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* 1. Complete reset of Sneat & Bootstrap layout wrappers to remove the 260px sidebar padding */
        .layout-wrapper,
        .layout-container,
        .layout-page,
        .content-wrapper,
        .container-xxl,
        .container-fluid,
        .content-backdrop {
            display: block !important;
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            padding-inline-start: 0 !important;
            padding-inline-end: 0 !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            transform: none !important;
            position: static !important;
        }

        /* 2. Hide all non-printable UI elements */
        .layout-navbar,
        .layout-menu,
        .layout-menu-toggle,
        .content-footer,
        .hero-section,
        .search-container,
        .table-toolbar,
        .stat-cards-container,
        .btn,
        .navbar,
        .footer,
        #formSearchRoom,
        .alert,
        .select2,
        .swal2-container,
        .page-loading-overlay {
            display: none !important;
        }

        /* 3. Official Print Header */
        .print-only-header {
            display: block !important;
            text-align: center !important;
            margin-bottom: 6px !important;
        }
        .print-only-header h4 {
            font-size: 12pt !important;
            font-weight: bold !important;
            margin: 0 !important;
            color: #000 !important;
        }
        .print-only-header h5 {
            font-size: 10.5pt !important;
            font-weight: bold !important;
            margin: 2px 0 !important;
            color: #000 !important;
        }
        .print-only-header p {
            font-size: 8.5pt !important;
            margin: 0 !important;
            color: #333 !important;
        }

        /* 4. Table Freeze Container: Unlock & Expand to 100% */
        .table-freeze-container {
            max-height: none !important;
            overflow: visible !important;
            border: none !important;
            box-shadow: none !important;
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* 5. Strictly enforce fixed table layout so it NEVER overflows A4 */
        .table-freeze {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            table-layout: fixed !important;
            border-collapse: collapse !important;
            margin: 0 auto !important;
        }

        /* 6. Exact Percentage Column Allocation for A4 Landscape */
        .table-freeze colgroup col.col-idx { width: 3.5% !important; }
        .table-freeze colgroup col.col-name { width: 16.5% !important; }
        .table-freeze colgroup col.col-code { width: 6.5% !important; }
        .table-freeze colgroup col.col-sub-w { width: <?= $subWidthPercent ?>% !important; }
        .table-freeze colgroup col.col-gpa { width: 5.5% !important; }

        /* 7. Cells styling */
        .table-freeze th,
        .table-freeze td {
            position: static !important;
            box-shadow: none !important;
            border: 0.5pt solid #555 !important;
            padding: 1.5px 1px !important;
            background: #fff !important;
            color: #000 !important;
            box-sizing: border-box !important;
            text-align: center !important;
        }

        .sticky-col-idx {
            width: 3.5% !important;
            min-width: 0 !important;
            max-width: none !important;
            font-size: 7pt !important;
            text-align: center !important;
        }
        .sticky-col-name {
            width: 16.5% !important;
            min-width: 0 !important;
            max-width: none !important;
            font-size: <?= $nameFontSize ?> !important;
            white-space: nowrap !important;
            text-align: left !important;
            padding-left: 2px !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }
        .sticky-col-code {
            width: 6.5% !important;
            min-width: 0 !important;
            max-width: none !important;
            font-size: 7pt !important;
            text-align: center !important;
            overflow: hidden !important;
            white-space: nowrap !important;
        }
        .sticky-col-gpa {
            width: 5.5% !important;
            min-width: 0 !important;
            max-width: none !important;
            font-size: 7.5pt !important;
            font-weight: bold !important;
            text-align: center !important;
            overflow: hidden !important;
        }

        .col-subject-header {
            height: 105px !important;
            width: <?= $subWidthPercent ?>% !important;
            min-width: 0 !important;
            max-width: none !important;
            padding: 0 !important;
            vertical-align: middle !important;
            overflow: hidden !important;
        }
        .col-subject-cell {
            width: <?= $subWidthPercent ?>% !important;
            min-width: 0 !important;
            max-width: none !important;
            font-size: <?= $subCellFontSize ?> !important;
            text-align: center !important;
            overflow: hidden !important;
            white-space: nowrap !important;
        }

        .subject-header-wrap {
            width: 100% !important;
            height: 105px !important;
            position: relative !important;
            overflow: hidden !important;
            margin: 0 auto !important;
        }
        .subject-rotated-text {
            position: absolute !important;
            top: 50% !important;
            left: 50% !important;
            width: 100px !important;
            height: <?= $rotatedTextHeight ?> !important;
            line-height: <?= $rotatedTextHeight ?> !important;
            font-size: <?= $subHeaderFontSize ?> !important;
            font-weight: 600 !important;
            color: #000 !important;
            transform: translate(-50%, -50%) rotate(-90deg) !important;
            transform-origin: center center !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: flex-start !important;
        }
        .badge-unit {
            border: none !important;
            background: transparent !important;
            color: #000 !important;
            padding: 0 1px !important;
            font-size: inherit !important;
            font-weight: 700 !important;
        }
        .subject-code-tag {
            color: #000 !important;
            font-size: inherit !important;
            font-weight: 700 !important;
        }
        .subject-name-tag {
            color: #000 !important;
            font-size: inherit !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
        }

        .badge-grade {
            border: none !important;
            background: transparent !important;
            color: #000 !important;
            font-weight: bold !important;
            font-size: inherit !important;
            padding: 0 !important;
            display: inline-block !important;
        }
        .badge-gpa {
            border: none !important;
            background: transparent !important;
            color: #000 !important;
            font-weight: bold !important;
            padding: 0 !important;
            font-size: inherit !important;
            display: inline-block !important;
        }

        .table-freeze thead {
            display: table-header-group !important;
        }
        .table-freeze tbody tr {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
    }
</style>

<div class="container-fluid p-3">
    <!-- Print Header -->
    <div class="print-only-header d-none">
        <h4 class="fw-bold mb-1">โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</h4>
        <h5 class="fw-bold mb-1">รายงานผลการเรียนรายห้องเรียน ระดับชั้น <?= esc($keyroom_short ?? "") ?></h5>
        <p class="mb-2">ประจำปีการศึกษา <?= esc($KeyCheckYear ?? "") ?></p>
    </div>

    <!-- Hero Header -->
    <div class="hero-section">
        <div class="row align-items-center g-3">
            <div class="col-md-9">
                <h2 class="mb-1">
                    <i class='bx bx-table me-2'></i>รายงานผลการเรียนรายห้อง <?= esc($keyroom_short ?? "") ?>
                </h2>
                <p class="mb-0 opacity-75">
                    <?= esc($totip ?? "ตรวจสอบข้อมูลการเรียนรายวิชาและเกรดเฉลี่ยรายบุคคล พร้อมระบบตรึงหัวตารางและชื่อนักเรียน") ?>
                </p>
            </div>
            <div class="col-md-3 text-md-end">
                <span class="badge bg-white text-success p-2 px-3 fw-bold shadow-sm" style="font-size: 0.95rem;">
                    <i class='bx bx-calendar me-1'></i> <?= esc($KeyCheckYear ?? get_selected_year()) ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <?php 
        $currentSegment = service('request')->getUri()->getSegment(3) ?? '';
        $formAction = ($currentSegment === "Executive") 
            ? site_url('Admin/Acade/Executive/ReportRoom') 
            : site_url('Admin/Acade/Evaluate/ReportRoom');
        $excelAction = ($currentSegment === "Executive") 
            ? site_url('Admin/Acade/Executive/exportRoomReportToExcel') 
            : site_url('Admin/Acade/Evaluate/exportRoomReportToExcel');
    ?>
    <form action="<?= $formAction ?>" method="post" id="formSearchRoom">
        <?= csrf_field() ?>
        <div class="search-container">
            <div class="row align-items-end g-3">
                <div class="col-md-5">
                    <label class="form-label fw-bold text-dark mb-1 small">
                        <i class='bx bx-calendar me-1 text-success'></i>ปีการศึกษา/ภาคเรียน
                    </label>
                    <select class="form-select select2" name="KeyCheckYear" id="KeyCheckYear">
                        <option value="">-- เลือกปีการศึกษา --</option>
                        <?php 
                            $activeRoomYear = (isset($KeyCheckYear) && !empty($KeyCheckYear)) ? $KeyCheckYear : get_selected_year();
                        ?>
                        <?php foreach ($CheckYear as $v_CheckYear) : ?>
                        <option <?= ($activeRoomYear == $v_CheckYear->RegisterYear) ? 'selected' : ''?> value="<?= esc($v_CheckYear->RegisterYear) ?>">
                            ปีการศึกษา <?= esc($v_CheckYear->RegisterYear) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-bold text-dark mb-1 small">
                        <i class='bx bx-door-open me-1 text-success'></i>ระดับห้องเรียน
                    </label>
                    <select class="form-select select2" name="keyroom" id="keyroom">
                        <option value="">-- เลือกระดับห้องเรียน --</option>
                        <?php foreach ($room as $v_room) : ?>
                            <option <?= (isset($keyroom) && $keyroom == $v_room) ? "selected" : "" ?> value="<?= esc($v_room) ?>">
                                <?= esc($v_room) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-success w-100 fw-bold" style="background-color: #15a362; border-color: #15a362; height: 42px; border-radius: 8px;" type="submit">
                        <i class='bx bx-search-alt me-1'></i> ค้นข้อมูล
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- Main Content Section -->
    <?php if(!isset($Nodata) || $Nodata == 0): ?>
        <div class="card border-0 text-center py-5 shadow-sm" style="border-radius: 16px;">
            <div class="bg-success bg-opacity-10 d-inline-flex p-4 rounded-circle mb-3 mx-auto">
                <i class='bx bx-search-alt text-success' style="font-size: 4rem;"></i>
            </div>
            <h4 class="fw-bold text-dark mb-1">กรุณาเลือกปีการศึกษาและห้องเรียน</h4>
            <p class="text-muted mb-0">ระบบจะแสดงผลการเรียนพร้อมตรึงหัวตารางและชื่อนักเรียนให้อัตโนมัติ</p>
        </div>
    <?php else: ?>
        <?php
            // Calculate Room Summary Statistics
            $gpaList = [];
            if (isset($CheckSub) && !empty($CheckSub)) {
                foreach ($CheckSub as $row) {
                    $gpaList[] = floatval(end($row));
                }
            }
            $totalStudents = count($stu ?? []);
            $avgGPA = count($gpaList) > 0 ? (array_sum($gpaList) / count($gpaList)) : 0;
            $maxGPA = count($gpaList) > 0 ? max($gpaList) : 0;
            $minGPA = count($gpaList) > 0 ? min($gpaList) : 0;
        ?>

        <!-- Statistics Cards -->
        <div class="row g-3 mb-3 stat-cards-container">
            <div class="col-6 col-md-3">
                <div class="stat-card d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-medium">นักเรียนทั้งหมด</div>
                        <h4 class="fw-bold mb-0 text-dark"><?= $totalStudents ?> <span class="fs-6 fw-normal text-muted">คน</span></h4>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class='bx bx-user'></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-medium">รายวิชาทั้งหมด</div>
                        <h4 class="fw-bold mb-0 text-dark"><?= count($subject ?? []) ?> <span class="fs-6 fw-normal text-muted">วิชา</span></h4>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class='bx bx-book-open'></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-medium">GPA เฉลี่ยห้อง</div>
                        <h4 class="fw-bold mb-0 text-success"><?= number_format($avgGPA, 2) ?></h4>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class='bx bx-award'></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-medium">GPA สูงสุด / ต่ำสุด</div>
                        <h4 class="fw-bold mb-0 text-dark">
                            <span class="text-success"><?= number_format($maxGPA, 2) ?></span> / <span class="text-danger"><?= number_format($minGPA, 2) ?></span>
                        </h4>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                        <i class='bx bx-line-chart'></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Toolbar -->
        <div class="table-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2">
            <!-- Left: Quick Search -->
            <div class="d-flex align-items-center gap-2">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <span class="input-group-text bg-light border-end-0"><i class='bx bx-search'></i></span>
                    <input type="text" id="filterStudentInput" class="form-control border-start-0" placeholder="ค้นหาชื่อ หรือเลขที่...">
                </div>
                <span id="filteredCountBadge" class="badge bg-secondary d-none small"></span>
            </div>

            <!-- Right: Actions & Legends -->
            <div class="d-flex align-items-center gap-2">
                <!-- Legend Guide -->
                <div class="d-none d-lg-flex align-items-center gap-2 small me-2 text-muted">
                    <span><span class="badge-grade grade-zero me-1">0</span> เกรด 0</span>
                    <span><span class="badge-grade grade-incomplete me-1">ร</span> ติด ร</span>
                    <span><span class="badge-grade grade-nosit me-1">มส</span> ติด มส</span>
                </div>

                <!-- Column Width Switcher (ยืด/ขยายความกว้างวิชา) -->
                <div class="d-flex align-items-center gap-1 me-1">
                    <span class="small text-muted d-none d-xl-inline">ความกว้าง:</span>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-secondary col-size-btn" data-size="compact" title="ขนาดกะทัดรัด (62px)">แคบ</button>
                        <button type="button" class="btn btn-secondary active col-size-btn" data-size="normal" title="ขนาดปกติ (80px)">ปกติ</button>
                        <button type="button" class="btn btn-outline-secondary col-size-btn" data-size="wide" title="ขยายกว้าง สบายตา (105px)">กว้าง</button>
                    </div>
                </div>

                <!-- Export Excel Form (Official PhpSpreadsheet) -->
                <form action="<?= $excelAction ?>" method="post" id="formExportExcel" class="d-inline no-loader">
                    <?= csrf_field() ?>
                    <input type="hidden" name="KeyCheckYear" value="<?= esc($KeyCheckYear ?? '') ?>">
                    <input type="hidden" name="keyroom" value="<?= esc($keyroom ?? '') ?>">
                    <button type="submit" class="btn btn-sm btn-outline-success fw-medium shadow-sm" id="btnExportExcel">
                        <i class='bx bx-file me-1'></i> ส่งออก Excel
                    </button>
                </form>

                <!-- Print Button -->
                <button type="button" class="btn btn-sm btn-outline-secondary fw-medium shadow-sm" onclick="printReport()">
                    <i class='bx bx-printer me-1'></i> พิมพ์
                </button>

                <!-- Toggle Fullscreen Button -->
                <button type="button" class="btn btn-sm btn-outline-primary fw-medium shadow-sm" id="btnToggleFullscreen" title="ขยายเต็มจอ">
                    <i class='bx bx-fullscreen me-1'></i> <span class="d-none d-sm-inline">เต็มจอ</span>
                </button>
            </div>
        </div>

        <!-- 2D Freeze Table Container -->
        <div class="table-freeze-container" id="tableFreezeContainer">
            <table class="table-freeze" id="tblGradeSumRoom">
                <colgroup>
                    <col class="col-idx" style="width: 48px;">
                    <col class="col-name" style="width: 220px;">
                    <col class="col-code" style="width: 90px;">
                    <?php if (!empty($subject)): ?>
                        <?php foreach ($subject as $v_subject): ?>
                            <col class="col-sub-w" style="width: 80px;">
                        <?php endforeach; ?>
                        <col class="col-gpa" style="width: 76px;">
                    <?php endif; ?>
                </colgroup>
                <thead>
                    <tr>
                        <th class="sticky-col-idx">ที่</th>
                        <th class="sticky-col-name text-start">ชื่อ - นามสกุล</th>
                        <th class="sticky-col-code">รหัสนักเรียน</th>
                        <?php if (!empty($subject)): ?>
                            <?php foreach ($subject as $v_subject): ?>
                                <th class="col-subject-header" title="<?= esc($v_subject->SubjectCode) ?> <?= esc($v_subject->SubjectName) ?> (<?= esc($v_subject->SubjectUnit) ?> นก.)">
                                    <div class="subject-header-wrap">
                                        <div class="subject-rotated-text">
                                            <span class="badge-unit me-1"><?= esc($v_subject->SubjectUnit ?? '') ?></span>
                                            <span class="subject-code-tag me-1"><?= esc($v_subject->SubjectCode ?? '') ?></span>
                                            <span class="subject-name-tag"><?= esc($v_subject->SubjectName ?? '') ?></span>
                                        </div>
                                    </div>
                                </th>
                            <?php endforeach; ?>
                            <th class="sticky-col-gpa">GPA</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($CheckSub) && !empty($CheckSub)): foreach ($CheckSub as $v_stu) : ?>
                        <tr>
                            <td class="sticky-col-idx text-muted small"><?= esc($v_stu[1] ?? '-') ?></td>
                            <td class="sticky-col-name fw-medium text-dark" title="<?= esc($v_stu[2] ?? '-') ?>"><?= esc($v_stu[2] ?? '-') ?></td>
                            <td class="sticky-col-code text-muted font-monospace small"><?= esc($v_stu[3] ?? '-') ?></td>
                            <?php 
                                $colIdx = 4;
                                foreach ($subject as $v_RegisSubject): 
                                    $gradeData = explode("/", $v_stu[$colIdx] ?? '');
                                    $gradeValue = trim($gradeData[1] ?? '');
                            ?>
                                <td class="col-subject-cell">
                                    <?php if ($gradeValue === '0'): ?>
                                        <span class="badge-grade grade-zero" title="เกรด 0">0</span>
                                    <?php elseif ($gradeValue === 'ร'): ?>
                                        <span class="badge-grade grade-incomplete" title="ติด ร (รอผลการตัดสิน)">ร</span>
                                    <?php elseif ($gradeValue === 'มส'): ?>
                                        <span class="badge-grade grade-nosit" title="ติด มส (หมดสิทธิ์สอบ)">มส</span>
                                    <?php elseif ($gradeValue === 'มผ'): ?>
                                        <span class="badge-grade grade-failed" title="ไม่ผ่าน">มผ</span>
                                    <?php elseif ($gradeValue === 'ผ'): ?>
                                        <span class="badge-grade grade-passed" title="ผ่าน">ผ</span>
                                    <?php elseif (is_numeric($gradeValue)): ?>
                                        <?php $gFloat = floatval($gradeValue); ?>
                                        <span class="<?= ($gFloat >= 3.5) ? 'grade-high' : (($gFloat <= 1.0) ? 'grade-low' : 'grade-normal') ?>">
                                            <?= esc($gradeValue) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted"><?= esc($gradeValue ?: '-') ?></span>
                                    <?php endif; ?>
                                </td>
                            <?php $colIdx++; endforeach; ?>
                            
                            <!-- Student GPA -->
                            <?php 
                                $gpaFinal = floatval(end($v_stu)); 
                                $gpaClass = ($gpaFinal >= 3.00) ? 'gpa-high' : (($gpaFinal < 2.00) ? 'gpa-low' : 'gpa-med');
                            ?>
                            <td class="sticky-col-gpa">
                                <span class="badge-gpa <?= $gpaClass ?>">
                                    <?= number_format($gpaFinal, 2); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr>
                            <td colspan="<?= 4 + count($subject ?? []) ?>" class="text-center py-4 text-muted">
                                ไม่พบข้อมูลผลการเรียนของห้องเรียนนี้
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="small text-muted mt-2 d-flex align-items-center justify-content-between">
            <div>
                <i class='bx bx-info-circle me-1 text-success'></i> เลื่อนซ้าย-ขวาเพื่อดูรายวิชาทั้งหมด (ระบบตรึงชื่อนักเรียนและเกรดเฉลี่ยให้อัตโนมัติ)
            </div>
            <div>
                แสดงทั้งหมด <strong><?= $totalStudents ?></strong> คน
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Initialize Select2 with Bootstrap 5 Theme
    $('.select2').each(function() {
        $(this).select2({ 
            theme: 'bootstrap-5',
            width: '100%'
        });
    });

    // เมื่อเปลี่ยนปีการศึกษา ให้ส่งฟอร์มอัตโนมัติเพื่อดึงรายการห้องใหม่
    $('#KeyCheckYear').on('change', function() {
        if ($(this).val()) {
            if (typeof window.showGlobalLoading === 'function') {
                window.showGlobalLoading('กำลังอัปเดตรายการห้องเรียน...', 'ประจำปีการศึกษา ' + $(this).val());
            }
            $('#formSearchRoom')[0].submit();
        }
    });

    // Handle Form Filter Logic
    $('#formSearchRoom').on('submit', function() {
        let selectedYear = $('#KeyCheckYear').val();
        let selectedRoom = $('#keyroom').val();

        if (!selectedYear) {
            Swal.fire({ 
                icon: 'warning', 
                title: 'กรุณาเลือกปีการศึกษา', 
                confirmButtonColor: '#15a362',
                customClass: { container: 'swal2-top-layer' }
            });
            return false;
        }
        if (!selectedRoom) {
            Swal.fire({ 
                icon: 'warning', 
                title: 'กรุณาเลือกระดับห้องเรียน', 
                confirmButtonColor: '#15a362',
                customClass: { container: 'swal2-top-layer' }
            });
            return false;
        }

        let selectedRoomText = $('#keyroom option:selected').text().trim();
        let selectedYearText = $('#KeyCheckYear option:selected').text().trim();

        if (typeof window.showGlobalLoading === 'function') {
            window.showGlobalLoading('กำลังโหลดข้อมูลผลการเรียน...', selectedRoomText + ' ' + selectedYearText);
        }
        const $btn = $(this).find('button[type="submit"]');
        if ($btn.length) {
            $btn.prop('disabled', true).html("<span class='spinner-border spinner-border-sm me-1'></span> กำลังค้นหา...");
        }
        return true;
    });

    // Quick Search / Filter Student in Table
    $('#filterStudentInput').on('keyup', function() {
        let query = $(this).val().toLowerCase().trim();
        let visibleCount = 0;
        let totalCount = $('#tblGradeSumRoom tbody tr').length;

        $('#tblGradeSumRoom tbody tr').each(function() {
            let rowText = $(this).text().toLowerCase();
            if (rowText.indexOf(query) !== -1) {
                $(this).show();
                visibleCount++;
            } else {
                $(this).hide();
            }
        });

        if (query.length > 0) {
            $('#filteredCountBadge').text('แสดง ' + visibleCount + ' จาก ' + totalCount + ' คน').removeClass('d-none');
        } else {
            $('#filteredCountBadge').addClass('d-none');
        }
    });

    // Column Width Switcher (ปรับความกว้างคอลัมน์วิชา)
    $('.col-size-btn').on('click', function() {
        $('.col-size-btn').removeClass('active btn-secondary').addClass('btn-outline-secondary');
        $(this).addClass('active btn-secondary').removeClass('btn-outline-secondary');
        let size = $(this).data('size');
        $('#tblGradeSumRoom').removeClass('tbl-size-compact tbl-size-normal tbl-size-wide').addClass('tbl-size-' + size);
    });

    // Export Excel with Loading State
    $('#formExportExcel').on('submit', function(e) {
        e.preventDefault();
        let $btn = $('#btnExportExcel');
        let origHtml = $btn.html();

        // Change button to loading state
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> กำลังสร้างไฟล์...');

        let formData = new FormData(this);
        let formAction = $(this).attr('action');

        fetch(formAction, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('การดาวน์โหลดล้มเหลว (รหัสสถานะ: ' + response.status + ')');
            }

            let disposition = response.headers.get('Content-Disposition') || '';
            let filename = 'รายงานผลการเรียนรายห้อง.xlsx';
            if (disposition.indexOf("filename*=UTF-8''") !== -1) {
                filename = decodeURIComponent(disposition.split("filename*=UTF-8''")[1].split(';')[0]);
            } else if (disposition.indexOf('filename=') !== -1) {
                filename = disposition.split('filename=')[1].split(';')[0].replace(/["']/g, '');
                try { filename = decodeURIComponent(filename); } catch(e){}
            }

            return response.blob().then(blob => ({ blob, filename }));
        })
        .then(({ blob, filename }) => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            a.remove();

            $btn.prop('disabled', false).html(origHtml);

            Swal.fire({
                icon: 'success',
                title: 'ดาวน์โหลดสำเร็จ',
                text: 'ไฟล์ Excel ถูกสร้างเรียบร้อยแล้ว',
                timer: 2000,
                showConfirmButton: false,
                customClass: { container: 'swal2-top-layer' }
            });
        })
        .catch(error => {
            console.error('Download error:', error);
            $btn.prop('disabled', false).html(origHtml);
            Swal.fire({
                icon: 'error',
                title: 'ดาวน์โหลดไม่สำเร็จ',
                text: error.message || 'ไม่สามารถสร้างไฟล์ Excel ได้ โปรดลองใหม่อีกครั้ง',
                confirmButtonColor: '#15a362',
                customClass: { container: 'swal2-top-layer' }
            });
        });
    });

    // Toggle Fullscreen Functionality
    $('#btnToggleFullscreen').on('click', function() {
        let container = document.getElementById('tableFreezeContainer');
        if (!document.fullscreenElement) {
            if (container.requestFullscreen) {
                container.requestFullscreen();
            } else if (container.webkitRequestFullscreen) {
                container.webkitRequestFullscreen();
            } else if (container.msRequestFullscreen) {
                container.msRequestFullscreen();
            }
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            }
        }
    });

    document.addEventListener('fullscreenchange', function() {
        let isFull = !!document.fullscreenElement;
        if (isFull) {
            $('#tableFreezeContainer').addClass('is-fullscreen');
            $('#btnToggleFullscreen').html("<i class='bx bx-exit-fullscreen me-1'></i> <span class='d-none d-sm-inline'>ย่อขนาด</span>");
        } else {
            $('#tableFreezeContainer').removeClass('is-fullscreen');
            $('#btnToggleFullscreen').html("<i class='bx bx-fullscreen me-1'></i> <span class='d-none d-sm-inline'>เต็มจอ</span>");
        }
    });

    // Helper for printing: exit fullscreen if active before triggering print dialog
    window.printReport = function() {
        if (document.fullscreenElement && document.exitFullscreen) {
            document.exitFullscreen().then(function() {
                setTimeout(function() { window.print(); }, 150);
            }).catch(function() {
                window.print();
            });
        } else {
            window.print();
        }
    };
});
</script>
<?= $this->endSection() ?>