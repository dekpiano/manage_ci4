<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0"><?=$title;?></h1>
                <nav aria-label="breadcrumb" class="mt-2">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=base_url('Admin/Acade/Registration/Students')?>">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active"><?=$title;?></li>
                        
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <div class="page-utilities">
                    <div class="row g-2 justify-content-start justify-content-md-end align-items-center">

                        <div class="col-auto">
                            <select class="form-select w-auto">
                                <option selected="" value="option-1">All</option>
                                <option value="option-2">This week</option>
                                <option value="option-3">This month</option>
                                <option value="option-4">Last 3 months</option>

                            </select>
                        </div>

                    </div>
                    <!--//row-->
                </div>
                <!--//table-utilities-->
            </div>
            <!--//col-auto-->
        </div>
        <div class="app-card app-card-orders-table shadow-sm mb-5">
            <div class="app-card-body p-3">
                <div class="table-responsive">
                    <table class="table app-table-hover mb-0 text-left" id="tbStudent">
                        <thead>
                            <tr>
                                <th>เลขประจำตัว</th>
                                <th>ชื่อ - นามสกุล</th>
                                <th>ชั้น</th>
                                <th>เลขที่</th>
                                <th>สายการเรียน</th>
                                <th>สถานะนักเรียน</th>
                                <th>สถานะพฤติกรรม</th>
                            </tr>
                        </thead>
                        <tbody>

                        </table>
                    </div>
                    <!--//table-responsive-->

                </div>
                <!--//app-card-body-->
            </div>

        </div>



    </div>
</div>
<?= $this->endSection() ?>