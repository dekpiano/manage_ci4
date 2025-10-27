<!-- Modal -->
<div class="modal fade" id="ClubSetDateRegister" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-semibold" id="exampleModalLabel">
                        <i class="bi bi-calendar-date me-2"></i>กำหนดวันลงทะเบียนชุมนุม
                    </h5>
                    <small class="text-muted">ตั้งค่าช่วงเวลาการเปิด-ปิดลงทะเบียนชุมนุม</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="FormClubSetDateRegister">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control thaiDateTimeStart" name="c_onoff_regisstart"
                                    id="c_onoff_regisstart" placeholder="เลือกวันที่" value="">
                                <label for="c_onoff_regisstart">วันที่เปิดลงทะเบียน</label>
                            </div>
                            <p id="result"></p>
                        </div>

                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control thaiDateTimeEnd" name="c_onoff_regisend"
                                    id="c_onoff_regisend" placeholder="เลือกวันที่" value="">
                                <label for="c_onoff_regisend">วันที่ปิดลงทะเบียน</label>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning mt-4 border-start border-warning border-4">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="bi bi-exclamation-triangle-fill fs-4 text-warning me-2"></i>
                            </div>
                            <div>
                                <h6 class="alert-heading fw-bold mb-1">หมายเหตุสำคัญ</h6>
                                <p class="mb-0">กรณีที่จะปิดการลงทะเบียนชุมนุม ให้ตั้งวันที่ปิดลงทะเบียนเป็นวันที่ก่อนวันปัจจุบัน</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-primary-subtle">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>ยกเลิก
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-calendar-check me-1"></i>บันทึกวันที่ลงทะเบียน
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>