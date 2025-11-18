<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">ชุมนุม /</span> ข้อมูลนักเรียนที่ลงทะเบียน
    </h4>

    <!-- Student Club Registrations Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">ข้อมูลนักเรียนที่ลงทะเบียนชุมนุม</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table id="studentClubRegisTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>ชื่อ-นามสกุล</th>
                            <th>รหัสนักเรียน</th>
                            <th>ชั้น</th>
                            <th>เลขที่</th>
                            <th>ชื่อชุมนุม</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be loaded via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    $('#studentClubRegisTable').DataTable({
        "processing": true,
        "serverSide": false, // Set to false as we are loading all data at once
        "ajax": {
            "url": "<?= base_url('admin/academic/ConAdminDevelopStudents/ClubGetStudentRegisterClub') ?>",
            "type": "GET",
            "dataSrc": "data" // Look for the 'data' key in the JSON response
        },
        "columns": [
            { "data": "Fullname" },
            { "data": "StudentCode" },
            { "data": "StudentClass" },
            { "data": "StudentNumber" },
            { 
                "data": "club_name",
                "render": function(data, type, row) {
                    if (type === 'display') {
                        if (data === 'ยังไม่ได้เลือกชุมนุม') {
                            return '<span class="badge bg-danger">' + data + '</span>';
                        } else {
                            return '<span class="badge bg-success">' + data + '</span>';
                        }
                    }
                    return data;
                }
            }
        ],
        "responsive": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/th.json"
        },
        "dom": '<"row"<"col-md-6"l><"col-md-6"f>><"row mt-4"<"col-md-12"B>><"row"<"col-md-12"rt>><"row"<"col-md-6"i><"col-md-6"p>>',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: 'Excel',
                className: 'btn btn-success'
            },
            {
                extend: 'print',
                text: 'Print',
                className: 'btn btn-info'
            }
        ],
        "order": [[2, 'asc'], [3, 'asc']]
    });
});
</script>
<?= $this->endSection() ?>
