<?= $this->extend('user/layout/teacher_main') ?>

<?= $this->section('extra_css') ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Intro.js Styles -->
    <link rel="stylesheet" href="https://unpkg.com/intro.js/minified/introjs.min.css">
    <style>
        .introjs-donebutton, .introjs-nextbutton {
            background-color: #15a362 !important;
            background-image: none !important;
            border-color: #15a362 !important;
            text-shadow: none !important;
            color: #fff !important;
            box-shadow: none !important;
        }
        .introjs-donebutton:hover, .introjs-nextbutton:hover {
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
        .introjs-arrow.top-middle, .introjs-arrow.top, .introjs-arrow.top-right {
            border-bottom-color: #15a362 !important;
        }
        .introjs-arrow.bottom, .introjs-arrow.bottom-middle, .introjs-arrow.bottom-right {
            border-top-color: #15a362 !important;
        }
        .introjs-arrow.left, .introjs-arrow.left-bottom, .introjs-arrow.left-middle {
            border-right-color: #15a362 !important;
        }
        .introjs-arrow.right, .introjs-arrow.right-bottom, .introjs-arrow.right-middle {
            border-left-color: #15a362 !important;
        }
    </style>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div id="tourAdminHeader">
            <h4 class="fw-bold py-2 mb-0" style="color: #1b5e20;">
                <span class="text-muted fw-light">วิชาการ /</span> จัดการผลงานการแข่งขันของโรงเรียน
            </h4>
            <small class="text-muted">ระบบหลังบ้านสำหรับครูและผู้ดูแลระบบในการบันทึก อนุมัติ และปรับปรุงผลงาน</small>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <button id="btnStartAdminTour" class="btn btn-outline-success" style="color: #15a362; border-color: #15a362;">
                <i class="bx bx-help-circle me-1"></i> แนะนำการใช้งาน
            </button>
            <a id="btnCreateComp" href="<?= base_url('admin/academic/competition/create') ?>" class="btn btn-success" style="background-color: #15a362; border-color: #15a362;">
                <i class="bx bx-plus me-1"></i> บันทึกผลงานใหม่
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0" id="tourAdminTableCard">
        <div class="card-header d-flex justify-content-between align-items-center border-bottom mb-3 flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <h5 class="card-title mb-0">รายการบันทึกผลงานทั้งหมด</h5>
                <span class="badge bg-label-success fw-bold">
                    <i class="bx bx-calendar me-1"></i>ปีการศึกษา <?= get_selected_year() ?>
                </span>
            </div>
        </div>
        <div class="table-responsive px-4 pb-4">
            <table class="table table-hover dt-responsive" id="tableCompetitions" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 45%;" class="all">กิจกรรม / รายการแข่งขัน</th>
                        <th style="width: 90px;" class="min-desktop">ปีการศึกษา</th>
                        <th style="width: 110px;" class="min-desktop">ระดับ</th>
                        <th style="width: 110px;" class="min-desktop">วันที่แข่งขัน</th>
                        <th style="width: 120px;" class="min-desktop">สถานะ</th>
                        <th style="width: 220px;" class="all text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <?php if (!empty($competitions)): ?>
                        <?php foreach ($competitions as $comp): ?>
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark fs-6">
                                        <?= esc($comp->comp_activity) ?>
                                    </div>
                                    <div class="fw-bold text-secondary mt-1" style="font-size: 0.9rem;">
                                        <i class="bx bx-trophy me-1 text-warning"></i><?= esc($comp->comp_name) ?>
                                    </div>
                                    <small class="text-muted d-block">
                                        <i class="bx bx-map me-1"></i><?= esc($comp->comp_location ?: '-') ?>
                                    </small>
                                </td>
                                <td><?= esc($comp->comp_academic_year) ?>/<?= esc($comp->comp_term) ?></td>
                                <td>
                                    <span class="badge bg-label-info"><?= esc($comp->comp_level) ?></span>
                                </td>
                                <td>
                                    <?php 
                                        $d = strtotime($comp->comp_date);
                                        $y = date('Y', $d) + 543;
                                        echo date('d/m', $d) . '/' . $y;
                                    ?>
                                </td>
                                <td>
                                    <?php if ($comp->comp_status === 'อนุมัติแล้ว'): ?>
                                        <span class="badge bg-success" style="background-color: #15a362 !important;">อนุมัติแล้ว</span>
                                    <?php elseif ($comp->comp_status === 'ตีกลับ/แก้ไข'): ?>
                                        <span class="badge bg-danger">ตีกลับให้แก้ไข</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">รอการตรวจสอบ</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-success btn-view-detail" data-id="<?= $comp->comp_id ?>" style="background-color: #15a362; border-color: #15a362;" title="ดูรายละเอียด">
                                        <i class="bx bx-show me-1"></i> ดูข้อมูล
                                    </button>
                                    <a href="<?= base_url('admin/academic/competition/edit/' . $comp->comp_id) ?>" class="btn btn-sm btn-outline-warning" title="แก้ไข">
                                        <i class="bx bx-edit-alt me-1"></i> แก้ไข
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger btn-delete-comp" data-url="<?= base_url('admin/academic/competition/delete/' . $comp->comp_id) ?>" title="ลบ">
                                        <i class="bx bx-trash me-1"></i> ลบ
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

<!-- Modal รายละเอียดผลการแข่งขัน -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title d-flex align-items-center">
                    <i class="bx bx-trophy text-warning fs-3 me-2"></i> รายละเอียดผลการแข่งขัน
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <h6 class="fw-bold mb-1">รายการหลัก:</h6>
                        <p id="detName" class="fs-5 fw-semibold text-primary"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted d-block small">ประเภท/กิจกรรมย่อยที่แข่ง</label>
                        <span id="detActivity" class="fw-bold"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted d-block small">ระดับการแข่งขัน</label>
                        <span id="detLevel" class="badge bg-label-info"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted d-block small">วันที่จัดการแข่งขัน</label>
                        <span id="detDate" class="fw-bold"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted d-block small">สถานที่ / หน่วยงานผู้จัด</label>
                        <span id="detLocation" class="fw-bold"></span>
                    </div>
                    <div class="col-12"><hr class="my-1"></div>
                    
                    <!-- รายชื่อผู้แข่ง -->
                    <div class="col-md-6">
                        <h6 class="fw-bold"><i class="bx bx-user me-1 text-success"></i> นักเรียนที่เข้าร่วมการแข่งขัน</h6>
                        <ul class="list-group list-group-flush" id="detStudents"></ul>
                    </div>

                    <!-- รายชื่อครู -->
                    <div class="col-md-6">
                        <h6 class="fw-bold"><i class="bx bx-user-voice me-1 text-success"></i> ครูผู้ดูแลและฝึกซ้อม</h6>
                        <ul class="list-group list-group-flush" id="detTeachers"></ul>
                    </div>

                    <div class="col-12"><hr class="my-1"></div>

                    <!-- รางวัลที่ได้รับ -->
                    <div class="col-12">
                        <h6 class="fw-bold"><i class="bx bx-award me-1 text-warning"></i> รางวัลที่ได้รับ</h6>
                        <div id="detAwards" class="d-flex flex-wrap gap-2"></div>
                    </div>

                    <!-- ภาพผลงานและเอกสาร -->
                    <div class="col-12">
                        <h6 class="fw-bold"><i class="bx bx-file me-1 text-info"></i> เกียรติบัตร & รูปภาพผลงาน</h6>
                        <div class="row g-2" id="detMedia"></div>
                    </div>
                </div>

                <!-- แท็บตรวจสอบสถานะสำหรับผู้ดูแลระบบ -->
                <div class="card mt-4 border bg-light d-none" id="adminApprovalSection">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bx bx-shield-quarter me-1 text-danger"></i> เมนูการอนุมัติสำหรับผู้ดูแลระบบ</h6>
                        <form id="formStatusUpdate">
                            <?= csrf_field() ?>
                            <input type="hidden" name="comp_id" id="statusCompId">
                            <div class="row g-3">
                                <div class="col-md-5">
                                    <label class="form-label">ปรับเปลี่ยนสถานะ</label>
                                    <select class="form-select" name="comp_status" id="statusSelect">
                                        <option value="รออนุมัติ">รออนุมัติ</option>
                                        <option value="อนุมัติแล้ว">อนุมัติแล้ว</option>
                                        <option value="ตีกลับ/แก้ไข">ตีกลับให้แก้ไข</option>
                                    </select>
                                </div>
                                <div class="col-md-7">
                                    <label class="form-label">คำแนะนำเพิ่มเติม (กรณีตีกลับ)</label>
                                    <input type="text" class="form-control" name="comp_feedback" id="statusFeedback" placeholder="ระบุเหตุผลเพื่อปรับปรุงข้อมูล...">
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary" style="background-color: #15a362; border-color: #15a362;">บันทึกสถานะ</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
            </div>
        </div>
    </div>
</div>

<style>
/* บังคับ SweetAlert2 อยู่ระดับบนสุดตามกฎ UX */
.swal2-container {
    z-index: 9999 !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable
    const table = $('#tableCompetitions').DataTable({
        responsive: true,
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/Thai.json"
        },
        order: [[3, 'desc']], // เรียงตามวันที่แข่งขันเป็นหลัก (คอลัมน์ที่ 3)
        columnDefs: [
            { orderable: false, targets: 5 } // ปิดการกดเรียงลำดับในปุ่มการจัดการ (คอลัมน์ที่ 5)
        ]
    });

    const modalDetail = new bootstrap.Modal(document.getElementById('modalDetail'));
    
    // กำหนดปุ่มดูรายละเอียด (AJAX) ด้วย Event Delegation เพื่อให้สามารถคลิกได้เมื่อมีการแบ่งหน้าหรือค้นหา
    $(document).on('click', '.btn-view-detail', function() {
        const id = $(this).attr('data-id');
        
        fetch(`<?= base_url('admin/academic/competition/detail') ?>/${id}`)
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    const comp = data.comp;
                    
                    document.getElementById('detName').textContent = comp.comp_name;
                    document.getElementById('detActivity').textContent = comp.comp_activity;
                    document.getElementById('detLevel').textContent = comp.comp_level;
                    document.getElementById('detDate').textContent = data.thaiDate;
                    document.getElementById('detLocation').textContent = `${comp.comp_location || '-'} (${comp.comp_organizer || '-'})`;
                    
                    // นักเรียน
                    const studentContainer = document.getElementById('detStudents');
                    studentContainer.innerHTML = '';
                    if (data.students.length > 0) {
                        data.students.forEach(st => {
                            studentContainer.innerHTML += `
                                <li class="list-group-item px-0 py-1 d-flex align-items-center">
                                    <i class="bx bx-chevron-right text-success me-1"></i>
                                    <span>${st.StudentCode} - ${st.StudentPrefix}${st.StudentFirstName} ${st.StudentLastName} (ม.${st.StudentClass}/${st.StudentNumber})</span>
                                </li>`;
                        });
                    } else {
                        studentContainer.innerHTML = '<li class="list-group-item text-muted px-0 py-1">ไม่มีข้อมูลรายชื่อ</li>';
                    }

                    // ครู
                    const teacherContainer = document.getElementById('detTeachers');
                    teacherContainer.innerHTML = '';
                    if (data.teachers.length > 0) {
                        data.teachers.forEach(t => {
                            teacherContainer.innerHTML += `
                                <li class="list-group-item px-0 py-1 d-flex align-items-center">
                                    <i class="bx bx-chevron-right text-success me-1"></i>
                                    <span>${t.pers_prefix}${t.pers_firstname} ${t.pers_lastname}</span>
                                </li>`;
                        });
                    } else {
                        teacherContainer.innerHTML = '<li class="list-group-item text-muted px-0 py-1">ไม่มีข้อมูลรายชื่อ</li>';
                    }

                    // รางวัล
                    const awardsContainer = document.getElementById('detAwards');
                    awardsContainer.innerHTML = '';
                    if (data.awards.length > 0) {
                        data.awards.forEach(aw => {
                            awardsContainer.innerHTML += `<span class="badge bg-success" style="background-color: #15a362 !important; font-size: 0.9rem;"><i class="bx bx-trophy me-1"></i>${aw}</span>`;
                        });
                    } else {
                        awardsContainer.innerHTML = '<span class="text-muted">ไม่ระบุรางวัล</span>';
                    }

                    // สื่อและไฟล์แนบ
                    const mediaContainer = document.getElementById('detMedia');
                    mediaContainer.innerHTML = '';
                    
                    // แสดงเกียรติบัตร
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

                    // แสดงภาพกิจกรรม
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

                    // แสดงส่วนการอนุมัติสำหรับผู้ดูแลระบบ
                    const adminSec = document.getElementById('adminApprovalSection');
                    <?php 
                    if (in_array($userStatus, ['admin', 'manager', 'superadmin'])): 
                    ?>
                    adminSec.classList.remove('d-none');
                    document.getElementById('statusCompId').value = comp.comp_id;
                    document.getElementById('statusSelect').value = comp.comp_status;
                    document.getElementById('statusFeedback').value = comp.comp_feedback || '';
                    <?php else: ?>
                    adminSec.classList.add('d-none');
                    <?php endif; ?>

                    modalDetail.show();
                } else {
                    Swal.fire({
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถดึงข้อมูลรายการนี้ได้',
                        icon: 'error',
                        confirmButtonColor: '#15a362'
                    });
                }
            })
            .catch(err => {
                console.error(err);
            });
    });

    // การส่งข้อมูลอนุมัติของ Admin
    const formStatus = document.getElementById('formStatusUpdate');
    formStatus.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('<?= base_url('admin/academic/competition/update-status') ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    title: 'สำเร็จ!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonColor: '#15a362'
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    title: 'เกิดข้อผิดพลาด',
                    text: data.message,
                    icon: 'error',
                    confirmButtonColor: '#15a362'
                });
            }
        });
    });

    // ฟังก์ชันลบรายการแข่งขัน ด้วย Event Delegation
    $(document).on('click', '.btn-delete-comp', function() {
        const url = $(this).attr('data-url');
        Swal.fire({
            title: 'ยืนยันการลบข้อมูล?',
            text: "ข้อมูลนี้จะถูกลบออกจากระบบอย่างถาวรและไม่สามารถกู้คืนได้!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#15a362',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'ใช่, ต้องการลบ!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });

    // Intro.js Admin Tour
    const btnStartAdminTour = document.getElementById('btnStartAdminTour');
    if (btnStartAdminTour) {
        btnStartAdminTour.addEventListener('click', function() {
            const steps = [
                {
                    title: '🔑 ระบบจัดการผลงานการแข่งขัน',
                    intro: 'ยินดีต้อนรับเข้าสู่หน้ารวมและจัดการข้อมูลผลการแข่งขันหลังบ้านครับ'
                },
                {
                    element: '#tourAdminHeader',
                    title: '📌 ภาพรวมระบบจัดการ',
                    intro: 'หน้านี้ใช้สำหรับให้คุณครูและผู้ดูแลระบบทำการเพิ่มข้อมูล อนุมัติ หรือตีกลับผลงานที่ส่งเข้ามาแก้ไขครับ',
                    position: 'bottom'
                },
                {
                    element: '#btnCreateComp',
                    title: '➕ บันทึกผลงานการแข่งขันใหม่',
                    intro: 'หากต้องการบันทึกข้อมูลการแข่งขันของนักเรียนเพิ่มเติม ให้กดที่ปุ่มนี้เพื่อเปิดฟอร์มสำหรับกรอกข้อมูลและระบุเกียรติบัตรครับ',
                    position: 'bottom'
                },
                {
                    element: '#tourAdminTableCard',
                    title: '📂 ตารางรายการผลงานทั้งหมด',
                    intro: 'ตารางรวบรวมรายการที่คุณครูบันทึกเข้ามา พร้อมคอลัมน์สถานะ (อนุมัติแล้ว/รอตรวจสอบ/ตีกลับให้แก้ไข)',
                    position: 'top'
                }
            ];

            if (document.querySelector('.btn-view-detail')) {
                steps.push({
                    element: document.querySelector('.btn-view-detail'),
                    title: '👁️ ดูข้อมูลเชิงลึก',
                    intro: 'คลิกเพื่อตรวจสอบรายละเอียดการแข่งขัน รายชื่อผู้เข้าร่วม เกียรติบัตร และภาพประกอบ (สำหรับ Admin จะสามารถอนุมัติหรือตีกลับจากตรงนี้ได้)',
                    position: 'bottom'
                });
            }
            if (document.querySelector('.btn-outline-warning')) {
                steps.push({
                    element: document.querySelector('.btn-outline-warning'),
                    title: '✏️ แก้ไขข้อมูล',
                    intro: 'คลิกที่ปุ่มนี้เพื่อเข้าไปปรับปรุงรายละเอียด หรือแก้ไขรายการการแข่งขันที่ถูกตีกลับ',
                    position: 'bottom'
                });
            }
            if (document.querySelector('.btn-outline-danger')) {
                steps.push({
                    element: document.querySelector('.btn-outline-danger'),
                    title: '🗑️ ลบรายการ',
                    intro: 'หากบันทึกข้อมูลผิดพลาดและต้องการเอาออกจากระบบ สามารถใช้ปุ่มนี้ในการลบข้อมูลได้ครับ (ต้องได้รับการยืนยันอีกครั้ง)',
                    position: 'bottom'
                });
            }

            introJs().setOptions({
                steps: steps,
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
<?= $this->endSection() ?>
