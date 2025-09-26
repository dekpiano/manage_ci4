<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<style>
.border-left-primary {
    border-left: .25rem solid #5BC3D5 !important;
}

.toolbar {
    float: left;
}

.dataTables_length {
    float: left;
}
</style>
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">

            <div class="row g-3 mb-4 align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="app-page-title mb-0">จัดการข้อมูล<?= isset($title) ? esc($title) : '' ?>
                        <?= (isset($DataRepeat[0]->SubjectCode) ? esc($DataRepeat[0]->SubjectCode) : '').' '.(isset($DataRepeat[0]->SubjectName) ? esc($DataRepeat[0]->SubjectName) : '') ?></h1>
                </div>
            </div>
            <hr>
            <?php if(isset($DataRepeat) && $DataRepeat) :?>
            <section class="we-offer-area">
                <div class="app-card app-card-orders-table pt-2">
                    <div class="app-card-body">
                        <div class="table-responsive  p-3">
                            <form id="FormRegisRepeatUpdate1" method="post">
                                <!-- <div class="row justify-content-center mb-4">
                                    <div class="col-md-6 d-flex align-items-center">
                                        <div class="w-25">ครูสอน</div>
                                        <div>
                                            <select name="RepeatTeacher" id="RepeatTeacher" class="form-select">
                                                <option value="">เลือกครูสอน...</option>
                                                <?php foreach ($Teacher as $key => $v_Teache):?>
                                                <option
                                                    <?=@$DataRepeatTeacher[0]->RepeatTeacher==$v_Teache->pers_id? "selected" : ""?>
                                                    value="<?=$v_Teache->pers_id?>">
                                                    <?=$v_Teache->pers_prefix.$v_Teache->pers_firstname.' '.$v_Teache->pers_lastname?>
                                                </option>
                                                <?php endforeach;?>
                                            </select>
                                            <br>
                                            <small>เลือกครูผู้สอนใหม่กรณีที่ไม่ใช่ครูคนเก่า</small>
                                        </div>

                                    </div>
                                </div> -->
                                <hr>

                                <input type="text" name="YearRepeat" value="<?= isset($DataRepeat[0]->RegisterYear) ? esc($DataRepeat[0]->RegisterYear) : '' ?>"
                                    style="display:none;">
                                <input type="text" name="SubjectRepeat" value="<?= isset($DataRepeat[0]->SubjectID) ? esc($DataRepeat[0]->SubjectID) : '' ?>"
                                    style="display:none;">
                                <table class="table app-table-hover mb-0 text-left" id="">
                                    <thead>
                                        <tr class="text-center">
                                            <th>เลือกที่เรียนซ้ำ</th>
                                            <th>เรียนปี</th>
                                            <th>ห้อง</th>
                                            <th>เลขที่</th>
                                            <th>รหัสประจำตัว</th>
                                            <th>ชื่อนักเรียน</th>
                                            <th>คะแนน</th>
                                            <th>ผลการเรียน</th>
                                            <th>สถานะเรียนซ้ำ</th>
                                            <th>สถานะ นร</th>
                                            <th>ครูที่สอนเรียนซ้ำ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($DataRepeat as $key => $v_DataRepeat) : ?>
                                        <tr
                                            class="<?= (isset($v_DataRepeat->Grade) && ($v_DataRepeat->Grade == "มส" ||  $v_DataRepeat->Grade <= 0)) ? "table-danger" : ""?>">
                                            <td class="text-center">
                                                <input type="checkbox" name="SelRepeat[]" id="SelRepeat"
                                                    data-bs-target=".myModal" value="<?= isset($v_DataRepeat->StudentID) ? esc($v_DataRepeat->StudentID) : '' ?>"
                                                    class="form-check-input SelRepeat"
                                                    <?= (isset($v_DataRepeat->Grade_Type) && isset($v_DataRepeat->RepeatStatus) && $v_DataRepeat->Grade_Type != "" && $v_DataRepeat->RepeatStatus == "ไม่ผ่าน") ? "checked" : ""?>>
                                            </td>
                                            <td class="text-center"><?= isset($v_DataRepeat->RegisterYear) ? esc($v_DataRepeat->RegisterYear) : '' ?></td>
                                            <td class="text-center"><?= isset($v_DataRepeat->StudentClass) ? esc($v_DataRepeat->StudentClass) : '' ?></td>
                                            <td class="text-center"><?= isset($v_DataRepeat->StudentNumber) ? esc($v_DataRepeat->StudentNumber) : '' ?></td>
                                            <td class="text-center"><?= isset($v_DataRepeat->StudentCode) ? esc($v_DataRepeat->StudentCode) : '' ?></td>
                                            <td class="text-left">
                                                <?= (isset($v_DataRepeat->StudentPrefix) ? esc($v_DataRepeat->StudentPrefix) : '').(isset($v_DataRepeat->StudentFirstName) ? esc($v_DataRepeat->StudentFirstName) : '').' '.(isset($v_DataRepeat->StudentLastName) ? esc($v_DataRepeat->StudentLastName) : '') ?>
                                            </td>
                                            <td class="text-center">
                                                <?= isset($v_DataRepeat->Grade) ? esc($v_DataRepeat->Grade) : '' ?></td>
                                            <td class="text-center">
                                                <?= (isset($v_DataRepeat->Grade_Type) && $v_DataRepeat->Grade_Type == "") ? "เรียนปกติ" : (isset($v_DataRepeat->Grade_Type) ? esc($v_DataRepeat->Grade_Type) : '').' ('.(isset($v_DataRepeat->RepeatYear) ? esc($v_DataRepeat->RepeatYear) : '').')'?>
                                            </td>
                                            <td class="text-center"><?= isset($v_DataRepeat->RepeatStatus) ? esc($v_DataRepeat->RepeatStatus) : '';?>
                                                <?= (isset($v_DataRepeat->RepeatStatus) && $v_DataRepeat->RepeatStatus == "ผ่าน") ? '('.(isset($v_DataRepeat->RepeatYear) ? esc($v_DataRepeat->RepeatYear) : '').')' : ""?>
                                            </td>
                                            <td class="text-center"><?= isset($v_DataRepeat->StudentBehavior) ? esc($v_DataRepeat->StudentBehavior) : '' ;?></td>
                                            <td><?= isset($v_DataRepeat->RepeatTeacherName) ? esc($v_DataRepeat->RepeatTeacherName) : '' ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>

                                </table>
                                <!-- <div class="mt-3 text-center">
                                    <button class="btn app-btn-primary">บันทึก</button>
                                </div> -->
                            </form>

                        </div>
                        <!--//table-responsive-->
                    </div>
                    <!--//app-card-body-->
                </div>


            </section>
            <?php else :  ?>
            <div class="app-card shadow-sm mb-4 border-left-decoration">
                <div class="inner">
                    <div class="app-card-body p-4">
                        <div class="row gx-5 gy-3">
                            <div class="col-12 col-lg-9">

                                <div>
                                    <h3>ยังไม่มีข้อมูลการลงทะเบียนเรียน</h3>
                                </div>
                            </div>
                            <!--//col-->
                            <div class="col-12 col-lg-3">
                                <a class="btn app-btn-primary"
                                    href="<?= site_url('Admin/Acade/Registration/Repeat') ?>">ย้อนกลับ</a>
                            </div>
                            <!--//col-->
                        </div>
                        <!--//row-->

                    </div>
                    <!--//app-card-body-->

                </div>
                <!--//inner-->
            </div>

            <?php endif; ?>

            <!--//row-->
        </div>



    </div>
    <!--//main-wrapper-->

    <!-- โมเดล -->
    <div class="modal fade myModal" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เลือกครูสอน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="FormRegisRepeatUpdate" method="post">
                    <div class="modal-body">
                        <select name="RepeatTeacher" id="RepeatTeacher" class="form-select">
                            <option value="">เลือกครูสอน...</option>
                            <?php foreach ($Teacher as $key => $v_Teache):?>
                            <option <?= (isset($DataRepeatTeacher[0]->RepeatTeacher) && isset($v_Teache->pers_id) && $DataRepeatTeacher[0]->RepeatTeacher == $v_Teache->pers_id) ? "selected" : ""?>
                                value="<?= isset($v_Teache->pers_id) ? esc($v_Teache->pers_id) : '' ?>">
                                <?= (isset($v_Teache->pers_prefix) ? esc($v_Teache->pers_prefix) : '').(isset($v_Teache->pers_firstname) ? esc($v_Teache->pers_firstname) : '').' '.(isset($v_Teache->pers_lastname) ? esc($v_Teache->pers_lastname) : '') ?>
                            </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <input type="text" name="StuID" id="StuID" value="" style="display:none;">
                        <input type="text" id="YearRepeat" name="YearRepeat" value="<?= isset($DataRepeat[0]->RegisterYear) ? esc($DataRepeat[0]->RegisterYear) : '' ?>"
                            style="display:none;">
                        <input type="text" id="SubjectRepeat" name="SubjectRepeat"
                            value="<?= isset($DataRepeat[0]->SubjectID) ? esc($DataRepeat[0]->SubjectID) : '' ?>" style="display:none;">
                        
                        <button type="submit" class="btn btn-primary" id="btnSaveRepeat">บันทึก</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
// $('#SelectYearRegister').select2({
//     width: 300
// });

// $('#teacherregis').select2({
//     width: 300
// });
// $('#subjectregis').select2({
//     width: 300
// });
// $('#Room').select2({
//     width: 300
// });
// $('#RoomEdit').select2({
//     width: 300
// });

// $('#RepeatTeacher').select2({

// });

$(document).on("change", "#SelectYearRegister", function() {
    window.location.href = '../' + $(this).val();
});


$(document).on("change", "#Room", function() {
    filterByStudyLine($(this).val(),'All');
});

$(document).on("click", 'input[name="btnradio"]', function() {
    var selectedStudyLine = $(this).next('label').text(); // ดึงค่าจาก label ที่อยู่ถัดจาก input
     // ทำให้ปุ่ม checked
    $('input[name="btnradio"]').prop('checked', false); // ยกเลิก checked ทุกปุ่ม
    $(this).prop('checked', true); // ตั้ง checked ให้ปุ่มที่เลือก
    $('label.btn').removeClass('active'); // ลบคลาส active จากทุกปุ่ม
    $(this).next('label').addClass('active'); // เพิ่มคลาส active ให้ปุ่มที่เลือก
    
    filterByStudyLine($('#Room').val(),selectedStudyLine);
});

function filterByStudyLine(KeyRoom,KeyStudyLines) {
    $('#multiselect option').remove();

    $.post("<?= site_url('admin/academic/ConAdminRegisRepeat/AdminRegisRepeatSelect') ?>", { KeyRoom: KeyRoom, KeyStudyLines:KeyStudyLines }, function(data, status) {
        console.log(data);
        var SplitStudyLines = data[0].StudyLines.split("|");

        var html = `
        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
            <input type="radio" class="btn-check" name="btnradio" id="btnradio99" autocomplete="off" checked>
            <label class="btn btn-outline-primary" style="border: 1px solid;" for="btnradio99">All</label>
        `;
                $.each(SplitStudyLines, function(index, value){
        html +=  `
            <input type="radio" class="btn-check" name="btnradio" id="btnradio${index}" autocomplete="off" ${value === KeyStudyLines ?"checked":""}>
            <label class="btn btn-outline-primary" style="border: 1px solid;" for="btnradio${index}">${value}</label>
        `;
                });
        html +=  `</div>`;

        $('#StudyLines').html(html);
        
        $.each(data, function(index, value) {
            //console.log(value);
            // trHTML = '<tr><td></td><td>' + value.StudentCode + '</td><td>' + value.StudentPrefix+value.StudentFirstName+' '+value.StudentLastName + '</td></tr>';
            // trHTML = '<option value="' + value.StudentID + '">' + value.StudentClass + ' ' + value.StudentNumber.padStart(2, '0') + ' ' + value.StudentPrefix + value.StudentFirstName + ' ' + value.StudentLastName + '</option>';
            // $('#multiselect').append(trHTML);
        });
    }, 'json');
}

$(document).on("change", "#RoomEdit", function() {

    $('#multiselect option').remove();

    $.post("<?= site_url('admin/academic/ConAdminRegisRepeat/AdminRegisRepeatSelect') ?>", { KeyRoom: $(this).val() }, function(data, status) {

        $.each(data, function(index, value) {
            //console.log(value);
            // trHTML = '<tr><td></td><td>' + value.StudentCode + '</td><td>' + value.StudentPrefix+value.StudentFirstName+' '+value.StudentLastName + '</td></tr>';
            // trHTML = '<option value="' + value.StudentID + '">' + value.StudentClass + ' ' + value.StudentNumber.padStart(2, '0') + ' ' + value.StudentPrefix + value.StudentFirstName + ' ' + value.StudentLastName + '</option>';
            // $('#multiselect').append(trHTML);
        });


    }, 'json');

});


    var lastCheckedCheckbox = null; // ตัวแปรเก็บ checkbox ล่าสุดที่ถูกติ๊ก
    // เมื่อ checkbox ถูกคลิก
    $('.SelRepeat').change(function() {
        var targetModal = $(this).data('bs-target'); // ได้ค่าจาก data-bs-target (เช่น .myModal)

        if ($(this).is(':checked')) {
            $('#StuID').val($(this).val()); // ได้ค่าจาก data-bs-target (เช่น .myModal)
           
            $(targetModal).modal('show'); // ใช้ jQuery เปิดโมเดล
            lastCheckedCheckbox = $(this); // เก็บ checkbox ที่ถูกติ๊ก
        } else {
            // ถ้า checkbox ไม่ถูกเลือกให้ปิดโมเดล
            lastCheckedCheckbox = $(this);
            Swal.fire({
                title: 'คำถาม?',
                text: "คุณต้องการถอนเรียนออกจากเรียนซ้ำหรือไม่?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true
              }).then((result) => {
                if (result.isConfirmed) {
              
                  $.ajax({
                    url: '<?= site_url('admin/academic/ConAdminRegisRepeat/AdminRegisRepeatAdd') ?>',
                    type: 'post',
                    data: {
                        DelStuID:$(this).val(),
                        YearRepeat: $('#YearRepeat').val(),
                        SubjectRepeat: $('#SubjectRepeat').val(),
                        DelStatus:"Del"
                    },
                    error: function() {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'ระบบผิดพลาด ลองใหม่อีกครั้ง!',
                            showConfirmButton: false,
                            timer: 3000
                        })
                    },
                    success: function(data) {
                        console.log(data);
                        if (data) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'ถอนการลงทะเบียนเรียนซ้ำ สำเร็จ!',
                                showConfirmButton: false,
                                timer: 3000
                            }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    location.reload(true);
                                }
                            });
            
                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'warning',
                                title: 'คุณไม่ได้เลือกนักเรียนในการลงทะเบียนเรียนซ้ำ!',
                                showConfirmButton: false,
                                timer: 3000
                            })
                        }
            
                    }
                });
                
                }else{
                    lastCheckedCheckbox.prop('checked', true);
                    lastCheckedCheckbox = null;
                }
              });

            $(targetModal).modal('hide'); // ใช้ jQuery ปิดโมเดล
        }
    });

     // เมื่อโมเดลถูกปิด (ทั้งจากปุ่มปิดหรือคลิกภายนอก)
     $('.myModal').on('hidden.bs.modal', function() {
        // รีเซ็ต checkbox ที่เกี่ยวข้องกับโมเดลนั้นๆ ที่ถูกเลือกเท่านั้น
        if (lastCheckedCheckbox) {
            lastCheckedCheckbox.prop('checked', false); // รีเซ็ต checkbox ที่ถูกติ๊ก
            lastCheckedCheckbox = null; // รีเซ็ตตัวแปรเพื่อไม่ให้เก็บค่าไว้
        }
        
    });



$(document).on("submit", "#FormRegisRepeatUpdate", function(e) {
    e.preventDefault();
    //console.log($(this).serialize());
    $.ajax({
        url: '<?= site_url('admin/academic/ConAdminRegisRepeat/AdminRegisRepeatAdd') ?>',
        type: 'post',
        data: $(this).serialize(),
        error: function() {
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'ระบบผิดพลาด ลองใหม่อีกครั้ง!',
                showConfirmButton: false,
                timer: 3000
            })
        },
        success: function(data) {
            console.log(data);
            if (data) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'ลงทะเบียนเรียนซ้ำ สำเร็จ!',
                    showConfirmButton: false,
                    timer: 3000
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        location.reload(true);
                    }
                });

            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'warning',
                    title: 'คุณไม่ได้เลือกนักเรียนในการลงทะเบียนเรียนซ้ำ!',
                    showConfirmButton: false,
                    timer: 3000
                })
            }

        }
    });
});
</script>
<?= $this->endSection() ?>
