<?php
session_start();
require_once("LineLoginLib.php");
include('connect.php');
include('connectDB.php');
include('error.php');
$sql = "SELECT * FROM provinces where code in('38', '39', '41', '42', '43', '47', '48')";
$query = mysqli_query($conn, $sql);

$sql2 = "SELECT * FROM provinces where code in('38', '39', '41', '42', '43', '47', '48')";
$query2 = mysqli_query($conn, $sql2);

$sql3 = "SELECT * FROM provinces where code in('38', '39', '41', '42', '43', '47', '48')";
$query3 = mysqli_query($conn, $sql3);

 
// กรณีต้องการตรวจสอบการแจ้ง error ให้เปิด 3 บรรทัดล่างนี้ให้ทำงาน กรณีไม่ ให้ comment ปิดไป
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
 
// กรณีมีการเชื่อมต่อกับฐานข้อมูล
//require_once("dbconnect.php");

define('LINE_LOGIN_CHANNEL_ID', '');
define('LINE_LOGIN_CHANNEL_SECRET', '');
define('LINE_LOGIN_CALLBACK_URL', 'https://.moph.go.th/r8nds/login_uselib_callback.php'); //ใส่ url ของ web server

$LineLogin = new LineLoginLib(
    LINE_LOGIN_CHANNEL_ID, LINE_LOGIN_CHANNEL_SECRET, LINE_LOGIN_CALLBACK_URL);
     
if(!isset($_SESSION['ses_login_accToken_val'])){    
    $LineLogin->authorize();
    exit;
}
 
$accToken = $_SESSION['ses_login_accToken_val'];
// Status Token Check
if($LineLogin->verifyToken($accToken)) {
     
}
 
 
// echo "<pre>";
// Status Token Check with Result 
//$statusToken = $LineLogin->verifyToken($accToken, true);
//print_r($statusToken);
 
 
//////////////////////////
// echo "<hr>";
// GET LINE USERID FROM USER PROFILE
//$userID = $LineLogin->userProfile($accToken);
//echo $userID;
 
//////////////////////////
// echo "<hr>";
// GET LINE USER PROFILE 
$userInfo = $LineLogin->userProfile($accToken, true);
if(!is_null($userInfo) && is_array($userInfo) && array_key_exists('userId', $userInfo)){
    //print_r($userInfo);
}
 
//exit;
if(isset($_SESSION['ses_login_userData_val']) && $_SESSION['ses_login_userData_val'] != ""){
    // GET USER DATA FROM ID TOKEN
    $lineUserData = json_decode($_SESSION['ses_login_userData_val'], true);
    "Line UserID: ".$lineUserData['sub']."<br>";
    "Line Display Name: ".$lineUserData['name']."<br>";
    '<img style="width:100px;" src="'.$lineUserData['picture'].'" /><br>';
    $lineid = $lineUserData['sub'];
    $displayname = $lineUserData['name'];
}

if(isset($_SESSION['ses_login_refreshToken_val']) && $_SESSION['ses_login_refreshToken_val']!=""){

}
if(isset($_SESSION['ses_login_refreshToken_val']) && $_SESSION['ses_login_refreshToken_val']!="") {
    if(isset($_POST['refreshToken'])){
        $refreshToken = $_SESSION['ses_login_refreshToken_val'];
        $new_accToken = $LineLogin->refreshToken($refreshToken); 
        if(isset($new_accToken) && is_string($new_accToken)){
            $_SESSION['ses_login_accToken_val'] = $new_accToken;
        }       
        $LineLogin->redirect("page-login.php");
    }
}
// Revoke Token
//if($LineLogin->revokeToken($accToken)){
//  echo "Logout Line Success<br>";   
//}
//
// Revoke Token with Result
//$statusRevoke = $LineLogin->revokeToken($accToken, true);
//print_r($statusRevoke);
?>

<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width,initial-scale=1"> -->
    <title>Register</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
		body {  font-family: 'Kanit', sans-serif;	}
		h1,h2,h3,h4,h5,h6 {  font-family: 'Kanit', sans-serif;	}
    </style>
    <style type="text/css">.bgimg {  background-image: url('../images/disLogo.png'); }  </style>

    <script type="text/javascript">
    function ShowHideDiv() {
        var level = document.getElementById("level");
        var hospcode = document.getElementById("hosp");
        hospcode.style.display = level.value == "pcu" ? "block" : "none";

        var province = document.getElementById("province");
        province.style.display = level.value == "pcu" ? "block" : "none";

        var opt = document.getElementById("province2");
        opt.style.display = level.value == "opt" ? "block" : "none";

        var pmj = document.getElementById("province3");
        pmj.style.display = level.value == "pmj" ? "block" : "none";

        var province2 = document.getElementById("opt2");
        province2.style.display = level.value == "opt" ? "block" : "none";
        
    }
    </script>

        <script src="script/jquery.min.js"></script>
        <script src="script/script4.js"></script>
        <script src="script/jquery.min.js"></script>
        <script src="script/script5.js"></script>
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
                            <div class="card-body pt-5">
                                
                                    <a class="text-center " > <h2 class="card login-form mb-4">ลงทะเบียน</h2></a>
                                    <div class="form-validation">
                                    <form class="form-valide" action="line_register_db.php" method="post">

                                    <?php include('errors.php'); ?>
                                    <?php if (isset($_SESSION['error'])) : ?>
                                        <div class="error">
                                            <h4>
                                                <?php 
                                                    echo $_SESSION['error'];
                                                    unset($_SESSION['error']);
                                                ?>
                                            </h4>
                                        </div>
                                    <?php endif ?>
                                    <?php if (isset($_SESSION['err'])) : ?>
                                        <div class="error">
                                            <h4>
                                                <?php 
                                                    echo $_SESSION['err'];
                                                    unset($_SESSION['err']);
                                                ?>
                                            </h4>
                                        </div>
                                    <?php endif ?>
                                        
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="lineid">ID Line 
                                            </label>
                                            <div class="col-lg-6">
                                                    <label class=" col-form-label" for="lineid" id="lineid"><?php echo $lineid; ?></label>
                                                    <input type="hidden" name="lineid" value="<?php echo $lineid ; ?>" size="32">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="username">Display  Name 
                                            </label>
                                            <div class="col-lg-6">
                                                <label class=" col-form-label" for="username" id="display_name">
                                                    <?php
                                                        // echo $displayname;
                                                    ?>
                                                </label>
                                                <!-- <input type="hidden" name="displayname" value="<?php echo $displayname ; ?>" size="32"> -->
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="username">ชื่อ</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="username1" name="username" placeholder="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="lastname">สกุล</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="lastname1" name="lastname" placeholder="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="cid">เลขบัตรประชาชน</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="cid" name="cid" placeholder="" onfocusout="checkForm()">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="email">อีเมลล์ </label>
                                            <div class="col-lg-6">
                                                <input type="email" class="form-control" id="email1" name="email" placeholder="">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="password_1">Password</label>
                                            <div class="col-lg-6">
                                                <input type="password" class="form-control" id="password1" name="password_1" placeholder="">
                                            </div>
                                        </div>
                                        
                                         
                                        <div class="form-group row">
		                                    <label class="col-lg-4 col-form-label" for="level" class="col-md-4 control-label">ระดับผู้ใช้งาน</label>
		                                    <div class="col-md-6">
			                                    <select class="form-control" name="level" id="level" onchange="ShowHideDiv()" >
				                                    <option disabled selected required>-เลือกหน่วยงาน-</option>
				                                    <option value="pcu">รพ.</option>
				                                    <option value="pmj">พมจ.</option>
				                                    <option value="opt">อบต./เทศบาล</option>
			                                    </select>
		                                    </div>
	                                    </div>

                                        <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="provinces2" ></label>
                                                    <div class="col-md-6">                        
                                                    <select name="province_id1" id="province3" class="form-control" style="display: none" require>
                                                    <option value="">-เลือกจังหวัด-</option>
                                                            <?php while($result3 = mysqli_fetch_assoc($query3)):?>
                                                            <option value="<?=$result3['code']?>"><?=$result3['name_th']?></option>
                                                            <?php endwhile; ?>
                                                    </select>                     
                                                    </div>                        
                                        </div>
                                        
                                        <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="provinces" ></label>
                                                    <div class="col-md-6">                        
                                                    <select name="province_id" id="province" class="form-control" style="display: none" require>
                                                    <option value="">-เลือกจังหวัด-</option>
                                                            <?php while($result = mysqli_fetch_assoc($query)):?>
                                                            <option value="<?=$result['code']?>"><?=$result['name_th']?></option>
                                                            <?php endwhile; ?>
                                                    </select>
                                                    </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="hosp"></label>
                                            <div class="col-lg-6">
                                            <select name="hosp_id" id="hosp" class="form-control" style="display: none" require>
                                                <option value="">-เลือก รพ.-</option>
                                            </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="provinces2" ></label>
                                                    <div class="col-md-6">                        
                                                    <select name="province_id2" id="province2" class="form-control" style="display: none" require>
                                                    <option value="">-เลือกจังหวัด-</option>
                                                            <?php while($result2 = mysqli_fetch_assoc($query2)):?>
                                                            <option value="<?=$result2['code']?>"><?=$result2['name_th']?></option>
                                                            <?php endwhile; ?>
                                                    </select>                     
                                                    </div>                        
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="hospcode"></label>
                                            <div class="col-lg-6">
                                            <select name="opt_id" id="opt2" class="form-control" style="display: none" require>
                                                <option value="">-เลือก อบต./เทศบาล-</option>
                                            </select>
                                            </div>
                                        </div>

                                       
                                        
                                        <!-- <div class="form-group row">
                                            <label class="col-lg-4 col-form-label"><a href="#">Terms &amp; Conditions</a>  <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-8">
                                                <label class="css-control css-control-primary css-checkbox" for="val-terms">
                                                    <input type="checkbox" class="css-control-input" id="val-terms" name="val-terms" value="1"> <span class="css-control-indicator"></span> I agree to the terms</label>
                                            </div>
                                        </div> -->
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" class="btn btn-success" name="reg_user">ลงทะเบียน</button>
                                                <button type="button" class="btn btn-primary" name="reg" style="color: white; text-align: center; text-size:20px;"><a href="page-login.php">&nbsp;<font color="white">ยกเลิก</font></a></button>
                                                <!-- <button type="submit" class="btn btn-primary">ยกเลิก</button> -->
                                            </div>
                                        </div>
                                    </form>
                                    
                                    <!-- <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                
                                                <button type="submit" class="btn btn-primary" name="reg" style = " color: white; text-align: center; text-size:20px;"><a href="page-login.php" >&nbsp;<font color="white" >ยกเลิก</font></a></button>
                                            </div>
                                        </div> -->

                                        <!-- <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                               <h4>ถ้าลงทะเบียนผ่านไลน์แล้ว ให้กดยกเลิก แล้วทำการ Login ผ่านไลน์อีกครั้ง</h4>
                                            </div>
                                        </div> -->
                                    </div>
                                    
                                    <!-- <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                            <p>เป็นสมาชิกอยู่แล้ว <a href="page-login.php">Click ที่นี่</a></p>
                                            </div>
                                            
                                    </div>   -->
                                </div>
                                    <!-- <p class="mt-5 login-form__footer">เป็นสมาชิกอยู่แล้ว <a href="page-login.php" class="text-primary">Click ที่นี้</a></p> -->
                                    </p>
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
