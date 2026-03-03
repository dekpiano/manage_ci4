<?= $this->extend('user/layout/main') ?>

<?= $this->section('content') ?>

<!-- Fancybox CSS for Image Zoom/Lightbox -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
<style>
    .exam-card { border-radius: 15px; overflow: hidden; transition: transform 0.2s; border: none; }
    .exam-card:hover { transform: translateY(-5px); }
    .exam-header { background: linear-gradient(135deg, #71dd37 0%, #15a362 100%); color: white; border: none; padding: 1.2rem; }
    .exam-badge { background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(5px); border-radius: 20px; padding: 4px 12px; font-size: 0.75rem; font-weight: 500; }
    .exam-img-wrapper { position: relative; cursor: zoom-in; }
    .btn-download { border-radius: 50px; font-size: 0.8rem; padding: 0.5rem 1.2rem; margin-top: 10px; display: inline-flex; align-items: center; }
    .empty-state { padding: 4rem 1rem; border-radius: 20px; background: #f8f9fa; }
    @media (max-width: 576px) {
        .exam-header h5 { font-size: 1rem; }
        .exam-header { padding: 1rem; }
    }
</style>

<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="main-wrapper">
                <section class="mb-4 text-center">
                    <h4 class="fw-bold text-primary mb-1">ตารางสอบประจำภาคเรียน</h4>
                    <p class="text-muted small">Academic Exam Schedules</p>
                </section>

                <div id="exam-list">
                    <?php if(!empty($Exam)): ?>
                        <?php foreach ($Exam as $key => $v_Exam) : ?>
                        <div class="card exam-card shadow-lg mb-4">
                            <div class="card-header exam-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 text-white fw-bold">
                                    <i class="bx bx-calendar-check me-1"></i>
                                    สอบ<?=$v_Exam['exam_type']?>
                                </h5>
                                <span class="exam-badge">
                                    <?= $v_Exam['exam_term'] ?>/<?= $v_Exam['exam_year'] ?>
                                </span>
                            </div>

                            <div class="card-body p-3">
                                <div class="row g-3">
                                    <?php foreach ($v_Exam['files'] as $fileName) : 
                                        $fileUrl = "https://skj.nsnpao.go.th/uploads/academic/ExamSchedule/" . $fileName;
                                        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
                                    ?>
                                        <div class="col-12 text-center mb-4">
                                            <?php if(in_array(strtolower($fileExt), ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                                <div class="exam-img-wrapper" data-fancybox="gallery-<?= $key ?>" data-src="<?= $fileUrl ?>">
                                                    <img src="<?= $fileUrl ?>" class="img-fluid rounded shadow-sm" alt="ตารางสอบ">
                                                    <div class="mt-2 text-primary small">
                                                        <i class="bx bx-zoom-in me-1"></i>แตะที่รูปเพื่อขยาย
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="ratio ratio-16x9">
                                                    <iframe src="<?= $fileUrl ?>" class="rounded shadow-sm"></iframe>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <a href="<?= $fileUrl ?>" download="<?= $fileName ?>" class="btn btn-outline-primary btn-download mt-2">
                                                <i class="bx bx-download me-1"></i>บันทึกไฟล์ลงมือถือ
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state text-center shadow-sm">
                            <img src="<?= base_url('assets/img/illustrations/man-with-laptop-light.png') ?>" alt="empty" width="150" class="mb-3 opacity-50">
                            <h5 class="text-muted">ไม่พบข้อมูลตารางสอบ</h5>
                            <p class="text-muted small">โรงเรียนยังไม่ได้เปิดให้ตรวจสอบตารางสอบในขณะนี้</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fancybox JS -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
    Fancybox.bind("[data-fancybox]", {
        // Custom options for mobile
        compact: false,
        idle: false
    });
</script>

<?= $this->endSection() ?>
