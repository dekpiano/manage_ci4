<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <section class="cta-section theme-bg-light py-5">
            <div class="container text-center">

                <h2 class="heading">จัดการข้อมูล<?= isset($title) ? esc($title) : '' ?></h2>

            </div>
        </section>

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- DataTales Example -->
            <div class="row justify-content-lg">
                <div class="col-12">
                    <div class="card card-settings shadow mb-4 ">

                        <div class="card-body p-4">
                            <form action="<?= site_url('admin/academic/ConAdminClassSchedule/'.(isset($action) ? esc($action, 'url') : 'insert_class_schedule'));?>" method="post" enctype="multipart/form-data" class="FormAddClassSchedule">
                                <?= csrf_field() ?>
                                <input type="hidden" name="schestu_id"
                                    value="<?= isset($action) && $action == 'insert_class_schedule' ? (isset($class_schedule) ? esc($class_schedule) : '') : (isset($class_schedule[0]->schestu_id) ? esc($class_schedule[0]->schestu_id) : '') ?>">

                                <fieldset class="mb-3">
                                    <legend class="h6 mb-3">ข้อมูลภาคการศึกษา</legend>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="schestu_term" class="form-label">ภาคเรียน</label>
                                            <select name="schestu_term" id="schestu_term" class="form-select">
                                                <option <?= (isset($class_schedule[0]->schestu_term) && $class_schedule[0]->schestu_term == '1') ? 'selected' : '' ?> value="1">1</option>
                                                <option <?= (isset($class_schedule[0]->schestu_term) && $class_schedule[0]->schestu_term == '2') ? 'selected' : '' ?> value="2">2</option>
                                                <option <?= (isset($class_schedule[0]->schestu_term) && $class_schedule[0]->schestu_term == '3') ? 'selected' : '' ?> value="3">3</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="schestu_year" class="form-label">ปีการศึกษา</label>
                                            <?php $toYear = date("Y",strtotime(date('Y')))+543;?>
                                            <select name="schestu_year" id="schestu_year" class="form-select">
                                                <?php for ($i = $toYear-2; $i <= $toYear+2; $i++): ?>
                                                <option <?= (isset($class_schedule[0]->schestu_year) && $class_schedule[0]->schestu_year == $i) || ($toYear==$i && !isset($class_schedule[0]->schestu_year)) ? 'selected' : '' ?> value="<?= esc($i) ?>"><?= esc($i) ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="mb-3">
                                    <legend class="h6 mb-3">ข้อมูลห้องเรียน</legend>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="schestu_classname" class="form-label">ชั้น ม.</label>
                                            <select name="schestu_classname" id="schestu_classname" class="form-select">
                                                <?php 
                                                for ($g = 1; $g <= 6; $g++) {
                                                    for ($r = 1; $r <= 6; $r++) { $room["$g/$r"] = "$g.$r"; }
                                                }
                                                foreach ($room as $key => $v_ClassRoom): ?>
                                                <option <?= (isset($class_schedule[0]->schestu_classname) && $class_schedule[0]->schestu_classname == $key) ? 'selected' : '' ?> value="<?= esc($key) ?>"><?= esc($key) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="schestu_name" class="form-label">ชื่อห้องเรียน (แผนการเรียน)</label>
                                            <?php $NameRoom = array('วิทย์-คณิต','วิทย์-เทคโน','ภาษา','การงานอาชีพ','ดนตรี','นาฏศิลป์','ศิลปะ','ฟุตบอล','ฟุตซอล','บาสเกตบอล','วอลเลย์บอล'); ?>
                                            <select id="schestu_name" class="form-select" name="schestu_name">
                                                <option value="">เลือกแผนการเรียน</option>
                                                <?php foreach ($NameRoom as $key => $v_NameRoom) :?>
                                                <option <?= (isset($class_schedule[0]->schestu_name) && $class_schedule[0]->schestu_name == $v_NameRoom) ? 'selected' : '' ?> value="<?= esc($v_NameRoom) ?>"><?= esc($v_NameRoom) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="mb-3">
                                    <legend class="h6 mb-3">ไฟล์ตารางเรียน</legend>
                                    <label for="schestu_filename" class="form-label">รูป / PDF ตารางเรียน</label>
                                    <input type="file" class="form-control" name="schestu_filename" id="schestu_filename" accept=".jpg,.jpeg,.png,.pdf" />
                                    <div class="form-text">รองรับ PDF (แปลงเป็นรูปอัตโนมัติ) และไฟล์ภาพ JPG, PNG</div>
                                    <img id="previewImage" src="#" alt="Image Preview" class="img-fluid rounded mt-2 border p-1" style="display:none; max-height: 400px;" />
                                    <canvas id="pdf-canvas" style="display: none;"></canvas>
                                </fieldset>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-lg btn-primary"><i class="bx bx-check-circle"></i> บันทึก</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>




        </div>
        <!-- /.container-fluid -->

    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://unpkg.com/pdfjs-dist@3.11.174/build/pdf.min.js"></script>
<script>
    // Initialize PDF.js worker
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://unpkg.com/pdfjs-dist@3.11.174/build/pdf.worker.min.js';

    // Function to trim whitespace from canvas
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
     * Render ALL pages ของ PDF แล้วต่อเป็นรูปเดียว (แนวตั้ง)
     * @param {Uint8Array} pdfData - ข้อมูล PDF
     * @param {number} scale - ความละเอียด (2.0 = คุณภาพดี)
     * @returns {Promise<HTMLCanvasElement>} - canvas ที่รวมทุกหน้า
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
            // เติมพื้นขาวก่อน render
            context.fillStyle = '#FFFFFF';
            context.fillRect(0, 0, canvas.width, canvas.height);
            await page.render({ canvasContext: context, viewport: viewport }).promise;
            pageCanvases.push(canvas);
        }

        // ถ้ามีหน้าเดียว → trim แล้ว return เลย
        if (pageCanvases.length === 1) {
            return trimCanvas(pageCanvases[0]);
        }

        // หลายหน้า → ต่อแนวตั้ง
        const maxWidth = Math.max(...pageCanvases.map(c => c.width));
        const totalHeight = pageCanvases.reduce((sum, c) => sum + c.height, 0);
        const gap = 10; // ช่องว่างระหว่างหน้า (px)
        const finalCanvas = document.createElement('canvas');
        finalCanvas.width = maxWidth;
        finalCanvas.height = totalHeight + (gap * (pageCanvases.length - 1));
        const finalCtx = finalCanvas.getContext('2d');
        finalCtx.fillStyle = '#FFFFFF';
        finalCtx.fillRect(0, 0, finalCanvas.width, finalCanvas.height);

        let yOffset = 0;
        for (const pc of pageCanvases) {
            // วางหน้ากึ่งกลาง (กรณีหน้ากว้างไม่เท่ากัน)
            const xOffset = Math.round((maxWidth - pc.width) / 2);
            finalCtx.drawImage(pc, xOffset, yOffset);
            yOffset += pc.height + gap;
        }

        return finalCanvas;
    }

    // แสดงภาพตัวอย่างเมื่อเลือกไฟล์
    $('#schestu_filename').on('change', function (event) {
        const file = event.target.files[0];
        if (!file) return;
        
        const fileExt = file.name.split('.').pop().toLowerCase();
        
        if (fileExt === 'pdf') {
            const reader = new FileReader();
            reader.onload = function() {
                const typedarray = new Uint8Array(this.result);
                renderAllPdfPages(typedarray, 1.5).then(function(resultCanvas) {
                    $('#previewImage').attr('src', resultCanvas.toDataURL('image/jpeg', 0.85)).show();
                }).catch(function(err) {
                    console.error('PDF preview error:', err);
                    $('#previewImage').hide();
                    Swal.fire({ icon: 'warning', title: 'ไม่สามารถแสดงตัวอย่าง PDF', text: err.message || 'กรุณาลองไฟล์อื่น', timer: 3000, showConfirmButton: false });
                });
            };
            reader.readAsArrayBuffer(file);
        } else {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#previewImage').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(file);
        }
    });

    $(document).on('submit','.FormAddClassSchedule', function (e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        const action = $(form).attr('action');
        const submitBtn = $(form).find('button[type="submit"]');
        const originalBtnHtml = submitBtn.html();
        
        const fileInput = $('#schestu_filename')[0];
        if (fileInput.files.length === 0) {
            Swal.fire({ icon: "error", title: "ผิดพลาด!", text: "กรุณาเลือกไฟล์ตารางเรียน" });
            return;
        }

        const file = fileInput.files[0];
        const fileExt = file.name.split('.').pop().toLowerCase();

        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>กำลังประมวลผล...');

        Swal.fire({
            title: 'กำลังประมวลผลไฟล์...',
            html: '<div class="py-3"><div class="spinner-border text-success" style="width: 3rem; height: 3rem;"></div><p class="mt-2 text-dark">หากเป็นไฟล์ PDF ระบบกำลังแปลงเป็นรูปภาพและปรับปรุงคุณภาพ...</p></div>',
            allowOutsideClick: false,
            showConfirmButton: false
        });

        const performSubmit = (blob, fileName) => {
            const remoteUploadFormData = new FormData();
            remoteUploadFormData.append('schestu_filename', blob, fileName);
            remoteUploadFormData.append('filename', fileName);
            remoteUploadFormData.append('term', $('#schestu_term').val());
            remoteUploadFormData.append('year', $('#schestu_year').val());

            $.ajax({
                url: '<?= site_url('admin/academic/ConAdminClassSchedule/upload_proxy') ?>',
                type: 'POST',
                data: remoteUploadFormData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(uploadResponse) {
                    if (uploadResponse.status === 'success' && uploadResponse.filename) {
                        const finalFileName = uploadResponse.filename;
                        
                        // Now submit the final form data to DB
                        const dbFormData = new FormData(form);
                        dbFormData.delete('schestu_filename');
                        dbFormData.append('schestu_filename', finalFileName);

                        $.ajax({
                            url: action,
                            type: "POST",
                            data: dbFormData,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function (response) {
                                Swal.close();
                                if(response && response.success){
                                    Swal.fire({ icon: "success", title: "สำเร็จ!", text: "บันทึกข้อมูลตารางเรียนเรียบร้อยแล้ว", confirmButtonColor: '#15a362' })
                                    .then(() => window.location.href = '<?= site_url('Admin/Acade/Course/ClassSchedule') ?>');
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
                    } else {
                        Swal.fire({ icon: "error", title: "อัปโหลดไฟล์ไม่สำเร็จ!", text: uploadResponse.message || "กรุณาลองใหม่", confirmButtonColor: '#dc3545' });
                        submitBtn.prop('disabled', false).html(originalBtnHtml);
                    }
                },
                error: function() {
                    Swal.fire({ icon: "error", title: "เกิดข้อผิดพลาด!", text: "ไม่สามารถเชื่อมต่อเพื่ออัปโหลดไฟล์ได้", confirmButtonColor: '#dc3545' });
                    submitBtn.prop('disabled', false).html(originalBtnHtml);
                }
            });
        };

        if (fileExt === 'pdf') {
            // ตรวจสอบว่า PDF.js พร้อมใช้งานหรือไม่
            if (typeof pdfjsLib === 'undefined') {
                Swal.close();
                Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: 'ระบบแปลงไฟล์ PDF ไม่พร้อมใช้งาน (CDN ล้มเหลว) กรุณารีเฟรชหน้าแล้วลองใหม่อีกครั้ง' });
                submitBtn.prop('disabled', false).html(originalBtnHtml);
                return;
            }

            const reader = new FileReader();
            reader.onload = function() {
                const typedarray = new Uint8Array(this.result);

                // ใช้ renderAllPdfPages เพื่อ render ทุกหน้าแล้วต่อเป็นรูปเดียว
                renderAllPdfPages(typedarray, 2.0).then(function(resultCanvas) {
                    resultCanvas.toBlob(function(blob) {
                        if (!blob) {
                            Swal.close();
                            Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: 'ไม่สามารถแปลง PDF เป็นรูปภาพได้ กรุณาลองใหม่' });
                            submitBtn.prop('disabled', false).html(originalBtnHtml);
                            return;
                        }
                        const cleanClassName = $('#schestu_classname').val().replace(/[\/\\]/g, '-');
                        const newFileName = Date.now() + '-' + $('#schestu_year').val() + '-' + $('#schestu_term').val() + '-Room-' + cleanClassName + '.jpg';
                        console.log('PDF converted to JPEG blob:', blob.size, 'bytes, filename:', newFileName);
                        performSubmit(blob, newFileName);
                    }, 'image/jpeg', 0.92);
                }).catch(function(err) {
                    console.error('PDF conversion error:', err);
                    Swal.close();
                    Swal.fire({ icon: 'error', title: 'แปลงไฟล์ PDF ไม่สำเร็จ!', text: 'เกิดข้อผิดพลาด: ' + (err.message || 'ไม่ทราบสาเหตุ') + '\nกรุณาลองแปลง PDF เป็นรูปภาพก่อนอัปโหลด', confirmButtonColor: '#dc3545' });
                    submitBtn.prop('disabled', false).html(originalBtnHtml);
                });
            };
            reader.onerror = function() {
                Swal.close();
                Swal.fire({ icon: 'error', title: 'อ่านไฟล์ไม่สำเร็จ!', text: 'ไม่สามารถอ่านไฟล์ PDF ได้ กรุณาลองใหม่' });
                submitBtn.prop('disabled', false).html(originalBtnHtml);
            };
            reader.readAsArrayBuffer(file);
        } else {
            // ไฟล์รูปภาพ → ส่งตรงได้เลย
            const cleanClassName = $('#schestu_classname').val().replace(/[\/\\]/g, '-');
            const uniqueFileName = Date.now() + '-' + $('#schestu_year').val() + '-' + $('#schestu_term').val() + '-Room-' + cleanClassName + '.' + fileExt;
            performSubmit(file, uniqueFileName);
        }
    });
</script>
<?= $this->endSection() ?>
