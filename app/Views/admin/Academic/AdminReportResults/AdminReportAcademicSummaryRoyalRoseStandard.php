<?php // Note: Sorting logic should be handled in the controller.
/*
usort($CheckYear, function($a, $b) {
    list($termA, $yearA) = explode('/', $a->RegisterYear);
    list($termB, $yearB) = explode('/', $b->RegisterYear);

    if ($yearA == $yearB) {
        return $termA <=> $termB; // Sort by term
    }
    return $yearA <=> $yearB; // Sort by year
});
*/
?>

<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0"><?= isset($title) ? esc($title) : '' ?></h1>
            </div>
            <div class="col-auto">
                <div class="page-utilities">
                    <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                        <div class="col-auto">
                        <?php if((service('request')->uri->getSegment(3) ?? '') === "Executive") :?>
                            <form class="docs-search-form row gx-1 align-items-center" method="get"
                                action="<?= site_url('Admin/Acade/Executive/ReportAcademicSummaryRoyalRoseStandard') ?>">
                                <?php else: ?>
                                    <form class="docs-search-form row gx-1 align-items-center" method="get"
                                action="<?= site_url('Admin/Acade/Evaluate/ReportAcademicSummaryRoyalRoseStandard') ?>">
                                <?php endif; ?>
                                <div class="col-auto">
                                    <?php $Level = array('ม.1','ม.2','ม.3','ม.4','ม.5','ม.6') ?>
                                    <select class="form-select w-auto" name="SelLevel" id="SelLevel">
                                        <option value="0">เลือกระดับชั้น...</option>
                                        <?php foreach ($Level as $key => $v_Level) : ?>
                                        <option <?= service('request')->getGet('SelLevel') == $v_Level ? "selected" : "" ?>
                                            value="<?= esc($v_Level) ?>"><?= esc($v_Level) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <select class="form-select w-auto" name="KeyYear" id="KeyYear">
                                        <option value="0">เลือกปีการศึกษา...</option>
                                        <?php foreach ($CheckYear as $key => $v_CheckYear) : ?>
                                        <option <?= isset($KeyYear) && $KeyYear == (isset($v_CheckYear->RegisterYear) ? $v_CheckYear->RegisterYear : '') ? 'selected' : '' ?>
                                            value="<?= isset($v_CheckYear->RegisterYear) ? esc($v_CheckYear->RegisterYear) : '' ?>"><?= isset($v_CheckYear->RegisterYear) ? esc($v_CheckYear->RegisterYear) : '' ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button class="btn app-btn-primary clickLoder" type="submit">ค้นหา</button>
                                </div>
                            </form>
                        </div>
                        <!--//col-->

                    </div>
                    <!--//row-->
                </div>
                <!--//table-utilities-->
            </div>
            <!--//col-auto-->
        </div>
        <!--//row-->

        <style>
        .fixTableHead {
            overflow-y: auto;
            height: 550px;
        }

        .fixTableHead thead th {
            position: sticky;
            top: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 8px 15px;
            border: 2px solid #529432;
        }

        th {
            background: #ABDD93;
        }
        </style>
        <?php if(service('request')->getGet('SelLern') === '0'):?>
        <div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
            <div class="inner">
                <div class="app-card-body p-3 p-lg-4">
                    <h3 class="text-center"><i class="bi bi-arrow-right-circle-fill"></i> กรุณาเลือกรายการ
                        ทางปุ่มขวาบน</h3>

                </div>
                <!--//app-card-body-->

            </div>
            <!--//inner-->
        </div>
        <?php else: ?>
        <div class="app-card  shadow-sm mb-5 p-2 " style="width: 100%;">
            <div class="app-card-body">
                <div class="table-responsive fixTableHead">
                    <table class="table app-table-hover mb-0 text-left table-bordered scrollit"
                        id="ReportSummaryRoyalRoseStandard" style="">
                        <!--ReportSummaryTeacher-->
                            <thead>
                                <tr class="text-center table-success">
                                    <th class="cell text-center">กลุ่มสาระฯ</th>
                                    <th class="cell text-center">วิชา</th>
                                    <th class="cell text-center">จำนวนนักเรียน</th>
                                    <th class="cell text-center">4</th>
                                    <th class="cell text-center">3.5</th>
                                    <th class="cell text-center">3</th>
                                    <th class="cell text-center">2.5</th>
                                    <th class="cell text-center">2</th>
                                    <th class="cell text-center">1.5</th>
                                    <th class="cell text-center">1</th>
                                    <th class="cell text-center">0,ร,มส</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($Showdata as $key => $v_data):?>
                                <tr>
                                    <td class="cell">
                                        <?= isset($v_data->FirstGroup) ? esc($v_data->FirstGroup) : '' ?>
                                    </td>
                                    <td class="cell">
                                    <?= (isset($v_data->SubjectCode) ? esc($v_data->SubjectCode) : '').' '.(isset($v_data->SubjectName) ? esc($v_data->SubjectName) : '') ?>
                                    </td>
                                    <td class="cell row-total text-center">
                                        
                                    </td>
                                    <td class="cell text-center sum-cell PC_Good"><?= isset($v_data->G4_0) ? esc($v_data->G4_0) : '' ?></td>
                                    <td class="cell text-center sum-cell PC_Good"><?= isset($v_data->G3_5) ? esc($v_data->G3_5) : '' ?></td>
                                    <td class="cell text-center sum-cell PC_Good"><?= isset($v_data->G3_0) ? esc($v_data->G3_0) : '' ?></td>
                                    <td class="cell text-center sum-cell"><?= isset($v_data->G2_5) ? esc($v_data->G2_5) : '' ?></td>
                                    <td class="cell text-center sum-cell"><?= isset($v_data->G2_0) ? esc($v_data->G2_0) : '' ?></td>
                                    <td class="cell text-center sum-cell"><?= isset($v_data->G1_5) ? esc($v_data->G1_5) : '' ?></td>
                                    <td class="cell text-center sum-cell"><?= isset($v_data->G1_0) ? esc($v_data->G1_0) : '' ?></td>
                                    <td class="cell text-center sum-cell"><?= isset($v_data->G0) ? esc($v_data->G0) : '' ?></td>
                                </tr>
                                <?php endforeach; ?>

                            </tbody>
                    </table>
                </div>
                <!--//table-responsive-->
               
            </div>
            <!--//app-card-body-->
        </div>
        <?php endif; ?>

    </div>
    <!--//container-fluid-->
</div>
<!--//app-content-->
<?= $this->endSection() ?>
