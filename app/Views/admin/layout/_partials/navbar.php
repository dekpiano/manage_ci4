                <nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                            <i class="icon-base bx bx-menu icon-md"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
                        <!-- Search -->
                        <div class="navbar-nav align-items-center me-auto">
                            <div class="nav-item d-flex align-items-center">
                                <span class="w-px-22 h-px-22"><i class="icon-base bx bx-search icon-md"></i></span>
                                <input type="text" id="navbar-search-input"
                                    class="form-control border-0 shadow-none ps-1 ps-sm-2 d-md-block d-none"
                                    placeholder="ค้นหาเมนูหรือระบบ..." aria-label="Search..." />
                            </div>
                        </div>
                        <!-- /Search -->

                        <ul class="navbar-nav flex-row align-items-center ms-md-auto">
                            <!-- Place this tag where you want the button to render. -->


                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow p-0 d-flex align-items-center" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="me-2 text-end d-none d-md-block">
                                        <div class="fw-semibold lh-1" style="font-size: 0.9rem;"><?= session()->get('fullname') ?></div>
                                        <small class="text-muted lh-1" style="font-size: 0.75rem;">
                                            <?= session()->get('admin_rloes_status') ?>
                                        </small>
                                    </div>
                                    <div class="avatar avatar-online">
                                        <img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?= session()->get('img') ?>" alt
                                            class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?= session()->get('img') ?>" alt=""
                                                            class="w-px-40 h-auto rounded-circle">
                                                    </div>
                                                </div>
                                                <div class="grow">
                                                    <h6 class="mb-0"><?= session()->get('fullname') ?></h6>
                                                    <small class="text-body-secondary"><?= session()->get('admin_rloes_status') ?></small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= base_url('LogoutTeacher') ?>">
                                            <i class="icon-base bx bx-power-off icon-md me-3 text-danger"></i><span class="text-danger fw-bold">ออกจากระบบ</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>