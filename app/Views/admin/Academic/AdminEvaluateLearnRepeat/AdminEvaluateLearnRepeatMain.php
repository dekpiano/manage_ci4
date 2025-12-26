<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">วิชาการ /</span> <?= esc($title); ?>
            </h4>
        </div>
        <div class="col-md-6 text-md-end">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-md-end mb-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('Admin/Home'); ?>">หน้าหลัก</a></li>
                    <li class="breadcrumb-item active"><?= esc($title); ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <?php
    $onoff_status = $repeat_setting->onoff_status ?? 'off';
    $onoff_detail = $repeat_setting->onoff_detail ?? '';
    $onoff_year = $repeat_setting->onoff_year ?? '-';
    ?>

    <!-- Status Overview Cards -->
    <div class="row mb-4 g-4">
        <div class="col-md-4">
            <div class="card h-100 border-start border-<?= $onoff_status == 'on' ? 'success' : 'danger' ?> border-3 shadow-none bg-label-<?= $onoff_status == 'on' ? 'success' : 'danger' ?>">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded bg-<?= $onoff_status == 'on' ? 'success' : 'danger' ?>">
                                <i class="bx <?= $onoff_status == 'on' ? 'bx-check-circle' : 'bx-x-circle' ?> fs-4"></i>
                            </span>
                        </div>
                        <h6 class="mb-0">สถานะระบบ</h6>
                    </div>
                    <div class="d-flex align-items-baseline gap-1">
                        <h4 class="mb-0 text-<?= $onoff_status == 'on' ? 'success' : 'danger' ?>"><?= $onoff_status == 'on' ? 'เปิดใช้งาน' : 'ปิดใช้งาน' ?></h4>
                    </div>
                    <p class="mb-0 mt-1 text-muted small">ระบบบันทึกคะแนนเรียนซ้ำ</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-start border-primary border-3 shadow-none bg-label-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded bg-primary">
                                <i class="bx bx-calendar fs-4"></i>
                            </span>
                        </div>
                        <h6 class="mb-0">ปีการศึกษาปัจจุบัน</h6>
                    </div>
                    <div class="d-flex align-items-baseline gap-1">
                        <h4 class="mb-0 text-primary"><?= esc($onoff_year) ?></h4>
                    </div>
                    <p class="mb-0 mt-1 text-muted small">เทอม/ปีการศึกษาที่กำลังดำเนินการ</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-start border-warning border-3 shadow-none bg-label-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-3">
                            <span class="avatar-initial rounded bg-warning">
                                <i class="bx bx-recode fs-4"></i>
                            </span>
                        </div>
                        <h6 class="mb-0">รายการความซ้ำ</h6>
                    </div>
                    <div class="d-flex align-items-baseline gap-1">
                        <h4 class="mb-0 text-warning"><?= esc($onoff_detail) ?></h4>
                    </div>
                    <p class="mb-0 mt-1 text-muted small">จำนวนครั้งที่ประกาศให้เรียนซ้ำ</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Configuration Form -->
    <div class="row h-100">
        <div class="col-md-12 h-100">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between border-bottom mb-4">
                    <h5 class="card-title m-0 me-2"><i class="bx bx-cog me-2 text-primary"></i>แผงควบคุมการตั้งค่าระบบ</h5>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                            <a class="dropdown-item" href="javascript:location.reload();">ล้างข้อมูล/รีเฟรช</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="formSettings">
                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline">
                                    <select name="CheckOnoffRepeat" id="CheckOnoffRepeat" class="form-select">
                                        <option <?= $onoff_status == "on" ? "selected" : "" ?> value="on">เปิดระบบ (On)</option>
                                        <option <?= $onoff_status == "off" ? "selected" : "" ?> value="off">ปิดระบบ (Off)</option>
                                    </select>
                                    <label for="CheckOnoffRepeat">สถานะการบันทึกคะแนน</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline">
                                    <select name="onoff_year" id="onoff_year" class="form-select">
                                        <?php foreach ($CountYear as $key => $value) : ?>
                                            <option <?= $onoff_year == $value->RegisterYear ? "selected" : "" ?> value="<?= esc($value->RegisterYear) ?>"><?= esc($value->RegisterYear) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="onoff_year">ปีการศึกษาที่ดำเนินการ</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline">
                                    <select name="CheckTimeRepeat" id="CheckTimeRepeat" class="form-select">
                                        <option <?= $onoff_detail == "เรียนซ้ำครั้งที่ 1" ? "selected" : "" ?> value="เรียนซ้ำครั้งที่ 1">เรียนซ้ำครั้งที่ 1</option>
                                        <option <?= $onoff_detail == "เรียนซ้ำครั้งที่ 2" ? "selected" : "" ?> value="เรียนซ้ำครั้งที่ 2">เรียนซ้ำครั้งที่ 2</option>
                                        <option <?= $onoff_detail == "เรียนซ้ำครั้งที่ 3" ? "selected" : "" ?> value="เรียนซ้ำครั้งที่ 3">เรียนซ้ำครั้งที่ 3</option>
                                    </select>
                                    <label for="CheckTimeRepeat">เงื่อนไขการเรียนซ้ำ</label>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-primary d-flex align-items-center" role="alert">
                            <span class="alert-icon me-2">
                                <i class="bx bx-info-circle fs-4"></i>
                            </span>
                            <div>
                                <strong>แจ้งเตือน:</strong> การเปลี่ยนการตั้งค่าจะมีผลต่อการแสดงผลรายชื่อนักเรียนและการบันทึกคะแนนในหน้ากรอกคะแนนเรียนซ้ำทันที
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Potential Table (Hidden by user preference but styled for Sneat) -->
    <?php if (0): ?>
        <div class="row mt-4 h-100">
            <div class="col-12 h-100">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-uppercase fw-bold"><i class="bx bx-table me-2"></i>รายชื่อรายวิชาที่มีนักเรียนเรียนซ้ำ</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-hover" id="Tb_Repeat">
                                <thead>
                                    <tr>
                                        <th class="text-center">ปีการศึกษา</th>
                                        <th class="text-center">ระดับชั้น</th>
                                        <th>รายวิชา</th>
                                        <th>ครูผู้สอน (เรียนซ้ำ)</th>
                                        <th class="text-center">การจัดการ</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    <?php if (!empty($DataRepeat)): ?>
                                        <?php foreach ($DataRepeat as $key => $v_result) : ?>
                                            <tr>
                                                <td class="text-center"><span class="badge bg-label-secondary"><?= isset($v_result->RegisterYear) ? esc($v_result->RegisterYear) : '' ?></span></td>
                                                <td class="text-center fw-semibold"><?= isset($v_result->RegisterClass) ? esc($v_result->RegisterClass) : '' ?></td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span class="text-dark fw-bold"><?= isset($v_result->SubjectCode) ? esc($v_result->SubjectCode) : '' ?></span>
                                                        <small class="text-muted"><?= isset($v_result->SubjectName) ? esc($v_result->SubjectName) : '' ?></small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class='bx bx-user-circle fs-4 me-2 text-primary'></i>
                                                        <span><?= isset($v_result->pers_prefix) ? esc($v_result->pers_prefix . $v_result->pers_firstname . ' ' . $v_result->pers_lastname) : '' ?></span>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?php
                                                                $parts = explode('/', $v_result->RegisterYear);
                                                                echo site_url('Admin/Acade/Evaluate/AcademicRepeat/' . ($parts[0] ?? '') . '/' . ($parts[1] ?? '') . '/' . (isset($v_result->SubjectID) ? esc($v_result->SubjectID, 'url') : ''));
                                                                ?>" class="btn btn-icon btn-outline-warning">
                                                        <i class="bx bx-edit-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center p-5">
                                                <i class="bx bx-search-alt fs-1 d-block mb-3 text-muted"></i>
                                                <span class="text-muted">ไม่พบข้อมูลรายวิชาเรียนซ้ำในปีการศึกษานี้</span>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        // Sort academic year dropdown
        var $onoffYearSelect = $('#onoff_year');
        var options = $onoffYearSelect.find('option').get();

        options.sort(function(a, b) {
            var aVal = a.value.split('/');
            var bVal = b.value.split('/');

            var aTerm = parseInt(aVal[0]);
            var aYear = parseInt(aVal[1]);
            var bTerm = parseInt(bVal[0]);
            var bYear = parseInt(bVal[1]);

            if (aYear !== bYear) {
                return aYear - bYear; // Sort by year first
            }
            return aTerm - bTerm; // Then by term
        });

        $onoffYearSelect.empty().append(options);

        $('#Tb_Repeat').DataTable({
            "responsive": true,
            "autoWidth": false,
            "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.13.7/i18n/Thai.json"
            }
        });

        // Handle settings changes and save to database
        $('#CheckOnoffRepeat, #onoff_year, #CheckTimeRepeat').on('change', function() {
            var status = $('#CheckOnoffRepeat').val();
            var year = $('#onoff_year').val();
            var time = $('#CheckTimeRepeat').val();

            // Show loading overlay
            Swal.fire({
                title: 'กำลังบันทึกการตั้งค่า...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });

            $.ajax({
                url: '<?= site_url('Admin/Acade/Evaluate/update_repeat_settings') ?>',
                type: 'POST',
                data: {
                    setting_status: status,
                    setting_year: year,
                    setting_time: time
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ!',
                        text: 'บันทึกการตั้งค่าระบบเรียบร้อยแล้ว',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด!',
                        text: 'ไม่สามารถเชื่อมต่อกับฐานข้อมูลได้ กรุณาลองใหม่ภายหลัง',
                        confirmButtonColor: '#3085d6'
                    });
                    console.error('Error updating settings:', error);
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>