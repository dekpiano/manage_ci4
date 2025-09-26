<!-- Modal -->
<div class="modal fade" id="ModalClubSetYear" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">กำหนดปีการศึกษา</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="FormClubSetOnoffYear">
                <div class="modal-body">

                    <div class="d-flex ">
                        <div class="d-flex align-items-center me-3">
                            <label for="c_onoff_year" class=" me-2">ปีการศึกษา:</label>
                            <select class="form-select w-auto" id="c_onoff_year" name="c_onoff_year" required>
                                <option value="2567">2567</option>
                                <option value="2568">2568</option>
                            </select>

                        </div>
                        <div class="d-flex align-items-center me-3">
                            <label for="c_onoff_term" class="me-2">ภาคเรียน:</label>
                            <select class="form-select  w-auto" id="c_onoff_term" name="c_onoff_term" required>
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">บันทึกปีการศึกษา</button>
                </div>
            </form>
        </div>
    </div>
</div>