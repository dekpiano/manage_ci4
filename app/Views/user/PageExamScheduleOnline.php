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
                <div class="row g-4">
                    <?php if(!empty($Exam)): ?>
                        <?php foreach ($Exam as $v_Exam) : ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="card-body text-center">
                                    <div class="avatar avatar-lg bg-label-primary mx-auto mb-3">
                                        <i class="bx bx-laptop fs-2"></i>
                                    </div>
                                    <h5 class="card-title mb-1">สอบ<?=$v_Exam->exam_type?></h5>
                                    <p class="text-muted small mb-3">ปีการศึกษา <?=$v_Exam->exam_year?> ภาคเรียนที่ <?=$v_Exam->exam_term?></p>
                                    
                                    <?php 
                                        $fileUrl = "https://skj.nsnpao.go.th/uploads/academic/ExamSchedule/" . $v_Exam->exam_filename;
                                    ?>
                                    <a href="<?= $fileUrl ?>" target="_blank" class="btn btn-primary w-100">
                                        <i class="bx bx-show me-1"></i> เข้าชมตารางสอบ
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-body text-center py-5">
                                    <i class="bx bx-info-circle fs-1 text-muted mb-3"></i>
                                    <h5>ไม่มีข้อมูลตารางสอบออนไลน์</h5>
                                    <p class="text-muted">ขณะนี้ยังไม่มีการเปิดระบบตารางสอบออนไลน์</p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>