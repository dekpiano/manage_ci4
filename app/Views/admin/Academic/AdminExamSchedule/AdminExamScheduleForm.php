<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <section class="cta-section theme-bg-light py-5">
            <div class="container text-center">

                <h2 class="heading">จัดการข้อมูล<?= isset($title) ? esc($title) : '' ?></h2>

            </div>
        </section>

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- DataTales Example -->
            <div class="row justify-content-lg">
                <div class="col-12">
                    <div class="card app-card-settings shadow mb-4 ">

                        <div class="card-body">
                            <form action="<?= site_url('admin/academic/ConAdminExamSchedule/'.(isset($action) ? esc($action, 'url') : ''));?>"
                                class="FormAddExamSchedule">
                                <div class="form-group row mb-3">
                                    <label for="exam_id" class="col-sm-2 col-form-label">รหัส<?= isset($title) ? esc($title) : '' ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly class="form-control" id="exam_id" name="exam_id"
                                            value="<?= (isset($action) && $action == 'insert_exam_schedule') ? (isset($exam_schedule) ? esc($exam_schedule) : '') : (isset($exam_schedule[0]->exam_id) ? esc($exam_schedule[0]->exam_id) : '') ?>"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="exam_type" class="col-sm-2 col-form-label">ประเภท</label>
                                    <div class="col-sm-10">
                                        <select name="exam_type" id="exam_type" class="form-control">
                                            <option value="ตารางสอบกลางภาค">ตารางสอบกลางภาค</option>
                                            <option value="ตารางสอบปลายภาค">ตารางสอบปลายภาค</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="exam_term" class="col-sm-2 col-form-label">ภาคเรียน</label>
                                    <div class="col-sm-10">
                                        <select name="exam_term" id="exam_term" class="form-control">
                                            <option value="1" <?= (isset($exam_schedule[0]->exam_term) && $exam_schedule[0]->exam_term == 1) ? 'selected' : '' ?>> 1</option>
                                            <option value="2" <?= (isset($exam_schedule[0]->exam_term) && $exam_schedule[0]->exam_term == 2) ? 'selected' : '' ?>> 2</option>
                                            <option value="3" <?= (isset($exam_schedule[0]->exam_term) && $exam_schedule[0]->exam_term == 3) ? 'selected' : '' ?>> 3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="exam_year" class="col-sm-2 col-form-label">ปีการศึกษา</label>
                                    <?php $toYear = date("Y",strtotime(date('Y')))+543;?>
                                    <div class="col-sm-10">
                                        <select name="exam_year" id="exam_year" class="form-control">
                                            <?php for ($i = $toYear-2; $i <= $toYear+2; $i++): ?>
                                            <option <?=$toYear==$i?'selected':''?> value="<?= esc($i) ?>"><?= esc($i) ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="exam_filename"
                                        class="col-sm-2 col-form-label">รูป<?= isset($title) ? esc($title) : '' ?></label>
                                    <div class="col-sm-10">
                                        <input type="file" name="exam_filename" id="exam_filename" />
                                        <small id="emailHelp" class="form-text text-muted">PNG / JPG ขนาดไฟล์ไม่เกิน
                                            2
                                            mb</small>
                                        <br>
                                        <img id="previewImage" src="#" alt="Image Preview"
                                            style="display:none; width:100%; height:auto;" />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="exam_filename" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10">
                                        <button type="submit"
                                            class="btn btn-lg app-btn-primary  btn-block"> บันทึก</button>

                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>




        </div>
        <!-- /.container-fluid -->

    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    // แสดงภาพตัวอย่างเมื่อเลือกไฟล์
    $('#exam_filename').on('change', function (event) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#previewImage').attr('src', e.target.result).show();
        }
        reader.readAsDataURL(event.target.files[0]);
    });

    $(document).on('submit','.FormAddExamSchedule', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var action = $(this).attr('action');

        $.ajax({
            url: action,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if(response == 1){
                    Swal.fire({
                        title: "แจ้งเตือน?",
                        text: "คุณเพิ่มตารางสอบเรียบร้อยแล้ว!",
                        icon: "success",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "ตกลง!"
                      }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '../ExamSchedule';
                        }
                      });
                }

            },
            error: function (xhr, status, error) {
                console.log(("Error: " + xhr.responseText));
            }
        });
    });
</script>
<?= $this->endSection() ?>
