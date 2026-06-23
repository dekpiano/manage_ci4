<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
/* ===== Design System - Green Glassmorphism ===== */
:root {
    --primary-green: #15a362;
    --primary-green-dark: #0e864f;
    --primary-green-light: #e8f5ed;
    --gradient-green: linear-gradient(135deg, #15a362 0%, #20c997 50%, #17a2b8 100%);
    --card-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
    --hover-shadow: 0 16px 48px rgba(0, 0, 0, 0.12);
}

.lifecycle-wrapper {
    padding-bottom: 3rem;
    min-height: 80vh;
}

/* Header Banner */
.lifecycle-header {
    background: var(--gradient-green);
    border-radius: 20px;
    padding: 2rem 2.5rem;
    color: #fff;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(21, 163, 98, 0.2);
    position: relative;
    overflow: hidden;
}

.lifecycle-header::before {
    content: '';
    position: absolute;
    top: -50px;
    right: -50px;
    width: 250px;
    height: 250px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

/* Choice Cards */
.mode-card {
    border-radius: 20px;
    border: 2px solid transparent;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    cursor: pointer;
    background: #fff;
    text-align: center;
    padding: 2.5rem 1.5rem;
    height: 100%;
    box-shadow: var(--card-shadow);
}

.mode-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--hover-shadow);
    border-color: var(--primary-green);
}

.mode-card.active {
    border-color: var(--primary-green);
    background: var(--primary-green-light);
}

.mode-icon {
    width: 80px;
    height: 80px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    margin: 0 auto 1.5rem;
    transition: all 0.3s ease;
}

.bg-light-success-gradient { background: linear-gradient(135deg, #d4edda 0%, #e8f5ed 100%); color: var(--primary-green); }
.bg-light-info-gradient { background: linear-gradient(135deg, #e0f2ff 0%, #f0f7ff 100%); color: #007bff; }

.mode-card:hover .mode-icon { transform: scale(1.1) rotate(5deg); }

/* Step Panels */
.step-container {
    background: #fff;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: var(--card-shadow);
    margin-top: 2rem;
}

.step-header {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #f0f0f0;
}

.step-number {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--primary-green);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    margin-right: 1rem;
    font-size: 0.9rem;
}

/* List Items */
.list-wrapper {
    max-height: 450px;
    overflow-y: auto;
    border: 1px solid #eee;
    border-radius: 12px;
    padding: 0.5rem;
}

.item-row {
    padding: 0.75rem 1rem;
    border-radius: 10px;
    margin-bottom: 0.5rem;
    transition: all 0.2s;
    cursor: pointer;
    border: 1px solid transparent;
}

.item-row:hover { background: #f8f9fa; }
.item-row.selected {
    background: var(--primary-green-light);
    border-color: rgba(21, 163, 98, 0.2);
}

/* Badges */
.badge-status-1 { background: #d4edda; color: #15a362; }
.badge-status-2 { background: #fff3cd; color: #856404; }
.badge-status-3 { background: #f8d7da; color: #dc3545; }
.badge-status-5 { background: #e7f7ff; color: #03c3ec; }

/* Sticky Action Bar */
.sticky-action-bar {
    position: sticky;
    bottom: 1rem;
    z-index: 100;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 1rem 1.5rem;
    box-shadow: 0 -10px 30px rgba(0,0,0,0.05), 0 10px 20px rgba(0,0,0,0.1);
    transform: translateY(20px);
    opacity: 0;
    transition: all 0.4s ease;
    pointer-events: none;
    border: 1px solid rgba(21, 163, 98, 0.1);
}

.sticky-action-bar.show {
    transform: translateY(0);
    opacity: 1;
    pointer-events: auto;
}

/* Filters */
.filter-group {
    background: #f8fdf9;
    padding: 1.25rem;
    border-radius: 15px;
    border: 1px solid #e8f5ed;
}

.status-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
}

    /* ===== Modern standalone Select2 Styling ===== */
    .select2-modern + .select2-container--bootstrap-5 .select2-selection {
        border-radius: 12px !important;
        border: 2px solid #eaedf1 !important;
        min-height: 48px !important;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
        background-color: #fff !important;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02) !important;
    }
    .select2-modern + .select2-container--bootstrap-5.select2-container--focus .select2-selection {
        border-color: var(--primary-green) !important;
        box-shadow: 0 0 0 0.25rem rgba(21, 163, 98, 0.15) !important;
    }
    .select2-modern + .select2-container--bootstrap-5 .select2-selection__rendered {
        padding-left: 1rem !important;
        font-weight: 700;
        color: #566a7f;
        font-size: 0.95rem;
    }

    /* Balanced Date Inputs */
    .student-be-datepicker {
        background-color: #fff !important;
        border-radius: 12px !important;
        border: 2px solid #eaedf1 !important;
        min-height: 40px !important;
        font-weight: 600;
        cursor: pointer;
    }
</style>

<div class="lifecycle-wrapper container-xxl">
    <!-- Header Area -->
    <div class="lifecycle-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1 text-white"><i class='bx bx-recycle me-2'></i>จัดการวงจรชีวิตนักเรียน</h3>
            <p class="mb-0 text-white-50">เลือกการดำเนินการที่คุณต้องการจัดการ เพื่อประมวลผลข้อมูลรายชั้นเรียนหรือกลุ่มนักเรียน</p>
        </div>
        <div>
            <a href="<?= base_url('Admin/Acade/Registration/Students') ?>" class="btn btn-white btn-sm rounded-pill px-4">
                <i class='bx bx-arrow-back me-1'></i> กลับหน้าจัดการ
            </a>
        </div>
    </div>

    <!-- Mode Selection -->
    <div class="row g-4 mb-5" id="mode-selector">
        <div class="col-md-6">
            <div class="mode-card" data-mode="promotion">
                <div class="mode-icon bg-light-success-gradient">
                    <i class='bx bx-trending-up'></i>
                </div>
                <h4 class="fw-bold">เลื่อนชั้นเรียน</h4>
                <p class="text-muted">ปรับปรุงระดับชั้นเรียนสำหรับนักเรียนเป็นรายกลุ่มเมื่อสิ้นปีการศึกษา</p>
                <div class="badge bg-label-success rounded-pill px-3">End of Year Promotion</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mode-card" data-mode="status">
                <div class="mode-icon bg-light-info-gradient">
                    <i class='bx bx-user-pin'></i>
                </div>
                <h4 class="fw-bold">จัดการสถานะพ้นสภาพ</h4>
                <p class="text-muted">จัดการนักเรียนที่จบการศึกษา ลาออก พักการเรียน หรือพ้นสภาพอื่นๆ</p>
                <div class="badge bg-label-info rounded-pill px-3">Lifecycle & Exit Status</div>
            </div>
        </div>
    </div>

    <!-- Workspace Area (Hidden by default) -->
    <div id="lifecycle-workspace" style="display: none;">
        <!-- Step Panels Row -->
        <div class="row g-4">
            <!-- Step 1: Filter/Setup -->
            <div class="col-lg-4">
                <div class="step-container h-100">
                    <div class="step-header">
                        <div class="step-number">1</div>
                        <h5 class="mb-0 fw-bold">ระบุกลุ่มเป้าหมาย</h5>
                    </div>
                    
                    <div class="filter-group mb-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">ปีการศึกษาต้นทาง</label>
                            <select class="form-select select2-modern" id="source_year">
                                <?php 
                                    // สำหรับ Source Year ให้ใช้ข้อมูลตามในฐานข้อมูลเสมอเพื่อความถูกต้องของแหล่งข้อมูล
                                    foreach($school_years as $y): ?>
                                    <option value="<?= $y->schyear_year ?>" <?= $y->schyear_year == get_selected_year() ? 'selected' : '' ?>><?= $y->schyear_year ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">ระดับชั้นเรียน</label>
                            <select class="form-select select2-modern" id="source_class">
                                <option value="">-- เลือกชั้นเรียน --</option>
                                <?php foreach($class_list as $c): ?>
                                    <option value="ม.<?= $c ?>">ม.<?= $c ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-0" id="status-filter-group" style="display:none;">
                            <label class="form-label fw-bold small text-muted">สถานะปัจจุบัน</label>
                            <select class="form-select select2-modern" id="source_status">
                                <option value="1/ปกติ">1/ปกติ</option>
                                <option value="2/พักการเรียน">2/พักการเรียน</option>
                                <option value="3/จำหน่าย">3/จำหน่าย</option>
                                <option value="5/จบการศึกษา">5/จบการศึกษา</option>
                            </select>
                        </div>
                    </div>
                    <button class="btn btn-primary w-100 btn-lg shadow-sm" id="btn-fetch-students">
                        <i class='bx bx-search-alt me-2'></i> เรียกดูรายชื่อนักเรียน
                    </button>
                    
                    <div class="mt-4 p-3 bg-light rounded-3 d-none d-lg-block">
                        <small class="text-muted d-block mb-1"><i class='bx bx-info-circle me-1'></i> คำแนะนำ:</small>
                        <ul class="small text-muted ps-3 mb-0">
                            <li>เลือกชั้นเรียนที่ต้องการดำเนินการ</li>
                            <li>หากต้องการค้นหาทุกห้องในชั้น (เช่น ม.1 ทั้งหมด) ให้เลือกชั้นหลัก</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Step 2: Selection -->
            <div class="col-lg-8">
                <div class="step-container h-100 position-relative">
                    <div class="step-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="step-number">2</div>
                            <h5 class="mb-0 fw-bold">เลือกรายชื่อนักเรียน</h5>
                        </div>
                        <div class="form-check form-switch ps-0 d-flex align-items-center">
                            <label class="form-check-label me-5 fw-bold small text-primary" for="check-all-students">เลือกทั้งหมด</label>
                            <input class="form-check-input ms-0" type="checkbox" id="check-all-students">
                        </div>
                    </div>

                    <div id="student-list-container">
                        <div class="p-5 text-center text-muted">
                            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="100" class="opacity-25 mb-3" alt="Empty">
                            <p>กรุณาระบุกลุ่มเป้าหมายที่อยู่ด้านซ้ายมือ</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 3: Action Context (Sticky Bar) -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="sticky-action-bar" id="action-workspace">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    <i class='bx bx-user-check fs-4'></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold" id="selected-summary">เลือกแล้ว 0 รายการ</h6>
                                    <small class="text-muted">กำลังรอคำสั่งดำเนินการ...</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Promotion Inputs -->
                        <div class="col-md-7 action-group" id="promotion-inputs">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-success">เลื่อนชั้นไปยัง:</label>
                                    <div class="row g-1">
                                        <div class="col-7">
                                            <select class="form-select select2-modern" id="target_grade">
                                                <option value="">ชั้น</option>
                                                <?php for($i=1;$i<=6;$i++): ?><option value="<?= $i ?>">ม.<?= $i ?></option><?php endfor; ?>
                                            </select>
                                        </div>
                                        <div class="col-5">
                                            <select class="form-select select2-modern" id="target_room">
                                                <?php for($i=1;$i<=12;$i++): ?><option value="<?= $i ?>"><?= $i ?></option><?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-info">ปรับสถานะ (ถ้าจำเป็น):</label>
                                    <select class="form-select select2-modern" id="target_status">
                                        <option value="">-- ไม่เปลี่ยนแปลง --</option>
                                        <option value="5/จบการศึกษา">5/จบการศึกษา</option>
                                        <option value="3/จำหน่าย">3/จำหน่าย</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">ปีการศึกษาที่บันทึก:</label>
                                    <select class="form-select select2-modern" id="target_year">
                                        <?php 
                                            // 🛡️ Logic การสร้างปีและเทอมในอนาคต (เทอม 1 และ 2 เสมอ)
                                            $allYearsSet = array_map(function($y) { return $y->schyear_year; }, $school_years);
                                            
                                            // แยกหาปี พ.ศ. ล่าสุด
                                            $justYears = array_map(function($y) { 
                                                $parts = explode('/', $y);
                                                return (int)(count($parts) > 1 ? $parts[1] : $p[0]); // รองรับทั้ง 1/2568 และ 2568
                                            }, $allYearsSet);
                                            $latestYear = !empty($justYears) ? max($justYears) : (int)date('Y') + 543;

                                            // สร้างรายการปีในอนาคตเพิ่ม 2 ปี (เทอม 1 และ 2)
                                            for($i = 0; $i <= 2; $i++) {
                                                $year = $latestYear + $i;
                                                $allYearsSet[] = "1/$year";
                                                $allYearsSet[] = "2/$year";
                                            }

                                            // กรองรายการซ้ำและจัดเรียงแบบพิเศษ (ปี desc, เทอม desc)
                                            $allYearsSet = array_unique($allYearsSet);
                                            usort($allYearsSet, function($a, $b) {
                                                $pa = explode('/', $a);
                                                $pb = explode('/', $b);
                                                $ya = (int)(count($pa) > 1 ? $pa[1] : $pa[0]);
                                                $ta = (int)(count($pa) > 1 ? $pa[0] : 1);
                                                $yb = (int)(count($pb) > 1 ? $pb[1] : $pb[0]);
                                                $tb = (int)(count($pb) > 1 ? $pb[0] : 1);
                                                
                                                if ($ya !== $yb) return $yb - $ya;
                                                return $tb - $ta;
                                            });

                                            $currentSelected = get_selected_year();
                                            foreach($allYearsSet as $y): 
                                        ?>
                                            <option value="<?= $y ?>" <?= $y == $currentSelected ? 'selected' : '' ?>><?= $y ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Status Update Inputs -->
                        <div class="col-md-7 action-group" id="status-inputs" style="display:none;">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-3">
                                    <label class="form-label small fw-bold text-info">สถานะใหม่:</label>
                                    <select class="form-select select2-modern" id="bulk_new_status">
                                        <option value="">-- เลือก --</option>
                                        <option value="1/ปกติ">1/ปกติ</option>
                                        <option value="2/พักการเรียน">2/พักการเรียน</option>
                                        <option value="2/ย้ายสถานศึกษา">2/ย้ายสถานศึกษา</option>
                                        <option value="3/จำหน่าย">3/จำหน่าย</option>
                                        <option value="5/จบการศึกษา">5/จบการศึกษา</option>
                                    </select>
                                </div>
                                <div class="col-lg-6" id="bulk_details_area">
                                     <div id="finish_inputs" style="display:none;">
                                         <div class="row g-1">
                                             <div class="col-6">
                                                 <label class="form-label small fw-bold text-primary">วันอนุมัติ:</label>
                                                 <input type="text" class="form-control student-be-datepicker" id="bulk_date_approve" placeholder="เลือกวันที่...">
                                             </div>
                                             <div class="col-6">
                                                 <label class="form-label small fw-bold text-primary">วันที่จบ:</label>
                                                 <input type="text" class="form-control student-be-datepicker" id="bulk_date_finish" placeholder="เลือกวันที่...">
                                             </div>
                                         </div>
                                     </div>
                                     <div id="leave_inputs" style="display:none;">
                                         <label class="form-label small fw-bold text-danger">สาเหตุการจำหน่าย/ย้าย:</label>
                                         <input type="text" class="form-control" id="bulk_leave_reason" placeholder="ระบุเหตุผล...">
                                     </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small fw-bold">วันที่บันทึก:</label>
                                    <input type="text" class="form-control student-be-datepicker" id="bulk_status_date" value="<?= date('Y-m-d') ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 text-end mt-3 mt-md-0">
                            <button class="btn btn-success btn-lg px-4 w-100 shadow-sm" id="btn-submit-workspace">
                                <i class='bx bx-check-double me-2'></i> ประมวลผล
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    let currentMode = ''; // 'promotion' or 'status'

    // Initialize Select2 for all select elements
    $('.select2-modern').select2({
        theme: 'bootstrap-5',
        width: '100%',
        dropdownParent: $('body')
    });

    // Initialize Buddhist Era Date Picker
    function updateCalendarToBE(instance) {
        setTimeout(() => {
            const yearDisplay = instance.calendarContainer.querySelector(".flatpickr-current-month .cur-year");
            if (yearDisplay) {
                const year = parseInt(instance.currentYear);
                if (year < 2400) {
                    if (yearDisplay.tagName === "INPUT") yearDisplay.value = year + 543;
                    else yearDisplay.textContent = year + 543;
                }
            }
            const yearInput = instance.calendarContainer.querySelector(".numInput.cur-year");
            if (yearInput && parseInt(instance.currentYear) < 2400) yearInput.value = parseInt(instance.currentYear) + 543;
        }, 5);
    }

    $(".student-be-datepicker").flatpickr({
        disableMobile: true,
        dateFormat: "Y-m-d", // Sends A.D. ISO to Backend
        altInput: true,      // Show another format to user
        altFormat: "d/m/Y",  // Desired format
        locale: "th",
        onOpen: (s, d, i) => updateCalendarToBE(i),
        onMonthChange: (s, d, i) => updateCalendarToBE(i),
        onYearChange: (s, d, i) => updateCalendarToBE(i),
        formatDate: (date, format) => {
            if (format === "d/m/Y") {
                const y = date.getFullYear() + 543;
                return `${date.getDate().toString().padStart(2, '0')}/${(date.getMonth() + 1).toString().padStart(2, '0')}/${y}`;
            }
            return flatpickr.formatDate(date, format);
        },
        parseDate: (dateStr) => {
            if (dateStr && dateStr.includes('/')) {
                const p = dateStr.split('/');
                return new Date(parseInt(p[2]) - 543, parseInt(p[1]) - 1, parseInt(p[0]));
            }
            return flatpickr.parseDate(dateStr, "Y-m-d");
        }
    });

    // --- Mode Selection Logic ---
    $('.mode-card').on('click', function() {
        $('.mode-card').removeClass('active');
        $(this).addClass('active');
        
        currentMode = $(this).data('mode');
        switchWorkspace(currentMode);
    });

    function switchWorkspace(mode) {
        // Reset Workspace
        $('#lifecycle-workspace').fadeIn();
        $('.action-group').hide();
        $('#student-list-container').html(`
            <div class="p-5 text-center text-muted">
                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="100" class="opacity-25 mb-3" alt="Empty">
                <p>กรุณาระบุกลุ่มเป้าหมายที่อยู่ด้านซ้ายมือ</p>
            </div>
        `);
        $('#action-workspace').removeClass('show');

        // Smart Year Auto-Selection
        const baseYearFull = $('#source_year').val() || '<?= get_selected_year() ?>';
        const baseYearNum = parseInt(baseYearFull);
        
        if(mode === 'promotion') {
            $('#status-filter-group').hide();
            $('#promotion-inputs').show();
            
            // Auto suggest next year term 1 for promotion (e.g. 2568/1)
            const nextYearTerm1 = (baseYearNum + 1) + '/1';
            const nextYearOnly = (baseYearNum + 1).toString();
            
            if ($('#target_year option[value="' + nextYearTerm1 + '"]').length) {
                $('#target_year').val(nextYearTerm1).trigger('change');
            } else if ($('#target_year option[value="' + nextYearOnly + '"]').length) {
                $('#target_year').val(nextYearOnly).trigger('change');
            } else {
                // Not found, maybe pick first year that starts with numeric + 1
                $('#target_year option').each(function() {
                    if($(this).val().startsWith(baseYearNum + 1)) {
                        $('#target_year').val($(this).val()).trigger('change');
                        return false;
                    }
                });
            }
        } else {
            $('#status-filter-group').show();
            $('#status-inputs').show();
            // Default to current selected year (full string)
            $('#target_year').val(baseYearFull).trigger('change');
        }

        // Smooth scroll to workspace
        $('html, body').animate({
            scrollTop: $("#lifecycle-workspace").offset().top - 20
        }, 600);
    }

    // --- Fetch Reasoning ---
    $('#btn-fetch-students').on('click', function() {
        const year = $('#source_year').val();
        const sClass = $('#source_class').val();
        const status = (currentMode === 'status') ? $('#source_status').val() : '1/ปกติ';

        if(!sClass) {
            Swal.fire('คำเตือน', 'กรุณาระดับชั้นต้นทาง', 'warning');
            return;
        }

        $('#student-list-container').html('<div class="p-5 text-center"><div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div><p class="mt-3 text-muted">กำลังค้นหารายชื่อนักเรียน...</p></div>');

        $.get('<?= base_url('Admin/Acade/Registration/Students/DataFilters') ?>', {
            class: sClass,
            status: status
        }, function(data) {
            renderStudentItems(data);
        });
    });

    function renderStudentItems(data) {
        if(data.length === 0) {
            $('#student-list-container').html('<div class="p-5 text-center text-muted"><i class="bx bx-user-x fs-1 opacity-25"></i><p>ไม่พบรายชื่อในเงื่อนไขที่ระบุ</p></div>');
            return;
        }

        let html = '<div class="list-wrapper">';
        data.forEach(s => {
            const statusId = s.StudentStatus.split('/')[0];
            html += `
            <div class="item-row d-flex align-items-center" data-id="${s.StudentID}">
                <div class="form-check me-3">
                    <input class="form-check-input student-cb" type="checkbox" value="${s.StudentID}">
                </div>
                <div class="flex-grow-1">
                    <div class="fw-bold d-flex align-items-center">
                        ${s.StudentPrefix}${s.StudentFirstName} ${s.StudentLastName}
                        <span class="ms-2 badge badge-status-${statusId}" style="zoom: 0.8;">${s.StudentStatus}</span>
                    </div>
                    <small class="text-muted">Code: ${s.StudentCode} | เลขที่: ${s.StudentNumber || '-'} | ห้อง ${s.StudentClass}</small>
                </div>
                <div class="text-end">
                    <small class="text-muted d-block" style="font-size: 10px;">ล่าสุด: ${s.YearFinish || '-'}</small>
                </div>
            </div>`;
        });
        html += '</div>';
        $('#student-list-container').html(html);
        updateSelectedUI();
    }

    // --- Selection Management ---
    $(document).on('click', '.item-row', function(e) {
        if (!$(e.target).hasClass('form-check-input')) {
            const cb = $(this).find('.student-cb');
            cb.prop('checked', !cb.is(':checked'));
        }
        $(this).toggleClass('selected', $(this).find('.student-cb').is(':checked'));
        updateSelectedUI();
    });

    $('#check-all-students').on('change', function() {
        const isChecked = $(this).is(':checked');
        $('.student-cb').prop('checked', isChecked);
        $('.item-row').toggleClass('selected', isChecked);
        updateSelectedUI();
    });

    function updateSelectedUI() {
        const selected = $('.student-cb:checked').length;
        $('#selected-summary').text(`เลือกแล้ว ${selected} รายการ`);
        
        if (selected > 0) {
            $('#action-workspace').addClass('show');
        } else {
            $('#action-workspace').removeClass('show');
        }
    }

    // --- Action Handling ---
    $('#bulk_new_status').on('change', function() {
        const val = $(this).val();
        $('#finish_inputs, #leave_inputs').hide();
        if(val === '5/จบการศึกษา') $('#finish_inputs').show();
        else if(val === '3/จำหน่าย' || val === '2/พักการเรียน' || val === '2/ย้ายสถานศึกษา') $('#leave_inputs').show();
    });

    $('#btn-submit-workspace').on('click', function() {
        const ids = $('.student-cb:checked').map(function() { return $(this).val(); }).get();
        if (ids.length === 0) return;

        Swal.fire({
            title: 'ยืนยันการดำเนินการ?',
            text: `ประมวลผลนักเรียนจำนวน ${ids.length} รายการ ตามคำสั่งที่ระบุ`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ยืนยันดำเนินการ',
            confirmButtonColor: '#28a745',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                if (currentMode === 'promotion') {
                    executePromotion(ids);
                } else {
                    executeStatusUpdate(ids);
                }
            }
        });
    });

    function executePromotion(ids) {
        const grade = $('#target_grade').val();
        const room = $('#target_room').val();
        const status = $('#target_status').val();

        if(!grade && !status) {
            Swal.fire('คำเตือน', 'กรุณาระบุชั้นเรียนปลายทางหรือระดับสถานะ', 'warning');
            return;
        }

        showLoading();
        $.post('<?= base_url('Admin/Acade/Registration/Students/PromotionBulk') ?>', {
            student_ids: ids,
            next_grade: grade,
            next_room: room,
            next_status: status,
            status_date: new Date().toISOString().split('T')[0],
            status_year: $('#target_year').val()
        }, handleResponse);
    }

    function executeStatusUpdate(ids) {
        const status = $('#bulk_new_status').val();
        if(!status) {
            Swal.fire('คำเตือน', 'กรุณาเลือกสถานะใหม่', 'warning');
            return;
        }

        showLoading();
        $.post('<?= base_url('Admin/Acade/Registration/Students/StatusUpdateBulk') ?>', {
            student_ids: ids,
            new_status: status,
            status_date: $('#bulk_status_date').val(),
            status_year: $('#source_year').val(),
            date_approve: $('#bulk_date_approve').val(),
            date_finish: $('#bulk_date_finish').val(),
            leave_reason: $('#bulk_leave_reason').val()
        }, handleResponse);
    }

    function handleResponse(res) {
        Swal.fire(res.status === 'success' ? 'สำเร็จ' : 'แจ้งเตือน', res.message, res.status);
        if(res.status === 'success') {
            $('#btn-fetch-students').trigger('click');
            $('#check-all-students').prop('checked', false);
        }
    }

    function showLoading() {
        Swal.fire({
            title: 'กำลังประมวลผล...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });
    }
});
</script>
<?= $this->endSection() ?>
