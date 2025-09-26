<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">

        <div class="container mt-4">
            <!-- Dashboard Header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-4">
                    <h1 class="h3">แดชบอร์ดระบบชุมนุม</h1>
                    <p class="text-muted">ภาพรวมข้อมูลเกี่ยวกับชุมนุม</p>

                </div>

                <div class="d-flex">
                <div class="app-utility-item app-user-dropdown dropdown">
                        <a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown" href="#"
                            role="button" aria-expanded="false"><i class="bi bi-gear-fill icon"></i> ตั้งค่าพื้นฐาน</a>
                        <ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle" style="">
                            <li><a class="dropdown-item" href="#" id="MenuSetDateAttendancer">ตั้งค่าเวลาเรียน</a></li>
                        </ul>
                    </div>

                    <div class="app-utility-item app-user-dropdown dropdown">
                        <a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown" href="#"
                            role="button" aria-expanded="false"><i class="bi bi-gear-fill icon"></i> ตั้งค่าระบบ</a>
                        <ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle" style="">
                            <li><a class="dropdown-item" href="#" id="MenuSetYear">ตั้งค่าปีการศึกษา</a></li>
                            <li><a class="dropdown-item" href="#" id="MenuSetDateRegister">ตั้งค่าเปิด-ปิดระบบ</a>
                            </li>

                        </ul>
                    </div>

                    <a class="btn app-btn-primary"
                        href="<?= site_url('Admin/Acade/DevelopStudents/Clubs/All') ?>"><i class="bi bi-menu-button-wide"></i> จัดการชุมนุม</a>
                </div>
            </div>

            <?php $Status = isset($StatusOnoffClub) && $StatusOnoffClub == "เปิด"? "success" : "danger";
            $Icon = isset($StatusOnoffClub) && $StatusOnoffClub == "เปิด"? '<i class="bi bi-check-circle"></i>' : '<i class="bi bi-x-circle"></i>';
            ?>
            <div class="">
                <div class="app-card app-card-chart h-100 shadow-sm mb-3 ">
                    <div class="app-card-header p-3 bg-<?= esc($Status) ?> text-white">
                        <?php $ExYearClub = isset($CheckOnoffClub->c_onoff_year) ? explode(' / ',$CheckOnoffClub->c_onoff_year) : ['','']; ?>
                        กำหนดการลงทะเบียนกิจกรรมชุมนุม ภาคเรียนที่ <?= esc($ExYearClub[1]) ?> ปีการศึกษา
                        <?= esc($ExYearClub[0]) ?>
                    </div>
                    <div class="app-card-body p-3 p-lg-4 d-flex justify-content-between align-items-center">
                        <div>
                            <div>เปิดวันที่
                                <span class="fw-bold">
                                    <?php echo isset($CheckOnoffClub->c_onoff_regisstart) ? $this->datethai->thai_date_and_time(strtotime($CheckOnoffClub->c_onoff_regisstart)) : '' ?>
                                </span>

                            </div>
                            <div>ถึงวันที่
                                <span class="fw-bold">
                                    <?php echo isset($CheckOnoffClub->c_onoff_regisend) ? $this->datethai->thai_date_and_time(strtotime($CheckOnoffClub->c_onoff_regisend)) : '' ?>
                                </span>
                            </div>
                        </div>
                        <div>
                            
                            <a class=" text-white btn btn-<?= esc($Status) ?>"
                                href="https://themes.3rdwavemedia.com/bootstrap-templates/admin-dashboard/portal-free-bootstrap-admin-dashboard-template-for-developers/">สถานะ
                                : <?= $Icon ?> <?= isset($StatusOnoffClub) ? esc($StatusOnoffClub) : '' ?>ลงทะเบียน</a>
                        </div>


                    </div>
                </div>
            </div>
            <!-- Cards Section -->
            <div class="row">
                <!-- Card 1: ชุมนุมทั้งหมด -->
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <div class="card-icon bg-primary mb-3">
                                <i class="fas fa-users"></i>
                            </div>
                            <h5 class="card-title">ชุมนุมทั้งหมด</h5>
                            <h2><?= isset($TotalClubs) ? count($TotalClubs) : 0 ?></h2>
                            <p class="text-muted">ปีการศึกษา 2567</p>
                            <p>
                                <a class="btn btn-primary"
                                    href="<?= site_url('Admin/Acade/DevelopStudents/Clubs/All') ?>">ดูทั้งหมด</a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card 2: นักเรียนทั้งหมด -->
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <div class="card-icon bg-success mb-3">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <h5 class="card-title">นักเรียนลงทะเบียน</h5>
                            <h2><?= isset($TotalStudent[0]->StudentAll) ? esc($TotalStudent[0]->StudentAll) : 0 ?></h2>
                            <p class="text-muted">ทั้งหมด</p>
                            <p><button class="btn btn-success BtnShowStudent" id="BtnShowStudent">ดูทั้งหมด</button>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card 3: ครูที่ปรึกษา -->
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <div class="card-icon bg-warning mb-3">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <h5 class="card-title">ครูที่ปรึกษาชุมนุม</h5>
                            <h2><?= isset($TotalTeacher[0]->total_advisors) ? esc($TotalTeacher[0]->total_advisors) : 0 ?></h2>
                            <p class="text-muted">ในระบบ</p>
                        </div>
                    </div>
                </div>

                <!-- Card 4: ชุมนุมยอดนิยม -->
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <div class="card-icon bg-danger mb-3">
                                <i class="fas fa-star"></i>
                            </div>
                            <h5 class="card-title">ชุมนุมยอดนิยม</h5>
                            <h2><?= isset($ClubPopula->club_name) ? esc($ClubPopula->club_name) : '' ?></h2>
                            <p class="text-muted">'<?= isset($ClubPopula->total_members) ? esc($ClubPopula->total_members) : '' ?> คน'</p>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<!-- Modal ดูนักเรียนที่ลงทะเบียน -->
<div class="modal fade" id="ModalShowStudentRegisterToClub" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">รายชื่อนักเรียนที่ลงทะเบียนชุมนุม</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="classFilter" class="form-label">เลือกห้องเรียน</label>
                    <select id="classFilter" class="">
                        <option value="">ทั้งหมด</option>
                        <!-- Options จะถูกสร้างด้วยข้อมูลห้องเรียนจากฐานข้อมูล -->
                    </select>
                </div>
                <table id="TbStudentRegisterClub" class="table table-bordered table-hover w-100">
                    <thead>
                        <tr>
                            <th>รหัสนักเรียน</th>
                            <th>ชื่อนักเรียน</th>
                            <th>เลขที่</th>
                            <th>ห้องเรียน</th>
                            <th>ชุมนุม</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?= view('admin/Academic/AdminDevelopStudents/Clubs/AdminClubSetYear.php'); ?>
<?= view('admin/Academic/AdminDevelopStudents/Clubs/AdminClubSetDateRegister.php'); ?>
<?= view('admin/Academic/AdminDevelopStudents/Clubs/AdminClubSetDateAttendance.php'); ?>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
//---------------------- แดชบอร์ด ---------------------------
const classFilter = new SlimSelect({
    select: '#classFilter',
    showSearch: true, // เปิดให้สามารถค้นหาได้
    allowDeselect: true, // สามารถเลือกได้มากกว่า 1
});


// ฟังก์ชันแปลงวันที่จาก "24 พฤศจิกายน 2024" เป็น "2024/11/24"
function convertThaiDateToISO(dateString) {
    // รายชื่อเดือนภาษาไทย
    const thaiMonths = [
        "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
        "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
    ];

    // แยกส่วนวันที่
    const dateParts = dateString.split(" "); // [ "24", "พฤศจิกายน", "2024" ]
    const day = dateParts[0]; // วันที่
    const month = thaiMonths.indexOf(dateParts[1]) + 1; // เดือน (หาค่าดัชนีจากเดือน)
    const year = dateParts[2]; // ปี ค.ศ.

    // ตรวจสอบว่าแปลงสำเร็จหรือไม่
    if (!day || !month || !year) {
        console.error("รูปแบบวันที่ไม่ถูกต้อง!");
        return null;
    }

    // คืนค่ารูปแบบ "YYYY/MM/DD"
    return `${year}/${month.toString().padStart(2, '0')}/${day.padStart(2, '0')}`;
}

//ดูข้อมูลนักเรียน
$(document).on('click', '.BtnShowStudent', function () {   
    $('#ModalShowStudentRegisterToClub').modal('show');

    $.ajax({
        url: '<?= site_url('admin/academic/ConAdminDevelopStudents/ClubGetClassroom') ?>',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log(response);
            
            var classFilter = $('#classFilter');
            response.classrooms.forEach(function(classroom) {
                classFilter.append('<option value="'+ classroom.StudentClass +'">'+ classroom.StudentClass +'</option>');
            });
        }
    });
});

var TbStudentRegisterClub = $('#TbStudentRegisterClub').DataTable({
    autoWidth: false, // ปิดการตั้งค่าความกว้างอัตโนมัติ
    responsive: true,
    order: [[3, 'asc'], [2, 'asc']],
    ajax: {
        url: '<?= site_url('admin/academic/ConAdminDevelopStudents/ClubGetStudentRegisterClub') ?>',
        type: 'GET',
        dataType: 'json',
        data: function(d) {
            d.classFilter = $('#classFilter').val(); // ส่งค่าที่เลือกจาก Dropdown ไป
        }
    },
    columns: [
        { data: 'StudentCode',title: 'รหัสนักเรียน' },
        { data: 'Fullname', title: 'ชื่อ - สกุล' },
        { data: 'StudentNumber', title: 'เลขที่' },
        { data: 'StudentClass', title: 'ห้องเรียน' },
        { data: 'club_status', title: 'สถานะชุมนุม',
            render: function(data, type, row) {
                if (data === 'ยังไม่ได้เลือกชุมนุม') {
                    return `<span class="badge bg-danger">${data}</span>`;
                } else {
                    return `<span class="badge bg-success">${data}</span>`;
                }
            }
         }
    ],
    dom: 'Bfrtip', // เพิ่มปุ่ม
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'ดาวน์โหลด Excel',
                className: 'btn btn-success',
                 title: 'รายงานข้อมูลนักเรียนที่ลงทะเบียนชุมนุม',
                filename:'รายงานข้อมูลนักเรียนที่ลงทะเบียนชุมนุม'
            },
            {
                extend: 'print',
                text: 'พิมพ์รายงาน',
                className: 'btn btn-primary',
                 title: 'รายงานข้อมูลนักเรียนที่ลงทะเบียนชุมนุม',
                filename:'รายงานข้อมูลนักเรียนที่ลงทะเบียนชุมนุม'
            }
        ],
    responsive: true,
    language: {
        url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/th.json" // เพิ่มภาษาไทย
    }
});

// เมื่อเลือกห้องเรียนใหม่
$('#classFilter').on('change', function() {
    TbStudentRegisterClub.ajax.reload(); // รีเฟรชข้อมูล
});

// กำหนดปีการศึกษา
$(document).on('click', '#MenuSetYear', function () { 
    $('#ModalClubSetYear').modal('show');
 });

 $(document).on('submit','#FormClubSetOnoffYear',function (e) {
    e.preventDefault();
    // ดึงค่าจากฟอร์ม
    const c_onoff_term = $('#c_onoff_term').val();
    const c_onoff_year = $('#c_onoff_year').val();

    // ตรวจสอบค่าก่อนส่ง
    if (!c_onoff_term || !c_onoff_year) {
        alert('กรุณากรอกข้อมูลให้ครบถ้วน');
        return;
    }

    // ส่งข้อมูลผ่าน AJAX
    $.ajax({
        url: '<?= site_url('admin/academic/ConAdminDevelopStudents/ClubSetOnoffYear') ?>', // ชี้ไปที่ Controller
        type: 'POST',
        dataType: 'json',
        data: {
            c_onoff_term: c_onoff_term,
            c_onoff_year: c_onoff_year
        },
        success: function (response) {
            if (response.status === 'success') {
                        
                $('#ModalClubSetYear').modal('hide');
                $('.modal-backdrop').remove();  
                Swal.fire({
                    title: "แจ้งเตือน?",
                    text: response.message,
                    icon: "success",
                  }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                  });
 
            } else {
                Swal.fire({
                    icon: "error",
                    title: "แจ้งเตือน!",
                    text: response.message
                });
            }
        },
        error: function () {
            $('#responseMessage').html(`<div class="alert alert-danger">เกิดข้อผิดพลาดในการบันทึกข้อมูล</div>`);
        }
    });
});

$(document).on('click', '#MenuSetDateRegister', function () { 
    $('#ClubSetDateRegister').modal('show');
    $.ajax({
        url: '<?= site_url('admin/academic/ConAdminDevelopStudents/ClubGetDateRegister') ?>', // URL ของ PHP ที่ดึงข้อมูล
        method: 'GET',
        dataType: 'json',
        success: function (response) {

            var c_onoff_regisstart = response.datetime.c_onoff_regisstart;
            var c_onoff_regisend = response.datetime.c_onoff_regisend;

            // แปลงค่าให้เป็น Date Object (เพื่อป้องกันการแปลง Time Zone ผิด)
            var TimeStart = new Date(c_onoff_regisstart);
            var TimeEnd = new Date(c_onoff_regisend);
            // ใช้งาน Flatpickr พร้อมตั้งค่าภาษาไทย
            flatpickr(".thaiDateTimeStart", {
                enableTime: true, // เปิดเลือกเวลา
                dateFormat: "d F Y H:i", // กำหนดรูปแบบวันที่เวลา
                locale: "th", // ตั้งค่าภาษาไทย
                disableMobile: true ,
                defaultDate: TimeStart,
            });

            flatpickr(".thaiDateTimeEnd", {
                enableTime: true, // เปิดเลือกเวลา
                dateFormat: "d F Y H:i", // กำหนดรูปแบบวันที่เวลา
                locale: "th", // ตั้งค่าภาษาไทย
                disableMobile: true ,
                defaultDate: TimeEnd,
            });
        },
        error: function (xhr, status, error) {
            console.error("Error fetching date:", error);
        }
    });


   
 });



$(document).on('submit','#FormClubSetDateRegister',function (e) {
    e.preventDefault();
    // ดึงค่าจากฟอร์ม
    const c_onoff_regisstart = $('#c_onoff_regisstart').val();
    const c_onoff_regisend = $('#c_onoff_regisend').val();
    
    // ตรวจสอบค่าก่อนส่ง
    if (!c_onoff_regisstart || !c_onoff_regisend) {
        alert('กรุณากรอกข้อมูลให้ครบถ้วน');
        return;
    }

    // ส่งข้อมูลผ่าน AJAX
    $.ajax({
        url: '<?= site_url('admin/academic/ConAdminDevelopStudents/ClubSetDateRegister') ?>', // ชี้ไปที่ Controller
        type: 'POST',
        dataType: 'json',
        data: {
            c_onoff_regisstart: c_onoff_regisstart,
            c_onoff_regisend: c_onoff_regisend
        },
        success: function (response) {
            if (response.status === 'success') {
                       
                $('#ClubSetDateRegister').modal('hide');
                $('#FormClubSetDateRegister')[0].reset();
                $('.modal-backdrop').remove();   
                Swal.fire({
                    title: "แจ้งเตือน?",
                    text: response.message,
                    icon: "success",
                  }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                  });

                
            } else {
                Swal.fire({
                    icon: "error",
                    title: "แจ้งเตือน!",
                    text: response.message
                });
            }
        },
        error: function () {
            $('#responseMessage').html(`<div class="alert alert-danger">เกิดข้อผิดพลาดในการบันทึกข้อมูล</div>`);
        }
    });
});


$(document).on('click', '#MenuSetDateAttendancer', function () { 
    $('#ClubSetDateAttendance').modal('show');
    

    $.ajax({
        url: '<?= site_url('admin/academic/ConAdminDevelopStudents/ClubGetWeeksToUpdate') ?>', // URL ของ Controller
        type: 'GET',                    // ประเภทคำขอ
        dataType: 'json',               // ประเภทข้อมูลที่รับมา
        success: function (response) {
            
            if (response.status === 'success') {
                response.data.forEach(function (week, index) {

                    var TimeEnd = new Date(week.tcs_start_date);

                    flatpickr("#tcs_academic_year"+(index+1), {
                        altFormat: "d m Y",
                        dateFormat: "d F Y", // กำหนดรูปแบบวันที่เวลา
                        locale: "th", // ตั้งค่าภาษาไทย
                        disableMobile: true ,
                        defaultDate: TimeEnd,
                        onChange: function (selectedDates, dateStr, instance) {
                            // แสดงวันที่ใน console สำหรับตรวจสอบ
                            const isoDate = convertThaiDateToISO(dateStr); 
                            let id = $(instance.input).data('id');
                            console.log("Selected Date:", id);
                            updateClubDateSchedule(id, isoDate);
                        }
                    });
                });
              
            } 
        }
    });
    
   

    $.ajax({
        url: `<?= site_url('admin/academic/ConAdminDevelopStudents/ClubCreateWeeks') ?>`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            //console.log(data); // เช็คข้อมูลที่ดึงมา
        },
        error: function () {
            console.error('ไม่สามารถดึงข้อมูลได้');
        }
    });
});

function loadWeeksData() {
    $.ajax({
        url: '<?= site_url('admin/academic/ConAdminDevelopStudents/ClubGetWeeksToUpdate') ?>', // URL ของ Controller
        type: 'GET',                    // ประเภทคำขอ
        dataType: 'json',               // ประเภทข้อมูลที่รับมา
        success: function (response) {
            let rows = '';
            if (response.status === 'success') {
                response.data.forEach(function (week, index) {
                    
                    if(week.tcs_week_status == "เปิด"){
                        var Ckecked = "checked";
                    }else{
                        var Ckecked = "";
                    }
                    rows += `
                        <tr>
                            <td>สัปดาห์ที่ ${index + 1}</td>
                            <td><input type="date" class="form-control tcs_academic_year" name="tcs_academic_year" id="tcs_academic_year${index + 1}" value="" data-id="${week.tcs_schedule_id}"></td>
                            <td>
                                <div class="form-check form-switch d-flex">
                                    <input class="form-check-input status-btn" type="checkbox" data-status="${week.tcs_week_status}" data-id="${week.tcs_schedule_id}" ${Ckecked} id="customSwitch${index + 1}" >
                                    <label class="form-check-switch-label" for="customSwitch${index + 1}"></label>
                                </div>
                            </td>
                            
                        </tr>
                    `;

                });

            } else {
                rows = '<tr><td colspan="3" class="text-center">ไม่มีข้อมูล</td></tr>';
            }
            $('#TbDateWeeks tbody').html(rows); // แสดงข้อมูลในตาราง
        },
        error: function () {
            alert('ไม่สามารถโหลดข้อมูลได้');
        }
    });
}

// อัปเดตวันที่เวลาเรียนในฐานข้อมูล
function updateClubDateSchedule(id, newDate) {
    $.ajax({
        url: '<?= site_url('admin/academic/ConAdminDevelopStudents/ClubUpdateSchedule') ?>', // URL ของ Controller
        type: 'POST',
        data: {
            id: id, // ID ของข้อมูลที่จะแก้ไข
            date: newDate // วันที่ใหม่ในรูปแบบ Y-m-d
        },
        dataType:'json',
        success: function (response) {
            if (response.status === 'success') {
                
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "อัปเดตวันที่สำเร็จ",
                    showConfirmButton: false,
                    timer: 1500
                  });
            } else {
                alert('เกิดข้อผิดพลาด: ' + response.message);
            }
        },
        error: function () {
            alert('ไม่สามารถอัปเดตวันที่ได้');
        }
    });
}

// เรียกฟังก์ชันโหลดข้อมูล
loadWeeksData();

// --------- เปิด-ปิด ปุ่มสถานะชุมนุม ---------------
$(document).on('click', '.status-btn', function() {
    var statusButton = $(this);
    var Id = statusButton.data('id');  // id ของชุมนุม
    var currentStatus = statusButton.data('status');  // สถานะปัจจุบัน (เปิดหรือปิด)

    // สลับสถานะ
    var newStatus = (currentStatus === 'เปิด') ? 'ปิด' : 'เปิด';  // เปลี่ยนสถานะ

    // ส่งคำขอ AJAX ไปอัพเดตสถานะในฐานข้อมูล
    $.ajax({
        url: '<?= site_url('admin/academic/ConAdminDevelopStudents/ClubUpdateStatus') ?>',  // URL สำหรับอัพเดตสถานะ
        method: 'POST',
        data: {
            id: Id,  // ส่ง id ของชุมนุม
            status: newStatus  // ส่งสถานะใหม่
        },
        dataType:'json',
        success: function(response) {
            console.log(response.status);
            
            // เมื่ออัพเดตสำเร็จ, เปลี่ยนสถานะใน UI
            if (response.status === "success") {
                // เปลี่ยนข้อความในปุ่มตามสถานะใหม่
                statusButton.data('status', newStatus);  // อัพเดตสถานะใน data attribute
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "สถานะถูกอัพเดตแล้ว",
                    showConfirmButton: false,
                    timer: 1500
                  });
            } else {
                alert('เกิดข้อผิดพลาดในการอัพเดตสถานะ');
            }
        },
        error: function() {
            alert('ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์');
        }
    });
});
</script>
<?= $this->endSection() ?>
