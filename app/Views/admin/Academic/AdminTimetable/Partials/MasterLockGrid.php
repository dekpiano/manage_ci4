<style>
    .master-grid-wrapper {
        position: relative;
        max-height: 70vh; /* ใช้หน่วย vh เพื่อให้สัมพันธ์กับหน้าจอ */
        overflow: scroll !important; /* บังคับให้แสดง Scrollbar */
        border-radius: 12px;
        border: 1px solid #e6e8eb;
        background: #fff;
        -webkit-overflow-scrolling: touch;
    }

    .master-grid-table {
        border-collapse: separate;
        border-spacing: 0;
        min-width: 2500px; /* บังคับความกว้างเพื่อให้เลื่อนซ้ายขวาได้ */
        table-layout: fixed; /* ล็อคความกว้างคอลัมน์ให้เท่ากัน */
    }

    /* 📌 Sticky Row (Header) */
    .master-grid-table thead tr:first-child th {
        position: sticky;
        top: 0;
        z-index: 100;
        background: #f8f9fa;
        border-bottom: 2px solid #e6e8eb;
        height: 45px;
    }
    .master-grid-table thead tr:nth-child(2) th {
        position: sticky;
        top: 45px;
        z-index: 100;
        background: #fdfdfd;
        border-bottom: 1px solid #e6e8eb;
        height: 35px;
    }

    /* 📌 Sticky Column (Class Names) */
    .master-grid-table td:first-child, 
    .master-grid-table th:first-child {
        position: sticky;
        left: 0;
        z-index: 90;
        background: #fff;
        border-right: 2px solid #e6e8eb;
        font-weight: 700;
        color: #15a362;
        width: 100px !important;
    }
    /* จุดตัดซ้ายบนสุด */
    .master-grid-table thead tr:first-child th:first-child {
        z-index: 110;
        background: #15a362 !important;
        color: #fff !important;
    }
    .master-grid-table thead tr:nth-child(2) th:first-child {
        z-index: 110;
    }

    /* 🎨 Cell Styling */
    .master-cell {
        height: 38px;
        min-width: 50px;
        transition: all 0.2s ease;
        position: relative;
        padding: 2px !important;
    }
    .master-cell:hover {
        background-color: rgba(21, 163, 98, 0.05) !important;
        transform: scale(1.05);
        z-index: 5;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    /* 🏷️ Content Labels */
    .lock-badge {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        font-weight: 700;
        font-size: 0.65rem;
        letter-spacing: -0.2px;
    }
    
    .badge-master { background: rgba(3, 195, 236, 0.12); color: #03c3ec; border: 1px solid rgba(3, 195, 236, 0.2); }
    .badge-subject { background: rgba(21, 163, 98, 0.12); color: #15a362; border: 1px solid rgba(21, 163, 98, 0.2); }
    .badge-lunch { background: #f1f0f2; color: #a1acb8; font-style: italic; opacity: 0.7; }

    /* 🌈 Row Highlight */
    .master-grid-table tr:hover td:not(:first-child) {
        background-color: rgba(21, 163, 98, 0.02);
    }

    .legend-item {
        display: inline-flex;
        align-items: center;
        margin-right: 15px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .legend-box {
        width: 12px;
        height: 12px;
        border-radius: 3px;
        margin-right: 5px;
    }
</style>

<div class="mb-3 d-flex justify-content-between align-items-center bg-white p-3 rounded-3 shadow-sm border border-light">
    <div>
        <h6 class="mb-0 fw-bold text-dark"><i class='bx bx-grid-alt me-1 text-primary'></i> สรุปภาพรวมการล็อควิชาทั่งโรงเรียน</h6>
        <p class="small text-muted mb-0">แสดงสถานะการล็อควิชาของทุกห้องเรียนแยกตามช่วงเวลา</p>
    </div>
    <div class="d-flex">
        <div class="legend-item"><div class="legend-box badge-subject"></div> วิชาเรียน</div>
        <div class="legend-item"><div class="legend-box badge-master"></div> กิจกรรมกลาง</div>
        <div class="legend-item"><div class="legend-box badge-lunch"></div> พักกลางวัน</div>
    </div>
</div>

<div class="master-grid-wrapper shadow-none border rounded-3 overflow-hidden">
    <table class="table master-grid-table mb-0 text-center">
        <thead>
            <tr>
                <th rowspan="2" class="align-middle">ห้องเรียน</th>
                <?php foreach($days as $day): if(!$day->is_active) continue; ?>
                <th colspan="<?= count($periods) ?>" class="py-2 border-start" style="background: #f4f6f8;">
                    <span class="text-uppercase fw-bold ls-1" style="color: <?= 
                        ($day->day_key == 'MON') ? '#ff5252' : 
                        (($day->day_key == 'TUE') ? '#e91e63' : 
                        (($day->day_key == 'WED') ? '#4caf50' : 
                        (($day->day_key == 'THU') ? '#ff9800' : 
                        (($day->day_key == 'FRI') ? '#2196f3' : '#697a8d'))))
                    ?>;">
                        <?= $day->day_name ?>
                    </span>
                </th>
                <?php endforeach; ?>
            </tr>
            <tr>
                <?php foreach($days as $day): if(!$day->is_active) continue; ?>
                    <?php foreach($periods as $p): ?>
                    <th class="py-1 border-start small text-muted fw-normal" style="font-size: 0.6rem;">
                        ค.<?= $p->period_number ?>
                    </th>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($classes as $className): 
                $level = 0;
                if (preg_match('/^([1-6])/', $className, $matches)) $level = (int)$matches[1];
            ?>
            <tr>
                <td class="align-middle bg-light-subtle"><?= $className ?></td>
                <?php foreach($days as $day): if(!$day->is_active) continue; ?>
                    <?php foreach($periods as $p): 
                        $locked = $lockMap[$className][$day->day_key][$p->period_number] ?? null;
                        $master = $masterMap[$day->day_key][$p->period_number] ?? null;
                        
                        $level_group = ($level >= 4 && $level <= 6) ? 'Senior' : 'Junior';
                        $isLunch = false;
                        foreach($all_periods as $ap) {
                            if($ap->period_number == $p->period_number && $ap->is_break == 1 && ($ap->level_group == $level_group || $ap->level_group == 'ALL')) {
                                $isLunch = true;
                                break;
                            }
                        }
                        
                        $badgeClass = '';
                        $content = '';
                        
                        if ($isLunch) {
                            $badgeClass = 'badge-lunch';
                            $content = 'พัก';
                        } elseif ($master) {
                            $badgeClass = 'badge-master';
                            $content = mb_substr($master->subject_name, 0, 5);
                        } elseif ($locked) {
                            $badgeClass = 'badge-subject';
                            $content = $locked->tsub_code;
                        }
                    ?>
                    <td class="master-cell align-middle border-start">
                        <?php if($content): ?>
                            <div class="lock-badge <?= $badgeClass ?>" data-bs-toggle="tooltip" title="<?= $locked ? $locked->tsub_name : ($master ? $master->subject_name : '') ?>">
                                <?= $content ?>
                            </div>
                        <?php endif; ?>
                    </td>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    // Initialize tooltips for the new grid
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
</script>
