<style>
.form-check-switch-label {
    display: flex;
    align-items: center;
    position: relative;
    padding-left: 3.5rem;
    cursor: pointer;
}

.form-check-input:checked+.form-check-switch-label::before {
    content: 'เปิด';
    color: white;
    text-align: center;
    position: absolute;
    left: 0;
    width: 3rem;
    line-height: 1.25rem;
}

.form-check-input+.form-check-switch-label::before {
    content: 'ปิด';
    background-color: #6c757d;
    color: white;
    text-align: center;
    position: absolute;
    left: 0;
    width: 3rem;
    height: 1.25rem;
    border-radius: 1.25rem;
    line-height: 1.25rem;
    transition: all 0.3s ease;
}

.form-check-input:checked+.form-check-switch-label::before {
    background-color: #15a362;
    left: 1.25rem;
}

.form-check-input {
    display: none;
}
</style>
<!-- Modal -->
<div class="modal fade" id="ClubSetDateAttendance" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ขัอมูลเวลาเรียนปีการศึกษา
                    <?= isset($CheckOnoffClub->c_onoff_year) ? esc($CheckOnoffClub->c_onoff_year) : '' ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="FormClubSetDateAttendance">
                <div class="modal-body">

                    <div class="table-responsive">
                        <table class="table app-table-hover mb-0 text-left" id="TbDateWeeks">
                            <thead>
                                <tr class="text-center">
                                    <th class="cell">ครั้งที่</th>
                                    <th class="cell">วันที่เรียน</th>
                                    <th class="cell">สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>