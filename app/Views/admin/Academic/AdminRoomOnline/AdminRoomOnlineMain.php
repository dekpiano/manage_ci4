<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="">
    <div class="">

        <!-- Dashboard Counts Section-->
        <section class="">
            <div class="">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center">
                            <h3 class="h4 float-left">จัดการห้องเรียนออนไลน์ </h3>
                            <button type="button" class="btn btn-primary float-right ShowAddRoomOnline">
                                + เพิ่มห้องเรียนออนไลน์
                            </button>
                            <!-- data-toggle="modal" data-target="#AddRoomOnline" -->
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover display" id="roomOnlineTable" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ปีการศึกษา</th>
                                            <th>รหัสวิชา</th>
                                            <th>ชื่อวิชา</th>
                                            <th>ระดับชั้น</th>
                                            <th>ครูผู้สอน</th>
                                            <th>ลิ้งก์ห้องส่งงาน</th>
                                            <th>ลิ้งก์ห้องเรียนออนไลน์</th>
                                            <th>คำสั่ง</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data will be loaded by DataTables -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<!-- The Modal -->
<div class="modal fade" id="AddRoomOnline" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRoomModalLabel">เพิ่ม/แก้ไข ห้องเรียนออนไลน์</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="FormRoomOnline" class="needs-validation" novalidate>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="roomon_year" name="roomon_year" required>
                                    <option value="">เลือกปีการศึกษา</option>
                                    <?php $year = date('Y')+543;
                                    for ($i=$year-1; $i <= $year+1; $i++) : ?>
                                    <option <?=$year==$i ? "selected" : ""?> value="<?= esc($i) ?>"><?= esc($i) ?></option>
                                    <?php endfor; ?>
                                </select>
                                <label for="roomon_year">ปีการศึกษา</label>
                                <div class="invalid-feedback">กรุณาเลือกปีการศึกษา</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="roomon_term" name="roomon_term" required>
                                    <option value="">เลือกภาคเรียน</option>
                                    <?php for ($i=1; $i <= 3; $i++) : ?>
                                    <option value="<?= esc($i) ?>"><?= esc($i) ?></option>
                                    <?php endfor; ?>
                                </select>
                                <label for="roomon_term">ภาคเรียน</label>
                                <div class="invalid-feedback">กรุณาเลือกภาคเรียน</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="roomon_coursecode" name="roomon_coursecode" placeholder="กรอกรหัสวิชา" required>
                                <label for="roomon_coursecode">รหัสวิชา</label>
                                <div class="invalid-feedback">กรุณากรอกรหัสวิชา</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="roomon_coursename" name="roomon_coursename" placeholder="กรอกชื่อวิชา" required>
                                <label for="roomon_coursename">ชื่อวิชา</label>
                                <div class="invalid-feedback">กรุณากรอกชื่อวิชา</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="roomon_classlevel" class="form-label">ระดับชั้น (เลือกได้มากกว่า 1 ห้อง กรณีสอนรวม)</label>
                        <select id="roomon_classlevel" name="roomon_classlevel[]" required multiple>
                            <option value="">เลือกระดับชั้น</option>
                            <?php foreach ($classroom->ListRoom() as $key => $value) : ?>
                            <option value="<?= esc($value) ?>"><?= esc($value) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">กรุณาเลือกระดับชั้น</div>
                    </div>

                    <div class="form-floating mb-3">
                        <select name="roomon_teachid" id="roomon_teachid" class="form-select" required>
                            <option value=''>เลือกครูผู้สอน</option>
                            <?php foreach ($NameTeacher as $key => $v_NameTeacher) : ?>
                            <option value="<?= isset($v_NameTeacher->pers_id) ? esc($v_NameTeacher->pers_id) : '' ?>">
                                <?= (isset($v_NameTeacher->pers_prefix) ? esc($v_NameTeacher->pers_prefix) : '').(isset($v_NameTeacher->pers_firstname) ? esc($v_NameTeacher->pers_firstname) : '').' '.(isset($v_NameTeacher->pers_lastname) ? esc($v_NameTeacher->pers_lastname) : '') ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="roomon_teachid">ครูผู้สอน</label>
                        <div class="invalid-feedback">กรุณาเลือกครูผู้สอน</div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="roomon_linkroom" name="roomon_linkroom" placeholder="ลิ้งก์ห้องส่งงาน" required>
                        <label for="roomon_linkroom">ลิ้งก์ห้องส่งงาน (แนะนำ Classroom)</label>
                        <div class="invalid-feedback">กรุณาใส่ลิ้งก์ห้องส่งงาน</div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="roomon_liveroom" name="roomon_liveroom" placeholder="ลิ้งก์ห้องเรียนออนไลน์" required>
                        <label for="roomon_liveroom">ลิ้งก์ห้องเรียนออนไลน์ (Meet, Line, Facebook, อื่นๆ)</label>
                        <div class="invalid-feedback">กรุณาใส่ลิ้งก์ห้องเรียนออนไลน์</div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="roomon_note" name="roomon_note" placeholder="หมายเหตุ">
                        <label for="roomon_note">หมายเหตุ</label>
                    </div>
                    
                    <input type="hidden" id="roomon_id" name="roomon_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="DeleteRoomOnline" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ลบข้อมูล</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" class="FormDeleteRoomOnline">
                <div class="modal-body">
                    <p>คุณต้องการลบข้อมูลหรือไม่</p>
                    <input type="text" class="d-none" id="del_roomon_id" name="del_roomon_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">ลบ</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    var table = $('#roomOnlineTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?= site_url('admin/room-online/data') ?>",
            "type": "POST"
        },
        "columns": [
            { 
                "data": null,
                "render": function ( data, type, row ) {
                    return row.roomon_year + '/' + row.roomon_term;
                }
            },
            { "data": "roomon_coursecode" },
            { "data": "roomon_coursename" },
            { "data": "roomon_classlevel" },
            { "data": "teacher_name" },
            { "data": "roomon_linkroom" },
            { "data": "roomon_liveroom" },
            {
                "data": "roomon_id",
                "render": function ( data, type, row ) {
                    return '<a href="#" class="btn btn-warning btn-sm ShowEditRoomOnline" roomid="' + data + '">แก้ไข</a> <a href="#" class="btn btn-danger btn-sm ShowDeleteRoomOnline" roomid="' + data + '">ลบ</a>';
                },
                "orderable": false
            }
        ],
        "responsive": true
    });

    $(document).on("click", ".ShowAddRoomOnline", function () {
        $('#AddRoomOnline').modal('show');
        $('#FormRoomOnline').addClass('Add_RoomOnline');
        $('#FormRoomOnline').removeClass('Update_RoomOnline');
        $('#FormRoomOnline')[0].reset();
        classlevel.set([]); // Clear SlimSelect
    });

    var classlevel = new SlimSelect({
        select: '#roomon_classlevel'
    });

    $(document).on("click", ".ShowEditRoomOnline", function (e) {
        e.preventDefault();
        $('#AddRoomOnline').modal('show');
        $('#FormRoomOnline').addClass('Update_RoomOnline');
        $('#FormRoomOnline').removeClass('Add_RoomOnline');
        
        $.post("<?= site_url('admin/ConAdminRoomOnline/EditRoomOnline') ?>", { roomid: $(this).attr('roomid') }, function (data, status) {
            if(data){
                $('#roomon_id').val(data.roomon_id);
                $('#roomon_coursecode').val(data.roomon_coursecode);
                $('#roomon_coursename').val(data.roomon_coursename);
                $('#roomon_linkroom').val(data.roomon_linkroom);
                $('#roomon_liveroom').val(data.roomon_liveroom);
                $('#roomon_teachid').val(data.roomon_teachid);
                $('#roomon_note').val(data.roomon_note);
                $('#roomon_year').val(data.roomon_year);
                $('#roomon_term').val(data.roomon_term);

                var classLevels = data.roomon_classlevel ? data.roomon_classlevel.split('|') : [];
                classlevel.set(classLevels);
            }
        }, "json");
    });

    $(document).on("click", ".ShowDeleteRoomOnline", function (e) {
        e.preventDefault();
        $('#DeleteRoomOnline').modal('show');
        $('#del_roomon_id').val($(this).attr('roomid'));
    });

    $(document).on("submit", ".Add_RoomOnline", function (e) {
        e.preventDefault();
        $.ajax({
            url: '<?= site_url('admin/ConAdminRoomOnline/AddRoomOnline') ?>',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            success: function (data) {
                if (data != 2) {
                    $('#AddRoomOnline').modal('hide');
                    table.ajax.reload(); // Reload DataTable
                    Swal.fire({
                        icon: 'success',
                        title: 'บันทึกข้อมูลสำเร็จ',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'ข้อมูลซ้ำ มีในระบบแล้ว',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        });
    });

    $(document).on("submit", ".Update_RoomOnline", function (e) {
        e.preventDefault();
        $.ajax({
            url: '<?= site_url('admin/ConAdminRoomOnline/UpdateRoomOnline') ?>',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            success: function (data) {
                if (data > 0) {
                    $('#AddRoomOnline').modal('hide');
                    table.ajax.reload(); // Reload DataTable
                    Swal.fire({
                        icon: 'success',
                        title: 'อัปเดตข้อมูลสำเร็จ',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        });
    });

    $(document).on("submit", ".FormDeleteRoomOnline", function (e) {
        e.preventDefault();
        $.post("<?= site_url('admin/ConAdminRoomOnline/DeleteRoomOnline') ?>", { roomid: $("#del_roomon_id").val() }, function (data, status) {
            if (data == 1) {
                $('#DeleteRoomOnline').modal('hide');
                table.ajax.reload(); // Reload DataTable
                Swal.fire({
                    icon: 'success',
                    title: 'ลบข้อมูลสำเร็จ',
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                alertify.error('ลบข้อมูลไม่สำเร็จ');
            }
        });
    });
});
</script>
<?= $this->endSection() ?>