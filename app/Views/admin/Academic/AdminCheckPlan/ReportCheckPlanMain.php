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
    .hero-report {
        background: linear-gradient(135deg, var(--primary-emerald) 0%, var(--dark-emerald) 100%);
        border-radius: var(--border-radius);
        padding: 2.5rem;
        color: white;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(21, 163, 98, 0.15);
    }

    .hero-report::after {
        content: '';
        position: absolute;
        bottom: -20%;
        right: -5%;
        width: 300px; height: 300px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        pointer-events: none;
    }

    /* Filter Card */
    .filter-card-premium {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        background: white;
        margin-top: -2rem;
        position: relative;
        z-index: 10;
    }

    .filter-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #eee;
        padding: 1.25rem 1.5rem;
        border-radius: var(--border-radius) var(--border-radius) 0 0;
    }

    /* Table Styling */
    .table-report-premium thead th {
        background-color: #f8f9fa;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #566a7f;
        padding: 1rem;
        border-top: none;
    }

    .btn-emerald {
        background-color: var(--primary-emerald);
        border-color: var(--primary-emerald);
        color: white;
    }
    .btn-emerald:hover {
        background-color: var(--dark-emerald);
        border-color: var(--dark-emerald);
        color: white;
    }

    .text-emerald { color: var(--primary-emerald) !important; }
    .bg-light-emerald { background-color: var(--light-emerald) !important; }

    /* Form Controls */
    .form-select-premium {
        border-radius: 10px;
        border: 1px solid #d9dee3;
        padding: 0.6rem 1rem;
        transition: all 0.2s;
    }
    .form-select-premium:focus {
        border-color: var(--primary-emerald);
        box-shadow: 0 0 0 0.25rem rgba(21, 163, 98, 0.1);
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y animate__animated animate__fadeIn">
    <!-- Hero Header -->
    <div class="hero-report">
        <div class="row align-items-center">
            <div class="col-md-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="<?= site_url('Admin/Home') ?>" class="text-white opacity-75">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">รายงานการส่งแผน</li>
                    </ol>
                </nav>
                <h2 class="fw-bold mb-1 text-white">รายงานสรุปการส่งแผนการสอน</h2>
                <p class="mb-0 text-white opacity-75">
                    <i class="bx bx-file me-1"></i> ตรวจสอบสถิติและข้อมูลการจัดทำแผนการจัดการเรียนรู้รายภาคเรียน
                </p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0 d-none d-md-block">
                <i class='bx bx-bar-chart-alt-2 opacity-25' style="font-size: 8rem;"></i>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card filter-card-premium mb-4">
        <div class="filter-header d-flex align-items-center">
            <div class="bg-light-emerald p-2 rounded me-3">
                <i class="bx bx-filter-alt text-emerald fs-4"></i>
            </div>
            <h5 class="mb-0 fw-bold">กรองข้อมูลรายงาน</h5>
        </div>
        <div class="card-body p-4">
            <form action="<?= current_url() ?>" method="get" class="row g-4 align-items-end">
                <div class="col-md-3">
                    <label for="year_term" class="form-label fw-semibold mb-2">ปีการศึกษา / ภาคเรียน</label>
                    <select id="year_term" class="form-select form-select-premium" onchange="updateHiddenFields()">
                        <?php foreach($year_terms as $yt): ?>
                            <?php $val = $yt->seplan_year . '/' . $yt->seplan_term; ?>
                            <option value="<?= $val ?>" <?= ($sel_year.'/'.$sel_term == $val) ? 'selected' : '' ?>>
                                ปีการศึกษา <?= $yt->seplan_year ?> / ภาคเรียนที่ <?= $yt->seplan_term ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="year" id="input_year" value="<?= $sel_year ?>">
                    <input type="hidden" name="term" id="input_term" value="<?= $sel_term ?>">
                </div>
                <div class="col-md-4">
                    <label for="group" class="form-label fw-semibold mb-2">กลุ่มสาระการเรียนรู้</label>
                    <select name="group" id="group" class="form-select form-select-premium">
                        <option value="">-- กรุณาเลือกกลุ่มสาระฯ --</option>
                        <?php foreach($groups as $g): ?>
                            <option value="<?= $g->lear_id ?>" <?= ($sel_group == $g->lear_id) ? 'selected' : '' ?>>
                                <?= $g->lear_namethai ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="type" class="form-label fw-semibold mb-2">ประเภทเอกสาร</label>
                    <select name="type" id="type" class="form-select form-select-premium">
                        <option value="">-- แสดงทั้งหมด --</option>
                        <option value="1" <?= ($sel_type == '1') ? 'selected' : '' ?>>แบบตรวจแผนการจัดการเรียนรู้</option>
                        <option value="2" <?= ($sel_type == '2') ? 'selected' : '' ?>>บันทึกตรวจใช้แผน</option>
                        <option value="3" <?= ($sel_type == '3') ? 'selected' : '' ?>>โครงการสอน</option>
                        <option value="4" <?= ($sel_type == '4') ? 'selected' : '' ?>>แผนการสอนหน้าเดียว</option>
                        <option value="5" <?= ($sel_type == '5') ? 'selected' : '' ?>>บันทึกหลังสอน</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-emerald w-100 py-2 rounded-pill shadow-sm">
                        <i class="bx bx-search-alt me-1"></i> แสดงรายงาน
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Report Table Section -->
    <?php if(!empty($sel_group) && !empty($report_data)): ?>
    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
        <div class="card-header bg-white py-4 px-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h5 class="mb-1 fw-bold text-dark">
                    <i class="bx bx-list-ul me-2 text-emerald"></i>
                    ผลการส่งแผน - <?= esc($sel_group_name ?? '') ?>
                </h5>
                <p class="text-muted mb-0 small">
                    ภาคเรียนที่ <?= esc($sel_term) ?> | ปีการศึกษา <?= esc($sel_year) ?> 
                    <span class="mx-2">|</span> 
                    <span class="badge bg-label-success px-3">รวม <?= count($report_data) ?> รายการ</span>
                </p>
            </div>
            <?php
                $docTypeName = 'ทะเบียนส่งแผนการสอน';
                switch($sel_type) {
                    case '1': $docTypeName = 'ทะเบียนส่งแบบตรวจแผนการจัดการเรียนรู้'; break;
                    case '2': $docTypeName = 'ทะเบียนส่งบันทึกตรวจใช้แผน'; break;
                    case '3': $docTypeName = 'ทะเบียนส่งโครงการสอน'; break;
                    case '4': $docTypeName = 'ทะเบียนส่งแผนการสอนหน้าเดียว'; break;
                    case '5': $docTypeName = 'ทะเบียนส่งบันทึกหลังสอน'; break;
                }
            ?>
            <button type="button" class="btn btn-outline-success rounded-pill px-4" 
                onclick="exportTableToExcel('reportTable', 'รายงานการส่งแผน_<?= $sel_group_name ?>_<?= $sel_year ?>_<?= $sel_term ?>', '<?= $docTypeName ?>', '<?= $sel_group_name ?>', '<?= $sel_term ?>', '<?= $sel_year ?>')">
                <i class="bx bxs-file-export me-1"></i> ส่งออกไฟล์ Excel
            </button>
        </div>
        
        <div class="table-responsive text-nowrap">
            <table class="table table-hover table-report-premium mb-0" id="reportTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">ที่</th>
                        <th style="width: 25%">ชื่อ-สกุล ครูผู้สอน</th>
                        <th class="text-center" style="width: 10%">รหัสวิชา</th>
                        <th style="width: 25%">ชื่อวิชา</th>
                        <th class="text-center" style="width: 5%">ระดับ</th>
                        <th class="text-center" style="width: 10%">ประเภท</th>
                        <th class="text-center" style="width: 20%">วัน-เวลาที่ส่งข้อมูล</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <?php foreach($report_data as $index => $row): ?>
                    <tr>
                        <td class="text-center align-middle font-monospace"><?= $index + 1 ?></td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3">
                                    <span class="avatar-initial rounded-circle bg-label-secondary"><i class="bx bx-user"></i></span>
                                </div>
                                <span class="fw-bold text-dark"><?= esc($row->pers_prefix . $row->pers_firstname . ' ' . $row->pers_lastname) ?></span>
                            </div>
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge bg-label-primary px-3"><?= esc($row->seplan_coursecode) ?></span>
                        </td>
                        <td class="align-middle fw-semibold"><?= esc($row->seplan_namesubject) ?></td>
                        <td class="text-center align-middle">
                            <span class="badge bg-label-info">ม.<?= esc($row->seplan_gradelevel) ?></span>
                        </td>
                        <td class="text-center align-middle">
                            <small class="text-muted fw-bold"><?= esc($row->subject_type) ?></small>
                        </td>
                        <td class="text-center align-middle">
                            <?php 
                                if (!empty($row->seplan_createdate) && $row->seplan_createdate != '0000-00-00' && $row->seplan_createdate != '0000-00-00 00:00:00') {
                                    $ts = strtotime($row->seplan_createdate);
                                    echo '<div class="fw-bold text-dark">' . date('d/m/', $ts) . (date('Y', $ts) + 543) . '</div>';
                                    echo '<div class="small text-muted">' . date('H:i', $ts) . ' น.</div>';
                                } else {
                                    echo '<span class="text-light-muted">---</span>';
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
        <div class="card border-0 shadow-sm mt-3 animate__animated animate__shakeX" style="border-radius: 16px;">
            <div class="card-body text-center py-5">
                <div class="avatar avatar-xl bg-label-warning mx-auto mb-3">
                    <span class="avatar-initial rounded-circle"><i class="bx bx-info-circle fs-1"></i></span>
                </div>
                <h4 class="fw-bold text-dark">ไม่พบข้อมูลการส่งแผน</h4>
                <p class="text-muted">ยังไม่มีรายการส่งแผนสำหรับกลุ่มสาระและปีการศึกษาที่เลือก</p>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="location.reload();">ลองใหม่อีกครั้ง</button>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center py-5 opacity-50">
            <i class='bx bx-spreadsheet' style="font-size: 5rem;"></i>
            <p class="mt-2 fw-semibold">กรุณาเลือกตัวกรองด้านบนเพื่อแสดงรายงาน</p>
        </div>
    <?php endif; ?>

</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://cdn.jsdelivr.net/npm/xlsx-js-style@1.2.0/dist/xlsx.bundle.js"></script>
<script>
    function updateHiddenFields() {
        const val = document.getElementById('year_term').value;
        const [year, term] = val.split('/');
        document.getElementById('input_year').value = year;
        document.getElementById('input_term').value = term;
    }

    function exportTableToExcel(tableID, filename = '', docType = '', groupName = '', term = '', year = ''){
        const table = document.getElementById(tableID);
        if (!table) return;
        const colCount = table.querySelectorAll('thead th').length;
        
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
        
        const wb = XLSX.utils.book_new();
        const ws_data = [];
        
        ws_data.push([docType || 'ทะเบียนส่งแผนการสอน', '', '', '', '', '', '']);
        ws_data.push(['กลุ่มสาระการเรียนรู้' + (groupName || ''), '', '', '', '', '', '']);
        ws_data.push(['ภาคเรียนที่ ' + (term || '-') + ' ปีการศึกษา ' + (year || '-'), '', '', '', '', '', '']);
        ws_data.push(['', '', '', '', '', '', '']);
        
        const headerRow = [];
        table.querySelectorAll('thead th text').forEach(th => headerRow.push(th.innerText.trim()));
        // Fallback for custom header cells
        if(headerRow.length === 0) {
            table.querySelectorAll('thead th').forEach(th => headerRow.push(th.innerText.trim()));
        }
        ws_data.push(headerRow);
        
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const rowData = [];
            row.querySelectorAll('td').forEach(cell => {
                let cellText = cell.innerText.trim().replace(/\n/g, ' ');
                rowData.push(cellText);
            });
            ws_data.push(rowData);
        });
        
        const ws = XLSX.utils.aoa_to_sheet(ws_data);
        const range = XLSX.utils.decode_range(ws['!ref']);
        
        for(let R = range.s.r; R <= range.e.r; ++R) {
            for(let C = range.s.c; C <= range.e.c; ++C) {
                const cellAddress = XLSX.utils.encode_cell({ r: R, c: C });
                if(!ws[cellAddress]) ws[cellAddress] = { v: '' };
                
                if(R === 0) ws[cellAddress].s = titleStyle;
                else if(R === 1 || R === 2) ws[cellAddress].s = subTitleStyle;
                else if(R === 4) ws[cellAddress].s = headerStyle;
                else if(R > 4) {
                    if(C === 0 || C === 2 || C === 4 || C === 5 || C === 6) ws[cellAddress].s = bodyCenterStyle;
                    else ws[cellAddress].s = bodyStyle;
                }
            }
        }
        
        ws['!merges'] = [
            { s: { r: 0, c: 0 }, e: { r: 0, c: colCount - 1 } },
            { s: { r: 1, c: 0 }, e: { r: 1, c: colCount - 1 } },
            { s: { r: 2, c: 0 }, e: { r: 2, c: colCount - 1 } }
        ];
        
        ws['!cols'] = [
            { wch: 6 }, { wch: 30 }, { wch: 14 }, { wch: 40 }, { wch: 8 }, { wch: 14 }, { wch: 25 }
        ];
        
        XLSX.utils.book_append_sheet(wb, ws, "รายงานการส่งแผน");
        XLSX.writeFile(wb, (filename || 'รายงานการส่งแผน') + '.xlsx');
    }
</script>
<?= $this->endSection() ?>
