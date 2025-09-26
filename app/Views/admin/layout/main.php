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
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/favicon/favicon.ico') ?>" />

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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/2.12.1/slimselect.min.css" rel="stylesheet">
    </link>

     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    
    <?= $this->renderSection('extra_css') ?>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>


<body style="font-family: 'K2D', sans-serif; background-color: #F0F8FF;">
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
                    <div class="container-xxl flex-grow-1 container-p-y">

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
    <script src="<?=base_url();?>assets/vendor/libs/jquery/jquery.js"></script>
    
    <script src="<?=base_url();?>assets/vendor/libs/popper/popper.js"></script>
    <script src="<?=base_url();?>assets/vendor/js/bootstrap.js"></script>

    <script src="<?=base_url();?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="<?=base_url();?>assets/vendor/js/menu.js"></script>

    <script src="<?=base_url();?>assets/vendor/libs/popper/popper.js"></script>

    <!-- endbuild -->

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/2.12.1/slimselect.min.js"></script>

    <!-- DataTable JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<!-- DataTable Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
<script src="https://cdn.rawgit.com/crlcu/multiselect/v2.5.1/dist/js/multiselect.min.js"></script>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <!-- Vendors JS -->
    <script src="<?=base_url();?>assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->

    <script src="<?=base_url();?>assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="<?=base_url();?>assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag before closing body tag for github widget button. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <?= $this->renderSection('script') ?>
</body>

</html>