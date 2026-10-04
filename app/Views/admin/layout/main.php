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
    <link rel="icon" type="image/x-icon" href="https://skj.ac.th/uploads/logo/LogoSKJ_4.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=K2D:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/demo.css') ?>" />
    <link rel="stylesheet" href="<?= base_url()?>/assets/vendor/fonts/iconify-icons.css" />
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= base_url()?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link href="https://unpkg.com/slim-select@latest/dist/slimselect.css" rel="stylesheet">
    </link>

     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    
    <!-- Jquery Thailand CSS -->
    <link rel="stylesheet" href="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.css">
    <?= $this->renderSection('extra_css') ?>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
    <!-- DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Theme & Accessibility Contrast Utilities -->
    <style>
        :root {
            --primary-emerald: #15a362;
            --dark-emerald: #0d6d41;
            --light-emerald: #e8f5ee;
        }
        .text-emerald { color: #0d6d41 !important; }
        .text-primary-emerald { color: #15a362 !important; }
        .bg-emerald { background-color: #15a362 !important; color: #ffffff !important; }
        .bg-emerald-light { background-color: #e8f5ee !important; color: #0d6d41 !important; }
        .btn-white {
            background-color: #ffffff !important;
            color: #0d6d41 !important;
            border: 1px solid rgba(0, 0, 0, 0.08) !important;
            font-weight: 700 !important;
            transition: all 0.2s ease;
        }
        .btn-white:hover {
            background-color: #f0fdf4 !important;
            color: #065f46 !important;
            border-color: #86efac !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        }
        .swal2-container { z-index: 9999 !important; }

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


<body style="font-family: 'K2D', sans-serif; background-color: #F0F8FF;">
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
            <?= $this->include('admin/layout/_partials/sidebar') ?>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <?= $this->include('admin/layout/_partials/navbar') ?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl grow container-p-y">

                        <?= $this->renderSection('content') ?>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <?= $this->include('admin/layout/_partials/footer') ?>
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

    <!-- Core JS -->
<!-- Helpers -->
    <script src="<?= base_url()?>/assets/vendor/js/helpers.js"></script>
    <script src="<?=base_url();?>assets/js/config.js"></script>
    <script src="<?=base_url();?>assets/vendor/libs/jquery/jquery.js"></script>
    
    <script src="<?=base_url();?>assets/vendor/libs/popper/popper.js"></script>
    <script src="<?=base_url();?>assets/vendor/js/bootstrap.js"></script>

    <script src="<?=base_url();?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="<?=base_url();?>assets/vendor/js/menu.js"></script>

    <script src="<?=base_url();?>assets/vendor/libs/popper/popper.js"></script>

    <!-- endbuild -->

    
    <script src="https://unpkg.com/slim-select@latest/dist/slimselect.min.js"></script>

<!-- DataTable JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<!-- DataTables Global Default Configuration -->
<script>
/**
 * Set DataTables global defaults
 * - stateSave: Remember current page, search, and sorting when navigating back
 * - stateDuration: Store state for the session (will be cleared when browser closes)
 * - Use sessionStorage instead of localStorage for better session handling
 */
$.extend(true, $.fn.dataTable.defaults, {
    stateSave: true,
    stateDuration: -1, // Use sessionStorage (cleared when browser closes)
    stateLoadCallback: function(settings, callback) {
        try {
            var state = JSON.parse(sessionStorage.getItem('DataTables_' + settings.sInstance + '_' + window.location.pathname));
            callback(state);
        } catch(e) {
            callback(null);
        }
    },
    stateSaveCallback: function(settings, data) {
        try {
            sessionStorage.setItem('DataTables_' + settings.sInstance + '_' + window.location.pathname, JSON.stringify(data));
        } catch(e) {}
    }
});
</script>

<!-- DataTable Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
<script src="https://cdn.rawgit.com/crlcu/multiselect/v2.5.1/dist/js/multiselect.min.js"></script>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<style>
    .swal2-popup-on-top {
        z-index: 99999 !important; /* A very high z-index to ensure it's always on top */
    }
</style>
<!-- Flatpickr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
<!-- Flatpickr Thai Locale JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/l10n/th.js"></script>
    <!-- Vendors JS -->
    <script src="<?=base_url();?>assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->

    <script src="<?=base_url();?>assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="<?=base_url();?>assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag before closing body tag for github widget button. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <!-- Jquery Thailand JS -->
    <script src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/JQL.min.js"></script>
    <script src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/typeahead.bundle.js"></script>
    <script src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.js"></script>


<script>
    (function() {
        const sessionCheckInterval = 60000; // 1 minute in milliseconds
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
                        // Stop the interval to prevent multiple alerts
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
    console.error(<?php echo empty(session()->get('fullname')); ?>);
    
$(document).ajaxError(function(event, jqXHR, ajaxSettings, thrownError) {
    if (jqXHR.status === 401) { // Check for 401 Unauthorized status
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
     * Automatically adds CSRF hidden field to all POST forms that don't have one
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

<?php 
    $db = \Config\Database::connect();
    $realSchoolYearObj = $db->table('tb_schoolyear')->get()->getRow();
    $realSchoolYear = $realSchoolYearObj->schyear_year ?? (date('Y') + 543);
?>
/**
 * Global Year Selection Handler (Only for Sidebar Active Year)
 * Automatically saves selected year to session when the sidebar dropdown changes
 */
$(document).on('change', '#schyear_year_sidebar', function() {
    var selectedYear = $(this).val();
    var realSchoolYear = "<?= $realSchoolYear ?>";
    
    // Check if the selected year is in the past (สิ้นสุดแล้ว)
    var isPast = false;
    if (selectedYear && realSchoolYear) {
        var sParts = selectedYear.split('/');
        var rParts = realSchoolYear.split('/');
        if (sParts.length === 2 && rParts.length === 2) {
            var sTerm = parseInt(sParts[0]), sYear = parseInt(sParts[1]);
            var rTerm = parseInt(rParts[0]), rYear = parseInt(rParts[1]);
            
            if (sYear < rYear) {
                isPast = true;
            } else if (sYear === rYear && sTerm < rTerm) {
                isPast = true;
            }
        }
    }

    if (selectedYear) {
        var executeAjax = function() {
            $.ajax({
                url: "<?= site_url('Admin/SetSelectedYear') ?>",
                type: 'POST',
                data: { 
                    year: selectedYear,
                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'ไม่สามารถบันทึกปีการศึกษาได้',
                            text: response.message || 'กรุณาลองใหม่อีกครั้ง',
                            customClass: { popup: 'swal2-popup-on-top' }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('SetSelectedYear Error:', status, error, xhr.responseText);
                    Swal.fire({
                        icon: 'warning',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถเปลี่ยนปีการศึกษาได้ กรุณา Refresh หน้าใหม่แล้วลองอีกครั้ง',
                        confirmButtonColor: '#15a362',
                        customClass: { popup: 'swal2-popup-on-top' }
                    }).then(() => {
                        location.reload();
                    });
                }
            });
        };

        if (!isPast) {
            Swal.fire({
                icon: 'warning',
                title: 'แจ้งเตือน!',
                html: 'การแก้ไข <b>"ปีการศึกษาที่ใช้งาน"</b> ไปยังปีการศึกษาปัจจุบันหรือปีการศึกษาในอนาคต จะส่งผลต่อระบบทั้งหมด!<br>หากตั้งค่าเป็นปีการศึกษาที่ยังไม่ถึง ระบบบางระบบในงานวิชาการอาจทำงานผิดพลาดหรือแสดงข้อมูลคลาดเคลื่อน<br><br><span class="text-danger fw-bold">ยืนยันการเปลี่ยนแปลงหรือไม่?</span>',
                showCancelButton: true,
                confirmButtonColor: '#15a362',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                customClass: { popup: 'swal2-popup-on-top' }
            }).then((result) => {
                if (result.isConfirmed) {
                    executeAjax();
                } else {
                    // Revert to original by reloading the page
                    location.reload(); 
                }
            });
        } else {
            // ปีการศึกษาอดีต (สิ้นสุดแล้ว) สามารถเปลี่ยนได้เลยโดยไม่ต้องแจ้งเตือน
            executeAjax();
        }
    }
});

// Global function to open file in new tab (Word, Excel, PowerPoint via Office Online Viewer, others directly)
function openFileInNewTab(fileUrl) {
    const ext = fileUrl.split('.').pop().toLowerCase();
    if (['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'].includes(ext)) {
        window.open(`https://view.officeapps.live.com/op/view.aspx?src=${encodeURIComponent(fileUrl)}`, '_blank');
    } else {
        window.open(fileUrl, '_blank');
    }
}
</script>

    <?= $this->renderSection('script') ?>

    <!-- Global Menu Search Logic -->
    <style>
        #search-results-wrapper {
            position: absolute;
            top: 100%;
            left: 0;
            width: 350px;
            max-height: 400px;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            z-index: 1060;
            overflow-y: auto;
            border: 1px solid #eee;
            display: none;
            margin-top: 10px;
        }
        .search-result-item {
            padding: 10px 15px;
            border-bottom: 1px solid #f8f9fa;
            display: flex;
            align-items: center;
            text-decoration: none !important;
            color: #435971;
            transition: all 0.2s;
        }
        .search-result-item:hover {
            background-color: #f0faf5;
            color: #15a362;
        }
        .search-result-item i {
            font-size: 1.2rem;
            margin-right: 12px;
            color: #697a8d;
        }
        .search-result-item:hover i {
            color: #15a362;
        }
        .search-result-header {
            font-size: 0.75rem;
            color: #adb5bd;
            font-weight: 700;
            padding: 10px 15px 5px;
            text-transform: uppercase;
        }
    </style>

    <div id="search-results-wrapper"></div>

    <script>
    $(document).ready(function() {
        const $searchInput = $('#navbar-search-input');
        const $resultsWrapper = $('#search-results-wrapper');
        let menuItems = [];

        // Index the sidebar menu items
        $('#layout-menu .menu-item').each(function() {
            const $item = $(this);
            const $link = $item.children('.menu-link');
            if ($link.length && $link.attr('href') !== 'javascript:void(0);') {
                const title = $link.find('div[data-i18n]').text().trim() || $link.text().trim();
                const icon = $link.find('i').attr('class') || 'bx bx-link';
                const parentHeader = $item.closest('.menu-inner').find('.menu-header').last().find('.menu-header-text').text() || 'เมนูหลัก';
                
                menuItems.push({
                    title: title,
                    url: $link.attr('href'),
                    icon: icon,
                    header: parentHeader
                });
            }
        });

        // Search logic
        $searchInput.on('input', function() {
            const query = $(this).val().trim().toLowerCase();
            if (query.length < 2) {
                $resultsWrapper.hide();
                return;
            }

            const filtered = menuItems.filter(item => 
                item.title.toLowerCase().includes(query) || 
                item.header.toLowerCase().includes(query)
            );

            if (filtered.length > 0) {
                let html = '';
                let lastHeader = '';
                
                filtered.forEach(item => {
                    if (item.header !== lastHeader) {
                        html += `<div class="search-result-header">${item.header}</div>`;
                        lastHeader = item.header;
                    }
                    html += `
                        <a href="${item.url}" class="search-result-item">
                            <i class="${item.icon}"></i>
                            <div>
                                <div class="fw-bold fs-tiny lh-1">${item.title}</div>
                                <small class="text-muted" style="font-size: 0.65rem;">${item.url.split('/').pop()}</small>
                            </div>
                        </a>
                    `;
                });
                $resultsWrapper.html(html).show();
                
                // Position results wrapper under input
                const offset = $searchInput.offset();
                $resultsWrapper.css({
                    top: offset.top + $searchInput.outerHeight() + 5,
                    left: offset.left
                });
            } else {
                $resultsWrapper.html('<div class="p-3 text-center text-muted">ไม่พบคิวรีที่ตรงกัน</div>').show();
            }
        });

        // Close search results on click outside or Esc
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#navbar-search-input, #search-results-wrapper').length) {
                $resultsWrapper.hide();
            }
        });

        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                $resultsWrapper.hide();
            }
        });

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
    });
    </script>
    <?= $this->renderSection('modals') ?>
</body>

</html>