<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="flex-grow-1 container-p-y">
    <!-- Breadcrumb -->
    <div class="card mb-4">
        <div class="card-body py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-0">
                        <i class="bx bx-calendar-check text-primary me-2"></i>
                        จัดการข้อมูล<?= isset($title) ? esc($title) : '' ?>
                    </h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('Admin/Home') ?>">หน้าหลัก</a></li>
                            <li class="breadcrumb-item"><a href="#">งานทะเบียน</a></li>
                            <li class="breadcrumb-item active"><?= isset($title) ? esc($title) : '' ?></li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#examScheduleModal">
                        <i class="bx bx-plus me-1"></i>
                        เพิ่ม<?= isset($title) ? esc($title) : '' ?>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add/Edit -->
    <div class="modal fade" id="examScheduleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="examScheduleForm" action="<?= site_url('admin/academic/ConAdminExamSchedule/insert_exam_schedule');?>" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title">เพิ่มตารางสอบ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label">ประเภทการสอบ</label>
                                <select name="exam_type" class="form-select" required>
                                    <option value="">-- เลือกประเภทการสอบ --</option>
                                    <option value="กลางภาค">สอบกลางภาค</option>
                                    <option value="ปลายภาค">สอบปลายภาค</option>
                                </select>
                            </div>
                            
                            <div class="col-6 mb-3">
                                <label class="form-label">ภาคเรียน</label>
                                <select name="exam_term" class="form-select" required>
                                    <option value="">-- เลือกภาคเรียน --</option>
                                    <option value="1">ภาคเรียนที่ 1</option>
                                    <option value="2">ภาคเรียนที่ 2</option>
                                </select>
                            </div>

                            <div class="col-6 mb-3">
                                <label class="form-label">ปีการศึกษา</label>
                                <select name="exam_year" class="form-select" required>
                                    <option value="">-- เลือกปีการศึกษา --</option>
                                    <?php 
                                    $currentYear = date('Y')+543;
                                    for($i = $currentYear; $i >= $currentYear-2; $i--): 
                                    ?>
                                    <option value="<?=$i?>"><?=$i?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label">ไฟล์ตารางสอบ</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" name="exam_filename" id="exam_filename" accept=".pdf,.xls,.xlsx,.doc,.docx,.jpg,.jpeg,.png,.gif" required>
                                    <label class="input-group-text" for="exam_filename">เลือกไฟล์</label>
                                </div>
                                <div class="form-text">รองรับไฟล์: PDF, Excel, Word ขนาดไม่เกิน 5MB</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" id="saveButton" class="btn btn-primary">บันทึกข้อมูล</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div class="card-body">
            <!-- Filter Section -->
            <div class="d-none">
                <div id="yearFilterGroup" class="d-flex align-items-center me-2">
                    <label for="yearFilter" class="form-label mb-0 me-2">ปีการศึกษา</label>
                    <select id="yearFilter" class="form-select form-select-sm">
                        <option value="">ทั้งหมด</option>
                        <?php 
                        $currentYear = date('Y')+543;
                        for($i = $currentYear; $i >= $currentYear-5; $i--): 
                        ?>
                        <option value="<?=$i?>"><?=$i?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover display nowrap" id="examScheduleTable" width="100%">
                    <thead>
                        <tr>
                            <th class="text-nowrap">การสอบ</th>
                            <th class="text-nowrap">ปีการศึกษา</th>
                            <th class="text-nowrap">ภาคเรียน</th>
                            <th class="text-nowrap">ไฟล์ตารางสอบ</th>
                            <th class="text-nowrap">วันที่อัปโหลด</th>
                            <th class="text-nowrap text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $remoteBaseUrl = "http://118.172.140.151:8000/uploads/academic/ExamSchedule/";
                    foreach ($exam_schedule as $key => $v_exam_schedule) : 
                        $fileName = isset($v_exam_schedule->exam_filename) ? esc($v_exam_schedule->exam_filename) : '';
                        $fileUrl = $remoteBaseUrl . rawurlencode($fileName);
                        // The local delete URL should not contain the filename anymore, as the file is remote.
                        // The controller should be updated to reflect this.
                        $localDeleteUrl = site_url('Admin/Acade/ConAdminExamSchedule/delete_exam_schedule/'.(isset($v_exam_schedule->exam_id) ? esc($v_exam_schedule->exam_id, 'url') : ''));
                    ?>
                    <tr>
                        <td>
                            <span
                                class="badge bg-label-<?= $v_exam_schedule->exam_type == 'กลางภาค' ? 'info' : 'warning' ?>">
                                <?= isset($v_exam_schedule->exam_type) ? esc($v_exam_schedule->exam_type) : '' ?>
                            </span>
                        </td>
                        <td><?= isset($v_exam_schedule->exam_year) ? esc($v_exam_schedule->exam_year) : '' ?></td>
                        <td><?= isset($v_exam_schedule->exam_term) ? esc($v_exam_schedule->exam_term) : '' ?></td>
                        <td>
                            <a href="<?= $fileUrl ?>"
                                target="_blank" rel="noopener noreferrer" class="d-flex align-items-center text-body">
                                <i class="bx bx-file me-2 text-primary"></i>
                                <span class="text-truncate" style="max-width: 150px;">
                                    <?= $fileName ?>
                                </span>
                            </a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bx bx-calendar-alt me-1"></i>
                                <?= date('d/m/Y', strtotime($v_exam_schedule->exam_create)) ?>
                                <small class="text-muted ms-2">
                                    <?= date('H:i', strtotime($v_exam_schedule->exam_create)) ?>
                                </small>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="<?= $fileUrl ?>"
                                    target="_blank" class="btn btn-icon btn-outline-primary btn-sm">
                                    <i class="bx bx-show"></i>
                                </a>
                                <button type="button"
                                    onclick="deleteExamSchedule('<?= $localDeleteUrl ?>', '<?= $fileName ?>')"
                                    class="btn btn-icon btn-outline-danger btn-sm">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Empty State -->
                <?php if(empty($exam_schedule)): ?>
                <div class="text-center py-5">
                    <img src="<?= base_url('assets/img/illustrations/empty.svg') ?>" alt="No Data" class="mb-3"
                        width="180">
                    <h6 class="text-muted mb-0">ไม่พบข้อมูลตารางสอบ</h6>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>


<?= $this->section('script') ?>
<!-- DataTables JS -->

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<script>
    const UPLOAD_URL = 'http://118.172.140.151:8000/upload.php';
    const DELETE_URL = 'http://118.172.140.151:8000/delete.php';
    const UPLOAD_PATH = 'academic/ExamSchedule'; // Changed from UPLOAD_DESTINATION

    // Initialize DataTable
    var table = $('#examScheduleTable').DataTable({
        "processing": true,
        "dom": '<"d-flex justify-content-between align-items-center mb-3"<"d-flex align-items-center"l><"d-flex align-items-center"f>>rtip',
        "language": {
            "lengthMenu": "แสดง _MENU_ รายการ",
            "search": "ค้นหา: ",
            "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
            "infoEmpty": "ไม่พบรายการ",
            "zeroRecords": "ไม่พบข้อมูลที่ค้นหา",
            "paginate": {
                "first": "หน้าแรก",
                "last": "หน้าสุดท้าย",
                "next": "ถัดไป",
                "previous": "ก่อนหน้า"
            }
        },
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "ทั้งหมด"]],
        "columnDefs": [
            {
                "targets": [3, 5], // คอลัมน์ไฟล์และคำสั่ง
                "orderable": false
            }
        ],
        "order": [[4, 'desc']], // เรียงตามวันที่ล่าสุด
        responsive: true,
        
        initComplete: function () {
            // Move the year filter next to the search bar
            $('#yearFilterGroup').prependTo($('#examScheduleTable_filter').parent());

            // เพิ่ม dropdown filter สำหรับปีการศึกษาและภาคเรียน
            this.api().columns([1, 2]).every(function (index) {
                var column = this;
                var select = $('<select class="form-select form-select-sm" style="width: 200px; margin-right: 10px;"><option value="">- ทั้งหมด -</option></select>')
                    .appendTo($('.dt-buttons'))
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val ? '^' + val + '$' : '', true, false).draw();
                    });

                column.data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>');
                });
            });

          
        }
    });

    function deleteRemoteFile(fileName, path) { // Changed destination to path
        const postData = {
            files: [fileName], // Server expects an array
            path: path
        };

        return $.ajax({
            url: DELETE_URL,
            type: 'POST',
            data: JSON.stringify(postData), // Stringify the data to JSON
            contentType: 'application/json; charset=utf-8', // Set content type to JSON
            dataType: 'json' // Expect a JSON response
        });
    }

    function deleteExamSchedule(localDeleteUrl, remoteFileName) {
        Swal.fire({
            title: 'ยืนยันการลบข้อมูล?',
            text: "ไฟล์จะถูกลบจากเซิร์ฟเวอร์และข้อมูลจะถูกลบจากฐานข้อมูล!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // Try to delete remote file first, but proceed even if it fails.
                deleteRemoteFile(remoteFileName, UPLOAD_PATH).always(function(deleteResponse) {
                    console.log('Remote delete response:', deleteResponse);

                    // Now, delete the local DB record via POST AJAX
                    $.ajax({
                        url: localDeleteUrl,
                        type: 'POST', // Use POST for the delete action
                        success: function(localResponse) {
                            Swal.fire(
                                'ลบข้อมูลแล้ว!',
                                'ข้อมูลของคุณถูกลบเรียบร้อยแล้ว',
                                'success'
                            ).then(() => {
                                location.reload(); // Reload to reflect changes
                            });
                        },
                        error: function() {
                            Swal.fire(
                                'เกิดข้อผิดพลาด!',
                                'ไม่สามารถลบข้อมูลออกจากฐานข้อมูลได้',
                                'error'
                            );
                        }
                    });
                });
            }
        });
    }

    // Form Submit Handler
    $('#examScheduleForm').on('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const fileInput = $('#exam_filename')[0];

        if (fileInput.files.length === 0) {
            Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: 'กรุณาเลือกไฟล์ที่ต้องการอัปโหลด' });
            return;
        }

        const file = fileInput.files[0];
        const remoteUploadFormData = new FormData();
        remoteUploadFormData.append('file', file);
        remoteUploadFormData.append('path', UPLOAD_PATH); // Changed from destination

        Swal.fire({
            title: 'กำลังอัปโหลดไฟล์...',
            text: 'กรุณารอสักครู่',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // 1. Upload file to remote server
        $.ajax({
            url: UPLOAD_URL,
            type: 'POST',
            data: remoteUploadFormData,
            processData: false,
            contentType: false,
            dataType: 'json', 
            success: function(uploadResponse) {
                if (uploadResponse.status === 'success' && uploadResponse.filename) { // Changed from uploadResponse.success
                    const remoteFileName = uploadResponse.filename;

                    // 2. Submit metadata to local server
                    const localFormData = new FormData(form);
                    localFormData.delete('exam_filename');
                    localFormData.append('exam_filename', remoteFileName);

                    $.ajax({
                        url: $(form).attr('action'),
                        type: 'POST',
                        data: localFormData,
                        processData: false,
                        contentType: false,
                        dataType: 'json', 
                        success: function(localResponse) {
                            if (localResponse.success) {
                                // Hide the modal
                                $('#examScheduleModal').modal('hide');

                                Swal.fire({
                                    icon: 'success',
                                    title: 'สำเร็จ!',
                                    text: 'บันทึกข้อมูลเรียบร้อยแล้ว',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => location.reload());
                            } else {
                                // Use html property to render potential HTML tags from server message
                                Swal.fire({ icon: 'error', title: 'บันทึกข้อมูลไม่สำเร็จ!', html: localResponse.message || 'กรุณาลองใหม่อีกครั้ง' });
                                deleteRemoteFile(remoteFileName, UPLOAD_PATH);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            let errorMessage = 'เกิดข้อผิดพลาดในการบันทึกข้อมูลลงฐานข้อมูล';
                            // Try to get a more specific message from the server response
                            if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                                errorMessage = jqXHR.responseJSON.message;
                            } else if (jqXHR.responseText) {
                                const matches = jqXHR.responseText.match(/<title>(.*?)<\/title>/);
                                if (matches && matches[1]) {
                                    errorMessage += '<br><small style="text-align:left; display:block;">' + matches[1] + '</small>';
                                }
                            }
                            Swal.fire({ icon: 'error', title: 'ผิดพลาด!', html: errorMessage });
                            deleteRemoteFile(remoteFileName, UPLOAD_PATH);
                        }
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'อัปโหลดไฟล์ไม่สำเร็จ!', text: uploadResponse.message || 'กรุณาตรวจสอบไฟล์และลองใหม่อีกครั้ง' });
                }
            },
            error: function() {
                Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์อัปโหลดได้' });
            }
        });
    });

    // Year Filter Handler
    $('#yearFilter').on('change', function() {
        var selectedYear = $(this).val();
        table.column(1) // ปรับตามคอลัมน์ที่เก็บปีการศึกษา (0-based index)
            .search(selectedYear)
            .draw();
    });

    // File Input Validation
    $('#exam_filename').on('change', function() {
        var file = this.files[0];
        if(file) {
            var fileSize = file.size / 1024 / 1024; // convert to MB
            if(fileSize > 5) {
                Swal.fire({
                    icon: 'error',
                    title: 'ไฟล์มีขนาดใหญ่เกินไป',
                    text: 'กรุณาเลือกไฟล์ขนาดไม่เกิน 5MB'
                });
                this.value = '';
                return;
            }

            // ตรวจสอบนามสกุลไฟล์
            var validExtensions = ['pdf', 'xls', 'xlsx', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'gif'];
            var fileExt = file.name.split('.').pop().toLowerCase();
            if (!validExtensions.includes(fileExt)) {
                Swal.fire({
                    icon: 'error',
                    title: 'ไฟล์ไม่ถูกต้อง',
                    text: 'รองรับเฉพาะไฟล์ PDF, Excel และ Word เท่านั้น'
                });
                this.value = '';
                return;
            }
        }
    });

</script>
<?= $this->endSection() ?>