<?= $this->extend('user/layout/main') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header Section with Login Call-to-Action -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold py-2 mb-0" style="color: #1b5e20;">
                <span class="text-muted fw-light">วิชาการ /</span> ผลงานและรางวัลการแข่งขันของโรงเรียน
            </h4>
            <small class="text-muted">รวบรวมเกียรติยศและความภาคภูมิใจของบุคลากรและนักเรียน โรงเรียนสวนกุหลาบวิทยาลัย ปทุมธานี</small>
        </div>
        <div>
            <?php if (session()->get('login_id')): ?>
                <a href="<?= base_url('admin/academic/competition') ?>" class="btn btn-success" style="background-color: #15a362; border-color: #15a362;">
                    <i class="bx bx-dashboard me-1"></i> เข้าสู่หน้าจัดการผลงาน
                </a>
            <?php else: ?>
                <a href="<?= base_url('LoginTeacher') ?>" class="btn btn-primary">
                    <i class="bx bx-log-in-circle me-1"></i> เข้าสู่ระบบสำหรับครูเพื่อบันทึกผลงาน
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Filter & Statistics Cards -->
    <div class="row g-4 mb-4">
        <!-- Card 1: จำนวนรายการแข่งขันทั้งหมด -->
        <div class="col-sm-6 col-md-4">
            <div class="card bg-white border-0 shadow-sm" style="border-left: 5px solid #15a362 !important;">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-light-success p-2 rounded me-3" style="background-color: rgba(21, 163, 98, 0.1); color: #15a362;">
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
                        <div class="avatar bg-light-warning p-2 rounded me-3" style="background-color: rgba(255, 178, 43, 0.1); color: #ffb22b;">
                            <i class="bx bx-star fs-3"></i>
                        </div>
                        <div>
                            <span class="d-block text-muted small">ปีการศึกษาล่าสุด</span>
                            <h4 class="card-title mb-0 fw-bold"><?= date('Y')+543 ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 fw-bold" style="color: #1b5e20;">ทำเนียบผลงานและรางวัลที่ได้รับ</h5>
        </div>
        <div class="table-responsive text-nowrap px-4 pb-4">
            <table class="table table-hover" id="publicTableCompetitions">
                <thead>
                    <tr>
                        <th style="width: 80px;">ปีการศึกษา</th>
                        <th>รายการแข่งขันหลัก</th>
                        <th>กิจกรรม/ประเภทที่แข่งขัน</th>
                        <th>ระดับ</th>
                        <th>วันที่</th>
                        <th style="width: 100px;" class="text-center">รายละเอียด</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <?php if (empty($competitions)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">ยังไม่มีการบันทึกผลงานการแข่งขันที่ได้รับการอนุมัติในระบบ</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($competitions as $comp): ?>
                            <tr>
                                <td><?= esc($comp->comp_academic_year) ?>/<?= esc($comp->comp_term) ?></td>
                                <td>
                                    <div class="fw-bold text-dark"><?= esc($comp->comp_name) ?></div>
                                    <small class="text-muted"><i class="bx bx-map me-1"></i><?= esc($comp->comp_location ?: '-') ?></small>
                                </td>
                                <td><?= esc($comp->comp_activity) ?></td>
                                <td>
                                    <span class="badge bg-label-success" style="color: #15a362; background-color: rgba(21, 163, 98, 0.1);"><?= esc($comp->comp_level) ?></span>
                                </td>
                                <td>
                                    <?php 
                                        $d = strtotime($comp->comp_date);
                                        $y = date('Y', $d) + 543;
                                        echo date('d/m', $d) . '/' . $y;
                                    ?>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-success btn-view-public-detail" data-id="<?= $comp->comp_id ?>" style="background-color: #15a362; border-color: #15a362;">
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
                    <div class="col-12"><hr class="my-1"></div>
                    
                    <!-- รายชื่อผู้แข่ง -->
                    <div class="col-md-6">
                        <h6 class="fw-bold"><i class="bx bx-user me-1 text-success"></i> นักเรียนที่เข้าร่วมการแข่งขัน</h6>
                        <ul class="list-group list-group-flush" id="pubDetStudents"></ul>
                    </div>

                    <!-- รายชื่อครู -->
                    <div class="col-md-6">
                        <h6 class="fw-bold"><i class="bx bx-user-voice me-1 text-success"></i> ครูผู้ดูแลและฝึกซ้อม</h6>
                        <ul class="list-group list-group-flush" id="pubDetTeachers"></ul>
                    </div>

                    <div class="col-12"><hr class="my-1"></div>

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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.btn-view-public-detail');
    const modalDetail = new bootstrap.Modal(document.getElementById('modalPublicDetail'));
    
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            
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
                        
                        // นักเรียน
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

                        // ครู
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

                        // รางวัล
                        const awardsContainer = document.getElementById('pubDetAwards');
                        awardsContainer.innerHTML = '';
                        if (data.awards.length > 0) {
                            data.awards.forEach(aw => {
                                awardsContainer.innerHTML += `<span class="badge bg-success" style="background-color: #15a362 !important; font-size: 0.9rem;"><i class="bx bx-trophy me-1"></i>${aw}</span>`;
                            });
                        } else {
                            awardsContainer.innerHTML = '<span class="text-muted">ไม่ระบุรางวัล</span>';
                        }

                        // สื่อและไฟล์แนบ
                        const mediaContainer = document.getElementById('pubDetMedia');
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
                                        <a href="${fileUrl}" target="_blank" class="btn btn-xs btn-outline-primary d-block w-100"><i class="bx bx-download me-1"></i>เปิดดูไฟล์</a>
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
                                        <a href="${fileUrl}" target="_blank" class="btn btn-xs btn-outline-primary d-block w-100"><i class="bx bx-zoom-in me-1"></i>ดูรูปใหญ่</a>
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
    });
});
</script>
<?= $this->endSection() ?>
