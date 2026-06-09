<style>
    .text-success { color: #15a362 !important; }
    .btn-success { background-color: #15a362 !important; border-color: #15a362 !important; }
    .btn-outline-success { color: #15a362 !important; border-color: #15a362 !important; }
    .btn-outline-success:hover { background-color: #15a362 !important; color: #fff !important; }
    .border-success { border-color: #15a362 !important; }
</style>
                <nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme shadow-none border-bottom"
                    id="layout-navbar" style="backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.8) !important;">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                            <i class="icon-base bx bx-menu icon-md"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Left Side: Dynamic Text -->
                        <div class="navbar-nav align-items-center me-auto">
                            <div class="nav-item d-flex align-items-center">
                                <!-- Mobile: งานวิชาการ | Desktop: Digital Academic Portal -->
                                <span class="fw-bold fs-5 text-dark d-block d-md-none">งานวิชาการ สกจ.</span>
                                <span class="fw-bold fs-5 text-dark d-none d-md-block">Digital <span class="text-success">Academic</span> Portal</span>
                            </div>
                        </div>

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <?php if (!session()->get('login_id')): ?>
                                <!-- Desktop: Separate Buttons -->
                                <div class="d-none d-md-flex align-items-center">
                                    <li class="nav-item me-2">
                                        <a href="https://student.skj.ac.th/" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-bold">
                                            <i class="bx bx-user me-1"></i> นักเรียน
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="http://teacher2.skj.ac.th/" class="btn btn-sm btn-success rounded-pill px-3 fw-bold shadow-sm">
                                            <i class="bx bx-id-card me-1"></i> ครูผู้สอน
                                        </a>
                                    </li>
                                </div>

                                <!-- Mobile: Single Login Dropdown -->
                                <li class="nav-item dropdown d-md-none">
                                    <a class="btn btn-sm btn-success dropdown-toggle rounded-pill px-3 fw-bold shadow-sm" href="javascript:void(0);" data-bs-toggle="dropdown">
                                        <i class="bx bx-log-in-circle me-1"></i> เข้าสู่ระบบ
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                                        <li>
                                            <a class="dropdown-item py-2" href="https://student.skj.ac.th/">
                                                <i class="bx bx-user me-2"></i> สำหรับนักเรียน
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2" href="http://teacher2.skj.ac.th/">
                                                <i class="bx bx-id-card me-2"></i> สำหรับครูผู้สอน
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php else: ?>
                                <!-- User Dropdown if logged in -->
                                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                    <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                                        data-bs-toggle="dropdown">
                                        <div class="d-flex align-items-center">
                                            <div class="me-2 text-end d-none d-md-block">
                                                <small class="text-muted d-block lh-1">ยินดีต้อนรับ</small>
                                                <span class="fw-semibold fs-7"><?= session()->get('fullname') ?></span>
                                            </div>
                                            <div class="avatar avatar-online">
                                                <img src="<?= session()->get('img') ? 'https://personnel.skj.ac.th/uploads/admin/Personnal/'.session()->get('img') : base_url('assets/img/avatars/1.png') ?>" alt
                                                    class="w-px-40 h-auto rounded-circle border border-2 border-success" />
                                            </div>
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                                        <li>
                                            <div class="dropdown-item fw-bold text-dark">
                                                <i class="bx bx-user me-2"></i> ข้อมูลส่วนตัว
                                            </div>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="<?= base_url('LogoutTeacher') ?>">
                                                <i class="bx bx-power-off me-2"></i> ออกจากระบบ
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </nav>