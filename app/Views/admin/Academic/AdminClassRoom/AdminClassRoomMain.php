<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
.stat-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}
.stat-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    font-size: 1.5rem;
}
.stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    line-height: 1.2;
}
.stat-label {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 4px;
}
.ss-main .ss-single-selected {
    height: 40px;
}
</style>

<div class="container-xl py-3">
    <!-- Page Header -->
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="page-title mb-0">
                <i class="bx bx-building-house me-2"></i>จัดการข้อมูล<?= isset($title) ? esc($title) : '' ?>
            </h1>
            <p class="text-muted mb-0 mt-1">ปีการศึกษา: <strong id="header-selected-year"><?= isset($selectedYear) ? esc($selectedYear) : '' ?></strong></p>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" id="ModalAddClassRoom" data-bs-toggle="modal" data-bs-target="#myModal"> 
                <i class="bx bx-plus-circle me-1"></i> เพิ่ม<?= isset($title) ? esc($title) : '' ?>
            </button>
        </div>
    </div>

    <!-- Dashboard Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Classrooms Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-primary" id="stat-classrooms"><?= isset($total_classrooms) ? number_format($total_classrooms) : 0 ?></div>
                            <div class="stat-label">ห้องเรียนทั้งหมด</div>
                        </div>
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bx bx-chalkboard"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted" id="stat-year-text"><i class="bx bx-calendar me-1"></i>ในปีการศึกษา <?= isset($selectedYear) ? esc($selectedYear) : '-' ?></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Level Heads Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-warning" id="stat-level-heads"><?= isset($total_level_heads) ? number_format($total_level_heads) : 0 ?></div>
                            <div class="stat-label">ครูหัวหน้าระดับ</div>
                        </div>
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bx bx-crown"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted"><i class="bx bx-group me-1"></i>มอบหมายแล้ว</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Advisors Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-info" id="stat-advisors"><?= isset($total_advisors) ? number_format($total_advisors) : 0 ?></div>
                            <div class="stat-label">ครูที่ปรึกษา</div>
                        </div>
                        <div class="stat-icon bg-info bg-opacity-10 text-info">
                            <i class="bx bx-user-voice"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted"><i class="bx bx-check-circle me-1"></i>ได้รับมอบหมาย</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Selected Year Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-value text-success" id="stat-selected-year"><?= isset($selectedYear) ? esc($selectedYear) : '-' ?></div>
                            <div class="stat-label">ปีการศึกษาที่เลือก</div>
                        </div>
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="bx bx-calendar-check"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted"><i class="bx bx-list-check me-1"></i><span id="stat-total-records"><?= isset($total_records) ? number_format($total_records) : 0 ?> รายการทั้งหมด</span></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Section -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-list-ul me-2"></i>รายการห้องเรียน / ที่ปรึกษา
                    </h5>
                </div>
                <div class="col-auto">
                    <div class="d-flex align-items-center gap-2">
                        <label for="yearFilter" class="form-label mb-0 fw-medium">ปีการศึกษา:</label>
                        <select class="form-select form-select-sm" id="yearFilter" style="width: auto; min-width: 120px;">
                            <?php if (!empty($years)): ?>
                                <?php foreach ($years as $year): ?>
                                    <option value="<?= $year->Reg_Year ?>" <?= ($year->Reg_Year == $selectedYear) ? 'selected' : '' ?>>
                                        <?= $year->Reg_Year ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php elseif(isset($selectedYear)): ?>
                                <option value="<?= $selectedYear ?>" selected><?= $selectedYear ?></option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <input type="hidden" class="csrf_token" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="tb-classroom">
                    <thead class="table-light">
                        <tr>
                            <th>ปีการศึกษา</th>
                            <th>ห้องเรียน</th>
                            <th>ครูที่ปรึกษา / ครูหัวหน้าระดับ</th>
                            <th class="text-center">คำสั่ง</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $tea = []; foreach ($classRoom as $key => $v_classRoom) : 
                            $tea[] = isset($v_classRoom->class_teacher) ? $v_classRoom->class_teacher : '';
                        ?>
                        <tr id="row-<?= isset($v_classRoom->regclass_id) ? esc($v_classRoom->regclass_id) : '' ?>">
                            <td><?= isset($v_classRoom->Reg_Year) ? esc($v_classRoom->Reg_Year) : '' ?></td>
                            <td>
                                <?php if(isset($v_classRoom->Reg_Class) && strlen($v_classRoom->Reg_Class) == 1) : ?>
                                    <span class="badge bg-warning text-dark"><i class="bx bx-crown me-1"></i>หัวหน้าระดับ ม. <?= esc($v_classRoom->Reg_Class) ?></span>
                                <?php else : ?>
                                    <span class="badge bg-primary"><i class="bx bx-chalkboard me-1"></i>ห้อง ม.<?= isset($v_classRoom->Reg_Class) ? esc($v_classRoom->Reg_Class) : '' ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?= (isset($v_classRoom->pers_prefix) ? esc($v_classRoom->pers_prefix) : '').(isset($v_classRoom->pers_firstname) ? esc($v_classRoom->pers_firstname) : '').' '.(isset($v_classRoom->pers_lastname) ? esc($v_classRoom->pers_lastname) : '') ?></td>
                            <td class="text-center"><button class="btn btn-danger btn-sm btn-delete" data-id="<?= isset($v_classRoom->regclass_id) ? esc($v_classRoom->regclass_id, 'url') : '' ?>"><i class="bx bx-trash me-1"></i>ลบ</button></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

        <!-- The Modal -->
        <div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">เพิ่ม<?= isset($title) ? esc($title) : '' ?></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form id="AddClassRoom" action="#" method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">ปีการศึกษา <?php $d= (date('Y')+543)-1;?></label>
                                <select name="year" id="year" class="form-control">
                                    <?php for($i=$d; $i<=$d+2; $i++) : ?>
                                    <option <?=$i==date('Y')+543 ? 'selected' : ''?>><?= esc($i) ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="classroom">ห้องเรียน / ระดับชั้น</label>
                               
                                <select name="classroom" id="classroom" class="" required>
                                    <option value="1">หัวหน้าระดับชั้น ม.1</option>
                                    <option value="2">หัวหน้าระดับชั้น ม.2</option>
                                    <option value="3">หัวหน้าระดับชั้น ม.3</option>
                                    <option value="4">หัวหน้าระดับชั้น ม.4</option>
                                    <option value="5">หัวหน้าระดับชั้น ม.5</option>
                                    <option value="6">หัวหน้าระดับชั้น ม.6</option>
                                <?php 
                                if (!isset($classroom)) {
                                    $classroom = new App\Libraries\Classroom();
                                }
                                foreach ($classroom->ListRoom() as $key => $ListRoom) : ?>                                    
                                <option value="<?= esc($ListRoom) ?>">ที่ปรึกษาห้อง <?= esc($ListRoom) ?></option>
                                <?php endforeach; ?>
                                </select>
                              
                            </div>
                            <div class="mb-3">
                                <label for="teacher">ครูที่ปรึกษา / ครูหัวหน้าระดับ</label>
                                <select name="teacher" id="teacher" class="" required >

                                    <option value=''>เลือกครูที่ปรึกษา</option>
                                    <?php foreach ($NameTeacher as $key => $v_NameTeacher) : ?>
                               
                                    <option value="<?= isset($v_NameTeacher->pers_id) ? esc($v_NameTeacher->pers_id) : '' ?>">
                                        <?= (isset($v_NameTeacher->pers_prefix) ? esc($v_NameTeacher->pers_prefix) : '').(isset($v_NameTeacher->pers_firstname) ? esc($v_NameTeacher->pers_firstname) : '').' '.(isset($v_NameTeacher->pers_lastname) ? esc($v_NameTeacher->pers_lastname) : '') ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">                       
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
  
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).on('submit', '#AddClassRoom', function (e) {
    e.preventDefault();
    var formadd = $('#AddClassRoom').serialize();
    $.ajax({
        type: 'post',
        url: "<?= site_url('admin/academic/ConAdminClassRoom/AddClassRoom') ?>",
        data: formadd,
        beforeSend: function () {
            console.log("กำลังโหลด");
        },
        complete: function () {
            //console.log("คือไรว่ะ");
        },
        success: function (result) {
            $('#myModal').modal('hide');
            console.log(result);
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'บันทึกข้อมูลสำเร็จ',
                showConfirmButton: false,
                timer: 1500
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    window.location.reload();
                }
            })

        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus);
        }
    });

});

$(document).ready(function () {

    var ta = $('#tb-classroom').DataTable({
        "order": [
            [0, "desc"],
            [1, "asc"]
        ]
    });

    $('#year').select2({
        theme: "bootstrap-5",
        dropdownParent: $('#myModal')
    });
    $('#classroom').select2({
        theme: "bootstrap-5",
        dropdownParent: $('#myModal')
    });
    $('#teacher').select2({
        theme: "bootstrap-5",
        dropdownParent: $('#myModal')
    });
    
});

$('#yearFilter').on('change', function() {
    var year = $(this).val();
    if(year) {
        window.location.href = '<?= site_url('Admin/Acade/Registration/ClassRoom/') ?>' + year;
    }
});

$(document).on('click', '.btn-delete', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    var url = '<?= site_url('admin/academic/ConAdminClassRoom/DeleteClassRoom/') ?>' + id;
    var csrfName = $('.csrf_token').attr('name');
    var csrfHash = $('.csrf_token').val();

    Swal.fire({
        title: 'คุณแน่ใจหรือไม่?',
        text: "คุณต้องการลบข้อมูลนี้ใช่ไหม!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่, ลบเลย!',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: 'POST', // Change to POST for delete operations with CSRF
                data: {
                    [csrfName]: csrfHash
                },
                dataType: 'json',
                success: function(response) {
                    $('.csrf_token').val(response.csrf_hash);
                    if (response.status === 'success') {
                        Swal.fire(
                            'ลบแล้ว!',
                            response.message,
                            'success'
                        );
                        $('#row-' + id).remove();
                    } else {
                        Swal.fire(
                            'ผิดพลาด!',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire(
                        'เกิดข้อผิดพลาด!',
                        'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้',
                        'error'
                    );
                }
            });
        }
    });
});
</script>
<?= $this->endSection() ?>
