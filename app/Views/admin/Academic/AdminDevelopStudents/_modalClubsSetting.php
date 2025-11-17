<!-- Modal -->
<div class="modal fade" id="modalClubSettings" tabindex="-1" aria-labelledby="modalClubSettingsLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalClubSettingsLabel">
                    <i class="bx bx-cog me-2"></i>ตั้งค่าการลงทะเบียนและระบบ (ปีการศึกษา <?= esc($current_year) ?>)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <!-- Student Registration -->
                    <div class="col-md-4">
                        <div class="card shadow-none border h-100">
                            <div class="card-body text-center">
                                <i class='bx bxs-user-detail bx-lg text-primary mb-3'></i>
                                <h5 class="card-title">สำหรับนักเรียน</h5>
                                <p class="card-text">เปิด/ปิด ให้นักเรียนลงทะเบียนเข้าร่วมชุมนุม</p>
                                <div class="form-check form-switch d-flex justify-content-center">
                                    <input class="form-check-input club-onoff-toggle" type="checkbox" id="student-toggle" 
                                           data-target="student"
                                           <?= (isset($onoff_status['student']->c_onoff_status) && $onoff_status['student']->c_onoff_status == 1) ? 'checked' : '' ?>>
                                    <label class="form-check-label ms-2" for="student-toggle">
                                        <span id="student-status-text"><?= (isset($onoff_status['student']->c_onoff_status) && $onoff_status['student']->c_onoff_status == 1) ? 'เปิด' : 'ปิด' ?></span>
                                    </label>
                                </div>
                                <div class="mt-3 pt-3 border-top">
                                    <div class="mb-2">
                                        <label class="form-label" for="student-start-date">วันที่เริ่ม</label>
                                        <input type="text" id="student-start-date" class="form-control club-onoff-datepicker" placeholder="เลือกวันที่" data-target="student" data-type="start" 
                                               value="<?= isset($onoff_status['student']->c_onoff_regisstart) && $onoff_status['student']->c_onoff_regisstart != '0000-00-00 00:00:00' ? date('Y-m-d', strtotime($onoff_status['student']->c_onoff_regisstart)) : '' ?>">
                                    </div>
                                    <div>
                                        <label class="form-label" for="student-end-date">วันที่สิ้นสุด</label>
                                        <input type="text" id="student-end-date" class="form-control club-onoff-datepicker" placeholder="เลือกวันที่" data-target="student" data-type="end"
                                               value="<?= isset($onoff_status['student']->c_onoff_regisend) && $onoff_status['student']->c_onoff_regisend != '0000-00-00 00:00:00' ? date('Y-m-d', strtotime($onoff_status['student']->c_onoff_regisend)) : '' ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Teacher Registration -->
                    <div class="col-md-4">
                        <div class="card shadow-none border h-100">
                            <div class="card-body text-center">
                                <i class='bx bxs-user-account bx-lg text-info mb-3'></i>
                                <h5 class="card-title">สำหรับครูที่ปรึกษา</h5>
                                <p class="card-text">เปิด/ปิด ให้ครูสร้างและจัดการข้อมูลชุมนุม</p>
                                <div class="form-check form-switch d-flex justify-content-center">
                                    <input class="form-check-input club-onoff-toggle" type="checkbox" id="teacher-toggle"
                                           data-target="teacher"
                                           <?= (isset($onoff_status['teacher']->c_onoff_status) && $onoff_status['teacher']->c_onoff_status == 1) ? 'checked' : '' ?>>
                                    <label class="form-check-label ms-2" for="teacher-toggle">
                                        <span id="teacher-status-text"><?= (isset($onoff_status['teacher']->c_onoff_status) && $onoff_status['teacher']->c_onoff_status == 1) ? 'เปิด' : 'ปิด' ?></span>
                                    </label>
                                </div>
                                <div class="mt-3 pt-3 border-top">
                                    <div class="mb-2">
                                        <label class="form-label" for="teacher-start-date">วันที่เริ่ม</label>
                                        <input type="text" id="teacher-start-date" class="form-control club-onoff-datepicker" placeholder="เลือกวันที่" data-target="teacher" data-type="start"
                                               value="<?= isset($onoff_status['teacher']->c_onoff_regisstart) && $onoff_status['teacher']->c_onoff_regisstart != '0000-00-00 00:00:00' ? date('Y-m-d', strtotime($onoff_status['teacher']->c_onoff_regisstart)) : '' ?>">
                                    </div>
                                    <div>
                                        <label class="form-label" for="teacher-end-date">วันที่สิ้นสุด</label>
                                        <input type="text" id="teacher-end-date" class="form-control club-onoff-datepicker" placeholder="เลือกวันที่" data-target="teacher" data-type="end"
                                               value="<?= isset($onoff_status['teacher']->c_onoff_regisend) && $onoff_status['teacher']->c_onoff_regisend != '0000-00-00 00:00:00' ? date('Y-m-d', strtotime($onoff_status['teacher']->c_onoff_regisend)) : '' ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Maintenance -->
                    <div class="col-md-4">
                        <div class="card shadow-none border bg-light-danger h-100">
                            <div class="card-body text-center">
                                <i class='bx bxs-server bx-lg text-danger mb-3'></i>
                                <h5 class="card-title">ปิดปรับปรุงระบบ</h5>
                                <p class="card-text">เปิด/ปิด การเข้าใช้งานระบบทั้งหมด</p>
                                <div class="form-check form-switch d-flex justify-content-center">
                                    <input class="form-check-input club-onoff-toggle" type="checkbox" id="system-toggle"
                                           data-target="system"
                                           <?= (isset($onoff_status['system']->c_onoff_status) && $onoff_status['system']->c_onoff_status == 1) ? 'checked' : '' ?>>
                                    <label class="form-check-label ms-2" for="system-toggle">
                                        <span id="system-status-text"><?= (isset($onoff_status['system']->c_onoff_status) && $onoff_status['system']->c_onoff_status == 1) ? 'ปิดปรับปรุง' : 'ออนไลน์' ?></span>
                                    </label>
                                </div>
                                <div class="mt-3 pt-3 border-top">
                                    <div class="mb-2">
                                        <label class="form-label" for="system-start-date">วันที่เริ่ม</label>
                                        <input type="text" id="system-start-date" class="form-control club-onoff-datepicker" placeholder="เลือกวันที่" data-target="system" data-type="start"
                                               value="<?= isset($onoff_status['system']->c_onoff_regisstart) && $onoff_status['system']->c_onoff_regisstart != '0000-00-00 00:00:00' ? date('Y-m-d', strtotime($onoff_status['system']->c_onoff_regisstart)) : '' ?>">
                                    </div>
                                    <div>
                                        <label class="form-label" for="system-end-date">วันที่สิ้นสุด</label>
                                        <input type="text" id="system-end-date" class="form-control club-onoff-datepicker" placeholder="เลือกวันที่" data-target="system" data-type="end"
                                               value="<?= isset($onoff_status['system']->c_onoff_regisend) && $onoff_status['system']->c_onoff_regisend != '0000-00-00 00:00:00' ? date('Y-m-d', strtotime($onoff_status['system']->c_onoff_regisend)) : '' ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>
