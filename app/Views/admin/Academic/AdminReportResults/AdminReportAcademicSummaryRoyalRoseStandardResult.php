<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
    :root {
        --primary-green: #15a362;
        --dark-green: #1d4310;
        --light-green: #ABDD93;
        --glass-bg: rgba(255, 255, 255, 0.9);
    }

    /* Hero Section - The Royal Look */
    .hero-royal {
        background: #15a362;
        background: linear-gradient(135deg, #15a362 0%, #0d6d41 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 10px 30px rgba(21, 163, 98, 0.2);
        position: relative;
        overflow: hidden;
    }

    .hero-royal::after {
        content: '';
        position: absolute;
        bottom: -30%;
        right: -10%;
        width: 250px;
        height: 250px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    /* Stats Widgets (Premium Glass Cards) */
    .widget-glass {
        background: #fff;
        border-radius: 15px;
        padding: 1.25rem;
        border: 1px solid #edf2f9;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .widget-glass:hover { transform: translateY(-5px); }
    .widget-glass .icon-box {
        width: 50px;
        height: 50px;
        background: rgba(21, 163, 98, 0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-green);
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    /* Professional Table */
    #RoyalRoseTable {
        border-collapse: collapse !important;
        width: 100%;
        border: 2px solid var(--primary-green);
        border-radius: 15px;
        overflow: hidden;
    }

    #RoyalRoseTable thead th {
        background-color: var(--light-green) !important;
        border: 1px solid var(--primary-green) !important;
        color: #000 !important;
        font-weight: 700;
        vertical-align: middle !important;
        padding: 12px 5px !important;
        font-size: 0.85rem;
    }

    #RoyalRoseTable tbody td {
        border: 1px solid #e9ecef;
        vertical-align: middle;
        padding: 10px 5px !important;
        font-size: 0.85rem;
    }

    .col-highlight-good { background-color: rgba(21, 163, 98, 0.08) !important; font-weight: bold; color: var(--primary-green) !important; }
    .footer-summary { background-color: #fcfcfc; border-top: 2px solid var(--primary-green) !important; font-weight: bold; }

    .fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
        opacity: 0;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container-fluid flex-grow-1 container-p-y">
    <!-- Hero Header -->
    <div class="hero-royal fade-in-up">
        <div class="row align-items-center">
            <div class="col-md-7">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mb-1">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">วิชาการ</a></li>
                        <li class="breadcrumb-item active text-white">มาตรฐานกุหลาบหลวง</li>
                    </ol>
                </nav>
                <h3 class="fw-bold mb-1 text-white"><i class='bx bxs-award me-2'></i>สถิติตามเกณฑ์มาตรฐานโครงการกุหลาบหลวง</h3>
                <p class="mb-0 text-white-50 opacity-75 small">ปีการศึกษา <?= esc($KeyYear) ?> | ระดับชั้น <?= esc($KeyLevel) ?></p>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                    <a href="<?= site_url('Admin/Acade/Evaluate/ReportAcademicSummaryRoyalRoseStandard?SelLevel='.esc($KeyLevel).'&KeyYear='.urlencode($KeyYear)) ?>" 
                       class="btn btn-white bg-white text-success shadow-sm btn-sm px-3 rounded-pill bold me-2">
                        <i class='bx bx-edit-alt me-1'></i> ปรับปรุงรายวิชา
                    </a>
                    <form action="<?= site_url('Admin/Acade/Evaluate/ReportAcademicSummaryRoyalRoseStandard/Export') ?>" method="post" class="d-inline">
                        <?= csrf_field() ?>
                        <input type="hidden" name="SelLevel" value="<?= esc($KeyLevel) ?>">
                        <input type="hidden" name="KeyYear" value="<?= esc($KeyYear) ?>">
                        <?php if(isset($selected_subjects)): ?>
                            <?php foreach($selected_subjects as $subId): ?>
                                <input type="hidden" name="selected_subjects[]" value="<?= esc($subId) ?>">
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-success shadow-sm btn-sm px-3 rounded-pill bold">
                            <i class='bx bxs-spreadsheet me-1'></i> ดาวน์โหลด Excel
                        </button>
                    </form>
                    <div id="exportSummaryButtons" class="d-inline"></div>
                </div>
            </div>
        </div>
    </div>

    <?php if(!empty($Showdata)):?>
    <?php 
        $grandTotalStu = 0; $grandGoodTotal = 0;
        foreach ($Showdata as $v) {
            $grandTotalStu += (int)$v->TotalStu;
            $grandGoodTotal += (int)$v->G4_0 + (int)$v->G3_5 + (int)$v->G3_0;
        }
        $overallPercent = $grandTotalStu > 0 ? ($grandGoodTotal / $grandTotalStu) * 100 : 0;
    ?>

    <!-- Responsive Stats Panels -->
    <div class="row g-3 mb-4 fade-in-up" style="animation-delay: 0.1s;">
        <div class="col col-6 col-lg-3">
            <div class="widget-glass d-flex align-items-center">
                <div class="icon-box me-3 m-0"><i class='bx bx-book-bookmark'></i></div>
                <div>
                    <h6 class="text-muted small mb-0">สาระฯ ท่ีประมวลผล</h6>
                    <h4 class="mb-0 fw-bold"><?= count($Showdata) ?></h4>
                </div>
            </div>
        </div>
        <div class="col col-6 col-lg-3">
            <div class="widget-glass d-flex align-items-center">
                <div class="icon-box me-3 m-0" style="background: rgba(3, 195, 236, 0.1); color: #03c3ec;"><i class='bx bx-group'></i></div>
                <div>
                    <h6 class="text-muted small mb-0">นักเรียนรวม (ครั้ง)</h6>
                    <h4 class="mb-0 fw-bold"><?= number_format($grandTotalStu) ?></h4>
                </div>
            </div>
        </div>
        <div class="col col-6 col-lg-3">
            <div class="widget-glass d-flex align-items-center">
                <div class="icon-box me-3 m-0" style="background: rgba(113, 221, 55, 0.1); color: #71dd37;"><i class='bx bxs-star'></i></div>
                <div>
                    <h6 class="text-muted small mb-0">จำนวนเกรดดี (3+)</h6>
                    <h4 class="mb-0 fw-bold"><?= number_format($grandGoodTotal) ?></h4>
                </div>
            </div>
        </div>
        <div class="col col-6 col-lg-3">
            <div class="widget-glass d-flex align-items-center bg-success text-white">
                <div class="icon-box me-3 m-0 bg-white bg-opacity-20 text-white"><i class='bx bx-tachometer'></i></div>
                <div>
                    <h6 class="text-white-50 small mb-0">ร้อยละรวม (KPI)</h6>
                    <h4 class="mb-0 fw-bold text-white"><?= number_format($overallPercent, 2) ?>%</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Table Section -->
    <div class="fade-in-up" style="animation-delay: 0.2s;">
        <div class="bg-white" style="border-radius: 12px; border: 2px solid var(--primary-green); overflow: hidden;">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="RoyalRoseTable">
                    <thead>
                        <tr class="text-center">
                            <th rowspan="2" class="text-start" style="padding-left: 15px !important;">กลุ่มสาระการเรียนรู้</th>
                            <th rowspan="2" style="width: 80px;">นักเรียน<br>เข้าสอบ</th>
                            <th colspan="8">จำนวนนักเรียนที่ได้รับเกรด</th>
                            <th rowspan="2" class="bg-primary text-white border-primary" style="width: 80px;">รวม<br>3 ขึ้นไป</th>
                            <th rowspan="2" class="bg-primary text-white border-primary" style="width: 80px;">ร้อยละ<br>3 ขึ้นไป</th>
                        </tr>
                        <tr class="text-center">
                            <th class="table-active">4</th>
                            <th class="table-active">3.5</th>
                            <th class="table-active">3</th>
                            <th>2.5</th>
                            <th>2</th>
                            <th>1.5</th>
                            <th>1</th>
                            <th class="text-danger bg-light">0,ร,มส</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $totG4 = 0; $totG35 = 0; $totG3 = 0; $totG25 = 0; $totG2 = 0; 
                            $totG15 = 0; $totG1 = 0; $totG0 = 0;

                            foreach ($Showdata as $v_data): 
                                $rowGoodTotal = (int)$v_data->G4_0 + (int)$v_data->G3_5 + (int)$v_data->G3_0;
                                $rowTotal = (int)$v_data->TotalStu;
                                $rowGoodPercent = $rowTotal > 0 ? ($rowGoodTotal / $rowTotal) * 100 : 0;
                                
                                $totG4 += (int)$v_data->G4_0; $totG35 += (int)$v_data->G3_5; $totG3 += (int)$v_data->G3_0;
                                $totG25 += (int)$v_data->G2_5; $totG2 += (int)$v_data->G2_0; $totG15 += (int)$v_data->G1_5;
                                $totG1 += (int)$v_data->G1_0; $totG0 += (int)$v_data->G0;
                        ?>
                        <tr>
                            <td class="border-end"><strong class="text-dark ms-2"><?= esc($v_data->FirstGroup) ?></strong></td>
                            <td class="text-center border-end fw-bold table-light text-primary"><?= number_format($rowTotal) ?></td>
                            <td class="text-center border-end"><?= number_format($v_data->G4_0) ?></td>
                            <td class="text-center border-end"><?= number_format($v_data->G3_5) ?></td>
                            <td class="text-center border-end"><?= number_format($v_data->G3_0) ?></td>
                            <td class="text-center border-end"><?= number_format($v_data->G2_5) ?></td>
                            <td class="text-center border-end"><?= number_format($v_data->G2_0) ?></td>
                            <td class="text-center border-end"><?= number_format($v_data->G1_5) ?></td>
                            <td class="text-center border-end"><?= number_format($v_data->G1_0) ?></td>
                            <td class="text-center border-end text-danger bg-light"><?= number_format($v_data->G0) ?></td>
                            <td class="text-center border-end col-highlight-good"><?= number_format($rowGoodTotal) ?></td>
                            <td class="text-center col-highlight-good"><?= number_format($rowGoodPercent, 2) ?>%</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="footer-summary">
                        <tr class="table-secondary text-dark">
                            <td class="text-end fw-bold pe-3">รวมทุกกลุ่มสาระการเรียนรู้</td>
                            <td class="text-center fw-bold"><?= number_format($grandTotalStu) ?></td>
                            <td class="text-center fw-bold"><?= number_format($totG4) ?></td>
                            <td class="text-center fw-bold"><?= number_format($totG35) ?></td>
                            <td class="text-center fw-bold"><?= number_format($totG3) ?></td>
                            <td class="text-center fw-bold"><?= number_format($totG25) ?></td>
                            <td class="text-center fw-bold"><?= number_format($totG2) ?></td>
                            <td class="text-center fw-bold"><?= number_format($totG15) ?></td>
                            <td class="text-center fw-bold"><?= number_format($totG1) ?></td>
                            <td class="text-center fw-bold text-danger"><?= number_format($totG0) ?></td>
                            <td class="text-center col-highlight-good"><?= number_format($grandGoodTotal) ?></td>
                            <td class="text-center col-highlight-good"><?= number_format($overallPercent, 2) ?>%</td>
                        </tr>
                        <tr class="table-light text-muted small fw-bold">
                            <td class="text-end pe-3">ร้อยละเฉลี่ยแยกตามเกรด</td>
                            <td class="text-center">-</td>
                            <td class="text-center"><?= $grandTotalStu > 0 ? number_format(($totG4 / $grandTotalStu) * 100, 2) : '0' ?></td>
                            <td class="text-center"><?= $grandTotalStu > 0 ? number_format(($totG35 / $grandTotalStu) * 100, 2) : '0' ?></td>
                            <td class="text-center"><?= $grandTotalStu > 0 ? number_format(($totG3 / $grandTotalStu) * 100, 2) : '0' ?></td>
                            <td class="text-center"><?= $grandTotalStu > 0 ? number_format(($totG25 / $grandTotalStu) * 100, 2) : '0' ?></td>
                            <td class="text-center"><?= $grandTotalStu > 0 ? number_format(($totG2 / $grandTotalStu) * 100, 2) : '0' ?></td>
                            <td class="text-center"><?= $grandTotalStu > 0 ? number_format(($totG15 / $grandTotalStu) * 100, 2) : '0' ?></td>
                            <td class="text-center"><?= $grandTotalStu > 0 ? number_format(($totG1 / $grandTotalStu) * 100, 2) : '0' ?></td>
                            <td class="text-center"><?= $grandTotalStu > 0 ? number_format(($totG0 / $grandTotalStu) * 100, 2) : '0' ?></td>
                            <td class="text-center" colspan="2">ความสำเร็จตามเป้าหมาย (3 ขึ้นไป): <?= number_format($overallPercent, 2) ?>%</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
$(document).ready(function() {
    // Export Data with Plain DataTable
    if ($('#RoyalRoseTable').length && !$.fn.DataTable.isDataTable('#RoyalRoseTable')) {
        let table = $('#RoyalRoseTable').DataTable({
            dom: 'rt',
            ordering: false,
            paging: false,
            info: false,
            autoWidth: false,
            buttons: [
                { 
                    extend: 'excelHtml5', 
                    text: '<i class="bx bxs-file-export me-1"></i> Excel',
                    className: 'btn btn-success p-2 px-3 border-0 shadow-sm rounded-pill ms-1',
                    title: 'สรุปมาตรฐานกุหลาบหลวง_<?= esc($KeyLevel) ?>_<?= esc($KeyYear) ?>',
                    footer: true
                },
                { 
                    extend: 'print', 
                    text: '<i class="bx bx-printer me-1"></i> พิมพ์',
                    className: 'btn btn-outline-secondary p-2 px-3 border-0 shadow-sm rounded-pill ms-1',
                    footer: true
                }
            ]
        });
        table.buttons().container().appendTo('#exportSummaryButtons');
    }
});
</script>
<?= $this->endSection() ?>
