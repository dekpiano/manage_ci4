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
                    <li class="menu-item <?= ($uri->getSegment(1) == '' ? 'active' : null) ?>">
                        <a href="<?=base_url();?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-smile"></i>
                            <div class="text-truncate" data-i18n="Basic">หน้าแรก</div>
                        </a>
                    </li>
                    <li class="menu-item <?= ($uri->getSegment(1) == 'ClassSchedule' ? 'active' : null) ?>">
                        <a href="<?=base_url('ClassSchedule');?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-calendar"></i>
                            <div class="text-truncate" data-i18n="Basic">ตารางเรียน</div>
                        </a>
                    </li>
                    <li class="menu-item <?= ($uri->getSegment(1) == 'ExamSchedule' ? 'active' : null) ?>">
                        <a href="<?=base_url('ExamSchedule');?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-file"></i>
                            <div class="text-truncate" data-i18n="Basic">ตารางสอบ</div>
                        </a>
                    </li>
                    <li class="menu-item <?= ($uri->getSegment(1) == 'StudentsList' ? 'active' : null) ?>">
                        <a href="<?=base_url('StudentsList');?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-group"></i>
                            <div class="text-truncate" data-i18n="Basic">รายชื่อนักเรียน</div>
                        </a>
                    </li>
                    <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">ดาวน์โหลด</span>
                    </li>
                      <li class="menu-item <?= ($uri->getSegment(1) == 'file' ? 'active' : null) ?>">
                        <a href="<?=base_url('StudentsList');?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-group"></i>
                            <div class="text-truncate" data-i18n="Basic">ดาวน์โหลดไฟล์</div>
                        </a>
                    </li>
                </ul>
            </aside>