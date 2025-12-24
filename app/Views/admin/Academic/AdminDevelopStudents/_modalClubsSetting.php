<!-- Modal Student Settings -->
<div class="modal fade" id="modalClubStudentSettings" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">
                    <i class="bx bxs-user-detail me-2 text-primary"></i>ตั้งค่าสำหรับนักเรียน
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <p class="text-muted">จัดการการเปิด/ปิด และกำหนดช่วงเวลาการลงทะเบียนของนักเรียน</p>
                    <div class="form-check form-switch d-flex justify-content-center align-items-center">
                        <input class="form-check-input club-onoff-toggle me-3" type="checkbox" id="student-toggle" 
                               data-target="student" style="width: 3rem; height: 1.5rem;"
                               <?= (isset($onoff_status['student']->c_onoff_status) && $onoff_status['student']->c_onoff_status == 1) ? 'checked' : '' ?>>
                        <label class="form-check-label h5 mb-0" for="student-toggle">
                            <span id="student-status-text" class="badge bg-label-<?= (isset($onoff_status['student']->c_onoff_status) && $onoff_status['student']->c_onoff_status == 1) ? 'success' : 'danger' ?>">
                                <?= (isset($onoff_status['student']->c_onoff_status) && $onoff_status['student']->c_onoff_status == 1) ? 'เปิดระบบ' : 'ปิดระบบ' ?>
                            </span>
                        </label>
                    </div>
                </div>
                
                <div class="card bg-light border-0">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="student-start-date">วันที่เริ่มลงทะเบียน</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-calendar-plus text-primary"></i></span>
                                <input type="text" id="student-start-date" class="form-control club-onoff-datepicker" placeholder="คลิกเพื่อเลือกวันที่" data-target="student" data-type="start" 
                                       value="<?= isset($onoff_status['student']->c_onoff_regisstart) && $onoff_status['student']->c_onoff_regisstart != '0000-00-00 00:00:00' ? date('Y-m-d', strtotime($onoff_status['student']->c_onoff_regisstart)) : '' ?>">
                            </div>
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-bold" for="student-end-date">วันที่สิ้นสุดลงทะเบียน</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-calendar-minus text-danger"></i></span>
                                <input type="text" id="student-end-date" class="form-control club-onoff-datepicker" placeholder="คลิกเพื่อเลือกวันที่" data-target="student" data-type="end"
                                       value="<?= isset($onoff_status['student']->c_onoff_regisend) && $onoff_status['student']->c_onoff_regisend != '0000-00-00 00:00:00' ? date('Y-m-d', strtotime($onoff_status['student']->c_onoff_regisend)) : '' ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top">
                <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal">ตกลง</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Teacher Settings -->
<div class="modal fade" id="modalClubTeacherSettings" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">
                    <i class="bx bxs-user-account me-2 text-info"></i>ตั้งค่าสำหรับครูที่ปรึกษา
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <p class="text-muted">จัดการการเปิด/ปิด และกำหนดช่วงเวลาการจัดการข้อมูลของครู</p>
                    <div class="form-check form-switch d-flex justify-content-center align-items-center">
                        <input class="form-check-input club-onoff-toggle me-3" type="checkbox" id="teacher-toggle"
                               data-target="teacher" style="width: 3rem; height: 1.5rem;"
                               <?= (isset($onoff_status['teacher']->c_onoff_status) && $onoff_status['teacher']->c_onoff_status == 1) ? 'checked' : '' ?>>
                        <label class="form-check-label h5 mb-0" for="teacher-toggle">
                            <span id="teacher-status-text" class="badge bg-label-<?= (isset($onoff_status['teacher']->c_onoff_status) && $onoff_status['teacher']->c_onoff_status == 1) ? 'success' : 'danger' ?>">
                                <?= (isset($onoff_status['teacher']->c_onoff_status) && $onoff_status['teacher']->c_onoff_status == 1) ? 'เปิดระบบ' : 'ปิดระบบ' ?>
                            </span>
                        </label>
                    </div>
                </div>

                <div class="card bg-light border-0">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="teacher-start-date">วันที่เริ่มจัดการข้อมูล</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-calendar-plus text-info"></i></span>
                                <input type="text" id="teacher-start-date" class="form-control club-onoff-datepicker" placeholder="คลิกเพื่อเลือกวันที่" data-target="teacher" data-type="start"
                                       value="<?= isset($onoff_status['teacher']->c_onoff_regisstart) && $onoff_status['teacher']->c_onoff_regisstart != '0000-00-00 00:00:00' ? date('Y-m-d', strtotime($onoff_status['teacher']->c_onoff_regisstart)) : '' ?>">
                            </div>
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-bold" for="teacher-end-date">วันที่สิ้นสุดจัดการข้อมูล</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-calendar-minus text-danger"></i></span>
                                <input type="text" id="teacher-end-date" class="form-control club-onoff-datepicker" placeholder="คลิกเพื่อเลือกวันที่" data-target="teacher" data-type="end"
                                       value="<?= isset($onoff_status['teacher']->c_onoff_regisend) && $onoff_status['teacher']->c_onoff_regisend != '0000-00-00 00:00:00' ? date('Y-m-d', strtotime($onoff_status['teacher']->c_onoff_regisend)) : '' ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top">
                <button type="button" class="btn btn-info text-white w-100" data-bs-dismiss="modal">ตกลง</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal System Maintenance Settings -->
<div class="modal fade" id="modalClubSystemSettings" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-danger">
            <div class="modal-header border-bottom bg-label-danger">
                <h5 class="modal-title text-danger">
                    <i class="bx bx-error me-2"></i>จัดการการเข้าถึงระบบ (ปิดปรับปรุง)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
                    <i class="bx bx-info-circle me-2 fs-4"></i>
                    <div>การปิดปรับปรุงระบบจะทำให้สมาชิกทั่วไป (ครูและนักเรียน) ไม่สามารถเข้าถึงระบบชุมนุมได้</div>
                </div>

                <div class="text-center mb-4">
                    <div class="form-check form-switch d-flex justify-content-center align-items-center">
                        <input class="form-check-input club-onoff-toggle me-3" type="checkbox" id="system-toggle"
                               data-target="system" style="width: 3rem; height: 1.5rem;"
                               <?= (isset($onoff_status['system']->c_onoff_status) && $onoff_status['system']->c_onoff_status == 1) ? 'checked' : '' ?>>
                        <label class="form-check-label h5 mb-0" for="system-toggle">
                            <span id="system-status-text" class="badge bg-<?= (isset($onoff_status['system']->c_onoff_status) && $onoff_status['system']->c_onoff_status == 1) ? 'danger' : 'success' ?>">
                                <?= (isset($onoff_status['system']->c_onoff_status) && $onoff_status['system']->c_onoff_status == 1) ? 'ปิดปรับปรุง' : 'ออนไลน์ปกติ' ?>
                            </span>
                        </label>
                    </div>
                </div>

                <div class="card bg-label-secondary border-0">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="system-start-date">วันที่เริ่มปิดปรับปรุง</label>
                            <input type="text" id="system-start-date" class="form-control club-onoff-datepicker bg-white" placeholder="เลือกวันที่" data-target="system" data-type="start"
                                   value="<?= isset($onoff_status['system']->c_onoff_regisstart) && $onoff_status['system']->c_onoff_regisstart != '0000-00-00 00:00:00' ? date('Y-m-d', strtotime($onoff_status['system']->c_onoff_regisstart)) : '' ?>">
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-bold" for="system-end-date">วันที่สิ้นสุดปิดปรับปรุง</label>
                            <input type="text" id="system-end-date" class="form-control club-onoff-datepicker bg-white" placeholder="เลือกวันที่" data-target="system" data-type="end"
                                   value="<?= isset($onoff_status['system']->c_onoff_regisend) && $onoff_status['system']->c_onoff_regisend != '0000-00-00 00:00:00' ? date('Y-m-d', strtotime($onoff_status['system']->c_onoff_regisend)) : '' ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top">
                <button type="button" class="btn btn-outline-secondary w-100" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>
