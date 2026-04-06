<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
    :root {
        --primary-green: #15a362;
        --dark-green: #1d4310;
        --light-green: #ABDD93;
        --glass-bg: rgba(255, 255, 255, 0.9);
    }

    /* Hero Section - The Standard Theme */
    .hero-header {
        background: #15a362;
        background: linear-gradient(135deg, #15a362 0%, #0d6d41 100%);
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 10px 30px rgba(21, 163, 98, 0.2);
        position: relative;
        overflow: hidden;
    }

    .hero-header::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    /* Search Container */
    .search-container {
        background: #fff;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border: 1px solid #edf2f9;
        margin-bottom: 2rem;
    }

    /* Table Styles - Traditional & Strong */
    #subjectSelectionTable {
        border-collapse: collapse !important;
        border: 2px solid var(--primary-green);
        border-radius: 15px;
        overflow: hidden;
    }

    #subjectSelectionTable thead th {
        background-color: var(--light-green) !important;
        border: 1px solid var(--primary-green) !important;
        color: #000 !important;
        font-weight: 700;
        vertical-align: middle !important;
        padding: 15px 10px !important;
        font-size: 0.9rem;
    }

    #subjectSelectionTable tbody td {
        border: 1px solid #e9ecef;
        vertical-align: middle;
        padding: 12px 10px !important;
    }

    .group-row {
        background-color: rgba(21, 163, 98, 0.08) !important;
        font-weight: bold;
        color: var(--dark-green);
    }

    .fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
        opacity: 0;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .sticky-submit {
        position: sticky;
        bottom: 20px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 1.5rem;
        border-radius: 15px;
        box-shadow: 0 -10px 25px rgba(0,0,0,0.05);
        border: 1px solid #eee;
        z-index: 100;
    }
</style>

<div class="container-fluid flex-grow-1 container-p-y">
    <!-- Hero Section -->
    <div class="hero-header fade-in-up">
        <div class="row align-items-center">
            <div class="col-md-7">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mb-1">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">วิชาการ</a></li>
                        <li class="breadcrumb-item active text-white">มาตรฐานกุหลาบหลวง</li>
                    </ol>
                </nav>
                <h2 class="display-6 fw-bold mb-0 text-white">โครงการกุหลาบหลวง</h2>
                <p class="text-white-50 mt-2 mb-0">ขั้นตอนที่ 1: ค้นหาและเลือกรายวิชาพื้นฐานเพื่อสรุปสถิติทางการเรียน</p>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                <div class="badge bg-white bg-opacity-20 p-3 rounded-3 text-start d-inline-block shadow-sm">
                    <i class='bx bx-check-double fs-3 mb-1'></i>
                    <div class="small text-white-50">ระบบประมวลผลอัตโนมัติ</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <form id="filterForm" method="get" action="<?= site_url('Admin/Acade/Evaluate/ReportAcademicSummaryRoyalRoseStandard') ?>">
        <div class="search-container fade-in-up" style="animation-delay: 0.1s;">
            <div class="row align-items-end g-3">
                <div class="col-lg-4">
                    <label class="small fw-bold text-muted mb-1"><i class='bx bx-calendar me-1'></i>ปีการศึกษา</label>
                    <select name="KeyYear" class="form-select select2" required>
                        <option value="0">-- เลือกปีการศึกษา --</option>
                        <?php foreach ($CheckYear as $year): ?>
                            <option value="<?= esc($year->RegisterYear) ?>" <?= $KeyYear == $year->RegisterYear ? 'selected' : '' ?>>
                                ปีการศึกษา <?= esc($year->RegisterYear) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <label class="small fw-bold text-muted mb-1"><i class='bx bx-layer me-1'></i>ระดับชั้น</label>
                    <select name="SelLevel" class="form-select select2" required>
                        <option value="0">-- เลือกระดับชั้น --</option>
                        <?php 
                        $levels = ['ม.1', 'ม.2', 'ม.3', 'ม.4', 'ม.5', 'ม.6'];
                        foreach ($levels as $lv): ?>
                            <option value="<?= $lv ?>" <?= $KeyLevel == $lv ? 'selected' : '' ?>><?= $lv ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-lg-2">
                    <button type="submit" class="btn btn-success w-100 shadow-sm btn-submit" style="height: 40px; border-radius: 10px;">
                        <i class='bx bx-list-ol me-1'></i> ดึงรายวิชา
                    </button>
                </div>
            </div>
        </div>
    </form>

    <?php if(empty($SubjectsList)):?>
        <div class="fade-in-up" style="animation-delay: 0.2s;">
            <div class="card border-0 shadow-sm text-center py-5" style="border-radius: 20px;">
                <div class="bg-label-success d-inline-flex p-4 rounded-circle mb-3 mx-auto">
                    <i class='bx bx-spreadsheet fs-1'></i>
                </div>
                <h4 class="fw-bold">เริ่มต้นใช้งานกุหลาบหลวง</h4>
                <p class="text-muted px-5">กรุณาเลือกปีการศึกษาและระดับชั้นที่ต้องการดึงข้อมูลวิชาเพื่อเริ่มการคำนวณสถิติ</p>
            </div>
        </div>
    <?php else: ?>
        <!-- Selection Section -->
        <div class="fade-in-up" style="animation-delay: 0.2s;">
            <form id="calculationForm" method="post" action="<?= site_url('Admin/Acade/Evaluate/ReportAcademicSummaryRoyalRoseStandard') ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="SelLevel" value="<?= esc($KeyLevel) ?>">
                <input type="hidden" name="KeyYear" value="<?= esc($KeyYear) ?>">

                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 px-2">
                    <h5 class="mb-2 mb-md-0 fw-bold"><i class='bx bx-check-circle text-success me-1'></i> ติ๊กเลือกวิชาพื้นฐานที่ต้องการ</h5>
                    <div class="btn-group shadow-sm rounded-3">
                        <button type="button" id="btnSelectAll" class="btn btn-sm btn-outline-success">เลือกทั้งหมด</button>
                        <button type="button" id="btnDeselectAll" class="btn btn-sm btn-outline-secondary">ยกเลิกทั้งหมด</button>
                    </div>
                </div>

                <div class="card border-0 shadow-sm overflow-hidden mb-5" style="border-radius: 15px; border: 2px solid var(--primary-green) !important;">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="subjectSelectionTable">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 70px;">เลือก</th>
                                    <th class="text-start">กลุ่มสาระการเรียนรู้ / รายชื่อวิชา</th>
                                    <th style="width: 150px;">รหัสวิชา</th>
                                    <th style="width: 150px;">ประเภท</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $currentGroup = '';
                                foreach ($SubjectsList as $v_subject): 
                                    $isNewGroup = ($currentGroup !== $v_subject->FirstGroup);
                                    if ($isNewGroup):
                                        $currentGroup = $v_subject->FirstGroup;
                                ?>
                                    <tr class="group-row">
                                        <td colspan="4">
                                            <i class='bx bxs-folder-open me-2 text-success'></i>กลุ่มสาระ<?= esc($currentGroup) ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <tr class="subject-row">
                                    <td class="text-center border-end">
                                        <div class="form-check d-flex justify-content-center m-0">
                                            <input class="form-check-input subject-checkbox" type="checkbox" name="selected_subjects[]" 
                                                   value="<?= esc($v_subject->SubjectID) ?>" id="sub<?= esc($v_subject->SubjectID) ?>" checked>
                                        </div>
                                    </td>
                                    <td class="border-end">
                                        <label for="sub<?= esc($v_subject->SubjectID) ?>" class="d-block cursor-pointer">
                                            <span class="text-dark fw-bold"><?= esc($v_subject->SubjectName) ?></span>
                                        </label>
                                    </td>
                                    <td class="text-center border-end fw-bold text-muted"><?= esc($v_subject->SubjectCode) ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-label-success rounded-pill"><?= esc($v_subject->SubjectType) ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="sticky-submit fade-in-up">
                    <div class="row align-items-center">
                        <div class="col-md-8 mb-3 mb-md-0">
                            <h5 class="mb-1 fw-bold text-dark"><i class='bx bx-info-circle me-1 text-success'></i> พร้อมประมวลผลแล้วหรือยัง?</h5>
                            <p class="text-muted small mb-0">โปรดตรวจสอบรายวิชาที่ติ๊กเลือกให้ถูกต้อง ระบบจะนำเกรดจากวิชาเหล่านี้มาประมวลผลรวมกันรายกลุ่มสาระครับ</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <button type="submit" class="btn btn-success btn-lg px-5 shadow-success btn-submit w-100 w-md-auto" style="border-radius: 12px;">
                                <i class='bx bx-calculator me-2'></i> ประมวลผลสถิติ
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Initialize Select2 - Fixed Version
    $('.select2').each(function() {
        $(this).select2({ 
            theme: 'bootstrap-5',
            width: '100%'
        });
    });

    // Loading State with SweetAlert2
    const startLoading = () => {
        Swal.fire({
            title: 'กำลังดึงข้อมูลวิชา...',
            text: 'ระบบกำลังดำเนินการค้นหา กรุณารอสักครู่',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });
    };

    $('#filterForm').on('submit', function() {
        startLoading();
        return true;
    });

    $('#calculationForm').on('submit', function(e) {
        if ($('.subject-checkbox:checked').length === 0) {
            e.preventDefault();
            Swal.fire({ icon: 'error', title: 'ไม่พบวิชาที่เลือก', text: 'กรุณาเลือกวิชาอย่างน้อย 1 วิชาเพื่อคำนวณครับ' });
            return false;
        }
        Swal.fire({
            title: 'กำลังประมวลผลสถิติ...',
            text: 'ระบบกำลังวิเคราะห์เกรดมาตรฐานกุหลาบหลวง กรุณารอสักครู่',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });
        return true;
    });

    // Multi-select helpers
    $('#btnSelectAll').on('click', () => $('.subject-checkbox').prop('checked', true));
    $('#btnDeselectAll').on('click', () => $('.subject-checkbox').prop('checked', false));

    // Row-click helper
    $('.subject-row').on('click', function(e) {
        if ($(e.target).is('input')) return;
        let ck = $(this).find('.subject-checkbox');
        ck.prop('checked', !ck.prop('checked'));
    });
});
</script>
<?= $this->endSection() ?>