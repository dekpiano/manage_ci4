<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0"><?=$title?></h1>
            </div>
            <div class="col-auto">
                <div class="page-utilities">
                    <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                        <div class="col-auto">
                            ปีการศึกษา
                        </div>
                        <div class="col-auto">
                            <select class="form-select w-auto SelTearEnoll" name="SelLern" id="SelLern" key_year="<?=$CheckYearadmission->openyear_year?>">
                                <option value="">เลือกปี...</option>
                                <?php foreach ($SelYear as $key => $v_SelYear) : ?>
                                <option
                                    <?=$CheckYearadmission->openyear_year == $v_SelYear->recruit_year ? "selected" : ""?>
                                    value="<?=$v_SelYear->recruit_year?>"><?=$v_SelYear->recruit_year?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                        <!--//col-->

                    </div>
                    <!--//row-->
                </div>
                <!--//table-utilities-->
            </div>
            <!--//col-auto-->
        </div>
        <!--//row-->

        <div class="app-card  shadow-sm mb-5 p-2 ">
            <div class="app-card-body">
                <div class="table-responsive">
                    <table class="table app-table-hover mb-0 text-left table-bordered TbDataAdmission" id="example" style="">
                        <thead class="text-center table-success">
                            <tr class="align-middle">
                            <th rowspan="2">#</th>
                                <th rowspan="2">ลำดับ</th>
                                <th rowspan="2">ชื่อ - นามสกุล</th>
                                <th rowspan="2">ระดับ</th>
                                <th rowspan="2">รอบสมัคร</th>
                                <th rowspan="2">สายการเรียน</th>
                                <th colspan="3">สถานะ</th>
                            </tr>
                            <tr class="align-middle">
                                <!-- <th colspan="5"></th> -->
                                <th>การสมัคร</th>
                                <th>รายงานตัว</th>
                                <th>มอบตัว</th>
                            </tr>
                        </thead>
                        <tbody>
                       
                        </tbody>
                    </table>
                </div>
                <!--//table-responsive-->

            </div>
            <!--//app-card-body-->
        </div>


    </div>
    <!--//container-fluid-->
</div>
<!--//app-content-->
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    let TbDataAdmission;
    //alert($('#SelLern').attr('key_year'));
    TB_DataAdmission($('#SelLern').attr('key_year'));
    $(document).on('change', '.SelTearEnoll', function() {
        //alert($(this).val());
        TB_DataAdmission($(this).val());
    });

    function TB_DataAdmission(Year) {
        TbDataAdmission = $('.TbDataAdmission').DataTable({
            destroy: true,
            "order": [
                [0, "asc"]
            ],
            'processing': true,
            "ajax": {
                url: "../../../../admin/academic/ConAdminReportResult/AdminReportEnrollData",
                "type": "POST",
                data: { "keyYear": Year }
            },
            'columnDefs': [
                { targets: [0, 1, 3, 4, 6, 7, 8], className: 'dt-center' },
                { width: '300px', targets: [2] }
            ],
            'columns': [{
                    data: 'recruit_id',
                    render: function(data, type, row) {
                        return '<a href="ID/' + data + '">ดูข้อมูล</a>';
                    }
                },
                { data: 'recruit_id' },
                { data: 'recruit_Fullname' },
                {
                    data: 'recruit_regLevel',
                    render: function(data, type, row) {
                        return 'ม.' + data;
                    }
                },
                { data: 'recruit_category' },
                { data: 'recruit_tpyeRoom' },
                {
                    data: 'recruit_status',
                    render: function(data, type, row) {
                        return (data == 'ผ่านการตรวจสอบ' ? '<span class="badge rounded-pill bg-success text-center">ผ่านการตรวจ</span>' : '<span class="badge rounded-pill bg-danger">ไม่ผ่านการตรวจ</span>');
                    }
                },
                {
                    data: 'stu_UpdateConfirm',
                    render: function(data, type, row) {
                        return (data != '' ? '<span class="badge rounded-pill bg-success">รายงานตัวแล้ว</span>' : '<span class="badge rounded-pill bg-danger">รอรายงานตัว</span>');
                    }
                },
                {
                    data: 'recruit_statusSurrender',
                    render: function(data, type, row) {
                        return (data == '' ? '<span class="badge rounded-pill bg-danger">ยังไม่มอบตัว</span>' : '<span class="badge rounded-pill bg-success">มอบตัวแล้ว</span>');
                    }
                }
            ]
        });
    }
</script>
<?= $this->endSection() ?>
