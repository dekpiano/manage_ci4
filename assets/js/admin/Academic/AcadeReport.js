$('.ShowStudent').DataTable({
    "order": [
        [4, "asc"],
        [1, "asc"]
    ]
});

$('.tblGrade').DataTable({
    "order": [
        [0, "asc"]
    ],
    dom: 'Bfrtip',
    buttons: [
        'copy', 'excel', 'pdf', 'print'
    ]
});

// $('#ReportSummaryTeacher').DataTable({
//     "scrollX": "300px",
//     "order": [
//         [3, "asc"],
//         [0, "asc"]
//     ],
//     "columnDefs": [
//         { "width": "180px", "targets": 0 },
//         { "width": "230px", "targets": 1 },
//         { "width": "50px", "targets": 3 }
//     ]
// });

//admin เกรด นักเรียน
$('#tblGradeSumRoom tbody tr').each(function () {

    var totalGrade = 0;
    var totalUnit = 0;
    var averageGrade = 0;
    var value = 0;

    $(this).find('.showGrade').each(function () {
        var valueUnit = parseFloat($(this).attr('data_unit'));
        var valueGrade = parseFloat($(this).text());

        if (!isNaN(valueGrade)) {
            if (!isNaN(valueUnit)) {
                totalUnit += valueUnit;
            }


            value += valueUnit * valueGrade;

        }
        averageGrade = value / totalUnit;

    });
    //console.log(averageGrade);
    $(this).find('.totalGrade').html(parseFloat(String(averageGrade).substring(0, 4)).toFixed(2));
});

//สรุปผลสัมฤทธื์ คะแนนรวมดี ครู
//หาจำนวนคนของเกรดรวม
$('#ReportSummaryTeacher tbody tr').each(function () {
    var SumGradeGood = 0;
    $(this).find('.showGradeGood').each(function () {
        var ValueGradeGood = parseInt($(this).text())
        if (!isNaN(ValueGradeGood)) {
            SumGradeGood += ValueGradeGood;
        }
    });
    $(this).find('.SumGradeGood').html('<b>' + SumGradeGood + '</b>');
    //console.log(SumGradeGood);
});

// หาผลรวม ร กับ มส
$('#ReportSummaryTeacher tbody tr').each(function () {
    var SumGradeNoGood = 0;
    $(this).find('.showGradeNoGood').each(function () {
        var ValueGradeNoGood = parseInt($(this).text())
        if (!isNaN(ValueGradeNoGood)) {
            SumGradeNoGood += ValueGradeNoGood;
        }
    });
    var value = parseInt($('td', this).eq(14).text());
    $(this).find('.SumGradeNoGood').html('<b>' + (SumGradeNoGood + value) + '</b>');
    // console.log(SumGradeNoGood);
});

//หาร้อยละผลการเรียนดี
$('#ReportSummaryTeacher tbody tr').each(function () {
    var SumPcGood = 0;
    $(this).find('.PC_Good').each(function () {
        var PcGood = parseFloat($(this).text())
        if (!isNaN(PcGood)) {
            SumPcGood += PcGood;
        }
    });
    var value = parseInt($('td', this).eq(17).text());
    $(this).find('.SumPcGood').html('<b>' + parseFloat((SumPcGood / value * 100)).toFixed(2) + '</b>');
    //console.log(SumPcGood);
});

// หาค่าเฉลี่ย
$('#ReportSummaryTeacher tbody tr').each(function () {
    var AvgGrade = 0;
    var G = [4, 3.5, 3, 2.5, 2, 1.5, 1, 0];
    $(this).find('.showGradeGood').each(function (key, val) {
        var ValueGradeGood = parseInt($(this).text())
        if (!isNaN(ValueGradeGood)) {
            AvgGrade += G[key] * ValueGradeGood;
        }
    });
    var value = parseFloat($('td', this).eq(14).text());
    $(this).find('.AvgGrade').html('<b>' + parseFloat(AvgGrade / value).toFixed(2) + '</b>');

});

// หา SD
$('#ReportSummaryTeacher tbody tr').each(function () {
    var AvgSD = 0;
    var G = [4, 3.5, 3, 2.5, 2, 1.5, 1, 0];
    var v_19 = parseFloat($('td', this).eq(19).text()); //ค่าเฉลี่ย
    var v_17 = parseFloat($('td', this).eq(17).text()); //รวม ร มส
    var v_16 = parseFloat($('td', this).eq(16).text()); //มส
    var v_15 = parseFloat($('td', this).eq(15).text()); //ร

    $(this).find('.showGradeGood').each(function (key, val) {
        var ValueGradeGood = parseInt($(this).text())
        if (!isNaN(ValueGradeGood)) {
            AvgSD += ValueGradeGood * (G[key] - v_19) ** 2;
        }
    });
    var SumAvgSD = Math.sqrt(AvgSD / (v_17 - v_16 - v_15));

    $(this).find('.SumAvgSD').html('<b>' + parseFloat(SumAvgSD).toFixed(2) + '</b>');

});

$(document).on("change", "#CheckYearSaveScore", function () {
    let Select_year = $(this).val();
    window.location.href = '../' + Select_year;

});

$(document).on("change", "#SelectRoomReportScore", function () {

    $('.loader').show();
    let SelectRoom = $(this).val();
    let KeyCheckYear = $('#KeyCheckYear').val();
    let term = $('#term').val();
    let year = $('#year').val();
    window.location.href = '../../../' + KeyCheckYear + '/' + SelectRoom;
    //alert(KeyCheckYear);


});

$("#ReportSummaryRoyalRoseStandard tbody tr").each(function () {
    let rowTotal = 0;
    $(this).find(".sum-cell").each(function () {
        let value = parseInt($(this).text(), 10);
        if (!isNaN(value)) {
            rowTotal += value;
        }
    });

    $(this).find(".row-total").text(rowTotal); // ใส่ผลรวมไว้ที่คอลัมน์แรก
});
