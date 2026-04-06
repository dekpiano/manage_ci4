<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<!-- Custom Styling for Search-to-Edit Interface -->
<style>
    :root {
        --skj-primary: #15a362;
        --skj-secondary: #0d6efd;
        --skj-glass: rgba(255, 255, 255, 0.9);
        --skj-card-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .edit-search-container {
        animation: fadeIn 0.6s ease-out;
        max-width: 1400px;
        margin: 0 auto;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Hero Section with Glassmorphism */
    .hero-search-section {
        background: url('https://www.transparenttextures.com/patterns/cubes.png'), linear-gradient(135deg, #15a362 0%, #20c997 100%);
        border-radius: 24px;
        padding: 4rem 2rem;
        position: relative;
        overflow: hidden;
        margin-bottom: -3.5rem;
        box-shadow: 0 15px 50px rgba(21, 163, 98, 0.3);
    }

    .hero-search-section::before {
        content: "";
        position: absolute;
        top: -100px;
        right: -100px;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        z-index: 0;
    }

    .search-card-premium {
        background: var(--skj-glass);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 20px;
        box-shadow: var(--skj-card-shadow);
        z-index: 10;
        position: relative;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Search Input Enhancement */
    .search-input-wrapper {
        position: relative;
    }

    .search-input-wrapper .form-control {
        height: 72px;
        border-radius: 18px;
        padding-left: 65px;
        padding-right: 140px;
        font-size: 1.25rem;
        font-weight: 500;
        border: 2px solid #eaedf1;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
    }

    .search-input-wrapper .form-control:focus {
        border-color: var(--skj-primary);
        box-shadow: 0 8px 25px rgba(21, 163, 98, 0.15);
        transform: translateY(-2px);
    }

    .search-btn-hero {
        position: absolute;
        right: 10px;
        top: 10px;
        height: 52px;
        padding: 0 30px;
        border-radius: 14px;
        font-weight: 700;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(21, 163, 98, 0.3);
    }

    .search-icon-main {
        position: absolute;
        left: 24px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.8rem;
        color: var(--skj-primary);
        opacity: 0.7;
    }

    /* Data Presentation */
    .student-entry-card {
        border: 1px solid #f1f3f5;
        border-radius: 16px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        background: #fff;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .student-entry-card:hover {
        border-color: var(--skj-primary);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        transform: translateX(5px);
    }

    .student-avatar {
        width: 64px;
        height: 64px;
        border-radius: 14px;
        background: #f0faf5;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--skj-primary);
        font-weight: 800;
        font-size: 1.5rem;
        border: 1px solid rgba(21, 163, 98, 0.1);
    }

    /* Result Animation */
    .animate-item {
        animation: slideInRight 0.4s ease forwards;
        opacity: 0;
    }

    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    /* Floating Labels for Search Suggestions */
    .suggested-tags .badge {
        padding: 8px 16px;
        border-radius: 30px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
    }

    .suggested-tags .badge:hover {
        background: #fff;
        color: var(--skj-primary);
        transform: scale(1.05);
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y edit-search-container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style2 mb-4">
            <li class="breadcrumb-item"><a href="<?= base_url('Admin/Home') ?>">หน้าหลัก</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('Admin/Acade/Registration/Students') ?>">จัดการนักเรียน</a></li>
            <li class="breadcrumb-item active fw-bold text-success">แก้ไขข้อมูลรายบุคคล</li>
        </ol>
    </nav>

    <!-- Hero Content -->
    <div class="hero-search-section text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="text-white fw-800 display-5 mb-2">ค้นหาข้อมูลนักเรียน</h1>
                <p class="text-white opacity-75 fs-5 mb-4">ระบุชื่อ นามสกุล หรือเลขประจำตัวนักเรียน เพื่อเข้าสู่โหมดการแก้ไขข้อมูลเชิงลึก</p>
                <div class="suggested-tags d-flex justify-content-center gap-2 mb-2">
                    <span class="badge tag-clickable" data-query="เด็กชาย">เด็กชาย</span>
                    <span class="badge tag-clickable" data-query="เด็กหญิง">เด็กหญิง</span>
                    <span class="badge tag-clickable" data-query="ม.1">ห้อง ม.1</span>
                    <span class="badge tag-clickable" data-query="ม.4">ห้อง ม.4</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Card -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card search-card-premium mb-5">
                <div class="card-body p-4">
                    <div class="search-input-wrapper">
                        <i class="bx bx-id-card search-icon-main"></i>
                        <input type="text" id="individualSearchTrigger" 
                               class="form-control" 
                               placeholder="พิมพ์ รหัสนักเรียน 5 หลัก หรือ ชื่อ-นามสกุล..."
                               autocomplete="off">
                        <button id="searchExecutionBtn" class="btn btn-success search-btn-hero">
                            <i class="bx bx-search-alt-2 me-1"></i> เริ่มค้นหา
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Display Results -->
    <div id="resultsWrapper" class="row justify-content-center d-none">
        <div class="col-lg-10">
            <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                <h4 class="fw-bold mb-0">🚀 ผลการค้นหาที่พบ (<span id="countIndicator">0</span>)</h4>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">เรียงลำดับ</button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">ชื่อ-นามสกุล (ก-ฮ)</a></li>
                        <li><a class="dropdown-item" href="#">รหัสนักเรียน (น้อย-มาก)</a></li>
                    </ul>
                </div>
            </div>
            
            <div id="resultsContainer">
                <!-- Items Dynamic Content -->
            </div>
        </div>
    </div>

    <!-- Instructions / Empty State -->
    <div id="guidanceState" class="row justify-content-center mt-5">
        <div class="col-lg-8 text-center py-5">
            <div class="d-inline-flex p-4 rounded-circle bg-label-success mb-4">
                <i class="bx bx-detail fs-1"></i>
            </div>
            <h3 class="fw-bold text-dark">ระบบค้นหาอัจฉริยะ</h3>
            <p class="text-muted fs-5 mb-0 px-md-5">คุณสามารถระบุข้อมูลบางส่วน เช่น "สมชาย" หรือรหัส "12345" <br>ระบบจะดึงข้อมูลที่เกี่ยวข้องล่าสุดจากฐานข้อมูลทันที</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mainInput = document.getElementById('individualSearchTrigger');
    const searchBtn = document.getElementById('searchExecutionBtn');
    const wrapper = document.getElementById('resultsWrapper');
    const container = document.getElementById('resultsContainer');
    const countText = document.getElementById('countIndicator');
    const guidance = document.getElementById('guidanceState');

    if (searchBtn) {
        searchBtn.addEventListener('click', triggerProcessing);
        mainInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') triggerProcessing();
        });
    }

    // Tag clickable logic
    document.querySelectorAll('.tag-clickable').forEach(tag => {
        tag.addEventListener('click', function() {
            mainInput.value = this.getAttribute('data-query');
            mainInput.focus();
            triggerProcessing();
        });
    });

    function triggerProcessing() {
        const query = mainInput.value.trim();
        if (query.length < 2) {
            Swal.fire({
                icon: 'info',
                title: 'ระบุคำค้นหาเพิ่มอีกนิด',
                text: 'กรุณาพิมพ์อย่างน้อย 2 ตัวอักษรขึ้นไปครับ',
                confirmButtonColor: '#15a362'
            });
            return;
        }

        Swal.fire({
            title: 'กำลังตรวจสอบข้อมูล...',
            html: '<div class="py-3"><div class="spinner-grow text-success" role="status"></div></div>',
            showConfirmButton: false,
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        const fd = new FormData();
        fd.append('search', query);

        // เปลี่ยนมาใช้ $.post เพื่อให้ใช้งานร่วมกับ Global CSRF Setup ได้ครับ 💎
        $.post("<?= base_url('Admin/Acade/Registration/Students/AdjustNumberGlobalSearch') ?>", { search: query })
        .done(function(data) {
            container.innerHTML = '';
            Swal.close();

            // ตรวจสอบว่า data เป็น Array หรือไม่ป้องกัน Error .forEach
            if (!Array.isArray(data) || data.length === 0) {
                wrapper.classList.add('d-none');
                guidance.classList.remove('d-none');
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่พบข้อมูล',
                    text: 'ไม่พบรายชื่อนักเรียนที่มีคำว่า "' + query + '" ในระบบ',
                    confirmButtonColor: '#15a362'
                });
            } else {
                data.forEach((s, index) => {
                    const roomInfo = s.StudentClass || 'ยังไม่มีห้อง';
                    const sClass = (s.StudentStatus && s.StudentStatus.includes('ปกติ')) ? 'bg-label-success' : 'bg-label-danger';
                    const editLink = "<?= base_url('Admin/Acade/Registration/Students/Edit') ?>/" + s.StudentID;
                    
                    container.innerHTML += `
                        <div class="student-entry-card animate-item" style="animation-delay: ${index * 0.05}s">
                            <div class="d-flex align-items-center">
                                <div class="student-avatar me-4">
                                    ${(s.StudentFirstName || 'S').charAt(0)}
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1 text-dark">${s.StudentPrefix || ''}${s.StudentFirstName || ''} ${s.StudentLastName || ''}</h5>
                                    <div class="d-flex gap-2">
                                        <span class="badge bg-label-primary">รหัสนักเรียน: ${s.StudentCode || ''}</span>
                                        <span class="badge bg-label-info">ห้อง: ${roomInfo}</span>
                                        <span class="badge ${sClass}">${s.StudentStatus || '-'}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="action-zone">
                                <a href="${editLink}" class="btn btn-primary px-4 py-2 fw-bold rounded-pill">
                                    <i class="bx bx-edit-alt me-1"></i> แก้ไขข้อมูล
                                </a>
                            </div>
                        </div>
                    `;
                });

                countText.textContent = data.length;
                wrapper.classList.remove('d-none');
                guidance.classList.add('d-none');
                
                // Smooth focus
                wrapper.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        })
        .fail(function(xhr, status, error) {
            console.error('Error:', error);
            Swal.fire('ผิดพลาด', 'ระบบเชื่อมต่อขัดข้อง: ' + (xhr.responseJSON ? xhr.responseJSON.message : error), 'error');
        });
    }
});
</script>
<?= $this->endSection() ?>
