<?php 
// Simplified student details form - Perfect Form Floating with Select2 & Buddhist Era (พ.ศ.)
$student = $student ?? (object)[];
$fields = [
    'StudentID', 'StudentPrefix', 'StudentFirstName', 'StudentLastName', 'StudentCode', 'StudentIDNumber', 
    'StudentDateBirth', 'StudentClass', 'StudentNumber', 'StudentStudyLine', 'StudentStatus', 'StudentBehavior',
    'StudentDateEntrance', 'StudentSex'
];

foreach ($fields as $field) {
    $$field = esc($student->$field ?? '');
}
?>

<style>
/* Modern Form Layout */
.simplified-form-wrapper {
    max-width: 1000px;
    margin: 0 auto;
}

.form-section-card {
    background: #fff;
    border-radius: 18px;
    padding: 1.75rem 2rem;
    margin-bottom: 1.5rem;
    border: 1px solid #eef2f7;
    box-shadow: 0 4px 20px rgba(0,0,0,0.03);
}

.section-label {
    display: flex;
    align-items: center;
    margin-bottom: 1.25rem;
    font-weight: 700;
    color: #15a362;
    font-size: 1.15rem;
}

.section-label i {
    margin-right: 0.65rem;
    background: #e8f5ed;
    color: #15a362;
    padding: 8px;
    border-radius: 10px;
    font-size: 1.25rem;
}

/* ===== PERFECT FORM FLOATING STYLING ===== */
.simplified-form-wrapper .form-floating {
    position: relative;
    display: block;
}

/* Floating Label Default (Resting) State - Vertically Centered */
.simplified-form-wrapper .form-floating > label,
.simplified-form-wrapper .form-floating > .form-select ~ label {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 58px;
    padding: 1.15rem 1rem 0.5rem;
    overflow: hidden;
    text-align: start;
    text-overflow: ellipsis;
    white-space: nowrap;
    pointer-events: none;
    border: 1px solid transparent;
    transform-origin: 0 0;
    transform: scale(1) translateY(0) !important;
    transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), color 0.2s ease, opacity 0.2s ease !important;
    color: #697a8d !important;
    font-size: 0.95rem;
    line-height: 1.25;
    z-index: 5;
    margin: 0;
}

/* Standard Inputs in form-floating */
.simplified-form-wrapper .form-floating > .form-control {
    height: 58px !important;
    min-height: 58px !important;
    line-height: 1.25;
    padding: 1.625rem 0.95rem 0.625rem !important;
    border-radius: 12px !important;
    border: 1.5px solid #d9dee3 !important;
    font-size: 0.95rem !important;
    color: #212529 !important;
    background-color: #fff !important;
}

.simplified-form-wrapper .form-floating > .form-control:focus {
    border-color: #15a362 !important;
    box-shadow: 0 0 0 3px rgba(21, 163, 98, 0.15) !important;
}

/* Floating Label Active State (when input has value, focus, or floated class) */
.simplified-form-wrapper .form-floating > .form-control:focus ~ label,
.simplified-form-wrapper .form-floating > .form-control:not(:placeholder-shown) ~ label,
.simplified-form-wrapper .form-floating.is-floated > label,
.simplified-form-wrapper .form-floating.is-focused > label,
.simplified-form-wrapper .form-floating:has(.select2-container--open) > label,
.simplified-form-wrapper .form-floating:has(.select2-container--focus) > label {
    opacity: 1 !important;
    transform: scale(.8) translateY(-0.55rem) translateX(.15rem) !important;
    color: #15a362 !important;
    font-weight: 600 !important;
}

/* ===== SELECT2 IN FORM FLOATING ===== */
.simplified-form-wrapper .form-floating > .select2-container--bootstrap-5 {
    width: 100% !important;
}

.simplified-form-wrapper .form-floating > .select2-container--bootstrap-5 .select2-selection {
    height: 58px !important;
    min-height: 58px !important;
    padding: 0 1rem !important;
    border-radius: 12px !important;
    border: 1.5px solid #d9dee3 !important;
    display: flex !important;
    align-items: center !important;
    background-color: #fff !important;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
}

.simplified-form-wrapper .form-floating > .select2-container--bootstrap-5.select2-container--focus .select2-selection,
.simplified-form-wrapper .form-floating > .select2-container--bootstrap-5.select2-container--open .select2-selection,
.simplified-form-wrapper .form-floating.is-focused > .select2-container--bootstrap-5 .select2-selection {
    border-color: #15a362 !important;
    box-shadow: 0 0 0 3px rgba(21, 163, 98, 0.15) !important;
}

/* Rendered text inside select: hidden at rest, visible when floated */
.simplified-form-wrapper .form-floating:not(.is-floated):not(.is-focused):not(:has(.select2-container--open)) .select2-selection__rendered {
    opacity: 0 !important;
    transition: opacity 0.2s ease;
}

.simplified-form-wrapper .form-floating.is-floated .select2-selection__rendered,
.simplified-form-wrapper .form-floating.is-focused .select2-selection__rendered,
.simplified-form-wrapper .form-floating:has(.select2-container--open) .select2-selection__rendered {
    opacity: 1 !important;
    padding-top: 1.35rem !important;
    padding-left: 0 !important;
    padding-right: 1.5rem !important;
    color: #212529 !important;
    font-weight: 500 !important;
    font-size: 0.95rem !important;
    line-height: 1.25 !important;
    transition: opacity 0.2s ease, padding 0.2s ease;
}

.simplified-form-wrapper .form-floating > .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
    top: 50% !important;
    transform: translateY(-50%) !important;
    right: 0.95rem !important;
    transition: transform 0.25s ease !important;
}

.simplified-form-wrapper .form-floating:has(.select2-container--open) .select2-selection--single .select2-selection__arrow,
.simplified-form-wrapper .form-floating.is-focused .select2-selection--single .select2-selection__arrow {
    transform: translateY(-50%) rotate(180deg) !important;
}

.select2-container--bootstrap-5 .select2-dropdown .select2-results__options .select2-results__option--highlighted {
    background-color: #15a362 !important;
    color: #ffffff !important;
}

.select2-container--bootstrap-5 .select2-dropdown .select2-results__options .select2-results__option[aria-selected="true"] {
    background-color: #e8f5ed !important;
    color: #15a362 !important;
    font-weight: 600 !important;
}

/* Floating Label for Select2 on Focus / Open */
.simplified-form-wrapper .form-floating:has(.select2-container--open) > label,
.simplified-form-wrapper .form-floating:has(.select2-container--focus) > label {
    opacity: 1 !important;
    transform: scale(.8) translateY(-.65rem) translateX(.15rem) !important;
    color: #15a362 !important;
    font-weight: 600 !important;
}

/* ===== FLATPICKR IN FORM FLOATING ===== */
.simplified-form-wrapper .form-floating > input.flatpickr-input.form-control {
    height: 58px !important;
    min-height: 58px !important;
    padding: 1.625rem 0.95rem 0.625rem !important;
    background-color: #ffffff !important;
    cursor: pointer !important;
}

.simplified-form-wrapper .form-floating:has(input.flatpickr-input:focus) > label {
    opacity: 1 !important;
    transform: scale(.8) translateY(-.65rem) translateX(.15rem) !important;
    color: #15a362 !important;
    font-weight: 600 !important;
}

.flatpickr-calendar {
    border-radius: 14px !important;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.18) !important;
    border: 1px solid #e2e8f0 !important;
    z-index: 10060 !important; /* Always on top of Bootstrap modals */
}

.flatpickr-day.selected, .flatpickr-day.selected:hover {
    background: #15a362 !important;
    border-color: #15a362 !important;
    color: #ffffff !important;
}

.flatpickr-day:hover {
    background: #e8f5ed !important;
}
</style>

<div class="simplified-form-wrapper">
    <input type="hidden" name="StudentID" value="<?= $StudentID ?>">
    <input type="hidden" name="StudentSex" id="StudentSex" value="<?= $StudentSex ?>">

    <!-- Section 1: ข้อมูลส่วนตัวพื้นฐาน -->
    <div class="form-section-card">
        <div class="section-label">
            <i class='bx bx-user'></i> ข้อมูลส่วนตัวพื้นฐาน
        </div>
        
        <div class="row g-3">
            <div class="col-md-3">
                <div class="form-floating">
                    <select class="form-select select2" id="StudentPrefix" name="StudentPrefix" required>
                        <option value=""></option>
                        <?php foreach (['เด็กชาย', 'เด็กหญิง', 'นาย', 'นางสาว'] as $prefix): ?>
                        <option value="<?= $prefix ?>" <?= $StudentPrefix === $prefix ? 'selected' : '' ?>><?= $prefix ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="StudentPrefix"><i class='bx bx-user text-muted me-1'></i>คำนำหน้า <span class="text-danger">*</span></label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="StudentFirstName" name="StudentFirstName" placeholder=" " value="<?= $StudentFirstName ?>" required>
                    <label for="StudentFirstName">ชื่อ (First Name) <span class="text-danger">*</span></label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="StudentLastName" name="StudentLastName" placeholder=" " value="<?= $StudentLastName ?>" required>
                    <label for="StudentLastName">นามสกุล (Last Name) <span class="text-danger">*</span></label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating">
                    <input type="text" class="form-control student-be-datepicker" id="StudentDateBirth" name="StudentDateBirth" placeholder=" " value="<?= $StudentDateBirth ?>" required>
                    <label for="StudentDateBirth"><i class='bx bx-calendar text-success me-1'></i>วันเกิด (พ.ศ.) <span class="text-danger">*</span></label>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-floating">
                    <input type="text" class="form-control font-monospace" id="StudentIDNumber" name="StudentIDNumber" placeholder=" " value="<?= $StudentIDNumber ?>" pattern="[0-9]{13}" maxlength="13" title="กรอกรหัส 13 หลัก" required>
                    <label for="StudentIDNumber"><i class='bx bx-id-card text-muted me-1'></i>เลขประจำตัวประชาชน <span class="text-danger">*</span></label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating">
                    <input type="text" class="form-control font-monospace" id="StudentCode" name="StudentCode" placeholder=" " value="<?= $StudentCode ?>" required>
                    <label for="StudentCode"><i class='bx bx-hash text-muted me-1'></i>เลขประจำตัวนักเรียน <span class="text-danger">*</span></label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating">
                    <input type="text" class="form-control student-be-datepicker" id="StudentDateEntrance" name="StudentDateEntrance" placeholder=" " value="<?= $StudentDateEntrance ?>">
                    <label for="StudentDateEntrance"><i class='bx bx-calendar text-success me-1'></i>วันที่เข้าเรียน (พ.ศ.)</label>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: ข้อมูลการศึกษาและสถานะ -->
    <div class="form-section-card">
        <div class="section-label">
            <i class='bx bx-book-bookmark'></i> ข้อมูลการเรียนและสถานะ
        </div>

        <div class="row g-3">
            <div class="col-md-3">
                <div class="form-floating">
                    <select class="form-select select2" id="StudentClass" name="StudentClass" required>
                        <option value=""></option>
                        <?php if (!empty($class_list)): foreach ($class_list as $cls): ?>
                        <option value="ม.<?= $cls ?>" <?= $StudentClass === ('ม.' . $cls) ? 'selected' : '' ?>>ม.<?= $cls ?></option>
                        <?php endforeach; else: ?>
                            <?php for($i=1;$i<=6;$i++): ?>
                                <option value="ม.<?= $i ?>" <?= $StudentClass === ('ม.' . $i) ? 'selected' : '' ?>>ม.<?= $i ?></option>
                            <?php endfor; ?>
                        <?php endif; ?>
                    </select>
                    <label for="StudentClass"><i class='bx bx-book text-muted me-1'></i>ระดับชั้น <span class="text-danger">*</span></label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating">
                    <input type="number" class="form-control" id="StudentNumber" name="StudentNumber" placeholder=" " value="<?= $StudentNumber ?>">
                    <label for="StudentNumber">เลขที่ (No.)</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-select select2" id="StudentStudyLine" name="StudentStudyLine">
                        <option value=""></option>
                        <?php 
                        $lines = !empty($study_line_list) ? $study_line_list : ['GENERAL', 'CEP', 'CP', 'CP1', 'CP2', 'PAP1', 'PAP2', 'PAP3', 'PAP4', 'SMT(S)', 'SMT(T)', 'SP1', 'SP2', 'SP3', 'SP4'];
                        $uniqueLines = array_unique(array_filter($lines, function($item) {
                            return !empty($item) && $item !== 'เลือกสายการเรียน' && $item !== 'ทั่วไป' && $item !== 'GENERAL (ทั่วไป)';
                        }));
                        foreach ($uniqueLines as $line): 
                        ?>
                        <option value="<?= esc($line) ?>" <?= $StudentStudyLine === $line ? 'selected' : '' ?>><?= esc($line) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="StudentStudyLine"><i class='bx bx-category text-muted me-1'></i>สายการเรียน (Study Line)</label>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-select select2" id="StudentStatus" name="StudentStatus" required>
                        <option value="1/ปกติ" <?= $StudentStatus == '1/ปกติ' ? 'selected' : '' ?>>1/ปกติ</option>
                        <?php foreach (['2/ย้ายสถานศึกษา', '3/ขาดประจำ', '4/พักการเรียน', '5/จบการศึกษา', '6/เสียชีวิต'] as $status): ?>
                        <option value="<?= $status ?>" <?= ($StudentStatus === $status || ($status === '6/เสียชีวิต' && $StudentStatus === 'เสียชีวิต')) ? 'selected' : '' ?>><?= $status ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="StudentStatus"><i class='bx bx-check-circle text-muted me-1'></i>สถานะนักเรียน <span class="text-danger">*</span></label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-select select2" id="StudentBehavior" name="StudentBehavior">
                        <option value="ปกติ" <?= $StudentBehavior == 'ปกติ' ? 'selected' : '' ?>>ปกติ</option>
                        <?php foreach (['ขาดเรียนนาน', 'พฤติกรรมเสี่ยง', 'จำหน่าย', 'เสียชีวิต'] as $behavior): ?>
                        <option value="<?= $behavior ?>" <?= $StudentBehavior === $behavior ? 'selected' : '' ?>><?= $behavior ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="StudentBehavior"><i class='bx bx-info-circle text-muted me-1'></i>สถานะพฤติกรรม (Behavior)</label>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Function to synchronize floating labels for inputs, selects and flatpickr
function syncFormFloatingLabels($scope) {
    var $root = $scope ? $($scope) : $('.simplified-form-wrapper');

    $root.find('.form-floating').each(function() {
        var $ff = $(this);
        var hasVal = false;

        var $select = $ff.find('select');
        if ($select.length && $select.val() && $select.val().toString().trim() !== '') {
            hasVal = true;
        }

        var $input = $ff.find('input:not([type="hidden"])');
        if ($input.length && $input.val() && $input.val().toString().trim() !== '') {
            hasVal = true;
        }

        if (hasVal) {
            $ff.addClass('is-floated');
        } else {
            $ff.removeClass('is-floated');
        }
    });
}

// Global initialization helper for Select2 and Buddhist Era Flatpickr
function initStudentFormComponents($scope) {
    var $root = $scope ? $($scope) : $('.simplified-form-wrapper');

    // 1. Initialize Select2 on all select elements
    if ($.fn.select2) {
        $root.find('select.select2, select').each(function() {
            var $sel = $(this);
            if ($sel.hasClass('select2-hidden-accessible')) {
                $sel.select2('destroy');
            }
            var $modal = $sel.closest('.modal');
            $sel.select2({
                theme: 'bootstrap-5',
                width: '100%',
                dropdownParent: $modal.length ? $modal : $(document.body)
            });

            // Handle floating label on select2 open/close/change
            $sel.off('select2:opening.float select2:open.float select2:closing.float select2:close.float change.float')
                .on('select2:opening.float select2:open.float', function() {
                    $(this).closest('.form-floating').addClass('is-focused is-floated');
                })
                .on('select2:closing.float select2:close.float', function() {
                    var $ff = $(this).closest('.form-floating');
                    $ff.removeClass('is-focused');
                    syncFormFloatingLabels($ff);
                })
                .on('change.float', function() {
                    syncFormFloatingLabels($(this).closest('.form-floating'));
                });
        });
    }

    // 2. Initialize Flatpickr in Buddhist Era (พ.ศ.)
    if (typeof flatpickr !== 'undefined') {
        var updateCalendarBE = function(instance) {
            setTimeout(function() {
                if (!instance || !instance.calendarContainer) return;
                var yearInput = instance.calendarContainer.querySelector(".numInput.cur-year");
                if (yearInput) {
                    var yr = parseInt(instance.currentYear, 10);
                    if (yr < 2400) yearInput.value = yr + 543;
                }
                var yearDisplay = instance.calendarContainer.querySelector(".flatpickr-current-month .cur-year");
                if (yearDisplay && yearDisplay.tagName !== "INPUT") {
                    var yr = parseInt(instance.currentYear, 10);
                    if (yr < 2400) yearDisplay.textContent = yr + 543;
                }
            }, 10);
        };

        $root.find('.student-be-datepicker').each(function() {
            var $input = $(this);
            var rawVal = ($input.val() || '').trim();
            var initialDate = null;

            if (rawVal) {
                if (rawVal.includes('/')) {
                    var parts = rawVal.split('/');
                    if (parts.length === 3) {
                        var d = parseInt(parts[0], 10);
                        var m = parseInt(parts[1], 10) - 1;
                        var y = parseInt(parts[2], 10);
                        if (y > 2400) y -= 543;
                        initialDate = new Date(y, m, d);
                    }
                } else if (rawVal.includes('-')) {
                    var parts = rawVal.split('-');
                    if (parts.length === 3) {
                        if (parts[0].length === 4) { // YYYY-MM-DD
                            var y = parseInt(parts[0], 10);
                            var m = parseInt(parts[1], 10) - 1;
                            var d = parseInt(parts[2], 10);
                            if (y > 2400) y -= 543;
                            initialDate = new Date(y, m, d);
                        } else { // DD-MM-YYYY
                            var d = parseInt(parts[0], 10);
                            var m = parseInt(parts[1], 10) - 1;
                            var y = parseInt(parts[2], 10);
                            if (y > 2400) y -= 543;
                            initialDate = new Date(y, m, d);
                        }
                    }
                }
            }

            if (this._flatpickr) {
                this._flatpickr.destroy();
            }

            var fp = $input.flatpickr({
                disableMobile: true,
                dateFormat: "d/m/Y",
                altInput: true,
                altFormat: "d/m/Y",
                defaultDate: initialDate,
                locale: "th",
                onReady: function(s, d, inst) { 
                    updateCalendarBE(inst); 
                    syncFormFloatingLabels($input.closest('.form-floating'));
                },
                onOpen: function(s, d, inst) { 
                    updateCalendarBE(inst); 
                    $input.closest('.form-floating').addClass('is-floated');
                },
                onClose: function(s, d, inst) {
                    syncFormFloatingLabels($input.closest('.form-floating'));
                },
                onChange: function(s, d, inst) {
                    syncFormFloatingLabels($input.closest('.form-floating'));
                },
                onMonthChange: function(s, d, inst) { updateCalendarBE(inst); },
                onYearChange: function(s, d, inst) { updateCalendarBE(inst); },
                formatDate: function(date, format, locale) {
                    var d = date.getDate().toString().padStart(2, '0');
                    var m = (date.getMonth() + 1).toString().padStart(2, '0');
                    var y = date.getFullYear() + 543;
                    return d + "/" + m + "/" + y;
                },
                parseDate: function(dateStr, format) {
                    if (dateStr && dateStr.includes('/')) {
                        var parts = dateStr.split('/');
                        if (parts.length === 3) {
                            var d = parseInt(parts[0], 10);
                            var m = parseInt(parts[1], 10) - 1;
                            var y = parseInt(parts[2], 10);
                            if (y > 2400) y -= 543;
                            return new Date(y, m, d);
                        }
                    }
                    return flatpickr.parseDate(dateStr, "Y-m-d");
                }
            });
        });
    }

    // 3. Auto detect sex on Prefix change
    $root.find('#StudentPrefix').off('change.autoSex').on('change.autoSex', function() {
        var val = $(this).val();
        var sex = '';
        if (val === 'เด็กชาย' || val === 'นาย') sex = 'ชาย';
        else if (val === 'เด็กหญิง' || val === 'นางสาว') sex = 'หญิง';
        if (sex) {
            $root.find('#StudentSex').val(sex);
        }
    });

    // 4. Input events for text inputs to keep floating label in sync
    $root.find('.form-floating input').off('input.float focus.float blur.float')
        .on('input.float focus.float blur.float', function() {
            syncFormFloatingLabels($(this).closest('.form-floating'));
        });

    // Initial label sync
    syncFormFloatingLabels($root);
}

// Auto-run on document ready or dynamic load
if (typeof jQuery !== 'undefined') {
    $(function() {
        initStudentFormComponents();
    });
    setTimeout(function() {
        initStudentFormComponents();
    }, 150);
}
</script>
