<?php 
// Simplified student details form - minimal fields as requested
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
/* Modern Compact Layout for Simplified Form */
.simplified-form-wrapper {
    max-width: 1000px;
    margin: 0 auto;
}

.form-section-card {
    background: #fff;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    border: 1px solid #eef2f7;
    box-shadow: 0 10px 30px rgba(0,0,10,0.02);
}

.section-label {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
    font-weight: 700;
    color: #15a362;
    font-size: 1.2rem;
}

.section-label i {
    margin-right: 0.75rem;
    background: #e8f5ed;
    padding: 10px;
    border-radius: 12px;
}

.form-floating > .form-control, .form-floating > .form-select {
    border-radius: 12px;
    border: 2px solid #f1f3f5;
    transition: all 0.3s;
}

.form-floating > .form-control:focus, .form-floating > .form-select:focus {
    border-color: #15a362;
    box-shadow: 0 0 0 4px rgba(21, 163, 98, 0.1);
}

.form-floating > label {
    font-weight: 500;
    color: #6c757d;
}
</style>

<div class="simplified-form-wrapper">
    <input type="hidden" name="StudentID" value="<?= $StudentID ?>">

    <!-- Section 1: ข้อมูลส่วนตัวพื้นฐาน -->
    <div class="form-section-card">
        <div class="section-label">
            <i class='bx bx-user'></i> ข้อมูลส่วนตัวพื้นฐาน
        </div>
        
        <div class="row g-3">
            <div class="col-md-3">
                <div class="form-floating">
                    <select class="form-select" id="StudentPrefix" name="StudentPrefix" required>
                        <option value="">เลือกคำนำหน้า</option>
                        <?php foreach (['เด็กชาย', 'เด็กหญิง', 'นาย', 'นางสาว'] as $prefix): ?>
                        <option value="<?= $prefix ?>" <?= $StudentPrefix === $prefix ? 'selected' : '' ?>><?= $prefix ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="StudentPrefix">คำนำหน้า (Prefix)</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="StudentFirstName" name="StudentFirstName" placeholder="ชื่อ" value="<?= $StudentFirstName ?>" required>
                    <label for="StudentFirstName">ชื่อ (First Name)</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="StudentLastName" name="StudentLastName" placeholder="นามสกุล" value="<?= $StudentLastName ?>" required>
                    <label for="StudentLastName">นามสกุล (Last Name)</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating">
                    <input type="text" class="form-control student-be-datepicker" id="StudentDateBirth" name="StudentDateBirth" placeholder="วันเกิด" value="<?= $StudentDateBirth ?>" required>
                    <label for="StudentDateBirth">วันเกิด (Birthday)</label>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-floating">
                    <input type="text" class="form-control" id="StudentIDNumber" name="StudentIDNumber" placeholder="เลขประจำตัวประชาชน" value="<?= $StudentIDNumber ?>" pattern="[0-9]{13}" maxlength="13" title="กรอกรหัส 13 หลัก" required>
                    <label for="StudentIDNumber">เลขประจำตัวประชาชน (Thai ID)</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating">
                    <input type="text" class="form-control" id="StudentCode" name="StudentCode" placeholder="เลขประจำตัวนักเรียน" value="<?= $StudentCode ?>" required>
                    <label for="StudentCode">เลขประจำตัวนักเรียน (Student Code)</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating">
                    <input type="text" class="form-control student-be-datepicker" id="StudentDateEntrance" name="StudentDateEntrance" placeholder="วันที่เข้าเรียน" value="<?= $StudentDateEntrance ?>">
                    <label for="StudentDateEntrance">วันที่เข้าเรียน (Entrance Date)</label>
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
                    <select class="form-select" id="StudentClass" name="StudentClass" required>
                        <option value="">เลือกระดับชั้น</option>
                        <?php if (!empty($class_list)): foreach ($class_list as $cls): ?>
                        <option value="ม.<?= $cls ?>" <?= $StudentClass === ('ม.' . $cls) ? 'selected' : '' ?>>ม.<?= $cls ?></option>
                        <?php endforeach; else: ?>
                            <?php for($i=1;$i<=6;$i++): ?>
                                <option value="ม.<?= $i ?>" <?= $StudentClass === ('ม.' . $i) ? 'selected' : '' ?>>ม.<?= $i ?></option>
                            <?php endfor; ?>
                        <?php endif; ?>
                    </select>
                    <label for="StudentClass">ระดับชั้น (Class)</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating">
                    <input type="number" class="form-control" id="StudentNumber" name="StudentNumber" placeholder="เลขที่" value="<?= $StudentNumber ?>">
                    <label for="StudentNumber">เลขที่ (No.)</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-select" id="StudentStudyLine" name="StudentStudyLine">
                        <option value="">เลือกสายการเรียน</option>
                        <?php 
                        $lines = !empty($study_line_list) ? $study_line_list : ['GENERAL', 'CEP', 'CP', 'PAP1', 'PAP2', 'PAP3', 'PAP4', 'SMT(S)', 'SMT(T)', 'SP1', 'SP2', 'SP3', 'SP4'];
                        $uniqueLines = array_unique(array_filter($lines, function($item) {
                            return !empty($item) && $item !== 'เลือกสายการเรียน' && $item !== 'ทั่วไป' && $item !== 'GENERAL (ทั่วไป)';
                        }));
                        foreach ($uniqueLines as $line): 
                        ?>
                        <option value="<?= esc($line) ?>" <?= $StudentStudyLine === $line ? 'selected' : '' ?>><?= esc($line) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="StudentStudyLine">สายการเรียน (Study Line)</label>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-select" id="StudentStatus" name="StudentStatus" required>
                        <option value="1/ปกติ" <?= $StudentStatus == '1/ปกติ' ? 'selected' : '' ?>>1/ปกติ</option>
                        <?php foreach (['2/ย้ายสถานศึกษา', '3/ขาดประจำ', '4/พักการเรียน', '5/จบการศึกษา'] as $status): ?>
                        <option value="<?= $status ?>" <?= $StudentStatus === $status ? 'selected' : '' ?>><?= $status ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="StudentStatus">สถานะนักเรียน (Status)</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-select" id="StudentBehavior" name="StudentBehavior">
                        <option value="ปกติ" <?= $StudentBehavior == 'ปกติ' ? 'selected' : '' ?>>ปกติ</option>
                        <?php foreach (['ขาดเรียนนาน', 'พฤติกรรมเสี่ยง', 'จำหน่าย'] as $behavior): ?>
                        <option value="<?= $behavior ?>" <?= $StudentBehavior === $behavior ? 'selected' : '' ?>><?= $behavior ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="StudentBehavior">สถานะพฤติกรรม (Behavior)</label>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto sex detection based on prefix
    const prefixSelect = document.getElementById('StudentPrefix');
    if (prefixSelect) {
        prefixSelect.addEventListener('change', function() {
            const val = this.value;
            let sex = '';
            if (val === 'เด็กชาย' || val === 'นาย') sex = 'ชาย';
            else if (val === 'เด็กหญิง' || val === 'นางสาว') sex = 'หญิง';
            
            // You might want a hidden sex field if the DB requires it
        });
    }

    // Initialize Flatpickr for B.E. (พ.ศ.)
    if (typeof flatpickr !== 'undefined') {
        flatpickr(".student-be-datepicker", {
            disableMobile: true,
            dateFormat: "Y-m-d", // ส่งค่า ค.ศ. ISO ไปที่ Controller
            altInput: true,      // แสดงผลอีกรูปแบบให้ผู้ใช้เห็น
            altFormat: "d/m/Y",  // รูปแบบวัน/เดือน/ปี
            locale: "th",
            onOpen: function(selectedDates, dateStr, instance) {
                // เปลี่ยนปีในหัวปฏิทินให้เป็น พ.ศ. เมื่อเปิด
                updateCalendarToBE(instance);
            },
            onMonthChange: function(selectedDates, dateStr, instance) {
                setTimeout(() => updateCalendarToBE(instance), 0);
            },
            onYearChange: function(selectedDates, dateStr, instance) {
                setTimeout(() => updateCalendarToBE(instance), 0);
            },
            formatDate: function(date, format, locale) {
                // ปรับการแสดงผลในช่อง Input ให้เป็น พ.ศ.
                if (format === "d/m/Y") {
                    const d = date.getDate().toString().padStart(2, '0');
                    const m = (date.getMonth() + 1).toString().padStart(2, '0');
                    const y = date.getFullYear() + 543;
                    return `${d}/${m}/${y}`;
                }
                return flatpickr.formatDate(date, format, locale);
            },
            parseDate: function(dateStr, format) {
                // แปลง พ.ศ. กลับเป็น ค.ศ. เมื่อมีการพิมพ์
                if (dateStr && dateStr.includes('/')) {
                    const parts = dateStr.split('/');
                    if (parts.length === 3) {
                        const d = parseInt(parts[0], 10);
                        const m = parseInt(parts[1], 10) - 1;
                        const y = parseInt(parts[2], 10) - 543;
                        return new Date(y, m, d);
                    }
                }
                return flatpickr.parseDate(dateStr, format);
            }
        });

        // ฟังก์ชันช่วยเปลี่ยนตัวเลขปีในเมนูเลือกปีของ Flatpickr
        function updateCalendarToBE(instance) {
            setTimeout(() => {
                // 1. จัดการตัวเลขปีที่เป็นข้อความ (Text display)
                const yearDisplay = instance.calendarContainer.querySelector(".flatpickr-current-month .cur-year");
                if (yearDisplay) {
                    const year = parseInt(instance.currentYear);
                    if (year < 2400) {
                        if (yearDisplay.tagName === "INPUT") {
                            yearDisplay.value = year + 543;
                        } else {
                            yearDisplay.textContent = year + 543;
                        }
                    }
                }

                // 2. จัดการตัวเลขปีในตัวเลือกแบบ Dropdown (ถ้ามี)
                const monthDropdown = instance.calendarContainer.querySelector(".flatpickr-monthDropdown-months");
                // (Flatpickr มักไม่ใช้ dropdown ปีแบบมาตรฐาน แต่ใช้ numInput)
                
                // 3. จัดการ numInput (ตัวเลขปีที่กดลูกศรขึ้นลงได้)
                const yearInput = instance.calendarContainer.querySelector(".numInput.cur-year");
                if (yearInput) {
                    const year = parseInt(instance.currentYear);
                    if (year < 2400) {
                        yearInput.value = year + 543;
                    }
                }
            }, 5); // รอให้ Flatpickr render เสร็จเล็กน้อย
        }
    }
});
</script>