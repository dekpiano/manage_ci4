<div class="card border-0 shadow-none bg-transparent">
    <div class="card-header p-0 pb-3 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-1 fw-bold text-primary"><i class="bx bx-stats me-1"></i> ภาพรวมความไม่ว่างของครู</h5>
            <p class="mb-0 text-muted small">แสดงจำนวนครูที่ติดภารกิจ (สอน/ล็อคเวลา) ในแต่ละคาบเรียน ปีการศึกษา <?= $term ?>/<?= $year ?></p>
        </div>
        <div class="d-flex gap-2">
            <span class="badge bg-label-danger border border-danger"><i class="bx bx-lock-alt me-1"></i> ล็อคเวลา</span>
            <span class="badge bg-label-info border border-info"><i class="bx bx-chalkboard me-1"></i> ติดสอน</span>
        </div>
    </div>
    <div class="table-responsive rounded-3 border bg-white">
        <table class="table table-bordered text-center align-middle m-0">
            <thead class="bg-light">
                <tr>
                    <th style="width: 120px;" class="py-3">วัน / คาบ</th>
                    <?php foreach($periods as $p): ?>
                    <th class="py-3">คาบ <?= $p->period_number ?><br><small class="text-muted fw-normal"><?= substr($p->start_time, 0, 5) ?></small></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php 
                $dayStyles = [
                    'MON' => 'bg-label-danger', 'TUE' => 'bg-label-secondary', 'WED' => 'bg-label-success',
                    'THU' => 'bg-label-warning', 'FRI' => 'bg-label-info', 'SAT' => 'bg-label-primary', 'SUN' => 'bg-label-danger'
                ];
                foreach($days as $d): 
                    if(!$d->is_active) continue;
                ?>
                <tr>
                    <td class="fw-bold <?= $dayStyles[$d->day_key] ?? 'bg-light' ?>"><?= $d->day_name ?></td>
                    <?php foreach($periods as $p): 
                        $cell = $summary[$d->day_key][$p->period_number] ?? null;
                        $lockedCount = isset($cell['locked']) ? count(array_unique($cell['locked'])) : 0;
                        $busyCount = isset($cell['busy']) ? count(array_unique($cell['busy'])) : 0;
                        $total = $lockedCount + $busyCount;
                        
                        $lockedNames = isset($cell['locked']) ? implode("\n• ", array_unique($cell['locked'])) : '';
                        $busyNames = isset($cell['busy']) ? implode("\n• ", array_unique($cell['busy'])) : '';
                        
                        $tooltip = "";
                        if($lockedCount > 0) $tooltip .= "🔒 ล็อคเวลา ($lockedCount คน):\n• $lockedNames\n\n";
                        if($busyCount > 0) $tooltip .= "📖 ติดสอน ($busyCount คน):\n• $busyNames";
                    ?>
                    <td class="p-2" style="height: 80px;">
                        <?php if($total > 0): ?>
                        <div class="d-flex flex-column gap-1 h-100 justify-content-center cursor-help" 
                             data-bs-toggle="tooltip" data-bs-html="true" title="<?= esc($tooltip) ?>">
                            <?php if($lockedCount > 0): ?>
                            <div class="badge bg-danger rounded-pill shadow-sm" style="font-size: 0.65rem;">
                                <i class="bx bx-lock-alt me-1"></i> <?= $lockedCount ?>
                            </div>
                            <?php endif; ?>
                            <?php if($busyCount > 0): ?>
                            <div class="badge bg-info rounded-pill shadow-sm" style="font-size: 0.65rem;">
                                <i class="bx bx-chalkboard me-1"></i> <?= $busyCount ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php else: ?>
                        <div class="text-light opacity-25 small">
                            <i class="bx bx-check-circle"></i>
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

<script>
    // Re-initialize tooltips for the dynamic content
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
