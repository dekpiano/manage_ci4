<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>

<style>
    :root {
        --primary-emerald: #15a362;
        --dark-emerald: #0d6d41;
        --light-emerald: #e8f5ee;
        --border-radius: 16px;
    }

    /* SweetAlert2 z-index fix */
    .swal2-container {
        z-index: 9999 !important;
    }

    /* Hero Header */
    .hero-master-subjects {
        background: linear-gradient(135deg, var(--primary-emerald) 0%, var(--dark-emerald) 100%);
        border-radius: var(--border-radius);
        padding: 2.5rem;
        color: white;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(21, 163, 98, 0.15);
    }

    .hero-master-subjects::after {
        content: '';
        position: absolute;
        bottom: -20%;
        right: -5%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.06);
        border-radius: 50%;
        pointer-events: none;
    }

    /* Stats Card Premium */
    .stat-card-premium {
        border: none;
        border-radius: var(--border-radius);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: white;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    }

    .stat-card-premium:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08);
    }

    .stat-icon-box {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        transition: all 0.3s;
    }

    .stat-card-premium:hover .stat-icon-box {
        transform: scale(1.1) rotate(-5deg);
    }

    /* Cards and Table */
    .settings-card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        background: white;
    }

    .settings-card-header {
        background-color: white;
        border-bottom: 1px solid #f1f3f5;
        padding: 1.5rem;
        border-top-left-radius: var(--border-radius);
        border-top-right-radius: var(--border-radius);
    }

    .icon-wrapper {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--light-emerald);
        color: var(--primary-emerald);
        font-size: 1.2rem;
    }

    .btn-emerald {
        background-color: var(--primary-emerald);
        border-color: var(--primary-emerald);
        color: white;
        border-radius: 10px;
        padding: 0.6rem 1.25rem;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-emerald:hover {
        background-color: var(--dark-emerald);
        border-color: var(--dark-emerald);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(21, 163, 98, 0.2);
    }

    .btn-outline-emerald {
        border: 2px solid var(--primary-emerald);
        color: var(--primary-emerald);
        background: transparent;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-outline-emerald:hover {
        background-color: var(--primary-emerald);
        color: white;
    }

    .table thead th {
        background-color: #f8f9fa;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        font-weight: 700;
        color: #495057;
        border-bottom: 2px solid #eef2f7;
    }

    .badge-emerald {
        background-color: var(--light-emerald);
        color: var(--dark-emerald);
        border: 1px solid rgba(21, 163, 98, 0.2);
    }

    .form-label { font-weight: 600; color: #444; }
    .form-control, .form-select { border-radius: 10px; padding: 0.6rem 1rem; border: 1px solid #e2e8f0; }
    .form-control:focus, .form-select:focus { border-color: var(--primary-emerald); box-shadow: 0 0 0 3px rgba(21, 163, 98, 0.1); }
    .text-emerald {
        color: var(--dark-emerald) !important;
    }
    .text-primary-emerald {
        color: var(--primary-emerald) !important;
    }
    .btn-white {
        background-color: #ffffff !important;
        color: var(--dark-emerald) !important;
        border: 2px solid #ffffff !important;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1) !important;
        font-weight: 700 !important;
        transition: all 0.3s ease;
    }
    .btn-white:hover {
        background-color: #f0fdf4 !important;
        color: #065f46 !important;
        border-color: #86efac !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15) !important;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y animate__animated animate__fadeIn">
    <!-- Hero Header -->
    <div class="hero-master-subjects">
        <div class="row align-items-center">
            <div class="col-md-7">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="<?= base_url('Admin/Home') ?>" class="text-white opacity-75">หน้าหลัก</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('Admin/Acade/Course/RegisterSubject') ?>" class="text-white opacity-75">งานหลักสูตร</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">คลังรายวิชาหลักสูตรกลาง</li>
                    </ol>
                </nav>
                <h2 class="fw-bold mb-1 text-white">คลังรายวิชาหลักสูตรกลาง (Master Subjects)</h2>
                <p class="mb-0 text-white opacity-75">ฐานข้อมูลรายวิชาแกนกลางของโรงเรียน สำหรับใช้งานร่วมกับระบบวัดผล ตารางสอน และตารางสอบ</p>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0 d-flex flex-wrap justify-content-md-end gap-2" style="position: relative; z-index: 5;">
                <button class="btn btn-white text-emerald fw-bold border-0 shadow-lg px-3 py-2 rounded-pill" type="button" id="btn-sync-google-sheets">
                    <i class="bx bx-cloud-download me-1"></i> ซิงค์จาก Google Sheets
                </button>
                <button class="btn btn-warning text-dark fw-bold border-0 shadow-lg px-3 py-2 rounded-pill" type="button" data-bs-toggle="modal" data-bs-target="#ModalAddMasterSubject">
                    <i class="bx bx-plus-circle me-1"></i> เพิ่มรายวิชาใหม่
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card-premium p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-1 fw-bold text-dark" id="stat-total"><?= number_format($stats['total'] ?? 0) ?></h3>
                        <p class="text-muted mb-0 small">รายวิชาทั้งหมดในคลัง</p>
                    </div>
                    <div class="stat-icon-box" style="background: var(--light-emerald); color: var(--primary-emerald);">
                        <i class="bx bx-library"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card-premium p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-1 fw-bold text-success" id="stat-basic"><?= number_format($stats['basic'] ?? 0) ?></h3>
                        <p class="text-muted mb-0 small">วิชาพื้นฐาน</p>
                    </div>
                    <div class="stat-icon-box" style="background: #e8f5e9; color: #2e7d32;">
                        <i class="bx bx-book-open"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card-premium p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-1 fw-bold text-info" id="stat-advanced"><?= number_format($stats['advanced'] ?? 0) ?></h3>
                        <p class="text-muted mb-0 small">วิชาเพิ่มเติม</p>
                    </div>
                    <div class="stat-icon-box" style="background: #e1f5fe; color: #0288d1;">
                        <i class="bx bx-bookmark-plus"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card-premium p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-1 fw-bold" style="color: #b45309 !important;" id="stat-groups"><?= number_format($stats['groups'] ?? 0) ?></h3>
                        <p class="text-muted mb-0 small">กลุ่มสาระการเรียนรู้</p>
                    </div>
                    <div class="stat-icon-box" style="background: #fff8e1; color: #b45309;">
                        <i class="bx bx-category"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card settings-card">
        <div class="settings-card-header">
            <div class="row align-items-center g-3">
                <div class="col-md-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper me-3">
                            <i class="bx bx-list-ul"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">รายการวิชาแกนกลาง</h5>
                            <small class="text-muted">จัดการและแก้ไขข้อมูลรายวิชาหลักสูตร</small>
                        </div>
                    </div>
                </div>
                <!-- Filters -->
                <div class="col-md-8">
                    <div class="row g-2 justify-content-md-end">
                        <div class="col-sm-4">
                            <select class="form-select form-select-sm filter-control" id="filter-group">
                                <option value="">ทุกกลุ่มสาระ</option>
                                <?php foreach ($classroom->GroupSaraMain() as $v_grp): ?>
                                    <option value="<?= esc($v_grp) ?>"><?= esc($v_grp) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <select class="form-select form-select-sm filter-control" id="filter-class">
                                <option value="">ทุกระดับชั้น</option>
                                <?php foreach ($classroom->LevelClass() as $v_cls): ?>
                                    <option value="<?= esc($v_cls) ?>"><?= esc($v_cls) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <select class="form-select form-select-sm filter-control" id="filter-type">
                                <option value="">ทุกประเภทวิชา</option>
                                <option value="1/พื้นฐาน">พื้นฐาน</option>
                                <option value="2/เพิ่มเติม">เพิ่มเติม</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover w-100" id="tbMasterSubject">
                    <thead>
                        <tr>
                            <th>รหัสวิชา</th>
                            <th>ชื่อรายวิชา</th>
                            <th class="text-center">ระดับชั้น</th>
                            <th class="text-center">หน่วยกิต / ชม.</th>
                            <th>ประเภทวิชา</th>
                            <th>กลุ่มสาระหลัก</th>
                            <th>สาระย่อย</th>
                            <th class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Subject -->
<div class="modal fade animate__animated animate__fadeIn" id="ModalAddMasterSubject" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0" style="border-radius: 20px;">
            <form id="form-add-master-subject">
                <div class="modal-header px-4 py-3" style="background: var(--primary-emerald);">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper me-3 bg-white text-emerald">
                            <i class="bx bx-plus-circle"></i>
                        </div>
                        <h5 class="modal-title text-white fw-bold mb-0">เพิ่มรายวิชาใหม่เข้าคลังกลาง</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label required">รหัสวิชา <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-uppercase" required name="subject_code" placeholder="เช่น ท21101, ค31101">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label required">ชื่อวิชา <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" required name="subject_name" placeholder="ชื่อรายวิชาเต็ม">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required">ระดับชั้น <span class="text-danger">*</span></label>
                            <select class="form-select" required name="subject_class">
                                <option value="">เลือกระดับชั้น</option>
                                <?php foreach ($classroom->LevelClass() as $v_cls): ?>
                                    <option value="<?= esc($v_cls) ?>"><?= esc($v_cls) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required">หน่วยกิต <span class="text-danger">*</span></label>
                            <input type="number" step="0.5" min="0" max="10" class="form-control" required name="subject_unit" placeholder="เช่น 1.0 หรือ 1.5">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required">จำนวนชั่วโมง <span class="text-danger">*</span></label>
                            <input type="number" min="0" step="10" class="form-control" required name="subject_hour" placeholder="เช่น 40 หรือ 60">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required">ประเภทวิชา <span class="text-danger">*</span></label>
                            <select class="form-select" required name="subject_type">
                                <option value="1/พื้นฐาน">1/พื้นฐาน</option>
                                <option value="2/เพิ่มเติม">2/เพิ่มเติม</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required">สาระหลัก / กลุ่มสาระ <span class="text-danger">*</span></label>
                            <select class="form-select" required name="first_group">
                                <option value="">เลือกสาระหลัก</option>
                                <?php foreach ($classroom->GroupSaraMain() as $v_grp): ?>
                                    <option value="<?= esc($v_grp) ?>"><?= esc($v_grp) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">สาระย่อย</label>
                            <select class="form-select" name="second_group">
                                <option value="">เลือกสาระย่อย (ถ้ามี)</option>
                                <?php foreach ($classroom->GroupSaraSecond() as $v_sub): ?>
                                    <option value="<?= esc($v_sub) ?>"><?= esc($v_sub) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3 bg-light border-0" style="border-radius: 0 0 20px 20px;">
                    <button type="button" class="btn btn-label-secondary rounded-pill px-4" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-emerald px-4 shadow-sm rounded-pill fw-bold" id="btn-save-master">
                        <i class="bx bx-save me-1"></i> บันทึกข้อมูล
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Subject -->
<div class="modal fade animate__animated animate__fadeIn" id="ModalEditMasterSubject" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0" style="border-radius: 20px;">
            <form id="form-edit-master-subject">
                <input type="hidden" name="master_id" id="edit_master_id">
                <div class="modal-header px-4 py-3" style="background: var(--primary-emerald);">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper me-3 bg-white text-emerald">
                            <i class="bx bx-edit"></i>
                        </div>
                        <h5 class="modal-title text-white fw-bold mb-0">แก้ไขรายวิชาในคลังกลาง</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label required">รหัสวิชา <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-uppercase" required name="subject_code" id="edit_subject_code">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label required">ชื่อวิชา <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" required name="subject_name" id="edit_subject_name">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required">ระดับชั้น <span class="text-danger">*</span></label>
                            <select class="form-select" required name="subject_class" id="edit_subject_class">
                                <option value="">เลือกระดับชั้น</option>
                                <?php foreach ($classroom->LevelClass() as $v_cls): ?>
                                    <option value="<?= esc($v_cls) ?>"><?= esc($v_cls) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required">หน่วยกิต <span class="text-danger">*</span></label>
                            <input type="number" step="0.5" min="0" max="10" class="form-control" required name="subject_unit" id="edit_subject_unit">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required">จำนวนชั่วโมง <span class="text-danger">*</span></label>
                            <input type="number" min="0" step="10" class="form-control" required name="subject_hour" id="edit_subject_hour">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required">ประเภทวิชา <span class="text-danger">*</span></label>
                            <select class="form-select" required name="subject_type" id="edit_subject_type">
                                <option value="1/พื้นฐาน">1/พื้นฐาน</option>
                                <option value="2/เพิ่มเติม">2/เพิ่มเติม</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required">สาระหลัก / กลุ่มสาระ <span class="text-danger">*</span></label>
                            <select class="form-select" required name="first_group" id="edit_first_group">
                                <option value="">เลือกสาระหลัก</option>
                                <?php foreach ($classroom->GroupSaraMain() as $v_grp): ?>
                                    <option value="<?= esc($v_grp) ?>"><?= esc($v_grp) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">สาระย่อย</label>
                            <select class="form-select" name="second_group" id="edit_second_group">
                                <option value="">เลือกสาระย่อย (ถ้ามี)</option>
                                <?php foreach ($classroom->GroupSaraSecond() as $v_sub): ?>
                                    <option value="<?= esc($v_sub) ?>"><?= esc($v_sub) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3 bg-light border-0" style="border-radius: 0 0 20px 20px;">
                    <button type="button" class="btn btn-label-secondary rounded-pill px-4" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-emerald px-4 shadow-sm rounded-pill fw-bold" id="btn-update-master">
                        <i class="bx bx-save me-1"></i> บันทึกการแก้ไข
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    let tableMasterSubject;

    function loadMasterTable() {
        if ($.fn.DataTable.isDataTable('#tbMasterSubject')) {
            $('#tbMasterSubject').DataTable().destroy();
        }

        tableMasterSubject = $('#tbMasterSubject').DataTable({
            responsive: true,
            processing: true,
            language: { url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/Thai.json" },
            ajax: {
                url: "<?= site_url('admin/academic/subject-master/select') ?>",
                type: "POST",
                data: function(d) {
                    d.first_group   = $('#filter-group').val();
                    d.subject_class = $('#filter-class').val();
                    d.subject_type  = $('#filter-type').val();
                },
                dataSrc: function(json) {
                    if (json.stats) {
                        $('#stat-total').text(Number(json.stats.total || 0).toLocaleString());
                        $('#stat-basic').text(Number(json.stats.basic || 0).toLocaleString());
                        $('#stat-advanced').text(Number(json.stats.advanced || 0).toLocaleString());
                        $('#stat-groups').text(Number(json.stats.groups || 0).toLocaleString());
                    }
                    return json.data || [];
                }
            },
            columns: [
                {
                    data: 'subject_code',
                    render: function(data) {
                        return '<span class="fw-bold text-dark font-monospace">' + data + '</span>';
                    }
                },
                { data: 'subject_name', className: 'fw-medium text-dark' },
                {
                    data: 'subject_class',
                    className: 'text-center',
                    render: function(data) {
                        return data ? '<span class="badge bg-label-warning">' + data + '</span>' : '-';
                    }
                },
                {
                    data: null,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return `<span class="badge bg-light text-dark border">${row.subject_unit || 0} นก. / ${row.subject_hour || 0} ชม.</span>`;
                    }
                },
                {
                    data: 'subject_type',
                    render: function(data) {
                        if (!data) return '-';
                        if (data.includes('พื้นฐาน')) {
                            return '<span class="badge bg-label-success">' + data + '</span>';
                        }
                        return '<span class="badge bg-label-info">' + data + '</span>';
                    }
                },
                {
                    data: 'first_group',
                    render: function(data) {
                        return data ? '<span class="badge bg-label-primary">' + data + '</span>' : '-';
                    }
                },
                {
                    data: 'second_group',
                    render: function(data) {
                        return data ? '<span class="badge bg-label-secondary">' + data + '</span>' : '-';
                    }
                },
                {
                    data: 'master_id',
                    className: 'text-center',
                    orderable: false,
                    render: function(data) {
                        return `
                        <div class="d-flex justify-content-center gap-2">
                            <button type="button" class="btn btn-sm btn-icon btn-label-warning btn-edit-master" data-id="${data}" title="แก้ไข"><i class="bx bx-edit"></i></button>
                            <button type="button" class="btn btn-sm btn-icon btn-label-danger btn-delete-master" data-id="${data}" title="ลบ"><i class="bx bx-trash"></i></button>
                        </div>`;
                    }
                }
            ]
        });
    }

    loadMasterTable();

    // Trigger filters
    $('.filter-control').on('change', function() {
        tableMasterSubject.ajax.reload();
    });

    // 1-Click Sync from Google Sheets
    $('#btn-sync-google-sheets').click(function() {
        Swal.fire({
            title: 'ยืนยันการซิงค์ข้อมูล?',
            text: 'ระบบจะดึงข้อมูลรายวิชาจาก Google Sheets กลางมาบันทึกและอัปเดตลงในฐานข้อมูล',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#15a362',
            cancelButtonColor: '#8592a3',
            confirmButtonText: '<i class="bx bx-cloud-download me-1"></i> เริ่มซิงค์ข้อมูล',
            cancelButtonText: 'ยกเลิก',
            customClass: { container: 'swal2-container' }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'กำลังซิงค์ข้อมูล...',
                    html: '<div class="spinner-border text-success my-3" role="status"></div><p class="text-muted">กำลังดึงข้อมูลและปรับปรุงตารางฐานข้อมูล กรุณารอสักครู่...</p>',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    customClass: { container: 'swal2-container' }
                });

                $.ajax({
                    url: '<?= site_url('admin/academic/subject-master/sync') ?>',
                    type: 'POST',
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'ซิงค์ข้อมูลสำเร็จ!',
                                text: res.message,
                                confirmButtonColor: '#15a362',
                                customClass: { container: 'swal2-container' }
                            });
                            tableMasterSubject.ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด',
                                text: res.message,
                                confirmButtonColor: '#15a362',
                                customClass: { container: 'swal2-container' }
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์เพื่อซิงค์ข้อมูลได้',
                            customClass: { container: 'swal2-container' }
                        });
                    }
                });
            }
        });
    });

    // Add Subject Submit
    $('#form-add-master-subject').submit(function(e) {
        e.preventDefault();
        const submitBtn = $('#btn-save-master');
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> กำลังบันทึก...');

        $.ajax({
            url: '<?= site_url('admin/academic/subject-master/insert') ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    $('#ModalAddMasterSubject').modal('hide');
                    $('#form-add-master-subject')[0].reset();
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ!',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: { container: 'swal2-container' }
                    });
                    tableMasterSubject.ajax.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'ผิดพลาด',
                        text: res.message,
                        customClass: { container: 'swal2-container' }
                    });
                }
            },
            complete: function() {
                submitBtn.prop('disabled', false).html('<i class="bx bx-save me-1"></i> บันทึกข้อมูล');
            }
        });
    });

    // Edit Subject
    $(document).on('click', '.btn-edit-master', function() {
        const id = $(this).data('id');
        $.ajax({
            url: '<?= site_url('admin/academic/subject-master/edit/') ?>' + id,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    const d = res.data;
                    $('#edit_master_id').val(d.master_id);
                    $('#edit_subject_code').val(d.subject_code);
                    $('#edit_subject_name').val(d.subject_name);
                    $('#edit_subject_class').val(d.subject_class);
                    $('#edit_subject_unit').val(d.subject_unit);
                    $('#edit_subject_hour').val(d.subject_hour);
                    $('#edit_subject_type').val(d.subject_type);
                    $('#edit_first_group').val(d.first_group);
                    $('#edit_second_group').val(d.second_group);

                    $('#ModalEditMasterSubject').modal('show');
                } else {
                    Swal.fire('ผิดพลาด', res.message, 'error');
                }
            }
        });
    });

    // Edit Subject Submit
    $('#form-edit-master-subject').submit(function(e) {
        e.preventDefault();
        const submitBtn = $('#btn-update-master');
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> กำลังบันทึก...');

        $.ajax({
            url: '<?= site_url('admin/academic/subject-master/update') ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    $('#ModalEditMasterSubject').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ!',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: { container: 'swal2-container' }
                    });
                    tableMasterSubject.ajax.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'ผิดพลาด',
                        text: res.message,
                        customClass: { container: 'swal2-container' }
                    });
                }
            },
            complete: function() {
                submitBtn.prop('disabled', false).html('<i class="bx bx-save me-1"></i> บันทึกการแก้ไข');
            }
        });
    });

    // Delete Subject
    $(document).on('click', '.btn-delete-master', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'ยืนยันการลบรายวิชานี้?',
            text: 'รายวิชาจะถูกลบออกจากคลังกลาง (ไม่มีผลย้อนหลังกับวิชาที่ลงทะเบียนประจำเทอมไปแล้ว)',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#8592a3',
            confirmButtonText: '<i class="bx bx-trash me-1"></i> ยืนยันลบ',
            cancelButtonText: 'ยกเลิก',
            customClass: { container: 'swal2-container' }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= site_url('admin/academic/subject-master/delete/') ?>' + id,
                    type: 'DELETE',
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'ลบสำเร็จ!',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false,
                                customClass: { container: 'swal2-container' }
                            });
                            tableMasterSubject.ajax.reload();
                        } else {
                            Swal.fire('ผิดพลาด', res.message, 'error');
                        }
                    }
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
