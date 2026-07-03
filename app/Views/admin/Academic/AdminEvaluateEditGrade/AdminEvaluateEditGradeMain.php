<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
    :root {
        --primary-green: #15a362;
        --primary-green-hover: #128c53;
        --primary-green-rgb: 21, 163, 98;
        --soft-green: #f0faf5;
        --card-shadow: 0 8px 26px rgba(0, 0, 0, 0.04);
        --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .page-title-wrapper {
        border-left: 5px solid var(--primary-green);
        padding-left: 15px;
    }

    .card-premium {
        border: none;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        background: #ffffff;
        transition: var(--transition-smooth);
        overflow: hidden;
    }

    .card-premium:hover {
        box-shadow: 0 12px 30px rgba(21, 163, 98, 0.08);
    }

    .table-premium thead th {
        background-color: var(--primary-green) !important;
        color: #ffffff !important;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        border: none;
        padding: 14px;
    }

    .table-premium tbody td {
        vertical-align: middle;
        padding: 14px;
        border-color: #f1f5f9;
        color: #334155;
    }

    .btn-action-edit {
        background-color: var(--primary-green) !important;
        border-color: var(--primary-green) !important;
        color: #ffffff !important;
        font-weight: 600;
        border-radius: 8px;
        padding: 6px 16px;
        box-shadow: 0 4px 10px rgba(21, 163, 98, 0.15);
        transition: var(--transition-smooth);
    }

    .btn-action-edit:hover {
        background-color: var(--primary-green-hover) !important;
        border-color: var(--primary-green-hover) !important;
        transform: translateY(-1px);
        box-shadow: 0 6px 14px rgba(21, 163, 98, 0.25);
        color: #ffffff !important;
    }

    /* Customizing DataTables elements to match theme */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: var(--primary-green) !important;
        border-color: var(--primary-green) !important;
        color: white !important;
    }

    .form-select-custom {
        font-weight: 700; 
        color: var(--primary-green); 
        border-radius: 8px; 
        border: 1.5px solid rgba(21, 163, 98, 0.2);
        padding: 5px 12px;
        background-color: var(--soft-green);
        transition: var(--transition-smooth);
    }

    .form-select-custom:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(21, 163, 98, 0.15);
        outline: none;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div class="page-title-wrapper d-flex flex-column justify-content-center">
            <h4 class="fw-bold mb-1" style="color: #1e293b;">จัดการข้อมูล<?= isset($title) ? esc($title) : '' ?></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?=base_url('Admin/Home');?>">หน้าหลัก</a></li>
                    <li class="breadcrumb-item active" aria-current="page">ประเมินผลการเรียน</li>
                </ol>
            </nav>
        </div>
        
        <!-- Year filter select box -->
        <div class="card p-2 shadow-sm border-0 d-flex flex-row align-items-center bg-white rounded-3">
            <div class="me-2 fw-semibold text-muted" style="font-size: 0.9rem;">
                <i class='bx bx-calendar-event me-1 text-success fs-5'></i> ปีการศึกษา:
            </div>
            <div>
                <select name="onoff_year" id="onoff_year" class="form-select form-select-sm form-select-custom">
                    <?php foreach ($CheckYearRegis as $key => $value) : ?>
                    <option <?= isset($value->RegisterYear) && $currentYear == $value->RegisterYear ?"selected":"" ?>
                        value="<?= isset($value->RegisterYear) ? esc($value->RegisterYear) : '' ?>"><?= isset($value->RegisterYear) ? esc($value->RegisterYear) : '' ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card card-premium">
        <div class="card-body p-0">
            <div class="p-3 bg-light-success text-success d-flex align-items-center gap-2 border-bottom" style="background-color: rgba(21, 163, 98, 0.05); font-size: 0.9rem;">
                <i class='bx bx-info-circle fs-5'></i>
                <div class="fw-semibold">
                    กรุณาเลือกรายวิชาด้านล่างเพื่อเปิดหน้าจัดการคะแนนและเวลาเรียนรายคน
                </div>
            </div>
            <div class="table-responsive p-3">
                <table class="table table-premium table-hover mb-0" id="Tb_Repeat">
                    <thead class="text-center">
                        <tr>
                            <th class="cell" width="150">ปีการศึกษา</th>
                            <th class="cell">รายวิชา</th>
                            <th class="cell">ครูผู้สอน</th>
                            <th class="cell" width="160">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($result)): ?>
                        <?php foreach ($result as $key => $v_result) : ?>
                        <tr>
                            <td class="cell text-center fw-bold">
                                <span class="badge bg-label-success px-3 py-2 rounded-pill"><?= isset($v_result->RegisterYear) ? esc($v_result->RegisterYear) : '' ?></span>
                            </td>
                            <td class="cell fw-semibold">
                                <span class="d-block text-slate"><?= (isset($v_result->SubjectCode) ? esc($v_result->SubjectCode) : '') ?></span>
                                <small class="text-muted"><?= (isset($v_result->SubjectName) ? esc($v_result->SubjectName) : '') ?></small>
                            </td>
                            <td class="cell text-muted">
                                <i class='bx bx-user me-1'></i> <?= (isset($v_result->pers_prefix) ? esc($v_result->pers_prefix) : '').(isset($v_result->pers_firstname) ? esc($v_result->pers_firstname) : '').' '.(isset($v_result->pers_lastname) ? esc($v_result->pers_lastname) : '') ?>
                            </td>
                            <td class="cell text-center">
                                <a href="<?= site_url('Admin/Acade/Evaluate/EditGrade/'.(isset($v_result->RegisterYear) ? esc($v_result->RegisterYear, 'url') : '').'/'.(isset($v_result->SubjectID) ? esc($v_result->SubjectID, 'url') : '')) ?>"
                                    class="btn btn-sm btn-action-edit d-inline-flex align-items-center gap-1">
                                    <i class="bx bx-edit-alt fs-6"></i> แก้ไขคะแนน
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Sort academic year dropdown
    var $onoffYearSelect = $('#onoff_year');
    var options = $onoffYearSelect.find('option').get();

    options.sort(function(a, b) {
        var aVal = a.value.split('/');
        var bVal = b.value.split('/');

        var aTerm = parseInt(aVal[0]);
        var aYear = parseInt(aVal[1]);
        var bTerm = parseInt(bVal[0]);
        var bYear = parseInt(bVal[1]);

        if (aYear !== bYear) {
            return bYear - aYear; // Sort by year descending (latest first)
        }
        return bTerm - aTerm; // Then by term descending
    });

    $onoffYearSelect.empty().append(options); // Clear and re-append sorted options

    $('#Tb_Repeat').DataTable({
        "responsive": true,
        "autoWidth": false,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/th.json"
        }
    });

    // Handle year filter change
    $('#onoff_year').on('change', function() {
        var selectedYear = $(this).val();
        window.location.href = '<?= site_url('Admin/Acade/Evaluate/EditGrade/') ?>' + selectedYear;
    });
});
</script>
<?= $this->endSection() ?>
