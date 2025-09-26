<style>
table {
    width: 100%;
}

table,
th,
td {
    border: 1px solid black;
    border-collapse: collapse;

}

.text-center {
    text-align: center;
}

.td-work {
    width: 25px;
}
</style>

<div class="text-center">
    <?php 
    $subYear = explode('/',$schoolyear->schyear_year); 
    $SubRoomAll = explode('/',$SubRoom[1]);
    ?>
    <h3>
        รายชื่อนักเรียนชั้นมัธยมศึกษาปีที่ <?=$SubRoomAll[0]?> ห้อง <?=$SubRoomAll[1]?> ภาคเรียนที่ <?=$subYear[0]?> ปีการศึกษา <?=$subYear[1]?> <br>
        ครูที่ปรึกษา: 
        <?php foreach ($TeacRoom as $key => $v_TeacRoom) {
             echo $v_TeacRoom->pers_prefix.$v_TeacRoom->pers_firstname.' '.$v_TeacRoom->pers_lastname.' ';
        } ?>
         </h3>
 
</div>
<table class="table table-bordered mb-0 text-left">
    <thead>
        <tr class="text-center">
            <th class="cell" rowspan="2">ที่</th>
            <th class="cell" rowspan="2">เลขประจำตัว</th>
            <th class="cell" rowspan="2">ชื่อ - นามสกุล</th>
            <th class="cell" rowspan="2">หลักสูตร</th>
            <th class="cell" rowspan="2">สถานะ</th>
            <th colspan="15">งาน</th>
        </tr>
        <tr class="text-center">
            <?php for ($i=1; $i <= 15; $i++) : ?>
            <th class="cell"><?=$i;?></th>
            <?php endfor; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($selStudent as $key => $v_selStudent) : ?>
        <tr>
            <td class="text-center"><?=$v_selStudent->StudentNumber?></td>
            <td class="text-center"><span class="truncate"><?=$v_selStudent->StudentCode?></span></td>
            <td class="cell">
                <?=$v_selStudent->StudentPrefix.$v_selStudent->StudentFirstName.' '.$v_selStudent->StudentLastName?>
            </td>
            <td class="cell text-center"><?=$v_selStudent->StudentStudyLine?></td>
            <td class="cell text-center"><?=$v_selStudent->StudentBehavior?></td>
            <?php for ($i=1; $i <= 15; $i++) : ?>
            <td class="td-work"></td>
            <?php endfor; ?>
        </tr>

        <?php endforeach; ?>

    </tbody>
</table>