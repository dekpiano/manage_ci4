<div class="table-responsive">
    <table class="table table-bordered text-center align-middle bg-white shadow-sm">
        <thead class="bg-label-primary">
            <tr>
                <th style="width: 100px;">วัน / คาบ</th>
                <?php foreach($periods as $p): ?>
                <th><?= $p->period_number ?><br><small class="text-muted"><?= substr($p->start_time, 0, 5) ?></small></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($days as $d): ?>
            <tr>
                <td class="fw-bold bg-light"><?= $d->day_name ?></td>
                <?php foreach($periods as $p): 
                    $key = $d->day_key . '_' . $p->period_number;
                    $isLocked = isset($lock_map[$key]);
                    $busy = $busy_map[$key] ?? null;
                ?>
                <td class="p-1" style="height: 65px; min-width: 100px;">
                    <?php if($busy): ?>
                        <div class="bg-label-info rounded-3 p-1 d-flex flex-column align-items-center justify-content-center h-100 shadow-sm border border-info" title="ติดสอนวิชา <?= $busy->tsub_code ?>">
                            <span class="fw-bold small"><?= $busy->class_name ?></span>
                            <span style="font-size: 0.65rem;" class="text-truncate d-block w-100"><?= $busy->tsub_code ?></span>
                        </div>
                    <?php else: ?>
                        <div class="lock-slot-teacher rounded-3 d-flex align-items-center justify-content-center transition-all h-100 <?= $isLocked ? 'bg-danger text-white shadow-sm' : 'hover-bg-light border border-dashed' ?>"
                             style="cursor: pointer;"
                             onclick="toggleTeacherLock(this, '<?= $teacher_id ?>', '<?= $d->day_key ?>', '<?= $p->period_number ?>')">
                            <?php if($isLocked): ?>
                                <i class="bx bx-x fs-4"></i>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
