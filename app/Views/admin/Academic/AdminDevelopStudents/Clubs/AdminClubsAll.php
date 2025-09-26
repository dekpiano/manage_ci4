<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">จัดการชุมนุม</h1>
            </div>
            <div class="col-auto">
                <div class="page-utilities">
                    <div class="row g-2 justify-content-start justify-content-md-end align-items-center">

                        <div class="col-auto">
                            <select id="academicYearFilter" name="academicYearFilter" class="form-select w-auto">

                                <?php foreach ($YearAll as $key => $v_YearAll) : ?>
                                <option value="<?= (isset($v_YearAll['club_trem']) ? esc($v_YearAll['club_trem']) : '') ?>/<?= (isset($v_YearAll['club_year']) ? esc($v_YearAll['club_year']) : '') ?>">
                                    <?= (isset($v_YearAll['club_trem']) ? esc($v_YearAll['club_trem']) : '') ?>/<?= (isset($v_YearAll['club_year']) ? esc($v_YearAll['club_year']) : '') ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-auto">
                            <a class="btn app-btn-primary BtnAddClub" href="#">+ เพิ่มชุมนุม</a>
                        </div>
                    </div>
                    <!--//row-->
                </div>
                <!--//table-utilities-->
            </div>
            <!--//col-auto-->
        </div>
        <!-- Activities Table -->
        <div class="card">
            <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                <div>รายชื่อชุมนุม</div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="TbClubs">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ปีการศึกษา</th>
                                <th>ชื่อชุมนุม</th>
                                <th>ราละเอียดชุมนุม</th>
                                <th>ครูที่ปรึกษาชุมนุม</th>
                                <th>จำนวนที่รับ</th>
                                <th>ลงเรียน</th>
                                <th>คำสั่ง</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<style>
.ss-main .ss-single-selected {
    height: 40px;
}
</style>
<!-- Modal -->
<div class="modal fade" id="ModalAddClubs" tabindex="-1" aria-labelledby="clubModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clubModalLabel">เพิ่มชุมนุม</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Club Form -->
                <form method="POST" id="FormAddClubs">
                    <input type="hidden" name="club_id" id="club_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="club_year" class="form-label">ปีการศึกษา</label>
                                <select class="form-select" id="club_year" name="club_year" required1>
                                    <option value="" disabled selected>เลือกปีการศึกษา</option>
                                    <option value="2567">2567</option>
                                    <option value="2568">2568</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="club_trem" class="form-label">เทอม</label>
                                <select class="form-select" id="club_trem" name="club_trem" required1>
                                    <option value="" disabled selected>เลือกเทอม</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ชื่อชุมนุม -->
                    <div class="mb-3">
                        <label for="club_name" class="form-label">ชื่อชุมนุม</label>
                        <input type="text" class="form-control" id="club_name" name="club_name"
                            placeholder="ระบุชื่อชุมนุม" required1>
                    </div>

                    <!-- Club Description -->
                    <div class="mb-3">
                        <label for="club_description" class="form-label">รายละเอียดชุมนุม หรือเกี่ยวกับ</label>
                        <textarea class="form-control" id="club_description" name="club_description" rows="5"
                            placeholder="ระบุรายละเอียดชุมนุม หรือเกี่ยวกับ"></textarea>
                    </div>


                    <!-- Club Room -->
                    <div class="mb-3">
                        <label for="club_max_participants" class="form-label">รับจำนวน</label>
                        <input type="number" class="form-control" id="club_max_participants"
                            name="club_max_participants" placeholder="ใส่จำนวนสูงสุดของชุมนุม">
                    </div>

                    <!-- Club Advisor -->
                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="club_faculty_advisor" class="form-label">ครูที่ปรึกษาชุมนุม</label>
                            <select class="club_faculty_advisor" id="club_faculty_advisor" name="club_faculty_advisor[]"
                                multiple required1 style="width: 100%;">
                                <?php foreach ($Teacher as $key => $v_Teacher) : ?>
                                <option value="<?= isset($v_Teacher->pers_id) ? esc($v_Teacher->pers_id) : '' ?>">
                                    <?= (isset($v_Teacher->pers_prefix) ? esc($v_Teacher->pers_prefix) : '') . (isset($v_Teacher->pers_firstname) ? esc($v_Teacher->pers_firstname) : '') . ' ' . (isset($v_Teacher->pers_lastname) ? esc($v_Teacher->pers_lastname) : '') ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">บันทึกชุมนุม</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="ModalAddStudents" tabindex="-1" aria-labelledby="AddStudents" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AddStudentsTitle">จัดการนักเรียน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="FormAddStudentToClub">
                    <input type="hidden" name="club_id" id="club_id" class="club_id" value="">
                    <div class="mb-3">
                        <label for="studentSelect" class="form-label">เลือกนักเรียน</label>
                        <select id="studentSelect" name="student_ids[]" multiple>
                            <!-- ตัวเลือกจะถูกเพิ่มผ่าน JavaScript -->
                        </select>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary text-center ">เพิ่มนักเรียนเข้าชุมนุม</button>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <div class="w-100">
                    <!-- Card Footer สำหรับแสดงรายชื่อนักเรียน -->
                    <div class="card">
                        <div class="card-header" id="registeredCount">นักเรียนที่ลงทะเบียนแล้ว:</div>
                        <div class="card-body">
                            <!-- Registered Students -->

                            <table class="table table-striped" id="TbShowStudentRegisClub">
                                <thead>
                                    <tr>
                                        <th>ชั้น</th>
                                        <th>เลขที่</th>
                                        <th>รหัสนักเรียน</th>
                                        <th>ชื่อ-สกุล</th>
                                        <th>การกระทำ</th>
                                    </tr>
                                </thead>
                                <tbody id="addedStudentsList">
                                    <!-- ข้อมูลจะถูกโหลดที่นี่ -->
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
const faculty = new SlimSelect({
    select: '#club_faculty_advisor',
    showSearch: true, // เปิดให้สามารถค้นหาได้
    allowDeselect: true, // สามารถเลือกได้มากกว่า 1
});


$('#academicYearFilter').change(function () {   
   table.ajax.reload();
});

const table = $('#TbClubs').DataTable({
  processing: true,
    "ajax": {
        "url": "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsShow') ?>", // URL ที่จะดึงข้อมูล
        "type": "GET",
        "dataSrc": "data",
        data: function(d) {
          
          console.log('Selected Year:', $('#academicYearFilter').val());
          d.year = decodeURIComponent($('#academicYearFilter').val());  // ส่ง year ไปใน ajax data
      }
    },
    "columns": [
        { "data": "club_id" },
        { "data": null, "render": function (data, type, row, meta) {
                return row.club_trem+'/'+row.club_year; // แสดงเลขลำดับ
            }
        },
        { "data": "club_name" },
        { "data": "club_description" },
        { 
          "data": null, "render": function (data, type, row, meta) {
                return row.advisor_names; // แสดงเลขลำดับ
            }
         },
        { "data": "club_max_participants" },
        { 
          "data": null, "render": function (data, type, row, meta) {
                return `
                 <button class="btn-sm btn-warning BtnAddStudents" data-id="${row.club_id}" title="ลงทะเบียนเรียนชุมนุม" clubname="${row.club_name}">
                      ลงเรียน
                  </button>
                `
            }
         },
        { "data": null, "render": function (data, type, row) {
          return `
              <div class="text-center d-flex">
                  <button class="btn-sm btn-primary edit-btn" data-id="${row.club_id}"  title="แก้ไข">
                      <i class="fas fa-edit"></i>
                  </button>
                  <button class="btn-sm btn-danger remove-btn" data-id="${row.club_id}" title="ลบ">
                      <i class="fas fa-trash"></i>
                  </button>
              </div>
          `;
      }}
    ],
    error: function (settings, helpPage, message) {
       console.error('DataTable Error:', message);
    }
});

$(document).on('click', '.BtnAddClub', function() {
   $('#ModalAddClubs').modal('show');
   $('#FormAddClubs')[0].reset();
   faculty.set([]);
   $('#clubModalLabel').text('เพิ่มชุมนุม');
});

$(document).on('submit','#FormAddClubs',function (e) {
    e.preventDefault(); // Prevent default form submission
    var selectedAdvisors = faculty.selected();  // ได้อาร์เรย์ของที่ปรึกษาที่เลือก
    if (selectedAdvisors.length === 0) {
        Swal.fire('กรุณาเลือกที่ปรึกษาก่อน');
        return;
    }

    const url = $('#club_id').val() 
    ? "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsUpdate') ?>" // แก้ไข
    : "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsInsert') ?>"; // เพิ่มใหม่

     // ใช้ serialize() เพื่อดึงข้อมูลจากฟอร์ม
    var formData = $(this).closest('form').serializeArray();
    
    formData.push({ name: 'advisors', value: JSON.stringify(selectedAdvisors) });

    $.ajax({
      url: url, // Controller method for saving data
      type: 'POST',
      data: formData, // Serialize form data
      success: function (response) {

        if (response > 0) {
          // Close modal
          $('#ModalAddClubs').modal('hide');
          $('.modal-backdrop').remove(); 
        
          // Reset form
          $('#FormAddClubs')[0].reset();
          faculty.set([]);

          $('#TbClubs').DataTable().ajax.reload(); // รีเฟรช DataTable
          Swal.fire({
            icon: 'success', // ไอคอน
            title: 'แจ้งเตือน!',
            text: 'บันทึกข้อมูลสำเร็จ',
            showConfirmButton: false,
            timer: 2000 
        });

        } else {
            console.log('ผิดพลาด');
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(textStatus);
      }
    });
  });

   // เปิด Modal เพื่อแก้ไขข้อมูล
   $(document).on('click', '.edit-btn', function() {
    
    const clubId = $(this).data('id');
   
    $.ajax({
        url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsEdit/') ?>" + clubId,
        type: "GET",
        dataType: "json",
        success: function(data) {
            $('#clubModalLabel').text('แก้ไขชุมนุม'); // เปลี่ยน Title
            $('#club_id').val(data.club_id); 
            $('#club_year').val(data.club_year); 
            $('#club_trem').val(data.club_trem); 
            $('#club_name').val(data.club_name); 
            $('#club_description').val(data.club_description); 
            $('#club_max_participants').val(data.club_max_participants);     
            faculty.set([]);       

            const advisorsArray = data.club_faculty_advisor.split('|');
            faculty.set(advisorsArray);

            $('#ModalAddClubs').modal('show'); // เปิด Modal
        },
        error: function() {
            alert('Error fetching data.');
        }
    });
});

$(document).on('click', '.delete-btn', function () {
  const clubId = $(this).data('id'); // ดึง ID ชุมนุม

  // ใช้ SweetAlert2 สำหรับยืนยัน
  Swal.fire({
      title: 'คุณต้องการลบข้อมูลหรือไม่?',
      text: "ถ้าคุณเลือกลบข้อมูล ข้อมูลทั้งชุมนุมจะหายหมด พร้อมด้วยเวลาทั้งหมด!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
      if (result.isConfirmed) {
          // ส่งคำขอลบข้อมูลไปที่เซิร์ฟเวอร์
          $.ajax({
              url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsDelete/') ?>" + clubId,
              type: "POST",
              success: function (response) {
                  // แจ้งเตือนสำเร็จ
                  Swal.fire({
                      icon: 'success',
                      title: 'แจ้งเตือน!',
                      text: 'ข้อมูลชุมนุมได้ถูกลบทั้งหมดแล้ว!',
                      showConfirmButton: false,
                      timer: 2000
                  });

                  // รีเฟรช DataTable
                  $('#TbClubs').DataTable().ajax.reload();
              },
              error: function (jqXHR, textStatus, errorThrown) {
                  // แจ้งเตือนข้อผิดพลาด
                  Swal.fire({
                      icon: 'error',
                      title: 'Error!',
                      text: textStatus,
                      confirmButtonText: 'OK'
                  });
              }
          });
      }
  });
});

let slimSelectInstance;
$(document).on('click', '.BtnAddStudents', function () {
    $('#AddStudentsTitle').text("จัดการนักเรียนชุมนุม "+$(this).attr('clubname'))
    $('#ModalAddStudents').modal('show');

    let club_id = $(this).attr('data-id');
    $('.club_id').val(club_id);
    loadRegisteredStudents(club_id);
    // ตรวจสอบและทำลาย SlimSelect เดิม หากมี
    if (slimSelectInstance) {
        slimSelectInstance.destroy();
    }

    // กำหนด SlimSelect ใหม่
    slimSelectInstance = new SlimSelect({
      select: '#studentSelect',
      placeholder: 'ค้นหาและเลือกนักเรียน',
      closeOnSelect: false, // ให้เลือกได้หลายรายการ
      allowDeselect: true, // อนุญาตให้ยกเลิกการเลือก
      searchPlaceholder: 'พิมพ์เพื่อค้นหา...',
    });

    // โหลดข้อมูลนักเรียนผ่าน AJAX
    $.ajax({
      url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsStudentList') ?>",
      type: "GET",
      dataType: "json",
      success: function (data) {
          const options = data.map(student => ({
              text: student.FullName,
              value: student.StudentID,
          }));
          slimSelectInstance.setData(options);
      },
      error: function (xhr, status, error) {
          console.error("Error fetching student list:", error);
      }
  });
});

// ------------------------ทะเบียนเบียนชุมนุม------------------------------------------------
// โหลดตารางลงทะเบียนเบียนชุมนุม
function loadRegisteredStudents(clubId) {
    $.ajax({
        url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsTbShowStudentList') ?>",
        type: "GET",
        data: { club_id: clubId },
        success: function (response) {
            const data = JSON.parse(response);
            //$('#registeredCount').text(`นักเรียนที่ลงทะเบียนแล้ว: ${data} คน`);
            let tableRows = '';
            data.forEach(student => {
                
                tableRows += `
                    <tr>
                        <td>${student.StudentClass}</td>
                        <td>${student.StudentNumber}</td>
                        <td>${student.StudentCode}</td>
                        <td>${student.Fullname}</td>
                        <td>
                            <button class="btn btn-danger btn-sm remove-btn" data-id="${student.StudentID}">
                                ลบ
                            </button>
                        </td>
                    </tr>`;
            });
            $('#addedStudentsList').html(tableRows);
            var rowCount = $("#TbShowStudentRegisClub tbody tr").length;
            $("#registeredCount").text("นักเรียนที่ลงทะเบียนแล้ว: " + rowCount + " คน");
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
}


// เพื่มนักเรียนเข้าชุมนุม
$(document).on('submit','#FormAddStudentToClub', function (e) {
    e.preventDefault();

    const selectedStudents = slimSelectInstance.selected();
    const ClubID = $('.club_id').val();

    $.ajax({
        url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsAddStudentToClub') ?>",
        type: 'POST',
        data: {
            student_ids: selectedStudents,
            club_id: ClubID
        },
        dataType:'json',
        success: function (response) {
        if (response.status === 'duplicate') {
            // แจ้งเตือนข้อมูลซ้ำ
            Swal.fire({
                icon: "warning",
                title: "นักเรียนบางคนได้ลงทะเบียนในชุมนุมนี้แล้ว:",
                text: response.duplicate_students.join('\n'),
                footer: 'กรุณาเลือกนักเรียนเข้าชุมนุมใหม่อีกครั้ง!'
              });
           
        }else if (response.status === 'success') {
                Swal.fire({
                    icon: "success",
                    title: "แจ้งเตือน!",
                    text: 'เพิ่มนักเรียนเข้าชุมนุมเรียบร้อย'
                });
                loadRegisteredStudents(ClubID);
                // รีเซ็ตฟอร์มและ SlimSelect
                slimSelectInstance.set([]);
                $('#FormAddStudentToClub')[0].reset();
            } else {
                Swal.fire({
                    icon: "error",
                    title: "แจ้งเตือน!",
                    text: response.message || 'เกิดข้อผิดพลาด'
                  });
            }
        },
        error: function (xhr, status, error) {
            console.error('Error saving data:', error);
        }
    });
});

// ฟังก์ชันสำหรับลบนักเรียนออกจากชุมนุม
$(document).on('click', '.remove-btn', function () {
    const studentId = $(this).data('id'); // ดึง ID ของนักเรียนที่ต้องการลบ
    const clubId = $('.club_id').val(); // ID ของชุมนุม

    Swal.fire({
        title: 'คุณแน่ใจหรือไม่?',
        text: 'คุณต้องการลบนักเรียนคนนี้ออกจากชุมนุมหรือไม่?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่, ลบเลย!',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubDeleteStudentToClub') ?>",
                type: "POST",
                data: {
                    club_id: clubId,
                    student_id: studentId
                },
                success: function (response) {
                    const result = JSON.parse(response);
                    if (result.status === 'success') {
                        Swal.fire(
                            'ลบสำเร็จ!',
                            'นักเรียนถูกลบออกจากชุมนุมเรียบร้อยแล้ว',
                            'success'
                        );
                        loadRegisteredStudents(clubId); // โหลดข้อมูลนักเรียนใหม่
                    } else {
                        Swal.fire(
                            'เกิดข้อผิดพลาด!',
                            result.message,
                            'error'
                        );
                    }
                },
                error: function (xhr, status, error) {
                    Swal.fire(
                        'เกิดข้อผิดพลาด!',
                        'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้',
                        'error'
                    );
                }
            });
        }
    });
});
</script>
<?= $this->endSection() ?>
