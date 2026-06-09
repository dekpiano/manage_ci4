<?= $this->extend('user/layout/teacher_main') ?>

<?= $this->section('extra_css') ?>
<!-- Select2 CSS และ Custom CSS เพื่อให้เข้ากับธีม Sneat และสีเขียว #15a362 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

<style>
    /* ปรับแต่งปุ่มและสีหลักของเว็บเป็นสีเขียว #15a362 */
    .btn-success {
        background-color: #15a362 !important;
        border-color: #15a362 !important;
    }
    .btn-success:hover, .btn-success:focus {
        background-color: #11824e !important;
        border-color: #11824e !important;
    }
    .text-success {
        color: #15a362 !important;
    }
    .border-success {
        border-color: #15a362 !important;
    }
    
    /* ปรับแต่ง Select2 ให้กลมกลืนกับ Sneat */
    .select2-container--bootstrap-5 {
        width: 100% !important;
    }
    .select2-container--bootstrap-5 .select2-selection {
        border: 1px solid #d9dee3 !important;
        border-radius: 0.375rem !important;
        height: 38px !important;
        font-family: inherit;
        background-color: #fff;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        line-height: 36px !important;
        color: #697a8d !important;
        padding-left: 0.875rem !important;
    }
    .select2-container--bootstrap-5 .select2-selection--single {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23697a8d' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
        background-position: right 0.875rem center !important;
        background-size: 10px 12px !important;
    }
    .select2-container--bootstrap-5.select2-container--focus .select2-selection {
        border-color: #15a362 !important;
        box-shadow: 0 0 0.25rem rgba(21, 163, 98, 0.25) !important;
    }

    /* สไตล์การ์ดผู้เข้าร่วม (นักเรียน/ครู) */
    .participant-card {
        background: #fcfdfd;
        border: 1px solid #e4e6e8;
        border-radius: 0.5rem;
        padding: 1.25rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .participant-item {
        background-color: #ffffff;
        border: 1px solid #e4e6e8;
        border-radius: 0.375rem;
        padding: 8px 12px;
        transition: all 0.2s ease;
    }
    .participant-item:hover {
        border-color: rgba(21, 163, 98, 0.4);
        box-shadow: 0 2px 6px rgba(21, 163, 98, 0.08);
    }

    /* Drag and Drop Zone styling */
    .upload-zone {
        border: 2px dashed #15a362;
        background-color: #f7fcf9;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
        cursor: pointer;
        padding: 2.5rem 1.5rem;
    }
    .upload-zone:hover, .upload-zone.dragover {
        background-color: rgba(21, 163, 98, 0.08);
        border-color: #11824e;
    }
    .file-preview-item {
        background: #fff;
        border: 1px solid rgba(21, 163, 98, 0.15);
        border-radius: 0.25rem;
        padding: 8px 12px;
        margin-top: 5px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">วิชาการ / <a href="<?= base_url('admin/academic/competition') ?>" class="text-success">ผลงานการแข่งขัน</a> /</span> 
        <?= esc($title) ?>
    </h4>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center border-bottom py-3">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bx bx-edit me-1 text-success fs-4"></i> ฟอร์มบันทึกผลงานการแข่งขัน</h5>
                </div>
                <div class="card-body pt-4">
                    <form id="FormCompetition" action="<?= $action ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="row g-4">
                            <!-- ชื่องานแข่งขัน -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark" for="comp_name">ชื่องานการแข่งขัน/รายการหลัก <span class="text-danger">*</span></label>
                                <input type="text" id="comp_name" name="comp_name" class="form-control" placeholder="เช่น การแข่งขันศิลปหัตถกรรมนักเรียน ครั้งที่ 71" value="<?= old('comp_name', $comp ? $comp->comp_name : '') ?>" required>
                            </div>

                            <!-- ประเภทกิจกรรมที่แข่ง -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark" for="comp_activity">กิจกรรมย่อย/สาขาที่แข่ง <span class="text-danger">*</span></label>
                                <input type="text" id="comp_activity" name="comp_activity" class="form-control" placeholder="เช่น การแข่งขันเขียนโปรแกรมคอมพิวเตอร์ ระดับ ม.ปลาย" value="<?= old('comp_activity', $comp ? $comp->comp_activity : '') ?>" required>
                            </div>

                            <!-- ระดับการแข่งขัน -->
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-dark" for="comp_level">ระดับการแข่งขัน <span class="text-danger">*</span></label>
                                <select id="comp_level" name="comp_level" class="form-select" required>
                                    <option value="ระดับเขตพื้นที่" <?= old('comp_level', $comp ? $comp->comp_level : '') === 'ระดับเขตพื้นที่' ? 'selected' : '' ?>>ระดับเขตพื้นที่</option>
                                    <option value="ระดับจังหวัด" <?= old('comp_level', $comp ? $comp->comp_level : '') === 'ระดับจังหวัด' ? 'selected' : '' ?>>ระดับจังหวัด</option>
                                    <option value="ระดับภาค" <?= old('comp_level', $comp ? $comp->comp_level : '') === 'ระดับภาค' ? 'selected' : '' ?>>ระดับภาค</option>
                                    <option value="ระดับชาติ" <?= old('comp_level', $comp ? $comp->comp_level : '') === 'ระดับชาติ' ? 'selected' : '' ?>>ระดับชาติ</option>
                                    <option value="ระดับนานาชาติ" <?= old('comp_level', $comp ? $comp->comp_level : '') === 'ระดับนานาชาติ' ? 'selected' : '' ?>>ระดับนานาชาติ</option>
                                </select>
                            </div>

                            <!-- วันที่แข่งขัน -->
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-dark" for="comp_date">วันที่แข่งขัน <span class="text-danger">*</span></label>
                                <input type="text" id="comp_date" name="comp_date" class="form-control flatpickr-date" placeholder="เลือกวันที่แข่งขัน" value="<?= old('comp_date', $comp ? $comp->comp_date : '') ?>" required>
                            </div>

                            <!-- ปีการศึกษา -->
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-dark" for="comp_academic_year">ปีการศึกษา พ.ศ. <span class="text-danger">*</span></label>
                                <input type="number" id="comp_academic_year" name="comp_academic_year" class="form-control" placeholder="เช่น 2569" min="2500" max="2700" value="<?= old('comp_academic_year', $comp ? $comp->comp_academic_year : date('Y')+543) ?>" required>
                            </div>

                            <!-- ภาคเรียน -->
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-dark" for="comp_term">ภาคเรียนที่ <span class="text-danger">*</span></label>
                                <select id="comp_term" name="comp_term" class="form-select" required>
                                    <option value="1" <?= old('comp_term', $comp ? $comp->comp_term : '') === '1' ? 'selected' : '' ?>>1</option>
                                    <option value="2" <?= old('comp_term', $comp ? $comp->comp_term : '') === '2' ? 'selected' : '' ?>>2</option>
                                </select>
                            </div>

                            <!-- สถานที่ -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark" for="comp_location">สถานที่จัดการแข่งขัน</label>
                                <input type="text" id="comp_location" name="comp_location" class="form-control" placeholder="เช่น โรงเรียนสามโคก จังหวัดปทุมธานี" value="<?= old('comp_location', $comp ? $comp->comp_location : '') ?>">
                            </div>

                            <!-- หน่วยงานผู้จัด -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark" for="comp_organizer">หน่วยงานผู้จัดงาน</label>
                                <input type="text" id="comp_organizer" name="comp_organizer" class="form-control" placeholder="เช่น สำนักงานเขตพื้นที่การศึกษามัธยมศึกษา" value="<?= old('comp_organizer', $comp ? $comp->comp_organizer : '') ?>">
                            </div>

                            <!-- ข้อคิดเห็นการปฏิเสธ (กรณีตีกลับ) -->
                            <?php if ($comp && $comp->comp_status === 'ตีกลับ/แก้ไข'): ?>
                                <div class="col-12">
                                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                                        <i class="bx bx-error me-2 fs-4"></i>
                                        <div>
                                            <h6 class="alert-heading fw-bold mb-1">รายการนี้ถูกตีกลับให้แก้ไขโดยผู้ตรวจสอบ</h6>
                                            <span>ข้อเสนอแนะ: <strong><?= esc($comp->comp_feedback) ?></strong></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="col-12"><hr class="my-2 text-muted"></div>

                            <!-- รายชื่อรางวัลที่ได้ (Dynamic) -->
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold text-dark mb-0"><i class="bx bx-award text-success me-1 fs-4"></i> รางวัลที่ได้รับ</h6>
                                    <button type="button" class="btn btn-sm btn-outline-success" id="btnAddAward"><i class="bx bx-plus me-1"></i> เพิ่มช่องผลรางวัล</button>
                                </div>
                                <div id="awardContainer">
                                    <?php 
                                        $awards = $comp ? json_decode($comp->comp_awards, true) : [];
                                        if (empty($awards)) $awards = [''];
                                        foreach ($awards as $idx => $aw):
                                    ?>
                                        <div class="d-flex mb-2 award-row">
                                            <input type="text" name="comp_awards[]" class="form-control me-2" placeholder="ระบุรางวัลที่ได้ เช่น รางวัลชนะเลิศ เหรียญทอง หรือ เข้าร่วมการแข่งขัน" value="<?= esc($aw) ?>" required>
                                            <button type="button" class="btn btn-outline-danger btn-remove-row"><i class="bx bx-trash"></i></button>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="col-12"><hr class="my-2 text-muted"></div>

                            <!-- ดีไซน์ส่วนนักเรียนแบบ Card -->
                            <div class="col-md-6">
                                <div class="participant-card">
                                    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                                        <span class="fw-bold text-dark fs-6"><i class="bx bx-face text-success me-1 fs-4"></i> นักเรียนที่เข้าแข่งขัน</span>
                                        <button type="button" class="btn btn-xs btn-success text-white px-2 py-1" id="btnAddStudent"><i class="bx bx-plus-circle me-1"></i> เพิ่ม</button>
                                    </div>
                                    <div id="studentContainer" class="d-flex flex-column gap-2">
                                        <?php 
                                            $stList = isset($selectedStudents) ? $selectedStudents : [];
                                            if (empty($stList)):
                                        ?>
                                            <div class="d-flex participant-item align-items-center">
                                                <div class="flex-grow-1 me-2">
                                                    <select name="comp_student_ids[]" class="form-select select2-student" required></select>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-label-danger btn-remove-row p-2"><i class="bx bx-trash fs-5"></i></button>
                                            </div>
                                        <?php else: ?>
                                            <?php foreach ($stList as $st): ?>
                                                <div class="d-flex participant-item align-items-center">
                                                    <div class="flex-grow-1 me-2">
                                                        <select name="comp_student_ids[]" class="form-select select2-student" required>
                                                            <option value="<?= $st->StudentID ?>" selected><?= $st->StudentCode ?> - <?= $st->StudentPrefix ?><?= $st->StudentFirstName ?> <?= $st->StudentLastName ?> ชั้น <?= $st->StudentClass ?></option>
                                                        </select>
                                                    </div>
                                                    <button type="button" class="btn btn-sm btn-label-danger btn-remove-row p-2"><i class="bx bx-trash fs-5"></i></button>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- ดีไซน์ส่วนครูแบบ Card -->
                            <div class="col-md-6">
                                <div class="participant-card">
                                    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                                        <span class="fw-bold text-dark fs-6"><i class="bx bx-user-voice text-success me-1 fs-4"></i> ครูผู้ฝึกซ้อม/ผู้ควบคุม</span>
                                        <button type="button" class="btn btn-xs btn-success text-white px-2 py-1" id="btnAddTeacher"><i class="bx bx-plus-circle me-1"></i> เพิ่ม</button>
                                    </div>
                                    <div id="teacherContainer" class="d-flex flex-column gap-2">
                                        <?php 
                                            $tList = isset($selectedTeachers) ? $selectedTeachers : [];
                                            if (empty($tList)):
                                        ?>
                                            <div class="d-flex participant-item align-items-center">
                                                <div class="flex-grow-1 me-2">
                                                    <select name="comp_teacher_ids[]" class="form-select select2-teacher" required></select>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-label-danger btn-remove-row p-2"><i class="bx bx-trash fs-5"></i></button>
                                            </div>
                                        <?php else: ?>
                                            <?php foreach ($tList as $t): ?>
                                                <div class="d-flex participant-item align-items-center">
                                                    <div class="flex-grow-1 me-2">
                                                        <select name="comp_teacher_ids[]" class="form-select select2-teacher" required>
                                                            <option value="<?= $t->pers_id ?>" selected><?= $t->pers_prefix ?><?= $t->pers_firstname ?> <?= $t->pers_lastname ?></option>
                                                        </select>
                                                    </div>
                                                    <button type="button" class="btn btn-sm btn-label-danger btn-remove-row p-2"><i class="bx bx-trash fs-5"></i></button>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12"><hr class="my-2 text-muted"></div>

                            <!-- อัปโหลดเกียรติบัตร (ลากวาง) -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">เกียรติบัตรที่ได้รับ (ลากมาวางหรือคลิกเพื่ออัปโหลด)</label>
                                <div class="upload-zone text-center" id="dropzoneCert">
                                    <i class="bx bx-cloud-upload text-success fs-1 mb-2"></i>
                                    <h6 class="mb-1 text-dark fw-semibold">ลากไฟล์เกียรติบัตรมาวางที่นี่</h6>
                                    <p class="text-muted small mb-2">หรือคลิกเพื่อเลือกไฟล์ (รองรับ PDF, รูปภาพ)</p>
                                    <input type="file" id="certificate_files" name="certificate_files[]" class="d-none" multiple>
                                    <button type="button" class="btn btn-sm btn-outline-success btn-browse" onclick="document.getElementById('certificate_files').click();">เลือกไฟล์</button>
                                </div>
                                <div class="file-preview-container mt-2" id="previewCert"></div>
                                <?php if ($comp && $comp->comp_certificate_files): ?>
                                    <div class="mt-2 text-muted small">
                                        มีไฟล์เกียรติบัตรเดิมแล้ว <?= count(json_decode($comp->comp_certificate_files)) ?> ไฟล์ (อัปโหลดใหม่จะแนบต่อเพิ่ม)
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- อัปโหลดรูปภาพกิจกรรม (ลากวาง) -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">รูปภาพประกอบกิจกรรมผลงาน (ลากมาวางหรือคลิกเพื่ออัปโหลด)</label>
                                <div class="upload-zone text-center" id="dropzoneImages">
                                    <i class="bx bx-images text-success fs-1 mb-2"></i>
                                    <h6 class="mb-1 text-dark fw-semibold">ลากไฟล์รูปภาพมาวางที่นี่</h6>
                                    <p class="text-muted small mb-2">หรือคลิกเพื่อเลือกรูปภาพ (รองรับ JPG, PNG)</p>
                                    <input type="file" id="comp_images" name="comp_images[]" class="d-none" accept="image/*" multiple>
                                    <button type="button" class="btn btn-sm btn-outline-success btn-browse" onclick="document.getElementById('comp_images').click();">เลือกไฟล์</button>
                                </div>
                                <div class="file-preview-container mt-2" id="previewImages"></div>
                                <?php if ($comp && $comp->comp_images): ?>
                                    <div class="mt-2 text-muted small">
                                        มีภาพกิจกรรมเดิมแล้ว <?= count(json_decode($comp->comp_images)) ?> ภาพ (อัปโหลดใหม่จะแนบต่อเพิ่ม)
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-12 text-end mt-4">
                                <a href="<?= base_url('admin/academic/competition') ?>" class="btn btn-outline-secondary me-2">ยกเลิก</a>
                                <button type="submit" class="btn btn-success"><i class="bx bx-save me-1"></i> บันทึกข้อมูล</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<!-- ใช้ jQuery ของ layout หลัก และโหลด Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // ฟังก์ชันสร้างการค้นหาแบบ Select2 สำหรับช่องนักเรียน
    function initStudentSelect2(element) {
        $(element).select2({
            theme: 'bootstrap-5',
            placeholder: 'ค้นหาชื่อนักเรียน หรือ รหัสประจำตัว...',
            minimumInputLength: 2,
            width: '100%',
            ajax: {
                url: '<?= base_url('admin/academic/competition/search-students') ?>',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term // คีย์เวิร์ดค้นหา
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    }

    // ฟังก์ชันสร้างการค้นหาแบบ Select2 สำหรับช่องครู
    function initTeacherSelect2(element) {
        $(element).select2({
            theme: 'bootstrap-5',
            placeholder: 'ค้นหาชื่อครู/บุคลากร...',
            minimumInputLength: 2,
            width: '100%',
            ajax: {
                url: '<?= base_url('admin/academic/competition/search-teachers') ?>',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    }

    // บังคับทำ Select2 กับช่องที่มีอยู่ตอนเริ่มต้น
    $('.select2-student').each(function() {
        initStudentSelect2(this);
    });
    $('.select2-teacher').each(function() {
        initTeacherSelect2(this);
    });

    // ลบแถว (สำหรับรางวัล, นักเรียน, ครู)
    $(document).on('click', '.btn-remove-row', function() {
        const row = $(this).closest('.student-row, .teacher-row, .award-row, .participant-item');
        const container = row.parent();
        // ถ้าเป็นแถวสุดท้าย ไม่ยอมให้ลบ
        if (container.children().length > 1) {
            row.remove();
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'ไม่สามารถลบได้',
                text: 'ต้องมีรายการอย่างน้อย 1 รายการ',
                confirmButtonColor: '#15a362'
            });
        }
    });

    // เพิ่มช่องรางวัล
    $('#btnAddAward').click(function() {
        const html = `
            <div class="d-flex mb-2 award-row">
                <input type="text" name="comp_awards[]" class="form-control me-2" placeholder="ระบุรางวัลที่ได้ เช่น รางวัลชนะเลิศ เหรียญทอง หรือ เข้าร่วมการแข่งขัน" required>
                <button type="button" class="btn btn-outline-danger btn-remove-row"><i class="bx bx-trash"></i></button>
            </div>
        `;
        $('#awardContainer').append(html);
    });

    // เพิ่มช่องนักเรียน
    $('#btnAddStudent').click(function() {
        const newRow = $(`
            <div class="d-flex participant-item align-items-center">
                <div class="flex-grow-1 me-2">
                    <select name="comp_student_ids[]" class="form-select select2-student" required></select>
                </div>
                <button type="button" class="btn btn-sm btn-label-danger btn-remove-row p-2"><i class="bx bx-trash fs-5"></i></button>
            </div>
        `);
        $('#studentContainer').append(newRow);
        initStudentSelect2(newRow.find('.select2-student'));
    });

    // เพิ่มช่องครู
    $('#btnAddTeacher').click(function() {
        const newRow = $(`
            <div class="d-flex participant-item align-items-center">
                <div class="flex-grow-1 me-2">
                    <select name="comp_teacher_ids[]" class="form-select select2-teacher" required></select>
                </div>
                <button type="button" class="btn btn-sm btn-label-danger btn-remove-row p-2"><i class="bx bx-trash fs-5"></i></button>
            </div>
        `);
        $('#teacherContainer').append(newRow);
        initTeacherSelect2(newRow.find('.select2-teacher'));
    });

    // จัดการ Drag & Drop ไฟล์
    function setupDragAndDrop(zoneId, inputId, previewId) {
        const dropZone = document.getElementById(zoneId);
        const fileInput = document.getElementById(inputId);
        const previewContainer = $('#' + previewId);

        if (!dropZone || !fileInput) return;

        // ดักจับเหตุการณ์ Drag Over
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('dragover');
        });

        // ดักจับเหตุการณ์ Drag Leave
        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('dragover');
        });

        // ดักจับเหตุการณ์ Drop
        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files; // มอบหมายไฟล์ให้กับ input
                updateFilePreview(fileInput, previewContainer);
            }
        });

        // ดักจับเมื่อเลือกไฟล์ด้วยการ Browse ปกติ
        fileInput.addEventListener('change', () => {
            updateFilePreview(fileInput, previewContainer);
        });
    }

    // อัปเดตรายชื่อไฟล์ที่ถูกเลือกเข้าใน UI Preview
    function updateFilePreview(input, $previewContainer) {
        $previewContainer.empty();
        const files = input.files;
        if (files.length > 0) {
            const listHtml = $('<div class="d-flex flex-column gap-1"></div>');
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                listHtml.append(`
                    <div class="file-preview-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bx bx-file me-1 text-success"></i>
                            <span class="fw-semibold text-dark">${file.name}</span>
                            <span class="text-muted small ms-2">(${(file.size / 1024).toFixed(1)} KB)</span>
                        </div>
                        <i class="bx bx-check-circle text-success fs-5"></i>
                    </div>
                `);
            }
            $previewContainer.append(listHtml);
        }
    }

    // เริ่มทำงานระบบลากวาง
    setupDragAndDrop('dropzoneCert', 'certificate_files', 'previewCert');
    setupDragAndDrop('dropzoneImages', 'comp_images', 'previewImages');

    // เรียกใช้งาน Flatpickr สไตล์ Sneat (แสดงผลปี พ.ศ.)
    if (typeof flatpickr !== 'undefined') {
        flatpickr(".flatpickr-date", {
            dateFormat: "Y-m-d", // บันทึกเป็น ค.ศ. (ISO) ไปยังฐานข้อมูล
            altInput: true,      // เปิดการแสดงผลแบบทางเลือก
            altFormat: "d/m/Y",  // รูปแบบ วัน/เดือน/ปีพ.ศ.
            locale: "th",
            allowInput: true,
            monthSelectorType: "static",
            onOpen: function(selectedDates, dateStr, instance) {
                updateCalendarToBE(instance);
            },
            onMonthChange: function(selectedDates, dateStr, instance) {
                setTimeout(() => updateCalendarToBE(instance), 0);
            },
            onYearChange: function(selectedDates, dateStr, instance) {
                setTimeout(() => updateCalendarToBE(instance), 0);
            },
            formatDate: function(date, format, locale) {
                if (format === "d/m/Y") {
                    const d = date.getDate().toString().padStart(2, '0');
                    const m = (date.getMonth() + 1).toString().padStart(2, '0');
                    const y = date.getFullYear() + 543; // แปลงเป็น พ.ศ.
                    return `${d}/${m}/${y}`;
                }
                return flatpickr.formatDate(date, format, locale);
            },
            parseDate: function(dateStr, format) {
                if (dateStr && dateStr.includes('/')) {
                    const parts = dateStr.split('/');
                    if (parts.length === 3) {
                        const d = parseInt(parts[0], 10);
                        const m = parseInt(parts[1], 10) - 1;
                        const y = parseInt(parts[2], 10) - 543; // แปลงกลับเป็น ค.ศ.
                        return new Date(y, m, d);
                    }
                }
                return flatpickr.parseDate(dateStr, format);
            }
        });

        // ฟังก์ชันช่วยเปลี่ยนตัวเลขปีในหัวปฏิทิน Flatpickr ให้เป็น พ.ศ.
        function updateCalendarToBE(instance) {
            setTimeout(() => {
                const yearDisplay = instance.calendarContainer.querySelector(".flatpickr-current-month .cur-year");
                if (yearDisplay) {
                    const year = parseInt(instance.currentYear);
                    if (year < 2400) {
                        if (yearDisplay.tagName === "INPUT") {
                            yearDisplay.value = year + 543;
                        } else {
                            yearDisplay.textContent = year + 543;
                        }
                    }
                }
                const yearInput = instance.calendarContainer.querySelector(".numInput.cur-year");
                if (yearInput) {
                    const year = parseInt(instance.currentYear);
                    if (year < 2400) {
                        yearInput.value = year + 543;
                    }
                }
            }, 5);
        }
    }

    // ฟังก์ชันย่อยอัปเดตอัปโหลดชิ้นส่วนแบบ Chunk
    function uploadFileInChunks(file, path, progressCallback) {
        return new Promise((resolve, reject) => {
            const chunkSize = 200 * 1024; // ปรับลดขนาดชิ้นส่วนเป็น 200KB เพื่อให้ผ่านขีดจำกัดได้ง่ายขึ้น
            const fileSize = file.size;
            const totalChunks = Math.ceil(fileSize / chunkSize);
            let currentChunk = 0;
            
            // สร้างชื่อไฟล์ที่ปลอดภัยและไม่ซ้ำกัน
            const fileExt = file.name.split('.').pop().toLowerCase();
            const originalBase = file.name.substring(0, file.name.lastIndexOf('.'));
            const safeBase = originalBase.replace(/[^\w-]/g, '_').replace(/_+/g, '_');
            const fileName = (safeBase || 'file') + '-' + Date.now() + '-' + Math.random().toString(36).substring(2, 7) + '.' + fileExt;

            function uploadNext() {
                const start = currentChunk * chunkSize;
                const end = Math.min(start + chunkSize, fileSize);
                const chunk = file.slice(start, end);

                const formData = new FormData();
                formData.append('file', chunk, fileName);
                formData.append('filename', fileName);
                formData.append('chunk_index', currentChunk);
                formData.append('total_chunks', totalChunks);
                formData.append('path', path);

                // CSRF Token
                const csrfTokenName = '<?= csrf_token() ?>';
                const csrfTokenValue = $('input[name="' + csrfTokenName + '"]').val() || '<?= csrf_hash() ?>';
                formData.append(csrfTokenName, csrfTokenValue);

                const percent = Math.round((currentChunk / totalChunks) * 100);
                if (progressCallback) {
                    progressCallback(percent, currentChunk + 1, totalChunks);
                }

                $.ajax({
                    url: '<?= base_url('admin/academic/competition/upload_proxy') ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 'chunk_saved') {
                            currentChunk++;
                            uploadNext();
                        } else if (res.status === 'success' && res.filename) {
                            if (progressCallback) {
                                progressCallback(100, totalChunks, totalChunks);
                            }
                            resolve(res.filename);
                        } else {
                            reject(res.message || 'เกิดข้อผิดพลาดในการอัปโหลดไฟล์');
                        }
                    },
                    error: function(xhr, status, error) {
                        reject('HTTP ' + xhr.status + ': ' + (xhr.responseText || error));
                    }
                });
            }

            uploadNext();
        });
    }

    // ฟังก์ชันจัดการส่งคำขออัปโหลดไฟล์ทั้งหมดทีละไฟล์
    async function uploadAllFiles(files, path, label, progressUpdate) {
        const uploadedNames = [];
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const filename = await uploadFileInChunks(file, path, (percent, chunk, total) => {
                progressUpdate(`กำลังอัปโหลด ${label} ไฟล์ที่ ${i + 1}/${files.length}: ${file.name}<br>ชิ้นส่วนที่ ${chunk}/${total} (${percent}%)`);
            });
            uploadedNames.push(filename);
        }
        return uploadedNames;
    }

    // ฟังก์ชันช่วยย่อขนาดและบีบอัดรูปภาพ
    function compressImage(file) {
        return new Promise((resolve) => {
            if (!file.type.startsWith('image/')) {
                resolve(file); // ส่งกลับไฟล์เดิมถ้าไม่ใช่รูปภาพ (เช่น PDF)
                return;
            }

            const img = new Image();
            const objectUrl = URL.createObjectURL(file);
            img.onload = function() {
                URL.revokeObjectURL(objectUrl);
                const maxWidth = 1200; // จำกัดความกว้างสูงสุด 1200px (ลดเพื่อประหยัดพื้นที่และผ่านขีดจำกัด)
                let w = img.width, h = img.height;
                if (w > maxWidth) {
                    h = Math.round(h * (maxWidth / w));
                    w = maxWidth;
                }
                const canvas = document.createElement('canvas');
                canvas.width = w;
                canvas.height = h;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, w, h);
                canvas.toBlob(function(blob) {
                    if (blob) {
                        // คงชื่อไฟล์เดิมไว้
                        blob.name = file.name;
                        resolve(blob);
                    } else {
                        resolve(file);
                    }
                }, 'image/jpeg', 0.70); // บีบอัดคุณภาพรูป JPEG เป็น 70%
            };
            img.onerror = function() {
                URL.revokeObjectURL(objectUrl);
                resolve(file);
            };
            img.src = objectUrl;
        });
    }

    // จัดการการส่งฟอร์มหลักด้วย AJAX และระบบอัปโหลดชิ้นส่วน
    $(document).on('submit', '#FormCompetition', function(e) {
        e.preventDefault();
        const form = this;
        const submitBtn = $(form).find('button[type="submit"]');
        const originalBtnHtml = submitBtn.html();

        const certFilesInput = document.getElementById('certificate_files');
        const compImagesInput = document.getElementById('comp_images');

        const certFiles = certFilesInput.files || [];
        const imageFiles = compImagesInput.files || [];

        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>กำลังส่งข้อมูล...');

        Swal.fire({
            title: 'กำลังเตรียมระบบอัปโหลด...',
            html: '<div class="py-3"><div class="spinner-border text-success" style="width: 3rem; height: 3rem;"></div><p class="mt-2 text-dark">ระบบกำลังตรวจเช็คไฟล์...</p></div>',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: async () => {
                try {
                    let uploadedCertificates = [];
                    let uploadedImages = [];

                    // 1. อัปโหลดเกียรติบัตร (ถ้ามี)
                    if (certFiles.length > 0) {
                        const processedCertFiles = [];
                        for (let i = 0; i < certFiles.length; i++) {
                            Swal.update({
                                html: `<div class="py-3"><div class="spinner-border text-success mb-2" style="width: 3rem; height: 3rem;"></div><p class="mt-2 text-dark fw-semibold">กำลังตรวจสอบ/บีบอัดเกียรติบัตรใบที่ ${i+1}/${certFiles.length}...</p></div>`
                            });
                            const processed = await compressImage(certFiles[i]);
                            processedCertFiles.push(processed);
                        }

                        uploadedCertificates = await uploadAllFiles(
                            processedCertFiles, 
                            'academic/competitions/certificates', 
                            'เกียรติบัตร', 
                            (htmlContent) => {
                                Swal.update({
                                    html: '<div class="py-3"><div class="spinner-border text-success mb-2" style="width: 3rem; height: 3rem;"></div><p class="mt-2 text-dark fw-semibold">' + htmlContent + '</p></div>'
                                });
                            }
                        );
                    }

                    // 2. อัปโหลดรูปภาพกิจกรรม (ถ้ามี)
                    if (imageFiles.length > 0) {
                        const processedImageFiles = [];
                        for (let i = 0; i < imageFiles.length; i++) {
                            Swal.update({
                                html: `<div class="py-3"><div class="spinner-border text-success mb-2" style="width: 3rem; height: 3rem;"></div><p class="mt-2 text-dark fw-semibold">กำลังตรวจสอบ/บีบอัดรูปภาพกิจกรรมรูปที่ ${i+1}/${imageFiles.length}...</p></div>`
                            });
                            const processed = await compressImage(imageFiles[i]);
                            processedImageFiles.push(processed);
                        }

                        uploadedImages = await uploadAllFiles(
                            processedImageFiles, 
                            'academic/competitions/images', 
                            'รูปภาพกิจกรรม', 
                            (htmlContent) => {
                                Swal.update({
                                    html: '<div class="py-3"><div class="spinner-border text-success mb-2" style="width: 3rem; height: 3rem;"></div><p class="mt-2 text-dark fw-semibold">' + htmlContent + '</p></div>'
                                });
                            }
                        );
                    }

                    Swal.update({
                        html: '<div class="py-3"><div class="spinner-border text-success mb-2" style="width: 3rem; height: 3rem;"></div><p class="mt-2 text-dark fw-semibold">อัปโหลดไฟล์เสร็จสิ้น กำลังบันทึกข้อมูลเข้าระบบ...</p></div>'
                    });

                    // 3. ส่งข้อมูลฟอร์มหลักไปยัง Database
                    const dbFormData = new FormData(form);
                    dbFormData.delete('certificate_files[]');
                    dbFormData.delete('comp_images[]');
                    
                    dbFormData.append('comp_certificate_files', JSON.stringify(uploadedCertificates));
                    dbFormData.append('comp_images', JSON.stringify(uploadedImages));

                    $.ajax({
                        url: $(form).attr('action'),
                        type: 'POST',
                        data: dbFormData,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function(response) {
                            Swal.close();
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'สำเร็จ!',
                                    text: response.message || 'บันทึกข้อมูลสำเร็จ',
                                    confirmButtonColor: '#15a362'
                                }).then(() => {
                                    window.location.href = '<?= base_url('admin/academic/competition') ?>';
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'เกิดข้อผิดพลาด!',
                                    text: response.message || 'ไม่สามารถบันทึกข้อมูลได้',
                                    confirmButtonColor: '#dc3545'
                                });
                                submitBtn.prop('disabled', false).html(originalBtnHtml);
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.close();
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด!',
                                text: 'ไม่สามารถบันทึกข้อมูลเข้าระบบหลักได้: ' + error,
                                confirmButtonColor: '#dc3545'
                            });
                            submitBtn.prop('disabled', false).html(originalBtnHtml);
                        }
                    });

                } catch (uploadError) {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'การอัปโหลดไฟล์ล้มเหลว!',
                        html: '<p>เกิดข้อผิดพลาดระหว่างอัปโหลดไฟล์: </p><pre style="text-align:left;font-size:11px;max-height:200px;overflow:auto;background:#f5f5f5;padding:8px;border-radius:4px;">' + uploadError + '</pre>',
                        confirmButtonColor: '#dc3545'
                    });
                    submitBtn.prop('disabled', false).html(originalBtnHtml);
                }
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
