<?= $this->extend('user/layout/main') ?>

<?= $this->section('content') ?>

<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">

            <style>
            .fancy-title-view1 {
                float: left;
                width: 100%;
                margin-bottom: 70px;
                text-align: center;
            }

            .fancy-title-view1 h2 {
                margin-bottom: 8px;
                font-size: 40px;
                font-weight: 700;
                display: block;
            }

            .fancy-title-view1 p {
                margin-bottom: 0px;
                display: inline-block;
                width: 65%;
            }

            .fancy-title-view1 i {
                font-size: 22px;
            }

            .fancy-title-view1-color h2,
            .fancy-title-view1-color p {
                color: #000000;
            }

            .light-transparent {
                position: absolute;
                left: 0px;
                top: 0px;
                width: 100%;
                height: 100%;
                opacity: 0.65;
                background-color: #000;
            }

            .categories-view1-full {
                padding: 20px 0px 80px 0px;
                margin-top: 0;
                margin-bottom: 0;
                background: url(uploads/RoomLearning/bg.jpg);
                background-attachment: fixed;
                background-size: cover;
                position: relative;
                min-height: 100vh;
            }

            .categories,
            .categories-view1-wrap {
                float: left;
                width: 100%;
            }

            .categories ul li {
                list-style: none;
            }

            .categories>ul>li {
                float: none;
                display: inline-block;
                margin: 0px 0px 30px 0px;
                vertical-align: top;
            }

            .categories-view1-wrap {
                box-shadow: 0px 0px 25px 0px rgba(0, 0, 0, 0.08);
                padding: 30px 50px 30px 95px;
                border-radius: 10px;
                position: relative;
                background-color: #ffffff;
            }

            .categories-view1 i {
                position: absolute;
                left: 0px;
                top: 50%;
                font-size: 30px;
                color: #fb236a;
                width: 70px;
                height: 70px;
                border-radius: 0 100% 100% 0;
                text-align: center;
                padding-top: 10px;
                margin-top: -36px;
                background-color: #ffffff;
                border: 1px solid #eee;
                border-left: none;
                -webkit-transition: all 0.4s ease-in-out;
                -moz-transition: all 0.4s ease-in-out;
                -ms-transition: all 0.4s ease-in-out;
                -o-transition: all 0.4s ease-in-out;
                transition: all 0.4s ease-in-out;
            }

            .categories-view1 li:hover i {
                color: #ffffff;
                background-color: #274160;
            }

            .categories-view1 a {
                display: block;
                font-size: 18px;
                font-weight: 700;
                margin-bottom: 0px;
            }

            .categories-view1 small {
                font-size: 13px;
                color: #666;
            }

            .categories-view1 span {
                position: absolute;
                right: 5px;
                top: 8px;
                font-size: 90px;
                font-weight: 500;
                color: #999;
                opacity: 0.07;
                line-height: 1;
            }

            .main-load-btn {
                float: left;
                width: 100%;
                text-align: center;
                margin: 30px 0px;
            }

            .main-load-btn a {
                display: inline-block;
                line-height: 1;
                padding: 18px 45px;
                color: #ffffff;
                border-radius: 40px;
                font-size: 16px;
                font-weight: 600;
                -webkit-transition: all 0.4s ease-in-out;
                -moz-transition: all 0.4s ease-in-out;
                -ms-transition: all 0.4s ease-in-out;
                -o-transition: all 0.4s ease-in-out;
                transition: all 0.4s ease-in-out;
                background-color: #fb236a;
            }

            .main-load-btn a:hover {
                background-color: #274160;
            }

            .more-spacer {
                float: left;
                width: 100%;
                margin: 10px 0px;
            }
            </style>
            <div class="main-section categories-view1-full">
                <!-- <span class="light-transparent"></span> -->
                <div class="container">
                    <div class="row">

                        <div class="col-md-12">

                            <!-- FancyTitle -->
                            <div class="fancy-title-view1 fancy-title-view1-color">
                                <h2>ห้องเรียนออนไลน์</h2>
                                <p>Room Learning</p>
                            </div>
                            <!-- FancyTitle -->

                            <!-- Categories List -->
                            <div class="categories categories-view1">
                                <ul class="row">
                                    <?php foreach ($lear as $key => $v_lear) : ?>
                                    <li class="col-md-4">
                                        <div class="categories-view1-wrap">
                                            <i><?=$v_lear->lear_icon?></i>
                                            <a 
                                                href="<?=base_url('LearningOnline/'.$v_lear->lear_nameeng)?>"><?=$v_lear->lear_namethai?></a>
                                            <small><?=$v_lear->lear_nameeng?></small>
                                            <span><?=$key+1;?></span>
                                        </div>
                                    </li>
                                    <?php endforeach; ?>
                                    <!-- <li class="col-md-4">
                                        <div class="categories-view1-wrap">
                                            <i><img src="https://img.icons8.com/color/48/000000/tour-guide.png" /></i>
                                            <a target="_blank"
                                                href="https://sites.google.com/skj.ac.th/guide/%E0%B8%AB%E0%B8%99%E0%B8%B2%E0%B9%81%E0%B8%A3%E0%B8%81">แนะแนว</a>
                                            <small>Guidance work</small>
                                            <span>9</span>
                                        </div>
                                    </li> -->
                                </ul>
                            </div>
                            <!-- Categories List -->


                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>