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

    .menu-header {
        margin-top: 1.25rem !important;
    }

    .menu-header-text {
        color: #adb5bd !important;
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        letter-spacing: 1px;
        padding-left: 1.5rem !important;
        margin-bottom: 0.5rem;
        display: block;
        border-left: 3px solid var(--sidebar-primary);
        line-height: 1;
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

    <?php 
    $uri = service('uri'); 
    $totalSegments = $uri->getTotalSegments();
    $s1 = $totalSegments >= 1 ? $uri->getSegment(1) : '';
    $s2 = $totalSegments >= 2 ? $uri->getSegment(2) : '';
    $s3 = $totalSegments >= 3 ? $uri->getSegment(3) : '';
    $s4 = $totalSegments >= 4 ? $uri->getSegment(4) : '';
    $s5 = $totalSegments >= 5 ? $uri->getSegment(5) : '';
    ?>
    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item <?= ($totalSegments <= 2 && $s1 == 'Admin' && ($s2 == 'Home' || $s2 == '') ? 'active' : '') ?>">
            <a href="<?=base_url('Admin/Home');?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-alt"></i>
                <div data-i18n="หน้าหลัก">หน้าหลัก</div>
            </a>
        </li>

        <?php 
        $CheckrloesAcademic = session()->get('CheckrloesAcademic') ?? '';
        $Exp_Checkrloes = explode('|', $CheckrloesAcademic);
        ?>

        <!-- 1. งานทะเบียนและสถิติ -->
        <?php if(in_array("งานทะเบียน",$Exp_Checkrloes)): ?>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">งานทะเบียนและสถิติ</span>
        </li>
        
        <li class="menu-item <?= ($totalSegments >= 4 && ($s4 == 'Enroll' || $s4 == 'Repeat') ? 'active open' : '') ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="ลงทะเบียนเรียน">ลงทะเบียนเรียน</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= ($s4 == 'Enroll' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Registration/Enroll');?>" class="menu-link">
                        <div data-i18n="ลงทะเบียนปกติ">ลงทะเบียนปกติ</div>
                    </a>
                </li>
                <li class="menu-item <?= ($s4 == 'Repeat' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Registration/Repeat');?>" class="menu-link">
                        <div data-i18n="ลงทะเบียนเรียนซ้ำ">ลงทะเบียนเรียนซ้ำ</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item <?= ($totalSegments >= 4 && $s4 == 'Students' ? 'active open' : '') ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user-pin"></i>
                <div data-i18n="จัดการนักเรียน">จัดการนักเรียน</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= ($s4 == 'Students' && $s5 == '' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Registration/Students');?>" class="menu-link">
                        <div data-i18n="ภาพรวมจัดการนักเรียน">ภาพรวมจัดการนักเรียน</div>
                    </a>
                </li>
                <li class="menu-item <?= ($s4 == 'Students' && $s5 == 'Add' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Registration/Students/Add');?>" class="menu-link">
                        <div data-i18n="เพิ่มนักเรียนใหม่">เพิ่มนักเรียนใหม่</div>
                    </a>
                </li>
                <li class="menu-item <?= ($s4 == 'Students' && $s5 == 'Edit' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Registration/Students/Edit');?>" class="menu-link">
                        <div data-i18n="ค้นหา/แก้ไขรายบุคคล">ค้นหา/แก้ไขรายบุคคล</div>
                    </a>
                </li>
                <li class="menu-item <?= ($s4 == 'Students' && $s5 == 'AdjustNumber' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Registration/Students/AdjustNumber');?>" class="menu-link">
                        <div data-i18n="จัดเลขที่ห้องเรียน">จัดเลขที่ห้องเรียน</div>
                    </a>
                </li>
                <li class="menu-item <?= ($s4 == 'Students' && $s5 == 'Lifecycle' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Registration/Students/Lifecycle');?>" class="menu-link">
                        <div data-i18n="เลื่อนชั้น/จบการศึกษา">เลื่อนชั้น/จบการศึกษา</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item <?= ($totalSegments >= 4 && $s4 == 'ClassRoom' ? 'active' : '') ?>">
            <a href="<?=base_url('Admin/Acade/Registration/ClassRoom');?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="จัดการห้องเรียน / ที่ปรึกษา">จัดการห้องเรียน / ที่ปรึกษา</div>
            </a>
        </li>
        <li class="menu-item <?= ($totalSegments >= 4 && ($s4 == 'ExamSchedule' || $s4 == 'RoomOnline') ? 'active open' : '') ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-calendar-event"></i>
                <div data-i18n="ตารางสอบ & ออนไลน์">ตารางสอบ & ออนไลน์</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= ($s4 == 'ExamSchedule' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Registration/ExamSchedule');?>" class="menu-link">
                        <div data-i18n="จัดการตารางสอบ">จัดการตารางสอบ</div>
                    </a>
                </li>
                <li class="menu-item <?= ($s4 == 'RoomOnline' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Registration/RoomOnline');?>" class="menu-link">
                        <div data-i18n="จัดการห้องเรียนออนไลน์">จัดการห้องเรียนออนไลน์</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- 2. งานวัดผลและประเมินผล -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">งานวัดผลและประเมินผล</span>
        </li>
        <li class="menu-item <?= ($totalSegments >= 4 && ($s4 == 'ReportTeacherSaveScore' || $s4 == 'ReportTeacherSaveScoreCheck' || $s4 == 'ReportScoreRoomMain') ? 'active open' : '' ) ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
                <div data-i18n="รายงานผลคะแนน">รายงานผลคะแนน</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= ($s4 == 'ReportTeacherSaveScore' || $s4 == 'ReportTeacherSaveScoreCheck' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Evaluate/ReportTeacherSaveScore');?>" class="menu-link">
                        <div data-i18n="บันทึกคะแนน (ครู)">บันทึกคะแนน (ครู)</div>
                    </a>
                </li>
                <li class="menu-item <?= ($s4 == 'ReportScoreRoomMain' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Evaluate/ReportScoreRoomMain');?>" class="menu-link">
                        <div data-i18n="บันทึกคะแนน (ห้อง)">บันทึกคะแนน (ห้อง)</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item <?= ($totalSegments >= 4 && ($s4 == 'ReportPerson' || $s4 == 'ReportRoom' || $s4 == 'ReportAcademicSummary' || $s4 == 'ReportAcademicSummaryRoyalRoseStandard') ? 'active open' : '' ) ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="รายงานผลการเรียน">รายงานผลการเรียน</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= ($s4 == 'ReportPerson' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Evaluate/ReportPerson');?>" class="menu-link">
                        <div data-i18n="รายบุคคล (ปพ.1/6)">รายบุคคล (ปพ.1/6)</div>
                    </a>
                </li>
                <li class="menu-item <?= ($s4 == 'ReportRoom' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Evaluate/ReportRoom');?>" class="menu-link">
                        <div data-i18n="รายห้องเรียน">รายห้องเรียน</div>
                    </a>
                </li>
                <li class="menu-item <?= ($s4 == 'ReportAcademicSummary' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Evaluate/ReportAcademicSummary?SelLern=0');?>" class="menu-link">
                        <div data-i18n="สรุปผลสัมฤทธิ์">สรุปผลสัมฤทธิ์</div>
                    </a>
                </li>
                <li class="menu-item <?= ($s4 == 'ReportAcademicSummaryRoyalRoseStandard' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Evaluate/ReportAcademicSummaryRoyalRoseStandard?SelLern=0');?>" class="menu-link">
                        <div data-i18n="มาตรฐานกุหลาบหลวง">มาตรฐานกุหลาบหลวง</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item <?= ($totalSegments >= 3 && ($s3 == 'Evaluate' || $s3 == 'characteristics' || $s3 == 'rwl') && (in_array($s4, ['AcademicRepeat', 'AcademicResult', 'SaveScore']) || $s3 == 'characteristics' || $s3 == 'rwl') ? 'active open' : '') ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="ตั้งค่าระบบวัดผล">ตั้งค่าระบบวัดผล</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= ($s4 == 'AcademicRepeat' ? 'active' : '') ?>">
                    <a href="<?= base_url('Admin/Acade/Evaluate/AcademicRepeat'); ?>" class="menu-link">
                        <div data-i18n="ตั้งค่าเรียนซ้ำ (มส)">ตั้งค่าเรียนซ้ำ (มส)</div>
                    </a>
                </li>
                <li class="menu-item <?= ($s4 == 'AcademicResult' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Evaluate/AcademicResult');?>" class="menu-link">
                        <div data-i18n="ตั้งค่าแสดงผลการเรียน">ตั้งค่าแสดงผลการเรียน</div>
                    </a>
                </li>
                <li class="menu-item <?= ($s4 == 'SaveScore' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Evaluate/SaveScore');?>" class="menu-link">
                        <div data-i18n="ตั้งค่าบันทึกคะแนน">ตั้งค่าบันทึกคะแนน</div>
                    </a>
                </li>
                <li class="menu-item <?= ($s3 == 'characteristics' ? 'active' : '') ?>">
                    <a href="<?=base_url('admin/academic/characteristics/settings');?>" class="menu-link">
                        <div data-i18n="ประเมินคุณลักษณะ">ประเมินคุณลักษณะ</div>
                    </a>
                </li>
                <li class="menu-item <?= ($s3 == 'rwl' ? 'active' : '') ?>">
                    <a href="<?=base_url('admin/academic/rwl/settings');?>" class="menu-link">
                        <div data-i18n="ประเมินการอ่านฯ">ประเมินการอ่านฯ</div>
                    </a>
                </li>
            </ul>
        </li>
        <?php endif; ?>

        <!-- 3. งานหลักสูตรและนิเทศ -->
        <?php if(in_array("งานหลักสูตร",$Exp_Checkrloes)): ?>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">งานหลักสูตรและนิเทศ</span>
        </li>
        <li class="menu-item <?= ($s4 == 'RegisterSubject' ? 'active' : '') ?>">
            <a href="<?=base_url('Admin/Acade/Course/RegisterSubject');?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book-open"></i>
                <div data-i18n="จัดการวิชาเรียน">จัดการวิชาเรียน</div>
            </a>
        </li>
        <li class="menu-item <?= ($s4 == 'ClassSchedule' ? 'active' : '') ?>">
            <a href="<?=base_url('Admin/Acade/Course/ClassSchedule');?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                <div data-i18n="จัดการตารางเรียน">จัดการตารางเรียน</div>
            </a>
        </li>
        <li class="menu-item <?= ($s3 == 'timetable' ? 'active open' : '') ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-calendar-star" style="color: #15a362 !important;"></i>
                <div data-i18n="จัดตารางสอน (Auto)" style="font-weight: 700;">จัดตารางสอน (Auto)</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= ($s3 == 'timetable' && $s4 == 'process' ? 'active' : '') ?>">
                    <a href="<?=base_url('admin/academic/timetable/process');?>" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-magic-wand"></i>
                        <div data-i18n="จัดการและจัดตารางสอน">จัดการและจัดตารางสอน</div>
                    </a>
                </li>
                <li class="menu-item <?= ($s3 == 'timetable' && $s4 == 'full' ? 'active' : '') ?>">
                    <a href="<?=base_url('admin/academic/timetable/full');?>" class="menu-link">
                        <div data-i18n="ตารางสอนรวม">ตารางสอนรวม</div>
                    </a>
                </li>
                <li class="menu-item <?= ($s3 == 'timetable' && ($s4 == 'teacher-timetables' || $s4 == 'view-teacher') ? 'active' : '') ?>">
                    <a href="<?=base_url('admin/academic/timetable/teacher-timetables');?>" class="menu-link">
                        <div data-i18n="ตารางสอนรายครู">ตารางสอนรายครู</div>
                    </a>
                </li>
                <li class="menu-item <?= ($s3 == 'timetable' && ($s4 == 'class-timetables' || $s4 == 'view-class') ? 'active' : '') ?>">
                    <a href="<?=base_url('admin/academic/timetable/class-timetables');?>" class="menu-link">
                        <div data-i18n="ตารางเรียนรายห้อง">ตารางเรียนรายห้อง</div>
                    </a>
                </li>
                <li class="menu-item <?= ($s3 == 'timetable' && $s4 == 'teacher-constraints' ? 'active' : '') ?>">
                    <a href="<?=base_url('admin/academic/timetable/teacher-constraints');?>" class="menu-link">
                        <div data-i18n="เงื่อนไขเวลาครู">เงื่อนไขเวลาครู</div>
                    </a>
                </li>
                <li class="menu-item <?= ($s3 == 'timetable' && $s4 == 'subject-groups' ? 'active' : '') ?>">
                    <a href="<?=base_url('admin/academic/timetable/subject-groups');?>" class="menu-link">
                        <div data-i18n="กลุ่มวิชาเรียนพร้อมกัน">กลุ่มวิชาเรียนพร้อมกัน</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item <?= ($s4 == 'SendPlan' || $s3 == 'checkplan' || ($s3 == 'report' && $s4 == 'checkplan') ? 'active open' : '') ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-edit"></i>
                <div data-i18n="นิเทศ/แผนการสอน">นิเทศ/แผนการสอน</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= ($s4 == 'SendPlan' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Course/SendPlan');?>" class="menu-link">
                        <div data-i18n="ตั้งค่าส่งแผน">ตั้งค่าส่งแผน</div>
                    </a>
                </li>
                <li class="menu-item <?= ($s3 == 'checkplan' ? 'active' : '') ?>">
                    <a href="<?=base_url('admin/academic/checkplan');?>" class="menu-link">
                        <div data-i18n="ตรวจแผนการสอน">ตรวจแผนการสอน</div>
                    </a>
                </li>
                <li class="menu-item <?= ($s3 == 'report' && $s4 == 'checkplan' ? 'active' : '') ?>">
                    <a href="<?=base_url('admin/academic/report/checkplan');?>" class="menu-link">
                        <div data-i18n="รายงานการส่งแผน">รายงานการส่งแผน</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- 4. งานวิจัยเพื่อพัฒนาคุณภาพ -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">งานวิจัยเพื่อพัฒนาคุณภาพ</span>
        </li>
        <li class="menu-item <?= ($s3 == 'Research' ? 'active open' : '') ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-search-alt-2"></i>
                <div data-i18n="งานวิจัยในชั้นเรียน">งานวิจัยในชั้นเรียน</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= ($s4 == 'Setup' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Research/Setup');?>" class="menu-link">
                        <div data-i18n="ตั้งค่าส่งงานวิจัย">ตั้งค่าส่งงานวิจัย</div>
                    </a>
                </li>
                <li class="menu-item <?= ($s4 == 'Report' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Research/Report');?>" class="menu-link">
                        <div data-i18n="รายงานส่งงานวิจัย">รายงานส่งงานวิจัย</div>
                    </a>
                </li>
            </ul>
        </li>
        <?php endif; ?>

        <!-- 5. กิจกรรมและแนะแนว -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">กิจกรรมและแนะแนว</span>
        </li>
        <?php if(in_array("งานกิจกรรมพัฒนาผู้เรียน",$Exp_Checkrloes)): ?>
        <li class="menu-item <?= ($totalSegments >= 3 && $s3 == 'DevelopStudents' || ($totalSegments >= 4 && $s4 == 'student-registrations') ? 'active open' : '' ) ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-extension"></i>
                <div data-i18n="งานพัฒนาผู้เรียน">งานพัฒนาผู้เรียน</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= ($totalSegments >= 4 && ($s4 == 'Clubs' || $s4 == 'student-registrations') ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/DevelopStudents/Clubs/Main');?>" class="menu-link">
                        <div data-i18n="จัดการชุมนุม">จัดการชุมนุม</div>
                    </a>
                </li>
            </ul>
        </li>
        <?php endif; ?>

        <?php if(in_array("งานแนะแนว",$Exp_Checkrloes)): ?>
        <li class="menu-item <?= ($totalSegments >= 3 && $s3 == 'Guidance') ? 'active open' : '' ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-street-view"></i>
                <div data-i18n="งานแนะแนว">งานแนะแนว</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= ($totalSegments >= 4 && $s4 == 'HomeVisit' ? 'active' : '') ?>">
                    <a href="<?=base_url('Admin/Acade/Guidance/HomeVisit');?>" class="menu-link">
                        <div data-i18n="ข้อมูลเยี่ยมบ้าน">ข้อมูลเยี่ยมบ้าน</div>
                    </a>
                </li>
            </ul>
        </li>
        <?php endif; ?>

        <!-- ตั้งค่าระบบ -->
        <?php 
        $session = session();
        if($session->get('status') === "manager" || $session->get('login_id') == "pers_021"):?>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">การตั้งค่าระบบ</span>
        </li>
        <li class="menu-item <?= ($totalSegments >= 4 && $s4 == 'AdminRoles' ? 'active' : '') ?>">
            <a href="<?=base_url('Admin/Acade/Setting/AdminRoles');?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-shield-quarter"></i>
                <div data-i18n="จัดการบทบาท">จัดการบทบาท</div>
            </a>
        </li>
        <li class="menu-item <?= ($s3 == 'api' ? 'active' : '') ?>">
            <a href="<?=base_url('admin/academic/api');?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-code-block"></i>
                <div data-i18n="จัดการ API">จัดการ API</div>
            </a>
        </li>
        <?php endif; ?>
        <!-- สำรองข้อมูล (Superadmin Only) -->
        <?php 
        $db = \Config\Database::connect();
        $check_super = $db->table('tb_admin_rloes')->where('admin_rloes_userid', session('login_id'))->get()->getRow();
        if (@$check_super->admin_rloes_status === 'superadmin'): ?>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Advanced System Management</span>
        </li>
        <li class="menu-item <?= ($s1 == 'admin' && $s3 == 'backup' ? 'active' : '') ?>">
            <a href="<?=base_url('admin/academic/backup');?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cloud-download" style="color: var(--sidebar-primary) !important;"></i>
                <div data-i18n="สำรองข้อมูลฐานข้อมูล" style="font-weight: 700;">สำรองข้อมูลฐานข้อมูล</div>
            </a>
        </li>
        <li class="menu-item <?= ($s1 == 'diagnostic' && $s2 == 'register-class' ? 'active' : '') ?>">
            <a href="<?=base_url('diagnostic/register-class');?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-list-check" style="color: #ff9f43 !important;"></i>
                <div data-i18n="แก้ไขห้องเรียน (Audit)" style="font-weight: 700;">แก้ไขห้องเรียน (Audit)</div>
            </a>
        </li>
        <?php endif; ?>
    </ul>
</aside>