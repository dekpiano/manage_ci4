<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบงานวิชาการ | สวนกุหลายวิทยาลัย (จิรประวัติ) นครสวรรค์</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/font-awesome/css/font-awesome.min.css') ?>">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="<?= base_url('assets/css/fontastic.css') ?>">
    <!-- Google fonts - Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sarabun:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.default.css') ?>" id="theme-stylesheet">

    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.ico">
    <!-- Tweaks for older IEs-->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

</head>

<body style="font-family:Sarabun;">


    <div class="page login-page">
        <div class="container d-flex align-items-center">
            <div class="form-holder has-shadow">
                <div class="row">
                    <!-- Logo & Information Panel-->
                    <div class="col-lg-6">
                        <div class="info d-flex align-items-center">
                            <div class="content">
                                <div class="logo">
                                    <span style="font-size: 3rem;">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                    </span>
                                    <h1>สำหรับครู / อาจารย์</h1>
                                </div>
                                <ul>
                                    <li>งานหลักสูตร</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Form Panel    -->
                    <div class="col-lg-6 bg-white">
                        <div class="form d-flex align-items-center">
                            <div class="content ">
                                <h3 class="mb-3 text-center">เข้าสู่ระบบ งานวิชาการ </h3>
                                <form method="post" action="<?= base_url('control_login/check_teacher') ?>"
                                    class="form-validate">
                                    <div class="form-group">
                                        <input id="login-username" type="email" name="username" id="username" required
                                            data-msg="กรุณากรอกชื่อผู้ใช้งาน Email" class="input-material" autocomplete="off">
                                        <label for="login-username" class="label-material">ชื่อผู้ใช้งาน Email</label>
                                    </div>
                                    <div class="form-group">
                                        <input id="login-password" type="password" name="password" id="password"
                                            required data-msg="กรุณากรอกรหัสผ่าน" class="input-material">
                                        <label for="login-password" class="label-material">รหัสผ่าน</label>
                                    </div><button id="login" type="submit" class="btn btn-primary"><i
                                            class="fas fa-sign-in-alt"></i> Login</button>
                                  
                                </form>
                                <hr>
                                <?php
                                if(!isset($login_button))
                                {
                                    echo '<h3><a href="'.base_url('Control_login/LoginGoogleTeacher').'">Logout</h3></div>';
                                }
                                else
                                {
                                    echo '<div align="center">'.$login_button . '</div>';
                                }
                                ?>
                                <div class="text-center mt-5">
                                <a class="btn btn-outline-primary"
                                    href="<?= base_url() ?>">กลับสู่หน้าหลัก</a>
                                </div>
                               
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- JavaScript files-->
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/popper.js/umd/popper.min.js') ?>"> </script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/jquery.cookie/jquery.cookie.js') ?>"> </script>
    <script src="<?= base_url('assets/vendor/chart.js/Chart.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/jquery-validation/jquery.validate.min.js') ?>"></script>
    <!-- Main File-->
    <script src="<?= base_url('assets/js/front.js') ?>"></script>
    <script src="<?= base_url('assets/js/all.js') ?>"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <?php if (session()->getFlashdata('status') == "OK") :?>
    <script>
    Swal.fire("แจ้งเตือน", "<?= session()->getFlashdata('msgerr') ?>", "<?= session()->getFlashdata('alert') ?>");
    </script>
    <?php endif; ?>
</body>

</html>
