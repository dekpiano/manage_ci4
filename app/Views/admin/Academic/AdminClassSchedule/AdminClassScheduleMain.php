<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="">
    <div class="">
        <section class="cta-section theme-bg-light py-5">
            <h3 class="heading">จัดการข้อมูล<?= isset($title) ? esc($title) : '' ?></h3>
        </section>
        <section class="we-offer-area text-center ">
            <div class="">
                <div class="d-flex justify-content-between mb-3">
                    <div class="card p-2">
                        <select name="SelYearClassSchedule" id="SelYearClassSchedule" class="form-select w-auto">
                            <?php foreach ($YearAll as $key => $v_YearAll) : ?>
                            <option <?= isset($v_YearAll->Year) && '1/2568' == $v_YearAll->Year ? "selected" : ""; ?>
                                value="<?= isset($v_YearAll->Year) ? esc($v_YearAll->Year) : '' ?>">
                                <?= isset($v_YearAll->Year) ? esc($v_YearAll->Year) : '' ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>


                    <a href="<?= site_url('Admin/Acade/Course/ClassSchedule/add');?>" class="btn btn-primary"> <i
                            class="far fa-plus-square"></i>
                        เพิ่ม<?= isset($title) ? esc($title) : '' ?></a>
                </div>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">

                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table table-bordered" id="TbClassSchedule" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ชื่อห้องเรียน</th>
                                        <th>ชั้น/ห้อง</th>
                                        <th>ปีการศึกษา</th>
                                        <th>ไฟล์ตัวอย่าง</th>
                                        <th>วันที่ลง</th>
                                        <th>คำสั่ง</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <style>
                                    .loading {
                                        display: none;
                                        /* ซ่อน loading ไว้ก่อน */
                                        text-align: center;
                                        font-weight: bold;
                                        color: blue;
                                    }
                                    </style>
                                    <tr class="loading">
                                        <td colspan="3">Loading data, please wait...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </div>
    <!--//main-wrapper-->

</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    let tableClassSchedule;
    const remoteBaseUrl = '<?= getenv('upload.server.baseurl') ?>';

    function loadClassSchedule(year) {
        tableClassSchedule = $('#TbClassSchedule').DataTable({
            destroy: true, // Destroy existing table before re-initializing
            processing: true,
            serverSide: false, // Client-side processing for now
            ajax: {
                url: '<?= site_url('admin/academic/ConAdminClassSchedule/getDataByYear') ?>',
                type: 'POST',
                data: { year: year },
                dataSrc: 'data' // Assuming the JSON response has a 'data' key
            },
            columns: [
                { data: 'schestu_name' },
                { data: 'schestu_classname' },
                { data: 'schestu_year' },
                { 
                    data: 'schestu_filename',
                    render: function(data, type, row) {
                        if (data) {
                            // Construct the full path: base_url + year + / + term + / + filename
                            const fullRemotePath = remoteBaseUrl + row.schestu_year + '/' + row.schestu_term + '/' + data;
                            return '<a href="' + fullRemotePath + '" target="_blank">ดูไฟล์</a>';
                        }
                        return 'ไม่มีไฟล์';
                    }
                },
                { data: 'schestu_datetime' },
                { 
                    data: 'schestu_id',
                    render: function(data, type, row) {
                        console.log('Row data:', row);
                        console.log('Row schestu_year:', row.schestu_year);
                        console.log('Row schestu_term:', row.schestu_term);
                        return '<a href="<?= site_url('Admin/Acade/Course/ClassSchedule/edit/') ?>' + data + '" class="btn btn-warning btn-sm edit-schedule">แก้ไข</a> ' +
                               '<a href="#" class="btn btn-danger btn-sm delete-schedule" data-id="' + data + '" data-filename="' + row.schestu_filename + '" data-year="' + row.schestu_year + '" data-term="' + row.schestu_term + '">ลบ</a>';
                    }
                }
            ]
        });
    }

    // Initial load
    $(document).ready(function() {
        let initialYear = $('#SelYearClassSchedule').val();
        loadClassSchedule(initialYear);
    });

    // Handle year change
    $('#SelYearClassSchedule').on('change', function() {
        let selectedYear = $(this).val();
        loadClassSchedule(selectedYear);
    });

    $(document).on('click', '.delete-schedule', function() {
        let id = $(this).data('id');
        let filename = $(this).data('filename');
        const year = $(this).data('year'); // Changed to const
        const term = $(this).data('term'); // Changed to const
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "คุณต้องการลบข้อมูลนี้หรือไม่!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบเลย!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= site_url('admin/academic/ConAdminClassSchedule/delete_class_schedule') ?>/' + id + '/' + encodeURIComponent(filename) + '/' + year + '/' + term,
                    type: 'POST', // Or DELETE if route is configured
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('ลบสำเร็จ!', 'ข้อมูลถูกลบเรียบร้อยแล้ว', 'success');
                            tableClassSchedule.ajax.reload();
                        } else {
                            Swal.fire('เกิดข้อผิดพลาด!', response.message || 'ไม่สามารถลบข้อมูลได้', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('เกิดข้อผิดพลาด!', 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้', 'error');
                    }
                });
            }
        });
    });
</script>
<?= $this->endSection() ?>