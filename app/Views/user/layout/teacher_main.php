<!DOCTYPE html>

<html lang="en" class="customizer-hide" dir="ltr" data-assets-path="<?= base_url('assets/') ?>"
    data-template="vertical-menu-template-no-customizer">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?= esc($title ?? 'ระบบบันทึกผลงานครู') ?> | งานวิชาการ สกจ.</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="https://skj.ac.th/uploads/logo/LogoSKJ_4.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=K2D:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">

    <!-- Core CSS (ปรับให้เหมือนกับ admin/layout/main.php) -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/demo.css') ?>" />
    <link rel="stylesheet" href="<?= base_url()?>/assets/vendor/fonts/iconify-icons.css" />
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= base_url()?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <!-- SweetAlert2 CSS -->
    <link class="swal2-style" rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
    <!-- DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <?= $this->renderSection('extra_css') ?>
</head>

<body style="font-family: 'K2D', sans-serif; background-color: #f4fbf8;">
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Teacher Sidebar Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme"
                style="background-color: #FFFFFF; border-right: 1px solid rgba(21, 163, 98, 0.1);">
                <div class="app-brand demo py-3">
                    <a href="<?= base_url('competition/show'); ?>" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <img class="img-fluid" src="https://skj.ac.th/uploads/logo/LogoSKJ_4.png" alt="logo"
                                style="height:40px;">
                        </span>
                        <span class="app-brand-text demo menu-text fw-bold ms-2"
                            style="color: #1b5e20;">บันทึกผลงานครู</span>
                    </a>
                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>
                <div class="menu-divider mt-0"></div>
                <ul class="menu-inner py-1">
                    <li class="menu-item active">
                        <a href="<?= base_url('admin/academic/competition') ?>" class="menu-link"
                            style="background-color: rgba(21, 163, 98, 0.1); color: #15a362; font-weight: 700;">
                            <i class="menu-icon tf-icons bx bx-trophy" style="color: #15a362;"></i>
                            <div>จัดการผลงานการแข่งขัน</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?= base_url('competition/show') ?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-left-arrow-alt"></i>
                            <div>กลับหน้าแสดงผลงานหลัก</div>
                        </a>
                    </li>
                </ul>
            </aside>
            <!-- / Teacher Sidebar Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Simple Top Navbar -->
                <nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme shadow-none border-bottom"
                    id="layout-navbar"
                    style="background: rgba(255, 255, 255, 0.9) !important; border-color: rgba(21, 163, 98, 0.15) !important;">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>
                    <div class="navbar-nav align-items-center me-auto">
                        <span class="fw-bold text-dark fs-5"><span
                                style="color: #15a362;">Teacher</span> Portal / บันทึกผลงาน</span>
                    </div>
                    <ul class="navbar-nav flex-row align-items-center ms-auto">
                        <li class="nav-item dropdown-user dropdown">
                            <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                                data-bs-toggle="dropdown">
                                <div class="d-flex align-items-center">
                                    <div class="me-2 text-end">
                                        <small class="text-muted d-block lh-1">คุณกำลังใช้งานในฐานะครู</small>
                                        <span class="fw-semibold fs-7"
                                            style="color: #1b5e20;"><?= session()->get('fullname') ?></span>
                                    </div>
                                    <div class="avatar">
                                        <img src="<?= session()->get('img') ? 'https://personnel.skj.ac.th/uploads/admin/Personnal/' . session()->get('img') : base_url('assets/img/avatars/1.png') ?>"
                                            class="w-px-40 h-auto rounded-circle border border-2 border-success" />
                                    </div>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                                <li>
                                    <a class="dropdown-item text-danger"
                                        href="<?= base_url('LogoutTeacher') ?>">
                                        <i class="bx bx-power-off me-2"></i> ออกจากระบบ
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <?= $this->renderSection('content') ?>
                    </div>
                    <!-- / Content -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- / Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS (ปรับให้เรียกพาธเหมือนกับ admin/layout/main.php) -->
    <!-- Helpers -->
    <script src="<?= base_url()?>/assets/vendor/js/helpers.js"></script>
    <script src="<?=base_url();?>assets/js/config.js"></script>
    <script src="<?=base_url();?>assets/vendor/libs/jquery/jquery.js"></script>

    <script src="<?=base_url();?>assets/vendor/libs/popper/popper.js"></script>
    <script src="<?=base_url();?>assets/vendor/js/bootstrap.js"></script>

    <script src="<?=base_url();?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="<?=base_url();?>assets/vendor/js/menu.js"></script>

    <!-- DataTable JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <style>
        .swal2-popup-on-top {
            z-index: 99999 !important;
        }
    </style>

    <!-- Flatpickr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    <!-- Flatpickr Thai Locale JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/l10n/th.js"></script>

    <!-- Main JS -->
    <script src="<?=base_url();?>assets/js/main.js"></script>

    <script>
        (function() {
            const sessionCheckInterval = 60000;
            const sessionCheckUrl = '<?= site_url("session/check") ?>';
            const loginUrl = '<?= site_url("LogoutTeacher") ?>';

            const checkSession = () => {
                fetch(sessionCheckUrl)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.status === 'expired') {
                            clearInterval(sessionInterval);
                            Swal.fire({
                                icon: 'warning',
                                title: 'เซสชันหมดอายุ',
                                text: 'กรุณาเข้าสู่ระบบใหม่อีกครั้ง ระบบจะนำคุณไปหน้าล็อกอิน',
                                timer: 3000,
                                timerProgressBar: true,
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = loginUrl;
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error checking session status:', error);
                    });
            };

            const sessionInterval = setInterval(checkSession, sessionCheckInterval);
        })();
    </script>

    <script>
        $(document).ajaxError(function(event, jqXHR, ajaxSettings, thrownError) {
            if (jqXHR.status === 401) {
                Swal.fire({
                    icon: 'warning',
                    title: 'เซสชันหมดอายุ',
                    text: 'กรุณาเข้าสู่ระบบใหม่อีกครั้ง',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    window.location.href = '<?= base_url('LogoutTeacher') ?>';
                });
            }
        });

        /**
         * Global CSRF Auto-Injection for HTML Forms
         */
        $(document).on('submit', 'form[method="post"]', function() {
            if ($(this).find('input[name="<?= csrf_token() ?>"]').length === 0) {
                $(this).prepend('<?= csrf_field() ?>');
            }
        });

        /**
         * Global AJAX Setup for CSRF Protection
         */
        $.ajaxSetup({
            headers: {
                '<?= config('Security')->headerName ?>': '<?= csrf_hash() ?>'
            }
        });
    </script>

    <?= $this->renderSection('script') ?>
    <?= $this->renderSection('modals') ?>
</body>

</html>
