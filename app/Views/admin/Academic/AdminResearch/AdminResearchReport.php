<?= $this->extend('admin/layout/main') ?>

<?= $this->section('extra_css') ?>
<style>
/* Modern Emerald UI Styles */
.report-header {
    background: linear-gradient(135deg, #15a362 0%, #0d6d41 100%);
    color: white;
    border-radius: 1rem;
    padding: 2.5rem 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(21, 163, 98, 0.15);
    position: relative;
    overflow: hidden;
}
.report-header::after {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
    border-radius: 50%;
}
.stat-card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 5px 20px rgba(0,0,0,0.03);
    transition: all 0.3s ease;
    background: #fff;
    position: relative;
    overflow: hidden;
}
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(21, 163, 98, 0.1);
}
.stat-card::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 4px;
    background-color: #15a362;
    opacity: 0;
    transition: opacity 0.3s ease;
}
.stat-card:hover::before {
    opacity: 1;
}
.stat-icon-box {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 1rem;
    font-size: 2rem;
    background: rgba(21, 163, 98, 0.1);
    color: #15a362;
    transition: all 0.3s ease;
}
.stat-card:hover .stat-icon-box {
    background: #15a362;
    color: #fff;
    transform: scale(1.1) rotate(5deg);
}
.stat-card-danger .stat-icon-box {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}
.stat-card-danger:hover .stat-icon-box {
    background: #dc3545;
    color: #fff;
}
.stat-card-danger::before {
    background-color: #dc3545;
}
.stat-value {
    font-size: 2.2rem;
    font-weight: 800;
    line-height: 1.1;
    color: #2c3e50;
    margin-bottom: 0.25rem;
}
.stat-label {
    font-size: 0.95rem;
    color: #6c757d;
    font-weight: 500;
}
.filter-card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 5px 20px rgba(0,0,0,0.03);
    background: #fff;
}
.form-select, .form-control {
    border-radius: 0.5rem;
    padding: 0.6rem 1rem;
    border: 1px solid #e0e0e0;
}
.form-select:focus, .form-control:focus {
    border-color: #15a362;
    box-shadow: 0 0 0 0.25rem rgba(21, 163, 98, 0.25);
}
.btn-emerald {
    background-color: #15a362;
    border-color: #15a362;
    color: white;
    font-weight: 600;
    border-radius: 0.5rem;
    padding: 0.6rem 1.5rem;
    transition: all 0.3s ease;
}
.btn-emerald:hover {
    background-color: #0d6d41;
    border-color: #0d6d41;
    color: white;
    box-shadow: 0 4px 12px rgba(21, 163, 98, 0.3);
    transform: translateY(-2px);
}
.table-card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 5px 20px rgba(0,0,0,0.03);
    overflow: hidden;
}
.custom-table th {
    background-color: #f8f9fa !important;
    color: #495057 !important;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
    padding: 1rem;
    border-bottom: 2px solid #e9ecef;
}
.custom-table td {
    padding: 1rem;
    vertical-align: middle;
    border-bottom: 1px solid #f1f3f5;
}
.custom-table tbody tr {
    transition: all 0.2s ease;
}
.custom-table tbody tr:hover {
    background-color: #f8fbf9 !important;
}
.badge-emerald {
    background-color: rgba(21, 163, 98, 0.15);
    color: #0d6d41;
    border: 1px solid rgba(21, 163, 98, 0.3);
    font-weight: 600;
    padding: 0.4em 0.8em;
    border-radius: 6px;
}
.badge-group-pill {
    background-color: rgba(21, 163, 98, 0.08);
    color: #15a362;
    border: 1px solid rgba(21, 163, 98, 0.25);
    font-weight: 600;
    padding: 0.35em 0.75em;
    border-radius: 50px;
    font-size: 0.82rem;
    display: inline-flex;
    align-items: center;
}
.badge-order-pill {
    background-color: #f1f3f5;
    color: #495057;
    border: 1px solid #dee2e6;
    font-weight: 600;
    padding: 0.2em 0.55em;
    border-radius: 4px;
    font-size: 0.75rem;
}
</style>
<?= $this->endSection() ?>

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

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Modern Header -->
    <div class="report-header d-flex flex-column flex-md-row justify-content-between align-items-center">
        <div class="d-flex align-items-center mb-3 mb-md-0 zindex-1">
            <div class="bg-white text-emerald rounded-circle d-flex align-items-center justify-content-center me-4 shadow" style="width: 70px; height: 70px;">
                <i class="bx bx-pie-chart-alt-2 fs-1"></i>
            </div>
            <div>
                <h3 class="fw-bold mb-1 text-white">รายงานสถานะการส่งงานวิจัย</h3>
                <p class="mb-0 text-white-50 fs-6">ติดตามและตรวจสอบสถานะการส่งงานวิจัยของครูผู้สอนในแต่ละกลุ่มสาระ</p>
            </div>
        </div>
        <div class="zindex-1 text-end">
             <div class="text-white-50 small mb-1">กลุ่มสาระที่เลือก</div>
             <div class="badge bg-white text-emerald fs-6 px-3 py-2 rounded-pill shadow-sm">
                 <?= isset($selected_group_name) && !empty($selected_group_name) ? esc($selected_group_name) : 'ทุกกลุ่มสาระการเรียนรู้' ?>
             </div>
        </div>
    </div>

    <!-- Dashboard Stats -->
    <div class="row g-4 mb-5">
        <div class="col-sm-6 col-xl-4">
            <div class="card stat-card h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stat-label mb-1">ครูทั้งหมด (คน)</div>
                            <div class="stat-value text-dark"><?= $total ?></div>
                        </div>
                        <div class="stat-icon-box" style="background: rgba(67, 89, 113, 0.1); color: #435971;">
                            <i class="bx bx-group"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="card stat-card h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stat-label mb-1">ส่งงานวิจัยแล้ว (คน)</div>
                            <div class="stat-value text-emerald"><?= $submitted ?></div>
                        </div>
                        <div class="stat-icon-box">
                            <i class="bx bx-check-shield"></i>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top border-light">
                        <small class="text-muted"><i class='bx bx-trending-up text-emerald me-1'></i> อัตราการส่ง: <?= $total > 0 ? round(($submitted/$total)*100, 1) : 0 ?>%</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="card stat-card stat-card-danger h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stat-label mb-1">ยังไม่ส่ง (คน)</div>
                            <div class="stat-value text-danger"><?= $notSubmitted ?></div>
                        </div>
                        <div class="stat-icon-box">
                            <i class="bx bx-time-five"></i>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top border-light">
                        <small class="text-muted"><i class='bx bx-info-circle text-danger me-1'></i> ต้องติดตาม: <?= $total > 0 ? round(($notSubmitted/$total)*100, 1) : 0 ?>%</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filter Card -->
    <div class="card filter-card mb-4">
        <div class="card-body p-4">
             <form action="<?= base_url('Admin/Acade/Research/Report') ?>" method="post" class="row g-3 align-items-end">
                 <?= csrf_field() ?>
                <div class="col-md-4">
                    <label class="form-label fw-bold text-dark mb-2">กลุ่มสาระการเรียนรู้</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text bg-light border-end-0"><i class="bx bx-category text-muted"></i></span>
                        <select name="learning_group" id="learning_group" class="form-select border-start-0 ps-0">
                            <option value="">-- แสดงทั้งหมด --</option>
                            <?php if (isset($learning_groups)) : ?>
                                <?php foreach ($learning_groups as $group) : ?>
                                    <option value="<?= esc($group->lear_id) ?>" <?= (isset($selected_group) && $selected_group == $group->lear_id) ? 'selected' : '' ?>>
                                        <?= esc($group->lear_namethai) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold text-dark mb-2">ปีการศึกษา</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text bg-light border-end-0"><i class="bx bx-calendar text-muted"></i></span>
                        <select name="academic_year" id="academic_year" class="form-select border-start-0 ps-0">
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
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold text-dark mb-2">ภาคเรียน</label>
                    <select name="term" id="term" class="form-select">
                        <option value="">ทั้งหมด</option>
                        <option value="1" <?= (isset($selected_term) && $selected_term == '1') ? 'selected' : '' ?>>1</option>
                        <option value="2" <?= (isset($selected_term) && $selected_term == '2') ? 'selected' : '' ?>>2</option>
                        <option value="3" <?= (isset($selected_term) && $selected_term == '3') ? 'selected' : '' ?>>3</option>
                    </select>
                </div>
                 <div class="col-md-3">
                    <button type="submit" class="btn btn-emerald w-100 shadow-sm"><i class="bx bx-filter-alt me-2"></i> ค้นหาข้อมูล</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="card table-card">
        <div class="card-body p-0">
            <div class="table-responsive text-nowrap">
                <table id="researchReportTable" class="table custom-table mb-0 w-100">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">#</th>
                            <th width="26%">ข้อมูลครูผู้สอน</th>
                            <th width="18%">กลุ่มสาระการเรียนรู้</th>
                            <th width="28%">ชื่องานวิจัย</th>
                            <th class="text-center" width="8%">ปี/ภาค</th>
                            <th class="text-center" width="8%">สถานะ</th>
                            <th class="text-center" width="7%">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($submissions) && !empty($submissions)) : ?>
                            <?php $idx = 1; foreach ($submissions as $submission) : ?>
                                <tr>
                                    <td class="text-center text-muted fw-bold"><?= $idx++ ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-md me-3">
                                                 <img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?= esc($submission->pers_img ?? '') ?>" 
                                                      onerror="this.src='<?= base_url('assets/img/avatars/1.png') ?>'" 
                                                      alt="Avatar" class="rounded-circle border border-2 border-light shadow-sm">
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark fs-6"><?= esc($submission->pers_prefix . $submission->pers_firstname . ' ' . $submission->pers_lastname) ?></div>
                                                <div class="d-flex align-items-center gap-1 mt-1">
                                                    <small class="text-muted"><i class="bx bx-id-card me-1"></i><?= esc($submission->pers_id) ?></small>
                                                    <?php if (!empty($submission->pers_numberGroup)): ?>
                                                        <span class="badge badge-order-pill ms-1" title="ลำดับในกลุ่มสาระ">
                                                            <i class="bx bx-list-ol text-emerald me-1"></i>ลำดับที่ <?= esc($submission->pers_numberGroup) ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-group-pill">
                                            <i class="bx bx-book-open me-1"></i><?= esc($submission->lear_namethai ?? 'ไม่ระบุ') ?>
                                        </span>
                                    </td>
                                    <td style="max-width: 320px; white-space: normal;">
                                        <?php if(isset($submission->seres_research_name)): ?>
                                            <div class="fw-medium text-dark" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" title="<?= esc($submission->seres_research_name) ?>">
                                                <i class="bx bx-file-blank text-emerald me-1"></i> <?= esc($submission->seres_research_name) ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted"><i class="bx bx-minus"></i> ยังไม่มีข้อมูล</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if(isset($submission->seres_year)): ?>
                                         <span class="badge bg-light text-dark border shadow-sm px-3 py-2"><?= $submission->seres_term ?>/<?= $submission->seres_year ?></span>
                                        <?php else: ?>
                                         -
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if (isset($submission->seres_ID)) : ?>
                                            <span class="badge-emerald"><i class="bx bx-check-circle me-1"></i>ส่งแล้ว</span>
                                        <?php else : ?>
                                            <span class="badge-danger-soft"><i class="bx bx-x-circle me-1"></i>ยังไม่ส่ง</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                         <?php if (isset($submission->seres_file) && !empty($submission->seres_file)) : ?>
                                            <?php 
                                            // Fallback for research_base_url if not passed from controller
                                            $baseUrl = isset($research_base_url) ? $research_base_url : base_url('uploads/research/'); 
                                            ?>
                                            <a href="<?= $baseUrl . $submission->seres_year ?>/<?= $submission->seres_term ?>/<?= $submission->seres_file ?>" 
                                               class="btn btn-sm btn-outline-emerald" style="border-color: #15a362; color: #15a362;" target="_blank">
                                               <i class="bx bx-cloud-download me-1"></i>โหลดไฟล์
                                            </a>
                                        <?php else : ?>
                                            <button class="btn btn-sm btn-light text-muted" disabled style="background: #f8f9fa;">-</button>
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
        $('#researchReportTable').DataTable({
            order: [], // ใช้ลำดับที่จัดเรียงตามกลุ่มสาระ และลำดับในกลุ่มจาก Controller
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/th.json'
            },
            responsive: true,
            dom: '<"row p-4 pb-0"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row p-4 pt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            pageLength: 25,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'ทั้งหมด']
            ],
            // Custom Styling for DataTables Input elements
            initComplete: function() {
                $('.dataTables_length select').addClass('form-select form-select-sm d-inline-block w-auto mx-2');
                $('.dataTables_filter input').addClass('form-control form-control-sm d-inline-block w-auto ms-2').attr('placeholder', 'ค้นหา...');
                $('.dataTables_paginate .pagination').addClass('pagination-sm mb-0');
            }
        });

        // Hover effect for outline buttons
        $('.btn-outline-emerald').hover(
            function() { $(this).css({'background-color': '#15a362', 'color': 'white'}); },
            function() { $(this).css({'background-color': 'transparent', 'color': '#15a362'}); }
        );
    });
</script>
<?= $this->endSection() ?>
