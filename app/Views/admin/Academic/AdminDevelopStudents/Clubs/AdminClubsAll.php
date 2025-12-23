<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">จัดการชุมนุม</h5>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <select id="academicYearFilter" name="academicYearFilter" class="form-select form-select-sm"
                        style="min-width: 150px;">
                        <?php $isFirst = true; ?>
                        <?php foreach ($YearAll as $key => $v_YearAll) : ?>
                        <option
                            value="<?= (isset($v_YearAll['club_trem']) ? esc($v_YearAll['club_trem']) : '') ?>/<?= (isset($v_YearAll['club_year']) ? esc($v_YearAll['club_year']) : '') ?>"
                            <?= $isFirst ? 'selected' : '' ?>>
                            <?= (isset($v_YearAll['club_trem']) ? esc($v_YearAll['club_trem']) : '') ?>/<?= (isset($v_YearAll['club_year']) ? esc($v_YearAll['club_year']) : '') ?>
                        </option>
                        <?php $isFirst = false; ?>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" class="btn btn-primary btn-sm BtnAddClub w-100">
                        <i class="bx bx-plus me-1"></i>
                        เพิ่มชุมนุม</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-sm align-middle" id="TbClubs">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center" style="width: 60px;">#</th>
                                <th>ปีการศึกษา</th>
                                <th>ชื่อชุมนุม</th>
                                <th>ครูที่ปรึกษาชุมนุม</th>
                                <th class="text-center" style="width: 100px;">จำนวนที่รับ</th>
                                <th class="text-center" style="width: 100px;">ลงทะเบียนแล้ว</th>
                                <th class="text-center" style="width: 100px;">ลงเรียน</th>
                                <th class="text-center" style="width: 120px;">คำสั่ง</th>
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
.swal2-container {
    z-index: 999999;
    /* Very high z-index to ensure it's always on top */
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
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="club_year" class="form-label">ปีการศึกษา</label>
                                <select class="form-select" id="club_year" name="club_year">
                                    <option value="" disabled selected>เลือกปีการศึกษา</option>
                                    <option value="2567">2567</option>
                                    <option value="2568">2568</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="club_trem" class="form-label">เทอม</label>
                                <select class="form-select" id="club_trem" name="club_trem">
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
                            placeholder="ระบุชื่อชุมนุม">
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
                            <select class="form-select" id="club_faculty_advisor" name="club_faculty_advisor[]" multiple
                                style="width: 100%;" data-placeholder="ค้นหาและเลือกครูที่ปรึกษา">
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
    <div class="modal-dialog modal-lg">
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
                        <select id="studentSelect" name="student_ids[]" multiple class="form-select">
                            <!-- ตัวเลือกจะถูกเพิ่มผ่าน JavaScript -->
                        </select>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" id="btnAddStudentToClub"
                            class="btn btn-primary">เพิ่มนักเรียนเข้าชุมนุม</button>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <div class="w-100">
                    <div class="card">
                        <div class="card-header" id="registeredCount">นักเรียนที่ลงทะเบียนแล้ว:</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="TbShowStudentRegisClub">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 60px;">#</th>
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
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$('#academicYearFilter').change(function() {
    table.ajax.reload();
});

const table = $('#TbClubs').DataTable({
    processing: true,
    "ajax": {
        "url": "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsShow') ?>", // URL ที่จะดึงข้อมูล
        "type": "GET",
        "dataSrc": "data",
        data: function(d) {
            d.year = decodeURIComponent($('#academicYearFilter').val()); // ส่ง year ไปใน ajax data
        }
    },
    "columns": [{
            "data": null,
            "render": function(data, type, row, meta) {
                return `<div class="text-center">${meta.row + 1}</div>`;
            },
            "orderable": false
        },
        {
            "data": null,
            "render": function(data, type, row, meta) {
                return row.club_trem + '/' + row.club_year;
            }
        },
        {
            "data": "club_name"
        },
        {
            "data": null,
            "render": function(data, type, row, meta) {
                return row.advisor_names;
            },
            "width": "200px" // Set a fixed width for the advisor names column
        },
        {
            "data": null,
            "render": function(data, type, row) {
                return `<div class="text-center">${row.club_max_participants}</div>`;
            }
        },
        {
            "data": null,
            "render": function(data, type, row) {
                return `<div class="text-center">${row.member_count}</div>`;
            }
        },
        {
            "data": null,
            "render": function(data, type, row, meta) {
                return `
                 <div class="text-center">
                     <button class="btn btn-sm btn-outline-primary BtnAddStudents" data-id="${row.club_id}" 
                         title="ลงทะเบียนเรียนชุมนุม" clubname="${row.club_name}">
                         <i class="bx bx-user-plus me-1"></i>ลงเรียน
                     </button>
                 </div>
                `
            }
        },
        {
            "data": null,
            "render": function(data, type, row) {
                return `
              <div class="text-center d-flex gap-1 justify-content-center">
                  <button class="btn btn-sm btn-icon btn-outline-primary edit-btn" data-id="${row.club_id}"  title="แก้ไขชุมนุม ${row.club_name}">
                      <i class="bx bx-edit"></i>
                  </button>
                  <button class="btn btn-sm btn-icon btn-outline-danger delete-btn" data-id="${row.club_id}" title="ลบชุมนุม ${row.club_name}">
                      <i class="bx bx-trash"></i>
                  </button>
              </div>
          `;
            }
        }
    ],
    error: function(settings, helpPage, message) {
        console.error('DataTable Error:', message);
    }
});

$(document).on('click', '.BtnAddClub', function() {
    $('#ModalAddClubs').modal('show');
    $('#FormAddClubs')[0].reset();
    $('#club_faculty_advisor').val(null).trigger('change');
    $('#clubModalLabel').text('เพิ่มชุมนุม');

    // Destroy previous instance if it exists
    if ($('#club_faculty_advisor').data('select2')) {
        $('#club_faculty_advisor').select2('destroy');
    }

    // Initialize Select2 for add modal
    $('#club_faculty_advisor').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#ModalAddClubs'),
        placeholder: 'ค้นหาและเลือกครูที่ปรึกษา',
        allowClear: true,
        ajax: {
            url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsTeacherList') ?>",
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: data.map(teacher => ({
                        id: teacher.pers_id,
                        text: teacher.FullName
                    }))
                };
            },
            cache: true
        }
    });
});

$(document).on('submit', '#FormAddClubs', function(e) {
    e.preventDefault(); // Prevent default form submission
    var selectedAdvisors = $('#club_faculty_advisor').val(); // ได้อาร์เรย์ของที่ปรึกษาที่เลือก
    if (selectedAdvisors.length === 0) {
        Swal.fire('กรุณาเลือกที่ปรึกษาก่อน');
        return;
    }

    const url = $('#club_id').val() ?
        "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsUpdate') ?>" // แก้ไข
        :
        "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsInsert') ?>"; // เพิ่มใหม่

    // ใช้ serialize() เพื่อดึงข้อมูลจากฟอร์ม
    var formData = $(this).closest('form').serializeArray();

    formData.push({
        name: 'advisors',
        value: JSON.stringify(selectedAdvisors)
    });

    $.ajax({
        url: url, // Controller method for saving data
        type: 'POST',
        data: formData, // Serialize form data
        success: function(response) {

            if (response.status === 'success') {
                // Close modal
                $('#ModalAddClubs').modal('hide');
                $('.modal-backdrop').remove();

                // Reset form
                $('#FormAddClubs')[0].reset();
                $('#club_faculty_advisor').val(null).trigger('change');

                $('#TbClubs').DataTable().ajax.reload(); // รีเฟรช DataTable
                Swal.fire({
                    icon: 'success', // ไอคอน
                    title: 'แจ้งเตือน!',
                    text: 'บันทึกข้อมูลสำเร็จ',
                    showConfirmButton: false,
                    timer: 2000
                });

            } else {
                console.log('ผิดพลาด', response.message); // Log the actual error message
                Swal.fire({
                    icon: 'error',
                    title: 'แจ้งเตือน!',
                    text: response.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล',
                    confirmButtonText: 'OK'
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
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
            $('#club_faculty_advisor').val(null).trigger('change');

            const advisorsArray = data.club_faculty_advisor.split('|');

            $('#ModalAddClubs').data('preselected-advisors',
            advisorsArray); // Store pre-selected advisors

            $('#ModalAddClubs').data('preselected-advisor-details', data
                .preselected_advisor_details); // Store pre-selected advisor details

            $('#ModalAddClubs').modal('show'); // เปิด Modal
        },
        error: function() {
            alert('Error fetching data.');
        }
    });

    // Destroy previous instance if it exists
    if ($('#club_faculty_advisor').data('select2')) {
        $('#club_faculty_advisor').select2('destroy');
    }

    $('#ModalAddClubs').on('shown.bs.modal', function() {
        // Destroy previous instance if it exists
        if ($('#club_faculty_advisor').data('select2')) {
            $('#club_faculty_advisor').select2('destroy');
        }

        // Initialize Select2
        $('#club_faculty_advisor').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#ModalAddClubs'),
            placeholder: 'ค้นหาและเลือกครูที่ปรึกษา',
            allowClear: true,
            ajax: {
                url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsTeacherList') ?>",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: data.map(teacher => ({
                            id: teacher.pers_id,
                            text: teacher.FullName
                        }))
                    };
                },
                cache: true
            }
        });

        // Apply pre-selected advisors if available (for editing)
        const preselectedAdvisors = $('#ModalAddClubs').data('preselected-advisors');
        const preselectedAdvisorDetails = $('#ModalAddClubs').data('preselected-advisor-details');

        if (preselectedAdvisorDetails && preselectedAdvisorDetails.length > 0) {
            preselectedAdvisorDetails.forEach(function(advisor) {
                // Check if the option already exists to prevent duplicates
                if (!$('#club_faculty_advisor option[value="' + advisor.pers_id + '"]')
                    .length) {
                    const newOption = new Option(advisor.FullName, advisor.pers_id, true, true);
                    $('#club_faculty_advisor').append(newOption).trigger('change');
                }
            });
        }

        if (preselectedAdvisors && preselectedAdvisors.length > 0) {
            $('#club_faculty_advisor').val(preselectedAdvisors).trigger('change');
        }

        $('#ModalAddClubs').removeData('preselected-advisors'); // Clear the stored data
        $('#ModalAddClubs').removeData('preselected-advisor-details'); // Clear the stored data

    });
});

$(document).on('click', '.delete-btn', function() {
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
                url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsDelete/') ?>" +
                    clubId,
                type: "POST",
                success: function(response) {
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
                error: function(jqXHR, textStatus, errorThrown) {
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

$(document).on('click', '.BtnAddStudents', function() {
    $('#AddStudentsTitle').text("จัดการนักเรียนชุมนุม " + $(this).attr('clubname'))
    $('#ModalAddStudents').modal('show');

    let club_id = $(this).attr('data-id');
    $('.club_id').val(club_id);
    loadRegisteredStudents(club_id);

    // Destroy previous instance if it exists
    if ($('#studentSelect').data('select2')) {
        $('#studentSelect').select2('destroy');
    }

    // Initialize Select2
    $('#studentSelect').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#ModalAddStudents'),
        placeholder: 'ค้นหาและเลือกนักเรียน',
        allowClear: true,
        ajax: {
            url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsStudentList') ?>",
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: data.map(student => ({
                        id: student.StudentID,
                        text: student.FullName
                    }))
                };
            },
            cache: true
        }
    });
});

// ------------------------ทะเบียนเบียนชุมนุม------------------------------------------------
// โหลดตารางลงทะเบียนเบียนชุมนุม
function loadRegisteredStudents(clubId) {
    $.ajax({
        url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsTbShowStudentList') ?>",
        type: "GET",
        data: {
            club_id: clubId
        },
        dataType: 'json',
        success: function(data) {
            //$('#registeredCount').text(`นักเรียนที่ลงทะเบียนแล้ว: ${data} คน`);
            let tableRows = '';
            data.forEach((student, index) => {

                tableRows += `
                    <tr>
                        <td class="text-center">${index + 1}</td>
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
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}


// เพื่มนักเรียนเข้าชุมนุม
$(document).on('click', '#btnAddStudentToClub', function(e) {

    const selectedStudents = $('#studentSelect').val();
    const ClubID = $('.club_id').val();

    $.ajax({
        url: "<?= site_url('admin/academic/ConAdminDevelopStudents/ClubsAddStudentToClub') ?>",
        type: 'POST',
        data: {
            student_ids: selectedStudents,
            club_id: ClubID
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'duplicate') {
                // แจ้งเตือนข้อมูลซ้ำ
                Swal.fire({
                    icon: "warning",
                    title: "นักเรียนบางคนได้ลงทะเบียนในชุมนุมนี้แล้ว:",
                    text: response.duplicate_students.join('\n'),
                    footer: 'กรุณาเลือกนักเรียนเข้าชุมนุมใหม่อีกครั้ง!'
                });

            } else if (response.status === 'success') {
                Swal.fire({
                    icon: "success",
                    title: "แจ้งเตือน!",
                    text: 'เพิ่มนักเรียนเข้าชุมนุมเรียบร้อย'
                });
                loadRegisteredStudents(ClubID);
                // รีเซ็ตฟอร์มและ Select2
                $('#studentSelect').val(null).trigger('change');
                $('#FormAddStudentToClub')[0].reset();
            } else {
                Swal.fire({
                    icon: "error",
                    title: "แจ้งเตือน!",
                    text: response.message || 'เกิดข้อผิดพลาด'
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error saving data:', error);
        }
    });
});

// ฟังก์ชันสำหรับลบนักเรียนออกจากชุมนุม
$(document).on('click', '.remove-btn', function() {
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
                success: function(response) {
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
                error: function(xhr, status, error) {
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