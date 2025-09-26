<!-- Modal -->
<div class="modal fade" id="ClubSetDateRegister" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">กำหนดปีการศึกษา</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="FormClubSetDateRegister">
                <div class="modal-body">

                    <div class="">
                        <div class="d-flex align-items-center me-3">
                            <label for="c_onoff_year" class=" me-2">วันที่เปิดลงทะเบียน:</label>

                            <input type="text" class="form-control thaiDateTimeStart w-auto" name="c_onoff_regisstart"
                                id="c_onoff_regisstart" placeholder="เลือกวันที่" value="">
                            <p id="result"></p>
                        </div>

                        <div class="d-flex align-items-center me-3 mt-3 ">
                            <label for="c_onoff_term" class="me-2">วันที่ปิดลงทะเบียน:</label>
                            <input type="text" class="form-control thaiDateTimeEnd w-auto" name="c_onoff_regisend"
                                id="c_onoff_regisend" placeholder="เลือกวันที่" value="">
                        </div>

                    </div>
                    <hr>
                    <p>หมายเหตุ** ให้กรณีที่จะปิดการลงทะเบียนชุมนุม ให้ตั้ง วันที่ปิดลงทะเบียน ก่อนวันที่วันนี้</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">บันทึกวันที่ลงทะเบียน</button>
                </div>
            </form>
        </div>
    </div>
</div>