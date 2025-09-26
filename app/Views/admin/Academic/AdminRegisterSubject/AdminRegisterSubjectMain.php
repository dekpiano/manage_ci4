<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
.border-left-primary {
    border-left: .25rem solid #5BC3D5 !important;
}
 /* ปรับ Select2 ให้เข้ากับ Bootstrap */
 .select2-container .select2-selection--single {
            height: 38px; /* ให้เท่ากับ .form-control */
            padding: 6px 12px;
            border-radius: 5px;
            border: 1px solid #ced4da;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
        }
</style>
<div class="app-content pt-3 p-md-3 p-lg-4">
    <section class="we-offer-area">
        <div class="container-fluid">

            <div class="container-xl">

                <div class="row g-3 mb-4 align-items-center justify-content-between">
                    <div class="col-auto">
                        <h1 class="app-page-title mb-0">จัดการข้อมูล<?= isset($title) ? esc($title) : '' ?></h1>
                    </div>
                    <div class="col-auto">
                        <div class="page-utilities">
                            <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                                <div class="col-auto">
                                    <input type="text" name="CheckYearNow" id="CheckYearNow"
                                        value="<?= isset($SchoolYear->schyear_year) ? esc($SchoolYear->schyear_year) : '' ?>" style="display:none">

                                    <?php foreach ($GroupYear as $key => $v_GroupYear): 
                                // $GG = substr($v_GroupYear->SubjectYear, 2, 6);
                                // print_r(array($GG));
                                    //$GG = explode('/',$v_GroupYear->SubjectYear); 
                                    // $G = array_unique(array($GG));
                                 //echo '<pre>';print_r($SchoolYear->schyear_year);
                                ?>
                                    <?php endforeach; ?>

                                </div>

                            </div>
                            <!--//row-->
                        </div>
                        <!--//table-utilities-->
                    </div>
                    <!--//col-auto-->
                </div>
                <!--//row-->

                <div class="row">
                    <div class="col-md-12">
                        <div class="app-card app-card-settings shadow-sm p-3">
                            <div class="app-card-header mb-3">
                                <div class="row justify-content-between align-items-center">
                                    <div class="col-auto">
                                        <h4 class="app-card-title">เพิ่มข้อมูลรายวิชา</h4>
                                    </div>
                                    <!--//col-->
                                    <!-- <div class="col-auto">
                                        <div class="card-header-action">
                                            <a href="#">View report</a>
                                        </div>
                                        
                                    </div> -->
                                    <!--//col-->
                                </div>
                                <!--//row-->
                            </div>
                            <div class="app-card-body">
                                <form class="settings-form row" id="form-subject">
                                    <div class="mb-3 col-6 col-lg-6">
                                        <label for="setting-input-1" class="form-label">ปีการศึกษา</label>
                                        <select class="form-select" required="" name="SubjectYear" id="SubjectYear">
                                            <option value="">เลือกปีการศึกษา</option>
                                            <?php $d = date('Y')+541; 
                                                for($j=1; $j<=3; $j++):
                                                for ($i=$d; $i <= $d+2 ; $i++) :
                                                ?>
                                            <option <?= (isset($SchoolYear->schyear_year) && $SchoolYear->schyear_year == $j.'/'.$i) ? "selected" : ""?>
                                                value="<?= esc($j.'/'.$i) ?>"><?= esc($j.'/'.$i) ?></option>
                                            <?php endfor; ?>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-6 col-lg-6">
                                        <label for="setting-input-1" class="form-label">ระดับชั้นที่เปิดสอน
                                        </label>
                                        <select class="form-select" required="" name="SubjectClass"
                                            id="SubjectClass">
                                            <option value="">เลือกระดับชั้น</option>
                                            <?php $sara = $this->classroom->LevelClass();
                                                foreach ($sara as $key => $v_sara):?>
                                            <option value="<?= esc($v_sara) ?>"><?= esc($v_sara) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-6 col-lg-3">
                                        <label for="setting-input-1" class="form-label">รหัสวิชา
                                        </label>
                                        <select id="SubjectCode" name="SubjectCode" class="form-select">
                                            <option value="">-- พิมพ์เพื่อค้นหา --</option>
                                        </select>
                                        <!-- <input type="text" class=""  value=""
                                            required="" name="SubjectCode" id="SubjectCode"> -->
                                    </div>
                                    <div class="mb-3 col-6 col-lg-3">
                                        <label for="setting-input-1" class="form-label">ชื่อวิชา
                                        </label>
                                        <input type="text" class="form-control" value="" required=""
                                            name="SubjectName" id="SubjectName">
                                    </div>
                                    <div class="mb-3 col-6 col-lg-3">
                                        <label for="setting-input-1" class="form-label">หน่วยกิต
                                        </label>
                                        <select class="form-select" required="" name="SubjectUnit" id="SubjectUnit">
                                            <option value="">เลือกหน่วยกิต</option>
                                            <?php $Unit = array("0.5","1.0","1.5","2.0","2.5","3.0","3.5","4.0","4.5","5.0");
                                                foreach ($Unit as $key => $v_Unit):?>
                                            <option value="<?= esc($v_Unit) ?>"><?= esc($v_Unit) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-6 col-lg-3">
                                        <label for="setting-input-1" class="form-label">จำนวนชั่วโมง
                                        </label>

                                        <select class="form-select" required="" name="SubjectHour" id="SubjectHour">
                                            <option value="">เลือกชั่วโมง</option>
                                            <?php $Hour = array("20","40","60","80","100","120","140","160","180","200");
                                                foreach ($Hour as $key => $v_Hour):?>
                                            <option value="<?= esc($v_Hour) ?>"><?= esc($v_Hour) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-6 col-lg-4">
                                        <label for="setting-input-1" class="form-label">ประเภทวิชา</label>
                                        <select class="form-select " required="" name="SubjectType"
                                            id="SubjectType">
                                            <option value="">เลือกประเภทวิชา</option>
                                            <option value="1/พื้นฐาน">1/พื้นฐาน</option>
                                            <option value="2/เพิ่มเติม">2/เพิ่มเติม</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-6 col-lg-4">
                                        <label for="setting-input-1" class="form-label">สาระหลัก</label>
                                        <select class="form-select " required="" name="FirstGroup" id="FirstGroup">
                                            <option value="">เลือกสาระหลัก</option>
                                            <?php $sara = $this->classroom->GroupSaraMain();
                                                foreach ($sara as $key => $v_sara):?>
                                            <option value="<?= esc($v_sara) ?>"><?= esc($v_sara) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-6 col-lg-4">
                                        <label for="setting-input-1" class="form-label">สาระย่อย</label>
                                        <select class="form-select" required="" name="SecondGroup" id="SecondGroup">
                                            <option value="">เลือกสาระย่อย</option>
                                            <?php $sara = $this->classroom->GroupSaraSecond();
                                                foreach ($sara as $key => $v_sara):?>
                                            <option value="<?= esc($v_sara) ?>"><?= esc($v_sara) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn app-btn-primary">บันทึก</button>
                                </form>
                            </div>
                            <!--//app-card-body-->

                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="row mb-2 justify-content-start justify-content-md-end align-items-center">
                        <div class="col-auto d-flex">
                            <label for="" class="align-self-center">เลือกดู</label>
                            <select class="form-select w-auto SelectSubject ms-2 ">
                                <option selected value="">เลือกปีการศึกษา</option>
                                <?php foreach ($GroupYear as $key => $v_GroupYear): ?>
                                <option <?= (isset($v_GroupYear->SubjectYear) && isset($SchoolYear->schyear_year) && $v_GroupYear->SubjectYear == $SchoolYear->schyear_year) ? "selected" : ""?>
                                    value="<?= isset($v_GroupYear->SubjectYear) ? esc($v_GroupYear->SubjectYear) : '' ?>"><?= isset($v_GroupYear->SubjectYear) ? esc($v_GroupYear->SubjectYear) : '' ?></option>
                                <?php endforeach; ?>

                            </select>
                        </div>

                    </div>
                    <div class="col-md-12">
                        <div class="app-card app-card-orders-table shadow-sm mb-5">
                            <div class="app-card-body">
                                <div class="table-responsive p-3">
                                    <table class="table app-table-hover mb-0 text-left" id="tbSubject">
                                        <thead>
                                            <tr>
                                                <th class="cell">ปีการศึกษา</th>
                                                <th class="cell">รหัสวิชา</th>
                                                <th class="cell">ชื่อวิชา</th>
                                                <th class="cell">สาระ</th>
                                                <th class="cell">ชั้น</th>
                                                <th class="cell">ปีที่เรียน</th>
                                                <th class="cell">คำสั่ง</th>
                                            </tr>
                                        </thead>

                                    </table>
                                </div>

                            </div>
                            <!--//app-card-body-->
                        </div>
                        <!--//app-card-->

                    </div>
                </div>


            </div>


        </div>
    </section>

</div>
<!--//main-wrapper-->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ModalUpdateSubject" tabindex="-1" aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">แก้ไขวิชาเรียน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="settings-form row" id="form-update-subject">
                    <input type="text" class="form-control" value="" required="" name="Up_SubjectID"
                        id="Up_SubjectID" style="display:none;">

                    <div class="mb-3 col-6 col-lg-6">
                        <label for="setting-input-1" class="form-label">ปีการศึกษา</label>
                        <select class="form-select" required="" name="Up_SubjectYear" id="Up_SubjectYear">
                            <option value="">เลือกปีการศึกษา</option>
                            <?php $d = date('Y')+541; for ($i=$d; $i <= $d+2 ; $i++) :?>
                            <option value="1/<?= esc($i);?>">1/<?= esc($i);?></option>
                            <option value="2/<?= esc($i);?>">2/<?= esc($i);?></option>
                            <option value="3/<?= esc($i);?>">3/<?= esc($i);?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="mb-3 col-6 col-lg-6">
                        <label for="setting-input-1" class="form-label">ระดับชั้นที่เปิดสอน
                        </label>
                        <select class="form-select" required="" name="Up_SubjectClass" id="Up_SubjectClass">
                            <option value="">เลือกระดับชั้น</option>
                            <?php $sara = $this->classroom->LevelClass();
                                                foreach ($sara as $key => $v_sara):?>
                            <option value="<?= esc($v_sara) ?>"><?= esc($v_sara) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3 col-6 col-lg-3">
                        <label for="setting-input-1" class="form-label">รหัสวิชา
                        </label>

                        <input type="text" class="form-control" value="" required="" name="Up_SubjectCode"
                            id="Up_SubjectCode">
                    </div>
                    <div class="mb-3 col-6 col-lg-5">
                        <label for="setting-input-1" class="form-label">ชื่อวิชา
                        </label>
                        <input type="text" class="form-control" value="" required="" name="Up_SubjectName"
                            id="Up_SubjectName">
                    </div>
                    <div class="mb-3 col-6 col-lg-2">
                        <label for="setting-input-1" class="form-label">หน่วยกิต
                        </label>
                        <input type="text" class="form-control" value="" required="" name="Up_SubjectUnit"
                            id="Up_SubjectUnit">
                    </div>
                    <div class="mb-3 col-6 col-lg-2">
                        <label for="setting-input-1" class="form-label">จำนวนชั่วโมง
                        </label>
                        <input type="text" class="form-control" value="" required="" name="Up_SubjectHour"
                            id="Up_SubjectHour">
                    </div>
                    <div class="mb-3 col-6 col-lg-4">
                        <label for="setting-input-1" class="form-label">ประเภทวิชา</label>
                        <select class="form-select " required="" name="Up_SubjectType" id="Up_SubjectType">
                            <option value="">เลือกประเภทวิชา</option>
                            <option value="1/พื้นฐาน">1/พื้นฐาน</option>
                            <option value="2/เพิ่มเติม">2/เพิ่มเติม</option>
                        </select>
                    </div>
                    <div class="mb-3 col-6 col-lg-4">
                        <label for="setting-input-1" class="form-label">สาระหลัก</label>
                        <select class="form-select " required="" name="Up_FirstGroup" id="Up_FirstGroup">
                            <option value="">เลือกสาระหลัก</option>
                            <?php $sara = $this->classroom->GroupSaraMain();
                                                foreach ($sara as $key => $v_sara):?>
                            <option value="<?= esc($v_sara) ?>"><?= esc($v_sara) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3 col-6 col-lg-4">
                        <label for="setting-input-1" class="form-label">สาระย่อย</label>
                        <select class="form-select" required="" name="Up_SecondGroup" id="Up_SecondGroup">
                            <option value="">เลือกสาระย่อย</option>
                            <?php $sara = $this->classroom->GroupSaraSecond();
                                                foreach ($sara as $key => $v_sara):?>
                            <option value="<?= esc($v_sara) ?>"><?= esc($v_sara) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="submit" class="btn btn-primary">แก้ไข</button>
            </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
let tablel_Subject;
TB_Subject($('#CheckYearNow').val());
$(document).on('change', '.SelectSubject', function() {
    //alert($(this).val());
    TB_Subject($(this).val());
});


function TB_Subject(Year) {
    tablel_Subject = $('#tbSubject').DataTable({
        destroy: true,
        "order": [
            [1, "asc"]
        ],
        'processing': true,
        "ajax": {
            url: "<?= site_url('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectSelect') ?>",
            "type": "POST",
            data: { "keyYear": Year }
        },
        'columns': [
            { data: 'SubjectYear' },
            { data: 'SubjectCode' },
            { data: 'SubjectName' },
            { data: 'FirstGroup' },
            { data: 'SubjectClass' },
            { data: 'SubjectYear' },
            {
                data: 'SubjectID',
                render: function(data, type, row) {
                    return '<a href="#" idSbuj="' + data + '" class="btn btn-warning btn-sm EditSubject">แก้ไข</a> | <a href="#" idSbuj="' + data + '" class="btn btn-danger btn-sm delete_subject text-white">ลบ</a>';

                }
            }
        ]
    });
}


$(document).on('click', '.EditSubject', function() {
    $('#ModalUpdateSubject').modal('show');
    $.ajax({
        url: '<?= site_url('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectEdit') ?>',
        type: 'post',
        data: { KeySubj: $(this).attr('idSbuj') },
        dataType: 'json',
        error: function() {
            alert('Something is wrong');
        },
        success: function(data) {
            //console.log(data[0]);
            $('#Up_SubjectYear').val(data[0].SubjectYear);
            $('#Up_SubjectClass').val(data[0].SubjectClass);
            $('#Up_SubjectCode').val(data[0].SubjectCode);
            $('#Up_SubjectName').val(data[0].SubjectName);
            $('#Up_SubjectUnit').val(data[0].SubjectUnit);
            $('#Up_SubjectHour').val(data[0].SubjectHour);
            $('#Up_SubjectType').val(data[0].SubjectType);
            $('#Up_FirstGroup').val(data[0].FirstGroup);
            $('#Up_SecondGroup').val(data[0].SecondGroup);
            $('#Up_SubjectID').val(data[0].SubjectID);

        }
    });
});


$(document).on('submit', '#form-subject', function(e) {
    e.preventDefault();
    // console.log($(this).serialize());

    $.ajax({
        url: '<?= site_url('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectInsert') ?>',
        type: 'post',
        data: $(this).serialize(),
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText);
        },
        success: function(data) {
            console.log(data);
            if (data > 0) {
                $('#form-subject')[0].reset();
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'บันทึกข้อมูลสำเร็จ',
                    showConfirmButton: false,
                    timer: 3000
                })
                tablel_Subject.ajax.reload();
            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'ข้อมูลรายวิชานี้ ได้ลงทะเบียนในภาคเรียนนี้แล้ว',
                    showConfirmButton: false,
                    timer: 5000
                })
            }

        }
    });
});

$(document).on('submit', '#form-update-subject', function(e) {
    e.preventDefault();
    //console.log($(this).serialize());

    $.ajax({
        url: '<?= site_url('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectUpdate') ?>',
        type: 'post',
        data: $(this).serialize(),
        error: function() {
            alert('Something is wrong');
        },
        success: function(data) {
            $('#ModalUpdateSubject').modal('hide');
            if (data > 0) {
                $('#form-update-subject')[0].reset();
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'แก้ไขข้อมูลสำเร็จ',
                    showConfirmButton: false,
                    timer: 3000
                })
                tablel_Subject.ajax.reload();
            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'ข้อมูลรายวิชานี้ ได้ลงทะเบียนในภาคเรียนนี้แล้ว',
                    showConfirmButton: false,
                    timer: 5000
                })
            }

        }
    });
});


$(document).on('click', '.delete_subject', function() {
    var id = $(this).attr("idSbuj");

    Swal.fire({
        title: 'Are you sure?',
        text: "คุณต้องการลลข้อมูลหรือไม่!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= site_url('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectDelete/') ?>' + id,
                type: 'DELETE',
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR.responseText);
                },
                success: function(data) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'ลบข้อมูลสำเร็จ',
                        showConfirmButton: false,
                        timer: 1000
                    })
                    tablel_Subject.ajax.reload();
                }
            });
        }
    })
});

$(document).on('change', '#SubjectUnit', function() {
    console.log($(this).val());
    $('#SubjectHour option').removeAttr('selected');
    if ($(this).val() == 0.5) {
        $('#SubjectHour option[value=20]').attr('selected', 'selected');
    } else if ($(this).val() == 1.0) {
        $('#SubjectHour option[value=40]').attr('selected', 'selected');
    } else if ($(this).val() == 1.0) {
        $('#SubjectHour option[value=40]').attr('selected', 'selected');
    } else if ($(this).val() == 1.5) {
        $('#SubjectHour option[value=60]').attr('selected', 'selected');
    } else if ($(this).val() == 2.0) {
        $('#SubjectHour option[value=80]').attr('selected', 'selected');
    }
});


let subjects = []; // เก็บข้อมูลที่โหลดมา
let api_url = "https://sheets.googleapis.com/v4/spreadsheets/1RbMq3N-4itgCJCnnc8TsZ8k4XZNlEz_kOLkKBvEsajQ/values/main1?key=AIzaSyATVgVTJM7ou3XdyBH-FsxVd9uj_A32tCc";

function loadSubjects() {
    $.getJSON(api_url, function (data) {
        let rows = data.values;
        rows.shift(); // ลบแถวหัวตาราง (Header)

        subjects = rows.map(row => ({
            id: row[0],   // รหัสวิชา
            text: row[0], // แสดง รหัสวิชา + ชื่อวิชา
            SubjectName: row[1], // ชื่อวิชา
            SubjectUnit: row[2], // หน่วยกิต
            SubjectHour: row[3], // ชั่วโมง
            SubjectType: row[4],  // ประเภทวิชา
            FirstGroup: row[5],
            SecondGroup: row[6],
            SubjectClass: row[7] 
        }));

       // console.log("โหลดข้อมูลสำเร็จ", subjects);
        
        // อัปเดต Select2
        $("#SubjectCode").select2({
            placeholder: "พิมพ์รหัสวิชาเพื่อค้นหา",
            allowClear: true,
            minimumInputLength: 2,
            data: subjects,
            matcher: function (params, data) {
                if (!params.term || !data.text) return null;
                if (data.text.toLowerCase().includes(params.term.toLowerCase())) {
                    return data;
                }
                return null;
            }
        });
    });
}

loadSubjects(); // โหลดข้อมูลตอนเริ่มต้น


// เมื่อเลือกค่า
$("#SubjectCode").on("select2:select", function (e) {
    let selected = e.params.data;
    $("#SubjectName").val(selected.SubjectName);
    $("#SubjectUnit").val(selected.SubjectUnit);
    $("#SubjectHour").val(selected.SubjectHour);
    $("#SubjectType").val(selected.SubjectType);
    $("#FirstGroup").val(selected.FirstGroup);
    $("#SecondGroup").val(selected.SecondGroup);
    $("#SubjectClass").val(selected.SubjectClass);
});
</script>
<?= $this->endSection() ?>
