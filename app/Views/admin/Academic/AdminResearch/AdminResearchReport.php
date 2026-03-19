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
</style>

<!-- Stats Calculation (Simple PHP Logic based on data) -->
<?php
    $total = isset($submissions) ? count($submissions) : 0;
    $submitted = 0;
    $notSubmitted = 0;
    
    if (isset($submissions)) {
        foreach ($submissions as $sub) {
            if (isset($sub->seres_ID)) {
                $submitted++;
            } else {
                $notSubmitted++;
            }
        }
    }
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">งานวิชาการ /</span> รายงานการวิจัย
            </h4>
            <div class="text-muted">ติดตามสถานะการส่งงานวิจัยในชั้นเรียน</div>
        </div>
    </div>

    <!-- Dashboard Stats -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-4">
            <div class="card stat-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-primary"><?= $total ?></div>
                            <div class="stat-label">ครูทั้งหมดในกลุ่มสาระ</div>
                        </div>
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bx bx-group"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="card stat-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-success"><?= $submitted ?></div>
                            <div class="stat-label">ส่งงานวิจัยแล้ว</div>
                        </div>
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="bx bx-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="card stat-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-danger"><?= $notSubmitted ?></div>
                            <div class="stat-label">ยังไม่ส่ง</div>
                        </div>
                        <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                            <i class="bx bx-x-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filter Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
             <form action="<?= base_url('Admin/Acade/Research/Report') ?>" method="post" class="row g-3 align-items-center">
                 <?= csrf_field() ?>
                <div class="col-md-3">
                    <label class="form-label fw-bold small text-uppercase">กลุ่มสาระ</label>
                    <select name="learning_group" id="learning_group" class="form-select form-select-sm">
                        <option value="">ทั้งหมด</option>
                        <?php if (isset($learning_groups)) : ?>
                            <?php foreach ($learning_groups as $group) : ?>
                                <option value="<?= esc($group->lear_id) ?>" <?= (isset($selected_group) && $selected_group == $group->lear_id) ? 'selected' : '' ?>>
                                    <?= esc($group->lear_namethai) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold small text-uppercase">ปีการศึกษา</label>
                    <select name="academic_year" id="academic_year" class="form-select form-select-sm">
                        <option value="">ทั้งหมด</option>
                        <?php if (isset($academic_years)) : ?>
                            <?php foreach ($academic_years as $year) : ?>
                                <option value="<?= esc($year->seres_year) ?>" <?= (isset($selected_year) && $selected_year == $year->seres_year) ? 'selected' : '' ?>>
                                    <?= esc($year->seres_year) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold small text-uppercase">ภาคเรียน</label>
                     <select name="term" id="term" class="form-select form-select-sm">
                        <option value="">ทั้งหมด</option>
                        <option value="1" <?= (isset($selected_term) && $selected_term == '1') ? 'selected' : '' ?>>1</option>
                        <option value="2" <?= (isset($selected_term) && $selected_term == '2') ? 'selected' : '' ?>>2</option>
                        <option value="3" <?= (isset($selected_term) && $selected_term == '3') ? 'selected' : '' ?>>3</option>
                    </select>
                </div>
                 <div class="col-md-2">
                    <label class="form-label d-none d-md-block">&nbsp;</label>
                    <button type="submit" class="btn btn-primary btn-sm w-100"><i class="bx bx-filter"></i> กรองข้อมูล</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
             <h5 class="card-title mb-0">
                <i class="bx bx-list-check me-2"></i>รายการส่งงานวิจัย
                <?php if (isset($selected_group_name)) : ?>
                    <span class="badge bg-label-info ms-2"><?= esc($selected_group_name) ?></span>
                <?php endif; ?>
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table id="researchReportTable" class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ครูผู้สอน</th>
                            <th>ชื่องานวิจัย</th>
                            <th class="text-center">ปี/ภาค</th>
                            <th class="text-center">สถานะ</th>
                            <th class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($submissions) && !empty($submissions)) : ?>
                            <?php foreach ($submissions as $submission) : ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                 <img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?= esc($submission->pers_img ?? '') ?>" 
                                                      onerror="this.src='<?= base_url('assets/img/avatars/1.png') ?>'" 
                                                      alt="Avatar" class="rounded-circle">
                                            </div>
                                            <div>
                                                <div class="fw-bold"><?= esc($submission->pers_prefix . $submission->pers_firstname . ' ' . $submission->pers_lastname) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="max-width: 350px;">
                                        <?php if(isset($submission->seres_research_name)): ?>
                                            <div class="text-truncate" data-bs-toggle="tooltip" data-bs-placement="top" title="<?= esc($submission->seres_research_name) ?>" style="cursor: pointer;">
                                                <?= esc($submission->seres_research_name) ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted fst-italic">- ยังไม่ระบุ -</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if(isset($submission->seres_year)): ?>
                                         <span class="badge bg-label-secondary"><?= $submission->seres_term ?>/<?= $submission->seres_year ?></span>
                                        <?php else: ?>
                                         -
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if (isset($submission->seres_ID)) : ?>
                                            <span class="badge bg-success bg-opacity-75"><i class="bx bx-check me-1"></i>ส่งแล้ว</span>
                                        <?php else : ?>
                                            <span class="badge bg-danger bg-opacity-75"><i class="bx bx-x me-1"></i>ยังไม่ส่ง</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                         <?php if (isset($submission->seres_file) && !empty($submission->seres_file)) : ?>
                                            <?php 
                                            // Fallback for research_base_url if not passed from controller, though it should be.
                                            $baseUrl = isset($research_base_url) ? $research_base_url : base_url('uploads/research/'); 
                                            ?>
                                            <a href="<?= $baseUrl . $submission->seres_year ?>/<?= $submission->seres_term ?>/<?= $submission->seres_file ?>" 
                                               class="btn btn-sm btn-label-primary" target="_blank">
                                               <i class="bx bx-download me-1"></i>ดาวน์โหลด
                                            </a>
                                        <?php else : ?>
                                            <button class="btn btn-sm btn-label-secondary" disabled>ไม่มีไฟล์</button>
                                        <?php endif; ?>
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
        const initializeTooltips = () => {
             var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
             var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
             });
        };

        $('#researchReportTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/th.json'
            },
            responsive: true,
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            pageLength: 25,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'ทั้งหมด']
            ],
            drawCallback: function() {
                initializeTooltips();
            }
        });
    });
</script>
<?= $this->endSection() ?>
