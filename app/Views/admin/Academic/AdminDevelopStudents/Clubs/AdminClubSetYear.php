<!-- Modal -->
<div class="modal fade" id="ModalClubSetYear" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="bx bx-calendar me-2"></i>กำหนดปีการศึกษา
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="FormClubSetOnoffYear">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <select class="form-select" id="c_onoff_year" name="c_onoff_year" required>
                                    <?php
                                    $uniqueYears = [];
                                    if (!empty($YearAll)) {
                                        foreach ($YearAll as $y) {
                                            if (!empty($y['club_year'])) {
                                                $uniqueYears[] = intval($y['club_year']);
                                            }
                                        }
                                    }
                                    // Also include current year and next year
                                    $currentYearBE = date('Y') + 543;
                                    $uniqueYears[] = $currentYearBE;
                                    $uniqueYears[] = $currentYearBE + 1;

                                    $uniqueYears = array_unique($uniqueYears);
                                    rsort($uniqueYears);

                                    foreach ($uniqueYears as $yearVal):
                                    ?>
                                    <option value="<?=$yearVal;?>" <?= ($yearVal == ($current_year ?? '')) ? 'selected' : ''; ?>><?=$yearVal;?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="c_onoff_year">ปีการศึกษา</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <select class="form-select" id="c_onoff_term" name="c_onoff_term" required>
                                    <option value="1" <?= (($current_term ?? '') == '1') ? 'selected' : ''; ?>>1</option>
                                    <option value="2" <?= (($current_term ?? '') == '2') ? 'selected' : ''; ?>>2</option>
                                </select>
                                <label for="c_onoff_term">ภาคเรียน</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x me-1"></i>ยกเลิก
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-1"></i>บันทึก
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>