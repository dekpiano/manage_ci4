<?= $this->extend('user/layout/main') ?>

<?= $this->section('extra_css') ?>
<!-- DataTables Bootstrap 5 CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Intro.js Styles -->
    <link rel="stylesheet" href="https://unpkg.com/intro.js/minified/introjs.min.css">
    <style>
        .swal2-container {
            z-index: 9999 !important;
        }

        .introjs-donebutton,
        .introjs-nextbutton {
            background-color: #15a362 !important;
            background-image: none !important;
            border-color: #15a362 !important;
            text-shadow: none !important;
            color: #fff !important;
            box-shadow: none !important;
        }

        .introjs-donebutton:hover,
        .introjs-nextbutton:hover {
            background-color: #11824e !important;
            border-color: #11824e !important;
        }

        .introjs-prevbutton {
            text-shadow: none !important;
            box-shadow: none !important;
        }

        .introjs-bullets ul li a.active {
            background: #15a362 !important;
        }

        .introjs-tooltip {
            border: 2px solid #15a362 !important;
            border-radius: 8px !important;
            font-family: 'K2D', sans-serif !important;
        }

        .introjs-arrow.top-middle,
        .introjs-arrow.top,
        .introjs-arrow.top-right {
            border-bottom-color: #15a362 !important;
        }

        .introjs-arrow.bottom,
        .introjs-arrow.bottom-middle,
        .introjs-arrow.bottom-right {
            border-top-color: #15a362 !important;
        }

        .introjs-arrow.left,
        .introjs-arrow.left-bottom,
        .introjs-arrow.left-middle {
            border-right-color: #15a362 !important;
        }

        .introjs-arrow.right,
        .introjs-arrow.right-bottom,
        .introjs-arrow.right-middle {
            border-left-color: #15a362 !important;
        }
    </style>

    <!-- Header Section with Login Call-to-Action -->
    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div id="tourHeader">
            <h4 class="fw-bold py-2 mb-0" style="color: #1b5e20;">
                <span class="text-muted fw-light">วิชาการ /</span> ผลงานและรางวัลการแข่งขันของโรงเรียน
            </h4>
            <small class="text-muted">รวบรวมเกียรติยศและความภาคภูมิใจของบุคลากรและนักเรียน โรงเรียนสวนกุหลาบวิทยาลัย
                (จิรประวัติ) นครสวรรค์</small>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <button id="btnStartTour" class="btn btn-outline-success" style="color: #15a362; border-color: #15a362;">
                <i class="bx bx-help-circle me-1"></i> แนะนำการใช้งาน
            </button>
            <?php if (session()->get('login_id')): ?>
                <a id="btnDashboard" href="<?= base_url('admin/academic/competition') ?>" class="btn btn-success"
                    style="background-color: #15a362; border-color: #15a362;">
                    <i class="bx bx-dashboard me-1"></i> เข้าสู่หน้าจัดการผลงาน
                </a>
            <?php else: ?>
                <a id="btnLoginTeacher" href="<?= base_url('LoginTeacher') ?>" class="btn btn-primary">
                    <i class="bx bx-log-in-circle me-1"></i> เข้าสู่ระบบสำหรับครูเพื่อบันทึกผลงาน
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Filter & Statistics Cards -->
    <div class="row g-4 mb-4" id="tourStats">
        <!-- Card 1: จำนวนรายการแข่งขันทั้งหมด -->
        <div class="col-sm-6 col-md-4">
            <div class="card bg-white border-0 shadow-sm" style="border-left: 5px solid #15a362 !important;">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-light-success p-2 rounded me-3"
                            style="background-color: rgba(21, 163, 98, 0.1); color: #15a362;">
                            <i class="bx bx-trophy fs-3"></i>
                        </div>
                        <div>
                            <span class="d-block text-muted small">ผลงานทั้งหมด</span>
                            <h4 class="card-title mb-0 fw-bold"><?= count($competitions) ?> รายการ</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card 2: จำนวนประเภทงานแข่ง -->
        <div class="col-sm-6 col-md-4">
            <div class="card bg-white border-0 shadow-sm" style="border-left: 5px solid #ffb22b !important;">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-light-warning p-2 rounded me-3"
                            style="background-color: rgba(255, 178, 43, 0.1); color: #ffb22b;">
                            <i class="bx bx-star fs-3"></i>
                        </div>
                        <div>
                            <span class="d-block text-muted small">ปีการศึกษาล่าสุด</span>
                            <h4 class="card-title mb-0 fw-bold"><?= date('Y') + 543 ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Table -->
    <div class="card shadow-sm border-0" id="tourTableCard">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 fw-bold" style="color: #1b5e20;">ทำเนียบผลงานและรางวัลที่ได้รับ</h5>
        </div>
        <div class="table-responsive px-4 pb-4">
            <table class="table table-hover dt-responsive" id="publicTableCompetitions" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 45%;" class="all">กิจกรรม / รายการแข่งขัน</th>
                        <th style="width: 90px;" class="min-desktop">ปีการศึกษา</th>
                        <th style="width: 110px;" class="min-desktop">ระดับ</th>
                        <th style="width: 110px;" class="min-desktop">วันที่</th>
                        <th style="width: 120px;" class="all text-center">รายละเอียด</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <?php if (empty($competitions)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                ยังไม่มีการบันทึกผลงานการแข่งขันที่ได้รับการอนุมัติในระบบ</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($competitions as $comp): ?>
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark fs-6 text-truncate" style="max-width: 40vw;"
                                        title="<?= esc($comp->comp_activity) ?>">
                                        <?= esc($comp->comp_activity) ?>
                                    </div>
                                    <div class="fw-bold text-secondary text-truncate mt-1" style="max-width: 40vw; font-size: 0.9rem;"
                                        title="<?= esc($comp->comp_name) ?>">
                                        <i class="bx bx-trophy me-1 text-warning"></i><?= esc($comp->comp_name) ?>
                                    </div>
                                    <small class="text-muted text-truncate d-inline-block" style="max-width: 40vw;"
                                        title="<?= esc($comp->comp_location ?: '-') ?>">
                                        <i class="bx bx-map me-1"></i><?= esc($comp->comp_location ?: '-') ?>
                                    </small>
                                </td>
                                <td><?= esc($comp->comp_academic_year) ?>/<?= esc($comp->comp_term) ?></td>
                                <td>
                                    <span class="badge bg-label-success"
                                        style="color: #15a362; background-color: rgba(21, 163, 98, 0.1);"><?= esc($comp->comp_level) ?></span>
                                </td>
                                <td>
                                    <?php
                                    $d = strtotime($comp->comp_date);
                                    $y = date('Y', $d) + 543;
                                    echo date('d/m', $d) . '/' . $y;
                                    ?>
                                </td>
                                <td class="text-nowrap text-center">
                                    <button class="btn btn-sm btn-success btn-view-public-detail"
                                        data-id="<?= $comp->comp_id ?>"
                                        style="background-color: #15a362; border-color: #15a362;">
                                        <i class="bx bx-search-alt"></i> ดูข้อมูล
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal แสดงรายละเอียด (Public) -->
<div class="modal fade" id="modalPublicDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title d-flex align-items-center">
                    <i class="bx bx-trophy text-warning fs-3 me-2"></i> รายละเอียดผลการแข่งขันและรางวัลที่ได้รับ
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <h6 class="fw-bold mb-1">รายการหลัก:</h6>
                        <p id="pubDetName" class="fs-5 fw-semibold text-primary"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted d-block small">ประเภท/กิจกรรมย่อยที่แข่ง</label>
                        <span id="pubDetActivity" class="fw-bold"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted d-block small">ระดับการแข่งขัน</label>
                        <span id="pubDetLevel" class="badge bg-label-info"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted d-block small">วันที่จัดการแข่งขัน</label>
                        <span id="pubDetDate" class="fw-bold"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted d-block small">สถานที่ / หน่วยงานผู้จัด</label>
                        <span id="pubDetLocation" class="fw-bold"></span>
                    </div>
                    <div class="col-12">
                        <hr class="my-1">
                    </div>

                    <!-- รายชื่อผู้แข่ง -->
                    <div class="col-md-6">
                        <h6 class="fw-bold"><i class="bx bx-user me-1 text-success"></i> นักเรียนที่เข้าร่วมการแข่งขัน
                        </h6>
                        <ul class="list-group list-group-flush" id="pubDetStudents"></ul>
                    </div>

                    <!-- รายชื่อครู -->
                    <div class="col-md-6">
                        <h6 class="fw-bold"><i class="bx bx-user-voice me-1 text-success"></i> ครูผู้ดูแลและฝึกซ้อม</h6>
                        <ul class="list-group list-group-flush" id="pubDetTeachers"></ul>
                    </div>

                    <div class="col-12">
                        <hr class="my-1">
                    </div>

                    <!-- รางวัลที่ได้รับ -->
                    <div class="col-12">
                        <h6 class="fw-bold"><i class="bx bx-award me-1 text-warning"></i> รางวัลที่ได้รับ</h6>
                        <div id="pubDetAwards" class="d-flex flex-wrap gap-2"></div>
                    </div>

                    <!-- ภาพผลงานและเอกสาร -->
                    <div class="col-12">
                        <h6 class="fw-bold"><i class="bx bx-file me-1 text-info"></i> เกียรติบัตร & รูปภาพผลงาน</h6>
                        <div class="row g-2" id="pubDetMedia"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
            </div>
        </div>
    </div>
</div>

<!-- DataTable JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function openFileInNewTab(url) {
        window.open(url, '_blank');
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Initialize DataTable
        $('#publicTableCompetitions').DataTable({
            responsive: true,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/Thai.json"
            },
            order: [[3, 'desc']], // เรียงตามวันที่แข่งขันเป็นหลัก (คอลัมน์ที่ 3)
            columnDefs: [
                { orderable: false, targets: 4 } // ปิดเรียงลำดับปุ่มจัดการ/รายละเอียด (คอลัมน์ที่ 4)
            ]
        });

        const modalDetail = new bootstrap.Modal(document.getElementById('modalPublicDetail'));

        $(document).on('click', '.btn-view-public-detail', function () {
            const id = $(this).attr('data-id');

            fetch(`<?= base_url('admin/academic/competition/detail') ?>/${id}`)
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        const comp = data.comp;

                        document.getElementById('pubDetName').textContent = comp.comp_name;
                        document.getElementById('pubDetActivity').textContent = comp.comp_activity;
                        document.getElementById('pubDetLevel').textContent = comp.comp_level;
                        document.getElementById('pubDetDate').textContent = data.thaiDate;
                        document.getElementById('pubDetLocation').textContent = `${comp.comp_location || '-'} (${comp.comp_organizer || '-'})`;

                        const studentContainer = document.getElementById('pubDetStudents');
                        studentContainer.innerHTML = '';
                        if (data.students.length > 0) {
                            data.students.forEach(st => {
                                studentContainer.innerHTML += `
                                <li class="list-group-item px-0 py-1 d-flex align-items-center border-0">
                                    <i class="bx bx-chevron-right text-success me-1"></i>
                                    <span>${st.StudentCode} - ${st.StudentPrefix}${st.StudentFirstName} ${st.StudentLastName} (ม.${st.StudentClass}/${st.StudentNumber})</span>
                                </li>`;
                            });
                        } else {
                            studentContainer.innerHTML = '<li class="list-group-item text-muted px-0 py-1 border-0">ไม่มีข้อมูลรายชื่อ</li>';
                        }

                        const teacherContainer = document.getElementById('pubDetTeachers');
                        teacherContainer.innerHTML = '';
                        if (data.teachers.length > 0) {
                            data.teachers.forEach(t => {
                                teacherContainer.innerHTML += `
                                <li class="list-group-item px-0 py-1 d-flex align-items-center border-0">
                                    <i class="bx bx-chevron-right text-success me-1"></i>
                                    <span>${t.pers_prefix}${t.pers_firstname} ${t.pers_lastname}</span>
                                </li>`;
                            });
                        } else {
                            teacherContainer.innerHTML = '<li class="list-group-item text-muted px-0 py-1 border-0">ไม่มีข้อมูลรายชื่อ</li>';
                        }

                        const awardsContainer = document.getElementById('pubDetAwards');
                        awardsContainer.innerHTML = '';
                        if (data.awards.length > 0) {
                            data.awards.forEach(aw => {
                                awardsContainer.innerHTML += `<span class="badge bg-success" style="background-color: #15a362 !important; font-size: 0.9rem;"><i class="bx bx-trophy me-1"></i>${aw}</span>`;
                            });
                        } else {
                            awardsContainer.innerHTML = '<span class="text-muted">ไม่ระบุรางวัล</span>';
                        }

                        const mediaContainer = document.getElementById('pubDetMedia');
                        mediaContainer.innerHTML = '';

                        if (data.certs.length > 0) {
                            data.certs.forEach(file => {
                                const ext = file.split('.').pop().toLowerCase();
                                const isImg = ['jpg', 'jpeg', 'png', 'gif'].includes(ext);
                                const fileUrl = `https://skj.nsnpao.go.th/uploads/academic/competitions/certificates/${file}`;

                                mediaContainer.innerHTML += `
                                <div class="col-md-4 text-center border p-2 rounded bg-light">
                                    <div class="small fw-semibold mb-1 text-truncate">เกียรติบัตร</div>
                                    ${isImg ? `<img src="${fileUrl}" class="img-fluid rounded mb-2" style="max-height: 80px;">` : `<i class="bx bxs-file-pdf text-danger display-6 mb-2"></i>`}
                                    <a href="javascript:void(0)" onclick="openFileInNewTab('${fileUrl}')" class="btn btn-xs btn-outline-primary d-block w-100"><i class="bx bx-show me-1"></i>เปิดดูไฟล์</a>
                                </div>`;
                            });
                        }

                        if (data.images.length > 0) {
                            data.images.forEach(file => {
                                const fileUrl = `https://skj.nsnpao.go.th/uploads/academic/competitions/images/${file}`;
                                mediaContainer.innerHTML += `
                                <div class="col-md-4 text-center border p-2 rounded bg-light">
                                    <div class="small fw-semibold mb-1 text-truncate">ภาพกิจกรรม</div>
                                    <img src="${fileUrl}" class="img-fluid rounded mb-2" style="max-height: 80px; object-fit: cover; width: 100%;">
                                    <a href="javascript:void(0)" onclick="openFileInNewTab('${fileUrl}')" class="btn btn-xs btn-outline-primary d-block w-100"><i class="bx bx-zoom-in me-1"></i>ดูรูปใหญ่</a>
                                </div>`;
                            });
                        }

                        if (data.certs.length === 0 && data.images.length === 0) {
                            mediaContainer.innerHTML = '<div class="col-12 text-muted">ไม่มีไฟล์แนบและรูปภาพผลงาน</div>';
                        }

                        modalDetail.show();
                    } else {
                        Swal.fire({
                            title: 'เกิดข้อผิดพลาด',
                            text: 'ไม่สามารถดึงข้อมูลรายละเอียดได้',
                            icon: 'error',
                            confirmButtonColor: '#15a362'
                        });
                    }
                });
        });

        // Intro.js Guided Tour Initialization
        const btnStartTour = document.getElementById('btnStartTour');
        if (btnStartTour) {
            btnStartTour.addEventListener('click', function () {
                introJs().setOptions({
                    steps: [
                        {
                            title: '👋 ยินดีต้อนรับ!',
                            intro: 'นี่คือระบบทำเนียบผลงานการแข่งขันและรางวัลของโรงเรียนสวนกุหลาบวิทยาลัย ปทุมธานี ครับ'
                        },
                        {
                            element: '#tourHeader',
                            title: '📌 หน้าหลักผลงาน',
                            intro: 'ส่วนนี้จะแสดงภาพรวมและหัวข้อการทำรายการสืบค้นผลงานและรางวัลที่ได้รับการบันทึกในระบบครับ',
                            position: 'bottom'
                        },
                        {
                            element: document.getElementById('btnDashboard') || document.getElementById('btnLoginTeacher'),
                            title: '🔑 สำหรับคุณครูและบุคลากร',
                            intro: 'คุณครูสามารถกดเข้าสู่ระบบ หรือไปยังหน้าจัดการหลังบ้าน เพื่อเพิ่มข้อมูลกิจกรรมการแข่งขัน รูปภาพ และเกียรติบัตรผ่านส่วนนี้ได้ทันทีครับ',
                            position: 'bottom'
                        },
                        {
                            element: '#tourStats',
                            title: '📊 สถิติข้อมูล',
                            intro: 'แสดงสรุปจำนวนรายการแข่งขันทั้งหมดที่ได้รับการอนุมัติ และปีการศึกษาล่าสุดในระบบครับ',
                            position: 'bottom'
                        },
                        {
                            element: '#tourTableCard',
                            title: '🔍 ตารางทำเนียบเกียรติยศ',
                            intro: 'คุณสามารถค้นหาข้อมูลด้วยการพิมพ์คำค้นหา (เช่น ชื่อนักเรียน, ชื่อกิจกรรม, ปีการศึกษา) ในตารางนี้ได้แบบเรียลไทม์',
                            position: 'top'
                        },
                        {
                            element: document.querySelector('.btn-view-public-detail'),
                            title: '📄 ดูรายละเอียดเชิงลึก',
                            intro: 'หากต้องการดูรายชื่อนักเรียน ครูผู้ฝึกสอน ไฟล์เกียรติบัตร หรือภาพถ่ายกิจกรรม ให้คลิกที่ปุ่ม <strong>"ดูข้อมูล"</strong> นี้ได้เลยครับ',
                            position: 'left'
                        }
                    ],
                    nextLabel: 'ถัดไป ›',
                    prevLabel: '‹ ย้อนกลับ',
                    doneLabel: 'เสร็จสิ้น 🏁',
                    dontShowAgain: false
                }).start();
            });
        }
    });
</script>
<script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>

<?php if (session()->getFlashdata('error')): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: 'เกิดข้อผิดพลาด!',
                text: '<?= esc(session()->getFlashdata('error')) ?>',
                icon: 'error',
                confirmButtonText: 'ตกลง',
                confirmButtonColor: '#15a362'
            });
        });
    </script>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: 'สำเร็จ!',
                text: '<?= esc(session()->getFlashdata('success')) ?>',
                icon: 'success',
                confirmButtonText: 'ตกลง',
                confirmButtonColor: '#15a362'
            });
        });
    </script>
<?php endif; ?>

<?= $this->endSection() ?>