<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'ข้อมูลการจัดตารางสอนกลุ่มสาระการเรียนรู้') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,300;0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        @font-face {
            font-family: 'TH Sarabun PSK';
            src: url('<?= base_url('assets/fonts/THSarabun.ttf') ?>') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @page {
            size: A4 portrait;
            margin: 10mm 12mm 10mm 12mm;
        }

        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        body {
            font-family: 'TH Sarabun PSK', 'TH Sarabun New', 'Sarabun', sans-serif;
            font-size: 15pt;
            line-height: 1.3;
            color: #000;
            background: #f4f6f9;
            margin: 0;
            padding: 20px;
        }

        .no-print-bar {
            max-width: 900px;
            margin: 0 auto 15px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .btn-print {
            background-color: #15a362;
            color: #fff;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            text-decoration: none;
        }
        .btn-print:hover {
            background-color: #0e7043;
            color: #fff;
        }

        .btn-close-win {
            background-color: #6c757d;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-close-win:hover {
            background-color: #5c636a;
        }

        .sheet-container {
            background: #ffffff;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.12);
            border-radius: 2px;
        }

        /* Document Header */
        .doc-header {
            text-align: center;
            margin-bottom: 12px;
        }

        .doc-title {
            font-weight: 700;
            margin: 0 0 4px 0;
        }

        .school-name {
            font-weight: 700;
            margin: 0 0 6px 0;
        }

        /* Main Table */
        table.schedule-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15pt;
        }

        table.schedule-table th, 
        table.schedule-table td {
            border: 1px solid #000;
            padding: 4px 5px;
            vertical-align: middle;
        }

        table.schedule-table th {
            background-color: #ffffff;
            font-weight: 700;
            text-align: center;
        }

        .text-center { text-align: center !important; }
        .text-start  { text-align: left !important; }
        .text-end    { text-align: right !important; }
        .fw-bold     { font-weight: 700 !important; }

        /* Subject & Teacher Name Single Line & Auto-shrink */
        .subject-name-cell {
            white-space: nowrap !important;
            overflow: hidden;
            text-overflow: clip;
            padding: 3px 5px !important;
            max-width: 220px;
        }

        .subject-name-inner {
            display: inline-block;
            white-space: nowrap;
            transform-origin: left center;
        }

        .teacher-name-cell {
            white-space: nowrap !important;
            overflow: hidden;
            text-overflow: clip;
            padding: 3px 6px !important;
            max-width: 170px;
        }

        .teacher-name-inner {
            display: inline-block;
            white-space: nowrap;
            transform-origin: left center;
        }

        /* Grand Total Row */
        .total-row td {
            font-weight: 700;
            border-top: 1px solid #000;
        }

        /* Signatures Vertical */
        .signatures-container {
            margin-top: 30px;
            margin-bottom: 10px;
            margin-left: auto;
            margin-right: auto;
            width: 480px;
            max-width: 100%;
            display: flex;
            flex-direction: column;
            gap: 22px;
            page-break-inside: avoid;
        }

        .sig-row {
            display: flex;
            align-items: flex-end;
            white-space: nowrap;
        }

        .sig-lead {
            font-weight: normal;
            white-space: nowrap;
        }

        .sig-dots {
            flex: 1;
            border-bottom: 1px dotted #000;
            margin: 0 10px 3px 6px;
            height: 1px;
        }

        .sig-role {
            width: 170px;
            text-align: left;
            white-space: nowrap;
            font-weight: normal;
        }

        /* Print Media Styles */
        @media print {
            body {
                background: none;
                padding: 0;
                margin: 0;
            }

            .no-print-bar {
                display: none !important;
            }

            .sheet-container {
                box-shadow: none;
                padding: 0;
                margin: 0;
                max-width: 100%;
                border-radius: 0;
            }

            table.schedule-table th {
                background-color: #ffffff !important;
            }

            tr {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

    <!-- Top Action Bar (No Print) -->
    <div class="no-print-bar">
        <div>
            <strong><?= esc($group_name ?? 'กลุ่มสาระการเรียนรู้') ?></strong>
            <span style="color: #666; margin-left: 8px;">(ภาคเรียนที่ <?= esc($term) ?>/<?= esc($year) ?>)</span>
        </div>
        <div style="display: flex; gap: 10px;">
            <button onclick="window.print()" class="btn-print">
                <i class="bi bi-printer"></i> พิมพ์เอกสารทั้งหมด
            </button>
            <button onclick="window.close()" class="btn-close-win">
                ปิดหน้าต่าง
            </button>
        </div>
    </div>

    <!-- Printable Sheet -->
    <div class="sheet-container">

        <!-- Document Header -->
        <div class="doc-header">
            <div class="doc-title">
                ข้อมูลการจัดตารางสอน<?= esc($group_name ?? 'กลุ่มสาระการเรียนรู้') ?> ภาคเรียนที่ <?= esc($term) ?> ปีการศึกษา <?= esc($year) ?>
            </div>
            <div class="school-name">
                <?= esc($school->SchoolName ?? 'โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์') ?>
            </div>
        </div>

        <!-- Main Teaching Schedule Table -->
        <table class="schedule-table">
            <thead>
                <tr>
                    <th style="width: 32px;">ที่</th>
                    <th style="width: 160px;">ครูผู้สอน</th>
                    <th style="width: 65px;">รหัสวิชา</th>
                    <th>รายวิชา</th>
                    <th style="width: 50px;">พื้นฐาน</th>
                    <th style="width: 50px;">เพิ่มเติม</th>
                    <th style="width: 55px;">หน่วยกิต</th>
                    <th style="width: 55px;">ชั่วโมง/<br>สัปดาห์</th>
                    <th style="width: 45px;">ชั้น</th>
                    <th style="width: 50px;">ห้อง</th>
                    <th style="width: 45px;">รวม</th>
                    <th style="width: 75px;">หมายเหตุ</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($rows)): ?>
                <tr>
                    <td colspan="12" class="text-center" style="padding: 30px;">
                        ไม่พบข้อมูลการจัดตารางสอนในภาคเรียนนี้
                    </td>
                </tr>
                <?php else: ?>
                <?php 
                    $currentTeacherId = null;
                    foreach ($rows as $r): 
                ?>
                <tr>
                    <!-- ลำดับที่ (1, 2, 3...) (rowspan ตามจำนวนวิชาของครูท่านนั้น) -->
                    <?php if ($r['is_first_sub']): ?>
                        <td rowspan="<?= $r['rowspan'] ?>" class="text-center" style="vertical-align: middle;"><?= $r['row_no'] ?></td>
                    <?php endif; ?>

                    <!-- ครูผู้สอน (rowspan ตามจำนวนวิชาของครูท่านนั้น ห้ามขึ้นบรรทัดใหม่ ย่อขนาดอัตโนมัติ) -->
                    <?php if ($r['is_first_sub']): ?>
                        <td rowspan="<?= $r['rowspan'] ?>" class="teacher-name-cell" style="vertical-align: middle;">
                            <span class="teacher-name-inner" title="<?= esc($r['teacher_name']) ?>">
                                <strong><?= esc($r['teacher_name']) ?></strong>
                            </span>
                        </td>
                    <?php endif; ?>

                    <!-- รหัสวิชา -->
                    <td class="text-center" style="white-space: nowrap;"><?= esc($r['subject_code']) ?></td>

                    <!-- รายวิชา (ห้ามขึ้นบรรทัดใหม่ ย่อขนาดอัตโนมัติ) -->
                    <td class="text-start subject-name-cell">
                        <span class="subject-name-inner" title="<?= esc($r['subject_name']) ?>"><?= esc($r['subject_name']) ?></span>
                    </td>

                    <!-- เครื่องหมาย พื้นฐาน / -->
                    <td class="text-center">
                        <?= $r['is_basic'] ? '/' : '' ?>
                    </td>

                    <!-- เครื่องหมาย เพิ่มเติม / -->
                    <td class="text-center">
                        <?= $r['is_additional'] ? '/' : '' ?>
                    </td>

                    <!-- หน่วยกิต -->
                    <td class="text-center"><?= ($r['credit'] !== '-' && is_numeric($r['credit'])) ? number_format((float)$r['credit'], 1) : esc($r['credit']) ?></td>

                    <!-- ชั่วโมง/สัปดาห์ -->
                    <td class="text-center"><?= ($r['hours_per_week'] > 0) ? (float)$r['hours_per_week'] : '-' ?></td>

                    <!-- ชั้น (เช่น ม.1, ม.4) -->
                    <td class="text-center"><?= esc($r['grade_level']) ?></td>

                    <!-- ห้อง (เช่น 6, 1-3, PAP) -->
                    <td class="text-center" style="white-space: nowrap;"><?= esc($r['room_text']) ?></td>

                    <!-- รวม (คาบต่อสัปดาห์ x จำนวนห้อง) -->
                    <td class="text-center"><?= ($r['total_weekly_hours'] > 0) ? (float)$r['total_weekly_hours'] : '-' ?></td>

                    <!-- หมายเหตุ -->
                    <td class="text-start"><?= esc($r['remark']) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>

                <!-- แถวรวมจำนวนคาบสอนทั้งสิ้น -->
                <tr class="total-row">
                    <td colspan="10" class="text-end" style="padding-right: 15px;">
                        <strong>รวมจำนวนคาบสอน</strong>
                    </td>
                    <td class="text-center">
                        <strong><?= $total_hours ?></strong>
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <!-- Signatures (แบบ 3 ตำแหน่งตามเอกสาร) -->
        <div class="signatures-container">
            <div class="sig-row">
                <span class="sig-lead">ลงชื่อ</span>
                <span class="sig-dots"></span>
                <span class="sig-role">หัวหน้ากลุ่มสาระการเรียนรู้</span>
            </div>
            <div class="sig-row">
                <span class="sig-lead">ลงชื่อ</span>
                <span class="sig-dots"></span>
                <span class="sig-role">รองผู้อำนวยการฝ่ายวิชาการ</span>
            </div>
            <div class="sig-row">
                <span class="sig-lead">ลงชื่อ</span>
                <span class="sig-dots"></span>
                <span class="sig-role">ผู้อำนวยการสถานศึกษา</span>
            </div>
        </div>

    </div>

    <script>
    // ปรับลดขนาดตัวอักษรของชื่อวิชา และชื่อครูผู้สอนโดยอัตโนมัติหากข้อความยาวเกินความกว้างของช่อง เพื่อไม่ให้ตัดขึ้นบรรทัดใหม่
    function adjustFontSizes() {
        // 1. ปรับขนาดชื่อวิชา
        document.querySelectorAll('.subject-name-cell').forEach(cell => {
            const inner = cell.querySelector('.subject-name-inner');
            if (!inner) return;

            inner.style.fontSize = '15pt';
            inner.style.letterSpacing = 'normal';

            const maxWidth = cell.clientWidth - 8;
            let currentWidth = inner.scrollWidth;

            if (currentWidth > maxWidth && maxWidth > 0) {
                let scaleRatio = maxWidth / currentWidth;
                let newSize = Math.max(15 * scaleRatio, 11);
                inner.style.fontSize = newSize.toFixed(1) + 'pt';

                if (inner.scrollWidth > maxWidth) {
                    inner.style.letterSpacing = '-0.3px';
                }
            }
        });

        // 2. ปรับขนาดชื่อครูผู้สอน
        document.querySelectorAll('.teacher-name-cell').forEach(cell => {
            const inner = cell.querySelector('.teacher-name-inner');
            if (!inner) return;

            inner.style.fontSize = '15pt';
            inner.style.letterSpacing = 'normal';

            const maxWidth = cell.clientWidth - 10;
            let currentWidth = inner.scrollWidth;

            if (currentWidth > maxWidth && maxWidth > 0) {
                let scaleRatio = maxWidth / currentWidth;
                let newSize = Math.max(15 * scaleRatio, 11);
                inner.style.fontSize = newSize.toFixed(1) + 'pt';

                if (inner.scrollWidth > maxWidth) {
                    inner.style.letterSpacing = '-0.3px';
                }
            }
        });
    }

    window.addEventListener('DOMContentLoaded', adjustFontSizes);
    window.addEventListener('resize', adjustFontSizes);
    window.addEventListener('beforeprint', adjustFontSizes);
    </script>
</body>
</html>
