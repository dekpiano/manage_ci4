<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row align-items-center mb-4">
        <div class="col-12 col-md-6">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">วิชาการ /</span> รายงานมาตรฐานกุหลาบหลวง
            </h4>
        </div>
        <div class="col-12 col-md-6 text-md-end">
            <div class="badge bg-label-success fs-6 py-2 px-3">
                <i class='bx bx-info-circle me-1'></i> ขั้นตอนที่ 1: เลือกวิชาพื้นฐานที่ต้องการสรุป
            </div>
        </div>
    </div>

    <!-- ส่วนค้นหา (Filter Bar) - ดีไซน์ใหม่แบบ Clean -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header d-flex justify-content-between align-items-center py-3 border-bottom">
            <h5 class="mb-0 fw-bold"><i class='bx bx-filter-alt me-2 text-success'></i> ค้นหารายวิชาตามระดับชั้น</h5>
            <span class="badge bg-label-success"><?= !empty($SubjectsList) ? 'พบทั้งหมด '.count($SubjectsList).' รายวิชา' : 'กรุณาเลือกเงื่อนไข' ?></span>
        </div>
        <div class="card-body py-4">
            <form id="filterForm" method="get" action="<?= site_url('Admin/Acade/Evaluate/ReportAcademicSummaryRoyalRoseStandard') ?>" class="row g-3 justify-content-center">
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold">ปีการศึกษา / ภาคเรียน</label>
                    <select name="KeyYear" class="form-select select2" required>
                        <option value="0">--- เลือกปีการศึกษา ---</option>
                        <?php foreach ($CheckYear as $year): ?>
                            <option value="<?= esc($year->RegisterYear) ?>" <?= $KeyYear == $year->RegisterYear ? 'selected' : '' ?>>
                                ปีการศึกษา <?= esc($year->RegisterYear) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label fw-semibold">ระดับชั้น</label>
                    <select name="SelLevel" class="form-select" required>
                        <option value="0">--- ระดับชั้น ---</option>
                        <?php 
                        $levels = ['ม.1', 'ม.2', 'ม.3', 'ม.4', 'ม.5', 'ม.6'];
                        foreach ($levels as $lv): ?>
                            <option value="<?= $lv ?>" <?= $KeyLevel == $lv ? 'selected' : '' ?>><?= $lv ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <label class="form-label d-none d-md-block">&nbsp;</label>
                    <button type="submit" class="btn btn-success d-block w-100 py-2 shadow-none btn-submit">
                        <i class='bx bx-search-alt me-1'></i> ดึงรายชื่อวิชา
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php if(empty($SubjectsList)):?>
    <!-- Empty State -->
    <div class="card shadow-none bg-transparent border-dashed border-2 border-secondary mb-4 py-5">
        <div class="card-body text-center py-5">
            <div class="avatar avatar-xl mx-auto mb-4 bg-label-success">
                <span class="avatar-initial rounded-circle"><i class='bx bx-spreadsheet fs-1'></i></span>
            </div>
            <h5 class="fw-bold">ยังไม่มีข้อมูลวิชาแสดงผล</h5>
            <p class="text-muted mx-auto" style="max-width: 400px;">
                กรุณาเลือก <strong>ปีการศึกษา</strong> และ <strong>ระดับชั้น</strong> ที่ต้องการด้านบน จากนั้นกดปุ่มดึงรายชื่อวิชาเพื่อเริ่มขั้นตอนการคำนวณ
            </p>
        </div>
    </div>
    <?php else: ?>

    <!-- ส่วนเลือกวิชาแบบเต็มจอ (Table Selection) -->
    <div class="card shadow-sm border-0 mb-4">
        <form id="calculationForm" method="post" action="<?= site_url('Admin/Acade/Evaluate/ReportAcademicSummaryRoyalRoseStandard') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="SelLevel" value="<?= esc($KeyLevel) ?>">
            <input type="hidden" name="KeyYear" value="<?= esc($KeyYear) ?>">

            <div class="card-header d-flex flex-wrap justify-content-between align-items-center bg-label-success py-3 border-bottom">
                <div class="mb-2 mb-sm-0">
                    <h5 class="mb-1 text-success fw-bold d-flex align-items-center">
                        <i class='bx bx-check-double me-2 fs-4'></i> รายชื่อวิชาพื้นฐาน
                    </h5>
                    <small class="text-muted"><?= esc($KeyLevel) ?> | ปีการศึกษา <?= esc($KeyYear) ?> (พบทั้งหมด <?= count($SubjectsList) ?> วิชา)</small>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" id="btnSelectAll" class="btn btn-outline-success btn-sm">เลือกทั้งหมด</button>
                    <button type="button" id="btnDeselectAll" class="btn btn-outline-secondary btn-sm">ยกเลิกทั้งหมด</button>
                    <button type="submit" class="btn btn-success shadow-sm ms-2 btn-submit">
                        <i class='bx bx-calculator me-1'></i> เริ่มคำนวณสถิติ
                    </button>
                </div>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="subjectSelectionTable">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 60px;">เลือก</th>
                                <th style="min-width: 250px;">กลุ่มสาระการเรียนรู้</th>
                                <th style="width: 150px;">รหัสวิชา</th>
                                <th>ชื่อวิชา</th>
                                <th style="width: 150px;">ประเภทวิชา</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $currentGroup = '';
                            foreach ($SubjectsList as $v_subject): 
                                $isNewGroup = ($currentGroup !== $v_subject->FirstGroup);
                                if ($isNewGroup) $currentGroup = $v_subject->FirstGroup;
                            ?>
                            <tr class="<?= $isNewGroup ? 'border-top border-success border-2 table-active-success' : '' ?>">
                                <td class="text-center">
                                    <div class="form-check d-flex justify-content-center">
                                        <input class="form-check-input subject-checkbox" type="checkbox" name="selected_subjects[]" 
                                               value="<?= esc($v_subject->SubjectID) ?>" id="sub<?= esc($v_subject->SubjectID) ?>" checked>
                                    </div>
                                </td>
                                <td>
                                    <?php if($isNewGroup): ?>
                                        <span class="badge bg-success rounded-pill mb-1"><?= esc($v_subject->FirstGroup) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted opacity-50 ms-3"><i class='bx bx-subdirectory-right small me-1'></i><?= esc($v_subject->FirstGroup) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><code class="fw-bold text-dark fs-6"><?= esc($v_subject->SubjectCode) ?></code></td>
                                <td class="fw-semibold text-secondary"><?= esc($v_subject->SubjectName) ?></td>
                                <td><span class="badge bg-label-success"><?= esc($v_subject->SubjectType) ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="card-footer bg-label-secondary py-4 border-top">
                <div class="row align-items-center">
                    <div class="col-lg-8 mb-3 mb-lg-0">
                        <div class="d-flex align-items-center text-secondary">
                            <i class='bx bx-help-circle fs-3 me-2 text-success'></i>
                            <span>ระบบจะนำคะแนนจากวิชาที่ท่านเลือก มาประยุกต์รวมกันตามกลุ่มสาระการเรียนรู้ เพื่อสรุปผลสัมฤทธิ์ทางการเรียนตามมาตรฐานกุหลาบหลวง</span>
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <button type="submit" class="btn btn-success btn-lg w-100 w-md-auto shadow-md btn-submit">
                            <i class='bx bx-calculator me-2'></i> ประมวลผลและดูสรุปสถิติ
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php endif; ?>
</div>

<style>
    #subjectSelectionTable tr:hover { cursor: pointer; }
    .border-dashed { border-style: dashed !important; }
    .table-active { --bs-table-accent-bg: rgba(105, 108, 255, 0.05) !important; }
</style>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        // ฟังก์ชันสำหรับแสดง Loading ที่ปุ่ม
        function showLoading(btn) {
            btn.addClass('disabled').prop('disabled', true);
            btn.html('<i class="bx bx-loader-alt bx-spin me-1"></i> กำลังประมวลผล...');
        }

        // จัดการฟอร์มตัวกรอง (ดึงรายชื่อวิชา)
        $('#filterForm').on('submit', function() {
            showLoading($(this).find('.btn-submit'));
        });

        // จัดการฟอร์มคำนวณ (เริ่มคำนวณ)
        $('#calculationForm').on('submit', function(e) {
            if ($('.subject-checkbox:checked').length === 0) {
                e.preventDefault();
                alert('กรุณาเลือกอย่างน้อย 1 วิชาเพื่อคำนวณครับ');
                return false;
            }
            showLoading($(this).find('.btn-submit'));
        });

        // จัดการคลิกที่แถวเพื่อให้ติ๊ก Checkbox ได้ง่ายขึ้น
        $('#subjectSelectionTable tbody tr').on('click', function(e) {
            if ($(e.target).is('input')) return;
            var chk = $(this).find('.subject-checkbox');
            chk.prop('checked', !chk.prop('checked'));
        });

        // ปุ่มเลือกทั้งหมด
        $('#btnSelectAll').on('click', function() {
            $('.subject-checkbox').prop('checked', true);
        });

        // ปุ่มยกเลิกทั้งหมด
        $('#btnDeselectAll').on('click', function() {
            $('.subject-checkbox').prop('checked', false);
        });
    });
</script>
<?= $this->endSection() ?>