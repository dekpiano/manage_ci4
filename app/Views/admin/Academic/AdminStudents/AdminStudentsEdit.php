<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">จัดการนักเรียน /</span> แก้ไขข้อมูล
    </h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0 premium-card">
                <div class="card-header d-flex justify-content-between align-items-center bg-label-primary py-3">
                    <h5 class="mb-0 fw-bold"><i class="bx bx-user-edit me-1"></i> <?= esc($title) ?></h5>
                    <a href="<?= base_url('Admin/Acade/Registration/Students') ?>" class="btn btn-outline-primary btn-sm">
                        <i class="bx bx-arrow-back me-1"></i> กลับหน้าหลัก
                    </a>
                </div>
                <div class="card-body p-4">
                    <form id="editStudentFormIndividual" action="<?= base_url('Admin/Academic/ConAdminStudents/update_student_details') ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="StudentID" value="<?= $student->StudentID ?>">
                        <input type="hidden" name="StudentIDNumber" value="<?= $student->StudentIDNumber ?>">
                        
                        <!-- Include the form partial -->
                        <?= view('admin/Academic/AdminStudents/_student_details_form') ?>

                        <?php if (!empty($student->updated_at) || !empty($student->created_at)): ?>
                        <div class="alert alert-light border d-flex align-items-center gap-3 py-2 px-3 mt-4 mb-3" role="alert" style="font-size: 0.85rem;">
                            <i class='bx bx-history fs-4 text-secondary'></i>
                            <div>
                                <?php if (!empty($student->updated_at)): ?>
                                    <?php
                                        $updatedDt = new \DateTime($student->updated_at);
                                        $updatedBE = (int)$updatedDt->format('Y') + 543;
                                        $updatedStr = $updatedDt->format('d/m/') . $updatedBE . ' ' . $updatedDt->format('H:i') . ' น.';
                                    ?>
                                    <span class="text-muted">แก้ไขล่าสุด:</span>
                                    <strong><?= esc($updatedStr) ?></strong>
                                    <?php if (!empty($student->updated_by)): ?>
                                        <span class="text-muted">โดย</span>
                                        <span class="badge bg-label-primary"><?= esc($student->updated_by) ?></span>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if (!empty($student->created_at)): ?>
                                    <?php
                                        $createdDt = new \DateTime($student->created_at);
                                        $createdBE = (int)$createdDt->format('Y') + 543;
                                        $createdStr = $createdDt->format('d/m/') . $createdBE . ' ' . $createdDt->format('H:i') . ' น.';
                                    ?>
                                    <span class="ms-3 text-muted">สร้างเมื่อ:</span>
                                    <strong><?= esc($createdStr) ?></strong>
                                    <?php if (!empty($student->created_by)): ?>
                                        <span class="text-muted">โดย</span>
                                        <span class="badge bg-label-secondary"><?= esc($student->created_by) ?></span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">
                                <i class="bx bx-save me-1"></i> บันทึกการแก้ไขข้อมูล
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Function to fix floating labels for inputs wrapped by typeahead.js
    function updateFloatingLabels() {
        setTimeout(function() {
            $('.form-floating .twitter-typeahead .tt-input').each(function () {
                var $input = $(this);
                var $parent = $input.closest('.form-floating');
                if ($input.val() && $input.val().trim().length > 0) {
                    $parent.addClass('label-floated');
                } else {
                    $parent.removeClass('label-floated');
                }
            });
        }, 50);
    }

    // Initialize Thailand Address Autocomplete for Home Address
    $.Thailand({
        database: '<?= base_url('assets/database/db.json') ?>',
        $district: $('#stu_hTambon'),
        $amphoe: $('#stu_hDistrict'),
        $province: $('#stu_hProvince'),
        $zipcode: $('#stu_hPostCode'),
    });

    // Initialize Thailand Address Autocomplete for Current Address
    $.Thailand({
        database: '<?= base_url('assets/database/db.json') ?>',
        $district: $('#stu_cTumbao'),
        $amphoe: $('#stu_cDistrict'),
        $province: $('#stu_cProvince'),
        $zipcode: $('#stu_cPostcode'),
    });

    // Initialize Thailand Address Autocomplete for School Address
    $.Thailand({
        database: '<?= base_url('assets/database/db.json') ?>',
        $district: $('#stu_schoolTambao'),
        $amphoe: $('#stu_schoolDistrict'),
        $province: $('#stu_schoolProvince'),
    });

    // Handle floating labels for typeahead inputs
    updateFloatingLabels();
    $(document).on('keyup change typeahead:change typeahead:select', '.twitter-typeahead .tt-input', updateFloatingLabels);

    const editForm = document.getElementById('editStudentFormIndividual');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const origHtml = submitBtn ? submitBtn.innerHTML : '';
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> กำลังบันทึกข้อมูล...';
            }

            const formData = new FormData(this);
            
            Swal.fire({
                title: 'กำลังบันทึกข้อมูล...',
                html: '<div class="py-3"><div class="spinner-border text-primary" role="status"></div></div>',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => { Swal.showLoading(); }
            });

            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                Swal.close();
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ!',
                        text: 'แก้ไขข้อมูลนักเรียนเรียบร้อยแล้ว',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = origHtml;
                    }
                    Swal.fire('ผิดพลาด', data.message || 'บันทึกข้อมูลไม่สำเร็จ', 'error');
                }
            })
            .catch(error => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = origHtml;
                }
                console.error('Error:', error);
                Swal.fire('ผิดพลาด', 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์', 'error');
            });
        });
    }
});
</script>
<?= $this->endSection() ?>
