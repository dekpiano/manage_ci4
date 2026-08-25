<?= $this->extend('user/layout/main') ?>

<?= $this->section('content') ?>

<!-- Fancybox CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
<style>
    .search-card { border-radius: 20px; border: none; background: #fff; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-top: -30px; position: relative; z-index: 10; }
    .btn-search { border-radius: 50px; padding: 10px 30px; font-weight: 600; transition: all 0.3s; }
    .btn-search:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(21, 163, 98, 0.3); }
    .class-card { border-radius: 15px; border: none; transition: all 0.3s; cursor: pointer; height: 100%; border-bottom: 4px solid #15a362; }
    .class-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    .class-icon { width: 50px; height: 50px; background: #e8f5e9; color: #15a362; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1rem; }
    .hero-section { background: linear-gradient(135deg, #15a362 0%, #71dd37 100%); padding: 4rem 0 6rem 0; color: white; text-align: center; }
    .page-title { font-weight: 800; letter-spacing: -1px; }
    .ss-main { border-radius: 10px !important; padding: 5px !important; border: 1px solid #eee !important; }
</style>

<div class="app-wrapper">
    <div class="hero-section">
        <div class="container">
            <h1 class="page-title text-white mb-2">ตารางเรียน</h1>
            <p class="opacity-75">ตรวจสอบตารางเรียนประจำภาคเรียนของคุณได้ที่นี่</p>
        </div>
    </div>

    <div class="container-xl">
        <!-- Search Controls -->
        <div class="card search-card p-4 mb-5">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="small fw-bold text-muted mb-2">ปีการศึกษา</label>
                    <select id="SearchYear" class="form-select">
                        <option value="">กำลังโหลด...</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="small fw-bold text-muted mb-2">ภาคเรียน</label>
                    <select id="SearchTerm" class="form-select" disabled>
                        <option value="">เลือกปีการศึกษาก่อน</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="small fw-bold text-muted mb-2">ค้นหาห้องเรียน</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bx bx-search text-muted"></i></span>
                        <input type="text" id="FilterClass" class="form-control border-start-0" placeholder="เช่น 1/1, 4/2..." disabled>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div id="loading-state" class="text-center py-5" style="display: none;">
            <div class="spinner-border text-success" role="status"></div>
            <p class="mt-2 text-muted">กำลังค้นหาข้อมูล...</p>
        </div>

        <div id="results-container" class="row g-4 mb-5">
            <!-- Dynamic Cards Here -->
            <div class="col-12 text-center py-5 text-muted" id="initial-msg">
                <i class="bx bx-info-circle fs-1 d-block mb-3 opacity-25"></i>
                กรุณาเลือกปีการศึกษาและภาคเรียนเพื่อดูตารางเรียน
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
$(document).ready(function() {
    const uploadServerBaseUrl = '<?= env("upload.server.baseurl") ?>';
    let allData = [];

    // Load available years
    const activeYearOnly = '<?= get_selected_year_only() ?>';
    const activeTermOnly = '<?= get_selected_term_only() ?>';

    $.ajax({
        url: '<?= site_url('user/getscheduleyears') ?>',
        method: 'GET',
        success: function(years) {
            let html = '<option value="">เลือกปีการศึกษา...</option>';
            let hasActiveYear = false;
            years.forEach(y => {
                const isSel = (y.schestu_year == activeYearOnly) ? 'selected' : '';
                if (isSel) hasActiveYear = true;
                html += `<option value="${y.schestu_year}" ${isSel}>ปีการศึกษา ${y.schestu_year}</option>`;
            });
            $('#SearchYear').html(html);

            if (hasActiveYear || activeYearOnly) {
                $('#SearchYear').val(activeYearOnly).trigger('change');
                if (activeTermOnly) {
                    $('#SearchTerm').val(activeTermOnly).trigger('change');
                }
            }
        }
    });

    $('#SearchYear').change(function() {
        if ($(this).val()) {
            $('#SearchTerm').prop('disabled', false).html(`
                <option value="">เลือกภาคเรียน...</option>
                <option value="1">ภาคเรียนที่ 1</option>
                <option value="2">ภาคเรียนที่ 2</option>
            `);
        } else {
            $('#SearchTerm').prop('disabled', true).html('<option value="">เลือกปีการศึกษาก่อน</option>');
            $('#FilterClass').prop('disabled', true);
        }
        $('#results-container').html('<div class="col-12 text-center py-5 text-muted">กรุณาเลือกภาคเรียน</div>');
    });

    $('#SearchTerm').change(function() {
        const year = $('#SearchYear').val();
        const term = $(this).val();
        if (year && term) {
            $('#loading-state').show();
            $('#results-container').hide();
            
            $.ajax({
                url: '<?= site_url('user/searchclassschedule') ?>',
                method: 'GET',
                data: { year: year, term: term },
                success: function(data) {
                    allData = data;
                    $('#loading-state').hide();
                    $('#results-container').show();
                    $('#FilterClass').prop('disabled', false).val('');
                    renderCards(data);
                }
            });
        }
    });

    $('#FilterClass').on('input', function() {
        const query = $(this).val().toLowerCase();
        const filtered = allData.filter(item => 
            item.schestu_classname.toLowerCase().includes(query) || 
            item.schestu_name.toLowerCase().includes(query)
        );
        renderCards(filtered);
    });

    function renderCards(data) {
        if (data.length === 0) {
            $('#results-container').html('<div class="col-12 text-center py-5 text-muted">ไม่พบข้อมูลตารางเรียน</div>');
            return;
        }

        let html = '';
        data.forEach(item => {
            const imageUrl = uploadServerBaseUrl + item.schestu_year + '/' + item.schestu_term + '/' + item.schestu_filename;
            
            html += `
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card class-card shadow-sm p-3" data-fancybox="gallery" data-src="${imageUrl}" data-caption="ม.${item.schestu_classname} (${item.schestu_name})">
                        <div class="class-icon">
                            <i class="bx bx-book-open"></i>
                        </div>
                        <h6 class="fw-bold mb-1">ชั้น ม.${item.schestu_classname}</h6>
                        <p class="text-muted small mb-0 text-truncate">${item.schestu_name}</p>
                    </div>
                </div>
            `;
        });
        $('#results-container').html(html);
    }

    Fancybox.bind("[data-fancybox]", {
        compact: false,
        idle: false,
        dragToClose: false
    });
});
</script>

<?= $this->endSection() ?>
