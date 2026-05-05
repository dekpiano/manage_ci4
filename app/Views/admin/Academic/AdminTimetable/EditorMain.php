<?= $this->extend('admin/layout/main') ?>

<?= $this->section('extra_css') ?>
<style>
.timetable-grid {
    border-collapse: separate;
    border-spacing: 3px;
    table-layout: fixed;
    width: 100%;
}
.timetable-grid th {
    background: #f8f9fa;
    text-align: center;
    padding: 10px 6px;
    border-radius: 8px;
    font-weight: 700;
    color: #566a7f;
    font-size: 0.8rem;
}
.timetable-grid td.slot-cell {
    height: 90px;
    background: #ffffff;
    border: 2px dashed #e0e0e0;
    border-radius: 8px;
    position: relative;
    transition: all 0.2s ease;
    cursor: pointer;
    vertical-align: top;
    padding: 6px;
    font-size: 0.72rem;
}
.timetable-grid td.slot-cell:hover {
    border-color: #15a362;
    background: #f0faf5;
}
.timetable-grid td.slot-cell.slot-filled {
    background: #e8f5e9;
    border: 2px solid #15a362;
    cursor: default;
}
.timetable-grid td.slot-cell.slot-filled:hover {
    background: #ffebee;
    border-color: #ef5350;
}
.assignment-card {
    cursor: pointer;
    transition: all 0.2s ease;
    user-select: none;
}
.assignment-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.assignment-card.active-assign {
    border: 2px solid #15a362 !important;
    box-shadow: 0 0 0 3px rgba(21, 163, 98, 0.2);
}
.sticky-sidebar {
    position: sticky;
    top: 90px;
}
.drag-highlight {
    background-color: rgba(21, 163, 98, 0.2) !important;
    border: 2px dashed #15a362 !important;
}
    .slot-cell.constraint-locked {
        background-color: #fff1f0 !important;
        border: 2px solid #ff3e1d !important;
        position: relative;
    }
    .slot-cell.constraint-locked::after {
        content: "\eb92"; /* bx-lock-alt */
        font-family: 'boxicons' !important;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 1.5rem;
        color: rgba(255, 62, 29, 0.2);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="row align-items-center mb-4">
        <div class="col-md-7">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mb-1">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/academic/timetable') ?>">ตารางสอน</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/academic/timetable/process') ?>">ประมวลผล</a></li>
                    <li class="breadcrumb-item active">จัดตาราง <?= $class_name ?></li>
                </ol>
            </nav>
            <div class="d-flex align-items-center">
                <a href="<?= base_url('admin/academic/timetable/process') ?>" class="btn btn-icon btn-label-secondary rounded-circle me-3">
                    <i class="bx bx-chevron-left fs-4"></i>
                </a>
                <div>
                    <h4 class="fw-bold mb-0">จัดตารางห้อง <?= $class_name ?></h4>
                    <small class="text-muted">ภาคเรียนที่ <?= $term ?>/<?= $year ?></small>
                </div>
            </div>
        </div>
        <div class="col-md-5 text-end">
            <button class="btn btn-label-danger rounded-pill px-3 me-2" id="btnClearAll">
                <i class="bx bx-trash me-1"></i> ล้างตารางห้องนี้
            </button>
            <a href="<?= base_url('admin/academic/timetable/process') ?>" class="btn btn-primary rounded-pill px-4 shadow" style="background: #15a362 !important; border: none;">
                <i class="bx bx-check me-1"></i> เสร็จสิ้น
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Sidebar: Pending Assignments -->
        <div class="col-lg-3">
            <div class="sticky-sidebar">
                <div class="card border-0 shadow-sm rounded-4 mb-3">
                    <div class="card-header border-bottom bg-white py-3 px-3">
                        <h6 class="fw-bold mb-0"><i class="bx bx-list-plus me-1 text-success"></i> วิชาที่ต้องจัด</h6>
                    </div>
                    <div class="card-body p-3">
                        <div id="pendingList" style="max-height: 550px; overflow-y: auto;">
                            <?php foreach($class_assignments as $assign): ?>
                            <?php
                                $t_ids = explode(',', $assign->teacher_id);
                                $t_names = [];
                                foreach($t_ids as $tid) {
                                    foreach($teachers as $t) {
                                        if($t->pers_id == $tid) $t_names[] = $t->pers_firstname;
                                    }
                                }
                            ?>
                             <div class="card assignment-card border mb-2 rounded-3 shadow-none" 
                                  draggable="true"
                                  data-assign-id="<?= $assign->assign_id ?>" 
                                  data-hours="<?= $assign->hours_per_week ?>"
                                  data-split="<?= $assign->period_split ?>"
                                  data-code="<?= $assign->tsub_code ?: 'กิจกรรม' ?>"
                                  data-name="<?= $assign->tsub_name ?>"
                                  data-teacher="<?= implode(', ', $t_names) ?>"
                                  data-teachers="<?= $assign->teacher_id ?>">
                                <div class="card-body p-2">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <span class="badge bg-label-dark" style="font-size:0.65rem;"><?= $assign->tsub_code ?: 'กิจกรรม' ?></span>
                                        <span class="badge bg-success rounded-pill remain-badge" style="font-size:0.65rem;">
                                            <span class="remain-count"><?= $assign->hours_per_week ?></span>/<span><?= $assign->hours_per_week ?></span> คาบ
                                        </span>
                                    </div>
                                    <div class="fw-bold text-dark small text-truncate"><?= $assign->tsub_name ?></div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted" style="font-size: 0.65rem;">
                                            <i class="bx bx-user me-1"></i><?= implode(', ', $t_names) ?>
                                        </div>
                                        <div class="badge bg-label-info p-1" style="font-size: 0.55rem;"><?= str_replace(',', ' + ', $assign->period_split) ?></div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 bg-label-warning">
                    <div class="card-body p-3">
                        <h6 class="fw-bold mb-2 small"><i class="bx bx-info-circle me-1"></i> วิธีใช้งาน (Drag & Drop)</h6>
                        <ul class="ps-3 mb-0 small text-muted">
                            <li><b>ลาก</b> วิชาจากด้านซ้ายมาวางใน <b>ช่องตาราง</b></li>
                            <li><b>ลาก</b> วิชาที่วางแล้วในตารางเพื่อ <b>ย้ายที่</b></li>
                            <li>หรือคลิกเลือกวิชาแล้วคลิกช่องตารางเพื่อวางตามปกติ</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main: Timetable Grid -->
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-3 overflow-auto">
                    <table class="timetable-grid">
                        <thead>
                            <tr>
                                <th style="width: 70px;">วัน / คาบ</th>
                                <?php foreach($periods as $p): ?>
                                <th class="text-center">
                                    <div class="small fw-bold">คาบ <?= $p->period_number ?></div>
                                    <div style="font-size: 0.6rem; font-weight: normal;"><?= date('H:i', strtotime($p->start_time)) ?>-<?= date('H:i', strtotime($p->end_time)) ?></div>
                                </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $dayColors = [
                                'MON' => ['#ffebee', '#f44336'],
                                'TUE' => ['#fce4ec', '#e91e63'],
                                'WED' => ['#e8f5e9', '#4caf50'],
                                'THU' => ['#fff3e0', '#ff9800'],
                                'FRI' => ['#e3f2fd', '#2196f3'],
                                'SAT' => ['#f3e5f5', '#9c27b0'],
                                'SUN' => ['#fffde7', '#fbc02d']
                            ];
                            foreach($days as $day): 
                                if(!$day->is_active) continue;
                                $colors = $dayColors[$day->day_key] ?? ['#f8f9fa', '#6c757d'];

                                // Determine current class group
                                // 🔍 Determine level (Junior: ม.1-3 / Senior: ม.4-6)
                                $isSenior = (preg_match('/ม\.[4-6]/', $class_name) || preg_match('/^[4-6]/', $class_name));
                                $current_level_group = $isSenior ? 'Senior' : 'Junior';
                                $lunchPeriod = $isSenior ? 5 : 4;
                            ?>
                            <tr>
                                <td class="fw-bold text-center" style="background: <?= $colors[0] ?>; color: <?= $colors[1] ?>; border-radius: 8px; font-size: 0.8rem;">
                                    <?= $day->day_name ?>
                                </td>
                                <?php foreach($periods as $p): 
                                    // Check if this period is a break for THIS class
                                    $isLunch = ((int)$p->period_number == (int)$lunchPeriod);
                                    $is_this_break = ($p->is_break && ($p->level_group == 'ALL' || $p->level_group == $current_level_group));
                                    
                                    // Check for Master Slot
                                    $master_subject = null;
                                    foreach($master_slots as $ms) {
                                        if($ms->day == $day->day_key && $ms->period == $p->period_number && ($ms->level_group == 'ALL' || $ms->level_group == $current_level_group)) {
                                            $master_subject = $ms->subject_name;
                                            break;
                                        }
                                    }
                                ?>
                                <td class="slot-cell <?= ($isLunch || $is_this_break || $master_subject) ? 'locked-cell bg-light' : '' ?>" 
                                    data-day="<?= $day->day_key ?>" 
                                    data-period="<?= $p->period_number ?>"
                                    data-is-locked="<?= ($isLunch || $is_this_break || $master_subject) ? '1' : '0' ?>">
                                    <?php if($isLunch): ?>
                                        <div class="text-center text-danger fw-bold small mt-2 py-2 bg-warning bg-opacity-10 rounded border border-warning border-opacity-25" style="font-size: 0.6rem !important;">พักกลางวัน</div>
                                    <?php elseif($is_this_break): ?>
                                        <div class="text-center text-muted fw-bold small mt-2 py-2 bg-secondary bg-opacity-10 rounded">พัก</div>
                                    <?php elseif($master_subject): ?>
                                        <div class="text-center mt-1">
                                            <div class="fw-bold text-info" style="font-size: 0.65rem;"><?= $master_subject ?></div>
                                            <span class="badge bg-label-info p-1" style="font-size: 0.5rem;">กิจกรรม</span>
                                        </div>
                                    <?php endif; ?>
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
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    let selectedAssignId = null;
    const csrfTokenName = '<?= csrf_token() ?>';
    const masterSlots = <?= json_encode($master_slots) ?>;
    const teacherConstraints = <?= json_encode($teacher_constraints) ?>;
    let csrfHeader = '<?= csrf_hash() ?>';
    let currentDragBlockSize = 1;

    // Helper to update CSRF after AJAX
    function updateCSRF(res) {
        if (res && res.csrf_hash) csrfHeader = res.csrf_hash;
    }

    function getNextBlockSize(assignId) {
        const card = $(`.assignment-card[data-assign-id="${assignId}"]`);
        if (!card.length) return 1;
        const total = parseInt(card.data('hours'));
        const remain = parseInt(card.find('.remain-count').text());
        const placed = total - remain;
        const splits = card.data('split').toString().split(',').map(Number);
        let current = 0;
        for (let s of splits) {
            if (placed >= current && placed < current + s) return s;
            current += s;
        }
        return 1;
    }

    const teachersList = <?= json_encode($teachers) ?>;
    const labelColors = ['primary', 'success', 'warning', 'info', 'danger', 'secondary', 'dark'];
    const getAssignColor = (id) => labelColors[id % labelColors.length];
    
    const getTeacherName = (ids) => {
        if(!ids) return '';
        const idArr = ids.toString().split(',');
        return idArr.map(id => {
            const t = teachersList.find(item => item.pers_id == id);
            return t ? t.pers_firstname : id;
        }).join(', ');
    };

    // --- Load existing timetable data ---
    function loadTimetable() {
        $.get('<?= base_url("admin/academic/timetable/get-class-timetable") ?>', { class: '<?= $class_name ?>' }, function(data) {
            // Clear only non-break slots to preserve PHP-rendered Breaks and Master Slots
            $('.slot-cell:not([data-is-break="1"])')
                .removeClass('slot-filled')
                .removeAttr('data-id')
                .removeAttr('data-assign-id')
                .removeAttr('data-is-locked')
                .html('')
                .css({ 'border': '', 'padding': '' });
            
            const placedCount = {};
            
            // 🚀 Smart Block Detection for Visual Connection
            data.sort((a, b) => a.period - b.period); // Sort by period
            const assignGroups = {};
            data.forEach(item => {
                if(!assignGroups[item.assign_id]) assignGroups[item.assign_id] = {};
                if(!assignGroups[item.assign_id][item.day]) assignGroups[item.assign_id][item.day] = [];
                assignGroups[item.assign_id][item.day].push(item);
            });

            data.forEach(item => {
                const $slot = $(`.slot-cell[data-day="${item.day}"][data-period="${item.period}"]`);
                const isLocked = item.is_locked == 1;
                
                // Check if this is the start, middle, or end of a block
                const dayGroup = assignGroups[item.assign_id][item.day];
                const isStart = !dayGroup.find(g => parseInt(g.period) === parseInt(item.period) - 1);
                const isEnd = !dayGroup.find(g => parseInt(g.period) === parseInt(item.period) + 1);
                
                const subjectName = item.tsub_name || 'กิจกรรม';
                const teacherName = getTeacherName(item.teacher_id);
                const colorClass = `bg-label-${getAssignColor(item.assign_id)}`;
                const borderClass = `border-${getAssignColor(item.assign_id)}`;
                
                $slot.addClass('slot-filled').addClass(borderClass)
                     .attr('data-id', item.data_id)
                     .attr('data-assign-id', item.assign_id)
                     .attr('data-is-locked', item.is_locked)
                     .attr('draggable', item.is_locked == 1 ? 'false' : 'true')
                     .css({
                        'border-top': isStart ? '' : 'none',
                        'border-bottom': isEnd ? '' : 'none',
                        'padding-top': isStart ? '5px' : '0',
                        'padding-bottom': isEnd ? '5px' : '0',
                        'border-width': '2px',
                        'border-style': 'solid'
                     });

                if (isStart) {
                    $slot.html(`
                        <div class="h-100 position-relative p-1 ${isLocked ? 'border border-warning border-2 rounded-2' : colorClass + ' rounded-3'}" 
                             data-id="${item.data_id}"
                             style="font-size:0.75rem; min-height: 80px; border-bottom-left-radius: ${isEnd ? '8px' : '0'}; border-bottom-right-radius: ${isEnd ? '8px' : '0'};">
                            <div class="fw-bold text-dark text-truncate">${item.tsub_code || 'ACT'}</div>
                            <div class="text-truncate" title="${subjectName}" style="font-size: 0.7rem;">${subjectName}</div>
                            <div class="text-muted small mt-1" style="font-size: 0.6rem;">${teacherName}</div>
                            <div class="position-absolute bottom-0 end-0 p-1">
                                <i class="bx ${isLocked ? 'bx-lock-alt text-warning' : 'bx-lock-open-alt text-muted opacity-25'} btn-toggle-lock" 
                                   data-id="${item.data_id}" data-locked="${item.is_locked}" style="cursor:pointer; font-size: 0.9rem;"></i>
                            </div>
                        </div>
                    `);
                } else {
                    // Subsequent cells in block: also show info but maybe slightly faded or just repeat
                    $slot.html(`
                        <div class="h-100 position-relative p-1 ${isLocked ? 'border-start border-end border-warning border-2' : colorClass} opacity-75" 
                             data-id="${item.data_id}"
                             style="font-size:0.75rem; min-height: 80px; border-bottom-left-radius: ${isEnd ? '8px' : '0'}; border-bottom-right-radius: ${isEnd ? '8px' : '0'};">
                             <div class="text-muted opacity-50 text-truncate" style="font-size: 0.65rem;">${item.tsub_code || 'ACT'} (ต่อ)</div>
                             <div class="d-flex align-items-center justify-content-center mt-1">
                                <i class="bx bx-chevrons-down opacity-25"></i>
                             </div>
                        </div>
                    `);
                }
                
                placedCount[item.assign_id] = (placedCount[item.assign_id] || 0) + 1;
            });
            
            // Update remaining counts on sidebar
            $('.assignment-card').each(function() {
                const aid = $(this).data('assignId');
                const total = parseInt($(this).data('hours'));
                const placed = placedCount[aid] || 0;
                const remain = total - placed;
                $(this).find('.remain-count').text(remain);
                
                if (remain <= 0) {
                    $(this).find('.remain-badge').removeClass('bg-success').addClass('bg-secondary');
                    $(this).addClass('opacity-50');
                } else {
                    $(this).find('.remain-badge').removeClass('bg-secondary').addClass('bg-success');
                    $(this).removeClass('opacity-50');
                }
            });
        });
    }
    loadTimetable();

    function highlightTeacherConstraints(teacherIds) {
        $('.slot-cell').removeClass('constraint-locked');
        if(!teacherIds) return;
        
        const tIdArr = teacherIds.toString().split(',');
        tIdArr.forEach(tid => {
            const constraints = teacherConstraints.filter(c => c.teacher_id == tid);
            constraints.forEach(c => {
                $(`.slot-cell[data-day="${c.day}"][data-period="${c.period}"]`).addClass('constraint-locked');
            });
        });
    }

    // Handle Selection of Assignment from Sidebar
    $('.assignment-card').on('click', function() {
        $('.assignment-card').removeClass('border-primary shadow-lg').css('transform', 'scale(1)');
        $(this).addClass('border-primary shadow-lg').css('transform', 'scale(1.02)');
        selectedAssignId = $(this).data('assign-id');
        
        // 🚀 Highlight Teacher Constraints
        highlightTeacherConstraints($(this).data('teachers'));
    });
 // --- Hover effect for blocks ---
    $(document).on('mouseenter', '.slot-cell:not(.slot-filled)', function() {
        if (!selectedAssignId) return;
        const $activeCard = $(`.assignment-card[data-assign-id="${selectedAssignId}"]`);
        const split = $activeCard.data('split').toString().split(',');
        const totalHours = parseInt($activeCard.data('hours'));
        const remain = parseInt($activeCard.find('.remain-count').text());
        const placed = totalHours - remain;

        // Determine block size for the next placement
        let currentTotal = 0;
        let blockSize = 1;
        for (let s of split) {
            let sInt = parseInt(s);
            if (placed >= currentTotal && placed < (currentTotal + sInt)) {
                blockSize = sInt;
                break;
            }
            currentTotal += sInt;
        }

        const day = $(this).data('day');
        const startPeriod = parseInt($(this).data('period'));
        
        // Highlight consecutive slots
        for (let i = 0; i < blockSize; i++) {
            const $target = $(`.slot-cell[data-day="${day}"][data-period="${startPeriod + i}"]`);
            if ($target.length && !$target.hasClass('slot-filled') && !$target.data('isBreak')) {
                $target.css('background-color', 'rgba(21, 163, 98, 0.2)');
            } else if (i > 0) {
                $(this).css('background-color', 'rgba(255, 0, 0, 0.1)');
            }
        }
    }).on('mouseleave', '.slot-cell', function() {
        $('.slot-cell:not(.slot-filled)').css('background-color', '');
    });

    $(document).on('dragstart', '.assignment-card', function(e) {
        const assignId = $(this).data('assignId');
        currentDragBlockSize = getNextBlockSize(assignId);
        const data = { type: 'new', assignId: assignId };
        e.originalEvent.dataTransfer.setData('text/plain', JSON.stringify(data));
        $(this).addClass('opacity-50');
    });

    $(document).on('dragstart', '.slot-cell.slot-filled', function(e) {
        if ($(this).attr('data-is-locked') == '1') {
            e.preventDefault();
            return;
        }
        const dataId = $(this).attr('data-id') || $(this).find('[data-id]').attr('data-id');
        if (!dataId) {
            e.preventDefault();
            return;
        }

        // Count consecutive slots in this block to get current drag block size
        const day = $(this).data('day');
        const period = parseInt($(this).data('period'));
        const assignId = $(this).attr('data-assign-id');
        let size = 1;
        // Check forward
        for(let i=1; i<5; i++) {
            if($(`.slot-cell[data-day="${day}"][data-period="${period+i}"][data-assign-id="${assignId}"]`).length) size++;
            else break;
        }
        // Check backward
        for(let i=1; i<5; i++) {
            if($(`.slot-cell[data-day="${day}"][data-period="${period-i}"][data-assign-id="${assignId}"]`).length) size++;
            else break;
        }
        currentDragBlockSize = size;

        const data = { type: 'move', dataId: dataId };
        e.originalEvent.dataTransfer.setData('text/plain', JSON.stringify(data));
    });

    $(document).on('dragend', '.assignment-card, .slot-cell', function() {
        $(this).removeClass('opacity-50');
        $('.slot-cell').removeClass('drag-highlight');
    });

    $(document).on('dragover', '.slot-cell', function(e) {
        e.preventDefault();
        $('.slot-cell').removeClass('drag-highlight');
        
        if ($(this).data('is-locked') != 1) {
            const day = $(this).data('day');
            const period = parseInt($(this).data('period'));
            for (let i = 0; i < currentDragBlockSize; i++) {
                $(`.slot-cell[data-day="${day}"][data-period="${period + i}"]`).addClass('drag-highlight');
            }
        }
    });

    $(document).on('dragleave', '.slot-cell', function() {
        // Handled by dragover on next element or dragend
    });

    $(document).on('drop', '.slot-cell', function(e) {
        e.preventDefault();
        $(this).removeClass('bg-label-primary opacity-50');
        
        if ($(this).data('is-locked') == 1) {
            Swal.fire({ icon: 'warning', title: 'พื้นที่ควบคุม', text: 'ไม่สามารถวางวิชาในคาบพักหรือกิจกรรมส่วนกลางได้', timer: 1500, showConfirmButton: false });
            return;
        }

        const day = $(this).data('day');
        const period = $(this).data('period');
        let data;
        try {
            data = JSON.parse(e.originalEvent.dataTransfer.getData('text/plain'));
        } catch(err) { return; }

        if (data.type === 'new') {
            saveSlot(data.assignId, day, period);
        } else if (data.type === 'move') {
            moveSlot(data.dataId, day, period);
        }
    });

    function moveSlot(dataId, day, period) {
        $.post('<?= base_url("admin/academic/timetable/move-slot") ?>', {
            data_id: dataId,
            day: day,
            period: period,
            '<?= csrf_token() ?>': csrfHeader
        }, function(res) {
            updateCSRF(res);
            if (res.status === 'success') {
                Swal.fire({ icon: 'success', title: 'ย้ายสำเร็จ', text: res.message, timer: 1000, showConfirmButton: false });
                loadTimetable();
            } else {
                Swal.fire('ไม่สามารถย้ายได้', res.message, 'error');
            }
        });
    }

    // --- Select assignment from sidebar ---
    $(document).on('click', '.assignment-card', function() {
        const remain = parseInt($(this).find('.remain-count').text());
        if (remain <= 0) {
            Swal.fire({ icon: 'info', title: 'จัดครบแล้ว', text: 'วิชานี้ถูกจัดลงตารางครบทุกคาบแล้ว', timer: 1500, showConfirmButton: false });
            return;
        }
        
        $('.assignment-card').removeClass('active-assign');
        $(this).addClass('active-assign');
        selectedAssignId = $(this).data('assignId');
    });

    // --- Toggle Lock ---
    $(document).on('click', '.btn-toggle-lock', function(e) {
        e.stopPropagation(); // Prevent triggering slot-cell click
        const id = $(this).data('id');
        const currentLocked = $(this).data('locked');
        const newLocked = currentLocked == 1 ? 0 : 1;

        $.post('<?= base_url("admin/academic/timetable/toggle-lock") ?>', {
            data_id: id,
            is_locked: newLocked,
            '<?= csrf_token() ?>': csrfHeader
        }, function(res) {
            updateCSRF(res);
            if (res.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ',
                    text: res.message,
                    timer: 1000,
                    showConfirmButton: false
                });
                loadTimetable();
            } else {
                Swal.fire('ผิดพลาด', res.message, 'error');
            }
        });
    });

    // --- Click on slot ---
    $(document).on('click', '.slot-cell', function() {
        const $slot = $(this);
        if ($slot.data('is-locked') == 1) {
            Swal.fire({
                icon: 'warning',
                title: 'ไม่สามารถวางได้',
                text: 'ช่องนี้เป็นคาบพักหรือกิจกรรมส่วนกลาง ไม่สามารถวางวิชาได้',
                timer: 1500,
                showConfirmButton: false
            });
            return;
        }
        const day = $slot.data('day');
        const period = $slot.data('period');

        if ($slot.hasClass('slot-filled')) {
            if ($slot.attr('data-is-locked') == '1') {
                Swal.fire({ icon: 'warning', title: 'คาบเรียนนี้ถูกล็อคอยู่', text: 'กรุณาคลิกที่ไอคอนกุญแจเพื่อปลดล็อคก่อนลบครับ' });
                return;
            }
            // Remove this slot
            const dataId = $slot.attr('data-id');
            Swal.fire({
                title: 'ลบวิชานี้ออก?',
                text: 'วิชานี้เป็นคาบที่จัดต่อเนื่องกัน ระบบจะลบออกทั้งบล็อกเพื่อให้สอดคล้องกับรูปแบบการหั่นคาบครับ',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ลบออก',
                cancelButtonText: 'ยกเลิก',
                customClass: { confirmButton: 'btn btn-danger rounded-pill me-2 px-4', cancelButton: 'btn btn-label-secondary rounded-pill px-4' },
                buttonsStyling: false
            }).then(result => {
                if (result.isConfirmed) {
                    $.post('<?= base_url("admin/academic/timetable/delete-slot") ?>', { data_id: dataId, '<?= csrf_token() ?>': csrfHeader }, function(res) {
                        updateCSRF(res);
                        if (res.status === 'success') {
                            loadTimetable();
                        } else {
                            Swal.fire('ผิดพลาด', res.message, 'error');
                        }
                    });
                }
            });
        } else {
            // Place selected assignment
            if (!selectedAssignId) {
                Swal.fire({ icon: 'warning', title: 'กรุณาเลือกวิชา', text: 'คลิกเลือกวิชาจากแถบด้านซ้ายก่อนครับ', timer: 2000, showConfirmButton: false });
                return;
            }
            saveSlot(selectedAssignId, day, period);
        }
    });

    function saveSlot(assignId, day, period) {
        $.post('<?= base_url("admin/academic/timetable/save-slot") ?>', {
            assign_id: assignId,
            day: day,
            period: period,
            '<?= csrf_token() ?>': csrfHeader
        }, function(res) {
            updateCSRF(res);
            if (res.status === 'success') {
                loadTimetable();
            } else {
                Swal.fire({ icon: 'error', title: 'ไม่สามารถวางได้', text: res.message });
            }
        });
    }

    // --- Clear all ---
    $('#btnClearAll').on('click', function() {
        Swal.fire({
            title: 'ล้างตารางห้อง <?= $class_name ?> ทั้งหมด?',
            text: 'วิชาทั้งหมดที่จัดไว้จะถูกลบออก ต้องจัดใหม่ทั้งหมด',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ล้างทั้งหมด',
            cancelButtonText: 'ยกเลิก',
            customClass: { confirmButton: 'btn btn-danger rounded-pill me-2 px-4', cancelButton: 'btn btn-label-secondary rounded-pill px-4' },
            buttonsStyling: false
        }).then(result => {
            if (result.isConfirmed) {
                $.post('<?= base_url("admin/academic/timetable/clear-class-timetable") ?>', {
                    class_name: '<?= $class_name ?>',
                    '<?= csrf_token() ?>': csrfHeader
                }, function(res) {
                    updateCSRF(res);
                    if (res.status === 'success') {
                        Swal.fire({ icon: 'success', title: 'ล้างสำเร็จ', timer: 1000, showConfirmButton: false });
                        loadTimetable();
                    }
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
