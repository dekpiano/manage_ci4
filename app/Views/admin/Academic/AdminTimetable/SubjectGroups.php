<?= $this->extend('admin/layout/main') ?>

<?= $this->section('extra_css') ?>
<style>
    .kanban-board-container {
        display: flex;
        gap: 1.25rem;
        overflow-x: auto;
        padding-bottom: 1.5rem;
        min-height: calc(100vh - 280px);
    }
    .kanban-pool-column {
        width: 360px;
        min-width: 340px;
        flex-shrink: 0;
    }
    .kanban-group-column {
        width: 340px;
        min-width: 320px;
        flex-shrink: 0;
    }
    .kanban-card-list {
        min-height: 400px;
        max-height: calc(100vh - 350px);
        overflow-y: auto;
        padding: 0.5rem;
        border-radius: 0.5rem;
        transition: background-color 0.2s ease, border-color 0.2s ease;
    }
    .kanban-card-list.drag-hover {
        background-color: #e8fadf !important;
        border: 2px dashed #15a362 !important;
    }
    .subject-drag-card {
        cursor: grab;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
        border-left: 4px solid #15a362;
        user-select: none;
    }
    .subject-drag-card:active {
        cursor: grabbing;
        transform: scale(0.98);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15) !important;
    }
    .subject-drag-card.dragging {
        opacity: 0.4;
    }
    .swal2-container {
        z-index: 9999 !important;
    }
    .badge-hours {
        background-color: #e8fadf;
        color: #15a362;
        font-weight: 600;
    }
    body:not(.modal-open) .modal-backdrop { 
        display: none !important; 
        pointer-events: none !important; 
    }
</style>
<?= $this->endSection() ?>

<?php
/**
 * Helper to determine theme color for subject codes
 */
$getSubjectColor = function($code) {
    $first = mb_substr(trim((string)$code), 0, 1, 'UTF-8');
    $colors = [
        'ท' => ['bg' => '#FFF3E0', 'text' => '#BF360C', 'border' => '#FFB74D'],
        'ค' => ['bg' => '#E0F7FA', 'text' => '#006064', 'border' => '#4DD0E1'],
        'ว' => ['bg' => '#E8F5E9', 'text' => '#1B5E20', 'border' => '#81C784'],
        'ส' => ['bg' => '#F3E5F5', 'text' => '#4A148C', 'border' => '#BA68C8'],
        'พ' => ['bg' => '#FCE4EC', 'text' => '#880E4F', 'border' => '#F06292'],
        'ศ' => ['bg' => '#FFF9C4', 'text' => '#E65100', 'border' => '#FFD54F'],
        'ง' => ['bg' => '#E0F2F1', 'text' => '#004D40', 'border' => '#4DB6AC'],
        'อ' => ['bg' => '#EDE7F6', 'text' => '#311B92', 'border' => '#9575CD'],
        'จ' => ['bg' => '#FBE9E7', 'text' => '#BF360C', 'border' => '#FF8A65'],
        'ญ' => ['bg' => '#FCE4EC', 'text' => '#880E4F', 'border' => '#F48FB1'],
        'ก' => ['bg' => '#F1F8E9', 'text' => '#33691E', 'border' => '#AED581'],
    ];
    return $colors[$first] ?? ['bg' => '#F8F9FA', 'text' => '#212529', 'border' => '#DEE2E6'];
};

/**
 * Robust helper to parse grade number, grade label (ม.X), and tier (JUNIOR / SENIOR)
 */
$parseGrade = function($className) {
    $raw = trim((string)$className);
    if (preg_match('/(\d+)/', $raw, $matches)) {
        $num = (int)$matches[1];
        if ($num >= 1 && $num <= 6) {
            return [
                'num' => (string)$num,
                'label' => 'ม.' . $num,
                'tier' => ($num <= 3) ? 'JUNIOR' : 'SENIOR',
                'display_class' => (mb_strpos($raw, 'ม.') === 0) ? $raw : 'ม.' . $raw
            ];
        }
    }
    return [
        'num' => '',
        'label' => $raw,
        'tier' => 'ALL',
        'display_class' => $raw
    ];
};

// Partition assignments: unassigned pool vs grouped
$poolAssignments = [];
$groupedAssignments = [];
foreach ($assignments as $a) {
    if (!empty($a->group_id)) {
        $groupedAssignments[$a->group_id][] = $a;
    } else {
        $poolAssignments[] = $a;
    }
}
?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold py-2 mb-1">
                <span class="text-muted fw-light">วิชาการ / ตารางสอน /</span> กระดานจัดกลุ่มวิชาเรียนพร้อมกัน (Simultaneous Grouping Board)
            </h4>
            <div class="text-muted small">
                จับลาก-วาง (Drag & Drop) เพื่อจัดกลุ่มวิชาที่ต้องเรียนในคาบเดียวกัน เช่น วิชาเลือกเสรี, คาบคู่ขนาน, วิชาแยกสายในห้องเดียวกัน
            </div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-danger rounded-pill" onclick="clearAllGroups()">
                <i class="bx bx-trash me-1"></i> ล้างกลุ่มทั้งหมด
            </button>
            <a href="<?= base_url('admin/academic/timetable/process') ?>" class="btn btn-outline-secondary rounded-pill">
                <i class="bx bx-arrow-back me-1"></i> ไปหน้าจัดตารางสอน
            </a>
            <button class="btn btn-primary rounded-pill" onclick="openNewGroupModal()" style="background-color: #15a362; border-color: #15a362;">
                <i class="bx bx-plus me-1"></i> สร้างกลุ่มใหม่
            </button>
        </div>
    </div>

    <!-- Filter & Control Bar -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <div class="row g-2 align-items-center">
                <!-- Grade Filter -->
                <div class="col-xl-4 col-lg-5 col-md-12">
                    <div class="d-flex align-items-center gap-1 flex-wrap">
                        <span class="small fw-bold text-muted me-1"><i class="bx bx-filter-alt"></i> ชั้น:</span>
                        <button type="button" class="btn btn-xs btn-primary rounded-pill filter-grade-btn active" data-grade="ALL">ทั้งหมด</button>
                        <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill filter-grade-btn" data-grade="JUNIOR">ม.ต้น</button>
                        <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill filter-grade-btn" data-grade="SENIOR">ม.ปลาย</button>
                        <?php foreach(['1' => 'ม.1', '2' => 'ม.2', '3' => 'ม.3', '4' => 'ม.4', '5' => 'ม.5', '6' => 'ม.6'] as $num => $lbl): ?>
                            <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill filter-grade-btn" data-grade="<?= $lbl ?>" data-grade-num="<?= $num ?>"><?= $lbl ?></button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Subject Type Filter (พื้นฐาน / เพิ่มเติม) -->
                <div class="col-xl-3 col-lg-3 col-md-4">
                    <div class="d-flex align-items-center gap-1 flex-wrap">
                        <span class="small fw-bold text-muted me-1"><i class="bx bx-category"></i> ประเภท:</span>
                        <button type="button" class="btn btn-xs btn-primary rounded-pill filter-type-btn active" data-type="ALL">ทั้งหมด</button>
                        <button type="button" class="btn btn-xs btn-outline-primary rounded-pill filter-type-btn" data-type="พื้นฐาน">พื้นฐาน</button>
                        <button type="button" class="btn btn-xs btn-outline-warning rounded-pill filter-type-btn" data-type="เพิ่มเติม">เพิ่มเติม</button>
                    </div>
                </div>

                <!-- Hours Filter -->
                <div class="col-xl-3 col-lg-2 col-md-4">
                    <div class="d-flex align-items-center gap-1 flex-wrap">
                        <span class="small fw-bold text-muted me-1"><i class="bx bx-time"></i> คาบ:</span>
                        <button type="button" class="btn btn-xs btn-primary rounded-pill filter-hours-btn active" data-hours="ALL">ทั้งหมด</button>
                        <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill filter-hours-btn" data-hours="1">1</button>
                        <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill filter-hours-btn" data-hours="2">2</button>
                        <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill filter-hours-btn" data-hours="3">3</button>
                        <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill filter-hours-btn" data-hours="4">4+</button>
                    </div>
                </div>

                <!-- Search Input -->
                <div class="col-xl-2 col-lg-2 col-md-4">
                    <div class="input-group input-group-merge input-group-sm">
                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                        <input type="text" class="form-control" id="searchSubjectInput" placeholder="ค้นหา...">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kanban Board Container -->
    <div class="kanban-board-container">
        <!-- 📦 Left Column: Unassigned Subjects Pool -->
        <div class="kanban-pool-column">
            <div class="card border-0 shadow-sm h-100 bg-light">
                <div class="card-header bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">
                            <i class="bx bx-box me-1 text-primary"></i> สระวิชาที่ยังไม่เข้ากลุ่ม
                        </h6>
                        <small class="text-muted">ลากวิชาจากที่นี่ไปหยอดลงในกลุ่ม</small>
                    </div>
                    <span class="badge bg-label-primary rounded-pill fs-tiny" id="poolCountBadge">
                        <?= count($poolAssignments) ?> วิชา
                    </span>
                </div>
                <div class="card-body p-2">
                    <div class="kanban-card-list bg-transparent" id="poolCardList" 
                         ondragover="allowDrop(event)" ondragleave="dragLeave(event)" ondrop="dropToPool(event)">
                        <?php foreach($poolAssignments as $a): 
                            $cTheme = $getSubjectColor($a->tsub_code);
                            $gInfo = $parseGrade($a->class_name);
                            $subType = $a->subject_type ?? 'เพิ่มเติม';
                        ?>
                        <div class="card subject-drag-card border-0 shadow-xs mb-2 p-2 bg-white" 
                             draggable="true" 
                             ondragstart="dragStart(event)" 
                             ondragend="dragEnd(event)"
                             id="card_assign_<?= $a->assign_id ?>"
                             data-assign-id="<?= $a->assign_id ?>"
                             data-class="<?= esc($a->class_name) ?>"
                             data-grade="<?= esc($gInfo['label']) ?>"
                             data-grade-num="<?= esc($gInfo['num']) ?>"
                             data-grade-tier="<?= esc($gInfo['tier']) ?>"
                             data-type="<?= esc($subType) ?>"
                             data-hours="<?= (int)$a->hours_per_week ?>"
                             data-code="<?= esc($a->tsub_code) ?>"
                             data-name="<?= esc($a->tsub_name) ?>"
                             data-teacher="<?= esc($a->teacher_names) ?>"
                             data-teacher-ids="<?= esc($a->teacher_id ?? '') ?>"
                             style="border-left-color: <?= $cTheme['border'] ?> !important;">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <div class="d-flex align-items-center gap-1 flex-wrap">
                                    <span class="badge px-2 py-0.5 rounded fw-bold" style="background-color: <?= $cTheme['bg'] ?>; color: <?= $cTheme['text'] ?>; font-size: 0.68rem;">
                                        <?= esc($a->tsub_code ?: 'กิจกรรม') ?>
                                    </span>
                                    <!-- Badge ประเภทวิชา (พื้นฐาน / เพิ่มเติม) -->
                                    <?php if ($subType === 'พื้นฐาน'): ?>
                                        <span class="badge bg-label-primary rounded px-1.5 py-0.5 fw-semibold" style="font-size: 0.63rem;">
                                            พื้นฐาน
                                        </span>
                                    <?php elseif ($subType === 'เพิ่มเติม'): ?>
                                        <span class="badge bg-label-warning rounded px-1.5 py-0.5 fw-semibold" style="font-size: 0.63rem;">
                                            เพิ่มเติม
                                        </span>
                                    <?php elseif (!empty($subType)): ?>
                                        <span class="badge bg-label-secondary rounded px-1.5 py-0.5 fw-semibold" style="font-size: 0.63rem;">
                                            <?= esc($subType) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="d-flex gap-1 align-items-center">
                                    <span class="badge bg-label-info rounded px-1.5 py-0.5" style="font-size: 0.65rem;">
                                        [<?= esc($gInfo['display_class']) ?>]
                                    </span>
                                    <span class="badge badge-hours rounded px-1.5 py-0.5" style="font-size: 0.65rem;">
                                        <?= (int)$a->hours_per_week ?> คาบ
                                    </span>
                                </div>
                            </div>
                            <div class="fw-bold text-dark small text-truncate" title="<?= esc($a->tsub_name) ?>">
                                <?= esc($a->tsub_name) ?>
                            </div>
                            <div class="text-muted d-flex align-items-center justify-content-between mt-1" style="font-size: 0.68rem;">
                                <span class="text-truncate" style="max-width: 85%;">
                                    <i class="bx bx-user me-0.5"></i><?= esc($a->teacher_names) ?>
                                </span>
                                <i class="bx bx-move text-muted"></i>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        
                        <div class="text-center text-muted py-5 <?= !empty($poolAssignments) ? 'd-none' : '' ?>" id="poolEmptyNotice">
                            <i class="bx bx-check-circle fs-2 text-success"></i>
                            <div class="small mt-1">วิชาทั้งหมดถูกจัดเข้ากลุ่มแล้ว</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🚀 Right Columns: Group Columns -->
        <div class="d-flex gap-3 align-items-start flex-nowrap" id="groupColumnsContainer">
            <?php foreach($groups as $grp): 
                $items = $groupedAssignments[$grp->group_id] ?? [];
                $maxH = !empty($items) ? max(array_column($items, 'hours_per_week')) : 0;
                $targetGrade = $grp->target_grade ?? 'ALL';
                $gradeBadgeClass = 'bg-label-secondary';
                $gradeBadgeText = 'ทุกระดับชั้น';
                if ($targetGrade === 'ม.ต้น' || $targetGrade === 'JUNIOR') {
                    $gradeBadgeClass = 'bg-label-info';
                    $gradeBadgeText = 'ม.ต้น';
                } elseif ($targetGrade === 'ม.ปลาย' || $targetGrade === 'SENIOR') {
                    $gradeBadgeClass = 'bg-label-warning';
                    $gradeBadgeText = 'ม.ปลาย';
                } elseif (!empty($targetGrade) && $targetGrade !== 'ALL') {
                    $gradeBadgeClass = 'bg-label-primary';
                    $gradeBadgeText = (mb_strpos($targetGrade, 'ม.') === 0 ? '' : 'ม.') . $targetGrade;
                }
            ?>
            <div class="kanban-group-column" id="group_col_<?= $grp->group_id ?>" data-group-id="<?= $grp->group_id ?>" data-target-grade="<?= esc($targetGrade) ?>">
                <div class="card border-0 shadow-sm h-100" style="border-top: 4px solid #15a362 !important;">
                    <!-- Group Header -->
                    <div class="card-header bg-white border-bottom p-3">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <div class="text-truncate" style="max-width: 200px;">
                                <h6 class="mb-1 fw-bold text-dark text-truncate group-title-text" title="<?= esc($grp->group_name) ?>">
                                    <?= esc($grp->group_name) ?>
                                </h6>
                                <span class="badge <?= $gradeBadgeClass ?> rounded-pill" style="font-size: 0.65rem;">
                                    <i class="bx bx-bookmark me-0.5"></i><?= esc($gradeBadgeText) ?>
                                </span>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="editGroupName(<?= $grp->group_id ?>, '<?= esc($grp->group_name) ?>', '<?= esc($targetGrade) ?>')">
                                        <i class="bx bx-edit me-1 text-warning"></i> แก้ไขข้อมูลกลุ่ม
                                    </a>
                                    <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="deleteGroup(<?= $grp->group_id ?>)">
                                        <i class="bx bx-trash me-1"></i> ลบกลุ่มนี้
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="badge bg-label-success rounded-pill group-items-count" style="font-size: 0.68rem;">
                                <?= count($items) ?> วิชา
                            </span>
                            <span class="badge bg-label-dark rounded-pill" style="font-size: 0.68rem;">
                                เรียนพร้อมกัน: <strong class="group-max-hours"><?= $maxH ?></strong> คาบ
                            </span>
                        </div>
                    </div>

                    <!-- Group Drop Zone -->
                    <div class="card-body p-2 bg-light bg-opacity-50">
                        <div class="kanban-card-list group-card-list" 
                             data-group-id="<?= $grp->group_id ?>"
                             ondragover="allowDrop(event)" 
                             ondragleave="dragLeave(event)" 
                             ondrop="dropToGroup(event, '<?= $grp->group_id ?>')">
                            
                            <?php foreach($items as $a): 
                                $cTheme = $getSubjectColor($a->tsub_code);
                                $gInfo = $parseGrade($a->class_name);
                                $subType = $a->subject_type ?? 'เพิ่มเติม';
                            ?>
                            <div class="card subject-drag-card border-0 shadow-xs mb-2 p-2 bg-white" 
                                 draggable="true" 
                                 ondragstart="dragStart(event)" 
                                 ondragend="dragEnd(event)"
                                 id="card_assign_<?= $a->assign_id ?>"
                                 data-assign-id="<?= $a->assign_id ?>"
                                 data-class="<?= esc($a->class_name) ?>"
                                 data-grade="<?= esc($gInfo['label']) ?>"
                                 data-grade-num="<?= esc($gInfo['num']) ?>"
                                 data-grade-tier="<?= esc($gInfo['tier']) ?>"
                                 data-type="<?= esc($subType) ?>"
                                 data-hours="<?= (int)$a->hours_per_week ?>"
                                 data-code="<?= esc($a->tsub_code) ?>"
                                 data-name="<?= esc($a->tsub_name) ?>"
                                 data-teacher="<?= esc($a->teacher_names) ?>"
                                 data-teacher-ids="<?= esc($a->teacher_id ?? '') ?>"
                                 style="border-left-color: <?= $cTheme['border'] ?> !important;">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <div class="d-flex align-items-center gap-1 flex-wrap">
                                        <span class="badge px-2 py-0.5 rounded fw-bold" style="background-color: <?= $cTheme['bg'] ?>; color: <?= $cTheme['text'] ?>; font-size: 0.68rem;">
                                            <?= esc($a->tsub_code ?: 'กิจกรรม') ?>
                                        </span>
                                        <!-- Badge ประเภทวิชา (พื้นฐาน / เพิ่มเติม) -->
                                        <?php if ($subType === 'พื้นฐาน'): ?>
                                            <span class="badge bg-label-primary rounded px-1.5 py-0.5 fw-semibold" style="font-size: 0.63rem;">
                                                พื้นฐาน
                                            </span>
                                        <?php elseif ($subType === 'เพิ่มเติม'): ?>
                                            <span class="badge bg-label-warning rounded px-1.5 py-0.5 fw-semibold" style="font-size: 0.63rem;">
                                                เพิ่มเติม
                                            </span>
                                        <?php elseif (!empty($subType)): ?>
                                            <span class="badge bg-label-secondary rounded px-1.5 py-0.5 fw-semibold" style="font-size: 0.63rem;">
                                                <?= esc($subType) ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="d-flex gap-1 align-items-center">
                                        <span class="badge bg-label-info rounded px-1.5 py-0.5" style="font-size: 0.65rem;">
                                            [<?= esc($gInfo['display_class']) ?>]
                                        </span>
                                        <span class="badge badge-hours rounded px-1.5 py-0.5" style="font-size: 0.65rem;">
                                            <?= (int)$a->hours_per_week ?> คาบ
                                        </span>
                                        <button type="button" class="btn btn-xs text-danger p-0 ms-1 btn-remove-assign" title="ปลดออกจากกลุ่ม" onclick="removeAssignFromGroup(<?= $a->assign_id ?>)">
                                            <i class="bx bx-x fs-6"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="fw-bold text-dark small text-truncate" title="<?= esc($a->tsub_name) ?>">
                                    <?= esc($a->tsub_name) ?>
                                </div>
                                <div class="text-muted d-flex align-items-center justify-content-between mt-1" style="font-size: 0.68rem;">
                                    <span class="text-truncate" style="max-width: 85%;">
                                        <i class="bx bx-user me-0.5"></i><?= esc($a->teacher_names) ?>
                                    </span>
                                    <i class="bx bx-move text-muted"></i>
                                </div>
                            </div>
                            <?php endforeach; ?>

                            <div class="text-center text-muted py-5 group-empty-notice <?= !empty($items) ? 'd-none' : '' ?>">
                                <i class="bx bx-down-arrow-circle fs-3 text-secondary"></i>
                                <div class="small mt-1">ลากวิชามาวางที่นี่</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

            <!-- Add Group Placeholder Card -->
            <div class="kanban-group-column" style="width: 200px; min-width: 200px;">
                <button type="button" class="btn btn-outline-success border-dashed w-100 h-100 py-5 rounded-4 d-flex flex-column align-items-center justify-content-center gap-2" 
                        onclick="openNewGroupModal()" style="border-width: 2px; min-height: 250px;">
                    <i class="bx bx-plus-circle fs-1" style="color: #15a362;"></i>
                    <span class="fw-bold text-success">+ สร้างกลุ่มใหม่</span>
                </button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<!-- Modal Create / Rename Group -->
<div class="modal fade" id="modalGroupManage" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header text-white" style="background-color: #15a362;">
                <h5 class="modal-title text-white fw-bold" id="modalGroupTitle">
                    <i class="bx bx-layer me-2"></i> สร้างกลุ่มวิชาเรียนพร้อมกัน
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formGroupManage">
                <?= csrf_field() ?>
                <input type="hidden" name="group_id" id="manage_group_id">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">
                            ชื่อกลุ่มวิชาเรียนพร้อมกัน <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" name="group_name" id="manage_group_name" 
                               placeholder="เช่น กลุ่มวิชาเลือกเสรี ม.4 (2 คาบ), กลุ่มความเป็นเลิศ ม.ต้น" required>
                        <div class="form-text small text-muted">
                            วิชาทั้งหมดที่ถูกลากมาใส่ในกลุ่มนี้ จะถูกจัดตารางให้ลงในคาบเดียวกันเสมอ
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">
                            ระดับชั้นเป้าหมาย
                        </label>
                        <select class="form-select" name="target_grade" id="manage_target_grade">
                            <option value="ALL">ทุกระดับชั้น (ไม่จำกัด)</option>
                            <option value="ม.ต้น">ระดับชั้น ม.ต้น (ม.1 - ม.3)</option>
                            <option value="ม.ปลาย">ระดับชั้น ม.ปลาย (ม.4 - ม.6)</option>
                            <option value="ม.1">เฉพาะ ม.1</option>
                            <option value="ม.2">เฉพาะ ม.2</option>
                            <option value="ม.3">เฉพาะ ม.3</option>
                            <option value="ม.4">เฉพาะ ม.4</option>
                            <option value="ม.5">เฉพาะ ม.5</option>
                            <option value="ม.6">เฉพาะ ม.6</option>
                        </select>
                        <div class="form-text small text-muted">
                            ใช้เพื่อช่วยคัดกรองการแสดงผล และจัดกลุ่มตามระดับชั้น
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4" id="btnSaveGroupModal" style="background-color: #15a362; border-color: #15a362;">
                        <i class="bx bx-save me-1"></i> บันทึกข้อมูล
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
let currentDraggedAssignId = null;

// Drag & Drop Handlers
function dragStart(e) {
    currentDraggedAssignId = $(e.target).closest('.subject-drag-card').data('assign-id');
    e.dataTransfer.setData('text/plain', currentDraggedAssignId);
    $(e.target).closest('.subject-drag-card').addClass('dragging');
}

function dragEnd(e) {
    $('.subject-drag-card').removeClass('dragging');
    $('.kanban-card-list').removeClass('drag-hover');
}

function allowDrop(e) {
    e.preventDefault();
    $(e.target).closest('.kanban-card-list').addClass('drag-hover');
}

function dragLeave(e) {
    $(e.target).closest('.kanban-card-list').removeClass('drag-hover');
}

// Drop to Group Column with Smart Validation
function dropToGroup(e, groupId) {
    e.preventDefault();
    $('.kanban-card-list').removeClass('drag-hover');

    const assignId = e.dataTransfer.getData('text/plain') || currentDraggedAssignId;
    if (!assignId) return;

    const $card = $('#card_assign_' + assignId);
    if ($card.length === 0) return;

    const $targetList = $('#group_col_' + groupId).find('.group-card-list');

    // Extract attributes of dragged card
    const currentTeacherIds = String($card.data('teacher-ids') || '').split(',').map(s => s.trim()).filter(Boolean);
    const currentClass = String($card.data('class') || '').trim();
    const currentType = String($card.data('type') || '').trim();
    const currentName = String($card.data('name') || '').trim();
    const currentTeacherName = String($card.data('teacher') || '').trim();

    let teacherClash = null;
    let basicClash = null;
    let isSplitSubgroup = false;

    // Check against all existing cards in target group
    $targetList.find('.subject-drag-card').each(function() {
        const $existingCard = $(this);
        if ($existingCard.data('assign-id') == assignId) return;

        const existingTeacherIds = String($existingCard.data('teacher-ids') || '').split(',').map(s => s.trim()).filter(Boolean);
        const existingClass = String($existingCard.data('class') || '').trim();
        const existingType = String($existingCard.data('type') || '').trim();
        const existingName = String($existingCard.data('name') || '').trim();
        const existingTeacherNames = String($existingCard.data('teacher') || '').trim();

        // 1. Teacher clash check (ครูคนเดียวกันห้ามสอน 2 วิชาพร้อมกัน)
        for (const tId of currentTeacherIds) {
            if (existingTeacherIds.includes(tId)) {
                teacherClash = {
                    teacher: existingTeacherNames || currentTeacherName,
                    subject: existingName
                };
                break;
            }
        }

        // 2. Class clash check (วิชาพื้นฐานห้องเดียวกันห้ามลงกลุ่มเดียวกัน)
        if (existingClass === currentClass) {
            if (currentType === 'พื้นฐาน' || existingType === 'พื้นฐาน') {
                basicClash = {
                    className: currentClass,
                    existingSubject: existingName,
                    currentSubject: currentName
                };
            } else {
                isSplitSubgroup = true;
            }
        }
    });

    if (teacherClash) {
        Swal.fire({
            icon: 'error',
            title: 'ครูผู้สอนซ้ำซ้อนในกลุ่มเดียวกัน',
            html: `ไม่สามารถจัดเข้ากลุ่มนี้ได้ เนื่องจากคุณครู <strong>${teacherClash.teacher}</strong> มีสอนวิชา <strong>${teacherClash.subject}</strong> ในกลุ่มนี้อยู่แล้ว<br><small class="text-danger">ครูไม่สามารถสอน 2 วิชาพร้อมกันในคาบเดียวกันได้</small>`,
            confirmButtonColor: '#15a362'
        });
        return;
    }

    if (basicClash) {
        Swal.fire({
            icon: 'error',
            title: 'วิชาพื้นฐานห้องเดียวกันซ้ำซ้อน',
            html: `ห้อง <strong>${basicClash.className}</strong> มีวิชาพื้นฐาน (<strong>${basicClash.existingSubject}</strong>) อยู่ในกลุ่มนี้แล้ว<br><small class="text-danger">นักเรียนทั้งห้องต้องเรียนวิชาพื้นฐานพร้อมกัน ไม่สามารถแยกไปเรียนวิชาอื่นในคาบเดียวกันได้</small>`,
            confirmButtonColor: '#15a362'
        });
        return;
    }

    // Send AJAX to update group
    $.ajax({
        url: '<?= base_url("admin/academic/timetable/update-assignment-group") ?>',
        type: 'POST',
        data: {
            assign_id: assignId,
            group_id: groupId,
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
        },
        dataType: 'json',
        success: function(res) {
            if (res.status === 'success') {
                // Add remove button if not exists
                if ($card.find('.btn-remove-assign').length === 0) {
                    $card.find('.badge-hours').after(`
                        <button type="button" class="btn btn-xs text-danger p-0 ms-1 btn-remove-assign" title="ปลดออกจากกลุ่ม" onclick="removeAssignFromGroup(${assignId})">
                            <i class="bx bx-x fs-6"></i>
                        </button>
                    `);
                }
                
                $targetList.append($card);
                updateKanbanCounters();
                
                if (isSplitSubgroup) {
                    showToastNotification(`ย้ายเข้ากลุ่มแล้ว (กลุ่มย่อยห้อง ${currentClass})`);
                } else {
                    showToastNotification('ย้ายวิชาเข้ากลุ่มเรียบร้อยแล้ว');
                }
            } else {
                Swal.fire({ icon: 'error', title: 'ผิดพลาด', text: res.message, confirmButtonColor: '#15a362' });
            }
        },
        error: function() {
            Swal.fire({ icon: 'error', title: 'การเชื่อมต่อล้มเหลว', text: 'ไม่สามารถย้ายวิชาได้', confirmButtonColor: '#15a362' });
        }
    });
}

// Drop back to Pool
function dropToPool(e) {
    e.preventDefault();
    $('.kanban-card-list').removeClass('drag-hover');

    const assignId = e.dataTransfer.getData('text/plain') || currentDraggedAssignId;
    if (!assignId) return;

    removeAssignFromGroup(assignId);
}

// Remove Assignment from Group
function removeAssignFromGroup(assignId) {
    const $card = $('#card_assign_' + assignId);
    if ($card.length === 0) return;

    $.ajax({
        url: '<?= base_url("admin/academic/timetable/update-assignment-group") ?>',
        type: 'POST',
        data: {
            assign_id: assignId,
            group_id: '',
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
        },
        dataType: 'json',
        success: function(res) {
            if (res.status === 'success') {
                $card.find('.btn-remove-assign').remove();
                $card.find('.subgroup-badge').remove();
                $('#poolCardList').append($card);
                updateKanbanCounters();
                showToastNotification('ปลดวิชาออกจากกลุ่มเรียบร้อยแล้ว');
            } else {
                Swal.fire({ icon: 'error', title: 'ผิดพลาด', text: res.message, confirmButtonColor: '#15a362' });
            }
        }
    });
}

// Update counters, empty notices, and subgroup badges across the board
function updateKanbanCounters() {
    // 1. Pool count
    const poolCount = $('#poolCardList').find('.subject-drag-card').length;
    $('#poolCountBadge').text(poolCount + ' วิชา');
    if (poolCount === 0) {
        $('#poolEmptyNotice').removeClass('d-none');
    } else {
        $('#poolEmptyNotice').addClass('d-none');
    }

    // 2. Each group count and subgroup detection
    $('.kanban-group-column[data-group-id]').each(function() {
        const $col = $(this);
        const $cards = $col.find('.subject-drag-card');
        const count = $cards.length;
        
        $col.find('.group-items-count').text(count + ' วิชา');

        let maxH = 0;
        const classCounts = {};
        $cards.each(function() {
            const h = parseInt($(this).data('hours')) || 0;
            if (h > maxH) maxH = h;

            const c = String($(this).data('class') || '').trim();
            if (c) {
                classCounts[c] = (classCounts[c] || 0) + 1;
            }
        });
        $col.find('.group-max-hours').text(maxH);

        // Render / Remove subgroup badges
        $cards.each(function() {
            const $c = $(this);
            const c = String($c.data('class') || '').trim();
            if (classCounts[c] > 1) {
                if ($c.find('.subgroup-badge').length === 0) {
                    $c.find('.badge-hours').before(`
                        <span class="badge bg-label-warning rounded px-1.5 py-0.5 subgroup-badge me-0.5" style="font-size: 0.62rem;" title="วิชาแยกกลุ่มย่อยในห้องเดียวกัน">
                            <i class="bx bx-git-branch me-0.5"></i>กลุ่มย่อย
                        </span>
                    `);
                }
            } else {
                $c.find('.subgroup-badge').remove();
            }
        });

        if (count === 0) {
            $col.find('.group-empty-notice').removeClass('d-none');
        } else {
            $col.find('.group-empty-notice').addClass('d-none');
        }
    });
}

// Filter Logic: Filter Pool cards, Group cards, and Group columns accurately
function applyFilters() {
    const $activeGradeBtn = $('.filter-grade-btn.active');
    const selectedGrade = String($activeGradeBtn.data('grade') || 'ALL');
    const selectedGradeNum = String($activeGradeBtn.data('grade-num') || '');
    const selectedType = String($('.filter-type-btn.active').data('type') || 'ALL');
    const selectedHours = String($('.filter-hours-btn.active').data('hours') || 'ALL');
    const searchVal = $('#searchSubjectInput').val().toLowerCase().trim();

    // 1. Filter all subject cards
    $('.subject-drag-card').each(function() {
        const $card = $(this);
        const cardGrade = String($card.data('grade') || '');         // e.g. "ม.1", "ม.4"
        const cardGradeNum = String($card.data('grade-num') || '');  // e.g. "1", "4"
        const cardTier = String($card.data('grade-tier') || '');     // e.g. "JUNIOR", "SENIOR"
        const cardType = String($card.data('type') || '');           // e.g. "พื้นฐาน", "เพิ่มเติม"
        const cardHours = String($card.data('hours') || '');
        const cardCode = String($card.data('code') || '').toLowerCase();
        const cardName = String($card.data('name') || '').toLowerCase();
        const cardClass = String($card.data('class') || '').toLowerCase();
        const cardTeacher = String($card.data('teacher') || '').toLowerCase();

        // Grade matching
        let matchGrade = false;
        if (selectedGrade === 'ALL') {
            matchGrade = true;
        } else if (selectedGrade === 'JUNIOR') {
            matchGrade = (cardTier === 'JUNIOR' || ['1', '2', '3'].includes(cardGradeNum));
        } else if (selectedGrade === 'SENIOR') {
            matchGrade = (cardTier === 'SENIOR' || ['4', '5', '6'].includes(cardGradeNum));
        } else {
            matchGrade = (cardGrade === selectedGrade || (selectedGradeNum !== '' && cardGradeNum === selectedGradeNum));
        }

        // Subject Type matching (พื้นฐาน / เพิ่มเติม)
        let matchType = false;
        if (selectedType === 'ALL') {
            matchType = true;
        } else {
            matchType = (cardType === selectedType);
        }

        // Hours matching
        let matchHours = false;
        if (selectedHours === 'ALL') {
            matchHours = true;
        } else if (selectedHours === '4') {
            matchHours = parseInt(cardHours, 10) >= 4;
        } else {
            matchHours = (cardHours === selectedHours);
        }

        // Search matching
        let matchSearch = true;
        if (searchVal !== '') {
            matchSearch = cardCode.includes(searchVal) || 
                          cardName.includes(searchVal) || 
                          cardClass.includes(searchVal) || 
                          cardTeacher.includes(searchVal) ||
                          cardType.toLowerCase().includes(searchVal);
        }

        if (matchGrade && matchType && matchHours && matchSearch) {
            $card.show();
        } else {
            $card.hide();
        }
    });

    // 2. Filter Group Columns
    $('.kanban-group-column[data-group-id]').each(function() {
        const $col = $(this);
        const colGrade = String($col.data('target-grade') || 'ALL');
        let showCol = false;

        if (selectedGrade === 'ALL') {
            showCol = true;
        } else if (colGrade === 'ALL' || colGrade === '') {
            showCol = true;
        } else if (selectedGrade === 'JUNIOR') {
            showCol = (colGrade === 'JUNIOR' || colGrade === 'ม.ต้น' || ['1', '2', '3', 'ม.1', 'ม.2', 'ม.3'].includes(colGrade));
        } else if (selectedGrade === 'SENIOR') {
            showCol = (colGrade === 'SENIOR' || colGrade === 'ม.ปลาย' || ['4', '5', '6', 'ม.4', 'ม.5', 'ม.6'].includes(colGrade));
        } else {
            showCol = (colGrade === selectedGrade || colGrade === selectedGradeNum);
        }

        // Keep visible if there are visible matching cards inside this group
        if (!showCol && $col.find('.subject-drag-card:visible').length > 0) {
            showCol = true;
        }

        if (showCol) {
            $col.show();
        } else {
            $col.hide();
        }
    });

    // Update pool visible count badge
    const visiblePoolCount = $('#poolCardList').find('.subject-drag-card:visible').length;
    $('#poolCountBadge').text(visiblePoolCount + ' วิชา');
}

// Group Modal
function openNewGroupModal() {
    $('#manage_group_id').val('');
    $('#manage_group_name').val('');
    
    // Auto-select active grade from filter if applicable
    const activeGrade = $('.filter-grade-btn.active').data('grade') || 'ALL';
    if (activeGrade !== 'ALL') {
        $('#manage_target_grade').val(activeGrade);
    } else {
        $('#manage_target_grade').val('ALL');
    }

    $('#modalGroupTitle').html('<i class="bx bx-plus-circle me-2"></i> สร้างกลุ่มวิชาเรียนพร้อมกัน');
    $('#modalGroupManage').modal('show');
}

function editGroupName(groupId, currentName, currentTargetGrade) {
    $('#manage_group_id').val(groupId);
    $('#manage_group_name').val(currentName);
    $('#manage_target_grade').val(currentTargetGrade || 'ALL');
    $('#modalGroupTitle').html('<i class="bx bx-edit me-2"></i> แก้ไขข้อมูลกลุ่ม');
    $('#modalGroupManage').modal('show');
}

function deleteGroup(groupId) {
    Swal.fire({
        title: 'ยืนยันการลบกลุ่ม?',
        text: 'วิชาในกลุ่มนี้จะถูกปลดกลับคืนสู่สระวิชาทั้งหมด',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#15a362',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่, ลบเลย!',
        cancelButtonText: 'ยกเลิก'
    }).then(function(result) {
        if (result.isConfirmed) {
            $.post('<?= base_url("admin/academic/timetable/delete-joint-group") ?>/' + groupId, {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            }, function(res) {
                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'ลบสำเร็จ',
                        timer: 1000,
                        showConfirmButton: false
                    }).then(() => window.location.reload());
                } else {
                    Swal.fire({ icon: 'error', title: 'ผิดพลาด', text: res.message, confirmButtonColor: '#15a362' });
                }
            }, 'json');
        }
    });
}

function clearAllGroups() {
    Swal.fire({
        title: 'ยืนยันล้างกลุ่มทั้งหมด?',
        text: 'วิชาทั้งหมดจะถูกปลดกลับคืนสู่สระวิชา และลบคอลัมน์กลุ่มทั้งหมด',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff3e1d',
        cancelButtonColor: '#8592a3',
        confirmButtonText: 'ใช่, ล้างทั้งหมด!',
        cancelButtonText: 'ยกเลิก'
    }).then(function(result) {
        if (result.isConfirmed) {
            $.post('<?= base_url("admin/academic/timetable/clear-all-subject-groups") ?>', {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            }, function(res) {
                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'ล้างกลุ่มเรียบร้อยแล้ว',
                        timer: 1000,
                        showConfirmButton: false
                    }).then(() => window.location.reload());
                } else {
                    Swal.fire({ icon: 'error', title: 'ผิดพลาด', text: res.message, confirmButtonColor: '#15a362' });
                }
            }, 'json');
        }
    });
}

function showToastNotification(msg) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: false
    });
    Toast.fire({
        icon: 'success',
        title: msg
    });
}

$(document).ready(function() {
    // Grade filter click
    $('.filter-grade-btn').on('click', function() {
        $('.filter-grade-btn').removeClass('active btn-primary').addClass('btn-outline-secondary');
        $(this).addClass('active btn-primary').removeClass('btn-outline-secondary');
        applyFilters();
    });

    // Subject Type filter click (พื้นฐาน / เพิ่มเติม)
    $('.filter-type-btn').on('click', function() {
        $('.filter-type-btn').removeClass('active btn-primary').addClass('btn-outline-secondary');
        $(this).addClass('active btn-primary').removeClass('btn-outline-secondary');
        applyFilters();
    });

    // Hours filter click
    $('.filter-hours-btn').on('click', function() {
        $('.filter-hours-btn').removeClass('active btn-primary').addClass('btn-outline-secondary');
        $(this).addClass('active btn-primary').removeClass('btn-outline-secondary');
        applyFilters();
    });

    // Search input typing
    $('#searchSubjectInput').on('keyup', function() {
        applyFilters();
    });

    // Modal submit
    $('#formGroupManage').on('submit', function(e) {
        e.preventDefault();
        const gId = $('#manage_group_id').val();
        const gName = $('#manage_group_name').val().trim();
        const gGrade = $('#manage_target_grade').val();

        if (gName === '') return;

        const postUrl = gId 
            ? '<?= base_url("admin/academic/timetable/save-joint-group") ?>'
            : '<?= base_url("admin/academic/timetable/quick-create-group") ?>';

        $.post(postUrl, {
            group_id: gId,
            group_name: gName,
            target_grade: gGrade,
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
        }, function(res) {
            if (res.status === 'success') {
                $('#modalGroupManage').modal('hide');
                window.location.reload();
            } else {
                Swal.fire({ icon: 'error', title: 'ผิดพลาด', text: res.message, confirmButtonColor: '#15a362' });
            }
        }, 'json');
    });

    // Modal backdrop safeguard
    $('#modalGroupManage').on('hidden.bs.modal', function () {
        if ($('.modal.show').length === 0) {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css({ overflow: '', paddingRight: '' });
        }
    });

    // Explicitly bind to window for inline HTML event attributes
    window.dragStart = dragStart;
    window.dragEnd = dragEnd;
    window.allowDrop = allowDrop;
    window.dragLeave = dragLeave;
    window.dropToGroup = dropToGroup;
    window.dropToPool = dropToPool;
    window.removeAssignFromGroup = removeAssignFromGroup;
    window.openNewGroupModal = openNewGroupModal;
    window.editGroupName = editGroupName;
    window.deleteGroup = deleteGroup;
    window.clearAllGroups = clearAllGroups;

    // Run initial filter check and subgroup badge calculations
    updateKanbanCounters();
    applyFilters();
});
</script>
<?= $this->endSection() ?>
