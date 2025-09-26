<?= $this->extend('user/layout/main') ?>

<?= $this->section('content') ?>

<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="main-wrapper">
                <section class="cta-section theme-bg-light py-5">
                    <div class="container text-center">
                        <h2 class="heading">ตารางสอบ</h2>
                        <div class="intro">Welcome to Exam Schedule System</div>
                    </div>
                    <!--//container-->

                </section>
                <div id="accordion">
                    <?php  foreach ($Exam as $key => $v_Exam) : ?>
                    <div class="card">
                        <!-- <div class="card-header" id="heading<?=$key?>">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?=$key?>"
                                    aria-expanded="true" aria-controls="collapse<?=$key?>">
                                    ตารางสอบ<?=$v_Exam->exam_type?> ปีการศึกษา <?=$v_Exam->exam_year?> ภาคเรียนที่
                                    <?=$v_Exam->exam_term?>
                                </button>
                            </h5>
                        </div> -->
<!-- 
                        <div id="collapse<?=$key?>" class="collapse <?=$key == 0 ? 'show' : ''?>"
                            aria-labelledby="heading<?=$key?>" data-parent="#accordion">
                            <div class="card-body">
                                <iframe src="<?=base_url('uploads/academic/exam_schedule/').$v_Exam->exam_filename;?>"
                                    width="100%" height="500px"></iframe>
                            </div>
                        </div> -->

                        <img class="img-fluid" src="<?=base_url('uploads/academic/exam_schedule/main1.jpg')?>" alt="">
                        <img class="img-fluid" src="<?=base_url('uploads/academic/exam_schedule/main2.jpg')?>" alt="">
                    </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>