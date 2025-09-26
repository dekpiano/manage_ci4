<?= $this->extend('user/layout/main') ?>

<?= $this->section('content') ?>

<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="main-wrapper">
                <section class="cta-section theme-bg-light py-5">
                    <div class="container text-center">
                        <h2 class="heading">ตารางสอบออนไลน์</h2>
                        <div class="intro">(ให้นักเรียนตรวจสอบลิ้งก์ และวิชาที่สอบก่อนทำข้อสอบ ว่าตรงกับข้อสอบหรือไม่
                            ถ้ามีปัญหาในการสอบ ให้นักเรียนติดต่อโดยตรงกับครูประจำวิชา !)</div>
                    </div>
                    <!--//container-->

                </section>
                <div class="container text-center">
                    <?php if (1): ?>
                    <div id="28">
                        <?php $this->load->view('user/ExamSchedule/28.php'); ?>
                    </div>
                   

                    <div id="1">
                        <?php $this->load->view('user/ExamSchedule/1.php'); ?>
                    </div>
                   
                    <div id="2">
                        <?php $this->load->view('user/ExamSchedule/2.php'); ?>
                    </div>
                                    
                    <div id="3">
                        <?php $this->load->view('user/ExamSchedule/3.php'); ?>
                    </div>
                    <?php else: ?>
                  <div class="card mb-3">
                        <!-- <div class="card-body">
                            <h2>
                                <div class="">การสอบออนไลน์ปลายภาคเรียน เทมอ 2 ปีการศึกษา 2564 สิ้นสุดลงแล้ว</div>
                                <div class="">นักเรียนที่ยังไม่ได้สอบ กรุณาติดต่อครูประจำวิชา</div>
                            </h2>
                        </div> -->
                    </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>