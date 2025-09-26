<?= $this->extend('user/layout/main') ?>

<?= $this->section('content') ?>

<style>

/* Large desktops and laptops */
@media (min-width: 1200px) {
    .learnOnline a{
        padding: 20px;
        font-size: 24px;
    }
}

/* Landscape tablets and medium desktops */
@media (min-width: 992px) and (max-width: 1199px) {
    .learnOnline a{
        padding: 20px;
        font-size: 24px;
    }
}

/* Portrait tablets and small desktops */
@media (min-width: 768px) and (max-width: 991px) {}

/* Landscape phones and portrait tablets */
@media (max-width: 767px) {}

/* Portrait phones and smaller */
@media (max-width: 480px) {
  
}

   
</style>
<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="text-center learnOnline">
                <a href="https://forms.gle/Ngfj3h2NqmJv6qfo8" target="_blank" class="btn btn-primary  text-white">+
                    บันทึกรายงานการสอนออนไลน์</a>
            </div>
            <br>
            <iframe width="100%" height="1000" src="https://datastudio.google.com/embed/reporting/3d8b7de2-3991-42bc-a6f3-a48fd0375f08/page/QMMSC"  frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
    </div>
</div>

<?= $this->endSection() ?>