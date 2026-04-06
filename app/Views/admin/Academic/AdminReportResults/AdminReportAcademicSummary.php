<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
    :root {
        --primary-green: #15a362;
        --dark-green: #1d4310;
        --light-green: #ABDD93;
    }

    /* Hero Section */
    .hero-header {
        background: #15a362;
        background: linear-gradient(135deg, #15a362 0%, #0d6d41 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.15);
        position: relative;
        overflow: hidden;
    }

    .hero-header::after {
        content: '';
        position: absolute;
        bottom: -20px;
        right: -20px;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    /* Search Container */
    .search-container {
        background: #fff;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        border: 1px solid #edf2f9;
        margin-bottom: 1.5rem;
    }

    /* Table Styles */
    #ReportSummaryTeacher {
        border-collapse: collapse !important;
        width: 100%;
    }

    #ReportSummaryTeacher thead th {
        background-color: #ABDD93 !important;
        border: 1px solid #529432 !important;
        color: #000 !important;
        font-weight: 700;
        vertical-align: middle !important;
        position: sticky;
        top: 0;
        z-index: 40;
        padding: 10px 5px !important;
        font-size: 0.85rem;
    }

    #ReportSummaryTeacher tbody td {
        border: 1px solid #e9ecef;
        vertical-align: middle;
        padding: 8px 5px !important;
        font-size: 0.85rem;
    }

    .bg-grade-high { background-color: #f1f8e9 !important; }
    .bg-grade-low { background-color: #fffde7 !important; }
    .bg-status-danger { background-color: #ffebee !important; }

    .fade-in-up {
        animation: fadeInUp 0.4s ease-out forwards;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Select2 Bootstrap 5 Fixes */
    .select2-container--bootstrap-5 .select2-selection {
        height: 40px !important;
        display: flex !important;
        align-items: center !important;
    }
</style>

<div class="container-fluid flex-grow-1 container-p-y">
    <!-- Hero Header -->
    <div class="hero-header fade-in-up">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3 class="fw-bold mb-1 text-white"><i class='bx bx-bar-chart-alt-2 me-2'></i>สรุปผลสัมฤทธิ์ทางการเรียน</h3>
                <p class="mb-0 text-white-50 opacity-75">รายงานสถิติการตัดเกรด ค่าเฉลี่ย และผลการเรียนรายวิชา แยกตามกลุ่มสาระการเรียนรู้</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <?php if (!empty($KeyYear) && $KeyYear != '0'): ?>
                    <span class="badge bg-white bg-opacity-20 fs-6 p-2 px-3 rounded-pill text-white shadow-sm">
                        <i class='bx bx-calendar-check me-1 text-white'></i> ปีการศึกษา <?= esc($KeyYear) ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modern Search Control -->
    <form method="get" action="<?= site_url('Admin/Acade/Evaluate/ReportAcademicSummary'); ?>" id="formFilterSummary">
        <div class="search-container fade-in-up">
            <div class="row align-items-end g-3">
                <div class="col-lg-3">
                    <label class="form-label fw-bold text-dark small">ปีการศึกษา</label>
                    <select class="form-select select2" name="KeyYear" id="KeyYear">
                        <option value="0">-- เลือกปีการศึกษา --</option>
                        <?php foreach ($CheckYear as $v_CheckYear) : ?>
                            <option <?= (isset($KeyYear) && $KeyYear == $v_CheckYear->RegisterYear) ? 'selected' : '' ?> value="<?= esc($v_CheckYear->RegisterYear) ?>">
                                ปีการศึกษา <?= esc($v_CheckYear->RegisterYear) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-lg-4">
                    <label class="form-label fw-bold text-dark small">กลุ่มสาระการเรียนรู้</label>
                    <select class="form-select select2" name="SelLern" id="SelLern">
                        <option value="0">-- ทั้งหมด / ไม่ระบุ --</option>
                        <?php foreach ($lern as $v_lern) : ?>
                            <option <?= (service('request')->getGet('SelLern') == $v_lern->lear_id) ? "selected" : "" ?> value="<?= esc($v_lern->lear_id) ?>">
                                <?= esc($v_lern->lear_namethai) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-lg-2">
                    <button class="btn btn-success w-100 shadow-sm fw-bold" style="height: 40px;" type="submit">
                        <i class="bx bx-search-alt me-1"></i> ค้นหา
                    </button>
                </div>
                <div class="col-lg-3 text-end" id="exportSummaryButtons">
                </div>
            </div>
        </div>
    </form>

    <?php if (empty($Showdata)) : ?>
        <div class="card border-0 shadow-none bg-transparent text-center py-5 fade-in-up">
            <div class="avatar avatar-xl mx-auto mb-3" style="width: 100px; height: 100px;">
                <span class="avatar-initial rounded-circle bg-label-success"><i class="bx bx-search-alt" style="font-size: 3rem;"></i></span>
            </div>
            <h4 class="text-dark fw-bold">กรุณาเลือกข้อมูลเพื่อแสดงรายงาน</h4>
            <p class="text-muted">เลือกปีการศึกษาและกลุ่มสาระด้านบนเพื่อเริ่มต้น</p>
        </div>
    <?php else : ?>
        <!-- Data Table -->
        <div class="fade-in-up" style="animation-delay: 0.1s;">
            <div class="bg-white" style="border-radius: 12px; border: 2px solid #529432; overflow: hidden;">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="ReportSummaryTeacher">
                        <thead>
                            <tr class="text-center">
                                <th rowspan="2" style="width: 180px;">ครูผู้สอน</th>
                                <th rowspan="2" style="min-width: 250px;">รายวิชา / รหัสวิชา</th>
                                <th rowspan="2" style="width: 60px;">ชั้น</th>
                                <th rowspan="2" style="width: 50px;">นก.</th>
                                <th rowspan="2" class="bg-primary text-white" style="width: 60px;">นร.</th>
                                <th colspan="8" class="bg-success text-white">ผลการเรียน (จำนวนคน)</th>
                                <th colspan="2" class="bg-warning text-dark text-nowrap">สถานะ</th>
                                <th colspan="4" class="bg-info text-white">สถิติรวม</th>
                            </tr>
                            <tr class="text-center">
                                <th class="bg-grade-high text-dark">4</th>
                                <th class="bg-grade-high text-dark">3.5</th>
                                <th class="bg-grade-high text-dark">3</th>
                                <th>2.5</th>
                                <th>2</th>
                                <th>1.5</th>
                                <th>1</th>
                                <th class="text-danger bg-grade-low">0</th>
                                <th class="bg-status-danger text-dark">ร</th>
                                <th class="bg-status-danger text-dark">มส</th>
                                <th class="bg-info text-white border-white">3+</th>
                                <th class="bg-info text-white border-white">% 3+</th>
                                <th class="bg-info text-white border-white">เฉลี่ย</th>
                                <th class="bg-info text-white border-white">SD</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($Showdata as $v_data) : 
                                $totalNumeric = (int)$v_data->TotalNumeric;
                                $goodCount = (int)$v_data->G4_0 + (int)$v_data->G3_5 + (int)$v_data->G3_0;
                                $goodPercent = ($totalNumeric > 0) ? ($goodCount / $totalNumeric) * 100 : 0;
                            ?>
                                <tr>
                                    <td class="border-end">
                                        <div class="fw-medium text-dark small"><?= esc($v_data->pers_prefix . $v_data->pers_firstname . ' ' . $v_data->pers_lastname) ?></div>
                                    </td>
                                    <td class="border-end">
                                        <div class="small"><span class="badge bg-label-success me-1"><?= esc($v_data->SubjectCode) ?></span> <?= esc($v_data->SubjectName) ?></div>
                                    </td>
                                    <td class="text-center border-end fw-bold"><?= esc($v_data->StudentClass) ?></td>
                                    <td class="text-center border-end"><?= number_format((float)$v_data->SubjectUnit, 1) ?></td>
                                    <td class="text-center border-end fw-bold text-primary bg-light"><?= esc($v_data->SumStu) ?></td>
                                    
                                    <td class="text-center border-end bg-grade-high"><?= $v_data->G4_0 ?: '0' ?></td>
                                    <td class="text-center border-end bg-grade-high"><?= $v_data->G3_5 ?: '0' ?></td>
                                    <td class="text-center border-end bg-grade-high"><?= $v_data->G3_0 ?: '0' ?></td>
                                    
                                    <td class="text-center border-end"><?= $v_data->G2_5 ?: '0' ?></td>
                                    <td class="text-center border-end"><?= $v_data->G2_0 ?: '0' ?></td>
                                    <td class="text-center border-end"><?= $v_data->G1_5 ?: '0' ?></td>
                                    <td class="text-center border-end"><?= $v_data->G1_0 ?: '0' ?></td>
                                    <td class="text-center border-end text-danger fw-bold bg-grade-low"><?= $v_data->G0 ?: '0' ?></td>
                                    
                                    <td class="text-center border-end bg-status-danger"><?= $v_data->G_W ?: '0' ?></td>
                                    <td class="text-center border-end bg-status-danger"><?= $v_data->G_MS ?: '0' ?></td>
                                    
                                    <td class="text-center border-end fw-bold bg-light text-success"><?= $goodCount ?></td>
                                    <td class="text-center border-end fw-bold <?= $goodPercent >= 50 ? 'text-success' : 'text-danger' ?> bg-light">
                                        <?= number_format($goodPercent, 1) ?>%
                                    </td>
                                    <td class="text-center border-end fw-bold bg-light table-info"><?= number_format((float)$v_data->MeanGrade, 2) ?></td>
                                    <td class="text-center fw-bold bg-light"><?= number_format((float)$v_data->SDGrade, 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Correct Initialization of Select2
    $('.select2').each(function() {
        $(this).select2({ 
            theme: 'bootstrap-5',
            width: '100%'
        });
    });

    // Loading Spinner with SweetAlert2
    $('#formFilterSummary').on('submit', function() {
        if ($('#KeyYear').val() === '0') {
            Swal.fire({ icon: 'warning', title: 'กรุณาเลือกปีการศึกษา', confirmButtonColor: '#28a745' });
            return false;
        }
        Swal.fire({
            title: 'กำลังดึงข้อมูลสรุป...',
            text: 'ระบบกำลังวิเคราะห์สถิติทางการเรียนให้คุณ กรุณารอสักครู่',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });
        return true;
    });

    // DataTable for Export Buttons
    if ($('#ReportSummaryTeacher').length && !$.fn.DataTable.isDataTable('#ReportSummaryTeacher')) {
        let table = $('#ReportSummaryTeacher').DataTable({
            dom: 'rt',
            buttons: [
                { 
                    extend: 'excelHtml5', 
                    text: '<i class="bx bxs-file-export me-1"></i> Excel',
                    className: 'btn btn-success btn-sm border-0 shadow-sm me-1',
                    title: 'สรุปผลสัมฤทธิ์ทางการเรียน_<?= esc($KeyYear ?? "") ?>'
                },
                { 
                    extend: 'print', 
                    text: '<i class="bx bx-printer me-1"></i> พิมพ์รายงาน',
                    className: 'btn btn-outline-secondary btn-sm border-0 shadow-sm'
                }
            ],
            ordering: false,
            paging: false,
            info: false,
            autoWidth: false
        });
        table.buttons().container().appendTo('#exportSummaryButtons');
    }
});
</script>
<?= $this->endSection() ?>