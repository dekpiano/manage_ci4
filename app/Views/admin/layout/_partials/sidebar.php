            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="index.html" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <img class="img-fluid" src="https://skj.ac.th/uploads/logo/LogoSKJ_4.png" alt="logo" style="height:40px;">
                        </span>
                        <span class="app-brand-text demo menu-text fw-bold ms-2">งานวิชาการ สกจ.</span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <i class="bx bx-chevron-left d-block d-xl-none align-middle"></i>
                    </a>
                </div>

                <div class="menu-divider mt-0"></div>

                <div class="menu-inner-shadow"></div>

                <?php $uri = service('uri'); ?>
                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    <li class="menu-item <?= ($uri->getTotalSegments() <= 2 && $uri->getSegment(1) == 'Admin' && ($uri->getSegment(2) == 'Home' || $uri->getSegment(2) == '') ? 'active' : '') ?>">
                        <a href="<?=base_url('Admin/Home');?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="หน้าหลัก">หน้าหลัก</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <div class="nav-link">
                            <div class="d-flex align-items-center">
                                <div class="ms-3 me-2">
                                    <small>กำลังใช้ปีการศึกษา</small>
                                </div>
                                <select name="schyear_year" id="schyear_year" class="form-select form-select-sm me-3" style="width: auto;" onchange="location = this.value;">
                                    <?php $Y = date('Y')+543;
                                                            for ($i=2565; $i <= $Y+2; $i++):
                                                            for ($j=1; $j <= 2; $j++) : ?>
                                    <option <?=$SchoolYear->schyear_year == $j.'/'.$i ?"selected":""?> value="<?=$j.'/'.$i;?>">
                                        <?=$j.'/'.$i;?></option>
                                    <?php endfor; ?>
                                    <?php endfor; ?>

                                </select>
                            </div>
                        </div>
                    </li>

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">บริหารงานวิชาการ</span>
                    </li>

                    <?php 
                    $CheckrloesAcademic = session()->get('CheckrloesAcademic');
                    $Exp_Checkrloes = explode('|', $CheckrloesAcademic);
                    ?>

                    <?php if(in_array("งานทะเบียน",$Exp_Checkrloes)): ?>
                    <li class="menu-item <?= ($uri->getTotalSegments() >= 3 && $uri->getSegment(3) == 'Registration' ? 'active open' : '') ?>">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-book-content"></i>
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
                        </ul>
                    </li>
                    <?php endif; ?>

                    <?php if(in_array("งานวัดและประเมินผล",$Exp_Checkrloes)): ?>
                    <li class="menu-item <?= ($uri->getTotalSegments() >= 3 && $uri->getSegment(3) == 'Evaluate' ? 'active open' : '') ?>">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-file-find"></i>
                            <div data-i18n="งานวัดและประเมินผล">งานวัดและประเมินผล</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'EditGrade' ? 'active' : '') ?>">
                                <a href="<?=base_url('Admin/Acade/Evaluate/EditGrade/').$SchoolYear->schyear_year?>" class="menu-link">
                                    <div data-i18n="จัดการผลการเรียน (0 ร)">จัดการผลการเรียน (0 ร)</div>
                                </a>
                            </li>
                            <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'AcademicRepeat' ? 'active' : '') ?>">
                                <a href="<?=base_url('Admin/Acade/Evaluate/AcademicRepeat/').(isset($checkOnOff[6]->onoff_year) ? $checkOnOff[6]->onoff_year : '');?>" class="menu-link">
                                    <div data-i18n="จัดการผลการเรียนซ้ำ (มส)">จัดการผลการเรียนซ้ำ (มส)</div>
                                </a>
                            </li>
                            <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'ReportScoreRoomMain' && $uri->getTotalSegments() >= 3 && $uri->getSegment(3) == 'Evaluate' ? 'active' : '') ?>">
                                <a href="<?=base_url('Admin/Acade/Evaluate/ReportScoreRoomMain/').$SchoolYear->schyear_year.'/All/All';?>" class="menu-link">
                                    <div data-i18n="รายงานผลการบันทึกคะแนน (รายห้องเรียน)">รายงานผลการบันทึกคะแนน (รายห้องเรียน)</div>
                                </a>
                            </li>
                            <li class="menu-item <?= (($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'ReportTeacherSaveScore' && $uri->getTotalSegments() >= 3 && $uri->getSegment(3) == 'Evaluate') || ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'ReportTeacherSaveScoreCheck') ? 'active' : '') ?>">
                                <a href="<?=base_url('Admin/Acade/Evaluate/ReportTeacherSaveScore/').$SchoolYear->schyear_year;?>" class="menu-link">
                                    <div data-i18n="รายงานผลการบันทึกคะแนน (ครูผู้สอน)">รายงานผลการบันทึกคะแนน (ครูผู้สอน)</div>
                                </a>
                            </li>
                            <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'ReportPerson' && $uri->getTotalSegments() >= 3 && $uri->getSegment(3) == 'Evaluate' ? 'active' : '') ?>">
                                <a href="<?=base_url('Admin/Acade/Evaluate/ReportPerson');?>" class="menu-link">
                                    <div data-i18n="รายงานผลการเรียนรายบุคคล">รายงานผลการเรียนรายบุคคล</div>
                                </a>
                            </li>
                            <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'ReportRoom' ? 'active' : '') ?>">
                                <a href="<?=base_url('Admin/Acade/Evaluate/ReportRoom');?>" class="menu-link">
                                    <div data-i18n="รายงานผลการเรียนรายห้องเรียน">รายงานผลการเรียนรายห้องเรียน</div>
                                </a>
                            </li>
                            <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'ReportSummaryTeacher' && $uri->getTotalSegments() >= 3 && $uri->getSegment(3) == 'Evaluate' ? 'active' : '') ?>">
                                <a href="<?=base_url('Admin/Acade/Evaluate/ReportSummaryTeacher?SelLern=0');?>" class="menu-link">
                                    <div data-i18n="รายงานสรุปผลสัมฤทธิ์ทางการเรียน">รายงานสรุปผลสัมฤทธิ์ทางการเรียน</div>
                                </a>
                            </li>
                            <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'ReportAcademicSummaryRoyalRoseStandard' && $uri->getTotalSegments() >= 3 && $uri->getSegment(3) == 'Evaluate' ? 'active' : '') ?>">
                                <a href="<?=base_url('Admin/Acade/Evaluate/ReportAcademicSummaryRoyalRoseStandard?SelLern=0');?>" class="menu-link">
                                    <div data-i18n="รายการผลสัมฤทธิ์ทางการเรียนตามมาตรฐานกุหลาบหลวง">รายการผลสัมฤทธิ์ทางการเรียนตามมาตรฐานกุหลาบหลวง</div>
                                </a>
                            </li>
                            <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'AcademicResult' ? 'active' : '') ?>">
                                <a href="<?=base_url('Admin/Acade/Evaluate/AcademicResult');?>" class="menu-link">
                                    <div data-i18n="ตั้งค่าแสดงผลการเรียนนักเรียน">ตั้งค่าแสดงผลการเรียนนักเรียน</div>
                                </a>
                            </li>
                            <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'SaveScore' ? 'active' : '') ?>">
                                <a href="<?=base_url('Admin/Acade/Evaluate/SaveScore');?>" class="menu-link">
                                    <div data-i18n="ตั้งค่าบันทึกผลการเรียน">ตั้งค่าบันทึกผลการเรียน</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <?php endif; ?>

                    <?php if(in_array("งานหลักสูตร",$Exp_Checkrloes)): ?>
                    <li class="menu-item <?= ($uri->getTotalSegments() >= 3 && $uri->getSegment(3) == 'Course' ? 'active open' : '') ?>">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-book"></i>
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
                            <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'SendPlan' ? 'active' : '') ?>">
                                <a href="<?=base_url('Admin/Acade/Course/SendPlan');?>" class="menu-link">
                                    <div data-i18n="จัดการส่งแผน">จัดการส่งแผน</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <?php endif; ?>

                    <?php if(in_array("งานพัฒนาผู้เรียน",$Exp_Checkrloes)): ?>
                    <li class="menu-item <?= ($uri->getTotalSegments() >= 3 && $uri->getSegment(3) == 'DevelopStudents' ? 'active open' : '') ?>">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-user-check"></i>
                            <div data-i18n="งานพัฒนาผู้เรียน">งานพัฒนาผู้เรียน</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item <?= ($uri->getTotalSegments() >= 4 && $uri->getSegment(4) == 'Clubs' ? 'active' : '') ?>">
                                <a href="<?=base_url('Admin/Acade/DevelopStudents/Clubs/Main');?>" class="menu-link">
                                    <div data-i18n="จัดการชุมนุม">จัดการชุมนุม</div>
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
                            <i class="menu-icon tf-icons bx bx-cog"></i>
                            <div data-i18n="จัดการบทบาทในวิชาการ">จัดการบทบาทในวิชาการ</div>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </aside>