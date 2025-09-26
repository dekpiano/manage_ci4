<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">


        <div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
            <div class="inner">
                <div class="app-card-body p-3 p-lg-4">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?= site_url('assets/images/welcome.svg');?>" alt="" class="img-fluid">
                        </div>
                        <div class="col-md-7 text-center align-self-center">
                            <h2 class="heading">ยินดีต้อนรับที่คุณกลับมา</h2>
                            <div class="intro">ระบบงานสารสนเทศโรงเรียน สำหรับ Admin และเจ้าหน้าที่</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection() ?>