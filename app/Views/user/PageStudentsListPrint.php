<style>
    /* ตั้งค่าคุณสมบัติพื้นฐานสำหรับ mPDF */
    body {
        font-family: 'thsarabun';
        font-size: 12pt;
        color: #333;
        line-height: 1;
    }

    /* การจัดรูปแบบ Header ใหม่ให้ดูสวยงามและเป็นสัดส่วน */
    .header-table {
        width: 100%;
        border: none !important;
        margin-bottom: 12px;
        border-bottom: 2px solid #15a362 !important; /* เส้นกั้นด้านล่างสีหลัก */
        padding-bottom: 8px;
    }

    .header-table td {
        border: none !important;
        padding: 0;
        vertical-align: bottom;
    }

    .title-main {
        font-size: 19pt;
        color: #15a362;
        font-weight: bold;
        margin: 0;
        line-height: 1.1;
    }

    .title-sub {
        font-size: 13pt;
        color: #666;
        margin-top: 4px;
    }

    .advisor-box {
        text-align: right;
        font-size: 11pt;
        line-height: 1.2;
        color: #444;
    }

    .advisor-label {
        font-weight: bold;
        color: #15a362;
        font-size: 10pt;
        text-transform: uppercase;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed; /* บังคับความกว้างคอลัมน์ */
    }

    table, th, td {
        border: 0.1mm solid #000;
    }

    th {
        background-color: #f8f9fa;
        font-size: 12pt;
        font-weight: bold;
        padding: 3px 1px;
        text-align: center;
        vertical-align: middle;
    }

    td {
        padding: 2px 4px;
        font-size: 12pt;
        vertical-align: middle;
        white-space: nowrap; /* ป้องกันข้อมูลขึ้นบรรทัดใหม่ */
        overflow: hidden;
    }

    .text-center { text-align: center; }
    .text-left { text-align: left; }
    
    /* บีบพื้นที่ส่วนซ้ายให้เหลือน้อยที่สุด (รวม ~40%) เพื่อให้ช่องขวากว้างขึ้น (~60%) */
    .col-no { width: 3%; font-size: 8pt; }
    .col-code { width: 7%; font-size: 8pt; }
    .col-name { 
        width: 17%; 
        font-size: 9pt; /* ฟอนต์เล็กเพื่อประหยัดพื้นที่ */
    } 
    .col-line { width: 8%; font-size: 8pt; }
    .col-status { width: 5%; font-size: 8pt; }
    .col-work { width: 1.93%; } /* (60% / 31 ช่อง) = ~1.93% ต่อช่อง */

    .truncate {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
</style>

<table class="header-table">
    <?php 
    $subYear = explode('/',$schoolyear->schyear_year); 
    $SubRoomAll = explode('/',$SubRoom[1]);
    ?>
    <tr>
        <td width="60%">
            <div class="title-main">รายชื่อนักเรียน ชั้นมัธยมศึกษาปีที่ <?=$SubRoomAll[0]?> ห้อง <?=$SubRoomAll[1]?></div>
            <div class="title-sub">ภาคเรียนที่ <?=$subYear[0]?> ปีการศึกษา <?=$subYear[1]?></div>
        </td>
        <td width="40%" class="advisor-box">
            <span class="advisor-label">ครูที่ปรึกษา</span><br>
            <?php foreach ($TeacRoom as $key => $v_TeacRoom) : ?>
                 <?= $v_TeacRoom->pers_prefix.$v_TeacRoom->pers_firstname.' '.$v_TeacRoom->pers_lastname ?><br>
            <?php endforeach; ?>
        </td>
    </tr>
</table>

<table class="table">
    <thead>
        <tr>
            <th class="col-no" rowspan="2">ที่</th>
            <th class="col-code" rowspan="2">เลขประจำตัว</th>
            <th class="col-name" rowspan="2">ชื่อ - นามสกุล</th>
            <th class="col-line" rowspan="2">หลักสูตร</th>
            <th class="col-status" rowspan="2">สถานะ</th>
            <th colspan="31">ตารางงาน/เช็คชื่อ (วันที่ 1 - 31)</th>
        </tr>
        <tr>
            <?php for ($i=1; $i <= 31; $i++) : ?>
            <th class="col-work" style="font-size: 7pt;"><?=$i;?></th>
            <?php endfor; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($selStudent as $key => $v_selStudent) : ?>
        <tr>
            <td class="text-center" style="font-size: 8pt;"><?= $v_selStudent->StudentNumber ?></td>
            <td class="text-center" style="font-size: 8pt;"><?= $v_selStudent->StudentCode ?></td>
            <td class="text-left col-name" style="font-size: 9pt;">
                <?= $v_selStudent->StudentPrefix.$v_selStudent->StudentFirstName.' '.$v_selStudent->StudentLastName ?>
            </td>
            <td class="text-center" style="font-size: 7.5pt;"><?= $v_selStudent->StudentStudyLine ?></td>
            <td class="text-center" style="font-size: 7.5pt;"><?= $v_selStudent->StudentBehavior ?></td>
            <?php for ($i=1; $i <= 31; $i++) : ?>
            <td class="col-work text-center"></td>
            <?php endfor; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>