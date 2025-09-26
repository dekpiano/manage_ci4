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
                <div class="d-flex justify-content-between">
                    <h1 class="app-page-title mb-0">จัดการข้อมูล<?= isset($title) ? esc($title) : '' ?></h1>
                    <div>
                    <h4>ปีการศึกษา <?= isset($SchoolYear->schyear_year) ? esc($SchoolYear->schyear_year) : '' ?></h4> 
                    </div>
                </div>      
            </div>
            <hr>

            <section class="we-offer-area">
                <div class="app-card app-card-orders-table pt-2">
                    <div class="app-card-body">
                        <input type="text" name="schyear_year" id="schyear_year" value="<?= isset($SchoolYear->schyear_year) ? esc($SchoolYear->schyear_year) : '' ?>" style="display:none;">
                        <div class="mt-2 d-flex align-items-center justify-content-center">
                            <label for="">เลือกปีลงทะเบียนเรียนซ้ำ </label>
                            <select class="form-select w-auto ms-2" id="CheckYearRegisRepeat" name="CheckYearRegisRepeat">
                                <?php foreach ($GroupYear as $key => $v_GroupYear) : ?>
                                <option <?= (isset($SchoolYear->schyear_year) && isset($v_GroupYear->SubjectYear) && $SchoolYear->schyear_year == $v_GroupYear->SubjectYear) ? "selected" : "" ?> value="<?= isset($v_GroupYear->SubjectYear) ? esc($v_GroupYear->SubjectYear) : '' ?>"><?= isset($v_GroupYear->SubjectYear) ? esc($v_GroupYear->SubjectYear) : '' ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="table-responsive  p-3">
                            <table class="table app-table-hover mb-0 text-left" id="tbRegisRepeatSubject">
                                <thead>
                                    <tr>
                                        <th class="cell">เรียนปี</th>
                                        <th class="cell">รหัสวิชา</th>
                                        <th class="cell">ชื่อวิชา</th>
                                        <th class="cell">กลุ่มสาระ</th>
                                        <th class="cell">ชั้น</th>
                                        <th class="cell">ครูผู้สอน</th>
                                        <th class="cell">คำสั่ง</th>
                                        <th class="cell">เรียนซ้ำ</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                        <!--//table-responsive-->
                    </div>
                    <!--//app-card-body-->
                </div>


            </section>


            <!--//row-->
        </div>



    </div>
    <!--//main-wrapper-->


    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title ShowSubjectName" id="staticBackdropLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover" id="tb_ShowRegisRepeat">
                        <thead>
                            <tr>
                                <th scope="col">ห้อง</th>
                                <th scope="col">เลขที่</th>
                                <th scope="col">เลขประจำตัว</th>
                                <th scope="col">ชื่อ - นามสกุล</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>

                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
let tbRegisRepeatSubject;
TB_RegisRepeatSubject($('#schyear_year').val());
$(document).on('change', '#CheckYearRegisRepeat', function() {
    //alert($(this).val());
    TB_RegisRepeatSubject($(this).val());
});

function TB_RegisRepeatSubject(Year) {
    tbRegisRepeatSubject = $('#tbRegisRepeatSubject').DataTable({
        destroy: true,
        "order": [
            [7, "desc"]
        ],
        'processing': true,
        "ajax": {
            url: "<?= site_url('admin/academic/ConAdminRegisRepeat/AdminRegisRepeatShow') ?>",
            "type": "POST",
            data: { "keyYear": Year }
        },
        'columns': [
            { data: 'SubjectYear' },
            { data: 'SubjectCode' },
            { data: 'SubjectName' },
            { data: 'FirstGroup' },
            { data: 'SubjectClass' },
            {
                data: 'TeacherName',
                render: function(data, type, row) {
                    return data;
                }
            },
            {
                data: 'SubjectID',
                render: function(data, type, row) {
                    return '<a class="btn-sm app-btn-primary" href="<?= site_url('Repeat/Detail/') ?>' + (row.SubjectYear ? row.SubjectYear : '') + '/' + (row.SubjectCode ? row.SubjectCode : '') + '/' + (row.TeacherID ? row.TeacherID : '') +'">ลงทะเบียนเรียนซ้ำ</a>';
                }
            },
            {
                data: 'SumRepeat',
                render: function(data, type, row) {
                    return '<span class="badge bg-warning text-black-50">' +data +' คน </span>';
                }
            }
        ]
    });
}

// The following functions related to displaying student details and canceling repeat registration
// will be placed here based on the original Academic.js structure.
$(document).on("click", ".ShowRegisRepeat", function() {

    $('#tb_ShowRegisRepeat tbody tr').remove();

    $.post("<?= site_url('admin/academic/ConAdminRegisRepeat/AdminRegisRepeatShow') ?>", {
        subid: $(this).attr('sub-id'),
        teachid: $(this).attr('teach-id')
    }, function(data, status) {
        //console.log(data);
        $('.ShowSubjectName').html("วิชา " + (data[0].SubjectName ? data[0].SubjectName : '') + "<br>ครูผู้สอน " + (data[0].pers_prefix ? data[0].pers_prefix : '') + (data[0].pers_firstname ? data[0].pers_firstname : '') + ' ' + (data[0].pers_lastname ? data[0].pers_lastname : ''));
        $.each(data, function(index, value) {
            $('#tb_ShowRegisRepeat tbody').append('<tr class="DelTableRow"><td>' + (value.StudentClass ? value.StudentClass : '') + '</td><td>' + (value.StudentNumber ? value.StudentNumber : '') + '</td><td>' + (value.StudentCode ? value.StudentCode : '') + '</td><td>' + (value.StudentPrefix ? value.StudentPrefix : '') + (value.StudentFirstName ? value.StudentFirstName : '') + ' ' + (value.StudentLastName ? value.StudentLastName : '') + '</td></tr>');
        });
    }, 'json');

});

$(document).on("click", ".CancelRegisRepeat", function() {
    console.log($(this).attr('key-teacher'));
    Swal.fire({
        title: 'ต้องการลบการลงทะเบียนหรือไม่?',
        text: 'เมื่อลบการลงทะเบียนวิชานี้แล้ว คะแนนและรายชื่อนักเรียนในวิชานี้ จะถูกลบทั้งหมด',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
    }).then((result) => {
        if (result.isConfirmed) {
            $(this).parents('tr').remove();

            $.post("<?= site_url('admin/academic/ConAdminRegisRepeat/AdminRegisRepeatCancel') ?>", {
                KeyTeacher: $(this).attr('key-teacher'),
                KeySubject: $(this).attr('key-subject')
            }, function(data, status) {
                console.log(data);

            });

            Swal.fire(
                'ลบข้อมูลเรียบร้อย!',
                'Your data has been deleted.',
                'success'
            )
        }
    })
});
</script>
<?= $this->endSection() ?>
