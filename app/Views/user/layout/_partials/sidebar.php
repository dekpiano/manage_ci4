            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme" style="background-color: #c5eada; background-image: url('data:image/svg+xml,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 1440 320\'%3e%3cdefs%3e%3clinearGradient id=\'wave-gradient\' x1=\'0%25\' y1=\'0%25\' x2=\'100%25\' y2=\'0%25\'%3e%3cstop offset=\'0%25\' style=\'stop-color:%238cd9b3;\' /%3e%3cstop offset=\'100%25\' style=\'stop-color:%23c5eada;\' /%3e%3c/linearGradient%3e%3c/defs%3e%3cpath fill=\'url(%23wave-gradient)\' d=\'M0,192L48,197.3C96,203,192,213,288,224C384,235,480,245,576,250.7C672,256,768,256,864,245.3C960,235,1056,213,1152,192C1248,171,1344,149,1392,138.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z\'%3e%3c/path%3e%3c/svg%3e'); background-size: cover;">
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
                    <li class="menu-item <?= ($uri->getTotalSegments() >= 2 && $uri->getSegment(2) == 'competition' ? 'active' : null) ?>">
                        <a href="<?=base_url('competition/show');?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-trophy" style="color: #15a362 !important;"></i>
                            <div class="text-truncate" data-i18n="Basic" style="font-weight: 700; color: #1b5e20;">ผลงานการแข่งขัน</div>
                        </a>
                    </li>
                    <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">ประกันคุณภาพ</span>
                    </li>
                        <li class="menu-item <?= ($uri->getSegment(1) == 'QADocument' ? 'active' : null) ?>">
                            <a href="https://sites.google.com/skj.ac.th/skj68/home" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-file"></i>
                                <div class="text-truncate" data-i18n="Basic">การประกันคุณภาพภายนอก</div>
                            </a>
                    <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">ดาวน์โหลด</span>
                    </li>
                      <li class="menu-item <?= ($uri->getSegment(1) == 'file' ? 'active' : null) ?>">
                        <a href="https://documentcenter.skj.ac.th/" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-group"></i>
                            <div class="text-truncate" data-i18n="Basic">ดาวน์โหลดไฟล์</div>
                        </a>
                    </li>
                </ul>
            </aside>