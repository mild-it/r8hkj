<?php
session_start();
require_once('LineLogin.php');
include('server.php');
?>

<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width,initial-scale=1"> -->
    <title>R8:NDS</title>
    <!-- Favicon icon -->
    <script src="https://kit.fontawesome.com/a46fd306c2.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/disLogo.png">
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->
    <link href="css/style.css" rel="stylesheet">

    <link href='https://fonts.googleapis.com/css?family=Kanit:400,300&subset=thai,latin' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
		body { font-family: 'Kanit', sans-serif; }
		h1,h2,h3,h4,h5,h6 { font-family: 'Kanit', sans-serif; }
    </style>
    <style type="text/css">.bgimg {  background-image: url('../images/disLogo.png'); }  </style>

    <style>
body {
	background-image: url("images/user-login.png");
    no-repeat fix; background-size: 100%;
}

</style>
    
</head>

<body class="h-100">
    
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                                <!-- <div >
                                    <img src="images/nawang.png"   width: auto  height="140" >
                                </div> -->
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-success shadow-info border-radius-lg pt-4 pb-3">
                                    <h4 class="text-white text-capitalize ps-3 text-center" >การพัฒนาคุณภาพชีวิต<br>คนพิการด้วยระบบอิเล็กทรอนิกส์<br></h4>
                                    <h3 class="text-white text-capitalize ps-3 text-center" >ระบบบริการคนพิการแบบเบ็ดเสร็จ : Nawang Model<br></h3>
                                    <h4 class="text-white text-capitalize ps-3 text-center">One Stop Service Center for Disabilities</h4>
                                    <h5 class="text-yellow text-capitalize ps-3 text-center">Version 1.1</h5>
                                </div>
                            </div>
                            <div class="card-body pt-5" >
                                <!-- <a class="text-center" href="page-login.php"> <h4>เข้าสู่ระบบ</h4></a> -->
                                <form class="mt-3 mb-3 login-input" action="login_db.php" method="post">
                                    <?php if (isset($_SESSION['error'])) : ?>
                                        <div class="error">
                                            <h3>
                                                <?php
                                                    echo $_SESSION['error'];
                                                    unset($_SESSION['error']);
                                                ?>
                                            </h3>
                                        </div>
                                    <?php endif ?>
                                    <?php if (isset($_SESSION['status'])) : ?>
                                        <div class="status">
                                            <h4>
                                                <?php
                                                    echo $_SESSION['status'];
                                                    unset($_SESSION['status']);
                                                ?>
                                            </h4>
                                        </div>
                                    <?php endif ?>

                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="อีเมล์*" name="email">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" placeholder="รหัสผ่าน*" name="password">
                                    </div>
                                    <button type="submit" class="btn login-form__btn submit w-100" name="login_user">เข้าสู่ระบบ</button>
                                </form>

                                <form action="checklogin_line.php" method="post">
                                    <button type="submit" style = "background-color: #4CAF50; color: white; text-align: center; text-size:20px;" class="btn login-form__btn submit w-100 " name="login_line" id="login_line"><i class="fa-brands fa-line" style="font-size:20px"></i><span class="align-middle">Login with LINE</span></button>
                                </form>
                                <?php
                                $line = new LineLogin();
                                $link = $line->getLink();
                                ?>
                                <!-- <h4><p class="mt-5 login-form__footer">ลงทะเบียนผู้ใช้งานระบบ ผ่านไลน์ <a href="login_uselib.php" class="text-primary">Click ที่นี่</a></p></h4> -->
                                <h4><p class="mt-5 login-form__footer">ลงทะเบียนผู้ใช้งานระบบ ผ่านไลน์ <a href="<?php echo $link; ?>" class="text-primary">Click ที่นี่</a></p></h4>
                                <h4><p class="mt-5 login-form__footer">คู่มือการใช้งาน/เอกสาร <a href="https://drive.google.com/drive/folders/1G5DVjShSVCDqzh2R4bwpKSrUot6v8CbG" class="text-primary" target="_blank">Click ที่นี่</a></p></h4>
                                <div class="row">
                                    <div class="col-md-6"><a href="report_case_r8.php" target="_blank" class="btn btn-info btn-block" role="button" aria-pressed="true">Dashboard</a></div>
                                    <div class="col-md-6"><button type="button" class="btn btn-warning btn-block" onclick="location.href='reset_pw.php';">ลืมรหัสผ่าน</button></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        <img src="images/QrCode_R8NDS_OpenChat.jpg">
                                    </div>
                                    <div class="col-md-8"><br><br>
                                        <b>Line Open Chat</b><br>
                                        พูดคุย แจ้งปัญหาการใช้งานระบบ
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--**********************************
        Scripts
    ***********************************-->
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>
</body>
</html>





