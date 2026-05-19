<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">งานแนะแนว /</span> <?= $title ?>
    </h4>

    <div class="row g-4">
        <!-- Master: Student List -->
        <div class="col-xl-8 col-lg-7">
            <div class="card h-100">
                <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center border-bottom mb-2">
                    <h5 class="mb-3 mb-md-0"><i class="bx bx-group me-2"></i>รายชื่อผู้สมัคร</h5>
                    <div class="d-flex align-items-center">
                        <label for="SelLern" class="me-2 mb-0 text-nowrap">ปีการศึกษา</label>
                        <select class="form-select w-auto SelTearEnoll" name="SelLern" id="SelLern" key_year="<?= $CheckYearadmission->openyear_year ?>">
                            <option value="">เลือกปี...</option>
                            <?php foreach ($SelYear as $key => $v_SelYear) : ?>
                                <option <?= $CheckYearadmission->openyear_year == $v_SelYear->recruit_year ? "selected" : "" ?> value="<?= $v_SelYear->recruit_year ?>"><?= $v_SelYear->recruit_year ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover TbDataAdmission w-100 cursor-pointer">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>รหัสสมัคร</th>
                                    <th>ชื่อ - นามสกุล</th>
                                    <th>ระดับ</th>
                                    <th>รอบสมัคร</th>
                                    <th>ผลการตัดสิน</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail: Student Information -->
        <div class="col-xl-4 col-lg-5">
            <div class="card sticky-top" style="top: 100px; z-index: 100;">
                <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="mb-0"><i class="bx bx-user me-2"></i>รายละเอียดข้อมูล</h5>
                    <div id="detailActions" style="display: none;">
                        <button class="btn btn-sm btn-icon btn-outline-secondary" onclick="closeDetail()"><i class="bx bx-x"></i></button>
                    </div>
                </div>
                <div class="card-body" id="studentDetailContainer">
                    <div class="text-center py-5" id="noSelectionMessage">
                        <div class="avatar avatar-xl bg-label-secondary mx-auto mb-3">
                            <i class="bx bx-search-alt-2 fs-1"></i>
                        </div>
                        <h6 class="text-muted">กรุณาเลือกรายชื่อนักเรียน<br>เพื่อดูรายละเอียดข้อมูล</h6>
                    </div>
                    
                    <!-- Detail Content -->
                    <div id="studentDetailContent" style="display: none;">
                        <div class="user-avatar-section mb-4">
                            <div class="d-flex align-items-center flex-column">
                                <img id="detImg" class="img-fluid rounded my-3 shadow-sm" src="" height="120" width="120" alt="Avatar" />
                                <div class="user-info text-center">
                                    <h5 class="mb-1" id="detName">-</h5>
                                    <span class="badge bg-label-info" id="detLevel">-</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="info-container">
                            <ul class="list-unstyled border-top pt-3">
                                <li class="mb-2 d-flex justify-content-between">
                                    <span class="fw-bold text-muted small text-uppercase">เลขบัตรประชาชน:</span>
                                    <span id="detIden" class="fw-medium">-</span>
                                </li>
                                <li class="mb-2 d-flex justify-content-between">
                                    <span class="fw-bold text-muted small text-uppercase">วันเกิด:</span>
                                    <span id="detBirth">-</span>
                                </li>
                                <li class="mb-2 d-flex justify-content-between">
                                    <span class="fw-bold text-muted small text-uppercase">เบอร์โทรศัพท์:</span>
                                    <span class="text-primary fw-bold" id="detPhone">-</span>
                                </li>
                                <li class="mb-2 d-flex justify-content-between">
                                    <span class="fw-bold text-muted small text-uppercase">รอบที่สมัคร:</span>
                                    <span id="detCategory">-</span>
                                </li>
                                <li class="mb-2">
                                    <span class="fw-bold text-muted small text-uppercase">สายการเรียน:</span>
                                    <div class="mt-1 small text-dark fw-medium" id="detTypeRoom">-</div>
                                </li>
                            </ul>
                            
                            <div class="mt-4 p-3 bg-light rounded border">
                                <h6 class="text-uppercase small fw-bold text-muted mb-3 border-bottom pb-2">สถานะดำเนินการปัจจุบัน</h6>
                                <div class="d-flex flex-column gap-2" id="detStatusList">
                                    <!-- Dynamic Status -->
                                </div>
                            </div>

                            <div class="d-grid mt-4 pt-2">
                                <a id="detFullLink" href="#" class="btn btn-outline-primary btn-sm">ดูข้อมูลเต็มรูปแบบ <i class="bx bx-right-arrow-alt ms-1"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Loading Spinner -->
                    <div id="detailLoading" class="text-center py-5" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">กำลังดึงข้อมูล...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<style>
    .cursor-pointer tbody tr { cursor: pointer; }
    .table-hover tbody tr.selected { background-color: rgba(21, 163, 98, 0.08) !important; border-left: 4px solid #15a362; }
    
    /* Green highlight and theme adjustments */
    .text-primary { color: #15a362 !important; }
    .btn-outline-primary {
        color: #15a362;
        border-color: #15a362;
    }
    .btn-outline-primary:hover {
        background-color: #15a362 !important;
        border-color: #15a362 !important;
        color: #fff !important;
    }
    .spinner-border.text-primary {
        color: #15a362 !important;
    }
    .bg-label-primary {
        background-color: rgba(21, 163, 98, 0.08) !important;
        color: #15a362 !important;
    }
    .page-item.active .page-link {
        background-color: #15a362 !important;
        border-color: #15a362 !important;
    }
    .form-select:focus {
        border-color: #15a362 !important;
        box-shadow: 0 0 0 0.25rem rgba(21, 163, 98, 0.25) !important;
    }
</style>

<script>
    let TbDataAdmission;
    
    // Client-side Thai Buddhist Era Date Formatter
    function formatThaiDate(dateStr) {
        if (!dateStr || dateStr === '-' || dateStr === '0000-00-00') return '-';
        
        // If already in Thai format
        if (dateStr.includes('พ.ศ.') || dateStr.includes('ม.ค.') || dateStr.includes('ก.พ.')) {
            return dateStr;
        }
        
        let parts = dateStr.split('-');
        if (parts.length !== 3) return dateStr;
        
        let year = parseInt(parts[0]);
        let month = parseInt(parts[1]);
        let day = parseInt(parts[2]);
        
        if (isNaN(year) || isNaN(month) || isNaN(day)) return dateStr;
        
        // Convert to Buddhist Era (พ.ศ.)
        if (year < 2400) year += 543;
        
        const shortMonths = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
        return day + ' ' + shortMonths[month - 1] + ' ' + year;
    }

    $(document).ready(function() {
        TB_DataAdmission($('#SelLern').attr('key_year'));
        
        $(document).on('change', '.SelTearEnoll', function() {
            TB_DataAdmission($(this).val());
            closeDetail();
        });

        $(document).on('click', '.TbDataAdmission tbody tr', function() {
            if ($(this).find('.dataTables_empty').length > 0) return;
            
            $('.TbDataAdmission tbody tr').removeClass('selected');
            $(this).addClass('selected');
            
            let rowData = TbDataAdmission.row(this).data();
            if (rowData) {
                viewStudentDetail(rowData.recruit_id);
            }
        });
    });

    function viewStudentDetail(id) {
        $('#noSelectionMessage').hide();
        $('#studentDetailContent').hide();
        $('#detailLoading').show();
        $('#detailActions').show();

        $.ajax({
            url: "<?= base_url('Admin/Acade/Executive/ReportEnroll/ID') ?>/" + id,
            type: "GET",
            dataType: "json",
            success: function(res) {
                $('#detailLoading').hide();
                $('#studentDetailContent').fadeIn();
                
                let student = res.DataStudent;
                $('#detName').text((student && student.stu_prefix || '') + (student && student.stu_fristName || '') + ' ' + (student && student.stu_lastName || ''));
                $('#detLevel').text('ม.' + res.recruit_regLevel);
                $('#detIden').text(student && student.stu_iden || '-');
                
                // Formatted Thai Buddhist Era birthDay
                $('#detBirth').text(formatThaiDate(student && student.stu_birthDay || res.recruitData && res.recruitData.recruit_birthday || '-'));
                
                $('#detPhone').text(student && student.stu_phone || '-');
                $('#detCategory').text(res.recruit_category || '-');
                $('#detTypeRoom').text(res.recruit_tpyeRoom || '-');
                
                let imgUrl = 'https://admission.skj.ac.th/uploads/recruitstudent/m' + res.recruit_regLevel + '/img/' + res.recruit_img;
                $('#detImg').attr('src', imgUrl).on('error', function() {
                    $(this).attr('src', 'https://ui-avatars.com/api/?name=' + (student && student.stu_fristName || 'Student') + '&color=15a362&background=e0f2f1');
                });

                // Status List
                let statusHtml = '';
                
                // 1. ผลการตัดสิน (Final Status)
                statusHtml += '<div class="mb-3"><span class="badge bg-label-success mb-1 w-100 py-2"><i class="bx bx-award me-1"></i> ผลการตัดสิน: ' + (res.recruit_statusFinal || 'รอดำเนินการ') + '</span></div>';
                
                // 2. การสมัคร
                if (res.recruit_status == 'ผ่านการตรวจสอบ') {
                    statusHtml += '<div class="d-flex align-items-center text-success mb-2 small"><i class="bx bxs-check-circle me-2"></i> การสมัคร: ผ่านการตรวจ</div>';
                } else {
                    statusHtml += '<div class="d-flex align-items-center text-danger mb-2 small"><i class="bx bxs-x-circle me-2"></i> การสมัคร: ' + (res.recruit_status || 'ไม่ระบุ') + '</div>';
                }
                
                // 3. รายงานตัว
                if (student && student.stu_UpdateConfirm && student.stu_UpdateConfirm != '') {
                    statusHtml += '<div class="d-flex align-items-center text-success mb-2 small"><i class="bx bxs-check-circle me-2"></i> รายงานตัว: เรียบร้อย</div>';
                } else {
                    statusHtml += '<div class="d-flex align-items-center text-warning mb-2 small"><i class="bx bxs-time me-2"></i> รายงานตัว: รอการดำเนินการ</div>';
                }
                
                // 4. มอบตัว
                if (res.recruit_statusSurrender && res.recruit_statusSurrender != '') {
                    statusHtml += '<div class="d-flex align-items-center text-success mb-0 small"><i class="bx bxs-check-circle me-2"></i> มอบตัว: ' + res.recruit_statusSurrender + '</div>';
                } else {
                    statusHtml += '<div class="d-flex align-items-center text-secondary mb-0 small"><i class="bx bx-minus-circle me-2"></i> มอบตัว: ยังไม่ดำเนินการ</div>';
                }
                
                $('#detStatusList').html(statusHtml);
                $('#detFullLink').attr('href', "<?= base_url('Admin/Acade/Executive/ReportEnroll/ID') ?>/" + id);
            },
            error: function() {
                Swal.fire('ผิดพลาด!', 'ไม่สามารถดึงข้อมูลได้', 'error');
                closeDetail();
            }
        });
    }

    function closeDetail() {
        $('.TbDataAdmission tbody tr').removeClass('selected');
        $('#studentDetailContent').hide();
        $('#detailActions').hide();
        $('#detailLoading').hide();
        $('#noSelectionMessage').fadeIn();
    }

    function TB_DataAdmission(Year) {
        if (!Year) return;
        
        TbDataAdmission = $('.TbDataAdmission').DataTable({
            destroy: true,
            pageLength: 15,
            "order": [[1, "asc"]],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Thai.json"
            },
            'processing': true,
            "ajax": {
                url: "<?= base_url('Admin/Acade/Executive/ReportEnroll/Data') ?>",
                "type": "POST",
                data: { "keyYear": Year }
            },
            'columnDefs': [
                { targets: [0, 3, 5], className: 'dt-center' },
            ],
            'columns': [
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                { data: 'recruit_id' },
                { 
                    data: 'recruit_Fullname',
                    render: function(data, type, row) {
                        return '<span class="fw-medium text-success">' + data + '</span>';
                    }
                },
                {
                    data: 'recruit_regLevel',
                    render: function(data, type, row) {
                        return '<span class="badge bg-label-info">ม.' + data + '</span>';
                    }
                },
                { data: 'recruit_category' },
                {
                    data: 'recruit_statusFinal',
                    render: function(data, type, row) {
                        return '<span class="badge bg-label-success">' + (data || '-') + '</span>';
                    }
                }
            ]
        });
    }
</script>
<?= $this->endSection() ?>
