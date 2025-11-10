<style>
.modal {
    z-index: 99999; /* Very high z-index to ensure it's on top */
}
.modal-backdrop {
    z-index: 99998; /* Slightly lower than modal */
}
.form-switch-custom {
    --switch-width: 3rem;
    --switch-height: 1.5rem;
    --switch-padding: 0.25rem;
    position: relative;
    display: inline-block;
    width: var(--switch-width);
    height: var(--switch-height);
}

.form-switch-custom .switch-label {
    position: absolute;
    left: -9999px;
    top: 50%;
}

.form-switch-custom .switch-toggle {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: #e9ecef;
    border: 1px solid #ced4da;
    border-radius: var(--switch-height);
    transition: 0.15s ease-in-out;
}

.form-switch-custom .switch-toggle:after {
    content: '';
    position: absolute;
    height: calc(var(--switch-height) - (var(--switch-padding) * 2));
    width: calc(var(--switch-height) - (var(--switch-padding) * 2));
    border-radius: 50%;
    background: white;
    top: var(--switch-padding);
    left: var(--switch-padding);
    transition: 0.15s ease-in-out;
}

.form-switch-custom input:checked + .switch-toggle {
    background: var(--bs-primary);
    border-color: var(--bs-primary);
}

.form-switch-custom input:checked + .switch-toggle:after {
    transform: translateX(calc(var(--switch-width) - var(--switch-height)));
}

.form-switch-custom input:focus + .switch-toggle {
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.table-weeks {
    --bs-table-striped-bg: var(--bs-gray-100);
}

.table-weeks th {
    background: var(--bs-gray-200);
    font-weight: 600;
}

.table-weeks td {
    vertical-align: middle;
}
</style>

<!-- Modal -->
<div class="modal fade" id="ClubSetDateAttendance" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="exampleModalLabel">กำหนดเวลาเรียนชุมนุม</h5>
                    <small class="text-muted">ปีการศึกษา <?= isset($CheckOnoffClub->c_onoff_year) ? esc($CheckOnoffClub->c_onoff_year) : '' ?></small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="FormClubSetDateAttendance">
                <div class="modal-body p-4">
                    <div class="table-responsive">
                        <table class="table table-weeks align-middle" id="TbDateWeeks">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 80px;">ครั้งที่</th>
                                    <th>วันที่เรียน</th>
                                    <th style="width: 100px;">สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dynamic content -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-save me-1"></i> บันทึกการตั้งค่า
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>