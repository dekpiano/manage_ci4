<!DOCTYPE html>

<html lang="en" class="customizer-hide" dir="ltr" data-assets-path="<?= base_url('assets/') ?>"
    data-template="vertical-menu-template-no-customizer">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?= esc($title ?? 'งานวิชาการ') ?> | งานวิชาการ สกจ.</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="https://skj.ac.th/uploads/logo/LogoSKJ_4.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=K2D:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/demo.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/fonts/iconify-icons.css') ?>" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= base_url()?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/2.12.1/slimselect.min.css" rel="stylesheet">
    </link>
    <!-- Helpers -->
    <script src="<?= base_url()?>/assets/vendor/js/helpers.js"></script>
    <script src="<?=base_url();?>assets/vendor/libs/jquery/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/2.12.1/slimselect.min.js"></script>
    <?= $this->renderSection('extra_css') ?>
    <style>
        /* ==========================================================================
           GLOBAL SYSTEM PRELOADER / LOADING SCREEN (CONTENT AREA ONLY - EXCLUDING SIDEBAR)
           ========================================================================== */
        .global-loader-overlay {
            position: fixed;
            top: 0;
            left: var(--bs-menu-width, 16.25rem);
            right: 0;
            bottom: 0;
            width: auto;
            height: 100vh;
            background: rgba(240, 248, 255, 0.94);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            z-index: 1070;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
            visibility: visible;
            transition: left 0.25s ease, opacity 0.35s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* When sidebar is collapsed */
        .layout-menu-collapsed .global-loader-overlay {
            left: var(--bs-menu-collapsed-width, 5.25rem);
        }

        /* On mobile/tablet where sidebar is offcanvas drawer */
        @media (max-width: 1199.98px) {
            .global-loader-overlay {
                left: 0 !important;
            }
        }

        .layout-without-menu .global-loader-overlay {
            left: 0 !important;
        }

        .global-loader-overlay.fade-out {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .global-loader-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 2.2rem 2.8rem;
            box-shadow: 0 20px 50px rgba(21, 163, 98, 0.18), 0 8px 24px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(21, 163, 98, 0.25);
            max-width: 440px;
            width: 90%;
            transform: scale(1);
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .global-loader-overlay.fade-out .global-loader-card {
            transform: scale(0.92);
        }

        .global-loader-logo-wrapper {
            position: relative;
            width: 86px;
            height: 86px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .global-loader-spinner {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 3.5px solid rgba(21, 163, 98, 0.15);
            border-top-color: #15a362;
            border-right-color: #15a362;
            animation: globalSpin 0.9s cubic-bezier(0.68, -0.55, 0.27, 1.55) infinite;
        }

        .global-loader-logo-circle {
            width: 62px;
            height: 62px;
            background: #ffffff;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(21, 163, 98, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 6px;
            animation: globalPulse 1.8s ease-in-out infinite;
        }

        .global-loader-logo {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .global-loader-progress {
            width: 100%;
            height: 4px;
            background: #eef2f5;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .global-loader-progress-bar {
            position: absolute;
            top: 0;
            left: -50%;
            height: 100%;
            width: 50%;
            background: linear-gradient(90deg, #15a362, #4ade80);
            border-radius: 10px;
            animation: globalIndeterminate 1.4s ease-in-out infinite;
        }

        @keyframes globalSpin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes globalPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.06); }
        }

        @keyframes globalIndeterminate {
            0% { left: -50%; width: 30%; }
            50% { left: 25%; width: 60%; }
            100% { left: 100%; width: 30%; }
        }

        @media print {
            .global-loader-overlay {
                display: none !important;
            }
        }
    </style>
</head>


<body style="font-family: 'K2D', sans-serif;">
    <!-- Global System Preloader / Loading Screen -->
    <div id="globalSystemLoader" class="global-loader-overlay">
        <div class="global-loader-card text-center">
            <!-- School Emblem & Pulse Ring -->
            <div class="global-loader-logo-wrapper mb-3">
                <div class="global-loader-spinner"></div>
                <div class="global-loader-logo-circle">
                    <img src="https://skj.ac.th/uploads/logo/LogoSKJ_4.png" alt="SKJ Logo" class="global-loader-logo">
                </div>
            </div>

            <!-- Title & Subtitle -->
            <h5 class="fw-bold text-dark mb-1" id="globalLoaderTitle">กำลังโหลดระบบ...</h5>
            <p class="text-muted small mb-3" id="globalLoaderSubtitle">โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</p>

            <!-- Gradient Progress Bar -->
            <div class="global-loader-progress mb-3">
                <div class="global-loader-progress-bar"></div>
            </div>

            <!-- Pulsing Badge Status -->
            <div class="d-inline-flex align-items-center gap-2 bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill small fw-medium">
                <span class="spinner-border spinner-border-sm text-success" role="status"></span>
                <span id="globalLoaderStatus">กรุณารอสักครู่...</span>
            </div>
        </div>
    </div>

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <?= $this->include('user/layout/_partials/sidebar') ?>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <?= $this->include('user/layout/_partials/navbar') ?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">

                        <?= $this->renderSection('content') ?>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <?= $this->include('user/layout/_partials/footer') ?>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <?= $this->renderSection('modals') ?>

    <!-- Core JS -->

    <script src="<?=base_url();?>assets/vendor/libs/popper/popper.js"></script>
    <script src="<?=base_url();?>assets/vendor/js/bootstrap.js"></script>

    <script src="<?=base_url();?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="<?=base_url();?>assets/vendor/js/menu.js"></script>

    <script src="<?=base_url();?>assets/vendor/libs/popper/popper.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="<?=base_url();?>assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="<?=base_url();?>assets/js/main.js"></script>

    <!-- Place this tag before closing body tag for github widget button. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script>
    // Global function to open file in new tab (Word, Excel, PowerPoint via Office Online Viewer, others directly)
    function openFileInNewTab(fileUrl) {
        const ext = fileUrl.split('.').pop().toLowerCase();
        if (['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'].includes(ext)) {
            window.open(`https://view.officeapps.live.com/op/view.aspx?src=${encodeURIComponent(fileUrl)}`, '_blank');
        } else {
            window.open(fileUrl, '_blank');
        }
    }

    /* ==========================================================================
       GLOBAL SYSTEM LOADER SCRIPTS
       ========================================================================== */
    window.showGlobalLoading = function(title, subtitle, statusText) {
        if (title) $('#globalLoaderTitle').text(title);
        if (subtitle) $('#globalLoaderSubtitle').text(subtitle);
        if (statusText) $('#globalLoaderStatus').text(statusText);
        $('#globalSystemLoader').removeClass('fade-out');
    };

    window.hideGlobalLoading = function() {
        $('#globalSystemLoader').addClass('fade-out');
    };

    // Auto-hide when initial page load is ready
    $(window).on('load', function() {
        setTimeout(function() {
            window.hideGlobalLoading();
        }, 250);
    });

    // Fallback: hide if load event completed or was missed
    setTimeout(function() {
        window.hideGlobalLoading();
    }, 600);

    // Prevent sticking on browser history Back/Forward cache (bfcache)
    window.addEventListener('pageshow', function(event) {
        window.hideGlobalLoading();
    });

    // Intercept clicks on links for smooth page transitions
    $(document).on('click', 'a', function(e) {
        const href = $(this).attr('href');
        const target = $(this).attr('target');
        const hasToggle = $(this).attr('data-bs-toggle') || $(this).attr('data-toggle');
        const isDownload = $(this).attr('download') !== undefined || $(this).hasClass('no-loader');

        if (!href || href === '#' || href.startsWith('#') || href.startsWith('javascript:') || target === '_blank' || hasToggle || isDownload) {
            return;
        }

        const linkText = $(this).text().trim() || 'กำลังเปิดหน้า...';
        window.showGlobalLoading('กำลังเปิดหน้า...', linkText, 'ระบบกำลังโหลดข้อมูล...');
    });

    // Intercept standard form submissions across the system (skipping AJAX forms that call preventDefault)
    $(document).on('submit', 'form:not(.no-loader):not([target="_blank"])', function(e) {
        if (e.isDefaultPrevented()) return;
        window.showGlobalLoading('กำลังประมวลผลข้อมูล...', 'ระบบกำลังบันทึกและประมวลผลข้อมูล กรุณารอสักครู่');
    });
    </script>
</body>

</html>