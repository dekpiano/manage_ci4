<style>
.modal {
    z-index: 99999;
}
.modal-backdrop {
    z-index: 99998;
}
.flatpickr-calendar {
    z-index: 1000000 !important;
}
#ClubSetDateAttendance .week-card-table {
    border: 1px solid #e7e7e8;
    border-radius: 8px;
    background: #ffffff;
    overflow: hidden;
}
#ClubSetDateAttendance .table-sm th, 
#ClubSetDateAttendance .table-sm td {
    padding: 0.35rem 0.6rem;
    vertical-align: middle;
}
#ClubSetDateAttendance .week-card-table thead th {
    background-color: #f8fafc;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    color: #566a7f;
    border-bottom: 1px solid #e7e7e8;
}
#ClubSetDateAttendance .form-control-sm {
    font-size: 0.8125rem;
    padding-top: 0.2rem;
    padding-bottom: 0.2rem;
}
#ClubSetDateAttendance .input-group-text {
    padding: 0.2rem 0.5rem;
}
#ClubSetDateAttendance .form-check-input {
    cursor: pointer;
    width: 2.2rem;
    height: 1.15rem;
}
</style>

<!-- Modal -->
<div class="modal fade" id="ClubSetDateAttendance" tabindex="-1" aria-labelledby="ClubSetDateAttendanceLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <!-- Modal Header (Compact) -->
            <div class="modal-header py-2.5 px-3 border-bottom bg-white d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="p-2 rounded bg-label-success me-2.5">
                        <i class="bx bx-calendar-event fs-4 text-success"></i>
                    </div>
                    <div>
                        <h6 class="modal-title fw-bold mb-0 text-dark" id="ClubSetDateAttendanceLabel">
                            <?= !empty($is_scout_page) ? 'กำหนดเวลาเรียนกิจกรรมลูกเสือ - เนตรนารี' : 'กำหนดเวลาเรียนชุมนุม' ?>
                        </h6>
                        <small class="text-muted" style="font-size: 0.775rem;">
                            ปีการศึกษา <?= isset($CheckOnoffClub->c_onoff_year) ? esc($CheckOnoffClub->c_onoff_year) : '' ?><?= isset($CheckOnoffClub->c_onoff_term) ? ' / ภาคเรียนที่ ' . esc($CheckOnoffClub->c_onoff_term) : '' ?> (ปฏิทินไทย พ.ศ.)
                        </small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <div class="d-none d-sm-flex align-items-center gap-1.5" id="weeksStatsContainer">
                        <span class="badge bg-label-success rounded-pill px-2.5 py-1 small">
                            <i class="bx bx-check-circle me-1"></i>เปิด <span id="countWeeksOpen" class="fw-bold">0</span>
                        </span>
                        <span class="badge bg-label-secondary rounded-pill px-2.5 py-1 small">
                            <i class="bx bx-minus-circle me-1"></i>ปิด <span id="countWeeksClosed" class="fw-bold">0</span>
                        </span>
                        <span class="badge bg-label-primary rounded-pill px-2.5 py-1 small">
                            รวม <span id="countWeeksTotal" class="fw-bold">0</span> สัปดาห์
                        </span>
                    </div>
                    <button type="button" class="btn-close ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            <form method="post" id="FormClubSetDateAttendance">
                <div class="modal-body py-2.5 px-3">
                    <!-- Compact Info Bar -->
                    <div class="d-flex align-items-center justify-content-between px-3 py-1.5 mb-2.5 rounded bg-light border">
                        <div class="small text-muted d-flex align-items-center">
                            <i class="bx bx-info-circle text-success me-1.5 fs-6"></i>
                            <span>คลิกที่ช่องวันที่เพื่อเลือกวันเรียน (พ.ศ.) หรือเปิด-ปิดสลับสัปดาห์ ระบบบันทึกอัตโนมัติทันที</span>
                        </div>
                        <div class="small fw-semibold text-success d-none d-md-flex align-items-center">
                            <i class="bx bx-check-double me-1"></i>บันทึกอัตโนมัติ (Auto-saved)
                        </div>
                    </div>

                    <!-- 2-Column Responsive Layout (Display in 1 screen) -->
                    <div class="row g-2.5" id="weeksDualColumnContainer">
                        <!-- Column 1: สัปดาห์ช่วงแรก -->
                        <div class="col-12 col-md-6">
                            <div class="week-card-table shadow-xs">
                                <div class="bg-light px-3 py-1.5 border-bottom d-flex align-items-center justify-content-between">
                                    <span class="fw-bold text-dark small" id="part1Label"><i class="bx bx-list-ol me-1 text-primary"></i>สัปดาห์ที่ 1 - 10</span>
                                    <span class="badge bg-white text-muted border small py-0.5">ช่วงแรก</span>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover align-middle mb-0" id="TbDateWeeksCol1">
                                        <thead>
                                            <tr class="text-center">
                                                <th style="width: 90px;">สัปดาห์</th>
                                                <th>วันที่เรียน (พ.ศ.)</th>
                                                <th style="width: 70px;">สถานะ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Dynamic content Part 1 -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Column 2: สัปดาห์ช่วงหลัง -->
                        <div class="col-12 col-md-6">
                            <div class="week-card-table shadow-xs">
                                <div class="bg-light px-3 py-1.5 border-bottom d-flex align-items-center justify-content-between">
                                    <span class="fw-bold text-dark small" id="part2Label"><i class="bx bx-list-ol me-1 text-primary"></i>สัปดาห์ที่ 11 - 20</span>
                                    <span class="badge bg-white text-muted border small py-0.5">ช่วงหลัง</span>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover align-middle mb-0" id="TbDateWeeksCol2">
                                        <thead>
                                            <tr class="text-center">
                                                <th style="width: 90px;">สัปดาห์</th>
                                                <th>วันที่เรียน (พ.ศ.)</th>
                                                <th style="width: 70px;">สถานะ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Dynamic content Part 2 -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden single table container for backwards compatibility -->
                    <table class="d-none" id="TbDateWeeks"><tbody></tbody></table>
                </div>

                <!-- Modal Footer (Compact) -->
                <div class="modal-footer py-2 px-3 bg-light border-top d-flex justify-content-between align-items-center">
                    <div class="small text-muted">
                        <i class="bx bx-bulb text-success me-1"></i>ระบบบันทึกวันที่และสถานะแบบ Real-time ทันที
                    </div>
                    <div>
                        <button type="button" class="btn btn-success btn-sm px-4" style="background-color: #15a362; border-color: #15a362;" data-bs-dismiss="modal">
                            <i class="bx bx-check me-1"></i> เสร็จสิ้น / ปิดหน้าต่าง
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>