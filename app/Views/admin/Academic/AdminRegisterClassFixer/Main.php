<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">วิชาการ /</span> ตรวจสอบและแก้ไขห้องเรียน (เลือกรายห้อง)
    </h4>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">สแกนตามปีการศึกษาและรายห้อง</h5>
        </div>
        <div class="card-body">
            <form id="filterForm" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="filterYear">ปีการศึกษาอ้างอิง</label>
                    <?php $activeFixerYear = get_selected_year(); ?>
                    <select id="filterYear" class="form-select select2">
                        <option value="">เลือกปีการศึกษา...</option>
                        <?php foreach ($years as $y): ?>
                            <option value="<?= esc($y->RegisterYear) ?>" <?= ($y->RegisterYear == $activeFixerYear) ? 'selected' : '' ?>><?= esc($y->RegisterYear) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="filterRoom">เลือกห้องเรียน (ที่ต้องการสแกนหาผู้ที่มีข้อมูลไม่ครบ)</label>
                    <div class="input-group">
                        <select id="filterRoom" class="form-select select2">
                            <option value="">เลือกห้องเรียน (เช่น ม.1/1)...</option>
                            <?php foreach ($rooms as $r): ?>
                                <option value="<?= esc($r->RegisterClass) ?>"><?= esc($r->RegisterClass) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="button" id="btnSearch" class="btn btn-primary">
                            <i class="bx bx-search me-1"></i> วิเคราะห์รายห้อง
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-4 shadow-sm" id="resultCard" style="display: none;">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">ตารางวิเคราะห์ความต่อเนื่องรายบุคคล</h5>
                <small class="text-muted">ตรวจสอบประวัติย้อนหลังเทียบกับห้องเรียนปัจจุบันที่เลือก</small>
            </div>
            <div class="text-end">
                <span class="badge bg-label-primary p-2" id="totalSummary">ทั้งหมด 0 คน</span>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered table-hover mb-0" id="auditTable">
                <thead class="bg-light">
                    <tr id="tableHeader">
                        <!-- Headings will be injected here -->
                    </tr>
                </thead>
                <tbody id="auditBody">
                    <!-- Rows will be injected here -->
                </tbody>
            </table>
        </div>
        <div class="card-footer border-top d-flex justify-content-center">
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm mb-0" id="paginationControls">
                    <!-- Pagination will be injected here -->
                </ul>
            </nav>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
let currentPage = 1;

$(document).ready(function() {
    $('.select2').select2();

    $('#btnSearch').on('click', function() {
        currentPage = 1;
        loadPage(currentPage);
    });

    function loadPage(page) {
        const year = $('#filterYear').val();
        const room = $('#filterRoom').val();
        
        if (!year || !room) return alert('กรุณาเลือกทั้งปีการศึกษาและห้องเรียน');

        $('#btnSearch').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> กำลังวิเคราะห์...');
        
        $.ajax({
            url: '<?= base_url('diagnostic/register-class/audit-data') ?>',
            type: 'GET',
            data: { year: year, room: room, page: page },
            success: function(res) {
                $('#btnSearch').prop('disabled', false).html('<i class="bx bx-search me-1"></i> วิเคราะห์รายห้อง');
                
                if (!res.students || res.students.length === 0) {
                    $('#resultCard').hide();
                    alert('ไม่พบข้อมูลที่ต้องแก้ไขในห้องนี้');
                    return;
                }

                $('#resultCard').show();
                $('#totalSummary').text(`นักเรียนในห้อง ${res.total_students} คน (หน้า ${res.current_page}/${res.total_pages})`);
                
                // 1. Build Header
                let headerHtml = '<th class="bg-white sticky-left">ชื่อ-นามสกุล</th>';
                res.years.forEach(yr => {
                    headerHtml += `<th class="text-center ${yr === year ? 'bg-label-info' : ''}">${yr}</th>`;
                });
                $('#tableHeader').html(headerHtml);

                // 2. Build Body
                let bodyHtml = '';
                res.students.forEach(std => {
                    bodyHtml += `<tr>`;
                    bodyHtml += `<td class="bg-white sticky-left">
                                    <div class="fw-bold">${std.FullName}</div>
                                    <small class="text-muted">${std.StudentCode}</small>
                                 </td>`;
                    
                    res.years.forEach(yr => {
                        const data = std.History[yr];
                        const isTargetYear = (yr === year);
                        bodyHtml += `<td class="text-center align-middle ${isTargetYear ? 'bg-light' : ''}" style="min-width: 150px;">`;
                        
                        if (data) {
                            if (data.IsRaw) {
                                let selectHtml = `<select class="form-select form-select-sm mb-1 select-room" 
                                                          data-student="${std.StudentID}" data-year="${yr}">`;
                                data.Options.forEach(opt => {
                                    let sel = (opt === data.BestGuess) ? 'selected' : '';
                                    selectHtml += `<option value="${opt}" ${sel}>${opt}</option>`;
                                });
                                selectHtml += `</select>`;
                                
                                bodyHtml += `
                                    <div class="p-1 border border-warning rounded bg-light-warning">
                                        <small class="d-block text-warning fw-bold mb-1">รอยืนยัน (${data.Room})</small>
                                        ${selectHtml}
                                        <button class="btn btn-xs btn-primary btn-save-cell w-100" 
                                                data-student="${std.StudentID}" data-year="${yr}">
                                            <i class="bx bx-save"></i> บันทึก
                                        </button>
                                    </div>
                                `;
                            } else {
                                bodyHtml += `<span class="badge bg-label-success fs-6">${data.Room}</span>`;
                            }
                        } else {
                            bodyHtml += `<span class="text-muted small">-</span>`;
                        }
                        bodyHtml += `</td>`;
                    });
                    bodyHtml += `</tr>`;
                });
                $('#auditBody').html(bodyHtml);

                // 3. Pagination Logic
                let paginationHtml = '';
                paginationHtml += `<li class="page-item ${res.current_page === 1 ? 'disabled' : ''}">
                                    <a class="page-link" href="javascript:void(0);" data-page="${res.current_page - 1}"><i class="bx bx-chevron-left"></i></a>
                                   </li>`;
                
                let start = Math.max(1, res.current_page - 2);
                let end = Math.min(res.total_pages, start + 4);
                if (end - start < 4) start = Math.max(1, end - 4);

                for (let i = start; i <= end; i++) {
                    paginationHtml += `<li class="page-item ${i === res.current_page ? 'active' : ''}">
                                        <a class="page-link" href="javascript:void(0);" data-page="${i}">${i}</a>
                                       </li>`;
                }

                paginationHtml += `<li class="page-item ${res.current_page === res.total_pages ? 'disabled' : ''}">
                                    <a class="page-link" href="javascript:void(0);" data-page="${res.current_page + 1}"><i class="bx bx-chevron-right"></i></a>
                                   </li>`;
                
                $('#paginationControls').html(paginationHtml);
            }
        });
    }

    $(document).on('click', '#paginationControls .page-link', function() {
        const page = $(this).data('page');
        if (page && page !== currentPage) {
            currentPage = page;
            loadPage(page);
            $('html, body').animate({
                scrollTop: $("#resultCard").offset().top - 100
            }, 500);
        }
    });

    $(document).on('click', '.btn-save-cell', function() {
        const studentId = $(this).data('student');
        const year = $(this).data('year');
        const $cell = $(this).closest('td');
        const selectedRoom = $cell.find('.select-room').val();

        if (!selectedRoom) return alert('กรุณาระบุห้องเรียน');

        const $btn = $(this);
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

        $.ajax({
            url: '<?= base_url('diagnostic/register-class/process-fix') ?>',
            type: 'POST',
            data: {
                student_id: studentId,
                year: year,
                new_room: selectedRoom,
                <?= csrf_token() ?>: '<?= csrf_hash() ?>'
            },
            success: function(response) {
                if (response.status === 'success') {
                    $cell.html(`<span class="badge bg-label-success fs-6 animate__animated animate__pulse">${selectedRoom}</span>`);
                } else {
                    alert('Error: ' + response.message);
                    $btn.prop('disabled', false).html('<i class="bx bx-save"></i> บันทึก');
                }
            }
        });
    });
});
</script>

<style>
.sticky-left {
    position: sticky;
    left: 0;
    z-index: 2;
    background: white !important;
    box-shadow: 2px 0 5px rgba(0,0,0,0.05);
}
.bg-light-warning {
    background-color: #fff9e6;
}
.btn-xs {
    padding: 0.2rem 0.4rem;
    font-size: 0.75rem;
}
#auditTable th {
    vertical-align: middle;
}
</style>

<?= $this->endSection() ?>
