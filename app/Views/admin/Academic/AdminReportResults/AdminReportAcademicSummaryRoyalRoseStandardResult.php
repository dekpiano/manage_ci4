<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row align-items-center mb-4">
        <div class="col-12 col-md-6">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">วิชาการ / <a href="<?= site_url('Admin/Acade/Evaluate/ReportAcademicSummaryRoyalRoseStandard') ?>" class="text-muted">มาตรฐานกุหลาบหลวง</a> /</span> ผลการประมวลผล
            </h4>
        </div>
        <div class="col-12 col-md-6 text-md-end">
            <a href="<?= site_url('Admin/Acade/Evaluate/ReportAcademicSummaryRoyalRoseStandard?SelLevel='.esc($KeyLevel).'&KeyYear='.urlencode($KeyYear)) ?>" class="btn btn-outline-secondary shadow-none border-dashed">
                <i class='bx bx-redo me-1'></i> ปรับเปลี่ยนรายวิชาใหม่
            </a>
        </div>
    </div>

    <?php if(!empty($Showdata)):?>
    <?php 
        $parts = explode('/', $KeyYear);
        $termStr = $parts[0] ?? '';
        $yearStr = $parts[1] ?? '';

        // คำนวณยอดรวมทั้งหมดสำหรับ Widgets
        $grandTotalStu = 0; $grandGoodTotal = 0;
        foreach ($Showdata as $v) {
            $grandTotalStu += (int)$v->TotalStu;
            $grandGoodTotal += (int)$v->G4_0 + (int)$v->G3_5 + (int)$v->G3_0;
        }
        $overallPercent = $grandTotalStu > 0 ? ($grandGoodTotal / $grandTotalStu) * 100 : 0;
    ?>

    <!-- Summary Widgets - Green Theme -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card card-border-shadow-success h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-book-content"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0"><?= count($Showdata) ?></h4>
                    </div>
                    <p class="mb-1 fw-semibold">กลุ่มสาระฯ ที่ประมวลผล</p>
                    <p class="mb-0 text-muted small">สรุปจากรายวิชาที่ท่านเลือก</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-border-shadow-warning h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-group"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0"><?= number_format($grandTotalStu) ?></h4>
                    </div>
                    <p class="mb-1 fw-semibold">จำนวนรวม (คน/ครั้ง)</p>
                    <p class="mb-0 text-muted small">ยอดรวมนักเรียนทุกวิชา</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-border-shadow-success h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-star"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0"><?= number_format($grandGoodTotal) ?></h4>
                    </div>
                    <p class="mb-1 fw-semibold">จำนวนเกรดดี (3 ขึ้นไป)</p>
                    <p class="mb-0 text-muted small">รวม 3, 3.5, 4</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-border-shadow-success h-100 bg-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-white text-success"><i class="bx bx-tachometer"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0 text-white"><?= number_format($overallPercent, 2) ?>%</h4>
                    </div>
                    <p class="mb-1 fw-semibold">ร้อยละรวม (KPI)</p>
                    <p class="mb-0 text-white opacity-75 small">ภาพรวมมาตรฐานกุหลาบหลวง</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ผลการประมวลผล (Table View) -->
    <div class="card shadow-sm border-0 overflow-hidden">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center bg-white py-3 border-bottom">
            <div class="d-flex align-items-center me-3 mb-2 mb-sm-0">
                <div class="avatar avatar-sm me-2">
                    <span class="avatar-initial rounded-circle bg-label-success"><i class="bx bx-table fs-4"></i></span>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">ตารางสรุปมาตรฐานกุหลาบหลวง</h5>
                    <small class="text-muted">ระดับชั้น <?= esc($KeyLevel) ?> สรุปปีการศึกษา <?= esc($termStr) ?>/<?= esc($yearStr) ?></small>
                </div>
            </div>
            <div id="export-buttons"></div>
        </div>
        <div class="card-body p-0">
            <style>
                #RoyalRoseTable thead th {
                    background-color: #2d5a27;
                    color: white;
                    text-align: center;
                    border: 1px solid #1e3d1a !important;
                    font-size: 0.85rem;
                    text-transform: none;
                    vertical-align: middle;
                }
                #RoyalRoseTable tbody td { vertical-align: middle; border: 1px solid #d9dee3 !important; }
                .col-highlight-good { background-color: rgba(113, 221, 55, 0.08) !important; font-weight: bold; color: #71dd37; }
                .footer-summary-row { background-color: #f8f9fa; font-weight: bold; border-top: 2px solid #2d5a27 !important; }
                @media print {
                    .btn, .sidebar, .layout-navbar, .footer { display: none !important; }
                    .card { border: none !important; box-shadow: none !important; }
                }
            </style>
            <div class="table-responsive">
                <table class="table table-bordered m-0" id="RoyalRoseTable">
                    <thead>
                        <tr>
                            <th rowspan="2" class="text-start">กลุ่มสาระการเรียนรู้</th>
                            <th rowspan="2" style="width: 80px;">นักเรียน<br>เข้าสอบ</th>
                            <th colspan="8">จำนวนนักเรียนที่มีผลการเรียนรู้</th>
                            <th rowspan="2" class="bg-dark " style="width: 80px;">จำนวนนักเรียนที่ได้ระดับดี<br>(3 ขึ้นไป)</th>
                            <th rowspan="2" class="bg-dark " style="width: 80px;">ร้อยละระดับดีขึ้นไป<br>(3 ขึ้นไป)</th>
                        </tr>
                        <tr>
                            <th style="width: 45px;">4</th>
                            <th style="width: 45px;">3.5</th>
                            <th style="width: 45px;">3</th>
                            <th style="width: 45px;">2.5</th>
                            <th style="width: 45px;">2</th>
                            <th style="width: 45px;">1.5</th>
                            <th style="width: 45px;">1</th>
                            <th style="width: 50px;">0,ร,มส</th>
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
                            <td><span class="fw-bold text-dark"><?= esc($v_data->FirstGroup) ?></span></td>
                            <td class="text-center fw-semibold"><?= number_format($rowTotal) ?></td>
                            <td class="text-center"><?= number_format($v_data->G4_0) ?></td>
                            <td class="text-center"><?= number_format($v_data->G3_5) ?></td>
                            <td class="text-center"><?= number_format($v_data->G3_0) ?></td>
                            <td class="text-center"><?= number_format($v_data->G2_5) ?></td>
                            <td class="text-center"><?= number_format($v_data->G2_0) ?></td>
                            <td class="text-center"><?= number_format($v_data->G1_5) ?></td>
                            <td class="text-center"><?= number_format($v_data->G1_0) ?></td>
                            <td class="text-center text-danger"><?= number_format($v_data->G0) ?></td>
                            <td class="text-center col-highlight-good"><?= number_format($rowGoodTotal) ?></td>
                            <td class="text-center col-highlight-good"><?= number_format($rowGoodPercent, 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="footer-summary-row mt-3">
                        <tr class="table-secondary">
                            <td class="text-end fw-bold">รวมทั้งหมด</td>
                            <td class="text-center fw-bold"><?= number_format($grandTotalStu) ?></td>
                            <td class="text-center fw-bold"><?= number_format($totG4) ?></td>
                            <td class="text-center fw-bold"><?= number_format($totG35) ?></td>
                            <td class="text-center fw-bold"><?= number_format($totG3) ?></td>
                            <td class="text-center fw-bold"><?= number_format($totG25) ?></td>
                            <td class="text-center fw-bold"><?= number_format($totG2) ?></td>
                            <td class="text-center fw-bold"><?= number_format($totG15) ?></td>
                            <td class="text-center fw-bold"><?= number_format($totG1) ?></td>
                            <td class="text-center fw-bold"><?= number_format($totG0) ?></td>
                            <td class="text-center col-highlight-good"><?= number_format($grandGoodTotal) ?></td>
                            <td class="text-center col-highlight-good"><?= number_format($overallPercent, 2) ?></td>
                        </tr>
                        <tr class="table-light">
                            <td class="text-end fw-bold">ร้อยละแยกตามเกรด</td>
                            <td class="text-center">-</td>
                            <td class="text-center"><?= $grandTotalStu > 0 ? number_format(($totG4 / $grandTotalStu) * 100, 2) : '0' ?></td>
                            <td class="text-center"><?= $grandTotalStu > 0 ? number_format(($totG35 / $grandTotalStu) * 100, 2) : '0' ?></td>
                            <td class="text-center"><?= $grandTotalStu > 0 ? number_format(($totG3 / $grandTotalStu) * 100, 2) : '0' ?></td>
                            <td class="text-center"><?= $grandTotalStu > 0 ? number_format(($totG25 / $grandTotalStu) * 100, 2) : '0' ?></td>
                            <td class="text-center"><?= $grandTotalStu > 0 ? number_format(($totG2 / $grandTotalStu) * 100, 2) : '0' ?></td>
                            <td class="text-center"><?= $grandTotalStu > 0 ? number_format(($totG15 / $grandTotalStu) * 100, 2) : '0' ?></td>
                            <td class="text-center"><?= $grandTotalStu > 0 ? number_format(($totG1 / $grandTotalStu) * 100, 2) : '0' ?></td>
                            <td class="text-center"><?= $grandTotalStu > 0 ? number_format(($totG0 / $grandTotalStu) * 100, 2) : '0' ?></td>
                            <td class="text-center col-highlight-good">รวมร้อยละ</td>
                            <td class="text-center col-highlight-good"><?= number_format($overallPercent, 2) ?>%</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    var table = $('#RoyalRoseTable').DataTable({
        dom: 't',
        ordering: false,
        paging: false,
        language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/th.json' }
    });

    new $.fn.dataTable.Buttons(table, {
        buttons: [
            { 
                extend: 'excelHtml5', 
                text: '<i class="bx bxs-file-export me-1"></i> ส่งออก Excel', 
                className: 'btn btn-success me-2 shadow-none',
                title: 'รายงานมาตรฐานกุหลาบหลวง_<?= esc($KeyLevel) ?>',
                exportOptions: {
                    columns: ':visible',
                    footer: true
                },
                customize: function (xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    var lastRow = $('row', sheet).last();
                    var lastRowIndex = parseInt(lastRow.attr('r'));
                    
                    // ฟังก์ชันช่วยสร้าง Row ของ Excel
                    function createExcelRow(index, data) {
                        var row = '<row r="' + index + '">';
                        for (var i = 0; i < data.length; i++) {
                            var letter = String.fromCharCode(65 + i);
                            row += '<c t="inlineStr" r="' + letter + index + '" s="2">';
                            row += '<is><t>' + data[i] + '</t></is>';
                            row += '</c>';
                        }
                        row += '</row>';
                        return row;
                    }

                    // ข้อมูลแถวรวมทั้งหมด
                    var rowSum = [
                        'รวมทั้งหมด',
                        '<?= number_format($grandTotalStu) ?>',
                        '<?= number_format($totG4) ?>',
                        '<?= number_format($totG35) ?>',
                        '<?= number_format($totG3) ?>',
                        '<?= number_format($totG25) ?>',
                        '<?= number_format($totG2) ?>',
                        '<?= number_format($totG15) ?>',
                        '<?= number_format($totG1) ?>',
                        '<?= number_format($totG0) ?>',
                        '<?= number_format($grandGoodTotal) ?>',
                        '<?= number_format($overallPercent, 2) ?>'
                    ];

                    // ข้อมูลแถวร้อยละ
                    var rowPercent = [
                        'ร้อยละแยกตามเกรด',
                        '-',
                        '<?= $grandTotalStu > 0 ? number_format(($totG4 / $grandTotalStu) * 100, 2) : "0" ?>',
                        '<?= $grandTotalStu > 0 ? number_format(($totG35 / $grandTotalStu) * 100, 2) : "0" ?>',
                        '<?= $grandTotalStu > 0 ? number_format(($totG3 / $grandTotalStu) * 100, 2) : "0" ?>',
                        '<?= $grandTotalStu > 0 ? number_format(($totG25 / $grandTotalStu) * 100, 2) : "0" ?>',
                        '<?= $grandTotalStu > 0 ? number_format(($totG2 / $grandTotalStu) * 100, 2) : "0" ?>',
                        '<?= $grandTotalStu > 0 ? number_format(($totG15 / $grandTotalStu) * 100, 2) : "0" ?>',
                        '<?= $grandTotalStu > 0 ? number_format(($totG1 / $grandTotalStu) * 100, 2) : "0" ?>',
                        '<?= $grandTotalStu > 0 ? number_format(($totG0 / $grandTotalStu) * 100, 2) : "0" ?>',
                        'รวมร้อยละ',
                        '<?= number_format($overallPercent, 2) ?>%'
                    ];

                    // แทรกแถวใหม่ต่อจากแถวสุดท้าย
                    sheet.childNodes[0].childNodes[1].innerHTML += createExcelRow(lastRowIndex + 1, rowSum);
                    sheet.childNodes[0].childNodes[1].innerHTML += createExcelRow(lastRowIndex + 2, rowPercent);
                }
            },
            { 
                extend: 'print', 
                text: '<i class="bx bx-printer me-1"></i> พิมพ์รายงาน', 
                className: 'btn btn-outline-success shadow-none',
                exportOptions: {
                    columns: ':visible',
                    footer: true
                }
            }
        ]
    }).container().appendTo($('#export-buttons'));
});
</script>
<?= $this->endSection() ?>
