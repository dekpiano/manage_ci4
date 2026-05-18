<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
.stat-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}
.stat-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    font-size: 1.5rem;
}
.stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    line-height: 1.2;
}
.stat-label {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 4px;
}
.swal2-container {
    z-index: 9999 !important;
}
.drop-zone {
    border: 2px dashed #15a362 !important;
    border-radius: 8px;
    padding: 30px;
    text-align: center;
    cursor: pointer;
    background: rgba(21, 163, 98, 0.02);
    transition: all 0.2s ease-in-out;
}
.drop-zone:hover, .drop-zone.dragover {
    background: rgba(21, 163, 98, 0.08) !important;
    border-color: #11814e !important;
}
.border-light-success {
    border-color: rgba(21, 163, 98, 0.25) !important;
}
.border-light-success:focus {
    border-color: #15a362 !important;
    box-shadow: 0 0 0 0.25rem rgba(21, 163, 98, 0.25) !important;
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Page Header -->
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">งานหลักสูตร /</span> จัดการตารางเรียน
            </h4>
            <p class="text-muted mb-0">ปีการศึกษา: <strong id="headerYear"><?= isset($YearAll[0]->Year) ? esc($YearAll[0]->Year) : '-' ?></strong></p>
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-success btn-add-schedule" style="background-color: #15a362; border-color: #15a362;">
                <i class="bx bx-plus-circle me-1"></i> เพิ่มตารางเรียนใหม่
            </button>
        </div>
    </div>

    <!-- Dashboard Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Files -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-primary" id="stat-total">0</div>
                            <div class="stat-label">ตารางเรียนทั้งหมด</div>
                        </div>
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bx bx-calendar"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Junior High -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-success" id="stat-m13">0</div>
                            <div class="stat-label">มัธยมต้น (ม.1-3)</div>
                        </div>
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="bx bx-user"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Senior High -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-info" id="stat-m46">0</div>
                            <div class="stat-label">มัธยมปลาย (ม.4-6)</div>
                        </div>
                        <div class="stat-icon bg-info bg-opacity-10 text-info">
                            <i class="bx bx-user-voice"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Files Uploaded -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-warning" id="stat-files">0</div>
                            <div class="stat-label">ไฟล์แนบแล้ว</div>
                        </div>
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bx bx-file"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Section -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-list-ul me-2"></i>รายการตารางเรียน
                    </h5>
                </div>
                <div class="col-auto">
                    <div class="d-flex align-items-center gap-2">
                        <label for="SelYearClassSchedule" class="form-label mb-0 fw-medium">เลือกปี:</label>
                        <select name="SelYearClassSchedule" id="SelYearClassSchedule" class="form-select form-select-sm" style="width: auto; min-width: 140px;">
                            <?php foreach ($YearAll as $key => $v_YearAll) : ?>
                            <option <?= $key === 0 ? "selected" : ""; ?>
                                value="<?= isset($v_YearAll->Year) ? esc($v_YearAll->Year) : '' ?>">
                                <?= isset($v_YearAll->Year) ? esc($v_YearAll->Year) : '' ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="TbClassSchedule">
                    <thead class="table-light">
                        <tr>
                            <th class="cell">ชื่อห้องเรียน</th>
                            <th class="cell">ชั้น/ห้อง</th>
                            <th class="cell">ปีการศึกษา</th>
                            <th class="cell">วันที่ลงข้อมูล</th>
                            <th class="cell text-center">ไฟล์ตารางสอน</th>
                            <th class="cell text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Content -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form Class Schedule -->
<div class="modal fade" id="modalClassSchedule" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom pb-3">
                <h5 class="modal-title d-flex align-items-center" id="modalClassScheduleTitle">
                    <i class="bx bx-calendar-plus text-success me-2 fs-3"></i>
                    <span>เพิ่มตารางเรียนใหม่</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="FormClassSchedule" action="<?= site_url('admin/academic/ConAdminClassSchedule/insert_class_schedule') ?>" method="post" enctype="multipart/form-data" class="FormAddClassSchedule">
                <?= csrf_field() ?>
                <input type="hidden" name="schestu_id" id="schestu_id" value="">
                <div class="modal-body py-4">
                    <!-- ข้อมูลภาคการศึกษา -->
                    <h6 class="text-success fw-bold mb-3 d-flex align-items-center">
                        <span class="badge bg-success bg-opacity-10 text-success me-2">Step 1</span> ข้อมูลภาคการศึกษา
                    </h6>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="schestu_term" class="form-label">ภาคเรียน <span class="text-danger">*</span></label>
                            <select name="schestu_term" id="schestu_term" class="form-select border-light-success">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="schestu_year" class="form-label">ปีการศึกษา <span class="text-danger">*</span></label>
                            <?php $toYear = date("Y", strtotime(date('Y'))) + 543; ?>
                            <select name="schestu_year" id="schestu_year" class="form-select border-light-success">
                                <?php for ($i = $toYear - 2; $i <= $toYear + 2; $i++): ?>
                                <option value="<?= esc($i) ?>" <?= $toYear == $i ? 'selected' : '' ?>><?= esc($i) ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <!-- ข้อมูลห้องเรียน -->
                    <h6 class="text-success fw-bold mb-3 d-flex align-items-center">
                        <span class="badge bg-success bg-opacity-10 text-success me-2">Step 2</span> ข้อมูลห้องเรียน
                    </h6>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="schestu_classname" class="form-label">ชั้น ม. <span class="text-danger">*</span></label>
                            <select name="schestu_classname" id="schestu_classname" class="form-select border-light-success">
                                <?php 
                                for ($g = 1; $g <= 6; $g++) {
                                    for ($r = 1; $r <= 6; $r++) { $room["$g/$r"] = "$g.$r"; }
                                }
                                foreach ($room as $key => $v_ClassRoom): ?>
                                <option value="<?= esc($key) ?>"><?= esc($key) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="schestu_name" class="form-label">ชื่อห้องเรียน (แผนการเรียน) <span class="text-danger">*</span></label>
                            <?php $NameRoom = array('วิทย์-คณิต','วิทย์-เทคโน','ภาษา','การงานอาชีพ','ดนตรี','นาฏศิลป์','ศิลปะ','ฟุตบอล','ฟุตซอล','บาสเกตบอล','วอลเลย์บอล'); ?>
                            <select id="schestu_name" class="form-select border-light-success" name="schestu_name" required>
                                <option value="">เลือกแผนการเรียน</option>
                                <?php foreach ($NameRoom as $key => $v_NameRoom) :?>
                                <option value="<?= esc($v_NameRoom) ?>"><?= esc($v_NameRoom) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- ไฟล์ตารางเรียน -->
                    <h6 class="text-success fw-bold mb-3 d-flex align-items-center">
                        <span class="badge bg-success bg-opacity-10 text-success me-2">Step 3</span> อัปโหลดไฟล์ตารางเรียน
                    </h6>
                    <div class="mb-3">
                        <label class="form-label mb-2">รูป / PDF ตารางเรียน <span class="text-danger">*</span></label>
                        
                        <!-- Drag and Drop Area -->
                        <div id="dropZone" class="drop-zone d-flex flex-column align-items-center justify-content-center">
                            <i class="bx bx-cloud-upload text-success mb-2" style="font-size: 3.5rem;"></i>
                            <p class="mb-1 fw-semibold text-dark text-center" id="dropZoneText">ลากไฟล์มาวางที่นี่ หรือคลิกเพื่อเลือกไฟล์</p>
                            <p class="mb-0 text-muted small text-center">รองรับ PDF, JPG, PNG (ระบบจะแปลง PDF เป็นรูปภาพโดยอัตโนมัติ)</p>
                            <input type="file" name="schestu_filename" id="schestu_filename" accept=".jpg,.jpeg,.png,.pdf" style="display: none;">
                        </div>
                        
                        <!-- Selected File Status Badge -->
                        <div id="fileInfo" class="mt-3 p-3 bg-light rounded border border-success-subtle align-items-center justify-content-between" style="display: none !important;">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-file text-success fs-3 me-2"></i>
                                <div style="max-width: 80%;">
                                    <span class="fw-semibold text-dark d-block text-truncate" id="fileNameDisplay">-</span>
                                    <small class="text-muted" id="fileSizeDisplay">-</small>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-icon btn-text-danger rounded-circle" id="removeFileBtn" title="ลบไฟล์">
                                <i class="bx bx-x fs-4"></i>
                            </button>
                        </div>

                        <!-- Image Preview Area -->
                        <div class="text-center mt-3" id="previewContainer" style="display: none;">
                            <img id="previewImage" src="#" alt="Image Preview" class="img-fluid rounded border p-1" style="max-height: 350px; width: auto;" />
                        </div>
                        <canvas id="pdf-canvas" style="display: none;"></canvas>
                    </div>
                </div>
                <div class="modal-footer border-top pt-3">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x me-1"></i> ยกเลิก
                    </button>
                    <button type="submit" class="btn btn-success" id="btnSubmitForm" style="background-color: #15a362; border-color: #15a362;">
                        <i class="bx bx-check-circle me-1"></i> บันทึกข้อมูล
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://unpkg.com/pdfjs-dist@3.11.174/build/pdf.min.js"></script>
<script>
    // Initialize PDF.js worker
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://unpkg.com/pdfjs-dist@3.11.174/build/pdf.worker.min.js';

    let tableClassSchedule;
    let existingFilename = ''; // Track existing filename for edit mode
    let selectedFile = null; // Global storage for selected file
    const remoteBaseUrl = '<?= getenv('upload.server.baseurl') ?>';

    // Function to trim whitespace from canvas (verbatim from legacy form)
    function trimCanvas(canvas) {
        const context = canvas.getContext('2d');
        const width = canvas.width;
        const height = canvas.height;
        const imgData = context.getImageData(0, 0, width, height);
        const pixels = imgData.data;

        let minX = width, minY = height, maxX = 0, maxY = 0;
        let found = false;

        for (let y = 0; y < height; y++) {
            for (let x = 0; x < width; x++) {
                const index = (y * width + x) * 4;
                const r = pixels[index], g = pixels[index + 1], b = pixels[index + 2];
                if (r < 253 || g < 253 || b < 253) {
                    if (x < minX) minX = x;
                    if (x > maxX) maxX = x;
                    if (y < minY) minY = y;
                    if (y > maxY) maxY = y;
                    found = true;
                }
            }
        }
        if (!found) return canvas;

        const padding = 15;
        minX = Math.max(0, minX - padding); minY = Math.max(0, minY - padding);
        maxX = Math.min(width, maxX + padding); maxY = Math.min(height, maxY + padding);

        const cropWidth = maxX - minX, cropHeight = maxY - minY;
        const croppedCanvas = document.createElement('canvas');
        croppedCanvas.width = cropWidth; croppedCanvas.height = cropHeight;
        const croppedContext = croppedCanvas.getContext('2d');
        croppedContext.fillStyle = '#FFFFFF';
        croppedContext.fillRect(0, 0, cropWidth, cropHeight);
        croppedContext.drawImage(canvas, minX, minY, cropWidth, cropHeight, 0, 0, cropWidth, cropHeight);
        return croppedCanvas;
    }

    /**
     * Render ALL pages of PDF then stack vertically (verbatim from legacy form)
     */
    async function renderAllPdfPages(pdfData, scale) {
        const pdf = await pdfjsLib.getDocument(pdfData).promise;
        const numPages = pdf.numPages;
        const pageCanvases = [];

        for (let i = 1; i <= numPages; i++) {
            const page = await pdf.getPage(i);
            const viewport = page.getViewport({ scale: scale });
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            canvas.width = viewport.width;
            canvas.height = viewport.height;
            context.fillStyle = '#FFFFFF';
            context.fillRect(0, 0, canvas.width, canvas.height);
            await page.render({ canvasContext: context, viewport: viewport }).promise;
            pageCanvases.push(canvas);
        }

        if (pageCanvases.length === 1) {
            return trimCanvas(pageCanvases[0]);
        }

        const maxWidth = Math.max(...pageCanvases.map(c => c.width));
        const totalHeight = pageCanvases.reduce((sum, c) => sum + c.height, 0);
        const gap = 10;
        const finalCanvas = document.createElement('canvas');
        finalCanvas.width = maxWidth;
        finalCanvas.height = totalHeight + (gap * (pageCanvases.length - 1));
        const finalCtx = finalCanvas.getContext('2d');
        finalCtx.fillStyle = '#FFFFFF';
        finalCtx.fillRect(0, 0, finalCanvas.width, finalCanvas.height);

        let yOffset = 0;
        for (const pc of pageCanvases) {
            const xOffset = Math.round((maxWidth - pc.width) / 2);
            finalCtx.drawImage(pc, xOffset, yOffset);
            yOffset += pc.height + gap;
        }

        return finalCanvas;
    }

    // Update Dashboard Stats
    function updateStats(data) {
        if (!data || !Array.isArray(data)) return;

        const total = data.length;
        const m13 = data.filter(row => {
            let cls = (row.schestu_classname || '');
            return cls.match(/^[1-3]\//);
        }).length;
        
        const m46 = data.filter(row => {
            let cls = (row.schestu_classname || '');
            return cls.match(/^[4-6]\//);
        }).length;

        const files = data.filter(row => row.schestu_filename && row.schestu_filename !== '').length;

        $('#stat-total').fadeOut(150, function() { $(this).text(total).fadeIn(150); });
        $('#stat-m13').fadeOut(150, function() { $(this).text(m13).fadeIn(150); });
        $('#stat-m46').fadeOut(150, function() { $(this).text(m46).fadeIn(150); });
        $('#stat-files').fadeOut(150, function() { $(this).text(files).fadeIn(150); });
    }

    function loadClassSchedule(year) {
        if ($.fn.DataTable.isDataTable('#TbClassSchedule')) {
            $('#TbClassSchedule').DataTable().destroy();
        }

        tableClassSchedule = $('#TbClassSchedule').DataTable({
            responsive: true,
            processing: true,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/th.json"
            },
            ajax: {
                url: '<?= site_url('admin/academic/ConAdminClassSchedule/getDataByYear') ?>',
                type: 'POST',
                data: { year: year },
                dataSrc: function(json) {
                    if (json.error) {
                        Swal.fire({
                            icon: 'info',
                            title: 'ไม่พบข้อมูล',
                            text: 'ยังไม่มีข้อมูลตารางเรียนสำหรับปีที่เลือก',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        updateStats([]);
                        return [];
                    }
                    let rows = (json.data) ? json.data : json;
                    updateStats(rows);
                    return rows;
                }
            },
            columns: [
                { 
                    data: 'schestu_name',
                    render: function(data) {
                        return '<span class="fw-bold text-primary">' + data + '</span>';
                    }
                },
                { 
                    data: 'schestu_classname',
                    render: function(data) {
                        return '<span class="badge bg-label-info">' + data + '</span>';
                    }
                },
                { 
                    data: 'schestu_year',
                    render: function(data) {
                        return '<span class="badge bg-label-warning">' + data + '</span>';
                    }
                },
                { 
                    data: 'schestu_datetime',
                    render: function(data) {
                        // Display year in Thai Buddhist Era format if it contains date
                        let displayDate = data;
                        try {
                            if(data) {
                                let parts = data.split(' ');
                                let dateParts = parts[0].split('-');
                                if(dateParts.length === 3) {
                                    let thYear = parseInt(dateParts[0]) + 543;
                                    displayDate = dateParts[2] + '/' + dateParts[1] + '/' + thYear + (parts[1] ? ' ' + parts[1] : '');
                                }
                            }
                        } catch(e) {}
                        return '<small class="text-muted"><i class="bx bx-time me-1"></i>' + displayDate + '</small>'; 
                    }
                },
                { 
                    data: 'schestu_filename',
                    className: 'text-center',
                    render: function(data, type, row) {
                        if (data) {
                            const fullRemotePath = remoteBaseUrl + row.schestu_year + '/' + row.schestu_term + '/' + data;
                            return '<a href="' + fullRemotePath + '" target="_blank" class="btn btn-sm btn-label-secondary"><i class="bx bx-link-external me-1"></i>ดูไฟล์</a>';
                        }
                        return '<span class="text-muted">-</span>';
                    }
                },
                { 
                    data: 'schestu_id',
                    className: 'text-center',
                    render: function(data, type, row) {
                        return `
                        <div class="dropdown">
                          <button type="button" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item edit-schedule" href="javascript:void(0);" data-id="${data}">
                                <i class="bx bx-edit-alt me-2 text-warning"></i>แก้ไข
                            </a>
                            <a class="dropdown-item delete-schedule" href="javascript:void(0);" data-id="${data}" data-filename="${row.schestu_filename}" data-year="${row.schestu_year}" data-term="${row.schestu_term}">
                                <i class="bx bx-trash me-2 text-danger"></i>ลบ
                            </a>
                          </div>
                        </div>`;
                    }
                }
            ]
        });
    }

    // Modal Control and resets
    function resetFormState() {
        $('#FormClassSchedule')[0].reset();
        $('#schestu_id').val('');
        existingFilename = '';
        selectedFile = null;
        
        // Reset file inputs & displays
        $('#schestu_filename').val('');
        $('#fileInfo').css('display', 'none').hide();
        $('#fileNameDisplay').text('-');
        $('#fileSizeDisplay').text('-');
        
        $('#previewImage').attr('src', '#').hide();
        $('#previewContainer').hide();
        
        // Reset dropzone text
        $('#dropZoneText').text('ลากไฟล์มาวางที่นี่ หรือคลิกเพื่อเลือกไฟล์');

        // Reset submit button state (in case previous upload failed and left it disabled)
        $('#btnSubmitForm').prop('disabled', false);
    }

    function openModalForEdit(rowData) {
        resetFormState();

        // Populate fields
        $('#schestu_id').val(rowData.schestu_id);
        $('#schestu_term').val(rowData.schestu_term);
        $('#schestu_year').val(rowData.schestu_year);
        $('#schestu_classname').val(rowData.schestu_classname);
        $('#schestu_name').val(rowData.schestu_name);
        
        existingFilename = rowData.schestu_filename;

        // Visual tweaks for Edit Mode
        $('#modalClassScheduleTitle span').text('แก้ไขตารางเรียน');
        $('#modalClassScheduleTitle i').removeClass('bx-calendar-plus text-success').addClass('bx-edit text-warning');
        $('#btnSubmitForm').html('<i class="bx bx-check-circle me-1"></i> บันทึกการแก้ไข').removeClass('btn-success').addClass('btn-warning').css({
            'background-color': '#ff9f43',
            'border-color': '#ff9f43'
        });

        // Show existing file if any
        if (existingFilename) {
            $('#fileInfo').css('display', 'flex').show();
            $('#fileNameDisplay').text(existingFilename);
            $('#fileSizeDisplay').text('ไฟล์ปัจจุบันบนเซิร์ฟเวอร์');
            
            const fullRemotePath = remoteBaseUrl + rowData.schestu_year + '/' + rowData.schestu_term + '/' + existingFilename;
            $('#previewImage').attr('src', fullRemotePath).show();
            $('#previewContainer').show();
        }

        $('#modalClassSchedule').modal('show');
    }

    // File Selection Handlers
    function handleFileSelected(file) {
        if (!file) return;

        const fileExt = file.name.split('.').pop().toLowerCase();
        const allowedExts = ['jpg', 'jpeg', 'png', 'pdf'];

        if (!allowedExts.includes(fileExt)) {
            Swal.fire({
                icon: 'error',
                title: 'ไฟล์ไม่รองรับ',
                text: 'กรุณาอัปโหลดไฟล์รูปภาพ (JPG, PNG) หรือไฟล์ PDF เท่านั้น',
                confirmButtonColor: '#dc3545'
            });
            return;
        }

        // Show Info Badge
        $('#fileInfo').css('display', 'flex').show();
        $('#fileNameDisplay').text(file.name);
        const sizeKB = (file.size / 1024).toFixed(1);
        $('#fileSizeDisplay').text(sizeKB + ' KB');

        // Render Preview
        if (fileExt === 'pdf') {
            $('#dropZoneText').text('กำลังโหลดหน้าตัวอย่าง PDF...');
            const reader = new FileReader();
            reader.onload = function() {
                const typedarray = new Uint8Array(this.result);
                renderAllPdfPages(typedarray, 1.5).then(function(resultCanvas) {
                    $('#previewImage').attr('src', resultCanvas.toDataURL('image/jpeg', 0.85)).show();
                    $('#previewContainer').show();
                    $('#dropZoneText').text('อัปโหลดไฟล์เรียบร้อย');
                }).catch(function(err) {
                    console.error('PDF preview error:', err);
                    $('#previewImage').hide();
                    $('#previewContainer').hide();
                    Swal.fire({ icon: 'warning', title: 'ไม่สามารถแสดงตัวอย่าง PDF', text: 'กรุณาลองไฟล์อื่น', timer: 2000, showConfirmButton: false });
                });
            };
            reader.readAsArrayBuffer(file);
        } else {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#previewImage').attr('src', e.target.result).show();
                $('#previewContainer').show();
                $('#dropZoneText').text('อัปโหลดไฟล์เรียบร้อย');
            }
            reader.readAsDataURL(file);
        }
    }

    // Document Events
    $(document).ready(function() {
        let initialYear = $('#SelYearClassSchedule').val();
        $('#headerYear').text(initialYear || '-');
        loadClassSchedule(initialYear);

        // Drag & Drop Handlers
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('schestu_filename');

        dropZone.addEventListener('click', () => fileInput.click());

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.add('dragover');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.remove('dragover');
            }, false);
        });

        dropZone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files.length > 0) {
                selectedFile = files[0];
                handleFileSelected(files[0]);
            }
        });

        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                selectedFile = e.target.files[0];
                handleFileSelected(e.target.files[0]);
            }
        });

        // Remove File Button
        $('#removeFileBtn').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            $('#schestu_filename').val('');
            $('#fileInfo').css('display', 'none').hide();
            $('#previewImage').attr('src', '#').hide();
            $('#previewContainer').hide();
            $('#dropZoneText').text('ลากไฟล์มาวางที่นี่ หรือคลิกเพื่อเลือกไฟล์');
            existingFilename = '';
            selectedFile = null;
        });

        // Add Button Trigger
        $('.btn-add-schedule').on('click', function() {
            resetFormState();
            $('#modalClassScheduleTitle span').text('เพิ่มตารางเรียนใหม่');
            $('#modalClassScheduleTitle i').removeClass('bx-edit text-warning').addClass('bx-calendar-plus text-success');
            $('#btnSubmitForm').html('<i class="bx bx-check-circle me-1"></i> บันทึกข้อมูล').removeClass('btn-warning').addClass('btn-success').css({
                'background-color': '#15a362',
                'border-color': '#15a362'
            });
            $('#modalClassSchedule').modal('show');
        });

        // Edit Button Trigger
        $(document).on('click', '.edit-schedule', function() {
            let id = $(this).data('id');
            let rowData = tableClassSchedule.rows().data().toArray().find(r => r.schestu_id === id);
            if (rowData) {
                openModalForEdit(rowData);
            }
        });

        // Handle URL parameters for legacy redirect actions
        const urlParams = new URLSearchParams(window.location.search);
        const action = urlParams.get('action');
        const actionId = urlParams.get('id');

        if (action === 'add') {
            $('.btn-add-schedule').click();
            // Clear URL param without refreshing
            window.history.replaceState({}, document.title, window.location.pathname);
        } else if (action === 'edit' && actionId) {
            tableClassSchedule.on('draw', function() {
                let rowData = tableClassSchedule.rows().data().toArray().find(r => r.schestu_id === actionId);
                if (rowData) {
                    openModalForEdit(rowData);
                    tableClassSchedule.off('draw');
                }
            });
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    });

    // Handle year change
    $('#SelYearClassSchedule').on('change', function() {
        let selectedYear = $(this).val();
        $('#headerYear').text(selectedYear || '-');
        loadClassSchedule(selectedYear);
    });

    // Delete Action
    $(document).on('click', '.delete-schedule', function() {
        let id = $(this).data('id');
        let filename = $(this).data('filename');
        const year = $(this).data('year');
        const term = $(this).data('term');
        
        Swal.fire({
            title: 'ยืนยันการลบ?',
            text: "ข้อมูลรายวิชาและไฟล์ที่แนบจะถูกลบถาวร",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= site_url('admin/academic/ConAdminClassSchedule/delete_class_schedule') ?>/' + id + '/' + encodeURIComponent(filename) + '/' + year + '/' + term,
                    type: 'POST',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('ลบสำเร็จ!', 'ข้อมูลถูกลบเรียบร้อยแล้ว', 'success');
                            tableClassSchedule.ajax.reload();
                        } else {
                            Swal.fire('เกิดข้อผิดพลาด!', response.message || 'ไม่สามารถลบข้อมูลได้', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('เกิดข้อผิดพลาด!', 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้', 'error');
                    }
                });
            }
        });
    });

    // Modal Form Submit (Upload Proxy + Database Save)
    $(document).on('submit', '#FormClassSchedule', function (e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        const action = $(form).attr('action');
        const submitBtn = $(form).find('button[type="submit"]');
        const originalBtnHtml = submitBtn.html();
        
        const isEditMode = $('#schestu_id').val() !== '';
        
        if (!isEditMode && !selectedFile) {
            Swal.fire({ icon: "error", title: "ผิดพลาด!", text: "กรุณาเลือกไฟล์ตารางเรียน" });
            return;
        }

        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>กำลังส่งข้อมูล...');

        Swal.fire({
            title: 'กำลังประมวลผลไฟล์...',
            html: '<div class="py-3"><div class="spinner-border text-success" style="width: 3rem; height: 3rem;"></div><p class="mt-2 text-dark">ระบบกำลังส่งข้อมูลและอัปโหลดไฟล์ตารางเรียนของคุณ...</p></div>',
            allowOutsideClick: false,
            showConfirmButton: false
        });

        const performSubmit = (blob, fileName) => {
            const chunkSize = 500 * 1024; // 500KB chunks (ลดขนาดเพื่อไม่ให้เกินขีดจำกัด nginx client_max_body_size)
            const fileSize = blob.size;
            const totalChunks = Math.ceil(fileSize / chunkSize);
            let currentChunk = 0;

            const uploadNextChunk = () => {
                const start = currentChunk * chunkSize;
                const end = Math.min(start + chunkSize, fileSize);
                const chunk = blob.slice(start, end);
                
                const remoteUploadFormData = new FormData();
                remoteUploadFormData.append('schestu_filename', chunk, fileName);
                remoteUploadFormData.append('filename', fileName);
                remoteUploadFormData.append('chunk_index', currentChunk);
                remoteUploadFormData.append('total_chunks', totalChunks);
                remoteUploadFormData.append('term', $('#schestu_term').val());
                remoteUploadFormData.append('year', $('#schestu_year').val());

                // Inject CSRF token to pass CodeIgniter security filter check
                const csrfTokenName = '<?= csrf_token() ?>';
                const csrfTokenValue = $('input[name="' + csrfTokenName + '"]').val() || '<?= csrf_hash() ?>';
                remoteUploadFormData.append(csrfTokenName, csrfTokenValue);

                // Update SweetAlert2 progress bar with dynamic progression
                const percent = Math.round((currentChunk / totalChunks) * 100);
                Swal.update({
                    html: '<div class="py-3">' +
                          '<div class="spinner-border text-success mb-2" style="width: 3rem; height: 3rem;"></div>' +
                          '<p class="mt-2 text-dark fw-semibold">กำลังส่งข้อมูลและอัปโหลดไฟล์ตารางเรียน...</p>' +
                          '<div class="progress mt-2 mx-auto" style="height: 10px; max-width: 80%;">' +
                          '  <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: ' + percent + '%" aria-valuenow="' + percent + '" aria-valuemin="0" aria-valuemax="100"></div>' +
                          '</div>' +
                          '<p class="mt-1 text-muted small">กำลังส่งชิ้นส่วนที่ ' + (currentChunk + 1) + '/' + totalChunks + ' (' + percent + '%)</p>' +
                          '</div>'
                });

                $.ajax({
                    url: '<?= site_url('admin/academic/ConAdminClassSchedule/upload_proxy') ?>',
                    type: 'POST',
                    data: remoteUploadFormData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(uploadResponse) {
                        if (uploadResponse.status === 'chunk_saved') {
                            currentChunk++;
                            uploadNextChunk();
                        } else if (uploadResponse.status === 'success' && uploadResponse.filename) {
                            // Update progression to 100%
                            Swal.update({
                                html: '<div class="py-3">' +
                                      '<div class="spinner-border text-success mb-2" style="width: 3rem; height: 3rem;"></div>' +
                                      '<p class="mt-2 text-dark fw-semibold">กำลังส่งข้อมูลและอัปโหลดไฟล์ตารางเรียน...</p>' +
                                      '<div class="progress mt-2 mx-auto" style="height: 10px; max-width: 80%;">' +
                                      '  <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>' +
                                      '</div>' +
                                      '<p class="mt-1 text-muted small">ส่งชิ้นส่วนครบถ้วนแล้ว กำลังบันทึกข้อมูล...</p>' +
                                      '</div>'
                            });

                            const finalFileName = uploadResponse.filename;
                            const dbFormData = new FormData(form);
                            dbFormData.delete('schestu_filename');
                            dbFormData.append('schestu_filename', finalFileName);

                            saveToDatabase(dbFormData, submitBtn, originalBtnHtml);
                        } else {
                            Swal.fire({ icon: "error", title: "อัปโหลดไฟล์ไม่สำเร็จ!", text: uploadResponse.message || "กรุณาลองใหม่", confirmButtonColor: '#dc3545' });
                            submitBtn.prop('disabled', false).html(originalBtnHtml);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Upload chunk error:', {
                            status: xhr.status,
                            statusText: xhr.statusText,
                            responseText: xhr.responseText,
                            error: error
                        });
                        const serverMsg = xhr.responseText ? xhr.responseText.substring(0, 300) : 'ไม่มีข้อมูลจากเซิร์ฟเวอร์';
                        Swal.fire({ 
                            icon: "error", 
                            title: "เกิดข้อผิดพลาด! (HTTP " + xhr.status + ")", 
                            html: "<p>ไม่สามารถอัปโหลดชิ้นส่วนที่ " + (currentChunk+1) + "/" + totalChunks + " ได้</p><pre style='text-align:left;font-size:11px;max-height:200px;overflow:auto;background:#f5f5f5;padding:8px;border-radius:4px;'>" + $('<div>').text(serverMsg).html() + "</pre>", 
                            confirmButtonColor: '#dc3545' 
                        });
                        submitBtn.prop('disabled', false).html(originalBtnHtml);
                    }
                });
            };

            uploadNextChunk();
        };

        // Skip proxy if edit mode and no new file was selected
        if (isEditMode && !selectedFile) {
            const dbFormData = new FormData(form);
            dbFormData.delete('schestu_filename');
            dbFormData.append('schestu_filename', existingFilename);
            saveToDatabase(dbFormData, submitBtn, originalBtnHtml);
            return;
        }

        const file = selectedFile;
        const fileExt = file.name.split('.').pop().toLowerCase();

        if (fileExt === 'pdf') {
            if (typeof pdfjsLib === 'undefined') {
                Swal.close();
                Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: 'ระบบแปลงไฟล์ PDF ไม่พร้อมใช้งาน กรุณาลองใหม่อีกครั้ง' });
                submitBtn.prop('disabled', false).html(originalBtnHtml);
                return;
            }

            const reader = new FileReader();
            reader.onload = function() {
                const typedarray = new Uint8Array(this.result);
                renderAllPdfPages(typedarray, 3.0).then(function(resultCanvas) {
                    resultCanvas.toBlob(function(blob) {
                        if (!blob) {
                            Swal.close();
                            Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: 'ไม่สามารถแปลง PDF เป็นรูปภาพได้' });
                            submitBtn.prop('disabled', false).html(originalBtnHtml);
                            return;
                        }
                        const cleanClassName = $('#schestu_classname').val().replace(/[\/\\]/g, '-');
                        const newFileName = Date.now() + '-' + $('#schestu_year').val() + '-' + $('#schestu_term').val() + '-Room-' + cleanClassName + '.png';
                        performSubmit(blob, newFileName);
                    }, 'image/png');
                }).catch(function(err) {
                    console.error('PDF conversion error:', err);
                    Swal.close();
                    Swal.fire({ icon: 'error', title: 'แปลงไฟล์ PDF ไม่สำเร็จ!', text: 'เกิดข้อผิดพลาด: ' + (err.message || 'ไม่ทราบสาเหตุ'), confirmButtonColor: '#dc3545' });
                    submitBtn.prop('disabled', false).html(originalBtnHtml);
                });
            };
            reader.readAsArrayBuffer(file);
        } else {
            const cleanClassName = $('#schestu_classname').val().replace(/[\/\\]/g, '-');
            const uniqueFileName = Date.now() + '-' + $('#schestu_year').val() + '-' + $('#schestu_term').val() + '-Room-' + cleanClassName + '.jpg';
            
            // Resize and compress regular images before uploading
            const img = new Image();
            const objectUrl = URL.createObjectURL(file);
            img.onload = function() {
                URL.revokeObjectURL(objectUrl);
                const maxWidth = 2000;
                let w = img.width, h = img.height;
                if (w > maxWidth) {
                    h = Math.round(h * (maxWidth / w));
                    w = maxWidth;
                }
                const canvas = document.createElement('canvas');
                canvas.width = w;
                canvas.height = h;
                canvas.getContext('2d').drawImage(img, 0, 0, w, h);
                canvas.toBlob(function(compressedBlob) {
                    performSubmit(compressedBlob, uniqueFileName);
                }, 'image/jpeg', 0.78);
            };
            img.onerror = function() {
                URL.revokeObjectURL(objectUrl);
                performSubmit(file, uniqueFileName);
            };
            img.src = objectUrl;
        }
    });

    function saveToDatabase(dbFormData, submitBtn, originalBtnHtml) {
        $.ajax({
            url: '<?= site_url('admin/academic/ConAdminClassSchedule/insert_class_schedule') ?>',
            type: "POST",
            data: dbFormData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                Swal.close();
                if(response && response.success){
                    Swal.fire({ 
                        icon: "success", 
                        title: "สำเร็จ!", 
                        text: "บันทึกข้อมูลตารางเรียนเรียบร้อยแล้ว", 
                        confirmButtonColor: '#15a362' 
                    }).then(() => {
                        $('#modalClassSchedule').modal('hide');
                        tableClassSchedule.ajax.reload();
                    });
                } else {
                    Swal.fire({ icon: "error", title: "เกิดข้อผิดพลาด!", text: response.error || "เกิดข้อผิดพลาด", confirmButtonColor: '#dc3545' });
                    submitBtn.prop('disabled', false).html(originalBtnHtml);
                }
            },
            error: function () {
                Swal.close();
                Swal.fire({ icon: "error", title: "เกิดข้อผิดพลาด!", text: "ไม่สามารถบันทึกข้อมูลลงฐานข้อมูลได้", confirmButtonColor: '#dc3545' });
                submitBtn.prop('disabled', false).html(originalBtnHtml);
            }
        });
    }
</script>
<?= $this->endSection() ?>