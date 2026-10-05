<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="https://skj.ac.th/uploads/logo/LogoSKJ_4.png" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Prompt:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        @font-face {
            font-family: 'THSarabunNew';
            src: url('<?= base_url('public/assets/fonts/THSarabunNew.ttf') ?>') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: 'THSarabunNew';
            src: url('<?= base_url('public/assets/fonts/THSarabunNew Bold.ttf') ?>') format('truetype');
            font-weight: bold;
            font-style: normal;
        }

        :root {
            --p-emerald: #15a362;
            --p-emerald-dark: #0f854e;
            --font-doc: 'THSarabunNew', 'Sarabun', -apple-system, sans-serif;
        }

        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #31373e;
            font-family: var(--font-doc);
            color: #000;
            -webkit-font-smoothing: antialiased;
        }

        /* SCREEN TOOLBAR */
        .transcript-toolbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(22, 27, 34, 0.96);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            padding: 10px 20px;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.35);
            font-family: 'Prompt', var(--font-doc);
        }

        .toolbar-left, .toolbar-center, .toolbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-tb {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 13.5px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .btn-tb-primary {
            background-color: var(--p-emerald);
            color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(21, 163, 98, 0.4);
        }
        .btn-tb-primary:hover {
            background-color: var(--p-emerald-dark);
            transform: translateY(-1px);
        }

        .btn-tb-outline {
            background: transparent;
            border-color: rgba(255, 255, 255, 0.3);
            color: #f7fafc !important;
        }
        .btn-tb-outline:hover, .btn-tb-outline.active {
            background: rgba(255, 255, 255, 0.18);
            border-color: #fff;
        }

        .zoom-ctrl {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #e2e8f0;
        }
        .zoom-ctrl select {
            background: #2d3748;
            color: #fff;
            border: 1px solid #4a5568;
            border-radius: 4px;
            padding: 4px 8px;
            font-size: 13px;
            cursor: pointer;
        }

        /* DOCUMENT PAGES WRAPPER */
        .pages-container {
            padding: 24px 0 60px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 30px;
            transition: transform 0.2s ease;
            transform-origin: top center;
        }

        /* EXACT A4 SHEET DIMENSION */
        .transcript-page {
            width: 210mm;
            height: 297mm;
            min-height: 297mm;
            max-height: 297mm;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
            font-family: 'THSarabunNew', 'Sarabun', sans-serif;
            color: #000;
        }

        /* BACKGROUND OFFICIAL TEMPLATE */
        .template-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 210mm;
            height: 297mm;
            z-index: 1;
            pointer-events: none;
            display: block;
        }
        .hide-template .template-bg {
            display: none !important;
        }

        /* OVERLAY DATA LAYER */
        .transcript-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 210mm;
            height: 297mm;
            z-index: 2;
            pointer-events: auto;
        }

        /* PRINT STYLES */
        @page {
            size: A4 portrait;
            margin: 0;
        }

        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .transcript-toolbar {
                display: none !important;
            }
            .pages-container {
                padding: 0 !important;
                gap: 0 !important;
                transform: none !important;
            }
            .transcript-page {
                width: 210mm !important;
                height: 297mm !important;
                min-height: 297mm !important;
                max-height: 297mm !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border: none !important;
                page-break-after: always !important;
                break-after: page !important;
            }
            .transcript-page.page-hide {
                display: none !important;
            }
        }

        /* POSITIONED TEXT ELEMENTS */
        .pos {
            position: absolute;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.15;
            font-size: 14pt;
        }

        /* GRADE COLUMNS */
        .grade-col {
            position: absolute;
            top: 114.2mm;
            width: 64.5mm;
            height: 175mm;
        }
        .grade-item {
            position: absolute;
            width: 100%;
            display: flex;
            align-items: center;
        }
        .grade-item .item-h {
            font-weight: bold;
            text-align: left;
            width: 42.5mm;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        .grade-item .item-name {
            width: 42.5mm;
            text-align: left;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        .grade-item .item-unit {
            position: absolute;
            text-align: center;
            width: 10.5mm;
        }
        .grade-item .item-grade {
            position: absolute;
            text-align: center;
            width: 13.5mm;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <!-- SCREEN NAVIGATION / PRINT TOOLBAR -->
    <header class="transcript-toolbar no-print">
        <div class="toolbar-left">
            <a href="javascript:history.back()" class="btn-tb btn-tb-outline">
                <i class='bx bx-arrow-back'></i> ย้อนกลับ
            </a>
            <div style="font-size: 14.5px; font-weight: 600; color: #fff;">
                ปพ.1 : <?= esc($stu->StudentFirstName . ' ' . $stu->StudentLastName) ?> (<?= esc($stu->StudentCode) ?>)
            </div>
            <span class="badge" style="background: rgba(21, 163, 98, 0.2); color: #4ade80; border: 1px solid rgba(74, 222, 128, 0.4); padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                ระดับ<?= ($Level == 'senior') ? 'มัธยมศึกษาตอนปลาย (ปพ.1 : พ)' : 'มัธยมศึกษาตอนต้น (ปพ.1 : บ)' ?>
            </span>
        </div>

        <div class="toolbar-center">
            <button type="button" class="btn-tb btn-tb-outline active" id="btn-show-all" onclick="setViewMode('all')">
                <i class='bx bx-book-open'></i> ทั้ง 2 หน้า
            </button>
            <button type="button" class="btn-tb btn-tb-outline" id="btn-show-p1" onclick="setViewMode('p1')">
                <i class='bx bx-file'></i> หน้า 1 (ด้านหน้า)
            </button>
            <button type="button" class="btn-tb btn-tb-outline" id="btn-show-p2" onclick="setViewMode('p2')">
                <i class='bx bx-file'></i> หน้า 2 (ด้านหลัง)
            </button>
            <button type="button" class="btn-tb btn-tb-outline" id="btn-toggle-bg" onclick="toggleTemplateBg()" title="สลับโหมดพื้นหลังแบบฟอร์ม">
                <i class='bx bx-layer'></i> <span id="lbl-toggle-bg">ซ่อนแม่แบบ (พิมพ์เฉพาะข้อความ)</span>
            </button>
        </div>

        <div class="toolbar-right">
            <div class="zoom-ctrl">
                <i class='bx bx-zoom-in'></i>
                <select id="zoom-select" onchange="setZoom(this.value)">
                    <option value="0.8">80%</option>
                    <option value="0.9">90%</option>
                    <option value="1.0" selected>100% (A4 เป๊ะ)</option>
                    <option value="1.1">110%</option>
                    <option value="1.25">125%</option>
                </select>
            </div>

            <!-- Switch Level -->
            <?php 
                $otherLevel = ($Level == 'senior') ? 'junior' : 'senior';
                $otherText  = ($Level == 'senior') ? 'ม.ต้น' : 'ม.ปลาย';
            ?>
            <a href="<?= base_url("Admin/Acade/Evaluate/PrintTranscript/{$IdStudent}/{$otherLevel}") ?>" class="btn-tb btn-tb-outline" title="สลับระดับชั้น">
                <i class='bx bx-transfer'></i> สลับดู <?= $otherText ?>
            </a>

            <button type="button" class="btn-tb btn-tb-primary" onclick="window.print()">
                <i class='bx bx-printer'></i> พิมพ์ / บันทึก PDF (Ctrl+P)
            </button>
        </div>
    </header>

    <!-- DOCUMENT PAGES WRAPPER -->
    <main class="pages-container" id="pages-container">

        <!-- ==================== หน้าที่ 1 (FRONT) ==================== -->
        <article class="transcript-page" id="page-1">
            <!-- แม่แบบเอกสารทางการความละเอียดสูง 100% ตรงตามต้นฉบับ -->
            <img src="<?= $tpl_front_url ?>" class="template-bg" alt="ปพ.1 ด้านหน้า">

            <!-- เลเยอร์หยอดข้อความด้วย CSS พิกัดมิลลิเมตรแม่นยำ 100% -->
            <div class="transcript-overlay">
                <!-- ข้อมูลโรงเรียน -->
                <div class="pos" style="left: 23mm; top: 26mm; width: 145mm;">
                    <?= esc($school->SchoolName ?? 'สวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์') ?>
                </div>
                <div class="pos" style="left: 23mm; top: 31.5mm; width: 145mm;">
                    <?= esc($school->WorkPlace ?? 'สำนักงานเขตพื้นที่การศึกษามัธยมศึกษานครสวรรค์') ?>
                </div>
                <div class="pos" style="left: 23mm; top: 37mm; width: 55mm;">
                    <?= esc($school->District ?? 'นครสวรรค์ออก') ?>
                </div>
                <div class="pos" style="left: 23mm; top: 42.5mm; width: 55mm;">
                    <?= esc($school->Prefecture ?? 'เมืองนครสวรรค์') ?>
                </div>
                <div class="pos" style="left: 23mm; top: 48mm; width: 55mm;">
                    <?= esc($school->Province ?? 'นครสวรรค์') ?>
                </div>
                <div class="pos" style="left: 42mm; top: 53.5mm; width: 55mm;">
                    <?= esc($school->Division ?? 'สำนักงานเขตพื้นที่การศึกษามัธยมศึกษานครสวรรค์') ?>
                </div>

                <!-- ข้อมูลนักเรียน -->
                <div class="pos" style="left: 110mm; top: 37mm; width: 62mm;">
                    <?= esc($stu->StudentPrefix . $stu->StudentFirstName) ?>
                </div>
                <div class="pos" style="left: 110mm; top: 42.5mm; width: 62mm;">
                    <?= esc($stu->StudentLastName) ?>
                </div>
                <div class="pos" style="left: 130mm; top: 48mm; width: 42mm;">
                    <?= esc($stu->StudentCode) ?>
                </div>
                <div class="pos" style="left: 130mm; top: 53.5mm; width: 42mm;">
                    <?= esc($stu->StudentIDNumber ?? ($stu->stu_iden ?? '-')) ?>
                </div>

                <!-- วันเข้าเรียน, โรงเรียนเดิม, จังหวัด, ชั้นเรียนสุดท้าย -->
                <div class="pos" style="left: 50mm; top: 59mm; width: 45mm;">
                    <?= esc($d_entrance) ?>
                </div>
                <div class="pos" style="left: 23mm; top: 64.5mm; width: 65mm;">
                    <?= esc($stu->stu_schoolfrom ?? ($stu->StudentOldSchool ?? '-')) ?>
                </div>
                <div class="pos" style="left: 23mm; top: 70mm; width: 65mm;">
                    <?= esc($stu->stu_schoolProvince ?? ($stu->StudentProvince ?? '-')) ?>
                </div>
                <div class="pos" style="left: 28mm; top: 75.5mm; width: 60mm;">
                    <?= esc(($Level == 'senior') ? 'มัธยมศึกษาปีที่ 3' : 'ประถมศึกษาปีที่ 6') ?>
                </div>

                <!-- วันเกิด (วัน เดือน ปี พ.ศ.) -->
                <div class="pos" style="left: 108mm; top: 59mm; width: 15mm; text-align: center;">
                    <?= esc($b_day) ?>
                </div>
                <div class="pos" style="left: 135mm; top: 59mm; width: 32mm; text-align: center;">
                    <?= esc($b_month) ?>
                </div>
                <div class="pos" style="left: 175mm; top: 59mm; width: 18mm; text-align: center;">
                    <?= esc($b_year) ?>
                </div>

                <!-- เพศ, สัญชาติ, ศาสนา -->
                <div class="pos" style="left: 101mm; top: 64.5mm; width: 18mm; text-align: center;">
                    <?= esc($gender) ?>
                </div>
                <div class="pos" style="left: 132mm; top: 64.5mm; width: 22mm; text-align: center;">
                    <?= esc($stu->stu_nationality ?? ($stu->StudentNationality ?? 'ไทย')) ?>
                </div>
                <div class="pos" style="left: 175mm; top: 64.5mm; width: 20mm; text-align: center;">
                    <?= esc($stu->stu_religion ?? 'พุทธ') ?>
                </div>

                <!-- ชื่อ-ชื่อสกุล บิดา มารดา -->
                <div class="pos" style="left: 120mm; top: 70mm; width: 75mm;">
                    <?= esc($father_name) ?>
                </div>
                <div class="pos" style="left: 120mm; top: 75.5mm; width: 75mm;">
                    <?= esc($mother_name) ?>
                </div>

                <!-- รูปถ่ายนักเรียน (ถ้ามี) วางลงในกรอบ 3 x 4 ซม. พอดี -->
                <?php if (!empty($stu->stu_img)): ?>
                    <img src="https://admission.skj.ac.th/uploads/recruitstudent/m<?= ($Level == 'senior') ? '4' : '1' ?>/img/<?= esc($stu->stu_img) ?>" 
                         style="position: absolute; left: 174.5mm; top: 17mm; width: 29.5mm; height: 39.5mm; object-fit: cover; z-index: 3;" 
                         alt="รูปถ่าย" onerror="this.style.display='none';">
                <?php endif; ?>

                <!-- ชุดที่ และ เลขที่ (ถ้ามี) -->
                <?php if (!empty($stu->PW1_Series)): ?>
                    <div class="pos" style="left: 80mm; top: 17.5mm; width: 30mm; text-align: center;">
                        <?= esc($stu->PW1_Series) ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($stu->PW1_No)): ?>
                    <div class="pos" style="left: 125mm; top: 17.5mm; width: 30mm; text-align: center;">
                        <?= esc($stu->PW1_No) ?>
                    </div>
                <?php endif; ?>

                <!-- ตารางผลการเรียน 3 คอลัมน์ (3 ปีการศึกษา) -->
                <?php 
                    $col_x = [7.2, 73.2, 139.3];
                    $off_unit  = [43, 45, 45];
                    $off_grade = [51, 54, 54];
                    $w_name  = 41.5;
                    $w_unit  = 10.5;
                    $w_grade = 13.5;

                    foreach ($columns_results as $c_idx => $col_cfg):
                        $start_x = $col_x[$c_idx];
                        $lh = $col_cfg['line_h'];
                        $fs = $col_cfg['font_sz'];
                        $u_off = $off_unit[$c_idx];
                        $g_off = $off_grade[$c_idx];
                ?>
                    <div class="grade-col" style="left: <?= $start_x ?>mm;">
                        <?php foreach ($col_cfg['items'] as $i_idx => $item): 
                            $curr_top = $i_idx * $lh;
                        ?>
                            <div class="grade-item" style="top: <?= $curr_top ?>mm; height: <?= $lh ?>mm; line-height: <?= $lh ?>mm; font-size: <?= $fs ?>pt;">
                                <?php if ($item['t'] == 's'): ?>
                                    <div class="item-name" style="width: <?= $w_name ?>mm;" title="<?= esc($item['d']->SubjectCode . ' ' . $item['d']->SubjectName) ?>">
                                        <?= esc($item['d']->SubjectCode . ' ' . $item['d']->SubjectName) ?>
                                    </div>
                                    <div class="item-unit" style="left: <?= $u_off ?>mm; width: <?= $w_unit ?>mm;">
                                        <?= number_format(floatval($item['d']->SubjectUnit), 1) ?>
                                    </div>
                                    <div class="item-grade" style="left: <?= $g_off ?>mm; width: <?= $w_grade ?>mm;">
                                        <?= esc($item['d']->Grade) ?>
                                    </div>
                                <?php elseif ($item['t'] == 'h'): ?>
                                    <div class="item-h" style="width: <?= $w_name ?>mm; font-size: <?= $fs + 0.5 ?>pt;">
                                        <?= esc($item['val']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>

                <!-- ลายเซ็นนายทะเบียนด้านล่างคอลัมน์ที่ 3 -->
                <div class="pos" style="left: 133mm; top: 278.5mm; width: 75mm; text-align: center; font-size: 13pt;">
                    (<?= esc($school->RegisName ?? '............................................................') ?>)
                </div>
            </div>
        </article>


        <!-- ==================== หน้าที่ 2 (BACK) ==================== -->
        <article class="transcript-page" id="page-2">
            <!-- แม่แบบเอกสารทางการด้านหลังความละเอียดสูง 100% ตรงตามต้นฉบับ -->
            <img src="<?= $tpl_back_url ?>" class="template-bg" alt="ปพ.1 ด้านหลัง">

            <!-- เลเยอร์หยอดข้อความด้วย CSS พิกัดมิลลิเมตรแม่นยำ 100% -->
            <div class="transcript-overlay">
                <!-- ชุดที่ และ เลขที่ (ถ้ามี) -->
                <?php if (!empty($stu->PW1_Series)): ?>
                    <div class="pos" style="left: 80mm; top: 10.5mm; width: 30mm; text-align: center;">
                        <?= esc($stu->PW1_Series) ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($stu->PW1_No)): ?>
                    <div class="pos" style="left: 125mm; top: 10.5mm; width: 30mm; text-align: center;">
                        <?= esc($stu->PW1_No) ?>
                    </div>
                <?php endif; ?>

                <!-- ผลการประเมินกิจกรรมพัฒนาผู้เรียน (3 ปีการศึกษา) -->
                <?php 
                    $act_rows = [
                        ['name' => 'กิจกรรมแนะแนว', 'h' => '40', 'top' => 41.0],
                        ['name' => 'ลูกเสือ/เนตรนารี/รด.', 'h' => '40', 'top' => 45.5],
                        ['name' => 'กิจกรรมชุมนุม/ชมรม', 'h' => '40', 'top' => 50.0],
                        ['name' => 'กิจกรรมเพื่อสังคมฯ', 'h' => '10', 'top' => 54.5]
                    ];
                    foreach ($col_x as $c_idx => $c_left):
                        $hasData = !empty($columns_results[$c_idx]['items']);
                        if (!$hasData) continue;
                        foreach ($act_rows as $act):
                ?>
                            <div class="pos" style="left: <?= $c_left + 2 ?>mm; top: <?= $act['top'] ?>mm; width: 40mm; font-size: 11pt;">
                                <?= esc($act['name']) ?>
                            </div>
                            <div class="pos" style="left: <?= $c_left + 44 ?>mm; top: <?= $act['top'] ?>mm; width: 9mm; text-align: center; font-size: 11pt;">
                                <?= esc($act['h']) ?>
                            </div>
                            <div class="pos" style="left: <?= $c_left + 54 ?>mm; top: <?= $act['top'] ?>mm; width: 9mm; text-align: center; font-weight: bold; font-size: 11pt;">
                                ผ
                            </div>
                <?php 
                        endforeach;
                    endforeach; 
                ?>

                <!-- ส่วนกลางซ้าย: สรุปผลการประเมิน และ ผลการตัดสิน -->
                <div class="pos" style="left: 68mm; top: 112mm; width: 14mm; text-align: center; font-size: 12.5pt;">
                    <?= number_format($sum_basic_credits_reg, 1) ?>
                </div>
                <div class="pos" style="left: 86mm; top: 112mm; width: 14mm; text-align: center; font-size: 12.5pt;">
                    <?= number_format($sum_basic_credits_pass, 1) ?>
                </div>
                <div class="pos" style="left: 114mm; top: 112mm; width: 22mm; text-align: center; font-size: 12.5pt;">
                    <?= ($sum_basic_credits_pass > 0) ? 'ผ่าน' : '-' ?>
                </div>

                <div class="pos" style="left: 68mm; top: 117mm; width: 14mm; text-align: center; font-size: 12.5pt;">
                    <?= number_format($sum_add_credits_reg, 1) ?>
                </div>
                <div class="pos" style="left: 86mm; top: 117mm; width: 14mm; text-align: center; font-size: 12.5pt;">
                    <?= number_format($sum_add_credits_pass, 1) ?>
                </div>
                <div class="pos" style="left: 114mm; top: 117mm; width: 22mm; text-align: center; font-size: 12.5pt;">
                    <?= ($sum_add_credits_pass > 0) ? 'ผ่าน' : '-' ?>
                </div>

                <!-- การอ่าน คิดวิเคราะห์ -->
                <div class="pos" style="left: 84mm; top: 122mm; width: 18mm; text-align: center; font-size: 12.5pt;">
                    <?= esc($stu->Evaluate_RAW ?? 'ดีเยี่ยม') ?>
                </div>
                <div class="pos" style="left: 114mm; top: 122mm; width: 22mm; text-align: center; font-size: 12.5pt;">
                    ผ่าน
                </div>

                <!-- คุณลักษณะอันพึงประสงค์ -->
                <div class="pos" style="left: 84mm; top: 127mm; width: 18mm; text-align: center; font-size: 12.5pt;">
                    <?= esc($stu->Evaluate_Attribute ?? 'ดีเยี่ยม') ?>
                </div>
                <div class="pos" style="left: 114mm; top: 127mm; width: 22mm; text-align: center; font-size: 12.5pt;">
                    ผ่าน
                </div>

                <!-- กิจกรรมพัฒนาผู้เรียน -->
                <div class="pos" style="left: 84mm; top: 132mm; width: 18mm; text-align: center; font-size: 12.5pt;">
                    <?= esc($stu->Evaluate_Develop ?? 'ผ่าน') ?>
                </div>
                <div class="pos" style="left: 114mm; top: 132mm; width: 22mm; text-align: center; font-size: 12.5pt;">
                    ผ่าน
                </div>

                <!-- วันอนุมัติการจบ, วันออกจากโรงเรียน, สาเหตุ -->
                <div class="pos" style="left: 42mm; top: 139.5mm; width: 85mm; font-size: 12.5pt;">
                    <?= esc($stu->StudentDateApprove ?? '-') ?>
                </div>
                <div class="pos" style="left: 42mm; top: 144.5mm; width: 85mm; font-size: 12.5pt;">
                    <?= esc($stu->StudentDateFinish ?? '-') ?>
                </div>
                <div class="pos" style="left: 45mm; top: 149.5mm; width: 82mm; font-size: 12.5pt;">
                    <?= esc($stu->StudentLeave ?? 'จบการศึกษาตามหลักสูตร') ?>
                </div>

                <!-- ส่วนกลางขวา: กลุ่มสาระการเรียนรู้ (8 กลุ่มสาระ + IS) -->
                <?php 
                    $area_y = 130.0;
                    foreach ($learning_areas as $area_name => $area_val):
                        if ($area_name == 'การศึกษาค้นคว้าด้วยตนเอง (IS)' && $area_val['c'] == 0) {
                            $credits_display = '-';
                            $area_avg = '-';
                        } else {
                            $credits_display = number_format($area_val['c'], 1);
                            $area_avg = $area_val['c'] > 0 ? number_format(floor(($area_val['gp'] / $area_val['c']) * 100) / 100, 2, '.', '') : '0.00';
                        }
                ?>
                    <div class="pos" style="left: 184mm; top: <?= $area_y ?>mm; width: 12mm; text-align: center; font-size: 12pt;">
                        <?= esc($credits_display) ?>
                    </div>
                    <div class="pos" style="left: 194.5mm; top: <?= $area_y ?>mm; width: 14mm; text-align: center; font-size: 12pt;">
                        <?= esc($area_avg) ?>
                    </div>
                <?php 
                        $area_y += 4.7;
                    endforeach; 
                ?>

                <!-- ผลการเรียนเฉลี่ยตลอดหลักสูตร (GPAX) -->
                <div class="pos" style="left: 184mm; top: 174mm; width: 12mm; text-align: center; font-weight: bold; font-size: 12pt;">
                    <?= number_format($sum_credits, 1) ?>
                </div>
                <div class="pos" style="left: 194.5mm; top: 174mm; width: 14mm; text-align: center; font-weight: bold; font-size: 12pt;">
                    <?= esc($gpax) ?>
                </div>

                <!-- สัดส่วนผลการเรียนเฉลี่ยรวม (ด้านล่างซ้าย) -->
                <div class="pos" style="left: 42mm; top: 216mm; width: 25mm; text-align: center; font-weight: bold; font-size: 12pt;">
                    <?= esc($gpax) ?>
                </div>

                <!-- นายทะเบียน ด้านหลัง -->
                <div class="pos" style="left: 130mm; top: 195mm; width: 75mm; text-align: center; font-size: 13pt;">
                    (<?= esc($school->RegisName ?? '............................................................') ?>)
                </div>

                <!-- ผู้อำนวยการสถานศึกษา -->
                <div class="pos" style="left: 130mm; top: 216mm; width: 75mm; text-align: center; font-size: 13pt;">
                    (<?= esc($school->DirectorName ?? '............................................................') ?>)
                </div>
                <div class="pos" style="left: 130mm; top: 228mm; width: 75mm; text-align: center; font-size: 11pt;">
                    <?= esc($school->SchoolName ?? 'โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์') ?>
                </div>

                <!-- วันที่พิมพ์ -->
                <div class="pos" style="left: 130mm; top: 234mm; width: 75mm; text-align: center; font-size: 13pt;">
                    <?= esc($print_date) ?>
                </div>

                <!-- หมายเหตุ (ถ้ามี) -->
                <?php if (!empty($stu->Note)): ?>
                    <div class="pos" style="left: 132mm; top: 254mm; width: 70mm; font-size: 11pt;">
                        <?= esc($stu->Note) ?>
                    </div>
                <?php endif; ?>
            </div>
        </article>

    </main>

    <!-- UI INTERACTIVITY SCRIPT -->
    <script>
        function setViewMode(mode) {
            const p1 = document.getElementById('page-1');
            const p2 = document.getElementById('page-2');
            const bAll = document.getElementById('btn-show-all');
            const bP1 = document.getElementById('btn-show-p1');
            const bP2 = document.getElementById('btn-show-p2');

            bAll.classList.remove('active');
            bP1.classList.remove('active');
            bP2.classList.remove('active');

            if (mode === 'p1') {
                p1.style.display = 'block';
                p2.style.display = 'none';
                p1.classList.remove('page-hide');
                p2.classList.add('page-hide');
                bP1.classList.add('active');
            } else if (mode === 'p2') {
                p1.style.display = 'none';
                p2.style.display = 'block';
                p1.classList.add('page-hide');
                p2.classList.remove('page-hide');
                bP2.classList.add('active');
            } else {
                p1.style.display = 'block';
                p2.style.display = 'block';
                p1.classList.remove('page-hide');
                p2.classList.remove('page-hide');
                bAll.classList.add('active');
            }
        }

        function setZoom(val) {
            const container = document.getElementById('pages-container');
            const scale = parseFloat(val);
            container.style.transform = `scale(${scale})`;
            if (scale > 1.0) {
                container.style.marginBottom = `${(scale - 1) * 600}px`;
            } else {
                container.style.marginBottom = '60px';
            }
        }

        function toggleTemplateBg() {
            const container = document.getElementById('pages-container');
            const lbl = document.getElementById('lbl-toggle-bg');
            const btn = document.getElementById('btn-toggle-bg');

            container.classList.toggle('hide-template');
            if (container.classList.contains('hide-template')) {
                lbl.innerText = 'แสดงแม่แบบ (เต็มรูปแบบ)';
                btn.classList.add('active');
            } else {
                lbl.innerText = 'ซ่อนแม่แบบ (พิมพ์เฉพาะข้อความ)';
                btn.classList.remove('active');
            }
        }
    </script>
</body>
</html>
