<style>
    /* Premium Green Sidebar Theme - Header Focus & Soft Active */
    :root {
        --sidebar-bg: #FFFFFF;
        --sidebar-primary: #15a362;
        --sidebar-active-soft: #f0faf5;
        --sidebar-text: #435971;
        --sidebar-icon-default: #697a8d;
    }

    /* Fix Icons visibility */
    .menu-vertical .menu-icon {
        color: var(--sidebar-icon-default);
        transition: all 0.2s ease;
    }

    /* Menu Base Styling */
    .menu-vertical .menu-item .menu-link {
        font-family: 'K2D', sans-serif;
        transition: all 0.2s ease;
        border-radius: 0.375rem;
        margin: 0.2rem 0.85rem;
        padding-top: 0.65rem;
        padding-bottom: 0.65rem;
    }

    /* 🟢 Main Header/Parent Styling - Solid Green when Open */
    .menu-vertical .menu-item.open > .menu-link {
        background-color: var(--sidebar-primary) !important;
        color: #FFFFFF !important;
        box-shadow: 0 4px 12px rgba(21, 163, 98, 0.2);
    }

    .menu-vertical .menu-item.open > .menu-link .menu-icon {
        color: #FFFFFF !important;
    }

    /* ⚪ Active Item Styling - Soft Green with Light Shadow */
    .menu-vertical .menu-item.active:not(.open) > .menu-link,
    .menu-vertical .menu-sub .menu-item.active > .menu-link {
        background-color: var(--sidebar-active-soft) !important;
        color: var(--sidebar-primary) !important;
        font-weight: 700;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05) !important;
        border: 1px solid rgba(21, 163, 98, 0.1);
    }

    .menu-vertical .menu-item.active:not(.open) .menu-icon,
    .menu-vertical .menu-sub .menu-item.active .menu-icon {
        color: var(--sidebar-primary) !important;
    }

    /* Submenu Layout & Indentation - Reverted to Standard */
    .menu-vertical .menu-sub {
        background: transparent !important;
        padding: 0.25rem 0;
    }

    .menu-vertical .menu-sub .menu-item .menu-link {
        padding-left: 2.5rem !important; /* Standard indentation */
        font-size: 0.85rem;
        position: relative;
    }

    /* Submenu Visual Bullet - Reverted */
    .menu-vertical .menu-sub .menu-item .menu-link::before {
        content: "";
        position: absolute;
        left: 1.2rem; /* Standard bullet position */
        top: 50%;
        transform: translateY(-50%);
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background-color: #cbd5e0;
        transition: all 0.2s ease;
    }

    .menu-vertical .menu-sub .menu-item.active .menu-link::before {
        background-color: var(--sidebar-primary);
        width: 12px;
        height: 3px;
        border-radius: 2px;
    }

    /* Hover State */
    .menu-vertical .menu-item:not(.active):not(.open) > .menu-link:hover {
        background-color: #f8fdfb;
        color: var(--sidebar-primary) !important;
    }
    
    .menu-vertical .menu-item:not(.active):not(.open) > .menu-link:hover .menu-icon {
        color: var(--sidebar-primary) !important;
    }

    /* Academic Year Card */
    .sidebar-year-wrapper {
        margin: 1.25rem 0.85rem;
        padding: 1rem;
        background: #fdfdfd;
        border: 1px solid #f0f0f0;
        border-top: 3px solid var(--sidebar-primary);
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .year-label {
        font-size: 0.7rem;
        color: #888;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
        display: block;
    }

    .menu-header-text {
        color: #adb5bd !important;
        font-size: 0.7rem !important;
        letter-spacing: 1px;
        padding-left: 1.5rem !important;
        margin-top: 1.5rem;
    }
</style>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo py-3">
        <a href="<?=base_url('Admin/Home');?>" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img class="img-fluid" src="https://skj.ac.th/uploads/logo/LogoSKJ_4.png" alt="logo" style="height:45px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2" style="color: #1b5e20; font-size: 1.2rem;">งานวิชาการ สกจ.</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left align-middle fs-4"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>

    <!-- Academic Year Selection -->
    <div class="sidebar-year-wrapper">
        <div class="year-label">
            <i class='bx bxs-calendar-check me-1 fs-6'></i> ปีการศึกษาที่ใช้งาน
        </div>
        <?php $currentSelected = get_selected_year(); ?>
        <select name="schyear_year" id="schyear_year_sidebar" class="form-select form-select-sm border-light-subtle shadow-none" style="font-weight: 700; color: #1b5e20; border-radius: 4px;">
            <?php $Y = date('Y')+543;
                for ($i=2565; $i <= $Y+2; $i++):
                    for ($j=1; $j <= 2; $j++) : ?>
                        <option <?=($currentSelected == $j.'/'.$i) ?"selected":""?> value="<?=$j.'/'.$i;?>"><?=$j.'/'.$i;?></option>
            <?php endfor; endfor; ?>
        </select>
    </div>



    <?php $uri = service('uri'); ?>
    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item <?= ($uri->getTotalSegments() <= 2 && $uri->getSegment(1) == 'Admin' && ($uri->getSegment(2) == 'Home' || $uri->getSegment(2) == '') ? 'active' : '') ?>">
            <a href="<?=base_url('Admin/Home');?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-alt"></i>
                <div data-i18n="หน้าหลัก">หน้าหลัก</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">บริหารงานวิชาการ</span>
        </li>

        <?php 
        $CheckrloesAcademic = session()->get('CheckrloesAcademic') ?? '';
        $Exp_Checkrloes = explode('|', $CheckrloesAcademic);
        ?>

        <?php if(in_array("งานทะเบียน",$Exp_Checkrloes)): ?>
        <li class="menu-item <?= ($uri->getTotalSegments() >= 3 && ($uri->getSegment(3) == 'Registration' || $uri->getSegment(3) == 'Evaluate' || $uri->getSegment(3) == 'characteristics' || $uri->getSegment(3) == 'rwl')) ? 'active open' : '' ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="งานทะเบียน">งานทะเบียน</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'Enroll' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Registration/Enroll');?>" class="menu-link">
                        <div data-i18n="ลงทะเบียนเรียน (ปกติ)">ลงทะเบียนเรียน (ปกติ)</div>
                    </a>
                </li>
                <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'Repeat' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Registration/Repeat');?>" class="menu-link">
                        <div data-i18n="ลงทะเบียนเรียน (ซ้ำ)">ลงทะเบียนเรียน (ซ้ำ)</div>
                    </a>
                </li>
                <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'ClassRoom' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Registration/ClassRoom');?>" class="menu-link">
                        <div data-i18n="จัดการห้องเรียน / ที่ปรึกษา">จัดการห้องเรียน / ที่ปรึกษา</div>
                    </a>
                </li>
                <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'Students' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Registration/Students');?>" class="menu-link">
                        <div data-i18n="จัดการนักเรียน">จัดการนักเรียน</div>
                    </a>
                </li>
                <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'ExamSchedule' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Registration/ExamSchedule');?>" class="menu-link">
                        <div data-i18n="จัดการตารางสอบ">จัดการตารางสอบ</div>
                    </a>
                </li>
                <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'RoomOnline' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Registration/RoomOnline');?>" class="menu-link">
                        <div data-i18n="จัดการห้องเรียนออนไลน์">จัดการห้องเรียนออนไลน์</div>
                    </a>
                </li>
                <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && ($uri->getSegment(4) == 'ReportTeacherSaveScore' || strpos($uri->getSegment(4), 'ReportTeacherSaveScore') === 0) && $uri->getSegment(3) == 'Evaluate') ? 'active' : '' ?>">
                    <a href="<?=base_url('Admin/Acade/Evaluate/ReportTeacherSaveScore');?>" class="menu-link">
                        <div data-i18n="รายงานผลการบันทึกคะแนน (ครูผู้สอน)" style="white-space: normal;">รายงานผลการบันทึกคะแนน (ครูผู้สอน)</div>
                    </a>
                </li>
                <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'ReportScoreRoomMain' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Evaluate/ReportScoreRoomMain');?>" class="menu-link">
                        <div data-i18n="รายงานผลการบันทึกคะแนน (รายห้องเรียน)" style="white-space: normal;">รายงานผลการบันทึกคะแนน (รายห้องเรียน)</div>
                    </a>
                </li>
                <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'ReportPerson' && $uri->getTotalSegments() >= 3 && $uri->getSegment(3) == 'Evaluate' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Evaluate/ReportPerson');?>" class="menu-link">
                        <div data-i18n="รายงานผลการเรียนรายบุคคล" style="white-space: normal;">รายงานผลการเรียนรายบุคคล</div>
                    </a>
                </li>
                <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'ReportRoom' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Evaluate/ReportRoom');?>" class="menu-link">
                        <div data-i18n="รายงานผลการเรียนรายห้องเรียน" style="white-space: normal;">รายงานผลการเรียนรายห้องเรียน</div>
                    </a>
                </li>
                <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'ReportAcademicSummary' && $uri->getTotalSegments() >= 3 && $uri->getSegment(3) == 'Evaluate' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Evaluate/ReportAcademicSummary?SelLern=0');?>" class="menu-link">
                        <div data-i18n="รายงานสรุปผลสัมฤทธิ์ทางการเรียน" style="white-space: normal;">รายงานสรุปผลสัมฤทธิ์ทางการเรียน</div>
                    </a>
                </li>
                <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'ReportAcademicSummaryRoyalRoseStandard' && $uri->getTotalSegments() >= 3 && $uri->getSegment(3) == 'Evaluate' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Evaluate/ReportAcademicSummaryRoyalRoseStandard?SelLern=0');?>" class="menu-link">
                        <div data-i18n="รายการผลสัมฤทธิ์ทางการเรียนตามมาตรฐานกุหลาบหลวง" style="white-space: normal;">รายการผลสัมฤทธิ์ทางการเรียนตามมาตรฐานกุหลาบหลวง</div>
                    </a>
                </li>
                <hr>
                <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'AcademicRepeat' ? 'active' : '') ?>">
                    <a href="<?= base_url('Admin/Acade/Evaluate/AcademicRepeat'); ?>" class="menu-link">
                        <div data-i18n="ตั้งค่าเรียนซ้ำ (มส)">ตั้งค่าเรียนซ้ำ (มส)</div>
                    </a>
                </li>
                <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'AcademicResult' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Evaluate/AcademicResult');?>" class="menu-link">
                        <div data-i18n="ตั้งค่าแสดงผลการเรียนนักเรียน" style="white-space: normal;">ตั้งค่าแสดงผลการเรียนนักเรียน</div>
                    </a>
                </li>
                <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'SaveScore' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Evaluate/SaveScore');?>" class="menu-link">
                        <div data-i18n="ตั้งค่าบันทึกผลการเรียน" style="white-space: normal;">ตั้งค่าบันทึกผลการเรียน</div>
                    </a>
                </li>
                <li class="menu-item <?= ($uri->getTotalSegments() >= 2 && $uri->getSegment(2) == 'academic' && $uri->getTotalSegments() >= 3 && $uri->getSegment(3) == 'characteristics' ? 'active' : '') ?>">
                    <a href="<?=base_url('admin/academic/characteristics/settings');?>" class="menu-link">
                        <div data-i18n="ตั้งค่าประเมินคุณลักษณะ" style="white-space: normal;">ตั้งค่าประเมินคุณลักษณะ</div>
                    </a>
                </li>
                <li class="menu-item <?= ($uri->getTotalSegments() >= 2 && $uri->getSegment(2) == 'academic' && $uri->getTotalSegments() >= 3 && $uri->getSegment(3) == 'rwl' ? 'active' : '') ?>">
                    <a href="<?=base_url('admin/academic/rwl/settings');?>" class="menu-link">
                        <div data-i18n="ตั้งค่าประเมินการอ่านฯ" style="white-space: normal;">ตั้งค่าประเมินการอ่านฯ</div>
                    </a>
                </li>
            </ul>
        </li>
        <?php endif; ?>

        <?php if(in_array("งานหลักสูตร",$Exp_Checkrloes)): ?>
        <li class="menu-item <?= ($uri->getTotalSegments() >= 3 && ($uri->getSegment(3) == 'Course' || $uri->getSegment(3) == 'Research')) || ($uri->getSegment(2) == 'academic' && ($uri->getSegment(3) == 'checkplan' || ($uri->getSegment(3) == 'report' && $uri->getSegment(4) == 'checkplan'))) ? 'active open' : '' ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-edit"></i>
                <div data-i18n="งานหลักสูตร">งานหลักสูตร</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'RegisterSubject' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Course/RegisterSubject');?>" class="menu-link">
                        <div data-i18n="จัดการวิชาเรียน">จัดการวิชาเรียน</div>
                    </a>
                </li>
                <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'ClassSchedule' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Course/ClassSchedule');?>" class="menu-link">
                        <div data-i18n="จัดการตารางเรียน">จัดการตารางเรียน</div>
                    </a>
                </li>
                <hr>
                <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'SendPlan' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Course/SendPlan');?>" class="menu-link">
                        <div data-i18n="ตั้งค่าส่งแผน">ตั้งค่าส่งแผน</div>
                    </a>
                </li>
                <li class="menu-item <?= ($uri->getTotalSegments() >= 3 && $uri->getSegment(3) == 'checkplan' ? 'active' : '') ?>">
                    <a href="<?=base_url('admin/academic/checkplan');?>" class="menu-link">
                        <div data-i18n="ตรวจแผนการสอน">ตรวจแผนการสอน</div>
                    </a>
                </li>
                <li class="menu-item <?= ($uri->getTotalSegments() >= 3 && $uri->getSegment(3) == 'report' && $uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'checkplan' ? 'active' : '') ?>">
                    <a href="<?=base_url('admin/academic/report/checkplan');?>" class="menu-link">
                        <div data-i18n="รายงานการส่งแผนการสอน">รายงานการส่งแผนการสอน</div>
                    </a>
                </li>
                <hr>
                <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(3) == 'Research' && $uri->getSegment(4) == 'Setup' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Research/Setup');?>" class="menu-link">
                        <div data-i18n="ตั้งค่าส่งงานวิจัย">ตั้งค่าส่งงานวิจัย</div>
                    </a>
                </li>
                <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(3) == 'Research' && $uri->getSegment(4) == 'Report' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Research/Report');?>" class="menu-link">
                        <div data-i18n="รายงานส่งงานวิจัย">รายงานส่งงานวิจัย</div>
                    </a>
                </li>
            </ul>
        </li>
        <?php endif; ?>

        <?php if(in_array("งานกิจกรรมพัฒนาผู้เรียน",$Exp_Checkrloes)): ?>
        <li class="menu-item <?= ($uri->getTotalSegments() >= 3 && $uri->getSegment(3) == 'DevelopStudents' || ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'student-registrations') ? 'active open' : '' ) ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                <div data-i18n="งานพัฒนาผู้เรียน">งานพัฒนาผู้เรียน</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && ($uri->getSegment(4) == 'Clubs' || $uri->getSegment(4) == 'student-registrations') ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/DevelopStudents/Clubs/Main');?>" class="menu-link">
                        <div data-i18n="จัดการชุมนุม">จัดการชุมนุม</div>
                    </a>
                </li>
            </ul>
        </li>
        <?php endif; ?>

        <?php if(in_array("งานแนะแนว",$Exp_Checkrloes)): ?>
        <li class="menu-item <?= ($uri->getTotalSegments() >= 3 && $uri->getSegment(3) == 'Guidance') ? 'active open' : '' ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-street-view"></i>
                <div data-i18n="งานแนะแนว">งานแนะแนว</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'HomeVisit' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Guidance/HomeVisit');?>" class="menu-link">
                        <div data-i18n="ข้อมูลเยี่ยมบ้าน">ข้อมูลเยี่ยมบ้าน</div>
                    </a>
                </li>
            </ul>
        </li>
        <?php endif; ?>

        <?php 
        $session = session();
        if($session->get('status') === "manager" || $session->get('login_id') == "pers_021"):?>
        <li class="menu-item <?= ($uri->getTotalSegments() >= 2 && $uri->getSegment(2) == 'Acade' && $uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'AdminRoles' ? 'active' : '') ?>">
            <a href="<?=base_url('Admin/Acade/Setting/AdminRoles');?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-shield-quarter"></i>
                <div data-i18n="จัดการบทบาท">จัดการบทบาท</div>
            </a>
        </li>
        <?php endif; ?>
    </ul>
</aside>