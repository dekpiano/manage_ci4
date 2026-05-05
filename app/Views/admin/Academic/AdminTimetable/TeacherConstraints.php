<?= $this->extend('admin/layout/main') ?>

<?= $this->section('extra_css') ?>
<style>
    .constraint-grid td {
        height: 70px;
        width: 110px;
        vertical-align: middle;
        text-align: center;
        padding: 5px !important;
    }
    .constraint-slot {
        cursor: pointer;
        transition: all 0.2s;
        border-radius: 8px;
        border: 2px dashed #eee;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
    }
    .constraint-slot:hover {
        background-color: #f8f9fa;
        border-color: #ff3e1d;
    }
    .constraint-slot.locked {
        background-color: #fff1f0;
        border: 2px solid #ff3e1d;
        color: #ff3e1d;
        font-weight: bold;
    }
    .constraint-slot.locked i {
        font-size: 1.2rem;
        margin-bottom: 2px;
    }
    .day-col {
        width: 100px;
        font-weight: bold;
    }
    .select2-container--bootstrap-5 .select2-selection {
        border-radius: 50px;
    }
    /* Ensure SweetAlert2 is always on top */
    .swal2-container {
        z-index: 9999 !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">วิชาการ / ตารางสอน /</span> เงื่อนไขเวลาของครู</h4>
        <div class="badge bg-label-success fs-6">ปีการศึกษา <?= $term ?>/<?= $year ?></div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 mx-auto">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <label class="form-label fw-bold">เลือกครูผู้สอนเพื่อจัดการเวลา</label>
                    <div class="input-group">
                        <select class="form-select select2" id="teacherSelect">
                            <option value="">-- เลือกครูผู้สอน --</option>
                            <?php foreach($teachers as $t): ?>
                            <option value="<?= $t->pers_id ?>" <?= $selected_teacher == $t->pers_id ? 'selected' : '' ?>>
                                <?= $t->pers_prefix ?><?= $t->pers_firstname ?> <?= $t->pers_lastname ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <button class="btn btn-primary" type="button" id="btnFilter"><i class="bx bx-search"></i> ดึงข้อมูล</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if($selected_teacher): ?>
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-white border-bottom py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-danger"><i class="bx bx-lock-alt me-2"></i>กำหนดเวลา "ไม่ว่างสอน" (Teacher Locks)</h5>
                <span class="badge bg-label-secondary">คลิกที่ช่องเพื่อ ล็อค / ปลดล็อค</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered m-0 constraint-grid">
                    <thead class="bg-light">
                        <tr>
                            <th class="day-col text-center">วัน / คาบ</th>
                            <?php foreach($periods as $p): ?>
                            <th class="text-center">คาบ <?= $p->period_number ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $dayMap = [
                            'MON' => ['จันทร์', '#ffebee', '#f44336'],
                            'TUE' => ['อังคาร', '#fce4ec', '#e91e63'],
                            'WED' => ['พุธ', '#e8f5e9', '#4caf50'],
                            'THU' => ['พฤหัสบดี', '#fff3e0', '#ff9800'],
                            'FRI' => ['ศุกร์', '#e3f2fd', '#2196f3'],
                            'SAT' => ['เสาร์', '#f3e5f5', '#9c27b0'],
                            'SUN' => ['อาทิตย์', '#fffde7', '#fbc02d']
                        ];
                        foreach($days as $day): 
                            if(!$day->is_active) continue;
                            $colors = $dayMap[$day->day_key] ?? ['#f8f9fa', '#6c757d'];
                        ?>
                        <tr>
                            <td class="fw-bold text-center" style="background: <?= $colors[0] ?>; color: <?= $colors[1] ?>">
                                <?= $day->day_name ?>
                            </td>
                            <?php foreach($periods as $p): 
                                $is_locked = false;
                                foreach($constraints as $c) {
                                    if($c->day == $day->day_key && $c->period == $p->period_number) {
                                        $is_locked = true; break;
                                    }
                                }
                            ?>
                            <td>
                                <div class="constraint-slot <?= $is_locked ? 'locked' : '' ?>" 
                                     data-day="<?= $day->day_key ?>" 
                                     data-period="<?= $p->period_number ?>"
                                     data-locked="<?= $is_locked ? 1 : 0 ?>">
                                    <?php if($is_locked): ?>
                                        <i class="bx bx-lock-alt"></i>
                                        <span>ไม่ว่าง</span>
                                    <?php else: ?>
                                        <span class="text-muted opacity-25">ว่าง</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-label-danger border-top py-3">
            <div class="d-flex align-items-center">
                <i class="bx bx-error-circle me-2 fs-4"></i>
                <div class="small"><b>หมายเหตุ:</b> คาบที่ถูกล็อคเป็นสีแดง จะถูกใช้เป็นเงื่อนไขในการจัดตารางสอน ระบบจะไม่สามารถวางวิชาที่มีครูท่านนี้สอนลงในคาบเหล่านี้ได้</div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="text-center py-5">
        <div class="mb-3"><i class="bx bx-user-voice text-muted" style="font-size: 5rem;"></i></div>
        <h5 class="text-muted">กรุณาเลือกครูผู้สอนเพื่อจัดการเงื่อนไขเวลา หรือตรวจสอบรายการสรุปด้านล่าง</h5>
    </div>
    <?php endif; ?>

    <!-- Summary Table for All Teacher Constraints -->
    <div class="card shadow-sm border-0 rounded-4 mt-5">
        <div class="card-header bg-white border-bottom py-3">
            <h5 class="mb-0 fw-bold"><i class="bx bx-list-ul me-2 text-primary"></i>รายการเงื่อนไขเวลาครูทั้งหมด (ปีการศึกษา <?= $term ?>/<?= $year ?>)</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th class="text-center">วัน</th>
                            <th class="text-center">คาบที่</th>
                            <th>หมายเหตุ/เหตุผล</th>
                            <th class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($all_constraints)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">ยังไม่มีการกำหนดเงื่อนไขเวลาครู</td>
                        </tr>
                        <?php else: 
                            $dayLabels = [
                                'MON' => ['จันทร์', 'danger'],
                                'TUE' => ['อังคาร', 'secondary'],
                                'WED' => ['พุธ', 'success'],
                                'THU' => ['พฤหัสบดี', 'warning'],
                                'FRI' => ['ศุกร์', 'info'],
                                'SAT' => ['เสาร์', 'primary'],
                                'SUN' => ['อาทิตย์', 'dark']
                            ];
                            foreach($all_constraints as $idx => $con): 
                                $dayInfo = $dayLabels[$con->day] ?? [$con->day, 'secondary'];
                        ?>
                        <tr>
                            <td><?= $idx + 1 ?></td>
                            <td class="fw-bold"><?= $con->pers_prefix ?><?= $con->pers_firstname ?> <?= $con->pers_lastname ?></td>
                            <td class="text-center">
                                <span class="badge bg-label-<?= $dayInfo[1] ?> rounded-pill px-3"><?= $dayInfo[0] ?></span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-primary rounded-circle" style="width: 25px; height: 25px; padding: 5px; line-height: 15px;"><?= $con->period ?></span>
                            </td>
                            <td><?= $con->reason ?: '-' ?></td>
                            <td class="text-center">
                                <a href="<?= base_url("admin/academic/timetable/teacher-constraints?teacher_id=".$con->teacher_id) ?>" class="btn btn-icon btn-label-primary btn-sm rounded-pill">
                                    <i class="bx bx-edit-alt"></i>
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
    let csrfHeader = '<?= csrf_hash() ?>';

    $('.select2').select2({
        theme: 'bootstrap-5'
    });

    $('#btnFilter').on('click', function() {
        const tid = $('#teacherSelect').val();
        if(tid) {
            window.location.href = '<?= base_url("admin/academic/timetable/teacher-constraints") ?>?teacher_id=' + tid;
        } else {
            Swal.fire({ icon: 'warning', title: 'กรุณาเลือกครู', text: 'เลือกครูที่ต้องการจัดการข้อมูลก่อนครับ' });
        }
    });

    $('.constraint-slot').on('click', function() {
        const $slot = $(this);
        const day = $slot.data('day');
        const period = $slot.data('period');
        const currentLocked = $slot.data('locked');
        const newLocked = currentLocked == 1 ? 0 : 1;
        const teacher_id = '<?= $selected_teacher ?>';

        if(!teacher_id) return;

        $slot.css('opacity', '0.5');

        const postData = {
            teacher_id: teacher_id,
            day: day,
            period: period,
            is_locked: newLocked
        };
        postData['<?= csrf_token() ?>'] = csrfHeader;

        $.post('<?= base_url("admin/academic/timetable/save-teacher-constraint") ?>', postData, function(res) {
            if(res.csrf_hash) csrfHeader = res.csrf_hash;
            
            if(res.status === 'success') {
                $slot.css('opacity', '1');
                $slot.data('locked', newLocked);
                if(newLocked == 1) {
                    $slot.addClass('locked').html('<i class="bx bx-lock-alt"></i><span>ไม่ว่าง</span>');
                } else {
                    $slot.removeClass('locked').html('<span class="text-muted opacity-25">ว่าง</span>');
                }
            } else {
                Swal.fire('ผิดพลาด', res.message, 'error');
                $slot.css('opacity', '1');
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
