<?= $this->extend('admin/layout/main') ?>

<?= $this->section('extra_css') ?>
<style>
    :root {
        --primary-emerald: #15a362;
        --soft-emerald: #f0faf5;
    }

    .master-grid-card {
        border-radius: 15px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .slot-master {
        height: 80px;
        transition: all 0.2s ease;
        cursor: pointer;
        border: 1px dashed #e0e0e0;
        position: relative;
        background: #fff;
    }

    .slot-master:hover {
        background: var(--soft-emerald);
        border-color: var(--primary-emerald);
        transform: scale(1.02);
        z-index: 10;
        box-shadow: 0 5px 15px rgba(21, 163, 98, 0.1);
    }

    .slot-filled {
        background: var(--soft-emerald);
        border: 2px solid var(--primary-emerald) !important;
    }

    .slot-filled .activity-name {
        color: var(--primary-emerald);
        font-weight: 700;
        font-size: 0.85rem;
    }

    .slot-filled .level-badge {
        position: absolute;
        bottom: 5px;
        right: 5px;
        font-size: 0.6rem;
    }

    .day-col {
        width: 100px;
        background: #f8f9fa;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        border-right: 2px solid #eee;
    }

    .period-header {
        background: #f8f9fa;
        border-bottom: 2px solid #eee;
        padding: 10px;
        text-align: center;
    }

    .period-number {
        font-weight: 800;
        color: #444;
        display: block;
    }

    .period-time {
        font-size: 0.7rem;
        color: #888;
    }

    .swal2-container {
        z-index: 9999 !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">วิชาการ / ตารางสอน /</span> ตั้งค่าตารางกิจกรรมหลัก (Master Slots) 📅
            </h4>
            <div class="text-muted small">กำหนดกิจกรรมที่เรียนพร้อมกันทั้งระดับชั้น เช่น ชุมนุม, ลูกเสือ, โฮมรูม</div>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= base_url('admin/academic/timetable/process') ?>" class="btn btn-label-secondary btn-lg rounded-4 shadow-sm px-4">
                <i class="bx bx-chevron-left fs-4 me-1"></i> ย้อนกลับหน้าจัดตาราง
            </a>
            <button class="btn btn-primary btn-lg rounded-4 shadow-sm px-4" onclick="location.reload()">
                <i class="bx bx-refresh fs-4 me-1"></i> รีเฟรช
            </button>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 bg-label-success">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="avatar avatar-md bg-success rounded-3 me-3">
                        <i class="bx bx-info-circle text-white fs-3"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-success">คำแนะนำการใช้งาน</h6>
                        <p class="mb-0 small text-dark opacity-75">
                            คลิกที่ช่องคาบเรียนเพื่อกำหนดกิจกรรมส่วนกลาง วิชาที่ถูกระบุในหน้านี้จะถูก <b>"ล็อคตายตัว"</b> 
                            และครูจะไม่สามารถถูกจัดลงในคาบเหล่านี้ได้หากมีกิจกรรมทับซ้อน
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card master-grid-card">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center py-3">
            <div class="d-flex align-items-center gap-3">
                <h5 class="m-0 fw-bold text-dark"><i class='bx bx-grid-alt me-2 text-primary'></i> ผังตารางกิจกรรมหลัก</h5>
                <div class="btn-group btn-group-sm rounded-pill overflow-hidden border shadow-sm" role="group">
                    <input type="radio" class="btn-check" name="level_filter" id="filter_all" value="ALL" checked>
                    <label class="btn btn-outline-primary px-3" for="filter_all">ทั้งหมด</label>
                    
                    <input type="radio" class="btn-check" name="level_filter" id="filter_junior" value="Junior">
                    <label class="btn btn-outline-primary px-3" for="filter_junior">ม.ต้น</label>
                    
                    <input type="radio" class="btn-check" name="level_filter" id="filter_senior" value="Senior">
                    <label class="btn btn-outline-primary px-3" for="filter_senior">ม.ปลาย</label>
                </div>
            </div>
            <div class="badge bg-label-primary fs-6 py-2 px-3 rounded-pill border border-primary border-opacity-25">
                ปีการศึกษา <?= $term ?>/<?= $year ?>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered m-0 border-0">
                    <thead>
                        <tr>
                            <th class="day-col p-0">วัน / คาบ</th>
                            <?php foreach($periods as $p): ?>
                            <th class="period-header p-0">
                                <div class="py-2">
                                    <span class="period-number">คาบ <?= $p->period_number ?></span>
                                    <span class="period-time"><?= date('H:i', strtotime($p->start_time)) ?> - <?= date('H:i', strtotime($p->end_time)) ?></span>
                                </div>
                            </th>
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
                            <td class="day-col" style="background: <?= $colors[0] ?>; color: <?= $colors[1] ?>;">
                                <?= $day->day_name ?>
                            </td>
                            <?php foreach($periods as $p): ?>
                            <td class="p-0">
                                <div id="slot-<?= $day->day_key ?>-<?= $p->period_number ?>" 
                                     class="slot-master d-flex flex-column align-items-center justify-content-center text-center p-2"
                                     onclick="editMasterSlot('<?= $day->day_key ?>', '<?= $p->period_number ?>', '<?= $day->day_name ?>')">
                                    <div class="activity-display w-100">
                                        <!-- Activities will be rendered here by JS -->
                                        <i class="bx bx-plus text-muted opacity-25 fs-4"></i>
                                    </div>
                                </div>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Master Slot -->
<div class="modal fade" id="modalMasterSlot" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <form class="modal-content border-0 shadow-lg rounded-4" id="formMasterSlot">
            <div class="modal-header bg-primary text-white border-0 py-3">
                <h5 class="modal-title fw-bold text-white mb-0">ตั้งค่ากิจกรรมหลัก</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" id="modal_day" name="day">
                <input type="hidden" id="modal_period" name="period">
                
                <div class="text-center mb-3">
                    <span class="badge bg-label-primary fs-7 mb-1" id="modal_info_day"></span>
                    <h6 class="fw-bold mb-0" id="modal_info_period"></h6>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-uppercase">ระดับชั้นที่มีกิจกรรม</label>
                    <select class="form-select rounded-pill border-primary" name="level_group" id="modal_level_group">
                        <option value="ALL">ทุกระดับชั้น (ALL)</option>
                        <option value="Junior">มัธยมต้น (Junior)</option>
                        <option value="Senior">มัธยมปลาย (Senior)</option>
                    </select>
                </div>

                <div class="mb-0">
                    <label class="form-label fw-bold small text-uppercase">ชื่อกิจกรรม / วิชา</label>
                    <input type="text" class="form-control rounded-pill border-primary" 
                           name="subject_name" id="modal_subject_name" 
                           placeholder="เช่น ชุมนุม, ลูกเสือ, โฮมรูม" 
                           autocomplete="off">
                    <div class="form-text small mt-1 text-danger italic">* เว้นว่างเพื่อลบกิจกรรมออก</div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0 p-4">
                <button type="button" class="btn btn-label-secondary rounded-pill px-4" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow">บันทึกข้อมูล</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    const masterData = <?= json_encode($master_slots) ?>;
    let currentFilter = 'ALL';

    $(document).ready(function() {
        renderGrid();

        $('input[name="level_filter"]').on('change', function() {
            currentFilter = $(this).val();
            renderGrid();
        });

        $('#formMasterSlot').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            
            Swal.fire({
                title: 'กำลังบันทึก...',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            $.post('<?= base_url("admin/academic/timetable/save-master-slot") ?>', formData, function(res) {
                if(res.status === 'success') {
                    Swal.fire({ icon: 'success', title: 'สำเร็จ', text: res.message, timer: 1000, showConfirmButton: false })
                        .then(() => window.location.reload());
                } else {
                    Swal.fire('ผิดพลาด', res.message, 'error');
                }
            });
        });
    });

    function renderGrid() {
        // Reset all slots
        $('.slot-master').removeClass('slot-filled');
        $('.activity-display').html('<i class="bx bx-plus text-muted opacity-25 fs-4"></i>');

        masterData.forEach(item => {
            // If filter is ALL, show everything but highlight ALL differently
            // If filter is Junior/Senior, only show that level + ALL
            const show = (currentFilter === 'ALL') || 
                         (item.level_group === 'ALL') || 
                         (item.level_group === currentFilter);

            if (show) {
                const $slot = $(`#slot-${item.day}-${item.period}`);
                $slot.addClass('slot-filled');
                
                let badgeClass = 'bg-label-primary';
                if(item.level_group === 'Junior') badgeClass = 'bg-label-success';
                if(item.level_group === 'Senior') badgeClass = 'bg-label-warning';

                $slot.find('.activity-display').html(`
                    <div class="activity-name text-truncate px-1">${item.subject_name}</div>
                    <span class="badge ${badgeClass} level-badge">${item.level_group}</span>
                `);
            }
        });
    }

    function editMasterSlot(day, period, dayName) {
        $('#modal_day').val(day);
        $('#modal_period').val(period);
        $('#modal_info_day').text(dayName);
        $('#modal_info_period').text('คาบที่ ' + period);

        // Check if there's existing data for the CURRENT filter
        const existing = masterData.find(m => m.day === day && m.period === period && m.level_group === currentFilter);
        
        $('#modal_subject_name').val(existing ? existing.subject_name : '');
        $('#modal_level_group').val(currentFilter).trigger('change');

        $('#modalMasterSlot').modal('show');
    }
</script>
<?= $this->endSection() ?>
