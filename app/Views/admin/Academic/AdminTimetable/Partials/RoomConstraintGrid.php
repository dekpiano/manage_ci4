<div class="table-responsive">
    <table class="table table-bordered text-center align-middle bg-white shadow-sm">
        <thead class="bg-label-warning">
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
                    $isLocked = isset($lock_map[$d->day_key . '_' . $p->period_number]);
                ?>
                <td class="p-1 slot-toggle" style="height: 60px; cursor: pointer;" 
                    onclick="toggleRoomLock(this, '<?= $room_name ?>', '<?= $d->day_key ?>', '<?= $p->period_number ?>')">
                    <div class="lock-slot-room rounded-3 d-flex align-items-center justify-content-center transition-all h-100 <?= $isLocked ? 'bg-warning text-white' : '' ?>">
                        <?php if($isLocked): ?>
                            <i class="bx bx-block fs-4"></i>
                        <?php endif; ?>
                    </div>
                </td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
