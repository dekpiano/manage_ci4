<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">
            <span class="text-muted fw-light">งานวิชาการ /</span> รายงานการส่งแผนการสอน
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= site_url('Admin/Home') ?>">หน้าหลัก</a></li>
                <li class="breadcrumb-item active">รายงานการส่งแผน</li>
            </ol>
        </nav>
    </div>

    <!-- Filter Card -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0 text-white"><i class="bx bx-filter-alt me-2"></i>ตัวกรองข้อมูล</h5>
        </div>
        <div class="card-body mt-3">
            <form action="<?= current_url() ?>" method="get" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="year_term" class="form-label">ปีการศึกษา / ภาคเรียน</label>
                    <select id="year_term" class="form-select" onchange="updateHiddenFields()">
                        <?php foreach($year_terms as $yt): ?>
                            <?php $val = $yt->seplan_year . '/' . $yt->seplan_term; ?>
                            <option value="<?= $val ?>" <?= ($sel_year.'/'.$sel_term == $val) ? 'selected' : '' ?>>
                                <?= $yt->seplan_year ?> / <?= $yt->seplan_term ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <!-- Split inputs for controller -->
                    <input type="hidden" name="year" id="input_year" value="<?= $sel_year ?>">
                    <input type="hidden" name="term" id="input_term" value="<?= $sel_term ?>">
                </div>
                <div class="col-md-4">
                    <label for="group" class="form-label">กลุ่มสาระการเรียนรู้</label>
                    <select name="group" id="group" class="form-select">
                        <option value="">-- กรุณาเลือกกลุ่มสาระฯ --</option>
                        <?php foreach($groups as $g): ?>
                            <option value="<?= $g->lear_id ?>" <?= ($sel_group == $g->lear_id) ? 'selected' : '' ?>>
                                <?= $g->lear_namethai ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="type" class="form-label">ประเภทเอกสาร (Optionally Filter)</label>
                    <select name="type" id="type" class="form-select">
                        <option value="">-- ทั้งหมด --</option>
                        <option value="1" <?= ($sel_type == '1') ? 'selected' : '' ?>>แบบตรวจแผนการจัดการเรียนรู้</option>
                        <option value="2" <?= ($sel_type == '2') ? 'selected' : '' ?>>บันทึกตรวจใช้แผน</option>
                        <option value="3" <?= ($sel_type == '3') ? 'selected' : '' ?>>โครงการสอน</option>
                        <option value="4" <?= ($sel_type == '4') ? 'selected' : '' ?>>แผนการสอนหน้าเดียว</option>
                        <option value="5" <?= ($sel_type == '5') ? 'selected' : '' ?>>บันทึกหลังสอน</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bx bx-search me-1"></i> ค้นหา
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Report Table -->
    <?php if(!empty($sel_group) && !empty($report_data)): ?>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bx bx-table me-2"></i>
                รายงานสถานะการส่งแผน - <?= esc($sel_group_name ?? '') ?> (<?= count($report_data) ?> รายการ)
            </h5>
            <?php
                // Map type number to document name
                $docTypeName = 'ทะเบียนส่งแผนการสอน';
                switch($sel_type) {
                    case '1': $docTypeName = 'ทะเบียนส่งแบบตรวจแผนการจัดการเรียนรู้'; break;
                    case '2': $docTypeName = 'ทะเบียนส่งบันทึกตรวจใช้แผน'; break;
                    case '3': $docTypeName = 'ทะเบียนส่งโครงการสอน'; break;
                    case '4': $docTypeName = 'ทะเบียนส่งแผนการสอนหน้าเดียว'; break;
                    case '5': $docTypeName = 'ทะเบียนส่งบันทึกหลังสอน'; break;
                }
            ?>
            <button type="button" class="btn btn-success" onclick="exportTableToExcel('reportTable', 'รายงานการส่งแผน_<?= $sel_group_name ?>_<?= $sel_year ?>_<?= $sel_term ?>', '<?= $docTypeName ?>', '<?= $sel_group_name ?>', '<?= $sel_term ?>', '<?= $sel_year ?>')">
                <i class="bx bx-download me-1"></i> ดาวน์โหลด Excel
            </button>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered table-hover table-striped" id="reportTable">
                <thead class="table-light text-center align-middle">
                    <tr>
                        <th style="width: 5%">ที่</th>
                        <th style="width: 20%">ชื่อ-สกุล</th>
                        <th style="width: 10%">รหัสวิชา</th>
                        <th style="width: 20%">ชื่อวิชา</th>
                        <th style="width: 5%">ระดับ</th>
                        <th style="width: 10%">ประเภท</th>
                        <!-- 5 Check Columns -->
                        <th style="width: 15%">วันที่ส่งแผน</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($report_data as $index => $row): ?>
                    <tr>
                        <td class="text-center"><?= $index + 1 ?></td>
                        <td><?= esc($row->pers_prefix . $row->pers_firstname . ' ' . $row->pers_lastname) ?></td>
                        <td class="text-center"><?= esc($row->seplan_coursecode) ?></td>
                        <td><?= esc($row->seplan_namesubject) ?></td>
                        <td class="text-center">ม.<?= esc($row->seplan_gradelevel) ?></td>
                        <td class="text-center"><?= esc($row->subject_type) ?></td>
                        <td class="text-center">
                            <?php 
                                if (!empty($row->seplan_createdate) && $row->seplan_createdate != '0000-00-00' && $row->seplan_createdate != '0000-00-00 00:00:00') {
                                    $ts = strtotime($row->seplan_createdate);
                                    echo date('d/m/', $ts) . (date('Y', $ts) + 543) . ' ' . date('H:i', $ts);
                                } else {
                                    echo '-';
                                }
                            ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php elseif(!empty($sel_group)): ?>
        <div class="alert alert-warning text-center mt-3" role="alert">
            <i class="bx bx-info-circle me-1"></i> ไม่พบข้อมูลการส่งแผนในกลุ่มสาระและปีการศึกษานี้
        </div>
    <?php endif; ?>

</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<!-- xlsx-js-style Library for Excel Export with Styling -->
<script src="https://cdn.jsdelivr.net/npm/xlsx-js-style@1.2.0/dist/xlsx.bundle.js"></script>
<script>
    function updateHiddenFields() {
        const val = document.getElementById('year_term').value;
        const [year, term] = val.split('/');
        document.getElementById('input_year').value = year;
        document.getElementById('input_term').value = term;
    }

    // Excel Export Function using xlsx-js-style with TH Sarabun Font
    function exportTableToExcel(tableID, filename = '', docType = '', groupName = '', term = '', year = ''){
        // Get table element
        const table = document.getElementById(tableID);
        const colCount = table.querySelectorAll('thead th').length;
        
        // Thai Government Standard Styles
        const titleStyle = {
            font: { name: 'TH Sarabun New', sz: 18, bold: true },
            alignment: { horizontal: 'center', vertical: 'center' }
        };
        const subTitleStyle = {
            font: { name: 'TH Sarabun New', sz: 16, bold: true },
            alignment: { horizontal: 'center', vertical: 'center' }
        };
        const headerStyle = {
            font: { name: 'TH Sarabun New', sz: 16, bold: true },
            alignment: { horizontal: 'center', vertical: 'center', wrapText: true },
            border: {
                top: { style: 'thin', color: { rgb: '000000' } },
                bottom: { style: 'thin', color: { rgb: '000000' } },
                left: { style: 'thin', color: { rgb: '000000' } },
                right: { style: 'thin', color: { rgb: '000000' } }
            },
            fill: { fgColor: { rgb: 'D9E1F2' } }
        };
        const bodyStyle = {
            font: { name: 'TH Sarabun New', sz: 16 },
            alignment: { vertical: 'center' },
            border: {
                top: { style: 'thin', color: { rgb: '000000' } },
                bottom: { style: 'thin', color: { rgb: '000000' } },
                left: { style: 'thin', color: { rgb: '000000' } },
                right: { style: 'thin', color: { rgb: '000000' } }
            }
        };
        const bodyCenterStyle = {
            font: { name: 'TH Sarabun New', sz: 16 },
            alignment: { horizontal: 'center', vertical: 'center' },
            border: {
                top: { style: 'thin', color: { rgb: '000000' } },
                bottom: { style: 'thin', color: { rgb: '000000' } },
                left: { style: 'thin', color: { rgb: '000000' } },
                right: { style: 'thin', color: { rgb: '000000' } }
            }
        };
        
        // Extract data from table
        const wb = XLSX.utils.book_new();
        const ws_data = [];
        
        // ===== ADD HEADER TITLE (3 rows) =====
        // Row 1: Document Type Title (18pt Bold)
        const titleRow1 = [docType || 'ทะเบียนส่งแผนการสอน'];
        for(let i = 1; i < colCount; i++) titleRow1.push('');
        ws_data.push(titleRow1);
        
        // Row 2: Learning Group Name (16pt Bold)
        const titleRow2 = ['กลุ่มสาระการเรียนรู้' + (groupName || '')];
        for(let i = 1; i < colCount; i++) titleRow2.push('');
        ws_data.push(titleRow2);
        
        // Row 3: Term and Year (16pt Bold)
        const titleRow3 = ['ภาคเรียนที่ ' + (term || '-') + ' ปีการศึกษา ' + (year || '-')];
        for(let i = 1; i < colCount; i++) titleRow3.push('');
        ws_data.push(titleRow3);
        
        // Empty row for spacing
        const emptyRow = [];
        for(let i = 0; i < colCount; i++) emptyRow.push('');
        ws_data.push(emptyRow);
        
        // ===== ADD TABLE HEADER =====
        const headerRow = [];
        const headers = table.querySelectorAll('thead th');
        headers.forEach(th => {
            headerRow.push(th.innerText.trim());
        });
        ws_data.push(headerRow);
        
        // ===== ADD DATA ROWS =====
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const rowData = [];
            const cells = row.querySelectorAll('td');
            cells.forEach(cell => {
                rowData.push(cell.innerText.trim());
            });
            ws_data.push(rowData);
        });
        
        // Create worksheet from data array
        const ws = XLSX.utils.aoa_to_sheet(ws_data);
        
        // ===== APPLY STYLES =====
        const range = XLSX.utils.decode_range(ws['!ref']);
        
        for(let R = range.s.r; R <= range.e.r; ++R) {
            for(let C = range.s.c; C <= range.e.c; ++C) {
                const cellAddress = XLSX.utils.encode_cell({ r: R, c: C });
                if(!ws[cellAddress]) ws[cellAddress] = { v: '' };
                
                // Apply styles based on row
                if(R === 0) {
                    // Title row 1 (Document Type - 18pt Bold Centered)
                    ws[cellAddress].s = titleStyle;
                } else if(R === 1 || R === 2) {
                    // Title rows 2-3 (16pt Bold Centered)
                    ws[cellAddress].s = subTitleStyle;
                } else if(R === 4) {
                    // Table Header row (16pt Bold with border and background)
                    ws[cellAddress].s = headerStyle;
                } else if(R > 4) {
                    // Data rows (16pt with border)
                    // Center for columns: ที่(0), รหัสวิชา(2), ระดับ(4), ประเภท(5), วันที่ส่งแผน(6)
                    if(C === 0 || C === 2 || C === 4 || C === 5 || C === 6) {
                        ws[cellAddress].s = bodyCenterStyle;
                    } else {
                        ws[cellAddress].s = bodyStyle;
                    }
                }
            }
        }
        
        // ===== MERGE CELLS for Title Rows =====
        ws['!merges'] = [
            { s: { r: 0, c: 0 }, e: { r: 0, c: colCount - 1 } }, // Row 1
            { s: { r: 1, c: 0 }, e: { r: 1, c: colCount - 1 } }, // Row 2
            { s: { r: 2, c: 0 }, e: { r: 2, c: colCount - 1 } }, // Row 3
        ];
        
        // Set column widths
        const colWidths = [
            { wch: 6 },   // ที่
            { wch: 28 },  // ชื่อ-สกุล
            { wch: 14 },  // รหัสวิชา
            { wch: 35 },  // ชื่อวิชา
            { wch: 8 },   // ระดับ
            { wch: 14 },  // ประเภท
            { wch: 20 },  // วันที่ส่งแผน
        ];
        ws['!cols'] = colWidths;
        
        // Set row heights for title rows
        ws['!rows'] = [
            { hpt: 28 },  // Row 1 - Title (18pt)
            { hpt: 24 },  // Row 2 - Subtitle
            { hpt: 24 },  // Row 3 - Subtitle
            { hpt: 15 },  // Row 4 - Empty
            { hpt: 24 },  // Row 5 - Table Header
        ];
        
        // Add worksheet to workbook
        XLSX.utils.book_append_sheet(wb, ws, "รายงานการส่งแผน");
        
        // Generate filename
        filename = filename ? filename + '.xlsx' : 'รายงานการส่งแผน.xlsx';
        
        // Save file
        XLSX.writeFile(wb, filename);
    }
</script>
<?= $this->endSection() ?>
